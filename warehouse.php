<?php
$mode = ( isset($_GET['action']) ) ? $_GET['action'] : $_POST['action'];
include('cfu.php');
if (empty($PriTarget)) $PriTarget = 'Alpha';
if (empty($SecTarget)) $SecTarget = 'Beta';
postHead('');
AuthUser("$Pl_Value[USERNAME]","$Pl_Value[PASSWORD]");
if ($CFU_Time >= $TIMEAUTH+$TIME_OUT_TIME || $TIMEAUTH <= $CFU_Time-$TIME_OUT_TIME){echo "�s�u�O�ɡI<br>�Э��s�n�J�I";exit;}
GetUsrDetails("$Pl_Value[USERNAME]",'Gen','Game');
$t_now = time();
if ($Gen['btltime'] == $t_now){echo "�ʧ@�L�֡C";postFooter();mysql_query("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `btltime` = ".intval($t_now+10)." WHERE `username` = '$Gen[username]' LIMIT 1;");exit;}

$UsrWepA = explode('<!>',$Game['wepa']);
$UsrWepB = explode('<!>',$Game['wepb']);
$UsrWepC = explode('<!>',$Game['wepc']);
GetWeaponDetails("$UsrWepA[0]",'UsWep_A');
$UsrWepA[2]= (isset($UsrWepA[2])) ? $UsrWepA[2] : 0;
if ($UsrWepA[2]){
if ($UsrWepA[2]==1) $UsWep_A['name'] = $UsrWepA[3].$UsWep_A['name']."<sub>&copy;</sub>";
else $UsWep_A['name'] = $UsWep_A['name'].$UsrWepA[3]."<sub>&copy;</sub>";
$UsWep_A['atk'] += $UsrWepA[4];
$UsWep_A['hit'] += $UsrWepA[5];
$UsWep_A['rd'] += $UsrWepA[6];
$UsWep_A['enc'] = $UsrWepA[7];
}
$UsWepSpec_A = ReturnSpecs("$UsWep_A[spec]");
GetWeaponDetails("$UsrWepB[0]",'UsWep_B');
$UsrWepB[2]= (isset($UsrWepB[2])) ? $UsrWepB[2] : 0;
if ($UsrWepB[2]){
if ($UsrWepB[2]==1) $UsWep_B['name'] = $UsrWepB[3].$UsWep_B['name']."<sub>&copy;</sub>";
else $UsWep_B['name'] = $UsWep_B['name'].$UsrWepB[3]."<sub>&copy;</sub>";
$UsWep_B['atk'] += $UsrWepB[4];
$UsWep_B['hit'] += $UsrWepB[5];
$UsWep_B['rd'] += $UsrWepB[6];
$UsWep_B['enc'] = $UsrWepB[7];
}
$UsWepSpec_B = ReturnSpecs("$UsWep_B[spec]");
GetWeaponDetails("$UsrWepC[0]",'UsWep_C');
$UsrWepC[2]= (isset($UsrWepC[2])) ? $UsrWepC[2] : 0;
if ($UsrWepC[2]){
if ($UsrWepC[2]==1) $UsWep_C['name'] = $UsrWepC[3].$UsWep_C['name']."<sub>&copy;</sub>";
else $UsWep_C['name'] = $UsWep_C['name'].$UsrWepC[3]."<sub>&copy;</sub>";
$UsWep_C['atk'] += $UsrWepC[4];
$UsWep_C['hit'] += $UsrWepC[5];
$UsWep_C['rd'] += $UsrWepC[6];
$UsWep_C['enc'] = $UsrWepC[7];
}
$UsWepSpec_C = ReturnSpecs("$UsWep_C[spec]");
//Set DataTable
$sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_warehouse` WHERE username='". $Pl_Value['USERNAME'] ."'");
$query_whr = mysql_query($sql);$defineuserc = 0;
$defineuserc = mysql_num_rows($query_whr);
if ($defineuserc == 0){
	$sqldfwh = ("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_user_warehouse` (username) VALUES('$Pl_Value[USERNAME]')");
	mysql_query($sqldfwh) or die ('<br><center>����إ߭ܮw���<br>��]:' . mysql_error() . '<br>');
	$sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_warehouse` WHERE username='". $Pl_Value['USERNAME'] ."'");
	$query_whr = mysql_query($sql) or die ('<br><center>������o�ܮw���<br>��]:' . mysql_error() . '<br>');
}elseif ($defineuserc > 1){echo "�Τ�W�٥X�{���D�A���p���޲z���C";exit;}
$Warehouse = mysql_fetch_row($query_whr);
$WarehseWeps = explode("\n",$Warehouse[1]);
$Countnumwhwp = count($WarehseWeps);
if (($CFU_Time - $Warehouse[2]) <= 1){echo "�A��b�����ӧ֤F�C�Щ����A���C<br>�h�¦X�@�I";exit;}

if ($mode == 'selection'){
	echo "<font style=\"font-size: 12pt\">�ܮw</font>";
	printTHR();

	echo "<form action=warehouse.php?action=main method=post name=mainform>";
	echo "<input type=hidden value='none' name=actionb>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr><td align=center width=250><b style=\"font-size: 10pt;\">�ܮw</b></td></tr>";
	echo "<tr><td align=left>";
	echo "�Z���w<Br>�@- �K�O���ѪZ���B�˳ƪ��H�s�A��<br>�@- �Ԫ������]��ϥ�<br>�@- �S���骺���p�U�i�H�H�s�ϥΤ��Z��<br>";
	echo "��Ǯw<Br>�@- ���Ѧ��O�����骺�H�s�A��<br>�@- ���欰 $".number_format($Hangar_Price)."<br>�@- �Ԫ���������ϥ�<br>�@- ���W���˳ơB�Z�������^����<br>";
	echo "<center><input type=\"submit\" value='�Z���w'><input type=\"submit\" value='��Ǯw' onClick=\"mainform.action='hangar.php?action=main';\">";
	echo "</center></tr></td></form></table>";
}

//Warehouse GUI
elseif ($mode=='main'){

$actionb = ( isset($_POST['actionb']) ) ? $_POST['actionb'] : '';

if ($mode=='main' && $actionb == 'procget'){
	if ($UsrWepB[0] && $UsrWepC[0]){$ErrorMsg = '�A�S���Ŧ�˳ơI';}
	elseif ($getwep == 'none'){$ErrorMsg = '�Ы��w�n���X���˳ơC';}
	else {
	
	$WChacheArrays = explode("\n",$Warehouse[1]);
	sort($WChacheArrays);
	$Warehouse[1] = implode("\n",$WChacheArrays);
	$Warehouse[1] = trim($Warehouse[1]);
	
	unset($GetWarehseWeps);
	$GetWarehseWeps = explode("\n",$Warehouse[1]);
	unset($sql,$dest);
	if (!$UsrWepB[0]){$dest='wepb';unset($UsWep_B,$UsrWepB);}
	elseif (!$UsrWepC[0]){$dest='wepc';unset($UsWep_C,$UsrWepC);}	
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `$dest` = '$GetWarehseWeps[$getwep]' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
	mysql_query($sql);unset($sql);
	unset($GetWarehseWeps[$getwep]);
	sort($GetWarehseWeps);
	$Warehouse[1] = implode("\n",$GetWarehseWeps);
	$Warehouse[1] = trim($Warehouse[1]);
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_warehouse` SET `warehouse` = '$Warehouse[1]', `timelast` = '$CFU_Time' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
	mysql_query($sql);
	unset($sql,$dest,$GetWepDe,$Gen,$Game,$UsrWepB,$UsrWepC,$UsWep_B,$UsWep_C,$UsWepSpec_B,$UsWepSpec_C);}
	$ErrorMsg= (isset($ErrorMsg)) ? $ErrorMsg : '���\\���X�˳ƤF�I';
	echo "<form action=warehouse.php?action=main method=post name=frmct target=$SecTarget>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";
	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
	echo "<p align=center style=\"font-size: 16pt\">$ErrorMsg<br><input type=submit value=\"��^\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"><input type=button value=\"�~��ϥΪZ���w\" onClick=\"frmct.submit()\"></p>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";
	
	postFooter();exit;
}
if ($mode=='main' && $actionb == 'prockeep'){
	if (!$UsrWepB[0] && $keepwep=='wepb'){$ErrorMsg = '�䤣��A���˳�!!';}
	elseif (!$UsrWepC[0] && $keepwep=='wepc'){$ErrorMsg = '�䤣��A���˳�!!';}
	elseif ($keepwep=='wepa' && $Gen['msuit']){$ErrorMsg = '�����ϥΤ��Z����J�ܮw�I';}
	elseif (!$keepwep){$ErrorMsg = '�䤣��A���˳�!!';}
	elseif ($Countnumwhwp > 100){$ErrorMsg = '�ܮw�Ӧh�Z���F�I';}
	else {
		$Warehouse[1] .="\n$Game[$keepwep]";
		$WChacheArrays = explode("\n",$Warehouse[1]);
		sort($WChacheArrays);
		$Warehouse[1] = implode("\n",$WChacheArrays);
		$Warehouse[1] = trim($Warehouse[1]);
		unset($sql);
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_warehouse` SET `warehouse` = '$Warehouse[1]', `timelast` = '$CFU_Time' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
		mysql_query($sql);unset($sql);
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `$keepwep` = '0<!>0' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
		mysql_query($sql);
		unset($Gen,$Game,$UsrWepB,$UsrWepC,$UsWep_B,$UsWep_C);
	$ErrorMsg= (isset($ErrorMsg)) ? $ErrorMsg : 0;
	if (!$ErrorMsg)$ErrorMsg ='���\\�s�J�˳ƤF�I';
	echo "<form action=warehouse.php?action=main method=post name=frmct target=$SecTarget>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";
	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
	echo "<p align=center style=\"font-size: 16pt\">$ErrorMsg<br><input type=submit value=\"��^\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"><input type=button value=\"�~��ϥΪZ���w\" onClick=\"frmct.submit()\"></p>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";
	
	postFooter();exit;
	}
}

$a_sel = $b_sel = $c_sel = '';

echo "�Z���w<hr>";
echo "<br>";
echo "<form action=warehouse.php?action=main method=post name=whmainform>";
echo "<input type=hidden value='' name=actionb>";
echo "<input type=hidden value='' name=actionc>";
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#FFFFFF\" width=\"650\">";
	echo "<tr align=center><td colspan=10><b>�˳ƪZ���C��: </b></td></tr>";
	echo "<tr align=center>";
	echo "<td width=\"20\">No.</td>";
	echo "<td width=\"195\">�Z���W��</td>";
	echo "<td width=\"80\">�����O</td>";
	echo "<td width=\"30\">�R��</td>";
	echo "<td width=\"30\">�^��</td>";
	echo "<td width=\"40\">EN���O</td>";
	echo "<td width=\"80\">�Z��/�ݩ�</td>";
	echo "<td width=\"120\">�S��ĪG</td>";
	echo "<td width=\"85\">����</td>";
	echo "<td width=\"50\">���A��</td>";
	echo "</tr>";
	
	if ($UsrWepA[0]){
	if ($UsrWepA[1] > 0) $UsrWepA['displayXp'] = '+'.($UsrWepA[1]/100).'%';
	elseif ($UsrWepA[1] < 0) $UsrWepA['displayXp'] = ($UsrWepA[1]/100).'%';
	else $UsrWepA['displayXp'] = '��0%';
	echo "<tr align=center>";
	echo "<td width=\"20\">�{</td>";
	echo "<td width=\"195\">$UsWep_A[name]</td>";
	echo "<td width=\"80\">". number_format($UsWep_A['atk']) ."</td>";
	echo "<td width=\"30\">$UsWep_A[hit]</td>";
	echo "<td width=\"30\">$UsWep_A[rd]</td>";
	echo "<td width=\"40\">$UsWep_A[enc]</td>";
	printf("<td width=\"80\">%s</td>", getRangeAttrb($UsWep_A['range'],$UsWep_A['attrb'],$UsWep_A['equip']));
	echo "<td width=\"120\">$UsWepSpec_A</td>";
	echo "<td width=\"85\">". number_format($UsWep_A['price']) ."</td>";
	echo "<td width=\"50\">$UsrWepA[displayXp]</td>";
	if(!$Gen['msuit']) $a_sel = "<option value='wepa'>�ƥΤ@: $UsWep_A[name]";
	else $a_sel = '';
	echo "</tr>";}
	if ($UsrWepB[0]){
	if ($UsrWepB[1] > 0) $UsrWepB['displayXp'] = '+'.($UsrWepB[1]/100).'%';
	elseif ($UsrWepB[1] < 0) $UsrWepB['displayXp'] = ($UsrWepB[1]/100).'%';
	else $UsrWepB['displayXp'] = '��0%';
	echo "<tr align=center>";
	echo "<td width=\"20\">�@</td>";
	echo "<td width=\"195\">$UsWep_B[name]</td>";
	echo "<td width=\"80\">". number_format($UsWep_B['atk']) ."</td>";
	echo "<td width=\"30\">$UsWep_B[hit]</td>";
	echo "<td width=\"30\">$UsWep_B[rd]</td>";
	echo "<td width=\"40\">$UsWep_B[enc]</td>";
	printf("<td width=\"80\">%s</td>", getRangeAttrb($UsWep_B['range'],$UsWep_B['attrb'],$UsWep_B['equip']));
	echo "<td width=\"120\">$UsWepSpec_B</td>";
	echo "<td width=\"85\">". number_format($UsWep_B['price']) ."</td>";
	echo "<td width=\"50\">$UsrWepB[displayXp]</td>";
	$b_sel = "<option value='wepb'>�ƥΤ@: $UsWep_B[name]";
	echo "</tr>";}
	if ($UsrWepC[0]){
	if ($UsrWepC[1] > 0) $UsrWepC['displayXp'] = '+'.($UsrWepC[1]/100).'%';
	elseif ($UsrWepC[1] < 0) $UsrWepC['displayXp'] = ($UsrWepC[1]/100).'%';
	else $UsrWepC['displayXp'] = '��0%';
	echo "<tr align=center>";
	echo "<td width=\"20\">�G</td>";
	echo "<td width=\"195\">$UsWep_C[name]</td>";
	echo "<td width=\"80\">". number_format($UsWep_C['atk']) ."</td>";
	echo "<td width=\"30\">$UsWep_C[hit]</td>";
	echo "<td width=\"30\">$UsWep_C[rd]</td>";
	echo "<td width=\"40\">$UsWep_C[enc]</td>";
	printf("<td width=\"80\">%s</td>", getRangeAttrb($UsWep_C['range'],$UsWep_C['attrb'],$UsWep_C['equip']));
	echo "<td width=\"120\">$UsWepSpec_C</td>";
	echo "<td width=\"85\">". number_format($UsWep_C['price']) ."</td>";
	echo "<td width=\"50\">$UsrWepC[displayXp]</td>";
	$c_sel = "<option value='wepc'>�ƥΤG: $UsWep_C[name]";
	echo "</tr>";}
	echo "</table>";
	printTHR('85%');
	$Disable_Keep_Msg = '';
	if (!$UsrWepB[0] && !$UsrWepC[0]){
		if (!$Gen['msuit'] && !$UsrWepA[0]) $Disable_Keep_Msg .= '<center>�A�S���˳Ư�s�J�ܮw�C</center>';
		elseif ($Gen['msuit'] && !$UsrWepA[0]) $Disable_Keep_Msg .= '<center>�A�S���˳Ư�s�J�ܮw�C</center>';
		elseif ($Gen['msuit'] && $UsrWepA[0]) $Disable_Keep_Msg .= '<center>�A�S���˳Ư�s�J�ܮw�C</center>';
	}
	if ($Countnumwhwp > 100){$Disable_Keep_Msg .= '<center>�ܮw�Ӧh�Z���F�I����A�s�J�ܮw�C</center><br>';}
	if ($Disable_Keep_Msg) echo $Disable_Keep_Msg;
	else {
	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#FFFFFF\" width=\"300\">";
	echo "<tr><td>�s��Z��:";
	echo "<center><select name='keepwep'><option value=0>�ССССССССССe�п�ܡf�ССССССССС� $a_sel $b_sel $c_sel </select><br><input type=submit value=�T�w�s�� onClick=\"whmainform.actionb.value='prockeep'\"></center></td></tr>";
	echo "</table>";}
	printTHR('85%');
//In Warehouse

	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#FFFFFF\" width=\"650\">";
	echo "<tr align=center><td colspan=10><b>�ܮw�����Z��: </b></td></tr>";
	echo "<tr align=center>";
	echo "<td width=\"20\">No.</td>";
	echo "<td width=\"195\">�Z���W��</td>";
	echo "<td width=\"80\">�����O</td>";
	echo "<td width=\"30\">�R��</td>";
	echo "<td width=\"30\">�^��</td>";
	echo "<td width=\"40\">EN���O</td>";
	echo "<td width=\"80\">�Z��/�ݩ�</td>";
	echo "<td width=\"120\">�S��ĪG</td>";
	echo "<td width=\"85\">����</td>";
	echo "<td width=\"50\">���A��</td>";
	echo "</tr>";
	$SelWepOpt = '';

	if ($Countnumwhwp > 0 && $Warehouse[1] != ''){
		for($ctwp=0;$ctwp<$Countnumwhwp;$ctwp++){unset($WhThisInfoSys,$WhThisInfo,$WhThisSpec);
		$WhThisInfo = explode('<!>',$WarehseWeps[$ctwp]);
		GetWeaponDetails("$WhThisInfo[0]",'WhThisInfoSys');
		$WhThisSpec = ReturnSpecs($WhThisInfoSys['spec']);
		
		$WhThisInfo[2]= (isset($WhThisInfo[2])) ? $WhThisInfo[2] : 0;
		if ($WhThisInfo[2]){
		if ($WhThisInfo[2]==1) $WhThisInfoSys['name'] = $WhThisInfo[3].$WhThisInfoSys['name']."<sub>&copy;</sub>";
		else $WhThisInfoSys['name'] = $WhThisInfoSys['name'].$WhThisInfo[3]."<sub>&copy;</sub>";
		$WhThisInfoSys['atk'] += $WhThisInfo[4];
		$WhThisInfoSys['hit'] += $WhThisInfo[5];
		$WhThisInfoSys['rd'] += $WhThisInfo[6];
		$WhThisInfoSys['enc'] = $WhThisInfo[7];
		}
	
		if ($WhThisInfo[1] > 0) $WhThisInfo['displayXp'] = '+'.($WhThisInfo[1]/100).'%';
		elseif ($WhThisInfo[1] < 0) $WhThisInfo['displayXp'] = ($WhThisInfo[1]/100).'%';
		else $WhThisInfo['displayXp'] = '��0%';
	
		$SelWepOpt .= "<option value = $ctwp>(No. $ctwp) $WhThisInfoSys[name] (���A��: $WhThisInfo[displayXp])";
		echo "<tr align=center>";
		echo "<td width=\"20\">$ctwp</td>";
		echo "<td width=\"195\">$WhThisInfoSys[name]</td>";
		echo "<td width=\"80\">". number_format($WhThisInfoSys['atk']) ."</td>";
		echo "<td width=\"30\">$WhThisInfoSys[hit]</td>";
		echo "<td width=\"30\">$WhThisInfoSys[rd]</td>";
		echo "<td width=\"40\">$WhThisInfoSys[enc]</td>";
		printf("<td width=\"80\">%s</td>", getRangeAttrb($WhThisInfoSys['range'],$WhThisInfoSys['attrb'],$WhThisInfoSys['equip']));
		echo "<td width=\"120\">$WhThisSpec</td>";
		echo "<td width=\"85\">". number_format($WhThisInfoSys['price']) ."</td>";
		echo "<td width=\"50\">$WhThisInfo[displayXp]</td>";
		echo "</tr>";unset($WhThisInfoSys,$WhThisInfo,$WhThisSpec);}
		echo "</table>";
		printTHR('85%');
		if ($UsrWepB[0] && $UsrWepC[0]){echo '<center>�A�S���Ŧ�q�ܮw���X�˳ơC';}
		else {
			echo "<script language=\"JavaScript\">";
			echo "function chkPut(){";
			echo "if (confirm(\"����m��b�����l�����~, ���|���h�Ҧ����A��!!\\n�T�w�ܡH\") == true){";
			echo "whmainform.action = \"tactfactory.php?action=main\";whmainform.actionb.value='put';whmainform.actionc.value='wh';";
			echo "}else return false; }";
			echo "function chkView(){";
			echo "whmainform.action = \"tactfactory.php?action=main\";whmainform.actionb.value='view';whmainform.actionc.value='wh';";
			echo "}";
			echo "</script>";
			echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#FFFFFF\" width=\"300\">";
			echo "<tr><td>���X�Z���B�m��J���l���˵��Ź�:<br>";
			echo "<center><select name='getwep'><option value='none'>�ССССССССССe�п�ܡf�ССССССССС� $SelWepOpt </select><br>";
			echo "<input type=submit value=�T�w���X onClick=\"whmainform.actionb.value='procget'\">";
			echo "<input type=submit value=�m��J���l onClick=\"return chkPut();\">";
			echo "<input type=submit value=�˵��Ź� onClick=\"return chkView();\">";
			echo "</center></td></tr></table>";
		}
	}else {echo "<tr align=center><td colspan=9>�ܮw���S���Z��</td></tr></table>";}
	printTHR('85%');
echo "</form>";
}//End GUI

else {echo "���w�q�ʧ@�I";}
postFooter();exit;
?>