<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_project = "localhost";
$database_project = "0000";
$username_project = "0000";
$password_project = "0000";
$project = mysql_pconnect($hostname_project, $username_project, $password_project) or trigger_error(mysql_error(),E_USER_ERROR);
mysql_query("SET NAMES 'utf8' "); 
?>