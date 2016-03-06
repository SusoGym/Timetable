<?php
function readdata($usr, $pwd) {

  $userData = base64_encode($usr . ":" . $pwd);

  $headers = array(
      'Authorization: Basic ' . $userData
  );
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://intranet.suso.schulen.konstanz.de/gpuntis/schueler/data.txt");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'TLSv1');
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // <-- Insecure! But not ssl good be this page on
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  $result = utf8_encode(curl_exec($ch));
  curl_close($ch);
  $lines = explode("\r\n", ($result));
  unset($lines[sizeof($lines)-1]);
  $resultArray = array();
  foreach($lines as $key => $line)
  {
      $splinter = explode(";", $line);
      $class = $splinter[0];
      $date = $splinter[1];
      $hour = $splinter[2];
      $newteacher = $splinter[3];
      $newsubject = $splinter[4];
      $newroom = $splinter[5];
      $actualteacher = $splinter[6];
      $actualroom = $splinter[7];
      $comment = $splinter[8];

      $day = explode(".", $date)[0];
      $month = explode(".", $date)[1];
      $date = mktime(12, 0, 0, $month, $day, date("Y"));

      if(strpos($hour, "-") !== false) // hour === e.g. 9 - 10
      {
          $start = explode(" -", $hour)[0];
          $end = explode("- ", $hour)[1];
          for($i = intval($start); $i <= intval($end); $i++)
          {
              array_push($resultArray, array(
                  "class"          => $class,
                  "date"           => $date,
                  "hour"           => $i,
                  "newteacher"     => $newteacher,
                  "newsubject"     => $newsubject,
                  "newroom"        => $newroom,
                  "actualteacher"  => $actualteacher,
                  "actualroom"     => $actualroom,
                  "comment"        => $comment
                ));
          }
      }
      else
      {
          array_push($resultArray, array(
            "class"          => $class,
            "date"           => $date,
            "hour"           => intval($hour),
            "newteacher"     => $newteacher,
            "newsubject"     => $newsubject,
            "newroom"        => $newroom,
            "actualteacher"  => $actualteacher,
            "actualroom"     => $actualroom,
            "comment"        => $comment
          ));
      }
  }

  return $resultArray;

}
?>
