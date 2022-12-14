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
<title>???????????????????????????</title>
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
<p><span class="gary_word">????????????:</span>??????????????????</p>
<div id="form">
  <form action="<?php echo $editFormAction; ?>" name="form1" method="POST">
  <table class="form_table">
  <tr>
  <td colspan="2" align="center">[*] ?????????  | [-] ?????????</td>
  </tr>
  <tr><td>
  <label for="who">*????????????:</label>
      <select name="who" id="who">
      <option value="?????????">?????????</option>
      <?php foreach($name_array as $name){ 
	  echo '<option value="'.$name.'">'.$name.'</option>';
	  };
	  ?>      
  	  </select>  
    </td></tr>
  <tr><td>
  	<label for="froms">*????????????:</label>
  	<select name="froms" id="froms" >
      <?php	 $companyObj->echoOption(); //???????????????class,object ??? list_name.php	  ?> 
    </select>
 </td></tr>
 <tr>
   <td><label for="date">*????????????:</label>
     <input type="text" name="date" id="date" size="50" class="datetimepicker1" ></td></tr> 
 <tr>
   <td>
   <label for="company">*????????????:</label>
   <input type="text" name="company" id="company" size="50" required />

   </td></tr>
   <tr>
     <td><label for="contactP">*????????????:</label>
       <input type="text" name="contactP" id="contactP" size="50" required />
       
     </td></tr>
   <tr>
   <td>
   <label for="phone">-????????????:</label>
   <input type="text" name="phone" id="phone" size="50" >
  
   </td>   
   </tr>
    <tr>
   <td>
   <label for="cellPhone">-????????????:</label>
   <input type="text" name="cellPhone" id="cellPhone" size="50">
   
   </td>   
   </tr>
   <tr><td>
  <label for="who">*????????????:</label>
      <select name="service" id="service">      
       <?php $serviceObj->echoOption();  ?> 
  	  </select>  
    </td></tr>
  <tr>
  <td ><label for="contents">*????????????:</label>
    <textarea name="contents" id="contents" rows="3" cols="50" required></textarea>		
   
    </td>
    
  </tr>
   <tr>
   <td>
   <label for="address">????????????:</label>
   <input type="text" name="address" id="address" size="50"  required />
   
   </td>   
   </tr>
   <tr><td>
  <label for="replayP">????????????:</label>
      <select name="replayP" id="replayP">
      <option value="?????????">?????????</option>
      <option value="?????????">?????????</option>
      <?php foreach($name_array as $name){ 
	  echo '<option value="'.$name.'">'.$name.'</option>';
	  };
	  ?> 
  	  </select>  
    </td></tr>
    <tr>
   <td><label for="repalyDate">????????????:</label>
     <input type="text" name="repalyDate" id="repalyDate" size="50" class="datetimepicker1"></td></tr> 
 <tr>
   <td>
   <tr>
  <td ><label for="replayPs">????????????:</label>
    <textarea name="replayPs" id="replayPs" rows="3" cols="50"></textarea></td>
  </tr>
  <tr><td>
  <label for="viewP">????????????:</label>
      <select name="viewP" id="viewP">
      <option value="?????????">?????????</option>
      <option value="?????????">?????????</option>
      <?php foreach($name_array as $name){ 
	  echo '<option value="'.$name.'">'.$name.'</option>';
	  };
	  ?> 
  	  </select>  
    </td></tr>
    <tr>
   <td><label for="viewDate">????????????:</label>
     <input type="text" name="viewDate" id="viewDate" size="50" class="datetimepicker1"></td></tr> 
 <tr>
   <td>
   <tr>
  <td ><label for="viewPs">????????????:</label>
    <textarea name="viewPs" id="viewPs" rows="3" cols="50"></textarea>
    <input type="submit" name="submit" size="20" value="??????"  />
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