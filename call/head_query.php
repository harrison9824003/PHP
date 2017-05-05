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
?>