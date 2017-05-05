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

$colname_sale_mail = "-1";
if (isset($_GET['id'])) {
  $colname_sale_mail = $_GET['id'];
}
mysql_select_db($database_db, $db);
$query_sale_mail = sprintf("SELECT * FROM `phonesale` WHERE id = %s", GetSQLValueString($colname_sale_mail, "int"));
$sale_mail = mysql_query($query_sale_mail, $db) or die(mysql_error());
$row_sale_mail = mysql_fetch_assoc($sale_mail);
$totalRows_sale_mail = mysql_num_rows($sale_mail);

mysql_select_db($database_db, $db);
$query_mail_name = "SELECT * FROM `user`";
$mail_name = mysql_query($query_mail_name, $db) or die(mysql_error());
$row_mail_name = mysql_fetch_assoc($mail_name);
$totalRows_mail_name = mysql_num_rows($mail_name);
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
<meta charset="utf-8">
<link href="../../css/sale.css" rel="stylesheet" type="text/css">
<!-- InstanceEndEditable -->
</head>

<body>
<div id="wapper" none="true">
<header  _height="none">
<!-- InstanceBeginEditable name="EditRegion5" -->
EditRegion5
<!-- InstanceEndEditable -->
<div id="logo"><img src="../../img/logo-2_s1.png" width="100%" height="37"></div>
</header>
<article _height="auto">
<!-- InstanceBeginEditable name="contact" -->
<div id="clean_layout"></div>
<p><span class="gary_word">當前位置:</span>電訪紀錄郵件編輯</p>
 <?php if(isset($_GET['date'])){ ?>
    
    <form name="form1" method="post" action="mailsend.php">
    <table width="100%" border="1" class="middle">
      <tr class="titleword">
         <td width="10%">日期</td>
         <td width="10%">電訪員</td>
         <td width="10%">撥打通數</td>
         <td width="10%">報價追蹤</td>
         <td width="10%">無效客戶</td>
         <td width="10%">客戶回訪</td>
         <td width="10%">DM</td>
         <td width="10%">MAIL</td>
         <td width="10%">傳真</td>
         
         </tr>
      <tr>
        <td>
          <label for="date"></label>
          <input name="date" type="text" id="date" value="<?php echo $row_record['date']; ?>" size="15">
        </td>
        <td><label for="callP"></label>
          <input name="callP" type="text" id="callP" value="<?php echo $row_record['callP']; ?>" size="15"></td>
        <td><label for="callnum"></label>
          <input name="callnum" type="text" id="callnum" value="<?php echo $row_record['callnum']; ?>" size="15"></td>
        <td><label for="good"></label>
          <input name="good" type="text" id="good" value="<?php echo $row_record['good']; ?>" size="15"></td>
        <td><label for="bad"></label>
          <input name="bad" type="text" id="bad" value="<?php echo $row_record['bad']; ?>" size="15"></td>
        <td><label for="access"></label>
          <input name="access" type="text" id="access" value="<?php echo $row_record['access']; ?>" size="15"></td>
        <td><label for="realmail"></label>
          <input name="realmail" type="text" id="realmail" value="<?php echo $row_record['realmail']; ?>" size="15"></td>
        <td><label for="mail"></label>
          <input name="mail" type="text" id="mail" value="<?php echo $row_record['mail']; ?>" size="15"></td>
        <td><label for="fax"></label>
          <input name="fax" type="text" id="fax" value="<?php echo $row_record['fax']; ?>" size="15"></td>
        
      </tr>
      <tr>
      <td>寄件者備註</td>
        <td colspan="8"><label for="ps"></label>
          <textarea name="ps" id="ps" cols="100%" rows="5"></textarea></td>
      </tr>
    </table>
    <p>&nbsp;</p>
    <p align="center"><strong>收件者(可複選)</strong>：
      
        
        <span id="sprycheckbox1"><span class="checkboxRequiredMsg">最少選取一位收件者</span>
		<?php do { ?>
          <input type="checkbox" name="sendwho[]" id="sendwho" value="<?php echo $row_mail_name['email']; ?>">
          <label for="sendwho"><?php echo $row_mail_name['user_account']; ?></label>
		  <?php } while ($row_mail_name = mysql_fetch_assoc($mail_name)); ?> 
          </span>
       </p>
    <p>&nbsp;      </p>
    <p align="center">
      <input name="button" type="submit" class="sendmail" id="button" value="送出">
    </p>
    <p>&nbsp;</p>
    </form>
    <?php }?>
    <?php if(isset($_GET['id'])){ ?>      
  <form name="form1" method="post" action="salemailto.php">
    <table width="100%" border="1" class="middle">
      <tr class="titleword">
        <td width="10%">電訪員</td>
        <td width="10%">客戶編號</td>
        <td width="20%">公司名稱</td>
        <td width="10%">聯絡人</td>
        <td width="15%" >聯絡電話</td>
        <td width="10%">回復人員</td>
        <td width="10%">回覆時間</td>
        <td width="15%">回復備註</td>
        </tr>
      <tr class="hight2em">
        <td>
          <label for="callP"></label>
          <input name="callP" type="text" id="callP" value="<?php echo $row_sale_mail['callP']; ?>" size="15">
          </td>
        <td><label for="clientnum"></label>
          <input name="clientnum" type="text" id="clientnum" value="<?php echo $row_sale_mail['clientnum']; ?>" size="15"></td>
        <td><label for="client"></label>
          <input name="client" type="text" id="client" value="<?php echo $row_sale_mail['client']; ?>" size="20"></td>
        <td><label for="responsible"></label>
          <input name="responsible" type="text" id="responsible" value="<?php echo $row_sale_mail['responsible']; ?>" size="15"></td>
        <td align="left" ><img src="../../img/phone33.png" width="16" height="16">：
          
          
          <label for="phone">
            <input name="phone" type="text" id="phone" value="<?php echo $row_sale_mail['phone']; ?>" size="15">
            </label>
          <hr />            
          <img src="../../img/cellphone87.png" width="16" height="16">：
          <label for="cellphone">
            <input name="cellphone" type="text" id="cellphone" value="<?php echo $row_sale_mail['cellphone']; ?>" size="15">
          </label></td>
        <td><label for="saleP"></label>
          <input name="saleP" type="text" id="saleP" value="<?php echo $row_sale_mail['saleP']; ?>" size="15"></td>
        <td><label for="saleDate"></label>
          <input name="saleDate" type="text" id="saleDate" value="<?php echo $row_sale_mail['saleDate']; ?>" size="15"></td>
        <td ><label for="salePs"></label>
          <textarea name="salePs" id="salePs"  cols="20" rows="3"><?php echo $row_sale_mail['salePs']; ?></textarea></td>
        </tr>
      <tr class="titleword">
        <td>電訪日期</td>
        <td colspan="2">洽談內容</td>
        <td colspan="2">地址</td>
        <td>勘查人員</td>
        <td>勘查時間</td>
        <td>勘查備註</td>
        </tr>
      <tr class="hight2em">
        <td><label for="date"></label>
          <input name="date" type="text" id="date" value="<?php echo $row_sale_mail['date']; ?>" size="15"></td>
        <td colspan="2"><label for="serviceC"></label>
          <textarea name="serviceC" id="serviceC"   cols="30" rows="3"><?php echo $row_sale_mail['serviceC']; ?></textarea></td>
        <td colspan="2"><label for="address"></label>
          <input name="address" type="text" id="address" value="<?php echo $row_sale_mail['address']; ?>" size="30"> </td>
        <td><label for="lookP"></label>
          <input name="lookP" type="text" id="lookP" value="<?php echo $row_sale_mail['lookP']; ?>" size="15"></td>
        <td><label for="lookDate"></label>
          <input name="lookDate" type="text" id="lookDate" value="<?php echo $row_sale_mail['lookDate']; ?>" size="15"></td>
        <td class="wordS"><label for="lookPs"></label>
          <textarea name="lookPs" id="lookPs"   cols="20" rows="3"><?php echo $row_sale_mail['lookPs']; ?></textarea></td>
        </tr>
      <tr class="bgbule">
      <td class="titleword"><label for="ps">寄件者備註</label></td>
        <td colspan="7">
          <textarea name="ps" id="ps" cols="100%" rows="3"></textarea></td>
        
        </tr>
      </table>
    <p align="center">&nbsp;  </p>
    <p align="center"><strong>收件者(可複選)</strong>：
      
        
        <span id="sprycheckbox1"><span class="checkboxRequiredMsg">最少選取一位收件者</span>
		<?php do { ?>
          <input type="checkbox" name="sendwho[]" id="sendwho" value="<?php echo $row_mail_name['email']; ?>">
          <label for="sendwho"><?php echo $row_mail_name['user_account']; ?></label>
		  <?php } while ($row_mail_name = mysql_fetch_assoc($mail_name)); ?> 
          </span>
            
    </p>
    <p align="center">&nbsp;</p>
    <p align="center">
    <input name="button" type="submit" class="sendmail" id="button" value="發送">
    </p>
  </form> 
    <?php } ?>
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
mysql_free_result($sale_mail);

mysql_free_result($mail_name);
?>
