<?php
//Game Screen Main Process Unit, for php-eb v0.50
$mode = ( isset($_GET['action']) ) ? $_GET['action'] : $_POST['action'];
include('cfu.php');
include('includes/repairplayer-f.inc.php');
if (empty($PriTarget)) $PriTarget = 'Alpha';
if (empty($SecTarget)) $SecTarget = 'Beta';
if (empty($ThrTarget)) $ThrTarget = 'Chat';
AuthUser();

//Online Limit Connection
if ($OLimit){
$Online_Time = time() - $Offline_Time;
$OnlineSQL = ("SELECT count(time2) FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` WHERE `time2` > '$Online_Time'");
$OnlineSQL_Query = mysql_query($OnlineSQL);
$OnlinePlNum = mysql_fetch_row($OnlineSQL_Query);
if ($OnlinePlNum[0] >= $OLimit && $CFU_Time-$UsrGenrl['time2'] < $Offline_Time){
	echo "<center><br><br>上線人數太多。<br>現上線人數: $OnlinePlNum[0]<br>上線人數上限: $OLimit<br><a href=\"index.php\" target='_top' style=\"text-decoration: none\">回到首頁</a><br><br>";
	postFooter();exit;
}
}

function check_user_agent() {
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	if (preg_match ( "/phone|iphone|itouch|ipod|symbian|android|htc_|htc-|palmos|blackberry|opera mini|iemobile|windows ce|nokia|fennec|hiptop|kindle|mot |mot-|webos\/|samsung|sonyericsson|^sie-|nintendo/i", $user_agent)){
		return true;
    }else{
		return false;
	}
}

$ismobile = check_user_agent();

if($ismobile){
	header("Location: gmscrn_old.php?action=proc");
}
elseif ( $mode == 'proc' && !$ismobile ){
	include('gmscrn_base.php');
}
else
{
	echo "<br><br><br>Undefined Action<br><br><br>";
	postFooter();
}
?>