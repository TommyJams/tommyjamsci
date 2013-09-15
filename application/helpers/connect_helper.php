<?php
mysql_close(mysql_connect(DATABASE_HOST,DATABASE_USERNAME,DATABASE_PASSWORD));
$connection = mysql_connect(DATABASE_HOST,DATABASE_USERNAME,DATABASE_PASSWORD);
if (!$connection) {
	die("Database connection failed: " . mysql_error());
}

$db_select = mysql_select_db(DATABASE,$connection);
if(!$db_select)
{
die("database selection failed".mysql_error());
}


