<?php
$mode = ( isset($_GET['action']) ) ? $_GET['action'] : $_POST['action'];
include('cfu.php');
if (empty($PriTarget)) $PriTarget = 'Alpha';
if (empty($SecTarget)) $SecTarget = 'Beta';
if (!isset($Game_Scrn_Type)) $Game_Scrn_Type = 1;
postHead('');
AuthUser("$Pl_Value[USERNAME]","$Pl_Value[PASSWORD]");
if ($CFU_Time >= $TIMEAUTH+$TIME_OUT_TIME || $TIMEAUTH <= $CFU_Time-$TIME_OUT_TIME){echo "�s�u�O�ɡI<br>�Э��s�n�J�I";exit;}
GetUsrDetails("$Pl_Value[USERNAME]",'Gen','Game');
if ($Game['organization'])
$Pl_Org = ReturnOrg("$Game[organization]");
else $Pl_Org = false;
//Special Commands GUI
if ($mode=='Start'){
	echo "<font style=\"font-size: 12pt\">���߲�´</font>";
	printTHR();
	if ($actionb == 'A'){
	echo "<form action=organization.php?action=Start method=post name=mainform>";
	echo "<input type=hidden value='B' name=actionb>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

	echo "<script language=\"Javascript\">";
	echo "function cfmStartOrg(){";
	echo "if ($OrganizingCost > $Gen[cash]){alert('���������C');return false;}";
	echo "else if (mainform.org_name.value == ''){alert('�Х���J��´�W�١C');return false;}";
	echo "else {if (confirm('���߲�´�ݭn ". number_format($OrganizingCost) ." ���A�T�w�ܡH')==true){return true;}";
	echo "else {return false;}}";
	echo "}</script>";

	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">���߲�´�һݸ��: </b></td></tr>";
	echo "<tr><td align=left>���߲�´�ݭn: ". number_format($OrganizingCost) ." ��<br>";
	echo "��´�W��: <input type=text name=org_name maxlength=32 size=27><br>(�`�N����P�{����a�W�٤@��)<br>";
	echo "�N���C��: <br><center>";
	$br=$ct_default=0;
	foreach ($MainColors as $TheColor){$br++;$ct_default++;
	echo "<input type=\"radio\" name=\"org_color\" value=#".$TheColor;
	if ($ct_default==1) echo " checked";
	echo "><font color=#".$TheColor.">��</font> &nbsp;&nbsp; ";
	if ($br==6){echo"<br>";$br=0;}	}
	echo "<input type=submit value=\"�T�w���߲�´\" onClick=\"return cfmStartOrg();\">";
	echo "</tr></td></form></table>";
	}

	if ($actionb == 'B'){
	if ($OrganizingCost > $Gen['cash']){echo "���������C";postFooter();exit;}
	if ($Gen['fame'] < $OrganizingFame && $Gen['fame'] > $OrganizingNotor){echo "�W�n�����C";postFooter();exit;}

	$Gen['cash'] -= $OrganizingCost;
	$Gen['fame'] += 1;
	if( $Game['rank'] < 48000 ) $Game['rank'] = 48000;

	$HistoryWrite = "<font color=\"$Gen[color]\">$Game[gamename]</font> �Х� <font color=\"$org_color\">$org_name</font> ��´�A���w��Ҧ��H�ۥѥ[�J�ΰh�X�C";
	WriteHistory($HistoryWrite);
	//Enter Organization Info
	$sql = ("INSERT INTO ".$GLOBALS['DBPrefix']."phpeb_user_organization (id, name, color) VALUES('$CFU_Time','$org_name','$org_color')");
	mysql_query($sql) or die ('<br><center>���৹�����U<br>��]:' . mysql_error() . '<br>');

	$restriction = array("|","`","'","--","\"","\\");
	$org_name = str_replace($restriction,'',$org_name);
	$org_name = preg_replace('/<[^<>]*>/','',$org_name);

	$sql = ("SELECT id FROM `".$GLOBALS['DBPrefix']."phpeb_user_organization` WHERE name='". $org_name ."'");
	$query = mysql_query($sql) or die ('�L�k���o�򥻸�T, ��]:' . mysql_error() . '<br>');
	$New_Org = mysql_fetch_row($query);

	//��s Game Info
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `rank` = '".($Game['rank'])."', `rights` = '1', `organization` = '$New_Org[0]' WHERE `username` = '".$Pl_Value['USERNAME']."' LIMIT 1");
	$query = mysql_query($sql) or die ('�L�k���o�򥻸�T, ��]:' . mysql_error() . '<br>');

	//��s General Info
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `cash` = '$Gen[cash]', `fame` = '$Gen[fame]' WHERE `username` = '".$Pl_Value['USERNAME']."' LIMIT 1");
	$query = mysql_query($sql) or die ('�L�k���o�򥻸�T, ��]:' . mysql_error() . '<br>');

	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
	echo "<p align=center style=\"font-size: 16pt\">���߲�´�����F�I<br>�դU���W�n�W��1�I�C<input type=submit value=\"��^\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";
	}
}
elseif($mode == 'Employ'){
	if ($actionb == 'C'){
		$CancelFlag = '';
		if (!$Employer){echo "�A�Q���ܽЧr�H";postFooter();exit;}
		elseif ($Game['rights']=='1'){echo "�D�u����Q�ܽСC";postFooter();exit;}
		else {$Og_Org=$Pl_Org;$Pl_Org = ReturnOrg($Employer);}if (!$Og_Org){$Og_Org =  ReturnOrg('0');}
	
		if(strpos($Pl_Org['request_list'],'!'.$Pl_Value['USERNAME'].',') === false){$EmployMsg = "�Ӳ�´�S���ܽбz�C";$CancelFlag = '1';}
		else{
			$str = "/(!$Pl_Value[USERNAME], )+/";
			$Pl_Org['request_list'] = preg_replace($str,'',$Pl_Org['request_list']);
		}
	
		//��s Org Info
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `request_list` = '$Pl_Org[request_list]' WHERE `id` = '".$Pl_Org['id']."' LIMIT 1");
		$query = mysql_query($sql) or die ('�L�k���o��´��T, ��]:' . mysql_error() . '<br>');
	
		//��s General Info
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `request` = '' WHERE `username` = '".$Pl_Value['USERNAME']."' LIMIT 1");
		$query = mysql_query($sql) or die ('�L�k���o�򥻸�T, ��]:' . mysql_error() . '<br>');
	
		if ($actionc == 'Accept' && !$CancelFlag){
			if($Game['organization'] == 0)	$Game['rank'] += 2000;
			if($Game['rank'] > 100000)	$Game['rank'] = 100000;
			//��s Game Info
			$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `rank` = ".($Game['rank']).", `rights` = '0', `organization` = '$Pl_Org[id]' WHERE `username` = '".$Pl_Value['USERNAME']."' LIMIT 1");
			$query = mysql_query($sql) or die ('�L�k���o�C����T, ��]:' . mysql_error() . '<br>');
			$EmployMsg = "���\�[�J��´�I";
			$HistoryWrite = "<font color=\"$Og_Org[color]\">$Og_Org[name]</font> �� <font color=\"$Gen[color]\">$Game[gamename]</font> ���ܽХ[�J <font color=\"$Pl_Org[color]\">$Pl_Org[name]</font>�C";
			WriteHistory($HistoryWrite);
		}
	
		elseif ($actionc == 'Refuse' && !$CancelFlag){
			$EmployMsg = "���\�ڵ��[�J��´�C";
			$HistoryWrite = "<font color=\"$Og_Org[color]\">$Og_Org[name]</font> �� <font color=\"$Gen[color]\">$Game[gamename]</font> �ڵ��F�[�J <font color=\"$Pl_Org[color]\">$Pl_Org[name]</font>���ܽСC";
			WriteHistory($HistoryWrite);
		}
	
		echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn>";
		echo "<p align=center style=\"font-size: 16pt\"><br><br><br>$EmployMsg<input type=submit value=\"��^\" ";
		if($Game_Scrn_Type == 1)
		echo "onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"";
		echo "></p>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
		echo "</form>";
		postFooter();
		echo "</body>";
		echo "</html>";
		exit;
	}

	//
	// End of Action C
	//

echo "<font style=\"font-size: 12pt\">�۶ҤH�~</font>";
printTHR();

if ($actionb == 'A'){
		echo "<form action=organization.php?action=Employ method=post name=mainform>";
		echo "<input type=hidden value='B' name=actionb>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	
		echo "<script language=\"Javascript\">";
		echo "function cfmEmploy(){";
		echo "if (mainform.EmployTar.value == ''){alert('�Х���J�n���󪺤H�C');return false;}";
		echo "else {if (confirm('�ܽХؼХ[�J��´�A�T�w�ܡH')==true){return true;}";
		echo "else {return false;}}";
		echo "}</script>";
	
		echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
		echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">�۶ҤH�~: </b></td></tr>";
	
		unset($sql,$query,$AvailPersons);
		$sql = ("SELECT `username`,`gamename`,`organization` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `username` != '".$Pl_Value['USERNAME']."' AND `organization` != '$Game[organization]' AND !`rights` OR !`organization` ORDER BY `organization` ASC");
		$query = mysql_query($sql) or die(mysql_error());
		$AvailPersons = mysql_fetch_array($query);
		$EmployOpt = '';
		do{
		$TarOrg = ReturnOrg($AvailPersons['organization']);
		$EmployOpt .= "<option value='$AvailPersons[username]'>$AvailPersons[gamename] ($TarOrg[name])";
		unset($AvailPersons,$TarOrg);
		}
		while ($AvailPersons = mysql_fetch_array($query));
	
		if ($EmployOpt){
			echo "<tr><td align=left>�V <select name=EmployTar>$EmployOpt</select><br><input type=submit value=\"�ܽ�\" onClick=\"return cfmEmploy();\"> �o�X�ܽЫH�C</td></tr>";
		}
	
	
		if(strpos($Pl_Org['request_list'],'!'.$Pl_Value['USERNAME'].',') !== false){
			$str = "/(!$Pl_Value[USERNAME], )+/";
			$Pl_Org['request_list'] = preg_replace($str,'',$Pl_Org['request_list']);
		}
	
		if ($Pl_Org['request_list']){
		echo "<tr><td align=left>���o��^�Ъ��ܽЫH: <br>";
	
		$Pl_Org['request_list'] = preg_replace('/!| /','',$Pl_Org['request_list']);
		$List_of_Letters = explode(',',$Pl_Org['request_list']);
		unset($TargetName,$TarInfo);
		foreach($List_of_Letters as $TargetName){
		if ($TargetName){
		$sqle = ("SELECT `".$GLOBALS['DBPrefix']."phpeb_user_game_info`.`gamename`, `".$GLOBALS['DBPrefix']."phpeb_user_organization`.`name`, `".$GLOBALS['DBPrefix']."phpeb_user_organization`.`color` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info`, `".$GLOBALS['DBPrefix']."phpeb_user_organization` WHERE `".$GLOBALS['DBPrefix']."phpeb_user_game_info`.`username`='". $TargetName ."' AND `".$GLOBALS['DBPrefix']."phpeb_user_game_info`.`organization` = `".$GLOBALS['DBPrefix']."phpeb_user_organization`.`id`");
		$querye = mysql_query($sqle) or die ('�L�k���o��T, ��]:' . mysql_error() . '<br>');
		$TarInfo = mysql_fetch_array($querye);
		echo "<font color=\"$TarInfo[color]\">$TarInfo[name] �� $TarInfo[gamename]</font><br>";}
		}
		echo "</td></tr>";
		}
		echo "</form></table>";
	}

//
// End of Action A
//

	if ($actionb == 'B'){
	
		if (!$EmployTar || $EmployTar == $Pl_Value['USERNAME']){echo "�A�n����֧r�H";postFooter();exit;}
	
		$Pl_Org = ReturnOrg($Game['organization']);
	
		$Pl_Org['request_list'] .= '!'.$EmployTar.', ';
	
		//��s Org Info
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `request_list` = '$Pl_Org[request_list]' WHERE `id` = '".$Game['organization']."' LIMIT 1");
		$query = mysql_query($sql) or die ('�L�k���o�򥻸�T, ��]:' . mysql_error() . '<br>');
	
		$requesttx = "$Pl_Org[name] �� $Game[gamename] �V�z�o�X�[�J��´���ܽЫH�C<br>�A�n�[�J��´�ܡH<br>";
		$requesttx .= "<input type=hidden name=Employer value=\'$Pl_Org[id]\'>";
	
		//��s General Info
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `request` = '$requesttx' WHERE `username` = '".$EmployTar."' LIMIT 1");
		$query = mysql_query($sql) or die ('�L�k���o�򥻸�T, ��]:' . mysql_error() . '<br>');
	
		echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
		echo "<p align=center style=\"font-size: 16pt\">��´�ܽЫH�w�o�X�C<input type=submit value=\"��^\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
		echo "</form>";
	}

//
// End of Action B
//
}//End of Employ
elseif ($mode == 'LeaveOrg'){
	if (!$Game['organization'] || $Game['rights']){echo "�H�z���������������´�C";postFooter();exit;}
	if ($actionb != 'A' && $actionb != 'B' && $actionb != 'C') {echo "���w�q�ʧ@�I<br>";exit;}
	if ($actionb == 'A'){
		if ($Pl_Org['license'] == 1 || $Pl_Org['license'] == 3)
			{echo "�z����´���e�\�A�p�۲����A�Y�u���Q���}�N�бz�k�`�a�C";postFooter();exit;}
		$Game['rank'] -= 4000;
	}
	else {
		if ($Pl_Org['license'] != 1 && $Pl_Org['license'] != 3)
			{echo "�z�L�ݰk�`�C";postFooter();exit;}
		if ($actionb == 'C') $Gen['fame'] -= 10;
		$Gen['fame'] = floor($Gen['fame']*0.9);
		$Game['rank'] -= 12000;
	}
	if( $Game['rank'] < 0 ) $Game['rank'] = 0;
	//��s Gen Info
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `fame` = '$Gen[fame]' WHERE `username` = '".$Pl_Value['USERNAME']."' LIMIT 1");
	$query = mysql_query($sql) or die ('�L�k���o�C����T, ��]:' . mysql_error() . '<br>');

	if (abs($Gen['fame']) >= 100){
	$HistoryWrite = "<font color=\"$Gen[color]\">$Game[gamename]</font> ���� <font color=\"$Pl_Org[color]\">$Pl_Org[name]</font>�C";
	WriteHistory($HistoryWrite);}

	//��s Game Info
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `rank` = '".($Game['rank'])."', `rights` = '0', `organization` = '0' WHERE `username` = '".$Pl_Value['USERNAME']."' LIMIT 1");
	$query = mysql_query($sql) or die ('�L�k���o�C����T, ��]:' . mysql_error() . '<br>');

	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
	echo "<p align=center style=\"font-size: 16pt\">�w������´�C<input type=submit value=\"��^\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";
	}
//End of LeaveOrg
elseif ($mode == 'LeavePlace'){
	echo "<font style=\"font-size: 12pt\">�h��</font>";
	printTHR();
	if (!$Game['organization'] || !$Game['rights']){echo "�H�z����������h��C";postFooter();exit;}

	if ($Game['rights'] == '1'){$RightsTitle = $RightsClass['Major'];$AllowWho = "`rights` != '1'";}
	elseif ($Game['rights']){$RightsTitle = $RightsClass['Leader'];$AllowWho = "!`rights`";}

	if ($actionb == 'A'){
	echo "<form action=organization.php?action=LeavePlace method=post name=mainform>";
	echo "<input type=hidden value='B' name=actionb>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

	echo "<script language=\"Javascript\">";
	echo "function cfmLeavePlace(){";
	echo "if (mainform.GiveTar.value == ''){alert('�Х���J�n�������H�C');return false;}";
	echo "else {if (confirm('�h�쵹�ؼФH���A�T�w�ܡH')==true){return true;}";
	echo "else {return false;}}";
	echo "}</script>";

	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">�h������: </b></td></tr>";

	unset($sql,$query,$AvailPersons);
	$sql = ("SELECT `username`,`gamename` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `username` != '".$Pl_Value['USERNAME']."'  AND `organization` = '$Game[organization]' AND $AllowWho AND `rank` > 72000 ORDER BY `rank` DESC");
	$query = mysql_query($sql) or die(mysql_error());
	$GiveTarOpt = '';
	while ($AvailPersons = mysql_fetch_array($query))
		$GiveTarOpt .= "<option value='$AvailPersons[username]'>$AvailPersons[gamename]";
	unset($AvailPersons);

	echo "<tr><td align=left>�z���v�O: $RightsTitle <br>";

	if ($GiveTarOpt)
		echo "�i�h�쵹���H:<select name=GiveTar>$GiveTarOpt</select><br><input type=submit value=\"�h��\" onClick=\"return cfmLeavePlace();\">";
	else 	echo "�S���A�X���H��C<br>���쪺�H�������@�w���x���C";
	echo "</td></tr></form></table>";
	}// Action A End

	elseif ($actionb == 'B'){

	if (!$GiveTar){echo "�Х����w�ؼСC";postFooter();exit;}

	$sqlgame = ("SELECT `gamename`,`color` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info`,`".$GLOBALS['DBPrefix']."phpeb_user_general_info` WHERE `".$GLOBALS['DBPrefix']."phpeb_user_game_info`.`username`='". $GiveTar ."'");
	$query_game = mysql_query($sqlgame) or die ('�L�k���o�C����T, ��]:' . mysql_error() . '<br>');
	$GiveTarOpt = mysql_fetch_array($query_game);

	$HistoryWrite = "<font color=\"$Pl_Org[color]\">$Pl_Org[name]</font> �� <font color=\"$Gen[color]\">$Game[gamename]</font> �� $RightsTitle ���v�O���� <font color=\"$GiveTarOpt[color]\">$GiveTarOpt[gamename]</font> �C";
	WriteHistory($HistoryWrite);

	//��s Game Info
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `rights` = '".$Game['rights']."', `organization` = '$Game[organization]' WHERE `username` = '".$GiveTar."' LIMIT 1");
	$query = mysql_query($sql) or die ('�L�k���o�򥻸�T, ��]:' . mysql_error() . '<br>');

	//��s Game Info
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `rights` = '0', `organization` = '$Game[organization]' WHERE `username` = '".$Pl_Value['USERNAME']."' LIMIT 1");
	$query = mysql_query($sql) or die ('�L�k���o�򥻸�T, ��]:' . mysql_error() . '<br>');

	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
	echo "<p align=center style=\"font-size: 16pt\">�h�짹���F�I<input type=submit value=\"��^\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";

	}// Action B End


	else {echo "���w�q�ʧ@�I";}
}//End of LeavePlace
elseif ($mode == 'Vice'){

	if ($Game['rights'] != '1'){echo "�A�S���v�O���R�ƥD�u�C";postFooter();exit;}
	if ($Game['rights'] == '1'){$RightsTitle = $RightsClass['Major'];}
	elseif ($Game['rights']){$RightsTitle = $RightsClass['Leader'];}

	if ($actionb == 'A'){
		echo "<form action=organization.php?action=Vice method=post name=mainform>";
		echo "<input type=hidden value='B' name=actionb>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	
		echo "<script language=\"Javascript\">";
		echo "function cfmVice(){";
		echo "if (mainform.GiveTar.value == ''){alert('�Х���J�n���R���ƥD�u���H�C');return false;}";
		echo "else {if (confirm('���R�ؼФH���A�T�w�ܡH')==true){return true;}";
		echo "else {return false;}}";
		echo "}</script>";
	
		echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
		echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">���R�ƥD�u: </b></td></tr>";
	
		unset($sql,$query,$AvailPersons);
		$sql = ("SELECT `username`,`gamename` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `username` != '".$Pl_Value['USERNAME']."'  AND `organization` = '$Game[organization]' AND `rank` > 60000 ORDER BY `rank` DESC");
		$query = mysql_query($sql) or die(mysql_error());
		$GiveTarOpt = '';
		while ($AvailPersons = mysql_fetch_array($query))
			$GiveTarOpt .= "<option value='$AvailPersons[username]'>$AvailPersons[gamename]";
		unset($AvailPersons);
		echo "<tr><td align=left>�z���v�O: $RightsTitle <br>";
	
		if ($GiveTarOpt)
			echo "���R���ƥD�u���H:<select name=GiveTar>$GiveTarOpt</select><br><input type=submit value=\"���R\" onClick=\"return cfmVice();\">";
		else 	echo "�S���i�H�Q���R���H, �ƥD�u�������@�w���\�Z�B�x���C";
		echo "</td></tr></form></table>";
	}// Action A End

	elseif ($actionb == 'B'){

	if (!$GiveTar){echo "�Х����w�ؼСC";postFooter();exit;}

	$sqlgame = ("SELECT gen.username AS name, `color`, `gamename`, `rights` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` `game`, `".$GLOBALS['DBPrefix']."phpeb_user_general_info` `gen` WHERE gen.username = game.username AND organization = $Game[organization] AND (gen.username = '". $GiveTar ."' OR `rights` = 2) LIMIT 2;");
	$qgame = mysql_query($sqlgame) or die ('�L�k���o�C����T, ��]:' . mysql_error() . '<br>');
	$TarQnum = mysql_num_rows($qgame);
	if($TarQnum > 1){
		$mem[0] = mysql_fetch_array($qgame);
		$mem[1] = mysql_fetch_array($qgame);
		if($mem[0]['rights'] == '2') {
			$TarQ = $mem[1];
			$TarXQ = $mem[0];
		}else{
			$TarQ = $mem[0];
			$TarXQ = $mem[1];
		}
		$HistoryWrite = "<font color=\"$Pl_Org[color]\">$Pl_Org[name]</font> �� <font color=\"$Gen[color]\">$Game[gamename]</font> �ŧG, <font color=\"$TarQ[color]\">$TarQ[gamename]</font> �N���� <font color=\"$TarXQ[color]\">$TarXQ[gamename]</font> �� ".$RightsClass['Leader']." �F�C";
		//��s Game Info
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `rights` = '2' WHERE `username` = '".$TarQ['name']."' LIMIT 1");
		$query = mysql_query($sql);
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `rights` = '0' WHERE `username` = '".$TarXQ['name']."' LIMIT 1");
		$query = mysql_query($sql);
	}
	else {
		$TarQ = mysql_fetch_array($qgame);
		$TarXQ = false;
		$HistoryWrite = "<font color=\"$Pl_Org[color]\">$Pl_Org[name]</font> �� <font color=\"$Gen[color]\">$Game[gamename]</font> ���´���� <font color=\"$TarQ[color]\">$TarQ[gamename]</font> ���R�� ".$RightsClass['Leader']." �F�C";
		//��s Game Info
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `rights` = '2' WHERE `username` = '".$GiveTar."' LIMIT 1");
		$query = mysql_query($sql) or die ('�L�k���o�򥻸�T, ��]:' . mysql_error() . '<br>');
	}

	WriteHistory($HistoryWrite);

	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
	echo "<p align=center style=\"font-size: 16pt\">���R�����F�I<input type=submit value=\"��^\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";

	}// Action B End


	else {echo "���w�q�ʧ@�I";}
}//End of Vice Presidency
elseif ($mode == 'Break'){
if ($actionb = 'A'){
	if (!$Game['organization'] && $Game['rights'] != '1'){echo "�H�z����������Ѵ���´�C";postFooter();exit;}

	$sql = ("SELECT count(username) FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `organization` = '".$Game['organization']."'");
	$query = mysql_query($sql);
	$result = mysql_fetch_row($query);
	if($result[0] > 1) {echo "�Х��Ѷ��ҥH��´�H���C";postFooter();exit;}

	$HistoryWrite = "<font color=\"$Gen[color]\">$Game[gamename]</font> �� <font color=\"$Pl_Org[color]\">$Pl_Org[name]</font> �Ѵ��F�C";
	WriteHistory($HistoryWrite);
	
	$Game['rank'] -= 48000;
	if($Game['rank'] < 0) $Game['rank'] = 0;

	//��s Game Info
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `rank` = '".($Game['rank'])."', `rights` = '0', `organization` = '0' WHERE `username` = '".$Pl_Value['USERNAME']."'");
	$query = mysql_query($sql) or die ('�L�k���o�C����T, ��]:' . mysql_error() . '<br>');
	//��s Map Info
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_map` SET `occupied` = '0' WHERE `occupied` = '".$Game['organization']."'");
	$query = mysql_query($sql) or die ('�L�k���o�C����T, ��]:' . mysql_error() . '<br>');
	//���� Org Info
	$sql = ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_organization` WHERE id='". $Game['organization'] ."' LIMIT 1");
	$query = mysql_query($sql) or die ('�L�k���o�C����T, ��]:' . mysql_error() . '<br>');

	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
	echo "<p align=center style=\"font-size: 16pt\">��´�w�Q�Ѵ��C<input type=submit value=\"��^\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";
	}// Action A End
}// End of Break Organization

elseif ($mode == 'Dismiss'){
	echo "<font style=\"font-size: 12pt\">�Ѷ�</font>";
	printTHR();
	if (!$Game['organization'] || !$Game['rights']){echo "�H�z����������Ѷ���L�H�C";postFooter();exit;}

	if ($Game['rights'] == '1'){$RightsTitle = $RightsClass['Major'];$AllowWho = "`rights` != '1'";}
	elseif ($Game['rights']){$RightsTitle = $RightsClass['Leader'];$AllowWho = "!`rights`";}

	if ($actionb == 'A'){
	echo "<form action=organization.php?action=Dismiss method=post name=mainform>";
	echo "<input type=hidden value='B' name=actionb>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

	echo "<script language=\"Javascript\">";
	echo "function cfmDismiss(){";
	echo "if (mainform.GiveTar.value == ''){alert('�Х���J�n�Ѷ����H�C');return false;}";
	echo "else {if (confirm('�Ѷ��ؼФH���A�T�w�ܡH')==true){return true;}";
	echo "else {return false;}}";
	echo "}</script>";

	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">�Ѷ��H��: </b></td></tr>";

	unset($sql,$query,$AvailPersons);
	$sql = ("SELECT `username`,`gamename` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `username` != '".$Pl_Value['USERNAME']."'  AND `organization` = '$Game[organization]' AND $AllowWho ORDER BY `rank` DESC");
	$query = mysql_query($sql) or die(mysql_error());
	$GiveTarOpt = '';
	while ($AvailPersons = mysql_fetch_array($query))
		$GiveTarOpt .= "<option value='$AvailPersons[username]'>$AvailPersons[gamename]";
	unset($AvailPersons);
	echo "<tr><td align=left>�z���v�O: $RightsTitle <br>";

	if ($GiveTarOpt)
		echo "�i�Ѷ����H:<select name=GiveTar>$GiveTarOpt</select><br><input type=submit value=\"�Ѷ�\" onClick=\"return cfmDismiss();\">";
	else 	echo "�S���i�H�Q�Ѷ����H�C";
	echo "</td></tr></form></table>";
	}// Action A End

	elseif ($actionb == 'B'){

		if (!$GiveTar){echo "�Х����w�ؼСC";postFooter();exit;}
	
		$sqlgame = ("SELECT `gamename` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE username='". $GiveTar ."'");
		$qgame = mysql_query($sqlgame) or die ('�L�k���o�C����T, ��]:' . mysql_error() . '<br>');
		$TarQ = mysql_fetch_array($qgame);
	
		$HistoryWrite = "<font color=\"$Pl_Org[color]\">$Pl_Org[name]</font> �� <font color=\"$Gen[color]\">$Game[gamename]</font> ���´���� <font color=\"$TarQ[color]\">$TarQ[gamename]</font> �Ѷ��F�C";
		WriteHistory($HistoryWrite);
	
		$Game['rank'] -= 2000;
		if($Game['rank'] < 0) $Game['rank'] = 0;
	
		//��s Game Info
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `rank` = '".($Game['rank'])."', `rights` = '0', `organization` = '0' WHERE `username` = '".$GiveTar."' LIMIT 1");
		$query = mysql_query($sql) or die ('�L�k���o�򥻸�T, ��]:' . mysql_error() . '<br>');
	
		echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
		echo "<p align=center style=\"font-size: 16pt\">�Ѷ������F�I<input type=submit value=\"��^\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
		echo "</form>";

	}// Action B End


	else {echo "���w�q�ʧ@�I";}
}//End of Dismiss
elseif ($mode == 'JoinOrg'){
	echo "<font style=\"font-size: 12pt\">�[�J��´</font>";
	printTHR();
	if ($Game['organization']){echo "�A�w�����ݪ���´�F�C";postFooter();exit;}

	if ($actionb == 'A'){
		echo "<form action=organization.php?action=JoinOrg method=post name=mainform>";
		echo "<input type=hidden value='B' name=actionb>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	
		echo "<script language=\"Javascript\">";
		echo "function cfmJoinOrg(){";
		echo "if (mainform.GiveTar.value == ''){alert('�Х���J�n�[�J����´�C');return false;}";
		echo "else {if (confirm('�[�J�ؼв�´�A�T�w�ܡH')==true){return true;}";
		echo "else {return false;}}";
		echo "}</script>";
	
		echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
		echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">�[�J��´�����s�|������´: </b></td></tr>";
	
		unset($sql,$query,$AvailPersons);
		$sql = ("SELECT `id`,`name` FROM `".$GLOBALS['DBPrefix']."phpeb_user_organization` WHERE `id` != '0' AND `license` < 2  ORDER BY `id` DESC");
		$query = mysql_query($sql) or die(mysql_error());
		$AvailPersons = mysql_fetch_array($query);
		
		$GiveTarOpt = '';
		do{
		$GiveTarOpt .= "<option value='$AvailPersons[id]'>$AvailPersons[name]";
		unset($AvailPersons);
		}
		while ($AvailPersons = mysql_fetch_array($query));
	
		if ($GiveTarOpt)
		echo "<tr><td align=left>�i�[�J����´:<select name=GiveTar>$GiveTarOpt</select><br><input type=submit value=\"�[�J\" onClick=\"return cfmJoinOrg();\"></td></tr>";
		else echo "<tr><td align=left>�S���i�H�Q�[�J����´�C</td></tr>";
		echo "</form></table>";
	}// Action A End

	elseif ($actionb == 'B'){

		if (!$GiveTar){echo "�Х����w�n�[�J����´�C";postFooter();exit;}

		$Og_Org = ReturnOrg($Game['organization']);
		$Pl_Org = ReturnOrg($GiveTar);
		if($Pl_Org['license'] >= 2){echo "�ؼв�´�������s�|���C";postFooter();exit;}

		if (abs($Gen['fame']) >= 100){
			$HistoryWrite = "<font color=\"$Og_Org[color]\">$Og_Org[name]</font> �� <font color=\"$Gen[color]\">$Game[gamename]</font> �[�J <font color=\"$Pl_Org[color]\">$Pl_Org[name]</font>�C";
			WriteHistory($HistoryWrite);
		}

		$Game['rank'] += 2000;
		if($Game['rank'] > 100000) $Game['rank'] = 100000;

		//��s Game Info
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `rank` = '".($Game['rank'])."', `rights` = '0', `organization` = '".$GiveTar."' WHERE `username` = '".$Pl_Value['USERNAME']."' LIMIT 1");
		$query = mysql_query($sql) or die ('�L�k���o�򥻸�T, ��]:' . mysql_error() . '<br>');

		echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
		echo "<p align=center style=\"font-size: 16pt\">�[�J��´�����F�I<input type=submit value=\"��^\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
		echo "</form>";

	}// Action B End


	else {echo "���w�q�ʧ@�I";}
}//End of JoinOrg
elseif ($mode == 'Settings'){
	echo "<font style=\"font-size: 12pt\">��´�]�w</font>";
	printTHR();
	if (!$Game['organization'] || $Game['rights'] != '1'){echo "�A���v�O�����C";postFooter();exit;}

	if ($actionb == 'A'){
	echo "<form action=organization.php?action=ModOrg method=post name=mainform>";
	echo "<input type=hidden value='' name=actionb>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

	echo "<script language=\"Javascript\">";
	echo "function cfmModOrgLi(){";
	echo "if (confirm('�ק��´�ۥѫ�, �T�w�ܡH')==true){mainform.actionb.value='ModLi';return true;}";
	echo "else {return false;}";
	echo "}</script>";

	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">�]�w��´�պA: </b></td></tr>";
	echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">��´���: ".number_format($Pl_Org['funds'])."��</b></td></tr>";
	echo "<tr><td align=left>��´�ۥѫ�:<br><input type=radio name=\"license\" checked value=\"0\">: �ۥѥ[�J�B�h�X<br><input type=radio name=\"license\" value=\"1\">: �ۥѥ[�J�A����h�X<br><input type=radio name=\"license\" value=\"2\">: ����[�J�A�ۥѰh�X<br><input type=radio name=\"license\" value=\"3\">: ����[�J�B�h�X<br>";
	echo "<input type=submit value=\"�]�w\" onClick=\"return cfmModOrgLi();\">";
	echo "</td></tr>";

	if ($Pl_Org['funds'] > 1000000){

	echo "<script language=\"Javascript\">";
	echo "function cfmModOrgC(){";
	echo "if (confirm('�H 1,000,000�� �ק��´�N���, �T�w�ܡH')==true){mainform.actionb.value='ModC';return true;}";
	echo "else {return false;}";
	echo "}</script>";

	echo "<tr><td align=left>��´�N���:<br>���ܥN���ݭn�ϥ� 1,000,000�� ��´����C<br>";
	$br=$ct_default=0;
	foreach ($MainColors as $TheColor){$br++;$ct_default++;
	echo "<input type=\"radio\" name=\"org_color\" value=#".$TheColor;
	if ($ct_default==1) echo " checked";
	echo "><font color=#".$TheColor.">��</font> &nbsp;&nbsp; ";
	if ($br==6){echo"<br>";$br=0;}	}
	echo "<input type=submit value=\"�]�w\" onClick=\"return cfmModOrgC();\">";
	echo "</td></tr>";
	}
	if ($Pl_Org['funds'] > 10000000){
	echo "<script language=\"Javascript\">";
	echo "function cfmModOrgN(){";
	echo "if (confirm('�H 10,000,000�� �ק��´�W��, �T�w�ܡH')==true){mainform.actionb.value='ModN';return true;}";
	echo "else {return false;}";
	echo "}</script>";

	echo "<tr><td align=left>��´�W��:<br>���ܲ�´�W�ٻݭn�ϥ� 10,000,000�� ��´����C<br>";
	echo "�s�W��: <input type=text name=NewOrgName maxlength=32>";
	echo "<input type=submit value=\"�]�w\" onClick=\"return cfmModOrgN();\">";
	echo "</td></tr>";
	}
	echo "</form></table>";
	}// Action A End
	else {echo "���w�q�ʧ@�I";}
}//End of Settings
elseif ($mode == 'ModOrg'){
	if (!$Game['organization'] || $Game['rights'] != '1'){echo "�A���v�O�����C";postFooter();exit;}

	if ($actionb == 'ModLi'){
		//��s Org Info
		if ($license > 3 || $license < 0){echo "Hacking Attempt.";postFooter();exit;}
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `license` = '$license' WHERE `id` = '".$Pl_Org['id']."' LIMIT 1");
		$query = mysql_query($sql) or die ('�L�k���o��´��T, ��]:' . mysql_error() . '<br>');
		if ($license == 0) $LiText = "�Y��_<b>�����s�|��</b>�[�J�ӥB�|���i�H<b>�ۥѲ���</b>��´";
		elseif ($license == 1) $LiText = "�Y��_<b>�����s�|��<b>�[�J��<b>����|���ۦ�h�X</b>";
		elseif ($license == 2) $LiText = "�Y��_<b>���A�����s�|��</b>�[�J���|���i�H<b>�ۥѲ���</b>��´";
		elseif ($license == 3) $LiText = "�Y��_<b>���A�����s�|��</b>�[�J�ӥB<b>����|���ۦ�h�X</b>";
		$HistoryWrite = "<font color=\"$Pl_Org[color]\">$Pl_Org[name]</font> �� <font color=\"$Gen[color]\">$Game[gamename]</font> �ŧG��´".$LiText."�C";
		WriteHistory($HistoryWrite);
	}// Action A End
	elseif ($actionb == 'ModC'){
		if (1000000 > $Pl_Org['funds']){echo "��´��������C";postFooter();exit;}
		if (!$org_color){echo "�Х���n�C��C";postFooter();exit;}
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `color` = '$org_color', `funds` = `funds`-1000000 WHERE `id` = '".$Pl_Org['id']."' LIMIT 1");
		$query = mysql_query($sql) or die ('�L�k���o��´��T, ��]:' . mysql_error() . '<br>');
		$Gen['cash']-=1000000;
		$HistoryWrite = "<font color=\"$org_color\">$Pl_Org[name]</font> �� <font color=\"$Gen[color]\">$Game[gamename]</font> �ŧG��´���ܥN���C��C";
		WriteHistory($HistoryWrite);
	}
	elseif ($actionb == 'ModN'){
		if (10000000 > $Pl_Org['funds']){echo "��´��������C";postFooter();exit;}
		if (!$NewOrgName){echo "�Х���n��´�W�١C";postFooter();exit;}
		$NewOrgName = preg_replace('/<[^<>]*>/','',$NewOrgName);
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `name` = '$NewOrgName', `funds` = `funds`-10000000 WHERE `id` = '".$Pl_Org['id']."' LIMIT 1");
		$query = mysql_query($sql) or die ('�L�k���o��´��T, ��]:' . mysql_error() . '<br>');
		$HistoryWrite = "<font color=\"$Pl_Org[color]\">$Pl_Org[name]</font> �� <font color=\"$Gen[color]\">$Game[gamename]</font> �ŧG��´��W�� <font color=\"$Pl_Org[color]\">$NewOrgName</font> �C";
		WriteHistory($HistoryWrite);
	}
	else {echo "���w�q�ʧ@�I";}
	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
	echo "<p align=center style=\"font-size: 16pt\">��´�]�w�����F�I<input type=submit value=\"��^\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";

}//End of ModOrg
elseif ($mode == 'CityAtk'){
	echo "<font style=\"font-size: 12pt\">�𲤭p��</font>";
	printTHR();
	if (!$Game['organization'] || $Game['rights'] != '1'){echo "�A���v�O�����C";postFooter();exit;}
	
	if($Pl_Org['optmissioni']){
		$sql = ("SELECT COUNT(`t_end`) FROM `".$GLOBALS['DBPrefix']."phpeb_user_war` WHERE `war_id` = '$Pl_Org[optmissioni]' AND `t_end` > '$CFU_Time' LIMIT 1;");
		$query = mysql_query($sql);
		$result = mysql_fetch_row($query);
		if($result[0] > 0) {echo "<p style='font-size: 12pt; color: coral' align=center>�Ԫ��w�o�ʡC";postFooter();exit;}
	}

	if ($actionb == 'A'){
		echo "<form action=organization.php?action=CityAtk method=post name=mainform>";
		echo "<input type=hidden value='B' name=actionb>";
		echo "<input type=hidden value='1' name=reinforcements>";
		echo "<input type=hidden value='0' name=revolutionPrice>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

		echo "<script language=\"Javascript\">";
		echo "function changeDuration(){price.innerHTML= $Org_War_Cost * mainform.duration.value;}";
		echo "function cfmDeclare(){";
		echo "if ($Pl_Org[funds] < parseInt(price.innerHTML) + parseInt(mainform.revolutionPrice.value)){alert('��´��������I');return false;}";
		echo "else if (confirm('�Y�N�o�ʾԪ�, �i�H�ܡH')==true){return true;}";
		echo "else {return false;}";
		echo "}function makeVal(val,max){";
		echo "val = val.replace(/[a-zA-Z\-+&!?=,<>@#$%\^\*\#\/\\\\[\]\{\}\'\"]+/,'');";
		echo "val = Math.round(val);";
		echo "if(!val) val = 1;";
		echo "if(val > max) val = max;";
		echo "if(val < 1) val = 1;";
		echo "return val;";
		echo "}function detectArea(){";
		echo "if(mainform.atkArea[0])";
		echo "for(i=0;mainform.atkArea[i];i++){";
		echo "	if(mainform.atkArea[i].checked) {";
		echo "		avaVal = parseInt(document.getElementById('rnfrcmnt_'+mainform.atkArea[i].value).innerHTML);avaVal -= 1;";
		echo "		inputVal = prompt('�п�J�հʭx�O���ƶq( 1 - '+avaVal+' )', '1');";
		echo "		if(inputVal == null) {mainform.atkArea[i].checked = false;return false;}";
		echo "		inputVal = makeVal(inputVal,avaVal); alert('�Y�N�հ� '+inputVal+' �I�x�O�C');";
		echo "		mainform.reinforcements.value = inputVal;";
		echo "		sel_msg.innerHTML = '�q '+mainform.atkArea[i].value+' �հ� '+numberFormat(inputVal)+' �I�x�O�i��C';";
		echo "		continue;";
		echo "	}";
		echo "}";
		echo "else {";
		echo "		avaVal = parseInt(document.getElementById('rnfrcmnt_'+mainform.atkArea.value).innerHTML);avaVal -= 1;";
		echo "		inputVal = prompt('�п�J�հʭx�O���ƶq( 1 - '+avaVal+' )', '1');";
		echo "		if(inputVal == null) {mainform.atkArea.checked = false;return false;}";
		echo "		inputVal = makeVal(inputVal,avaVal); alert('�Y�N�հ� '+inputVal+' �I�x�O�C');";
		echo "		mainform.reinforcements.value = inputVal;";
		echo "		sel_msg.innerHTML = '�q '+mainform.atkArea.value+' �հ� '+numberFormat(inputVal)+' �I�x�O�i��C';";
		echo "}";
		echo "}";
		echo "function numberFormat(num){";
		echo "	var numF = '';";
		echo "	var pNum = new String( num );";
		echo "	num = pNum;";
		echo "	var l = num.length;";
		echo "	var tx = Math.floor(l/3);";
		echo "	var rx = (l%3);";
		echo "	if (rx == 1){numF = num.substr(0,1);pNum = num.substr(1);}";
		echo "	else if (rx == 2){numF = num.substr(0,2);pNum = num.substr(2);}";
		echo "	else {numF = num.substr(0,3);pNum = num.substr(3);}";
		echo "	while(pNum.length >= 3){";
		echo "		numF = numF+','+pNum.substr(0,3);";
		echo "		pNum = pNum.substr(3);";
		echo "	}";
		echo "	return numF;";
		echo "}</script>";

		echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
		echo "<tr><td align=left width=475><b style=\"font-size: 10pt;\">�p����ϰ�o�ʾԪ�: </b></td></tr>";
		echo "<tr><td align=left><b style=\"font-size: 10pt;\">��´���: ".number_format($Pl_Org['funds'])."��</b></td></tr>";
		echo "<tr><td align=left>�ݭn���: �C�p�� ".number_format($Org_War_Cost)."��<br>�@�ݭn: <span id=price>$Org_War_Cost</span> ��<br>";


		unset($sql,$query,$AtTarPosblty,$nums);
		$sql = ("SELECT `map_id`,`name`,`aname` FROM `".$GLOBALS['DBPrefix']."phpeb_user_map`,`".$GLOBALS['DBPrefix']."phpeb_user_organization` WHERE `occupied`=`id` AND `occupied` != ". $Pl_Org['id']." ORDER BY `map_id` ASC");
		$query = mysql_query($sql) or die ('�L�k���o�򥻸�T, ��]:' . mysql_error() . '<br>');
		$nums = mysql_num_rows($query);
		$AtTarPosblty = $AtkDisabled = '';
		if ($nums){
			while ($AtkInfo = mysql_fetch_array($query))
				$AtTarPosblty .= "<option value='$AtkInfo[map_id]'>$AtkInfo[aname] ($AtkInfo[map_id] - $AtkInfo[name])";
			echo "��<select name=sttimedelay style=\"$BStyleA;text-align: center;\"><option value=6>6<option value=7>7<option value=8>8<option value=9>9<option value=10>10<option value=11>11<option value=12>12<option value=13>13<option value=14>14<option value=15>15<option value=16>16<option value=17>17<option value=18>18</select>�p�ɫ�";
			echo "�V<select name=target style=\"$BStyleA;text-align: center;\">$AtTarPosblty</select> �o��<br>";
			echo "����<select name=duration onChange=\"changeDuration()\" style=\"$BStyleA;text-align: center;\"><option value=1>1<option value=2>2<option value=3>3</select>�p�ɪ��Ԫ�";
			$DefaultOName = $CFU_Date."���Ԫ�";
			echo "<br>��ʥN��: <input type=text name=Opt_Name maxlength=32 size=39 $BStyleB style=\"$BStyleA;text-align: center;\" value='$DefaultOName'>";
			echo "<hr width=80% align=center>";

			echo "<b style=\"font-size: 10pt;\">�հʭx�O: </b>";
			echo "<table align=center border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
				$sql = ("SELECT `map_id`, `aname`, `development`, `defenders`, `tickets` FROM `".$GLOBALS['DBPrefix']."phpeb_user_map` WHERE `occupied` = '$Game[organization]' ORDER BY `map_id`");
				$query = mysql_query($sql);

				$O_Area = array();

				while($j = mysql_fetch_array($query))	$O_Area[$j['map_id']] = $j;
				unset($j);
				
				if(mysql_num_rows($query) > 0){
					echo "<tr>";
					echo "<td width=400 valign=top>";
					echo "�U���ҰϪ��x�ƤO�q:";
						echo "<table align=center border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 12pt;\" bordercolor=\"#FFFFFF\">";
						echo "<tr align=center><td width=50>�ϰ�</td><td width=150>�ϰ�W��</td><td width=75>�`�x�O</td><td width=75>�q���Ͻհ�</td></tr>";
							foreach($O_Area as $a)
								printf ('<tr align=center><td>%s</td><td>%s</td><td id=rnfrcmnt_%1$s>%s</td><td><input type=radio name=atkArea value="%1$s" onClick="detectArea();"></td></tr>',$a['map_id'],$a['aname'],$a['tickets']);
						echo "</table>";
					echo "</td></tr>";
				}
				else{
					$sql = ("SELECT count(username) as `num` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `organization` = '$Game[organization]';");
					$query = mysql_query($sql);
					$members = mysql_fetch_row($query);
					echo "<script language=\"Javascript\">";
					echo "function checkRevolution(){";
					echo "		inputVal = makeVal(mainform.atkArea.value,".($members[0]*1000)."); alert('�Y�N�հ� '+numberFormat(inputVal)+' �I�x�O�_�q�C');";
					echo "		mainform.reinforcements.value = mainform.atkArea.value = inputVal; mainform.revolutionPrice.value = mainform.reinforcements.value*$ticketCost;";
					echo "		sel_msg.innerHTML = '�l�� '+inputVal+' �I�x�O�_�q�C<br>�_�q�һݲ�´���(�]�A�žԶO): \$' + numberFormat(parseInt(mainform.revolutionPrice.value)+parseInt(price.innerHTML));";
					echo "	}";
					echo "</script>";
					echo "<tr>";
					echo "<td width=400 valign=top>";
					echo "<b>�_�q</b>:";
					echo "<br>�@- �ѩ�v���´�èS����a, �]���i�H�i��u�_�q�v<br>�@- �_�q�x�O���p��覡:<br>�@�@- �x�O�ƶq: ��´�H�� * 1000 (".number_format($members[0]*1000)." �I)<br>�@�@- �W��: " . ($dailyTicketLim * 4) . "<br>�@- �C�@�I�x�O������: ".$ticketCost."<br>";
						echo "<br> ��J�_�q�x�O�ƶq: <input type=text name=atkArea value=0 onChange=\"checkRevolution();\">";
					echo "</td></tr>";
				}
				echo "<tr><td id=sel_msg>&nbsp;</td></tr>";
			echo "</td></tr>";
			echo "</table>";
		}
		else {echo "�S���i�𲤪������C"; $AtkDisabled = ' disabled';}
		echo "<hr width=80% align=center>";
		echo "<center><input type=submit value=\"�ž�\"$AtkDisabled onClick=\"return cfmDeclare();\" $BStyleB style=\"$BStyleA;\">";
		echo "</td></tr></form></table>";
	}

	elseif ($actionb == 'B'){
		if ($duration > 3){echo "�Ԫ��ɶ��Y���L���C";postFooter();exit;}
		elseif ($duration < 0){echo "�Ԫ��ɶ��Y���X���C";postFooter();exit;}
		if ($sttimedelay > 18 || $sttimedelay < 6){echo "�Ԫ����ɮɰݥX���C";postFooter();exit;}
		$Cost = $Org_War_Cost * $duration;
		if ($Cost < 0){echo "Hacking Attempt�I";postFooter();exit;}
		if (!$Pl_Org['id']){echo "��´�X���I";postFooter();exit;}
		if ($Pl_Org['funds'] < $Cost){echo "��´��������C";postFooter();exit;}
		if ($Pl_Org['optmissioni']){echo "�W�@�����Ԫ��٨S�����I";postFooter();exit;}

		unset($sql,$query);
		$sql = ("SELECT `occupied` FROM `".$GLOBALS['DBPrefix']."phpeb_user_map` WHERE `map_id` = '$target'");
		$query = mysql_query($sql) or die();
		$count = mysql_num_rows($query);

		if($count == 0){echo "�䤣��ؼаϰ�I";postFooter();exit;}
		else{
			$TargetInf = mysql_fetch_array($query);
			if($TargetInf['occupied'] == $Pl_Org['id']) {echo "���ϰ�w�g���w��Ҧ��I����i��𲤡C";postFooter();exit;}
		}
		
		$revolutionFlag = false;
		$reinforcements = intval($reinforcements);
		if($reinforcements < 1) $reinforcements = 1;
		
		if($revolutionPrice > 0){
		
			$sql = ("SELECT count(map_id) as `aNum` FROM `".$GLOBALS['DBPrefix']."phpeb_user_map` WHERE `occupied` = '$Game[organization]'");
			$query = mysql_query($sql);
			$areaCount = mysql_fetch_row($query);
			if($areaCount[0] > 0){
				echo "���~: �w����a, ����i��_�q�C";
				postFooter();
				exit;
			}
			$revolutionFlag = true;
			
			$sql = ("SELECT count(username) as `mNum` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `organization` = '$Game[organization]'");
			$query = mysql_query($sql);
			$memberCount = mysql_fetch_row($query);

			if ($reinforcements > $memberCount[0] * 1000 || $reinforcements > $dailyTicketLim * 4){echo "�_�q�x�O�L���I";postFooter();exit;}

			$Cost += $reinforcements*$ticketCost;

			if ($Cost < 0){echo "Hacking Attempt�I";postFooter();exit;}
			if ($Pl_Org['funds'] < $Cost){echo "��´��������C";postFooter();exit;}
			
			$HistoryWrite = "<font color=\"$Pl_Org[color]\">$Pl_Org[name]</font> �H <b style=\"color: $Pl_Org[color]\">".$reinforcements."�I</b> �x�O�_�q, �� ".$target." �ϰ�žԡI<br>��ʥN���y<font color=\"$Pl_Org[color]\">".$Opt_Name."</font>�z�I";

		}
		else{
			$sql = ("SELECT `occupied`,`tickets` FROM `".$GLOBALS['DBPrefix']."phpeb_user_map` WHERE `map_id` = '$atkArea'");
			$query = mysql_query($sql) or die();
			$AtkAreaInf = mysql_fetch_array($query);
			if($reinforcements > $AtkAreaInf['tickets']-1){echo "�x�O�����I";postFooter();exit;}
			$HistoryWrite = "<font color=\"$Pl_Org[color]\">$Pl_Org[name]</font> ���X <b style=\"color: $Pl_Org[color]\">".$reinforcements."�I</b> �x�O�� ".$target." �ϰ�žԡI<br>��ʥN���y<font color=\"$Pl_Org[color]\">".$Opt_Name."</font>�z�I";
		}

		if($AtkAreaInf['occupied'] != $Pl_Org['id'] && !$revolutionFlag){echo "���~: �հʭx�O�B�o�ʧ������ϰ�, �D�v���´�Ҧ��I<br>�ЬD��v���´����a�հʭx�O�B�o�ʧ����C";postFooter();exit;}

		WriteHistory($HistoryWrite);

		$StartTime = $CFU_Time + $sttimedelay * 3600;
		$EndTime = $StartTime + $duration * 3600;

		$war_id = $CFU_Time;

		if(!$revolutionFlag){
			$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_map` SET `tickets` = ".($AtkAreaInf['tickets']-$reinforcements)." WHERE `map_id` = '$atkArea' LIMIT 1;");
			mysql_query($sql);
		}

		$sql = ("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_user_war` (`war_id`, `t_start`, `t_end`, `a_org`, `b_org`, `ticket_a`, `ticket_b`, `mission`) VALUES('$war_id', '$StartTime', '$EndTime', '$Game[organization]', $TargetInf[occupied], $reinforcements, 1, 'Atk<$target>');");
		mysql_query($sql);

		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `funds` = `funds`-$Cost, `optmissioni` = '$war_id', `operation` = '$Opt_Name' WHERE `id` = '$Game[organization]' LIMIT 1;");
		mysql_query($sql);

		echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
		echo "<p align=center style=\"font-size: 16pt\">�Ԫ��o�ʤF�I<input type=submit value=\"��^\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
		echo "</form>";
	}

	else {echo "���w�q�ʧ@�I";}
}//End of CityAtk


elseif ($mode == 'TakeCity'){
	echo "<font style=\"font-size: 12pt\">����ϰ�</font>";
	printTHR();
	if (!$Game['organization'] || $Game['rights'] != '1'){echo "�A���v�O�����C";postFooter();exit;}
	if ($Game['status']){echo "�ײz���A�L�k����ϰ�C";postFooter();exit;}
	$Area = ReturnMap("$Gen[coordinates]");

	$sql = ("SELECT `mission`,`t_start`,`t_end`,`ticket_a`,`victory` FROM `".$GLOBALS['DBPrefix']."phpeb_user_war` WHERE `war_id` = '".$Pl_Org['optmissioni']."' AND `t_end` > '$CFU_Time' LIMIT 1;");
	$query = mysql_query($sql);
	$Opt_Info = mysql_fetch_array($query);
	
	$ErrorFlag = '';
	$tmp = array();
	if(preg_match('/Atk<([0-9a-zA-Z]+)>/', $Opt_Info['mission'], $tmp)){
		$Mission_Area_Id = $tmp[1];
	}else{
		$Mission_Area_Id = '';
	}
	unset($tmp);

	if(!$Opt_Info) $ErrorFlag .= '�L�k���o�԰���T�ξԪ��w�����I<br>';
	if($Mission_Area_Id != $Gen['coordinates']) $ErrorFlag .= '�L�k����ϰ�A�S���惡�a�ϫžԡI<br>';
	if ($Opt_Info['victory'] != 1){$ErrorFlag .= "�L�k����ϰ�A�����ӥX�Ԫ��C<br>";}
	if ($Area["Sys"]["occprice"] > $Pl_Org['funds'])$ErrorFlag .= "��´��������I�������ϰ�C<br>";

	if($ErrorFlag) {echo $ErrorFlag;postFooter();exit;}

	if ($actionb == 'A'){
	echo "<form action=organization.php?action=TakeCity method=post name=mainform>";
	echo "<input type=hidden value='B' name=actionb>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

	echo "<script language=\"Javascript\">";
	echo "function cfmOccupy(){";
	echo "if ($Pl_Org[funds] < ".$Area["Sys"]["occprice"]."){alert('��´��������I');return false;}";
	echo "else if (confirm('�H ".$Area["Sys"]["occprice"]." ���a���a��, �i�H�ܡH')==true){return true;}";
	echo "else {return false;}";
	echo "}</script>";
	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">���⦹�ϰ�: </b></td></tr>";

	echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">�ϰ�: $Gen[coordinates]</b><br>";
	echo "��´���: ".number_format($Pl_Org['funds'])."��<br>";
	echo "����O��: ".number_format($Area["Sys"]["occprice"])."��<br>";
	$Area_At = $Area["Sys"]["at"];
	$Area_De = $Area["Sys"]["de"];
	$Area_Ta = $Area["Sys"]["ta"];
	echo "�n������O:<br>HP�W��: ". $Area["Sys"]["hpmax"];
	echo "<br>�����O: $Area_At ���äO: $Area_De �R��: $Area_Ta<br>";
	GetWeaponDetails($Area["Sys"]["wepa"],'FortDfltWep');
	echo "���m�Z��: $FortDfltWep[name]<br>";
	echo "<input type=submit value=���⦹�ϰ� onClicl=\"return cfmOccupy()\">";
	echo "</td></tr>";
	echo "</form></table>";
	}
	elseif ($actionb == 'B'){

	if($Opt_Info['ticket_a'] < 1) $Opt_Info['ticket_a'] = 1;
	elseif($Opt_Info['ticket_a'] > $ticketMax) $Opt_Info['ticket_a'] = $ticketMax;

	$HistoryWrite = "<font color=\"$Pl_Org[color]\">$Pl_Org[name]</font> ���\\�� $Gen[coordinates] �ϰ����F�I";
	WriteHistory($HistoryWrite);

	unset($sql,$query);
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_map` SET `hpmax` = '".$Area["Sys"]["hpmax"]."' ,`hp`=`hpmax` ,`at` ='".$Area["Sys"]["at"]."', `de` ='".$Area["Sys"]["de"]."', `ta` ='".$Area["Sys"]["ta"]."', `wepa` ='".$Area["Sys"]["wepa"]."', `occupied` = '$Game[organization]', `tickets` = '' WHERE `map_id` = '$Gen[coordinates]' LIMIT 1;");
	$query = mysql_query($sql) or die(mysql_error());

	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `funds` = `funds`-".$Area["Sys"]["occprice"].", `optmissioni` = 0, `operation` = '' WHERE `id` = '$Game[organization]' LIMIT 1;");
	mysql_query($sql);

	$sql = ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_war` WHERE `war_id` = $Pl_Org[optmissioni] LIMIT 1;");
	$query = mysql_query($sql);

	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
	echo "<p align=center style=\"font-size: 16pt\">���\\����F���ϰ�I<input type=submit value=\"��^\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";
	}

	else {echo "���w�q�ʧ@�I";}
}//End of TakeCity

else {echo "���w�q�ʧ@�I";}
postFooter();
echo "</body>";
echo "</html>";
exit;
?>