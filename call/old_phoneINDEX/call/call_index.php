<?php require_once("session.php"); ?>
<?php require_once('../Connections/db.php'); 
		require_once('../list_name.php');
		require_once('head_query.php');
?>
<!doctype html>
<html><!-- InstanceBegin template="/Templates/layout.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>網站與電話記錄管理</title>
<link href="../css/call.css" rel="stylesheet" type="text/css">
<!-- InstanceEndEditable -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<link href="../css/layout.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js/layout.js"></script>
<script type="text/javascript" src="../js/minwt.auto_full_height.mini.js"></script>
<!-- InstanceBeginEditable name="head" -->
<script type="text/javascript">
/**來電紀錄與電訪紀錄 DIV 轉換**/
$(document).ready(function(e) {
<?php if(isset($_GET["page_call"])){?>
	$("#tab1").show();
	$(".tabs li:eq(0)").css("background-color","#0C6");
	$(".tabs li:eq(1)").css("background-color","#999");
    $("#tab2").hide();	
<?php }else if(isset($_GET["page_sale"])){ ?>
	$("#tab2").show();
	$(".tabs li:eq(1)").css("background-color","#0C6");
	$(".tabs li:eq(0)").css("background-color","#999");
    $("#tab1").hide();	
<?php } ?>
});
</script>
<style type="text/css">
footer {
	height: 35px;
	width: 100%;
	position: fixed;
	bottom: 0px;
	background-color: #093;
	padding-top: 5px;
	padding-bottom: 5px;
}
</style>
<!-- InstanceEndEditable -->
</head>

<body>
<div id="wapper" none="true">
<header  _height="none">
<!-- InstanceBeginEditable name="EditRegion5" -->
<?php require_once('../header.php'); ?>
<!-- InstanceEndEditable -->
<div id="logo"><img src="../img/logo-2_s1.png" width="100%" height="37"></div>
</header>
<article _height="auto">
<!-- InstanceBeginEditable name="contact" -->
<div id="clean_layout"></div>
<p>當前位置:電話紀錄</p>
<div class="abgne_tab">
		<ul class="tabs">
			<li>來電</li>
			<li>電訪</li>
		</ul>
 
		<div class="tab_container">
			<div id="tab1" class="tab_content">
				<h2>待處理來電紀錄</h2>
                <table width="100%" class="data_table" >
                  <tr>
                    <td colspan="9">                    
       <?php             

//來電頁數選擇程式
    //分頁頁碼  
    echo '共有 '.$totalRows_call.' 筆- '.$page_call.' 頁-共 '.$pages_call.' 頁';  
    echo " | <a href=?page_call=1>第一頁</a> ";
	
	echo $page_call>1?"<a href=?page_call=".($page_call-1)."><<-</a>":" ";
    echo "第 ";?>
    <?php					
	for( $i=1 ; $i<=$pages_call ; $i++ ) {  
		if($page_call-5<$i && $i<$page_call+5 ) {		?> 
    <a href=?page_call=<?php echo $i; ?> class='page_link'><?php echo $i; ?></a> 
<?php	}}    
    echo " 頁 ";
	echo $page_call<$pages_call?"<a href=?page_call=".($page_call+1).">->></a>":" ";
	echo "<a href=?page_call=".$pages_call.">末頁</a><br />"; 
	
?>  

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="form">
<label for="date">時間(天):</label>
<select name="date" id="date" class="select_color"  >
<?php 
	$day_array = array ("不限制", "7", "14", "30", "60");
	foreach($day_array as $day){
		echo '<option value="'.$day.'" '.($_COOKIE['date']==$day?"selected='selected'":"").'>'.$day.'</option>';
		}
?>
</select>
<!--<label for="date2">其他天數:</label>
<input type="text" name="date2" id="date2" size="5" class="select_color"/>-->
<label for="service"> 服務項目:</label>
<select name="service" id="service"  class="select_color">
<?php
$service = array ("不限制", "地板打蠟", "地毯清洗", "駐點清潔", "病媒防治", "石材美容", "外牆清洗", "水塔清洗", "沙發清洗", "其他");
foreach($service as $name){
echo '<option value="'.$name.'"  '.($name==$_COOKIE['service']?"selected='selected'":"").' >'.$name.'</option>';
} ?>
</select>
<input type="hidden" name="searchCheck" id="searchCheck" value="checked" />
<input type="submit" name="submit" id="submit" value="查詢" />
</form>


                  </td>
                  </tr>
                  <tr>
                  	<td>狀態</td>
                    <td>進線</td>                    
                    <td>進線時間</td>
                    <td>客戶名稱</td>
                    <td>服務項目</td>
                    <td>聯絡人</td>
                    <td>連絡電話</td>
                    <td>聯絡手機</td>
                    <td>&nbsp;</td>
                  </tr>
                  <?php while($row_call = mysql_fetch_array($result_call)){?>
                  <tr>
                  	<td><img src="../img/icon/<?php echo $row_call['replayP']=='未處理'?'F_notOk.png':'F_ok.png'; ?>" width="20" height="20"></td>
                    <td><?php echo $row_call['froms']; ?></td>                    
                    <td><?php echo $row_call['date']; ?></td>
                    <td><?php echo $row_call['company']; ?></td>
                    <td><?php echo $row_call['service']; ?></td>
                    <td><?php echo $row_call['contactP']; ?></td>
                    <td><?php echo $row_call['phone']; ?></td>
                    <td><?php echo $row_call['cellPhone']; ?></td>
                    <td><a href="call_page/call_page_detail.php?id=<?php echo $row_call['id']; ?>" class="book"></a></td>
                  </tr>
                  <?php } ?>
                </table>

			</div>
			<div id="tab2" class="tab_content">
				<h2>待處理電訪紀錄</h2>
				<table width="100%" class="data_table" id="data_table">
                  <tr>
                    <td colspan="9">
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
<form method="post" action="" name="form3">
	<label for="date_S">時間(天):</label>
    <select name="date_S" id="date_S" class="select_color"  >
    <?php 
        $day_array = array ("不限制", "7", "14", "30", "60", "90", "120");
        foreach($day_array as $day){
            echo '<option value="'.$day.'" '.($_COOKIE['date_S']==$day?"selected='selected'":"").'>'.$day.'	</option>';
            }
    ?>
</select>	
    <input type="submit" name="Submit_S" id="Submit_S" value="查詢" />
    <input type="hidden" name="search_S" id="search_S" value="search_S" />
</form>
                    </td>
                    </tr>
                  <tr>
                  	<td>狀態</td>
                    <td>客戶名稱</td>                    
                    <td>電訪時間</td>
                    <td>電訪員</td>
                    <td colspan="2">洽談內容</td>
                    <td>連絡電話</td>
                    <td>聯絡手機</td>
                    <td>&nbsp;</td>
                  </tr>
                  <?php while($row_sale = mysql_fetch_array($result_sale)){?>
                  <tr>
                  	<td><img src="../img/icon/<?php echo $row_sale['saleP']=='未處理'?'F_notOk.png':'F_ok.png'; ?>" width="20" height="20"></td>
                    <td><?php echo $row_sale['client']; ?></td>                    
                    <td><?php echo $row_sale['date']; ?></td>
                    <td><?php echo $row_sale['saleP']; ?></td>
                    <td colspan="2"><?php echo mb_substr($row_sale['serviceC'],0,15,"utf-8")."..."; ?></td>
                    <td><?php echo $row_sale['phone']; ?></td>
                    <td><?php echo $row_sale['cellphone']; ?></td>
                    <td><a href="sale_page/sale_page_detail.php?id=<?php echo $row_sale['id'];?>" class="book"></a></td>
                  </tr>
                  <?php } ?>
                </table>
			</div>
		</div>
</div>
<!-- InstanceEndEditable -->
</article>
<footer  _height="none">
<!-- InstanceBeginEditable name="footer" -->
<div id="footer_nav">
	<div>
    	<span class="fname_btn"><a href="#">使用者</a></span>
    	<span class="fn_btn setting"><a href="#">設定</a></span>        
      <span class="fn_btn loginOut"><a href="../loginOut.php">登出</a></span>
    </div>
	<div>
    	<span class="fname_btn"><a href="#">來電紀錄</a></span>
    	<span class="fn_btn btn_add"><a href="call_page/call_page_add.php">新增</a></span>
        <span class="fn_btn btn_look"><a href="call_page/call_page.php">查看</a></span>
        <span class="fn_btn btn_search"><a href="call_page/call_page_search.php">收尋</a></span>
    </div>
	<div>
    	<span class="fname_btn"><a href="#">電訪紀錄</a></span>
    	<span class="fn_btn btn_add"><a href="sale_page/sale_page_add.php">新增</a></span>
        <span class="fn_btn btn_look"><a href="sale_page/sale_page.php">查看</a></span>
        <span class="fn_btn btn_search"><a href="sale_page/sale_page_search.php">收尋</a></span>
        <span class="fn_btn btn_record"><a href="sale_page/saleRecord.php">紀錄</a></span>
    </div>
    <div>
    	<span class="fname_btn"><a href="#">應徵紀錄</a></span>        
    	<span class="fn_btn btn_add"><a href="workRecord/record_add.php">新增</a></span>
        <span class="fn_btn btn_look"><a href="workRecord/work_record.php">查看</a></span>
        <span class="fn_btn btn_search"><a href="workRecord/record_search.php">收尋</a></span>
    </div>    
</div>
<!-- InstanceEndEditable -->
</footer>
</div>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($sale);

mysql_free_result($call);
?>
