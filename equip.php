<?php
$mode = ( isset($_GET['action']) ) ? $_GET['action'] : $_POST['action'];
include('cfu.php');
if (empty($PriTarget)) $PriTarget = 'Alpha';
if (empty($SecTarget)) $SecTarget = 'Beta';
postHead('');
AuthUser("$Pl_Value[USERNAME]","$Pl_Value[PASSWORD]");
if ($CFU_Time >= $TIMEAUTH+$TIME_OUT_TIME || $TIMEAUTH <= $CFU_Time-$TIME_OUT_TIME){echo "�s�u�O�ɡI<br>�Э��s�n�J�I";exit;}
if ($mode == 'equip'){
include('equip_wep.php');
}//equipwep
elseif ($mode == 'equipwep' && $actionb == 'equip'){
GetUsrDetails("$Pl_Value[USERNAME]",'','GameVal');

$actionc = ( isset($_GET['actionc']) ) ? $_GET['actionc'] : $_POST['actionc'];
$Setting_Selection = ($actionc == 'rt_equip') ? '' : '`gen_img_dir`,`unit_img_dir`,`base_img_dir`,';

$Pl_Settings_Query = ("SELECT ".$Setting_Selection."`btltime` FROM `".$GLOBALS['DBPrefix']."phpeb_user_settings` s,`".$GLOBALS['DBPrefix']."phpeb_user_general_info` g WHERE s.username='". $GameVal['username'] ."' AND s.username=g.username");
$Pl_Settings = mysql_fetch_array(mysql_query ($Pl_Settings_Query));
$t_now = time();

if ($Pl_Settings['btltime'] == $t_now){echo "�ʧ@���X�z�L�֡A�j���B�@1�p�ɡC";postFooter();mysql_query("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `btltime` = ".intval($t_now+3600)." WHERE `username` = '$GameVal[username]' LIMIT 1;");exit;}
elseif ($t_now - $Pl_Settings['btltime'] <= 1){echo "�ʧ@�L�֡C";postFooter();mysql_query("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `btltime` = ".intval($t_now+3)." WHERE `username` = '$GameVal[username]' LIMIT 1;");sleep(3);exit;}

if($actionc != 'rt_equip'){
	//Adjust to user's setting
	if ($Pl_Settings['gen_img_dir'])
	$General_Image_Dir = $Pl_Settings['gen_img_dir'];
	if ($Pl_Settings['unit_img_dir'])
	$Unit_Image_Dir = $Pl_Settings['unit_img_dir'];
	if ($Pl_Settings['base_img_dir'])
	$Base_Image_Dir = $Pl_Settings['base_img_dir'];
}

if (isset($GameVal[$slot_sw])){
if($slot_sw != 'wepb' && $slot_sw != 'wepc'){echo "���w�q���ʧ@�C";postFooter();exit;}
$O_Wep = $GameVal['wepa'];
$GameVal['wepa'] = $GameVal[$slot_sw];
$GameVal[$slot_sw] = $O_Wep;}
else {echo "���w�q���ʧ@�C";postFooter();exit;}

$UsrWepA = explode('<!>',$GameVal['wepa']);
$UsrWepS = explode('<!>',$GameVal[$slot_sw]);

GetWeaponDetails("$UsrWepA[0]",'SysWepE_A');
$UsrWepA[2] = (isset($UsrWepA[2])) ? $UsrWepA[2]: 0;
if ($UsrWepA[2]){
if ($UsrWepA[2]==1) $SysWepE_A['name'] = $UsrWepA[3].$SysWepE_A['name']."<sub>&copy;</sub>";
else $SysWepE_A['name'] = $SysWepE_A['name'].$UsrWepA[3]."<sub>&copy;</sub>";
$SysWepE_A['atk'] += $UsrWepA[4];
$SysWepE_A['hit'] += $UsrWepA[5];
$SysWepE_A['rd'] += $UsrWepA[6];
$SysWepE_A['enc'] = $UsrWepA[7];
}
GetWeaponDetails("$UsrWepS[0]",'SysWepE_S');
$UsrWepS[2] = (isset($UsrWepS[2])) ? $UsrWepS[2]: 0;
if ($UsrWepS[2]){
if ($UsrWepS[2]==1) $SysWepE_S['name'] = $UsrWepS[3].$SysWepE_S['name']."<sub>&copy;</sub>";
else $SysWepE_S['name'] = $SysWepE_S['name'].$UsrWepS[3]."<sub>&copy;</sub>";
$SysWepE_S['atk'] += $UsrWepS[4];
$SysWepE_S['hit'] += $UsrWepS[5];
$SysWepE_S['rd'] += $UsrWepS[6];
$SysWepE_S['enc'] = $UsrWepS[7];
}

if ($UsrWepA[1] > 0) $DisplayXp['A'] = '+'.($UsrWepA[1]/100).'%';
elseif ($UsrWepA[1] < 0) $DisplayXp['A'] = ($UsrWepA[1]/100).'%';
else $DisplayXp['A'] = '��0%';

if ($UsrWepS[1] > 0) $DisplayXp['S'] = '+'.($UsrWepS[1]/100).'%';
elseif ($UsrWepS[1] < 0) $DisplayXp['S'] = ($UsrWepS[1]/100).'%';
else $DisplayXp['S'] = '��0%';

//Update Information
$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `wepa` = '$GameVal[wepa]', `wepb` = '$GameVal[wepb]', `wepc` = '$GameVal[wepc]', `eqwep` = '$GameVal[eqwep]' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
mysql_query($sql);

$s = ($slot_sw == 'wepb') ? 'B' : 'C';

//JS Auto-Update
echo "<script language=\"JavaScript\">";
echo "parent.document.getElementById('EqmExp_A').innerHTML = '".$DisplayXp['A']."';";
echo "parent.document.getElementById('EqmExp_".$s."').innerHTML = '".$DisplayXp['S']."';";

echo "parent.document.getElementById('EqmName_A').innerHTML = '".$SysWepE_A['name']."';";
echo "parent.document.getElementById('EqmName_".$s."').innerHTML = '".$SysWepE_S['name']."';";

$Inf['A'] = "�˳Ư�O:<br>";
$Inf['A'] .= "�@�����O: ".$SysWepE_A['atk']."�@�@�@�^��: ".$SysWepE_A['rd']."<br>�@�R��: ".$SysWepE_A['hit']."�@�@�@EN���O: <span id=EqmEnc_A>".$SysWepE_A['enc']."</span><br>";
$Inf['A'] .= "�S��ĪG:<br>";
if ($SysWepE_A['equip']) $Inf['A'] .= "�i�H�˳�<br>";
if ($SysWepE_A['spec']) $Inf['A'] .= ReturnSpecs($SysWepE_A['spec']);
if (!$SysWepE_A['spec'] && !$SysWepE_A['equip']) $Inf['A'] .= "�S��";

$Inf['S'] = "�˳Ư�O:<br>";
$Inf['S'] .= "�@�����O: ".$SysWepE_S['atk']."�@�@�@�^��: ".$SysWepE_S['rd']."<br>�@�R��: ".$SysWepE_S['hit']."�@�@�@EN���O: <span id=EqmEnc_".$s.">".$SysWepE_S['enc']."</span><br>";
$Inf['S'] .= "�S��ĪG:<br>";
if ($SysWepE_S['equip']) $Inf['S'] .= "�i�H�˳�<br>";
if ($SysWepE_S['spec']) $Inf['S'] .= ReturnSpecs($SysWepE_S['spec']);
if (!$SysWepE_S['spec'] && !$SysWepE_S['equip']) $Inf['S'] .= "�S��";

echo "parent.document.getElementById('EqmDis_A').innerHTML = \"".$Inf['A']."\";";
echo "parent.document.getElementById('EqmDis_".$s."').innerHTML = \"".$Inf['S']."\";";

if(canEquipAsWep($SysWepE_S))
	echo "parent.document.getElementById('EqW_btn_".$s."').innerHTML = \"(�˳Ʀ��Z��)\";";
else	echo "parent.document.getElementById('EqW_btn_".$s."').innerHTML = '';";

if ($SysWepE_S['equip'])
	echo "parent.document.getElementById('EqE_btn_".$s."').innerHTML = \"(�ˤW���U�˳�)\";";
else	echo "parent.document.getElementById('EqE_btn_".$s."').innerHTML = '';";

echo "</script>";

if($actionc == 'rt_equip') exit;
echo "<form action=equip.php?action=equip method=post name=frmeq target=$SecTarget>";
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
echo "</form>";
echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
echo "<p align=center style=\"font-size: 16pt\">�˳Ƨ����F�I<br><input type=submit value=\"��^\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"><input type=button value=\"�~��˳�\" onClick=\"frmeq.submit()\"></p>";
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
echo "</form>";
postFooter();

}

elseif ($mode == 'buywep' && $actionb == 'process'){
GetUsrDetails("$Pl_Value[USERNAME]",'GenVal','GameVal');
GetWeaponDetails("$BuyWepDesired",'BuyWepS');
$UsrWepA = explode('<!>',$GameVal['wepa']);
$UsrWepB = explode('<!>',$GameVal['wepb']);
$UsrWepC = explode('<!>',$GameVal['wepc']);
$ERROR_Buy_Wep = '';$Pos_Flag='';
if ($GenVal['cash'] - $BuyWepS['price'] < 0){echo "��������!!<br>";PostFooter();exit;}
if ($BuyWepS['buy'] != 1){echo "�����ʶR���Z���C<br>";PostFooter();exit;}
if (strpos($BuyWepS['spec'],'CannotEquip') !== false && !$UsrWepA[0]){echo "���˳ƪZ���e, �����ʶR�����~�C<br>";PostFooter();exit;}
$GenVal['cash'] = $GenVal['cash'] - $BuyWepS['price'];

if($UsrWepA[0] == '0') {$UsrWepA[0] = $BuyWepS['id'];$UsrWepA[1] = 0;$Pos_Flag='�A�{�b���ϥγo�s���Z���C';}
elseif($UsrWepB[0] == '0') {$UsrWepB[0] = $BuyWepS['id'];$UsrWepB[1] = 0;$Pos_Flag='�s���Z���ˤF�b�ƥΤ@�C';}
elseif($UsrWepC[0] == '0') {$UsrWepC[0] = $BuyWepS['id'];$UsrWepC[1] = 0;$Pos_Flag='�s���Z���ˤF�b�ƥΤG�C';}
else $ERROR_Buy_Wep = 'True';

if ($ERROR_Buy_Wep){echo "�ʶR�ɵo�Ϳ��~�A�ʶR����C<br>";PostFooter();exit;}

$GameVal['wepa'] = implode('<!>',$UsrWepA);
$GameVal['wepb'] = implode('<!>',$UsrWepB);
$GameVal['wepc'] = implode('<!>',$UsrWepC);

$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `wepa` = '$GameVal[wepa]', `wepb` = '$GameVal[wepb]', `wepc` = '$GameVal[wepc]' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
mysql_query($sql);
$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `cash` = '$GenVal[cash]' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
mysql_query($sql);
echo "<form action=equip.php?action=equip method=post name=frmeq target=$SecTarget>";
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
echo "</form>";
echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
echo "<p align=center style=\"font-size: 16pt\">�ʶR�����F�I$Pos_Flag<br><input type=submit value=\"��^\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"><input type=button value=\"�~��˳�\" onClick=\"frmeq.submit()\"></p>";
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
echo "</form>";
	postFooter();
	}
elseif ($mode == 'sellwep' && $actionb == 'process' && $actionc =='validcode'){
GetUsrDetails("$Pl_Value[USERNAME]",'GenVal','GameVal');

if ($SellWepDesired == 'WepA'){$SLOTWEP='wepa';
$UsrWepA = explode('<!>',$GameVal['wepa']);
GetWeaponDetails("$UsrWepA[0]",'SellWepS');
if (!$UsrWepA[0]){echo "�Z�����s�b�C";PostFooter();exit;}
}
elseif ($SellWepDesired == 'WepB'){$SLOTWEP='wepb';
$UsrWepB = explode('<!>',$GameVal['wepb']);
GetWeaponDetails("$UsrWepB[0]",'SellWepS');
if (!$UsrWepB[0]){echo "�Z�����s�b�C";PostFooter();exit;}
}
elseif ($SellWepDesired == 'WepC'){$SLOTWEP='wepc';
$UsrWepC = explode('<!>',$GameVal['wepc']);
GetWeaponDetails("$UsrWepC[0]",'SellWepS');
if (!$UsrWepC[0]){echo "�Z�����s�b�C";PostFooter();exit;}
}
else {echo '�X���I';exit;}
$SellP = Floor(($SellWepS['price']*0.5 + $SellWepS['price']*0.1)/1000)*1000;
$GenVal['cash'] = $GenVal['cash'] + $SellP;
$GameVal[$SLOTWEP] = '0<!>0';

$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `$SLOTWEP` = '$GameVal[$SLOTWEP]' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
mysql_query($sql);
$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `cash` = '$GenVal[cash]' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
mysql_query($sql);
echo "<form action=equip.php?action=equip method=post name=frmeq target=$SecTarget>";
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
echo "</form>";
echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
echo "<p align=center style=\"font-size: 16pt\">��X�����F�I<br>�A�o��F��� $SellP ���C<br><input type=submit value=\"��^\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"><input type=button value=\"�~��˳�\" onClick=\"frmeq.submit()\"></p>";
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
echo "</form>";
	postFooter();
	}
//Equip Equipments
elseif ($mode == 'equipwep' && $actionb == 'equipdef'){
$SRFlag=$TFlag=false;
GetUsrDetails("$Pl_Value[USERNAME]",'GenVal','GameVal');
if($GenVal['msuit'])
GetMsDetails("$GenVal[msuit]",'NowMS');
$O_Wep = $GameVal['eqwep'];
if ($slot_sw == 'wepb') $s = 'B';
else  $s = 'C';

if ($GameVal[$slot_sw] && $GameVal[$slot_sw][0] != '0' && $slot_sw != 'eqwep'){
	if ($slot_sw == 'wepa'){echo "�ФŽ�է�˳Ƥ����Z���ˤJ���U�˳ơC";postFooter();exit;}
	$GameVal['eqwep'] = $GameVal[$slot_sw];
	$GameVal[$slot_sw] = $O_Wep;
}
elseif($GameVal[$slot_sw] && $slot_sw == 'eqwep'){
	if ($GameVal['wepb'][0] == '0'){$GameVal['wepb']=$GameVal['eqwep'];$GameVal['eqwep']='0<!>0';$s = 'B';}
	elseif ($GameVal['wepc'][0] == '0'){$GameVal['wepc']=$GameVal['eqwep'];$GameVal['eqwep']='0<!>0';$s = 'C';}
	else {echo "�S���Ŧ���U�˳ơC";postFooter();exit;}
	$SRFlag=$TFlag=false;
}
else {echo "���w�q���ʧ@�C";postFooter();exit;}

$Equ_Id = explode('<!>',$GameVal['eqwep']);
$Equ_Prep = ("SELECT `name`,`atk`,`hit`,`rd`,`enc`,`equip`,`spec` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` WHERE id='". $Equ_Id[0] ."'");
$Equ_Query = mysql_query($Equ_Prep);
$Equ = mysql_fetch_array($Equ_Query);

$Equ_Id[2] = (isset($Equ_Id[2])) ? $Equ_Id[2]: 0;
if ($Equ_Id[2]){
if ($Equ_Id[2]==1) $Equ['name'] = $Equ_Id[3].$Equ['name']."<sub>&copy;</sub>";
else $Equ['name'] = $Equ['name'].$Equ_Id[3]."<sub>&copy;</sub>";
$Equ['atk'] += $Equ_Id[4];
$Equ['hit'] += $Equ_Id[5];
$Equ['rd'] += $Equ_Id[6];
$Equ['enc'] = $Equ_Id[7];
}
unset($a);
if (preg_match('/ExtHP<([0-9]+)>/',$Equ['spec'],$a)){$GameVal['hpmax'] += intval($a[1]);$SRFlag = 1;unset($a);}
if (preg_match('/ExtEN<([0-9]+)>/',$Equ['spec'],$a)){$GameVal['enmax'] += intval($a[1]);$SRFlag = 1;unset($a);}

$P_Equ_Id = explode('<!>',$GameVal['eqwep']);
$P_Equ_Prep = ("SELECT `spec` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` WHERE id='". $P_Equ_Id[0] ."'");
$P_Equ_Query = mysql_query($P_Equ_Prep);
$P_Equ = mysql_fetch_array($P_Equ_Query);

$Eq_Id = explode('<!>',$O_Wep);
$Eq_Prep = ("SELECT `name`,`atk`,`hit`,`rd`,`enc`,`equip`,`spec` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` WHERE id='". $Eq_Id[0] ."'");
$Eq_Query = mysql_query($Eq_Prep);
$Eq = mysql_fetch_array($Eq_Query);
$Eq_Id[2] = (isset($Eq_Id[2])) ? $Eq_Id[2]: 0;

if ($Eq_Id[2]){
if ($Eq_Id[2]==1) $Eq['name'] = $Eq_Id[3].$Eq['name']."<sub>&copy;</sub>";
else $Eq['name'] = $Eq['name'].$Eq_Id[3]."<sub>&copy;</sub>";
$Eq['atk'] += $Eq_Id[4];
$Eq['hit'] += $Eq_Id[5];
$Eq['rd'] += $Eq_Id[6];
$Eq['enc'] = $Eq_Id[7];
}

if (strpos($Eq['spec'],'HPPcRec') !== false){$GameVal['hp'] = 0;$GameVal['status'] = 1;$SRFlag = 1;$TFlag = 1;}
if (strpos($Eq['spec'],'ENPcRec') !== false){$GameVal['en'] = 0;$SRFlag = 1;$TFlag = 1;}
if (isset($a)) unset($a);
if (preg_match('/ExtHP<([0-9]+)>/',$Eq['spec'],$a)){$GameVal['hpmax'] -= intval($a[1]);$SRFlag = 1;unset($a);}
if (preg_match('/ExtEN<([0-9]+)>/',$Eq['spec'],$a)){$GameVal['enmax'] -= intval($a[1]);$SRFlag = 1;unset($a);}

if (strpos($NowMS['spec'],'EXAMSystem') === false && strpos($P_Equ['spec'],'EXAMSystem') === false && strpos($GameVal['spec'],'EXAMSystem') !== false) {
	$SRFlag = 1;
	$GameVal['spec'] = str_replace('EXAMSystem, ','',$GameVal['spec']);
	$hypmd_sql = '';
	$hypmd = 0;
	if ($GenVal['hypermode'] >= 4 && $GenVal['hypermode'] <= 6){
		switch($GenVal['hypermode']){
		case 4: $hypmd = 0; break;
		case 5: $hypmd = 1; break;
		case 6: $hypmd = 2; break;
		}
		$TFlag = 1;
		$hypmd_sql = ", `hypermode` = $hypmd ";
	}
}

$isEXAMtypch = ($GenVal['typech'] == 'nat' || $GenVal['typech'] == 'enh' || $GenVal['typech'] == 'ext');
if (strpos($Equ['spec'],'EXAMSystem') !== false && strpos($GameVal['spec'],'EXAMSystem') === false && $isEXAMtypch){
	$GameVal['spec'] .= 'EXAMSystem, ';
	$SRFlag = 1;
}

$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `eqwep` = '$GameVal[eqwep]', `wepa` = '$GameVal[wepa]', `wepb` = '$GameVal[wepb]', `wepc` = '$GameVal[wepc]'");

if ($SRFlag)
$sql .= (", `spec` = '$GameVal[spec]', `hp` = '$GameVal[hp]', `hpmax` = '$GameVal[hpmax]', `status` = '$GameVal[status]', `en` = '$GameVal[en]', `enmax` = '$GameVal[enmax]'");
$sql .= (" WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
mysql_query($sql);
unset($sql);
if ($TFlag){
$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `time1` = '$CFU_Time'");
if ($hypmd_sql) $sql .= $hypmd_sql;
$sql .= (" WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
mysql_query($sql);}

if ($Equ_Id[1] > 0) $DisplayXp['D'] = '+'.($Equ_Id[1]/100).'%';
elseif ($Equ_Id[1] < 0) $DisplayXp['D'] = ($Equ_Id[1]/100).'%';
else $DisplayXp['D'] = '��0%';

if ($Eq_Id[1] > 0) $DisplayXp['S'] = '+'.($Eq_Id[1]/100).'%';
elseif ($Eq_Id[1] < 0) $DisplayXp['S'] = ($Eq_Id[1]/100).'%';
else $DisplayXp['S'] = '��0%';

//JS Auto-Update
echo "<script language=\"JavaScript\">";
echo "parent.document.getElementById('EqmExp_D').innerHTML = '".$DisplayXp['D']."';";
echo "parent.document.getElementById('EqmExp_".$s."').innerHTML = '".$DisplayXp['S']."';";
echo "parent.document.getElementById('EqmName_D').innerHTML = '".$Equ['name']."';";
echo "parent.document.getElementById('EqmName_".$s."').innerHTML = '".$Eq['name']."';";

$Inf['D'] = "�˳Ư�O:<br>";
$Inf['D'] .= "�@�����O: ".$Equ['atk']."�@�@�@�^��: ".$Equ['rd']."<br>�@�R��: ".$Equ['hit']."�@�@�@EN���O: <span id=EqmEnc_D>".$Equ['enc']."</span><br>";
$Inf['D'] .= "�S��ĪG:<br>";
if ($Equ['equip']) $Inf['D'] .= "�i�H�˳�<br>";
if ($Equ['spec']) $Inf['D'] .= ReturnSpecs($Equ['spec']);
if (!$Equ['spec'] && !$Equ['equip']) $Inf['D'] .= "�S��";

$Inf['S'] = "�˳Ư�O:<br>";
$Inf['S'] .= "�@�����O: ".$Eq['atk']."�@�@�@�^��: ".$Eq['rd']."<br>�@�R��: ".$Eq['hit']."�@�@�@EN���O: <span id=EqmEnc_".$s.">".$Eq['enc']."</span><br>";
$Inf['S'] .= "�S��ĪG:<br>";
if ($Eq['equip']) $Inf['S'] .= "�i�H�˳�<br>";
if ($Eq['spec']) $Inf['S'] .= ReturnSpecs($Eq['spec']);
if (!$Eq['spec'] && !$Eq['equip']) $Inf['S'] .= "�S��";

echo "parent.document.getElementById('EqmDis_D').innerHTML = \"".$Inf['D']."\";";
echo "parent.document.getElementById('EqmDis_".$s."').innerHTML = \"".$Inf['S']."\";";

if ($GenVal['hypermode'] == 1 || ($GenVal['hypermode'] >= 4 && $GenVal['hypermode'] <= 6))
	echo "parent.document.getElementById('pltype').style.filter = \"progid:DXImageTransform.Microsoft.Glow(color: 0000FF,strength=2)\";";
else	echo "parent.document.getElementById('pltype').style.filter = '';";

if ($GenVal['hypermode'] == 1 || $GenVal['hypermode'] == 5){
	echo "parent.document.getElementById('seedTxt').innerHTML = 'SEED Mode';";
	echo "parent.document.getElementById('seedTxt').style.color = 'FFFF00';";
	echo "parent.document.getElementById('seedTxt').style.fontWeight = 'bold';";
}else	echo "parent.document.getElementById('seedTxt').innerHTML = '';";

if ($GenVal['hypermode'] >= 4 && $GenVal['hypermode'] <= 6){
	echo "parent.document.getElementById('examTxt').innerHTML = 'EXAM Activated';";
	echo "parent.document.getElementById('examTxt').style.color = 'FF0000';";
	echo "parent.document.getElementById('examTxt').style.fontWeight = 'bold';";
}else	echo "parent.document.getElementById('examTxt').innerHTML = '';";

if($O_Wep[0] == '0'){
echo "parent.document.getElementById('Eqm_".$s."').style.visibility = 'hidden';";
echo "parent.document.getElementById('Eqm_".$s."').style.position = 'absolute';";
echo "parent.document.getElementById('EqmL_".$s."').style.visibility = 'hidden';";
echo "parent.document.getElementById('EqmL_".$s."').style.position = 'absolute';";
}
if($slot_sw != 'eqwep'){
echo "parent.document.getElementById('Eqm_D').style.visibility = 'visible';";
echo "parent.document.getElementById('Eqm_D').style.position = 'relative';";
echo "parent.document.getElementById('EqmL_D').style.visibility = 'visible';";
echo "parent.document.getElementById('EqmL_D').style.position = 'relative';";
}
else {
echo "parent.document.getElementById('Eqm_D').style.visibility = 'hidden';";
echo "parent.document.getElementById('Eqm_D').style.position = 'absolute';";
echo "parent.document.getElementById('EqmL_D').style.visibility = 'hidden';";
echo "parent.document.getElementById('EqmL_D').style.position = 'absolute';";

echo "parent.document.getElementById('Eqm_".$s."').style.visibility = 'visible';";
echo "parent.document.getElementById('Eqm_".$s."').style.position = 'relative';";
echo "parent.document.getElementById('EqmL_".$s."').style.visibility = 'visible';";
echo "parent.document.getElementById('EqmL_".$s."').style.position = 'relative';";
}

echo "parent.document.getElementById('current_hp').innerHTML = ".$GameVal['hp'].";";
echo "parent.document.getElementById('max_hp').innerHTML = ".$GameVal['hpmax'].";";
echo "parent.document.getElementById('current_en').innerHTML = ".$GameVal['en'].";";
echo "parent.document.getElementById('max_en').innerHTML = ".$GameVal['enmax'].";";

if ($Equ_Id[0] && ($GameVal['wepb'][0] == '0' || $GameVal['wepc'][0] == '0'))
	echo "parent.document.getElementById('EqR_btn_D').innerHTML = \"(���U���˳�)\";";

if(canEquipAsWep($Eq)){
	echo "parent.document.getElementById('EqW_btn_".$s."').innerHTML = \"(�˳Ʀ��Z��)\";";
}
else	echo "parent.document.getElementById('EqW_btn_".$s."').innerHTML = '';";

if ($Eq['equip'])
	echo "parent.document.getElementById('EqE_btn_".$s."').innerHTML = \"(�ˤW���U�˳�)\";";
else	echo "parent.document.getElementById('EqE_btn_".$s."').innerHTML = '';";

echo "</script>";

if($actionc == 'rt_equip') exit;
echo "<form action=equip.php?action=equip method=post name=frmeq target=$SecTarget>";
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
echo "</form>";
echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
echo "<p align=center style=\"font-size: 16pt\">�˳Ƨ����F�I<br><input type=submit value=\"��^\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"><input type=button value=\"�~��˳�\" onClick=\"frmeq.submit()\"></p>";
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
echo "</form>";
	postFooter();
	}
//
elseif ($mode == 'buyms' && ($actionb == 'buyms' || !$actionb)){
GetUsrDetails("$Pl_Value[USERNAME]",'GenVal','GameVal');
$ResaleValue = 0;
if ($GenVal['msuit']){
	GetMsDetails("$GenVal[msuit]",'NowMS');
	$SellPrice = Floor($NowMS['price'] * 0.9);
	$Refund  = floor(($GameVal['hpmax'] - $NowMS['hpfix'])/100) * $Mod_HP_Cost;
	$Refund += floor(($GameVal['enmax'] - $NowMS['enfix'])/10 ) * $Mod_EN_Cost;
	$ResaleValue = $SellPrice + $Refund;
}
	echo "�w��Ө����Ͳ��u���I�I�I<hr><center>";
	if($GameVal['organization'] != 0)
		echo "<b>��´�M��: </b><br><input type=button value=��´�����s�� $BStyleB style=\"$BStyleA\" onClick=\"buymsform.action='buysetms.php?action=main';buymsform.actionb.value='';buymsform.submit();\">".sprintTHR('75%');
	echo "<b>���ʾ���: </b><br>";
	printTHR('75%');
	echo "<a name=imagetop><img src=$Unit_Image_Dir/none.gif id=ms_sel onClick=\"buymsform.buymsbutton.click();\" style=\"cursor: crosshair;\"></a><br><span id=msnamesel align=center style='font-size: 16px;font-weight: Bold';>�L����</span><span id=priceselctd style=\"visibility: hidden;position: absolute;\">100</span>";
	printTHR('75%');
echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 9pt;\" bordercolor=\"#FFFFFF\" width=\"740\">";
echo "<tr align=center>";
echo "<td width=\"20\">No.</td>";
echo "<td width=\"195\">����W��</td>";
echo "<td width=\"50\">Attacking</td>";
echo "<td width=\"50\">Defending</td>";
echo "<td width=\"50\">Mobility</td>";
echo "<td width=\"50\">Targeting</td>";
echo "<td width=\"50\">HP�[��</td>";
echo "<td width=\"55\">HP�^�_�v</td>";
echo "<td width=\"50\">EN�[��</td>";
echo "<td width=\"55\">EN�^�_�v</td>";
echo "<td width=\"30\">�n�D����</td>";
echo "<td width=\"85\">����</td>";
echo "</tr>";
$c=0;
$sqlsysms = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_sys_ms` WHERE `price` <= $GenVal[cash]+$ResaleValue AND `needlv` <= $GameVal[level]+10  AND id != '0' AND btype = 0 ORDER BY needlv DESC, price DESC");
$sysms_q =mysql_query("$sqlsysms");
$thequery = $sysms_q;
$allmsnum = mysql_num_rows($sysms_q);
if ($allmsnum>1){
	echo "<style type=\"text/css\">.buymslist{cursor: pointer;}</style>";
	
	$c=0;
	$SysMsDetail=$BuyMsPossibilities = '';
	$SWITCHMSIMGFUNCTION = "function switchmsImg(){";

	while ($SysMsDetail = mysql_fetch_array($sysms_q)){
		$c+=1;
		if (intval($SysMsDetail['hprec']) >= 1) $ShowHpRec = intval($SysMsDetail['hprec']).'/��';
		elseif ($SysMsDetail['hprec'] < 1 && $SysMsDetail['hprec'] != 0) $ShowHpRec=($SysMsDetail['hprec']*100).'% /��';
		else $ShowHpRec='���|�^�_';
		
		if ($SysMsDetail['enrec'] >= 1) $ShowEnRec = intval($SysMsDetail['enrec']).'/��';
		elseif ($SysMsDetail['enrec'] < 1 && $SysMsDetail['enrec'] != 0) $ShowEnRec=($SysMsDetail['enrec']*100).'% /��';
		else $ShowEnRec='���|�^�_';
		
		$lnkStr = "'$SysMsDetail[id]', '$SysMsDetail[msname]', '".str_replace('<br>',"\\n ",ReturnSpecs($SysMsDetail['spec']))."', $SysMsDetail[hpfix], $SysMsDetail[enfix], ";
		$lnkStr .= "$SysMsDetail[atf], $SysMsDetail[def], $SysMsDetail[taf], $SysMsDetail[ref], $SysMsDetail[hprec], $SysMsDetail[enrec]";

		echo "<tr align=center class=buymslist onMouseover=\"this.style.color='yellow';\" onMouseout=\"this.style.color=''\" onClick=\"lnkSelectMS($lnkStr);\">";
		echo "<td width=\"20\">$c</td>";
		echo "<td width=\"195\" id=ms_".$SysMsDetail['id']."_name>$SysMsDetail[msname]</td>";
		
		$AtfClr = colorConvert("$SysMsDetail[atf]",'50');
		$DefClr = colorConvert("$SysMsDetail[def]",'50');
		$RefClr = colorConvert("$SysMsDetail[ref]",'50');
		$TafClr = colorConvert("$SysMsDetail[taf]",'50');
		
		echo "<td width=\"50\" style=\"color: $AtfClr\">$SysMsDetail[atf]</td>";
		echo "<td width=\"50\" style=\"color: $DefClr\">$SysMsDetail[def]</td>";
		echo "<td width=\"50\" style=\"color: $RefClr\">$SysMsDetail[ref]</td>";
		echo "<td width=\"50\" style=\"color: $TafClr\">$SysMsDetail[taf]</td>";
		
		echo "<td width=\"50\">$SysMsDetail[hpfix]</td>";
		echo "<td width=\"55\">$ShowHpRec</td>";
		echo "<td width=\"50\">$SysMsDetail[enfix]</td>";
		echo "<td width=\"55\">$ShowEnRec</td>";
		echo "<td width=\"30\">$SysMsDetail[needlv]</td>";
		echo "<td width=\"85\">$SysMsDetail[price]</td>";
		echo "</tr>";

		$SWITCHMSIMGFUNCTION .= "if (document.buymsform.BuyMsDesired.value == '$SysMsDetail[id]'){";
		$SWITCHMSIMGFUNCTION .= "document.getElementById('ms_sel').src='$Unit_Image_Dir/$SysMsDetail[image]';";
		$SWITCHMSIMGFUNCTION .= "document.getElementById('msnamesel').innerHTML=document.getElementById('ms_".$SysMsDetail['id']."_name').innerHTML;";
		$SWITCHMSIMGFUNCTION .= "document.getElementById('priceselctd').innerHTML='$SysMsDetail[price]';}";
		$BuyMsPossibilities .= "<option value=$SysMsDetail[id]>$SysMsDetail[msname]";
		$SysMsDetail='';
	}
	
	//End Repeat
	
	echo "<script language=\"Javascript\">";
	echo "function lnkSelectMS(id, name, spec, hp, en, at, de, ta, re, hp_rec, en_rec){";
	echo "	location.replace('#imagetop');";
	echo "	document.buymsform.BuyMsDesired.value = id;";
	echo "	switchmsImg();";
	echo "	alert('����W��:\\n' + name + '\\n-------------------------\\n�S��ĪG:\\n ' + spec";
	echo "		+ '\\n-------------------------\\nHP: ' + hp + '\\tEN: ' + en";
	echo "		+ '\\n��: ' + at + '\\t��: ' + de + '\\n�R��: ' + ta + '\\t����: ' + re";
	echo "		+ '\\n-------------------------\\nHP�^�_�v: '+hp_rec+'\\nEN�^�_�v: ' + en_rec );";
	echo "}";
	echo $SWITCHMSIMGFUNCTION;
	echo "}</script>";
	
	echo "<form action=equip.php?action=buyms method=post name=buymsform><tr align=center valign=bottom><td colspan=12>";
	echo "<input type=hidden value='process' name=actionb>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	
	echo "���ʾ���: <select onChange=\"switchmsImg();location.replace('#imagetop')\" name=BuyMsDesired";
	$additionaltext = '';
	if ($GenVal['msuit']) {echo " disabled = true"; $additionaltext = "<br><font style=\"font-size: 14px;color: red\"><b>�A�w������A�Х��i�����A�ʤJ�C</b>";}
	echo ">";
	echo "<option value=''>---��ܾ���---$BuyMsPossibilities</select>";
	echo "<script language='Javascript'>";
	echo "function returncheckbuyms(){";
	echo "if(document.buymsform.BuyMsDesired.selectedIndex == ''){alert('�S����n����C');return false;}";
	echo "if(priceselctd.innerHTML > $GenVal[cash]){alert('��������!!');return false;}";
	echo "else{if (confirm('�ʶR'+msnamesel.innerHTML+'�ݭn '+priceselctd.innerHTML+'���C\\n�T�w�n�ʶR�ܡH') == true){return true;}else{return false;}}";
	echo "}</script>";
	echo "<input name=buymsbutton type=submit onClick=\"return returncheckbuyms();\" value='�ʶR'";
	if ($GenVal['msuit']) echo " disabled = true";
	echo ">";
}
else echo "<tr align=center><td colspan=12>�S���i�ʶR������";

echo "$additionaltext</td></tr></form></table>";
if ($GenVal['msuit']){
	echo "<br><hr width=75%><br>";
	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#FFFFFF\" width=\"300\">";
	echo "<form action=equip.php?action=buyms method=post name=sellmsform>";
	echo "<input type=hidden value='process' name=actionb>";
	echo "<input type=hidden value='sell' name=actionc>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
		echo "<script language=\"Javascript\">";
		echo "function cfmsell(){";
		echo "if (confirm('�T�w�n����ܡH�Ҧ��B�~HP/EN�N�|�Q��ܽ�I') == true){sellmsform.submit()}else{return false}";
		echo "}";
		echo "</script>";
	echo "<tr align=center valign=bottom><td><b>�������</b></td></tr>";
	echo "<tr height=250><td valign=bottom align=center><img src='".$Unit_Image_Dir."/$NowMS[image]'><p>$NowMS[msname]</p></td></tr>";
	echo "<tr><td>������� $SellPrice ���C<br>�ܽ檺�˥ҩM�෽�X�@: $Refund ���C<br>�⦹�����������o���: ".number_format($ResaleValue)." ���C<br>�i�����: <input type=button value='�T�w' onclick='cfmsell();'></td></tr>";
	echo "</form></table>";
}
postFooter();
}
//Start Evolution System
elseif ($mode == 'evolution' && $actionb == 'evolution' && $evfrom && $evto){
	$slotConv = array('A' => 'wepa', 'B' => 'wepb', 'C' => 'wepc');
	$evto = intval($evto);
	if($evto < 1) {echo "evto error<hr>"; exit;}
	$Slot = array_search($evfrom, $slotConv);
	if($Slot === false) {echo "Slot Error<hr>"; exit;}

	// Create Objects
	include_once('includes/sfo.class.php');
	$Pl = new player_stats();
	$Pl->SetUser($Pl_Value['USERNAME']);
	$Pl->FetchPlayer(true);
	$Pl->ProcessAllWeapon();
	$CurrentWep = $Pl->Eq[$Slot];

	$sql = "SELECT `from_id`, `to_id`, `ev_xp`, `ev_cost` ";
	$sql .= " FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep_ev` WHERE ";
	$sql .= " `ev_id` = '$evto';";	
	$query = mysql_query($sql);

	$EvInf = mysql_fetch_array($query);
	
	$FlagUnable = false;
	if($EvInf['from_id'] != $CurrentWep['id']) $FlagUnable = true;
	elseif($EvInf['ev_xp'] > $CurrentWep['exp']) $FlagUnable = true;
	elseif($EvInf['ev_cost'] > $Pl->Player['cash']) $FlagUnable = true;
	$Pl->Player['cash'] -= $EvInf['ev_cost'];

	if (!$FlagUnable){
		$sql = "UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `$evfrom` = '$EvInf[to_id]<!>0' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;";
		mysql_query($sql);
		$sql = "UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `cash` = '{$Pl->Player[cash]}' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;";
		mysql_query($sql);
		echo "<form action=equip.php?action=equip method=post name=frmeq target=$SecTarget>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
		echo "</form>";
		echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
		echo "<p align=center style=\"font-size: 16pt\">��y�����F�I<br><input type=submit value=\"��^\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"><input type=button value=\"�~��˳�\" onClick=\"frmeq.submit()\"></p>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
		echo "</form>";
		postFooter();
	}else {echo "���Z���L�k��y���ؼЪZ���B���ϥΪZ�������A�Ȥ����B�Ϊ��������I";postFooter();exit;}

}//End Evolution System

//
// Mode: Buy/Sell MS
// �ʶR�P����
//

elseif ($mode == 'buyms' && $actionb == 'process'){
	GetUsrDetails("$Pl_Value[USERNAME]",'GenVal','GameVal');
	$actionc = (isset($actionc)) ? $actionc: false;
	
	//
	// Sub-action "Buy Mode"
	//
	
	if ($actionc != 'sell'){
		if ($GenVal['msuit']){echo "�w�g������!!<br>";PostFooter();exit;}
	
		GetMsDetails("$BuyMsDesired",'BuyMsDVal');
		if ($GenVal['cash'] - $BuyMsDVal['price'] < 0){echo "��������!!<br>";PostFooter();exit;}
		if ($GameVal['level'] < $BuyMsDVal['needlv']){echo "���Ť���!!<br>";PostFooter();exit;}
	
		$GenVal['cash'] = $GenVal['cash'] - $BuyMsDVal['price'];
		$GenVal['msuit'] = $BuyMsDVal['id'];
	
		// Process Extension HP/EN
		$Ext = array('HP' => 0, 'EN' => 0);
		$ExtTemp = getExtStat($GameVal['equip']);
		$Ext['HP'] += $ExtTemp['HP'];
		$Ext['EN'] += $ExtTemp['EN'];
		$ExtTemp = getExtStat($GameVal['p_equip']);
		$Ext['HP'] += $ExtTemp['HP'];
		$Ext['EN'] += $ExtTemp['EN'];
	
		$GameVal['hpmax'] = $BuyMsDVal['hpfix'] + $Ext['HP'];
		$GameVal['enmax'] = $BuyMsDVal['enfix'] + $Ext['EN'];
		$GameVal['hp'] = $GameVal['hpmax'];
		$GameVal['en'] = $GameVal['enmax'];
		
		$isEXAMtypch = ($GenVal['typech'] == 'nat' || $GenVal['typech'] == 'enh' || $GenVal['typech'] == 'ext');
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `hpmax` = '$GameVal[hpmax]', `enmax` = $GameVal[enmax], `hp` = '$GameVal[hp]', ");
		if (strpos($BuyMsDVal['spec'],'EXAMSystem') !== false && strpos($GameVal['spec'],'EXAMSystem') === false && $isEXAMtypch) {
			$GameVal['spec'] .= 'EXAMSystem, ';
			$sql .= ("`spec` = '$GameVal[spec]', ");
		}
		$sql .= ("`en` = $GameVal[en] WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
		mysql_query($sql);
		
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `cash` = '$GenVal[cash]',
		`msuit` = $GenVal[msuit] WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
		mysql_query($sql);
		
		echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
		echo "<p align=center style=\"font-size: 16pt\">�ʶR�����F�I<br><input type=submit value=\"��^\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
	}
	
	//
	// Sub-action "Sell Mode"
	//
	
	elseif($actionc == 'sell'){
		GetMsDetails("$GenVal[msuit]",'NowMS');
		$Pl_WepD = explode('<!>',$GameVal['eqwep']);
		GetWeaponDetails("$Pl_WepD[0]",'Pl_SyWepD');
		$Pl_WepE = explode('<!>',$GameVal['p_equip']);
		GetWeaponDetails("$Pl_WepE[0]",'Pl_SyWepE');
		if (!$GenVal['msuit']){echo "�A�S������!!<br>";PostFooter();exit;}

		// Process Extension HP/EN
		$Ext = array('HP' => 0, 'EN' => 0);
		$ExtTemp = getExtStat($GameVal['equip']);
		$Ext['HP'] += $ExtTemp['HP'];
		$Ext['EN'] += $ExtTemp['EN'];
		$ExtTemp = getExtStat($GameVal['p_equip']);
		$Ext['HP'] += $ExtTemp['HP'];
		$Ext['EN'] += $ExtTemp['EN'];
		
		$GameVal['hpmax'] -= $Ext['HP'];
		$GameVal['enmax'] -= $Ext['EN'];
	
		// Refund
		$SellPrice = Floor($NowMS['price'] * 0.9);
		$Refund  = floor(($GameVal['hpmax'] - $NowMS['hpfix'])/100) * $Mod_HP_Cost;
		$Refund += floor(($GameVal['enmax'] - $NowMS['enfix'])/10 ) * $Mod_EN_Cost;
		$GenVal['cash'] = $GenVal['cash'] + $SellPrice + $Refund;
	
		// Reset HP, EN and MS
		$GameVal['hpmax'] = $GameVal['enmax'] = 0;
		$GenVal['msuit'] = '0';
		
		$sql = "UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET ";
		$sql .= "`p_equip` = '0<!>0', `ms_custom` = '', `status` = '0', ";
		$sql .= "`hpmax` = '$GameVal[hpmax]', `enmax` = $GameVal[enmax], `hp` = '0', ";		// Structuring SQL, `en` left-out on purpose
		if (strpos($GameVal['spec'],'EXAMSystem') !== false && strpos($Pl_SyWepD['spec'],'EXAMSystem') === false) {
			$GameVal['spec'] = str_replace('EXAMSystem, ','',$GameVal['spec']);
			$sql .= ("`spec` = '$GameVal[spec]', ");
			$hypmd_sql = '';
			$hypmd = 0;
			if ($GenVal['hypermode'] >= 4 && $GenVal['hypermode'] <= 6){
				switch($GenVal['hypermode']){
				case 4: $hypmd = 0; break;
				case 5: $hypmd = 1; break;
				case 6: $hypmd = 2; break;
				}
				$hypmd_sql = ", `hypermode` = $hypmd ";
			}
		}
	
		$sql .= ("`en` = '0' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
		mysql_query($sql);
	
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `cash` = '$GenVal[cash]'");
		$hypmd_sql = (isset($hypmd_sql)) ? $hypmd_sql: 0;
		if ($hypmd_sql) $sql .= $hypmd_sql;
		$sql .= (", `msuit` = $GenVal[msuit] WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
		mysql_query($sql);
		echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
		echo "<p align=center style=\"font-size: 16pt\">���駹���F�I<br>�A�o���� ".number_format($SellPrice+$Refund)." ���C<input type=submit value=\"��^\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
	
	}
	else {echo "<br><br><br>undefined subaction";postFooter();exit;}
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";
	postFooter();
}

else {echo "<br><br><br>undefined subaction";postFooter();}

//
// Refactored Functions
//

// Borrowed From statsmod.php
// Location: "Mode: Modify MS HP/EN - View"
function getExtStat($EqF){
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

?>