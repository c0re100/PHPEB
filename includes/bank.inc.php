<?php
//-------------------------//-------------------------//-------------------------//
//--------------------------   Banking System Include   -------------------------//
//-------------------  php-eb Ultimate Edition Version v1.0  --------------------//
//---------------------------   Official Open Build    --------------------------//
//-------------------------//-------------------------//-------------------------//

// Functions for bank.php, Banking System
// Created: 2010/01/12 4:18am
// Last Modified: 2010/01/12

//
// Mining System Plugin Functions - Need to include mining.config.php before use
//

// Plugin Mining System Function - Print Raw Material requirement list
function printRawReq($Str,$Msg){
	global $product_id_list;

	$Raw = getRaw($Str);

	if($Raw[0] == 0) return;

	echo $Msg;
	echo "<div style='width: 100%'><table align=left>";

	$i = 0;
	foreach($product_id_list As $p_id => $p_name){
		if($Raw[$p_id] == 0) continue;
		if($i == 0) echo '<tr>';
		echo "<td align=right width=60>$p_name:&nbsp;</td><td width=40>$Raw[$p_id] ��</td>";
		if($i == 1){
			echo '</tr>';
			$i = 0;
		}
		else $i++;
	}
	echo "</table></div>";

}

// Plugin Mining System Function - Print Product Textbox Table
function printProductTable($elmName){
	global $product_id_list;

	echo "<table align=center>";
	echo "<tr align=center style='font-weight: Bold'><td>���</td><td>�ƶq</td><td>���</td><td>�ƶq</td></tr>";

	$i = 0;
	foreach($product_id_list As $p_id => $p_name){
		if($i == 0) echo '<tr>';
		echo "<td align=right>$p_name</td><td><input type=text name=".$elmName.'['.$p_id.'] maxlength=3 size=4 value=0 onclick="this.value=\'\'" onchange="this.value=parseInt(this.value)"></td>';
		if($i == 1){
			echo '</tr>';
			$i = 0;
		}
		else $i++;
	}
	echo "</table>";

}

//
// Refactored Functions
//

function getInbox($sh,$sh_slot){

	$SafeIN = explode('<#>',$sh);
	$SafeIN_Wep = explode('<!>',$SafeIN[2]);

	$sql = ("SELECT `gamename`,`name`,`atk`,`hit`,`rd`,`enc`,`w`.`spec`,`equip` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` `g`,`".$GLOBALS['DBPrefix']."phpeb_sys_wep` `w` WHERE `username`='". $SafeIN[0] ."' AND `id` = '". $SafeIN_Wep[0] ."'");
	$query = mysql_query($sql) or die ('�L�k���o�C����T, ��]:' . mysql_error() . '<br>');
	$SafeIN_Dealer = mysql_fetch_array($query);
		if ($SafeIN_Wep[2]){
			if ($SafeIN_Wep[2]==1) $SafeIN_Dealer['name'] = $SafeIN_Wep[3].$SafeIN_Dealer['name']."<sub>&copy;</sub>";
			else $SafeIN_Dealer['name'] = $SafeIN_Dealer['name'].$SafeIN_Wep[3]."<sub>&copy;</sub>";
			$SafeIN_Dealer['atk'] += $SafeIN_Wep[4];
			$SafeIN_Dealer['hit'] += $SafeIN_Wep[5];
			$SafeIN_Dealer['rd'] += $SafeIN_Wep[6];
			$SafeIN_Dealer['enc'] = $SafeIN_Wep[7];
		}
	if ($SafeIN_Wep[1] > 0) $SafeIN_Wep['displayXp'] = '+'.($SafeIN_Wep[1]/100).'%';
	elseif ($SafeIN_Wep[1] < 0) $SafeIN_Wep['displayXp'] = ($SafeIN_Wep[1]/100).'%';
	else $SafeIN_Wep['displayXp'] = '��0%';
	echo "��a: $SafeIN_Dealer[gamename]<br>�X��: ".number_format($SafeIN[1]);
	
	printRawReq($SafeIN[5],'<br>��� - �z�ݤ�I:<br>');
	printRawReq($SafeIN[4],'<br>��� - ��a��I:<br>');
	
	if($SafeIN_Wep[0]){
		echo "<br>�˳�: $SafeIN_Dealer[name]<br>���A��: $SafeIN_Wep[displayXp]<br>��O: <br>";
		echo "�@�����O: $SafeIN_Dealer[atk]�@�@�@�^��: $SafeIN_Dealer[rd]<br>�@�R��: $SafeIN_Dealer[hit]�@�@�@EN���O: $SafeIN_Dealer[enc]<br>";
		$D_Specs = ReturnSpecs($SafeIN_Dealer['spec']);
		echo "�S��ĪG:";
		if ($SafeIN_Dealer['equip']) echo "�i�H�˳�<br>";
		if ($SafeIN_Dealer['spec']) echo $D_Specs;
		elseif(!$SafeIN_Dealer['spec'] && !$SafeIN_Dealer['equip']) echo "�S������S��ĪG<br>";
	}
	else{
		echo "<br>������S���A�ΪZ�˥���C<br>";
	}

	echo "<input type=submit $disableOnFull onClick=\"return ConfirmDeal('$sh_slot')\" value=�T�{���>";
	echo "<input type=submit onClick=\"return RejectDeal('$sh_slot')\" value=�ڵ����>";

}
function getOutbox($sh,$sh_slot,$user){

	$SafeOUT = explode('<#>',$sh);
	$SafeOUT_Wep = explode('<!>',$SafeOUT[2]);

	$sql = "SELECT `gamename`,`name`,`atk`,`hit`,`rd`,`enc`,`w`.`spec` AS `spec`, `equip`, `$SafeOUT[3]` AS `inbox` ";
	$sql .= " FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` `g`, `".$GLOBALS['DBPrefix']."phpeb_sys_wep` `w`, `".$GLOBALS['DBPrefix']."phpeb_user_bank` `b` ";
	$sql .= " WHERE `g`.`username`='". $SafeOUT[0] ."' AND `id` = '". $SafeOUT_Wep[0] ."' AND `b`.`username` = `g`.`username`; ";
	$query = mysql_query($sql) or die ('�L�k���o�C����T, ��]:' . mysql_error() . '<br>');
	$SafeOUT_Dealer = mysql_fetch_array($query);
		if (isset($SafeOUT_Wep[2])){
			if ($SafeOUT_Wep[2]==1) $SafeOUT_Dealer['name'] = $SafeOUT_Wep[3].$SafeOUT_Dealer['name']."<sub>&copy;</sub>";
			else $SafeOUT_Dealer['name'] = $SafeOUT_Dealer['name'].$SafeOUT_Wep[3]."<sub>&copy;</sub>";
			$SafeOUT_Dealer['atk'] += $SafeOUT_Wep[4];
			$SafeOUT_Dealer['hit'] += $SafeOUT_Wep[5];
			$SafeOUT_Dealer['rd'] += $SafeOUT_Wep[6];
			$SafeOUT_Dealer['enc'] = $SafeOUT_Wep[7];
		}
	if ($SafeOUT_Wep[1] > 0) $SafeOUT_Wep['displayXp'] = '+'.($SafeOUT_Wep[1]/100).'%';
	elseif ($SafeOUT_Wep[1] < 0) $SafeOUT_Wep['displayXp'] = ($SafeOUT_Wep[1]/100).'%';
	else $SafeOUT_Wep['displayXp'] = '��0%';
	echo "�ؼжR�a: $SafeOUT_Dealer[gamename]<br>���: ".number_format($SafeOUT[1]);

	printRawReq($SafeOUT[4],'<br>��� - �z�N��I:<br>');
	printRawReq($SafeOUT[5],'<br>��� - ����I:<br>');

	if($SafeOUT_Wep[0]){
		echo "<br>�˳�: $SafeOUT_Dealer[name]<br>���A��: $SafeOUT_Wep[displayXp]<br>��O: <br>";
		echo "�@�����O: $SafeOUT_Dealer[atk]�@�@�@�^��: $SafeOUT_Dealer[rd]<br>�@�R��: $SafeOUT_Dealer[hit]�@�@�@EN���O: $SafeOUT_Dealer[enc]<br>";
		$D_Specs = ReturnSpecs($SafeOUT_Dealer['spec']);
		echo "�S��ĪG:";
		if ($SafeOUT_Dealer['equip']) echo "�i�H�˳�<br>";
		if ($SafeOUT_Dealer['spec']) echo $D_Specs;
		else echo "�S������S��ĪG<br>";
	}
	else{
		echo "<br>������S���A�ΪZ�˥���C<br>";
	}

	echo "<input type=submit $disableOnFull onClick=\"return CancelDeal('$sh_slot')\" value=������>";
	$RejectedFlag = false;
	if(!$SafeOUT_Dealer['inbox']) $RejectedFlag = true;
	else{
		$DealerIN = explode('<#>',$SafeOUT_Dealer['inbox']);
		if($DealerIN[0] != $user) $RejectedFlag = true;
		else{
			for($i = 1; $i < count($DealerIN); $i++){
				if($i == 3) continue;
				if($DealerIN[$i] != $SafeOUT[$i]){
					$RejectedFlag = true;
					break;
				}
			}
		}
	}
	if($RejectedFlag) echo "&nbsp;&nbsp;(���v�ڵ��F���)";

}

//Get Safehouse item (Weapon/Equipment) name, inc. customed name
function getSHWepName($Wep){
	$sql = "SELECT `name` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` WHERE `id` = '$Wep[0]' LIMIT 1;";
	$query = mysql_query($sql);
	$WepS = mysql_fetch_array($query);
	if (isset($Wep[2])){
		if ($Wep[2]==1) $WepS['name'] = $Wep[3].$WepS['name']."<sub>&copy;</sub>";
		else $WepS['name'] = $WepS['name'].$Wep[3]."<sub>&copy;</sub>";
	}
	return $WepS['name'];
}

?>