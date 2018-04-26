<?php

header('Content-Type: text/html; charset=utf-8');
$mode = (isset($_GET['action'])) ? $_GET['action'] : $_POST['action'];
include('cfu.php');
include('includes/repairplayer-f.inc.php');
AuthUser();
postHead('');
if ($mode == 'proc') {
    	postHead(1);
	//Assign Variables
	$User = $_SESSION['username'];
	$Password = $_SESSION['password'];
	
	$onlineip = $_SERVER['REMOTE_ADDR'];
    $sql_iplog = ('UPDATE `'.$GLOBALS['DBPrefix']."phpeb_user_general_info` SET lastip='$onlineip', lastlogin='$CFU_Time' WHERE username='".$_SESSION['username']."'");
    mysql_query($sql_iplog);
	
	//Fetch Player Information
	include_once('includes/sfo.class.php');
	$Pl = new player_stats;
	$Pl->SetUser($User);
	$Pl->FetchPlayer(true,false,', `request`');
	
	$Player = &$Pl->Player;
	GetUsrDetails("$_SESSION[username]",'Gen','Game');
	
	//Adjust to user's setting
	if ($Player['gen_img_dir'])
	$General_Image_Dir = $Player['gen_img_dir'];
	if ($Player['unit_img_dir'])
	$Unit_Image_Dir = $Player['unit_img_dir'];
	if ($Player['base_img_dir'])
	$Base_Image_Dir = $Player['base_img_dir'];

	//Area and Organization
	$Area = ReturnMap($Player['coordinates']);
	$AreaLandForm = ReturnMType($Area["Sys"]["type"]);
	$LandFormBg = ReturnMBg($Area["Sys"]["type"]);
	$AreaOrg = ReturnOrg($Area["User"]["occupied"]);
	if($Player['organization'] == $Area["User"]["occupied"]) $Pl_Org = &$AreaOrg;
	else $Pl_Org = ReturnOrg($Player['organization']);

	//Ranks
	$RightsTitle = $Pl_Rank = '';
	if ($Player['rights'] == '1') {$RightsTitle = $RightsClass['Major'];}
	elseif ($Player['rights']) {$RightsTitle = $RightsClass['Leader'];}
	$Pl_Rank = rankConvert($Player['rank']);

	//Process Character Status
	$AtClr = colorConvert($Player['attacking']);
	$DeClr = colorConvert($Player['defending']);
	$ReClr = colorConvert($Player['reacting']);
	$TaClr = colorConvert($Player['targeting']);

	$NextStatPt_At=$Player['attacking']+1;
	$NextStatPt_De=$Player['defending']+1;
	$NextStatPt_Re=$Player['reacting']+1;
	$NextStatPt_Ta=$Player['targeting']+1;

	CalcStatReq('At',"$NextStatPt_At");
	CalcStatReq('De',"$NextStatPt_De");
	CalcStatReq('Re',"$NextStatPt_Re");
	CalcStatReq('Ta',"$NextStatPt_Ta");

	$Stat_Add = array();
	$Stat_Add['at'] = $Stat_Add['de'] = $Stat_Add['re'] = $Stat_Add['ta'] = $Stat_Add['sp'] = array('Style' => '', 'Image' => '');

	function setAddStatImg($Growth, $StatReq, $Stat, &$aCollection, $Limit=150){
	global $General_Image_Dir;
	if ($Growth >= $StatReq && $Stat < $Limit){
		$aCollection['Style'] = " cursor: pointer;";
		$aCollection['Image'] = "$General_Image_Dir/neo/plus_sign.gif";
	} else {
		$aCollection['Style'] = " cursor: default; ";
		$aCollection['Image'] = "$General_Image_Dir/neo/plus_sign_grey.gif";
	}
}
	
	setAddStatImg($Player['growth'],$At_Stat_Req,$Player['attacking'],$Stat_Add['at']);
	setAddStatImg($Player['growth'],$De_Stat_Req,$Player['defending'],$Stat_Add['de']);
	setAddStatImg($Player['growth'],$Re_Stat_Req,$Player['reacting'], $Stat_Add['re']);
	setAddStatImg($Player['growth'],$Ta_Stat_Req,$Player['targeting'],$Stat_Add['ta']);
	setAddStatImg($Player['growth'],$SP_Stat_Req,0,$Stat_Add['sp']); // To be set in CFU

	// Process Character Information
	// Using Phase Structure

	//
	// Prephase I
	//
	
	//Get User MS Stats
	if ($Player['msuit'] == "nil") $Player['msuit'] = '0';
	$Pl->ProcessMS(true);
	$Ms = &$Pl->MS;
	if ($Player['msuit']){
		// Repair and Update
		$RepUpdateFlag = (($CFU_Time - $Player['time1']) >= 5);
		$Pl_Repaired = RepairPlayer($Pl->Player,$Pl->Eq['D'],$Pl->Eq['E'],0,0,$RepUpdateFlag);
		$Pl->Player['hp'] = $Pl_Repaired['hp'];
		$Pl->Player['en'] = $Pl_Repaired['en'];
		$Pl->Player['sp'] = $Pl_Repaired['sp'];
		$Pl->Player['status'] = $Pl_Repaired['status'];
		$Pl->Player['time1'] = $Pl_Repaired['time1'];
	}
	
	// Initialize Player Details
	$Pl->iniFixes(true);
	$Pl->analyzeHypermodeState();
	$Pl->ProcessAllWeapon();

	//
	// Prephase II
	//

	// Set Spec Sub-System: Check Requirements
	$Pl->checkSetSpec();
	if($Pl->SetSpecID){
		// Include Interface
		include_once('includes/spc/spc.superclass.php');
		// Include Implementation Classes
		include_once('includes/spc/spc.'.$Pl->SetSpecID.'.class.php');
		$str = '$Pl->SetSpec = new sSpc_'.$Pl->SetSpecID.'($Pl);';
		eval($str);
		$Pl->SetSpec->checkSetActivation();
		$Pl->SetSpec->prephase();
	}

	// Apply Weapon/Equipment Type Custom Limitations
	$Pl->applyTypeCustoms();

	//
	// Metaphase
	//

	//Generate Special Ability Pool
	$Pl->generateSpecialAbilityPool();

	// Meta-phase Set Specs
	if($Pl->SetSpecID) $Pl->SetSpec->metaphase();

	// Pilot Hypermode Effects
	$Pl->applyEXAM();
	$Pl->applySEEDMode();
	$Pl->deterSpecRequirements();

	// MS Effects
	//Upper-case Mob Effects
	$Pl->applyMSMobU();
	//Upper-case Tar Effect
	$Pl->applyMSTarU();
	//Upper-case Def Specs
	$Pl->applyMSDefU();
	
	//Organization War Information
		$Otp_TellTime = $WarColor = '';
		$Otp_Area_Sql = ("SELECT `t_start`,`t_end`,`a_org`,`b_org`,`ticket_a`,`ticket_b`,`victory` FROM `".$GLOBALS['DBPrefix']."phpeb_user_war` WHERE `mission` = 'Atk<$Player[coordinates]>' AND `t_end` > '$CFU_Time' ORDER BY `t_start` ASC LIMIT 1");
		$Otp_Area_Q = mysql_query($Otp_Area_Sql) or die(mysql_error());
		$Otp_A_ITar = mysql_fetch_array($Otp_Area_Q);
		if ($Otp_A_ITar){
			$WarColor = 'color: FF7575;';
			if ($Otp_A_ITar['t_start'] >= $CFU_Time){
			$TimeTSSec = $Otp_A_ITar['t_start'] - $CFU_Time;
			$TimetS['hours'] = floor($TimeTSSec/3600);
			$TimetS['minutes'] = floor(($TimeTSSec - ($TimetS['hours']*3600))/60);
			$TimetS['seconds'] = floor($TimeTSSec - ($TimetS['hours']*3600) - ($TimetS['minutes']*60));
			$Otp_TellTime = "還有$TimetS[hours]小時$TimetS[minutes]分鐘$TimetS[seconds]秒開始戰爭。";
			}
			else{
			$TimeTSSec = $Otp_A_ITar['t_end'] - $CFU_Time;
			$TimetS['hours'] = floor($TimeTSSec/3600);
			$TimetS['minutes'] = floor(($TimeTSSec - ($TimetS['hours']*3600))/60);
			$TimetS['seconds'] = floor($TimeTSSec - ($TimetS['hours']*3600) - ($TimetS['minutes']*60));
			$Otp_TellTime = "還有$TimetS[hours]小時$TimetS[minutes]分鐘$TimetS[seconds]秒戰爭宣告終了。";}
		}

    echo "<style type=\"text/css\">b {FILTER: glow(color: 0000ff,strength=1);height:1} body {background-image: url('$General_Image_Dir".$LandFormBg."1024.jpg')}</style>";

    echo '<br>';

    echo '<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" height="300px"><tr>';
    echo "<td width=\"80%\" height=\"20\" style=\"font-size: 14pt;\" align=center><font style=\"color: $Player[color]; font-weight: Bold\">$Player[gamename]</font> <font style=\"color: $Pl_Org[color]\">($Pl_Org[name])</font>";
    if ($RightsTitle) {
        echo "<font style=\"color: yellow;font-weight: Bold;\">  $RightsTitle</font>";
    }
    if ($Player['organization']) {
        echo "  $Pl_Rank";
    }
	if($Pl_Org[id] != 0){
		echo "    國家宗旨: <font style=\"color: $Pl_Org[color]\">$Pl_Org[pose]</font>";
	}
    echo "    <font style=\"font-size: 10pt\">$TypeFame: $ShowFame    所在區域: $Player[coordinates]    統治組織: <font style=\"color: $AreaOrg[color]\">".$AreaOrg[name].'</font>';
    if ($Otp_TellTime) {
        echo " <font style=\"color: red\">[戰爭狀態]</font> $Otp_TellTime";
    }

    echo '</font></td>';

    echo '</tr><tr><td width="100%" height="100%">';
    echo '<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" height=100% width="100%">';
    echo '<tr>';
    echo '<td width="14%" valign=center>';
    echo '<img src="'.$Unit_Image_Dir."/$Ms[image]\">";
	
	if ($Player['msuit'])
	switch ($Player['status']){case 0: $StatusShow="可戰鬥"; $StatusColor='#016CFE';break; case 1: $StatusShow="修理中"; $StatusColor='#FF2200';break;}
	else {$StatusShow = '沒有機體'; $StatusColor = '#FF2200';}
	
    echo "<br>$Ms[msname]<br> 機體等級: $Player[mslv] <br> 勝利積分/次數: $Player[v_points]/$Player[victory]<br>狀態: <b id=status_now style=\"color: $StatusColor\">$StatusShow</b></td>"
,'<td width="2%">　</td>'
,'<td width="21%" valign=top>　<div align="center">'
,'<center>'
,'<table cellpadding=0 cellspacing=0 border=0 style="font-size:14px; border-collapse:collapse" bordercolor="#111111">'
,'<tr>';
    echo '<form action=nil method=post name=addstat target=Beta>';
    echo "<input type=hidden value='none' name=actionb>";
    echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
    echo '</form>';
    echo '<script language="JavaScript">';
    echo 'function add_stat(type){';
    echo "        if (type == 'at'){";
    echo "        if ($Player[growth] < $At_Stat_Req || $At_Stat_Req == '0' || $Player[growth] == '0'){alert('你的成長點數不足夠！');return false}";
    echo "        if (confirm('你現在有 $Player[growth] 成長點數。\\n要把攻擊技術加到 $NextStatPt_At 的話需要 $At_Stat_Req 點數。\\n確定嗎?') == true){";
    echo "        addstat.action='statsmod.php?action=addstat';addstat.target='Alpha';addstat.actionb.value='at';addstat.submit();}else{ataddlink.style.visibility='visible';return false}";
    echo '        }';
    echo "        if (type == 'de'){";
    echo "        if ($Player[growth] < $De_Stat_Req || $De_Stat_Req == '0' || $Player[growth] == '0'){alert('你的成長點數不足夠！');return false}";
    echo "        if (confirm('你現在有 $Player[growth] 成長點數。\\n要把防禦能力加到 $NextStatPt_De 的話需要 $De_Stat_Req 點數。\\n確定嗎?') == true){";
    echo "        addstat.action='statsmod.php?action=addstat';addstat.target='Alpha';addstat.actionb.value='de';addstat.submit();}else{deaddlink.style.visibility='visible';return false}";
    echo '        }';
    echo "        if (type == 're'){";
    echo "        if ($Player[growth] < $Re_Stat_Req || $Re_Stat_Req == '0' || $Player[growth] == '0'){alert('你的成長點數不足夠！');return false}";
    echo "        if (confirm('你現在有 $Player[growth] 成長點數。\\n要把迴避加到 $NextStatPt_Re 的話需要 $Re_Stat_Req 點數。\\n確定嗎?') == true){";
    echo "        addstat.action='statsmod.php?action=addstat';addstat.target='Alpha';addstat.actionb.value='re';addstat.submit();}else{readdlink.style.visibility='visible';return false}";
    echo '        }';
    echo "        if (type == 'ta'){";
    echo "        if ($Player[growth] < $Ta_Stat_Req || $Ta_Stat_Req == '0' || $Player[growth] == '0'){alert('你的成長點數不足夠！');return false}";
    echo "        if (confirm('你現在有 $Player[growth] 成長點數。\\n要把命中能力加到 $NextStatPt_Ta 的話需要 $Ta_Stat_Req 點數。\\n確定嗎?') == true){";
    echo "        addstat.action='statsmod.php?action=addstat';addstat.target='Alpha';addstat.actionb.value='ta';addstat.submit();}else{taaddlink.style.visibility='visible';return false}";
    echo '        }}</script>';
    if ($Player['growth'] >= $At_Stat_Req && $Player['attacking'] < 150) {
        $AtAdd = " style=\"text-decoration: underline overline\" onClick=\"this.style.visibility='hidden';add_stat('at')\" onMouseover=\"this.style.color='yellow'\" onMouseOut=\"this.style.color='';\" id = 'ataddlink'";
    }
    if ($Player['growth'] >= $De_Stat_Req && $Player['defending'] < 150) {
        $DeAdd = " style=\"text-decoration: underline overline\" onClick=\"this.style.visibility='hidden';add_stat('de')\" onMouseover=\"this.style.color='yellow'\" onMouseOut=\"this.style.color='';\" id = 'deaddlink'";
    }
    if ($Player['growth'] >= $Re_Stat_Req && $Player['reacting'] < 150) {
        $ReAdd = " style=\"text-decoration: underline overline\" onClick=\"this.style.visibility='hidden';add_stat('re')\" onMouseover=\"this.style.color='yellow'\" onMouseOut=\"this.style.color='';\" id = 'readdlink'";
    }
    if ($Player['growth'] >= $Ta_Stat_Req && $Player['targeting'] < 150) {
        $TaAdd = " style=\"text-decoration: underline overline\" onClick=\"this.style.visibility='hidden';add_stat('ta')\" onMouseover=\"this.style.color='yellow'\" onMouseOut=\"this.style.color='';\" id = 'taaddlink'";
    }

		$Ms_At_Mod = $Ms['atf']-$Ms['base']['atf'];
		$Ms_De_Mod = $Ms['def']-$Ms['base']['def'];
		$Ms_Re_Mod = $Ms['ref']-$Ms['base']['ref'];
		$Ms_Ta_Mod = $Ms['taf']-$Ms['base']['taf'];
		
		//Ms Level
		$A_AvgMs = floor(($Ms['atf'] + $Ms['taf']) / 2);
		$B_AvgMs = floor(($Ms['def'] + $Ms['ref']) / 2);
		$Ms_At_Mod += ceil($Player['mslv'] * $Ms['atf'] / $A_AvgMs);
		$Ms_Ta_Mod += ceil($Player['mslv'] * $Ms['def'] / $A_AvgMs);
		$Ms_De_Mod += ceil($Player['mslv'] * $Ms['ref'] / $B_AvgMs);
		$Ms_Re_Mod += ceil($Player['mslv'] * $Ms['taf'] / $B_AvgMs);
		
		$ShowAt = $Player['attacking'] * 0.2;
		$ShowDe = $Player['defending'] * 0.2;
		$ShowRe = $Player['reacting'] * 0.2;
		$ShowTa = $Player['targeting'] * 0.2;
		
    echo '<br><br><br>';
    echo "<td rowspan=3 align=center><span id=attacking$AtAdd>攻擊</span><br>";
    echo "<b style=\"color:$AtClr;\">$Player[attacking] + $Ms_At_Mod</b></td>";
    echo "<td align=center><span id=defending$DeAdd>防禦</span><br>";
    echo "<b style=\"color:$DeClr;\">$Player[defending] + $Ms_De_Mod</b></td>";
    echo "<td rowspan=3 align=center><span id=reacting$ReAdd>迴避</span><br>";
    echo "<b style=\"color:$ReClr;\">$Player[reacting] + $Ms_Re_Mod </b></td>";
    echo '</tr>',
'<tr>',
'<td valign=top>',
'<table cellpadding=0 cellspacing=0 border=0 bgcolor="#000000">',
'<tr>',
"<td width=30 height=30 align=right valign=bottom background=\"$Base_Image_Dir/btl.gif\"><img src='$Base_Image_Dir/tl.gif' width=$ShowAt height=$ShowDe style=\"position:relative;filter:alpha(opacity=70,finishopacitiy=70);\"></td>",
"<td width=30 height=30 align=left valign=bottom background=\"$Base_Image_Dir/btr.gif\"><img src='$Base_Image_Dir/tr.gif' width=$ShowRe height=$ShowDe style=\"position:relative;filter:alpha(opacity=70,finishopacitiy=70);\"></td>",
'</tr><tr>',
"<td width=30 height=30 align=right valign=top background=\"$Base_Image_Dir/bbl.gif\"><img src='$Base_Image_Dir/bl.gif' width=$ShowAt height=$ShowTa style=\"position:relative;filter:alpha(opacity=70,finishopacitiy=70);\"></td>",
"<td width=30 height=30 align=left valign=top background=\"$Base_Image_Dir/bbr.gif\"><img src='$Base_Image_Dir/br.gif' width=$ShowRe height=$ShowTa style=\"position:relative;filter:alpha(opacity=70,finishopacitiy=70);\"></td>",
'</tr></table></td></tr><tr>';
    echo "<td align=center><span id=targeting$TaAdd>命中</span><br>";
    echo "<b style=\"color:$TaClr;\">$Player[targeting] + $Ms_Ta_Mod</b></td>";
    echo '</tr>';
    echo '</table>';
    echo '</center>';
    echo '</div>';
    echo '</td>';
    echo '<td width="2%"> ';
    echo '</td>';
    echo '<td width="30%" valign=top><div align="center">';
    echo '<center>';
    echo '<table style="font-size:15px;" width="55%"><tr>';
    echo '<td style="background: '.$BStyleC.';font-size:13px;" align=center width="70">';
    if ($Player['msuit']) {
        echo '<b>生命值</b></td>';
    } else {
        echo '<b>生命付加值</b></td>';
    }
    $Pl_ShowHP = floor($Player['hp']);
	$Pl_ShowEN = floor($Player['en']);
	$Pl_ShowSP = floor($Player['sp']);
	$SP_RecRate = 0.004 * $Player['spmax'];
    echo "<td align=right style=\"border:1px solid #404040;\" width=\"124\"><b id=current_hp>$Pl_ShowHP</b><b> / $Player[hpmax]</b></td></tr><tr>";
    echo '<td style="background: '.$BStyleC.';font-size:13px;" align=center width="70">';
    if ($Player['msuit']) {
        echo '<b>能量值</b></td>';
    } else {
        echo '<b>能量付加值</b></td>';
    }
    echo "<td align=right style=\"border:1px solid #404040;\" width=\"124\"><b id=current_en>$Pl_ShowEN</b><b> / $Player[enmax]</b></td></tr><tr>";

    echo '<td style="background: '.$BStyleC.';font-size:13px;" align=center width="70">';
    echo '<b>氣力</b></td>';
    echo "<td align=right style=\"border:1px solid #404040;\" width=\"124\"><b id=current_sp>$Pl_ShowSP</b><b> / $Player[spmax]</b></td></tr><tr>";

    echo '<td style="background: '.$BStyleC.';font-size:13px;" align=center width="70">';
    echo '<b>等級</b></td>';
    if ($Player['level'] > 150) {
        $Player['level'] = 150;
    }
    echo "<td align=right style=\"border:1px solid #404040;\" width=\"124\"><b>$Player[level]</b></td></tr><tr>";
    echo '<td style="background: '.$BStyleC.';font-size:13px;" align=center width="70">';
    $Show_Exp = '';
    if ($Player['level'] >= 150) {
        $UserNextLvExp = false;
        $Show_Exp = '<center>---</center>';
    } else {
        calcExp("$Player[level]");
        $Show_Exp = "$Player[expr] / $UserNextLvExp";
    }
    echo '<b>經驗值</b></td>';
    echo "<td align=right style=\"border:1px solid #404040;\" width=\"124\"><b>$Show_Exp</b></td></tr><tr>";
	echo '<td style="background: '.$BStyleC.';font-size:13px;" align=center width="70">';
	$Show_MsExp = '';
	if ($Player['mslv'] >= 30) {
        $UserNextMsLvExp = false;
        $Show_MsExp = '<center>---</center>';
    } else {
        calcMsExp("$Player[mslv]");
        $Show_MsExp = "$Player[msexp] / $UserNextMsLvExp";
    }
	echo '<b>機體經驗值</b></td>';
    echo "<td align=right style=\"border:1px solid #404040;\" width=\"124\"><b>$Show_MsExp</b></td></tr><tr>";
    echo '<td style="background: '.$BStyleC.';font-size:13px;" align=center width="70">';
    echo '<b>種族</b></td>';
    echo '<td align=right style="border:1px solid #404040;" width="124"><b';
    if ($Player['hypermode'] == 1 || ($Player['hypermode'] >= 4 && $Player['hypermode'] <= 6)) {
        echo ' style="filter: glow(color: 0000FF,strength=2)"';
    }
    echo ">$Player[type_name]";
    if ($Player['hypermode'] == 1 || $Player['hypermode'] == 5) {
        echo '<br><font style="color: FFFF00;font-weight: bold">SEED Mode</font>';
    }
    if ($Player['hypermode'] >= 4 && $Player['hypermode'] <= 6) {
        echo '<br><font style="color: FF0000;font-weight: bold">EXAM Activated</font>';
    }
    echo '</b></td></tr><tr>';
    echo '<td style="background: '.$BStyleC.';font-size:13px;" align=center width="70">';
    echo '<b>成長點數</b></td>';
    echo "<td align=right style=\"border:1px solid #404040;\" width=\"124\"><b>$Player[growth]</b></td></tr><tr>";
    echo '<td style="background: '.$BStyleC.';font-size:13px;" align=center width="70">';
    echo '<b>金錢</b></td>';
    echo '<td align=right style="border:1px solid #404040;" width="124"><b>'.number_format($Player['cash']).'</b></td></tr></table>';
    echo '</center>';
    echo '</div></td>';
    echo '<td width="2%">　</td>';
    echo '<td width="34%" valign=top>';
    if ($Player['msuit']) {
        $UsrWepA = explode('<!>', $Player['wepa']);
        $UsrWepB = explode('<!>', $Player['wepb']);
        $UsrWepC = explode('<!>', $Player['wepc']);
        $UsrWepD = explode('<!>', $Player['eqwep']);
        $UsrWepE = explode('<!>', $Player['p_equip']);
        GetWeaponDetails("$UsrWepA[0]", 'SysWepA');
        GetWeaponDetails("$UsrWepB[0]", 'SysWepB');
        GetWeaponDetails("$UsrWepC[0]", 'SysWepC');
        GetWeaponDetails("$UsrWepD[0]", 'SysWepD');
        GetWeaponDetails("$UsrWepE[0]", 'SysWepE');
        if ($UsrWepA[2] == 1) {
            $SysWepA['name'] = $UsrWepA[3].$SysWepA['name'];
        } elseif ($UsrWepA[2] == 2) {
            $SysWepA['name'] = $SysWepA['name'].$UsrWepA[3];
        }
        if ($UsrWepB[2] == 1) {
            $SysWepB['name'] = $UsrWepB[3].$SysWepB['name'];
        } elseif ($UsrWepB[2] == 2) {
            $SysWepB['name'] = $SysWepB['name'].$UsrWepB[3];
        }
        if ($UsrWepC[2] == 1) {
            $SysWepC['name'] = $UsrWepC[3].$SysWepC['name'];
        } elseif ($UsrWepC[2] == 2) {
            $SysWepC['name'] = $SysWepC['name'].$UsrWepC[3];
        }
        if ($UsrWepD[2] == 1) {
            $SysWepD['name'] = $UsrWepD[3].$SysWepD['name'];
        } elseif ($UsrWepD[2] == 2) {
            $SysWepD['name'] = $SysWepD['name'].$UsrWepD[3];
        }
        if ($UsrWepE[2] == 1) {
            $SysWepE['name'] = $UsrWepE[3].$SysWepE['name'];
        } elseif ($UsrWepE[2] == 2) {
            $SysWepE['name'] = $SysWepE['name'].$UsrWepE[3];
        }
    }

    echo '<span style="background-color:  '.$Player['color'].'"> <b>裝備</b> </span> ';
    if ($Player['msuit']) {
        echo "$SysWepA[name] 經驗: $UsrWepA[1]<br>備用一: $SysWepB[name] 經驗: $UsrWepB[1]<br>備用二: $SysWepC[name] 經驗: $UsrWepC[1]";
    } else {
        echo '<br>沒有機體。<br><br><br>';
    }
    echo '<br><span style="background-color:  '.$Player['color'].'">&nbsp<b>輔助裝備</b> </span> ';
    if ($Player['msuit']) {
        echo "$SysWepD[name] 經驗: $UsrWepD[1]";
    }
    if ($Player['p_equip'] && $Player['p_equip'] != '0<!>0') {
        echo '<br><span style="background-color:  '.$Player['color'].'">&nbsp<b>常規裝備</b> </span> ';
        if ($Player['msuit']) {
            echo "$SysWepE[name] 經驗: $UsrWepE[1]";
        }
    }
	
	$Pl_ShowHP = floor($Player['hp']);
	$Pl_ShowEN = floor($Player['en']);
	$Pl_ShowSP = floor($Player['sp']);
	$SP_RecRate = 0.004 * $Player['spmax'];
	echo "<script language=\"JavaScript\">";
	echo "var m_h = $Player[hpmax];";	// prefix "m_" for max
	echo "var m_e = $Player[enmax];";
	echo "var m_s = $Player[spmax];";
	echo "var i_h = $Pl_ShowHP;";		// prefix "i_" for initial
	echo "var i_e = $Pl_ShowEN;";
	echo "var i_s = $Pl_ShowSP;";
	echo "var h = $Pl_ShowHP;";		// no prefix for now
	echo "var e = $Pl_ShowEN;";
	echo "var s = $Pl_ShowSP;";
	echo "var r_h = 0;";
	echo "var r_e = 0;";
	echo "var r_s = 0;";
	echo "var chatUpdate = 0;";
	echo "var sprate = $SP_RecRate;";
    echo 'var timerID;';
    echo 'TheDate = new Date();';
    echo 'var m_time=TheDate.getTime();';
    echo 'AutoRepairJ();';
    echo 'function AutoRepairJ(){';
    echo 'TheDate2 = new Date();';
    echo '        n_time=TheDate2.getTime();';
    echo "        ts_gap = (m_time - n_time)/-1000;\n";

    $HP_AutoRepairType = $EN_AutoRepairType = 0;
	if ($Ms['hprec'] >= 1) $HP_AutoRepairType = 1;//Constant HP Recovery
	if ($Ms['hprec'] < 1 && $Ms['hprec'] >= 0.001) $HP_AutoRepairType = 2;//Percentage HP Recovery

	if ($Ms['enrec'] >= 1)$EN_AutoRepairType = 1;//Constant EN Recovery
	if ($Ms['enrec'] < 1 && $Ms['enrec'] >= 0.001) $EN_AutoRepairType = 2;//Percentage EN Recovery

	switch ($HP_AutoRepairType){
		case 1: echo "hprate = $Ms[hprec];";break;
		case 2: echo "hprate = $Ms[hprec]*m_h;";break;
		default: echo "hprate = 0;";break;}
	switch ($EN_AutoRepairType){
		case 1: echo "enrate = $Ms[enrec];";break;
		case 2: echo "enrate = $Ms[enrec]*m_e;";break;
		default: echo "enrate = 0;";break;}

	if ($Player['hypermode'] == 2 || $Player['hypermode'] == 6) $SP_RecRate *= 2;

	$EqRecHP=$EqRecEN=$PEqRecHP=$PEqRecEN='';
	if ($Pl->Eq['D']['spec']){
		if (strpos($Pl->Eq['D']['spec'],'HPPcRecA') !== false){$EqRecHP = " + (ts_gap * (0.005 * m_h))";}
		if (strpos($Pl->Eq['D']['spec'],'ENPcRecB') !== false){$EqRecEN = " + (ts_gap * (0.015 * m_e))";}
		elseif (strpos($Pl->Eq['D']['spec'],'ENPcRecA') !== false){$EqRecEN = " + (ts_gap * (0.0075 * m_e))";}
	}
	if ($Pl->Eq['E']['spec']){
		if (strpos($Pl->Eq['E']['spec'],'HPPcRecA') !== false){$PEqRecHP = " + (ts_gap * (0.005 * m_h))";}
		if (strpos($Pl->Eq['E']['spec'],'ENPcRecB') !== false){$PEqRecEN = " + ts_gap * (0.015 * m_e))";}
		elseif (strpos($Pl->Eq['E']['spec'],'ENPcRecA') !== false){$PEqRecEN = " + (ts_gap * (0.0075 * m_e))";}
	}

    echo "        if (h < 0){h = 0;}\n";
    echo "        if (h < $Player[hpmax]){h = $Pl_ShowHP + (ts_gap * hprate);".$EqRecHP."}else{h = $Player[hpmax];}\n";
    echo "        if (e < $Player[enmax]){e = $Pl_ShowEN + (ts_gap * enrate);".$EqRecEN."}else{e = $Player[enmax];}\n";
    echo "        if (s < $Player[spmax]){s = $Pl_ShowSP + (ts_gap * ".$SP_RecRate.");}else{s = $Player[spmax];}\n";

    echo "        if (h >= $Player[hpmax] && status_now.innerText=='修理中')";
    echo "        {status_now.innerText='可戰鬥';status_now.style.color='#143DC1';}";

    echo '        current_hp.innerText=Math.round (h);';
    echo '        current_en.innerText=Math.round (e);';
    echo '        current_sp.innerText=Math.round (s);';
    echo '        clearTimeout(timerID);';
    echo '        timerID = setTimeout("AutoRepairJ()",100);';
    echo '        }';
    echo '        </script>';

    if ($Player['request']) {
        echo '<form action=organization.php?action=Employ method=post name=requestOrg>';
        echo "<input type=hidden value='C' name=actionb>";
        echo "<input type=hidden name=actionc value=''>";
        echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
        echo '<p><span style="font-weight: 700; font-size: 10pt; background-color:  '.$Player['color'].'"> <b>邀請信</b> </span><br>';
        echo "$Player[request]";
        echo "<input type=submit onClick=\"actionc.value='Accept'\" value='答應'>";
        echo "<input type=submit onClick=\"actionc.value='Refuse'\" value='拒絕'>";
        echo '</form>';
    }

	//Bar 9 & 10: Tickets & Operation Notice
	$Tickets = 0;
	$Operation_Details = '';
	$atkMissionFlag = 0;

	if ($Pl_Org['optmissioni']){
		if($Pl_Org['id'] == $Otp_A_ITar['a_org']) {
			$Pl_Mission['mission'] = 'Atk<'.$Player['coordinates'].'>';
			$Pl_Mission['t_start'] = $Otp_A_ITar['t_start'];
			$Pl_Mission['t_end'] = $Otp_A_ITar['t_end'];
			$Pl_Mission['ticket_a'] = $Otp_A_ITar['ticket_a'];
			$Pl_Mission['victory'] = $Otp_A_ITar['victory'];
		}
		else{
			$sql = ("SELECT `mission`,`t_start`,`t_end`,`ticket_a`,`victory` FROM `".$GLOBALS['DBPrefix']."phpeb_user_war` WHERE `war_id` = '$Pl_Org[optmissioni]' AND `t_end` > '$CFU_Time' LIMIT 1;");
			$query = mysql_query($sql);
			if(mysql_num_rows($query) <= 0) {
				$sql = ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_war` WHERE `war_id` = $Pl_Org[optmissioni] LIMIT 1;");
				$query = mysql_query($sql);
				$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `optmissioni` = 0 WHERE `id` = $Pl_Org[id] LIMIT 1;");
				$query = mysql_query($sql);
			}
			$Pl_Mission = mysql_fetch_array($query);
		}
		$Pl_Show_Mission = array();
		if(preg_match('/Atk<([0-9a-zA-Z]+)>/',$Pl_Mission['mission'],$Pl_Show_Mission)){
			if($Pl_Show_Mission[1] != $Player['coordinates'])	$Opt_Area = ReturnMap($Pl_Show_Mission[1]);
			else $Opt_Area = $Area;
			if($Opt_Area["User"]["occupied"] == $Area["User"]["occupied"])	$Opt_Org = $AreaOrg;
			elseif($Opt_Area["User"]["occupied"] == $Player['organization'])$Opt_Org = $Pl_Org;
			else $Opt_Org = ReturnOrg($Opt_Area["User"]["occupied"]);
			$Operation_Details .= "<font style=\"font-size: 8pt;color: white\">[任務]</font><br><font style=\"font-size: 8pt;\">行動代號: $Pl_Org[operation]</font><br>";
			$Operation_Details .= "<font style=\"font-size: 10pt;color: white\">[內容] 區域攻防戰</font><br>把 <font color=$Opt_Org[color]>$Pl_Show_Mission[1]區域</font> 的 <font color=$Opt_Org[color]>敵方要塞</font> 擊破<br>或<br>殲滅 <font color=$Opt_Org[color]>$Pl_Show_Mission[1]區域</font> 中的<font color=$Opt_Org[color]>$Opt_Org[name]</font>軍力";
			$Operation_Details .= "</td></tr><tr height=109 style=\"padding-left: 10px;padding-top: 3px\" valign=top><td style=\"background-image: url('$General_Image_Dir/neo/rt_tab_bg.jpg');\" colspan=3 width=200>";
			$StartAtk = preg_replace('/星期(.*), /','星期\\1<br>',cfu_time_convert($Pl_Mission['t_start']));
			$TimeEnd = preg_replace('/星期(.*), /','星期\\1<br>',cfu_time_convert($Pl_Mission['t_end']));
			$Operation_Details .=  "<font style=\"font-size: 10pt;color: white\">[開始時間]</font><br> $StartAtk <br><font style=\"font-size: 10pt;color: white\">[完結時間]</font><br> $TimeEnd ";
			$Tickets = $Pl_Mission['ticket_a'];
			$atkMissionFlag = 1;
		}
	}
	elseif($Pl_Org['id'] != 0){
		if($Otp_A_ITar['b_org'] == $Pl_Org['id']){
			$Def_Area_Id = $Player['coordinates'];
			$Defend_War['t_start'] = $Otp_A_ITar['t_start'];
			$Defend_War['t_end'] = $Otp_A_ITar['t_end'];
			$Defend_War['a_org'] = $Otp_A_ITar['a_org'];
			$Defend_War['ticket_b'] = $Otp_A_ITar['ticket_b'];
		}else{
			$sql = ("SELECT `t_start`,`t_end`,`a_org`,`mission`,`ticket_b` FROM `".$GLOBALS['DBPrefix']."phpeb_user_war` WHERE `b_org` = '$Pl_Org[id]' AND `t_end` > '$CFU_Time' ORDER BY `t_start` ASC LIMIT 1");
			$query = mysql_query($sql);
			$Defend_War = mysql_fetch_array($query);
			$tmp = array();
			if(preg_match('/Atk<([0-9a-zA-Z]+)>/', $Defend_War['mission'], $tmp)){
				$Def_Area_Id = $tmp[1];
			}else{
				$Def_Area_Id = '';
			}
			unset($tmp);
		}
		if($Defend_War){
			$A_Org = ReturnOrg($Defend_War['a_org']);
			$Operation_Details .= "<font style=\"font-size: 10pt;color: white\">[內容] 區域防禦戰</font><br>殲滅 <font color=$Pl_Org[color]>".$Def_Area_Id."區域</font> 中的<font color=$A_Org[color]>$A_Org[name]</font>軍力";
			$Operation_Details .= "<br>或<br>防止 <font color=$Pl_Org[color]>".$Def_Area_Id."區域要塞</font>,<br>於戰爭結束前被攻陷";

			if($Def_Area_Id == $Player['coordinates'] && $Player['rights'] == '1' && $Defend_War['t_start'] > $CFU_Time && $Defend_War['ticket_b'] == 1)
				$Operation_Details .= "<br><b style=\"cursor: pointer\" onmouseover=\"this.style.color='yellow'\" onmouseout=\"this.style.color='white'\" onClick=\"SetiFT('\'調動兵力迎擊\'');act.action='city.php?action=Reinforcement';act.actionb.value='C';act.target='$SecTarget';act.submit();\"><u>調動兵力迎擊</u></b>";

			$Operation_Details .= "</td></tr><tr height=109 style=\"padding-left: 10px;padding-top: 3px\" valign=top><td style=\"background-image: url('$General_Image_Dir/neo/rt_tab_bg.jpg');\" colspan=3 width=200>";
			$StartAtk = preg_replace('/星期(.*), /','星期\\1<br>',cfu_time_convert($Defend_War['t_start']));
			$TimeEnd = preg_replace('/星期(.*), /','星期\\1<br>',cfu_time_convert($Defend_War['t_end']));
			$Operation_Details .=  "<font style=\"font-size: 10pt;color: white\">[開始時間]</font><br> $StartAtk <br><font style=\"font-size: 10pt;color: white\">[完結時間]</font><br> $TimeEnd ";
			$Tickets = $Defend_War['ticket_b'];
		}
	}
	
    if ($Pl_Org['opttime'] > $CFU_Time && $Pl_Org['optmissioni']) {
        echo '<p><span style="font-weight: 700; font-size: 10pt; background-color:  '.$Pl_Org['color'].'"> <b>出擊通知書 - 組織有任務交給您了</b></span><br>';
        echo "<font style=\"font-size: 10pt;color: white\">[任務]</font><font style=\"font-size: 8pt;\">行動代號: $Pl_Org[operation]<br>";
        if (preg_match('/Atk<([0-9a-zA-Z]+)>/',$Pl_Mission['mission'])) {
            $Pl_Show_Mission = ereg_replace('(Atk=\()|\)', '', $Pl_Org['optmissioni']);

            if($Opt_Area["User"]["occupied"] == $Area["User"]["occupied"])	$Opt_Org = $AreaOrg;
			elseif($Opt_Area["User"]["occupied"] == $Player['organization'])$Opt_Org = $Pl_Org;
			else $Opt_Org = ReturnOrg($Opt_Area["User"]["occupied"]);
			
            echo "<font style=\"font-size: 10pt;color: white\">[內容]</font>攻擊屬於 <font color=$Opt_Org[color]>$Opt_Org[name]</font> 統治下的",$Opt_Area['Sys']['map_id'],'區域';
            $StartAtk = preg_replace('/星期(.*), /','星期\\1<br>',cfu_time_convert($Defend_War['t_start']));
			$TimeEnd = preg_replace('/星期(.*), /','星期\\1<br>',cfu_time_convert($Defend_War['t_end']));
            echo "<br><font style=\"font-size: 10pt;color: white\">[開始時間]</font> $StartAtk <br><font style=\"font-size: 10pt;color: white\">[完結時間]</font> $TimeEnd ";
        }
        echo '</font>';
    }
    if ($LogEntries && $Pl_Settings['show_log_num']) {
        if ($Pl_Settings['show_log_num'] > $LogEntries) {
            $Pl_LEnt = $LogEntries;
        } else {
    $Pl_LEnt = $Pl_Settings['show_log_num'];
}
echo '<script language="JavaScript">';
echo "function showlog(){logspc.style.visibility='visible';logspc.style.position='relative';logbtn.innerText='[X]';logbtn.href=\"Javascript:hidelog();\"}";
echo "function hidelog(){logspc.style.visibility='hidden';logspc.style.position='absolute';logbtn.innerText='[+]';logbtn.href=\"Javascript:showlog();\"}";
echo '</script>';
echo '<p><span style="font-weight: 700; font-size: 10pt; background-color:  '.$Player['color'].'"> <b>歷程紀錄</b> <a href="Javascript:showlog();" id=logbtn style="text-decoration: none">[+]</a></span><br><div id=logspc style="font-size: 8pt;position: absolute;visibility: hidden">';
$User_Log = GetUsrLog($user) or die('無法取得紀錄資訊！！<br>請聯絡管理員！');
for ($LogShowNum = 1;$LogShowNum <= $Pl_LEnt;++$LogShowNum) {
    $i = 'time'.$LogShowNum;
    $j = 'log'.$LogShowNum;
    if ($User_Log[$i]) {
        echo cfu_time_convert($User_Log[$i])."<br>$User_Log[$j]<br>";
    }
    unset($i, $j);
}
    }

    echo '</div></td></tr>';
    echo '</table>';
    echo '</td>';
    echo '</tr>';
    echo '<script language="JavaScript">',
'setTimeout("enablerf();",2000);',
'function enablerf(){',
        'act.ig_refresh.disabled=false;',
        '}',
'</script>';

    echo '<form action=nil method=post name=act target=Beta>';
    echo '<tr>';
    echo '<td width="100%" height="11">';
    echo "<input type=hidden value='none' name=actionb>";
	echo "<input type=hidden value='old' name='version'>";
    echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
    echo "<input style=\"$BStyleA\" $BStyleB type=button value='戰鬥' onClick=\"act.action='battle.php?action=battle_sel';actionb.value='A';act.target='Beta';act.submit();\">";
    echo "<input style=\"$BStyleA\" $BStyleB type=button value='移動' onClick=\"act.action='map.php?action=Move';actionb.value='A';act.target='Beta';act.submit();\">";
    if ($Player['rights'] == '1' && $atkMissionFlag == 1 && $Pl_Mission['victory'] == 1) {
        echo "<input style=\"$BStyleA\" $BStyleB type=button value='佔領' onClick=\"act.action='organization.php?action=TakeCity';actionb.value='A';act.target='Beta';act.submit();\">";
    }
	if ($Player['rights'] == '1' && $atkMissionFlag == 1) {
		echo "<input style=\"$BStyleA\" $BStyleB type=button value='放棄佔領' onClick=\"act.action='organization.php?action=GiveUp';actionb.value='A';act.target='Beta';act.submit();\">";
	}	
    echo "　<input style=\"$BStyleA\" $BStyleB type=button value='裝備' onClick=\"act.action='equip.php?action=equip';act.target='Beta';act.submit();\">";
    echo "<input style=\"$BStyleA\" $BStyleB type=button value='機體生產' onClick=\"act.action='equip.php?action=buyms';act.actionb.value='buyms';act.target='Beta';act.submit();\">";
    echo "<input style=\"$BStyleA\" $BStyleB type=button value='機體改造' onClick=\"act.action='statsmod.php?action=modms';act.actionb.value='buyms';act.target='Beta';act.submit();\">";
    echo "<input style=\"$BStyleA\" $BStyleB type=button value='兵器製造' onClick=\"act.action='tactfactory.php?action=main';act.actionb.value='none';act.target='Beta';act.submit();\">";
    echo "<input style=\"$BStyleA\" $BStyleB type=button value='修理工場' onClick=\"act.action='statsmod.php?action=repairms';act.actionb.value='sel';act.target='Beta';act.submit();\">";
    echo "　<input style=\"$BStyleA\" $BStyleB type=button value='戰術學院' onClick=\"act.action='tacticslearn.php?action=main';act.actionb.value='none';act.target='Beta';act.submit();\">";
	echo "　<input style=\"$BStyleA\" $BStyleB type=button value='原料採集' onClick=\"act.action='plugins/mining/mining.php';act.actionb.value='none';act.target='Beta';act.submit();\">";
    echo "<input style=\"$BStyleA\" $BStyleB type=button value='倉庫' onClick=\"act.action='warehouse.php?action=selection';act.actionb.value='none';act.target='Beta';act.submit();\">";
    echo "<input style=\"$BStyleA\" $BStyleB type=button value='銀行' onClick=\"act.action='bank.php?action=main';act.actionb.value='none';act.target='Beta';act.submit();\">";
    echo "<input style=\"$BStyleA\" $BStyleB type=button value='商場' onClick=\"act.action='market.php?action=main';act.actionb.value='none';act.target='Beta';act.submit();\">";
	echo "　<input style=\"$BStyleA\" $BStyleB type=button value='情報' onClick=\"act.action='information.php?action=Main';act.actionb.value='';act.target='Beta';act.submit();\">";
    echo "<input style=\"$BStyleA\" $BStyleB type=button value='排名' onClick=\"act.action='gen_info.php?action=ranks';act.actionb.value='none';act.target='Beta';act.submit();\">";
	echo "　<input style=\"$BStyleA\" $BStyleB type=button value='特殊' onClick=\"act.action='scommand.php?action=main';act.actionb.value='none';act.target='Beta';act.submit();\">";
	if ($Player['acc_status'] == '9') {
		echo "　<input style=\"$BStyleA\" $BStyleB type=button value='舊管理中心' onClick=\"act.action='admin.php?action=panel';actionb.value='A';act.target='Beta';act.submit();\">";
		echo "<input style=\"$BStyleA\" $BStyleB type=button value='新管理中心' onClick=\"act.action='manager.php';actionb.value='A';act.target='Beta';act.submit();\">";
	}
    echo "　<input style=\"$BStyleA\" $BStyleB type=button name=ig_refresh value='重新整理' disabled onClick=\"act.action='gmscrn_old.php?action=proc';act.target='Alpha';act.submit();\">";
	echo "　<input style=\"$BStyleA\" $BStyleB type=button name=chat value='聊天' onClick=\"window.open('','$CFU_Time','resizable=1,width=800,height=600');act.action='chat.php';act.target='$CFU_Time';act.submit();\">";
	echo "<input style=\"$BStyleA\" $BStyleB type=button name=forum value='討論區' onClick=\"window.open('http://ext4.me/forum.php');\">";
	echo "　<input style=\"$BStyleA\" $BStyleB type=button name=forum value='切換至新介面' onClick=\"window.location.replace('gmscrn_main.php?action=proc');\">";
    echo "　<input style=\"$BStyleA\" $BStyleB type=button value='退出' onClick=\"location.replace('logout.php');\">";
    echo '</td>';
    echo '</tr></form>';
    echo '</table>';

    echo '<table>';
    echo '<tr><td align=center style="filter: chroma(color: black)">';
    echo '<script language="JavaScript">';
    echo "if (screen.availWidth < 1024){document.write('<iframe name=\'Beta\' src=\'gen_info.php\' width=\'800\' height=\'600\' marginheight=0 marginwidth=0 frameborder=0>');} else{";
    echo "document.write('<iframe name=\'Beta\' src=\'gen_info.php\' width=\'1277\' height=\'600\' marginheight=0 marginwidth=0 frameborder=0>');}";
    echo '</script>';
    echo '</td></tr>';
    echo '</table>';
    echo '<table height=100% valign=bottom>';
    postFooter();
    echo '</table>';
    echo '</body>';
    echo '</html>';
	
	if($Use_Behavior_Checker){
		include_once('includes/behavior_checker.class.php');
		$BChecker = new BehaviorChecker($Pl, $GLOBALS['Btl_Intv'], 0, $GLOBALS['Offline_Time'], $GLOBALS['CFU_Time'], $GLOBALS['DBPrefix']);
		$BChecker->checkInsomnia();
	}
	
    exit;
}

        echo '<br><br><br>Undefined Action';postFooter();
