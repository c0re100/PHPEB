<?php
//�G�⥫������
//Provided and Written By: Kermit
//Debug & Amendments By: IE�� Website: http://www.iewan.com/
//php-eb v0.25Final SP2 Alterations Officially Made By: v2Alliance
//php-eb v0.35 Alterations Officially Made By: v2Alliance
$mode = ( isset($_GET['action']) ) ? $_GET['action'] : $_POST['action'];
include('cfu.php');
if (empty($PriTarget)) $PriTarget = 'Alpha';
if (empty($SecTarget)) $SecTarget = 'Beta';
postHead('');
AuthUser("$Pl_Value[USERNAME]","$Pl_Value[PASSWORD]");
if ($CFU_Time >= $TIMEAUTH+$TIME_OUT_TIME || $TIMEAUTH <= $CFU_Time-$TIME_OUT_TIME){echo "�s�u�W�ɡI<br>�Э��s�n�J�I";exit;}
GetUsrDetails("$Pl_Value[USERNAME]",'Gen','Game');
$weplist = '';
//GUI
if ($actionb=='none'){
	echo "<b style=\"font-size:12px;\">�G�⥫��<hr>";
	echo "<br>";
	echo "<form action=market.php?action=main method=post name=mainform>";
	echo "<input type=hidden value='none' name=actionb>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "<script language=\"Javascript\">";
	echo "function cfmsell(){";
	echo "if($Gen[cash] < mainform.price.value){alert('�A���{�������O�I');mainform.remit.style.visibility='visible';return false;}";
	echo "if (confirm('�T�w�n��'+mainform.price.value+'���ʶR�ܡH') == true){mainform.submit();return true}else {mainform.remit.style.visibility='visible';return false;}";

	echo "}</script>";

	$wep_list = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_market` WHERE 1 ORDER BY `id`");
	$query = mysql_query($wep_list);
	while($temp = mysql_fetch_array($query)) {
	$OwnerName_SQL = ("SELECT `gamename` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `username` = '$temp[owner]' LIMIT 1;");
	$O_Query = mysql_query($OwnerName_SQL);
	$OName = mysql_fetch_array($O_Query);
	$wep_specs=ReturnSpecs($temp['spec']);
	$weplist .= "<tr class=b>
	<td><div align='center'>$OName[gamename]</div></td>
	<td><div align='center'>$temp[name]</div></td>
	<td><div align='center'>$temp[enc]</div></td>
	<td><div align='center'>$temp[atk]</div></td>
	<td><div align='center'>$temp[hit]</div></td>
	<td><div align='center'>$temp[rd]</div></td>
	<td><div align='center'>$wep_specs</div></td>
	<td><div align='center'>$temp[price]</div></td>
	<td><div align='center'><input type=radio name=actionb value=remit onClick=\"price.value=$temp[price];mainform.sellid.value='$temp[id]';mainform.wepid.value='$temp[wepid]';mainform.owner.value='$temp[owner]';remit.disabled=false;\"></div></td>
	</tr>";
	}
	echo "<input type=hidden name=sellid value=0 maxlength=10 size=10>";
	echo "<input type=hidden name=wepid value=0 maxlength=10 size=10>";
	echo "<input type=hidden name=price value=0 maxlength=10 size=10>";
	echo "<input type=hidden name=owner value=0 maxlength=10 size=10>";
	echo "<p align=center style=\"font-size: 16; font-family: Arial\">�e�U�X��ӫ~�@��:</p>";
	echo "<table width=\"100%\" align=center border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 12; font-family: Arial\" bordercolor=\"#FFFFFF\">";
	echo "<tr><td>";
	echo "<table width=\"100%\" border=\"1\" align=center cellspacing=\"0\" cellpadding=\"0\">";
	echo '<td width="10%"><div align="center">�����</div></td>';
	echo '<td width="20%"><div align="center">�Z���W��</div></td>';
	echo '<td width="5%"><div align="center">EN����</div></td>';
	echo '<td width="6%"><div align="center">����</div></td>';
	echo '<td width="5%"><div align="center">�R��</div></td>';
	echo '<td width="5%"><div align="center">�^�X</div></td>';
	echo '<td width="10%"><div align="center">�S��</div></td>';
	echo '<td width="10%"><div align="center">����</div></td>';
	echo '<td width="5%"><div align="center">�ʶR</div></td>';
	echo "$weplist</table></table>";
	echo "<p align=left>�A���{��: ".number_format($Gen['cash']);
	echo "<br><center><input type=button name=remit disabled value=�T�w�ʶR onClick=\"remit.style.visibility='hidden';cfmsell()\"></center></form>";
	}
elseif ($actionb=='remit'){
	
	
	
	$sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_bank` WHERE `username` = '$Pl_Value[USERNAME]'");
	$query = mysql_query($sql);
	$BankUser = mysql_fetch_array($query);

	if ($BankUser['status'] != '1'){echo "�A�٨S���b�Ȧ�}��A�����ʶR���������Z���I";postFooter();exit;}
	
  $sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_market` WHERE `id` = '$sellid' LIMIT 1;");
  $query = mysql_query($sql);
  $wepnum = mysql_num_rows($query);
  
  if ($wepnum != '1'){echo "�ӪZ���w�g�Q��L���a�R���I";postFooter();exit;}
	
	
	$UsrWepA = explode('<!>',$Game['wepa']);
	$UsrWepB = explode('<!>',$Game['wepb']);
	$UsrWepC = explode('<!>',$Game['wepc']);
	if($UsrWepA[0] == '0') {$Game['wepa']=$wepid;$Pos_Flag="�ʶR�����F�I�A�{�b���ϥγo�s���Z��";}
	elseif($UsrWepB[0] == '0') {$Game['wepb']=$wepid;$Pos_Flag="�ʶR�����F�I�s���Z���s��b�ƥΤ@";}
	elseif($UsrWepC[0] == '0') {$Game['wepc']=$wepid;$Pos_Flag="�ʶR�����F�I�s���Z���s��b�ƥΤG";}
	else {$Pos_Flag="�A���W�S���Ŧ�I�������������";$price=0;}
	if ($price>0)
	{
	//���Z��
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `wepa` = '$Game[wepa]', `wepb` = '$Game[wepb]', `wepc` = '$Game[wepc]' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
	mysql_query($sql);
	//�R���ӳ����~
	$sql = ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_market` WHERE `id` = '$sellid' LIMIT 1;");
	mysql_query($sql);
	//����
	$Gen['cash'] = $Gen['cash'] - $price;
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `cash` = '$Gen[cash]' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
	mysql_query($sql);
	//����
	GetUsrDetails("$owner",'Gen2','Game2');
	$Gen2['cash'] = $Gen2['cash'] + $price;
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `cash` = '$Gen2[cash]' WHERE `username` = '$owner' LIMIT 1;");
	mysql_query($sql);
  }
	echo "<form action=market.php?actionb=none method=post name=frmeq target=$SecTarget>";
	echo "<p align=center style=\"font-size: 16pt\">$Pos_Flag<br><input type=submit value=\"��^\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"><input type=submit value=\"�~��}�ӳ�\" onClick=\"frmeq.submit()\"></p>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";
	}
else {echo "���w�q�ʧ@�I";}
postFooter();exit;
?>