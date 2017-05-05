<?php require_once('../../Connections/db.php'); 
require_once('../../list_name.php');
?>
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


$recruited="-1";
if(isset($_POST['recruited']) && count($_POST['recruited']) > 0 && $_POST['recruited'] != '未選擇'){
	setcookie("recruited", $_POST['recruited'], time()+3600);
	
	header('refresh: 0;url="record_search.php"');
	}
$recruited = $_COOKIE['recruited'];
	
mysql_select_db($database_db, $db);
$query_record = sprintf("SELECT * FROM recruited WHERE recruited = %s", GetSQLValueString($recruited, "text"));	
$record = mysql_query($query_record, $db) or die(mysql_error());
$totalRows_record = mysql_num_rows($record);
$per_record = 5;
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
/*if(isset($_COOKIE['name']) || isset($_COOKIE['recruited']) || isset($_COOKIE['phone']) || isset($_COOKIE['cellphone'])){
isset($_COOKIE['name'])?$name = $_COOKIE['name']:'';
isset($_COOKIE['recruited'])?$recruited = $_COOKIE['recruited']:'';
isset($_COOKIE['phone'])?$phone = $_COOKIE['phone']:'';
isset($_COOKIE['cellphone'])?$cellphone = $_COOKIE['cellphone']:'';

$sql_item = array();
if(!empty($name)) array_push($sql_item, $name);
if(!empty($recruited) && $recruited != '未選擇') array_push($sql_item, $recruited);
if(!empty($phone)) array_push($sql_item, $phone);
if(!empty($cellphone)) array_push($sql_item, $cellphone);

$sql_word = "";
for($i= 0 ;$i<count($sql_item);$i++){
	if($i==0){
		$sql_word = "WHERE";
		}
	}
}*/




?>
<?php require_once('list.php'); ?>
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
<!--<script type="text/javascript">
window.onunload = deleteCookie ;
function deleteCookie(){
	var arr = new Array ("name", "recruited");  
		for(var i =1;i<3;i++){
			eraseCookie("name");	
					}				
       } 
function formSetCookie(form){
	for(var i=1;i<form.length-1;i++){
		
		var formValue = form[i].value;
		//判斷欄位是否為空值
		
			
			
			//建立 cookie
			var selectName = form[i].name;
			var selectValue = formValue;
			setCookie(selectName, selectValue, 1);	
			
		}
		window.location.reload();
	}
</script>-->
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
<p>當前位置:收尋應徵紀錄</p>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" name="form1"> 
	<fieldset style="padding:5px; margin-left:5px;margin-right:5px;" id="fied">
    <legend >查詢應徵紀錄</legend>	
    <label for="recruited">應徵地點</label>
    <select name="recruited">
    	<option value="未選擇">未選擇</option>
    	<?php foreach($job_list as $jobname){ ?>
    	<option value="<?php echo $jobname ?>"><?php echo $jobname ?></option>
        <?php } ?>
    </select>    
    <input type="submit" name="Submit" id="Submit" value="查詢" class="searchBtn" />
    </fieldset>
</form>

<table width="100%" style="table-layout: fixed" border="1">
      <tr align="left">
        <td colspan="9">
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
        </td>
        <?php while($row_record = mysql_fetch_assoc($result_record)){ ?>
      </tr>
        <tr style="background-color:#0F9">
          <td colspan="2">☆個人資料</td>
          <td colspan="2">☆求職條件</td>
          <td colspan="2">☆交通條件</td>
          <td colspan="2">專長說明</td>
          <td>備註</td>
          </tr>
        <tr>
          <td>姓名</td>
          <td>性別</td>
          <td>應徵類別</td>
          <td>上班時段</td>
          <td>持有駕照</td>
          <td>自備車輛</td>
          <td colspan="2" rowspan="3"><?php echo $row_record['ps']; ?></td>
          <td rowspan="5"><?php echo $row_record['callPs']; ?></td>
          </tr>
        
        <tr>
          <td><?php echo $row_record['name']; ?></td>
          <td><?php echo $row_record['sex'] ?></td>
          <td><?php echo $row_record['job']?></td>
          <td>
          <?php echo $row_record['timeStart']?>
          <?php echo $row_record['timeEnd']?>          
          </td>
          <td>
          <?php echo $row_record['license']?></td>
          <td><?php echo $row_record['traffic'] ?></td>
          </tr>
        <tr>
          <td>聯絡電話</td>
          <td>行動電話</td>
          <td colspan="2">應徵工作地點</td>
          <td colspan="2">工作狀態</td>
          </tr>
        <tr>
          <td><?php echo $row_record['phone']; ?></td>
          <td><?php echo $row_record['cellphone']; ?></td>
          <td colspan="2"><?php echo $row_record['recruited']; ?></td>
          <td colspan="2" rowspan="2"><?php echo $row_record['workwhere']; ?></td>
          <td>新增日期</td>
          <td>修改日期</td>
          </tr>
        <tr>
          <td height="21" colspan="2"><p>居住地址：<?php echo $row_record['address']; ?></p></td>
          <td colspan="2">工作經驗:<?php echo $row_record['workyears']; ?></td>
          <td><?php echo $row_record['date']; ?></td>
          <td><?php echo date("Y-m-d"); ?></td>
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
/*if(isset($_COOKIE['name']) || isset($_COOKIE['recruited']) || isset($_COOKIE['phone']) || isset($_COOKIE['cellphone'])){}*/

mysql_free_result($record);

?>
