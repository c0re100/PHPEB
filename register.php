<?php
include('cfu.php');
if (empty($CFU_RegLowerCaseOnly)) $CFU_RegLowerCaseOnly = '1';
?>
<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta name="GENERATOR" content="Microsoft FrontPage 5.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<title>User Registration - �Τ���U</title>
</head>

<?php

function reg_pFoot(){
	$mcfu_time = explode(' ', microtime());
	$cfu_ptime = number_format(($mcfu_time[1] + $mcfu_time[0] - $GLOBALS['cfu_stime']), 6);
	echo "<p align=center style=\"font-size: 10pt\">Registration System - v0.5 Version";
	echo "<br>&copy; 2005-2006 v2Alliance. All Rights Reserved.�@���v�Ҧ� ���o���<br>";
	if ($GLOBALS['Show_ptime'])
	echo "<font style=\"font-size: 7pt\">Processed in ".$cfu_ptime." second(s).</font></p>";
}

//Anti-Direct Connection
if (!$disabled_AUC){
	if (strpos($HTTP_REFERER,'index2.php') === false && strpos($HTTP_REFERER,'register.php') === false){
	echo "Unauthorized Connection Detected<br>Referer: $HTTP_REFERER<br>";
	echo "IP: $REMOTE_ADDR Logged<br>";
	postFooter();
	$contents = '/*'."Date: `$CFU_Date' \n Logged Username: `$Pl_Value[USERNAME]' \t\t Logged Password: `$Pl_Value[PASSWORD]'\n";
	$contents .= "IP: `$REMOTE_ADDR' \t\t Referer: `$HTTP_REFERER'\n";
	$contents .= "REQUEST_METHOD: `$REQUEST_METHOD' \t\t SCRIPT_FILENAME: `$SCRIPT_FILENAME' \nQUERY_STRING: `$QUERY_STRING '\n";
	$contents .= '_______________________________________________________';
	$contents .= '_______________________________________________________*/'."\n";
	$fp = fopen($AUC_Log,"r+");
	fwrite($fp,$contents);
	fclose($fp);
	exit;
	}
}

if ($MAX_PLAYERS){
$NumPlSQL = ("SELECT count(*) FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` WHERE `regkey` != 'npc';");
$NumPlSQL_Query = mysql_query($NumPlSQL);
$NumPl = mysql_fetch_row($NumPlSQL_Query);
	if ($NumPl[0] >= $MAX_PLAYERS){
		echo "<center><br><br>�n���H�ƤӦh�C<br>�{�n���H��: $OnlinePlNum[0]<br>�n���H�ƤW��: $MAX_PLAYERS<br><a href=\"index2.php\" target='_top' style=\"text-decoration: none\">�^�쭺��</a><br><br>";
		postFooter();exit;
	}
}

if ($OLimit){
	$Online_Time = time() - $Offline_Time;
	$OnlineSQL = ("SELECT count(time2) FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` WHERE `time2` > '$Online_Time' AND `regkey` != 'npc';");
	$OnlineSQL_Query = mysql_query($OnlineSQL);
	$OnlinePlNum = mysql_fetch_row($OnlineSQL_Query);
		if ($OnlinePlNum[0] >= $OLimit){
			echo "<center><br><br>�W�u�H�ƤӦh�C<br>�{�W�u�H��: $OnlinePlNum[0]<br>�W�u�H�ƤW��: $OLimit<br><a href=\"index2.php\" target='_top' style=\"text-decoration: none\">�^�쭺��</a><br><br>";
			postFooter();exit;
		}
}

$REGISTER_S1 = (isset($REGISTER_S1)) ? $REGISTER_S1 : 0;
if (!$REGISTER_S1){
if ($CFU_Time >= $TIMEAUTH+$TIME_OUT_TIME || $TIMEAUTH <= $CFU_Time-$TIME_OUT_TIME){echo "�s�u�O�ɡI<br><a href=\"index2.php\" target='_top' style=\"text-decoration: none\">�^�쭺��</a>";exit;}
echo "<script langauge=\"Javascript\">";
echo "window.status ='";
if ($MAX_PLAYERS)
echo "�@�n���H��: ".$NumPl[0]."/".$MAX_PLAYERS;
if ($OLimit)
echo "�@�W�u�H��: ".$OnlinePlNum[0]."/".$OLimit;

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
			}";
if(!$CFU_RegLowerCaseOnly)
echo "			else if((code >= 'A') && (code <= 'Z')){
				continue;
			}";
echo "			else{
				return false;
			}
		}
		return true;
	}
function checkRegister(){
	if (document.regform.reg_username.value ==''){alert('�п�J�ϥΪ̦W�١C');return false}
	else if(checkGname(document.regform.reg_gamename.value) == false){alert('�C�������W�٥X���C\\n�нT�w�W�٨S�t���u\\\�v, �u|�v, �u`�v, �u\\'�v,�u\"�v');return false}
	else if(document.regform.reg_password.value ==''){alert('�п�J�K�X�C');return false}
	else if(checkC(document.regform.reg_username.value) == false){alert('�ϥΪ̦W�٥u�i�H�O";if($CFU_RegLowerCaseOnly) echo "�p�g";echo "�^��r���P�Ʀr�զ��I\\n�ӥB����H�u0�v�}���I');return false;}
	else if(checkC(document.regform.reg_password.value) == false){alert('�K�X�u�i�H�O";if($CFU_RegLowerCaseOnly) echo "�p�g";echo "�^��r���P�Ʀr�զ��I\\n�ӥB����H�u0�v�}���I');return false;}
	else if(document.regform.reg_password.value != document.regform.reg_passwordconf.value){alert('���s��J���K�X���ۦP�A�Э��s��J�C');return false;}
	else if(pt_cal.innerHTML != 22){alert('��O�I�ƦX�p���O22�I');return false;}
	else {if (confirm('�H�W��Ƭҥ��T�B�i�H�}�l�n���ܡH') == true){return true}else {return false}}
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

<p align=\"center\" style=\"font-size: 18pt;font-weight: 800\">User Registration - �Τ���U</p>
<form action=register.php method=POST name=regform>
<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">
  <center>
  <table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#111111\" width=\"80%\" id=\"AutoNumber1\">
    <tr>
      <td width=\"33%\" style=\"font-size: 12pt;font-weight: 800\">ID:";if($CFU_RegLowerCaseOnly) echo "<font style=\"font-size: 9pt\">(�u��Τp�g�^��r���μƦr)</font>";echo "<br><input type=text name=reg_username maxlength=16></td>
      <td width=\"33%\" rowspan=\"4\" align=center><input type=\"submit\" name=\"Form[Submitbutton]\" value =\"Register - ���U\" onClick=\"return checkRegister()\"></td>
      <td width=\"34%\" rowspan=\"4\">&#12288;</td>
    </tr>
    <tr>
      <td width=\"33%\" style=\"font-size: 12pt;font-weight: 800\">Game Name:<font style=\"font-size: 9pt\">(����W��)</font><br><input type=text name=reg_gamename maxlength=16></td>
    </tr>
    <tr>
      <td width=\"33%\" style=\"font-size: 12pt;font-weight: 800\">Password:<font style=\"font-size: 9pt\">(�K�X)</font><br><input type=password name=reg_password maxlength=16></td>
    </tr>
    <tr>
      <td width=\"33%\" style=\"font-size: 12pt;font-weight: 800\">Re-Enter:<font style=\"font-size: 9pt\">(���s�T�{�K�X)</font><br><input type=password name=reg_passwordconf maxlength=16></td>
    </tr>
  </table>
  </center>

  <center>
  <table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#111111\" width=\"95%\" id=\"AutoNumber2\">
    <tr>
      <td width=\"100%\" style=\"font-size: 12pt;font-weight: 800\">���U�X: ";
if ($CFU_CheckRegKey) echo "<input type=text name=reg_key maxlength=10>";
else echo "N/A - ���A��";
echo "</td>
    </tr>
  </table>
  </center>


<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#111111\" width=\"100%\" id=\"AutoNumber3\">
  <tr rowspan=2>
    <td width=\"50%\" rowspan=\"3\" valign=top style=\"font-size: 12pt;font-weight: 800\">Color:<font style=\"font-size: 9pt\">(�ЬD���C��)</font><br>";

$br=0;$ct_default=0;
foreach ($MainColors as $CVAL){$br++;$ct_default++;
echo "<input type=\"radio\" name=\"REG_VAL[COLOR]\" value=#".$CVAL;
if ($ct_default==1) echo " checked";
echo "><font color=#".$CVAL.">��</font>&nbsp;";
if ($br==6){echo"<br>";$br=0;}
}


echo "</td>
    <td width=\"33%\" style=\"font-size: 12pt;font-weight: 800\">Type:<font style=\"font-size: 9pt\">(�ЬD��H������)</font><br><select size=6 name=\"REG_VAL[TYPE]\">
    <option value='nat' selected>�@��H</option>
    <option value='ext'>Extended</option>
    <option value='enh'>�j�ƤH</option>
    <option value='psy'>���ʤO</option>
    <option value='nt'>NT</option>
    <option value='co'>Coordinator</option>
    </select></td>
  </tr>
    <tr style=\"font-size: 10pt;\">
    <td width=\"34%\"><span lang=\"zh-tw\" style=\"font-size: 12pt;font-weight: 800\">��O�I��(�X�p�ݭn��22�I):</span><br>�����ޥ�: <select size=1 name=\"reg_at\"  onChange=\"calstatpt()\">
    <option value='1'>1<option value='2'>2<option value='3'>3<option value='4'>4<option value='5'>5<option value='6'>6<option value='7'>7<option value='8'>8<option value='9'>9<option value='10'>10
    </select><br>���m��O: <select size=1 name=\"reg_de\" onChange=\"calstatpt()\">
    <option value=1>1<option value=2>2<option value=3>3<option value=4>4<option value=5>5<option value=6>6<option value=7>7<option value=8>8<option value=9>9<option value=10>10
    </select><br>�R����O: <select size=1 name=\"reg_ta\" onChange=\"calstatpt()\">
    <option value=1>1<option value=2>2<option value=3>3<option value=4>4<option value=5>5<option value=6>6<option value=7>7<option value=8>8<option value=9>9<option value=10>10
    </select><br>�����O: <select size=1 name=\"reg_re\" onChange=\"calstatpt()\">
    <option value=1>1<option value=2>2<option value=3>3<option value=4>4<option value=5>5<option value=6>6<option value=7>7<option value=8>8<option value=9>9<option value=10>10
    </select><br>�X�p��: <span id=pt_cal style>4</span>
    </td>
  </tr>
</table>
<input type=hidden name=REGISTER_S1 value='1'>
</form>
</body>

";
}

elseif ($REGISTER_S1){
echo "<body bgcolor=\"#000000\" text=#dcdcdc link=#dcdcdc style=\"margin:0px 0px 0px 0px;\" oncontextmenu=\"return false;\" style=\"font-family: Arial\">";
if ($reg_password != $reg_passwordconf) {echo "�K�X���۹�";
exit;
}

if ($reg_username == '<AttackFort>'){echo "�W�٤��i�H�O�n��C";exit;}
if (preg_match("/^NPC/",$reg_username)){echo "�W�٤��i�H�ONPC�}���C";exit;}
if (preg_match("/^NPC/",$reg_gamename)){echo "�W�٤��i�H�ONPC�}���C";exit;}
$reg_username = str_replace("[\|\`(--)]+",'',$reg_username);
if ($CFU_RegLowerCaseOnly) $reg_username = strtolower($reg_username);

if($CFU_CheckRegKey){
	if ($reg_key != $NPC_RegKey){
unset($sql);
$sql= ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_regkeys` WHERE `regkey` = ".$reg_key." ");
$RegKeyQuery = mysql_query($sql);
$numsRKey = mysql_num_rows($RegKeyQuery);
if (!$numsRKey){echo "������o���U�X����T�C";postFooter();exit;}
$RegKeyData = mysql_fetch_array($RegKeyQuery);
if ($RegKeyData['status']){echo "���U�X�w�g�Q�ϥΡC";postFooter();exit;}
if($CFU_CheckIP){
$sql= ("SELECT count(*) FROM `".$GLOBALS['DBPrefix']."phpeb_regkeys` WHERE `ip` = ".$REMOTE_ADDR." ");
$ReadyReg = 0;
$RegKeyQuery = mysql_query($sql) or $ReadyReg = 1;
if(!$ReadyReg)
$RegKeyIPCheck = mysql_fetch_row($RegKeyQuery);
if ($RegKeyIPCheck >= 1){echo "IP�w�g�Q�ϥΡC";postFooter();exit;}
}
}}
else $reg_key = '';
$statusptmax=22;
if ($reg_at+$reg_de+$reg_ta+$reg_re != $statusptmax){
echo "��O�I���`�M���O $statusptmax �I";postFooter();exit;
}
$CASH_BASE=120000;
$CASH=$CASH_BASE;
if ($CFU_Time >= $TIMEAUTH+$TIME_OUT_TIME || $TIMEAUTH <= $CFU_Time-$TIME_OUT_TIME){echo "�s�u�O�ɡI";exit;}
if (!preg_match('/^(nat|ext|enh|psy|nt|co)$/',$REG_VAL['TYPE'])) {echo "�t�Υ���T�{�z�������A�Э��s��աC";postFooter();exit;}
else $CASH=$CASH_BASE*3;

if ($reg_at>10 || $reg_de>10 || $reg_ta>10 || $reg_re>10){echo "��O�L���I";postFooter();exit;}
if ($reg_at<=0 || $reg_de<=0 || $reg_ta<=0 || $reg_re<=0){echo "��O�L�C�I";postFooter();exit;}

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
		echo "<p align=center>ID�w���H�ϥ�<br>ID is already in use<br>ID: $reg_username";
		echo "<form action=index2.php method=post>";
		echo "<center><input type=submit value=Back name=backtoindex></form>";
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
		echo "<p align=center>�C���W�٤w���H�ϥ�<br>Game Name is already in use<br>Game Name: $reg_gamename";
		echo "<form action=index2.php method=post>";
		echo "<center><input type=submit value=Back name=backtoindex></form>";
		reg_pFoot();
		exit;
	}

	//Enter General Info
	$sql = ("INSERT INTO ".$GLOBALS['DBPrefix']."phpeb_user_general_info (username, password, regkey,cash,color,avatar,msuit,typech,growth,time1,time2,btltime,coordinates) VALUES('$reg_username',md5('$reg_password'),'$reg_key','$CASH','$REG_VAL[COLOR]','nil','0','$REG_VAL[TYPE]','0','$t_now' ,'$t_now' ,'','$CoordinatesSt')");
	mysql_query($sql) or die ('<br><center>���৹�����U (Location ID: Register01)<br>��]:' . mysql_error() . '<br>');

	//Enter Game Info
	$sql = ("INSERT INTO ".$GLOBALS['DBPrefix']."phpeb_user_game_info (username, gamename,attacking,defending,reacting,targeting) VALUES('$reg_username','$reg_gamename','$reg_at','$reg_de','$reg_re','$reg_ta')");
	mysql_query($sql) or die ('<br><center>���৹�����U (Location ID: Register02)<br>��]:' . mysql_error() . '<br>');

	//Enter Settings
	$sql = ("INSERT INTO ".$GLOBALS['DBPrefix']."phpeb_user_settings (username) VALUES('$reg_username')");
	mysql_query($sql) or die ('<br><center>���৹�����U (Location ID: Register05)<br>��]:' . mysql_error() . '<br>');

	//Enter Log
	$sql = ("INSERT INTO ".$GLOBALS['DBPrefix']."phpeb_user_log (username,log1, time1) VALUES('$reg_username','�w��Ө�php-eb���@�ɡI',UNIX_TIMESTAMP())");
	mysql_query($sql) or die ('<br><center>���৹�����U (Location ID: Register03)<br>��]:' . mysql_error() . '<br>');

	//Enter Bank
	$sql = ("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_user_bank` (username) VALUES('$reg_username')");
	mysql_query($sql) or die ('<br><center>���৹�����U (Location ID: Register04)<br>��]:' . mysql_error() . '<br>');


	if($CFU_CheckRegKey){
	//Update Reg Key
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_regkeys` SET `username` = '$reg_username',`status`  = '1', `ip` = '$REMOTE_ADDR' WHERE  `regkey` = '$RegKeyData[regkey]' LIMIT 1 ;");
	mysql_query($sql) or die ('<br><center>���৹�����U (Location ID: Register04)<br>��]:' . mysql_error() . '<br>');
	}

	echo "<p align=center>Register Complete!<br>���U�����I<br>ID: $reg_username<br>Please Remeber Your ID!<br>�к�O�z�� ID �I";
	echo "<br><br><br><font color=".$REG_VAL['COLOR'].">This is your Color! ~ �o�N�O�z���N���C��I</font>";
	?>
<form action=index2.php method=post>
<center><input type=submit value=Back name=backtoindex>
</form>
<?php
reg_pFoot();
}
?>




</html>