<?php
include('cfu.php');
postHead('');
$mode = ( isset($_GET['action']) ) ? $_GET['action'] : $_POST['action'];
$RkSbAct = ( isset($RkSbAct) ) ? $RkSbAct : false;
if ($mode == 'var'){echo $SCRIPT_FILENAME." <br><hr>".$H."-".$i."-".$nu;}
if ($mode == 'cal'){CalcExp('','','1');postFooter();exit;}
if ($mode == 'Footer'){echo "<br><br><br><br><br><br><br><br><br><br><br><br>";postFooter();exit;}
if ($mode == 'calpt'){$bb=3;$cc=2;$bbc=0;$ccc=0;
for($aa=1;$aa<=100;$aa++){
	if ($aa > 1){$bbc+= $bb;$ccc+= $cc;}
	if ($aa > 1)echo "$aa &nbsp;&nbsp; == &nbsp;&nbsp; $bb (".($bbc+40).") &nbsp;&nbsp; == $cc ($ccc)<br>";
	else echo "$aa &nbsp;&nbsp; == &nbsp;&nbsp; 0(40) &nbsp;&nbsp; == 0<br>";
	if ($aa%5 == 0)$bb++;
	if (($aa-1)%10 == 0 && $aa>1)$cc++;
	}exit;
}
if ($mode == 'time'){$timenow1 =time();$TT = cfu_time_convert($timenow1);$timenow2 = getdate();$hihihihi=strlen("$CFU_Date"); echo "$timenow1<br>$timenow2[year]�~$timenow2[mon]��$timenow2[mday]��<br>$CFU_Date<br>$hihihihi<hr>$TT";exit;}
	//Weapon List
if ($mode == 'weplist'){
	$sql_wep_listQ = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` ORDER BY `tier`, `name` ");
	$query_wep_list = mysql_query($sql_wep_listQ);
	$selected_wep = mysql_fetch_array($query_wep_list);
	$SearchField['Name'] = (isset($SearchField['Name'])) ? $SearchField['Name'] : 0;
	if ($SearchField['Name']){
	$number_of_weps = mysql_num_rows($query_wep_list);
	$search_wep_inf_listQ = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` WHERE `name` = '$SearchField[Name]'");
	$search_wep_inf_list = mysql_query($search_wep_inf_listQ);
	$search_wep_inf = mysql_fetch_array($search_wep_inf_list);

	if ($search_wep_inf['nextev']){
	$search_wep_nextev=explode(',',$search_wep_inf['nextev']);
	foreach($search_wep_nextev as $nextevid){
	GetWeaponDetails("$nextevid",'Next_Ev_Inf');
	$Next_Ev .= "$Next_Ev_Inf[name]<br>";
	}
	}
	else $Next_Ev= '�S��';

	if ($search_wep_inf['familyid'] && $search_wep_inf['familyid'] != $search_wep_inf['id']){
	$search_wep_prev_listQ = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` WHERE `nextev` REGEXP '($search_wep_inf[id])+'");
	$search_wep_prev_list = mysql_query($search_wep_prev_listQ) or die(mysql_error());
	$Pre_Ev_Inf  = mysql_fetch_array($search_wep_prev_list);
	$Pre_Ev='';
	do{$Pre_Ev .= "$Pre_Ev_Inf[name]<br>";}
	while ($Pre_Ev_Inf  = mysql_fetch_array($search_wep_prev_list));
	}else $Pre_Ev='�S��';
	}
	else {$Pre_Ev=$Next_Ev=" --- ";}
	echo "<p align=center style=\"font-size: 24; font-family: Arial\">php-eb �Z���C��</p>";
	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 12; font-family: Arial\" bordercolor=\"#FFFFFF\" width=\"600\">";
	echo "<form action=gen_info.php?action=weplist method=post name=searchwepform>";
	echo "<tr align=center valign=top height=75>";
	echo "<td>";
	echo "Previous Evolution<br>$Pre_Ev";
	echo "</td>";
	echo "<td>Current Weapon<br><select name=SearchField[Name]>";
	do
	{
	$selected_wep['name'] = (isset($selected_wep['name'])) ? $selected_wep['name'] : 0;
	echo "<option value=\"$selected_wep[name]\"";
	if($selected_wep['name'] == $SearchField['Name'])echo " selected";
	echo ">$selected_wep[name]\n";
	}
	while ($selected_wep = mysql_fetch_array($query_wep_list));
	echo "</select><input type=submit value=�˵�></td>";
	echo "<td>";
	echo "Next Evolution<br>$Next_Ev</td>";
	echo "</tr></form>";
	if ($SearchField['Name']){
	echo "<tr>";
	echo "<td colspan=3>�@<span style=\"font-size: 20;color: yellow;font-weight:600;font-family: Arial\">$search_wep_inf[name]</span><br>".sprintTHR('70%');
	echo "<table align=center border=\"0\" width=\"100%\" style=\"font-size: 12; font-family: Arial\">";
	echo "<tr align=center>";
	echo "<td width=33%>Evolution Grade:<br>";
	if ($search_wep_inf['familyid']){
		GetWeaponDetails($search_wep_inf['familyid'],"searchfamilyinf");
	echo "<b style=\"font-size: 15; color: blue\">$searchfamilyinf[name]�t</b><font style=\"font-size: 15; color: red\">��$search_wep_inf[complexity]�N</font>";}
	else echo "���A��";
	echo "</font></td>";
	echo "<td width=34%>Price: ".number_format($search_wep_inf['price'])."��</td>";
	echo "<td width=33%>Enery Cost: ".number_format($search_wep_inf['enc'])."</td>";
	echo "</tr><tr><td colspan=3>".sprintTHR('70%')."</td></tr>";
	echo "<tr height=300 style=\"font-size: 16;\">";
	echo "<td valign=top width=20%><b>�����O:</b> <br>";
	echo number_format($search_wep_inf['atk']);
	echo "<br><br><b>�����^��:</b><br>";
	echo number_format($search_wep_inf['rd']);
	echo "<br><br><b>�R��:</b><br>";
	echo number_format($search_wep_inf['hit']);
	echo "</td>";
	echo "<td colspan=2 valign=top width=80%><b>�S��ĪG:</b><br>";
	$search_wep_specs=ReturnSpecs($search_wep_inf['spec']);
	echo "$search_wep_specs</td>";
	echo "</tr>";
	echo "</table>";
	echo "</td></tr>";
	}
	echo "</table>";
	postFooter();
	exit;
}

	//Ms List
if ($mode == 'mslist'){
	$sql_ms_listQ = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_sys_ms` ORDER BY `msname`");
	$query_ms_list = mysql_query($sql_ms_listQ);
	$selected_ms = mysql_fetch_array($query_ms_list);
	$SearchField['Name'] = (isset($SearchField['Name'])) ? $SearchField['Name'] : 0;
	if ($SearchField['Name']){
	$number_of_ms = mysql_num_rows($query_ms_list);
	$search_ms_inf_listQ = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_sys_ms` WHERE `msname` = '$SearchField[Name]'");
	$search_ms_inf_list = mysql_query($search_ms_inf_listQ);
	$search_ms_inf = mysql_fetch_array($search_ms_inf_list);
	}
	echo "<p align=center style=\"font-size: 24; font-family: Arial\">php-eb ����C��</p>";
	printTHR('70%');
	echo "<div align=center><form action=gen_info.php?action=mslist method=post name=searchmsform><select name=SearchField[Name]>";
	do
	{
	$selected_ms['id'] = (isset($selected_ms['id'])) ? $selected_ms['id'] : 0;
	$selected_ms['msname'] = (isset($selected_ms['msname'])) ? $selected_ms['msname'] : 0;
	if ($selected_ms['id']) echo "<option value='$selected_ms[msname]'";
	if("$selected_ms[msname]" == "$SearchField[Name]")echo " selected";
	if ($selected_ms['id']) echo ">$selected_ms[msname]\n";
	}
	while ($selected_ms = mysql_fetch_array($query_ms_list));
	echo "</select><input type=submit value=�˵�>";
	echo "</form>";
	echo "</div>".sprintTHR('70%');
	if ($SearchField['Name']){
	echo "<table align=center border=\"0\" width=\"600\" style=\"font-size: 16; font-family: Arial\">";
	echo "<tr valign=top align=left height=400>";
	echo "<td width=20%><b style=\"font-size: 18\">$search_ms_inf[msname]<b><br>";
	echo "<img src='".$Unit_Image_Dir."/$search_ms_inf[image]'></td>";
	echo "<td width=4%>";
	echo "�@</td>";
	echo "<td width=38%>";
	echo "Hp�W���[��: ".number_format($search_ms_inf['hpfix']);
	echo "<br>En�W���[��: ".number_format($search_ms_inf['enfix']);
	printTHR('100%');
	echo "Attacking�[��: $search_ms_inf[atf]";
	echo "<br>Reacting�[��: $search_ms_inf[ref]".sprintTHR('100%');
	echo "<br>���: ".number_format($search_ms_inf['price']);
	echo "</td>";
	if (intval($search_ms_inf['hprec']) >= 1)$ShowHpRec=(intval($search_ms_inf['hprec'])+$HP_BASE_RECOVERY).'/��';
	elseif ($search_ms_inf['hprec'] < 1 && $search_ms_inf['hprec'] != 0)$ShowHpRec=($search_ms_inf['hprec']*100).'% /��';
	else $ShowHpRec='���|�^�_';
	if ($search_ms_inf['enrec'] >= 1)$ShowEnRec=(intval($search_ms_inf['enrec'])+$EN_BASE_RECOVERY).'/��';
	elseif ($search_ms_inf['enrec'] < 1 && $search_ms_inf['enrec'] != 0)$ShowEnRec=($search_ms_inf['enrec']*100).'% /��';
	else $ShowEnRec='���|�^�_';
	echo "<td width=38%>";
	echo "Hp�^�_�v: $ShowHpRec";
	echo "<br>En�^�_�v: $ShowEnRec";
	printTHR('100%');
	echo "Defending�[��: $search_ms_inf[def]";
	echo "<br>Targeting�[��: $search_ms_inf[taf]".sprintTHR('100%');
	echo "</td>";
	echo "</tr>";
	echo "</table>";
	}
	postFooter();
	exit;
}

if ($mode == 'ranks'){
echo "<form action='gen_info.php?action=ranks' method='post' name='typerkfrm'>";
echo "<input type=hidden name=\"RkSbAct\" value='none'>";
echo "<input type=hidden name=\"ByID\" value='true'>";
echo "<input type=hidden name=\"searchPlayer\" value=''>";
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
echo "<table width=100% height=100%><tr><td align=center>";
echo "<table cellspacing=2 cellpadding=3>";
echo "<tr><td colspan=3><center><b><font size=4>�Q�j�Ʀ�]</font></b></center></td></tr>";
echo "<td align=center><input type=submit value=\"�Q�j�I��\" onClick=\"typerkfrm.RkSbAct.value='Property'\">";
echo "<input type=submit value=\"�Q�j�W�H\" onClick=\"typerkfrm.RkSbAct.value='Famed'\">";
echo "<input type=submit value=\"�Q�j�c�H\" onClick=\"typerkfrm.RkSbAct.value='Notorous'\">";
echo "<input type=submit value=\"�Q�j�a��\" onClick=\"typerkfrm.RkSbAct.value='Bounty'\">";
echo "<input type=submit value=\"�Q�j�˥�\" onClick=\"typerkfrm.RkSbAct.value='HP'\">";
echo "<input type=submit value=\"�Q�j�෽\" onClick=\"typerkfrm.RkSbAct.value='EN'\"></td>";
echo "<tr><td align=center><input type=submit value=\"�Q�j����\" onClick=\"typerkfrm.RkSbAct.value='Att'\">";
echo "<input type=submit value=\"�Q�j�R��\" onClick=\"typerkfrm.RkSbAct.value='Tar'\">";
echo "<input type=submit value=\"�Q�j�j��\" onClick=\"typerkfrm.RkSbAct.value='Re'\">";
echo "<input type=submit value=\"�Q�j���m\" onClick=\"typerkfrm.RkSbAct.value='Def'\">";
echo "<input type=submit value=\"�Q�j����\" onClick=\"typerkfrm.RkSbAct.value='Level'\">";
echo "<input type=submit value=\"�Q�j�ӧQ\" onClick=\"typerkfrm.RkSbAct.value='Victory'\"></td></tr>";
echo "</tr>";
echo "<script language=\"JavaScript\">";
echo "function getPlayerInfo(player){";
echo "	typerkfrm.action='information.php?action=searchPlayer';";
echo "	typerkfrm.searchPlayer.value=player;";
echo "	typerkfrm.submit();";
echo "	}</script>";
echo "</table></form>";
echo "</td></tr>";

function printPlayerLink($gamename, $username){
	$mouseHover = " onmouseover=\"this.style.color='yellow';\" onmouseout=\"this.style.color='white';\" ";
	$mouseClick = " onClick=\"getPlayerInfo('$username')\" ";
	return sprintf('<span style="cursor: pointer; text-decoration: underline; color: white;" %s %s>%s</span>', $mouseClick, $mouseHover, $gamename);
}

if ($RkSbAct == 'Property'){
echo "<tr><td>";
echo "<table width=100% height=100% cellspacing=2 cellpadding=3 style=\"font-size:16px;\" border=1>";
echo "<tr><td colspan=6><center><b>�Q�j�I�αƦ�]</b></center></td></tr>";
echo "<tr><td>�W��</td><td>�r�ϭ��W��</td><td>���ݰ�a</td><td>�]���`��</td><td colspan=2>�ҥξ���</td></tr>";
$sqlgen  = ("SELECT a.cash AS property,gamename AS game,a.username AS user,e.name AS org,msname,image FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` a,`".$GLOBALS['DBPrefix']."phpeb_user_game_info` b,`".$GLOBALS['DBPrefix']."phpeb_user_bank` c,`".$GLOBALS['DBPrefix']."phpeb_sys_ms` d,`".$GLOBALS['DBPrefix']."phpeb_user_organization` e ");
$sqlgen .= ("WHERE a.username = b.username AND c.username = a.username AND d.id = msuit AND b.organization = e.id ");
$sqlgen .= ("ORDER BY `property` DESC LIMIT 10");
$query_gen = mysql_query($sqlgen) or die ('�L�k���o�򥻸�T, ��]:' . mysql_error() . '<br>');
$counter = 0;
while($PropInf = mysql_fetch_array($query_gen)){
$counter++;
echo "<tr><td>$counter</td><td>".printPlayerLink($PropInf['game'],$PropInf['user'])."</td><td> $PropInf[org] </td><td>$PropInf[property]</td><td>$PropInf[msname]</td><td><img src=\"".$Unit_Image_Dir."/$PropInf[image]\"></td></tr>";
}


echo "</table>";
echo "</tr></td>";
}

elseif ($RkSbAct == 'Notorous'){
echo "<tr><td>";
echo "<table width=100% height=100% cellspacing=2 cellpadding=3 style=\"font-size:16px;\" border=1>";
echo "<tr><td colspan=6><center><b>�Q�j�c�H�Ʀ�]</b></center></td></tr>";
echo "<tr><td>�W��</td><td>�r�ϭ��W��</td><td>���ݰ�a</td><td>�c�W��</td><td colspan=2>�ҥξ���</td></tr>";

$sqlgen  = ("SELECT fame,gamename AS game,a.username AS user,d.name AS org,msname,image FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` a,`".$GLOBALS['DBPrefix']."phpeb_user_game_info` b,`".$GLOBALS['DBPrefix']."phpeb_sys_ms` c,`".$GLOBALS['DBPrefix']."phpeb_user_organization` d ");
$sqlgen .= ("WHERE a.username = b.username AND c.id = msuit AND d.id = organization AND `fame` < 0 ");
$sqlgen .= ("ORDER BY `fame` ASC LIMIT 10");
$query_gen = mysql_query($sqlgen) or die ('�L�k���o�򥻸�T, ��]:' . mysql_error() . '<br>');
$counter = 0;
while($R_Inf = mysql_fetch_array($query_gen)){
$Notoriety = abs($R_Inf['fame']);
$counter++;
echo "<tr><td>$counter</td><td>".printPlayerLink($R_Inf['game'],$R_Inf['user'])."</td><td> $R_Inf[org] </td><td>$Notoriety</td><td>$R_Inf[msname]</td><td><img src=\"".$Unit_Image_Dir."/$R_Inf[image]\"></td></tr>";
}
echo "</table>";
echo "</tr></td>";
}

elseif ($RkSbAct == 'Famed'){
echo "<tr><td>";
echo "<table width=100% height=100% cellspacing=2 cellpadding=3 style=\"font-size:16px;\" border=1>";
echo "<tr><td colspan=6><center><b>�Q�j�W�H�Ʀ�]</b></center></td></tr>";
echo "<tr><td>�W��</td><td>�r�ϭ��W��</td><td>���ݰ�a</td><td>�W�n��</td><td colspan=2>�ҥξ���</td></tr>";
$sqlgen  = ("SELECT fame,gamename AS game,a.username AS user,d.name AS org,msname,image FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` a,`".$GLOBALS['DBPrefix']."phpeb_user_game_info` b,`".$GLOBALS['DBPrefix']."phpeb_sys_ms` c,`".$GLOBALS['DBPrefix']."phpeb_user_organization` d ");
$sqlgen .= ("WHERE a.username = b.username AND c.id = msuit AND d.id = organization AND `fame` > 0 ");
$sqlgen .= ("ORDER BY `fame` DESC LIMIT 10");
$query_gen = mysql_query($sqlgen) or die ('�L�k���o�򥻸�T, ��]:' . mysql_error() . '<br>');
$counter = 0;
while($R_Inf = mysql_fetch_array($query_gen)){
$counter++;
echo "<tr><td>$counter</td><td>".printPlayerLink($R_Inf['game'],$R_Inf['user'])."</td><td> $R_Inf[org] </td><td>$R_Inf[fame]</td><td>$R_Inf[msname]</td><td><img src=\"".$Unit_Image_Dir."/$R_Inf[image]\"></td></tr>";
}

echo "</table>";
echo "</tr></td>";
}

elseif ($RkSbAct == 'Bounty'){
echo "<tr><td>";
echo "<table width=100% height=100% cellspacing=2 cellpadding=3 style=\"font-size:16px;\" border=1>";
echo "<tr><td colspan=6><center><b>�Q�j�a����Ʀ�]</b></center></td></tr>";
echo "<tr><td>�W��</td><td>�r�ϭ��W��</td><td>���ݰ�a</td><td>�a���</td><td colspan=2>�ҥξ���</td></tr>";
$sqlgen  = ("SELECT bounty,gamename AS game,a.username AS user,d.name AS org,msname,image FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` a,`".$GLOBALS['DBPrefix']."phpeb_user_game_info` b,`".$GLOBALS['DBPrefix']."phpeb_sys_ms` c,`".$GLOBALS['DBPrefix']."phpeb_user_organization` d ");
$sqlgen .= ("WHERE a.username = b.username AND c.id = msuit AND d.id = organization AND `bounty` > 0 ");
$sqlgen .= ("ORDER BY `bounty` DESC LIMIT 10");
$query_gen = mysql_query($sqlgen) or die ('�L�k���o�򥻸�T, ��]:' . mysql_error() . '<br>');
$counter = 0;
while($R_Inf = mysql_fetch_array($query_gen)){
$counter++;
echo "<tr><td>$counter</td><td>".printPlayerLink($R_Inf['game'],$R_Inf['user'])."</td><td> $R_Inf[org] </td><td>$R_Inf[bounty]</td><td>$R_Inf[msname]</td><td><img src=\"".$Unit_Image_Dir."/$R_Inf[image]\"></td></tr>";
}

echo "</table>";
echo "</tr></td>";
}

elseif ($RkSbAct == 'Level'){
echo "<tr><td>";
echo "<table width=100% height=100% cellspacing=2 cellpadding=3 style=\"font-size:16px;\" border=1>";
echo "<tr><td colspan=6><center><b>�Q�j���űƦ�]</b></center></td></tr>";
echo "<tr><td>�W��</td><td>�r�ϭ��W��</td><td>���ݰ�a</td><td>����</td><td colspan=2>�ҥξ���</td></tr>";
$sqlgen  = ("SELECT level,gamename AS game,a.username AS user,d.name AS org,msname,image FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` a,`".$GLOBALS['DBPrefix']."phpeb_user_game_info` b,`".$GLOBALS['DBPrefix']."phpeb_sys_ms` c,`".$GLOBALS['DBPrefix']."phpeb_user_organization` d ");
$sqlgen .= ("WHERE a.username = b.username AND c.id = msuit AND d.id = organization AND `level` > 0 ");
$sqlgen .= ("ORDER BY `level` DESC LIMIT 10");
$query_gen = mysql_query($sqlgen) or die ('�L�k���o�򥻸�T, ��]:' . mysql_error() . '<br>');
$counter = 0;
while($R_Inf = mysql_fetch_array($query_gen)){
$counter++;
echo "<tr><td>$counter</td><td>".printPlayerLink($R_Inf['game'],$R_Inf['user'])."</td><td> $R_Inf[org] </td><td>$R_Inf[level]</td><td>$R_Inf[msname]</td><td><img src=\"".$Unit_Image_Dir."/$R_Inf[image]\"></td></tr>";
}

echo "</table>";
echo "</tr></td>";
}
elseif ($RkSbAct == 'HP'){
echo "<tr><td>";
echo "<table width=100% height=100% cellspacing=2 cellpadding=3 style=\"font-size:16px;\" border=1>";
echo "<tr><td colspan=6><center><b>�Q�j�˥ұƦ�]</b></center></td></tr>";
echo "<tr><td>�W��</td><td>�r�ϭ��W��</td><td>���ݰ�a</td><td>�˥�</td><td colspan=2>�ҥξ���</td></tr>";
$sqlgen  = ("SELECT hpmax,gamename AS game,a.username AS user,d.name AS org,msname,image FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` a,`".$GLOBALS['DBPrefix']."phpeb_user_game_info` b,`".$GLOBALS['DBPrefix']."phpeb_sys_ms` c,`".$GLOBALS['DBPrefix']."phpeb_user_organization` d ");
$sqlgen .= ("WHERE a.username = b.username AND c.id = msuit AND d.id = organization AND `hpmax` > 0 ");
$sqlgen .= ("ORDER BY `hpmax` DESC LIMIT 10");
$query_gen = mysql_query($sqlgen) or die ('�L�k���o�򥻸�T, ��]:' . mysql_error() . '<br>');
$counter = 0;
while($R_Inf = mysql_fetch_array($query_gen)){
$counter++;
echo "<tr><td>$counter</td><td>".printPlayerLink($R_Inf['game'],$R_Inf['user'])."</td><td> $R_Inf[org] </td><td>$R_Inf[hpmax]</td><td>$R_Inf[msname]</td><td><img src=\"".$Unit_Image_Dir."/$R_Inf[image]\"></td></tr>";
}

echo "</table>";
echo "</tr></td>";
}
elseif ($RkSbAct == 'EN'){
echo "<tr><td>";
echo "<table width=100% height=100% cellspacing=2 cellpadding=3 style=\"font-size:16px;\" border=1>";
echo "<tr><td colspan=6><center><b>�Q�j�෽�Ʀ�]</b></center></td></tr>";
echo "<tr><td>�W��</td><td>�r�ϭ��W��</td><td>���ݰ�a</td><td>�෽</td><td colspan=2>�ҥξ���</td></tr>";
$sqlgen  = ("SELECT enmax,gamename AS game,a.username AS user,d.name AS org,msname,image FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` a,`".$GLOBALS['DBPrefix']."phpeb_user_game_info` b,`".$GLOBALS['DBPrefix']."phpeb_sys_ms` c,`".$GLOBALS['DBPrefix']."phpeb_user_organization` d ");
$sqlgen .= ("WHERE a.username = b.username AND c.id = msuit AND d.id = organization AND `enmax` > 0 ");
$sqlgen .= ("ORDER BY `enmax` DESC LIMIT 10");
$query_gen = mysql_query($sqlgen) or die ('�L�k���o�򥻸�T, ��]:' . mysql_error() . '<br>');
$counter = 0;
while($R_Inf = mysql_fetch_array($query_gen)){
$counter++;
echo "<tr><td>$counter</td><td>".printPlayerLink($R_Inf['game'],$R_Inf['user'])."</td><td> $R_Inf[org] </td><td>$R_Inf[enmax]</td><td>$R_Inf[msname]</td><td><img src=\"".$Unit_Image_Dir."/$R_Inf[image]\"></td></tr>";
}

echo "</table>";
echo "</tr></td>";
}
elseif ($RkSbAct == 'Victory'){
echo "<tr><td>";
echo "<table width=100% height=100% cellspacing=2 cellpadding=3 style=\"font-size:16px;\" border=1>";
echo "<tr><td colspan=6><center><b>�Q�j�ӧQ�Ʀ�]</b></center></td></tr>";
echo "<tr><td>�W��</td><td>�r�ϭ��W��</td><td>���ݰ�a</td><td>�ӧQ�Z��/�ӧQ����</td><td colspan=2>�ҥξ���</td></tr>";
$sqlgen  = ("SELECT victory,v_points,gamename AS game,a.username AS user,d.name AS org,msname,image FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` a,`".$GLOBALS['DBPrefix']."phpeb_user_game_info` b,`".$GLOBALS['DBPrefix']."phpeb_sys_ms` c,`".$GLOBALS['DBPrefix']."phpeb_user_organization` d ");
$sqlgen .= ("WHERE a.username = b.username AND c.id = msuit AND d.id = organization AND `victory` > 0 ");
$sqlgen .= ("ORDER BY `victory` DESC LIMIT 10");
$query_gen = mysql_query($sqlgen) or die ('�L�k���o�򥻸�T, ��]:' . mysql_error() . '<br>');
$counter = 0;
while($R_Inf = mysql_fetch_array($query_gen)){
$counter++;
echo "<tr><td>$counter</td><td>".printPlayerLink($R_Inf['game'],$R_Inf['user'])."</td><td> $R_Inf[org] </td><td>".$R_Inf['v_points'].'/'.$R_Inf['victory']."</td><td>$R_Inf[msname]</td><td><img src=\"".$Unit_Image_Dir."/$R_Inf[image]\"></td></tr>";
}

echo "</table>";
echo "</tr></td>";
}
elseif ($RkSbAct == 'Att'){
echo "<tr><td>";
echo "<table width=100% height=100% cellspacing=2 cellpadding=3 style=\"font-size:16px;\" border=1>";
echo "<tr><td colspan=6><center><b>�Q�j�����Ʀ�]</b></center></td></tr>";
echo "<tr><td>�W��</td><td>�r�ϭ��W��</td><td>���ݰ�a</td><td>�����O</td><td colspan=2>�ҥξ���</td></tr>";
$sqlgen  = ("SELECT attacking,gamename AS game,a.username AS user,d.name AS org,msname,image FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` a,`".$GLOBALS['DBPrefix']."phpeb_user_game_info` b,`".$GLOBALS['DBPrefix']."phpeb_sys_ms` c,`".$GLOBALS['DBPrefix']."phpeb_user_organization` d ");
$sqlgen .= ("WHERE a.username = b.username AND c.id = msuit AND d.id = organization AND `attacking` > 0 ");
$sqlgen .= ("ORDER BY `attacking` DESC LIMIT 10");
$query_gen = mysql_query($sqlgen) or die ('�L�k���o�򥻸�T, ��]:' . mysql_error() . '<br>');
$counter = 0;
while($R_Inf = mysql_fetch_array($query_gen)){
$counter++;
echo "<tr><td>$counter</td><td>".printPlayerLink($R_Inf['game'],$R_Inf['user'])."</td><td> $R_Inf[org] </td><td>$R_Inf[attacking]</td><td>$R_Inf[msname]</td><td><img src=\"".$Unit_Image_Dir."/$R_Inf[image]\"></td></tr>";
}

echo "</table>";
echo "</tr></td>";
}
elseif ($RkSbAct == 'Tar'){
echo "<tr><td>";
echo "<table width=100% height=100% cellspacing=2 cellpadding=3 style=\"font-size:16px;\" border=1>";
echo "<tr><td colspan=6><center><b>�Q�j�R���Ʀ�]</b></center></td></tr>";
echo "<tr><td>�W��</td><td>�r�ϭ��W��</td><td>���ݰ�a</td><td>�R��</td><td colspan=2>�ҥξ���</td></tr>";
$sqlgen  = ("SELECT targeting,gamename AS game,a.username AS user,d.name AS org,msname,image FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` a,`".$GLOBALS['DBPrefix']."phpeb_user_game_info` b,`".$GLOBALS['DBPrefix']."phpeb_sys_ms` c,`".$GLOBALS['DBPrefix']."phpeb_user_organization` d ");
$sqlgen .= ("WHERE a.username = b.username AND c.id = msuit AND d.id = organization AND `targeting` > 0 ");
$sqlgen .= ("ORDER BY `targeting` DESC LIMIT 10");
$query_gen = mysql_query($sqlgen) or die ('�L�k���o�򥻸�T, ��]:' . mysql_error() . '<br>');
$counter = 0;
while($R_Inf = mysql_fetch_array($query_gen)){
$counter++;
echo "<tr><td>$counter</td><td>".printPlayerLink($R_Inf['game'],$R_Inf['user'])."</td><td> $R_Inf[org] </td><td>$R_Inf[targeting]</td><td>$R_Inf[msname]</td><td><img src=\"".$Unit_Image_Dir."/$R_Inf[image]\"></td></tr>";
}

echo "</table>";
echo "</tr></td>";
}
elseif ($RkSbAct == 'Re'){
echo "<tr><td>";
echo "<table width=100% height=100% cellspacing=2 cellpadding=3 style=\"font-size:16px;\" border=1>";
echo "<tr><td colspan=6><center><b>�Q�j�j�ױƦ�]</b></center></td></tr>";
echo "<tr><td>�W��</td><td>�r�ϭ��W��</td><td>���ݰ�a</td><td>�j��</td><td colspan=2>�ҥξ���</td></tr>";
$sqlgen  = ("SELECT reacting,gamename AS game,a.username AS user,d.name AS org,msname,image FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` a,`".$GLOBALS['DBPrefix']."phpeb_user_game_info` b,`".$GLOBALS['DBPrefix']."phpeb_sys_ms` c,`".$GLOBALS['DBPrefix']."phpeb_user_organization` d ");
$sqlgen .= ("WHERE a.username = b.username AND c.id = msuit AND d.id = organization AND `reacting` > 0 ");
$sqlgen .= ("ORDER BY `reacting` DESC LIMIT 10");
$query_gen = mysql_query($sqlgen) or die ('�L�k���o�򥻸�T, ��]:' . mysql_error() . '<br>');
$counter = 0;
while($R_Inf = mysql_fetch_array($query_gen)){
$counter++;
echo "<tr><td>$counter</td><td>".printPlayerLink($R_Inf['game'],$R_Inf['user'])."</td><td> $R_Inf[org] </td><td>$R_Inf[reacting]</td><td>$R_Inf[msname]</td><td><img src=\"".$Unit_Image_Dir."/$R_Inf[image]\"></td></tr>";
}

echo "</table>";
echo "</tr></td>";
}
elseif ($RkSbAct == 'Def'){
echo "<tr><td>";
echo "<table width=100% height=100% cellspacing=2 cellpadding=3 style=\"font-size:16px;\" border=1>";
echo "<tr><td colspan=6><center><b>�Q�j���m�Ʀ�]</b></center></td></tr>";
echo "<tr><td>�W��</td><td>�r�ϭ��W��</td><td>���ݰ�a</td><td>���m</td><td colspan=2>�ҥξ���</td></tr>";
$sqlgen  = ("SELECT defending,gamename AS game,a.username AS user,d.name AS org,msname,image FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` a,`".$GLOBALS['DBPrefix']."phpeb_user_game_info` b,`".$GLOBALS['DBPrefix']."phpeb_sys_ms` c,`".$GLOBALS['DBPrefix']."phpeb_user_organization` d ");
$sqlgen .= ("WHERE a.username = b.username AND c.id = msuit AND d.id = organization AND `defending` > 0 ");
$sqlgen .= ("ORDER BY `defending` DESC LIMIT 10");
$query_gen = mysql_query($sqlgen) or die ('�L�k���o�򥻸�T, ��]:' . mysql_error() . '<br>');
$counter = 0;
while($R_Inf = mysql_fetch_array($query_gen)){
$counter++;
echo "<tr><td>$counter</td><td>".printPlayerLink($R_Inf['game'],$R_Inf['user'])."</td><td> $R_Inf[org] </td><td>$R_Inf[defending]</td><td>$R_Inf[msname]</td><td><img src=\"".$Unit_Image_Dir."/$R_Inf[image]\"></td></tr>";
}

echo "</table>";
echo "</tr></td>";
}
echo "</table>";
}

if ($mode == 'history'){
		
echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#111111\" width=\"70%\" >";

echo "<tr><td align=center style=\"font-size:16px;\"><b>���v<b></tr></td>";

$sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_game_history` ORDER BY `time` DESC LIMIT 0 , 30");
$query = mysql_query($sql);
$HistoryEntries = mysql_num_rows($query);

for($CountHist=1;$CountHist <= $HistoryEntries;$CountHist++){
$History = mysql_fetch_array($query);
$History['DateTime'] = cfu_time_convert($History['time']);
echo "<tr><td align=left style=\"font-size:10px;\"><b style=\"font-size:12px;\">$History[DateTime]</b><br>";
echo "$History[history]";
echo "</tr></td>";
}

echo "</tr></td>";
echo "</table>";
exit;
}

if (!$mode){

echo "<br><br><br>";
echo "<center><iframe name='history' src='gen_info.php?action=history' width=75% height='200' marginheight=0 marginwidth=0 frameborder=0>";
echo '</iframe>';
}

postFooter();
?>
</html>