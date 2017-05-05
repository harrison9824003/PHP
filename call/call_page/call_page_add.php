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
  $insertSQL = sprintf("INSERT INTO `call` (id, creatdate, who, froms, `date`, company, contactP, phone, cellPhone, service, contents, address, replayP, repalyDate, replayPs, viewP, viewDate, viewPs) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['creatdate'], "text"),
                       GetSQLValueString($_POST['who'], "text"),
                       GetSQLValueString($_POST['froms'], "text"),
                       GetSQLValueString($_POST['date'], "text"),
                       GetSQLValueString($_POST['company'], "text"),
                       GetSQLValueString($_POST['contactP'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['cellPhone'], "text"),
                       GetSQLValueString($_POST['service'], "text"),
                       GetSQLValueString($_POST['contents'], "text"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['replayP'], "text"),
                       GetSQLValueString($_POST['repalyDate'], "text"),
                       GetSQLValueString($_POST['replayPs'], "text"),
                       GetSQLValueString($_POST['viewP'], "text"),
                       GetSQLValueString($_POST['viewDate'], "text"),
                       GetSQLValueString($_POST['viewPs'], "text"));

  mysql_select_db($database_db, $db);
  $Result1 = mysql_query($insertSQL, $db) or die(mysql_error());

  $insertGoTo = "call_page.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
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
<link rel="stylesheet" type="text/css" href="../../js/jqcool.net-datetimepicke/jquery.datetimepicker.css"/ >
<script src="../../js/jqcool.net-datetimepicke/jquery.js"></script>
<script src="../../js/jqcool.net-datetimepicke/jquery.datetimepicker.js"></script>
<script src="../../js/call.js"></script> 
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
<p><span class="gary_word">當前位置:</span>新增來電紀錄</p>
<div id="form">
  <form action="<?php echo $editFormAction; ?>" name="form1" method="POST">
  <table class="form_table">
  <tr>
  <td colspan="2" align="center">[*] 為必填  | [-] 為選填</td>
  </tr>
  <tr><td>
  <label for="who">*建檔人員:</label>
      <select name="who" id="who">
      <option value="未選擇">未選擇</option>
      <?php foreach($name_array as $name){ 
	  echo '<option value="'.$name.'">'.$name.'</option>';
	  };
	  ?>      
  	  </select>  
    </td></tr>
  <tr><td>
  	<label for="froms">*進線公司:</label>
  	<select name="froms" id="froms" >
      <?php	 $companyObj->echoOption(); //自製物件，class,object 在 list_name.php	  ?> 
    </select>
 </td></tr>
 <tr>
   <td><label for="date">*進線日期:</label>
     <input type="text" name="date" id="date" size="50" class="datetimepicker1" ></td></tr> 
 <tr>
   <td>
   <label for="company">*客戶名稱:</label>
   <input type="text" name="company" id="company" size="50" required />

   </td></tr>
   <tr>
     <td><label for="contactP">*聯絡人員:</label>
       <input type="text" name="contactP" id="contactP" size="50" required />
       
     </td></tr>
   <tr>
   <td>
   <label for="phone">-室內號碼:</label>
   <input type="text" name="phone" id="phone" size="50" >
  
   </td>   
   </tr>
    <tr>
   <td>
   <label for="cellPhone">-手機號碼:</label>
   <input type="text" name="cellPhone" id="cellPhone" size="50">
   
   </td>   
   </tr>
   <tr><td>
  <label for="who">*服務項目:</label>
      <select name="service" id="service">      
       <?php $serviceObj->echoOption();  ?> 
  	  </select>  
    </td></tr>
  <tr>
  <td ><label for="contents">*服務內容:</label>
    <textarea name="contents" id="contents" rows="3" cols="50" required></textarea>		
   
    </td>
    
  </tr>
   <tr>
   <td>
   <label for="address">施工地址:</label>
   <input type="text" name="address" id="address" size="50"  required />
   
   </td>   
   </tr>
   <tr><td>
  <label for="replayP">回覆人員:</label>
      <select name="replayP" id="replayP">
      <option value="未處理">未處理</option>
      <option value="不需要">不需要</option>
      <?php foreach($name_array as $name){ 
	  echo '<option value="'.$name.'">'.$name.'</option>';
	  };
	  ?> 
  	  </select>  
    </td></tr>
    <tr>
   <td><label for="repalyDate">回覆日期:</label>
     <input type="text" name="repalyDate" id="repalyDate" size="50" class="datetimepicker1"></td></tr> 
 <tr>
   <td>
   <tr>
  <td ><label for="replayPs">回覆內容:</label>
    <textarea name="replayPs" id="replayPs" rows="3" cols="50"></textarea></td>
  </tr>
  <tr><td>
  <label for="viewP">勘查人員:</label>
      <select name="viewP" id="viewP">
      <option value="未處理">未處理</option>
      <option value="不需要">不需要</option>
      <?php foreach($name_array as $name){ 
	  echo '<option value="'.$name.'">'.$name.'</option>';
	  };
	  ?> 
  	  </select>  
    </td></tr>
    <tr>
   <td><label for="viewDate">回覆日期:</label>
     <input type="text" name="viewDate" id="viewDate" size="50" class="datetimepicker1"></td></tr> 
 <tr>
   <td>
   <tr>
  <td ><label for="viewPs">回覆內容:</label>
    <textarea name="viewPs" id="viewPs" rows="3" cols="50"></textarea>
    <input type="submit" name="submit" size="20" value="新增"  />
    </td>
  </tr>  
 </table>
 <input type="hidden" name="id" id="id">
 <input type="hidden" name="creatdate" id="creatdate" value="<?php echo date('Ym'); ?>">
 <input type="hidden" name="MM_insert" value="form1">
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