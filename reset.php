<?php
header('Content-Type: text/html; charset=utf-8');
$mode = ( isset($_GET['action']) ) ? $_GET['action'] : $_POST['action'];
include('cfu.php');
postHead('');
AuthUser();
if ($CFU_Time >= $_SESSION['timeauth'] + $TIME_OUT_TIME || $_SESSION['timeauth'] <= $CFU_Time - $TIME_OUT_TIME) {
    echo '驗證機制！<br>請重新登入！';
    exit;
}
GetUsrDetails("$_SESSION[username]",'Gen','Game');
CalcTotalStatPtsG('Pl',$Game['level']);
if ($mode == 'stats') {
	if($Game['reset']){echo "您已經使用過重置點數的機會！";postFooter;exit;}
	if($Gen['cash'] <= 1000000){echo "您沒有足夠金錢重置點數！";postFooter;exit;}
	
	if ($actionb == 'A'){
		echo "<form action=reset.php?action=stats method=post name=mainform>";
        echo "<input type=hidden value='B' name=actionb>";
        echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
		
		echo "<script language=\"Javascript\">";
        echo "function cfmRestat(){";
        echo "if (confirm('您確定要重置點數嗎？一但確認便無法回復！')==true){return true;}";
        echo "else {return false;}";
        echo "}</script>";
		
        echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
        echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">重置點數: </b><br><font color=red>一但確認便無法回復<br>並且您只有一次機會重新配置點數！</font></td></tr>";
        echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">總成長點數: $Pl_Growth_Total</b><br>";
		echo "攻擊: $Game[attacking]<br>";
		echo "防禦: $Game[defending]<br>";
		echo "迴避: $Game[reacting]<br>";
		echo "命中: $Game[targeting]<br>";
        echo "重置點數費用: 1,000,000元<br>";
        echo "<input type=submit value=確定 onClick=\"return cfmRestat()\">";
        echo "</td></tr>";
        echo "</form></table>";
	}
	elseif ($actionb == 'B'){
		if($Game['reset']){echo "您已經使用過重置點數的機會！";postFooter;exit;}
		if($Gen['cash'] <= 1000000){echo "您沒有足夠金錢重置點數！";postFooter;exit;}
		
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `attacking` = '0', `defending` = '0', `reacting` = '0', `targeting` = '0', `reset` = '1' WHERE `username`='$_SESSION[username]'");
		mysql_query($sql);
		$sql2 = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `growth` = '$Pl_Growth_Total', `cash` = cash-1000000 WHERE `username`='$_SESSION[username]'");
		mysql_query($sql2);
		
		echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
		echo "<center><font style=\"font-size: 12pt;\">重置點數成功！</font><br>";
		echo "<input type=submit $BStyleB style=\"$BStyleA\" value=\"返回\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p></center>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
		echo "</form>";
	}
	else {echo "未定義動作！";}
}
PostFooter();
?>