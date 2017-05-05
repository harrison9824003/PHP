<?php require_once("session.php"); ?>
<?php require_once('../../list_name.php'); ?>
<?php require_once('../../Connections/db.php'); ?>
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
  $updateSQL = sprintf("UPDATE `call` SET creatdate=%s, who=%s, froms=%s, `date`=%s, company=%s, contactP=%s, phone=%s, cellPhone=%s, service=%s, contents=%s, address=%s, replayP=%s, repalyDate=%s, replayPs=%s, viewP=%s, viewDate=%s, viewPs=%s WHERE id=%s",
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
                       GetSQLValueString($_POST['viewPs'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_db, $db);
  $Result1 = mysql_query($updateSQL, $db) or die(mysql_error());

  $updateGoTo = "../call_index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_call_detail = "-1";
if (isset($_GET['id'])) {
  $colname_call_detail = $_GET['id'];
}
mysql_select_db($database_db, $db);
$query_call_detail = sprintf("SELECT * FROM `call` WHERE id = %s", GetSQLValueString($colname_call_detail, "int"));
$call_detail = mysql_query($query_call_detail, $db) or die(mysql_error());
$row_call_detail = mysql_fetch_assoc($call_detail);
$totalRows_call_detail = mysql_num_rows($call_detail);
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
  
  <script type="text/javascript">
 
  function checkReplayP(){
	  var replayP = document.getElementById("replayP").value ;
	  var replayDate = document.getElementById("repalyDate").value ;
	  var replayPs = document.getElementById("replayPs").value ;
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
<p><span class="gary_word">當前位置:</span>詳細資料與修正頁面</p>
<form name="form1" method="POST" action="<?php echo $editFormAction; ?>">
<table width="40%"  class="middle mail_t">
  <tr>
  <td width="40%"><label for="id">id</label></td>
  <td>
    <input name="id" type="text" id="id" value="<?php echo $row_call_detail['id']; ?>" size="32" class="text_input" readonly></td>
  </tr>
    <tr>
      <td><label for="who">建檔人員:</label></td>
      <td>        
      <select name="who" id="who">
      <option value="未選擇">未選擇</option>
      <?php foreach($name_array as $name){ 
	  echo '<option value="'.$name.'" '.($row_call_detail['who']==$name?"selected='selected'":"").'>'.$name.'</option>';
	  };
	  ?>      
  	  </select></td>
    </tr>
    <tr>
      <td><label for="froms">進線公司:</label></td>
      <td>
        <select name="froms" id="froms" >
      <?php	 $companyObj->echoOption(1,$row_call_detail['froms']); //自製物件，class,object 在 list_name.php	  ?>
    </select></td>
    </tr>
    <tr>
      <td><label for="date">進線日期:</label></td>
      <td>
        <input name="date" class="text_input" type="text" id="date" value="<?php echo $row_call_detail['date']; ?>" size="32"></td>
    </tr>
    <tr>
      <td><label for="company">公司名稱:</label></td>
      <td>
        <input name="company" class="text_input" type="text" id="company" value="<?php echo $row_call_detail['company']; ?>" size="32"></td>
    </tr>
    <tr>
      <td><label for="contactP">聯絡人:</label></td>
      <td>
        <input name="contactP" class="text_input" type="text" id="contactP" value="<?php echo $row_call_detail['contactP']; ?>" size="32"></td>
    </tr>
    <tr>
      <td><label for="phone">市內電話:</label></td>
      <td>
        <input name="phone" class="text_input" type="text" id="phone" value="<?php echo $row_call_detail['phone']; ?>" size="32"></td>
    </tr>
    <tr>
      <td><label for="cellPhone">手機:</label></td>
      <td>      	
        <input name="cellPhone" class="text_input" type="text" id="cellPhone" value="<?php echo $row_call_detail['cellPhone']; ?>" size="32">
        <label for="textarea"></label>
      </td>
    </tr>
    <tr>
      <td><label for="service">服務項目:</label></td>
      <td>      	
          <select name="service" id="service">
          <?php $serviceObj->echoOption(1,$row_call_detail['service']);  ?> 
          </select>
      </td>
    </tr>
    <tr>
      <td>施工內容:</td>
      <td>
        <textarea name="contents" id="textcontentsarea" value="<?php echo $row_call_detail['contents']; ?>" cols="32" rows="3"><?php echo $row_call_detail['contents']; ?></textarea>
      </td>
    </tr>
    <tr>
      <td><label for="address">地址:</label></td>
      <td>      	
        <input name="address" class="text_input" type="text" id="address" value="<?php echo $row_call_detail['address']; ?>" size="32">
        </td>
    </tr>
    <tr>
      <td><label for="repalyP">回覆人員:</label></td>
      <td>        
       <select name="replayP" id="replayP">
      <option value="未處理">未處理</option>
      <option value="不需要" <?php echo  $row_call_detail['replayP']=='不需要'?'selected="selected"':''?>>不需要</option>
      <?php foreach($name_array as $name){ 
	  echo '<option value="'.$name.'" '.($name ==$row_call_detail['replayP']?"selected='selected'":"").'>'.$name.'</option>';
	  };
	  ?> 
  	  </select> 
      </td>
    </tr>
    <tr>
      <td><label for="repalyDate">回覆時間:</label></td>
      <td>      	
        <input name="repalyDate" class="text_input datetimepicker1" type="text" id="repalyDate" value="<?php echo $row_call_detail['repalyDate']; ?>" size="32">
      </td>
    </tr>
    <tr>
      <td>回覆備註:</td>
      <td>       
        <textarea name="replayPs" class="text_input" id="replayPs" value="<?php echo $row_call_detail['replayPs']; ?>" cols="32" rows="3"><?php echo $row_call_detail['replayPs']; ?></textarea>
      </td>
    </tr>
    <tr>
      <td><label for="viewP">勘查人員:</label></td>
      <td>      	
         <select name="viewP" id="viewP">
      <option value="未處理">未處理</option>
      <option value="不需要" <?php echo  $row_call_detail['viewP']=='不需要'?'selected="selected"':''?>>不需要</option>
      <?php foreach($name_array as $name){ 
	  echo '<option value="'.$name.'" '.($name ==$row_call_detail['viewP']?"selected='selected'":"").'>'.$name.'</option>';
	  };
	  ?> 
  	  </select> 
      </td>
    </tr>
    <tr>
      <td><label for="viewDate">勘查日期:</label></td>
      <td>      	
        <input name="viewDate" class="text_input datetimepicker1" type="text" id="viewDate" value="<?php echo $row_call_detail['viewDate']; ?>" size="32">
      </td>
    </tr>
    <tr>
      <td>勘查備註:</td>
      <td>
        <textarea name="viewPs" id="viewPs" value="<?php echo $row_call_detail['viewPs']; ?>" cols="32" rows="3"><?php echo $row_call_detail['viewPs']; ?></textarea>
      </td>
    </tr>  
    <tr><td colspan="2">
    <p><input type="submit" class="text_input" name="mailto" id="mailto" value="修改"></p>
      </td></tr>
      <tr>
        <td colspan="2">
      <a class="email_btn" href="mail.php?id=<?php echo $row_call_detail['id']; ?>">寄送郵件</a>
      </td></tr>
  </table>
<input type="hidden" name="id" id="id" value="<?php echo $row_call_detail['id']; ?>">
<input type="hidden" name="creatdate" id="creatdate" value="<?php echo $row_call_detail['creatdate']; ?>">
<input type="hidden" name="MM_update" value="form1">
</form>

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
<?php require_once('call_footer.php');?>
<!-- InstanceEndEditable -->
</footer>
</div>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($call_detail);
?>
