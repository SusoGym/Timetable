<?php
session_start();
include("func.php");
if (!isset($_POST["usr"]) OR !isset($_POST["pwd"])) {
  header("Location: index.php");
} else {
  $usr = $_POST["usr"];
  $pwd = $_POST["pwd"];
  if (get_grade($usr, $pwd) == "") {
    $errno = 401;
    $errtxt = "You are not authorized to access this page. This may be caused by a wrong username/password.";
  } else {
    $_SESSION["login"] = true;
    $_SESSION["user"] = array('usr' => $usr, 'pwd' => $pwd);
    header("Location: main.php");
  }

  if (isset($errno)) {
    error($errno, $errtxt);
  }
}
?>
