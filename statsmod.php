<?php
$mode = ( isset($_GET['action']) ) ? $_GET['action'] : $_POST['action'];
include('cfu.php');
include('includes/repairplayer-f.inc.php');
if (empty($PriTarget)) $PriTarget = 'Alpha';
if (empty($SecTarget)) $SecTarget = 'Beta';
if (!isset($Game_Scrn_Type)) $Game_Scrn_Type = 1;
postHead('');
AuthUser("$Pl_Value[USERNAME]","$Pl_Value[PASSWORD]");
if ($CFU_Time >= $TIMEAUTH+$TIME_OUT_TIME || $TIMEAUTH <= $CFU_Time-$TIME_OUT_TIME){echo "�s�u�O�ɡI<br>�Э��s�n�J�I";exit;}
GetUsrDetails("$Pl_Value[USERNAME]",'Gen','Game');

$War_State = false;

function checkWartime($Coord){
	global $CFU_Time,$Otp_TellTime;
	$Otp_Area_Sql = ("SELECT `t_start`,`t_end` FROM `".$GLOBALS['DBPrefix']."phpeb_user_war` WHERE `mission` = 'Atk<$Coord>' AND `t_end` > '$CFU_Time' ORDER BY `t_start` ASC LIMIT 1");
	$Otp_Area_Q = mysql_query($Otp_Area_Sql) or die(mysql_error());
	$Otp_A_ITar = mysql_fetch_array($Otp_Area_Q);
	if ($Otp_A_ITar){
		if ($Otp_A_ITar['t_start'] >= $CFU_Time){
		$TimeTSSec = $Otp_A_ITar['t_start'] - $CFU_Time;
		$TimetS['hours'] = floor($TimeTSSec/3600);
		$TimetS['minutes'] = floor(($TimeTSSec - ($TimetS['hours']*3600))/60);
		$TimetS['seconds'] = floor($TimeTSSec - ($TimetS['hours']*3600) - ($TimetS['minutes']*60));
		$Otp_TellTime = "�٦�$TimetS[hours]�p��$TimetS[minutes]����$TimetS[seconds]��}�l�Ԫ��C";
		}
		else{
		$TimeTSSec = $Otp_A_ITar['t_end'] - $CFU_Time;
		$TimetS['hours'] = floor($TimeTSSec/3600);
		$TimetS['minutes'] = floor(($TimeTSSec - ($TimetS['hours']*3600))/60);
		$TimetS['seconds'] = floor($TimeTSSec - ($TimetS['hours']*3600) - ($TimetS['minutes']*60));
		$Otp_TellTime = "�٦�$TimetS[hours]�p��$TimetS[minutes]����$TimetS[seconds]��Ԫ��ŧi�פF1�C";
		return true;
		}
	}
	return false;
}

if ($mode=='addstat' && $actionb){
	$stat_added = '';
	switch($actionb){
	case 'at': $stat_added = 'attacking';if ($Game['attacking'] >= 150){echo "��O�L���I";exit;}$NextStatPt_At=$Game['attacking']+1;CalcStatReq('AtAdd',"$NextStatPt_At");if ($Gen['growth']-$AtAdd_Stat_Req < 0){echo "�I�Ƥ����I";exit;}$Gen['growth']-=$AtAdd_Stat_Req;$Game['attacking']=$NextStatPt_At;$ShowCompl="�����޳N�ܦ� $Game[attacking] �F�C";break;
	case 'de': $stat_added = 'defending';if ($Game['defending'] >= 150){echo "��O�L���I";exit;}$NextStatPt_De=$Game['defending']+1;CalcStatReq('DeAdd',"$NextStatPt_De");if ($Gen['growth']-$DeAdd_Stat_Req < 0){echo "�I�Ƥ����I";exit;}$Gen['growth']-=$DeAdd_Stat_Req;$Game['defending']=$NextStatPt_De;$ShowCompl="���m��O�ܦ� $Game[defending] �F�C";break;
	case 're': $stat_added = 'reacting';if ($Game['reacting'] >= 150){echo "��O�L���I";exit;}$NextStatPt_Re=$Game['reacting']+1; CalcStatReq('ReAdd',"$NextStatPt_Re");if ($Gen['growth']-$ReAdd_Stat_Req < 0){echo "�I�Ƥ����I";exit;}$Gen['growth']-=$ReAdd_Stat_Req;$Game['reacting'] =$NextStatPt_Re;$ShowCompl="�����ܦ� $Game[reacting] �F�C";break;
	case 'ta': $stat_added = 'targeting';if ($Game['targeting'] >= 150){echo "��O�L���I";exit;}$NextStatPt_Ta=$Game['targeting']+1;CalcStatReq('TaAdd',"$NextStatPt_Ta");if ($Gen['growth']-$TaAdd_Stat_Req < 0){echo "�I�Ƥ����I";exit;}$Gen['growth']-=$TaAdd_Stat_Req;$Game['targeting']=$NextStatPt_Ta;$ShowCompl="�R����O�ܦ� $Game[targeting] �F�C";break;
	case 'sp': $stat_added = 'spmax';if ($Gen['growth'] - $SP_Stat_Req < 0){echo "�I�Ƥ����I";exit;}$Gen['growth'] -= $SP_Stat_Req;$Game['spmax'] += 10;$ShowCompl="SP�W�[�F 10 �I�C";break;
	default : echo "���w�q�ާ@�I";
	}
	$sqlgen = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `growth` = '$Gen[growth]' WHERE `username` = '$Gen[username]' LIMIT 1;");
	mysql_query($sqlgen) or die ('�L�k���o�򥻸�T, ��]1:' . mysql_error() . '<br>' . postFooter());
	$sqlgame = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET ");
	$sqlgame .=("`$stat_added` = '$Game[$stat_added]' ");
	$sqlgame .=("WHERE `username` = '$Game[username]' LIMIT 1;");
	mysql_query($sqlgame) or die ('�L�k���o�C����T, ��]2:' . mysql_error() . '<br>' . postFooter());

	if ($Game_Scrn_Type == 1){
	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
	echo "<div align=left style=\"font-size: 16pt;height: 100%\">�����F�I<br>�{�b�A��$ShowCompl<br>";
	echo "<input type=submit value=\"��^\">";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</div>";
	echo "</form>";
	}
	elseif ($Game_Scrn_Type == 0) {
		$disableImg = "$General_Image_Dir/neo/plus_sign_grey.gif";
		echo "<script type=\"text/JavaScript\">";
		echo "parent.document.getElementById('pl_growth').innerHTML = ".$Gen['growth'].";";
		echo "parent.document.getElementById('".$stat_added."_addlink').style.visibility = 'visible';";
		if($stat_added != 'spmax'){
				CalcStatReq('New',$Game[$stat_added]+1);
				echo "parent.document.getElementById('pl_".$stat_added."').innerHTML = ".$Game[$stat_added].";";
				echo "parent.document.getElementById('pl_".$stat_added."').style.color = '".colorConvert($Game[$stat_added])."';";
			if($Game[$stat_added] < 150)
				echo "parent.document.getElementById('".$stat_added."_stat_req').innerHTML = ".$New_Stat_Req.";";
			echo "if (parseInt(parent.document.getElementById('attacking_stat_req').innerHTML) > parseInt(parent.document.getElementById('pl_growth').innerHTML || parseInt(parent.document.getElementById('pl_attacking').innerHTML) >= 150))";
			echo "{parent.document.getElementById('attacking_addlink').style.cursor = 'default';parent.document.getElementById('attacking_addlink').src = '$disableImg';}";
			echo "if (parseInt(parent.document.getElementById('defending_stat_req').innerHTML) > parseInt(parent.document.getElementById('pl_growth').innerHTML || parseInt(parent.document.getElementById('pl_defending').innerHTML) >= 150))";
			echo "{parent.document.getElementById('defending_addlink').style.cursor = 'default';parent.document.getElementById('defending_addlink').src = '$disableImg';}";
			echo "if (parseInt(parent.document.getElementById('reacting_stat_req').innerHTML) > parseInt(parent.document.getElementById('pl_growth').innerHTML || parseInt(parent.document.getElementById('pl_reacting').innerHTML) >= 150))";
			echo "{parent.document.getElementById('reacting_addlink').style.cursor = 'default';parent.document.getElementById('reacting_addlink').src = '$disableImg';}";
			echo "if (parseInt(parent.document.getElementById('targeting_stat_req').innerHTML) > parseInt(parent.document.getElementById('pl_growth').innerHTML || parseInt(parent.document.getElementById('pl_targeting').innerHTML) >= 150))";
			echo "{parent.document.getElementById('targeting_addlink').style.cursor = 'default';parent.document.getElementById('targeting_addlink').src = '$disableImg';}";
			if($Game[$stat_added] >= 150)
				echo "parent.document.getElementById('".$stat_added."_stat_req').innerHTML = 'N/A';";
		}else{
			echo "parent.document.getElementById('max_sp').innerHTML = parent.m_s = '".$Game['spmax']."';";
			echo "parent.document.getElementById('current_sp').innerHTML = parent.i_s = parent.s = ".$Game['sp'].";";
			echo "parent.sprate =". (0.004 * $Game['spmax']) .';';
		}
			echo "if (parseInt(document.getElementById('pl_growth').innerHTML) < $SP_Stat_Req)";
			echo "{parent.document.getElementById('spmax_addlink').style.cursor = 'default';parent.document.getElementById('spmax_addlink').src = '$disableImg';}";
		echo "</script>";
	}
}

//
// Mode: Modify MS HP/EN - View
//

function getHPModBasePrice($Current, $Default){
	global $Mod_HP_Cost, $Mod_HP_Cost;
	if($Current / $Default < 0.5){
		return $Current * 30 + $Mod_HP_Cost;
	}
	else{
		return $Current * 50 + $Mod_HP_UCost;
	}
}
function getENModBasePrice($Current, $Default){
	global $Mod_EN_Cost, $Mod_EN_Cost;
	$pc = $Current / $Default;
	if($pc < 0.25){
		return $Current * 150 + $Mod_EN_Cost;
	}
	elseif($Current / $Default < 0.5){
		return $Current * 300 + $Mod_EN_Cost;
	}
	elseif($Current / $Default < 0.75){
		return $Current * 600 + $Mod_EN_UCost;
	}
	else{
		return $Current * 1200 + $Mod_EN_UCost;
	}
}
function getExtStat($EqF){
	// Lended to equip.php
	$Ext = array('HP' => 0, 'EN' => 0);
	if ($EqF && $EqF != "0<!>0"){
		unset($Eq_Id,$Eq_Prep,$Eq_Query,$Eq,$a);
		$Eq_Id = explode('<!>',$EqF);
		$Eq_Prep = ("SELECT `spec` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` WHERE id='". $Eq_Id[0] ."'");
		$Eq_Query = mysql_query($Eq_Prep);
		$Eq = mysql_fetch_array($Eq_Query);
		if (preg_match('/ExtHP<([0-9]+)>/',$Eq['spec'],$a)){$Ext['HP'] += intval($a[1]);unset($a);}
		if (preg_match('/ExtEN<([0-9]+)>/',$Eq['spec'],$a)){$Ext['EN'] += intval($a[1]);unset($a);}
	}
}

if ($mode == 'modms'){
	echo "�����y<hr>";
	if(!$Gen['msuit']){echo "�A�S������I����i���y�u�{�I";exit;}

	echo "<br><table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#FFFFFF\" width=\"300\">";
	echo "<form action=statsmod.php?action=prcmodms method=post name=modmsform>";
	echo "<input type=hidden value='' name=actionb>";
	echo "<input type=hidden value='validcode2' name=slot_sw>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	GetMsDetails("$Gen[msuit]",'Pl_Ms');

	$Ext = array('HP' => 0, 'EN' => 0);
	$ExtTemp = getExtStat($Game['eqwep']);
	$Ext['HP'] += $ExtTemp['HP'];
	$Ext['EN'] += $ExtTemp['EN'];
	$ExtTemp = getExtStat($Game['p_equip']);
	$Ext['HP'] += $ExtTemp['HP'];
	$Ext['EN'] += $ExtTemp['EN'];
	
	$Game['hpmax'] -= $Ext['HP'];
	$Game['enmax'] -= $Ext['EN'];

	$HP_Mod_Base_Price = getHPModBasePrice($Game['hpmax'], $Pl_Ms['hpfix']);
	if ($HP_Mod_Base_Price > $Gen['cash']){
		$modhp_dis = 'disabled';
	}
	else{
		$modhp_dis = '';
	}

	$EN_Mod_Base_Price = getENModBasePrice($Game['enmax'], $Pl_Ms['enfix']);
	if ($EN_Mod_Base_Price > $Gen['cash']){
		$moden_dis = 'disabled';
	}
	else{
		$moden_dis='';
	}

	echo "<script langauge=\"Javascript\">";
	echo "function calchp(){";
	echo "var pricemt = document.modmsform.mod_hp_muiltiple.value;";
	echo "var price = pricemt * '$HP_Mod_Base_Price';";
	echo "hpmodprice.innerHTML = price;";
	echo "hpmodprice.style.color='blue';";
	echo "if (price > $Gen[cash]){hpmodprice.style.color='red';document.modmsform.hp_mod_submit.disabled=true;}";
	echo "else{document.modmsform.hp_mod_submit.disabled=false;}";
	echo "if (price == $Gen[cash]){hpmodprice.style.color='yellow';}";
	echo "}function calcen(){";
	echo "var pricemt = document.modmsform.mod_en_muiltiple.value;";
	echo "var price = pricemt * '$EN_Mod_Base_Price';";
	echo "enmodprice.innerHTML = price;";
	echo "enmodprice.style.color='blue';";
	echo "if (price > $Gen[cash]){enmodprice.style.color='red';document.modmsform.en_mod_submit.disabled=true;}";
	echo "else{document.modmsform.en_mod_submit.disabled=false;}";
	echo "if (price == $Gen[cash]){enmodprice.style.color='yellow';}}";
	echo "function returnCheckHP(){var resulthpadd=(document.modmsform.mod_hp_muiltiple.value)*100;";
	echo "if (hpmodprice.innerHTML > $Gen[cash]){alert('���������I');return false;}";
	echo "if (document.modmsform.mod_hp_muiltiple.value > 10){alert('���������I');return false;}";
	echo "if (confirm('��'+hpmodprice.innerHTML+'����y'+resulthpadd+'�IHP\\n�P�w�ܡH') == true){document.modmsform.actionb.value='hpmodding';return true;}else{return false;}";
	echo "}function returnCheckEN(){var resultenadd=(document.modmsform.mod_en_muiltiple.value)*10;";
	echo "if (enmodprice.innerHTML > $Gen[cash]){alert('���������I');return false;}";
	echo "if (document.modmsform.mod_en_muiltiple.value > 10){alert('���������I');return false;}";
	echo "if (confirm('��'+enmodprice.innerHTML+'����y'+resultenadd+'�IEN\\n�P�w�ܡH') == true){document.modmsform.actionb.value='enmodding';return true;}else{return false;}";
	echo "}</script>";
	echo "<tr align=center><td><b>�����y: </b></td></tr>";
	if($Game['hpmax'] + 1000 <= $Game['hpmax'] * $Max_HP){
		echo "<tr align=left>";
		echo "<td width=\"300\"><b>���[�˥�:</b><br>�C�I�[�@���W�[100�IHP<br>";
		echo "�һݪ���: $<span id=hpmodprice>$HP_Mod_Base_Price</span><br>";
		echo "��y����: <select size=1 name=\"mod_hp_muiltiple\" onChange=\"calchp()\">";
		echo "<option value='1'>1<option value='2'>2<option value='3'>3<option value='4'>4<option value='5'>5<option value='6'>6<option value='7'>7<option value='8'>8<option value='9'>9<option value='10'>10";
		echo "</select>��";
		echo "<input type=submit name=hp_mod_submit $modhp_dis value='�T�{��y' onClick=\"return returnCheckHP()\">";
		echo "</td>";
		echo "</tr>";
	}
	else echo "<tr align=left><td width=\"300\">�A�����餣��A�i����[�˥Ҥu�{�F�I<input type=hidden name=\"mod_hp_muiltiple\" value=1></td></tr>";
	if($Game['enmax'] + 100 < $Game['enmax'] * $Max_EN){
		echo "<tr align=left>";
		echo "<td width=\"300\"><b>���[�෽CAP:</b><br>�C�I�[�@���W�[10�IEN<br>";
		echo "�һݪ���: $<span id=enmodprice>$EN_Mod_Base_Price</span><br>";
		echo "��y����: <select size=1 name=\"mod_en_muiltiple\" onChange=\"calcen()\">";
		echo "<option value='1'>1<option value='2'>2<option value='3'>3<option value='4'>4<option value='5'>5<option value='6'>6<option value='7'>7<option value='8'>8<option value='9'>9<option value='10'>10";
		echo "</select>��";
		echo "<input type=submit name=en_mod_submit $modhp_dis value='�T�{��y' onClick=\"return returnCheckEN()\">";
		echo "</td>";
		echo "</tr>";
	}
	else echo "<tr align=left><td width=\"300\">�A�����餣��A�i��෽CAP�u�{�F�I<input type=hidden name=\"mod_en_muiltiple\" value=1></td></tr>";

	//MS Customization & Permanant Equipment
	echo "<tr align=left>";
	echo "<td width=\"300\"><b>�M�ΤƧ�y:</b><br>�M�ΤƧ�y�u�{�����ⶵ:<br>";
	echo "1: �򥻧�y�u�{<br>�@�@- �z�L�@�ǧ޳N, ��}����, ���ɪ���O<br>";
	echo "2: ����˳ƦX���u�{<br>�@�@- �⻲�U�˳�, �ä[�X���b����W<br>�@�@- �i�Ͼ���i�H�h���@�ػ��U�˳�<br>";
	echo "�ⶵ�u�{�L�������Y, �i�H�P�ɱĥ�, <Br>���C������C���u�{<b>�u��i��@��</b><br>";
	echo "<input type=submit name=ms_custom_submit value='�򥻧�y�u�{' onClick=\"modmsform.action='ms_custom.php?action=ms_custom';modmsform.actionb.value='GUI';\">";
	echo "<input type=submit name=ms_pequip_submit value='����˳ƦX���u�{' onClick=\"modmsform.action='ms_custom.php?action=ms_pequip';modmsform.actionb.value='GUI';\">";
	echo "</td>";
	echo "</tr>";

	echo "</form></table>";
postFooter();exit;
}

//
// Mode: Modify MS HP/EN - Process
//

elseif ($mode == 'prcmodms' && $actionb && $mod_hp_muiltiple && $mod_en_muiltiple){
if ($mod_hp_muiltiple > 10 || $mod_en_muiltiple > 10){echo "�@���L�̦h�u���Q��!!<br>";PostFooter();exit;}
if ($mod_hp_muiltiple <= 0 || $mod_en_muiltiple <= 0){echo "��y���ƥX�F���D!!<br>";PostFooter();exit;}
GetMsDetails("$Gen[msuit]",'Pl_Ms');

	$Ext = array('HP' => 0, 'EN' => 0);
	$ExtTemp = getExtStat($Game['eqwep']);
	$Ext['HP'] += $ExtTemp['HP'];
	$Ext['EN'] += $ExtTemp['EN'];
	$ExtTemp = getExtStat($Game['p_equip']);
	$Ext['HP'] += $ExtTemp['HP'];
	$Ext['EN'] += $ExtTemp['EN'];
	
	$Game['hpmax'] -= $Ext['HP'];
	$Game['enmax'] -= $Ext['EN'];

//
// Sub-action: HP Modding
//

if ($actionb == 'hpmodding'){
	
	$RealMax = $Max_HP * $Pl_Ms['hpfix'];
	
	if ($Game['hpmax'] >= $RealMax){echo "<center>HP��y�F��W���F�C<br></center>";PostFooter();exit;}

	$HP_Mod_Base_Price = getHPModBasePrice($Game['hpmax'], $Pl_Ms['hpfix']);
	
	$Mod_Cost = $mod_hp_muiltiple * $HP_Mod_Base_Price;
	$Mod_Amnt = $mod_hp_muiltiple * 100;
	
	if ($Gen['cash'] - $Mod_Cost < 0){echo "��������!!<br>";PostFooter();exit;}
	if ($Game['hpmax'] + $Mod_Amnt > $RealMax){
		$mod_hp_muiltiple = ceil(($RealMax - $Game['hpmax'])/100);
		$Mod_Cost = $mod_hp_muiltiple * $HP_Mod_Base_Price;
		$Mod_Amnt = $mod_hp_muiltiple * 100;
	}

	$Gen['cash'] -= $Mod_Cost;
	$Game['hpmax'] += $Mod_Amnt;
}

//
// Sub-action: EN Modding
//

if ($actionb == 'enmodding'){
	
	$RealMax = $Max_EN * $Pl_Ms['enfix'];
	
	if ($Game['enmax'] >= $RealMax){echo "<center>EN��y�F��W���F�C<br></center>";PostFooter();exit;}

	$EN_Mod_Base_Price = getENModBasePrice($Game['enmax'], $Pl_Ms['enfix']);

	$Mod_Cost = $mod_en_muiltiple * $EN_Mod_Base_Price;
	$Mod_Amnt = $mod_en_muiltiple * 10;
	
	if ($Gen['cash'] - $Mod_Cost < 0){echo "��������!!<br>";PostFooter();exit;}
	if ($Game['enmax'] + $Mod_Amnt > $RealMax){
		$mod_en_muiltiple = ceil(($RealMax - $Game['enmax'])/10);
		$Mod_Cost = $mod_en_muiltiple * $EN_Mod_Base_Price;
		$Mod_Amnt = $mod_en_muiltiple * 10;
	}

	$Gen['cash'] -= $Mod_Cost;
	$Game['enmax'] += $Mod_Amnt;
}

$Game['hpmax'] += $Ext['HP'];
$Game['enmax'] += $Ext['EN'];

$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `hpmax` = '".($Game['hpmax'])."', `enmax` = '".($Game['enmax'])."' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
mysql_query($sql) or die(mysql_error());

$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `cash` = '".($Gen['cash'])."' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
mysql_query($sql);

echo "<form action=statsmod.php?action=modms method=post name=frmmodms target=$SecTarget>";
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
echo "</form>";
echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
echo "<p align=center style=\"font-size: 16pt\">��y�����F�I<br><input type=submit value=\"��^\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
echo "</form>";
postFooter();
}

//
// Mode: Repair MS - View
//

elseif ($mode == 'repairms' && $actionb == 'sel'){

$War_State = checkWartime($Gen['coordinates']);

	$AreaORG_Prepare = ("SELECT `occupied` FROM `".$GLOBALS['DBPrefix']."phpeb_user_map` WHERE `map_id` = '$Gen[coordinates]'");
	$AreaORG_Query = mysql_query($AreaORG_Prepare) or die(mysql_error());
	$AreaORG = mysql_fetch_array($AreaORG_Query);
	$showOccupied = '';
	if ($Game['organization'] == $AreaORG['occupied']){
		$RepairHPCost = ceil($RepairHPCost * 0.5);
		$RepairENCost = ceil($RepairENCost * 0.5);
		$RepairEqCondCost = ceil($RepairEqCondCost * 0.5);
		$showOccupied = '���a�~����i�ɦ�50%�馩�u�f�C<br>';
	}

	echo "�ײz�u��<hr>";
	if (isset($Otp_TellTime) && $Otp_TellTime){echo "$Otp_TellTime<hr>";}
	if(!$Gen['msuit']){echo "<center>�A�S������I����i��ײz�I";exit;}
	echo "<br><table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#FFFFFF\" width=\"400\">";
	echo "<form action=statsmod.php?action=repairms method=post name=repairmsform>";
	echo "<input type=hidden value='reppro' name=actionb>";
	echo "<input type=hidden value='reppro' name=actionc>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "<tr align=center><td><b>�ײz����</b></td></tr>";
	GetMSDetails($Gen['msuit'],'NowMS');
	echo "<tr><td>�A������:<br><p align=center><img src='".$Unit_Image_Dir."/$NowMS[image]'><br>$NowMS[msname]</p>";
	echo "���u�����Զi��ɤ��|�}�ҡA".$showOccupied."�^�_�����p�U:<br>�^�_1�IHP�ݭn $RepairHPCost ���C<br>�^�_1�IEN�ݭn $RepairENCost ���C<br>�^�_ 0.01% �˳ƪ��A��, �򥻻��� $RepairEqCondCost ��, �è̷ӪZ�����ŤW�ջ���C";
	echo "</td></tr>";
	echo "<script langauge=\"Javascript\">function CheckRepHP(){if (hprepcost.innerHTML > $Gen[cash]){alert('���������I');return false;}if (confirm('�^�_HP�A�T�w�ײz�ܡH') == true){repairmsform.actionc.value='hprec';return true}else {return false}}";
	echo "function ChangePriceHP(typerepair){if (typerepair == 'pc'){var rephpamt = ($Game[hpmax] - document.getElementById('hp_show').innerHTML) * document.repairmsform.hp_rep_pc_amount.value ;document.getElementById('hppcrep').innerHTML = Math.round(rephpamt);var rehpprc = Math.round($RepairHPCost * rephpamt);";
	echo "document.getElementById('hprepcost').innerHTML = rehpprc;}if (typerepair == 'pt'){var rephpamt = document.repairmsform.hp_rep_amount.value;if (rephpamt > ($Game[hpmax] - document.getElementById('hp_show').innerHTML)){rephpamt = ($Game[hpmax] - document.getElementById('hp_show').innerHTML);}var rehpprc = Math.round($RepairHPCost * rephpamt);";
	echo "document.getElementById('hprepcost').innerHTML = rehpprc;}}function CheckEmergency(){if (".($EmergencyCost*$NowMS['needlv'])." > ".($Gen['cash'])."){alert('���������I');return false;}if (confirm('���X��, �T�w�ܡH') == true){document.repairmsform.actionc.value='emergency';return true}else {return false}}</script>";
	echo "<tr><td><b>�^�_HP:</b><br>HP: <span id=hp_show>$Game[hp]</span> / $Game[hpmax]";
	if ($Game['hp'] < $Game['hpmax']){
		if(!$War_State){
			echo "<br>�H�ʤ���^�_�l�U�� <input type=radio checked name='hp_rep_type' value='pc' OnClick=\"hp_rep_pc_amount.disabled=false;hp_rep_amount.disabled=true;hprepcost.innerHTML='0';hp_rep_pc_amount.value='0';\">: �^�_ <select name='hp_rep_pc_amount' onChange=\"ChangePriceHP('pc')\"><option value=0>--���--<option value=0.1>10%<option value=0.2>20%<option value=0.3>30%<option value=0.4>40%<option value=0.5>50%<option value=0.6>60%<option value=0.7>70%<option value=0.8>80%<option value=0.9>90%<option value=1.0 selected>100%</select>(<span id=hppcrep>0</span>�I)";
			echo "<br>��ʿ�J�^�_�q <input type=radio value='pt' name='hp_rep_type' OnClick=\"hp_rep_pc_amount.disabled=true;hp_rep_amount.disabled=false;hprepcost.innerHTML='0';hppcrep.innerHTML='0';\">: �^�_ <input type=text size=4 maxlength=5 name='hp_rep_amount' value=0 disabled onChange=\"ChangePriceHP('pt')\">�I";
			echo "<br>�һݪ���: <span id=hprepcost>0</span> ���C<br><input type=submit name=hp_rep_submit value='�^�_HP' onClick=\"return CheckRepHP();\">";
			
		}
		else	echo "<br>�@ - ��Զi�椤";
		if($Game['hp'] > $NowMS['hpfix']*0.8){
			echo "<br> - ���X��: ";
			echo "<br>�@- HP�F��즳�� 80% �� (".number_format(ceil($NowMS['hpfix']*0.8))."), ��Ͼ���i�J�i�o�i���A";
			echo "<br>�һݪ���: ".number_format($EmergencyCost*$NowMS['needlv'])." ���C<br><input type=submit name=hp_rep_submit value='���X��' onClick=\"return CheckEmergency();\">";
		}
		echo "</td></tr>";
	}else{echo "<br>�@ - �A�L�ݦ^�_HP</td></tr>";}
	echo "<script langauge=\"Javascript\">function CheckRepEN(){if (document.getElementById('enrepcost').innerHTML > $Gen[cash]){alert('���������I');return false;}if (confirm('�^�_EN�A�T�w�ײz�ܡH') == true){repairmsform.actionc.value='enrec';return true}else {return false}}";
	echo "function ChangePriceEN(typerepair){if (typerepair == 'pc'){var repenamt = ($Game[enmax] - document.getElementById('en_show').innerHTML) * document.repairmsform.en_rep_pc_amount.value ;document.getElementById('enpcrep').innerHTML = Math.round(repenamt);var reenprc = Math.round($RepairENCost * repenamt);";
	echo "document.getElementById('enrepcost').innerHTML = reenprc;}if (typerepair == 'pt'){var repenamt = document.repairmsform.en_rep_amount.value;if (repenamt > ($Game[enmax] - document.getElementById('en_show').innerHTML)){repenamt = ($Game[enmax] - document.getElementById('en_show').innerHTML);}var reenprc = Math.round($RepairENCost * repenamt);";
	echo "document.getElementById('enrepcost').innerHTML = reenprc;}}</script>";
	echo "<tr><td><b>�^�_EN:</b><br>EN: <span id=en_show>$Game[en]</span> / $Game[enmax]";
	if($War_State){echo "<br>�@ - ��Զi�椤</td></tr>";}
	elseif ($Game['en'] < $Game['enmax']){
	echo "<br>�H�ʤ���^�_�l�U�� <input type=radio checked name='en_rep_type' value='pc' OnClick=\"en_rep_pc_amount.disabled=false;en_rep_amount.disabled=true;document.getElementById('enrepcost').innerHTML='0';en_rep_pc_amount.value='0';\">: �^�_ <select name='en_rep_pc_amount' onChange=\"ChangePriceEN('pc')\"><option value=0>--���--<option value=0.1>10%<option value=0.2>20%<option value=0.3>30%<option value=0.4>40%<option value=0.5>50%<option value=0.6>60%<option value=0.7>70%<option value=0.8>80%<option value=0.9>90%<option value=1.0 selected>100%</select>(<span id=enpcrep>0</span>�I)";
	echo "<br>��ʿ�J�^�_�q <input type=radio value='pt' name='en_rep_type' OnClick=\"en_rep_pc_amount.disabled=true;en_rep_amount.disabled=false;document.getElementById('enrepcost').innerHTML='0';document.getElementById('enpcrep').innerHTML='0';\">: �^�_ <input type=text size=4 maxlength=5 name='en_rep_amount' value=0 disabled onChange=\"ChangePriceEN('pt')\">�I";
	echo "<br>�һݪ���: <span id=enrepcost>0</span> ���C<br><input type=submit name=en_rep_submit value='�^�_EN' onClick=\"return CheckRepEN();\">";
	echo "</td></tr>";
	}else{echo "<br>�@ - �A�L�ݦ^�_EN</td></tr>";}
		//���A�Ȭ���
			//echo "<input type=hidden name=cond_pos value=0>";
			echo "<script language=\"Javascript\">function CheckCond(pos,cost){";
			echo "if (cost > $Gen[cash]){alert('���������I');return false;}";
			echo "if (confirm('�T�w�^�_���A�ȶܡH') == true){repairmsform.actionb.value='eq_condrep';repairmsform.actionc.value=pos;return true}else {return false}";
			echo "}</script>";
			//Process All Weapons
				$Id_Phrase = '';
				for($i=1;$i <= 5;$i++){
				switch($i){
					case 1: $W_Slot = $Game['wepa']; break;
					case 2: $W_Slot = $Game['wepb']; break;
					case 3: $W_Slot = $Game['wepc']; break;
					case 4: $W_Slot = $Game['eqwep']; break;
					case 5: $W_Slot = $Game['p_equip']; break;
				}
				$W_Params[$i] = explode('<!>',$W_Slot);
				$Id_Phrase .= ($i == 5) ? 'id =\''. $W_Params[$i][0] .'\'' : 'id =\''. $W_Params[$i][0] .'\' OR ';
				unset($W_Slot);
				}

				$SQL = ("SELECT `id`,`name`,`complexity` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` WHERE " . $Id_Phrase);
				$Query = mysql_query($SQL);

				$j = 0;
				while($Weapon = mysql_fetch_array($Query)) {$Weapon_Raw[$j] = $Weapon; $j++;}

				for($k=1;$k<=5;$k++){
				$A = 'wepa';
				switch($k){
					case 2: $A = 'wepb';break;
					case 3: $A = 'wepc';break;
					case 4: $A = 'eqwep';break;
					case 5: $A = 'p_equip';break;
				}
					for($l=0;$l < $j;$l++) {
						if ($W_Params[$k][0] != $Weapon_Raw[$l]['id']) continue;
						$EqD[$A] = $Weapon_Raw[$l];
					}

				$EqD[$A]['exp']=$W_Params[$k][1];
				$EqD[$A]['pos']=$A;
				$W_Params[$k][2] = ( isset($W_Params[$k][2]) ) ? $W_Params[$k][2] : 0;
					if ($W_Params[$k][2]){
						if ($W_Params[$k][2] == 1) $EqD[$A]['name'] = $W_Params[$k][3].$EqD[$A]['name']."<sub>&copy;</sub>";
						else $EqD[$A]['name'] = $EqD[$A]['name'].$W_Params[$k][3]."<sub>&copy;</sub>";
					}
				}
			//End of Processing
			//UI
			echo "<tr><td><b>�^�_�Z�����A��:</b><br>";
			$i = 0;
			foreach($EqD as $e) {
				if($e['exp'] < $RepairEqCondMax){
					$DisplayXp = ($e['exp'] >= 0) ? '+'.($e['exp']/100) : ($e['exp']/100);
					$CondRepCost = ($RepairEqCondMax - $e['exp'])*$RepairEqCondCost*($e['complexity']+1);
					echo $e['name'].":<br>�@ - ���A��: <font color=red> ".$DisplayXp.'%</font><br>';
					echo "�@ - �һݪ���: ".number_format($CondRepCost)." ���C<Br>";
					echo "�@ - <input type=submit name=en_rep_submit value='�ײz���Z��' onClick=\"return CheckCond('".$e['pos']."',$CondRepCost);\"><br>";
				}else $i++;
			}
			if ($i == 5) echo "�@ - �S���i�^�_���A�Ȫ��Z��";
			echo "</td></tr>";


	echo "<script language=\"JavaScript\">";
	echo "fetchInstantStat();";
	echo "function fetchInstantStat(){";
	echo "document.getElementById('en_show').innerHTML = parent.document.getElementById('current_en').innerHTML;";
	echo "if(document.repairmsform.en_rep_type != null) if(document.repairmsform.en_rep_type[0].checked) ChangePriceEN('pc');";
	echo "document.getElementById('hp_show').innerHTML = parent.document.getElementById('current_hp').innerHTML;";
	echo "if(document.repairmsform.hp_rep_type != null) if(document.repairmsform.hp_rep_type[0].checked) ChangePriceHP('pc');";
	echo "setTimeout(\"fetchInstantStat()\",100);";
	echo "}";
	echo "</script>";


	echo "</form></table>";
postFooter();exit;
}//End Repair Form

//
// Mode: Repair MS - Process
//

elseif ($mode == 'repairms' && $actionb == 'reppro'){

	$War_State = checkWartime($Gen['coordinates']);

	if(($actionc == 'hprec' || $actionc == 'enrec') && $War_State){
		echo "��Զi�椤, �L�k�i��ײz�I";
		postFooter();
		exit;
	}

	$AreaORG_Prepare = ("SELECT `occupied` FROM `".$GLOBALS['DBPrefix']."phpeb_user_map` WHERE `map_id` = '$Gen[coordinates]'");
	$AreaORG_Q = mysql_query($AreaORG_Prepare) or die(mysql_error());
	$AreaORG = mysql_fetch_array($AreaORG_Q);
	if ($Game['organization'] == $AreaORG['occupied']){
		$RepairHPCost = ceil($RepairHPCost * 0.5);
		$RepairENCost = ceil($RepairENCost * 0.5);
	}

		$plr = array(
		"name" => $Pl_Value['USERNAME'],
		"hp" => $Game['hp'],
		"hpmax" => $Game['hpmax'],
		"en" => $Game['en'],
		"enmax" => $Game['enmax'],
		"sp" => $Game['sp'],
		"spmax" => $Game['spmax'],
		"status" => $Game['status'],
		"msuit" => $Gen['msuit'],
		"time1" => $Gen['time1'],
		"hypermode" => $Gen['hypermode'],
		"eqwep" => $Game['eqwep'],
		"p_equip" => $Game['p_equip']);
		$Pl_Repaired = RepairPlayer($plr,0,0,1);
	$Game['hp'] = $Pl_Repaired['hp'];
	$Game['en'] = $Pl_Repaired['en'];
	$Game['sp'] = $Pl_Repaired['sp'];
	$Game['status'] = $Pl_Repaired['status'];
	$Gen['time1'] = $Pl_Repaired['time1'];

	$RepairAmt=0;$PriceRepair=0;
	if ($actionc == 'hprec' && ($Game['hpmax'] != $Game['hp'])){
		if ($hp_rep_type == 'pc'){if ($hp_rep_pc_amount > 1.0 || $hp_rep_pc_amount <= 0 ){echo "�^�_�q�X��";postFooter();exit;}$RepairAmt = floor(($Game['hpmax'] - $Game['hp']) * $hp_rep_pc_amount);if ($RepairAmt > ($Game['hpmax'] - $Game['hp']))$RepairAmt = ($Game['hpmax'] - $Game['hp']);
		$PriceRepair = floor($RepairAmt * $RepairHPCost);
		}elseif ($hp_rep_type == 'pt'){
		if ($hp_rep_amount > $Game['hpmax'] || $hp_rep_amount <= 0 ){echo "�^�_�q�X��";postFooter();exit;}
		$RepairAmt = $hp_rep_amount; if ($RepairAmt > ($Game['hpmax'] - $Game['hp']))$RepairAmt = ($Game['hpmax'] - $Game['hp']);
		$PriceRepair = floor($RepairAmt * $RepairHPCost);
		}else {echo "���������O�I";postFooter();exit;}
		if ($PriceRepair < 0)$PriceRepair = 0;
		if ($Gen['cash'] - $PriceRepair < 0){echo "���������I";postFooter();exit;}
		$Gen['cash'] -= $PriceRepair;
		$Game['hp'] += $RepairAmt;
		if ($Game['hp'] > $Game['hpmax'])$Game['hp'] = $Game['hpmax'];
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `hp` = '$Game[hp]', `en` = '$Game[en]', `sp` = '$Game[sp]', `status` = '$Game[status]' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
		mysql_query($sql) or die (mysql_error());
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `cash` = '$Gen[cash]', `time1` = '$Gen[time1]' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
		mysql_query($sql) or die (mysql_error());
		if($Use_Behavior_Checker){
			$sql = "UPDATE `{$GLOBALS[DBPrefix]}phpeb_behaviour_check` SET `last_rtime` = {$GLOBALS[CFU_Time]} WHERE `username` = '{$Pl_Value[USERNAME]}';";
			$query = mysql_query($sql) or die('Behavior Checker Error! Cannot Update RTime!');
		}
		$RepMsg = "�H $PriceRepair ���^�_�F $RepairAmt �IHP�C";
		}
	elseif ($actionc == 'hprec' && ($Game['hpmax'] <= $Game['hp'])){echo "HP�w�g���F�I";postFooter();exit;}
	elseif ($actionc == 'enrec' && ($Game['enmax'] != $Game['en'])){
		if ($en_rep_type == 'pc'){if ($en_rep_pc_amount > 1.0 || $en_rep_pc_amount <= 0 ){echo "�^�_�q�X��";postFooter();exit;}$RepairAmt = floor(($Game['enmax'] - $Game['en']) * $en_rep_pc_amount);if ($RepairAmt > ($Game['enmax'] - $Game['en']))$RepairAmt = ($Game['enmax'] - $Game['en']);
		$PriceRepair = floor($RepairAmt * $RepairENCost);
		}elseif ($en_rep_type == 'pt'){
		if ($en_rep_amount > $Game['enmax'] || $en_rep_amount <= 0 ){echo "�^�_�q�X��";postFooter();exit;}
		$RepairAmt = $en_rep_amount; if ($RepairAmt > ($Game['enmax'] - $Game['en']))$RepairAmt = ($Game['enmax'] - $Game['en']);
		$PriceRepair = floor($RepairAmt * $RepairENCost);
		}else {echo "���������O�I";postFooter();exit;}
		if ($PriceRepair < 0)$PriceRepair = 0;
		if ($Gen['cash'] - $PriceRepair < 0){echo "���������I";postFooter();exit;}
		$Gen['cash'] -= $PriceRepair;
		$Game['en'] += $RepairAmt;
		if ($Game['en'] > $Game['enmax'])$Game['en'] = $Game['enmax'];
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `hp` = '$Game[hp]', `en` = '$Game[en]', `sp` = '$Game[sp]', `status` = '$Game[status]' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
		mysql_query($sql) or die (mysql_error());
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `cash` = '$Gen[cash]', `time1` = '$Gen[time1]' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
		mysql_query($sql) or die (mysql_error());
		$RepMsg = "�H $PriceRepair ���^�_�F $RepairAmt �IEN�C";
		}
	elseif ($actionc == 'enrec' && ($Game['enmax'] <= $Game['en'])){echo "EN�w�g���F�I";postFooter();exit;}
	elseif ($actionc == 'emergency'){
		GetMSDetails($Gen['msuit'],'NowMS');
		$PriceRepair = $EmergencyCost*$NowMS['needlv'];
		if($Game['hp'] < $NowMS['hpfix']*0.8){echo "HP�����I ������X���I";postFooter();exit;}
		if ($Gen['cash'] - $PriceRepair < 0){echo "���������I";postFooter();exit;}
		$Gen['cash'] -= $PriceRepair;
		$Game['status'] = 0;
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `hp` = '$Game[hp]', `en` = '$Game[en]', `sp` = '$Game[sp]', `status` = '0' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
		mysql_query($sql) or die (mysql_error());
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `cash` = '$Gen[cash]', `time1` = '$Gen[time1]' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
		mysql_query($sql) or die (mysql_error());
		$RepMsg = "�{�b�i�H�X���F�I";
	}
	else {echo "HP/EN�w�g���F�I";postFooter();exit;}

	if ($Game_Scrn_Type == 0) {
		echo "<script language=\"JavaScript\">";
		echo "TheNewDate = new Date();";
		echo "parent.r_h = parent.r_e = 0;";
		echo "parent.m_time = parent.mh_time = parent.me_time = TheNewDate.getTime();";
		echo "parent.document.getElementById('current_hp').innerHTML = parent.i_h = parent.h = ".$Game['hp'].";";
		echo "parent.document.getElementById('current_en').innerHTML = parent.i_e = parent.e = ".$Game['en'].";";
		if ($Game['status'] == '1') echo "parent.document.getElementById('status_now').innerHTML = '�ײz�i�椤';parent.document.getElementById('status_now').style.color='#FF2200';";
		else echo " parent.document.getElementById('status_now').innerHTML='�o�i�n���i��';parent.document.getElementById('status_now').style.color='#016CFE';";
		echo "parent.document.getElementById('pl_cash').innerHTML = '".number_format($Gen['cash'])."';";
		if ($Gen['fame'] >= 0)
		echo "parent.document.getElementById('type_fame').innerHTML = '�W�n';";
		else echo "parent.document.getElementById('type_fame').innerHTML = '�c�W';";
		echo "parent.document.getElementById('pl_fame').innerHTML = '".abs($Gen['fame'])."';";
		echo "</script>";
	}

echo "<form action=statsmod.php?action=repairms method=post name=frmrp target=$SecTarget>";
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=hidden value='sel' name=actionb>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
echo "<p align=center style=\"font-size: 16pt\"><br><br><br><br>$RepMsg<br><input type=button value=\"����������\" onClick=\"parent.$SecTarget.location.replace('about:blank');parent.document.getElementById('STiF').style.left = -1150;\"><input type=submit value=\"�~��ײz\">";
echo "</form>";
echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=submit value=\"���s��z\" onClick=\"parent.$SecTarget.location.replace('about:blank')\">";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
echo "</form>";

postFooter();exit;

}//End Repair Mode

//
// Mode: Condition Repairing - Process
//

elseif ($mode == 'repairms' && $actionb == 'eq_condrep'){

$War_State = checkWartime($Gen['coordinates']);

$AreaORG_Prepare = ("SELECT `occupied` FROM `".$GLOBALS['DBPrefix']."phpeb_user_map` WHERE `map_id` = '$Gen[coordinates]'");
$AreaORG_Query = mysql_query($AreaORG_Prepare) or die(mysql_error());
$AreaORG = mysql_fetch_array($AreaORG_Query);
$showOccupied = '';
if ($Game['organization'] == $AreaORG['occupied']) $RepairEqCondCost = ceil($RepairEqCondCost * 0.5);
	//Process All Weapons
		$Id_Phrase = '';
		for($i=1;$i <= 5;$i++){
		switch($i){
			case 1: $W_Slot = $Game['wepa']; break;
			case 2: $W_Slot = $Game['wepb']; break;
			case 3: $W_Slot = $Game['wepc']; break;
			case 4: $W_Slot = $Game['eqwep']; break;
			case 5: $W_Slot = $Game['p_equip']; break;
		}
		$W_Params[$i] = explode('<!>',$W_Slot);
		$Id_Phrase .= ($i == 5) ? 'id =\''. $W_Params[$i][0] .'\'' : 'id =\''. $W_Params[$i][0] .'\' OR ';
		unset($W_Slot);
		}

		$SQL = ("SELECT `id`,`name`,`complexity` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` WHERE " . $Id_Phrase);
		$Query = mysql_query($SQL);

		$j = 0;
		while($Weapon = mysql_fetch_array($Query)) {$Weapon_Raw[$j] = $Weapon; $j++;}

		$A = 'wepa';$EqmCondDis='EqmExp_A';
		for($k=1;$k<=5;$k++){
		switch($k){
			case 2: $A = 'wepb';$EqmCondDis='EqmExp_B';break;
			case 3: $A = 'wepc';$EqmCondDis='EqmExp_C';break;
			case 4: $A = 'eqwep';$EqmCondDis='EqmExp_D';break;
			case 5: $A = 'p_equip';$EqmCondDis='EqmExp_E';break;
		}
			for($l=0;$l < $j;$l++) {
				if ($W_Params[$k][0] != $Weapon_Raw[$l]['id']) continue;
				$EqD[$A] = $Weapon_Raw[$l];
			}

		$EqD[$A]['exp']=$W_Params[$k][1];
		$EqD[$A]['pos']=$A;
		$EqD[$A]['txt']=$EqmCondDis;
		$W_Params[$k][2] = ( isset($W_Params[$k][2]) ) ? $W_Params[$k][2] : 0;
			if ($W_Params[$k][2]){
				if ($W_Params[$k][2] == 1) $EqD[$A]['name'] = $W_Params[$k][3].$EqD[$A]['name']."<sub>&copy;</sub>";
				else $EqD[$A]['name'] = $EqD[$A]['name'].$W_Params[$k][3]."<sub>&copy;</sub>";
			}
		}
	//End of Processing

$Error_Flag = 0;
$CondRepCost = -1;
$DisMaxXp = '';
if($RepairEqCondMax == 0) $DisMaxXp = "��0%";
else $DisMaxXp = ($RepairEqCondMax >= 0) ? '+'.$RepairEqCondMax.'%' : $RepairEqCondMax.'%';

$isValidSlot = ($actionc == 'wepa' || $actionc == 'wepb' || $actionc == 'wepc' || $actionc == 'eqwep' || $actionc == 'p_equip');
if (!$isValidSlot) {$RepMsg = "��m�X���I<br>";$Error_Flag = 1;}
else {
	$CondRepCost = ($RepairEqCondMax - $EqD[$actionc]['exp'])*$RepairEqCondCost*($EqD[$actionc]['complexity']+1);
	if ($EqD[$actionc]['exp'] >= $RepairEqCondMax) {$RepMsg = "���A�ȹL���I<br>";$Error_Flag = 1;}
	elseif ($CondRepCost > $Gen['cash'] || $CondRepCost < 0) {$RepMsg = "�Яd�N�@�U�����I<br>";$Error_Flag = 1;}
	else $RepMsg = $EqD[$actionc]['name'].' ���ײz�����F�I<br>���A�Ȧ^�_�� '.$DisMaxXp;
}

if ($Error_Flag === 0){
	$Gen['cash'] -= $CondRepCost;
	//Update Weapon Info
		$Eq_Update = explode('<!>',$Game[$actionc]);
		$Eq_Update[1] = $RepairEqCondMax;
		$Game[$actionc] = implode('<!>',$Eq_Update);
	//Update Database
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `$actionc` = '$Game[$actionc]' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
	mysql_query($sql) or die (mysql_error());
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `cash` = '$Gen[cash]' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
	mysql_query($sql) or die (mysql_error());
}
echo "<script language=\"Javascript\">";
echo "parent.document.getElementById('pl_cash').innerHTML = '".number_format($Gen['cash'])."';";
echo "parent.document.getElementById('".$EqD[$actionc]['txt']."').innerHTML = '".$DisMaxXp."';";
echo "</script>";
echo "<form action=statsmod.php?action=repairms method=post name=frmrp target=$SecTarget>";
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=hidden value='sel' name=actionb>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
echo "<p align=center style=\"font-size: 16pt\"><br><br><br><br>$RepMsg<br><br><input type=button value=\"����������\" onClick=\"parent.$SecTarget.location.replace('about:blank');parent.document.getElementById('STiF').style.left = -1150;\"><input type=submit value=\"�~��ײz\">";
echo "</form>";
echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=submit value=\"���s��z\" onClick=\"parent.$SecTarget.location.replace('about:blank')\">";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
echo "</form>";

postFooter();
exit;
}
//End Condition Repairing Mode

//
// Mode: Character Type - View
//

elseif ($mode == 'modtypech' && $actionb == 'A'){
	echo "�H�ا�y<hr>";
	if($Gen['typech'] != 'nat'){echo "�A���O�@��H�I����i���y�I";exit;}

	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#FFFFFF\" width=\"300\">";

	echo "<form action=statsmod.php?action=modtypech method=post name=modchform>";
	echo "<input type=hidden value='B' name=actionb>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

	echo "<script langauge=\"Javascript\">function cfmModCh(){";
	echo "if ($Gen[cash] < $ModChType_Cost) {alert('�{������!!');return false;}";
	echo "else if (confirm('�u���n�i���y�ܡH') == true) {return true;} else {return false;}";
	echo "}</script>";

	echo "<tr><td align=center><b>�H�ا�y</b></td></tr>";
	echo "<tr><td>";
	echo "<b>²��:</b><br>�H�ا�y�O�@�Ӭ�����(Type)�� �@��(Natural) ���H�A<br>��y����A�Ϧۤv����:<br><br>1. Enhanced (�j�ƤH��)<br>��<br>2. Extended (�����H)<br>";
	echo "<br>��y������n�B�H<br>�ݧA�|���|�{��Enhanced��Extended��@��H�j�a�I<Br>���к�O�A�@�g��y�A�L�k�٭�A��L�k�A��y�I";
	echo "</td></tr>";

	echo "<tr><td>";
	echo "<b>�H�ا�y:</b><br>";
	echo "��y��:<br>";
	echo "<input type=radio name=dtype value=1 checked> Enhanced (�j�ƤH��)<br><input type=radio name=dtype value=2> Extended (�����H)<br>";
	echo "<b>�O��:</b> ".number_format($ModChType_Cost)." ��<br>";
	echo "</td></tr>";
	echo "<tr><td align=center>";
	echo "<input type=submit value=��y�T�w onClick=\"return cfmModCh();\">";
	echo "</td></tr>";

	echo "</form></table>";
postFooter();exit;
}

//
// Mode: Character Type - Process
//

elseif ($mode == 'modtypech' && $actionb == 'B'){
	echo "�H�ا�y<hr>";
	$Dest_Type = $ModChMsg = (string) '';
	switch($dtype){
		case 1: $Dest_Type = 'enh'; $ModChMsg = '�j�ƤH��';break;
		case 2: $Dest_Type = 'ext'; $ModChMsg = 'Extended';break;
		default: echo "�ؼФH�إX��!!";exit;
	}
	if($Gen['typech'] != 'nat'){echo "�A���O�@��H�I����i���y�I";exit;}
	else {
		if($Gen['cash'] < $ModChType_Cost){echo "�{������!!";exit;}
		else {
			$Gen['cash'] -= $ModChType_Cost;
			$Gen['typech'] = $Dest_Type;
			$SQL = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `cash` = '$Gen[cash]', `typech` = '$Gen[typech]', `hypermode` = 0 ");
			$SQL .= ("WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
			mysql_query($SQL) or die(mysql_error());
		}

	}

echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
echo "<p align=center style=\"font-size: 16pt\">��y�����F�I<br>�A�w��y�� $ModChMsg �I<br><input type=submit value=\"��^\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
echo "</form>";
postFooter();exit;
}
//End Character Type Modding

//
// Mode: Custom
//

elseif ($mode == 'custom'){
$IncThread = "mscust_200804221814";
include('ms_custom.php');
}
?>