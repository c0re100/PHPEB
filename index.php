<?php
//Settings
$HTTP_REFERER = '';		//請 Set 作可正常連線位置, cfu.php 內的 「$Allow_AUC」參數
//End of Settings
$NoConnect=1;
$NoCheckRef=1;
include('cfu.php');
postHead('1');
$mode = ( isset($_GET['action']) ) ? $_GET['action'] : '';

$VERSION = "<span onmouseover=\"this.style.cursor='pointer';window.status='php-eb 官方網站';\" onmouseout=\"window.status=''\" onClick=\"window.open('http://forum.v2alliance.net/')\">v2alliance php-eb Version ". $cSpec ."</span>";
if ($vBdNum) $VERSION .= "　&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><font style='font-size: 10px'>Build ". $vBdNum ."</font>";
if ($sSpec) $VERSION .= "　&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><span style='font-size: 10px' onmouseout=\"window.status=''\" onmouseover=\"this.style.cursor='pointer';window.status='網主 \'".$WebMasterName."\' 的網站'\" onClick=\"window.open('".$WebMasterSite."')\">". $sSpec ."</span>";

if (!$mode){

session_start();
unset($_SESSION['username']);
unset($_SESSION['password']);
unset($_SESSION['timeauth']);
echo "<link href='$General_Image_Dir/style.css' type=text/css rel=stylesheet>";
echo "<body oncontextmenu=\"return false;\" style=\"background-image: url('$General_Image_Dir/background/atmosphere/a2.gif')\">";
echo "<base target=\"slfrm\">";

echo "<center><table width='750' height='520'><tr><td height='220'>";
//Name
echo "<div align=center style=\"font-size:70px;font-family: 'Monotype Corsiva';color:yellow;filter:alpha(opacity=100,finishopacity=0,style=2);height:60px;\">";
echo "<b>無盡的戰鬥</b></div>";
echo "<div align=right><p>$VERSION&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p></div>";
echo "</td></tr>";
//<!---[Lower Part - Start]--->
echo "<tr height='300'><td><table width='900' height='300'><tr>";
echo "<td width=135 style=\"background-color: transparent;font-weight: Bold;filter: glow(color=#3366FF,strength=3);\">";
echo "<a href=\"?action=Login\" style='text-decoration: none;font-size:18px'>&nbsp;&nbsp;登入遊戲</a><p>";
echo "<a href=\"?action=Pedia\" style='text-decoration: none;font-size:18px'>&nbsp;&nbsp;遊戲資料</a></p>";
echo "<p><a href=\"gen_info.php?action=history\" style='text-decoration: none;font-size:18px'>&nbsp;&nbsp;歷史紀錄</a></p>";
echo "<p><a href=\"http://ext4.me/forum.php?mod=viewthread&tid=20&page=1\" TARGET=\"_blank\" style='text-decoration: none;font-size:18px'>&nbsp;&nbsp;最新公告</a></p>";
$consql = mysql_connect("localhost","ebs","wfc");
mysql_select_db("phpeb", $consql);
$query = mysql_query("SELECT count(username) as num FROM ".$GLOBALS['DBPrefix']."phpeb_user_general_info WHERE `username` NOT LIKE '%NPC%'");
$cnt = mysql_result($query, 0);
echo "<p style='color:red;text-decoration: none;font-size:16px'>&nbsp;&nbsp;註冊人數： $cnt</p>";

$Online_Time = time() - $Offline_Time;
$OnlineSQL = ("SELECT count(lastlogin) FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` WHERE `username` NOT LIKE '%c0re%' AND `lastlogin` > '$Online_Time'");
$OnlineSQL_Query = mysql_query($OnlineSQL);
$OnlinePlNum = mysql_result($OnlineSQL_Query, 0);
echo "<p style='color:red;text-decoration: none;font-size:16px'>&nbsp;&nbsp;在線人數： $OnlinePlNum</p>";
mysql_close($consql);
echo "<td width=665>";
echo "<iframe name='slfrm' src='?action=Login' width='650' height='300' marginheight=0 marginwidth=0 frameborder=0 style=\"background: transparent;\">";
echo "</td>";


echo "</tr></table></center>";

//<!---[Lower Part - End]--->


echo "</td></tr></table></body></html></iframe>";
echo "<font style=\"color:blue; font-weight: Bold;\">";
PostFooter();
echo "</font>";
}
elseif ($mode == 'Login'){


echo "<link href='$General_Image_Dir/style.css' type=text/css rel=stylesheet>";

echo "<body oncontextmenu=\"return false;\"><table width='600' height='300'><tr><td>";
echo "<p align='center'><b>";
echo "<font face='Arial' style=\"font-size: 52px;filter: glow(color=#3366FF,strength=8); height:10px; color:white\">";
echo "登入";
echo "</font></b></p>";
echo "<form action=\"logins.php\" method=post name=login target=_parent>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
echo "<p align='center'>";
echo "帳戶: <input type=text name=\"username\" style=\"height:21px; color:#ededed; font-size:16px; background: transparent; border:1px solid white; \" size=\"20\">";
echo "<br>";
echo "密碼: <input type=password name=\"password\" style=\"height:21px; color:#ededed; font-size:16px; background: transparent; border:1px solid white; \" size=\"20\">";
echo "<p align='center'>";
echo "<input type='submit' name='login' value='登入'><input type='reset' value='重設'></p>";
echo "<center><font onClick=\"login.action='register.php';login.submit();\" style=\"font-size: 16px;font-weight: Bold;filter: glow(color=#3366FF,strength=3); height:10px; color:yellow;\"><a href=\"#\"><br>&nbsp;按此註冊&nbsp;</a></font>";
echo "</form>";
echo "</td></tr></table></body></html>";

}

elseif ($mode == 'Pedia'){
echo "<link href='$General_Image_Dir/style.css' type=text/css rel=stylesheet>";

echo "<center>";

echo "<br><br><br><br>
<table border=0 cellpadding=0 cellspacing=0 align=center style=\"border:1px solid #606060;font-size:16px;\">
	<tr>
	<td colspan=2>&nbsp;Infopedia</td>
	</tr>
	<tr>
	<td><a href=\"gen_info.php?action=weplist\" target=\"_blank\" style=\"font-size:20px;\"><b>武器列表</b></a></td>
	</tr>
	<tr>
	<td><a href=\"gen_info.php?action=mslist\" target=\"_blank\" style=\"font-size:20px;\"><b>機體列表</b></a></td>
	</tr>
	<tr>
	<td><a href=\"gen_info.php?action=calpt\" target=\"_blank\" style=\"font-size:20px;\"><b>Pt Cal</b></a></td>
	</tr>
	<tr>
	<td><a href=\"gen_info.php?action=cal\" target=\"_blank\" style=\"font-size:20px;\"><b>經驗值表</b></a></td>
	</tr>
	</table>
";

echo "</body>";
}
?>