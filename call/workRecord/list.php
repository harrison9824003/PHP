<?php 
require_once('../../Connections/db.php');
mysql_select_db($database_db, $db);
$query_job = "SELECT * FROM jobaddress";
$job = mysql_query($query_job, $db) or die(mysql_error());
$row_job = mysql_fetch_assoc($job);


$job_list = array();
do {
	array_push($job_list, $row_job['name']);
	}while($row_job = mysql_fetch_assoc($job));	

mysql_free_result($job);
?>
