<?php require_once("session.php"); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO phonesale (id, time, `date`, clientnum, client, address, phone, cellphone, responsible, callP, serviceC, saleP, saleDate, salePs, lookP, lookDate, lookPs) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['time'], "text"),
                       GetSQLValueString($_POST['date'], "date"),
                       GetSQLValueString($_POST['clientnum'], "int"),
                       GetSQLValueString($_POST['client'], "text"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['cellphone'], "text"),
                       GetSQLValueString($_POST['responsible'], "text"),
                       GetSQLValueString($_POST['callP'], "text"),
                       GetSQLValueString($_POST['serviceC'], "text"),
                       GetSQLValueString($_POST['saleP'], "text"),
                       GetSQLValueString($_POST['saleDate'], "date"),
                       GetSQLValueString($_POST['salePs'], "text"),
                       GetSQLValueString($_POST['lookP'], "text"),
                       GetSQLValueString($_POST['lookDate'], "date"),
                       GetSQLValueString($_POST['lookPs'], "text"));

  mysql_select_db($database_db, $db);
  $Result1 = mysql_query($insertSQL, $db) or die(mysql_error());

  $insertGoTo = "sale_page.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<?php require_once('../../list_name.php'); ?>
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
<link href="../../css/sale.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="../../js/jqcool.net-datetimepicke/jquery.datetimepicker.css"/ >
<script src="../../js/jqcool.net-datetimepicke/jquery.js"></script>
<script src="../../js/jqcool.net-datetimepicke/jquery.datetimepicker.js"></script>

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
<p><span class="gary_word">當前位置:</span>新增電訪紀錄</p>
<form name="form1" method="POST" action="<?php echo $editFormAction; ?><?php echo $editFormAction; ?>">
<table width="100%" class="form_table">
  <tr>
  <td><label for="callP">電訪人員:</label>
    <select name="callP" id="callP">
      <option value="未選擇">未選擇</option>
      <?php foreach($name_array as $name){ 
	  echo '<option value="'.$name.'">'.$name.'</option>';
	  };
	  ?>
    </select></td>
  </tr>
  <tr>
    <td><label for="date">電訪日期:</label>
      <input type="text" name="date" id="date" size="50" class="datetimepicker"></td>
  </tr>
  <tr>
    <td><label for="clientnum">客戶編號:</label>
      <input type="text" name="clientnum" id="clientnum" size="50"></td>
  </tr>
  <tr>
    <td><label for="client">客戶名稱:</label>
      <input type="text" name="client" id="client" size="50"></td>
  </tr>
  <tr>
    <td><label for="address">客戶地址:</label>
      <input type="text" name="address" id="address" size="50"></td>
  </tr>
    <tr>
    <td><label for="phone">室內電話:</label>
      <input type="text" name="phone" id="phone" size="50"></td>
  </tr>
    <tr>
    <td><label for="cellphone">手機電話:</label>
      <input type="text" name="cellphone" id="cellphone" size="50"></td>
  </tr>
  <tr>
    <td><label for="responsible">負責人員:</label>
      <input type="text" name="responsible" id="responsible" size="50"></td>
  </tr>
  <tr>
    <td><label for="serviceC">洽談內容:</label>
      <textarea name="serviceC" id="serviceC" cols="50"  rows="3"></textarea></td>
  </tr>
  <tr>
    <td>
    <label for="saleP">回覆人員:</label>
      <select name="saleP" id="saleP">
      <option value="未處理">未處理</option>
      <?php foreach($name_array as $name){ 
	  echo '<option value="'.$name.'">'.$name.'</option>';
	  };
	  ?> 
  	  </select>
    </td>
  </tr>
  <tr>
    <td><label for="saleDate">回覆日期:</label>
      <input type="text" name="saleDate" id="saleDate" size="50" class="datetimepicker"></td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr>
    <td><label for="salePs">回覆內容:</label>
      <textarea name="salePs" id="salePs" cols="50"  rows="3"></textarea></td>
  </tr>
  <tr>
    <td>
    <label for="lookP">回覆人員:</label>
      <select name="lookP" id="lookP">
      <option value="未處理">未處理</option>
      <?php foreach($name_array as $name){ 
	  echo '<option value="'.$name.'">'.$name.'</option>';
	  };
	  ?> 
  	  </select>
    </td>
  </tr>
  <tr>
    <td><label for="lookDate">勘查日期:</label>
      <input type="text" name="lookDate" id="lookDate" size="50" class="datetimepicker"></td>
  </tr>
  <tr>
    <td><label for="lookPs">勘查備註:</label>
      <textarea name="lookPs" id="lookPs" cols="50"  rows="3"></textarea></td>
  </tr>
  <tr>
  <td align="right"><input type="submit" name="button" id="button" value="新增電訪">  
  </td>
  </tr>
  <tr>
  	<td>
    <input type="radio" name="category" id="category1" value="good" />
    <label for="category1">報價追蹤</label>
    <input type="radio" name="category" id="category2" value="bad" />
    <label for="category1">無效客戶</label>
    <input type="radio" name="category" id="category3" value="access" />
    <label for="category3">客戶勘查</label>
    <input type="radio" name="category" id="category4" value="fax" />
    <label for="category4">傳真</label>
    <input type="radio" name="category" id="category4" value="realmail" />
    <label for="realmail">DM</label>
    <input type="radio" name="category" id="category4" value="mail" />
    <label for="mail">email</label>
    </td>
  </tr>
</table>
<input type="hidden" name="id" id="id">
<input type="hidden" name="time" id="time" value="<?php echo date("Ym"); ?>">
<input type="hidden" name="MM_insert" value="form1"></form>

<script language="JavaScript">
$(document).ready(function(){
	var opt3={dateFormat: 'yy-mm-dd',
	showSecond: false,
	timeFormat: 'HH:mm',
	addSliderAccess:true,
	sliderAccessArgs:{touchonly:false}
                }; 
	$('.datetimepicker1').datetimepicker(opt3);
	});</script>
<!-- InstanceEndEditable -->
</article>
<footer  _height="none">
<!-- InstanceBeginEditable name="footer" -->
<?php require_once('sale_footer.php'); ?>
<!-- InstanceEndEditable -->
</footer>
</div>
</body>
<!-- InstanceEnd --></html>