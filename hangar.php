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
if ($t_now - $Gen['btltime'] <= 1){echo "�ʧ@�L�֡C";postFooter();mysql_query("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `btltime` = ".intval($t_now+10)." WHERE `username` = '$Gen[username]' LIMIT 1;");exit;}


function hasExam($spec){
	if(strpos($spec,'EXAMSystem') === false) return false;
	else return true;
}

$tickImg = $Base_Image_Dir. '/tickImgB.gif';
$crossImg = $Base_Image_Dir. '/crossImgB.gif';

$UsrWepA = explode('<!>',$Game['wepa']);
$UsrWepB = explode('<!>',$Game['wepb']);
$UsrWepC = explode('<!>',$Game['wepc']);
$UsrWepD = explode('<!>',$Game['eqwep']);
$UsrWepE = explode('<!>',$Game['p_equip']);
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

GetWeaponDetails("$UsrWepD[0]",'UsWep_D');
$UsrWepD[2]= (isset($UsrWepD[2])) ? $UsrWepD[2] : 0;
if ($UsrWepD[2]){
if ($UsrWepD[2]==1) $UsWep_D['name'] = $UsrWepD[3].$UsWep_D['name']."<sub>&copy;</sub>";
else $UsWep_D['name'] = $UsWep_D['name'].$UsrWepD[3]."<sub>&copy;</sub>";
$UsWep_D['atk'] += $UsrWepD[4];
$UsWep_D['hit'] += $UsrWepD[5];
$UsWep_D['rd'] += $UsrWepD[6];
$UsWep_D['enc'] = $UsrWepD[7];
}
$UsWepSpec_D = ReturnSpecs("$UsWep_D[spec]");

GetWeaponDetails("$UsrWepE[0]",'UsWep_E');
$UsrWepE[2]= (isset($UsrWepE[2])) ? $UsrWepE[2] : 0;
if ($UsrWepE[2]){
if ($UsrWepE[2]==1) $UsWep_E['name'] = $UsrWepE[3].$UsWep_E['name']."<sub>&copy;</sub>";
else $UsWep_E['name'] = $UsWep_E['name'].$UsrWepE[3]."<sub>&copy;</sub>";
$UsWep_E['atk'] += $UsrWepE[4];
$UsWep_E['hit'] += $UsrWepE[5];
$UsWep_E['rd'] += $UsrWepE[6];
$UsWep_E['enc'] = $UsrWepE[7];
}
$UsWepSpec_E = ReturnSpecs("$UsWep_E[spec]");

//Hangar GUI
if ($mode=='main'){

	$SQL_Main = ("SELECT `h_id`, `h_user`, `h_msuit`, `h_hp`, `h_hpmax`, `h_en`, `h_enmax`, `h_ms_custom`, `h_wepa`, `h_wepb`, `h_wepc`, `h_eqwep`, `h_p_equip`, `msname`, `atf`, `def`, `ref`, `taf`  FROM `".$GLOBALS['DBPrefix']."phpeb_user_hangar` `h`, `".$GLOBALS['DBPrefix']."phpeb_sys_ms` `ms` WHERE `h_user` = '$Pl_Value[USERNAME]' AND `id` = `h_msuit` ORDER BY `h_id` ASC;");
	$SQL_Query_Main = mysql_query($SQL_Main) or die(mysql_error());
	$NumHangarMS = mysql_num_rows($SQL_Query_Main);

if ($mode=='main' && $actionb == 'procget'){
	$actionc = intval($actionc);
	if ($Gen['msuit']){$ErrorMsg = '�Х��w�m�n���b�ϥΪ�����!!';}
	elseif ($Game['wepa'] != '0<!>0' || $Game['wepb'] != '0<!>0' || $Game['wepc'] != '0<!>0' || $Game['eqwep'] != '0<!>0'){$ErrorMsg = '�Х��w�m�n�ƥΤ����Z���M�˳�!!';}
	elseif (!$actionc){$ErrorMsg = '�Х���w�ؼо���!!';}
	else {
		$sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_hangar` WHERE `h_id` = '$actionc' AND `h_user` = '$Pl_Value[USERNAME]' LIMIT 1;");
		$sql_query = mysql_query($sql) or die(mysql_error());
		$CountResults = mysql_num_rows($sql_query);
		if ($CountResults != 1) $ErrorMsg = '�䤣�����C';
		else {
			$Hangar = mysql_fetch_array($sql_query);

			$Eq = explode('<!>',$Hangar['h_eqwep']);
			$P_Eq = explode('<!>',$Hangar['h_p_equip']);

			$sql = ("SELECT `spec` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` WHERE id='". $Eq[0] ."'");
			$query_r = mysql_query($sql);
			$SyEq = mysql_fetch_array($query_r);

			$sql = ("SELECT `spec` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` WHERE id='". $P_Eq[0] ."'");
			$query_r = mysql_query($sql);
			$SyP_Eq = mysql_fetch_array($query_r);

			$sql = ("SELECT `spec` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_ms` WHERE id='". $Hangar['h_msuit'] ."'");
			$query_r = mysql_query($sql);
			$SyMs = mysql_fetch_array($query_r);

			$isEXAMSpec = (hasExam($SyEq['spec']) || hasExam($SyP_Eq['spec']) || hasExam($SyMs['spec']));
			$isEXAMactive = hasExam($Game['spec']);
			$isEXAMtypech = ($Gen['typech'] == 'nat' || $Gen['typech'] == 'enh' || $Gen['typech'] == 'ext');

			if ($isEXAMSpec && !$isEXAMactive && $isEXAMtypech) {
				$Game['spec'] .= 'EXAMSystem, ';
				$EXAM_String = ("`spec` = '$Game[spec]', ");
			}else $EXAM_String = '';

			$SQL = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `msuit` = '$Hangar[h_msuit]' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
			mysql_query($SQL) or die(mysql_error());
			$SQL = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET $EXAM_String `hp` = '$Hangar[h_hp]', `hpmax` = '$Hangar[h_hpmax]', `en` = '$Hangar[h_en]', `enmax` = '$Hangar[h_enmax]', `ms_custom` = '$Hangar[h_ms_custom]', `wepa` = '$Hangar[h_wepa]', `wepb` = '$Hangar[h_wepb]', `wepc` = '$Hangar[h_wepc]', `eqwep` = '$Hangar[h_eqwep]', `p_equip` = '$Hangar[h_p_equip]' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
			mysql_query($SQL) or die(mysql_error());
			$SQL = ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_hangar` WHERE `h_id` = '$actionc' AND `h_user` = '$Pl_Value[USERNAME]' LIMIT 1;");
			mysql_query($SQL) or die(mysql_error());
		}
	}
	if (empty($ErrorMsg))$ErrorMsg ='���\\���X����M�˳ƤF�I';
	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
	echo "<p align=center style=\"font-size: 16pt\">$ErrorMsg<br><input type=submit value=\"��^\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";

	postFooter();exit;
}
if ($mode=='main' && $actionb == 'prockeep'){

	if (!$Gen['msuit']){$ErrorMsg = '�A�S������i�H�s�J��Ǯw!!';}
	elseif ($NumHangarMS >= $Hangar_Limit) {$ErrorMsg = '��Ǯw�Ŷ������I<Br>�w�g�ϥΤF$NumHangarMS/$Hangar_Limit�ӪŶ��C';}
	elseif ($Gen['cash'] - $Hangar_Price < 0) {$ErrorMsg = '���������I';}
	else {
		$sql = ("SELECT `spec` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_ms` WHERE id='". $Gen['msuit'] ."'");
		$query_r = mysql_query($sql);
		$SyMs = mysql_fetch_array($query_r);
		$hypmd_sql = '';
		$hypmd = 0;

		$isEXAMSpec = (hasExam($SyMs['spec']) || hasExam($UsWep_D['spec']) || hasExam($UsWep_E['spec']));

		if ( $isEXAMSpec && hasExam($Game['spec'])) {
			$Game['spec'] = str_replace('EXAMSystem, ','',$Game['spec']);
			$EXAM_String = ("`spec` = '$Game[spec]', ");
		}else $EXAM_String  = '';

		//Remove EXAM Activation
		if ($Gen['hypermode'] >= 4 && $Gen['hypermode'] <= 6){
			switch($Gen['hypermode']){
			case 4: $hypmd = 0; break;
			case 5: $hypmd = 1; break;
			case 6: $hypmd = 2; break;
			}
			$TFlag = 1;
			$hypmd_sql = ", `hypermode` = $hypmd ";
		}

		$sql = ("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_user_hangar` VALUES('','$Pl_Value[USERNAME]','$Gen[msuit]','$Game[hp]','$Game[hpmax]','$Game[en]','$Game[enmax]','$Game[ms_custom]','$Game[wepa]','$Game[wepb]','$Game[wepc]','$Game[eqwep]','$Game[p_equip]');");
		mysql_query($sql) or die(mysql_error());
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET $EXAM_String `hp` = 0, `hpmax` = 0, `en` = 0 , `enmax` = 0, `ms_custom` = '', `wepa` = '0<!>0', `wepb` = '0<!>0', `wepc` = '0<!>0', `eqwep` = '0<!>0', `p_equip` = '0<!>0' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
		mysql_query($sql) or die(mysql_error());
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `msuit` = 0 $hypmd_sql, `cash` = `cash`-$Hangar_Price WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
		mysql_query($sql) or die(mysql_error());
	}
	if (empty($ErrorMsg)) $ErrorMsg ='���\\�s�J����M�˳ƤF�I';
	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
	echo "<p align=center style=\"font-size: 16pt\">$ErrorMsg<br><input type=submit value=\"��^\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";

	postFooter();exit;
}

if ($mode=='main' && $actionb == 'procgive'){
	$actionc = intval($actionc);
	$entname = str_replace("[\|\`(--)]+",'',$entname);
	if (!$actionc){$ErrorMsg = '�Х���w�ؼо���!!';}
	elseif (!$entname || $entname == '<<��ʿ�J>>'){$ErrorMsg = '�Х���w�ؼФH��!!';}
	else {
		$sql = ("SELECT `username`, `level` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `gamename` = '".$entname."'");
		$sql_query = mysql_query($sql) or die(mysql_error());
		$CountResults = mysql_num_rows($sql_query);
		if ($CountResults != 1) $ErrorMsg = '�䤣��ؼЪ��a�C';
		else {
			$result = mysql_fetch_array($sql_query);
			$entuser = $result['username'];
			$level = $result['level'];
			$sql = ("SELECT `needlv` FROM `".$GLOBALS['DBPrefix']."phpeb_user_hangar`, `".$GLOBALS['DBPrefix']."phpeb_sys_ms` WHERE `h_msuit` = `id` AND `h_id` = '$actionc' AND `h_user` = '$Pl_Value[USERNAME]' LIMIT 1;");
			$sql_query = mysql_query($sql) or die(mysql_error());
			$CountResults = mysql_num_rows($sql_query);
			unset($result);
			$result = mysql_fetch_array($sql_query);
			if ($CountResults < 1) $ErrorMsg = '�䤣�����C';
			elseif ($result['needlv'] > $level){
				$ErrorMsg = '�����赥�Ť����C';
			}
			else {
				$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_hangar` SET `h_user` = '".$entuser."' WHERE `h_id` = '$actionc' AND `h_user` = '$Pl_Value[USERNAME]' LIMIT 1;");
				$query = mysql_query($sql);
			}
		}
	}
	if (empty($ErrorMsg)) $ErrorMsg ='�w�ذe����I';
	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
	echo "<p align=center style=\"font-size: 16pt\">$ErrorMsg<br><input type=submit value=\"��^\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";

	postFooter();exit;
}

echo "<font style=\"font-size: 12pt\">��Ǯw</font><hr>";
echo "<br>";
echo "<form action=hangar.php?action=main method=post name=hnmainform>";
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
	if ($UsrWepD[0]){
	if ($UsrWepD[1] > 0) $UsrWepD['displayXp'] = '+'.($UsrWepD[1]/100).'%';
	elseif ($UsrWepD[1] < 0) $UsrWepD['displayXp'] = ($UsrWepD[1]/100).'%';
	else $UsrWepD['displayXp'] = '��0%';
	echo "<tr align=center>";
	echo "<td width=\"20\">��</td>";
	echo "<td width=\"195\">$UsWep_D[name]</td>";
	echo "<td width=\"80\">". number_format($UsWep_D['atk']) ."</td>";
	echo "<td width=\"30\">$UsWep_D[hit]</td>";
	echo "<td width=\"30\">$UsWep_D[rd]</td>";
	echo "<td width=\"40\">$UsWep_D[enc]</td>";
	printf("<td width=\"80\">%s</td>", getRangeAttrb($UsWep_D['range'],$UsWep_D['attrb'],$UsWep_D['equip']));
	echo "<td width=\"120\">$UsWepSpec_D</td>";
	echo "<td width=\"85\">". number_format($UsWep_D['price']) ."</td>";
	echo "<td width=\"50\">$UsrWepD[displayXp]</td>";
	$c_sel = "<option value='WepD'>���U�˳�: $UsWep_D[name]";
	echo "</tr>";}
	if ($UsrWepE[0]){
	if ($UsrWepE[1] > 0) $UsrWepE['displayXp'] = '+'.($UsrWepE[1]/100).'%';
	elseif ($UsrWepE[1] < 0) $UsrWepE['displayXp'] = ($UsrWepE[1]/100).'%';
	else $UsrWepE['displayXp'] = '��0%';
	echo "<tr align=center>";
	echo "<td width=\"20\">�`</td>";
	echo "<td width=\"195\">$UsWep_E[name]</td>";
	echo "<td width=\"80\">". number_format($UsWep_E['atk']) ."</td>";
	echo "<td width=\"30\">$UsWep_E[hit]</td>";
	echo "<td width=\"30\">$UsWep_E[rd]</td>";
	echo "<td width=\"40\">$UsWep_E[enc]</td>";
	printf("<td width=\"80\">%s</td>", getRangeAttrb($UsWep_E['range'],$UsWep_E['attrb'],$UsWep_E['equip']));
	echo "<td width=\"120\">$UsWepSpec_E</td>";
	echo "<td width=\"85\">". number_format($UsWep_E['price']) ."</td>";
	echo "<td width=\"50\">$UsrWepE[displayXp]</td>";
	$c_sel = "<option value='WepD'>�`�W�˳�: $UsWep_E[name]";
	echo "</tr>";}
	echo "</table>";

	echo "<script language=\"Javascript\">";
	echo "function cfmKeep(){
		if (confirm('�� $".number_format($Hangar_Price)." �Ӧs�����ܡH') == true){hnmainform.actionb.value='prockeep';return true;}
		else {return false;}";
	echo "}</script>";


	echo "<hr width=85%>";
	if (!$Gen['msuit']){echo '<center>�A�S������i�H�s�J��Ǯw�C';}
	elseif ($NumHangarMS > $Hangar_Limit){echo '<center>��Ǯw�Ӧh����F�I����A�s�J��Ǯw�C';}
	else {
	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#FFFFFF\" width=\"200\">";
	echo "<tr><td align=center>�s�i��Ǯw:<br>";
	echo "<input type=submit value=�T�w�s�� onClick=\"return cfmKeep()\" $BStyleB style=\"$BStyleA\"></td></tr>";
	echo "</table>";}


	echo "<hr width=85%>";
//In Hangar

	echo "<script language=\"Javascript\">
function setLayer(posX,posY,Width,Height,msgText){
	var X = posX + document.body.scrollLeft + 10;
	var Y = posY + document.body.scrollTop + 10;
	if(eval(posX + Width + 30) > document.body.clientWidth){
		X = eval(posX - Width + document.body.scrollLeft - 20);
	}if(eval(posY + Height + 30) > document.body.clientHeight){
		Y = eval(posY - Height + document.body.scrollTop - 20);
	}if(X<0){
		X = 0;
	}if(Y<0){
		Y = 0;
	}

	tmpTxt = eval(msgText);

	document.getElementById(\"wepinfo\").style.width = Width;
	document.getElementById(\"wepinfo\").style.height = 'auto';
	document.getElementById(\"wepinfo\").style.backgroundColor = \"ffffdd\";
	document.getElementById(\"wepinfo\").style.padding = 10;
	document.getElementById(\"wepinfo\").innerHTML = tmpTxt;
	document.getElementById(\"wepinfo\").style.border = \"solid 1px #000000\";
	document.getElementById(\"wepinfo\").style.left = X;
	document.getElementById(\"wepinfo\").style.top  = Y;
}

function offLayer(){
	document.getElementById(\"wepinfo\").style.width = 0;
	document.getElementById(\"wepinfo\").style.height = 0;
	document.getElementById(\"wepinfo\").innerHTML = \"\";
	document.getElementById(\"wepinfo\").style.backgroundColor = \"transparent\";
	document.getElementById(\"wepinfo\").style.border = 0;
}

function confirmTake(h_id){
	if ($Gen[msuit] != 0){alert('�Х��w�m�n���b�ϥΪ�����');}
	else if ('$Game[wepa]' != '0<!>0' || '$Game[wepb]' != '0<!>0' || '$Game[wepc]' != '0<!>0' || '$Game[eqwep]' != '0<!>0'){alert('�Х��w�m�n�ƥΤ����Z���M�˳�!!');}
	else if (confirm('�n���XID: '+h_id+' �������?\\n�Ъ`�N, ���[�෽�M���[�˥��٦s�b����, �N�|�Q��m!') == true) {hnmainform.actionb.value='procget';hnmainform.actionc.value=h_id;hnmainform.submit();}
}
function confirmGive(h_id,ename){
	if (!ename || ename == '<<��ʿ�J>>'){alert(\"�Ы��w�ؼФH���C\");return false;}
	else if (confirm('�n�ذeID: '+h_id+' �����餩 '+ename+' ��?') == true) {hnmainform.actionb.value='procgive';hnmainform.actionc.value=h_id;hnmainform.submit();}
}
</script>
";

	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#333333\" width=\"680\">";
	echo "<tr align=center><td colspan=10><b>��Ǯw��������: </b></td></tr>";

	$TakeOptions = '';

	while($Hangar = mysql_fetch_array($SQL_Query_Main)){
	$TakeOptions .= "<option value='$Hangar[h_id]'>$Hangar[h_id]";

	if ($Hangar['h_ms_custom']){
		$MS_CFix = split('<!>',$Hangar['h_ms_custom']);
		$Hangar['msname'] = $MS_CFix[0];
		$Hangar['atf'] += $MS_CFix[1];
		$Hangar['def'] += $MS_CFix[2];
		$Hangar['ref'] += $MS_CFix[3];
		$Hangar['taf'] += $MS_CFix[4];
	}

	echo "<tr align=center style=\"cursor: pointer\" onClick=\"confirmTake('$Hangar[h_id]');\" onMouseOver=\"this.style.color='yellow'\" onMouseOut=\"this.style.color='white'\">";
	echo "<td width=\"80\" rowspan=2>��Ǯw ID</td>";
	echo "<td width=\"200\" rowspan=2>����W��</td>";
	echo "<td width=\"50\">Att</td>";
	echo "<td width=\"50\">Def</td>";
	echo "<td width=\"50\">Mob</td>";
	echo "<td width=\"50\">Tar</td>";
	echo "<td width=\"100\">HP</td>";
	echo "<td width=\"100\">EN</td>";
	echo "</tr>";
	echo "<tr align=center style=\"cursor: pointer\" onClick=\"confirmTake('$Hangar[h_id]');\">";
	echo "<td style=\"color: ".colorConvert($Hangar['atf'],50)."\">$Hangar[atf]</td>";
	echo "<td style=\"color: ".colorConvert($Hangar['def'],50)."\">$Hangar[def]</td>";
	echo "<td style=\"color: ".colorConvert($Hangar['ref'],50)."\">$Hangar[ref]</td>";
	echo "<td style=\"color: ".colorConvert($Hangar['taf'],50)."\">$Hangar[taf]</td>";
	echo "<td><span style=\"color: ".colorConvert($Hangar['h_hp'],$Hangar['h_hpmax'])."\">$Hangar[h_hp]</span> / ";
	echo "<span style=\"color: ".colorConvert($Hangar['h_hpmax'],$Max_HP)."\">$Hangar[h_hpmax]</span></td>";
	echo "<td><span style=\"color: ".colorConvert($Hangar['h_en'],$Hangar['h_enmax'])."\">$Hangar[h_en]</span> / ";
	echo "<span style=\"color: ".colorConvert($Hangar['h_enmax'],$Max_EN)."\">$Hangar[h_enmax]</span></td>";
	echo "</tr>";
	echo "<tr align=center style=\"cursor: pointer\" onClick=\"confirmTake('$Hangar[h_id]');\">";
	echo "<td style=\"color: ForestGreen; font-weight: Bold\">$Hangar[h_id]</td>";
	echo "<td style=\"color: ForestGreen; font-weight: Bold\">$Hangar[msname]</td>";
	echo "<td colspan=8>";

		echo "<table align=center border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#FFFFFF\" width=\"100%\">";
		echo "<tr align=center>";
		echo "<td width=\"20%\">�Z��</td>";
		echo "<td width=\"20%\">�ƥΤ@</td>";
		echo "<td width=\"20%\">�ƥΤG</td>";
		echo "<td width=\"20%\">���U�˳�</td>";
		echo "<td width=\"20%\">�`�W�˳�</td>";
		echo "</tr><tr align=center>";
		unset($I);
		$Eq_Listing = Array('A' => 'h_wepa','B' => 'h_wepb','C' => 'h_wepc','D' => 'h_eqwep','E' => 'h_p_equip');
		foreach($Eq_Listing as $I => $V){
			$H_Wep = 'H_Wep'.$I;
			$H_SyWep = 'H_SyWep'.$I;
			$W_Inf = 'W_Inf'.$I;
			if ($Hangar[$V] && $Hangar[$V] != '0<!>0') {
				$$H_Wep = split('<!>',$Hangar[$V]);
				GetWeaponDetails(${$H_Wep}[0],$H_SyWep);
					${$H_Wep}[2] = (isset(${$H_Wep}[2])) ? ${$H_Wep}[2] : 0;
				if (${$H_Wep}[2]){
					if (${$H_Wep}[2]==1) ${$H_SyWep}['name'] = ${$H_Wep}[3].${$H_SyWep}['name']."<sub>&copy;</sub>";
					else ${$H_SyWep}['name'] = ${$H_SyWep}['name'].${$H_Wep}[3]."<sub>&copy;</sub>";
					${$H_SyWep}['atk'] += ${$H_Wep}[4];
					${$H_SyWep}['hit'] += ${$H_Wep}[5];
					${$H_SyWep}['rd'] += ${$H_Wep}[6];
					${$H_SyWep}['enc'] = ${$H_Wep}[7];
				}
				if (${$H_Wep}[1] > 0) ${$H_Wep}['displayXp'] = '+'.(${$H_Wep}[1]/100).'%';
				elseif (${$H_Wep}[1] < 0) ${$H_Wep}['displayXp'] = (${$H_Wep}[1]/100).'%';
				else ${$H_Wep}['displayXp'] = '��0%';
				$$W_Inf = ${$H_SyWep}['name']."<br>���A��: ".${$H_Wep}['displayXp']."<hr width=95%>��O:<br>";
				$$W_Inf .= "�@�����O: ".${$H_SyWep}['atk']."�@�@�@�^��: ".${$H_SyWep}['rd']."<br>�@�R��: ".${$H_SyWep}['hit']."�@�@�@EN���O: ".${$H_SyWep}['enc']."<br>";
				$$W_Inf .= "�Z��/�ݩ�: ".getRangeAttrb(${$H_SyWep}['range'],${$H_SyWep}['attrb'],${$H_SyWep}['equip'],false)."<br>";
				$$W_Inf .= "�S��ĪG:<br>";
				if (${$H_SyWep}['equip']) $$W_Inf .= "�i�H�˳�<br>";
				if (${$H_SyWep}['spec']) $$W_Inf .= ReturnSpecs(${$H_SyWep}['spec']);
				echo "<td OnMouseOver=\"setLayer(event.clientX,event.clientY,200,100,'\'".$$W_Inf."\'')\" OnMouseOut=\"offLayer()\"><img src='$tickImg' alt='��'></td>";
			}
			else echo "<td><img src='$crossImg' alt='��'></td>";
		}
		echo "</tr></table>";

	echo "</td></tr>";

	}
	if ($TakeOptions){
		echo "<tr><td colspan=10 align=left>�ؼо���: <select name=take_id $BStyleB style=\"$BStyleA\">$TakeOptions</select>";
		echo "<br>�@- <input type=button onClick=confirmTake(hnmainform.take_id.value) value=\"���X\" $BStyleB style=\"$BStyleA\">";
		echo "<br>�@- �ذe��<input type=text name=\"entname\" value=\"<<��ʿ�J>>\" style=\"width: 120;font-size: 9pt; color: #ffffff; background-color: #000000;text-align: center\" onfocus=\"this.value='';this.style.textAlign='left'\" onmouseover=\"this.style.color='yellow'\" onmouseout=\"this.style.color='FFFFFF'\">";
		echo "&nbsp;<input type=button onClick=confirmGive(hnmainform.take_id.value,hnmainform.entname.value) value=\"�ذe\" $BStyleB style=\"$BStyleA\">";
		echo "</td></tr>";
	}
	else echo "<tr><td colspan=10 align=center>�S���i���X������C</td></tr>";
	echo "</table>";
	echo "<hr width=85%>";
echo "</form>";
echo "<div id=wepinfo style=\"position:absolute; z-index:10;color: black;\" align=left></div>";
}//End GUI

else {echo "���w�q�ʧ@�I";}
postFooter();exit;
?>