<?php
//----------------------------//
//--- php-eb Portal System ---//
//------- phpbb Version-------//
//----------------------------//
global $DBPrefix;
$PHPEB_LOCATION = 'index2.php';			//�}��php-eb����m, �@�뤣�έק�
$RegLocation = 'http://localhost/php-eb/';	//���U��m, �п�Jphp-eb���ؿ�
$DBHost = 'localhost';				//��Ʈw��m, �p localhost, 127.0.0.1, www.yourdomain.com, �лPcfu.php�ۦP!!
$DBUser = 'root';				//��Ʈw�ϥΪ̦W��, �лPcfu.php�ۦP!!
$DBPass = '';					//��Ʈw�K�X, �лPcfu.php�ۦP!!
$DBName = '';					//��Ʈw�W��, �лPcfu.php�ۦP!!
$DBPrefix = 'vsqa_';				//��ƪ�e��W, �лPcfu.php�ۦP!!
$Forum_DBHost = 'localhost';			//�׾¸�Ʈw��m, �p localhost, 127.0.0.1, www.yourdomain.com, �лP�׾¬ۦP!!
$Forum_DBUser = 'root';				//�׾¸�Ʈw�ϥΪ̦W��, �лP�׾¬ۦP!!
$Forum_DBPass = '';				//�׾¸�Ʈw�K�X, �лP�׾¬ۦP!!
$Forum_DBName = '';				//�׾¸�Ʈw�W��, �лP�׾¬ۦP!!
$Forum_DBPrefix = 'phpbb_';			//�׾¸�ƪ�e��W, �лP�׾¬ۦP!!

//----------------------------//

	echo "<html>";
	echo "<head>";		
	echo "<meta http-equiv=\"Pragma\" content=\"no-cache\">";
	echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=big5\">";
	echo "<title>Endless Battle ~ php-eb</title>";
	echo "</head>";
	echo "<body bgcolor=\"#000000\" text=#dcdcdc link=#dcdcdc style=\"margin:0px 0px 0px 0px;\" oncontextmenu=\"return false;\" style=\"font-family: Arial\">";
	$mode = ( isset($HTTP_GET_VARS['action']) ) ? $HTTP_GET_VARS['action'] : $HTTP_POST_VARS['action'];
	if(!$mode){
?>

<div align=center 
style="font-size:70px;font-family: 'Monotype Corsiva';color:#505050;filter:alpha(opacity=100,finishopacity=0,style=2);height:60px;background-color:#fff0f0;">
<b>Endless Battle</b>
</div>
<div align=center style="font-size:25px;font-family:'Monotype Corsiva','Comic Sans MS';color:#ffffff;"><b>Project php-eb</b></div>
<div align=center style="color:#a0a0a0;font-size:12px;">Copyright <a href="http://vsqa.no-ip.com" target=_blank style="text-decoration:none;font-family:Monotype Corsiva;color:#a0a0a0;"> V2Alliance</font></a> All Right Reserved.</div>
<hr width=80% style="filter:alpha(opacity=100,finishopacity=40,style=2)">

<p align="center">The Portal to the world of php-eb<br>�q�� php-eb �@�ɪ��J�f</p>

<hr width=80% style="filter:alpha(opacity=100,finishopacity=40,style=2)">
<br>
<script language='JavaScript'>
function startgame(destination) {
window.open(destination,'Alpha','menubar=no,status=no,top=20,left=50,toolbar=no,width=800,height=600');
window.opener=null;
window.close();
}
</script>

<center>
<?php
echo "<input type=button value=\"�i�J�C��\" onClick=startgame('$PHPEB_LOCATION')><br>";
echo "<input type=button value=\"���o���U�X\" onClick=startgame('".$RegLocation."phpeb_portal.php?action=regkey')>";
}
if($mode == 'regkey' && !$actionb){
echo "
<div align=center>
<center>
<form action=phpeb_portal.php?action=regkey method=post name=act>
<input type=hidden name=actionb value=proc>
<table border=0 width=100% height=100%>
<tr>
<td width=100% height=100%>
<div align=center>
<center>
<table border=0 width=500>
";
/*
<tr>
<td width=50% align=right>���ݽ׾�:</td>
<td width=50% align=left>
<select name=forum>
<option value='FORUMNAME'>�׾¤@
<option value='SECOND_FORUMNAME'>�׾¤G
</td>
</tr>
*/
echo "
<tr>
<td width=50% align=right>�׾©ҥΪ��n�J�W��:</td>
<td width=50% align=left><input type=text name=username size=16></td>
</tr>
<tr>
<td width=50% align=right>�K�X:</td>
<td width=50% align=left><input type=password name=password size=16></td>
</tr>
<tr>
<td width=50% align=right>�q�l:</td>
<td width=50% align=left><input type=text name=email size=16></td>
</tr>
</table><input type=submit value='���o���U�X'>
</center>
</div>
<p align=center>&#12288;</td>
</tr>
</table>
</form>
</center>
</div>
";
}
if($mode == 'regkey' && $actionb == 'proc'){

//if($forum == 'FORUMNAME'){

//Get Forum Details
mysql_connect ("$Forum_DBHost", "$Forum_DBUser", "$Forum_DBPass") or die ('Could not access database because: ' . mysql_error());
mysql_select_db ("$Forum_DBName");

$sql= ("SELECT * FROM `".$Forum_DBPrefix."users` WHERE `username` = '".$username."' LIMIT 1");
$RegKeyQuery = mysql_query($sql) or die(mysql_error());
$RegKeyData = mysql_fetch_array($RegKeyQuery);
		$password = md5($password);
		if (!$RegKeyData[user_active] || !$username || !$RegKeyData[username] || $RegKeyData[user_password] != $password || $RegKeyData[username] != $username){
		echo "<center><br><br>�ϥΪ̦W�٩αK�X���~�C<br>";
		exit;}
		if (!$RegKeyData[user_email] || $RegKeyData[user_email] != $email){
		echo "<center><br><br>�q�l�a�}���~�C<br><br>";
		exit;

//}


mysql_close();
//End
}

/* //START SECOND FORUM
elseif($forum == 'SECOND_FORUMNAME'){
//Get Forum Details
mysql_connect ("", "", "") or die ('Could not access database because: ' . mysql_error());
mysql_select_db ("");

//START SQL QUERIES

mysql_close();
//End
}
else{echo "<center><br><br>���~�C<br>������o�׾¸�T�C<br><br>";exit;}
//END of SECOND FORUM
*/


$RegKeyCache = time();

if (!$forum)
$forum = 'uni';

//Set Reg Key
mysql_connect ("$DBHost", "$DBUser", "$DBPass") or die ('Could not access database because: ' . mysql_error());
mysql_select_db ("$DBName");

//if($forum == 'dw'){	//FIRST FORUM
	
$sql = ("INSERT INTO ".$GLOBALS[DBPrefix]."phpeb_regkeys (regkey,username,id,email) VALUES('$RegKeyCache','$forum-$RegKeyData[user_id]','$forum-$RegKeyData[user_id]','$RegKeyData[user_email]')");
mysql_query($sql) or die ('<br><center>���৹�����U (Location ID: Portal01-1)<br>��]:' . mysql_error() . '<br>'."�i��O�]���z�w�ӽйL��E-Mail�w�Q�ϥΡC$RegKeyData[user_id]','$RegKeyData[user_email]");

/*
}
else{	//SECOND FORUM
$sql = ("INSERT INTO ".$GLOBALS[DBPrefix]."phpeb_regkeys (regkey,username,id,email) VALUES('$RegKeyCache','$forum-$RegKeyData[uid]','$forum-$RegKeyData[uid]','$RegKeyData[email]')");
mysql_query($sql) or die ('<br><center>���৹�����U (Location ID: Portal01-2)<br>��]:' . mysql_error() . '<br>'."�i��O�]���z�w�ӽйL��E-Mail�w�Q�ϥΡC$RegKeyData[uid]','$RegKeyData[email]");
}
*/

echo "<div align=center><form action=gmscrn_main.php?action=proc method=post name=frmreturn target=Alpha>";
echo "<p align=center style=\"font-size: 16pt\"><br><br><br><br><br>�إߵ��U�X�����I<br>�z�����U�X�O $RegKeyCache <br>�ЧA�O�U�����U�X�I<input type=text value=\"$RegKeyCache\"><br><input type=button value=\"�~��\" onClick=\"location.replace('$PHPEB_LOCATION')\"></p>";
echo "</form></div>";
mysql_close();

}
?>

</body>

</html>

