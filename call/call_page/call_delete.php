<?php require_once('session.php'); ?>
<?php require_once('../../list_name.php'); ?>
<?php require_once('../../Connections/db.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

if ((isset($_POST['id'])) && ($_POST['id'] != "")) {
  $deleteSQL = sprintf("DELETE FROM `call` WHERE id=%s",
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_db, $db);
  $Result1 = mysql_query($deleteSQL, $db) or die(mysql_error());

  $deleteGoTo = "call_page.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

$colname_call = "-1";
if (isset($_GET['id'])) {
  $colname_call = $_GET['id'];
}
mysql_select_db($database_db, $db);
$query_call = sprintf("SELECT * FROM `call` WHERE id = %s", GetSQLValueString($colname_call, "int"));
$call = mysql_query($query_call, $db) or die(mysql_error());
$row_call = mysql_fetch_assoc($call);
$totalRows_call = mysql_num_rows($call);
?>
<!doctype html>
<html><!-- InstanceBegin template="/Templates/layout.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>網站與電話記錄管理</title>
<!-- InstanceEndEditable -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<link href="../../css/layout.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../js/layout.js"></script>
<script type="text/javascript" src="../../js/minwt.auto_full_height.mini.js"></script>
<!-- InstanceBeginEditable name="head" -->
<link href="../../css/call.css" rel="stylesheet" type="text/css">
<style type="text/css">
footer {
	height: 35px;
	width: 100%;
	position: fixed;
	bottom: 0px;
	background-color: #093;
	padding-top: 5px;
	padding-bottom: 5px;
}
</style>
<!-- InstanceEndEditable -->
</head>

<body>
<div id="wapper" none="true">
<header  _height="none">
<!-- InstanceBeginEditable name="EditRegion5" -->
<?php require_once('../../header.php'); ?>
<!-- InstanceEndEditable -->
<div id="logo"><img src="../../img/logo-2_s1.png" width="100%" height="37"></div>
</header>
<article _height="auto">
<!-- InstanceBeginEditable name="contact" -->
<div id="clean_layout"></div>
<p><span class="gary_word">當前位置:</span>來電紀錄刪除</p>
<p align="center">你確定要刪除這個資料?</p>
<p align="center">&nbsp;</p>
<p align="center">&nbsp;</p>
<div class="wordcenter">
<form name="form1" method="post" action="">
  <label for="id">ID:</label>
  <input name="id" type="text" id="id" value="<?php echo $row_call['id']; ?>">
  <label for="company">公司名稱:</label>
  <input name="company" type="text" id="company" value="<?php echo $row_call['company']; ?>">
  <label for="contactP">聯絡人:</label>
  <input name="contactP" type="text" id="contactP" value="<?php echo $row_call['contactP']; ?>">
  <input type="submit" name="button" id="button" value="刪除">
</form>
</div>


<!-- InstanceEndEditable -->
</article>
<footer  _height="none">
<!-- InstanceBeginEditable name="footer" -->
<?php require_once('call_footer.php');?>
<!-- InstanceEndEditable -->
</footer>
</div>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($call);
?>
