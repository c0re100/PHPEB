<?php
// Turn this on (set to true) or delete this file when not using!!
// ���ϥή�, �O�o�]�w���uTrue�v �� �R���o���ɮ�!!
$UseAuth = true;
// Initialize Organizations
include('../../cfu.php');
postHead('','../../phpeb_session_dir');

$mode = ( isset($_POST['action']) ) ? $_POST['action'] : '';

//
// Login and authentications
//

if($UseAuth){

	if(!$mode){
	
		echo "<form action=initOrganization.php method=post name=main>";
		echo "<input type=hidden value='login' name=action>";
		echo "Username: <input type=text value='' name=Pl_Value[USERNAME]>";
		echo "Password: <input type=password value='' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
		echo "<input type=submit value='Login'>";
		echo "</form>";
		
		exit;
	
	}

	AuthUser($Pl_Value['USERNAME'],$Pl_Value['PASSWORD']);
	GetUsrDetails("$Pl_Value[USERNAME]",'Gen','Game');
		
	if($Gen['acc_status'] >= 0){
		
		echo "�S���v���s���C<br>�p�z�O�޲z��, �Х��]�w�޲z�������C<BR>";
		postFooter();
		exit;
	
	}

}
//
// Start Program
//

if($mode == 'process'){
	
	$sql = "SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_map`";
	$query = mysql_query($sql);
	$Usr = array();
	while($User = mysql_fetch_array($query)){
		$Usr[$User['map_id']] = $User;
	}
	
	$sql = "SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_sys_map`";
	$query = mysql_query($sql);
	$Sys = array();
	while($System = mysql_fetch_array($query)){
		$Sys[$System['map_id']] = $System;
	}
	
	foreach($Usr as &$u){
		
		$mid = $u['map_id'];
	
		$u['occupied'] = 0;
		$coord = $Sys[$mid]['area'];
		$pos = '';
		$lastChar = substr($u['map_id'],-1,1);
		switch($lastChar){
			case 'N': $pos = "�_"; break;
			case 'E': $pos = "�F"; break;
			case 'S': $pos = "�n"; break;
			case 'W': $pos = "��"; break;
			default: $pos = $lastChar;
		}
		$u['aname'] = "{$coord}�ϰ� - {$pos}��"; 
		$u['development'] = 0;
		$u['hp'] = $Sys[$mid]['hpmax'];
		$u['hpmax'] = $Sys[$mid]['hpmax'];
		$u['at'] = $Sys[$mid]['at'];
		$u['de'] = $Sys[$mid]['de'];
		$u['ta'] = $Sys[$mid]['ta'];
		switch($Sys[$mid]['type']){
			case 0: $u['wepa'] = 'FortWepE'; break;
			case 3: $u['wepa'] = 'FortWepS'; break;
			case 4: $u['wepa'] = 'FortWepC'; break;
			case 5: $u['wepa'] = 'FortWepM'; break;
			default: $u['wepa'] = '';
		}
		$u['spec'] = '';
		$u['defenders'] = '';
		$u['tickets'] = 0;
		
		$sql = "UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_map` SET ";
		$sql .= " `occupied` = '$u[occupied]', `aname` = '$u[aname]', `development` = '$u[development]',";
		$sql .= " `hp` = '$u[hp]', `hpmax` = '$u[hpmax]', `at` = '$u[at]', `de` = '$u[de]', `ta` = '$u[ta]',";
		$sql .= " `wepa` = '$u[wepa]', `spec` = '$u[spec]', `defenders` = '$u[defenders]', `tickets` = '$u[tickets]' ";
		$sql .= " WHERE `map_id` = '$mid' ;";
		$query = mysql_query($sql) or die(mysql_error().'<br>SQL: '.$sql);
		echo "SQL: $sql <br>";

	}
	
	echo "<hr>";

}
	
echo "<form action=initOrganization.php method=post name=main>";
echo "<input type=hidden value='process' name=action>";;
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

echo "<input type=submit value='Initialize'>";
	
echo "</form>";

postFooter();

?>