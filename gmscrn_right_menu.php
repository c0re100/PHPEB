<?php

	//Button 4: Battle
	drawButton(10,'�԰�', '�԰��e��','movebattle();');

	//Button 5: Movement
	drawButton(3,'����', '���ʵe��',"act.action='map.php?action=Move';act.actionb.value='A';act.target='$SecTarget';act.submit();");
	
	//Button 6: Occupy City
	if ($Player['rights'] == '1' && $atkMissionFlag == 1 && $Pl_Mission['victory'] == 1){
		drawButton(3,'����a��', '����a��',"act.action='organization.php?action=TakeCity';act.actionb.value='A';act.target='$SecTarget';act.submit();");
	}

	//Button 7: Equip
	drawButton(10,'�˳�', '�˳�',"act.action='equip.php?action=equip';act.target='$SecTarget';act.submit();");

	//Button 8: Buy MS
	drawButton(3,'����Ͳ��u��', '����Ͳ��u��',"act.action='equip.php?action=buyms';act.actionb.value='buyms';act.target='$SecTarget';act.submit();");

	//Button 9: Mod MS
	drawButton(3,'�����y�u��', '�����y�u��',"act.action='statsmod.php?action=modms';act.actionb.value='buyms';act.target='$SecTarget';act.submit();");

	//Button 10: Tactical Weapon Factory
	drawButton(3,'�L���s�y�u��', '�L���s�y�u��',"act.action='tactfactory.php?action=main';act.actionb.value='none';act.target='$SecTarget';act.submit();");

	//Button 11: Repair
	drawButton(3,'�ײz�u��', '�ײz�u��',"act.action='statsmod.php?action=repairms';act.actionb.value='sel';act.target='$SecTarget';act.submit();");


	//Button 12: Tactics Academy
	drawButton(10,'�ԳN�ǰ|', '�ԳN�ǰ|',"act.action='tacticslearn.php?action=main';act.actionb.value='none';act.target='$SecTarget';act.submit();");

	// Mining
	drawButton(3,'��ƱĶ�', '��ƱĶ�',"act.action='plugins/mining/mining.php';act.actionb.value='none';act.target='$SecTarget';act.submit();");

	//Button 13: Warehouses
	drawButton(10,'�ܮw', '�ܮw',"act.action='warehouse.php?action=selection';act.actionb.value='none';act.target='$SecTarget';act.submit();");

	//Button 14: Bank
	drawButton(3,'�Ȧ�', '�Ȧ�',"act.action='bank.php?action=main';act.actionb.value='none';act.target='$SecTarget';act.submit();");

	//Button 16: Special Commands
	drawButton(3,'�S����O', '�S����O',"act.action='scommand.php?action=main';act.actionb.value='none';act.target='$SecTarget';act.submit();");

	//Button 17: Information
	drawButton(3,'����', '����',"act.action='information.php?action=Main';act.actionb.value='';act.target='$SecTarget';act.submit();");


	//Button 18: Rankings
	drawButton(3,'�ƦW', '�ƦW',"act.action='gen_info.php?action=ranks';act.actionb.value='none';act.target='$SecTarget';act.submit();");

	//Button 19: Refresh - Disable
	drawSButton(10,'�ССС�','return false;','ig_refresh_d');

	//Button 20: Refresh - Enabled
	drawSButton(0,'���s��z','refreshWindow();',"ig_refresh_e' style='position: absolute;visibility: hidden;");

	//Button 21: Chat Board
	drawSButton(10,'�d���O',"window.open('','$CFU_Time','resizable=1,width=800,height=600');act.action='chat.php';act.target='$CFU_Time';act.submit();");

	//Button 22: Instant Chatroom
	drawSButton(10,'��ѫ�','openChatWindow();');

	//Button 23: Logout
	drawSButton(3,'�n�X',"location.replace('index2.php');");

	//Button 24: Manager Script
if ( $Player['acc_status'] < 0 ) {
	drawButton(3,'�޲z', '�޲z',"act.action='manager.php';act.actionb.value='none';act.target='$SecTarget';act.submit();");
}

?>