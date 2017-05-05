<?php 
	/**未處理電訪資料查詢**/
$now=date("Ym");
mysql_select_db($database_db, $db);
if(isset($_POST['search_S'])&&$_POST['search_S']=='search_S'){	
	$sale_month = $_POST['month_S'];
	if($sale_date!='不限制'){
		setcookie("date_S", $sale_date, time()+3600);
		}else{
		setcookie("date_S", "", time()-3600);	
			}
		header('refresh: 0;url="call_index.php"');	
	}
$query_sale ="";
if(isset($_COOKIE['date_S'])){
	$query_sale = "SELECT * FROM `phonesale` WHERE saleP ='未處理' AND TO_DAYS(NOW()) - TO_DAYS(date) <= ".$_COOKIE['date_S']." ORDER BY date DESC";
	}else{
	$query_sale = "SELECT * FROM `phonesale` WHERE saleP ='未處理'  ORDER BY date DESC";	
		}

$sale = mysql_query($query_sale, $db) or die(mysql_error());
$totalRows_sale = mysql_num_rows($sale);
$per_sale = 10;
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
?>
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
<?php mysql_free_result($sale); ?>