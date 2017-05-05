<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_db2 = "0000";
$database_db2 = "0000";
$username_db2 = "0000";
$password_db2 = "0000";

$db2 = mysql_pconnect($hostname_db2, $username_db2, $password_db2) or trigger_error(mysql_error(),E_USER_ERROR);
mysql_query("SET NAMES 'utf8' "); 
?>