<?php
//-------------------------//-------------------------//-------------------------//
//----------------------------   Core Function Unit   ---------------------------//
//----------------------------   phpeb Version 0.50   ---------------------------//
//---------------------------   Release Candidate 1    --------------------------//
//-------------------------//-------------------------//-------------------------//
//_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_//
//Detection of Process Time                             //                       //
global $gmcfu_time, $cfu_stime;                         //    �o�����L�ݳ]�w.    //
$gmcfu_time = explode(' ', microtime());                //    �ק�e�Фp��,      //
$cfu_stime = $gmcfu_time[1] + $gmcfu_time[0];           //    �]�����~�����,    //
if (!ini_get('register_globals'))                       //    �i��|�Ͼ�ӵ{��,  //
{extract($_POST);extract($_GET);extract($_SERVER);      //    �L�k���`�B�@!      //
if (isset($_SESSION)){extract($_SESSION);}}             //                       //
error_reporting(0);  //�����������~�^��: PHP5 ��ĳ�ﶵ  //                       //
//-------------------------//-------------------------//-------------------------//
//Configs - �C���Ψt�γ]�w

//������T
global $cSpec, $vBdNum;
$cSpec = '0.50';                                         //�����W��
$vBdNum = 'RC1';                                         //�׭q����

include('config.php');

//Anti Unauthorized Connection Settings
$disabled_AUC = 1;                  //����s�s�t�Ϊ��L�ĤưѼ�: 0���}�Ҩ���s�s�t��, 1�O��������s�s�t��
$AUC_Log = "unauthorizedlog.php";   //����s�s�t�Ϊ������ɦW��, ��ĳ�ϥΡu.php�v����

$Allow_AUC = "/(vsqa.no\-ip.com|v2alliance.net|php-eb.v2alliance.net)+/";
//�������`�s�u��m
//�Ш� index2.php �ק� $HTTP_REFERER �Ѽ�
//�HRegular Expression��F, �@���u(�v�P�u)+�v������Jphp-eb���ؿ���m�K�i
//�p:	(vsqa.no\-ip.com)+
//	(dai\-ngai.net)+
//	(phpebs.frwonline.com)+
//
//�p�Q�h��@�Ӧa��, �Цp����J:
//	(vsqa.no\-ip.com|dai\-ngai.net|phpebs.frwonline.com)+
//�b���}�Υؿ������[�u|�v�K�i�H
//�Цb�u-�v�e�[�J�u\�v, �_�h�|�X��
//_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_//
/*
Account Status:
-1: Administrator
0: Normal
1: Quarantine	// Not in Use
2: Lock
*/
//_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_//


//End of Configurations

//Connect

if(empty($NoConnect)){
mysql_connect ($GLOBALS['DBHost'], $GLOBALS['DBUser'], $GLOBALS['DBPass']) or die ('Could not access database because: ' . mysql_error());
if(mysql_get_server_info() > '4.1') {
	global $charset;
	$charset = 'big5'; //���A����r�չ� - �c�骩 php-eb �L�ݧ��
	if(!$dbcharset && in_array(strtolower($charset), array('gbk', 'big5', 'utf-8'))) {
		$dbcharset = str_replace('-', '', $charset);
	}
	if($dbcharset) {
		mysql_query("SET NAMES '$dbcharset'");
	}
}
if(mysql_get_server_info() > '5.0.1') {
	mysql_query("SET sql_mode=''");
}

//-------------------------//
//--------Select DB--------//
//-------------------------//

mysql_select_db ($GLOBALS['DBName']);
}
//_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_//

global $ConvColors;
$ConvColors=array(
	"#FFFF00","#FFFF78",
	"#FF0000","#FF2828","#FF5050",
	"#FFBF00","#FFCE3C","#FFDD78",
	"#00FF00","#3CFF3C","#78FF78",
	"#0000FF","#3C3CFF","#7878FF",
	"#FF3CFF","#FF00FF","#E100E1",
	"#FF3CAE","#FF0095","#E10083");

global $ConvGrades;
$ConvGrades=array(
	"ACE",	"S",
	"A+",	"A",	"A-",
	"B+",	"B",	"B-",
	"C+",	"C",	"C-",
	"D+",	"D",	"D-",
	"E+",	"E",	"E-",
	"F+",	"F",	"F-");

global $MainColors;
$MainColors = array(                                            //Rainbow Swatches By v2Alliance Gary
	"FF5050", "FF2828", "FF0000", "E10000", "C30000", "A50000",   //Red
	"FFDD78", "FFCE3C", "FFBF00", "EBB000", "D7A100", "C39200",   //Orange
	"FFFF78", "FFFF3C", "FFFF00", "EBEB00", "D7D700", "C3C300",   //Yellow
	"78FF78", "3CFF3C", "00FF00", "00E100", "00C300", "00A500",   //Green
	"78FFD2", "3CFFBE", "00FFAA", "00E196", "00C382", "00A56E",   //Light Green
	"78DDFF", "3CCEFF", "00BFFF", "00A9E1", "0092C3", "007CA5",   //Light Blue
	"7878FF", "3C3CFF", "0000FF", "0000E1", "0000C3", "0000A5",   //Blue
	"D278FF", "BE3CFF", "AA00FF", "9600E1", "8200C3", "6E00A5",   //Purple
	"FF78FF", "FF3CFF", "FF00FF", "E100E1", "C300C3", "A500A5",   //Indigo
	"FF78C7", "FF3CAE", "FF0095", "E10083", "C30072", "A50060",   //Violet
);

global $MainRanks;
$MainRanks = array(
'���@�L','�G���L','�@���L','�W���L','�L��','���',
'�x��','�U�h','���h','�W�h','���',
'��L','�ֱL','���L','�W�L',
'�֮�','����','�W��',
'��N','�ֱN','���N','�W�N','�@�ŤW�N',
'����','�`�q�O');

global $RightsClass;
$RightsClass = array("Major" => '�D�u',"Leader" => '�ƥD�u');

global $CFU_Time;
$CFU_Time = time() + $Time_Fix;
//Start Time Convert Function
function cfu_time_convert($The_Time){
	$DateTime = getdate($The_Time);
	switch($DateTime['wday']){
		case 0: $DateTime['wday']='��';break;
		case 1: $DateTime['wday']='�@';break;case 2: $DateTime['wday']='�G';break;
		case 3: $DateTime['wday']='�T';break;case 4: $DateTime['wday']='�|';break;
		case 5: $DateTime['wday']='��';break;case 6: $DateTime['wday']='��';break;
	}
	if (strlen($DateTime['minutes']) == 1){$DateTime['minutes']='0'.$DateTime['minutes'];}
	if (strlen($DateTime['seconds']) == 1){$DateTime['seconds']='0'.$DateTime['seconds'];}
	if($DateTime['hours'] > 12){$DateTime['period'] = '�U��';$DateTime['hours']-=12;}
	elseif($DateTime['hours'] == 12){$DateTime['period'] = '����';}
	elseif($DateTime['hours'] == 0){$DateTime['period'] = '�s��';}
	else $DateTime['period'] = '�W��';
	if($DateTime['hours'] == 0){$DateTime['hours']=12;}
	$FormatDate = "$DateTime[year]�~$DateTime[mon]��$DateTime[mday]��, �P��$DateTime[wday], $DateTime[period] $DateTime[hours]:$DateTime[minutes]:$DateTime[seconds]";
	return $FormatDate;
}
//End Time Convert Function
global $CFU_Date;
$CFU_Date = cfu_time_convert($CFU_Time); //convert the present time

//Anti-Unauthorized Connection
if (!$disabled_AUC) include("includes/auc.inc.php");

//_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_//

//Update Time
$CFU_TIME_USER = 0;
if (isset($session_un)) $CFU_TIME_USER = "$session_un";
elseif (isset($Pl_Value['USERNAME']))$CFU_TIME_USER="$Pl_Value[USERNAME]";
if ($CFU_TIME_USER){
	$CFU_Time_UpDate_Q = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `time2` = '$CFU_Time' WHERE `username` = '$CFU_TIME_USER' LIMIT 1;");
	mysql_query($CFU_Time_UpDate_Q);
}
//End of Time Updating


//Start Primary Functions
function postFooter(){
	$mcfu_time = explode(' ', microtime());
	$cfu_ptime = number_format(($mcfu_time[1] + $mcfu_time[0] - $GLOBALS['cfu_stime']), 6);
	echo "<p align=center style=\"font-size: 10pt\">&copy; 2005-2010 v2Alliance. All Rights Reserved.�@���v�Ҧ� ���o���<br>";
	if ($GLOBALS['Show_ptime'])
	echo "<font style=\"font-size: 7pt\">Processed in ".$cfu_ptime." second(s).</font></p>";
}
function postHead($withoutbody='',$session_dir='phpeb_session_dir',$additionalHeadings=''){
		// Date in the past
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		// always modified
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
 		// HTTP/1.1
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		// HTTP/1.0
		header("Pragma: no-cache");
		session_name("php-eb_Session");
		session_set_cookie_params(0,mktime(0,0,0,12,31,2015),"/","php-eb_Gen_Session_lv89ina");
		session_save_path($session_dir);
		session_start();
		session_register("session_un");
		session_register("session_pwd");
		session_destroy();
		echo "<html>";
		echo "<head>";
		echo "<meta http-equiv=\"Pragma\" content=\"no-cache\">";
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=big5\">";
		echo "<title>Endless Battle ~ php-eb - &copy; 2005-2010 v2Alliance</title>";
		echo "<style type=\"text/css\">BODY {FONT-SIZE: 10px; FONT-FAMILY: \"Arial\",  \"�s�ө���\"; cursor:default}TD {FONT-SIZE: 9pt; FONT-FAMILY: \"Arial\", \"�s�ө���\"}A:visited {COLOR: #FFFFFF;}</style>";
		echo $additionalHeadings;
		echo "</head>";
		if (!$withoutbody) echo "<body bgcolor=\"#000000\" text=#dcdcdc link=#dcdcdc style=\"margin:0px 0px 0px 0px;\" oncontextmenu=\"return true;\">";
}
function AuthUser($U,$P){
		$sql_ugnrli = ("SELECT username, password, acc_status FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` WHERE username='". $U ."'");
		$UsrGenrl_Qr = mysql_query ($sql_ugnrli) or die ('���~�I<br>����s����SQL��Ʈw(PHPEB_ERROR: 001)'.$GLOBALS['DBPrefix'].':' . mysql_error());
		$UsrGenrl = mysql_fetch_array($UsrGenrl_Qr);
		if (!$UsrGenrl['username'] || ($UsrGenrl['password'] != md5($P) && $UsrGenrl['password'] != $P) || $UsrGenrl['username'] != $U){
		echo "<center><br><br>�ϥΪ̦W�٩αK�X���~�C<br><br><a href=\"index2.php\" target='_top' style=\"text-decoration: none\">�^�쭺��</a>";
		postFooter();
		exit;}
		if ($UsrGenrl['acc_status'] == 2){
		echo "<center><br><br>�b���Q��A�лP�޲z���p���I<br><br><a href=\"index2.php\" target='_top' style=\"text-decoration: none\">�^�쭺��</a>";
		postFooter();
		exit;}
}
function ReturnSpecs($Specs){$SpecsTag='';
if (!$Specs)$SpecsTag='�S��';
else{
//Weapon Specs
if( strpos($Specs,'DamA') !== false ) $SpecsTag .='����l�a<br>';
if( strpos($Specs,'DamB') !== false ) $SpecsTag .='�԰�����<br>';
if( strpos($Specs,'Mob') !== false ){
	if( strpos($Specs,'MobA') !== false ) $SpecsTag .='�[�t<br>';
	if( strpos($Specs,'MobB') !== false ) $SpecsTag .='�W�e<br>';
	if( strpos($Specs,'MobC') !== false ) $SpecsTag .='�{��<br>';
	if( strpos($Specs,'MobD') !== false ) $SpecsTag .='�k��<br>';
	if( strpos($Specs,'Moba') !== false ) $SpecsTag .='²����i<br>';
	if( strpos($Specs,'Mobb') !== false ) $SpecsTag .='�j�O���i<br>';
	if( strpos($Specs,'Mobc') !== false ) $SpecsTag .='�̨ΤƱ��i<br>';
	if( strpos($Specs,'Mobd') !== false ) $SpecsTag .='���ű��i<br>';
	if( strpos($Specs,'Mobe') !== false ) $SpecsTag .='���ű��i<br>';
}
if( strpos($Specs,'Tar') !== false ){
	if( strpos($Specs,'TarA') !== false ) $SpecsTag .='�շ�<br>';
	if( strpos($Specs,'TarB') !== false ) $SpecsTag .='�˷�<br>';
	if( strpos($Specs,'TarC') !== false ) $SpecsTag .='����<br>';
	if( strpos($Specs,'TarD') !== false ) $SpecsTag .='�w��<br>';
	if( strpos($Specs,'Tara') !== false ) $SpecsTag .='�۰���w<br>';
	if( strpos($Specs,'Tarb') !== false ) $SpecsTag .='���Ůշ�<br>';
	if( strpos($Specs,'Tarc') !== false ) $SpecsTag .='�L�~�շ�<br>';
	if( strpos($Specs,'Tard') !== false ) $SpecsTag .='�h����w<br>';
	if( strpos($Specs,'Tare') !== false ) $SpecsTag .='������w<br>';
}
if( strpos($Specs,'Def') !== false ){
	if( strpos($Specs,'DefA') !== false ) $SpecsTag .='²�樾�m<br>';
	if( strpos($Specs,'DefB') !== false ) $SpecsTag .='���`���m<br>';
	if( strpos($Specs,'DefC') !== false ) $SpecsTag .='�j�ƨ��m<br>';
	if( strpos($Specs,'DefD') !== false ) $SpecsTag .='���Ũ��m<br>';
	if( strpos($Specs,'DefE') !== false ) $SpecsTag .='�̲ר��m<br>';
	if( strpos($Specs,'Defa') !== false ) $SpecsTag .='���<br>';
	if( strpos($Specs,'Defb') !== false ) $SpecsTag .='�ܿ�<br>';
	if( strpos($Specs,'Defc') !== false ) $SpecsTag .='�z�A<br>';
	if( strpos($Specs,'Defd') !== false ) $SpecsTag .='���<br>';
	if( strpos($Specs,'Defe') !== false ) $SpecsTag .='�Ŷ��۹�첾<br>';
	if( strpos($Specs,'PerfDef') !== false ) $SpecsTag .='�������m<br>';
}
if( strpos($Specs,'Pv') !== false ){
	if( strpos($Specs,'PvPhy') !== false ){
		if( strpos($Specs,'PvPhyA') !== false ) $SpecsTag .='�p��<br>';
		if( strpos($Specs,'PvPhyB') !== false ) $SpecsTag .='�ܽ���<br>';
		if( strpos($Specs,'PvPhyC') !== false ) $SpecsTag .='�u�}<br>';
		if( strpos($Specs,'PvPhyD') !== false ) $SpecsTag .='Phase Shift<br>';
		if( strpos($Specs,'PvPhyE') !== false ) $SpecsTag .='V. P. S.<br>';
	}
	if( strpos($Specs,'PvBeam') !== false ){
		if( strpos($Specs,'PvBeamA') !== false ) $SpecsTag .='�@��<br>';
		if( strpos($Specs,'PvBeamB') !== false ) $SpecsTag .='���ಾ<br>';
		if( strpos($Specs,'PvBeamC') !== false ) $SpecsTag .='�ᦱ<br>';
		if( strpos($Specs,'PvBeamD') !== false ) $SpecsTag .='��g<br>';
		if( strpos($Specs,'PvBeamE') !== false ) $SpecsTag .='����<br>';
	}
	if( strpos($Specs,'PvUni') !== false ){
		if( strpos($Specs,'PvUniA') !== false ) $SpecsTag .='���ʤz�Z<br>';
		if( strpos($Specs,'PvUniB') !== false ) $SpecsTag .='���O���a<br>';
		if( strpos($Specs,'PvUniC') !== false ) $SpecsTag .='�Ŷ��z�Z<br>';
		if( strpos($Specs,'PvUniD') !== false ) $SpecsTag .='�ɪ��Z��<br>';
		if( strpos($Specs,'PvUniE') !== false ) $SpecsTag .='�����s��<br>';
	}
}

if( strpos($Specs,'ShootDown') !== false ) $SpecsTag .='��u����<br>';
if( strpos($Specs,'DenseShot') !== false ) $SpecsTag .='�K���g��<br>';

if( strpos($Specs,'AntiDam')   !== false ) $SpecsTag .='�۰ʭ״_<br>';
if( strpos($Specs,'DoubleExp') !== false ) $SpecsTag .='�g������<br>';
if( strpos($Specs,'DoubleMon') !== false ) $SpecsTag .='��������<br>';
if( strpos($Specs,'DefX')      !== false ) $SpecsTag .='���O<br>';
if( strpos($Specs,'AtkA')      !== false ) $SpecsTag .='����<br>';
if( strpos($Specs,'MeltA')     !== false ) $SpecsTag .='������<br>';
if( strpos($Specs,'MeltB')     !== false ) $SpecsTag .='����<br>';
if( strpos($Specs,'Cease')     !== false ) $SpecsTag .='�T�D<br>';
if( strpos($Specs,'AntiPDef')  !== false ) $SpecsTag .='�e��<br>';
if( strpos($Specs,'Sniping')   !== false ) $SpecsTag .='����<br>';
if( strpos($Specs,'ChargeUp')  !== false ) $SpecsTag .='��q��R���n<br>';
if( strpos($Specs,'NTCustom')  !== false ) $SpecsTag .='�s�H���M��<br>';
if( strpos($Specs,'NTRequired')  !== false ) $SpecsTag .='�ݭn�s�H���O�q<br>';
if( strpos($Specs,'COCustom')    !== false ) $SpecsTag .='Coordinator�M��<br>';
if( strpos($Specs,'PsyRequired') !== false ) $SpecsTag .='���ʤO�M��<br>';
if( strpos($Specs,'SeedMode')   !== false ) $SpecsTag .='SEED Mode<br>';
if( strpos($Specs,'EXAMSystem') !== false ) $SpecsTag .='EXAM�t�αҰʥi��<br>';
// Specified Value Specs
if(preg_match('/CostSP<([0-9]+)>/',$Specs,$a))      $SpecsTag .= '����SP('.$a[1].')<br>';
if(preg_match('/CostEN<([0-9.]+)>/',$Specs,$a)){
	if($a[1] < 1) $a[1] = (floor($a[1]*10000)/100).'%';
	$SpecsTag .= '����EN('.$a[1].')<br>';
}
if(preg_match('/ReqStat<At><([0-9]+)>/',$Specs,$a)) $SpecsTag .= '�ݭnAttacking('.$a[1].')<br>';
if(preg_match('/ReqStat<De><([0-9]+)>/',$Specs,$a)) $SpecsTag .= '�ݭnDefending('.$a[1].')<br>';
if(preg_match('/ReqStat<Re><([0-9]+)>/',$Specs,$a)) $SpecsTag .= '�ݭnReacting('.$a[1].')<br>';
if(preg_match('/ReqStat<Ta><([0-9]+)>/',$Specs,$a)) $SpecsTag .= '�ݭnTargeting('.$a[1].')<br>';
if(preg_match('/ReqEqCond<([0-9]+)>/',$Specs,$a)){
	if ($a[1] > 0) $dXp = '+'.($a[1]/100).'%';
	elseif ($a[1] < 0) $dXp = ($a[1]/100).'%';
	else $dXp = '��0%';
	$SpecsTag .= '�ݭn���A��('.$dXp.')<br>';
}
if(strpos($Specs,'GNWeapon') !== false) $SpecsTag .="GN�ɤl�Z��<br>";
// TransAM En, Ex, No ���A
if(preg_match('/TransAM<([EnxNo]{2})><([0-9]+)>/',$Specs,$a)){
	if($a[1] == 'En') $SpecsTag .= 'TransAM �i�J�i��<br>';
	elseif($a[1] == 'Ex') $SpecsTag .= 'TransAM �o�ʤ�<br>';
	else $SpecsTag .= 'TransAM ��O�U�����A<br>';
}
//���U�˳ƱM�Ϊ��S��ĪG
if(strpos($Specs,'GNParticles') !== false) $SpecsTag .="GN�ɤl����<br>";
if(strpos($Specs,'HPPcRecA') !== false) $SpecsTag .='HP�^�_<br>';
if(strpos($Specs,'ENPcRecA') !== false) $SpecsTag .='EN�^�_(�p)<br>';
if(strpos($Specs,'ENPcRecB') !== false) $SpecsTag .='EN�^�_(�j)<br>';
if(preg_match('/ExtHP<([0-9]+)>/',$Specs,$a)) $SpecsTag .="HP���[($a[1])<br>";
if(preg_match('/ExtEN<([0-9]+)>/',$Specs,$a)) $SpecsTag .="EN���[($a[1])<br>";
//Others
if(strpos($Specs,'FortressOnly') !== false) $SpecsTag .='�n��M��<br>';
if(strpos($Specs,'RawMaterials') !== false) $SpecsTag .='���<br>';
if(strpos($Specs,'Blueprint') !== false)    $SpecsTag .='�]�p�Ź�<br>';
if(strpos($Specs,'CannotEquip') !== false)  $SpecsTag .='�L�k�˳�<br>';
//Attacking Type
if(strpos($Specs,'DoubleStrike') !== false)   $SpecsTag .='�G�s��<br>';
if(strpos($Specs,'TripleStrike') !== false)   $SpecsTag .='�T�s��<br>';
if(strpos($Specs,'AllWepStirke') !== false)   $SpecsTag .='���u�o�g<br>';
if(strpos($Specs,'CounterStrike') !== false)  $SpecsTag .='����<br>';
if(strpos($Specs,'FirstStrike') !== false)    $SpecsTag .='�������<br>';
if(strpos($Specs,'PrecisionStrike') !== false)$SpecsTag .='��T����<br>';
}
return $SpecsTag;
}

//Include Secondary Functions
$IncludeSCFI = ( isset($IncludeSCFI) ) ? $IncludeSCFI : true;
if($IncludeSCFI == true) include("includes/sc-fi.inc.php");

//Include Legacy Fetching Functions
$IncludeLFFI = ( isset($IncludeLFFI) ) ? $IncludeLFFI : true;
if($IncludeLFFI == true) include("includes/lf-fi.inc.php");

//Include Converting Functions
$IncludeCVFI = ( isset($IncludeCVFI) ) ? $IncludeCVFI : true;
if($IncludeCVFI == true) include("includes/cv-fi.inc.php");


?>