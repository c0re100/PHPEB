<?php
//-------------------------//-------------------------//-------------------------//
//----------------------------   Tactfactory System   ---------------------------//
//-------------------  php-eb Ultimate Edition Version v1.0  --------------------//
//---------------------------   Official Open Build    --------------------------//
//-------------------------//-------------------------//-------------------------//

$mode = ( isset($_GET['action']) ) ? $_GET['action'] : $_POST['action'];
include('cfu.php');
if (empty($PriTarget)) $PriTarget = 'Alpha';
if (empty($SecTarget)) $SecTarget = 'Beta';
postHead('');
AuthUser("$Pl_Value[USERNAME]","$Pl_Value[PASSWORD]");
GetUsrDetails("$Pl_Value[USERNAME]",'Gen','Game');
$UsrWepB = explode('<!>',$Game['wepb']);
$UsrWepB[2] = (isset($UsrWepB[2])) ? $UsrWepB[2]: 0;
$UsrWepC = explode('<!>',$Game['wepc']);
$UsrWepC[2] = (isset($UsrWepC[2])) ? $UsrWepC[2]: 0;

include('includes/tactfactory.inc.php');
include('plugins/mining/mining.config.php');

unset($IncThread);

$TargetPut = 0;

//Set DataTable
$sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_tactfactory` WHERE username='". $Pl_Value['USERNAME'] ."'");
$query_ttf = mysql_query($sql);$defineuserc = 0;
$defineuserc = mysql_num_rows($query_ttf);

if ($defineuserc == 0){
	$sqldftf = ("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_user_tactfactory` (username,time) VALUES('$Pl_Value[USERNAME]','$CFU_Time')");
	mysql_query($sqldftf) or die ('<br><center>����إߧL���s�y�u�����<br>��]:' . mysql_error() . '<br>');
	$sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_tactfactory` WHERE username='". $Pl_Value['USERNAME'] ."'");
	$query_ttf = mysql_query($sql) or die ('<br><center>������o�L���s�y�u�����<br>��]:' . mysql_error() . '<br>');
}

global $TactFactory;
$TactFactory = mysql_fetch_array($query_ttf);

if (($CFU_Time - $TactFactory['time']) < 1 && $defineuserc){
	echo "�A��b�����ӧ֤F�C�Щ����A���C<br>�h�¦X�@�I";
	postFooter();
	exit;
}

//Weapon Casting GUI
if ($mode=='main' && $actionb=='none'){
	echo "�L���s�y�u��<Hr>";
	echo "<form action=tactfactory.php?action=main method=post name=mainform target=$SecTarget>";
	echo "<input type=hidden value='none' name=actionb>";
	echo "<input type=hidden value='none' name=actionc>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

	//Start Table -- User's Information
	
	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-size: 12pt; border-collapse: collapse\" bordercolor=\"#111111\" width=\"400\" id=\"AutoNumber1\">";
	echo "<tr><td width=400 colspan=2>$Game[gamename] ���˳�</td></tr>";
	printPutOption($UsrWepB,'b');
	printPutOption($UsrWepC,'c');
	echo "</table>";
	
	//End Table -- User's Information

	echo "<hr align=center width=80%>";

	//Start Table -- Factory's Information
	$checkPresence = false;
	for($a = 1;$a <= 20;$a++){
		$c = 'm'.$a;
		if (isset($TactFactory[$c])){
			if ($TactFactory[$c]) {
				$checkPresence = true;
				break;
			}
		}
	}

	if($checkPresence){
		// JavaScripts
		echo "<script language=\"Javascript\">function CfmCast(){if (confirm('�u���n�}�l�X���u�ǶܡH\\n�@�����ѤF�A�Ҧ���ƴN�|�����I\\n�w�Ҽ{�M���ܡH')==true){";
		echo "mainform.action='tactfactory.php?action=cast';mainform.actionb.value='start';mainform.submit();}";
		echo "else {return false;}";
		echo "}</script>";

		// �X����Ʈw Table
		echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#111111\" width=\"700\">";
		echo "<tr><td width=700 colspan=6 align=center>�Z�˦X���w</td></tr>";
		for($i = 1; $i <= 10; $i++){
			$ii = $i + 10;
			echo '<tr><td width=40 align=right>'.$i.'��:&nbsp;</td>';
			printBinDetails($i);
			echo '<td width=40 align=right>'.$ii.'��:&nbsp;</td>';
			printBinDetails($ii);
			echo "</tr>";
		}
		// Raw Materials
		echo "<tr><td colspan=6 align=center><b>�[�J���</b>: &nbsp;";
		$pFormatStr = '%s: <input type=text maxlength=3 name="raw[%d]" value=0 style="height: 14pt; width: 30px; text-align: center; '.$BStyleA.'" onClick="this.value=\'\'" onChange="this.value=parseInt(this.value)"> &nbsp; &nbsp;';
		$pFormatStrB = '%s: <input type=text maxlength=3 name="rawCur[%d]" disabled value="%d" style="height: 14pt; width: 30px; text-align: center; '.$BStyleA.'" > &nbsp; &nbsp;';
		for($i = 1; $i <= 8; $i++){
			printf($pFormatStr, $product_id_list[$i], $i);
		}
		$rawBins = getMiningStorage($Pl_Value['USERNAME']);
		echo "<br><b>�{�����</b>: &nbsp;";
		for($i = 1; $i <= 8; $i++){
			printf($pFormatStrB, $product_id_list[$i], $i, $rawBins[$i]);
		}
		echo "</td></tr>";
		echo "</table>";

		// Confirmation Button
		echo "<br><center><input type=button name='start' value='�}�l�X���u��' onClick=\"CfmCast()\"></center>";
		echo "<hr align=center width=80%>";
	}

	echo "<p align=center><input type=button value='�u������' onClick=\"mainform.action='tactfactory.php?action=readme';mainform.submit();\"><input type=button value='�M�ΤƧ�y' onClick=\"mainform.action='tactfactory.php?action=custom';mainform.submit();\"><input type=button value='�u�{�v�u�|' onClick=\"mainform.action='tactfactory.php?action=guild';mainform.submit();\"><input type=button value='�i�J�Z���w' onClick=\"mainform.action='warehouse.php?action=main';mainform.submit();\"></p>";
	echo "</form>";
}
//Process with Put Weapon
elseif ($mode=='main' && $actionb=='put' && $actionc){

	if (!$Game[$actionc] && $actionc != 'wh'){echo "�S�����˳Ʀs�b�C";postFooter();exit;}
	if ($actionc == 'wepa'){echo "�����˳Ʀs�b�A�i�O�ڭ̵L�k��Z���q�z���骺�⤤��U�ӡC";postFooter();exit;}
	if ($actionc != 'wepb' && $actionc != 'wepc' && $actionc != 'wh'){echo "�z�Q��A�ۤv��@��ƶܡH";postFooter();exit;}

	$counter = 1;
	$TargetPut = 0;
	while($counter <= 20){
		$mc='m'.$counter;
		if (!$TactFactory[$mc]){
			$TargetPut = $mc;
			break;
		}
		$counter++;
	}

	if (!$TargetPut){echo "��Ʈw�w���F�A�A�u��ı�o���ݭn�Ψ���h��ƶܡH";postFooter();exit;};
	unset($counter,$sql);

	if($actionc != 'wh') $TargetPutWep = explode('<!>',$Game[$actionc]);
	else{
		$sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_warehouse` WHERE username='". $Pl_Value['USERNAME'] ."'");
		$query_whr = mysql_query($sql);
		$defineuserc = mysql_num_rows($query_whr);
		if ($defineuserc == 0){
			$sqldfwh = ("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_user_warehouse` (username) VALUES('$Pl_Value[USERNAME]')");
			mysql_query($sqldfwh) or die ('<br><center>����إ߭ܮw���<br>��]:' . mysql_error() . '<br>');
			$sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_warehouse` WHERE username='". $Pl_Value['USERNAME'] ."'");
			$query_whr = mysql_query($sql) or die ('<br><center>������o�ܮw���<br>��]:' . mysql_error() . '<br>');
		}elseif ($defineuserc > 1){echo "�Τ�W�٥X�{���D�A���p���޲z���C";exit;}
		$Warehouse = mysql_fetch_row($query_whr);
		
		if ($getwep == 'none'){echo '�Ы��w�n�m�񪺸˳ơC';postFooter();exit;}
		else {
			$WChacheArrays = explode("\n",$Warehouse[1]);
			sort($WChacheArrays);
			$Warehouse[1] = implode("\n",$WChacheArrays);
			$Warehouse[1] = trim($Warehouse[1]);
	
			$GetWarehseWeps = explode("\n",$Warehouse[1]);
			$TargetPutWep = explode('<!>',$GetWarehseWeps[$getwep]);
	
			unset($GetWarehseWeps[$getwep]);
			sort($GetWarehseWeps);
	
			$Warehouse[1] = implode("\n",$GetWarehseWeps);
			$Warehouse[1] = trim($Warehouse[1]);
		}
	}

	$TargetPutWep[2]= (isset($TargetPutWep[2])) ? $TargetPutWep[2]: 0;
	if ($TargetPutWep[2]){echo "�i��L�M�ΤƧ�y���˳ƵL�k�������ơC";postFooter();exit;}
	if ($TargetPutWep[1] < $RepairEqCondMax){echo "���˳ƪ��A�Ӯt, �L�k�������ơC";postFooter();exit;}
	
	if($actionc != 'wh'){
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `$actionc` = '0<!>0' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
		mysql_query($sql);unset($sql);
	}
	else{
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_warehouse` SET `warehouse` = '$Warehouse[1]', `timelast` = '$CFU_Time' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
		mysql_query($sql);
	}

	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_tactfactory` SET `time` = '$CFU_Time', `".$mc."` = '$TargetPutWep[0]' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
	mysql_query($sql) or die(mysql_error());unset($sql);
	
	echo "<form action=tactfactory.php?action=main method=post name=freect target=$SecTarget>";
	echo "<input type=hidden value='none' name=actionb>";
	echo "<input type=hidden value='none' name=actionc>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";
	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
	echo "<p align=center style=\"font-size: 16pt\">�m�񧹦��F�I<br><input type=submit value=\"��^\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\">";
	echo "<input type=button value=\"�^��u��\" onClick=\"freect.submit()\"><input type=button value='�i�J�Z���w' onClick=\"freect.action='warehouse.php?action=main';freect.submit();\"></p>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";	
}
//Process with View Blueprint
elseif ($mode=='main' && $actionb=='view' && $actionc){

	if ($actionc == 'wepa'){echo "�ŹϦ�m�X���C";postFooter();exit;}
	if ($actionc != 'wepb' && $actionc != 'wepc' && $actionc != 'wh'){echo "�ŹϦ�m�X���C";postFooter();exit;}
	if (!$Game[$actionc] && $actionc != 'wh'){echo "�S�����˳Ʀs�b�C";postFooter();exit;}

	if($actionc != 'wh') $TargetView = explode('<!>',$Game[$actionc]);
	else{
		$sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_warehouse` WHERE username='". $Pl_Value['USERNAME'] ."'");
		$query_whr = mysql_query($sql);
		if (mysql_num_rows($query_whr) != 1){echo "�Τ�W�٥X�{���D�A���p���޲z���C";exit;}

		$Warehouse = mysql_fetch_row($query_whr);
		
		if ($getwep == 'none'){echo '�Ы��w�n�ˬd���ŹϡC';postFooter();exit;}
		else {
			$WChacheArrays = explode("\n",$Warehouse[1]);
			sort($WChacheArrays);
			$Warehouse[1] = implode("\n",$WChacheArrays);
			$Warehouse[1] = trim($Warehouse[1]);
			$GetWarehseWeps = explode("\n",$Warehouse[1]);
			$TargetView = explode('<!>',$GetWarehseWeps[$getwep]);
		}
	}

	$sql = ("SELECT `directions`,
	`m1` ,`m2` ,`m3` ,`m4` ,`m5` ,`m6` ,`m7` ,`m8` ,`m9` ,`m10` ,
	`m11` , `m12` ,`m13` ,`m14` ,`m15` ,`m16` ,`m17` ,`m18` ,`m19` ,`m20` ,
	`raw_materials` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` WHERE `blueprint` = '$TargetView[0]'");
	$query = mysql_query($sql);

	if (mysql_num_rows($query) != 1){echo "<br><br><p align=center style='font-size: 14pt' >�䤣��ؼ��ŹϡC<br>�нT�{�Ӫ��~�O�_���u�]�p�Źϡv�C";}
	else{
		$Directions = mysql_fetch_row($query);
		echo "<table><tr><td><font color=orange>���</font></td></tr>";
		echo "<tr><td>". str_replace('\"','"',$Directions[0]) ."</td></tr>";
		echo "<tr><td style='text-align: center;'>";
		printBPTable($Directions, $product_id_list);
		echo "</td></tr>";
		echo "<tr><td><font color=orange>�ЧA�O�C�U�o�ǹ��</font></td></tr></table>";
	}
	
	echo "<form action=tactfactory.php?action=main method=post name=freect target=$SecTarget>";
	echo "<input type=hidden value='none' name=actionb>";
	echo "<input type=hidden value='none' name=actionc>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";
	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
	echo "<p align=center><input type=submit value=\"��^\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\">";
	echo "<input type=button value=\"�^��u��\" onClick=\"freect.submit()\"><input type=button value='�i�J�Z���w' onClick=\"freect.action='warehouse.php?action=main';freect.submit();\"></p>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";	
}

//Process with Reclaim Weapon
elseif ($mode=='main' && $actionb=='reclaim' && $actionc){
	if (!$TactFactory[$actionc]){echo "�S�����˳Ʀs�b�C";postFooter();exit;}
	if (!$UsrWepB[0]){$TargetRec = 'wepb';}
	elseif (!$UsrWepC[0]){$TargetRec = 'wepc';}
	else{echo "�S�Ŧ�˳ơC";postFooter();exit;}
	unset($sql);
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `$TargetRec` = '".$TactFactory[$actionc]."<!>0' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
	mysql_query($sql);unset($sql);
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_tactfactory` SET `time` = '$CFU_Time', `".$actionc."` = '' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
	mysql_query($sql) or die(mysql_error());unset($sql);
	echo "<form action=tactfactory.php?action=main method=post name=freect target=$SecTarget>";
	echo "<input type=hidden value='none' name=actionb>";
	echo "<input type=hidden value='none' name=actionc>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";
	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
	echo "<p align=center style=\"font-size: 16pt\">�^�������F�I<br><input type=submit value=\"��^\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"><input type=button value=\"�~��\" onClick=\"freect.submit()\"></p>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";	
}//End Reclaim and Put

//Start Cast
elseif($mode == 'cast' && $actionb == 'start' && $actionc=='none'){
	if(isset($ChosenTact)){echo "�A�Q�F����H";postFooter();exit;}
	if (!$UsrWepB[0]){$TargetGrant = 'wepb';}
	elseif (!$UsrWepC[0]){$TargetGrant = 'wepc';}
	else{echo "�S�Ŧ�˳ơC";postFooter();exit;}
	
	$raw[0] = 0;
	$Storage = array();
	for($i = 1; $i <= 8; $i++){
		$raw[$i] = intval($raw[$i]);
		if($raw[$i] < 0) $raw[$i] = 0;
		$raw[0] += $raw[$i];
	}
	
	$j = 0;
	$sqlStorage = array();
	$SQL_Format = 'UPDATE `'.$GLOBALS['DBPrefix'].'phpeb_mining_storage` SET `quantity` = %d WHERE `m_store_user` = \''.$Game['username'].'\' AND `item` = %d ;';
	if($raw[0] > 0){
		if(checkMBillsPending($Game['username'])){
			echo "�Х���I��ƱĶ��O�A�h�¦X�@�C";postFooter();exit;
		}
		$Storage = getMiningStorage($Game['username']);
		for($i = 1; $i <= 8; $i++){
			if($raw[$i] > 0){
				$Storage[$i] -= $raw[$i];
				if($Storage[$i] < 0){
					echo "<br><p align=center style='font-size: 12pt'>��Ƥ����I</p>";
					postFooter();
					exit;
				}
				$sqlStorage[$j] = sprintf($SQL_Format,$Storage[$i],$i);
				$j++;
			}
		}
	}
	
	$CastResult='';
	
	unset($sql,$query,$counter,$StopFlag,$mc);
	$sql = "SELECT `wep_id`, `m1`, `m2`, `m3`, `m4`, `m5`, `m6`, `m7`, `m8`, `m9`, `m10`, `m11`, `m12`, `m13`, `m14`, `m15`, `m16`, `m17`, `m18`, `m19`, `m20`, `raw_materials` ";
	$sql .= " FROM `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` ";
	$sql .= " WHERE `m1` = '$TactFactory[m1]' ORDER BY `grade` DESC;";	// Refine results
	$query = mysql_query($sql) or die ('<br><center>������o�L���s�y�u�����<br>��]:' . mysql_error() . '<br>');
	$nosrow = mysql_num_rows($query);
	unset($counter,$counterb,$counterc,$mb,$ChosenTact);

	// Analyse ID of attempted tact
	$ChosenTact = 0;
	$RawReq = '';
	$counter=1;
	while($Tacticals = mysql_fetch_array($query)){
		//Calculate number of bins required to analyse
		$counterb = 1;
		while($counterb <= 20 && !$StopFlagB){
			$mb='m'.$counterb;
			if (isset($Tacticals[$mb])){
				if($Tacticals[$mb] && $Tacticals[$mb] != 'NULL'){
					$counterb++;
					continue;
				}
			}
			break;
		}
		//Number of Bins actually needed calculated
		// `$counterb` = Actual Number of Bins + 1, reflect in for-loop
		$counterc = 1;
		$mc = '';
		$WrongFlag = false;
		for(; $counterc < $counterb; $counterc++){
			$mc='m'.$counterc;
			if ($TactFactory[$mc] != $Tacticals[$mc]){
				$WrongFlag = true;
				break;
			}
		}
		//Analysed right or wrong
		if(!$WrongFlag){
			$ChosenTact = $Tacticals['wep_id'];
			$RawReq = $Tacticals['raw_materials'];
			break;	// Prevent Further Analysis
		}
	}
	//Analysed attempt tact/weapon ID

	//Analyse Sufficiency of Raw Materials
	$RawReqs = getRaw($RawReq);
	if($RawReqs[0] > 0){
		if($raw[0] <= 0){
				$ChosenTact = 0;
		}
		else{
			for($i = 1; $i <= 8; $i++){
				if($raw[$i] < $RawReqs[$i]){
					$ChosenTact = 0;
					break;
				}
			}
		}
	}

	//Grant Chosen Weapon
	if ($ChosenTact){
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `$TargetGrant` = '".$ChosenTact."<!>0' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
		mysql_query($sql);
		$CastResult = "�X���u�Ƕ��Q����!!<br>�w�s�y�X <font color=blue>".getWeaponName($ChosenTact)."</font> �I";
	}else{
		$CastResult = "�s�y���ѤF�C�]�\�A�����t��M�W�[��Ƽƶq�C";
	}

	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_tactfactory` SET `time` = '$CFU_Time', `m1` = '', `m2` = '', `m3` = NULL, `m4` = NULL, `m5` = NULL, `m6` = NULL, `m7` = NULL, `m8` = NULL, `m9` = NULL, `m10` = NULL, `m11` = NULL, `m12` = NULL, `m13` = NULL, `m14` = NULL, `m15` = NULL, `m16` = NULL, `m17` = NULL, `m18` = NULL, `m19` = NULL, `m20` = NULL WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1"); 
	mysql_query($sql) or die(mysql_error());unset($sql);

	if(count($sqlStorage) > 0){
		foreach($sqlStorage As $sql) mysql_query($sql);
	}

	echo "<form action=tactfactory.php?action=main method=post name=freect target=$SecTarget>";
	echo "<input type=hidden value='none' name=actionb>";
	echo "<input type=hidden value='none' name=actionc>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";
	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
	echo "<p align=center style=\"font-size: 16pt\">$CastResult<br><input type=submit value=\"��^\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"><input type=button value=\"�~��\" onClick=\"freect.submit()\"></p>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";	
}
elseif($mode == 'readme' && $actionb == 'none' && $actionc=='none'){
echo "�L���s�y�u��<hr>";
	if($RepairEqCondMax == 0) $DisMinXp = '��0%';
	else $DisMinXp = ($RepairEqCondMax > 0) ? '+'.($RepairEqCondMax/100) : ($RepairEqCondMax/100);
	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr><td align=center width=400><b style=\"font-size: 10pt;\">�L���s�y�u������</b></td></tr>";
	echo "<tr><td align=left>";
	echo "<b>�L���s�y�u��</b><Br>�@- �i�H���P����ơB�Z���B�˳�, �X���s���Z���M�˳�<br>�@- �X���Z����, ������ӫ���(�]�p�Ź�/�X���k)�i��, �_�h�X���|����<br>�@- ���Ѫ���, �|���h�Ҧ���ƩM����b�����l�������~<br>�@- ����m��b�����l�����~, ���|���h�Ҧ����A��<br>�@- �˳ƪ��A����Ӯt, ������ $DisMinXp �H�W, �_�h�L�k�������ơC<br>";
	echo "<b>�M�ΤƧ�y�u��</b><Br>�@- �M�ΤƯ�����A��y�Z���B���ɫ¤O�M�Ĳv�C<br>�@- ��Z���ŦX�@�w������ɡA�i�H�i��M�ΤơC<br>�@- ����p�U:<br>�@ �@ - �Z�����A�ȹF +250% <br>�@ �@ - �Z�����S���i��M�Τ� <br>�@ �@ - �M�ΤƧ�����A�Z���g���k�s�C<br>�@- ���Ѫ���, �|���h�Ҧ���ƩM�i��M�Τƪ��Z��<br>�@- ����m��b�����l�����~, ���|���h�Ҧ��g��<br>";
	echo "<b>�u�{�v�u�|</b><Br>�@- �i�H�b�o�ʶR�X���Ź�<br>�@- �C���ʶR��]�|�o��Y�Z�˪�<B>�]�p�Ź�</B>�@�T<br>";
	echo "</tr></td></table>";
}
elseif($mode == 'guild' && $actionb == 'none' && $actionc=='none'){
	echo "�L���s�y�u�� -- �u�{�v�u�|<hr>";
	echo "
	<table>
	<tr><td>�ϥλ���</td></tr>
	<tr>
	<td style=\"font-size: 10pt\">
	�o�̬O�u�{�v�u�|�A�A�i�H�b�o�ʶR�X���ŹϡA�|���@�ܤT�Ӧ�u�{�v�^���A���A���u���@�ӤH�����ܬO�����T���C
	<br>�Ъ`�N, �Z�˦X���w�������ƩM���, �Y�ϩ�h�F, �]���|�v�T�X�����G�C
	<br>�i�O, ��Ƽƶq����, �άO�Z���B�˳ƪ����ǿ��F�A�o�|�X�����ѡB�\\���@±�I
	<br>�X���Z���������šA���O�O�Ѥ@�ŦܤQ�šC�Q�Ŭ��̰��šC
	<br>��������<font color=red>�H�żƤW��</font>�C������: �G���ŧO���譼".($TFDCostCons)." (�Y 2<sup>n</sup> * ".($TFDCostCons)." )
	</td></tr>
	<tr><td>
	<form action=tactfactory.php?action=guild method=post name=mainform>";
	echo "<input type=hidden value='buy' name=actionb>";
	echo "<input type=hidden value='none' name=actionc>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "�ʶR: 
	<script langauge=\"Javascript\">
	function changeprice(){
		document.getElementById('cost').innerHTML = (Math.pow(2,document.mainform.grade.value))*".($TFDCostCons).";
		if (cost.innerHTML > $Gen[cash]){document.getElementById('cost').style.color='Red';}
		else {document.getElementById('cost').style.color='DodgerBlue';}
	}
	function ChkBuy(){
	if (document.getElementById('cost').innerHTML > $Gen[cash]){alert('���������I');return false;}
	else {if (confirm('�T�w�n�ʶR�ܡH')==true){return true;}else{return false;}}
	}</script>
	<select name='grade' onchange=\"changeprice()\">
	<option value=1 selected>�@��</option>
	<option value=2>�G��</option>
	<!--
	<option value=3>�T��</option>
	<option value=4>�|��</option>
	<option value=5>����</option>
	<option value=6>����</option>
	<option value=7>�C��</option>
	<option value=8>�K��</option>
	<option value=9>�E��</option>
	<option value=10>�Q��</option>
	-->
	</select>�X���k�C<br>
	�һݪ��B: <span id=cost style='color: DodgerBlue;'>".intval(2*$TFDCostCons)."</span><br>
	<input type=submit value=�ʶR OnClick=\"return ChkBuy()\">
	</td></tr></form>";
	echo "<tr><td><form action=tactfactory.php?action=main method=post name=freect target=$SecTarget>";
	echo "<input type=hidden value='none' name=actionb>";
	echo "<input type=hidden value='none' name=actionc>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";
	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
	echo "<p align=left style=\"font-size: 16pt\">$CastResult<br><input type=submit value=\"��^\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"><input type=button value=\"�~��\" onClick=\"freect.submit()\"></p>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form></tr></td>";
	echo "</table>";
}
elseif ($mode == 'guild' && $actionb == 'buy' && $actionc=='none'){
	$grade = intval($grade);
	if ($grade < 0 || $grade > 10){echo "�ŧO�X��!!<br>";PostFooter();exit;}
	$TrueCost = intval(pow(2,$grade) * $TFDCostCons);
	if ( $TrueCost > $Gen['cash']){echo "��������!!<br>";PostFooter();exit;}
	else {$Gen['cash'] -= $TrueCost;}

	if (!$UsrWepB[0]){$TargetGrant = 'wepb';}
	elseif (!$UsrWepC[0]){$TargetGrant = 'wepc';}
	else{echo "�S�Ŧ��m�X���]�p�Ź�, �Х��ťX�ƥΤ@�ΤG�A�աC";postFooter();exit;}

	unset($sql);
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `cash` = '$Gen[cash]' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
	mysql_query($sql);
	
	unset($sql,$query,$counter,$TheTString,$TheBpString);

	$sql = ("SELECT `directions`,
	`m1` ,`m2` ,`m3` ,`m4` ,`m5` ,`m6` ,`m7` ,`m8` ,`m9` ,`m10` ,
	`m11` , `m12` ,`m13` ,`m14` ,`m15` ,`m16` ,`m17` ,`m18` ,`m19` ,`m20` ,
	`raw_materials`, `blueprint` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` WHERE `grade` = '$grade'");
	$query = mysql_query($sql);
	
	$TactEntries = array();
	
	$i = 0;
	while($TactEntries[$i] = mysql_fetch_array($query)){
		$i++;
	}
	$RandSelect = mt_rand(0, ($i - 1));
	$Result = $TactEntries[$RandSelect];

	echo "<table><tr><td><font color=orange>���</font></td></tr>";
	echo "<tr><td>". str_replace('\"','"',$Result['directions']) ."</td></tr>";
	echo "<tr><td style='text-align: center;' align=center>";
	printBPTable($Result, $product_id_list);
	echo "</td></tr><tr><td><font color=orange>�ЧA�O�C�U�o�ǹ��</font></td></tr>";
	echo "</table>";
	
	unset($sql);
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `$TargetGrant` = '". $Result['blueprint'] ."<!>0' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
	mysql_query($sql);
	unset($sql);

}
elseif($mode == 'custom'){
$IncThread = "tcust_200509241855";
include('tact_custom.php');
}
else {echo "���w�q�ʧ@�I";}
postFooter();
echo "</body>";
echo "</html>";
exit;
?>