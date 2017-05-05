<?php require_once("session.php"); ?>
<?php require_once('../../Connections/db.php'); ?>
<?php require_once('../../list_name.php'); ?>
<?php require_once('../../php_class.php'); ?>
<?php
if(isset($_POST['month_F'])&&$_POST['month_F']=='month_F'){
	$month = $_POST['month'];
	$year = $_POST['years'];
	$days = $_POST['days'];
	if($month != '不限制' &&$year!='不限制'){
			setcookie("year", $year, time()+3600);
			setcookie("month", $month, time()+3600);
			setcookie("SYM", $year.$month, time()+3600);						
		}else{
			setcookie("year", $year, time()-3600);
			setcookie("month", $month, time()-3600);
			setcookie("SYM", '', time()-3600);
			
			}
	if($days != '不限制'){
		setcookie("days", $days, time()+3600);		
		}else{
		setcookie("days", $days, time()-3600);	
		}
	header('refresh: 0;url="call_page.php"');
	}
$now = date("Ym");
mysql_select_db($database_db, $db);
if(isset($_COOKIE['year'])&& $_COOKIE['year']!='不限制'&&isset($_COOKIE['month'])&& $_COOKIE['month']!='不限制'){
	$query_call_m = "SELECT * FROM `call` WHERE creatdate = ".$_COOKIE['SYM']." ORDER BY date DESC";
}else if(isset($_COOKIE['days'])&&$_COOKIE['days']!='不限制'&&!isset($_COOKIE['year'])&&!isset($_COOKIE['month'])){
	$query_call_m = "SELECT * FROM `call` WHERE date <= DATE_ADD(NOW(), INTERVAL -".$_COOKIE['days']." DAY) ORDER BY date DESC";	
	}else{
	$query_call_m = "SELECT * FROM `call` ORDER BY date DESC";
	}
$call_m = mysql_query($query_call_m, $db) or die(mysql_error());
$totalRows_call_m = mysql_num_rows($call_m);
$per_call = 5 ;
$pages_call = ceil($totalRows_call_m/$per_call);
if (!isset($_GET["page_call"])){ //假如$_GET["page"]未設置
        $page_call=1; //則在此設定起始頁數
    } else {  
        $page_call = intval($_GET["page_call"]); //確認頁數只能夠是數值資料  
    }
$start_call = ($page_call-1)*$per_call; //每一頁開始的資料序號
$call2 = mysql_pconnect($hostname_db, $username_db, $password_db) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_query("SET NAMES 'utf8' ");  
$result_call = mysql_query($query_call_m.' LIMIT '.$start_call.', '.$per_call,$call2) or die("Error");
?>
<!doctype html>
<html>
<!-- InstanceBegin template="/Templates/layout.dwt.php" codeOutsideHTMLIsLocked="false" -->
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
<script type="text/javascript" src="../../js/ajax.js"></script>
<script type="text/javascript" src="../../js/call.js"></script>
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
<p><span class="gary_word">當前位置:</span>來電紀錄</p>

<div id="table_fram">
<table width="100%" class="data_table middle" style="table-layout:fixed">
<tr><td>
<?php 
//來電頁數選擇程式
    //分頁頁碼    
	echo "<a id='FirstPage' class='page_btn' href='call_page.php?page_call=1'>第一頁</a> ";
	if($page_call>1)
	echo "<a id='prePage' class='page_btn' href='call_page.php?page_call=".($page_call-1).")'><</a>";	
	?>
    
    <?php
    //echo '第';	
	$START_BTN = $page_call-3;
	if($START_BTN<=0){$START_BTN=1;};
	$END_BTN = $START_BTN+6;
	if($END_BTN>$pages_call&&$pages_call-7>0){
		$START_BTN=$pages_call-6;		
		$END_BTN = $pages_call ;
		}else if($END_BTN>$pages_call&&$pages_call-7<=0){
			$START_BTN=1;
			$END_BTN = $pages_call ;
			};	
	for( $START_BTN ; $START_BTN<=$END_BTN ; $START_BTN++ ) {?>   
		
   <a class="page_btn" href="call_page.php?page_call=<?php echo $START_BTN; ?>"><?php echo $START_BTN; ?></a>
   
<?php	}
	if($page_call<$pages_call)
	echo "<a class='page_btn' id='nextPage' href='call_page.php?page_call=".($page_call+1)."'>></a> ";
	echo '<a id="LastPage" class="page_btn" href="call_page.php?page_call='.$pages_call.'">最後一頁</a>';	
	echo '<button class="dataSelect">共有 '.$totalRows_call.' 筆- '.$page_call.' 頁-共 '.$pages_call.' 頁</button>';
	?>  
</td>
<td>
<form method="post" action="" name="form2">
<label for="years">年份:</label>
<select name="years" id="years">
<?php
	$years =2015; 
	$year_array = array("不限制");
	    for($i=0;$i<=(date("Y")-2015);$i++){
		array_push($year_array, $years);			
		$years++;	
		}
		foreach($year_array as $name){
		echo '<option value="'.$name.'" '.($name==$_COOKIE['year']?"selected='selected'":"").'>'.$name.'</option>';	
		}
?>
</select>
<label for="month">月份:</label>
<select name="month" id="month">
<?php
	$month = array("不限制","01", "02", "03" ,"04", "05", "06", "07", "08", "09", "10", "11", "12"); 
	foreach($month as $name){
		echo '<option value="'.$name.'" '.($name==$_COOKIE['month']?"selected='selected'":"").'>'.$name.'</option>'; 
	}
?>
</select>
<label for="days">幾天前:</label>
<input type="text" name="days" id="days" value="<?php echo isset($_COOKIE['days'])?$_COOKIE['days']:'' ?>" size="5" />
<!--<select name="days">
	<option value="不限制">不限制</option>
	<option value="30">30天</option>
    <option value="60">60天</option>
    <option value="90">90天</option>    
</select>-->
<input type="submit" name="Submit2" id="Submit2" value="查詢" />
<input type="hidden" name="month_F" id="month_F" value="month_F"/>
(資料 2015年08月開始紀錄)
</form>
</td>
</tr>
</table>
<div id="demo">
<?php while($row_call_m = mysql_fetch_assoc($result_call)){ ?>
<div class="call_block">
<table width="100%" class="data_table">
  <tr>
  	<td rowspan="4" width="2%" >
    <a href="call_page_detail.php?id=<?php echo $row_call_m['id']; ?>" class="admend call_detail_btn"></a>
    <a href="mail.php?id=<?php echo $row_call_m['id']; ?>"  class="mail call_detail_btn"></a>
    <a href="call_delete.php?id=<?php echo $row_call_m['id']; ?>" class="delete call_detail_btn"></a>    
    </td>
    <td width="10%" class="ctitle">進線公司</td>
    <td width="10%" class="ctitle">進線日期</td>
    <td width="10%" class="ctitle">公司名稱</td>
    <td width="10%" class="ctitle">聯絡人</td>
    <td width="15%" class="ctitle">連絡電話</td>
    <td width="10%" class="ctitle">回覆人員</td>
    <td width="10%" class="ctitle">回覆時間</td>
    <td width="25%" class="ctitle">回覆備註</td>
  </tr>
  <tr>
  	<td><?php echo $row_call_m['froms']; ?></td>
    <td><?php echo $row_call_m['date']; ?></td>
    <td><?php echo $row_call_m['company']; ?></td>
    <td><?php echo $row_call_m['contactP']; ?></td><br />
    <td><?php 
	echo !empty($row_call_m['phone'])?'室內:<br />'.$row_call_m['phone']:'';
	if(!empty($row_call_m['phone'])){echo '<br />';};	
	echo !empty($row_call_m['cellPhone'])?'手機:<br />'.$row_call_m['cellPhone']:''; ?></td>
    <td><?php echo $row_call_m['replayP']; ?></td>
    <td><?php echo $row_call_m['repalyDate']; ?></td>
    <td><?php echo $row_call_m['replayPs']; ?></td>
  </tr>
  <tr>
  	<td class="ctitle">建檔人員</td>
    <td><?php echo $row_call_m['who']; ?></td>
    <td class="ctitle">施工內容</td>
    <td colspan="2" ><?php echo $row_call_m['contents']; ?></td>    
    <td class="ctitle">勘查人員</td>
    <td class="ctitle">勘查時間</td>
    <td class="ctitle">勘查備註</td>
  </tr>
  <tr >
  	<td><span class="ctitle">服務項目</span></td>
    <td><?php echo $row_call_m['service']; ?></td>
    <td><span class="ctitle">施工地址</span></td>
    <td colspan="2"><?php echo $row_call_m['address']; ?></td>    
    <td><?php echo $row_call_m['viewP']; ?></td>
    <td><?php echo $row_call_m['viewDate']; ?></td>
    <td><?php echo $row_call_m['viewPs']; ?></td>
  </tr>  

</table>
</div>
<hr class="hr_color" />
<?php } ?>		
</div>
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
<?php
mysql_free_result($call_m);
?>
