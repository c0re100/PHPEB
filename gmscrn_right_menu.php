<?php

	//Button 4: Battle
	drawButton(10,'戰鬥', '戰鬥畫面','movebattle();');

	//Button 5: Movement
	drawButton(3,'移動', '移動畫面',"act.action='map.php?action=Move';act.actionb.value='A';act.target='$SecTarget';act.submit();");
	
	//Button 6: Occupy City
	
	if ($Player['rights'] == '1' && $atkMissionFlag == 1){
		drawButton(3,'放棄佔領', '放棄佔領',"act.action='organization.php?action=GiveUp';act.actionb.value='A';act.target='$SecTarget';act.submit();");
	}
	
	if ($Player['rights'] == '1' && $atkMissionFlag == 1 && $Pl_Mission['victory'] == 1){
		drawButton(3,'佔領地區', '佔領地區',"act.action='organization.php?action=TakeCity';act.actionb.value='A';act.target='$SecTarget';act.submit();");
	}

	//Button 7: Equip
	drawButton(10,'裝備', '裝備',"act.action='equip.php?action=equip';act.target='$SecTarget';act.submit();");

	//Button 8: Buy MS
	drawButton(3,'機體生產工場', '機體生產工場',"act.action='equip.php?action=buyms';act.actionb.value='buyms';act.target='$SecTarget';act.submit();");

	//Button 9: Mod MS
	drawButton(3,'機體改造工場', '機體改造工場',"act.action='statsmod.php?action=modms';act.actionb.value='buyms';act.target='$SecTarget';act.submit();");

	//Button 10: Tactical Weapon Factory
	drawButton(3,'兵器製造工場', '兵器製造工場',"act.action='tactfactory.php?action=main';act.actionb.value='none';act.target='$SecTarget';act.submit();");

	//Button 11: Repair
	drawButton(3,'修理工場', '修理工場',"act.action='statsmod.php?action=repairms';act.actionb.value='sel';act.target='$SecTarget';act.submit();");


	//Button 12: Tactics Academy
	drawButton(10,'戰術學院', '戰術學院',"act.action='tacticslearn.php?action=main';act.actionb.value='none';act.target='$SecTarget';act.submit();");

	// Mining
	drawButton(3,'原料採集', '原料採集',"act.action='plugins/mining/mining.php';act.actionb.value='none';act.target='$SecTarget';act.submit();");

	//Button 13: Warehouses
	drawButton(10,'倉庫', '倉庫',"act.action='warehouse.php?action=selection';act.actionb.value='none';act.target='$SecTarget';act.submit();");

	//Button 14: Bank
	drawButton(3,'銀行', '銀行',"act.action='bank.php?action=main';act.actionb.value='none';act.target='$SecTarget';act.submit();");

	//Button 15: Exchange
	drawButton(3,'二手市場', '二手市場',"act.action='market.php?action=main';act.actionb.value='none';act.target='$SecTarget';act.submit();");
	
	//Button 16: Special Commands
	drawButton(3,'特殊指令', '特殊指令',"act.action='scommand.php?action=main';act.actionb.value='none';act.target='$SecTarget';act.submit();");

	//Button 17: Information
	drawButton(3,'情報', '情報',"act.action='information.php?action=Main';act.actionb.value='';act.target='$SecTarget';act.submit();");


	//Button 18: Rankings
	drawButton(3,'排名', '排名',"act.action='gen_info.php?action=ranks';act.actionb.value='none';act.target='$SecTarget';act.submit();");

	//Button 19: Refresh - Disable
	drawSButton(10,'－－－－','return false;','ig_refresh_d');

	//Button 20: Refresh - Enabled
	drawSButton(0,'重新整理','refreshWindow();',"ig_refresh_e' style='position: absolute;visibility: hidden;");

	//Button 21: Chat Board
	drawCButton(10,'聊天室', '聊天室',"act.action='chat.php';act.target='$ThrTarget';act.submit();");
	
	//Button 22: Forum Button
	drawSButton(10,'討論區',"window.open('http://ext4.me/forum.php');");
	
	//Button 23: Forum Button
	drawSButton(10,'切換至舊介面',"window.location.replace('gmscrn_old.php?action=proc');");

	/*//Button 22: Instant Chatroom
	drawSButton(10,'聊天室','openChatWindow();');*/

	//Button 24: Logout
	drawSButton(3,'登出',"location.replace('logout.php');");

	//Button 25: Manager Script
if ( $Player['acc_status'] == 9 ) {
	drawButton(3,'新管理平台', '新管理平台',"act.action='manager.php';act.actionb.value='none';act.target='$ThrTarget';act.submit();");
	drawButton(3,'舊管理平台', '舊管理平台',"act.action='admin.php?action=panel';act.actionb.value='A';act.target='$ThrTarget';act.submit();");
}

?>