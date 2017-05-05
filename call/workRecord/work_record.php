<?php require_once('../../Connections/db.php');
require_once('../../list_name.php');
 ?>
<?php
mysql_select_db($database_db, $db);
$query_record = "SELECT * FROM recruited ORDER BY `id` DESC";
$record = mysql_query($query_record, $db) or die(mysql_error());
$totalRows_record = mysql_num_rows($record);
$per_record = 15;
$pages_record = ceil($totalRows_record/$per_record);
if (!isset($_GET["page_record"])){ //假如$_GET["page"]未設置
        $page_record=1; //則在此設定起始頁數
    } else {		  
        $page_record = intval($_GET["page_record"]); //確認頁數只能夠是數值資料  
    }
$start_record = ($page_record-1)*$per_record; //每一頁開始的資料序號
$record2 = mysql_pconnect($hostname_db, $username_db, $password_db) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_query("SET NAMES 'utf8' ");  
$result_record = mysql_query($query_record.' LIMIT '.$start_record.', '.$per_record,$record2) or die("Error");
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
<link rel="stylesheet" type="text/css" href="../../css/record.css" />
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
<p>當前位置:應徵紀錄</p>
 <?php
					
//來電頁數選擇程式
    //分頁頁碼  
    echo '共有 '.$totalRows_record.' 筆- '.$page_record.' 頁-共 '.$pages_record.' 頁';  
    echo " | <a href=?page_call=1>第一頁</a> ";
	
	echo $page_record>1?"<a href=?page_record=".($page_record-1)."><<-</a>":" ";
    echo "第 ";?>
    <?php					
	for( $i=1 ; $i<=$pages_record ; $i++ ) {  
		if($page_record-5<$i && $i<$page_record+5 ) { ?> 
    <a href=../../workRecord/?page_record=<?php echo $i; ?> class='page_link'><?php echo $i==$page_record?'['.$i.']':$i; ?></a> 
<?php	}}    
    echo " 頁 ";
	echo $page_record<$pages_record?"<a href=?page_record=".($page_record+1).">->></a>":" ";
	echo "<a href=?page_record=".$pages_record.">末頁</a><br />"; 
	
?>  
<table width="100%" border="1">
  <tr>
    <td>姓名</td>
    <td>應徵時間</td>
    <td>應徵地點</td>
    <td>性別</td>
    <td>電話</td>
    <td>手機</td>
    <td>有無工作經驗</td>    
    <td>查看詳細資料</td>
    <td>其他操作</td>    
  </tr>
  <?php while($row_record = mysql_fetch_assoc($result_record)){ ?>
  <tr>
    <td><?php echo $row_record['name']; ?></td>
    <td><?php echo $row_record['date']; ?></td>
    <td><?php echo $row_record['recruited']; ?></td>
    <td><?php echo $row_record['sex']; ?></td>
    <td><?php echo $row_record['phone']; ?></td>
    <td><?php echo $row_record['cellphone']; ?></td>    
    <td><?php echo $row_record['workyears']; ?></td>
    <td><a href="record_detail.php?id=<?php echo $row_record['id']; ?>">[ 前往 ]</a></td>
    <td>&nbsp;</td>    
  </tr>
  <?php } ?>
</table>


<!-- InstanceEndEditable -->
</article>
<footer  _height="none">
<!-- InstanceBeginEditable name="footer" -->
<?php require_once('footer.php'); ?>
<!-- InstanceEndEditable -->
</footer>
</div>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($record);
?>
