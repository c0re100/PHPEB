<?php
// Workspace UE ��
$IncludeSCFI = false; $IncludeLFFI = false; $IncludeCVFI = false;
include("cfu.php");
postHead('1');
?> 
<script language='JavaScript'>
function startgame(destination) {
window.open(destination,'<?php echo $PriTarget; ?>','top=20,left=50,width=800,height=600,menubar=0,toolbar=0,resizable=1,scrollbars=0,status=1');
//window.opener=null;
//window.close();
}
</script>
<body>
<center><table width=100% height=100%>
	<tr><td align='center' width=10% height=10%>
		<input type=button value="�}�l�C��" onClick=startgame('index2.php')>
	</td></tr>
	<tr><td align='center' width=90% height=90% valign=top>
		<table width=60% border=1 style="border-collapse: collapse;font-size: 12; font-family: Arial" bordercolor="#000000">
			<tr>
				<td colspan=2><B>���զ��A�����i</B></td>
			</tr>
			<!-- �Ĥ��Q���h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2010�~3��6��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>�ܦ�, ���h���F...
					<hr><b style="color: ForestGreen;font-size: 12pt">php-eb v0.50 Dev. Version / Beta Version</b>
					<br>Debug:
					<br>�@- �M�Τƨt��
					<br>�@�@ - �M�ΦW�٤����F�� Bug
					<br>�@�@ - �L�k��X���I����y�I�ƪ����D(��v = 1000:1:50, �n��:�X��:��y�I)
					<br>- �W�n�]�w
					<br>�@- �W�n���[�g��F, ���c�W���|��g��
					<br>�@- �W�n/�c�W�v�T�~��:
					<br>�@�@- ����: �v��W�n / 100 * ���W�n�δc�W
					<br>�@�@- �w��W�n�W > 0 �~���Ϊ�, �~���n���}���~���
					<hr>�m�� : "<a href="http://php-eb.v2alliance.net/dev/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: �����p�⾹ v3.0�\</a>" (2010���s����s�F)
					<br>������ @ 2009�~3��06�� AM 1:02
				</td>
			</tr>
			<!-- �Ĥ��Q�|�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2010�~2��21��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>�����̫�@��]�b debug, ���L��Q������...
					<br>�u�X�{�F�@�� "�Dde���i" �� Bug
					<br>�H�U�ODebug��x:
					<hr><b style="color: ForestGreen;font-size: 12pt">php-eb v0.50 Dev. Version / Beta Version</b>
					<br> - �D�C���e��: ��1280�H�U�� Resolution ��, �۰ʧ�� 800x600 ���I���Ϥ��� Bug
					<br>�@ - �ѩ�j�����a�Ϥ]�S�� 800x600 ���Ϥ�, �� 1024x768 ���ɷ|�S�I��
					<br> - ���q�t��
					<br>�@ - �a�ϱ��q�v�P�_���~��Bug
					<br>�@�@ - ���e�@�����q�v�]�H�{�b����m�@�ǡ�_��||
					<br> - �Z���ݩʰ��D: ���������Ӭ����骺�Z���w��^�������ݩ�
					<hr>�m�� : "<a href="http://php-eb.v2alliance.net/dev/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: �����p�⾹ v3.0�\</a>" (2010���s����s�F)
					<br>������ @ 2009�~2��21�� AM 18:34
				</td>
			</tr>
			<!-- �Ĥ��Q�T�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2010�~2��20��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>���������}�l!! (���F�T�~�ɶ�??)
					<br>�{�}�l�e�]�o�{�@�� Bug �Сġġ�"
					<br>���n��, De�F�N�n... �i�O�֨S�ɶ��F (�_
					<br>�������A���򥻤W�u�O�ݤ���o�@�����ʴ����A��...
					<br>�s��Ƥ]�O�@�q�� XD
					<br>�H�U�O��s��x:
					<hr><b style="color: ForestGreen;font-size: 12pt">php-eb v0.50 Dev. Version</b>
					<br> - �˳ƨt��: �ݨ��ݩʩM�Z���F, ���o�o�{�@�ǪZ�����G�]���F�ݩ� @_@ (���ץ�)
					<br> - �����s: ��� SEED �t�C����S�����F, ���� Phase Shift �M EN ����(�s�S��), �٦��@��
					<br> - �Ȯɲ����F3�ŤΥH�W���X���k�ʶR, ���g�n
					<br> - �[�J�F�������������˳�, ���ȮɵL�k�J��
					<br> - �ʶR�����, �i�ݨ�����S�� (Click�����Ʒ|�u�X����), �]�ץ��F�uEN�^�_�v�v��ܡuEN�W���v�����D
					<br> - �C���]�w����:
					<br>�@ - ���߲�´�O��: 1000�U -> 500�U
					<br>�@ - �_�q�x�O�W��: ����v * 4 (�Y1�U)
					<br>�@ - �n����v��O�վ�: �U�� 1, �W�� 100; �C 1�I �ƥέx�O���� 0.0025�I ��O
					<br> - Debug:
					<br>�@ - ���: �������߲�´��, �u�èt�έl�ͪ� Bug
					<br>�@ - �X��: �ʶR�X���k��ܻ����� JavaScript Error
					<br>�@ - ��ƱĶ�: ���εn�J�]��ϥΪ�Bug =__=||
					<br>�@ - �R���b�᥻�w Outdate, �{��s�F;
					<br> - �s�S��: ����EN (�ƭ�)
					<br>�@- ����M�����S��
					<br>�@- �ƭȬ���Ʈ�, �C���X������o�ƶq�� EN
					<br>�@- �ƭȬ� % ��, �C���X������ EN�W�� �����w�ʤ���
					<br>�@- ���ĪG���v�T�X��, �u�O�º���� EN ���ĪG
					<hr>�m�� : "<a href="http://php-eb.v2alliance.net/dev/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: �����p�⾹ v3.0�\</a>" (2010���s����s�F)
					<br>������ @ 2009�~2��20�� AM 17:38
				</td>
			</tr>
			<!-- �Ĥ��Q�G�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2010�~2��20��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>�s�~�ּ֡I(��?)
					<br>�o�o�o, (�H~) �O php-eb v0.50 ����s��x (ʨ, �ܧN...)
					<br>�W����:
					<br>�U�@�� (v0.49) �|������? �c... �p���p�U:
					<br>&nbsp; - ����t�έ��աB���s�w�q
					<br>&nbsp;�@ - ����Ǯw�ܱo����
					<br>&nbsp;�@ - �u��
					<br>&nbsp; - ��M PvP �t�� (?)
					<br>&nbsp; - ��s��������Ϥ�
					<br>�������S�����~ XD
					<br>�H�U�O v0.49 ����s:
					<hr><b style="color: ForestGreen;font-size: 12pt">php-eb v0.49 Dev. Version</b>
					<br>�@- ���U�t�� Debug: �s���U�H�جO�ťժ� Bug
					<br>�@- PHP Function "eregi" �వ "preg_match", �����u�Ƥά� PHP 5.3 / 6 �V�W�ݮe
					<br>�@- �a�Ϩt��: �i��ʬD��a�϶դO���G
					<br>�@- GUI Back-end: Code Refactor, ��M�R; drawButton()
					<br>�@- Firefox Support �[�j: Virtually same as IE
					<br>�@- information.php: �j�Ϫ��a��T
					<br>�@- Debug: HP, EN �� SP �䤤�@�ˬO�����ɭ�, ���|�۰ʦ^�_�� Bug
					<br>�@- Debug: ��[�J�������s�|������´���|�}
					<br>�@- Debug: �u�æb�P�@�j�Ϥ]��u�n�몺 Bug
					<br>�@- Debug: ��a��ꤣ���C��@������|�}
					<hr><b style="color: ForestGreen;font-size: 12pt">php-eb v0.50 Dev. Version</b>
					<br><br><b>�M�ηs�Z���Ҫ�:</b>
					<br>�@- �Ȧ�����D�u: �԰��p�M, ������
					<br>�@- Tier/Stage ��:
					<br>�@�@- Tier ����
					<br>�@�@�@- �C Tier ����O�]����ۤ��O
					<br>�@�@�@- �@ 10�� Tier, ���G�b 4�� Stage
					<br>�@�@- Stage �ɴ�
					<br>�@�@�@- Stage ����O���O�� Tier ����j
					<br>�@�@�@- ��V�C�� Stage �]���V Tier ��, ���w�n�X��
					<br>�@�@�@- 4 �� Stage:
					<br>�@�@�@�@ - Early Stage (���)
					<br>�@�@�@�@�@ - 3�� Tier, T1 - T3
					<br>�@�@�@�@ - Mid Stage (����)
					<br>�@�@�@�@�@ - 3�� Tier, T4 - T6
					<br>�@�@�@�@ - Late Stage (�ߴ�)
					<br>�@�@�@�@�@ - ��� Tier, T7 & T8
					<br>�@�@�@�@ - Final Stage (�״�)
					<br>�@�@�@�@�@ - ��� Tier, T9 & T10
					<br><br><b>�S�Ĭ���:</b>
					<br>�@- �Z������ĪG: ���Z���Z�����Z���Z���@�w���v�o�ʡu��������v
					<br>�@- �u��������v�ĪG Debug (���e��ˤ]���|�o��)
					<br>�@- CFU �B�z�S�ĦW�٪��p�u�� (�S�Ӥj���O)
					<br>�@- �s�S�Ĺ��: ��u����
					<br>�@�@ - ���ϥ��ݩʬ��u���u�v���Z��, �^���ܬ��쥻��60%
					<br>�@- �s�S�Ĺ��: �K���g��
					<br>�@�@ - �w��ϥ��ݩʬ��u���u�v���Z��, �^�ƥH 50% �W�� 66.7% (�|��P��u����)
					<br>�@- �s�S�Ĺ��: �ݩʴ�K�ĪG
					<br>�@�@- �����K
					<br>�@�@�@- �p�ҡ@�@�@�@�@: ����ˮ`��K10%��A��K200�I�ˮ`�C�`��K�q���j��1200�C
					<br>�@�@�@- �ܽ����@�@�@�@: ����ˮ`��K15%��A��K500�I�ˮ`�C�`��K�q���j��2000�C
					<br>�@�@�@- �u�}�@�@�@�@�@: ����ˮ`��K20%��A��K1000�I�ˮ`�C�`��K�q���j��4000�C
					<br>�@�@�@- Phase Shift�@ : ����ˮ`��K27%��A��K1700�I�ˮ`�C�`��K�q���j��6500�C
					<br>�@�@�@- V. P. S.�@�@�@: ����ˮ`��K35%��A��K2500�I�ˮ`�C�`��K�q���j��10000�C
					<br>�@�@- ������K(�ĪG�P�W, ������)
					<br>�@�@�@- �@��
					<br>�@�@�@- ���ಾ
					<br>�@�@�@- �ᦱ
					<br>�@�@�@- ��g
					<br>�@�@�@- ����
					<br>�@�@- �S���K(�ĪG�P�W, �S��)
					<br>�@�@�@- ���ʥ��w
					<br>�@�@�@- ���O�ޱ�
					<br>�@�@�@- �Ŷ��z�Z
					<br>�@�@�@- �ɪ��Z��
					<br>�@�@�@- �����s��
					<br>�@- �u�e��v�ĪG��s
					<br>�@�@- �L���@����K�ĪG�C(�]�A���ˮ`��K)
					<br><br><b>�˳ƨt��:</b>
					<br>�@ - ���c��s
					<br>�@ - �{�b�ɯŧ�y���ݨD���A�Ȥ��G�w�F
					<br>�@ - <b>�{�b�i�H�ݨ�Ҧ��i��ʤF (���A����)</b>
					<br>�@�@ - �ݤ���Y�O�S��, �h<u>�X��</u>�a���
					<br>�@ - �ʶR�����, �C����ܪ�����אּ�u�汼�{�b�������, �i�H�ʶR������v
					<br><br><b>��ƱĶ��t��:</b>
					<br>�@- �{�b�u���߲�´�v����a�w��Ҧ��H�Ķ����, �����v <b>�U��</b> 30%
					<br>�@�@�@ - �U���O����쥻���v�� 80% ��, �U���� 50%,
					<br>�@�@�@�@ �쥻���v�֩� 30% ����, �N�|�ܬ� 0%
					<br>�@- �ק�: �u���S�����q�v���a��, �Y�Ϲw���ƤF�{, �]�|�L��ì, ���O�ήɦ��� XD
					<br><br><b>���רt��:</b>
					<br>�@- �{�b�w�]�^�_ 100% HP/EN �F, ���@�U�K�i...
					<br>�@- Debug: ���׮�, �S���p��۰ʦ^�_�����~�� Bug =__=||
					<br>�@�@- �o���u���ץ��F
					<br>�@- �j�� Firefox/Standard Browsers �䴩, ���|�A�Q�~ Warning
					<br><br><b>�L���s�y�u�� / �X���t��:</b>
					<br>�@- �ʶR�X���k��, �i�M�R�ݨ�X�����ƻݨD
					<br>�@�@- �c... �ڭ̶ǲΪ��X���G���٦��H�ݶ�???
					<br>�@- �X���e, �i�ݨ�{������`�� (���M�Τƫh�٤���)
					<br><br><b>���v����:</b>
					<br>�@- �B�~��O�[�����: �����`��(�t�Ҧ��[��) 2���� / 1500 (��֤F, �� /1000 �� /1500 )
					<br>�@- �@��H SEED Mode �[���W�[ (���^ +15% -> +17% )
					<br><br><b>��L�ץ�/��s:</b>
					<br>�@- �Y�ɲ�� Debug: IE �]�W����s�h�F�� Object Error, �w�ץ�
					<br>�@- �����u�G�⥫���v Plugin
					<br><br><b>�s�W�u��/�u��ק�:</b>
					<br>�@- NPC �ͦ���
					<br>�@�@- �̵��ťͦ����w�ƶq�� NPC
					<br>�@- NPC �²M��
					<br>�@�@- ��Ҧ� NPC �~�����u��
					<br>�@- �Źϥͦ���
					<br>�@�@- �۰ʤƥͦ��ŹϪ��u��
					<br>�@�@- �|�۰� Link �X���k �Χ��ܤ@���X���w���ݨD���~
					<br>�@�@- �|�۰ʧ���W�@��(�̫᪺)�ŹϪ��~�� ID
					<br>�@- �X���k�s�W��
					<br>�@�@- �@�ӷs�W�X���k�����K���u��
					<br>�@�@- �s�W���i�Ρu�Źϥͦ����v�ͦ��Ź�
					<br>�@- ��´�]�w��l�ƾ�
					<br>�@�@- �~ Server �ɥΪ� Orz...
					<hr>�ǻ����� v0.50 �G�M�h��s!!
					<br>���ձN�|����ѥ����}�l...
					<br><br><b>������˪��F��:</b>
					<br>&nbsp; - �n�X���Z��
					<br>&nbsp; - �X������3 - ����10, �ҥH�O�h�R��~~~
					<br>&nbsp; - �M���B�Ψ�S��
					<br>&nbsp; - Gundam 00 �t�C���F�� (�ΤF�s�Z����, ���ˤF, �ܨ�S����� 0_0)
					<hr>�m�� : "<a href="http://php-eb.v2alliance.net/dev/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: �����p�⾹ v3.0�\</a>" (2010���s����s�F)
					<br>������ @ 2009�~2��20�� AM 3:48 (�g�F�@��, ���L���٦����֮ɶ��O... �� php-eb ^^" ///Orz)
				</td>
			</tr>
			<!-- �Ĥ��Q�G�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2010�~2��2��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>�S�@�~�F ||Orz...
					<br>�o�O v2Alliance �׾¥����}��᪺�Ĥ@�h��x...
					<br>�o�Ӥ�x, �O v0.48 ����x... ��F����... �ۤv�ݧa Orz...
					<br>��W�@�����w�����Ӥ@��...
					<br>�ܻ�... ���զ��A���O�ڦ��ئb�u��High�v���Pı �ס@��|||
					<hr>��s��x:
					<br><b style="color: ForestGreen;font-size: 12pt">php-eb v0.48 Dev. Version</b>
					<br><br><b>��ƱĶ��t��:</b>
					<br>&nbsp; - �[�J�Ƶ{����
					<br>&nbsp; - �Ƶ{1 �]�w�F���ɫJ����A���F
					<br>&nbsp; - ��ڤӦh��, �|�q�����a�F
					<br>&nbsp; - �{�b���Ƶ{��, �|�������˼ƤF(�i�O���a�q�����ɶ��]���F���ܷ|�����D)
					<br><br><b>�԰��t��:</b>
					<br>&nbsp; - �ޤJ Phase Structure
					<br>&nbsp;�@ - ���O�N�@�ǩʽ�۪񪺭p��B�J����, �O�{�ǧ�M�R
					<br>&nbsp;�@ - ���u�Ʀ���
					<br>&nbsp; - �M�˨t��
					<br>&nbsp;�@ - �{�b�M�˨t�ΰ򥻤W�w���n, �u�O���]�w
					<br>&nbsp; - �t���u��
					<br>&nbsp; �@- 10�������B�z�t��: 0.0300357 -> 0.0294675, ���ɤj�� 2%
					<br>&nbsp; �@- �@Standard Deviation: 0.001468708 -> 0.00143634, ���ɤj�� 2%
					<br>&nbsp; �@- �@(���p�h���̧֩M�̺C������, �u�ƫ᪺í�w�ʩ�������)
					<br>&nbsp; �@- �h�F�\��, �o�֤F�@�I�I; ���o��`�Ϊ��t�Ψӻ�, ��O�������F...
					<br><br><b>�H�س]�w:</b>
					<br>&nbsp; - �{�b����11�ܲ�16�ŤH�ؤF
					<br>&nbsp; - ��11�Ÿ��10�Ť@��
					<br>&nbsp; - �t�Χ�s: ���ܤF�P�w�H�ص��Ū� algorithm, �{�b�����p��X��
					<br>&nbsp; - �t�Χ�s: ��Ʈw Data Redundancy �U��, ID �M ���� �w����, �H Combined Key �P�w
					<br><br><b>�D�e���t�Χ�s:</b>
					<br>&nbsp; - ��ΤF Phase Structure (�����ӧ���)
					<br>&nbsp; - �ĥΤF�P�s�԰��t�Τ@�˪� sfo.class ���a��T�B�z��k
					<br>&nbsp;�@ - �D�e����ܪ���T��԰��t�Χ󱵪�F
					<br>&nbsp;�@ - �S�Ī��[��(��ƨ���, �pHyper-Thruster)�{�b�|��ܤF
					<br><br><b>��L/�����s:</b>
					<br>&nbsp; - Firefox �䴩�ܱo��n�F
					<br>&nbsp;�@ - �۰ʧ�s�t�Φb Firefox �W�i�H�Ψ�F
					<br>&nbsp;�@ - �򥻤W�� Firefox ���]�S������j���D�F, �u�O IE8 �|����n��, FF �S Filter...
					<br>&nbsp; - �S�ħP�w�ܱo��֤F
					<br>&nbsp; - �s�����, �[�J�F Nu Gundam �M Sazabi !!
					<br>&nbsp; �@- �s���K�u������, �j�����]���M�˪���(����Q), �����]�w�n
					<br>&nbsp; �@- 100�ťH�W����򥻤W�����n�b���K�u�������ʶR~
					<br>&nbsp; - �n���l��O��s�F
					<br>&nbsp; - ��Ʈw�W���Z�����O�@�X�w�ƤF:
					<br>&nbsp;�@ - ���O�����ⳡ��: �u�Z���v �M �u�ݩʡv
					<br>&nbsp;�@ - �Z�� - range: �� = 0, �� = 1, �S = 2
					<br>&nbsp;�@�@ - ���Z���N�|�����Z��, �S��Z���������v�T (�����)
					<br>&nbsp;�@ - �ݩ� - attrb: Beam = 0, ���� = 1, ���u = 2, �S�� = 3, �n�� = 4
					<br>&nbsp;�@ - �˳����ӷ|�Q�w�q���S��Z���S���ݩ�
					<br>&nbsp;�@ - �ѩ�����]�����, �{�b�����]�O���ZBeam~XD
					<br>&nbsp; - �����B��Ǯw�B���K�u����ܸ˳ƨ�����, �� O �M X �אּ: <img src="http://php-eb.v2alliance.net/dev/img1/crossImgW.gif" alt="Cross"> �M <img src="http://php-eb.v2alliance.net/dev/img1/tickImgW.gif" alt="Tick">
					<br>&nbsp; - ���K�u����W�ܡu��´��s�ҡv�F ^^, �ϥ����S���򯵱K Orz
					<br>&nbsp; - �}�o�Ϸs�u��: tactCalculator
					<br>&nbsp; �@- �Ψӭp��Z���M�ΤƮĪG���u��, ���}: <a href="http://php-eb.v2alliance.net/dev/others/tools/tactCalculator.html" style="font-size: 10pt;text-decoration: none;color: ForestGreen">http://php-eb.v2alliance.net/dev/others/tools/tactCalculator.html</a>
					<hr>�稺��h��s?? Orz...
					<br>�U�@�� (v0.49) �|������? �c... �p���p�U:
					<br>&nbsp; - ����t�έ��աB���s�w�q
					<br>&nbsp;�@ - ����Ǯw�ܱo����
					<br>&nbsp;�@ - �u��
					<br>&nbsp; - ��M PvP �t�� (?)
					<br>&nbsp; - ��s��������Ϥ�
					<br>v0.50 �w�w�p��:
					<br>&nbsp; - �s�Z����
					<br>&nbsp; - �M�˨t�Ρu��ˡv
					<br>&nbsp; - ���O�S�Ĺ��
					<br>�o�ǥ�(?)���O�n���Ӥ@�w�ɶ�����s...
					<br>�ܻ�, ���p�s�Z�����M�X�{����, php-eb �]�|��M�X�{... �K�K... (�_...
					<hr>�m�� : "<a href="http://php-eb.v2alliance.net/dev/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: �����p�⾹ v3.0�\</a>" (2010���s����s�F)
					<br>������ @ 2009�~2��2�� AM 12:42 to AM 1:51 (�g�F�@�p�ɦh= =)
				</td>
			</tr>
			<!-- �Ĥ��Q�@�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2010�~1��18��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>�T�u�S�T�u, �T�u����S�A�T�u...
					<br>�s�� php-eb �w�b������ı���}�o�F��Ӧ~�Y... =___=||
					<br>���U���� php-eb ���H�[���F... ||Orz
					<br>�o�O�t���h�@�~�H�ӲĤ@����s����x...
					<br>�b�ʴ����̫�@�� (v0.45Beta) ��, �ɺ��٦���s, �o�@���S���g��x...
					<br>�̪��ӬP��, php-eb �w�D�i�F�T�Ӫ���, �� v0.45 -> v0.46 -> v0.47 -> v0.48 ...
					<br>�γ\���H�|��, v0.4x �t�C������ v0.5 �F, ���٨S���}�H
					<br>�ƹ�W... �ڭ̦��w�M�w, �� "v0.xx" �R�W������, ���|�A���}...
					<br>���}���O�uphp-eb UE v1.0�v��...
					<br>�ܩ���@���O v1.0 ?
					<br>�Ӳ{�i�פ����F...
					<br>�H�U�O�@�ǭp�������D�n���e:
					<br>�@v0.48 - �W��(100�ū�)�H��, �Z�����O;
					<br>�@�@�@�@�@�@(�u�@��... �ѩ�e�⪩��s�Ӧh, �o���|�����)
					<br>�@v0.49 - �s�����B�Z����; ��s��������Ϥ�
					<br>�@v0.50 - �M�˨t�ι��, ���O�S�Ĺ��
					<br>�N�u���o�T�Ӫ���,
					<br>v0.50 �ܦ��i��N�O�ǻ������uUE v1.0�v��...
					<hr>��s��x:
					<br><b style="color: ForestGreen;font-size: 12pt">php-eb v0.46 Dev. Version</b>
					<br><br><b>���a�����O:</b>
					<br>&nbsp; - HP ��y�W������
					<br>&nbsp;�@�@- HP��y�W������HP���Q��
					<br>&nbsp; - EN ��y�W������
					<br>&nbsp;�@�@- EN��y�W������EN���Q��
					<br>&nbsp; - ����
					<br>&nbsp;�@�@- ��X���ܧ�: �{�b������� 90%
					<br>&nbsp;�@�@- ��X�����, HP/EN �|�P���ܽ� (�H�򥻻�)
					<br><br><b>���a���v��O:</b>
					<br>&nbsp; - �B�~��O�[��
					<br>&nbsp; �@ - �C1�I��O�[ 0.1% ��O�[�� 
					<br>&nbsp; �@ - ����:  �B�~��O�[��: �����`��(�t�Ҧ��[��) 2���� / 1000
					<br>&nbsp; �@ - �u�ݨD��O�ȡv�t�C�S�Ĥ��|�p���B�~��O�[�� (v0.47 �~��˪�)
					<br>&nbsp;�@�@- SEED Mode ���ŭ׭q:
					<br>&nbsp;�@�@�@- Coordinator:
					<br>&nbsp;�@�@�@�@- ����O +20% -> ����O +15%
					<br>&nbsp;�@�@�@- Extended:
					<br>&nbsp;�@�@�@�@- Attacking, Reacting: +20% -> +15%
					<br>&nbsp;�@�@�@�@- Targeting: +10% -> +5%
					<br>&nbsp;�@�@�@- Natural:
					<br>&nbsp;�@�@�@�@- ���� - Defending, Reacting +15%
					<br>&nbsp;�@�@- Exam System ���ŭ׭q:
					<br>&nbsp;�@�@�@- 100�ūe - ����:
					<br>&nbsp;�@�@�@�@- Enhanced, Extended:
					<br>&nbsp;�@�@�@�@�@- Attacking: +10
					<br>&nbsp;�@�@�@�@�@- Defending: -3
					<br>&nbsp;�@�@�@�@�@- Reacting : -2
					<br>&nbsp;�@�@�@�@�@- Targeting: +10
					<br>&nbsp;�@�@�@�@- Natural:
					<br>&nbsp;�@�@�@�@�@- Attacking: +15
					<br>&nbsp;�@�@�@�@�@- Defending: -6
					<br>&nbsp;�@�@�@�@�@- Reacting : -4
					<br>&nbsp;�@�@�@�@�@- Targeting: +10
					<br>&nbsp;�@�@�@- 100�ŤΫ� - �G���[��:
					<br>&nbsp;�@�@�@�@- Enhanced, Extended:
					<br>&nbsp;�@�@�@�@�@- Attacking: +5
					<br>&nbsp;�@�@�@�@�@- Targeting: +5
					<br>&nbsp;�@�@�@�@- Natural:
					<br>&nbsp;�@�@�@�@�@- Attacking: +10
					<br>&nbsp;�@�@�@�@�@- Defending: -3
					<br>&nbsp;�@�@�@�@�@- Reacting : -2
					<br>&nbsp;�@�@�@�@�@- Targeting: +10
					<br><br><b>��ƱĶ��t��:</b>
					<br>&nbsp; - �Y�N�˱��¦��u�����C�v�t�C
					<br>&nbsp; - �W�ߪ���ƱĶ��t��, ��ƩM�Z�ˤ��}�F
					<br>&nbsp; - �Ƶ{�Ķ��s, �C�b�p�ɤ@�ӱƵ{
					<br>&nbsp; �@- �C�ӱƵ{�u����w�Ķ��@�ح��, ���\�Ķ�����, �|��o�ӭ�Ƥ@�ӳ��
					<br>&nbsp; �@- �Ķ��L�{�|����
					<br>&nbsp; - ��Ƥ��� 8��, �V���V�U�u���B�Ķ����\�v�V�C:
					<br>&nbsp; �@- Lv. 1: ���
					<br>&nbsp; �@- Lv. 2: ��o
					<br>&nbsp; �@- Lv. 3: �ƦX�T
					<br>&nbsp; �@- Lv. 4: �»�
					<br>&nbsp; �@- Lv. 5: ���g
					<br>&nbsp; �@- Lv. 6: �W����
					<br>&nbsp; �@- Lv. 7: ����
					<br>&nbsp; �@- Lv. 8: ���B
					<br>&nbsp; - �u�঳�v���´��a�Ķ��B�إ߱Ƶ{
					<br>&nbsp; - �C�Ӧa�Ϫ��X���q�����@��
					<br>&nbsp; - ���\�v�|�����v���żv�T:
					<br>&nbsp; �@- ���v���ŧC����, ���ŭ�ƪ��Ķ����\�v�|�ܧC
					<br>&nbsp; �@- �v�T����: ��ڦ��\�v = �w�]�Ķ����\�v * ( 1 - ( ��Ƶ���/10 + 0.2 - ���v����/100 ) )
					<br>&nbsp; �@�@- ���\�v���|����u�w�]�Ķ����\�v�v
					<br>&nbsp; - ���O:
					<br>&nbsp; �@- �C�ӱƵ{���O�@���u�u�@�v, ���צ��\�P�_, ���n���O
					<br>&nbsp; �@- ���\�v�V��, �����V�K�y
					<br>&nbsp; �@- �O�b��:
					<br>&nbsp; �@�@- �i�H�y��A���b
					<br>&nbsp; �@�@- ���b�e��Ʈw�|�Q��w
					<br>&nbsp; �@�@- ���b��, �� 10% ����X�N�|�ǤJ��´���
					<br><br><b style="color: ForestGreen;font-size: 12pt">php-eb v0.47 Dev. Version</b>
					<br><br><b>�Ȧ����t�Χ�s:</b>
					<br>&nbsp; - �i�H���(��ƱĶ��t�Ϊ�)��ƤF
					<br>&nbsp; - ����t�η��X���աB�u��
					<br><br><b>�L���s�y�u��(�X���αM�Τƨt��)��s:</b>
					<br>&nbsp; - �{�b�i�H��(��ƱĶ��t�Ϊ�)��ƤF
					<br>&nbsp; �@ - �X����: �u�p���ƶq, �L���Ǥ��O
					<br>&nbsp; �@ - �M�Τ��I��: �C�ŧO����ƱM�Τ��I�Ƥ]���P, �V���ŶV�h�I��
					<br>&nbsp; �@�@ - ���ѩ󰪯ŭ�Ƥ���u��, �u���F�����X���v�M�C�ŭ�ƹw�p�O�D�n����
					<br>&nbsp; - �X���t�η��X���աB�u��
					<br>&nbsp; �@- �X����, �����B�z�t��: 0.017420 -> 0.006010, ���ɤj�� 3��, ��֪��B�z
					<br>&nbsp; �@- �@Standard Deviation: 0.013842 -> 0.001088, ���ɤj�� 13��, ��í�w
					<br>&nbsp; �@- ���զX���������s�X, �H�����Ѫ����|�w�Ʒ|�j��
					<br>&nbsp; �@- �ץ����G��ܡu�X�����ѡv��Bug, �_�]��Form�i��F�⦸Submission
					<br>&nbsp; - �X���ŹϨt��
					<br>&nbsp; �@- �ʶR�X���k��, �|�o��u�]�p�Źϡv���~(�ƥΪZ��)
					<br>&nbsp; �@- �s���X���k, �@��|�n�D�u�]�p�Źϡv��i�Ĥ@�Ӧ�
					<br>&nbsp; �@�@- ���y�ܻ�, �u�]�p�Źϡv�O���ӫ~
					<br>&nbsp; �@�@- �j�T���C�ʶR�X���k������
					<br>&nbsp; �@- �i�H�Ρu�]�p�Źϡv���~, ��u�L���s�y�u���v�Ρu�Z���w�v�i��u�˵��v
					<br>&nbsp; �@�@- �u�˵��v�|��ܡu�]�p�Źϡv���Z�����X���k
					<br>&nbsp; �@- �u�]�p�Źϡv�ݤ@�몫�~, �i�H���`���
					<br><br><b>�Z���w��s:</b>
					<br>&nbsp; - �{�b�i�H�˵��u�]�p�Źϡv�F
					<br><br><b>�����t�Χ�s:</b>
					<br>&nbsp; - �{�b�|��ܱĶ���ƪ��u�w�]�Ķ����\�v�v�F
					<br>&nbsp; - �{�b�|��ܦa����T�F (�]���s�����ܦh�]�w�]�P�a������)
					<br>&nbsp; - �����䴩 Mozilla Firefox 3.5 �� Google Chrome �F
					<br><br><b>���a���v��O:</b>
					<br>&nbsp; - �u���O�v�Ρu���ʤO���O�v
					<br>&nbsp; �@- �u���O�v�ĪG����:
					<br>&nbsp; �@�@- �H 60% �����|, ���v Defending +15
					<br>&nbsp; �@- �u�j�ƤH�v 70�ū�|���e�u���O�v�ĪG, ���ĪG���|���|
					<br>&nbsp; �@- �u���ʤO���O�v �ĪG�אּ:
					<br>&nbsp; �@�@- �b�S���u���O�v�ĪG�����X�U, �H 60% �����|, ���v Defending +15
					<br>&nbsp; �@�@�@- ���ĪG����@�u���O�v, �L�kĲ�k�u�⭿���O�v�ĪG
					<br>&nbsp; �@�@-�u�⭿���O�v
					<br>&nbsp; �@�@�@- �b���u���O�v�ĪG�����X�U, ��o�ʡu���O�v��, �� 20% ���|�u���O�v�ĪG�[��
					<br><br><b>��L��s:</b>
					<br>&nbsp; - ����: �{�b�|��ܦa����T�F (��]�P�W)
					<br>&nbsp; - ����^�_�v: �_�Ρu�ʥ���򥻦^�_�q�v, �Ҧ��������w�|�b5�����������^�_
					<br>&nbsp; - �s�����u�����p�⾹�v, �Ԩ��U��s��
					<br>&nbsp; - Firefox ���䴩�ﵽ�F, �̤֥i�H�L��ê�a���a... ������ĳ�ϥ�IE8...
					<br>&nbsp; - �޲z�Τp��:
					<br>&nbsp;�@ - �X���t�边(grantTactRaw.php) : �۰ʧ�X����Ʈw�񺡪��p�u��, �ΥH���զX���k
					<br>&nbsp;�@ - �Źϥͦ���(blueprintTact.php): �۰ʫإߡu�]�p�Źϡv�Z�˪��~���p�u��
					<br><br>
					<hr>�m�� : "<a href="http://vsqa.dai-ngai.net/peb-u/program/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: �����p�⾹ v3.0�\</a>" (�s����s�F)
					<br>������ @ 2010�~1��19�� AM 1:30
				</td>
			</tr>
			<!-- �Ĥ��Q�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2009�~2��1��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>��Ӫ���x...
					<br>�o�X�Ѩ��@��������s XD
					<br>�u�O������M�S���g��x~
					<br>����...
					<br>�̩��㪺��s�o�Q������~�K�K...
					<br>���L�᪺�ɶ��]... 0.0"
					<br>���դ]���G������n�F!?
					<hr>�m��:
					<br><b>���զ��A���]�w</b>:
					<br>�@- <a href="#testSettings" style="font-size: 10pt;text-decoration: none;color: ForestGreen">�S������, �Ьݬݳo��...</a>
					<br><b>�Z����ξ����</b>:
					<br>�@- <a href="http://vsqa.dai-ngai.net/peb-u/wep.xls" style="font-size: 10pt;text-decoration: none;color: ForestGreen">�Z����</a>
					<br>�@- <a href="http://vsqa.dai-ngai.net/peb-u/ms.xls" style="font-size: 10pt;text-decoration: none;color: ForestGreen">�����</a>
					<hr>��s��x:
					<br><b style="color: ForestGreen;font-size: 12pt">php-eb v0.45�] Close Test Version</b>
					<br><br><b>Debug �P �ק�:</b>
					<br>&nbsp; - �j�ƭn���O�BHP
					<br>&nbsp;�@ - ���e���]�w�����D, �{�b�ץ��n�F
					<br>&nbsp;�@ - �{�����c�] Improve �F
					<br>&nbsp; - �� Trans-AM ������(Exia �M 00)�{�b�u��󥿱`���A�U�i��u�򥻧�y�u�{�v
					<br>&nbsp; - �{�b�i�H�վ�D�������j�ӤF
					<br>&nbsp; - �ϥΪ̦W�٩M�K�X�{�b����H�u0�v�}�Y�F
					<br><br><b>�I���Ϥ��ɧ�:</b>
					<br>&nbsp; - �ɧ��F�|�ئa��(�a���B�뭱�B�t�z�B�ޥ��P)
					<br>&nbsp; �@�@ �� 1024x768�B1280x800�B1440x1050 �M 1680x1050 �Ϥ�
					<br><br><b>iChat Plugin:</b>
					<br>&nbsp; - �s�Y�ɲ�Ѩt��
					<br>&nbsp; �@- �䴩 IE 6, 7, 8 �� FF 3 (�z�פW FF1 �]�䴩��, ���S����)
					<br>&nbsp; �@- �T�W: ���}�B�K�W�B��´�W��
					<br>&nbsp; �@- �²�ѫh���F�W���u�d�����v
					<br>&nbsp; �@- ����� GM ���O: �M��Database �� GM�W (���i)
					<br>&nbsp; �@- ���s�����v, �|�b �Y�ɲ�� ���
					<br>&nbsp; �@- �۰ʴ��ܥ\��: ���s�T���|�۰ʴ���(Firefox���䴩���\��)
					<br>&nbsp; �@- �i�վ�����j��
					<hr>�m�� : "<a href="http://vsqa.dai-ngai.net/peb-u/program/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: �����p�⾹ v2.0�\</a>" (�s����s�F)
					<br>������ @ 2009�~2��1�� PM 8:15
				</td>
			</tr>
			<!-- �ĥ|�Q�E�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2009�~1��25��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>�~�T�Q��~��������~~ (�ƤF = ="
					<br>�ש�񰲤F>_<~
					<Br>Debug, debug �M debug
					<br>�ץ��F�@�� list �F�� bug...
					<br>��ĳ�j�a�]���@�� "list of bugs and recommendations" ����, �o�ˤ����K
					<hr>�m��:
					<br><b>���զ��A���]�w</b>:
					<br>�@- <a href="#testSettings" style="font-size: 10pt;text-decoration: none;color: ForestGreen">�S������, �Ьݬݳo��...</a>
					<br><b>�Z����ξ����</b>:
					<br>�@- <a href="http://vsqa.dai-ngai.net/peb-u/wep.xls" style="font-size: 10pt;text-decoration: none;color: ForestGreen">�Z����</a>
					<br>�@- <a href="http://vsqa.dai-ngai.net/peb-u/ms.xls" style="font-size: 10pt;text-decoration: none;color: ForestGreen">�����</a>
					<hr>��s��x:
					<br><b style="color: ForestGreen;font-size: 12pt">php-eb v0.44�] Close Test Version</b>
					<br>Debug �P �ק�:
					<br>&nbsp; - �藍��n���O�BHP��bug
					<br>&nbsp;�@ - �P�ɤ]���FHP�W�[�q ( �ܤ֤F )
					<br>&nbsp; - �ײz�u��
					<br>&nbsp;�@ - �{�b��ԮɥΤ���F
					<br>&nbsp;�@ - �s�W�\��: ������
					<br>&nbsp; �@�@- ���A���ײz���ɨϥ�
					<br>&nbsp; �@�@- HP �F��l HP (���t���[�Ȯ�) �� 80% �i�H�ϥ�
					<br>&nbsp; �@�@- �⪬�A�ܬ��i�o�i
					<br>&nbsp; - �����I�ƥ[ SP ���ĪG��s: �� �[�@�I �ܦ� �[ 10�I
					<br>&nbsp; - �ѨM��y����򥻯�O��,�W���ƭȤ����T�����D
					<br>&nbsp; - �� 00 �t�C���骺 ��lEN ���� (�H�x��), 00 Gundam �� EN �W�ɬ� 1 (�Ʊ��ѨM�u�Y��½�͡v��Bug)
					<br>&nbsp; - �� Internet Explorer 7 ����žԪ����D
					<hr>�m�� : "<a href="http://vsqa.dai-ngai.net/peb-u/program/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: �����p�⾹ v2.0�\</a>" (�s����s�F)
					<br>������ @ 2009�~1��25�� PM 11:16
				</td>
			</tr>
			<!-- �ĥ|�Q�K�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2009�~1��11��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>���ܵu��, �D�n�O Debug
					<hr>�m��:
					<br><b>���զ��A���]�w</b>:
					<br>�@- <a href="#testSettings" style="font-size: 10pt;text-decoration: none;color: ForestGreen">�S������, �Ьݬݳo��...</a>
					<br><b>�Z����ξ����</b>:
					<br>�@- <a href="http://vsqa.dai-ngai.net/peb-u/wep.xls" style="font-size: 10pt;text-decoration: none;color: ForestGreen">�Z����</a>
					<br>�@- <a href="http://vsqa.dai-ngai.net/peb-u/ms.xls" style="font-size: 10pt;text-decoration: none;color: ForestGreen">�����</a>
					<hr>��s��x:
					<br><b style="color: ForestGreen;font-size: 12pt">php-eb v0.43�] Close Test Version</b>
					<br>Debug:
					<br>&nbsp; - �Ĥ褣���ξԳN������Bug
					<br>&nbsp; - �󥿳����ԳN�� Hit �ץ� (����R���ץ�)
					<br>&nbsp; - �X�����ε����D
					<br>&nbsp; - %�^�_�S�ĵL�Ī����D
					<hr>�m�� : "<a href="http://vsqa.dai-ngai.net/peb-u/program/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: �����p�⾹ v2.0�\</a>" (�s����s�F)
					<br>������ @ 2009�~1��11�� PM 5:37
				</td>
			</tr>
			<!-- �ĥ|�Q�C�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2009�~1��7��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>10���g��B���������}�l�o, �P�¦U��!!<br>�e���B���e�����է���~~!!
					<hr>�m�� : "<a href="http://vsqa.dai-ngai.net/peb-u/program/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: �����p�⾹ v2.0�\</a>" (�s����s�F)
					<br>�c... �ܦ�= ="
					<br>������ @ 2009�~1��7�� PM 9:31
				</td>
			</tr>
			<!-- �ĥ|�Q���h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2009�~1��4��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>�{����: v0.42�] Build #1
					<hr>�m��:
					<br><b>���զ��A���]�w</b>:
					<br>�@- <a href="#testSettings" style="font-size: 10pt;text-decoration: none;color: ForestGreen">�S������, �Ьݬݳo��...</a>
					<br><b>�Z����ξ����</b>:
					<br>�@- <a href="http://vsqa.dai-ngai.net/peb-u/wep.xls" style="font-size: 10pt;text-decoration: none;color: ForestGreen">�Z����</a>
					<br>�@- <a href="http://vsqa.dai-ngai.net/peb-u/ms.xls" style="font-size: 10pt;text-decoration: none;color: ForestGreen">�����</a>
					<hr>��s��x:
					<br><b style="color: ForestGreen;font-size: 12pt">php-eb v0.42�] Build #1 Close Test Version</b>
					<br>Debug:
					<br>&nbsp; - ��ԵL�G�ӥX��Bug, ���Ӧ��G��, ���Ӥw De ���F
					<br>&nbsp; - �u���@�ӻ�a��, �L�k�հʭx�O�X���@�ס@�ס�
					<br>&nbsp; - �ⳡ 00 ����o�� Trans-AM ��, ����۰ʧ�s�ۤv�Ϥ������D
					<br>�ק�:
					<br>&nbsp; - �ԳN�ǰ|
					<br>&nbsp;�@ - �{�b�ǧ��Ԫk�|�u�۰ʧ�s�v�ǤF���Ԫk
					<br>&nbsp;�@ - �{�b�i�H�ΩԤU�����ǲ߾ԳN (�w�� Firefox �����ʶR�ԳN�����D)
					<br>&nbsp; - Trans-AM �t�Χ�s
					<br>&nbsp;�@ - �ĪG:  -> �D�n�����F Trans-AM �ɶ�, �N���O�u�Ƨ@�Ρv����j
					<br>&nbsp;�@�@ - �԰��i��e�� 10% �}�� Trans-AM System
					<br>&nbsp;�@�@�@ - �}�� Trans-AM System, �����O�W�� 300% (�S���)
					<br>&nbsp;�@�@ - �b Trans-AM System �Ұʪ��A�U, �� 50% �ܦ^ �u��O�C�U���A�v (���e�� 90%)
					<br>&nbsp;�@�@ - �b �u��O�C�U���A�v �U, �� 50% �ܦ^ �u���`���A�v(���e�� 90%)
					<br>&nbsp; - �[�J�h��� GN �t�C�Z�� (�p����w���������), �� 00 Gundam ���Z��
					<br>&nbsp;�@ - GN Beam Sabre (���R���B���ѡB���S�e��)
					<br>&nbsp;�@ - GN Sword II (�������O�B�e��)
					<br>&nbsp; - �M��: �ⳡ 00 �� ���|���H�Z�ˤF (�ܹ�f������ Orz)
					<br>&nbsp; - ��a�C����W��: ��b, �{�� 2500
					<br>&nbsp; - �x�O�����W�ɤ@��: �{�� 2000
					<br>PM 5:06 �ɥR:
					<br>&nbsp; - ���߲�´�n��Q��}�]�����x�O�� Bug �w���h
					<br>&nbsp; - 9�M10�Ū��X���Z�������O���ɤF5-10%
					<br>PM 10:12 �ɥR:
					<br>&nbsp; - �[�J�H�U�����:
					<br>&nbsp;�@ - 00 Gundam & Trans-AM Mode Version
					<br>&nbsp;�@ - Tallgeese III
					<br>&nbsp;�@ - Hyaku-Shiki
					<br>&nbsp;�@ - Gundam MK-II
					<hr>�m�� : "<a href="http://vsqa.dai-ngai.net/peb-u/program/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: �����p�⾹ v2.0�\</a>" (�s����s�F)
					<br>�ק�BDebug!<br>�c... ���ѬO�������̫�@�ѤF T^T... (���W9�I����{�bOrz)
					<br>������ @ 2009�~1��4�� PM 1:50
				</td>
			</tr>
			<!-- �ĥ|�Q���h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2009�~1��3��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>�{����: v0.42�]
					<hr>�m��:
					<br><b>���զ��A���]�w</b>:
					<br>�@- <a href="#testSettings" style="font-size: 10pt;text-decoration: none;color: ForestGreen">�S������, �Ьݬݳo��...</a>
					<br><b>�Z����ξ����</b>:
					<br>�@- <a href="http://vsqa.dai-ngai.net/peb-u/wep.xls" style="font-size: 10pt;text-decoration: none;color: ForestGreen">�Z����</a>
					<br>�@- <a href="http://vsqa.dai-ngai.net/peb-u/ms.xls" style="font-size: 10pt;text-decoration: none;color: ForestGreen">�����</a>
					<hr>��s��x:
					<br><b style="color: ForestGreen;font-size: 12pt">php-eb v0.42�] Close Test Version</b>
					<br>�ק�:
					<br>&nbsp; - �[�J Mobile Suit Gundam 00 ���ⳡ��, �u�M���v�Ӫ�
					<br>&nbsp;�@�@- Gundam Exia, ���{�ɹ�
					<br>&nbsp;�@�@- 00 Gundam
					<br>&nbsp; - �[�J Trans-AM �t��
					<br>&nbsp;�@ - �ĪG: 
					<br>&nbsp;�@�@ - �԰��i��e�� 10% �}�� Trans-AM System
					<br>&nbsp;�@�@�@ - �}�� Trans-AM System, �����O�W�� 300% (�ܺA��)
					<br>&nbsp;�@�@ - �b Trans-AM System �Ұʪ��A�U, �� 90% �ܦ^ �u��O�C�U���A�v
					<br>&nbsp;�@�@ - �b �u��O�C�U���A�v �U, �� 90% �ܦ^ �u���`���A�v
					<br>&nbsp; - �[�J GN �t�C�Z�� (�p������������), �S�I: <b>������ EN</b>
					<br>&nbsp;�@ - GN-Drive
					<br>&nbsp;�@ - GN-Shield
					<br>&nbsp;�@ - Seven-Sword System
					<br>&nbsp; - Devil Gundam: ���F�s�Ϥ�
					<br>&nbsp; - Debug:
					<br>&nbsp;�@�@- �u���߲�´�v�b�u���߲�´��a�v�m�����C�t�C�]���g��[����Bug
					<br>&nbsp;�@�@- �ײz�u��: HP/EN �]�|�۰ʧ�s�F (���e�u�|��s�䤤�@��)
					<hr>�o�O "�j" ��s, XD
					<br>������ @ 2009�~1��4�� AM 00:14
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>�{����: v0.41�] Build #4
					<hr>�m��:
					<br><b>���զ��A���]�w</b>:
					<br>�@- <a href="#testSettings" style="font-size: 10pt;text-decoration: none;color: ForestGreen">�S������, �Ьݬݳo��...</a>
					<br><b>�Z����ξ����</b>:
					<br>�@- <a href="http://vsqa.dai-ngai.net/peb-u/wep.xls" style="font-size: 10pt;text-decoration: none;color: ForestGreen">�Z����</a>
					<br>�@- <a href="http://vsqa.dai-ngai.net/peb-u/ms.xls" style="font-size: 10pt;text-decoration: none;color: ForestGreen">�����</a>
					<hr>��s��x:
					<br><b style="color: ForestGreen;font-size: 12pt">php-eb v0.41�] Build #4 Close Test Version</b>
					<br>�ק�:
					<br>&nbsp; - HiMAT �� �u%�^�סv �ĪG��: �Ĥ�R���v * �u%�^�׮ĪG�v,
					<br>&nbsp;�@�@- ��: �R���v�O�i�H���L100��, 
					<br>&nbsp;�@�@�@�@ - ��: ���ݱ��p�U, �p�R����������, HiMAT �O�{������
					<br>&nbsp; - �u�ˮ`��K�ĪG�v��s: 
					<br>&nbsp;�@�@- ���, �ܿ�, �z�A, ���, �Ŷ��۹�첾: ��K�q-> 500, 1000, 1500, 2500, 3500
					<hr>�m�� : "<a href="http://vsqa.dai-ngai.net/peb-u/program/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: �����p�⾹ v2.0�\</a>" (�s����s�F)
					<br>���ӭӤp��s... (����٥H�����ѬO�@��T��ס@��")
					<br>������ @ 2009�~1��3�� PM 2:00 (�e��h�]�g�F�� 2008 �~ Orz)
				</td>
			</tr>
			<!-- �ĥ|�Q�|�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2009�~1��2��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>�{����: v0.41�] Build #3
					<hr>�m��:
					<br><b>���զ��A���]�w</b>:
					<br>�@- <a href="#testSettings" style="font-size: 10pt;text-decoration: none;color: ForestGreen">�S������, �Ьݬݳo��...</a>
					<br><b>�Z����ξ����</b>:
					<br>�@- <a href="http://vsqa.dai-ngai.net/peb-u/wep.xls" style="font-size: 10pt;text-decoration: none;color: ForestGreen">�Z����</a>
					<br>�@- <a href="http://vsqa.dai-ngai.net/peb-u/ms.xls" style="font-size: 10pt;text-decoration: none;color: ForestGreen">�����</a>
					<hr>��s��x:
					<br><b style="color: ForestGreen;font-size: 12pt">php-eb v0.41�] Build #3 Close Test Version</b>
					<br>Debug:
					<br>&nbsp; - �uHP���[�v�M�uEN���[�v��Bug
					<br>&nbsp; �@- ���|�A "Double Count" �F
					<br>&nbsp;  - �����̥��w�|�ϥξԪk��Bug
					<br>&nbsp;  - �԰��e�����u�i�JSEED Mode�v�ΡuEXAM�v��, SP ���Ӥ��|�ܪ����D
					<br>&nbsp;  - �b�u���߲�´�v�ʶR�����, ��T���������D
					<br>�ק�:
					<br>&nbsp; - �ε�����: �u��⪺????�Q�A���ѡv�令�u��⪺????�Q�A���}�v
					<br>&nbsp; - Menu:
					<br>&nbsp;�@ - �԰�
					<br>&nbsp;�@�@ - EN�����έײz���ɷ|�����ܤF
					<br>&nbsp;�@ - ���s�d���ܤj�F(�{�b�O���TD)
					<hr>�m�� : "<a href="http://vsqa.dai-ngai.net/peb-u/program/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: �����p�⾹ v2.0�\</a>" (�s����s�F)
					<br>�s����~ Debug ~ Debug~~ �x, �O���a? (����٥H�����ѬO�@��T��ס@��")
					<br>������ @ 2009�~1��2�� PM 11:08
				</td>
			</tr>
			<!-- �ĥ|�Q�T�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2009�~1��2��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>�{����: v0.41�] Build #2
					<hr>�m��:
					<br><b>���զ��A���]�w</b>:
					<br>�@- �S������, �ЬݬݤW�@�h��x...
					<hr>��s��x:
					<br><b style="color: ForestGreen;font-size: 12pt">php-eb v0.41�] Build #2 Close Test Version</b>
					<br>�@- �w�窱�A�Ȧb�O�@����U, �����S�����A��, �o�g�����F�� Bug
					<br>�@- �w��x���i��F�h���ץ�
					<br>�@�@ - �W�[��ӭx���u����v�B�u�x��v, ���b�u�L���v�P�u�U�h�v����, �{�b4000�u�\�Z�v���@�x��
					<br>�@�@ - �[�J��´/�b<u>���߲�´</u>�Q����: �W��2000�I�u�\�Z�v
					<br>�@�@ - ������´/�Q�Ѷ�/�k�`: �U��2000/4000/12000�I�u�\�Z�v
					<br>�@�@ - ���ɡu��´�H���v(�D���߲�´��) ��o�u�\�Z�v
					<br>�@�@�@ - ���h�F�u�\�Z�v�|�b��Ԥ����W�覡���`��Bug
					<br>�@�@ - ���߲�´��, �u�\�Z�v�אּ�W�� 48000�I (�ѧ��@�L�ɨ�ֱL), �Ӥ��O���������u�`�q�O�v
					<br>�@�@ - �h�쭭��: 72000 �I (��N), �ƥD�u�һݡu�\�Z�v: 60000�I (�֮�)
					<br>�@- �{�b�������Ѷ�����´�H���~�i�H�Ѵ���´
					<Br>�@- Debug:
					<Br>�@�@- ��ԵL�G�ӥX��Bug, <b>���T�w�O�_�w DE �F</b>, �j�a�V�O����!!
					<hr>�m�� : "<a href="http://vsqa.dai-ngai.net/php-eb/prog/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: �����p�⾹ v2.0�\</a>"
					<br>�ﱵ�s���@�~ Orz... �Q��~... v0.25Final �b 1��1�� �� �s�� ���X�O, ���F�Ʊߩ], �u�h�� >_<"
					<br>������ @ 2009�~1��2�� AM 3:19
				</td>
			</tr>
			<!-- �ĥ|�Q�G�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2008�~12��30��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>php-eb Ultimate Edition, ²�١upeb-u�v�ʴ������}�l�I
					<br>�{����: v0.41�]
					<hr>�m��:
					<br><a name='testSettings'><b>���զ��A���]�w</b></a>:
					<br>���w, �|�]�����p���ܳ]�w
					<br><b>���եت�</b>:
					<br>�@- �C��������  
					<br>�@- �����˩w
					<br>�@- Bug ����
					<br>�@- �w���� ����
					<br>�@- �į� (�C���y�Z��)
					<br><b>�ثe�W�h</b>:
					<br>�@- 30�ūe<b>���i�H</b>�ϥΥ~���ס@��"
					<br>�@�@ - 30�ū�Ч�ڬ۰Q, �ʴ����O�h�� XD
					<br>�@- ���Bug, �Ц^��
					<br>�@�@ - ����覡, MSN�BE-Mail�Bphp-eb��ѫǡB�U�׾ª�PM�B�q�� (������)�Betc...
					<br>�@- <b>�O�K</b>�ʴ����e�B�������
					<br>�@- ������ �� v2Alliance �O�d�@�����W�h���v�Q Orz
					<br><b>���U�榡</b>:
					<br>�@- �Χڨ������Τ�W�ٶ}�Y
					<br>�@�@ - ������ӥΤ�W�٫�[�W�Ʀr
					<br>�@�@ - ��: �ڨ������Τ�W�� -> gary
					<br>�@�@�@�@- �D�b��username: gary
					<br>�@�@�@�@- ����: gary1, gary2, gary3 ... (<s>�j�Ӷ����ۥD�v</s>, <i>��ӨS����</i>)
					<br>�@�@ - ��������Q�o�{�|�Q<b>�R��</b>
					<br>�@�@ - <b>�C�������W��<u>�S������</u></b>
					<hr>��s��x:
					<br><b style="color: ForestGreen;font-size: 12pt">php-eb v0.41�] Close Test Version</b>
					<br>- ���A�ȳ]�w���
					<br>�@ - �������u���a��, ���A�Ȥ��|����֩� +10% (�Y +10% �H�U���|��)
					<br>�@ - �O�@�s�����:
					<br>�@�@�@ - 50�ťH�U, ���A�Ȥ��|����
					<br>�@�@�@ - �����̰������� 20��, ����q��b
					<br>�@ - ��Գ]�w: �����b�u�H��, ���A�Ȧ���q�� 2 �� (����)
					<br>�@ - �Q���}��, �B�~�������A�ȥ� 100 ��� 20
					<br>�@ - �u�b�u��M�v�����A�ȷl�ӫ׭��ƥ�: 50 ��� 25
					<br>�@ - �t���A�Ȯ�, EN���Ӳ��`�a�֪�Bug�wDE�F
					<br>- ���:
					<br>�@ - ���߲�´���|�A�����u�q���ѤF
					<br>�@ - �ϰ��T�|��ܡu�x�O�B�u�Ư�O�v�F
					<br>- ��´
					<br>�@ - ���ܤJ��´���|��l�ƭx���F
					<br>- �԰��e��
					<br>�@ - ���ܤF���A�ȼW���ܤ覡
					<br>�@ - �u�԰��v�ֱ���[�J�˼�, ����X�{�L�֪��T��
					<br>- ��Ǯw
					<br>�@ - �S�������ɤ���A���u���X�v�M�u��e�v�F
					<hr>�o���٬O�n�m�� : "<a href="http://vsqa.dai-ngai.net/php-eb/prog/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: �����p�⾹ v2.0�\</a>"
					<br>���F�n�X��... ���Ѳש󦳮ɶ����F= =
					<br>������ @ 2008�~12��30�� PM 8:27
				</td>
			</tr>
			<!-- �ĥ|�Q�@�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2008�~12��27��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>php-eb Ultimate Edition, ²�١upeb-u�v�ʴ������}�l�I
					<br>�{����: v0.4�]
					<br>�P v0.4�\ �����@�w�{�ת����O...
					<br>���h���F... �U�観��x...
					<hr>��K:
					<br><b>���զ��A���]�w</b>:
					<br>���w, �|�]�����p���ܳ]�w
					<br><b>���եت�</b>:
					<br>�@- �C��������  
					<br>�@- �����˩w
					<br>�@- Bug ����
					<br>�@- �w���� ����
					<br>�@- �į� (�C���y�Z��)
					<br><b>�ثe�W�h</b>:
					<br>�@- 30�ūe<b>���i�H</b>�ϥΥ~���ס@��"
					<br>�@�@ - 30�ū�Ч�ڬ۰Q, �ʴ����O�h�� XD
					<br>�@- ���Bug, �Ц^��
					<br>�@�@ - ����覡, MSN�BE-Mail�Bphp-eb��ѫǡB�U�׾ª�PM�B�q�� (������)�Betc...
					<br>�@- <b>�O�K</b>�ʴ����e�B�������
					<br>�@- ������ �� v2Alliance �O�d�@�����W�h���v�Q Orz
					<br><b>���U�榡</b>:
					<br>�@- �Χڨ������Τ�W�ٶ}�Y
					<br>�@�@ - ������ӥΤ�W�٫�[�W�Ʀr
					<br>�@�@ - ��: �ڨ������Τ�W�� -> gary
					<br>�@�@�@�@- �D�b��: gary
					<br>�@�@�@�@- ����: gary1, gary2, gary3 ... (�j�Ӷ����ۥD�v)
					<br>�@�@ - ��������Q�o�{�|�Q<b>�R��</b>
					<br>�@�@ - �C�������W��<B>�S������</B>
					<hr>��s��x:
					<br><b style="color: ForestGreen;font-size: 12pt">php-eb v0.4�] Close Test Version</b>
					<br> - �����Z���ݨD��O�ȤίS�ħ�
					<br> - �ܮw�t���X�R
					<br>�@ - ��Ǯw
					<br>�@�@ - �ذe����t��
					<br> �@- �Z���w�t��
					<br>�@�@ - �m��X���t��(���]�A��Ƥ�)
					<br> - �M�˾���t��
					<Br>�@ - �C�����١u��´���K��s�ҡv
					<br>�@ - ��������N����A�����ʶR
					<Br>�@ - �אּ�ݭn�u��a�v�~���ʶR
					<br>�@�@ - �ݭn�F��u��a�ƥءv�B�u�x�O�v���n�D
					<br>�@�@ - �M�˾���@��|���e�u�`�W�˳ơv, �����O���I, �����O�u�I...
					<br> - ��ˡu�ƥD�u�v
					<br>�@ - �p�G�u�D�u�v�O��, ����u�ƥD�u�v�N�O�ۤF
					<br>�@ - �S�����v�O: �ž�, ����´�]�w, �Ѷ��D�u�B�h�쵹�D�u��
					<br> - Debug
					<Br>�@ - ������aBug: �q���ĤH�x�O�ܹs���~�|, ��������a�� Bug
					<hr>�o�ӭn�m�� : "<a href="http://vsqa.dai-ngai.net/php-eb/prog/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: �����p�⾹ v2.0�\</a>" �ܦ���
					<br>���F= =... ������, ��p...
					<br>�S�Q��M���t�η|������Ӯɶ�(�ר䨺 GUI)...
					<br>�ʴ������}�l, ��Ƿ|�]�w�u���DNPC�v�Ѥj�a�m�\...
					<br>�V�O~
					<br>������ @ 2008�~12��27�� AM 1:28
				</td>
			</tr>
			<!-- �ĥ|�Q�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2008�~12��19��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>Debug! ���� De �F�@�� Bug
					<br>��Ӥ��e�S����a����´�O�u�����i�H�žԪ��I XD
					<br>�o�� Bug �w�Q De �F... ||Orz...
					<br>�~�M�ѤF�o�@�I�O = =" �S��a����i��, �����Ӧ���a����´ XD
					<br>�t�~, �綶�K De �F�Y�ϰ�S�H�N��������Ӱϭn�몺 Bug...
					<hr>��s��x:
					<br><b style="color: ForestGreen;font-size: 12pt">php-eb v0.4�\ Build #3</b>
					<br> - ���h�S����a�N����žԪ� Bug
					<br>�@ - ��Ԩt��: �[�J�F�u�_�q�v�l�t��
					<br>�@�@ - �S����a����´�i�H�z�L�u�_�q�v�ž�
					<br>�@�@ - �x�O�O�Y�ɱ��ʪ�, �ƶq�Ѳ�´�H���ƥبM�w, �̦h���C����W�����⭿
					<br> - ���h�S���H�b�Y�ϰ�S�H�N��������Ӱϭn�몺 Bug
					<hr>
					�o�ӭn�m�� : "<a href="http://vsqa.dai-ngai.net/php-eb/prog/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: �����p�⾹ v2.0�\</a>" �ܦ���
					<br>�ֶ}�l�ʴ��F~�֤F�֤F~~
					<br>ps. �ڦn���٦b Examination Period = =|| �u����...
					<br>������ @ 2008�~12��19�� PM 4:05
				</td>
			</tr>
			<!-- �ĤT�Q�E�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2008�~11��29��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>�@�@...
					<br>������ı, �o������ php-eb �j�P�W�w�g�����F,
					<br>�o��B�T�ѥ�⥼�����ӤS�����n�����������F(¶�f�O)
					<br>�⨺�ӥs���u�ݭn�ȡv���t�ΤޤJ�ù�˫�...
					<br>php-eb ���t�I�ݭn���G�ܤF��~~~ �h�O @_@" ...
					<hr>��s��x:
					<br><b style="color: ForestGreen;font-size: 12pt">php-eb v0.4�\ Build #2</b>
					<br> - SP�C�I�ݭn�����I�ƥ� 2�I, �[�� 5�I
					<br> - �󥿡u�ݨD�ȡv�u���{�פ��Τj�����S��ĪG���޿���D(�]�N�O��, �쥻�S���ĪG = =)
					<br> - �ҧ缾�a�g��Ȥ��� (���A�Ȥ���)
					<br>	 - ����:
					<br>�@�@�@ - �򥻸g�� = �ľ��v����<suf>2</suf> + �w�x���� * 0.01 + �ĭx���� * 0.02 ; �x���Ȫ��d�� : 0 �� 100,000
					<br>�@�@�@ - �����ұo�g�� = �򥻸g�� * �Ĥ覩�媺���; �Ĥ覩�媺��ҬO...
					<br>�@�@�@�@�@�@�@ �ˮ`�� / ��q�W��, �p�Ѿl��q���F�ˮ`��, �h �ˮ`�� = �Ѿl��q
					<br>�@�@�@ - ����ұo�g�� = �����ұo�g�� * 1 + (�w�W�n / 2000) + 10; �Y�O�C�I�W�n +0.05% �g��
					<br>�@�@ - �������Ť�ۤv�� 35 �Ū�, �u�����ұo�g��v ��b, �W�L 50 ��, �A��b (�Y�Ѿl��Ӫ� 1/4)
					<br>�@�@ - �̫�@���S���g��[��(�ϦӦ]���ˮ`�� = �Ѿl��q�Ӹg��|�����), �����ӧQ�Z�� (�H�e�S����, ���{�b��)
					<br>�@�@ - ��譱�Q����, �����ұo�g�� * 0.7
					<br>�@�@ - ����P�k���, �����ұo�g�� * 0.8 (�]�����ۤ~�O�Ԫ��ڡI�I)
					<br> - ���ʦh��Z���[�J�ݨD��,
					<br>�@ - �t�I�ɭn�n�n�Ҽ{�έ��@��Z����...
					<br>�@�@ - �o�� : "<a href="http://vsqa.dai-ngai.net/php-eb/prog/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: �����p�⾹ v2.0�\</a>" �ܦ���
					<hr>�ʴ�... �]�Ҽ{��11����M12�Y(�Φ�12�뤤)�O�ǥ̪ͭ��Ҹմ�...
					<br>�ҥH... ������12�뤤��12���... (ԣ!? �٦��@�Ӥ�!!!???)
					<br>���L, �o�n���O�������o��u�T�w�v���ʴ�����a?
					<br>�ʴ��������ӷ|�O�uphp-eb v0.4�], Build Dev. Version, Official Closed Test Version�v
					<br>�y��A�|���G�Ա�...
					<br>������ @ 2008�~11��29�� PM 2:00
				</td>
			</tr>
			<!-- �ĤT�Q�K�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2008�~11��25��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>�A�S�ݿ�...
					<br>�o�O��s = =||
					<br>�T�Ӥ�᪺��s...
					<br>�T�Ӥ�S�T�Ӥ�... �T�Ӥ뤧��S�A�T�Ӥ�... Orz...
					<br>���n 9��1�� �e�ʴ�, ��{�b�٨S�O= ="
					<br>�s���ͬ���Q�����ӱo���L...
					<br>�p��F... �p��F =__=||
					<br>�c...
					<br>�٬O���s����s�O...
					<hr>��s��x:
					<br><b style="color: ForestGreen;font-size: 12pt">php-eb v0.4�\</b> (��������)
					<br> - �ⵥ�ŤW�����ɦ� 150 ��
					<br> - ����W���]���ɦ� 150
					<br> - �{�b�i�H�� �����I�� �� SP �W���F
					<br> - �g�礽�����ҧ���
					<br>�@ - �� �Y100�� ���g���`�M, �ѭ���� 1.1�� �U���� 1��
					<br>�@�@ - �{�b 99�� �� 100�� �ݨD�g��: 3,942,611; ��_����� 1�d�U �֫ܦh, ���e 90�� �]�n�� 400�U �F...
					<br>�@�@ - �����~���ɤF...
					<br>�@�@�@�@ - �p:
					<br>�@�@�@�@�@ - 80�ť� 182�U �W�ɦ� 200�U (90�Ŧb�s�����U�ݭn����ָg��)
					<br>�@�@�@�@�@ - 70�ť� 95�U �W�ɦ� 140�U
					<br>�@�@�@�@�@ - 60�ť� 24.8�U �j�T�W�ɦ� 88.5�U
					<br>�@�@�@�@�@ - 30�Ū��һݸg����`�M, ���t���h�O�¤����U��47��
					<br>�@ - ���L�W���C�F�ܦh, �Ʊ榳�U���ɦ����Z�������n��
					<br>�@ - �Y�ƯŤ��A�O�@���Y�ɤF = ="
					<br>�@ - �g��ݨD���G�ܱo��������F
					<br>�@ - 150�Ÿg���`�M�� 506,508,776, ������1�Ťɨ�100�� 5�� (�������I�ƥu�O1��)
					<br>�@ - 125�Ÿg���`�M�� 252,148,910, ������1�Ťɨ�100�� 2.5��
					<br>�@ - �s�g���: <a href="http://vsqa.dai-ngai.net/php-eb/prog/gen_info.php?action=cal" style="font-size: 10pt;text-decoration: none;color: ForestGreen">http://vsqa.dai-ngai.net/php-eb/prog/gen_info.php?action=cal</a>
					<br>�@ - �¸g���: <a href="http://vsqa.dai-ngai.net/php-eb/prog_legacy/gen_info.php?action=cal" style="font-size: 10pt;text-decoration: none;color: ForestGreen">http://vsqa.dai-ngai.net/php-eb/prog_legacy/gen_info.php?action=cal</a>
					<br>
					<br><a href="http://vsqa.dai-ngai.net/php-eb/prog/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: �����p�⾹ v2.0�\</a>
					<br>�@ - �]����s, �ݬݨ��̪���x�a...
					<hr>�X�ɫʴ�?
					<Br>�ګܷQ�O���ӬP�����B��...
					<br>�������D�ɶ���_���\�O...
					<br>�Ʊ�U���g��x�|�O���Ӥ몺 >_<" (�]�N�O���P����).... 
					<br>������ @ 2008�~11��26�� AM 12:09
				</td>
			</tr>
			<!-- �ĤT�Q�C�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2008�~08��25��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>����... �ש��u�s�D�԰��t�Ρv�����������g�n�F (�_)
					<br>�n���ΤF�T�Ӥ�a?
					<br>�ܸرi�O...
					<br>�^�Q�H�e�]�u�O�@�Ӥj�����N������F��g�n...
					<br>�{�b���u�@�Ĳv�i��񩹤��C-�ס@��||
					<br>���L, �����F�N�O�����F...
					<br>php-eb �s�����w���B�J�ʴ����q...
					<br>�٤���? �N�O���ǭ׭q����ư�...
					<br>�n���l��O, �n��M�ݾ���, �s����, �Z����O�ίS�ĭ׭q...
					<br>�٦����ӥs�������t��= =||
					<br>�o�Ǥ��O�t�Χ�s, �o���ʤ�...
					<br>�Ʊ�@�����Q�a~
					<hr>��s��x:
					<br><b style="color: ForestGreen;font-size: 12pt">php-eb v0.4�\</b>
					<br>- �԰��t��
					<br>�@ - ������ˡu�x�O�t�Ρv
					<br>�@ - Debug: ��Ԯɤ��|�ײz�ĤH��Bug
					<br>- ��Ԩt��
					<br>�@ - ������ˡu�s��Ԩt�Ρv�Ρu�x�O�t�Ρv
					<br>�@ - �t�Τw���� - �q�žԦܦ���찱��
					<br>�@ - ���^�ƭײz�u�t�u�Ԫ���������A�ȡv���]�w
					<br>- �Y�ɲ�Ѩt��
					<br>�@ - �o�O�{�ɥ[�J���t��
					<br>�@ - �{����Ѩt�Ϊ��X�R
					<br> �@- ���ѡu���}�W�D�v���Y�ɲ��
					<br>�@�@ - �ٻݷL�է�s�v�M�Q�ʧ�s���� (�{�b�u���p�ɦ۰ʧ�s)
					<br>- �@�E���ɮק�s�F: cfu.php, chat.php, city.php, gmscrn_base.php, gmscrn_right_menu.php,
					<br>�@�@�@�@�@�@�@�@�@�@organization.php, battle-2.php, battle.php, battle-filter.php
					<br>�@�@�@�@�@�@�@�@�@�@(index.php ����x, �ĤQ���ɮ�)
					<hr>���Ѫ���s���ܦ��N���, �]�H�x v0.3x �����׵��B v0.4 �������{...
					<br>�ܻ�... �ӥH�������R�W�覡, �o�ӷs�������ӬO�uv0.40�v�~��... (�����H�i��|�s�o��4.0��XD)
					<br>��᭱���u0�v�ٲ��h, ��O�V���d�F�ܤ[���T�� v0.3x �����P�q�a?
					<br>�U�@�Ӫ���, �i�ઽ���R�W���uv0.50�v�Ϊ�... �u�̲ת��v php-eb Ultimate Edition v1.0
					<br>�n, �즹����~ �ʴ��|�t��q��... �j�n�E��@��H�e�|�a?
					<br>������ @ 2008�~08��26�� AM 2:49
				</td>
			</tr>
			<!-- �ĤT�Q���h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2008�~08��24��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>���Ѷi�x�԰��t��...
					<br>�ܽ���, ʨ...
					<br>�ĪG��O�����a,
					<br>���o�{�ܦhBug...
					<br>���ӥ��Ӥ@��Ѥ��৹���F...
					<br>���N�̷ǳƫʴ��aOrz...
					<br>���L�n���֦^��}�ǩu�`�F...
					<hr>��s��x:
					<br>php-eb v0.39�\
					<br>- �԰��t�� 
					<br>�@ - ��ˡu�x�O�t�Ρv
					<br>�@�@ - �򥻤W�w����, �x�O�|���F
					<br>�@�@ - �������n��M����B�ΧP�w�֦��ֱ��٨S�d�n
					<br>�@�@ - �S��˴��չL, �ܦh Bug ���ˤl
					<br>- cv-fi.inc.php
					<br>�@ - �[�J�u����vFunction, �{�b�����a��|�ι���Ũ��...
					<br>- sfo.inc.php
					<br>�@ - �j�� MS ��Ʈ�, �|�s Price �@���j�M
					<br>�@�@ - �o�O���F�x�O�t��...
					<br>- gmscrn_base.php
					<br>�@ - �{�b�|��ܤv��u�{�x�O�v�F
					<hr>�������ѯ�_�����O~?
					<br>ps. ���Ѩ����~�򤣾A ��_��
					<br>������ @ PM 8:05
				</td>
			</tr>
			<!-- �ĤT�Q���h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2008�~08��23��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>�c... ���Ѧ��I���A, ���వ�Ӧh�F>_<||
					<br>De �F Bug... �]�u���o��h ��_��
					<hr>��s��x:
					<br>php-eb v0.39�\
					<br>- CFU
					<br>�@- Debug + �ק�: PM 12:xx ���~��ܬ� �W�� 12:xx
					<br>�@- �{�b PM 12:xx �|�g�� ���� 12:xx; AM 12:00 �h�ܦ� �s�� 12:00
					<br>- battle-filter.php
					<br>�@- Debug: ��´���~��ܪ�Bug
					<hr>�ߦ�... ���I/�����~��a...
					<br>������ @ PM 1:23
				</td>
			</tr>
			<!-- �ĤT�Q�|�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2008�~08��22��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>�S�O "�P�@��" �� "��h" ��x�F...
					<br>���Ѻ�O��s�o�ܺƨg, �����ֹF��ؼЮ�, �|����ƨg�a XD
					<br>�o�O�s����x:
					<hr>��s��x:
					<br>php-eb v0.39�\
					<br>- �u�x�O�t�Ρv
					<br>�@ - �հʭx�O ~ �ץ�
					<br>�@�@ - �{�b��Ӥ��P����´, ��P�@�a�I�ž�, �Ӱϰ��D�i�H���O"�^��"�F
					<br>�@�@ - ���v�|�������F
					<br>- �ž�
					<br>�@- �A�ﵽ�F���v�ε��M��ܤ覡
					<br>- �u�԰��t�Ρv
					<br>�@- �{�b�|���T��ܼĤH�F
					<br>�@- �u�x�O�t�Ρv���������
					<hr>���I�b���o~
					<br>������ @ 23�� AM 2:19
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>�E�����y~ ���쥿�a~�����a�I
					<br>�ӭӤQ�����a~~XD
					<br>���ѥ���, �������, �����ܱo�ܺC...
					<br>�ҥH�������u...
					<br>���L�]�����F�u�e���u�áv���t�ΤF
					<br>�{�b, ���x�O�B�S���u��, �U�ƭѳ�, �u��F��~
					<br>�Ӫﱵ v0.40Alpha �a~
					<hr>��s��x:
					<br>php-eb v0.39�\
					<br>- �u�u�èt�Ρv
					<br>�@ - �u�s��Ԩt�Ρv���@����
					<br>�@ - �{�b�i�H�e���u�äF
					<br>�@ - �C�Ӱϰ�(�l�ϰ�)�u��t�m�|�Ӧu��
					<br>�@�@ - �u�ä��|�l�Ӧu��x�O(�Ϊ̷|�אּ�����I)
					<hr>�u�ðt�m���t�Ψ�ꥼ����Q�n, �γ\�|�אּ�C�ѥu�ഫ�@��,
					<br>����L�O�@�_�p,
					<br>�����x�O����o���I�u�}���v,
					<br>���ݬ�s��s~
					<br>������ @ PM 2:43 ~ �E�����a���ĵ�i�H���{���ͮġC
				</td>
			</tr>
			<!-- �ĤT�Q�T�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2008�~08��21��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>���P�@�馳 "��h" ��x�� XD
					<br>�o�O���| (���
					<br>�n, ���x�F XD
					<br>�|�I�����k�S�^���~��...
					<br>�w�g��u�x�O�t�Ρv��, ��u���լ��x�O���t�μg�n�F~~
					<br>�o�O�s����x:
					<hr>��s��x:
					<br>php-eb v0.39�\
					<br>- �u�x�O�t�Ρv
					<br>�@ - �{�b��u��賣�i�H�հʭx�O�F
					<br>�@ - �հʭx�O���ʶR�x�O��, �ƶq�]�w���u�v(�ť�) �� 0 ��, 
					<br>�@�@�@ ���|�Υh�հʩ��ʶR�����|�F
					<br>- �ž�
					<br>�@ - ���v�W�|����լ����x�O�Φ�ʥN�����
					<br>�@�@ - �y���ﵽ�F�ε��M��ܤ覡
					<br>- �X���q����
					<br>�@ - �{�b���u��]���u�X���q���ѡv�F
					<br>�@ - ���ܤF�ε�, �H�t�X�u�x�O�t�Ρv
					<hr>���I�b���o~
					<br>������ @ PM 10:11
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>�s���žԨt�Τw�g�g�n�F, �����ԡB��ԡB����B���٨S...
					<br>�n�n�n�[�o�F@_@
					<hr>��s��x:
					<br>php-eb v0.39�\
					<br>- �u�x�O�t�Ρv
					<br>�@ - �{�b�žԮɥi�H�հʭx�O�F�I
					<br>- �ž�
					<br>�@ - ���v�W�|����լ����x�O�Φ�ʥN�����
					<hr>���I�i��|�~��~
					<br>������ @ PM 2:08
				</td>
			</tr>
			<!-- �ĤT�Q�G�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2008�~08��20��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>�Q�ѱq O-Camp �^��, �ܲ֫ܲ�, ��ܵh >_<....
					<br>���L�����٬O�~��g~
					<br>�i�O�i�ר�ثe�o�謰��, ����ܦh�O @_@
					<hr>��s��x:
					<br>php-eb v0.39�\
					<br>- �u�x�O�t�Ρv
					<br>�@ - �W�j�x�O�� GUI �� �t�� �������F
					<hr>�{�b�u�t�հʭx�O, �M�u�x�O�t�Ρv���D��...
					<br>������ @ PM 3:03
				</td>
			</tr>
			<!-- �ĤT�Q�@�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2008�~08��15��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>����... �i�׽w�C... �Q�ѫh�h�F Pre-Camp �S�żg XD ... <br>���ӼƤѤ]���ӨS�ɶ��� ||Orz...
					<hr>��s��x:
					<br>php-eb v0.39�\
					<br>- �u�x�O�t�Ρv
					<br>�@ - �W�j(�Y�ʶR)�x�O�� GUI, �j�P�W�����F
					<hr>���ӬP�������쪺���|���j �ס@��|||
					<br>����... �U�����F ||Orz
					<br>������ @ PM 10:25
				</td>
			</tr>
			<!-- �ĤT�Q�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2008�~08��13��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>���Ѫ��i�פ���ܦn, �����i�H����, �o�X�ѳ����O���ܦh�Ŷ��ɶ�...
					<br>�u�s�D�԰��t�Ρv, ���O�ޤJ�u�x�O�t�Ρv���u�԰��t�Ρv...
					<br>��԰��t�ν����ƤF�@�I�I, �]���A�����e�@��, ������XD
					<hr>��s��x:
					<br>php-eb v0.39�\
					<br>- Debug
					<br>�@ - �Q�Ѥ�����a De ���쪺 bug
					<br>- Data table ����s
					<br>�@ - area_map
					<br>�@�@ - �[�J tickets (�����ϰ쪺�x�O)
					<br>�@�@ - ���� development ���γ~, �N�|�ΨӰO���W�����x�O���ɶ�
					<br>- ����w�q�x�O�t��
					<br>�@ - Area ����
					<br>�@�@ - �̦h 50000, �̤� 1
					<br>�@�@ - �ݭn�u�հʡv��
					<br>�@�@ - �ݭn��ꪺ, ��̰��B: 5000�I, �C�I����: $1,000
					<br>�@�@ - �p���e�һ�, ���ƦX���p��, �j���̦h�� 100, �p��d��: ����B�Z���B���v
					<hr>�Ʊ椵�ӬP��������~^_^
					<br>�U����~
					<br>������ @ PM 5:44
				</td>
			</tr>
			<!-- �ĤG�Q�E�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2008�~08��12��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>��... �Z���W�@����x�w�g�O��ӬP���FXD
					<br>�o�}�l���ܦ� XD
					<br>���L, �����^�챱��d�򤺤F
					<br>����, ���������}�l�ʤu���o�ӥs�u�s�D�԰��t�Ρv���F��
					<br>���F�@�Ƿǳƥ\�ҩM�إߤF Datatable...
					<br>���Ѥ]�ܦ� XD
					<br>�U��(����?)�~��~
					<hr>��s��x:
					<br><b style="color: ForestGreen;font-size: 12pt">php-eb v0.39�\</b>
					<br>- Debug
					<br>�@ - organization.php �@�Ǥp Bug
					<br>- �إ� data table: user_war
					<br>�@ - �x�s�Ԫ������
					<br>- ��L Data table ����s
					<br>�@ - user_organization
					<br>�@�@ - �R�h opttime, optstart, optmission, optmissionb, optmissionc
					<br>�@ - area_map
					<br>�@�@ - �[�J defenders (�����֤H�t�d���m�n��)
					<br>- organization.php
					<br>�@ - �s�t�� Migration ���ǳƥ\�@
					<br>�@�@ - ���s�w�q Index: optmissioni
					<Br>�@�@ - �ϥ� t_start �M t_end ���N���Ӫ� opttime �M optstart (���T�M���ܦh)
					<hr>�Ԫ��x�O�٥��w�q, �j�n�U���N�i�H�w�q�쪺�F~
					<br>������ @ PM 6:08
				</td>
			</tr>
			<!-- �ĤG�Q�K�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2008�~07��29��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>��Q���������o��... ���b�h�óo�O���O�j��s= =||...
					<br>�{�b�a���X�R�F, ��9����36��, �j�F4��...
					<br>���... �@�ɨèS���j�F, �u�O�n��h�F...
					<br>�{�b�C�@�Ϥ]�����uE�BS�BW�BN�v(�F�n��_)�|����, �C���Ϥ]���W�߭n��,
					<br>�j�ϻP�j�Ϥ����i�H�p���`����, �ӥB�b�P�@�j�Ϥ��i�H�������(�����B��P�@�p�Ϥ�)
					<br>�򥻤W�u�O�h�F�n���...
					<br>���ʪ��e���]�}�G�F�@�I�I...
					<br>����|��C���ϭn�몺�]�w����a���(�{�b�O�C���ϭn��]�O�@�˪�)
					<br>�i�O�X�R����... �t�ΤW���ۥѫ׷|�U���O //Orz
					<hr>��s��x:
					<br>php-eb v0.38�\
					<br>- Debug
					<br>�@ - �ۭq�԰��C��, �S��u���MS�v�@����, �|�ܥi�Ȧa�C�X���h���й�⪺Bug
					<br>- �a���X�R
					<Br>�@ - �{������h���n��i�H����F
					<br>�@ - �H���Ϫ��Φ��X�R
					<br>�@�@ - ����W, �ϻP�Ϥ������ʳt�פ���
					<br>�@�@ - ��ݨ��B��P�j�Ϫ����
					<br>�@�@ - �u��ݨ����ϩ��ݪ��n��
					<br>�@ - �y�����ƤF�u���ʡv�t��...
					<hr>���U�Ӫ��u�u�����v�j��s... �s��Ԩt��...
					<br>�p���ѤW�O�g�o�ܺ}�G�S��, ����ڷ|�_�ܦn���O�@�Ӱg @_@||
					<br>������ @ PM 2:31
				</td>
			</tr>
			<!-- �ĤG�Q�C�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2008�~07��28��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>�Q�ѥh�F�Ѯi, �Ȱ��@��...
					<br>���Ѥ]�S������j��s, �D�n���ODe�@�Ǥpbug...
					<br>�٦��ǳƱ��U�Ӫ���Ӥj��s...
					<br>�{�b�������פj����50%-60%�a...
					<hr>��s��x:
					<br>php-eb v0.38�\
					<br>- Debug
					<br>�@ - gmscrn_base.php
					<br>�@�@ - �h�����v�[���|�]�A����[�������~���
					<br>�@�@ - �{�b�|����zSeed����O�[���q�F
					<br>�@ - gen_info.php �M information.php
					<br>�@�@ - �]�w����Variable����l��...
					<BR>�@ - equip.php
					<br>�@�@ - �˳ƱM�ΤƧ�y�F�����U�˳Ʈ�, �|�X�{�u&lt;sub&gt;&amp;copy;&lt;/sub&gt;�v�r��
					<hr>�j�a���S���o�{... �����A�������U�˳Ƥ]����M�ΤƧ�y�OXD
					<br>�ڤ]�S�oı, ����~
					<br>������ @ PM 1:50
				</td>
			</tr>
			<!-- �ĤG�Q���h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2008�~07��26��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>�{�b�OAM 11:36...
					<br>�ӱo���������xXD
					<br>�����D�n�O Debug...
					<br>��D�n���O De �s�u�۰ʺ��סv�t�Ϊ�Bug...
					<br>�ӥB�����ɮפ]�ΤF�s�u�۰ʺ��סv�t��...
					<br>�p����ܱo�����T...
					<br>�i�ײz�Q... �i���ߤF�@��Orz...
					<br>�귽���ӫh�S�������...
					<hr>��s��x:
					<br>php-eb v0.38�\
					<br>- Debug
					<br>�@ - �s�u�۰ʺ��סv�t�ΰ���
					<br>�@�@ - �{�b�u�۰ʺ��סv�M�۰ʧ�s��[�t�X�F
					<br>- �����ĥηs�u�۰ʺ��סv�t��, repairplayer-f.inc.php
					<hr>���ư����I�|�~��g...
					<br>������ @ AM 11:40
				</td>
			</tr>
			<!-- �ĤG�Q���h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2008�~07��25��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>���ѨS�e�X�Ѫ����򶶧Q�F...
					<br>�u�Ʀ۰ʺ��ת����G���Ӳz�Q
					<br>�Ʀ��ܱo����Ӹ귽...
					<br>���L�{�b���B�⤽���j��W�i��i�H�`�ٸ귽...
					<br>���e�����D�n���]�ѨM�F�@�I�I...
					<br>�԰��C��, ��Ԫk���̤]�ĥ�������Ԩt�Ϊ����ؤ覡...
					<br>�G�M, �n�u�Ʀ۰ʺ��פ@�I�]���e�� XD
					<hr>��s��x:
					<br>php-eb v0.38�\
					<br>- �u�ơu�۰ʺ��סv
					<br>�@ - �ڤ]�����p���u�ƤF����...
					<hr>��... ������ @ PM 9:08
				</td>
			</tr>
			<!-- �ĤG�Q�|�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2008�~07��24��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>����, �D�n���O�b���Q�Ѵ��ιL��...
					<br>�o�ӡu�� NT �[���@�Ӧ������A�Ȫ��S���O�v..
					<br>�Ρu��s�ۭq�C��v(�Y�O�u�԰��C��L�o�t�γ]�w�v����s)...
					<br>�٦��@�X�@�ǦC���u��... ���L�ĪG�礣�ө���...
					<br>�Φۭq�C���M�٬O�|�֫ܦh�N�O�F...
					<br>�p�G���d�N����, �Q�Ѫ������O v0.37�\, �Ӥ��Ѫ��h�N�|�O v0.38�\...
					<br>�i�׾���ӻ��u�ݤ@��... �u�ƦC���F�ܦh�ɶ�... �Ȥ��ȱo�N... �����D�F@_@"
					<hr>��s��x:
					<br><b style="color: ForestGreen;font-size: 12pt">php-eb v0.38�\</b>
					<br>- �s�W NT Hyper �ƮĪG
					<br>�@ - �o�O NT �W�����ĪG, �s�j�ƤH�]�S��
					<br>�@ - �ĪG�W��: �w�P
					<br>�@ - �o�ʱ���:
					<br>�@�@ - NT Hyper �ƫ�(70�ū�۰ʵo��)
					<br>�@�@ - ���U�˳ƪ��A�ȹF +25%
					<br>�@ - �o�ʤ覡: ����Ұ�(�p�i�JSEED Mode�M�}Exam System����)
					<br>�@ - �ĪG:
					<br>�@�@ - �L�ĤƤ@���P�R�ʪ��������ˮ` (���M�|�Q�P�w���Q����)
					<br>�@�@�@ - �����U�˳ƪ��A�ȷ|�U�� 25%
					<br>�@ - �����ު����y: �ܱj���ĪG= =" ��R���ܵۼƩO... ���N���]�ܤj...
					<br>- �԰��C��L�o�t�γ]�w
					<br>�@ - �ۭq�C��
					<br>�@�@ - �ĥηs�[�c, �å[�H�u��(�ΤW�F���e�b�w�]�C��Ψ쪺�޳N)
					<Br>�@ - ����W���u��
					<br>�@ - ���A�ϥΡubattle-cfilter.php�v�Ρubattle-dfilter.php�v
					<br>�@�@ - �אּ�ϥ� include �覡, ���� include... �]�N�O��, �o���"�t��"�ש�Τ@�F
					<br>�@�@ - �s�W�ɮ�:
					<br>�@�@�@ - battle-filter.php
					<br>�@�@�@�@ - �s���u�԰��C��v�t�ή֤��ɮ�
					<br>�@�@�@ - 6�ӷs Includes, �����ݩ� Battle Filter �����ɮ�...
					<br>�@�@�@�@ - btl-fp1-c.php �� btl-fp1-d.php : �t�d SQL ���O�ο��
					<br>�@�@�@�@ - btl-fp2-c.php �� btl-fp2-d.php : �C���e�����D
					<br>�@�@�@�@ - btl-fp3-c.php �� btl-fp3-d.php : �C�X���Ϊ� Function
					<hr>���Ѩ즹����... �������ӷ|��զA���u�Ƥ@�U�u�۰ʦ^HP�BEN�BSP�v�� "AutoRepairing' �t��
					<br>���@�w���\��, �����G���u�ƪ����n... �{�b��b�Ӧh���D�F...
					<br>������ @ PM 7:23
				</td>
			</tr>
			<!-- �ĤG�Q�T�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2008�~07��23��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>�n, ���ѧ�u��Ԩt�Ρv�g���F�I
					<br>�{�b�Q�ηsGUI�M�u��Ԩt�Ρv, �i�H�F��u���Z�����~�򥴡v���ĪG, ��M�]���ֱo�۰ʧ�s!!
					<br>�i�O, �o�{ php-eb ���@�Ǩt�ΤW������, ���ɩ����� EN/SP �o�^���F�B������...
					<br>�o�i��O����O...
					<br>���L... �u��Ԩt�Ρv���G�]����K��XD
					<br>�ܩ�u�� NT �[���@�Ӧ������A�Ȫ��S���O�v, �o���٨S�g�n
					<br>�ۭq�C��]�٨S��s, ��, �N�O�o��@�^��(�ۨ��ۻy��)
					<br>�D�~: (?)
					<br>�Q��22�� PM 11:15 �ɴ����}�F register.php, �M���uRegister - ���U�v�� Button ���F��...
					<br>�����줧�e... ��Vista/IE7�n���|�]��m���D�Ӭݤ���uRegister - ���U�v�o���s�O...
					<hr>��s��x:
					<br><b style="color: ForestGreen;font-size: 12pt">php-eb v0.37�\</b>
					<br>- ��Ԩt��
					<br>�@ - �s�W Include �ɮ�: btl-continual-sys.inc.php
					<br>�@ - �{�b�i�H���u�l���ؼСv�~��԰��F
					<br>�@�@ - �������h���԰����P�@�ؼ�
					<br>�@�@ - ��t�X�u�˳ƪ��A�v�������˳ƥ\��, ���Z���λ��U�԰�
					<hr>�S��, ���Ѫ���x�N�O�o��u... Orz...
					<br>������ @ PM 5:08
					
				</td>
			</tr>
			<!-- �ĤG�Q�G�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2008�~07��22��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>ʨ...
					<br>�Ӧ����M�O... �Q�ߵ��ڥ����@�������_�T���u... 
					<br>�S��k���ѥu���� 1.5Mbps ���q�p(��ƥ�)�e�W...
					<br>�� php-eb ���Ѫ��i�ץ��ٺ�O����...
					<br>�Z�����A�Ȭ������F��, �j�P�W�Q�Ѥw�g�����F...
					<br>�S��, �˳ƪ��A�ȴN�O�o��@�^��...
					<br>�ܩ󤵤�... �O�ǳƧﵽ�԰��t��...
					<br>���L, �ҿת��ﵽ�ä��O�u�ƨt�ΡB��綠��,
					<br>�ӬO���F�u��K���a�v�Ӱ�����s...
					<br>�D�n�]�O�j�q�a�B�ݥΡu�۰ʧ�s�v�t��...
					<br>���L�b�ݥΪ��P��, �]�oı php-eb �t�ε��c�W������...
					<br>�S��k, �ߦ��ɶq���a...
					<br>�D�n��s�ɮ�: equip.php, gmscrn_base.php
					<br>���n��s�ɮ�: battle-2.php, cfu.php, battle-cfilter.php(�u�[�F���i�ϥέ���), tacticslearn.php
					<hr>��s��x:
					<br>php-eb v0.36�\
					<br>- �D�e���˳ƨt��
					<br>�@ - �{�b�i�H�����b�u�˳ƪ��A�v�������˳ƪZ���λ��U�F
					<br>�@ - �ϥΤF�u�۰ʧ�s�v�t��, ��������^�έ��s��z
					<br>- �˳ƪZ���λ��U�˳ƨt��
					<br>�@ - �{�b�˳ƪZ��/���U�ɷ|�u�۰ʧ�s�v�F
					<br>�@�@ - �ʶR�s�Z���M�˳ƨS�����ĪG
					<br>�@�@ - �ɯŪZ���]�S��
					<br>- ���v���A�����
					<br>�@- Seed Mode �P EXAM System Activated
					<br>�@�@ - �{�b�o��� Hyper�� ���A�|�u�۰ʧ�s�v�F
					<br>�@- �򥻪�4������[��, �{�b���]�A����[���F
					<br>�@�@ *(�b�s�԰������U, ����M���v���ӴN�O���}�p�⪺)
					<br>�@- �����: ���A�O 999, �ӬO��O�`�M
					<br>- tacticslearn.php
					<br>�@- �ץ��h�l�u0�v�����D...
					<hr>�ݤU�h��s�n���u���֤�, �o����ɶ��O...
					<br>�۫H�������ӷ|���n��Ԩt��... �٦��� NT �[���@�Ӧ������A�Ȫ��S���O...
					<br>������ @ PM 8:22; PM 8:46 �[�� tacticslearn.php
				</td>
			</tr>
			<!-- �ĤG�Q�@�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2008�~07��21��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>���Ѷi�פ���, �g�F�ܦh�F��...
					<br>�D�n���O�S�Ī��ק�~ ���A�Ȫ��u�D�n�v�@��...
					<br>�Өt�ΤW�h�S���Ӥj���...
					<hr>��s��x:
					<br>php-eb v0.36�\
					<br>�S�Ī���s:
					<br>����l�a
					<br>�@- �򥻮ĪG
					<br>�@�@- �o�ʱ���
					<br>�@�@�@ - �D�Z���M�ݯS��
					<br>�@�@�@ - �D�Z�����A�� > ��0%
					<br>�@�@�@ - �����ĤH(�R���v >0%)
					<br>�@�@- �ĪG
					<br>�@�@�@ - �H 15% ���|�l�ӼĤH�l�U�� 50% EN�C
					<br>�@�@�@ - �H�������|, �l�ӼĤH�Z���θ˳ƪ��A�ȡC
					<br>�@+ ���[�ĪG
					<br>�@�@+ �o�ʱ���
					<br>�@�@�@ - �D�Z�����A�� > +100%
					<br>�@�@+ �ĪG
					<br>�@�@�@ - �H�󰪾��|, �l�ӼĤH�Z���θ˳ƪ��A�ȡC
					<br>�԰�����
					<br>�@- �o�ʱ���: �D�Z�����A�� > +10%, �����D�Z���M�ݯS��
					<br>�@- �������S��į઺�Z���A�����ĤH��A�H�@�w���|�A�ϼĤH�Y�ϼĤHHP���O�s�A�|�ݭn�i�J�ײz���A�C
					<br>�������m
					<br>�@- �o�ʱ���: �D�Z�����A�� > +10%, �����D�Z���M�ݯS��
					<br>�@- �ϥΦ��������S��į઺�Z���ɡA���D���췥�j�����A�_�h���|����l�ˡC
					<br>�۰ʭ״_
					<br>�@- ����: ���U�˳Ƥα`�W�˳ƪ��A�� > +10%, �S���u���U�˳ơv��/�Ρu�`�W�˳ơv�h��������
					<br>�@- �ĪG: �ĤH�� �԰����� �ĤO�L�ĤơC
					<br>�@
					<br>%�p�⪺���ӥ[�t�S��
					<br>�@- �򥻵o�ʱ���:
					<br>�@  - �֦������S�Ī��˳�, ���A�� > +10%,+20%,+30%,+40%��+50%(���G�ӯS�ĵ��Ŧөw)�C
					<br>�@- �ĪG: �F�򥻵o�ʱ���һݪ����A�ȫ�, �C 1% ���A�ȼW�[ 1% �����^�ײv, �̰����O��: +10%,+20%,+30%,+40% �� +50%
					<br>�@
					<br>����
					<br>�@- �ĪG: ��C�Ĥ訾�m�O 10 �I�C
					<br>�@- ����: �D�Z�����A�� > +10% �C
					<br>������
					<br>�@- �ĪG: ��C�Ĥ訾�m�O 5 �I�C
					<br>�@- ����: �D�Z�����A�� > +10% �C
					<br>�e��
					<br>�@- �ĪG: ��觹�����m�L�ĤơC
					<br>�@- ����: �D�Z�����A�� > +10% �C
					<br><br>------------- �s�ĪG ---------------<br>
					<br>�ݭn����(�I��)
					<br>�@- ���v���F��һݯ���(�t�H�إ[��), �h�L�ĤƦ�����O���˳�
					<br>�@
					<br>�ݭn���A��(���A��)
					<br>�@- ���F��һݪ��A��, �h�L�ĤƦ�����O���˳�
				</td>
			</tr>
			<!-- �ĤG�Q�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2008�~07��19��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>�ܿ��... �Q�ѤS�S���ɶ��g XD...
					<br>�n�줵�Ѥ~�������, �ҥH��g�F�n�X�p��... (�{�b�O �U�� 6:30 ���k)
					<br>���Ѫ���s�D�n�O �ײz�u�t �� �˳ƪ��A�Ȫ����...
					<br>��˸˳ƪ��A�Ȥ�ڷQ�����ӱo�n�����O...
					<hr>��s��x:
					<br>php-eb v0.36�\
					<br>�ײz�u�t:
					<br>�@ - �u�^�_���A�ȡv���t��
					<Br>�@�@ - �{�b�i�H�ײz�˳ƤF
					<br>�@�@ - �ΤF�u�۰ʧ�s�v, ��������^�F
					<br>�@ - �ޤJ�u�۰ʧ�s�v
					<br>�@�@ - ��u�^�_���A�ȡv���t�Τ@��, ��������^, ��i�H���u�~��ײz�v(�H�e�]���ιL�a?)
					<br>�@ - �u�Y�ɭp��ײzHP/EN�v
					<br>�@�@ - �{�b�i�H�Y�ɬݨ� % �^�_ HP/EN �̷s������
					<br>�@�@ - % �^�_���t�β{�b�|����ǽT�a�P�w�F
					<br>�L���s�y�u��:
					<br>�@ - �{�b�����C�� ��0% ���A���˳Ʃ�J���l�F
					<hr>���U�ӬO��ˡu�˳ƪ��A�ȡv���D�n�γ~... ���ӽs�g�W���|�ӳ·Ъ�...
					<Br>���L�ٻݭn�ܦh����
				</td>
			</tr>
			<!-- �ĤQ�E�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2008�~07��17��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>��p���_��... �s��Ӥ]�ܦ��L... ����]�u��j�j���g�F�@�I�I...
					<hr>��s��x:
					<br>php-eb v0.36�\
					<br>�ײz�u�t:
					<br>�@- �s�W�u�^�_���A�ȡv������
					<br>�@�@- �ثe�٨S�g�n�Өt��
					<br>�@�@- �w�w�U��B�^�_����: �C0.01%���A�Ȫ�O = 500 * (�Z������ + 1)
					<hr>�����~��a... ���O���Ū���...
				</td>
			</tr>
			<!-- �ĤQ�K�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2008�~07��13��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>����O�P����, ���۹�a�h���ɶ��u�@... ���ƹ�]�u���T�B�|�p�ɦӤw... (�o�]�OCopy�� XD, ���i�D�q!?)
					<br>�D�n�]�O�u�Z�����A�ȡv�����...
					<br>�٦� Debug...
					<hr>��s��x:
					<br>php-eb v0.36�\
					<br>- �԰��t�Τp��s
					<br>�@ - �[�j��u�ԳN�v���w����(����ϥΥ��߱o�Ԫk)
					<br>�@ - �u�Ʀ��_�߱o�ԳN���޿�
					<br>- �s�W�Ԫk: ��T����
					<br>�@ - 85Lv �H 1200�U �߱o
					<br>�@ - �\��:
					<br>�@�@ - SP����: 45�I
					<br>�@�@ - �� 10�I ���v Attacking
					<br>�@�@ - �W 10�I ���v Targeting
					<br>�@�@ - �W 2�I ���� Targeting (Hit�[��)
					<br>�@�@ - �u��T�����v�S��
					<br>- �s�W�S��:�u��T�����v
					<br>�@ - �ĤH�����A�ȷl�Ӥ񥭱`�W�� 5 ��
					<br>�@ - ���w�|�l�ӼĤH�����A��
				</td>
			</tr>
			<!-- �ĤQ�C�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2008�~07��12��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>����O�P����, ���۹�a�h���ɶ��u�@... ���ƹ�]�u���T�B�|�p�ɦӤw...
					<br>�D�n�]�O�u�Z�����A�ȡv�����...
					<br>�٦� Debug...
					<hr>��s��x:
					<br>php-eb v0.36�\
					<br>- �~���ˡu�Z�����A�ȡv
					<br>�@- Debug
					<br>�@�@ - �h���u�ƻsBug�v XD
					<br>�@�@ - �ץ������޿���D
					<br>�@�@ - ���|�A���u�����A�ȡv���u�L�Z���v�Z�� XD
					<br>�@�@�@ - �D�Z�����Q�����v�|�S�O���F
					<br>�@�@ - �F��쥻�w�p�W�������, �S���o�ʦ����A�Ȫ����D
					<br>�@- ��˨䦸�n�γ~ (�D�n�γ~�Ϧӥ���� XD)
					<br>�@�@ - ���A�� > ��0% ��:
					<br>�@�@�@ - EN ���Ӵ�ֳ̦h 16.7% - 33.3% *(��1.)
					<br>�@�@�@�@ - ���A�ȷU��, EN ���Ӵ�ֶq�U��, ���|�O�H����֪�
					<br>�@�@�@�@�@ - +250% ��, ������� 25% �� EN ����
					<br>�@�@ - ���A�� < ��0% ��
					<br>�@�@�@ - �����O�U���u���A�ȡv�� % (�A�Ω�D�Z�������A��)
					<br>�@�@�@ - EN ���ӼW�[ �u���A�ȡv�� % *(��1.)
					<br>(��1: ���A�ȼv�T�� EN ����, ���|�v�T�X���һݭn�� EN, �ӥu�|�v�T��ڦ����� EN)
				</td>
			</tr>
			<!-- �ĤQ���h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2008�~07��11��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>�{�b�O...7��12�� �s�� 1:09 ...
					<br> - �~���ˡu�Z�����A�ȡv
					<br>�@ - �{���q�঩�μW���A�ȤF...
					<br>�@�@�@ - �D�Z���B���U�˳ƩM�`�W
					<Br>�@�@�@ - �إߤ@�Ǫ���]�w
					<br>�@�@�@ - �n���B��W�X�F��, �����ɶ� Debug...
					<br>�@�@�@�@�@- �ӥB�٦��n�h Bug XD
					<br> - Chat.php �� sfo.class.php
					<br>�@�@ - Debug (Minor), �D�n���O Undefined �� Variable...
				</td>
			</tr>
			<!-- �ĤQ���h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2008�~07��09��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>���ѫ�ҳt�פ���C... �٦����O... �ڨ��u����T�p�ɪ��ɶ�...
					<br> - �~���ˡu�Z�����A�ȡv
					<br>�@ - �{���q�঩���A�ȤF A_A
					<br>�@�@�@ - ��������
					<hr>�n... <br> ���ѦA�~��... XD (�o�OCopy & Paste...)
				</td>
			</tr>
			<!-- �ĤQ�|�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2008�~07��08��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>�j�a�n... �t���h��Ӥ�S���F XD ...
					<br>�o��Ӥ뭷���ޥh�F�u�@, �ܦ��S�ɶ���i...
					<br>�[�W�S�n��], �ܦh�ƭn�� XD
					<br>��̪�~���ťX�ӧ��, ���Ѻ�O���������_�u�a�H
					<br>���Q�Ѥ]���ֶ֤i�ת�... ���S����� XD
					<br>2008�~07��07��
					<br> - �[�J�ualternate algorithm for battle_function.php�v
					<br>�@ - �]�\�|�Y����ָ귽, ���{���q�L�k���դ]�S����� XD
					<br>2008�~07��08��
					<br> - �}�l��ˡu�Z�����A�ȡv
					<br>�@ - �{���q�u�O��u�Z���g��ȡv���W�r�令�u�Z�����A�ȡv
					<hr>�n... <br> �����~�� XD
				</td>
			</tr>
			<!-- �ĤQ�T�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2008�~05��13��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>�{�b�]�O 5��13�� 15:11 ...
					<br>���Ѷi��: ��B�����F�԰��t�Ϊ���s, �s�������~
					<br>������i�H����...
					<br>���`�N�s�����M�¤������ܤj���O...
					<br>�o�̥i�H�ѦҤ@�U:
					<br>�ˮ` = �Z�������O * ( 1 + ( ( ����AT - ����DE ) / 40 )) * ( 1 + ( ���vAt - ���vDe ) / 100 );
					<br>�R���v = �Z���R�� * ( 1 + ( ( ����TA - ����RE ) / 40 )) * ( 0.8 + ( ���vTa - ���vRe ) / 100 );
					<br>����:
					<br>��̾���ξ��v����=���m��,
					<br>���Z�������O
					<br>
					<br>��̾���ξ��v�R��=�^�׮�,
					<br>�R���v = 80%
					<hr>��s��x:
					<br>php-eb v0.36�\
					<br>- ��B�����԰��t�Ϊ���s, �w�ĥηs�[�c
					<br>- Debug: battle-2.php, battle_function.php
				</td>
			</tr>
			<!-- �ĤQ�G�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2008�~05��12��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>�{�b�]�O 5��13�� 2:23am ...
					<br>���Ѷi��: �԰��t�Τj���; �����v 75% ... (���p���L��s...)
					<br>��Q�����h�F��n�g...
					<br>battle-2.php ���ɮפj��, �]�޿�W�����D, ��ӤF�Q�hKB...
					<br>���٬O�����~... �٨SDebug, �S��k����...
					<hr>��s��x:
					<br>php-eb v0.36�\
					<br>- �s�W Include ��
					<br>�@- btl-mirrordam.legacy.php
					<br>�@- btl-seed-ncs.inc.php
					<br>�@�@* �o��Ӥ]�O�q battle-2.php �����ΥX�ӡB�ӨS���Ӥj�γ~������
					<br>- �����u��v�S��
					<br>�@- �ϥβv = 0, �]�]�ĪG���ӹ��, ���|��, �]�������F...
					<br>- battle-2.php �� battle_function.php
					<br>�@- �M�ηs�����ηs�[�c
					<br>�@- ���ܳ����B�⪺�޿�, �H��� �ɮ�Size �� ��Ʈ���
					<br>�@- ��s�S��ĪG(�Ѧ�08�~05��10�骺��s)
					<br>�@�@- �������m�אּ��K10000�I�ˮ`, ��M���·|�Q�e��...
					<hr>�c... �{�b�w�O 5��13�� 2:34am ... >_<"
				</td>
			</tr>
			<!-- �ĤQ�@�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2008�~05��11��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>���ѥD�O�u�ƨt��, �u�ƨt�Τ]�O�t�X�s������~ (���M�{�b�w�g05/12 12:24am...)
					<br>�{�b�u�ƪ��t��, ���G�� v0.20 Open �֤W 4�����k...
					<br>��_ v0.30 �֤W�F�⭿...
					<br>�G�M�٦��u�ƪ��Ŷ�...
					<br>���~...
					<br>�L�F����[, php-eb �ש�ΤW�F Objects ...
					<br>�ܻ����Ӧ��N�ΤF...
					<hr>��s��x:
					<br>php-eb v0.36�\
					<br>- �إ� includes directory
					<br>�@�@- �s�W�ɮ�
					<br>�@�@�@- auc.inc.php (cfu.php���ΥX��)
					<br>�@�@�@- autorepair-f.inc.php (cfu.php���ΥX��)
					<br>�@�@�@- cv-fi.inc.php (cfu.php���ΥX��)
					<br>�@�@�@- lf-fi.inc.php (cfu.php���ΥX��)
					<br>�@�@�@- sc-fi.inc.php (cfu.php���ΥX��)
					<br>�@�@�@- sfo.class.php (�ĥιw���}�o��Stat_Fetch_Object.php, �Ѧ�08�~4��22���s��x)
					<br>�@�@�@�@- ��s�M Debug
					<br>�@�@�@�@- �[�J ProcessAllWeapon �� Function, ��H��@ Query �B�z���W�Ҧ��˳�
					<br>- cfu.php ������
					<br>�@�@- ��j���� functions ���ΥX��, �H��ָ�ƶǰe�ιB��
					<br>�@�@- �{�γ~���s���׺�, �p EBS �� ebs.cgi
					<br>- battle.php
					<br>�@�@- �M�� sfo.class.php ���� �uplayer_stat�v Object
					<br>�@�@- �� battle.php ���u�����ݡv�B�u�V�áv�����u�M���ơv...
					<br>- battle-cfilter.php
					<br>�@�@- �򥻤W�S�����ܰ�, �O�ѩ� battle.php ���[�c�w���P, �Ȯɤ���ϥ�
					<br>- battle-dfilter.php
					<br>�@�@- ���ѳ̩��㪺��s, �w�]�C���u��
					<br>�@�@- �j�j��٤����n Query, �򥻤W�j������Ƥ]�@��Query����
					<br>- battle-2.php
					<br>�@�@- �}�l�i�J�ק�԰��t�Ϊ��B�J
					<br>�@�@- �C�C�M�� sfo.class.php �� object �ηs�[�c
					<br>�@�@- �ѩ���˸`���Y, ���@�b�K�n�i��...
				</td>
			</tr>
			<!-- �ĤQ�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2008�~05��10��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><a href="http://vsqa.dai-ngai.net/php-eb/prog/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: �����p�⾹ v2.0�\</a>
					<br>�����p�⾹���\��Χ�s��x���e:
					<br>- �[�J�Ԫk���䴩
					<br>- �[�J�s���� SEED Mode �� EXAM System �䴩
					<br>- �[�J���Ԫk�S�Ĥ䴩:
					<br>�@ - �G�s���B�T�s�� (*�u����Ԫk)
					<br>���|�[�J�䴩���Ԫk�S��: (�Y�t��q���e�����|�[�J)
					<br>�@- ���u�o�g, ����, �������
					<br>- ��s�H�U�S�ĮĪG:
					<br>�@- ����w�I�[�t�Υ[�R���ĪG, ���O��: +2, +6, +10, +14
					<br>�@- ����w�I�[���m�ĪG, ���O��: +3, +6, +9, +12, +15
					<br>�@- ������κ��ѮĪG, ���O��: -5 �� -10
					<br>�@- �T�D�ĪG, �s�ĪG�� -5, �������S�ļv�T
					<br>�@- �¦� % ��K�ˮ`�ĪG, �s�ĪG���w�I��ֶˮ`, ���O��: �� 1000, 800, 600, 400 �� 200
					<br>�@- �¦� % �[�t�S�ĮĪG�j���, �s�ĪG:
					<br>�@�@- �H�u�@�w���|�v�^�׼ĤH����
					<br>�@�@- ���|���O��: 10%, 20%, 30%, 40% �� 50%
					<br>�@�@* ��ˮɷ|�t�X�o�ʱ���
					<br>�@- �¦� % �[�R���S�ĮĪG�p���:
					<br>�@�@- ���|���ĤH�ĪG�v�T�F
					<br>�@- ���������z�Z�ιp�F�z�Z�ĪG (��N�ӷ|��s�ĪG?)
					<br>- �b�o�̥[�J��s��x
					<br>�����p�⾹���}�o�i�J���n�F~ ���᪺��s�|�O������ڱ��p���ץ�...
					<hr>���~, �w�N���Ѫ����զ��A���ƻs�F, �ëO�s�U��,
					<br>���U�ӷ|�j�T��s���զ��A��, ������ӷ|���j�ܯ�, �H�η|�~Server...
					<br><a href="http://vsqa.dai-ngai.net/php-eb/prog_legacy/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">Legacy Server �J�f</a>
					<hr>php-eb v0.36�\ w/DBV 7
					<br>- ��s�H�حץ�
					<br>�@- �{�b6�ӤH�ت��`�ץ��]�O45�F
					<br>�@- �C�ӤH�ؤ]�����P�ץ�����, �U����S�I:
					<br>�@�@- Natural (�@��) �@ �@: �@<b><font color=grey>����</font></b>��
					<br>�@�@- Enhanced (�j�ƤH): �@<b><font color=brown>��</font><font color=ForestGreen>�R</font></b>��
					<br>�@�@- Extended (�����H) : �@<b><font color=red>��</font><font color=ForestGreen>�R</font></b>��
					<br>�@�@- ���ʤO�@�@�@�@ �@ : �@<b><font color=brown>��</font><font color=Blue>�^</font></b>��
					<br>�@�@- New Type�@�@�@�@: �@<b><font color=Blue>�^</font><font color=ForestGreen>�R</font></b>��
					<br>�@�@- Coordinator�@�@�@: �@<b><font color=red>��</font><font color=Blue>�^</font></b>��
					<br>- ��s�S��(�����, �аѦҼ���������s)
				</td>
			</tr>
			<!-- �ĤE�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2008�~04��26��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><a href="http://vsqa.dai-ngai.net/php-eb/prog/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: �����p�⾹ v2.0�\</a>
					<br>�����p�⾹���\��Χ�s��x���e:
					<br>- �[�J�S�Ĥ䴩:
					<br>�@ - �������m, �e��
					<br>�@ - �T�D
					<br>�@ - �[�t, �W�e, �{��, �k��
					<br>�@ - ²����i, �j�O���i, �̨ΤƱ��i, ���ű��i, ���ű��i
					<br>�@ - �����z�Z, �p�F�z�Z
					<br>�@ - �շ�, �˷�, ����, �w��
					<br>�@ - �۰���w, ���Ůշ�, �L�~�շ�, �h����w, ������w
					<br>�@ - ²�樾�m, ���`���m, �j�ƨ��m, ���Ũ��m, �̲ר��m
					<br>�@ - ���, �ܿ�, �z�A, ���, �Ŷ��۹�첾
					<br>�@ - ������(���Ѥ@�q���s�W��), ����
					<br>- �򥻤W�w����, �i�@�԰��t�Υi��ʰѦҥ�
				</td>
			</tr>
			<!-- �ĤK�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2008�~04��24��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><a href="http://vsqa.dai-ngai.net/php-eb/prog/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: �����p�⾹ v2.0�\</a>
					<br>�����p�⾹���\��Χ�s��x���e:
					<br>- �[�J�S�Ĥ䴩:
					<br>�@ - ����
					<br>�@ - ���O (�]�A���ʤO�����O)
					<br>- �{�b�|��ܳ����p�⦳�Ī��S�ĤF
				</td>
			</tr>
			<!-- �ĤC�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2008�~04��23��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>�@�ҧ��մN�����g�F...
					<br>�Ȯɦ��s�F�觹���F:
					<br><a href="http://vsqa.dai-ngai.net/php-eb/prog/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: �����p�⾹ v2.0�\</a>
					<br>�o�O�ǻ����������p�⾹, �ΨӴ��շs������, �]�N�O��... php-eb �s�����������w�g��B�����F�I
					<br>�Q�ݬݷs�����p��, �i�H�i�h�ݬ�~
					<br>�����p�⾹���\��Χ�s��x���e:
					<br>- v2.0�\ ��
					<br>�@ - �}�o�۰t�I�uphp-eb �t�I�p��u��v v1.1 �� v1.2 ��
					<br>�@�@�@ - �ѩ�M�ΰt�I�p��u���, �~�H�� v1.1 �O�̷s��, �ҥH�D�n�� v1.1 ��y�Ӧ�
					<br>�@�@�@ - �w�[�J�Ҧ� v1.2 ������, �έץ��쥻 v1.1 ���� Bug
					<br>�@ - �۰ʮM���Z���B����B�H�إ[�����
					<br>�@ - �i�H�s�Ĥ誺��Ƥ@���p��
					<br>�@�@ - �۰ʭp������w�p�����O�B�R���v�B�̲׶ˮ`
					<br>���[�J���\��:
					<br>�@ - �٥��]�w����S��, �|�ɧ֥[�J
					<hr>�i�O php-eb �D�{���٨S�������s, �Y�O�s�u�u���v���԰��t�Τ]�٨S���,
					<br>�ٺ�O���ն��q�a�H
					<br>
					<br>�٦��@�I~ <b>�ЩҦ��Ө�o�̪��ʴ��H���`�N!!</b>
					<br>php-eb Ultimate Edition ���Ҧ����e�]�ݡu���K�v, <B>�Ф�</B>���}!!

				</td>
			</tr>
			<!-- �Ĥ��h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2008�~04��22��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>�Z���W�@�����i, �w�g��9�Ӥ�F @_@"
					<BR>����, ������_ php-eb �}�o~
					<br>�ؼЪ���: php-eb v1.0 Ultimate Edition :: AKA Phantasy Planes of Endless Battle
					<br>�Цh�h�d�N�������i!!
					<br>�{�b����: ���M�O v0.35Alpha
					<hr>���Ѫ��i��:
					<br> - �@�� ue_btl_calc.php �ζ}�o�uStat_Fetch_Object.php�vModule
					<br>�@ - ue_btl_calc.php
					<br>�@�@�@ - php-eb �t�I�p��u�㪺 php ����, �i�@�p�⤽�����G����
					<br>�@ - Stat_Fetch_Object.php
					<br>�@�@�@ - �i�J�Ҳդƪ��ɥN, ���԰��t�γ]�w�u��
					<br>�@�@�@ - �]�A: SetUser, FetchPlayer, ProcessWeapon, ProcessMS �|�� Function,
					<br>�@�@�@�@ ���N�¦� cfu ����Function
				</td>
			</tr>
			<!-- �Ĥ��h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2007�~07��19��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>�o�O��Ӫ����iOrz...
					<br>�ʴ����A���A�g�w�b�L�h�ƤQ�Ѥ��L�n�L��@�X��s
					<br>�{�b�������O v0.35Alpha �� Dev. Version ����
					<br>�{���q���i��, �u�O���FGUI
					<br>�i��C����, �i��|�oı�즳�uNotice: Undefined ...�v,
					<br>��, �o���O�s�{�ɪ����|, ���Ӧ^����...
					<br>�������M������h? ���@�V�]�s�b��... �u�O���L�F�ݤ���@_@"
					<br>���ƶq�Ӧh, �ణ�h�ִN���h�֧a...
				</td>
			</tr>
			<!-- �ĥ|�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2007�~03��10��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>�o���ʴ�, �H�ۦw�ˤu��M��s�u�㪺�X�{,
					<br>�ŧi�����F�I
					<br>v2Alliance�۷N�P�¨C�@��ʴ��H��,
					<br>��X�z���_�Q���ɶ��Ӷi��ʴ��I
					<br>���]���i�঳���ժ�XD~
					<br>�]�\��ɦA�������@�U�a~
					<br>���զ��A���|�����B�@(�d�@����?)... ����t�~�q��~
				</td>
			</tr>
			<!-- �ĤT�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2007�~02��27��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>�A����s�F~
					<br>�ק�/�W�[���e:
					<br>�@- �����[�JHypermode��ܡB����M�ΦW����ܡB�[����ܩM�`�W�˳����
					<br>�@- ��Ǯw�[�J�ԤU�����, �ѿ�ܭn���X������, �@��Alternative Method
					<br>Debugging:
					<br>�@- �����, ��ܱM�ΦW�٪�Suffix�ܤFPrefix���~
					<br>�@- �ϥ� Filter ��, �|�ݨ�u�����v¾��M���߲�´�]���x�������D
					<hr>��O:
					<br>�U��!
					<br>��Bug�V�O�F����
					<br>�����ħV�O�F����"
					<br>�]��(��)�ɤ�L�h��~
					<br>�}�ǳ�~
					<br>���L������~
					<br>�p�L�N�~, �o�өP��,
					<br>������ php-eb v0.30 �N�u�o��v�F...
					<br>�{�b�_�uDebug���[�s���F����
					<br>�[�o�[�o~
					<br>Your effort is much appreciated!
					<br>�ڭ̷P�E�z�̪��V�O�I
				</td>
			</tr>
			<!-- �ĤG�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2007�~02��25��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>�o�O�}�ʴ����A���Ĥ@���������u�j����s�v�I<br>�h�¦U��ʴ��H�����V�O�I
					<br>�wDe�F��Bug:
					<br>�@- �Q�j�I�� ��ܰ��D
					<br>�@- �RAccount�t�ΥX�{����RAccount�����D
					<br>�@- EXAM/SEED ���`��SP���� (�|�B�~����3 SP)
					<br>�@- �P�ɨϥ�SEED Mode �M EXAM Activated�@Hyper�Ʈɷ| SEED Mode �ĪG�L��
					<br>�@- �԰�����ܪ�EN���ӥu�O�Z���M�Ԫk
					<br>�@- Chatroom ���L�u@�v�ιL�����r�Ҳ��ͪ����D
					<hr>�s�W���e:
					<br>��� Super DRAGOON �Ψ�X���k (10�ŦX��, �������K���e), ��CO/Extended�M�ΪZ
					<br>��� EXAM System �X���k (6�ŦX��, �������K���e), ���եΪ�EXAM System����A�R�F����`
					<br>��� �s���F���i�X�� �ΦX���k (6�ŦX��, �������K���e), �γ~�O�W�[�M�Τ��I�ơI
					<br>�s�W �ӧQ�Z�� �I�� �s���F���i�X�� �t�� (�S����O��), �I���ȹw�] 1:1000, ���A����: 1:100 (10����)
					<br>���} �ӧQ�Z�� �M �ӧQ����
				</td>
			</tr>
			<!-- �Ĥ@�h -->
			<tr>
				<td align=right width=30>���:</td>
				<td >2007�~02��22��</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>���զ��A�������}�ҡI<br>�s���� php-eb �w�W�� php-eb v0.30, ���ժ����� Alpha Version
					<br>php-eb �o�Ӫ������wí�a�U��ʴ��H���o�I
					<br>���~, �Ʊ�U�줣�n��u���K���e�v���} ^^, ��@�ӱM�~���ʴ��H��!!
					<br>&nbsp;&nbsp;���զ��A���]�w: �ұo �g��, ���� 10����
					<br>&nbsp;&nbsp;���մ���: ���@�ܨ�P��
					<hr width=75%>����ˤ��e:<br> �u���� EXAM System (���U�˳�, �{�b�Ȯɯ�� 500�U ���ʶR)<br> ����Ϥ� (�w�ﴣ��) <br> �ƭӰ��ŪZ��, ���t�� Super DRAGOON (�������K���e)
					<br>�ƭӪZ���˳ƪ���O�վ�, �]�A Bit, �B�嬶�� (�������K���e)
				</td>
			</tr>
		</table>
	</td></tr>
</table>
</body>

</html>
<?php
exit;
?>