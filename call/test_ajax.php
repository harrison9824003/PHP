<?php 
	require_once('../Connections/db.php');
	require_once('../php_class.php'); 
	require_once('../search_class.php');
	$class = $_REQUEST['class_N'];
	$date =$_REQUEST['date_N'];	
	$days = $_REQUEST['days_N'];
	$status = $_REQUEST['status_N'];
	$call_page = $_REQUEST['page'];
?>
<?php	
	if($class == 'call'){	
	mysql_select_db($database_db, $db);
			$new_sql = new searchFunction;
			$new_sql->classN=$class;//資料庫名稱
			//$company;公司名稱
			$new_sql->dateN=$date;//日期
			$new_sql->days=$days;//推演天數
			$new_sql->status=$status;//狀態
			$new_sql->budling_sql();
			//$new_sql->creat_pod();			
			$call = mysql_query($new_sql->sql, $db) or die(mysql_error());
			//echo $query_call;
			//$row_call = mysql_fetch_assoc($call);
			$totalRows_call = mysql_num_rows($call);
			$per_call = 5 ;
			$pages_call = ceil($totalRows_call/$per_call);
			if ($call_page=='undefined'){ //假如$_GET["page"]未設置
					$page_call=1; //則在此設定起始頁數
				} else {  
					$page_call = intval($call_page); //確認頁數只能夠是數值資料
				}
			$start_call = ($page_call-1)*$per_call; //每一頁開始的資料序號
			//$new_sql -> POD_query($start_call, $per_call);
			$call2 = mysql_pconnect($hostname_db, $username_db, $password_db) or trigger_error(mysql_error(),E_USER_ERROR); 			
			mysql_select_db($database_db, $call2);
			mysql_query("SET NAMES 'utf8' "); 
			$result_call = mysql_query($new_sql->sql.' LIMIT '.$start_call.', '.$per_call,$call2) or die("Error".mysql_error());
			?>
<div class="demo_select">
  	<?php 
	//btn 物件引用 php_class.php
	$btn_call = new page_btn; 
	$btn_call -> btn_create($page_call,$pages_call,7);
	?>
    </div> 
<?php while($row_call_m = mysql_fetch_assoc($result_call)){ ?>          
<div class="call_block">
<table width="100%" class="data_table">
  <tr>
  	<td rowspan="4" width="2%">
    <a href="call_page/call_page_detail.php?id=<?php echo $row_call_m['id']; ?>" class="admend call_detail_btn"></a>
    <a href="call_page/mail.php?id=<?php echo $row_call_m['id']; ?>"  class="mail call_detail_btn"></a>
    <a href="call_page/call_delete.php?id=<?php echo $row_call_m['id']; ?>" class="delete call_detail_btn"></a>    
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
			
<?php }

	if($class == 'phonesale'){
		/**未處理電訪資料查詢**/
			mysql_select_db($database_db, $db);//連結資料庫
			$new_sqls = new searchFunction;			
			$new_sqls->classN=$class;//資料庫名稱
			//$company;公司名稱
			$new_sqls->dateN=$date;//日期
			$new_sqls->days=$days;//推演天數
			$new_sqls->status=$status;//狀態
			$new_sqls->budling_sqls();			 				
			$sale = mysql_query($new_sqls->sql, $db) or die(mysql_error());
			$totalRows_sale = mysql_num_rows($sale);
			$per_sale = 5;
			$pages_sale = ceil($totalRows_sale/$per_sale);
			if ($call_page=='undefined'){ //假如$_GET["page"]未設置
        	$page_sale=1; //則在此設定起始頁數
    		} else {  
        	$page_sale = intval($call_page); //確認頁數只能夠是數值資料  
   			}
$start_sale = ($page_sale-1)*$per_sale; //每一頁開始的資料序號
$sale2 = mysql_pconnect($hostname_db, $username_db, $password_db) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_query("SET NAMES 'utf8' ");  
$result_sale = mysql_query($new_sqls->sql.' LIMIT '.$start_sale.', '.$per_sale,$sale2) or die("Error");
?>
<div class="demo_select">
<?php 
	$btn_sale = new page_btn;
	$btn_sale ->  btn_create($page_sale,$pages_sale,7);
?>
</div>
<div id="sale_detail">
<?php while($row_sale = mysql_fetch_assoc($result_sale)){ ?>
<div class="sale_block">
<table width="100%" class="detail_table">
  <tr>
    <td rowspan="2" width="5%">
    <a href="sale_page/sale_page_detail.php?id=<?php echo $row_sale['id']; ?>" class="btn_sale amend">修改</a>
    <a href="sale_page/mail.php?id=<?php echo $row_sale['id']; ?>" class="btn_sale mail"></a>
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
<?php		
		}//查尋結束
?>


