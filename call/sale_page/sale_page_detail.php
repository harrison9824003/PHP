<?php require_once("session.php"); ?>
<?php require_once('../../Connections/db.php'); ?>
<?php require_once('../../Connections/PDF.php'); ?>
<?php require_once('../../list_name.php'); ?>
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE phonesale SET `time`=%s, `date`=%s, clientnum=%s, client=%s, address=%s, phone=%s, cellphone=%s, responsible=%s, callP=%s, serviceC=%s, saleP=%s, saleDate=%s, salePs=%s, lookP=%s, lookDate=%s, lookPs=%s WHERE id=%s",
                       GetSQLValueString($_POST['time'], "text"),
                       GetSQLValueString($_POST['date'], "date"),
                       GetSQLValueString($_POST['clientnum'], "int"),
                       GetSQLValueString($_POST['client'], "text"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['cellPhone'], "text"),
                       GetSQLValueString($_POST['responsible'], "text"),
                       GetSQLValueString($_POST['callP'], "text"),
                       GetSQLValueString($_POST['serviceC'], "text"),
                       GetSQLValueString($_POST['saleP'], "text"),
                       GetSQLValueString($_POST['saleDate'], "date"),
                       GetSQLValueString($_POST['salePs'], "text"),
                       GetSQLValueString($_POST['lookP'], "text"),
                       GetSQLValueString($_POST['lookDate'], "date"),
                       GetSQLValueString($_POST['lookPs'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_PDF, $PDF);
  $Result1 = mysql_query($updateSQL, $PDF) or die(mysql_error());

  $updateGoTo = "sale_page.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_sale = "-1";
if (isset($_GET['id'])) {
  $colname_sale = $_GET['id'];
}
mysql_select_db($database_db, $db);
$query_sale = sprintf("SELECT * FROM phonesale WHERE id = %s", GetSQLValueString($colname_sale, "int"));
$sale = mysql_query($query_sale, $db) or die(mysql_error());
$row_sale = mysql_fetch_assoc($sale);
$totalRows_sale = mysql_num_rows($sale);
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
<link href="../../css/sale.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="../../js/jqcool.net-datetimepicke/jquery.datetimepicker.css"/ >
<script src="../../js/jqcool.net-datetimepicke/jquery.js"></script>
<script src="../../js/jqcool.net-datetimepicke/jquery.datetimepicker.js"></script>
<script type="text/javascript">
 
  function checkReplayP(){
	  var replayP = document.getElementById("saleP").value ;
	  var replayDate = document.getElementById("saleDate").value ;
	  var replayPs = document.getElementById("salePs").value ;
	  //檢查回覆人員是否為空值
	  if(replayDate.length != 0 || replayPs.length != 0 ){
		  if(replayP != '未處理'){
			  form1.submit();
			  }else{
			  alert("請選擇回覆人員，謝謝~");
			  }//判斷是否為未處理結束 
		  }else{
			  form1.submit();
			}
	  }
  </script>
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
<p><span class="gary_word">當前位置:</span>電訪詳細資料與修改</p>

<div class="sale_block">
<form name="form1" method="POST" action="<?php echo $editFormAction; ?>">
<table width="100%" class="detail_table">
  <tr>
    <td rowspan="2" width="5%">    
    <a href="mail.php?id=<?php echo $row_sale['id'];  ?>" class="btn_sale mail"></a>
    <a href="" class="btn_sale detele"></a>    
    </td>
    <td width="10%">電訪員</td>
    <td width="10%">客戶編號</td>
    <td width="15%">公司名稱</td>
    <td width="10%">聯絡人</td>
    <td width="15%">聯絡電話</td>
    <td width="10%">回覆人員</td>
    <td width="10%">回覆時間</td>
    <td width="15%">回覆備註</td>
  </tr>
  <tr>
    <td><input type="text" name="callP" id="callP" value="<?php echo $row_sale['callP']; ?>"></td>
    <td><input type="text" name="clientnum" id="clientnum" value="<?php echo $row_sale['clientnum']; ?>"></td>
    <td><input type="text" name="client" id="client" value="<?php echo $row_sale['client']; ?>"></td>
    <td><input type="text" name="responsible" id="responsible" value="<?php echo $row_sale['responsible']; ?>"></td>
    <td><input type="text" name="phone" id="phone" value="<?php echo $row_sale['phone']; ?>"><br />
      <input type="text" name="cellPhone" id="cellPhone" value="<?php echo $row_sale['cellphone']; ?>"></td>
    <td>
      <select name="saleP" id="saleP">
        <option value="未處理" <?php echo $row_sale['saleP']=='未處理'?'selected="selected"':' ' ;  ?>>未處理</option>
        <?php foreach($name_array as $name){ ?>
        <option value="<?php echo $name ; ?>" <?php echo $row_sale['saleP']==$name?'selected="selected"':' ' ;  ?>><?php echo $name ; ?></option>
        <?php } ?>      
      </select></td>
    <td><input type="text" name="saleDate" id="saleDate" value="<?php echo $row_sale['saleDate']; ?>" class="datetimepicker"></td>
    <td><textarea  name="salePs" id="salePs" rows="3"><?php echo $row_sale['salePs']; ?></textarea></td>
  </tr>
  <tr>
    <td>ID</td>
    <td>日期</td>
    <td colspan="2">洽談內容</td>
    <td colspan="2">地址</td>
    <td>勘查人員</td>
    <td>勘查時間</td>
    <td>勘查備註</td>
  </tr>
  <tr>
    <td><input name="id" type="text" id="id" value="<?php echo $row_sale['id']; ?>" size="5" readonly></td>
    <td><input type="text" name="date" id="date" value="<?php echo $row_sale['date']; ?>" class="datetimepicker"></td>
    <td colspan="2"><textarea name="serviceC" id="serviceC" cols="40" rows="3"><?php echo $row_sale['serviceC']; ?></textarea></td>
    <td colspan="2"><input type="text" name="address" id="address" value="<?php echo $row_sale['address']; ?>" size="30"></td>
    <td>
    <select name="lookP" id="lookP">
        <option value="未處理" <?php echo $row_sale['lookP']==$name?'selected="selected"':' ' ;  ?>>未處理</option>
        <?php foreach($name_array as $name){ ?>
        <option value="<?php echo $name ; ?>" <?php echo $row_sale['lookP']==$name?'selected="selected"':' ' ;  ?>><?php echo $name ; ?></option>
        <?php } ?>      
      </select>
    </td>
    <td><input type="text" name="lookDate" id="lookDate" value="<?php echo $row_sale['lookDate']; ?>" class="datetimepicker"></td>
    <td><textarea name="lookPs" id="lookPs" rows="3"><?php echo $row_sale['lookPs']; ?></textarea></td>
  </tr>
  <tr>
  <td colspan="9"><input type="button" name="Submit" id="Submit" value="修改" onClick="checkReplayP()"></td>
  </tr>
</table>
<input type="hidden" name="time" id="time" value="<?php echo $row_sale['time']; ?>">
<input type="hidden" name="MM_update" value="form1">
</form>
</div>
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
<?php
mysql_free_result($sale);
?>
