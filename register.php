<?php
include('cfu.php');
?>
<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta name="GENERATOR" content="Microsoft FrontPage 5.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<title>無盡的戰鬥 - 註冊</title>
</head>

<?php

function reg_pFoot(){
	$mcfu_time = explode(' ', microtime());
	$cfu_ptime = number_format(($mcfu_time[1] + $mcfu_time[0] - $GLOBALS['cfu_stime']), 6);
	if ($GLOBALS['Show_ptime'])
	echo "<font style=\"font-size: 7pt\">Processed in ".$cfu_ptime." second(s).</font></p>";
}

if ($MAX_PLAYERS){
$NumPlSQL = ("SELECT count(*) FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` WHERE `regkey` != 'npc';");
$NumPlSQL_Query = mysql_query($NumPlSQL);
$NumPl = mysql_fetch_row($NumPlSQL_Query);
	if ($NumPl[0] >= $MAX_PLAYERS){
		echo "<center><br><br>登錄人數太多。<br>現登錄人數: $OnlinePlNum[0]<br>登錄人數上限: $MAX_PLAYERS<br><a href=\"index.php\" target='_top' style=\"text-decoration: none\">回到首頁</a><br><br>";
		postFooter();exit;
	}
}

if ($OLimit){
	$Online_Time = time() - $Offline_Time;
	$OnlineSQL = ("SELECT count(lastlogin) FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` WHERE `lastlogin` > '$Online_Time' AND `regkey` != 'npc';");
	$OnlineSQL_Query = mysql_query($OnlineSQL);
	$OnlinePlNum = mysql_fetch_row($OnlineSQL_Query);
		if ($OnlinePlNum[0] >= $OLimit){
			echo "<center><br><br>上線人數太多。<br>現上線人數: $OnlinePlNum[0]<br>上線人數上限: $OLimit<br><a href=\"index.php\" target='_top' style=\"text-decoration: none\">回到首頁</a><br><br>";
			postFooter();exit;
		}
}

$REGISTER_S1 = (isset($REGISTER_S1)) ? $REGISTER_S1 : 0;
if (!$REGISTER_S1){
echo "<script langauge=\"Javascript\">";
echo "window.status ='";
if ($MAX_PLAYERS)
echo "　登錄人數: ".$NumPl[0]."/".$MAX_PLAYERS;
if ($OLimit)
echo "　上線人數: ".$OnlinePlNum[0]."/".$OLimit;

echo "';";
	$restriction = array("|","`","'","--","\"","\\");
echo "
function checkGname(name){
	if(name == '') return false;
	else if(name.match(/['\"|\\\`(--)]+/g)) return false;
	else if(name.match(/^0.*/g)) return false;
	return true;
}
function checkC(str){
		var word = str;
		if(word.match(/^0.*/g)) return false;
		for(var c = 0 ; c < word.length ; c++){
			var code = word.charAt(c);
			if((code >= '0') && (code <= '9')){
				continue;
			}
			else if((code >= 'a') && (code <= 'z')){
				continue;
			}
			else if((code >= 'A') && (code <= 'Z')){
				continue;
			}
			else{
				return false;
			}
		}
		return true;
	}
function checkRegister(){
	if (document.regform.reg_username.value == ''){alert('請輸入登入帳戶。');return false}
	else if(document.regform.reg_username.value == 'NPC'){alert('禁止以NPC作為登入帳戶!!!');return false;}
	else if(checkGname(document.regform.reg_gamename.value) == false){alert('遊戲內的名稱出錯。\\n請確定名稱沒含有「\\\」, 「|」, 「`」, 「\\'」,「\"」');return false}
	else if(document.regform.reg_password.value == ''){alert('請輸入密碼。');return false}
	else if(document.regform.reg_gamename.value == 'NPC'){alert('禁止以NPC作為遊戲名稱!!!');return false;}
	else if(regform.reg_gamename.value.trim().length == 0){alert('遊戲名稱只可以由中文,英文或數字組成!!!');return false;}
	else if(checkC(document.regform.reg_username.value) == false){alert('登入帳戶只可以是由英文字母與數字組成!!!');return false;}
	else if(checkC(document.regform.reg_password.value) == false){alert('密碼只可以是由英文字母與數字組成!!!');return false;}
	else if(document.regform.reg_password.value != document.regform.reg_passwordconf.value){alert('重新輸入的密碼不相同，請重新輸入。');return false;}
	else if(pt_cal.innerHTML != 22){alert('能力點數合計不是22！');return false;}
	else {if (confirm('以上資料皆正確、可以開始登錄嗎？') == true){return true}else {return false}}
}
function calstatpt(){
	var At = 1*(document.regform.reg_at.value);
	var De = 1*(document.regform.reg_de.value);
	var Ta = 1*(document.regform.reg_ta.value);
	var Re = 1*(document.regform.reg_re.value);
	var statsum = At;
	statsum += De;
	statsum += Ta;
	statsum += Re;
	pt_cal.innerHTML = statsum;
	pt_cal.style.color='blue';
	if (statsum > 22){pt_cal.style.color='red';}
	if (statsum == 4){pt_cal.style.color='white';}
	if (statsum == 22){pt_cal.style.color='yellow';}

	}
</script>
<body bgcolor=\"#000000\" text=#dcdcdc link=#dcdcdc style=\"margin:0px 0px 0px 0px;\" style=\"font-family: Arial\" oncontextmenu=\"return false;\">

<center>
<p align=\"center\" style=\"font-size: 18pt;font-weight: 800\">註冊</p>
<form action=register.php method=POST name=regform>
<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">
  <center>
  <table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#111111\" width=\"80%\" id=\"AutoNumber1\">
    <tr>
      <td width=\"100%\" style=\"font-size: 12pt;font-weight: 800\" align=\"center\">登入帳戶:<font style=\"font-size: 9pt\">(只能用大小寫英文字母及數字)</font><br><input type=text name=reg_username maxlength=16></td>
    </tr>
    <tr>
      <td width=\"100%\" style=\"font-size: 12pt;font-weight: 800\" align=\"center\">遊戲名稱:<br><input type=text name=reg_gamename maxlength=16></td>
    </tr>
    <tr>
      <td width=\"100%\" style=\"font-size: 12pt;font-weight: 800\" align=\"center\">密碼:<font style=\"font-size: 9pt\">(只能用大小寫英文字母及數字)</font><br><input type=password name=reg_password maxlength=16></td>
    </tr>
    <tr>
      <td width=\"100%\" style=\"font-size: 12pt;font-weight: 800\" align=\"center\">確認密碼:<br><input type=password name=reg_passwordconf maxlength=16></td>
    </tr>
  </table>
  </center>

  <center>
  <table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#111111\" width=\"95%\" id=\"AutoNumber2\">
    <tr>
    </tr>
  </table>
  </center>


<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#111111\" width=\"100%\" id=\"AutoNumber3\">
  <tr rowspan=2>
    <td width=\"50%\" rowspan=\"3\" valign=top style=\"font-size: 12pt;font-weight: 800\" align=\"right\">代表顏色:<font style=\"font-size: 9pt\">(請挑選顏色)</font><br>";

$br=0;$ct_default=0;
foreach ($MainColors as $CVAL){$br++;$ct_default++;
echo "<input type=\"radio\" name=\"REG_VAL[COLOR]\" value=#".$CVAL;
if ($ct_default==1) echo " checked";
echo "><font color=#".$CVAL.">■</font>&nbsp;";
if ($br==6){echo"<br>";$br=0;}
}


echo "</td>
    <td width=\"50%\" style=\"font-size: 12pt;font-weight: 800\">種族:<font style=\"font-size: 9pt\">(請挑選人物類型)</font><br><select size=6 name=\"REG_VAL[TYPE]\">
    <option value='nat' selected>一般人</option>
    <option value='ext'>Extended</option>
    <option value='enh'>強化人</option>
    <option value='psy'>念動力</option>
    <option value='nt'>NT</option>
    <option value='co'>Coordinator</option>
    </select></td>
  </tr>
    <tr style=\"font-size: 10pt;\">
    <td width=\"34%\"><span lang=\"zh-tw\" style=\"font-size: 12pt;font-weight: 800\">能力點數(合計需要為22點):</span><br>攻擊能力: <select size=1 name=\"reg_at\"  onChange=\"calstatpt()\">
    <option value='1'>1<option value='2'>2<option value='3'>3<option value='4'>4<option value='5'>5<option value='6'>6<option value='7'>7<option value='8'>8<option value='9'>9<option value='10'>10
    </select><br>防禦能力: <select size=1 name=\"reg_de\" onChange=\"calstatpt()\">
    <option value=1>1<option value=2>2<option value=3>3<option value=4>4<option value=5>5<option value=6>6<option value=7>7<option value=8>8<option value=9>9<option value=10>10
    </select><br>命中能力: <select size=1 name=\"reg_ta\" onChange=\"calstatpt()\">
    <option value=1>1<option value=2>2<option value=3>3<option value=4>4<option value=5>5<option value=6>6<option value=7>7<option value=8>8<option value=9>9<option value=10>10
    </select><br>迴避能力: <select size=1 name=\"reg_re\" onChange=\"calstatpt()\">
    <option value=1>1<option value=2>2<option value=3>3<option value=4>4<option value=5>5<option value=6>6<option value=7>7<option value=8>8<option value=9>9<option value=10>10
    </select><br>合計值: <span id=pt_cal style>4</span>
    </td>
  </tr>
</table>
<input type=hidden name=REGISTER_S1 value='1'>
<br>
<td width=\"33%\" rowspan=\"4\" align=center><input type=\"submit\" name=\"Form[Submitbutton]\" value =\"註冊\" onClick=\"return checkRegister()\"></td>
</center>
</form>
</body>

";
}

elseif ($REGISTER_S1){
echo "<body bgcolor=\"#000000\" text=#dcdcdc link=#dcdcdc style=\"margin:0px 0px 0px 0px;\" oncontextmenu=\"return false;\" style=\"font-family: Arial\">";
if ($reg_password != $reg_passwordconf) {echo "密碼與確認密碼不相同！";
exit;
}

if ($reg_username == '<AttackFort>'){echo "遊戲名稱不可以是要塞。";exit;}
if (preg_match("/^NPC/i",$reg_username)){echo "登入帳戶不可以是NPC。";exit;}
if (preg_match("/^NPC/i",$reg_gamename)){echo "遊戲名稱不可以是NPC。";exit;}
$reg_username = str_replace("[\|\`(--)]+",'',$reg_username);

$statusptmax=22;
if ($reg_at+$reg_de+$reg_ta+$reg_re != $statusptmax){
echo "能力點數總和不是 $statusptmax ！";postFooter();exit;
}
$CASH_BASE=120000;
$CASH=$CASH_BASE;
if (!preg_match('/^(nat|ext|enh|psy|nt|co)$/',$REG_VAL['TYPE'])) {echo "系統未能確認您的種族，請重新賞試。";postFooter();exit;}
else $CASH=$CASH_BASE*3;

if ($reg_at>10 || $reg_de>10 || $reg_ta>10 || $reg_re>10){echo "能力過高！";postFooter();exit;}
if ($reg_at<=0 || $reg_de<=0 || $reg_ta<=0 || $reg_re<=0){echo "能力過低！";postFooter();exit;}

$CASH=floor($CASH);
$t_now=time();

//Analyze Coordinates
mt_srand ((double) microtime()*1000000);
switch(mt_rand(0,$StartZoneRestriction)){
	case 0: $CoordinatesSt='A1';break;
	case 1: $CoordinatesSt='A2';break;
	case 2: $CoordinatesSt='A3';break;
	case 3: $CoordinatesSt='B1';break;
	case 4: $CoordinatesSt='B2';break;
	case 5: $CoordinatesSt='B3';break;
	case 6: $CoordinatesSt='C1';break;
	case 7: $CoordinatesSt='C2';break;
	case 8: $CoordinatesSt='C3';break;
	default : $CoordinatesSt='A1';break;
}
switch(mt_rand(0,3)){
	case 0: $CoordinatesSt .= 'N';break;
	case 1: $CoordinatesSt .= 'E';break;
	case 2: $CoordinatesSt .= 'S';break;
	default: $CoordinatesSt .= 'W';break;
}
	
	$onlineip = $_SERVER['REMOTE_ADDR'];
	
	$reg_username = mysql_real_escape_string($reg_username);
	$reg_password = mysql_real_escape_string($reg_password);
	$REG_VAL['COLOR'] = mysql_real_escape_string($REG_VAL['COLOR']);
	$REG_VAL['TYPE'] = mysql_real_escape_string($REG_VAL['TYPE']);
	
	//Check Username
	$sql= ("SELECT `username` FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info`");
	$CheckUsrQ = mysql_query($sql);
	$UsrC_Halt = 0;
	while($UsrC = mysql_fetch_row($CheckUsrQ)){
		$str1 = strtoupper($reg_username);
		$str2 = strtoupper($UsrC[0]);
		if($str1 == $str2) $UsrC_Halt++;
		break;
	}
	if($UsrC_Halt) {
		echo "<p align=center style='color: red'>登入帳戶已有人使用<br>登入帳戶: $reg_username";
		echo "<form action=register.php method=post>";
		echo "<center><input type=submit value=回到註冊 name=backtoreg></form><br><br>";
		reg_pFoot();
		exit;
	}
	//Check Gamename
	$restriction = array("|","`","'","--","\"","\\");
	$reg_gamename = str_replace($restriction,'',$reg_gamename);
	$sql= ("SELECT COUNT(*) FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `gamename` = '$reg_gamename'");
	$CheckGnmQ = mysql_query($sql);
	$GnmC_Halt = 0;
	list($CountGameName) = mysql_fetch_row($CheckGnmQ);
	$GnmC_Halt += $CountGameName;

	if($GnmC_Halt) {
		echo "<p align=center style='color: red'>遊戲名稱已有人使用<br>遊戲名稱: $reg_gamename";
		echo "<form action=register.php method=post>";
		echo "<center><input type=submit value=回到註冊 name=backtoreg></form><br><br>";
		reg_pFoot();
		exit;
	}

	//Enter General Info
	$sql = ("INSERT INTO ".$GLOBALS['DBPrefix']."phpeb_user_general_info (username, password, cash,color,avatar,msuit,typech,growth,time1,time2,btltime,coordinates,lastlogin,lastip) VALUES('$reg_username',md5('$reg_password'),'$CASH','$REG_VAL[COLOR]','nil','0','$REG_VAL[TYPE]','0','$t_now' ,'$t_now' ,'','$CoordinatesSt','$t_now','$onlineip')");
	mysql_query($sql) or die ('<br><center>未能完成註冊 (Location ID: Register01)<br>原因:' . mysql_error() . '<br>');

	//Enter Game Info
	$sql = ("INSERT INTO ".$GLOBALS['DBPrefix']."phpeb_user_game_info (username, gamename,attacking,defending,reacting,targeting) VALUES('$reg_username','$reg_gamename','$reg_at','$reg_de','$reg_re','$reg_ta')");
	mysql_query($sql) or die ('<br><center>未能完成註冊 (Location ID: Register02)<br>原因:' . mysql_error() . '<br>');

	//Enter Settings
	$sql = ("INSERT INTO ".$GLOBALS['DBPrefix']."phpeb_user_settings (username) VALUES('$reg_username')");
	mysql_query($sql) or die ('<br><center>未能完成註冊 (Location ID: Register05)<br>原因:' . mysql_error() . '<br>');

	//Enter Log
	$sql = ("INSERT INTO ".$GLOBALS['DBPrefix']."phpeb_user_log (username,log1, time1) VALUES('$reg_username','歡迎來到php-eb的世界！',UNIX_TIMESTAMP())");
	mysql_query($sql) or die ('<br><center>未能完成註冊 (Location ID: Register03)<br>原因:' . mysql_error() . '<br>');

	//Enter Bank
	$sql = ("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_user_bank` (username) VALUES('$reg_username')");
	mysql_query($sql) or die ('<br><center>未能完成註冊 (Location ID: Register04)<br>原因:' . mysql_error() . '<br>');


	echo "<p align=center>Register Complete!<br>註冊完成！<br>ID: $reg_username<br>請緊記您的 ID ！";
	echo "<br><br><br><font color=".$REG_VAL['COLOR'].">這就是您的代表顏色！</font>";
	?>
<form action=index.php method=post>
<center><input type=submit value=回到主頁 name=backtoindex>
</form>
<br><br>
<?php
reg_pFoot();
}
?>




</html>