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

$colname_Recordset1 = "-1";
if (isset($_GET['id'])) {
  $colname_Recordset1 = $_GET['id'];
}
mysql_select_db($database_db, $db);
$query_Recordset1 = sprintf("SELECT * FROM `call` WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $db) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_db, $db);
$query_Recordset2 = "SELECT * FROM user ORDER BY user_id DESC";
$Recordset2 = mysql_query($query_Recordset2, $db) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
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
<p><span class="gary_word">當前位置:</span>郵件寄發編輯</p>
<form name="form1" method="post" action="callmailto.php">
    
  <table width="40%"  class="middle mail_t">
  <tr>
  <td width="40%"><label for="id">id</label></td>
  <td>
    <input name="id" type="text" id="id" value="<?php echo $row_Recordset1['id']; ?>" size="32" class="text_input" readonly></td>
  </tr>
    <tr>
      <td><label for="who">建檔人員:</label></td>
      <td>
        <input name="who" class="text_input" type="text" id="who" value="<?php echo $row_Recordset1['who']; ?>" size="32"></td>
    </tr>
    <tr>
      <td><label for="from">進線公司:</label></td>
      <td>
        <input name="from" class="text_input" type="text" id="from" value="<?php echo $row_Recordset1['froms']; ?>"  size="32"></td>
    </tr>
    <tr>
      <td><label for="date">進線日期:</label></td>
      <td>
        <input name="date" class="text_input" type="text" id="date" value="<?php echo $row_Recordset1['date']; ?>" size="32"></td>
    </tr>
    <tr>
      <td><label for="company">公司名稱:</label></td>
      <td>
        <input name="company" class="text_input" type="text" id="company" value="<?php echo $row_Recordset1['company']; ?>" size="32"></td>
    </tr>
    <tr>
      <td><label for="contactP">聯絡人:</label></td>
      <td>
        <input name="contactP" class="text_input" type="text" id="contactP" value="<?php echo $row_Recordset1['contactP']; ?>" size="32"></td>
    </tr>
    <tr>
      <td><label for="phone">市內電話:</label></td>
      <td>
        <input name="phone" class="text_input" type="text" id="phone" value="<?php echo $row_Recordset1['phone']; ?>" size="32"></td>
    </tr>
    <tr>
      <td><label for="cellPhone">手機:</label></td>
      <td>      	
        <input name="cellPhone" class="text_input" type="text" id="cellPhone" value="<?php echo $row_Recordset1['cellPhone']; ?>" size="32">
        <label for="textarea"></label>
      </td>
    </tr>
    <tr>
      <td><label for="service">服務項目:</label></td>
      <td>      	
        <input name="service" class="text_input" type="text" id="service" value="<?php echo $row_Recordset1['service']; ?>" size="32"></td>
    </tr>
    <tr>
      <td>施工內容:</td>
      <td>
        <textarea name="contents" id="textcontentsarea" value="<?php echo $row_Recordset1['contents']; ?>" cols="32" rows="3"><?php echo $row_Recordset1['contents']; ?></textarea>
      </td>
    </tr>
    <tr>
      <td><label for="address">地址:</label></td>
      <td>      	
        <input name="address" class="text_input" type="text" id="address" value="<?php echo $row_Recordset1['address']; ?>" size="32">
        </td>
    </tr>
    <tr>
      <td><label for="repalyP">回覆人員:</label></td>
      <td>      	
        <input name="repalyP" class="text_input" type="text" id="repalyP" value="<?php echo $row_Recordset1['replayP']; ?>" size="32">
      </td>
    </tr>
    <tr>
      <td><label for="repalyDate">回覆時間:</label></td>
      <td>      	
        <input name="repalyDate" class="text_input" type="text" id="repalyDate" value="<?php echo $row_Recordset1['repalyDate']; ?>" size="32">
      </td>
    </tr>
    <tr>
      <td>回覆備註:</td>
      <td>       
        <textarea name="repalyPs" class="text_input" id="repalyPs" value="<?php echo $row_Recordset1['replayPs']; ?>" cols="32" rows="3"><?php echo $row_Recordset1['replayPs']; ?></textarea>
      </td>
    </tr>
    <tr>
      <td><label for="viewP">勘查人員:</label></td>
      <td>      	
        <input name="viewP" class="text_input" type="text" id="viewP" value="<?php echo $row_Recordset1['viewP']; ?>" size="32">
      </td>
    </tr>
    <tr>
      <td><label for="viewDate">勘查日期:</label></td>
      <td>      	
        <input name="viewDate" class="text_input" type="text" id="viewDate" value="<?php echo $row_Recordset1['viewDate']; ?>" size="32">
      </td>
    </tr>
    <tr>
      <td>勘查備註:</td>
      <td>
        <textarea name="viewPs" id="viewPs" value="<?php echo $row_Recordset1['viewPs']; ?>" cols="32" rows="3"><?php echo $row_Recordset1['viewPs']; ?></textarea>
      </td>
    </tr>    
    <tr>
    <td colspan="2"><strong>收件者選擇(可複選)</strong></td>
    </tr>
    <tr>
    <td colspan="2">
      <?php do { ?>
        <input type="checkbox"  name="sendwho[]" id="sendwho" value="<?php echo $row_Recordset2['email']; ?>">
        <label for="sendwho"><?php echo $row_Recordset2['user_account']; ?></label>
        <?php } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2)); ?></td>
    </tr>
    <tr>
    	<td colspan="2">
        	<label for="other_email">其他收件者:</label>
            <input type="text" class="text_input" name="other_email" id="other_email" />
        </td>
    </tr>
    <tr>
    <td><label for="sendPPs" cols="32" rows="3">寄件者備註:</label></td>
    <td><textarea name="sendPPs"></textarea></td>
    </tr>
    <tr>
    <td colspan="2"><p>
      <input type="submit" class="text_input" name="mailto" id="mailto" value="mail 送出">
    </p>
      </td>
    </tr>
  </table>
  <p>&nbsp;</p>
    </form>
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
mysql_free_result($Recordset1);
?>
