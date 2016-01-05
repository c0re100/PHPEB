<?php
//-------------------------//-------------------------//-------------------------//
//-------------------  php-eb Ultimate Edition Version v1.0  --------------------//
//---------------------------   Official Open Build    --------------------------//
//-------------------------//-------------------------//-------------------------//
//----------------  php-eb UE Battle Result Calculator/Simulator ----------------//
//-------------------                v3.0Alpha               --------------------//
//-------------------------//-------------------------//-------------------------//

$IncludeSCFI = false;
$IncludeLFFI = false;
$IncludeCVFI = false;

include('cfu.php');

//Select Type Character
$SQL = ("SELECT `id`, `name`, `typelv`, `atf`, `def`, `ref`, `taf` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` ORDER BY `id`");
$Query = mysql_query($SQL);

$Type_ID = '';

while($TypeCh = mysql_fetch_array($Query))
	$Type_ID .= "\nTypeID[\"". $TypeCh['id'] ."\"][".$TypeCh["typelv"]."] =new Array(\"$TypeCh[name]\",$TypeCh[atf],$TypeCh[def],$TypeCh[ref],$TypeCh[taf]);";

//Select Weapon
$SQL = ("SELECT `id`, `name`, `atk`, `hit`, `rd`, `enc`, `spec`, `range`, `attrb` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` WHERE `spec` != 'Blueprint' ORDER BY `id`");
$Query = mysql_query($SQL) or die(mysql_error());

$Wep_Selection = '';
$Wep_ID = '';

while($Weapon = mysql_fetch_array($Query)){
	$Wep_Selection .= "\n<option value='". $Weapon['id'] ."'>".$Weapon['name'];
	$Specs = ReturnSpecs($Weapon['spec']);
	$Wep_ID .= "\nWepID[\"". $Weapon['id'] ."\"] =new Array(\"$Weapon[name]\",$Weapon[atk],$Weapon[rd],$Weapon[hit],$Weapon[enc],\"$Specs\",$Weapon[range],$Weapon[attrb]);";
}

//Select MS
$SQL = ("SELECT `id`, `msname`, `atf`, `def`, `ref`, `taf`, `spec` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_ms` ORDER BY `price`");
$Query = mysql_query($SQL);

$MS_Selection = '';
$MS_ID = '';

while($MS = mysql_fetch_array($Query)){
	$MS_Selection .= "\n<option value='". $MS['id'] ."'>".$MS['msname'];
	$Specs = ReturnSpecs($MS['spec']);
	$MS_ID .= "\nMSID[\"". $MS['id'] ."\"] =new Array(\"$MS[msname]\",$MS[atf],$MS[def],$MS[ref],$MS[taf],\"$Specs\");";
}


//Select Tactics Information
$SQL = ("SELECT `id`, `name`, `atf`, `def`, `ref`, `taf`, `hitf`, `missf`, `spec` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_tactics` ORDER BY `needlv`");
$Query = mysql_query($SQL);

$Tactics_Selection = '';
$Tactics_ID = '';

while($Tactics = mysql_fetch_array($Query)){
	$Tactics_Selection .= "\n<option value='". $Tactics['id'] ."'>".$Tactics['name'];
	$Specs = ReturnSpecs($Tactics['spec']);
	$Tactics_ID .= "\nTacticsID[\"". $Tactics['id'] ."\"] =new Array(\"$Tactics[name]\",$Tactics[atf],$Tactics[def],$Tactics[ref],$Tactics[taf],$Tactics[hitf],$Tactics[missf],\"$Specs\");";
}

?>

<html>
	<head>
		<title>PHP x JavaScript :: php-eb Ultimate Edition :: �����p�⾹ v3.0�\ ~ &copy; 2005-2010 v2Alliance</title>
		<meta http-equiv="Content-Type" content="text/html; charset=Big5">
		<meta http-equiv="content-language" content="zh">
	</head>
<body>


<!-- Insert Javascipt -->
<script language="JavaScript">
	var TypeID = new Array();
	TypeID["nat"] = new Array();
	TypeID["ext"] = new Array();
	TypeID["enh"] = new Array();
	TypeID["psy"] = new Array();
	TypeID["co"] = new Array();
	TypeID["nt"] = new Array();

	<?php echo $Type_ID; ?>
	
	var WepID = new Array();
	var MSID = new Array();
	var TacticsID = new Array();
	
	<?php echo $Wep_ID ."\n". $MS_ID ."\n". $Tactics_ID; ?>

</script>
<script language="JavaScript" src="includes/btl_calc.js"></script>
<script language="JavaScript">
	// Player Object: Pl
	var objPl = new player;
	// Player Object: Op
	var objOp = new player;
</script>

<table>
<tr><td>
<form name=Main>

��J����:<input type="text" name="Level"><br>
<input type="button" onClick="document.getElementById('StatptG').innerHTML=CalcStatPt(document.Main.Level.value);" value='�p��i�o�������I��'><br>
<input type="button" onClick="document.getElementById('TStatptG').innerHTML=CalcTotalStatPtsG(document.Main.Level.value);" value='�p��i�o���`�����I��''><br>
<input type="button" onClick="document.getElementById('ExpR').innerHTML=numFormat(CalcExp(document.Main.Level.value));" value='�p��һݸg��'><br>

��J�Q�p�⪺��O��:<input type="text" name="Status"><br>
<input type="button" onClick="document.getElementById('StatptR').innerHTML=CalcStatReq(document.Main.Status.value);" value='�p��һݦ����I��'><br>
<input type="button" onClick="document.getElementById('TStatptR').innerHTML=CalcTotalStatPtsR(document.Main.Status.value);" value='�p��һ��`�����I��'><br>
<input type="button" onClick="document.getElementById('TLevelStR').innerHTML=CalcLevelRec(document.Main.Status.value);" value='�p��һݯż�'><br>
<br>

</form>
</td>
<td>
<table>
	<tr>
		<td align=right>�U�@�ťi�o�����I��:</td>
		<td><span id=StatptG>&nbsp;</span></td>
	</tr>
	<tr>
		<td align=right>(�ܥ�����)�`�����I��:</td>
		<td><span id=TStatptG>&nbsp;</span></td>
	</tr>
	<tr>
		<td align=right>������ȩһݦ����I��:</td>
		<td><span id=StatptR>&nbsp;</span></td>
	</tr>
	<tr>
		<td align=right>(�ܥ������)�һ��`�����I��:</td>
		<td><span id=TStatptR>&nbsp;</span></td>
	</tr>
	<tr>
		<td align=right>(�ܥ������)�һݯż�:</td>
		<td><span id=TLevelStR>&nbsp;</span></td>
	</tr>
	<tr>
		<td align=right>�U�@�ũһݸg��:</td>
		<td><span id=ExpR>&nbsp;</span></td>
	</tr>
</table>
</td>
</tr>
</table>
<hr>
��O���Ŧ����I�ƭp�⾹:
<table align=center>
	<tr><td>

<form name=Calculator>
<table border=0>
	<tr>
		<td>Attacking:<select name="At" onChange="objPl.statChanged();"><script language="JavaScript">for(a=1;a<=150;a++){document.write('<option value='+a+'>'+a)}</script>
		</select> + <span id="pl_pi_atf">0</span> ( + <span id="pl_pi_xat">0</span>)</td>
		<td>Defending:<select name="De" onChange="objPl.statChanged();"><script language="JavaScript">for(a=1;a<=150;a++){document.write('<option value='+a+'>'+a)}</script>
		</select> + <span id="pl_pi_def">0</span> ( + <span id="pl_pi_xde">0</span>)</td>
	</tr>
	<tr>
		<td>Reacting:<select name="Re" onChange="objPl.statChanged();"><script language="JavaScript">for(a=1;a<=150;a++){document.write('<option value='+a+'>'+a)}</script>
		</select> + <span id="pl_pi_ref">0</span> ( + <span id="pl_pi_xre">0</span>)</td>
		<td>Targeting:<select name="Ta" onChange="objPl.statChanged();"><script language="JavaScript">for(a=1;a<=150;a++){document.write('<option value='+a+'>'+a)}</script>
		</select> + <span id="pl_pi_taf">0</span> ( + <span id="pl_pi_xta">0</span>)</td>
	</tr>
</table>

</td><td>

<table>
	<tr>
		<td align=right>����:</td>
		<td><span id="LevelR">1</span></td>
	</tr>
	<tr>
		<td align=right>�һ��`�����I��:</td>
		<td><span id="GrowR">&nbsp;</span></td>
	</tr>
	<tr>
		<td align=right>�|�l�����I��:</td>
		<td><span id="PtLeft">&nbsp;</span></td>
	</tr>
</table>
</td>
</tr>
<tr>
	<td align=center colspan=2>
		��ʿ�J���� <input name="Pl_dis_spcflv" type=checkbox onClick="objPl.chk_dis_spcflv();objPl.statChanged();">: <input disabled onChange="numParse(this);objPl.statChanged();" style="text-align: center;" type="text" name="Pl_Calc_Level" value=1 size=3 maxlength=3>&nbsp;&nbsp;&nbsp;&nbsp;
		�B�~�����I��: <input style="text-align: center;" type="text" name="Pl_Calc_xGrowth" size=3 maxlength=4 value=0 onChange="numParse(this);objPl.statChanged();"></td>
</tr>
<tr>
	<td align=center colspan=2>�H������:<select name="pl_type" onChange="objPl.statChanged();">
		<option value=nat selected>�@��H
		<option value=ext>Extended
		<option value=enh>�j�ƤH
		<option value=psy>���ʤO
		<option value=nt>NT
		<option value=co>Coordinator
	</select> (<span id=pl_type_dis_name>�@��</span>)</td>
</tr>
<tr>
	<td align=center>SEED Mode: <input name=pl_seed_mode type=checkbox onClick="objPl.statChanged();"></td>
	<td align=left>EXAM System Activated: <input name=pl_exam_activate type=checkbox onClick="objPl.statChanged();"></td>
</tr>
<tr>
	<td colspan=2><hr>Cookies �x�s/���J:
		<select name="selSlotA">
			<option value='1'>�O�� (1)</option>
			<option value='2'>�O�� (2)</option>
			<option value='3'>�O�� (3)</option>
			<option value='4'>�O�� (4)</option>
			<option value='5'>�O�� (5)</option>
		</select>
		<input type="button" value="�x�s" name="SaveBtn" onClick="objPl.saveToCookie(document.Calculator.selSlotA.value);alert('��Ƥw�x�s�I');">
		<input type="button" value="���J" name="LoadBtn" onClick="objPl.LoadFromCookie(document.Calculator.selSlotA.value, objOp);">
		&nbsp; &nbsp; &nbsp; �r��ץX/�פJ: 
		<input type="button" value="�ץX" name="ExportStr" onClick="document.Calculator.dataString.value=objPl.dataToStr();alert('��Ƥw�ץX�I');">
		<input type="button" value="�פJ" name="ImportStr" onClick="objPl.strToData(document.Calculator.dataString.value,objOp);">
	</td>
</tr>
<tr>
	<td colspan=2><input type="text" name="dataString" value="" style="width: 100%"></td>
</tr>
</table>

</form>
<form name=player_calc>
<hr>

�Z���B�˳ơB����D�ﾹ:

<table border=0 width=100%>
	<tr>
		<td>
			<table align=center width=800>
				<tr valign=top>
					<td align=right width=350>�Z��: <select name=wepa onChange="objPl.switchWep(objOp,'a');"> <?php echo $Wep_Selection; ?> </select>
						<br>���U�˳�: <select name=eq_wep onChange="objPl.switchWep(objOp,'e');"><?php echo $Wep_Selection; ?></select>
						<br>�`�W�˳�: <select name=p_equip onChange="objPl.switchWep(objOp,'p');"><?php echo $Wep_Selection; ?></select>
						<hr>
						<table width=100%>
							<tr>
								<td align=left>�S���O��:
								<br><span id=pl_spec_pool></span>
								<br>�Z��/�ݩ�:
								<br><span id=pl_range></span><span id=pl_attribute></span>
								</td>
							</tr>
						</table>
					</td>
					<td align=left>�Z���򥻧����O: <span id=weapon_atk_raw>0</span> + ��y�[�� <input type=text name=weapon_atk_add value=0 style="text-align: center;" onChange="numParse(this);objPl.AdjustSt(objOp);" size=4>
						<br>�Z�������O: <span id=weapon_atk>0</span>
						<br>�Z���򥻦^��: <span id=weapon_rds_raw>0</span>+ ��y�[�� <input type=text name=weapon_rds_add value=0 style="text-align: center;" onChange="numParse(this);objPl.AdjustSt(objOp);" size=4>
						<br>�Z���^��: <span id=weapon_rds>0</span>
						<br>�Z���򥻩R��: <span id=weapon_hit_raw>0</span>+ ��y�[�� <input type=text name=weapon_hit_add value=0 style="text-align: center;" onChange="numParse(this);objPl.AdjustSt(objOp);" size=4>
						<br>�Z���R��: <span id=weapon_hit>0</span>
						<br>�Z���z���`�ˮ`�O: <span id=weapon_t_dam>0</span>
					</td>
				</tr>
				<tr><td colspan=2><hr width=90%></td></tr>
				<tr valign=top>
					<td align=center valign=center width=350>
						����: <select name=pl_ms onChange="objPl.switchWep(objOp,'ms');"> <?php echo $MS_Selection; ?> </select>
					</td>
					<td align=left>
						�����O:<br>
						<table align=center width=400>
							<tr>
								<td>Attacking: <span id="ms_atf">0</span> + <input type=text name="ms_atf_c" value=0 style="text-align: center;" onChange="numParse(this);objPl.AdjustSt(objOp);" size=2 maxlength=2> (<span id="ms_atf_t">0</span>)</td>
								<td>Defending: <span id="ms_def">0</span> + <input type=text name="ms_def_c" value=0 style="text-align: center;" onChange="numParse(this);objPl.AdjustSt(objOp);" size=2 maxlength=2> (<span id="ms_def_t">0</span>)</td>
							</tr>
							<tr>
								<td>Mobility: <span id="ms_ref">0</span> + <input type=text name="ms_ref_c" value=0 style="text-align: center;" onChange="numParse(this);objPl.AdjustSt(objOp);" size=2 maxlength=2> (<span id="ms_ref_t">0</span>)</td>
								<td>Targeting: <span id="ms_taf">0</span> + <input type=text name="ms_taf_c" value=0 style="text-align: center;" onChange="numParse(this);objPl.AdjustSt(objOp);" size=2 maxlength=2> (<span id="ms_taf_t">0</span>)</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<hr>

�ĤH�D�ﾹ:

<table align=center width=800>
	<tr valign=top>
		<td align=right width=350>�Z��: <select name=op_wepa onChange="objOp.switchWep(objPl,'a');"> <?php echo $Wep_Selection; ?> </select>
			<br>���U�˳�: <select name=op_eq_wep onChange="objOp.switchWep(objPl,'e');"><?php echo $Wep_Selection; ?></select>
			<br>�`�W�˳�: <select name=op_p_equip onChange="objOp.switchWep(objPl,'p');"><?php echo $Wep_Selection; ?></select>
			<hr><table width=100%>
				<tr>
					<td align=left>�S���O��:
						<br><span id=op_spec_pool></span>
						<br>�Z��/�ݩ�:
						<br><span id=op_range></span><span id=op_attribute></span>
					</td>
				</tr>
			</table>
		</td>
		<td align=left>�Z���򥻧����O: <span id="op_weapon_atk_raw">0</span> + ��y�[�� <input type=text name="op_weapon_atk_add" style="text-align: center;" value=0 onChange="numParse(this);objOp.AdjustSt(objPl);" size=4>
			<br>�Z�������O: <span id="op_weapon_atk">0</span>
			<br>�Z���򥻦^��: <span id="op_weapon_rds_raw">0</span>+ ��y�[�� <input type=text name="op_weapon_rds_add" style="text-align: center;" value=0 onChange="numParse(this);objOp.AdjustSt(objPl);" size=4>
			<br>�Z���^��: <span id="op_weapon_rds">0</span>
			<br>�Z���򥻩R��: <span id="op_weapon_hit_raw">0</span>+ ��y�[�� <input type=text name="op_weapon_hit_add" style="text-align: center;" value=0 onChange="numParse(this);objOp.AdjustSt(objPl);" size=4>
			<br>�Z���R��: <span id="op_weapon_hit">0</span>
			<br>�Z���z���`�ˮ`�O: <span id="op_weapon_t_dam">0</span>
		</td>
	</tr>
	<tr><td colspan=2><hr width=90%></td></tr>
	<tr>
		<td width=350>����: <select name="op_ms" onChange="objOp.switchWep(objPl,'ms');">
			<?php echo $MS_Selection;?>
			</select>
		</td>
		<td>
			�����O:<br>
			<table align=center width=400>
				<tr>
					<td>Attacking: <span id="op_ms_atf">0</span> + <input type=text name="op_ms_atf_c" value=0 style="text-align: center;" onChange="numParse(this);objOp.AdjustSt(objPl);" size=2 maxlength=2> (<span id="op_ms_atf_t">0</span>)</td>
					<td>Defending: <span id="op_ms_def">0</span> + <input type=text name="op_ms_def_c" value=0 style="text-align: center;" onChange="numParse(this);objOp.AdjustSt(objPl);" size=2 maxlength=2> (<span id="op_ms_def_t">0</span>)</td>
				</tr>
				<tr>
					<td>Mobility: <span id="op_ms_ref">0</span> + <input type=text name="op_ms_ref_c" value=0 style="text-align: center;" onChange="numParse(this);objOp.AdjustSt(objPl);" size=2 maxlength=2> (<span id="op_ms_ref_t">0</span>)</td>
					<td>Targeting: <span id="op_ms_taf">0</span> + <input type=text name="op_ms_taf_c" value=0 style="text-align: center;" onChange="numParse(this);objOp.AdjustSt(objPl);" size=2 maxlength=2> (<span id="op_ms_taf_t">0</span>)</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align=left colspan=2>
			<table align=center>
				<tr>
					<td colspan=4 align=left>���v��O:</td>
				</tr>
				<tr>
					<td>Attacking:<select name="Op_At" style="text-align: center;" onChange="objOp.statChanged();"><script language="JavaScript">for(a=1;a<=150;a++){document.write('<option value='+a+'>'+a)}</script>
					</select> + <span id="op_pi_atf">0</span> ( + <span id="op_pi_xat">0</span> )</td>
					<td>Defending:<select name="Op_De" style="text-align: center;" onChange="objOp.statChanged();"><script language="JavaScript">for(a=1;a<=150;a++){document.write('<option value='+a+'>'+a)}</script>
					</select> + <span id="op_pi_def">0</span> ( + <span id="op_pi_xde">0</span> )</td>
					<td align=right>����:</td>
					<td width=50><span id="LevelR_Op">1</span></td>
					</tr>
				<tr>
					<td>Reacting:<select name="Op_Re" style="text-align: center;" onChange="objOp.statChanged();"><script language="JavaScript">for(a=1;a<=150;a++){document.write('<option value='+a+'>'+a)}</script>
					</select> + <span id="op_pi_ref">0</span> ( + <span id="op_pi_xre">0</span> )</td>
					<td>Targeting:<select name="Op_Ta" style="text-align: center;" onChange="objOp.statChanged();"><script language="JavaScript">for(a=1;a<=150;a++){document.write('<option value='+a+'>'+a)}</script>
					</select> + <span id="op_pi_taf">0</span> ( + <span id="op_pi_xta">0</span> )</td>
					<td align=right>�һ��`�����I��:</td>
					<td><span id=GrowR_Op>&nbsp;</span></td>
				</tr>
				<tr>
					<td align=right colspan=3>�|�l�����I��:</td>
					<td><span id=PtLeft_Op>&nbsp;</span></td>
				</tr>
				<tr>
					<td align=center colspan=2>
						��ʿ�J���� <input name="Op_dis_spcflv" type=checkbox onClick="objOp.chk_dis_spcflv();objOp.statChanged();">: <input disabled onChange="numParse(this);objOp.statChanged();" style="text-align: center;" type="text" name="Op_Calc_Level" value=1 size=3 maxlength=3>&nbsp;&nbsp;&nbsp;&nbsp;
						�B�~�����I��: <input style="text-align: center;" type="text" name="Op_Calc_xGrowth" size=3 maxlength=4 value=0 onChange="numParse(this);objOp.statChanged();"></td>
				</tr>
				<tr>
					<td align=center colspan=2>�H������:<select name="op_type" onChange="objOp.statChanged();">
						<option value='nat' selected >�@��H</option>
						<option value='ext'>Extended</option>
						<option value='enh'>�j�ƤH</option>
						<option value='psy'>���ʤO</option>
						<option value='nt'>NT</option>
						<option value='co'>Coordinator
					</select> (<span id=op_type_dis_name>�@��</span>)</td>
				</tr>
				<tr>
					<td align=center>SEED Mode: <input name=op_seed_mode type=checkbox onClick="objOp.statChanged();"></td>
					<td align=left>EXAM System Activated: <input name=op_exam_activate type=checkbox onClick="objOp.statChanged();"></td>
				</tr>
				<tr>
					<td colspan=2>Cookies �x�s/���J:
						<select name="selSlotB">
							<option value='1'>�O�� (1)</option>
							<option value='2'>�O�� (2)</option>
							<option value='3'>�O�� (3)</option>
							<option value='4'>�O�� (4)</option>
							<option value='5'>�O�� (5)</option>
						</select>
						<input type="button" value="�x�s" name="SaveBtn" onClick="objOp.saveToCookie(document.player_calc.selSlotB.value);alert('��Ƥw�x�s�I');">
						<input type="button" value="���J" name="LoadBtn" onClick="objOp.LoadFromCookie(document.player_calc.selSlotB.value, objPl);">
						&nbsp; &nbsp; &nbsp; �r��ץX/�פJ: 
						<input type="button" value="�ץX" name="ExportStr" onClick="document.player_calc.OpdataString.value=objOp.dataToStr();alert('��Ƥw�ץX�I');">
						<input type="button" value="�פJ" name="ImportStr" onClick="objOp.strToData(document.player_calc.OpdataString.value,objPl);">
					</td>
				</tr>
				<tr>
					<td colspan=2><input type="text" name="OpdataString" value="" style="width: 100%"></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>
<hr>
�w�p���G�p�⾹:


<form name=prediction_calc>

�v��Ԫk: <select name="pl_tactics" onChange="objPl.switchTactics(objOp);"> <?php echo $Tactics_Selection; ?> </select><br>
�Ĥ�Ԫk: <select name="op_tactics" onChange="objOp.switchTactics(objPl);"> <?php echo $Tactics_Selection; ?> </select><br>
<br>
<input type=button onClick="pd_Calc(objPl, objOp);" value='�}�l�p��'>

<table align=center width=800 border=1 bordercolor=#111111 style="border-collapse: collapse">
	<tr>
		<td colspan=4>�v��:</td>
	</tr>
	<tr>
		<td width=200 align=right>�C�^�w�p�ˮ`�O:</td>
		<td width=200 align=center><span id="pl_dam_per_rd_min">0</span> ~ <span id="pl_dam_per_rd_max">0</span></td>
		<td width=200 align=right>�C�^�����ˮ`�O:</td>
		<td width=200 align=center><span id="pl_dam_average">0</span></td>
	</tr>
	<tr>
		<td width=200 align=right>�C�^�w�p�R���v:</td>
		<td width=200 align=center><span id="pl_accuracy">0</span>%</td>
		<td width=200 align=right>�w�p�R������:</td>
		<td width=200 align=center><span id="pl_expected_hits">0</span>��</td>
	</tr>
	<tr>
		<td width=200 align=right>�w�p�`�ˮ`�O:</td>
		<td width=200 align=center><span id="pl_dam_min">0</span> ~ <span id="pl_dam_max">0</span></td>
		<td width=200 align=right>�w�p�����`�ˮ`�O:</td>
		<td width=200 align=center><span id="pl_expected_damage">0</span></td>
	</tr>
	<tr>
		<td colspan=4>�Ĥ�:</td>
	</tr>
	<tr>
		<td width=200 align=right>�C�^�w�p�ˮ`�O:</td>
		<td width=200 align=center><span id="op_dam_per_rd_min">0</span> ~ <span id="op_dam_per_rd_max">0</span></td>
		<td width=200 align=right>�C�^�����ˮ`�O:</td>
		<td width=200 align=center><span id="op_dam_average">0</span></td>
	</tr>
	<tr>
		<td width=200 align=right>�C�^�w�p�R���v:</td>
		<td width=200 align=center><span id="op_accuracy">0</span>%</td>
		<td width=200 align=right>�w�p�R������:</td>
		<td width=200 align=center><span id="op_expected_hits">0</span>��</td>
	</tr>
	<tr>
		<td width=200 align=right>�w�p�`�ˮ`�O:</td>
		<td width=200 align=center><span id="op_dam_min">0</span> ~ <span id="op_dam_max">0</span></td>
		<td width=200 align=right>�w�p�����`�ˮ`�O:</td>
		<td width=200 align=center><span id="op_expected_damage">0</span></td>
	</tr>
</table>

</form>

<!-- Insert JavaScript-->

<script language="JavaScript">

	// Object: Pl Initialize

	objPl.setElements(document.getElementById("LevelR"), document.getElementById("GrowR"), document.getElementById("PtLeft"), document.Calculator.pl_seed_mode, document.Calculator.pl_exam_activate);
	objPl.setAbilityElm(document.getElementById("pl_pi_atf"), document.getElementById("pl_pi_def"), document.getElementById("pl_pi_ref"), document.getElementById("pl_pi_taf"), document.getElementById("pl_pi_xat"), document.getElementById("pl_pi_xde"), document.getElementById("pl_pi_xre"), document.getElementById("pl_pi_xta"));

	// Basics
	objPl.oTypeName = document.getElementById('pl_type_dis_name');
	objPl.oTypeInf = document.Calculator.pl_type;
	objPl.setXGrowth(document.Calculator.Pl_Calc_xGrowth);
	objPl.setLevel(document.Calculator.Pl_Calc_Level);
	objPl.setSpcLv(document.Calculator.Pl_dis_spcflv);
	objPl.setBase(document.Calculator.At,document.Calculator.De,document.Calculator.Re,document.Calculator.Ta);

	// MS Elements
	objPl.setMS_elms(document.player_calc.pl_ms);
	objPl.setMS_At_Elms(document.getElementById("ms_atf"), document.getElementById("ms_atf_t"), document.player_calc.ms_atf_c);
	objPl.setMS_De_Elms(document.getElementById("ms_def"), document.getElementById("ms_def_t"), document.player_calc.ms_def_c);
	objPl.setMS_Re_Elms(document.getElementById("ms_ref"), document.getElementById("ms_ref_t"), document.player_calc.ms_ref_c);
	objPl.setMS_Ta_Elms(document.getElementById("ms_taf"), document.getElementById("ms_taf_t"), document.player_calc.ms_taf_c);
	
	// Weapon Elements
	objPl.setWeaponElms(document.player_calc.wepa, document.player_calc.eq_wep, document.player_calc.p_equip, document.getElementById('weapon_t_dam'), document.getElementById('pl_spec_pool'), document.getElementById('pl_range'), document.getElementById('pl_attribute'));
	objPl.setWeaponARH(document.getElementById("weapon_atk"), document.getElementById("weapon_rds"), document.getElementById("weapon_hit"));
	objPl.setWeaponARH_Raw(document.getElementById("weapon_atk_raw"), document.getElementById("weapon_rds_raw"), document.getElementById("weapon_hit_raw"));
	objPl.setWeaponARH_Add(document.player_calc.weapon_atk_add, document.player_calc.weapon_rds_add, document.player_calc.weapon_hit_add);
	
	// Calculator Elements
	objPl.setTactics(document.prediction_calc.pl_tactics);
	objPl.oDprd_Max = document.getElementById("pl_dam_per_rd_max");
	objPl.oDprd_Min = document.getElementById("pl_dam_per_rd_min");
	objPl.oAccPrd   = document.getElementById("pl_accuracy");
	objPl.oExpdHits = document.getElementById("pl_expected_hits");
	objPl.oDamMin   = document.getElementById("pl_dam_min");
	objPl.oDamMax   = document.getElementById("pl_dam_max");
	objPl.oDamAvg   = document.getElementById("pl_dam_average");
	objPl.oExpdDam  = document.getElementById("pl_expected_damage");
	
	// Object: Op Initialize

	objOp.setElements(document.getElementById("LevelR_Op"), document.getElementById("GrowR_Op"), document.getElementById("PtLeft_Op"), document.player_calc.op_seed_mode, document.player_calc.op_exam_activate);
	objOp.setAbilityElm(document.getElementById("op_pi_atf"), document.getElementById("op_pi_def"), document.getElementById("op_pi_ref"), document.getElementById("op_pi_taf"), document.getElementById("op_pi_xat"), document.getElementById("op_pi_xde"), document.getElementById("op_pi_xre"), document.getElementById("op_pi_xta"));

	// Basics
	objOp.oTypeName = document.getElementById('op_type_dis_name');
	objOp.oTypeInf = document.player_calc.op_type;
	objOp.setXGrowth(document.player_calc.Op_Calc_xGrowth);
	objOp.setLevel(document.player_calc.Op_Calc_Level);
	objOp.setSpcLv(document.player_calc.Op_dis_spcflv);
	objOp.setBase(document.player_calc.Op_At,document.player_calc.Op_De,document.player_calc.Op_Re,document.player_calc.Op_Ta);

	// MS Elements
	objOp.setMS_elms(document.player_calc.op_ms);
	objOp.setMS_At_Elms(document.getElementById("op_ms_atf"), document.getElementById("op_ms_atf_t"), document.player_calc.op_ms_atf_c);
	objOp.setMS_De_Elms(document.getElementById("op_ms_def"), document.getElementById("op_ms_def_t"), document.player_calc.op_ms_def_c);
	objOp.setMS_Re_Elms(document.getElementById("op_ms_ref"), document.getElementById("op_ms_ref_t"), document.player_calc.op_ms_ref_c);
	objOp.setMS_Ta_Elms(document.getElementById("op_ms_taf"), document.getElementById("op_ms_taf_t"), document.player_calc.op_ms_taf_c);
	
	// Weapon Elements
	objOp.setWeaponElms(document.player_calc.op_wepa, document.player_calc.op_eq_wep, document.player_calc.op_p_equip, document.getElementById('op_weapon_t_dam'), document.getElementById('op_spec_pool'), document.getElementById('op_range'), document.getElementById('op_attribute'));
	objOp.setWeaponARH(document.getElementById("op_weapon_atk"), document.getElementById("op_weapon_rds"), document.getElementById("op_weapon_hit"));
	objOp.setWeaponARH_Raw(document.getElementById("op_weapon_atk_raw"), document.getElementById("op_weapon_rds_raw"), document.getElementById("op_weapon_hit_raw"));
	objOp.setWeaponARH_Add(document.player_calc.op_weapon_atk_add, document.player_calc.op_weapon_rds_add, document.player_calc.op_weapon_hit_add);
	
	// Calculator Elements
	objOp.setTactics(document.prediction_calc.op_tactics);
	objOp.oDprd_Max = document.getElementById("op_dam_per_rd_max");
	objOp.oDprd_Min = document.getElementById("op_dam_per_rd_min");
	objOp.oAccPrd   = document.getElementById("op_accuracy");
	objOp.oExpdHits = document.getElementById("op_expected_hits");
	objOp.oDamMin   = document.getElementById("op_dam_min");
	objOp.oDamMax   = document.getElementById("op_dam_max");
	objOp.oDamAvg   = document.getElementById("op_dam_average");
	objOp.oExpdDam  = document.getElementById("op_expected_damage");

</script>

<hr>

<table align=center width=60% border=1 style="border-collapse: collapse;font-size: 12; font-family: Arial" bordercolor="#000000">
	<tr>
		<td colspan=2><B>��s��x</B></td>
	</tr>
	<!-- �ĤE�h -->
	<tr>
		<td align=right width=30>���:</td>
		<td >2010�~2��16��</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>- v3.0�] ��
			<br>�@ - php-eb �����䴩: v0.49 �԰��t��, �ݩʮĪG
			<br>�@ �@ - SEED ���ĪG��s (�@��H�[�j)
			<br>�@ �@ - �H�ص��� 11 - 16 (Debugged)
			<br>�@ �@ - �I�ƥ[����s (�C15%��O +1%�ĪG)
			<br>�@ - ���䴩�Z���ĪG�B�M��
		</td>
	</tr>
	<!-- �ĤK�h -->
	<tr>
		<td align=right width=30>���:</td>
		<td >2010�~1��17��</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>- v3.0�\ ��
			<br>�@ - ��� Object-based ���c
			<br>�@ - �s�����䴩: �����̷s���� Mozilla Firefox �� Google Chrome �s����, ���A���� Internet Explorer �F
			<br>�@ - php-eb �����䴩: v0.47 �԰��t��, �X���t��
			<br>�@ �@ - �w�L�o�U�ŹϪ��~
			<br>�@ - �x�s�B���J�B�ץX�B�פJ�\��
		</td>
	</tr>
	<!-- �ĤC�h -->
	<tr>
		<td align=right width=30>���:</td>
		<td >2009�~1��3��</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>- ��s�u�ˮ`��K�ĪG�v
			<br>- ��K�q: 3500, 2500, 1500, 1000, 500
		</td>
	</tr>
	<!-- �Ĥ��h -->
	<tr>
		<td align=right width=30>���:</td>
		<td >2008�~11��25��</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>- �ĥΤF�s�g�礽��
			<br>- �g��|�H�Ʀr�榡��X�F
		</td>
	</tr>
	<!-- �Ĥ��h -->
	<tr>
		<td align=right width=30>���:</td>
		<td >2008�~11��13��</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>- ��O�W������
			<br>�@- �{�b���ɨ� 150 �F
		</td>
	</tr>
	<!-- �ĥ|�h -->
	<tr>
		<td align=right width=30>���:</td>
		<td >2008�~05��10��</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>- �[�J�Ԫk���䴩
			<br>- �[�J�s���� SEED Mode �� EXAM System �䴩
			<br>�[�J���Ԫk�S�Ĥ䴩:
			<br>�@ - �G�s���B�T�s�� (*�u����Ԫk)
			<br>���|�[�J�䴩���Ԫk�S��: (�Y�t��q���e�����|�[�J)
			<br>�@- ���u�o�g, ����, �������
			<br>- �b�o�̥[�J��s��x
		</td>
	</tr>
	<!-- �ĤT�h -->
	<tr>
		<td align=right width=30>���:</td>
		<td >2008�~04��26��</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>�[�J�S�Ĥ䴩:
			<br>�@ - �������m, �e��
			<br>�@ - �T�D
			<br>�@ - �[�t, �W�e, �{��, �k��
			<br>�@ - ²����i, �j�O���i, �̨ΤƱ��i, ���ű��i, ���ű��i
			<br>�@ - �����z�Z, �p�F�z�Z
			<br>�@ - �շ�, �˷�, ����, �w��
			<br>�@ - �۰���w, ���Ůշ�, �L�~�շ�, �h����w, ������w
			<br>�@ - ²�樾�m, ���`���m, �j�ƨ��m, ���Ũ��m, �̲ר��m
			<br>�@ - ���, �ܿ�, �z�A, ���, �Ŷ��۹�첾
			<br>�@ - ������(���Ѥ@�q���s�W��), ����
			<br>- �򥻤W�w����, �i�@�԰��t�Υi��ʰѦҥ�
		</td>
	</tr>
	<!-- �ĤG�h -->
	<tr>
		<td align=right width=30>���:</td>
		<td >2008�~04��24��</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>�[�J�S�Ĥ䴩:
			<br>�@ - ����
			<br>�@ - ���O (�]�A���ʤO�����O)
			<br>- �{�b�|��ܳ����p�⦳�Ī��S�ĤF
		</td>
	</tr>
	<!-- �Ĥ@�h -->
	<tr>
		<td align=right width=30>���:</td>
		<td >2008�~04��23��</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>- v2.0�\ ��
			<br>�@ - �}�o�۰t�I�uphp-eb �t�I�p��u��v v1.1 �� v1.2 ��
			<br>�@�@�@ - �ѩ�M�ΰt�I�p��u���, �~�H�� v1.1 �O�̷s��, �ҥH�D�n�� v1.1 ��y�Ӧ�
			<br>�@�@�@ - �w�[�J�Ҧ� v1.2 ������, �έץ��쥻 v1.1 ���� Bug
			<br>�@ - �۰ʮM���Z���B����B�H�إ[�����
			<br>�@ - �i�H�s�Ĥ誺��Ƥ@���p��
			<br>�@�@ - �۰ʭp������w�p�����O�B�R���v�B�̲׶ˮ`
			<br>���[�J���\��:
			<br>�@ - �٥��]�w����S��, �|�ɧ֥[�J
		</td>
	</tr>
</table>


<!--- --- Separating Line--- -->

<br>
<br>
<a href='http://v2alliance.no-ip.org' style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: Emulator &copy; 2005-2010 v2Alliance All Rights Reserved<Br>Script Based on php-eb StatusPoint Calculator v1.2 &copy; 2005-2008 v2Alliance All Rights Reserved</a>
</body>
</html>