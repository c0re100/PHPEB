<?php
$mode = ( isset($_GET['action']) ) ? $_GET['action'] : $_POST['action'];
include('cfu.php');
if (empty($PriTarget)) $PriTarget = 'Alpha';
if (empty($SecTarget)) $SecTarget = 'Beta';
postHead('');
AuthUser("$Pl_Value[USERNAME]","$Pl_Value[PASSWORD]");
if ($CFU_Time >= $TIMEAUTH+$TIME_OUT_TIME || $TIMEAUTH <= $CFU_Time-$TIME_OUT_TIME){echo "�s�u�O�ɡI<br>�Э��s�n�J�I";exit;}
GetUsrDetails("$Pl_Value[USERNAME]",'Gen','Game');
$Pl_Settings_Query = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_settings` WHERE username='". $Gen['username'] ."'");
$Pl_Settings = mysql_fetch_array(mysql_query ($Pl_Settings_Query));
if ($Game['organization'])
$Pl_Org = ReturnOrg("$Game[organization]");
$Area = ReturnMap("$Gen[coordinates]");
//$AreaLandForm = ReturnMType($Area["Sys"]["type"]);
$Ar_Org = ReturnOrg($Area["User"]["occupied"]);
//Special Commands GUI
if ($mode=='main'){
	$SC_Prsn = $SC_Sys = $SC_Sys_Impt = $SC_Org = $SC_Org_Impt = $SC_Area = (string) ''; // Declare Variables
	echo "<font style=\"font-size: 12pt\">�S����O</font>";
	printTHR('');

	echo "<form action=scommand.php?action=main method=post name=mainform>";
	echo "<input type=hidden value='none' name=actionb>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";


	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr><td align=left width=250><b style=\"font-size: 10pt;\">�S����O�C��: </b></td></tr>";
	echo "<tr><td align=center>";

//��´���O

	if ($Gen['cash'] > $OrganizingCost && !$Game['organization'] && ($Gen['fame'] >= $OrganizingFame || $Gen['fame'] <= $OrganizingNotor))
	$SC_Org .= "<input type=\"submit\" value=\"���߲�´\" onClick=\"mainform.action='organization.php?action=Start';actionb.value='A';\">";

	if (!$Game['organization'])
	$SC_Org .= "<input type=\"submit\" value=\"�[�J��´\" onClick=\"mainform.action='organization.php?action=JoinOrg';actionb.value='A';\">";

	if ($Game['organization'] && $Game['rights']){
		$SC_Org .= "<input type=\"submit\" value=\"�۶ҤH�~\" onClick=\"mainform.action='organization.php?action=Employ';actionb.value='A';\">";
		$SC_Org .= "<input type=\"submit\" value=\"�h��\" onClick=\"mainform.action='organization.php?action=LeavePlace';actionb.value='A';\">";
		$SC_Org .= "<input type=\"submit\" value=\"�Ѷ�\" onClick=\"mainform.action='organization.php?action=Dismiss';actionb.value='A';\">";
	}
	if ($Game['organization'] && $Game['rights'] == '1'){
		$SC_Org .= "<br><input type=\"submit\" value=\"���R�ƥD�u\" onClick=\"mainform.action='organization.php?action=Vice';actionb.value='A';\">";
		$SC_Org .= "<input type=\"submit\" value=\"��´�]�w\" onClick=\"mainform.action='organization.php?action=Settings';actionb.value='A';\">";
		$SC_Org .= "<input type=\"submit\" value=\"�𲤭p��\" onClick=\"mainform.action='organization.php?action=CityAtk';actionb.value='A';\">";
	}
	if ($Game['organization'] && $Game['rights'] != 1 && $Pl_Org['license'] != 1 && $Pl_Org['license'] != 3){
	echo "<script language=\"Javascript\">";
	echo "function cfmLeaveOrg(){";
	echo "if (confirm('�u���n���}��´�ܡH\\n��^���߲�´�|�Q���@�ӭx���C\\n�z�u�|�Q�ݳo�@���A�ЦҼ{�M���C\\n�T�w�ܡH')==true){";
	echo "mainform.action='organization.php?action=LeaveOrg';mainform.actionb.value='A';return true;}";
	echo "else {return false;}";
	echo "}</script>";
	$SC_Org_Impt .= "<input type=\"submit\" value=\"������´\" onClick=\"return cfmLeaveOrg();\">";
	}
	elseif ($Game['organization'] && $Game['rights'] != 1 && $Pl_Org['license'] != 0 && $Pl_Org['license'] != 2 && $Gen['fame'] >= 10){
	echo "<script language=\"Javascript\">";
	echo "function cfmLeaveOrg(){";
	echo "if (confirm('�k�`���l�z���W�n\\n�u���n���}��´�ܡH\\n�z�u�|�Q�ݳo�@���A�ЦҼ{�M���C')==true){";
	echo "mainform.action='organization.php?action=LeaveOrg';mainform.actionb.value='B';return true;}";
	echo "else {return false;}";
	echo "}</script>";
	$SC_Org_Impt .= "<input type=\"submit\" value=\"�k�`\" onClick=\"return cfmLeaveOrg();\">";
	}
	elseif ($Game['organization'] && !$Game['rights'] && $Pl_Org['license'] != 0 && $Pl_Org['license'] != 2 && $Gen['fame'] < 10){
	echo "<script language=\"Javascript\">";
	echo "function cfmLeaveOrg(){";
	echo "if (confirm('�k�`�|���a�A���W�n\\n��^���߲�´�|�Q�� �T�� �x���C\\n�u���n�k�`���}��´�ܡH\\n�z�u�|�Q�ݳo�@���A�ЦҼ{�M���C\\n�T�w�ܡH')==true){";
	echo "mainform.action='organization.php?action=LeaveOrg';mainform.actionb.value='C';return true;}";
	echo "else {return false;}";
	echo "}</script>";
	$SC_Org_Impt .= "<input type=\"submit\" value=\"�k�`\" onClick=\"return cfmLeaveOrg();\">";
	}
	if ($Game['organization'] && $Game['rights'] == '1'){
	echo "<script language=\"Javascript\">";
	echo "function cfmBreakOrg(){";
	echo "if (confirm('�u���n�Ѵ���´�ܡH\\n�z�u�|�Q�ݳo�@���A�ЦҼ{�M���C')==true){";
	echo "mainform.action='organization.php?action=Break';mainform.actionb.value='A';return true;}";
	echo "else {return false;}";
	echo "}</script>";
	$SC_Org_Impt .= "<input type=\"submit\" value=\"�Ѵ���´\" onClick=\"return cfmBreakOrg()\">";
	}

//�ϰ���O
	if ($Area["User"]["occupied"] == $Game['organization'] && $Game['rights']){
		$SC_Area .= "<input type=\"submit\" value=\"�j�ƭn��\" onClick=\"mainform.action='city.php?action=ModFort';actionb.value='A';\">";
		$SC_Area .= "<input type=\"submit\" value=\"�e���u��\" onClick=\"mainform.action='city.php?action=AssignDefender';actionb.value='A';\">";
		$SC_Area .= "<br><input type=\"submit\" value=\"�x�ƤO�q���\" onClick=\"mainform.action='city.php?action=Reinforcement';actionb.value='A';\">";
		$SC_Area .= "<input type=\"submit\" value=\"�x�ƽհ�\" onClick=\"mainform.action='city.php?action=Reinforcement';actionb.value='C';\">";
		
	}

//�t�Ϋ��O
	$SC_Sys = "<input type=\"submit\" value=\"���K�X\" onClick=\"mainform.action='scommand.php?action=chpass';actionb.value='A';\">";
	$SC_Sys .= "<input type=\"submit\" value=\"�C���]�w\" onClick=\"mainform.action='scommand.php?action=settings';actionb.value='A';\">";

	//���n���O
	$SC_Sys_Impt = "<input type=\"submit\" value=\"�R���b��\" onClick=\"mainform.action='scommand.php?action=delete_account';actionb.value='A';\">";

//�ӤH���O
	if ($Gen['typech'] == 'nat' && $Gen['cash'] >= $ModChType_Cost)
	$SC_Prsn .= "<input type=\"submit\" value=\"�H�ا�y\" onClick=\"mainform.action='statsmod.php?action=modtypech';actionb.value='A';\">";
	if ($Game['v_points'] >= $VPt2AlloyReq)
	$SC_Prsn .= "<input type=\"submit\" value=\"�I���X��\" onClick=\"mainform.action='scommand.php?action=redeemAlloy';actionb.value='A';\">";

//�C�X���O
	if ($SC_Prsn){
	echo "<div align=left><b>�ӤH���O:</b></div>";
	echo "$SC_Prsn";}

	if ($SC_Sys){
	echo "<div align=left><b>�t�Ϋ��O:</b></div>";
	echo "$SC_Sys";}
	if ($SC_Sys_Impt)
	echo sprintTHR('200px')."<b>���n���O:</b><br>$SC_Sys_Impt";

	if ($SC_Org){
	echo "<div align=left><b>��´�������O:</b></div>";
	echo "$SC_Org";}
	if ($SC_Org_Impt)
	echo sprintTHR('200px')."<b>���n���O:</b><br>$SC_Org_Impt";

	if ($SC_Area){
	echo "<div align=left><b>�ϰ�������O:</b></div>";
	echo "$SC_Area";}
	echo "</tr></td></form></table>";
}
elseif ($mode=='chpass' && $actionb == 'A'){

	echo "<font style=\"font-size: 12pt\">�S����O</font>";
	printTHR();

	echo "<form action=scommand.php?action=chpass method=post name=mainform target=_parent>";
	echo "<input type=hidden value='B' name=actionb>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr><td align=left width=225><b style=\"font-size: 10pt;\">���K�X: </b></td></tr>";
	echo "<tr><td align=center>";

	echo "<script language=\"JavaScript\">";
	echo "function vldPass(){";
	echo "if (document.getElementById('pwd').value != '$Pl_Value[PASSWORD]'){alert('�K�X�����T�C');return false;}";
	echo "else if(!mainform.new_password.value){alert('���s��J�s�K�X�C');return false;}";
	echo "else if(mainform.new_password.value != mainform.vld_password.value){alert('���s��J���K�X�P�s�K�X���ۦP�A�Э��s��J�C');return false;}";
	echo "else {return true;}";
	echo "}</script>";

	echo "�{�b�K�X: <input type=password name=Pl_Value[PASSWORD] id=pwd><br>";
	echo "�s���K�X: <input type=password name=new_password value='' maxlength=16><br>";
	echo "���s��J: <input type=password name=vld_password value='' maxlength=16><br>";
	echo "<input type=submit value=\"�T�w\" onClick=\"return vldPass();\"><input type=reset value=\"���s�]�w\">";

	echo "</tr></td></form></table>";


}
elseif ($mode=='chpass' && $actionb == 'B'){
if ($new_password) {
	if ($new_password != $vld_password){echo "<center><br><br>��շs�K�X���۲šC<br><br>";postFooter();exit;}
	mysql_query("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `password` = md5('".$new_password."') WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;") or die(mysql_error());
	}
	echo "<br><br><br><br><br><p align=center style=\"font-size: 16pt\">�K�X��s�����I<br>";
	echo "<form action=\"gmscrn_main.php?action=proc\" method=post name=login>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$new_password' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "<input type=submit value=\"��^�C��\">";
	echo "</form>";
	echo "<br><br><br>";
}
elseif ($mode=='settings' && $actionb == 'A'){
	echo "<font style=\"font-size: 12pt\">�S����O</font>";
	printTHR();

	echo "<form action=scommand.php?action=settings method=post name=mainform>";
	echo "<input type=hidden value='B' name=actionb>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr><td align=left width=500><b style=\"font-size: 10pt;\">�C���]�w: ";
	if (isset($ModifiedFlag)) echo "<br><font color=yellow>��s�����I</font>";
	echo "</b></td></tr>";
	echo "<tr><td align=left>";

	if ($LogEntries){
	echo "��ܾ԰����{�����h��: <select name=Pl_Set_LogNum>";
	for ($i=0;$i<=$LogEntries;$i++) {echo "<option value='".$i."'"; if ($Pl_Settings['show_log_num'] == $i)echo " selected";echo ">".$i;}
	echo "</select><br>";}


	echo "�����b�u���aĵ�i: <input type=radio name=Pl_Set_AtkOnlineAlrt value=1";
	if($Pl_Settings['atkonline_alert']) echo " checked";
	echo "> �}�� <input type=radio name=Pl_Set_AtkOnlineAlrt value=0";
	if(!$Pl_Settings['atkonline_alert']) echo " checked";echo "> ����<br><br>";

	echo "<b>�Ϥ�����m�]�w</b><br>�H�U���]�w(�ť�)�h�|�ϥΦ��A���w�]<br>�ФŨϥΥ����r��(�]�A����r), �H�קK�ýX!<br>�ХΥH�U�覡��J:<br>";
	echo "�@http://�A�����}/���| &nbsp; &nbsp; &nbsp; &nbsp; (�o�Ҥl�|Ū���O���A�����Ϥ���)<br>";
	echo "�@file:///C:/���| &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; (�o�Ҥl�|Ū���ۤv�q���W���Ϥ���)<br>";
	echo "�I���Ϥ�: ";
	echo "<input type=text name='gen_img_dir' size='32' maxlength=128 value='$Pl_Settings[gen_img_dir]'><br>";
	echo "����Ϥ�: ";
	echo "<input type=text name='unit_img_dir' size='32' maxlength=128 value='$Pl_Settings[unit_img_dir]'><br>";
	echo "�t�ιϤ�: ";
	echo "<input type=text name='base_img_dir' size='32' maxlength=128 value='$Pl_Settings[base_img_dir]'><br><br>";

	echo "<b>�԰��C��L�o�t�γ]�w</b><br>";
	echo "�԰��C��L�o�t�γ]�w��[�ֹC���t��, ��i��K���a�m�\\<br>�p�n�ϥΪ���, �Х����<b>���ϥ�</b>�w�]�]�w<br><br>";
	echo "�Ъ`�N���n��ܤӦh���, �_�h�|<b>�Y����C�C���t��</b>!<br>�t�~�Ъ`�N: <b>���ϥιw�]�]�w</b><u style=\"color: red\">�L�k�����n��</u>�I<br><br>";
	echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <b>�ϥιw�]�]�w</b>: <input type=radio name=Pl_Set_BatDefFilter value=1";
	if($Pl_Settings['battle_def_filter']) echo " checked";
	echo "> �ϥ� <input type=radio name=Pl_Set_BatDefFilter value=0";
	if(!$Pl_Settings['battle_def_filter']) echo " checked";echo "> ���ϥ�<br><br>";

	echo "�@�@<b>������</b><br>";
	echo "<table width=50% border=0>";

	echo "<tr>";
	echo "<td align=right>Attacking �ż�:</td>";
	echo "<td><input type=radio name=Pl_Set_fdis_at value=1";
	if($Pl_Settings['fdis_at']) echo " checked";
	echo "> ��� <input type=radio name=Pl_Set_fdis_at value=0";
	if(!$Pl_Settings['fdis_at']) echo " checked";echo "> �����<br>";
	echo "</td></tr>";

	echo "<tr>";
	echo "<td align=right>Defending �ż�:</td>";
	echo "<td><input type=radio name=Pl_Set_fdis_de value=1";
	if($Pl_Settings['fdis_de']) echo " checked";
	echo "> ��� <input type=radio name=Pl_Set_fdis_de value=0";
	if(!$Pl_Settings['fdis_de']) echo " checked";echo "> �����<br>";
	echo "</td></tr>";

	echo "<tr>";
	echo "<td align=right>Reacting �ż�:</td>";
	echo "<td><input type=radio name=Pl_Set_fdis_re value=1";
	if($Pl_Settings['fdis_re']) echo " checked";
	echo "> ��� <input type=radio name=Pl_Set_fdis_re value=0";
	if(!$Pl_Settings['fdis_re']) echo " checked";echo "> �����<br>";
	echo "</td></tr>";

	echo "<tr>";
	echo "<td align=right>Targeting �ż�:</td>";
	echo "<td><input type=radio name=Pl_Set_fdis_ta value=1";
	if($Pl_Settings['fdis_ta']) echo " checked";
	echo "> ��� <input type=radio name=Pl_Set_fdis_ta value=0";
	if(!$Pl_Settings['fdis_ta']) echo " checked";echo "> �����<br>";
	echo "</td></tr>";

	echo "<tr>";
	echo "<td align=right>Level:</td>";
	echo "<td><input type=radio name=Pl_Set_fdis_lv value=1";
	if($Pl_Settings['fdis_lv']) echo " checked";
	echo "> ��� <input type=radio name=Pl_Set_fdis_lv value=0";
	if(!$Pl_Settings['fdis_lv']) echo " checked";echo "> �����<br>";
	echo "</td></tr>";

	echo "<tr>";
	echo "<td align=right>HP:</td>";
	echo "<td><input type=radio name=Pl_Set_fdis_hp value=1";
	if($Pl_Settings['fdis_hp']) echo " checked";
	echo "> ��� <input type=radio name=Pl_Set_fdis_hp value=0";
	if(!$Pl_Settings['fdis_hp']) echo " checked";echo "> �����<br>";
	echo "</td></tr>";

	echo "<tr>";
	echo "<td align=right>�W�n�δc�W:</td>";
	echo "<td><input type=radio name=Pl_Set_fdis_fame value=1";
	if($Pl_Settings['fdis_fame']) echo " checked";
	echo "> ��� <input type=radio name=Pl_Set_fdis_fame value=0";
	if(!$Pl_Settings['fdis_fame']) echo " checked";echo "> �����<br>";
	echo "</td></tr>";

	echo "<tr>";
	echo "<td align=right>�a���:</td>";
	echo "<td><input type=radio name=Pl_Set_fdis_bty value=1";
	if($Pl_Settings['fdis_bty']) echo " checked";
	echo "> ��� <input type=radio name=Pl_Set_fdis_bty value=0";
	if(!$Pl_Settings['fdis_bty']) echo " checked";echo "> �����<br>";
	echo "</td></tr>";

	echo "<tr>";
	echo "<td align=right>�ϥ�MS:</td>";
	echo "<td><input type=radio name=Pl_Set_fdis_ms value=1";
	if($Pl_Settings['fdis_ms']) echo " checked";
	echo "> ��� <input type=radio name=Pl_Set_fdis_ms value=0";
	if(!$Pl_Settings['fdis_ms']) echo " checked";echo "> �����<br>";
	echo "</td></tr>";

	echo "<tr>";
	echo "<td align=right>�H��Type:</td>";
	echo "<td><input type=radio name=Pl_Set_fdis_tch value=1";
	if($Pl_Settings['fdis_tch']) echo " checked";
	echo "> ��� <input type=radio name=Pl_Set_fdis_tch value=0";
	if(!$Pl_Settings['fdis_tch']) echo " checked";echo "> �����<br>";
	echo "</td></tr>";

	echo "<tr>";
	echo "<td align=right>�W�u�ΤU�u���A:</td>";
	echo "<td><input type=radio name=Pl_Set_fdis_con value=1";
	if($Pl_Settings['fdis_con']) echo " checked";
	echo "> ��� <input type=radio name=Pl_Set_fdis_con value=0";
	if(!$Pl_Settings['fdis_con']) echo " checked";echo "> �����<br>";
	echo "</td></tr>";
	echo "</table>";

	echo "<br>�@�@<b>�L�o�ﶵ</b><br>";
	echo "<table width=60% border=0>";

	echo "<tr>";
	echo "<td align=right width=37.5%>Attacking �d��:</td>";
	echo "<td><input type=text value=$Pl_Settings[filter_at_min] name='Pl_Set_filter_at_min' size=2 maxlength=3>��";
	echo "<input type=text value=$Pl_Settings[filter_at_max] name='Pl_Set_filter_at_max' size=2 maxlength=3>";
	echo "</td></tr>";

	echo "<tr>";
	echo "<td align=right> Defending �d��:</td>";
	echo "<td><input type=text value=$Pl_Settings[filter_de_min] name='Pl_Set_filter_de_min' size=2 maxlength=3>��";
	echo "<input type=text value=$Pl_Settings[filter_de_max] name='Pl_Set_filter_de_max' size=2 maxlength=3>";
	echo "</td></tr>";

	echo "<tr>";
	echo "<td align=right> Reacting �d��:</td>";
	echo "<td><input type=text value=$Pl_Settings[filter_re_min] name='Pl_Set_filter_re_min' size=2 maxlength=3>��";
	echo "<input type=text value=$Pl_Settings[filter_re_max] name='Pl_Set_filter_re_max' size=2 maxlength=3>";
	echo "</td></tr>";

	echo "<tr>";
	echo "<td align=right> Targeting �d��:</td>";
	echo "<td><input type=text value=$Pl_Settings[filter_ta_min] name='Pl_Set_filter_ta_min' size=2 maxlength=3>��";
	echo "<input type=text value=$Pl_Settings[filter_ta_max] name='Pl_Set_filter_ta_max' size=2 maxlength=3>";
	echo "</td></tr>";

	echo "<tr>";
	echo "<td align=right> Level �d��:</td>";
	echo "<td><input type=text value=$Pl_Settings[filter_lv_min] name='Pl_Set_filter_lv_min' size=2 maxlength=3>��";
	echo "<input type=text value=$Pl_Settings[filter_lv_max] name='Pl_Set_filter_lv_max' size=2 maxlength=3>";
	echo "</td></tr>";

	echo "<tr>";
	echo "<td align=right> HP�W���d��:</td>";
	echo "<td><input type=text value=$Pl_Settings[filter_hp_min] name='Pl_Set_filter_hp_min' size=5 maxlength=6>��";
	echo "<input type=text value=$Pl_Settings[filter_hp_max] name='Pl_Set_filter_hp_max' size=5 maxlength=6>";
	echo "</td></tr>";

	echo "<tr>";
	echo "<td align=right> �a����d��:</td>";
	echo "<td><input type=text value=$Pl_Settings[filter_bty_min] name='Pl_Set_filter_bty_min' size=8 maxlength=10>��";
	echo "<input type=text value=$Pl_Settings[filter_bty_max] name='Pl_Set_filter_bty_max' size=8 maxlength=10>";
	echo "</td></tr>";

	echo "<tr>";
	echo "<td align=right> �W�n�δc�W�d��:</td>";
	echo "<td><input type=text value=$Pl_Settings[filter_fame_min] name='Pl_Set_filter_fame_min' size=8 maxlength=10>��";
	echo "<input type=text value=$Pl_Settings[filter_fame_max] name='Pl_Set_filter_fame_max' size=8 maxlength=10>";
	echo "</td></tr>";

	echo "<tr>";
	echo "<td align=right> �W�u�ΤU�u:</td>";
	echo "<td><input type=radio name=Pl_Set_filter_con value=1";
	if($Pl_Settings['filter_con'] == 1) echo " checked";
	echo "> ��ܤW�u <input type=radio name=Pl_Set_filter_con value=2";
	if($Pl_Settings['filter_con'] == 2) echo " checked";
	echo "> ������u<br><input type=radio name=Pl_Set_filter_con value=0";
	if(!$Pl_Settings['filter_con']) echo " checked";echo "> �P�����<br>";
	echo "</td></tr>";

	echo "<tr>";
	echo "<td align=right> �ƦC�ѷ�:</td>";
	echo "<td><select name=filter_sort>";
	unset($i,$e);
	foreach(array('��´','������O','���m��O','����','�R��','����','HP','�a���','�ɶ�') as $i => $e){
	echo "<option value=".$i;
	if ($Pl_Settings['filter_sort'] == $i) echo " selected";
	echo ">$e";
	}
	unset($i,$e);
	echo "</select></td></tr>";

	echo "<tr>";
	echo "<td align=right> �ƦC����:</td>";
	echo "<td><input type=radio name=filter_sort_asc value=1";
	if($Pl_Settings['filter_sort_asc']) echo " checked";
	echo "> �p�ܤj <input type=radio name=filter_sort_asc value=0";
	if(!$Pl_Settings['filter_sort_asc']) echo " checked";echo "> �j�ܤp<br>";
	echo "</td></tr>";


	echo "</table>";

	echo "<input type=submit value=\"�T�w\"><input type=reset value=\"���s�]�w\">";

	echo "</tr></td></form></table>";


}
elseif ($mode=='settings' && $actionb == 'B'){

unset($Set,$i);
$i = 0;

$Pl_Set_LogNum = intval($Pl_Set_LogNum);
if ($Pl_Settings['show_log_num'] != $Pl_Set_LogNum && $Pl_Set_LogNum <= $LogEntries && $Pl_Set_LogNum >= 0){
$Set[$i] = "`show_log_num` = '$Pl_Set_LogNum'";$i++;}

if ($Pl_Settings['atkonline_alert'] != $Pl_Set_AtkOnlineAlrt){
$Set[$i] = ($Pl_Set_AtkOnlineAlrt) ? "`atkonline_alert` = '1'" : "`atkonline_alert` = '0'";$i++;
}

$ImgReplaceStr = '/[*?"<>|\\\'`]+/';

if ($Pl_Settings['gen_img_dir'] != $gen_img_dir){
$gen_img_dir = preg_replace($ImgReplaceStr,'',$gen_img_dir);
$Set[$i] = "`gen_img_dir` = '$gen_img_dir'";$i++;
}

if ($Pl_Settings['unit_img_dir'] != $unit_img_dir){
$unit_img_dir = preg_replace($ImgReplaceStr,'',$unit_img_dir);
$Set[$i] = "`unit_img_dir` = '$unit_img_dir'";$i++;
}

if ($Pl_Settings['base_img_dir'] != $base_img_dir){
$base_img_dir = preg_replace($ImgReplaceStr,'',$base_img_dir);
$Set[$i] = "`base_img_dir` = '$base_img_dir'";$i++;
}

if ($Pl_Settings['battle_def_filter'] != $Pl_Set_BatDefFilter){
$Set[$i] = ($Pl_Set_BatDefFilter) ? "`battle_def_filter` = '1'" : "`battle_def_filter` = '0'";$i++;
}

//Displays

if ($Pl_Settings['fdis_at'] != $Pl_Set_fdis_at){
$Set[$i] = ($Pl_Set_fdis_at) ? "`fdis_at` = '1'" : "`fdis_at` = '0'";$i++;
}

if ($Pl_Settings['fdis_de'] != $Pl_Set_fdis_de){
$Set[$i] = ($Pl_Set_fdis_de) ? "`fdis_de` = '1'" : "`fdis_de` = '0'";$i++;
}

if ($Pl_Settings['fdis_re'] != $Pl_Set_fdis_re){
$Set[$i] = ($Pl_Set_fdis_re) ? "`fdis_re` = '1'" : "`fdis_re` = '0'";$i++;
}

if ($Pl_Settings['fdis_ta'] != $Pl_Set_fdis_ta){
$Set[$i] = ($Pl_Set_fdis_ta) ? "`fdis_ta` = '1'" : "`fdis_ta` = '0'";$i++;
}

if ($Pl_Settings['fdis_lv'] != $Pl_Set_fdis_lv){
$Set[$i] = ($Pl_Set_fdis_lv) ? "`fdis_lv` = '1'" : "`fdis_lv` = '0'";$i++;
}

if ($Pl_Settings['fdis_hp'] != $Pl_Set_fdis_hp){
$Set[$i] = ($Pl_Set_fdis_hp) ? "`fdis_hp` = '1'" : "`fdis_hp` = '0'";$i++;
}

if ($Pl_Settings['fdis_fame'] != $Pl_Set_fdis_fame){
$Set[$i] = ($Pl_Set_fdis_fame) ? "`fdis_fame` = '1'" : "`fdis_fame` = '0'";$i++;
}

if ($Pl_Settings['fdis_bty'] != $Pl_Set_fdis_bty){
$Set[$i] = ($Pl_Set_fdis_bty) ? "`fdis_bty` = '1'" : "`fdis_bty` = '0'";$i++;
}

if ($Pl_Settings['fdis_ms'] != $Pl_Set_fdis_ms){
$Set[$i] = ($Pl_Set_fdis_ms) ? "`fdis_ms` = '1'" : "`fdis_ms` = '0'";$i++;
}

if ($Pl_Settings['fdis_tch'] != $Pl_Set_fdis_tch){
$Set[$i] = ($Pl_Set_fdis_tch) ? "`fdis_tch` = '1'" : "`fdis_tch` = '0'";$i++;
}

if ($Pl_Settings['fdis_con'] != $Pl_Set_fdis_con){
$Set[$i] = ($Pl_Set_fdis_con) ? "`fdis_con` = '1'" : "`fdis_con` = '0'";$i++;
}

if ($Pl_Settings['fdis_con'] != $Pl_Set_fdis_con){
$Set[$i] = ($Pl_Set_fdis_con) ? "`fdis_con` = '1'" : "`fdis_con` = '0'";$i++;
}

//Filters

unset($l,$m);
$l = array('at','de','re','ta','lv');

foreach($l as $m){
	unset($j,$k,$vi,$va,$Vi,$Va);
	$Vi = 'Pl_Set_filter_'.$m.'_min';
	$Va = 'Pl_Set_filter_'.$m.'_max';
	$vi = 'filter_'.$m.'_min';
	$va = 'filter_'.$m.'_max';
	$j = intval($$Vi);$k = intval($$Va);
	if ($j > 150) $j = 150;elseif ($j < 0) $j = 0;
	if ($k > 150) $k = 150;elseif ($k < 0) $k = 0;
	if ($Pl_Settings[$vi] != $j && $j <= $k){
	$Set[$i] = "`$vi` = '$j'";$i++;
	}
	if ($Pl_Settings[$va] != $k && $j <= $k){
	$Set[$i] = "`$va` = '$k'";$i++;
	}
}

unset($j,$k);
$j = intval($Pl_Set_filter_hp_min);$k = intval($Pl_Set_filter_hp_max);
if ($j > 9999999) $j = 9999999;elseif ($j < 0) $j = 0;
if ($k > 9999999) $k = 9999999;elseif ($k < 0) $k = 0;
if ($Pl_Settings['filter_hp_min'] != $j && $j <= $k){
$Set[$i] = "`filter_hp_min` = '$j'";$i++;
}
if ($Pl_Settings['filter_hp_max'] != $k && $j <= $k){
$Set[$i] = "`filter_hp_max` = '$k'";$i++;
}

unset($j,$k);
$j = intval($Pl_Set_filter_fame_min);$k = intval($Pl_Set_filter_fame_max);
if ($j > 1000) $j = 1000;elseif ($j < -1000) $j = -1000;
if ($k > 1000) $k = 1000;elseif ($k < -1000) $k = -1000;
if ($Pl_Settings['filter_fame_min'] != $j && $j <= $k){
$Set[$i] = "`filter_fame_min` = '$j'";$i++;
}
if ($Pl_Settings['filter_fame_max'] != $k && $j <= $k){
$Set[$i] = "`filter_fame_max` = '$k'";$i++;
}

unset($j,$k);
$j = intval($Pl_Set_filter_bty_min);$k = intval($Pl_Set_filter_bty_max);
if ($j > 9999999999) $j = 9999999999;elseif ($j < 0) $j = 0;
if ($k > 9999999999) $k = 9999999999;elseif ($k < 0) $k = 0;
if ($Pl_Settings['filter_bty_min'] != $j && $j <= $k){
$Set[$i] = "`filter_bty_min` = '$j'";$i++;
}
if ($Pl_Settings['filter_bty_max'] != $k && $j <= $k){
$Set[$i] = "`filter_bty_max` = '$k'";$i++;
}

if ($Pl_Settings['filter_con'] != $Pl_Set_filter_con){
if ($Pl_Set_filter_con == 1) $Set[$i] = "`filter_con` = '1'";
elseif ($Pl_Set_filter_con == 2) $Set[$i] = "`filter_con` = '2'";
else $Set[$i] = "`filter_con` = '0'";
$i++;
}

$filter_sort = intval($filter_sort);
if ($Pl_Settings['filter_sort'] != $filter_sort && $filter_sort >= 0 && $filter_sort <= 8){
$Set[$i] = "`filter_sort` = '$filter_sort'";
$i++;
}

if ($Pl_Settings['filter_sort_asc'] != $filter_sort_asc){
$Set[$i] = ($filter_sort_asc) ? "`filter_sort_asc` = '1'" : "`filter_sort_asc` = '0'";$i++;
}

unset($v,$k,$l,$SettingsQuery);
$SettingsQuery = '';
foreach($Set as $k => $v){$l = $k + 1;
	$SettingsQuery .= "$v";
	if ($l < $i) $SettingsQuery .= ', ';
}

if ($SettingsQuery)
mysql_query("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_settings` SET ".$SettingsQuery." WHERE `username` = '".$Pl_Value['USERNAME']."' LIMIT 1 ;") or die(mysql_error()."<br>$SettingsQuery");

	echo "<form action=scommand.php?action=settings method=post name=mainform>";
	echo "<input type=hidden value='A' name=actionb>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "<input type=hidden name=\"ModifiedFlag\" value=1></form>";
	//echo "<script language=\"JavaScript\">setTimeout(\"mainform.submit();\",1000);</script>";

	echo "<script language=\"JavaScript\">mainform.submit()</script>";
}
//�}�l�R���b��t��
elseif ($mode == 'delete_account' && $actionb == 'A'){

	echo "<font style=\"font-size: 12pt\">�S����O</font>";
	printTHR();

	echo "<form action=scommand.php?action=delete_account method=post name=mainform target=_parent>";
	echo "<input type=hidden value='B' name=actionb>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr><td align=left width=225><b style=\"font-size: 10pt;\">�R���b��: </b></td></tr>";
	echo "<tr><td align=left>";
	echo "<b>ĵ�i</b><Br>�z�i�H�b�o�̧R���o�ӱb��<br>���L��´��ɤH�ݭn����Ѵ���´<br>�@�g�R���A�Ҧ���ơA�]�A�ܮw�����˳�<Br>���|�Q�R�h�A�лդU�Ҽ{�M���I<Br>";
	echo "<script language=\"JavaScript\">";
	echo "function vldPass(){";
		echo "if (document.getElementById('pwd').value != '$Pl_Value[PASSWORD]'){alert('�K�X�����T�C');return false;}";
		echo "else if (confirm('�u���n�R���b��ܡH\\n�z�u�|�Q�ݳo�@���A�@���R���A�K����_��A�ЦҼ{�M���I') == true) {return true;}";
		echo "else {return false;}";
	echo "}</script>";
	echo "<hr>��J�K�X: <input type=password name=Pl_Value[PASSWORD] id=pwd><br>";
	echo "�T�w�R��: <input type=checkbox onClick=\"if (sbm_btn.disabled == true) sbm_btn.disabled = false; else sbm_btn.disabled = true;\"><br>";
	echo "<center><input type=submit name=sbm_btn disabled value=\"�R���b��\" onClick=\"return vldPass();\">";

	echo "</tr></td></form></table>";

}
elseif ($mode == 'delete_account' && $actionb == 'B'){

	if ($Game['rights'] == '1'){
	echo "<br><br><br><br><br><p align=center style=\"font-size: 16pt\">��´��ɤH�n����Ѵ���´�I<br>";
	echo "<form action=\"gmscrn_main.php?action=proc\" method=post name=login>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "<input type=submit value=\"��^�C��\">";
	echo "</form>";
	echo "<br><br><br>";
	exit;
	}

	mysql_query ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_mining_schedule` WHERE `mining_user` = '".$Pl_Value['USERNAME']."';");
	mysql_query ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_mining_sitem` WHERE `mining_user` = '".$Pl_Value['USERNAME']."';");
	mysql_query ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_mining_storage` WHERE `m_store_user` = '".$Pl_Value['USERNAME']."';");
	
	mysql_query ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_bank` WHERE `username` = '".$Pl_Value['USERNAME']."' Limit 1;");
	
	mysql_query ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `username` = '".$Pl_Value['USERNAME']."' Limit 1;");
	mysql_query ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` WHERE `username` = '".$Pl_Value['USERNAME']."' Limit 1;");
	
	mysql_query ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_hangar` WHERE `h_user` = '".$Pl_Value['USERNAME']."' Limit 1;");
	
	mysql_query ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_log` WHERE `username` = '".$Pl_Value['USERNAME']."' Limit 1;");
	mysql_query ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_settings` WHERE `username` = '".$Pl_Value['USERNAME']."' Limit 1;");
	mysql_query ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_tactfactory` WHERE `username` = '".$Pl_Value['USERNAME']."' Limit 1;");
	
	mysql_query ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_warehouse` WHERE `username` = '".$Pl_Value['USERNAME']."' Limit 1;");

	echo "<br><br><br><br><br><p align=center style=\"font-size: 16pt\">�w�g�R���b�� <b style='color: red'>$Pl_Value[USERNAME]</b> �C�C�C<br>";
	echo "<input type=button value=\"��^�D��\" onclick=\"location.replace('index2.php');\">";
	echo "<br><br><br>";
}
//�����R���b��t��
//�}�l�I���X���t��
elseif ($mode == 'redeemAlloy' && $actionb == 'A'){

	echo "<font style=\"font-size: 12pt\">�S����O</font>";
	printTHR();

	echo "<form action=scommand.php?action=redeemAlloy method=post name=mainform>";
	echo "<input type=hidden value='B' name=actionb>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr><td align=left width=225><b style=\"font-size: 10pt;\">�I���X��: </b></td></tr>";
	echo "<tr><td align=left>";
	echo "�z�i�H�b�o�̥γӧQ�Z���I�� �u�s���F���i�X���v <br>�I����v: <b>1 �� ".number_format($VPt2AlloyReq)."</b><Br>�Y�O ".number_format($VPt2AlloyReq)."�I �ӧQ�Z�� �i�H���� 1 �ӦX���I<br>";
	echo "�ҧI�����X���A�|�����s��դU���ܮw�A�Х��T�w�ܮw���S���h�l�Ŷ��I<br>";
	echo "�z���ӧQ�Z��: $Game[v_points]<br>";
	echo "<script language=\"JavaScript\">";
	echo "function vldPass(){";
		echo "if (document.getElementById('pwd').value != '$Pl_Value[PASSWORD]'){alert('�K�X�����T�C');return false;}";
		echo "else if (confirm('�u���n�I���X���ܡH\\n�z�u�|�Q�ݳo�@���A�@���I�������A�X�������٭즨�ӧQ�Z���A�ЦҼ{�M���I') == true) {return true;}";
		echo "else {return false;}";
	echo "}</script>";
	echo "<hr><center>�I��<select name=amountAlloy>";
	$MaxAmount = floor($Game['v_points']/$VPt2AlloyReq);
	for($i=1;$i<=$MaxAmount;$i++) echo "<option value=$i>$i";
	echo "</select>�ӦX��</center>";
	echo "<hr>�п�J�K�X: <input type=password name=Pl_Value[PASSWORD] id=pwd><br>";
	echo "�T�w�I��: <input type=checkbox onClick=\"if (sbm_btn.disabled == true) sbm_btn.disabled = false; else sbm_btn.disabled = true;\"><br>";
	echo "<center><input type=submit name=sbm_btn disabled value=\"�I���X��\" onClick=\"return vldPass();\">";

	echo "</tr></td></form></table>";

}
elseif ($mode == 'redeemAlloy' && $actionb == 'B'){

$amountAlloy = intval($amountAlloy);
$MaxAmount = floor($Game['v_points']/$VPt2AlloyReq);
if ($amountAlloy > $MaxAmount || $amountAlloy <= 0){echo "�I���ƶq�X���C<br>���ˬd�@�U�I";exit;}

//Get Warehouse Information
	//Set DataTable
	$sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_warehouse` WHERE username='". $Pl_Value['USERNAME'] ."'");
	$query_whr = mysql_query($sql);$defineuserc = 0;
	$defineuserc = mysql_num_rows($query_whr);
	if ($defineuserc == 0){
		$sqldfwh = ("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_user_warehouse` (username) VALUES('$Pl_Value[USERNAME]')");
		mysql_query($sqldfwh) or die ('<br><center>����إ߭ܮw���<br>��]:' . mysql_error() . '<br>');
		$sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_warehouse` WHERE username='". $Pl_Value['USERNAME'] ."'");
		$query_whr = mysql_query($sql) or die ('<br><center>������o�ܮw���<br>��]:' . mysql_error() . '<br>');
	}
	$Warehouse = mysql_fetch_row($query_whr);
	$WarehseWeps = explode("\n",$Warehouse[1]);
	$Countnumwhwp = count($WarehseWeps);
	if (($CFU_Time - $Warehouse[2]) <= 1){echo "�A��b�����ӧ֤F�C�Щ����A���C<br>�h�¦X�@�I";exit;}
//End Getting Warehouse Information
//Process
	unset($i);
	if ($Countnumwhwp+$amountAlloy > 100){echo "�Z���w�Ŷ������C<br>�Х��M�z�@�U�A�h�¦X�@�I";exit;}
	else {
		$AlloyEntry = "$AlloyID<!>0";
		for($i=1;$i<=$amountAlloy;$i++) $Warehouse[1] .="\n".$AlloyEntry;
			$WChacheArrays = explode("\n",$Warehouse[1]);
			sort($WChacheArrays);
			$Warehouse[1] = implode("\n",$WChacheArrays);
			$Warehouse[1] = trim($Warehouse[1]);
			$Game['v_points'] -= $amountAlloy * $VPt2AlloyReq;
			if($Game['v_points'] < 0){echo "�ӧQ�Z�������I";exit;}
			unset($sql);
			$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_warehouse` SET `warehouse` = '$Warehouse[1]', `timelast` = '$CFU_Time' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
			mysql_query($sql);unset($sql);
			$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `v_points` = '".$Game['v_points']."' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
			mysql_query($sql);
			unset($Gen,$Game,$UsrWepB,$UsrWepC,$UsWep_B,$UsWep_C);
		echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
		echo "<p align=center style=\"font-size: 16pt\">�I�������I<br><input type=submit value=\"��^\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
		echo "</form>";

		postFooter();exit;
	}
//End Process
}
//�����I���X���t��
else {echo "���w�q�ʧ@�I";}
postFooter();
echo "</body>";
echo "</html>";
exit;
?>