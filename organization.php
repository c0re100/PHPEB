<?php
$mode = ( isset($_GET['action']) ) ? $_GET['action'] : $_POST['action'];
include('cfu.php');
if (empty($PriTarget)) $PriTarget = 'Alpha';
if (empty($SecTarget)) $SecTarget = 'Beta';
if (!isset($Game_Scrn_Type)) $Game_Scrn_Type = 1;
postHead('');
AuthUser();
$now=time();
if ($CFU_Time >= $_SESSION['timeauth']+$TIME_OUT_TIME || $_SESSION['timeauth'] <= $CFU_Time-$TIME_OUT_TIME){echo "連線逾時！<br>請重新登入！";exit;}
GetUsrDetails("$_SESSION[username]",'Gen','Game');
if ($Game['organization'])
$Pl_Org = ReturnOrg("$Game[organization]");
else $Pl_Org = false;
//Special Commands GUI
if ($mode=='Start'){
	echo "<font style=\"font-size: 12pt\">成立組織</font>";
	printTHR();
	if ($actionb == 'A'){
	if ($Gen['cash'] < $OrganizingCost && !$Game['organization']){echo "條件不符";postFooter;exit;}
	if ($CFU_Time - $Game['lastorg'] < 86400){echo "24小時內只能成立國家一次。";postFooter();exit;}
	
	echo "<form action=organization.php?action=Start method=post name=mainform>";
	echo "<input type=hidden value='B' name=actionb>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

	echo "<script language=\"Javascript\">";
	echo "function cfmStartOrg(){";
	echo "if ($OrganizingCost > $Gen[cash]){alert('金錢不足。');return false;}";
	echo "else if (mainform.org_pose.value == '' || mainform.org_pose.value.trim().length == 0){alert('請先輸入組織宣言。');return false;}";
	echo "else if (mainform.org_name.value == '' || mainform.org_name.value.trim().length == 0){alert('請先輸入組織名稱。');return false;}";
	echo "else {if (confirm('成立組織需要 ". number_format($OrganizingCost) ." 元及100勝利積分，確定嗎？')==true){return true;}";
	echo "else {return false;}}";
	echo "}</script>";

	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">成立組織所需資料: </b></td></tr>";
	echo "<tr><td align=left>成立組織需要: ". number_format($OrganizingCost) ." 元及100勝利積分<br>";
	echo "組織名稱: <input type=text name=org_name maxlength=32 size=27><br>(注意不能與現有組織名稱一樣)<br>";
	echo "組織宗旨: <input type=text name=org_pose maxlength=90 size=27><br>(注意：30個字內)<br>";
	echo "代表顏色: <br><center>";
	$br=$ct_default=0;
	foreach ($MainColors as $TheColor){$br++;$ct_default++;
	echo "<input type=\"radio\" name=\"org_color\" value=#".$TheColor;
	if ($ct_default==1) echo " checked";
	echo "><font color=#".$TheColor.">◆</font> &nbsp;&nbsp; ";
	if ($br==6){echo"<br>";$br=0;}	}
	echo "<input type=submit value=\"確定成立組織\" onClick=\"return cfmStartOrg();\">";
	echo "</tr></td></form></table>";
	}

	if ($actionb == 'B'){
		$org_name = mysql_real_escape_string($org_name);
		$org_color = mysql_real_escape_string($org_color);
		$org_pose = mysql_real_escape_string($org_pose);
		if (!$org_name){echo "請先輸入組織名稱！";postFooter();exit;}
		if (!$org_pose){echo "請先輸入組織宣言！";postFooter();exit;}
		if ($Game['v_points'] < 100){echo "您沒有足夠勝利積分！";postFooter();exit;}
		if ($org_name == "中立組織"){echo "您以為您真的是中立嗎？";postFooter();exit;}
        if ($OrganizingCost > $Gen['cash']){echo "金錢不足。";postFooter();exit;}
        if ($Gen['fame'] < $OrganizingFame && $Gen['fame'] > $OrganizingNotor){echo "名聲不足。";postFooter();exit;}
		
		$points = ("UPDATE ".$GLOBALS['DBPrefix']."phpeb_user_game_info SET v_points = v_points-100 WHERE `username` = '".$_SESSION['username']."'");
		$minpts = mysql_query($points);

	$Gen['cash'] -= $OrganizingCost;
	$Gen['fame'] += 1;
	if( $Game['rank'] < 48000 ) $Game['rank'] = 48000;

	$HistoryWrite = "<font color=\"$Gen[color]\">$Game[gamename]</font> 創立 <font color=\"$org_color\">$org_name</font> 組織，並歡迎所有人自由加入及退出。<br>組織宗旨: <font color=\"$org_color\">$org_pose</font>";
	WriteHistory($HistoryWrite);
	//Enter Organization Info
	$sql = ("INSERT INTO ".$GLOBALS['DBPrefix']."phpeb_user_organization (id, name, color, pose) VALUES('$CFU_Time','$org_name','$org_color','$org_pose')");
	mysql_query($sql) or die ('<br><center>未能完成註冊<br>原因:' . mysql_error() . '<br>');

	$restriction = array("|","`","'","--","\"","\\");
	$org_name = str_replace($restriction,'',$org_name);
	$org_name = preg_replace('/<[^<>]*>/','',$org_name);

	$sql = ("SELECT id FROM `".$GLOBALS['DBPrefix']."phpeb_user_organization` WHERE name='". $org_name ."'");
	$query = mysql_query($sql) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');
	$New_Org = mysql_fetch_row($query);

	//更新 Game Info
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `rank` = '".($Game['rank'])."', `rights` = '1', `organization` = '$New_Org[0]' WHERE `username` = '".$_SESSION['username']."' LIMIT 1");
	$query = mysql_query($sql) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');

	//更新 General Info
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `cash` = '$Gen[cash]', `fame` = '$Gen[fame]' WHERE `username` = '".$_SESSION['username']."' LIMIT 1");
	$query = mysql_query($sql) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');

	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
	echo "<p align=center style=\"font-size: 16pt\">成立組織完成了！<br>閣下的名聲上升1點。<input type=submit value=\"返回\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
	
	
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";
	}
}
elseif($mode == 'Employ'){
	if ($CFU_Time - $Game['lastorg'] < 43200){echo "12小時內只能加入組織一次。";postFooter();exit;}
	
	if ($actionb == 'C'){
		$CancelFlag = '';
		if (!$Employer){echo "你被誰邀請呀？";postFooter();exit;}
		elseif ($Game['rights']=='1'){echo "總帥不能被邀請。";postFooter();exit;}
		else {$Og_Org=$Pl_Org;$Pl_Org = ReturnOrg($Employer);}if (!$Og_Org){$Og_Org =  ReturnOrg('0');}
	
		if(strpos($Pl_Org['request_list'],'!'.$_SESSION['username'].',') === false){$EmployMsg = "該組織沒有邀請您。";$CancelFlag = '1';}
		else{
			$str = "/(!$_SESSION[username], )+/";
			$Pl_Org['request_list'] = preg_replace($str,'',$Pl_Org['request_list']);
		}
	
		//更新 Org Info
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `request_list` = '$Pl_Org[request_list]' WHERE `id` = '".$Pl_Org['id']."' LIMIT 1");
		$query = mysql_query($sql) or die ('無法取得組織資訊, 原因:' . mysql_error() . '<br>');
	
		//更新 General Info
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `request` = '' WHERE `username` = '".$_SESSION['username']."' LIMIT 1");
		$query = mysql_query($sql) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');
	
		if ($actionc == 'Accept' && !$CancelFlag){
			if($Game['organization'] == 0)	$Game['rank'] += 2000;
			if($Game['rank'] > 100000)	$Game['rank'] = 100000;
			//更新 Game Info
			$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `rank` = ".($Game['rank']).", `rights` = '0', `organization` = '$Pl_Org[id]' WHERE `username` = '".$_SESSION['username']."' LIMIT 1");
			$query = mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');
			$EmployMsg = "成功加入組織！";
			$HistoryWrite = "<font color=\"$Og_Org[color]\">$Og_Org[name]</font> 的 <font color=\"$Gen[color]\">$Game[gamename]</font> 受邀請加入 <font color=\"$Pl_Org[color]\">$Pl_Org[name]</font>。";
			WriteHistory($HistoryWrite);
		}
	
		elseif ($actionc == 'Refuse' && !$CancelFlag){
			$EmployMsg = "成功拒絕加入組織。";
			$HistoryWrite = "<font color=\"$Og_Org[color]\">$Og_Org[name]</font> 的 <font color=\"$Gen[color]\">$Game[gamename]</font> 拒絕了加入 <font color=\"$Pl_Org[color]\">$Pl_Org[name]</font>的邀請。";
			WriteHistory($HistoryWrite);
		}
	
		echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn>";
		echo "<p align=center style=\"font-size: 16pt\"><br><br><br>$EmployMsg<input type=submit value=\"返回\" ";
		if($Game_Scrn_Type == 1)
		echo "onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"";
		echo "></p>";
		
		
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

echo "<font style=\"font-size: 12pt\">招募人才</font>";
printTHR();

if ($actionb == 'A'){
echo "<form action=organization.php?action=Employ method=post name=mainform>";
        echo "<input type=hidden value='B' name=actionb>";
        echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

        echo "<script language=\"Javascript\">";
        echo "function cfmEmploy(){";
        echo "if (mainform.EmployTar.value == ''){alert('請先輸入要招攬的人。');return false;}";
        echo "else {if (confirm('邀請目標加入組織，確定嗎？')==true){return true;}";
        echo "else {return false;}}";
        echo "}</script>";

        echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
        echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">招募人才: </b></td></tr>";

        unset($sql,$query,$AvailPersons);
        $sql = ("SELECT `username`,`gamename`,`organization` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `username` != '".$_SESSION['username']."' AND `organization` != '$Game[organization]' AND !`rights` OR !`organization` ORDER BY `organization` ASC");
        $query = mysql_query($sql) or die(mysql_error());
        $AvailPersons = mysql_fetch_array($query);
        do{
        $TarOrg = ReturnOrg($AvailPersons['organization']);
        $EmployOpt .= "<option value='$AvailPersons[username]'>$AvailPersons[gamename] ($TarOrg[name])";
        unset($AvailPersons,$TarOrg);
        }
        while ($AvailPersons = mysql_fetch_array($query));

        if ($EmployOpt)
        echo "<tr><td align=left>向 <input type=text name=EmployTar value=請輸入玩家名稱><br><input type=submit value=\"邀請\" onClick=\"return cfmEmploy();\"> 發出邀請信。</td></tr>";

        if(!ereg('(\!'.$_SESSION['username'].'\, )+',$Pl_Org['request_list'])){$EmployMsg = "該組織沒有邀請您。";$CancelFlag = '1';}
        else{$Pl_Org['request_list'] = ereg_replace('(\!'.$_SESSION['username'].'\, )+','',$Pl_Org['request_list']);}

        if ($Pl_Org['request_list']){
        echo "<tr><td align=left>未得到回覆的邀請信: <br>";

        $Pl_Org['request_list'] = ereg_replace('!| ','',$Pl_Org['request_list']);
        $List_of_Letters = explode(',',$Pl_Org['request_list']);
        unset($TargetName,$TarInfo);
        foreach($List_of_Letters as $TargetName){
        if ($TargetName){
        $sqle = ("SELECT `".$GLOBALS['DBPrefix']."phpeb_user_game_info`.`gamename`, `".$GLOBALS['DBPrefix']."phpeb_user_organization`.`name`, `".$GLOBALS['DBPrefix']."phpeb_user_organization`.`color` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info`, `".$GLOBALS['DBPrefix']."phpeb_user_organization` WHERE `".$GLOBALS['DBPrefix']."phpeb_user_game_info`.`username`='". $TargetName ."' AND `".$GLOBALS['DBPrefix']."phpeb_user_game_info`.`organization` = `".$GLOBALS['DBPrefix']."phpeb_user_organization`.`id`");
        $querye = mysql_query($sqle) or die ('無法取得資訊, 原因:' . mysql_error() . '<br>');
        $TarInfo = mysql_fetch_array($querye);
        echo "<font color=\"$TarInfo[color]\">$TarInfo[name] 的 $TarInfo[gamename]</font><br>";}
        }
        echo "</td></tr>";
        }
        echo "</form></table>";
	}

//
// End of Action A
//

	if ($actionb == 'B'){
		$EmployTar = mysql_real_escape_string($EmployTar);
		$getun = ("SELECT `username` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `gamename` = '".$EmployTar."' AND rights='0'");
		$getfull = mysql_query($getun);
		$tarname = mysql_fetch_row($getfull);

        if (!$EmployTar || $EmployTar == $_SESSION['username']){echo "你要招攬誰呀？";postFooter;exit;}
	
		$Pl_Org = ReturnOrg($Game['organization']);
	
		$Pl_Org['request_list'] .= '!'.$tarname[0].', ';
	
		//更新 Org Info
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `request_list` = '$Pl_Org[request_list]' WHERE `id` = '".$Game['organization']."' LIMIT 1");
		$query = mysql_query($sql) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');
	
		$requesttx = "$Pl_Org[name] 的 $Game[gamename] 向您發出加入組織的邀請信。<br>你要加入組織嗎？<br>";
		$requesttx .= "<input type=hidden name=Employer value=\'$Pl_Org[id]\'>";
	
		//更新 General Info
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `request` = '$requesttx' WHERE `username` = '".$tarname[0]."' LIMIT 1");
		$query = mysql_query($sql) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');
	
		echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
		echo "<p align=center style=\"font-size: 16pt\">組織邀請信已發出。<input type=submit value=\"返回\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
		
		
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
		echo "</form>";
	}

//
// End of Action B
//
}//End of Employ
elseif ($mode == 'LeaveOrg'){
	if (!$Game['organization'] || $Game['rights']){echo "以您的身份不能脫離組織。";postFooter();exit;}
	if ($actionb != 'A' && $actionb != 'B' && $actionb != 'C') {echo "未定義動作！<br>";exit;}
	if ($actionb == 'A'){
		if ($Pl_Org['license'] == 1 || $Pl_Org['license'] == 3)
			{echo "您的組織不容許你私自脫離，若真的想離開就請您逃亡吧。";postFooter();exit;}
		$Game['rank'] -= 4000;
	}
	else {
		if ($Pl_Org['license'] != 1 && $Pl_Org['license'] != 3)
			{echo "您無需逃亡。";postFooter();exit;}
		if ($actionb == 'C') $Gen['fame'] -= 10;
		$Gen['fame'] = floor($Gen['fame']*0.9);
		$Game['rank'] -= 12000;
	}
	if( $Game['rank'] < 0 ) $Game['rank'] = 0;
	//更新 Gen Info
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `fame` = '$Gen[fame]' WHERE `username` = '".$_SESSION['username']."' LIMIT 1");
	$query = mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');

	if (abs($Gen['fame']) >= 100){
	$HistoryWrite = "<font color=\"$Gen[color]\">$Game[gamename]</font> 脫離 <font color=\"$Pl_Org[color]\">$Pl_Org[name]</font>。";
	WriteHistory($HistoryWrite);}

	//更新 Game Info
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `rank` = '".($Game['rank'])."', `rights` = '0', `organization` = '0', `lastorg` = '$now' WHERE `username` = '".$_SESSION['username']."' LIMIT 1");
	$query = mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');

	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
	echo "<p align=center style=\"font-size: 16pt\">已脫離組織。<input type=submit value=\"返回\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
	
	
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";
	}
//End of LeaveOrg
elseif ($mode == 'LeavePlace'){
	echo "<font style=\"font-size: 12pt\">退位</font>";
	printTHR();
	if (!$Game['organization'] || !$Game['rights']){echo "以您的身份不能退位。";postFooter();exit;}

	if ($Game['rights'] == '1'){$RightsTitle = $RightsClass['Major'];$AllowWho = "`rights` != '1'";}
	elseif ($Game['rights']){$RightsTitle = $RightsClass['Leader'];$AllowWho = "!`rights`";}

	if ($actionb == 'A'){
	echo "<form action=organization.php?action=LeavePlace method=post name=mainform>";
	echo "<input type=hidden value='B' name=actionb>";
	
	
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

	echo "<script language=\"Javascript\">";
	echo "function cfmLeavePlace(){";
	echo "if (mainform.GiveTar.value == ''){alert('請先輸入要讓給的人。');return false;}";
	echo "else {if (confirm('退位給目標人物，確定嗎？')==true){return true;}";
	echo "else {return false;}}";
	echo "}</script>";

	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">退位讓賢: </b></td></tr>";

	unset($sql,$query,$AvailPersons);
	$sql = ("SELECT `username`,`gamename` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `username` != '".$_SESSION['username']."'  AND `organization` = '$Game[organization]' AND $AllowWho AND `rank` > 72000 ORDER BY `rank` DESC");
	$query = mysql_query($sql) or die(mysql_error());
	$GiveTarOpt = '';
	while ($AvailPersons = mysql_fetch_array($query))
		$GiveTarOpt .= "<option value='$AvailPersons[username]'>$AvailPersons[gamename]";
	unset($AvailPersons);

	echo "<tr><td align=left>您的權力: $RightsTitle <br>";

	if ($GiveTarOpt)
		echo "可退位給的人:<select name=GiveTar>$GiveTarOpt</select><br><input type=submit value=\"退位\" onClick=\"return cfmLeavePlace();\">";
	else 	echo "沒有適合的人選。<br>接位的人必須有一定的軍階。";
	echo "</td></tr></form></table>";
	}// Action A End

	elseif ($actionb == 'B'){
	$GiveTar= mysql_real_escape_string($GiveTar);
	if (!$GiveTar){echo "請先指定目標。";postFooter();exit;}

	$sqlgame = ("SELECT `gamename`,`color` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info`,`".$GLOBALS['DBPrefix']."phpeb_user_general_info` WHERE `".$GLOBALS['DBPrefix']."phpeb_user_game_info`.`username`='". $GiveTar ."'");
	$query_game = mysql_query($sqlgame) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');
	$GiveTarOpt = mysql_fetch_array($query_game);

	$HistoryWrite = "<font color=\"$Pl_Org[color]\">$Pl_Org[name]</font> 的 <font color=\"$Gen[color]\">$Game[gamename]</font> 把 $RightsTitle 之權力讓給 <font color=\"$GiveTarOpt[color]\">$GiveTarOpt[gamename]</font> 。";
	WriteHistory($HistoryWrite);

	//更新 Game Info
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `rights` = '".$Game['rights']."', `organization` = '$Game[organization]' WHERE `username` = '".$GiveTar."' LIMIT 1");
	$query = mysql_query($sql) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');

	//更新 Game Info
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `rights` = '0', `organization` = '$Game[organization]' WHERE `username` = '".$_SESSION['username']."' LIMIT 1");
	$query = mysql_query($sql) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');

	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
	echo "<p align=center style=\"font-size: 16pt\">退位完成了！<input type=submit value=\"返回\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
	
	
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";

	}// Action B End


	else {echo "未定義動作！";}
}//End of LeavePlace
elseif ($mode == 'Vice'){

	if ($Game['rights'] != '1'){echo "你沒有權力任命。";postFooter();exit;}
	if ($Game['rights'] == '1'){$RightsTitle = $RightsClass['Major'];}
	elseif ($Game['rights']){$RightsTitle = $RightsClass['Leader'];}

	if ($actionb == 'A'){
		echo "<form action=organization.php?action=Vice method=post name=mainform>";
		echo "<input type=hidden value='B' name=actionb>";
		
		
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	
		echo "<script language=\"Javascript\">";
		echo "function cfmVice(){";
		echo "if (mainform.GiveTar.value == ''){alert('請先輸入要任命為副主席的人。');return false;}";
		echo "else {if (confirm('任命目標人物，確定嗎？')==true){return true;}";
		echo "else {return false;}}";
		echo "}</script>";
	
		echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
		echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">任命: </b></td></tr>";
	
		unset($sql,$query,$AvailPersons);
		$sql = ("SELECT `username`,`gamename` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `username` != '".$_SESSION['username']."'  AND `organization` = '$Game[organization]' ORDER BY `rank` DESC");
		$query = mysql_query($sql) or die(mysql_error());
		$GiveTarOpt = '';
		while ($AvailPersons = mysql_fetch_array($query))
			$GiveTarOpt .= "<option value='$AvailPersons[username]'>$AvailPersons[gamename]";
		unset($AvailPersons);
		echo "<tr><td align=left>您的權力: $RightsTitle <br>";
	
		if ($GiveTarOpt)
			echo "任命為副主席的人:<select name=GiveTar>$GiveTarOpt</select><br><input type=submit value=\"任命\" onClick=\"return cfmVice();\">";
		else 	echo "沒有可以被任命的人, 副主席必須有一定的功績、軍階。";
		echo "</td></tr></form></table>";
		echo "<br>";
		echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\"  style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\" width=\"600px\">";
		echo "<tr align=center><td colspan=16><b>成員列表: </b></td></tr>";
		echo "<tr align=center>";
        echo "<td width=\"100\">玩家名稱</td>";
		echo "<td width=\"40\">等級</td>";
		echo "<td width=\"40\">職位</td>";
		echo "<td width=\"140\">最後上線時間</td>";
		echo "</tr>";
		
		$list = ("SELECT a.gamename AS gamename, a.level AS level,a.rights AS rights, b.lastlogin AS time FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` a INNER JOIN `".$GLOBALS['DBPrefix']."phpeb_user_general_info` b ON a.username = b.username WHERE a.organization = '$Game[organization]' AND a.rights!=1 ORDER BY a.level DESC");
		$qlist = mysql_query($list);
		
		while ($userlevel = mysql_fetch_array($qlist)){
			echo "<tr align=center>";
			echo "<td width=\"100\">$userlevel[gamename]</td>";
			echo "<td width=\"40\">$userlevel[level]</td>";
			if($userlevel['rights']==0){
				echo "<td width=\"40\">普通成員</td>";
			}
			if($userlevel['rights']==2){
				echo "<td width=\"40\">副主席</td>";
			}
			$realtime = cfu_time_convert($userlevel['time']);
			echo "<td width=\"140\">$realtime</td>";
			echo "</tr>";
		}
		
		echo "</form></table>";
		
	}// Action A End

	elseif ($actionb == 'B'){

	if (!$GiveTar){echo "請先指定目標。";postFooter();exit;}

	$sqlgame = ("SELECT gen.username AS name, `color`, `gamename`, `rights` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` `game`, `".$GLOBALS['DBPrefix']."phpeb_user_general_info` `gen` WHERE gen.username = game.username AND organization = $Game[organization] AND (gen.username = '". $GiveTar ."' OR `rights` = 2) LIMIT 2;");
	$qgame = mysql_query($sqlgame) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');
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
		$HistoryWrite = "<font color=\"$Pl_Org[color]\">$Pl_Org[name]</font> 的 <font color=\"$Gen[color]\">$Game[gamename]</font> 宣佈, <font color=\"$TarQ[color]\">$TarQ[gamename]</font> 將接任 <font color=\"$TarXQ[color]\">$TarXQ[gamename]</font> 為 ".$RightsClass['Leader']." 了。";
		//更新 Game Info
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `rights` = '2' WHERE `username` = '".$TarQ['name']."' LIMIT 1");
		$query = mysql_query($sql);
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `rights` = '0' WHERE `username` = '".$TarXQ['name']."' LIMIT 1");
		$query = mysql_query($sql);
	}
	else {
		$TarQ = mysql_fetch_array($qgame);
		$TarXQ = false;
		$HistoryWrite = "<font color=\"$Pl_Org[color]\">$Pl_Org[name]</font> 的 <font color=\"$Gen[color]\">$Game[gamename]</font> 把組織內的 <font color=\"$TarQ[color]\">$TarQ[gamename]</font> 任命為 ".$RightsClass['Leader']." 了。";
		//更新 Game Info
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `rights` = '2' WHERE `username` = '".$GiveTar."' LIMIT 1");
		$query = mysql_query($sql) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');
	}

	WriteHistory($HistoryWrite);

	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
	echo "<p align=center style=\"font-size: 16pt\">任命完成了！<input type=submit value=\"返回\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
	
	
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";

	}// Action B End


	else {echo "未定義動作！";}
}//End of Vice Presidency
elseif ($mode == 'Break'){
if ($actionb = 'A'){
	if (!$Game['organization'] && $Game['rights'] != '1'){echo "以您的身份不能解散組織。";postFooter();exit;}

	$sql = ("SELECT count(username) FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `organization` = '".$Game['organization']."'");
	$query = mysql_query($sql);
	$result = mysql_fetch_row($query);
	if($result[0] > 1) {echo "請先解僱所有成員。";postFooter();exit;}

	$HistoryWrite = "<font color=\"$Gen[color]\">$Game[gamename]</font> 把 <font color=\"$Pl_Org[color]\">$Pl_Org[name]</font> 解散了。";
	WriteHistory($HistoryWrite);
	
	$Game['rank'] -= 48000;
	if($Game['rank'] < 0) $Game['rank'] = 0;

	//更新 Game Info
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `rank` = '".($Game['rank'])."', `rights` = '0', `organization` = '0', `lastorg` = '$now' WHERE `username` = '".$_SESSION['username']."'");
	$query = mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');
	//更新 Map Info
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_map` SET `occupied` = '0' WHERE `occupied` = '".$Game['organization']."'");
	$query = mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');
	//消除 Org Info
	$sql = ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_organization` WHERE id='". $Game['organization'] ."' LIMIT 1");
	$query = mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');

	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
	echo "<p align=center style=\"font-size: 16pt\">組織已被解散。<input type=submit value=\"返回\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
	
	
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";
	}// Action A End
}// End of Break Organization

elseif ($mode == 'Dismiss'){
	echo "<font style=\"font-size: 12pt\">解僱</font>";
	printTHR();
	if (!$Game['organization'] || !$Game['rights']){echo "以您的身份不能解僱其他人。";postFooter();exit;}

	if ($Game['rights'] == '1'){$RightsTitle = $RightsClass['Major'];$AllowWho = "`rights` != '1'";}
	elseif ($Game['rights']){$RightsTitle = $RightsClass['Leader'];$AllowWho = "!`rights`";}

	if ($actionb == 'A'){
	echo "<form action=organization.php?action=Dismiss method=post name=userlist>";
	echo "<input type=hidden name=\"kick\" value=''>";
	echo "<input type=hidden value='B' name=actionb>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

	/*echo "<script language=\"Javascript\">";
	echo "function cfmDismiss(){";
	echo "if (mainform.GiveTar.value == ''){alert('請先輸入要解僱的人。');return false;}";
	echo "else {if (confirm('解僱目標人物，確定嗎？')==true){return true;}";
	echo "else {return false;}}";
	echo "}</script>";*/
	
	echo "<script language=\"Javascript\">";
	echo "function kickuser(name){";
	echo "        userlist.action='organization.php?action=Dismiss';";
	echo "        userlist.kick.value=name;";
	echo "		  userlist.submit();";
	echo "        }</script>";
		
	/*echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">解僱成員: </b></td></tr>";

	unset($sql,$query,$AvailPersons);
	$sql = ("SELECT `username`,`gamename` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `username` != '".$_SESSION['username']."'  AND `organization` = '$Game[organization]' AND $AllowWho ORDER BY `rank` DESC");
	$query = mysql_query($sql) or die(mysql_error());
	$GiveTarOpt = '';
	while ($AvailPersons = mysql_fetch_array($query))
		$GiveTarOpt .= "<option value='$AvailPersons[username]'>$AvailPersons[gamename]";
	unset($AvailPersons);
	echo "<tr><td align=left>您的權力: $RightsTitle <br>";

	if ($GiveTarOpt)
		echo "可解僱的人:<select name=GiveTar>$GiveTarOpt</select><br><input type=submit value=\"解僱\" onClick=\"return cfmDismiss();\">";
	else 	echo "沒有可以被解僱的人。";
	echo "</td></tr></form></table>";*/
	
		echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\"  style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\" width=\"600px\">";
		echo "<tr align=center><td colspan=16><b>成員列表: </b></td></tr>";
		echo "<tr align=center>";
        echo "<td width=\"100\">名稱</td>";
		echo "<td width=\"40\">等級</td>";
		echo "<td width=\"140\">最後上線時間</td>";
		echo "<td width=\"40\">操作</td>";
		echo "</tr>";
		
		$list = ("SELECT a.gamename AS gamename, a.level AS level, b.lastlogin AS time FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` a INNER JOIN `".$GLOBALS['DBPrefix']."phpeb_user_general_info` b ON a.username = b.username WHERE a.organization = '$Game[organization]' AND a.rights!=1 ORDER BY a.level DESC");
		$qlist = mysql_query($list);
		
		while ($userlist = mysql_fetch_array($qlist)){
			echo "<tr align=center>";
			echo "<td width=\"100\">$userlist[gamename]</td>";
			echo "<td width=\"40\">$userlist[level]</td>";
			$realtime = cfu_time_convert($userlist['time']);
			echo "<td width=\"140\">$realtime</td>";
			echo "<td width=\"40\"><input type=\"submit\" value=\"解僱\" onclick=\"kickuser('$userlist[gamename]');\"></td>";
			echo "</tr>";
		}
		
		echo "</form></table>";
	}// Action A End

	elseif ($actionb == 'B'){
		
		$kick = mysql_real_escape_string($kick);
		if (!$kick){echo "請先指定目標！";postFooter;exit;}
		/*if (!$GiveTar){echo "請先指定目標。";postFooter();exit;}*/
	
		$sqlgame = ("SELECT `gamename` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE gamename='". $kick ."'");
		$qgame = mysql_query($sqlgame);
		$TarQ = mysql_fetch_array($qgame);
	
		$HistoryWrite = "<font color=\"$Pl_Org[color]\">$Pl_Org[name]</font> 的 <font color=\"$Gen[color]\">$Game[gamename]</font> 把組織內的 <font color=\"$TarQ[color]\">$TarQ[gamename]</font> 解僱了。";
		WriteHistory($HistoryWrite);
	
		$Game['rank'] -= 2000;
		if($Game['rank'] < 0) $Game['rank'] = 0;
	
		//更新 Game Info
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `rank` = '".($Game['rank'])."', `rights` = '0', `organization` = '0' WHERE `gamename` = '".$kick."' LIMIT 1");
		$query = mysql_query($sql);
		$sql2 = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `cnum` = cnum-'1' WHERE `id` = '$Game[organization]' LIMIT 1");
		$query = mysql_query($sql2);
	
		echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
		echo "<p align=center style=\"font-size: 16pt\">解僱完成了！<input type=submit value=\"返回\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
		
		
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
		echo "</form>";

	}// Action B End


	else {echo "未定義動作！";}
}//End of Dismiss
elseif ($mode == 'JoinOrg'){
	echo "<font style=\"font-size: 12pt\">加入組織</font>";
	printTHR();
	if ($CFU_Time - $Game['lastorg'] < 43200){echo "12小時內只能加入組織一次。";postFooter();exit;}
	if ($Game['organization']){echo "你已有所屬的組織了。";postFooter();exit;}

	if ($actionb == 'A'){
		echo "<form action=organization.php?action=JoinOrg method=post name=joinlist>";
		echo "<input type=hidden value='B' name=actionb>";
		echo "<input type=hidden name=\"join\" value=''>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	
		/*echo "<script language=\"Javascript\">";
		echo "function cfmJoinOrg(){";
		echo "if (mainform.GiveTar.value == ''){alert('請先輸入要加入的組織。');return false;}";
		echo "else {if (confirm('加入目標組織，確定嗎？')==true){return true;}";
		echo "else {return false;}}";
		echo "}</script>";
	
		echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
		echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">加入組織接受新會員的組織: </b></td></tr>";
	
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
		echo "<tr><td align=left>可加入的組織:<select name=GiveTar>$GiveTarOpt</select><br><input type=submit value=\"加入\" onClick=\"return cfmJoinOrg();\"></td></tr>";
		else echo "<tr><td align=left>沒有可以被加入的組織。</td></tr>";
		echo "</form></table>";
	}// Action A End*/
		echo "<script language=\"Javascript\">";
		echo "function joinog(org){";
		echo "        joinlist.action='organization.php?action=JoinOrg';";
		echo "        joinlist.join.value=org;";
		echo "		  joinlist.submit();";
		echo "        }</script>";
		
		echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\"  style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\" width=\"600px\">";
		echo "<tr align=center><td colspan=16><b>組織列表: </b></td></tr>";
		echo "<tr align=center>";
        echo "<td width=\"100\">組織名稱</td>";
		echo "<td width=\"100\">統治者</td>";
		echo "<td width=\"140\">組織宗旨</td>";
		echo "<td width=\"40\">人數</td>";
		echo "<td width=\"40\">操作</td>";
		echo "</tr>";

		$sql = ("SELECT a.id AS id, a.name AS name, a.cnum AS num, a.pose AS pose, a.license AS license, b.gamename AS gamename FROM `".$GLOBALS['DBPrefix']."phpeb_user_organization` a INNER JOIN `".$GLOBALS['DBPrefix']."phpeb_user_game_info` b ON a.id=b.organization WHERE a.id != '0' AND b.rights=1 ORDER BY a.id DESC");
        $query = mysql_query($sql);
       
		while($joinlist = mysql_fetch_array($query)){
			echo "<tr align=center>";
			echo "<td width=\"100\">$joinlist[name]</td>";
			echo "<td width=\"100\">$joinlist[gamename]</td>";
			echo "<td width=\"140\" style=\"word-break:break-all\">$joinlist[pose]</td>";
			echo "<td width=\"40\">$joinlist[num] / 15</td>";
			if($joinlist['license'] >= 2){
			echo "<td width=\"40\"><input type=\"submit\" value=\"無法加入\" disabled></td>";}
			elseif($joinlist['license'] < 2){
			echo "<td width=\"40\"><input type=\"submit\" value=\"加入\" onclick=\"joinog('$joinlist[id]');\"></td>";}
		}
		echo "</form></table>";		
}
	elseif ($actionb == 'B'){

		$join = mysql_real_escape_string($join);
        if (!$join){echo "請先指定要加入的組織。";postFooter;exit;}
		/*if (!$GiveTar){echo "請先指定要加入的組織。";postFooter();exit;}*/
		
		$ppl = ("SELECT count(*) FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `organization` = '".$join."'");
		$qppl = mysql_query($ppl) or die('加入組織錯誤！');
		$lastp = mysql_fetch_row($qppl);
		
		if ($lastp[0] >= 15){echo "該組織人數過多，暫時無法加入。<br>請加入其他組織或自行成立組織。";postFooter;exit;}
		
		$Og_Org = ReturnOrg($Game['organization']);
		$Pl_Org = ReturnOrg($join);
		if($Pl_Org['license'] >= 2){echo "目標組織不接受新會員。";postFooter();exit;}

		if (abs($Gen['fame']) >= 100){
			$HistoryWrite = "<font color=\"$Og_Org[color]\">$Og_Org[name]</font> 的 <font color=\"$Gen[color]\">$Game[gamename]</font> 加入 <font color=\"$Pl_Org[color]\">$Pl_Org[name]</font>。";
			WriteHistory($HistoryWrite);
		}

		$Game['rank'] += 2000;
		if($Game['rank'] > 100000) $Game['rank'] = 100000;

		//更新 Game Info
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `rank` = '".($Game['rank'])."', `rights` = '0', `organization` = '".$join."', `lastorg` = '$now' WHERE `username` = '".$_SESSION['username']."' LIMIT 1");
		$query = mysql_query($sql) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');

		$sql2 = ("SELECT count(*) FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `organization` = '".$join."'");
		$query2 = mysql_query($sql2);
		$cquery = mysql_result($query2, 0);
		$sql3 = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `cnum` = '$cquery' WHERE `id` = '".$join."'");
		$query2 = mysql_query($sql3);
		
		echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
		echo "<p align=center style=\"font-size: 16pt\">加入組織完成了！<input type=submit value=\"返回\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
		
		
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
		echo "</form>";

	}// Action B End


	else {echo "未定義動作！";}
}//End of JoinOrg
elseif ($mode == 'Settings'){
	echo "<font style=\"font-size: 12pt\">組織設定</font>";
	printTHR();
	if (!$Game['organization'] || $Game['rights'] != '1'){echo "你的權力不足。";postFooter();exit;}

	if ($actionb == 'A'){
	echo "<form action=organization.php?action=ModOrg method=post name=mainform>";
	echo "<input type=hidden value='' name=actionb>";
	
	
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

	echo "<script language=\"Javascript\">";
	echo "function cfmModOrgLi(){";
	echo "if (confirm('修改組織自由度, 確定嗎？')==true){mainform.actionb.value='ModLi';return true;}";
	echo "else {return false;}";
	echo "}</script>";

	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">設定組織組態: </b></td></tr>";
	echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">組織資金: ".number_format($Pl_Org['funds'])."元</b></td></tr>";
	echo "<tr><td align=left>組織自由度:<br><input type=radio name=\"license\" checked value=\"0\">: 自由加入、退出<br><input type=radio name=\"license\" value=\"1\">: 自由加入，限制退出<br><input type=radio name=\"license\" value=\"2\">: 限制加入，自由退出<br><input type=radio name=\"license\" value=\"3\">: 限制加入、退出<br>";
	echo "<input type=submit value=\"設定\" onClick=\"return cfmModOrgLi();\">";
	echo "</td></tr>";

	if ($Pl_Org['funds'] > 1000000){

	echo "<script language=\"Javascript\">";
	echo "function cfmModOrgC(){";
	echo "if (confirm('以 1,000,000元 修改組織代表色, 確定嗎？')==true){mainform.actionb.value='ModC';return true;}";
	echo "else {return false;}";
	echo "}</script>";

	echo "<tr><td align=left>組織代表色:<br>更換代表色需要使用 1,000,000元 組織資金。<br>";
	$br=$ct_default=0;
	foreach ($MainColors as $TheColor){$br++;$ct_default++;
	echo "<input type=\"radio\" name=\"org_color\" value=#".$TheColor;
	if ($ct_default==1) echo " checked";
	echo "><font color=#".$TheColor.">◆</font> &nbsp;&nbsp; ";
	if ($br==6){echo"<br>";$br=0;}	}
	echo "<input type=submit value=\"設定\" onClick=\"return cfmModOrgC();\">";
	echo "</td></tr>";
	}
	if ($Pl_Org['funds'] > 10000000){
	echo "<script language=\"Javascript\">";
	echo "function cfmModOrgN(){";
	echo "if (confirm('以 10,000,000元 修改組織名稱, 確定嗎？')==true){mainform.actionb.value='ModN';return true;}";
	echo "else {return false;}";
	echo "}</script>";

	echo "<tr><td align=left>組織名稱:<br>更換組織名稱需要使用 10,000,000元 組織資金。<br>";
	echo "新名稱: <input type=text name=NewOrgName maxlength=32>";
	echo "<input type=submit value=\"設定\" onClick=\"return cfmModOrgN();\">";
	echo "</td></tr>";
	}
	if ($Pl_Org['funds'] > 1000000){
        echo "<script language=\"Javascript\">";
        echo "function cfmModOrgX(){";
        echo "if (confirm('以 1,000,000元 修改組織宗旨, 確定嗎？')==true){mainform.actionb.value='ModX';return true;}";
        echo "else {return false;}";
        echo "}</script>";

        echo "<tr><td align=left>組織宗旨:<br>更換組織宗旨需要使用 1,000,000元 組織資金。<br>";
        echo "新宗旨: <input type=text name=NewOrgPose maxlength=90 value=$Pl_Org[pose]>";
        echo "<input type=submit value=\"設定\" onClick=\"return cfmModOrgX();\">";
        echo "</td></tr>";
	}
	echo "</form></table>";
	}// Action A End
	else {echo "未定義動作！";}
}//End of Settings
elseif ($mode == 'ModOrg'){
	if (!$Game['organization'] || $Game['rights'] != '1'){echo "你的權力不足。";postFooter();exit;}
	
	if ($actionb == 'ModLi'){
		$license = mysql_real_escape_string($license);
		//更新 Org Info
		if ($license > 3 || $license < 0){echo "Hacking Attempt.";postFooter();exit;}
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `license` = '$license' WHERE `id` = '".$Pl_Org['id']."' LIMIT 1");
		$query = mysql_query($sql) or die ('無法取得組織資訊, 原因:' . mysql_error() . '<br>');
		if ($license == 0) $LiText = "即日起<b>接受新會員</b>加入而且會員可以<b>自由脫離</b>組織";
		elseif ($license == 1) $LiText = "即日起<b>接受新會員<b>加入但<b>限制會員自行退出</b>";
		elseif ($license == 2) $LiText = "即日起<b>不再接受新會員</b>加入但會員可以<b>自由脫離</b>組織";
		elseif ($license == 3) $LiText = "即日起<b>不再接受新會員</b>加入而且<b>限制會員自行退出</b>";
		$HistoryWrite = "<font color=\"$Pl_Org[color]\">$Pl_Org[name]</font> 的 <font color=\"$Gen[color]\">$Game[gamename]</font> 宣佈組織".$LiText."。";
		WriteHistory($HistoryWrite);
	}// Action A End
	elseif ($actionb == 'ModC'){
		$org_color = mysql_real_escape_string($org_color);
		if (1000000 > $Pl_Org['funds']){echo "組織資金不足。";postFooter();exit;}
		if (!$org_color){echo "請先選好顏色。";postFooter();exit;}
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `color` = '$org_color', `funds` = `funds`-1000000 WHERE `id` = '".$Pl_Org['id']."' LIMIT 1");
		$query = mysql_query($sql) or die ('無法取得組織資訊, 原因:' . mysql_error() . '<br>');
		$Gen['cash']-=1000000;
		$HistoryWrite = "<font color=\"$org_color\">$Pl_Org[name]</font> 的 <font color=\"$Gen[color]\">$Game[gamename]</font> 宣佈組織更換代表顏色。";
		WriteHistory($HistoryWrite);
	}
	elseif ($actionb == 'ModN'){
		$NewOrgName = mysql_real_escape_string($NewOrgName);
		if (10000000 > $Pl_Org['funds']){echo "組織資金不足。";postFooter();exit;}
		if (!$NewOrgName){echo "請先選好組織名稱。";postFooter();exit;}
		$NewOrgName = preg_replace('/<[^<>]*>/','',$NewOrgName);
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `name` = '$NewOrgName', `funds` = `funds`-10000000 WHERE `id` = '".$Pl_Org['id']."' LIMIT 1");
		$query = mysql_query($sql) or die ('無法取得組織資訊, 原因:' . mysql_error() . '<br>');
		$HistoryWrite = "<font color=\"$Pl_Org[color]\">$Pl_Org[name]</font> 的 <font color=\"$Gen[color]\">$Game[gamename]</font> 宣佈組織更名為 <font color=\"$Pl_Org[color]\">$NewOrgName</font> 。";
		WriteHistory($HistoryWrite);
	}
	elseif ($actionb == 'ModX'){
		$NewOrgPose = mysql_real_escape_string($NewOrgPose);
        if (1000000 > $Pl_Org['funds']){echo "組織資金不足。";postFooter();exit;}
        if (!$NewOrgPose){echo "請先選好組織宗旨。";postFooter();exit;}
        $sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `pose` = '$NewOrgPose', `funds` = `funds`-1000000 WHERE `id` = '".$Pl_Org['id']."' LIMIT 1");
        $query = mysql_query($sql) or die ('無法取得組織資訊, 原因:' . mysql_error() . '<br>');
	}
	else {echo "未定義動作！";}
	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
	echo "<p align=center style=\"font-size: 16pt\">組織設定完成了！<input type=submit value=\"返回\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
	
	
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";

}//End of ModOrg
elseif ($mode == 'CityAtk'){
	echo "<font style=\"font-size: 12pt\">攻略計劃</font>";
	printTHR();
	if (!$Game['organization'] || !$Game['rights']){echo "你的權力不足。";postFooter();exit;}
	if ($CFU_Time - $Pl_Org['lastopt'] < 21600){echo "6小時內只能發動一次戰爭。";postFooter();exit;}
	if ($Pl_Org['wartime'] >= 5){echo "每天只能發動5次戰爭，請勿濫用戰爭功能。";postFooter();exit;}
	
	if($Pl_Org['optmissioni']){
		$sql = ("SELECT COUNT(`t_end`) FROM `".$GLOBALS['DBPrefix']."phpeb_user_war` WHERE `war_id` = '$Pl_Org[optmissioni]' AND `t_end` > '$CFU_Time' LIMIT 1;");
		$query = mysql_query($sql);
		$result = mysql_fetch_row($query);
		if($result[0] > 0) {echo "<p style='font-size: 12pt; color: coral' align=center>戰爭已發動。";postFooter();exit;}
	}

	if ($actionb == 'A'){
		echo "<form action=organization.php?action=CityAtk method=post name=mainform>";
		echo "<input type=hidden value='B' name=actionb>";
		echo "<input type=hidden value='1' name=reinforcements>";
		echo "<input type=hidden value='0' name=revolutionPrice>";
		
		
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

		echo "<script language=\"Javascript\">";
		echo "function changeDuration(){price.innerHTML= $Org_War_Cost * mainform.duration.value;}";
		echo "function cfmDeclare(){";
		echo "if ($Pl_Org[funds] < parseInt(price.innerHTML) + parseInt(mainform.revolutionPrice.value)){alert('組織資金不足！');return false;}";
		echo "else if (confirm('即將發動戰爭, 可以嗎？')==true){return true;}";
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
		echo "		inputVal = prompt('請輸入調動軍力的數量( 1 - '+avaVal+' )', '1');";
		echo "		if(inputVal == null) {mainform.atkArea[i].checked = false;return false;}";
		echo "		inputVal = makeVal(inputVal,avaVal); alert('即將調動 '+inputVal+' 點軍力。');";
		echo "		mainform.reinforcements.value = inputVal;";
		echo "		sel_msg.innerHTML = '從 '+mainform.atkArea[i].value+' 調動 '+numberFormat(inputVal)+' 點軍力進攻。';";
		echo "		continue;";
		echo "	}";
		echo "}";
		echo "else {";
		echo "		avaVal = parseInt(document.getElementById('rnfrcmnt_'+mainform.atkArea.value).innerHTML);avaVal -= 1;";
		echo "		inputVal = prompt('請輸入調動軍力的數量( 1 - '+avaVal+' )', '1');";
		echo "		if(inputVal == null) {mainform.atkArea.checked = false;return false;}";
		echo "		inputVal = makeVal(inputVal,avaVal); alert('即將調動 '+inputVal+' 點軍力。');";
		echo "		mainform.reinforcements.value = inputVal;";
		echo "		sel_msg.innerHTML = '從 '+mainform.atkArea.value+' 調動 '+numberFormat(inputVal)+' 點軍力進攻。';";
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
		echo "<tr><td align=left width=475><b style=\"font-size: 10pt;\">計劃對區域發動戰爭: </b></td></tr>";
		echo "<tr><td align=left><b style=\"font-size: 10pt;\">組織資金: ".number_format($Pl_Org['funds'])."元</b></td></tr>";
		echo "<tr><td align=left>需要資金: 每小時 ".number_format($Org_War_Cost)."元<br>共需要: <span id=price>$Org_War_Cost</span> 元<br>";


		unset($sql,$query,$AtTarPosblty,$nums);
		$sql = ("SELECT `map_id`,`name`,`aname` FROM `".$GLOBALS['DBPrefix']."phpeb_user_map`,`".$GLOBALS['DBPrefix']."phpeb_user_organization` WHERE `occupied`=`id` AND `occupied` != ". $Pl_Org['id']." ORDER BY `map_id` ASC");
		$query = mysql_query($sql) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');
		$nums = mysql_num_rows($query);
		$AtTarPosblty = $AtkDisabled = '';
		if ($nums){
			while ($AtkInfo = mysql_fetch_array($query))
				$AtTarPosblty .= "<option value='$AtkInfo[map_id]'>$AtkInfo[aname] ($AtkInfo[map_id] - $AtkInfo[name])";
			echo "於<select name=sttimedelay style=\"$BStyleA;text-align: center;\"><option value=1>1<option value=2>2<option value=3>3<option value=4>4<option value=5>5<option value=6>6<option value=7>7<option value=8>8<option value=9>9<option value=10>10<option value=11>11<option value=12>12<option value=13>13</select>小時後";
			echo "向<select name=target style=\"$BStyleA;text-align: center;\">$AtTarPosblty</select> 發動<br>";
			echo "維持<select name=duration onChange=\"changeDuration()\" style=\"$BStyleA;text-align: center;\"><option value=1>1</select>小時的戰爭";
			$DefaultOName = $CFU_Date."的戰爭";
			echo "<br>行動代號: <input type=text name=Opt_Name maxlength=32 size=39 $BStyleB style=\"$BStyleA;text-align: center;\" value='$DefaultOName'>";
			echo "<hr width=80% align=center>";

			echo "<b style=\"font-size: 10pt;\">調動軍力: </b>";
			echo "<table align=center border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
				$sql = ("SELECT `map_id`, `aname`, `development`, `defenders`, `tickets` FROM `".$GLOBALS['DBPrefix']."phpeb_user_map` WHERE `occupied` = '$Game[organization]' ORDER BY `map_id`");
				$query = mysql_query($sql);

				$O_Area = array();

				while($j = mysql_fetch_array($query))	$O_Area[$j['map_id']] = $j;
				unset($j);
				
				if(mysql_num_rows($query) > 0){
					echo "<tr>";
					echo "<td width=400 valign=top>";
					echo "各管轄區的軍事力量:";
						echo "<table align=center border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 12pt;\" bordercolor=\"#FFFFFF\">";
						echo "<tr align=center><td width=50>區域</td><td width=150>區域名稱</td><td width=75>總軍力</td><td width=75>從此區調動</td></tr>";
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
					echo "		inputVal = makeVal(mainform.atkArea.value,".($members[0]*1000)."); alert('即將調動 '+numberFormat(inputVal)+' 點軍力起義。');";
					echo "		mainform.reinforcements.value = mainform.atkArea.value = inputVal; mainform.revolutionPrice.value = mainform.reinforcements.value*$ticketCost;";
					echo "		sel_msg.innerHTML = '召集 '+inputVal+' 點軍力起義。<br>起義所需組織資金(包括宣戰費): \$' + numberFormat(parseInt(mainform.revolutionPrice.value)+parseInt(price.innerHTML));";
					echo "	}";
					echo "</script>";
					echo "<tr>";
					echo "<td width=400 valign=top>";
					echo "<b>起義</b>:";
					echo "<br>　- 由於己方組織並沒有領地, 因此可以進行「起義」<br>　- 起義軍力的計算方式:<br>　　- 軍力數量: 組織人數 * 1000 (".number_format($members[0]*1000)." 點)<br>　　- 上限: " . ($dailyTicketLim * 4) . "<br>　- 每一點軍力的價錢: ".$ticketCost."<br>";
						echo "<br> 輸入起義軍力數量: <input type=text name=atkArea value=0 onChange=\"checkRevolution();\">";
					echo "</td></tr>";
				}
				echo "<tr><td id=sel_msg>&nbsp;</td></tr>";
			echo "</td></tr>";
			echo "</table>";
		}
		else {echo "沒有可攻略的城市。"; $AtkDisabled = ' disabled';}
		echo "<hr width=80% align=center>";
		echo "<center><input type=submit value=\"宣戰\"$AtkDisabled onClick=\"return cfmDeclare();\" $BStyleB style=\"$BStyleA;\">";
		echo "</td></tr></form></table>";
	}

	elseif ($actionb == 'B'){
		$sttimedelay = mysql_real_escape_string($sttimedelay);
		$duration = mysql_real_escape_string($duration);
		$target = mysql_real_escape_string($target);
		
		if ($duration > 1){echo "戰爭時間嚴重過長。";postFooter();exit;}
		elseif ($duration < 0){echo "戰爭時間嚴重出錯。";postFooter();exit;}
		if ($sttimedelay > 13 || $sttimedelay < 0){echo "戰爭延時時問出錯。";postFooter();exit;}
		$Cost = $Org_War_Cost * $duration;
		if ($Cost < 0){echo "Hacking Attempt！";postFooter();exit;}
		if (!$Pl_Org['id']){echo "組織出錯！";postFooter();exit;}
		if ($Pl_Org['funds'] < $Cost){echo "組織資金不足。";postFooter();exit;}
		if ($Pl_Org['optmissioni']){echo "上一次的戰爭還沒完結！";postFooter();exit;}

		unset($sql,$query);
		$sql = ("SELECT `occupied` FROM `".$GLOBALS['DBPrefix']."phpeb_user_map` WHERE `map_id` = '$target'");
		$query = mysql_query($sql) or die();
		$count = mysql_num_rows($query);

		if($count == 0){echo "找不到目標區域！";postFooter();exit;}
		else{
			$TargetInf = mysql_fetch_array($query);
			if($TargetInf['occupied'] == $Pl_Org['id']) {echo "此區域已經為已方所有！不能進行攻略。";postFooter();exit;}
		}
		
		$revolutionFlag = false;
		$reinforcements = intval($reinforcements);
		if($reinforcements < 1) $reinforcements = 1;
		
		if($revolutionPrice > 0){
		
			$sql = ("SELECT count(map_id) as `aNum` FROM `".$GLOBALS['DBPrefix']."phpeb_user_map` WHERE `occupied` = '$Game[organization]'");
			$query = mysql_query($sql);
			$areaCount = mysql_fetch_row($query);
			if($areaCount[0] > 0){
				echo "錯誤: 已有領地, 不能進行起義。";
				postFooter();
				exit;
			}
			$revolutionFlag = true;
			
			$sql = ("SELECT count(username) as `mNum` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `organization` = '$Game[organization]'");
			$query = mysql_query($sql);
			$memberCount = mysql_fetch_row($query);

			if ($reinforcements > $memberCount[0] * 1000 || $reinforcements > $dailyTicketLim * 4){echo "起義軍力過高！";postFooter();exit;}

			$Cost += $reinforcements*$ticketCost;

			if ($Cost < 0){echo "Hacking Attempt！";postFooter();exit;}
			if ($Pl_Org['funds'] < $Cost){echo "組織資金不足。";postFooter();exit;}
			
			$HistoryWrite = "<font color=\"$Pl_Org[color]\">$Pl_Org[name]</font> 以 <b style=\"color: $Pl_Org[color]\">".$reinforcements."點</b> 軍力起義, 對 ".$target." 區域宣戰！將於<font color=\"$Pl_Org[color]\"> $sttimedelay 小時</font> 後發動！<br>行動代號『<font color=\"$Pl_Org[color]\">".$Opt_Name."</font>』！";

		}
		else{
			$sql = ("SELECT `occupied`,`tickets` FROM `".$GLOBALS['DBPrefix']."phpeb_user_map` WHERE `map_id` = '$atkArea'");
			$query = mysql_query($sql) or die();
			$AtkAreaInf = mysql_fetch_array($query);
			if($reinforcements > $AtkAreaInf['tickets']-1){echo "軍力不足！";postFooter();exit;}
			$HistoryWrite = "<font color=\"$Pl_Org[color]\">$Pl_Org[name]</font> 派出 <b style=\"color: $Pl_Org[color]\">".$reinforcements."點</b> 軍力對 ".$target." 區域宣戰！將於<font color=\"$Pl_Org[color]\"> $sttimedelay 小時</font> 後發動！<br>行動代號『<font color=\"$Pl_Org[color]\">".$Opt_Name."</font>』！";
		}

		if($AtkAreaInf['occupied'] != $Pl_Org['id'] && !$revolutionFlag){echo "錯誤: 調動軍力、發動攻擊的區域, 非己方組織所有！<br>請挑選己方組織的領地調動軍力、發動攻擊。";postFooter();exit;}

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

		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `funds` = `funds`-$Cost, `optmissioni` = '$war_id', `operation` = '$Opt_Name', `lastopt` = '$now', `wartime` = $wartime+'1' WHERE `id` = '$Game[organization]' LIMIT 1;");
		mysql_query($sql);

		echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
		echo "<p align=center style=\"font-size: 16pt\">戰爭發動了！<input type=submit value=\"返回\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
		
		
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
		echo "</form>";
	}

	else {echo "未定義動作！";}
}//End of CityAtk


elseif ($mode == 'TakeCity'){
	echo "<font style=\"font-size: 12pt\">佔領區域</font>";
	printTHR();
	if (!$Game['organization'] || !$Game['rights']){echo "你的權力不足。";postFooter();exit;}
	if ($Game['status']){echo "修理中，無法佔領區域。";postFooter();exit;}
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

	if(!$Opt_Info) $ErrorFlag .= '無法取得戰鬥資訊或戰爭已完結！<br>';
	if($Mission_Area_Id != $Gen['coordinates']) $ErrorFlag .= '無法佔領區域，沒有對此地區宣戰！<br>';
	if ($Opt_Info['victory'] != 1){$ErrorFlag .= "無法佔領區域，仍未勝出戰爭。<br>";}
	if ($Area["Sys"]["occprice"] > $Pl_Org['funds'])$ErrorFlag .= "組織資金不足！不能佔領區域。<br>";

	if($ErrorFlag) {echo $ErrorFlag;postFooter();exit;}

	if ($actionb == 'A'){
	echo "<form action=organization.php?action=TakeCity method=post name=mainform>";
	echo "<input type=hidden value='B' name=actionb>";
	
	
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

	echo "<script language=\"Javascript\">";
	echo "function cfmOccupy(){";
	echo "if ($Pl_Org[funds] < ".$Area["Sys"]["occprice"]."){alert('組織資金不足！');return false;}";
	echo "else if (confirm('以 ".$Area["Sys"]["occprice"]." 佔地此地區, 可以嗎？')==true){return true;}";
	echo "else {return false;}";
	echo "}</script>";
	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">佔領此區域: </b></td></tr>";

	echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">區域: $Gen[coordinates]</b><br>";
	echo "組織資金: ".number_format($Pl_Org['funds'])."元<br>";
	echo "佔領費用: ".number_format($Area["Sys"]["occprice"])."元<br>";
	$Area_At = $Area["Sys"]["at"];
	$Area_De = $Area["Sys"]["de"];
	$Area_Ta = $Area["Sys"]["ta"];
	echo "要塞初期能力:<br>HP上限: ". $Area["Sys"]["hpmax"];
	echo "<br>攻擊力: $Area_At 防衛力: $Area_De 命中: $Area_Ta<br>";
	GetWeaponDetails($Area["Sys"]["wepa"],'FortDfltWep');
	echo "防禦武器: $FortDfltWep[name]<br>";
	echo "<input type=submit value=佔領此區域 onClicl=\"return cfmOccupy()\">";
	echo "</td></tr>";
	echo "</form></table>";
	}
	elseif ($actionb == 'B'){

	if($Opt_Info['ticket_a'] < 1) $Opt_Info['ticket_a'] = 1;
	elseif($Opt_Info['ticket_a'] > $ticketMax) $Opt_Info['ticket_a'] = $ticketMax;

	$HistoryWrite = "<font color=\"$Pl_Org[color]\">$Pl_Org[name]</font> 成功把 $Gen[coordinates] 區域佔領了！";
	WriteHistory($HistoryWrite);

	unset($sql,$query);
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_map` SET `hpmax` = '".$Area["Sys"]["hpmax"]."' ,`hp`=`hpmax` ,`at` ='".$Area["Sys"]["at"]."', `de` ='".$Area["Sys"]["de"]."', `ta` ='".$Area["Sys"]["ta"]."', `wepa` ='".$Area["Sys"]["wepa"]."', `occupied` = '$Game[organization]', `tickets` = '', `defenders` = '' WHERE `map_id` = '$Gen[coordinates]' LIMIT 1;");
	$query = mysql_query($sql) or die(mysql_error());

	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `funds` = `funds`-".$Area["Sys"]["occprice"].", `optmissioni` = 0, `operation` = '' WHERE `id` = '$Game[organization]' LIMIT 1;");
	mysql_query($sql);

	$sql = ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_war` WHERE `war_id` = $Pl_Org[optmissioni] LIMIT 1;");
	$query = mysql_query($sql);

	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
	echo "<p align=center style=\"font-size: 16pt\">成功佔領了此區域！<input type=submit value=\"返回\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
	
	
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";
	}

	else {echo "未定義動作！";}
}//End of TakeCity

elseif ($mode == 'GiveUp'){
        echo "<font style=\"font-size: 12pt\">放棄佔領區域</font>";
        echo "<hr width=80% style=\"filter:alpha(opacity=100,finishopacity=40,style=2)\">";
        if (!$Game['organization'] || !$Game['rights']){echo "你的權力不足。";postFooter;exit;}
        $Area = ReturnMap("$Gen[coordinates]");
		
	$sql = ("SELECT `mission`,`t_start`,`t_end`,`ticket_a`,`victory`,`war_id` FROM `".$GLOBALS['DBPrefix']."phpeb_user_war` WHERE `war_id` = '".$Pl_Org['optmissioni']."' AND `t_end` > '$CFU_Time' LIMIT 1;");
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
		
        if ($Mission_Area_Id != $Gen['coordinates'] && $CFU_Time > $Opt_Info['war_id']){
			echo "無法放棄佔領，沒有對此地區發動佔領。";
			postFooter();
			exit;
		}

        if ($actionb == 'A'){
        echo "<form action=organization.php?action=GiveUp method=post name=mainform>";
        echo "<input type=hidden value='B' name=actionb>";
        echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

        echo "<script language=\"Javascript\">";
        echo "function cfmGiveup(){";
        echo "if (confirm('放棄佔領此區域嗎？')==true){return true;}";
        echo "else {return false;}";
        echo "}</script>";
        echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
        echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">放棄佔領此區域: </b></td></tr>";

        echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">區域: $Gen[coordinates]</b><br>";
        echo "國家資金: ".number_format($Pl_Org['funds'])."元<br>";
        echo "放棄佔領費用: 1,000,000元<br>";
        echo "<input type=submit value=放棄佔領此區域 onClick=\"return cfmGiveup()\">";
        echo "</td></tr>";
        echo "</form></table>";
        }
        elseif ($actionb == 'B'){
		
		$checkt = ("SELECT `t_end` FROM `".$GLOBALS['DBPrefix']."phpeb_user_war` WHERE `war_id` = '".$Pl_Org['optmissioni']."'");
        $qcheck = mysql_query($checkt);
        $times = mysql_fetch_array($qcheck);
		
		if($times['t_end'] < $CFU_Time){
			$fee = 0;
			$text = "放棄已過時的戰爭，無須繳交投降費用。";
		} else if($times['t_end'] > $CFU_Time){
			$fee = 1000000;
			$text = "繳交投降費用 $1000000。";
		}
		
        $HistoryWrite = "<font color=\"$Pl_Org[color]\">$Pl_Org[name]</font> 放棄佔領 $Gen[coordinates] 區域了！";
        WriteHistory($HistoryWrite);

        $upsql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `operation` = '', `optmissioni` = '', `funds` = funds-$fee, `lastopt` = '0' WHERE `name` = '$Pl_Org[name]'");
        mysql_query($upsql);
		
		$delsql = ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_war` WHERE `war_id` = '".$Pl_Org['optmissioni']."'");
        mysql_query($delsql);

        echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=Alpha>";
        echo "<p align=center style=\"font-size: 16pt\">已放棄佔領此區域！<br> $text <br><input type=submit value=\"返回\" onClick=\"parent.Beta.location.replace('gen_info.php')\"></p>";
        echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
        echo "</form>";
        }

        else {echo "未定義動作！";}
}
//End of GiveUp

else {echo "未定義動作！";}
postFooter();
echo "</body>";
echo "</html>";
exit;
?>