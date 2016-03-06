<?php
function get_grade($usr, $pwd) {
  $data = base64_encode($usr . ":" . $pwd);
  $ch = curl_init();
  $headers = array(
      'Authorization: Basic ' . $data
  );
  curl_setopt($ch, CURLOPT_URL, "https://intranet.suso.schulen.konstanz.de/gpuntis/schueler/index.php");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'TLSv1');
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // --> Insecure! But not ssl good be this page on
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  if (curl_errno($ch)) {
      printError(500, curl_error($ch));
      return;
  }
  $result = utf8_encode(curl_exec($ch));
  $lines = explode("\n", $result);
  $line = $lines[18];
  $line = explode("<", $line)[0];
  $class = $line;
  return $class;
}

function sortData(&$data, $crit) {
    $sortArray = array();
    foreach($data as $key => $array) {
      $sortArray[$key] = $array[$crit];
    }

    array_multisort($sortArray, SORT_ASC, SORT_NUMERIC, $data);
}

function initDate() {
  global $thisday;
  global $thatday;
  if (date("N") >= 1 AND date("N") <= 4) {
    $thisday["day"] = date("j");
    $thisday["txt"] = "Heute";
    $thatday["day"] = date("j", strtotime("+1 day"));
    $thatday["txt"] = "Morgen";
  } elseif (date("N") == 5) {
    $thisday["day"] = date("j");
    $thisday["txt"] = "Heute";
    $thatday["day"] = date("j", strtotime("next Monday"));
    $thatday["txt"] = "Montag";
  } elseif (date("N") == 6) {
    $thisday["day"] = date("j", strtotime("next Monday"));
    $thisday["txt"] = "Montag";
    $thatday["day"] = date("j", strtotime("next Tuesday"));
    $thatday["txt"] = "Dienstag";
  } elseif (date("N") == 7) {
    $thisday["day"] = date("j", strtotime("+1 day"));
    $thisday["txt"] = "Morgen";
    $thatday["day"] = date("j", strtotime("next Tuesday"));
    $thatday["txt"] = "Dienstag";
  }
}

function error($errno, $errtxt) {
  include("error.php");
}

?>
