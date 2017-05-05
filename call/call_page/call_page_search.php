<?php require_once("session.php"); ?>
<?php require_once('../../Connections/db.php'); ?>
<?php require_once('../../list_name.php'); ?>
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

$colname_call_search = "-1";
$colname_phone = -1 ;
$colname_cellPhone = -1;
if (isset($_POST['company'])) {
  $colname_call_search = $_POST['company'];
  $colname_phone = $_POST['phone'];
  $colname_cellPhone = $_POST['cellPhone'];
  setcookie("company",$colname_call_search,time()+3600);
  setcookie("phone",$colname_phone,time()+3600);
  setcookie("cellPhone",$colname_cellPhone,time()+3600);
  header('refresh: 0;url="call_page_search.php"');
  }
if(isset($_COOKIE['company']) && $_COOKIE['company']!=NULL){
mysql_select_db($database_db, $db);
//判斷公司名稱是否為空值
if(!empty($_COOKIE['company'])){
	//若是室內不為空，手機為空值
	if(!empty($_COOKIE['phone']) && empty($_COOKIE['cellPhone'])){
//seach
$query_call_search = sprintf("SELECT * FROM `call` WHERE `company` LIKE %s AND `phone` = %s ", GetSQLValueString("%" . $_COOKIE['company'] . "%", "text"), GetSQLValueString($_COOKIE['phone'], "text"));
		}else if(empty($_COOKIE['phone']) && !empty($_COOKIE['cellPhone'])){
	//若是室內為空值，手機步為空值
//seach
$query_call_search = sprintf("SELECT * FROM `call` WHERE `company` LIKE %s AND `cellPhone` = %s ", GetSQLValueString("%" . $_COOKIE['company'] . "%", "text"), GetSQLValueString($_COOKIE['cellPhone'], "text"));
			}else if(!empty($_COOKIE['phone']) && !empty($_COOKIE['cellPhone'])){
//seach
$query_call_search = sprintf("SELECT * FROM `call` WHERE `company` LIKE %s AND `phone` = %s AND `cellPhone` = %s ", GetSQLValueString("%".$_COOKIE['company']."%", "text"), GetSQLValueString($_COOKIE['phone'], "text"), GetSQLValueString($_COOKIE['cellPhone'], "text"));
				}else{
//seach
$query_call_search = sprintf("SELECT * FROM `call` WHERE `company` LIKE %s ", GetSQLValueString("%" . $_COOKIE['company'] . "%", "text"));
					}
	//公司名稱不為空值結束
	//公司名稱為空值
	}else if(empty($_COOKIE['company'])){
		//若是室內不為空，手機為空值
	if(!empty($_COOKIE['phone']) && empty($_COOKIE['cellPhone'])){
//seach
$query_call_search = sprintf("SELECT * FROM `call` WHERE `phone` = %s ", GetSQLValueString( $_COOKIE['phone'], "text"));
		}else if(empty($_COOKIE['phone']) && !empty($_COOKIE['cellPhone'])){
	//若是室內為空值，手機步為空值
//seach
$query_call_search = sprintf("SELECT * FROM `call` WHERE `cellPhone` = %s ", GetSQLValueString($_COOKIE['cellPhone'], "text"));
			}else if(!empty($_COOKIE['phone']) && !empty($_COOKIE['cellPhone'])){
//seach
$query_call_search = sprintf("SELECT * FROM `call` WHERE `phone` = %s AND `cellPhone` = %s ",  GetSQLValueString($_COOKIE['phone'], "text"), GetSQLValueString($_COOKIE['cellPhone'], "text"));
					};
		};
		
$call_search = mysql_query($query_call_search, $db) or die(mysql_error());
$totalRows_call_search = mysql_num_rows($call_search);$per_call = 5;
$pages_call = ceil($totalRows_call_search/$per_call);
if (!isset($_GET["page_call"])){ //假如$_GET["page"]未設置
        $page_call=1; //則在此設定起始頁數
    } else {  
        $page_call = intval($_GET["page_call"]); //確認頁數只能夠是數值資料  
    }
$start_call = ($page_call-1)*$per_call; //每一頁開始的資料序號
$call2 = mysql_pconnect($hostname_db, $username_db, $password_db) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_query("SET NAMES 'utf8' ");  
$result_call = mysql_query($query_call_search.'ORDER BY date DESC LIMIT '.$start_call.', '.$per_call,$call2) or die("Error");}
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
<link href="../../css/call.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
function research(){					
			document.cookie = "company=; expire=Thu, 18 Dec 2013 12:00:00 GMT;";				
			document.cookie = "phone=; expire=Thu, 18 Dec 2013 12:00:00 GMT;";
			document.cookie = "cellPhone=; expire=Thu, 18 Dec 2013 12:00:00 GMT;";
			location.reload(true);				
	}
function submitForm(){
	form1.submit;
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
<p><span class="gary_word">當前位置:</span>查詢來電紀錄</p>
<table width="100%" border="1">
  <tr>
    <td align="left" ><form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
     <p>收尋資料條件(☆☆電話號碼請務必輸入完整號碼☆☆)</p>
    
    <hr class="hr_style" />
      
        <label for="company">公司名稱：</label>
        <input type="text" name="company" id="company" value="<?php echo isset($_COOKIE['company'])?$_COOKIE['company']:"" ?>">
        <label for="phone">聯絡電話：</label>
        <input type="text" name="phone" id="phone" value="<?php echo isset($_COOKIE['phone'])?$_COOKIE['phone']:"" ?>">
        <label for="cellPhone">聯絡手機：</label>
        <input type="text" name="cellPhone" id="cellPhone" value="<?php echo isset($_COOKIE['cellPhone'])?$_COOKIE['cellPhone']:"" ?>">        
        <input type="submit" name="companyseach" id="companyseach" value="查詢" class="searchBtn" >
        <button type="button"  onClick="research()">重新收尋</button>
    </form>
</td>
  </tr>
</table>
<table width="100%" class="data_table">
<tr><td>
<?php
if(isset($_COOKIE['company']) && !empty($_COOKIE['company'])){
//來電頁數選擇程式
    //分頁頁碼  
    echo '共有 '.$totalRows_call_search.' 筆- '.$page_call.' 頁-共 '.$pages_call.' 頁';  
    echo "<a href=?page_call=1>第一頁</a> "; 
    echo "第 ";?>
    <?php					
	for( $i=1 ; $i<=$pages_call ; $i++ ) {  
		if ( $page_call-5 < $i && $i < $page_call+5 ) { ?> 
    <a href=?page_call=<?php echo $i; ?> class='page_link'><?php echo $i; ?></a> 
<?php	}}    
    echo " 頁 ";
	echo "<a href=?page_call=".$pages_call.">末頁</a><br />"; 
	}
?>  
</td></tr>

</table>
<div id="table_fram">
<?php 
if(isset($_COOKIE['company']) && $_COOKIE['company']!=NULL){
while($row_call_m = mysql_fetch_assoc($result_call)){ ?>
<div class="call_block">
<table width="100%" class="data_table">

  <tr>
  	<td rowspan="4" width="2%">
    <a href="call_page_detail.php?id=<?php echo $row_call_m['id']; ?>" class="admend call_detail_btn"></a>
    <a href="mail.php?id=<?php echo $row_call_m['id']; ?>" class="mail call_detail_btn"></a>
    <a href="#" class="delete call_detail_btn"></a>    
    </td>
    <td width="10%">進線公司</td>
    <td width="10%">進線日期</td>
    <td width="20%">公司名稱</td>
    <td width="5%">聯絡人</td>
    <td width="15%">連絡電話</td>
    <td width="10%">回覆人員</td>
    <td width="10%">回覆時間</td>
    <td width="10%">回覆備註</td>
  </tr>
  <tr>
  	<td><?php echo $row_call_m['froms']; ?></td>
    <td><?php echo $row_call_m['date']; ?></td>
    <td><?php echo $row_call_m['company']; ?></td>
    <td><?php echo $row_call_m['contactP']; ?></td>
    <td>室內:<?php echo $row_call_m['phone']; ?><br />手機:<?php echo $row_call_m['cellPhone']; ?></td>
    <td><?php echo $row_call_m['replayP']; ?></td>
    <td><?php echo $row_call_m['repalyDate']; ?></td>
    <td><?php echo $row_call_m['replayPs']; ?></td>
  </tr>
  <tr>
  	<td>建檔人員</td>
    <td>服務項目</td>
    <td>施工內容</td>
    <td colspan="2">施工地址</td>    
    <td>勘查人員</td>
    <td>勘查時間</td>
    <td>勘查備註</td>
  </tr>
  <tr >
  	<td><?php echo $row_call_m['who']; ?></td>
    <td><?php echo $row_call_m['service']; ?></td>
    <td><?php echo $row_call_m['contents']; ?></td>
    <td colspan="2"><?php echo $row_call_m['address']; ?></td>    
    <td><?php echo $row_call_m['viewP']; ?></td>
    <td><?php echo $row_call_m['viewDate']; ?></td>
    <td><?php echo $row_call_m['viewPs']; ?></td>
  </tr>  

</table>
</div>
<?php }} ?>
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
if(isset($_COOKIE['company'])){
mysql_free_result($call_search);}
?>
