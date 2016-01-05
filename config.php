<?php
//-------------------------//-------------------------//-------------------------//
//----------------------------   Configuration Unit   ---------------------------//
//----------------------------   phpeb Version 0.50   ---------------------------//
//---------------------------   Release Candidate 1    --------------------------//
//-------------------------//-------------------------//-------------------------//

//��T�]�w
global $sSpec, $WebMasterName, $WebMasterSite;
$sSpec = 'Official RC';                                  //��L������T, �o���i�ۥѭק�
$WebMasterName = 'v2Alliance';                           //���D�W��
$WebMasterSite = 'http://v2alliance.no-ip.org/';         //���W���}, ���U "$sSpec" �ɩҶ}�Ҫ�����

//Database Configs ��Ʈw�]�w
global $DBHost, $DBUser, $DBPass, $DBName, $DBPrefix;

$DBHost = 'localhost';                                   //��Ʈw��m, �p localhost, 127.0.0.1, www.yourdomain.com
$DBUser = 'root';                                        //��Ʈw�ϥΪ̦W��
$DBPass = '';                                            //��Ʈw�K�X
$DBName = 'phpeb';                                       //��Ʈw�W��
$DBPrefix = 'v2a_';                                      //��ƪ�e��W, �w�˫e�Ы_�����!! �w�˫ᤣ��A���!!

//Setting Configs
global $MAX_PLAYERS, $Offline_Time, $TIME_OUT_TIME, $RepairHPCost, $RepairENCost, $EmergencyCost, $OrganizingCost, $HP_BASE_RECOVERY, $EN_BASE_RECOVERY;
global $General_Image_Dir, $Unit_Image_Dir, $Base_Image_Dir, $Org_War_Cost, $Max_Wep_Exp;
global $Mod_HP, $Mod_HP_Cost, $Mod_HP_UCost, $Mod_EN, $Mod_EN_Cost, $Mod_EN_UCost,$TFDCostCons;
global $ticketMax, $dailyTicketLim, $ticketCost;

//�򥻳]�w
$TIME_OUT_TIME = 3600;           //�O�ɮɶ�, ���
$Offline_Time =	600;             //�P�w���u�𮧤��v, ���u���ɶ�, ���, �H user_game �� time2 �@��
$MAX_PLAYERS = 500;              //�n���H�ƤW��, �Y���]�w�γ]�w���s, ���Ѽƫh�L��
$HP_BASE_RECOVERY = 0.0033;      //HP�򥻦^�_�v
$EN_BASE_RECOVERY = 0;           //EN�򥻦^�_�v, �w�L��
$OLimit = 25;                    //�W�u�H�ƤW��, �Y���]�w�γ]�w���s, ���Ѽƫh�L��

//�Ϲ���m�]�w
$General_Image_Dir = 'images';   //�򥻹Ϥ���m(�I���Ϥ�)
$Unit_Image_Dir = 'unitimg';     //����Ϥ���m
$Base_Image_Dir = 'img1';        //�t�ιϤ���m

//�򥻵��ݮɶ��]�w
$Btl_Intv = 3;                   //�԰����ݮɶ�, �Y���A���W�u�H�Ʀh, �г]�j�@�I, �H��֨t�θ귽����
$Move_Intv = 15;                 //���ʵ��ݮɶ�, �Y���Ϥj����, �i�H�]�֤@�I, ���Ъ`�N��Ԯɤu�t���ϥ�

//�Ȧ�]�w
$BankRqLv = 30;                  //�Ȧ�}��һݵ��� -- ��ĳ���� 26 ��, �H����h�� Account �˿�
$BankRqMoney = 1500000;          //�Ȧ�}��һݭn�������{�� -- ��ĳ���� 150�U, ��]�P�W
$BankFee = 100000;               //�}�����O
$Bank_SLog_Entries = 30;         //�����C����ܪ��ƥ�, ��ĳ���n�W�L30

//��´�����]�w
$OrganizingCost = '5000000';    //�إ߲�´����
$OrganizingFame = '5';          //�إ߲�´�һݭn�W�n -- �W�n���M�c�W���]�i�H�إ߲�´
$OrganizingNotor = '-5';        //�إ߲�´�һݭn�c�W (�ݬ��t��) -- �W�n���M�c�W���]�i�H�إ߲�´
$Org_War_Cost = 200000;          //�Ԫ�1�p�ɩһݻ���
//php-eb Ultimate Edition �����]�w
$ticketMax = 50000;              //�x�ƤO�q�W��
$dailyTicketLim = 2500;          //�x�O�C�����B�W��
$ticketCost = 2000;              //�C�@�I�x�O������

//�Z���]�w
$Max_Wep_Exp = 25000;            //�Z�����A�W�� -- ����ĳ�j��25000�Τ֩�15000, 10000 �۵��� �u���A��: +100%�v
$Min_Wep_Exp = -10000;           //�Z�����A�U�� -- ����֩� -10000, -10000 �۵��� �u���A��: -100%�v

//��������]�w
$Max_HP = 10;                    //HP �W������, �p�G���Q%�^�_HP������L�j���ܧO�]�Ӱ�
$Max_EN = 10;                    //EN �W������, �p�G���ڦ^EN�ܶQ����, �i�H�]���@�I(5000�w�ܰ�)
//�����y�]�w
$Mod_HP_Cost = 50000;            //�򥻧�yHP������
$Mod_HP_UCost = 250000;          //��HP�q��yHP������, �p�W��������, �i�H��o Set ���@�I
$Mod_EN_Cost = 50000;            //�򥻧�yEN������, �p�G���ڦ^EN�ܶQ����, �i�H�]�C�@�I
$Mod_EN_UCost = 250000;          //��EN�q��yEN������, �P�W
//����u�򥻧�y�u�{�v����
$Mod_MS_base_success = 0;        //�򥻦��\�v, ��ĳ 0 �� 100, ����i�]���t�ƩΤj��100
$Mod_MS_cpt_cost = 250000;       //�C�I��y�ȩүӪ���
$Mod_MS_vpt_cost = 10;           //�C�I��y�ȩүӳӧQ�n��
$Mod_MS_cpt_penalty = 0.25;      //�C�I��y�Ȧ������򥻦��\�v(�����ʤ���, 0.25 �Y 0.25%)
$Mod_MS_cpt_bonus = 0.25;        //�C�I��y�I�ƪ��򥻦��\�v�[��(�P�W)
//����u����˳ƦX���u�{�v����
$Mod_MS_pequip_c = 2.5;          //���\�v�t��, ���\�v��������: �u((100-���鵥��)*�t��/100)*100%�v

//��Ǯw�����]�w
$Hangar_Price = 100000;          //��Ǯw�H�s����(�C���O�s), �p�X�{�ݥΪ����p, �Х[��...
$Hangar_Limit = 25;              //��Ǯw����W��(�C�쪱�a), ��Ǯw�Q�����Өt�θ귽, ��ĳ���n�Ӧh

//�ײz�]�w
$RepairHPCost = '5';             //�u�t�^�_1 HP�һݻ���, 5 �ݩ�Q��
$RepairENCost = '5';             //�u�t�^�_1 EN�һݻ���, 5 �ݩ����K�y
$EmergencyCost = 50;             //���X��������, �n���H���鵥��
$RepairEqCondCost = 500;         //�u�t�^�_ 0.01% �˳ƪ��A�ȩһݻ���
$RepairEqCondMax = 0;            //�u�t�^�_�˳ƪ��A�ȳ̤j��, 0 �� ��0%, -1000 �� -10%, 1000 �� +10%... ����ĳ�j�� 0

//��L�]�w - ��
$VPt2AlloyReq = 1000;            //�h�ֳӧQ�Z���~��I���@�ӦX��
$AlloyID = '800690';             //�X��ID (v0.3x�� �X���Z����ƪ�ID: 800690)
$AlloyPoints = 50;               //�X��ID �I������y�I��
                                 //�Ա��Ѿ\�w�ˤεo�i����

$TFDCostCons = 5000;            //�ʶR�X����k�������t��, ����: [2^(�ż�)]*�����t��

$NotoriousIgnore = -25;          //�W�n(�t�Ƭ��c�W)�h�֥H�U(���O�]�A�o�ӼƦr), �۰ʨ��������b�u���aĵ�i

$ModChType_Cost = 1000000;       //�H�ا�y������

//Chatroom Board Configs - �d���O�]�w
$rmChatAutoRefresh = 5;          //�Y�ɲ�ѥD�ʧ�s�۹j�ɶ�, ���, v0.44Beta ��w�L�@��
$SpeakIntv = 5;                  //�o���۹j�ɶ�, ���
$ChatShow = 30;                  //�����ܪ��ƥ�
$ChatSave = 0;                   //��Ѹ�T�O�d���, �i�Τ�{��,�u(24*3600)�v���@��@�], ���]�w�γ]�� 0 �|�ä[�O�d
$ChatAutoRefresh = 60;           //��Ѹ�T�۰ʨ�s�����, ��ĳ���n�ֹL 60 ��

//Instant Chat Plugin Config - ��ѫǴ���]�w
global $iChatInstalled, $iChatScript, $iChatConfig, $iChatTarget;
$iChatInstalled = 1;                          //�Y�ɲ�ѫǴ���w�w��, 0: ���w��, 1: �w�w��
$iChatScript = 'plugins/ichat/iChat.php';	    //�Y�ɲ�ѫǴ����m
$iChatConfig = 'plugins/ichat/config.php';	  //�Y�ɲ�ѫǴ��� Config ��m
$iChatTarget = 'iChat';                       //�Y�ɲ�ѫǵ��� ID

//Battle System Configs - �԰��t�γ]�w
global $Damage_MS_Bias, $Damage_MS_Sense, $Damage_Pi_Bias, $Damage_Pi_Sense, $Acc_MS_Bias, $Acc_MS_Sense, $Acc_Pi_Bias, $Acc_Pi_Sense, $Exp_Multiplier;

$Damage_MS_Bias = 1;                //����𨾰����t��, ��u����������O�v�P�u�u����騾�m�O�v�ۦP��, �Z�������O�����ơC�]�w�� 1 ��, �Y�𨾬۵���, ���X�Z���즳�����O�C
$Damage_MS_Sense = 40;              //����𨾱ӷP�t��, ��𰪩󨾦h��, �Z�������O�W�ɪ�����
$Damage_Pi_Bias = 1;                //���v�𨾰����t��
$Damage_Pi_Sense = 100;             //���v�𨾱ӷP�t��
$Acc_MS_Bias = 1;                   //����R�^�����t��
$Acc_MS_Sense = 40;                 //����R�^�ӷP�t��
$Acc_Pi_Bias = 0.8;                 //���v�R�^�����t��
$Acc_Pi_Sense = 100;                //���v�R�^�ӷP�t��

$Eq_Damage_Co = 1;                  //�Z���θ˳ƪ��A�ȷl�Өt��, ��ĳ�]�w: 1 (ps. �l�Ӱ򥻭Ȭ� 5)
$Eq_Damage_On_Co = 25;              //�u�b�u��M�v�����A�ȷl�ӫ׭���, ��ĳ�]�w: 50
$Eq_Damage_Off_lim = 1000;          //�U�u��, ���A�ȧK�l�ӭ�, �]�w�� 1000 ��, �N���A�ȳ̦h�Q���� �u+10%�v
$Eq_Damage_Ex = 20;                 //�Q���}��, �B�~�������A��
$Eq_Cond_Bonus_Basic = 5;           //�˳ƪ��A�ȼW���򥻭�
$Eq_Cond_Bonus_ExCo = 5;            //�ԳӮ�, ���A�ȼW�����[���t��
$Eq_Damage_IgnoreLv = 50;           //�O�@�s�����, �h�֯ťH�U���A�Ȥ���
$Eq_Damage_ReduceLvGap = 20;        //�O�@�s�����, �����̰������̦h�֯ťH�W, ���A�Ȧ���q��b

$Exp_Multiplier = 1;               //�g��/�������W�t��

$Eq_Cond_Bonus_Basic *= $Exp_Multiplier;
$VPt2AlloyReq = floor($VPt2AlloyReq / $Exp_Multiplier);

//Other System Configs - ��L�t�γ]�w
global $LogEntries, $Show_ptime, $ChatShow, $ChatSave, $ChatAutoRefresh, $StartZoneRestriction, $dbcharset, $BStyleA, $BStyleB, $Game_Scrn_Type;
$NPC_RegKey = '';                   //�L�������U�X��, �ݭn��SQL Server�ۦ��@
$Game_Scrn_Type = 0;                //�C���e���ﶵ, 0: v0.35���� ; 1: �ǲ� php-eb ����
$AllowRefreshFormBtl = 0;           //��ܾ԰��᭫�s��z�����s, �A�Ω� v0.35 �����H�᪺�sGUI, 0: �����, 1:���
$Show_ptime = 1;                    //��ܵ{���B�@�ɶ�, �]�� 0 �h�����
$LogEntries = 5;                    //�԰������ƥؤW��, �п�J '0' �� '5', ��J�s�h�|�����԰������t��, �Фų]�j��5, �H�K�t�ΥX��
                                    //�����b�u�H�Ʀh��10�H����, ��ĳ���3�h�H�U, �H��C��Ʈ���
$StartZoneRestriction = 8;          //���a�}�l�ɪ��ϰ�, �H������, �i�H�]�� '0' �� '8'
                                    //�]�� 0 �ɥ��w�|�b A1 �}�l�C��
                                    //�]�� 2 �ɷ|�b A1 �� A3 �H���X�{, �p������
                                    //�p�]�� 5 �ɷ|�b A1 �� B3 �H���X�{,
                                    //�]�� 8 �ɷ|�b A1 �� C3 �H���X�{, �̰��i�]��8
                                    //�аѦ� register.php Line 233 �� Line 244
$dbcharset = 'big5';                //��Ʈw���A����r�չ� - �c�骩 php-eb �L�ݧ��
$Time_Fix = 0;                      //�P���A���ɮt�ץ�, ��쬰��, �p���A���ĥ�GMT��ڮɶ�, �ӻݭn�έ���B�x�_�B�_�ʮɶ�, �h��J 8*3600
$BStyleA = 'font-size: 9pt; color: #ffffff; background-color: #000000;';                          //�D�e�������s�˦�
$BStyleB = "onmouseover=\"this.style.color='yellow'\" onmouseout=\"this.style.color='FFFFFF'\"";  //�P�W, �ƹ����L�ɷ|��⪺�y�k

//v0.35 �� php-eb Ultimate Edition �����]�w
$SP_Stat_Req = 5;           //�C�I�B�~ SP �һݦ����I��

//GUI - �A�Ω� v0.35(�Χ�᪺����) �� ��GUI, �ǲ�GUI����Ϊ���!!
$PriTarget = 'Alpha';       //�D������ id, php-eb ������ ���� �� id�W��,
$SecTarget = 'Beta';        //�Ƶ����� id, �Ƶ����Y�ǲΤ����U�b������Frame
$ProcTarget = 'Process';    //�B�z������ id, �Ω�B�z�@�ǫ��O, �@�뤣�|�Q���a�ݨ쪺

//Registering Config           //���U�]�w
global $CFU_CheckRegKey, $CFU_CheckIP;
$CFU_CheckRegKey = '0';        //If True, Enabled	<-�ˬd���U�X, 0�����ˬd, 1���ˬd, �нT�{ Portal �t�Υ��`�B�@��
$CFU_CheckIP = '0';            //As above		<-�ˬdIP��m, 0�����ˬd, 1���ˬd
$CFU_RegLowerCaseOnly = '1';   //����u��ϥΤp�g���^��Τ�W�� - �|����w��, ��ĳ����

//Behaviour Checker
$Use_Behavior_Checker = true;


?>