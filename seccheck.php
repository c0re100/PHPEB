<?php
$VALIDATE_INTERVAL = 900;
$NO_VALIDATE = array("c0re","Saren");

function validatedOrDie($username) {
  global $NO_VALIDATE, $VALIDATE_INTERVAL;
  $onlineip = $_SERVER['REMOTE_ADDR'];

  $chktime = time();

  $conn = mysql_connect('localhost', 'ebs', 'wfc') or die('SQL error');
  mysql_select_db('phpeb', $conn);
  mysql_query("SET NAMES 'utf8'");
  $check = "SELECT checktime FROM v2a_phpeb_ip_sec WHERE username='$username'";
  $sectime = mysql_query($check, $conn);
  $row = mysql_fetch_row($sectime);

  if (($chktime - $row[0]) > $VALIDATE_INTERVAL && !in_array($username, $NO_VALIDATE)) {
    echo "<script src='https://www.google.com/recaptcha/api.js'></script>";
    echo '<form name=imgform method="post" action="seccheck.php">';
	echo "<input type=hidden value='$username' name=username>";
    echo '<p style="color:red;font-size:20px">驗證頁面</p>';
    echo '<div class="g-recaptcha" data-sitekey="6LdVLhETAAAAAKIc_trn7ngTuMIWxEMFljCnZb4A"></div>';
    echo '<br><br>';
    echo '<input type="submit" value="確定">';
    echo '</form>';
    mysql_close($conn);
    die();
  }
}

function validate() {
  require 'recaptcha/src/autoload.php';
  $secret = '6LdVLhETAAAAADW9q7LcdAfmsGnnZRlXoGa4IW1B';
  $recaptcha = new \ReCaptcha\ReCaptcha($secret);
  header('Content-Type: text/html; charset=utf-8');
  $onlineip = $_SERVER['REMOTE_ADDR'];
  $username = $_POST['username'];
  $resp = $recaptcha->verify($_POST['g-recaptcha-response'], $onlineip);
  if ($resp->isSuccess()) {
      echo '<p style="color:RED;font-size:20px">驗證成功。</p>';

      $checktime = time();

      $conn = mysql_connect('localhost', 'ebs', 'wfc') or die('SQL error');
      mysql_select_db('phpeb', $conn);
      mysql_query("SET NAMES 'utf8'");

      $del = "DELETE FROM v2a_phpeb_ip_sec WHERE username='$username'";
      $ins = "INSERT INTO v2a_phpeb_ip_sec (ipaddr, username, checktime) VALUES ('$onlineip', '$username', '$checktime')";

      mysql_query($del, $conn);
      mysql_query($ins, $conn);
      mysql_close($conn);
  } else {
      echo '<p style="color:RED;font-size:20px">未能通過驗證。</p>';
      echo '<p style="color:RED;font-size:20px">請重新驗證。</p>';
  }
}

if (isset($_POST["g-recaptcha-response"])) {
  validate();
}
