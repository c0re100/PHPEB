<?php
//Battle Filter - Part 2: Display Column Headings - Customized

	$CustomColumns = '';
	$ColumnNum = 3;
	if ($Pl->Player['fdis_lv'])	{$CustomColumns .= "<td width=\"30\">����</td>";$ColumnNum++;}
	if ($Pl->Player['fdis_at'])	{$CustomColumns .= "<td width=\"30\">����</td>";$ColumnNum++;}
	if ($Pl->Player['fdis_de'])	{$CustomColumns .= "<td width=\"30\">���m</td>";$ColumnNum++;}
	if ($Pl->Player['fdis_re'])	{$CustomColumns .= "<td width=\"30\">����</td>";$ColumnNum++;}
	if ($Pl->Player['fdis_ta'])	{$CustomColumns .= "<td width=\"30\">�R��</td>";$ColumnNum++;}
	if ($Pl->Player['fdis_tch'])	{$CustomColumns .= "<td width=\"80\">����</td>";$ColumnNum++;}
	if ($Pl->Player['fdis_ms'])	{$CustomColumns .= "<td width=\"200\">����</td>";$ColumnNum++;}
	if ($Pl->Player['fdis_hp'])	{$CustomColumns .= "<td width=\"100\">HP</td>";$ColumnNum++;}
	if ($Pl->Player['fdis_fame'])	{$CustomColumns .= "<td width=\"40\">�W�n</td>";$ColumnNum++;}
	if ($Pl->Player['fdis_bty'])	{$CustomColumns .= "<td width=\"60\">�a���</td>";$ColumnNum++;}
	if ($Pl->Player['fdis_con'])	{$CustomColumns .= "<td width=\"75\">���A</td>";$ColumnNum++;}

	echo "<tr align=center><td colspan=$ColumnNum><b>���C��: </b></td></tr>";
	echo "<tr align=center>";
	echo "<td width=\"20\">No.</td>";
	echo "<td width=\"250\">���W��</td>";
	echo $CustomColumns;
	echo "<td width=\"30\">�԰�</td>";
	echo "</tr>";

?>