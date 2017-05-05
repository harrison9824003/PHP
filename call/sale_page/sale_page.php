<?php require_once("session.php"); ?>
<?php require_once('../../list_name.php'); ?>
<?php require_once('../../Connections/db.php'); ?>
<?php
if(isset($_POST['month_F'])&&$_POST['month_F']=='month_F'){
	$month = $_POST['month'];
	$year = $_POST['years'];
	$day= $_POST['day'];
	if($month != '不限制' &&$year!='不限制'){
			setcookie("yearS", $year, time()+3600);
			setcookie("monthS", $month, time()+3600);
			setcookie("dayS", '31', time()+3600);
			setcookie("SYMS", $year."-".$month."-".'31', time()+3600);
		}else{
			setcookie("yearS", '', time()-3600);
			setcookie("monthS", '', time()-3600);
			setcookie("dayS", '', time()-3600);
			setcookie("SYMS", '', time()-3600);	
			}
	header('refresh: 0;url="sale_page.php"');
	}
$now = date("Ym");
mysql_select_db($database_db, $db);
if(isset($_COOKIE['SYMS'])){
$query_sale = "SELECT * FROM `phonesale` WHERE `date` <= '".$_COOKIE['SYMS']."'";
}else{
$query_sale = "SELECT * FROM `phonesale` WHERE time = $now";	
	}
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
<p><span class="gary_word">當前位置:</span>電訪紀錄</p>
<table class="detail_table" width="100%">
<tr><td>

<?php
//來電頁數選擇程式
    //分頁頁碼  
    echo '共有 '.$totalRows_sale.' 筆- '.$page_sale.' 頁-共 '.$pages_sale.' 頁';  
    echo "<a href=?page_sale=1>第一頁</a> ";
	echo $page_sale>1?"<a href=?page_sale=".($page_sale-1)."><<-</a>":" "; 
    echo "第 ";?>
    <?php					
	for( $i=1 ; $i<=$pages_sale ; $i++ ) {  
		if ( $page_sale-5 < $i && $i < $page_sale+5 ) { ?> 
    <a href=?page_sale=<?php echo $i; ?> class='page_link'><?php echo $i; ?></a> 
<?php	}}    
    echo " 頁 ";
	echo $page_sale<$pages_sale?"<a href=?page_sale=".($page_sale+1).">->></a>":" ";
	echo "<a href=?page_sale=".$pages_sale.">末頁</a><br />"; 
?>  
</td>
<td>
<form method="post" action="" name="form2">
<label for="years">年份:</label>
<select name="years" id="years"  required>
<?php
	$years =2015; 
	$year_array = array("不限制");
	    for($i=0;$i<=(date("Y")-2015);$i++){
		array_push($year_array, $years);			
		$years++;	
		}
		foreach($year_array as $name){
		echo '<option value="'.$name.'" '.($name==$_COOKIE['yearS']?"selected='selected'":"").'>'.$name.'</option>';	
		}
?>
</select>
<label for="month">月份:</label>
<select name="month" id="month"  required>
<?php
	$month = array("不限制","01", "02", "03" ,"04", "05", "06", "07", "08", "09", "10", "11", "12"); 
	foreach($month as $name){
		echo '<option value="'.$name.'" '.($name==$_COOKIE['monthS']?"selected='selected'":"").'>'.$name.'</option>'; 
	}
?>
</select>
<input type="submit" name="Submit2" id="Submit2" value="查詢" />
<input type="hidden" name="month_F" id="month_F" value="month_F"/>
(資料是從 2015年08月開始紀錄)
</form>
</td>
</tr>
</table>
<div id="sale_detail">
<?php while($row_sale = mysql_fetch_assoc($result_sale)){ ?>
<div class="sale_block">
<table width="100%" class="detail_table">
  <tr>
    <td rowspan="2" width="5%">
    <a href="sale_page_detail.php?id=<?php echo $row_sale['id']; ?>" class="btn_sale amend">修改</a>
    <a href="mail.php?id=<?php echo $row_sale['id']; ?>" class="btn_sale mail"></a>
    <a href="" class="btn_sale add_PDF"></a>
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
<?php }; ?>
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
mysql_free_result($sale);
?>
