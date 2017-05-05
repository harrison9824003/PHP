<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_PDF = "localhost";
$database_PDF = "0000";
$username_PDF = "0000";
$password_PDF = "0000";

$PDF = mysql_pconnect($hostname_PDF, $username_PDF, $password_PDF) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_query("SET NAMES 'utf8' ");
?>