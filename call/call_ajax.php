<?php 
/**資料的日期與服務項目查詢**/
if(isset($_POST['searchCheck']) && $_POST['searchCheck']){
	$date1 = $_POST['date'];
	//$date2 = $_POST['date2'];
	$service = $_POST['service'];
	$sql_array = array();
	if($date1 != '不限制'){
			//$msg = "測試";
			setcookie("date", $date1, time()+3600);
		}else{
			setcookie("date", '', time()-3600);
			}
	/*if($date2 != ''){
			$msg = "測試";
		}*/
	if($service != '不限制'){
			//$msg = "測試";
			setcookie("service", $service, time()+3600);
		}else{
			setcookie("service", $service, time()-3600);
			}
	header('refresh: 0;url="call_index.php"');
	}
/**未處理來電紀錄資料查詢--START--**/
mysql_select_db($database_db, $db);
/**檢查是否有日期與服務項目的 COOKIE**/
$query_call = "";
if(!isset($_COOKIE['date'])&&!isset($_COOKIE['service'])){
$query_call = "SELECT * FROM `call` WHERE replayP ='未處理' ORDER BY date DESC";
}
if(isset($_COOKIE['date'])&&!isset($_COOKIE['service'])){	
$query_call = "SELECT * FROM `call` WHERE replayP ='未處理' AND TO_DAYS(NOW()) - TO_DAYS(date) <= ".$_COOKIE['date']." ORDER BY date DESC";	
	}
if(!isset($_COOKIE['date'])&&isset($_COOKIE['service'])){	
$query_call = "SELECT * FROM `call` WHERE replayP ='未處理' AND service = '".$_COOKIE['service']."' ORDER BY date DESC";	
	}
if(isset($_COOKIE['date'])&&isset($_COOKIE['service'])){	
$query_call = "SELECT * FROM `call` WHERE replayP ='未處理' AND  TO_DAYS(NOW()) - TO_DAYS(date) <= ".$_COOKIE['date']." AND service = '".$_COOKIE['service']."' ORDER BY date DESC";	
	}
$call = mysql_query($query_call, $db) or die(mysql_error());
$totalRows_call = mysql_num_rows($call);
$per_call = 10;
$pages_call= ceil($totalRows_call/$per_call);
if (!isset($_GET["page_call"])){ //假如$_GET["page"]未設置
        $page_call=1; //則在此設定起始頁數
    } else {		  
        $page_call = intval($_GET["page_call"]); //確認頁數只能夠是數值資料  
    }
$start_call = ($page_call-1)*$per_call; //每一頁開始的資料序號
$call2 = mysql_pconnect($hostname_db, $username_db, $password_db) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_query("SET NAMES 'utf8' ");  
$result_call = mysql_query($query_call.' LIMIT '.$start_call.', '.$per_call,$call2) or die("Error");
/***查詢來電紀錄結束***/
?>
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
 <?php mysql_free_result($call); ?>