<?php
mysql_close(mysql_connect("tommyjamstest.cloudapp.net","tommyjams","1tommyblah"));
$connection = mysql_connect("tommyjamstest.cloudapp.net","tommyjams","1tommyblah");
if (!$connection) {
	die("Database connection failed: " . mysql_error());
}

$db_select = mysql_select_db(DATABASE,$connection);
if(!$db_select)
{
die("database selection failed".mysql_error());
}


