<?php
include "ChromePhp.php";
header('Content-type: text/json; charset=UTF-8');
const DEBUG = true;

function debug($msg)
{
    if(DEBUG)
        ChromePhp::log($msg);
}

function validBase64($data)
{
    return base64_encode(base64_decode($data, true)) === $data;
}

function printError($code, $msg)
{
    echo json_encode(array("errorcode" => $code, "errormsg" => $msg));
}

if(!isset($_GET['userdata']))
{
    printError(401, "No user credentials have been given!");return;
}

$userData = $_GET['userdata'];


if(!validBase64($userData))
{
    printError(400, "User credentials have to be the base64 encoded value of username:password!");
    return;
}

$headers = array(
    'Authorization: Basic ' . $userData
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://intranet.suso.schulen.konstanz.de/gpuntis/schueler/data.txt");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'TLSv1');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // --> Insecure! But not ssl good be this page on
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);


if (curl_errno($ch)) {
    printError(500, curl_error($ch));
    return;
}
$result = curl_exec($ch);
$result = utf8_encode($result);
curl_close($ch);

$array = explode("\r\n", ($result));
unset($array[sizeof($array)-1]);

$resultArray = array();

foreach($array as $key => $value)
{
    $splinter = explode(";", $value);
    $class = $splinter[0];
    $date = $splinter[1];
    $hour = $splinter[2];
    $sub = $splinter[3];
    $subject = $splinter[4];
    $room = $splinter[5];
    $comment = $splinter[6];

    if(strpos($hour, "-") !== false) // hour === e.g. 9 - 10
    {
        $start = explode(" -", $hour)[0];
        $end = explode("- ", $hour)[1];

        for($i = intval($start); $i <= intval($end); $i++)
        {
            array_push($resultArray, array(
                "class"      => $class,
                "date"       => $date,
                "hour"       => $i,
                "subteacher" => $sub,
                "room"       => $room,
                "comment"     => $comment));
        }

    }
    else
    {
        array_push($resultArray, array(
            "class"      => $class,
            "date"       => $date,
            "hour"       => intval($hour),
            "subteacher" => $sub,
            "room"       => $room,
            "comment"     => $comment));
    }
}

$finalResult = array("resultcode" => 200, "result" => $resultArray);

echo json_encode($finalResult, JSON_PRETTY_PRINT);
