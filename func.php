<?php
function get_grade($usr, $pwd) {
  $data = base64_encode($usr . ":" . $pwd);
  $ch = curl_init();
  $headers = array(
      'Authorization: Basic ' . $data
  );
  curl_setopt($ch, CURLOPT_URL, "https://intranet.suso.schulen.konstanz.de/gpuntis/");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'TLSv1');
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // --> Insecure! But not ssl good be this page on
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  if (curl_errno($ch)) {
     error(500, curl_error($ch));
     exit(0);
  }
  $result = utf8_encode(curl_exec($ch));
  if ($result == "") {
      error(500, "Invalid response from login server! <pre>" . $result . "</pre>");
      exit(0);
  }
  $lines = explode("\n", $result);
  $line = $lines[19];
  $line = explode("<", $line)[0];
  $class = $line;
  return $class;
}

function getUpdateTime($usr, $pwd)
{
    $data = base64_encode($usr . ":" . $pwd);
    $ch = curl_init();
    $headers = array(
        'Authorization: Basic ' . $data
    );
    curl_setopt($ch, CURLOPT_URL, "https://intranet.suso.schulen.konstanz.de/gpuntis/");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'TLSv1');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // --> Insecure! But not ssl good be this page on
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    if (curl_errno($ch)) {
        return null;
    }
    $result = utf8_encode(curl_exec($ch));
    if($result == "")
        return null;

    $lines = explode("\n", $result);
    $line = $lines[17];
    $innerBrackets = explode(")", explode("(", $line)[1])[0];
    $timeAndDate = explode(": ", $innerBrackets)[1];
    $date = date_create_from_format("d.m.Y H:i:s", $timeAndDate);
    return $date;
}

function sortData($data, $crit) {
    $sortArray = array();
    foreach($data as $key => $array) {
      $sortArray[$key] = $array[$crit];
    }

    array_multisort($sortArray, SORT_ASC, SORT_NUMERIC, $data);
    return $data;
}

function group($data, $crit)
{
    $return = array();
    foreach($data as $val) {
        $return[$val[$crit]][] = $val;
    }
    return $return;
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

function checkClassToDisplay($class, $userClass)
{

    if(isSuperUser() && isset($_SESSION["disp_all"]))
        return true;

    if(isSuperUser() && isset($_GET["class"]) && $class == $_GET["class"])
        return true;

    if($class == $userClass)
        return true;

    return false;
}

function isSuperUser()
{
    if(isset($_SESSION["user"]["usr"]))
        return isSuperUserSpecific($_SESSION["user"]["usr"]);
    else
        return false;
}

function isSuperUserSpecific($user)
{

    $SUPER_USERS = array("berszinkai", "krauterjas");

    return in_array(strtolower($user), $SUPER_USERS);
}

function toggleShowAll()
{

}

?>
