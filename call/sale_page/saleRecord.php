<?php require_once("session.php"); ?>
<?php require_once('../../Connections/db.php'); ?>
<?php require_once('../../list_name.php'); ?>

<?php
mysql_select_db($database_db, $db);
$query_sale = "SELECT * FROM record ORDER BY `date` DESC";
$sale = mysql_query($query_sale, $db) or die(mysql_error());
$totalRows_sale = mysql_num_rows($sale);

$per_sale = 15;
$pages_sale = ceil($totalRows_sale/$per_sale);
if (!isset($_GET["page_sale"])){ //假如$_GET["page"]未設置
        $page_sale=1; //則在此設定起始頁數
    } else {  
        $page_sale = intval($_GET["page_sale"]); //確認頁數只能夠是數值資料  
    }
$start_sale = ($page_sale-1)*$per_sale; //每一頁開始的資料序號
$sale2 = mysql_pconnect($hostname_db, $username_db, $password_db) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_query("SET NAMES 'utf8' ");  
$result_sale = mysql_query($query_sale.' LIMIT '.$start_sale.', '.$per_sale,$sale2) or die("Error");
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
mysql_select_db($database_db, $db);
$now_date = date("Y-m-d");
$query_isset = "SELECT * FROM record WHERE `date` = '$now_date'";
$isset = mysql_query($query_isset, $db) or die(mysql_error());
$totalRows_isset = mysql_num_rows($isset);
if ($totalRows_isset ==0) {
  $insertSQL = sprintf("INSERT INTO record (`date`, callP, callnum, good, bad, fax, realmail, mail, `access`) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($now_date, "text"),
                       GetSQLValueString('未選擇', "text"),
                       GetSQLValueString(0, "int"),
                       GetSQLValueString(0, "int"),
                       GetSQLValueString(0, "int"),
                       GetSQLValueString(0, "int"),
                       GetSQLValueString(0, "text"),
                       GetSQLValueString(0, "text"),
                       GetSQLValueString(0, "int"));

  mysql_select_db($database_db, $db);
  $Result1 = mysql_query($insertSQL, $db) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE record SET callP=%s, callnum=%s, good=%s, bad=%s, fax=%s, realmail=%s, mail=%s, `access`=%s WHERE `date`=%s",
                       GetSQLValueString($_POST['callP'], "text"),
                       GetSQLValueString($_POST['callnum'], "int"),
                       GetSQLValueString($_POST['good'], "int"),
                       GetSQLValueString($_POST['bad'], "int"),
                       GetSQLValueString($_POST['fax'], "int"),
                       GetSQLValueString($_POST['realmail'], "text"),
                       GetSQLValueString($_POST['mail'], "text"),
                       GetSQLValueString($_POST['access'], "int"),
                       GetSQLValueString($_POST['date'], "text"));

  mysql_select_db($database_db, $db);
  $Result1 = mysql_query($updateSQL, $db) or die(mysql_error());

  $updateGoTo = "saleRecord.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_db, $db);
$query_sale2 = "SELECT * FROM `call`";
$sale2 = mysql_query($query_sale2, $db) or die(mysql_error());
$row_sale2 = mysql_fetch_assoc($sale2);
$totalRows_sale2 = mysql_num_rows($sale2);
?>
<!doctype html>
<html><!-- InstanceBegin template="/Templates/layout.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>網站與電話記錄管理</title>
<link href="../../css/sale.css" rel="stylesheet" type="text/css">
<!-- InstanceEndEditable -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<link href="../../css/layout.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../js/layout.js"></script>
<script type="text/javascript" src="../../js/minwt.auto_full_height.mini.js"></script>
<!-- InstanceBeginEditable name="head" -->
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
<p><span class="gary_word">當前位置:</span>每日電訪紀錄</p>
<table width="95%" border="0"  class="middle select_T">
  <tr>
  <td colspan="10">
  <?php
//來電頁數選擇程式
    //分頁頁碼  
    echo '共有 '.$totalRows_sale.' 筆- '.$page_sale.' 頁-共 '.$pages_sale.' 頁';  
    echo "<a href=?page_sale=1>第一頁</a> "; 
	echo $page_sale>1?"<a href=?page_sale=".($page_sale-1)."><<-</a>":" ";
    echo "第 ";?>
    <?php    					
	for( $i=1 ; $i<=$pages_sale ; $i++ ) {				
		if ( $page_sale-5 < $i && $i < $page_sale+5 ) {	?> 
    <a href=?page_sale=<?php echo $i; ?> class='page_link'><?php echo $i; ?></a>
      
<?php }}    
    echo " 頁 ";
	echo $page_sale<$pages_sale?"<a href=?page_sale=".($page_sale+1).">->></a>":" ";
	echo "<a href=?page_sale=".$pages_sale.">末頁</a><br />"; 
?>  
  </td>
  </tr>
  </table>
  <table width="95%"   class="middle salerecord_t">
  <tr class="title_tr">
    <td>日期</td>
    <td>電訪人員</td>
    <td>電話數量</td>    
    <td>無效客戶</td>
    <td>客戶勘查</td>
    <td>DM</td>
    <td>MAIL</td>
    <td>傳真</td>
    <td>報價追蹤</td>
    <td>&nbsp;</td>
  </tr>  
  <?php while($row_sale = mysql_fetch_array($result_sale)){
	  if($row_sale['date'] == date("Y-m-d")){
	  ?>
      <form method="POST" action="<?php echo $editFormAction; ?>" name="form2">
     <tr>
    <td><input type="text" name="date" id="date" value="<?php echo $row_sale['date']; ?>"/></td>
    <td><select name="callP" >
    <option value="未選擇">未選擇</option>
    <?php foreach($name_array as $name){ 
	  echo '<option value="'.$name.'" '.( $row_sale['callP']==$name?"selected='selected'":"").'>'.$name.'</option>';
	  };
	  ?>
    </select></td>
    <td><input type="text" name="callnum" id="callnum" size="10" value="<?php echo $row_sale['callnum']; ?>"/></td>    
    <td><input type="text" name="bad" id="bad" size="10" value="<?php echo $row_sale['bad']; ?>" /></td>
    <td><input type="text" name="access" id="access" size="10" value="<?php echo $row_sale['access']; ?>" /></td>
    <td><input type="text" name="realmail" id="realmail" size="10" value="<?php echo $row_sale['realmail']; ?>" /></td>
    <td><input type="text" name="mail" id="mail" size="10" value="<?php echo $row_sale['mail']; ?>" /></td>
    <td><input type="text" name="fax" id="fax" size="10" value="<?php echo $row_sale['fax']; ?>" /></td>
    <td><input type="text" name="good" id="good" size="10" value="<?php echo $row_sale['good']; ?>" /></td>
    <td><input type="submit" name="Submit2" size="10" id="Submit2" value="更新"/></td>
  </tr>
     <input type="hidden" name="MM_update" value="form2">
      </form>
      <?php }else{ ?>
  <tr>
    <td><?php echo $row_sale['date']; ?></td>
    <td><?php echo $row_sale['callP']; ?></td>
    <td><?php echo $row_sale['callnum']; ?></td>    
    <td><?php echo $row_sale['bad']; ?></td>
    <td><?php echo $row_sale['access']; ?></td>
    <td><?php echo $row_sale['realmail']; ?></td>
    <td><?php echo $row_sale['mail']; ?></td>
    <td><?php echo $row_sale['fax']; ?></td>
    <td><?php echo $row_sale['good']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <?php }}?>
</table>

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
mysql_free_result($sale2);

mysql_free_result($sale);
?>
