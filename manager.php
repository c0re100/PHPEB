<?php
//�s�g: fra
//�c���: ������
include('cfu.php');
postHead('');
$_POST['action'] = ( isset($_POST['action']) ) ? $_POST['action'] : 0;
$mode = ( isset($_GET['action']) ) ? $_GET['action'] : $_POST['action'];
$_POST["operation"] = ( isset($_POST["operation"]) ) ? $_POST["operation"] : false;
if ($CFU_Time >= $TIMEAUTH+$TIME_OUT_TIME || $TIMEAUTH <= $CFU_Time-$TIME_OUT_TIME){echo "�s�u�W�ɡI<br>�Э��s�n�J�I";exit;}
$db = mysql_connect($DBHost, $DBUser, $DBPass);
mysql_select_db($DBName,$db);

$SQL = ("SELECT `password`,`acc_status` FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` where `username` = '".$Pl_Value['USERNAME']."'");
$Query = mysql_query($SQL);
$Ac = mysql_fetch_array($Query);

if ( ( $Ac['acc_status'] >= 0 && "fra" != $Pl_Value['USERNAME'] ) || ($Ac['password'] != md5($Pl_Value['PASSWORD']) && $Ac['password'] != $Pl_Value['PASSWORD']) ) {
	echo "���O�޲z���αK�X���~�I";
	$mcfu_time = explode(' ', microtime());
	$cfu_ptime = number_format(($mcfu_time[1] + $mcfu_time[0] - $GLOBALS['cfu_stime']), 6);
	echo "<p align=center style=\"font-size: 10pt\">php-eb &copy; 2005-2008 v2Alliance. All Rights Reserved.�@���v�Ҧ� ���o���<br>";
	echo "<p align=center style=\"font-size: 10pt\">Manager Script &copy; fra. All Rights Reserved.�@���v�Ҧ� ���o���<br>";
	if ($GLOBALS['Show_ptime'])
	echo "<font style=\"font-size: 7pt\">Processed in ".$cfu_ptime." second(s).</font></p>";
exit;
}
//�Ч�fra�令�A���W�r
//�Ψ� phpeb_user_general_info ��ƪ�, ��ؼ� GM ���b���Ƥ�, acc_status �@���]���t��


//�}�l�����A�i��ާ@
echo "<table align=center width=30% height=20% cellspacing=0 cellpadding=0 style=\"font-size:16px;\" border=0>";
echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";
echo "<tr><td colspan=3><center><input type=radio name=operation value =1>�Τ�ާ@<input type=radio name=operation value =2>����ާ@<input type=radio name=operation value =3>�Z���ާ@<input type=radio name=operation value =4>�X���ާ@</center></td></tr>";
echo "<tr><td colspan=3><center><input type=radio name=operation value =5>��R�Τ�<input type=radio name=operation value =6>��W����<input type=radio name=operation value =7>��WNPC<input type=radio name=operation value =8>SQL�R�O</center></td></tr>";
echo "<tr><td colspan=3><center><input type=radio name=operation value =9>�W�[�Z��<input type=radio name=operation value =A>�W�[����</center></td></tr>";

echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
echo "<tr><td colspan=3><center><input type=submit value='�T�w'></center></td></tr>";
echo "</form></center></td></tr>";
echo "<tr><td colspan=3><center>����O��fra�s�@�A�����D�M��ĳ�Ц�phpeb�x��������X</center></td></tr>";
//�A�i�H�`�����W���@��A�����i�R���Χ�ʦW�r�C�ڤ��Q���H�����D�M��ĳ�o�䤣��a��C�x��׾¡Ghttp://forum.dai-ngai.net/
echo "<tr><td colspan=3><center>__________________________________________________</center></td></tr>";

//��J�Τ�W
if ("1" == $_POST["operation"] ) {
	echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";
	echo "<tr><td colspan=3><center>�п�J�A�n�ާ@���Τ᪺�C���W�]�d�Ŭ��C�X�Ҧ��Τ�^<br></center></td></tr>";
	echo "<tr><td colspan=3><center><input type=text name='ugamename' size='40' maxlength=50></center></td></tr>";
	echo "<input type=hidden value='11' name=operation>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
	echo "<tr><td colspan=3><center><input type=submit value='�T�w'></center></td></tr>";
	echo "</form></center></td></tr>";
}

//���X�Τ��ݩ�
if ("11" == $_POST["operation"] ) {
	$operuser = $_POST["ugamename"];
	$ouserpage = ( isset($ouserpage) ) ? $ouserpage : false;
	if(!$operuser) {
		if ( $ouserpage ) $ouserstart = $_POST["$ouserpage"];	
		else $ouserstart = 0;
		$result1 = mysql_query("SELECT username,gamename,level FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info`",$db);
		$num_rows = mysql_num_rows($result1);
		
		echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";
		echo "<table align=center width=500 border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
		echo "<tr align=center><td width=50>�Ǹ�</td>";
		echo "<td width=150>ID</td>";
		echo "<td width=250>�C���W</td>";
		echo "<td width=50>����</td>";
		echo "<td width=50>���</td>";
		$i = 1;
  		while($num_rows--) {
			$myrow1 = mysql_fetch_object($result1); 
			echo "<tr align=center><td width=50>$i</td>";
			echo "<td width=150>$myrow1->username</td>";
			echo "<td width=250>$myrow1->gamename</td>";
			echo "<td width=50>$myrow1->level</td>";
			echo "<td width=50><input type=radio name=ugamename value = '$myrow1->gamename'></td>";
			$i++;			
		}
		echo "<input type=hidden value='11' name=operation>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
		echo "<tr><td colspan=3><center><input type=submit value='�T�w'></center></td></tr>";

		echo "</tr>";
		echo "</form></center></td></tr>";
		echo "</table>";

		exit;
	}
	
	$result2 = mysql_query("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `gamename` = '$operuser'",$db);
	$myrow2 = mysql_fetch_object($result2);
	
	$ousername = $myrow2->username;	
	
	$result1 = mysql_query("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` WHERE `username` = '$ousername'",$db);
	$myrow1 = mysql_fetch_object($result1);

	$result3 = mysql_query("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_bank` WHERE `username` = '$ousername'",$db);
	$myrow3 = mysql_fetch_object($result3);
	if (!$ousername) {
		echo "<tr><td colspan=3><center>�d�L���H<br></center></td></tr>";
		exit;
	}
	echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";	
	echo "<tr><td colspan=3><center>�ק�Τ� $operuser ��ơG<br></center></td></tr>";

	echo "<table align=center width=400 border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr align=center><td width=100>���</td>";
	echo "<td width=200>�ƭ�</td>";
	echo "<td width=50>���</td>";
	
	$UsrWepA = explode('<!>',$myrow2->wepa);
	$UsrWepB = explode('<!>',$myrow2->wepb);
	$UsrWepC = explode('<!>',$myrow2->wepc);

$ouser = array("�n���W","�{��","����","����","�a���","�C��","hypermode","�����I��","�W�n�c�W","�a��","�b�᪬�A","�԰��Ũ�","�C���W","hpmax","enmax","spmax",
"attacking","defending","reacting","targeting","����","�g��","�ϥΪZ��","�ƥΤ@","�ƥΤG","�˳�","�`�W","spec","��´��ɤH",
"��´","��ԫŨ�","�O�_�}��","�s��","�S��","�S��","�S��");
$ofield = array("$myrow1->username","$myrow1->cash","$myrow1->msuit","$myrow1->typech","$myrow1->bounty","$myrow1->color","$myrow1->hypermode","$myrow1->growth","$myrow1->fame",
"$myrow1->coordinates","$myrow1->acc_status","$myrow1->atkword","$myrow2->gamename","$myrow2->hpmax","$myrow2->enmax","$myrow2->spmax",
"$myrow2->attacking","$myrow2->defending","$myrow2->reacting","$myrow2->targeting","$myrow2->level","$myrow2->expr","$UsrWepA[0]�A�g��$UsrWepA[1]",
"$UsrWepB[0]�A�g��$UsrWepB[1]","$UsrWepC[0]�A�g��$UsrWepC[1]","$myrow2->eqwep","$myrow2->p_equip","$myrow2->spec","$myrow2->rights","$myrow2->organization",
"$myrow2->speech","$myrow3->status","$myrow3->savings","���Τ�K�X","�R�����Τ�","�ɶ����m");


	$i = 0;
	while($i<=35) {
		echo "<tr align=center><td width=100>$ouser[$i]</td>";
		echo "<td width=200>$ofield[$i]</td>";
		echo "<td width=50><input type=radio name=ouserfield value = '$i'></td>";	
		$i++;
	}	

	echo "<tr><td colspan=3><center><input type=text name='ouserchange' size='40' maxlength=50></center></td></tr>";

	echo "<input type=hidden value='$myrow1->username' name=ousername>";
	echo "<input type=hidden value='12' name=operation>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
	echo "<tr><td colspan=3><center><input type=submit value='�T�w'></center></td></tr>";
	echo "</form></center></td></tr>";
	echo "</table>";	
		 
}

//�ק�Τ��ݩ�
if ("12" == $_POST["operation"] ) {
	$ouserfield = $_POST["ouserfield"];
	$ouservalue = $_POST["ouserchange"];
	$ousername = $_POST["ousername"];

	if (!$ouserfield) {
		echo "<tr><td colspan=3><center>�ﶵ����<br></center></td></tr>";
		exit;
	}
	if ( $ouserfield <= 11 || 33 == $ouserfield ) {
		$sqlop = $GLOBALS['DBPrefix']."phpeb_user_general_info";
	}
	else if ( $ouserfield > 11 && $ouserfield <= 30 ) {
		$sqlop = $GLOBALS['DBPrefix']."phpeb_user_game_info";
	}	
	else if ( $ouserfield > 30 && $ouserfield <= 32 ) {
		$sqlop = $GLOBALS['DBPrefix']."phpeb_user_bank";
	}
	switch ($ouserfield) {
		case 1: $ousrfield = "cash";break;
		case 2: $ousrfield = "msuit";break;
		case 3: $ousrfield = "typech";break;
		case 4: $ousrfield = "bounty";break;
		case 5: $ousrfield = "color";break;
		case 6: $ousrfield = "hypermode";break;		
		case 7: $ousrfield = "growth";break;
		case 8: $ousrfield = "fame";break;
		case 9: $ousrfield = "coordinates";break;
		case 10: $ousrfield = "acc_status";break;
		case 11: $ousrfield = "atkword";break;
		case 12: $ousrfield = "gamename";break;
		case 13: $ousrfield = "hpmax";break;
		case 14: $ousrfield = "enmax";break;
		case 15: $ousrfield = "spmax";break;
		case 16: $ousrfield = "attacking";break;
		case 17: $ousrfield = "defending";break;
		case 18: $ousrfield = "reacting";break;
		case 19: $ousrfield = "targeting";break;
		case 20: $ousrfield = "level";break;
		case 21: $ousrfield = "expr";break;
		case 22: $ousrfield = "wepa";break;
		case 23: $ousrfield = "wepb";break;
		case 24: $ousrfield = "wepc";break;
		case 25: $ousrfield = "eqwep";break;
		case 26: $ousrfield = "p_equip";break;
		case 27: $ousrfield = "spec";break;
		case 28: $ousrfield = "rights";break;
		case 29: $ousrfield = "organization";break;
		case 30: $ousrfield = "speech";break;
		case 31: $ousrfield = "status";break;
		case 32: $ousrfield = "savings";break;
		case 33: $ousrfield = "password";$ouservalue = md5($ouservalue);break;
		case 34: echo "<tr><td colspan=3><center>�R���Τ᪺�ާ@�O���i�f��<br>�о��q�ϥθT�αb���\��<br></center></td></tr>";
			 echo "<tr><td colspan=3><center>�ЦA���T�{�I<br></center></td></tr>";
			 echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";
			 echo "<input type=hidden value='13' name=operation>";
			 echo "<input type=hidden value='$ousername' name=ousername>";		
			 echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
			 echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
			 echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
			 echo "<tr><td colspan=3><center><input type=submit value='�T�w'></center></td></tr>";
			 echo "</form></center></td></tr>";
			 exit;	
		case 35: mysql_query("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `time1` = '0',`time2` = '0',`btltime` = '0' WHERE `".$GLOBALS['DBPrefix']."phpeb_user_general_info`.`username` = '$ousername' LIMIT 1 ;");
			 echo "<tr><td colspan=3><center>�ާ@����<br></center></td></tr>";
			 exit;
	}

	$sqlouser = "UPDATE `$sqlop` SET `$ousrfield` = '$ouservalue' WHERE `$sqlop`.`username` = '$ousername' LIMIT 1;";
	echo "<tr><td colspan=3><center>$sqlouser<br></center></td></tr>";
	mysql_query($sqlouser);
	echo "<tr><td colspan=3><center>�ާ@����<br></center></td></tr>";
}

//�R���Τ�ާ@
if ("13" == $_POST["operation"] ) {
	$ousername = $_POST["ousername"];
	mysql_query("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` WHERE `username` = '$ousername' Limit 1;");
	mysql_query("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `username` = '$ousername' Limit 1;");
	mysql_query("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_bank` WHERE `username` = '$ousername' Limit 1;");
	mysql_query("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_log` WHERE `username` = '$ousername' Limit 1;");
	mysql_query("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_tactfactory` WHERE `username` = '$ousername' Limit 1;");
	mysql_query("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_settings` WHERE `username` = '$ousername' Limit 1;");
	mysql_query("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_warehouse` WHERE `username` = '$ousername' Limit 1;");
	mysql_query("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_hangar` WHERE `username` = '$ousername' Limit 1;");  
	mysql_query("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_chat` WHERE `c_user` = '$ousername';");
	echo "<tr><td colspan=3><center>�ާ@�����A�Τ�$ousername �w�R��<br></center></td></tr>";
}

//��J����W

if ("2" == $_POST["operation"] ) {
	echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";
	echo "<tr><td colspan=3><center>�п�J�A�n�ާ@������W�]�d�Ŭ��C�X�Ҧ�����^<br></center></td></tr>";
	echo "<tr><td colspan=3><center><input type=text name='omsname' size='40' maxlength=50></center></td></tr>";
	echo "<input type=hidden value='21' name=operation>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
	echo "<tr><td colspan=3><center><input type=submit value='�T�w'></center></td></tr>";
	echo "</form></center></td></tr>";
}
//��ܾ���ާ@
if ("21" == $_POST["operation"] ) {
	$omsname = $_POST["omsname"];
	if(!$omsname) {
		$result1 = mysql_query("SELECT id,msname,price FROM `".$GLOBALS['DBPrefix']."phpeb_sys_ms`",$db);
		$num_rows = mysql_num_rows($result1);
		echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";
		echo "<table align=center width=400 border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
		echo "<tr align=center><td width=50>ID</td>";
		echo "<td width=150>����W</td>";
		echo "<td width=80>����</td>";
		echo "<td width=50>���</td>"; 
		$i = 1;
  		while($num_rows--) {
			$myrow1 = mysql_fetch_object($result1); 
			echo "<tr align=center><td width=50>$myrow1->id</td>";
			echo "<td width=150>$myrow1->msname</td>";
			echo "<td width=80>$myrow1->price</td>";
			echo "<td width=50><input type=radio name=omsname value = '$myrow1->msname'></td>";
			$i++;	
			}
		echo "<input type=hidden value='21' name=operation>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
		echo "<tr><td colspan=3><center><input type=submit value='�T�w'></center></td></tr>";
		echo "</tr>";
		echo "</form></center></td></tr>";
		echo "</table>";
		exit;
	}
	$result1 = mysql_query("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_sys_ms` WHERE `msname` = '$omsname'",$db);
	$myrow1 = mysql_fetch_object($result1);
	if (!$myrow1->id) {
		echo "<tr><td colspan=3><center>�d�L������<br></center></td></tr>";
		exit;
	}

	echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";	
	echo "<tr><td colspan=3><center>�ק���� $omsname ��ơG<br></center></td></tr>";


$omslist = array("�s��","����W","����","att","def","rct","taf","HP�W�q","EN�W�q","HP�^�_","EN�^�_","�S��","�ݭn����","�Ϥ��ؿ�","�S��");
$omsfield = array("$myrow1->id","$myrow1->msname","$myrow1->price","$myrow1->atf","$myrow1->def","$myrow1->ref","$myrow1->taf",
"$myrow1->hpfix","$myrow1->enfix","$myrow1->hprec","$myrow1->enrec","$myrow1->spec","$myrow1->needlv","$myrow1->image","�R������");
	echo "<table align=center width=400 border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr align=center><td width=100>���</td>";
	echo "<td width=200>�ƭ�</td>";
	echo "<td width=50>���</td>";

	$i = 0;
	while($i<=14) {
		echo "<tr align=center><td width=100>$omslist[$i]</td>";
		echo "<td width=200>$omsfield[$i]</td>";
		echo "<td width=50><input type=radio name=omsfield value = '$i'></td>";	
		$i++;
	}

	echo "<tr><td colspan=3><center><input type=text name='omsvalue' size='40' maxlength=50></center></td></tr>";

	echo "<input type=hidden value='$myrow1->id' name=omsid>";
	echo "<input type=hidden value='22' name=operation>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
	echo "<tr><td colspan=3><center><input type=submit value='�T�w'></center></td></tr>";
	echo "</form></center></td></tr>";
	echo "</table>";	
}

//�ק������
if ("22" == $_POST["operation"] ) {
	$omsid = $_POST["omsid"];
	$omsfield = $_POST["omsfield"];
	$omsvalue = $_POST["omsvalue"];
	switch ($omsfield) {
		case 1: $omsfield = "msname";break;
		case 2: $omsfield = "price";break;
		case 3: $omsfield = "atf";break;		
		case 4: $omsfield = "def";break;
		case 5: $omsfield = "ref";break;
		case 6: $omsfield = "taf";break;
		case 7: $omsfield = "hpfix";break;
		case 8: $omsfield = "enfix";break;
		case 9: $omsfield = "hprec";break;
		case 10: $omsfield = "enrec";break;
		case 11: $omsfield = "spec";break;		
		case 12: $omsfield = "needlv";break;
		case 13: $omsfield = "image";break;
		case 14: echo "<tr><td colspan=3><center>�R�����骺�ާ@�O���i�f���C�ЦA���T�{�I<br></center></td></tr>";	
			 echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";
			 echo "<input type=hidden value='23' name=operation>";
			 echo "<input type=hidden value='$omsid' name=omsid>";		
			 echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
			 echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
			 echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
			 echo "<tr><td colspan=3><center><input type=submit value='�T�w'></center></td></tr>";
			 echo "</form></center></td></tr>";
			 exit;		
	}
	$sqloms = "UPDATE `".$GLOBALS['DBPrefix']."phpeb_sys_ms` SET `$omsfield` = '$omsvalue' WHERE `id` = '$omsid' LIMIT 1;";
	mysql_query($sqloms);
	echo "<tr><td colspan=3><center>�ާ@����<br></center></td></tr>";
}

//�R������ާ@
if ("23" == $_POST["operation"] ) {
	$omsid = $_POST["omsid"];
	mysql_query("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_sys_ms` WHERE `id` = '$omsid' Limit 1;");
	echo "<tr><td colspan=3><center>�ާ@�����A���� $omsid �w�R��<br></center></td></tr>";
}


//��J�Z���W
if ("3" == $_POST["operation"] ) {
	echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";
	echo "<tr><td colspan=3><center>�п�J�Z���W�]�d�Ŭ��C�X�Ҧ��Z���^<br></center></td></tr>";
	echo "<tr><td colspan=3><center><input type=text name='owepname' size='40' maxlength=50></center></td></tr>";
	echo "<input type=hidden value='31' name=operation>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
	echo "<tr><td colspan=3><center><input type=submit value='�T�w'></center></td></tr>";
	echo "</form></center></td></tr>";
}

//��ܪZ�����
if ("31" == $_POST["operation"] ) {
	$owepname = $_POST["owepname"];
	if(!$owepname) {
		$result1 = mysql_query("SELECT id,name,price FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep`",$db);
		$num_rows = mysql_num_rows($result1);

		echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";
		echo "<table align=center width=500 border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
		echo "<tr align=center><td width=50>ID</td>";
		echo "<td width=250>�Z���C��</td>";
		echo "<td width=100>����</td>";
		echo "<td width=50>���</td>";
		$i = 1;
  		while($num_rows--) {
			$myrow1 = mysql_fetch_object($result1); 
			echo "<tr align=center><td width=50>$myrow1->id</td>";
			echo "<td width=200>$myrow1->name</td>";
			echo "<td width=100>$myrow1->price</td>";
			echo "<td width=50><input type=radio name=owepname value = '$myrow1->name'></td>";
			$i++;			
			}
		echo "<input type=hidden value='31' name=operation>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
		echo "<tr><td colspan=3><center><input type=submit value='�T�w'></center></td></tr>";
		echo "</tr>";
		echo "</form></center></td></tr>";
		echo "</table>";
		exit;
	}
	$result1 = mysql_query("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` WHERE `name` = '$owepname'",$db);
	$myrow1 = mysql_fetch_object($result1);
	if (!$myrow1->id) {
		echo "<tr><td colspan=3><center>�d�L���Z��<br></center></td></tr>";
		exit;
	}


	echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";	
	echo "<tr><td colspan=3><center>�ק�Z�� $owepname ��ơG<br></center></td></tr>";


$oweplist = array("�s��","�W�r","�@�N","�ʽ�BDI","���","��y�i��","�S���y","����","�R��","�^��","EN����","����","�i�����U","�S��","�S��");
$owepvalue = array("$myrow1->id","$myrow1->name","$myrow1->grade","$myrow1->kind","$myrow1->familyid","$myrow1->nextev","$myrow1->specev",
"$myrow1->atk","$myrow1->hit","$myrow1->rd","$myrow1->enc","$myrow1->price","$myrow1->equip","$myrow1->spec","�R��");
	echo "<table align=center width=400 border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr align=center><td width=100>���</td>";
	echo "<td width=200>�ƭ�</td>";
	echo "<td width=50>���</td>";

	$i = 0;
	while($i<=14) {
		echo "<tr align=center><td width=100>$oweplist[$i]</td>";
		echo "<td width=200>$owepvalue[$i]</td>";
		echo "<td width=50><input type=radio name=owepfield value = '$i'></td>";	
		$i++;
	}

	echo "<tr><td colspan=3><center><input type=text name='owepvalue' size='40' maxlength=50></center></td></tr>";

	echo "<input type=hidden value='$myrow1->id' name=owepid>";
	echo "<input type=hidden value='32' name=operation>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
	echo "<tr><td colspan=3><center><input type=submit value='�T�w'></center></td></tr>";
	echo "</form></center></td></tr>";
	echo "</table>";		
	wepspec();
}
                        
//�ק�Z�����
if ("32" == $_POST["operation"] ) {
	$owepid = $_POST["owepid"];
	$owepfield = $_POST["owepfield"];
	$owepvalue = $_POST["owepvalue"];
	switch ($owepfield) {
		case 1: $owepfield = "name";break;
		case 2: $owepfield = "grade";break;
		case 3: $owepfield = "kind";break;	
		case 4: $owepfield = "familyid";break;
		case 5: $owepfield = "nextev";break;
		case 6: $owepfield = "specev";break;	
		case 7: $owepfield = "atk";break;
		case 8: $owepfield = "hit";break;
		case 9: $owepfield = "rd";break;	
		case 10: $owepfield = "enc";break;
		case 11: $owepfield = "price";break;
		case 12: $owepfield = "equip";break;	
		case 13: $owepfield = "spec";break;
		case 14: echo "<tr><td colspan=3><center>�R���Z�����ާ@�O���i�f���C�ЦA���T�{�I<br></center></td></tr>";	
			 echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";
			 echo "<input type=hidden value='33' name=operation>";
			 echo "<input type=hidden value='$owepid' name=owepid>";		
			 echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
			 echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
			 echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
			 echo "<tr><td colspan=3><center><input type=submit value='�T�w'></center></td></tr>";
			 echo "</form></center></td></tr>";
			 exit;		
	}
	$sqlowep = "UPDATE `".$GLOBALS['DBPrefix']."phpeb_sys_wep` SET `$owepfield` = '$owepvalue' WHERE `id` = '$owepid' LIMIT 1;";
//	echo "$sqlowep";
	mysql_query($sqlowep);
	echo "<tr><td colspan=3><center>�ާ@����<br></center></td></tr>";	

}

//�R���Z���ާ@
if ("33" == $_POST["operation"] ) {
	$owepid = $_POST["owepid"];
	mysql_query("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` WHERE `id` = '$owepid' Limit 1;");
	echo "<tr><td colspan=3><center>�ާ@�����A�Z�� $owepid �w�R��<br></center></td></tr>";
}

//��ܦX���C��
if ("4" == $_POST["operation"] ) {
	echo "<tr><td colspan=3><center>�п�J�A�n�ާ@���Z���]�d�Ŭ��C�X�Ҧ��X�������^<br></center></td></tr>";
	echo "<tr><td colspan=3><form action=manager.php?action=main method=post target=_self>";
	echo "<tr><td colspan=3><center><input type=text name='otatname' size='40' maxlength=50></center></td></tr>";
	echo "<input type=hidden value='41' name=operation>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
	echo "<tr><td colspan=3><center><input type=submit value='�T�w'></center></td></tr>";
	echo "</form></td></tr>";
}

//��ܦX�����
if ("41" == $_POST["operation"] ) {
	$otatname = $_POST["otatname"];
	if(!$otatname) {
		$result1 = mysql_query("SELECT tact_id,wep_id,grade FROM `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory`",$db);
		$num_rows = mysql_num_rows($result1);
		echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";
		echo "<table align=center width=250 border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
		echo "<tr align=center><td width=50>�s��</td>";
		echo "<td width=100>�Z��ID</td>";
		echo "<td width=50>�ŧO</td>";
		echo "<td width=50>���</td>";
		$i = 1;
  		while($num_rows--) {
			$myrow1 = mysql_fetch_object($result1); 
			echo "<tr align=center><td width=50>$myrow1->tact_id</td>";
			echo "<td width=100>$myrow1->wep_id</td>";
			echo "<td width=20>$myrow1->grade</td>";
			echo "<td width=50><input type=radio name=otatname value = '$myrow1->wep_id'></td>";
			$i++;			
			}
		echo "<input type=hidden value='41' name=operation>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
		echo "<tr><td colspan=3><center><input type=submit value='�T�w'></center></td></tr>";
		echo "</tr>";
		echo "</form></center></td></tr>";
		echo "</table>";
		exit;
	}
	$result1 = mysql_query("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` WHERE `wep_id` = '$otatname'",$db);
	$myrow1 = mysql_fetch_object($result1);
	if (!$myrow1->tact_id) {
		echo "<tr><td colspan=3><center>�d�L���Z��<br></center></td></tr>";
		exit;
	}

	echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";	
	echo "<tr><td colspan=3><center>�ק�Z�� $owepname ��ơG<br></center></td></tr>";


$otatlist = array("�s��","�Z���s��","����","���","1���l","2���l","3���l","4���l","5���l","6���l","7���l","8���l","9���l","10���l",
"11���l","12���l","13���l","14���l","15���l","16���l","17���l","18���l","19���l","20���l","�S��");
$otatvalue = array("$myrow1->tact_id","$myrow1->wep_id","$myrow1->grade","$myrow1->directions",
"$myrow1->m1","$myrow1->m2","$myrow1->m3","$myrow1->m4","$myrow1->m5","$myrow1->m6","$myrow1->m7","$myrow1->m8","$myrow1->m9","$myrow1->m10",
"$myrow1->m11","$myrow1->m12","$myrow1->m13","$myrow1->m14","$myrow1->m15","$myrow1->m16","$myrow1->m17","$myrow1->m18","$myrow1->m19","$myrow1->m20","�R������");
	echo "<table align=center width=400 border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr align=center><td width=100>���</td>";
	echo "<td width=200>�ƭ�</td>";
	echo "<td width=50>���</td>";

	$i = 0;
	while($i<=24) {
		echo "<tr align=center><td width=100>$otatlist[$i]</td>";
		echo "<td width=200>$otatvalue[$i]</td>";
		echo "<td width=50><input type=radio name=otatfield value = '$i'></td>";	
		$i++;
	}

	echo "<tr><td colspan=3><center><input type=text name='otatvalue' size='40' maxlength=50></center></td></tr>";

	echo "<input type=hidden value='$myrow1->tact_id' name=otatid>";
	echo "<input type=hidden value='42' name=operation>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
	echo "<tr><td colspan=3><center><input type=submit value='�T�w'></center></td></tr>";
	echo "</form></center></td></tr>";
	echo "</table>";	
	
	
}

//�ק�X�����
if ("42" == $_POST["operation"] ) {
	$otatid = $_POST["otatid"];
	$otatfield = $_POST["otatfield"];
	$otatvalue = $_POST["otatvalue"];
	switch ($otatfield) {
		case 1: $otatfield = "wep_id";break;
		case 2: $otatfield = "grade";break;
		case 3: $otatfield = "directions";break;	
		case 4: $otatfield = "m1";break;
		case 5: $otatfield = "m2";break;
		case 6: $otatfield = "m3";break;	
		case 7: $otatfield = "m4";break;
		case 8: $otatfield = "m5";break;	
		case 9: $otatfield = "m6";break;
		case 10: $otatfield = "m7";break;	
		case 11: $otatfield = "m8";break;
		case 12: $otatfield = "m9";break;
		case 13: $otatfield = "m10";break;
		case 14: $otatfield = "m11";break;
		case 15: $otatfield = "m12";break;
		case 16: $otatfield = "m13";break;	
		case 17: $otatfield = "m14";break;
		case 18: $otatfield = "m15";break;	
		case 19: $otatfield = "m16";break;
		case 20: $otatfield = "m17";break;	
		case 21: $otatfield = "m18";break;
		case 22: $otatfield = "m19";break;
		case 23: $otatfield = "m20";break;
		case 24: echo "<tr><td colspan=3><center>�R���������ާ@�O���i�f���C�ЦA���T�{�I<br></center></td></tr>";	
			 echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";
			 echo "<input type=hidden value='43' name=operation>";
			 echo "<input type=hidden value='$otatid' name=otatid>";		
			 echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
			 echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
			 echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
			 echo "<tr><td colspan=3><center><input type=submit value='�T�w'></center></td></tr>";
			 echo "</form></center></td></tr>";
			 exit;		
	}
	$sqlowep = "UPDATE `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` SET `$otatfield` = '$otatvalue' WHERE `tact_id` = '$otatid' LIMIT 1;";
	echo "$sqlowep";
	mysql_query($sqlowep);
	echo "<tr><td colspan=3><center>�ާ@����<br></center></td></tr>";	

}

//�R���X���C��ާ@
if ("43" == $_POST["operation"] ) {
	$otatid = $_POST["otatid"];
	mysql_query("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` WHERE `tact_id` = '$otatid' Limit 1;");
	echo "<tr><td colspan=3><center>�ާ@�����A�s�� $otatid �w�R��<br></center></td></tr>";
}


//��q�R���Τ�
if ("5" == $_POST["operation"] ) {
	$deletelv = $_POST["deletelv"];
	$deletetime = $_POST["deletetime"];
	$predel = $_POST["predel"];
	$deadline = time() - 86400*$deletetime;
	if(!$deletelv &&!$deletetime && !$predel) {
		echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";
		echo "<tr><td colspan=3><center>�R������C���@�A�P�ɿ諸�N�ӯŧO�Ӻ�<br></center></td></tr>";
		echo "<tr><td colspan=3><center><input type=text name='deletelv' size='20' maxlength=50>�ŧO</center></td></tr>";
		echo "<tr><td colspan=3><center><input type=text name='deletetime' value = 10 size='20' maxlength=50>�Ѽ�</center></td></tr>";
		echo "<input type=hidden value='5' name=operation>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
		echo "<tr><td colspan=3><center><input type=submit value='�T�w'></center></td></tr>";
		echo "</form></center></td></tr>";
		exit;	
	}	
        if($deletelv) {
		$result1=mysql_query("SELECT `username` , `gamename` , `level` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `level` <= $deletelv ");
	}
	else {
		$result1=mysql_query("SELECT `username` FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` WHERE `time2` < $deadline ");
	
	}
	$num_rows = mysql_num_rows($result1);
	if (!$num_rows){
		if($deletelv){
			echo "<tr><td colspan=3><center>��e�S��$deletelv �ťH�U�H��<br></center></td></tr>";
		}
		else 	{	
				echo "<tr><td colspan=3><center>��e�S��$deletetime �ѡ] $deadline ��^�H�W���W�u���H��<br></center></td></tr>";
			}
		exit;	
	} 
	echo "<table align=center width=250 border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr align=center><td width=50>�Ǹ�</td>";
	echo "<td width=100>ID</td>";
	echo "<td width=150>�W�r</td>";
	echo "<td width=50>lv</td>";
	$i = 1;
	while($num_rows--){
		$myrow1 = mysql_fetch_object($result1);
		if (1 == $predel) {
			mysql_query ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` WHERE `username` = '$myrow1->username' Limit 1;");
			mysql_query ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `username` = '$myrow1->username' Limit 1;");
			mysql_query ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_bank` WHERE `username` = '$myrow1->username' Limit 1;");
			mysql_query ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_log` WHERE `username` = '$myrow1->username' Limit 1;");
			mysql_query ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_tactfactory` WHERE `username` = '$myrow1->username' Limit 1;");
			mysql_query ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_settings` WHERE `username` = '$myrow1->username' Limit 1;");
			mysql_query ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_warehouse` WHERE `username` = '$myrow1->username' Limit 1;");
			mysql_query ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_hangar` WHERE `username` = '$myrow1->username' Limit 1;");
			mysql_query ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_chat` WHERE `c_user` = '$myrow1->username';");
		}
		echo "<tr align=center><td width=50>$i</td>";
		echo "<td width=100>$myrow1->username</td>";
		echo "<td width=150>$myrow1->gamename</td>";
		echo "<td width=50>$myrow1->level</td>";		
                $i++;
	}
	echo "</tr>";
	echo "</table>";
	if (1 == $predel) {
		echo "<tr><td colspan=3><center>�R������<br></center></td></tr>";	
	}
	
	if (!$predel) {
		echo "<tr><td colspan=3><center>�T�w�H�W�H���R���H<br></center></td></tr>";	
		echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";
		echo "<input type=hidden value='5' name=operation>";
		echo "<input type=hidden value='1' name=predel>";		
		echo "<input type=hidden value='$deletelv' name=deletelv>";
		echo "<input type=hidden value='$deletetime' name=deletetime>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
		echo "<tr><td colspan=3><center><input type=submit value='�T�w'></center></td></tr>";
		echo "</form></center></td></tr>";
		exit;	
	}
}

//��q�W�[����
if ("6" == $_POST["operation"] ) {
	echo "<tr><td colspan=3><center>����榡������W�[�@�ӼƦ�A���骺�Ϥ��s���]�O�p��<br></center></td></tr>";
	echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";
	
	echo "<table align=center width=250 border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr align=center><td width=100>����W</td>";
	echo "<td width=150><input type=text name='newmsname' value = �s���� size='20' maxlength=20></td>";		
	echo "<tr align=center><td width=100>����ƶq</td>";
	echo "<td width=150><input type=text name='newmsq' value = 10 size='20' maxlength=3></td>";		
	echo "<tr align=center><td width=100>��l�Ʀr</td>";
	echo "<td width=150><input type=text name='newmsnum' value = 1000 size='20' maxlength=5></td>";	
	echo "<tr align=center><td width=100>����</td>";
	echo "<td width=150><input type=text name='newmsprice' value = 10000 size='20' maxlength=10></td>";		
	echo "<tr align=center><td width=100>atk</td>";
	echo "<td width=150><input type=text name='newmsatk' value = 10 size='20' maxlength=3></td>";	
	echo "<tr align=center><td width=100>def</td>";
	echo "<td width=150><input type=text name='newmsdef' value = 10 size='20' maxlength=3></td>";		
	echo "<tr align=center><td width=100>ref</td>";
	echo "<td width=150><input type=text name='newmsref' value = 10 size='20' maxlength=3></td>";	
	echo "<tr align=center><td width=100>taf</td>";
	echo "<td width=150><input type=text name='newmstaf' value = 10 size='20' maxlength=3></td>";		
	echo "<tr align=center><td width=100>hpfix</td>";
	echo "<td width=150><input type=text name='newmshpfix' value = 10 size='20' maxlength=6></td>";	
	echo "<tr align=center><td width=100>enfix</td>";
	echo "<td width=150><input type=text name='newmsenfix' value = 10 size='20' maxlength=6></td>";		
	echo "<tr align=center><td width=100>hprec</td>";
	echo "<td width=150><input type=text name='newmshprec' value = 10 size='20' maxlength=6></td>";	
	echo "<tr align=center><td width=100>enrec</td>";
	echo "<td width=150><input type=text name='newmsenrec' value = 5 size='20' maxlength=6></td>";		
	echo "<tr align=center><td width=100>spec</td>";
	echo "<td width=150><input type=text name='newmsspec' size='20' maxlength=20></td>";	
	echo "<tr align=center><td width=100>�ݭn����</td>";
	echo "<td width=150><input type=text name='newmslevel' value = 10 size='20' maxlength=2></td>";		
	echo "<tr align=center><td width=100>�Ϥ��ؿ�</td>";
	echo "<td width=150><input type=text name='newmspicdir' value = 0/ size='20' maxlength=20></td>";	
	echo "<tr align=center><td width=100>�Ϥ��榡</td>";
	echo "<td width=150><input type=text name='newmspicformat' value = .jpg size='20' maxlength=5></td>";
	echo "<input type=hidden value='61' name=operation>";	
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
	echo "<tr><td colspan=3><center><input type=submit value='�T�w'></center></td></tr>";
	echo "</form></center></td></tr>";
}


if ("61" == $_POST["operation"]) {
	$newmsname = $_POST["newmsname"];
	$newmsq = $_POST["newmsq"];
	$newmsnum = $_POST["newmsnum"];
	$newmsprice = $_POST["newmsprice"];
	$newmsatk = $_POST["newmsatk"];
	$newmsdef = $_POST["newmsdef"];
	$newmsref = $_POST["newmsref"];
	$newmstaf = $_POST["newmstaf"];
	$newmshpfix = $_POST["newmshpfix"];
	$newmsenfix = $_POST["newmsenfix"];
	$newmshprec = $_POST["newmshprec"];
	$newmsenrec = $_POST["newmsenrec"];
	$newmsspec = $_POST["newmsspec"];
	$newmslevel = $_POST["newmslevel"];
	$newmspicdir = $_POST["newmspicdir"];
	$newmsnewmspicformat = $_POST["newmspicformat"];
	if (!$newmsname || !$newmsq || !$newmsnum || !$newmsprice || !$newmsatk || !$newmsdef || !$newmsref || !$newmstaf || !$newmshpfix || !$newmsenfix || !$newmshprec || !$newmsenrec || !$newmspicdir || !$newmsnewmspicformat) {
		echo "<tr><td colspan=3><center>�ﶵ���ҿ�|<br></center></td></tr>";	
		exit;
	}
	if (!$newmslevel) { $newmslevel = 0; }
	$i = 0;
	while ( $i < $newmsq ) {
		$imsnum = $newmsnum + $i;
		$iname = "$newmsname"."$imsnum";
		$ipic = "$newmspicdir"."$imsnum"."$newmsnewmspicformat";
		mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` (`id` ,`msname` ,`price` ,`atf` ,`def` ,`ref` ,`taf` ,`hpfix` ,`enfix` ,`hprec` ,`enrec` ,`spec` ,`needlv` ,`image`) VALUES ('$imsnum', '$iname', '$newmsprice', '$newmsatk', '$newmsdef', '$newmsref', '$newmstaf', '$newmshpfix', '$newmsenfix', '$newmshprec', '$newmsenrec', '$newmsspec', '$newmslevel', '$ipic');");
		$i++;
        }
	echo "<tr><td colspan=3><center>$newmsq ��$newmsname ����W�[����<br></center></td></tr>";
}

//��q�W�[NPC
if ("7" == $_POST["operation"] ) {
	echo "<tr><td colspan=3><center>NPC���榡��NPC�[�@�ӼƦr<br></center></td></tr>";
	echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";	
	echo "<table align=center width=250 border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr align=center><td width=100>NPC�W�r</td>";
	echo "<td width=150><input type=text name='nname' value = NPC size='20' maxlength=15></td>";
	echo "<tr align=center><td width=100>�K�X</td>";
	echo "<td width=150><input type=text name='npassword' size='20' maxlength=15></td>";
	echo "<tr align=center><td width=100>�_�l�Ʀr</td>";
	echo "<td width=150><input type=text name='nstart' value = 100 size='20' maxlength=10></td>";		
	echo "<tr align=center><td width=100>NPC�ƶq</td>";
	echo "<td width=150><input type=text name='nq' value = 10 size='20' maxlength=3></td>";		
	echo "<tr align=center><td width=100>����</td>";	
	echo "<td width=150><input type=text name='nlevel' value = 10 size='20' maxlength=2></td>";
	echo "<tr align=center><td width=100>�ر�</td>";	
	echo "<td width=150><input type=text name='ntype' value = psy4 size='20' maxlength=5></td>";
	echo "<tr align=center><td width=100>����</td>";
	echo "<td width=150><input type=text name='nms' value = 101 size='20' maxlength=5></td>";
	echo "<tr align=center><td width=100>�Z��</td>";
	echo "<td width=150><input type=text name='nwep' value = 701 size='20' maxlength=5></td>";
	echo "<tr align=center><td width=100>atk</td>";
	echo "<td width=150><input type=text name='natk' value = 20 size='20' maxlength=3></td>";	
	echo "<tr align=center><td width=100>def</td>";
	echo "<td width=150><input type=text name='ndef' value = 20 size='20' maxlength=3></td>";		
	echo "<tr align=center><td width=100>ref</td>";
	echo "<td width=150><input type=text name='nref' value = 20 size='20' maxlength=3></td>";	
	echo "<tr align=center><td width=100>taf</td>";
	echo "<td width=150><input type=text name='ntaf' value = 20 size='20' maxlength=3></td>";		
	echo "<tr align=center><td width=100>hp</td>";
	echo "<td width=150><input type=text name='nhp' value = 1000 size='20' maxlength=8></td>";	
	echo "<tr align=center><td width=100>en</td>";
	echo "<td width=150><input type=text name='nen' value = 10000 size='20' maxlength=8></td>";		
	echo "<tr align=center><td width=100>sp</td>";
	echo "<td width=150><input type=text name='nsp' value = 50 size='20' maxlength=6></td>";		
	echo "<tr align=center><td width=100>�߫�</td>";
	echo "<td width=150><input type=text name='nfame' value = -50 size='20' maxlength=5></td>";		
	echo "<tr align=center><td width=100>�a��</td>";
	echo "<td width=150><input type=text name='nbounty' value = 100000 size='20' maxlength=10></td>";	
	echo "<tr align=center><td width=100>�a��</td>";
	echo "<td width=150><input type=text name='narea' value = A1 size='20' maxlength=5></td>";
	echo "<input type=hidden value='71' name=operation>";	
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
	echo "<tr><td colspan=3><center><input type=submit value='�T�w'></center></td></tr>";
	echo "</form></center></td></tr>";
}

if ("71" == $_POST["operation"]) {
	$nname = $_POST["nname"];
	$npassword = $_POST["npassword"];
	$nstart = $_POST["nstart"];
	$nq = $_POST["nq"];
	$nlevel = $_POST["nlevel"];
	$ntype = $_POST["ntype"];
	$nms = $_POST["nms"];
	$nwep = $_POST["nwep"];
	$natk = $_POST["natk"];
	$ndef = $_POST["ndef"];
	$nref = $_POST["nref"];
	$ntaf = $_POST["ntaf"];
	$nhp = $_POST["nhp"];
	$nen = $_POST["nen"];
	$nsp = $_POST["nsp"];
	$nfame = $_POST["nfame"];
	$nbounty = $_POST["nbounty"];
	$narea = $_POST["narea"];
	
	if (!$npassword || !$nstart || !$nq || !$nlevel || !$ntype || !$nms || !$nwep || !$natk || !$ndef || !$nref || !$ntaf || !$nhp || !$nen || !$nsp || !$nfame || !$nbounty || !$narea) {
		echo "<tr><td colspan=3><center>�ﶵ���ҿ�|<br></center></td></tr>";	
		exit;
	}
	$npassword = md5($npassword);
	$i = 0;
	while ( $i < $nq ) {
		$npcnum = $nstart + $i;
		$npcname = "$nname"."$npcnum";
		
		$sql = ("INSERT INTO ".$GLOBALS['DBPrefix']."phpeb_user_general_info (username, password,color,msuit,typech,growth,time1,time2,btltime,coordinates,fame) VALUES('$npcname','$npassword','#FF5050','$nms','$ntype','0','$t_now' ,'$t_now' ,'','$narea','$nfame')");
		mysql_query($sql) or die ('<br><center>���৹�����U (Location ID: Register01)<br>��]:' . mysql_error() . '<br>');

		$sql = ("INSERT INTO ".$GLOBALS['DBPrefix']."phpeb_user_game_info (username, gamename,attacking,defending,reacting,targeting,hpmax,enmax,spmax,level,wepa) VALUES('$npcname','$npcname','$natk','$ndef','$nref','$ntaf','$nhp','$nen','$nsp','$nlevel','$nwep')");
		mysql_query($sql) or die ('<br><center>���৹�����U (Location ID: Register02)<br>��]:' . mysql_error() . '<br>');

		$sql = ("INSERT INTO ".$GLOBALS['DBPrefix']."phpeb_user_settings (username) VALUES('$npcname')");
		mysql_query($sql) or die ('<br><center>���৹�����U (Location ID: Register05)<br>��]:' . mysql_error() . '<br>');

		$sql = ("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_user_bank` (username) VALUES('$npcname')");
		mysql_query($sql) or die ('<br><center>���৹�����U (Location ID: Register04)<br>��]:' . mysql_error() . '<br>');

		$i++;
        }
	echo "<tr><td colspan=3><center>$nq ��NPC�W�[����<br></center></td></tr>";
}

//������Ʈw�ާ@
if ("8" == $_POST["operation"] ) {
	echo "<tr><td colspan=3><center>�п�JSQL�y�y<br></center></td></tr>";	
	echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";
	echo "<tr><td colspan=3><center><input type=text name='sql' size='100' maxlength=400><br></center></td></tr>";
	echo "<input type=hidden value='81' name=operation>";	
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
	echo "<tr><td colspan=3><center><input type=submit value='�T�w'></center></td></tr>";
	echo "</form></center></td></tr>";
}

if ("81" == $_POST["operation"] ) {
	$sql = $_POST["sql"];
	mysql_query("$sql");
	echo "<tr><td colspan=3><center>$sql<br></center></td></tr>";		
	echo "<tr><td colspan=3><center>���޻y�y���T�P�_�A���w�g�Q����F<br></center></td></tr>";	
}

//�W�[�Z��
if ("9" == $_POST["operation"] ) {
	echo "<tr><td colspan=3><center>�Z��ID���i����<br></center></td></tr>";
	echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";	
	echo "<table align=center width=250 border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr align=center><td width=100>�Z��ID</td>";
	echo "<td width=150><input type=text name='owid' value = 10000 size='20' maxlength=10></td>";
	echo "<tr align=center><td width=100>�Z���W</td>";
	echo "<td width=150><input type=text name='owname' value = �s�Z�� size='20' maxlength=20></td>";
	echo "<tr align=center><td width=100>grade</td>";
	echo "<td width=150><input type=text name='owgrade' value = 1 size='20' maxlength=2></td>";		
	echo "<tr align=center><td width=100>kind(BDI)</td>";
	echo "<td width=150><input type=text name='owkind' value = I size='20' maxlength=4></td>";		
	echo "<tr align=center><td width=100>familyid</td>";	
	echo "<td width=150><input type=text name='owfamilyid' value = 0 size='20' maxlength=6></td>";
	echo "<tr align=center><td width=100>nextev</td>";	
	echo "<td width=150><input type=text name='ownextev' size='20' maxlength=6></td>";
	echo "<tr align=center><td width=100>specev</td>";
	echo "<td width=150><input type=text name='owspecev' size='20' maxlength=6></td>";
	echo "<tr align=center><td width=100>����</td>";
	echo "<td width=150><input type=text name='owatk' value = 100 size='20' maxlength=10></td>";
	echo "<tr align=center><td width=100>�R��</td>";
	echo "<td width=150><input type=text name='owhit' value = 50 size='20' maxlength=5></td>";	
	echo "<tr align=center><td width=100>�^��</td>";
	echo "<td width=150><input type=text name='owrd' value = 10 size='20' maxlength=3></td>";		
	echo "<tr align=center><td width=100>����EN</td>";
	echo "<td width=150><input type=text name='owenc' value = 50 size='20' maxlength=10></td>";	
	echo "<tr align=center><td width=100>����</td>";
	echo "<td width=150><input type=text name='owprice' value = 50000 size='20' maxlength=10></td>";		
	echo "<tr align=center><td width=100>�O�_�i�˳�</td>";
	echo "<td width=150><input type=text name='owequip' value = 0 size='20' maxlength=3></td>";	
	echo "<tr align=center><td width=100>�S��</td>";
	echo "<td width=150><input type=text name='owspec' size='20' maxlength=20></td>";		

	echo "<input type=hidden value='91' name=operation>";	
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
	echo "<tr><td colspan=3><center><input type=submit value='�T�w'></center></td></tr>";
	echo "</form></center></td></tr>";
	wepspec();
}

if ("91" == $_POST["operation"]) {
	$id = $_POST["owid"];
	$name = $_POST["owname"];
	$grade = $_POST["owgrade"];
	$kind = $_POST["owkind"];		
	$familyid = $_POST["owfamilyid"];
	$nextev = $_POST["ownextev"];	
	$specev = $_POST["owspecev"];
	$atk = $_POST["owatk"];
	$hit = $_POST["owhit"];	
	$rd = $_POST["owrd"];		
	$enc = $_POST["owenc"];
	$price = $_POST["owprice"];
	$equip = $_POST["owequip"];
	$spec = $_POST["owspec"];	
	if ( !$id || !$name || !$atk || !$hit || !$rd || !$enc ) {
		echo "<tr><td colspan=3><center>�ﶵ���ҿ�|<br></center></td></tr>";	
		exit;
	}
	if ( !$price) { $price = 0; }
	if ( !$equip) { $equip = 0; }
	mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` (`id` ,`name` ,`grade` ,`kind` ,`familyid` ,`nextev` ,`specev` ,`atk` ,`hit` ,`rd` ,`enc` ,`price` ,`equip` ,`spec` ) VALUES ('$id', '$name', '$grade', '$kind', '$familyid', '$nextev', '$specev', '$atk', '$hit', '$rd', '$enc', '$price', '$equip', '$spec');");
	echo "<tr><td colspan=3><center>�Z�� $name �W�[����<br></center></td></tr>";                        
}
//�W�[����
if ("A" == $_POST["operation"] ) {
	echo "<tr><td colspan=3><center>�ݵۿ�a<br></center></td></tr>";
	echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";	
	echo "<table align=center width=250 border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";

	$result1 = mysql_query("SELECT tact_id,wep_id,grade FROM `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory`",$db);
	$num_rows = mysql_num_rows($result1);

	echo "<tr align=center><td width=100>����ID</td>";
	echo "<td width=150>$num_rows</td>";
	echo "<tr align=center><td width=100>�Z��ID</td>";
	echo "<td width=150><input type=text name='otwep' value = 101 size='20' maxlength=10></td>";
	echo "<tr align=center><td width=100>��������</td>";
	echo "<td width=150><input type=text name='otgrade' value = 5 size='20' maxlength=2></td>";
	echo "<tr align=center><td width=100>�Z������</td>";
	echo "<td width=150><input type=text name='otintro' size='20' maxlength=200></td>";		
	for($i = 0;$i<20;$i++){
		echo "<tr align=center><td width=100>�� $i ���l</td>";
		echo "<td width=150><input type=text name='ot$i' size='20' maxlength=10></td>";		
	}

	echo "<input type=hidden value='A1' name=operation>";
	echo "<input type=hidden value='$num_rows' name=otid>";		
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
	echo "<tr><td colspan=3><center><input type=submit value='�T�w'></center></td></tr>";
	echo "</form></center></td></tr>";
}

if ("A1" == $_POST["operation"]) {
	$otid = $_POST["otid"];
	$otwep = $_POST["otwep"];
	$otgrade = $_POST["otgrade"];
	$otintro = $_POST["otintro"];
	for($i = 0;$i<20;$i++){ $ot[$i] = $_POST["ot$i"]; }
	if ( !$otwep || !$ot0 ) {
		echo "<tr><td colspan=3><center>�ﶵ���ҿ�|<br></center></td></tr>";	
		exit;
	}
	
	mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` (`tact_id` ,`wep_id` ,`grade` ,`directions` ,`m1` ,`m2` ,`m3` ,`m4` ,`m5` ,`m6` ,`m7` ,`m8` ,`m9` ,`m10` ,`m11` ,`m12` ,`m13` ,`m14` ,`m15` ,`m16` ,`m17` ,`m18` ,`m19` ,`m20` ) VALUES ('$otid', '$otwep', '$otgrade', '$otintro', '$ot0', '$ot1', '$ot2', '$ot3', '$ot4', '$ot5', '$ot6', '$ot7', '$ot8', '$ot9', '$ot10', '$ot11', '$ot12', '$ot13', '$ot14', '$ot15', '$ot16', '$ot17', '$ot18', '$ot19');");
	echo "<tr><td colspan=3><center>�Z�� $name �W�[��X������<br></center></td></tr>";                        
}


echo "</table>";

function wepspec() {
	echo "<tr><td colspan=3><center>�Z���S�Ĥ@����<br></center></td></tr>";
$ospeclist = array("DamA","����l�a","DamB","�԰�����","MobA","�[�t","MobB","�W�e","MobC","�{��","MobD","�k��","Moba","²����i","Mobb","�j�O���i",
"Mobc","�̨ΤƱ��i","Mobd","���ű��i","Mobe","���ű��i","TarA","�շ�","TarB","�˷�","TarC","����","TarD","�w��","Tara","�۰���w",
"Tarb","���Ůշ�","Tarc","�L�~�շ�","Tard","�h����w","Tare","������w","DefA","²�樾�m","DefB","���`���m","DefC","�j�ƨ��m",
"DefD","���Ũ��m","DefE","�̲ר��m","Defa","���","Defb","�ܿ�","Defc","�z�A","Defd","���","Defe","�Ŷ��۹�첾","PerfDef","�������m",
"AntiDam","�۰ʭ״_","DoubleExp","�g������","DoubleMon","��������","DefX","���O","AtkA","����","MeltA","����","MeltB","����",
"Cease","�T�D","AntiPDef","�e��","AntiMobS","�����z�Z","AntiTarS","�p�F�z�Z","MirrorDam","��","NTCustom","���F�M��",
"NTRequired","�ݭn���F�O�q","COCustom","��ڱM��","PsyRequired","�]�k�v�M��","SeedMode","SEED Mode","EXAMSystem","EXAM�t�αҰʥi��",
"CostSP","����SP","HPPcRecA","HP�^�_","ENPcRecA","EN�^�_(�p)","ENPcRecB","EN�^�_(�j)","ExtHP","HP���[","ExtEN","EN���[",
"FortressOnly","�n��M��","RawMaterials","���","CannotEquip","�L�k�˳�","DoubleStrike","�G�s��","TripleStrike","�T�s��",
"AllWepStirke","���u�o�g","CounterStrike","����","FirstStrike","�������");
	echo "<table align=center width=500 border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr align=center><td width=100>�N�X</td>";
	echo "<td width=150>�S��</td>";
	echo "<td width=100>�N�X</td>";
	echo "<td width=150>�S��</td>";
	$i = 0;
	while($i<=130) {
		echo "<tr align=center><td width=100>$ospeclist[$i]</td>";
		$i++;
		echo "<td width=150>$ospeclist[$i]</td>";	
		$i++;
		echo "<td width=100>$ospeclist[$i]</td>";		
		$i++;
		echo "<td width=150>$ospeclist[$i]</td>";
		$i++;
	}
	echo "</table>";
}
?>


      

