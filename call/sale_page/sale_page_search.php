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

$colname_sale = "-1";
$colname_phone = "-1";
$colname_cellphone = "-1";
if (isset($_POST['client'])) {
  $colname_sale = $_POST['client'];
  $colname_phone = $_POST['phone'];
  $colname_cellphone = $_POST['cellphone'];
  //設定cookie給瀏覽器作為分頁的查詢
  setcookie("client",$colname_sale,time()+3600);
  setcookie("phone",$colname_phone,time()+3600);
  setcookie("cellphone",$colname_cellphone,time()+3600);
  //因cookie 需做重新整理頁面才會生效
  header('refresh: 0;url="'.$_SERVER['PHP_SELF'].'"');
}
if(isset($_COOKIE['client'])&&$_COOKIE['client']!=NULL){
	$sql =0;
	if(!empty($_COOKIE['client'])){
		//若公司名稱部為空值
		if(!empty($_COOKIE['phone'])&&!empty($_COOKIE['cellphone'])){			
			$sql=1;//室內與手機都不為空值
			}else if(!empty($_COOKIE['phone'])&&empty($_COOKIE['cellphone'])){
			$sql=2;	//手機為空值
			}else if(empty($_COOKIE['phone'])&&!empty($_COOKIE['cellphone'])){				
			$sql=3;//室內為空值	
			}else if(empty($_COOKIE['phone'])&&empty($_COOKIE['cellphone'])){			
			$sql=4;//市內與手機都為空值	
			};
		}
		if(empty($_COOKIE['client'])){//若公司名稱部為空值		
		if(!empty($_COOKIE['phone'])&&!empty($_COOKIE['cellphone'])){			
			$sql=5;//室內與手機都不為空值
			}else if(!empty($_COOKIE['phone'])&&empty($_COOKIE['cellphone'])){			
			$sql=6;	//手機為空值
			}else if(empty($_COOKIE['phone'])&&!empty($_COOKIE['cellphone'])){			
			$sql=7;	//室內為空值	
			};
		}
switch($sql){
	case 1:
		$query_sale = sprintf("SELECT * FROM phonesale WHERE client LIKE %s AND phone = %s AND cellphone =%s", GetSQLValueString("%".$_COOKIE['client']."%", "text"),GetSQLValueString($_COOKIE['phone'], "text"),GetSQLValueString($_COOKIE['cellphone'], "text"));
		break;
	case 2:
		$query_sale = sprintf("SELECT * FROM phonesale WHERE client LIKE %s AND phone = %s ", GetSQLValueString("%".$_COOKIE['client']."%", "text"),GetSQLValueString($_COOKIE['phone'], "text"));
		break;
	case 3:
		$query_sale = sprintf("SELECT * FROM phonesale WHERE client LIKE %s AND cellphone =%s", GetSQLValueString("%".$_COOKIE['client']."%", "text"),GetSQLValueString($_COOKIE['cellphone'], "text"));
		break;
	case 4:
		$query_sale = sprintf("SELECT * FROM phonesale WHERE client LIKE %s ", GetSQLValueString("%".$_COOKIE['client']."%", "text"));
		break;
	case 5:
		$query_sale = sprintf("SELECT * FROM phonesale WHERE phone = %s AND cellphone =%s", GetSQLValueString($_COOKIE['phone'], "text"),GetSQLValueString($_COOKIE['cellphone'], "text"));
		break;
	case 6:
		$query_sale = sprintf("SELECT * FROM phonesale WHERE phone = %s", GetSQLValueString($_COOKIE['phone'], "text"));
		break;
	case 7:
		$query_sale = sprintf("SELECT * FROM phonesale WHERE cellphone =%s", GetSQLValueString($_COOKIE['cellphone'], "text"));
		break;
	}
mysql_select_db($database_db, $db);
$sale = mysql_query($query_sale, $db) or die(mysql_error());
$totalRows_sale = mysql_num_rows($sale);
$per_sale = 5;
$pages_sale = ceil($totalRows_sale/$per_sale);
if(!isset($_GET['page_sale'])){
	$page_sale = 1;
	}else{
	$page_sale = intval($_GET['page_sale']);
	};
	$start_sale = ($page_sale-1)*$per_sale;
	$sale2 = mysql_pconnect($hostname_db, $username_db, $password_db) or trigger_error(mysql_error(),					E_USER_ERROR); 
mysql_query("SET NAMES 'utf8' "); 
	$result_sale = mysql_query($query_sale.' ORDER BY date DESC LIMIT '.$start_sale.', '.$per_sale,$sale2) or die("Error");
	
}//if cookie isset and not null --END
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
<script type="text/javascript">
function research(){					
			document.cookie = "client=; expire=Thu, 18 Dec 2013 12:00:00 GMT;";				
			document.cookie = "phone=; expire=Thu, 18 Dec 2013 12:00:00 GMT;";
			document.cookie = "cellphone=; expire=Thu, 18 Dec 2013 12:00:00 GMT;";
			location.reload(true);				
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
<p><span class="gary_word">當前位置:</span>電訪紀錄</p>
<table width="100%" border="1"><tr><td align="left">
<p>收尋資料條件(☆☆電話號碼請務必輸入完整號碼☆☆)</p>
<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  <label for="client">客戶名稱:</label>
  <input type="text" name="client" id="client">
  <label for="phone">室內電話:</label>
  <input type="text" name="phone" id="phone">
  <label for="cellphone">手機號碼:</label>
  <input type="text" name="cellphone" id="cellphone">
  <input type="submit" name="button" id="button" value="查詢" class="searchBtn">
  <button type="button" onClick="research()">重新查詢</button>
</form>
</td></tr></table>
<table class="detail_table" width="100%">
<tr><td>
<?php if(isset($_COOKIE['client'])&&!empty($_COOKIE['client'])){
//來電頁數選擇程式
    //分頁頁碼  
    echo '共有 '.$totalRows_sale.' 筆- '.$page_sale.' 頁-共 '.$pages_sale.' 頁';  
    echo "<a href=?page_sale=1>第一頁</a> "; 
    echo "第 ";?>
    <?php					
	for( $i=1 ; $i<=$pages_sale ; $i++ ) {  
		if ( $page_sale-5 < $i && $i < $page_sale+5 ) { ?> 
    <a href=?page_sale=<?php echo $i; ?> class='page_link'><?php echo $i; ?></a> 
<?php	}}    
    echo " 頁 ";
	echo "<a href=?page_sale=".$pages_sale.">末頁</a><br />";
	echo $_COOKIE['client']; 
}
?>  
</td></tr>
</table>
<div id="sale_detail">
<?php if(isset($_COOKIE['client'])&&$_COOKIE['client']!=NULL){
	while($row_sale = mysql_fetch_assoc($result_sale)){ ?>
<div class="sale_block">
<table width="100%" class="detail_table">
  <tr>
    <td rowspan="2" width="5%">
    <a href="sale_page_detail.php?id=<?php echo $row_sale['id']; ?>" class="btn_sale amend">修改</a>
    <a href="mail.php?id=<?php echo $row_sale['id']; ?>" class="btn_sale mail"></a>
    <a href="" class="btn_sale detele"></a>
    </td>
    <td width="10%">電訪員</td>
    <td width="10%">客戶編號</td>
    <td width="15%">公司名稱</td>
    <td width="10%">聯絡人</td>
    <td width="15%">聯絡電話</td>
    <td width="10%">回復人員</td>
    <td width="10%">回覆時間</td>
    <td width="15%">回復備註</td>
  </tr>
  <tr>
    <td><?php echo $row_sale['callP']; ?></td>
    <td><?php echo $row_sale['clientnum']; ?></td>
    <td><?php echo $row_sale['client']; ?></td>
    <td><?php echo $row_sale['responsible']; ?></td>
    <td><?php echo $row_sale['phone']; ?><br /><?php echo $row_sale['cellphone']; ?></td>
    <td><?php echo $row_sale['saleP']; ?></td>
    <td><?php echo $row_sale['saleDate']; ?></td>
    <td><?php echo $row_sale['salePs']; ?></td>
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
    <td><?php echo $row_sale['id']; ?></td>
    <td><?php echo $row_sale['date']; ?></td>
    <td colspan="2"><?php echo $row_sale['serviceC']; ?></td>
    <td colspan="2"><?php echo $row_sale['address']; ?></td>
    <td><?php echo $row_sale['lookP']; ?></td>
    <td><?php echo $row_sale['lookDate']; ?></td>
    <td><?php echo $row_sale['lookPs']; ?></td>
  </tr>
</table>
</div>
<?php }}?>
</div>
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
if(isset($_COOKIE['client'])&&$_COOKIE['client']!=NULL){
mysql_free_result($sale);}
?>
