<?php 
require_once('../../Connections/db.php'); 
require_once('list.php');
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	/*判斷應徵地點*/
	$recruited ="";
	if(strlen($_POST['recruited2'])>0){
		$recruited = $_POST['recruited2'];
		mysql_select_db($database_db, $db);
		$sql = "INSERT INTO jobaddress(name) VALUES ('$recruited')";
  		mysql_query($sql, $db) or die(mysql_error());
	}else{
		$recruited = $_POST['recruited'];
		}
	$start_T1 = $_POST['timeStart'];
	$start_T2 = $_POST['timeStart2'];
	$end_T1 = $_POST['timeEnd'];
	$end_T2 = $_POST['timeEnd2'];
	$start = $start_T1.' : '.$start_T2;
	$end = $end_T1.' : '.$end_T2;
  $insertSQL = sprintf("INSERT INTO recruited (id, name, sex, phone, cellphone, traffic, license, address, job, worktime, timeStart, timeEnd, workyears, workwhere, recruited, `date`, amendDate, ps, callPs) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['sex'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['cellphone'], "text"),
                       GetSQLValueString($_POST['traffic'], "text"),
                       GetSQLValueString($_POST['license'], "text"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['job'], "text"),
					   GetSQLValueString($_POST['worktime'], "text"),
                       GetSQLValueString($_POST['timeStart'], "text"),
                       GetSQLValueString($_POST['timeEnd'], "text"),
                       GetSQLValueString($_POST['workyears'], "text"),
                       GetSQLValueString($_POST['workwhere'], "text"),
                       GetSQLValueString($recruited, "text"),
                       GetSQLValueString($_POST['date'], "date"),
                       GetSQLValueString($_POST['amendDate'], "date"),
                       GetSQLValueString($_POST['ps'], "text"),
                       GetSQLValueString($_POST['callPs'], "text"));

  mysql_select_db($database_db, $db);
  $Result1 = mysql_query($insertSQL, $db) or die(mysql_error());

  $insertGoTo = "work_record.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}


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
<link rel="stylesheet" type="text/css" href="../../js/jqcool.net-datetimepicke/jquery.datetimepicker.css"/ >
<script src="../../js/jqcool.net-datetimepicke/jquery.js"></script>
<script src="../../js/jqcool.net-datetimepicke/jquery.datetimepicker.js"></script>
<script type="text/javascript">
function form_submit(){
	form1.submit();
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
<p>當前位置:新增應徵紀錄</p>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
<table width="100%" style="table-layout: fixed;" border="1">
      <tr align="left">
        <td colspan="9" align="right">[*] 為必填  | [-] 為選填          <button type="button" name="Submit" id="Submit" onclick="form_submit()">新增</button></td>
      </tr>
        <tr>
          <td colspan="2">☆個人資料</td>
          <td colspan="2">☆求職條件</td>
          <td colspan="2">☆交通條件</td>
          <td colspan="2">*專長說明</td>
          <td>備註</td>
      </tr>
        <tr>
          <td>*姓名</td>
          <td>性別</td>
          <td>應徵類別</td>
          <td>上班時段</td>
          <td>持有駕照</td>
          <td>自備車輛</td>
          <td colspan="2" rowspan="3"><textarea name="ps" id="ps" rows="3" cols="35"></textarea></td>
          <td rowspan="5"><textarea name="callPs" id="callPs" rows="6" cols="18"></textarea></td>
      </tr>
        
        <tr>
          <td><input type="text" name="name" id="name" size="18"></td>
          <td>
          <select name="sex" id="sex">
          <option value="未選擇">未選擇</option>
          <option value="男">男</option>
          <option value="女">女</option>
          </select>
          </td>
          <td>
          <label for="job">類別</label>
          <select name="job" id="job">
          <option value="未選擇">未選擇</option>
          <option value="駐點維護">駐點維護</option>
          <option value="機動人員">機動人員</option>
          </select><br />
          <label for="worktime">時段</label>
          <select name="worktime" id="worktime">
          <option value="未選擇">未選擇</option>
          <option value="日班">日班</option>
          <option value="夜班">夜班</option>
          </select>
          </td>
          <td>
          從
          <input type="time" name="timeStart" id="timeStart" value=""/>
            <br/>   
          至
          <input type="time" name="timeEnd" id="timeEnd" value="<?php echo $row_record['timeEnd']?>" />
          
          </td>
          <td>
          <select name="license" id="license">
          <option value="未選擇">未選擇</option>
          <option value="機車">機車</option>
          <option value="汽車">汽車</option>
          <option value="汽機車">汽機車</option>
          </select>
          </td>
          <td>
          <select name="traffic" id="traffic">
          <option value="未選擇">未選擇</option>
          <option value="機車">機車</option>
          <option value="汽車">汽車</option>
          <option value="汽機車">汽機車</option>
          </select>
          </td>
      </tr>
        <tr>
          <td>-聯絡電話</td>
          <td>-行動電話</td>
          <td colspan="2">*應徵工作地點</td>
          <td colspan="2">工作狀態</td>
      </tr>
        <tr>
          <td><input type="text" name="phone" id="phone" size="18"></td>
          <td><input type="text" name="cellphone" id="cellphone" size="18"></td>
          <td colspan="2">
          <select name="recruited" id="recruited">
          <?php foreach($job_list as $jobname){?>
          <option value="<?php echo $jobname; ?>"><?php echo $jobname; ?></option>
          <?php } ?>
          </select>
          <button type="button" name="new_p" id="new_p" >增加新地點</button>          
          <input type="text" name="recruited2" id="recruited2" />
          <button type="button" name="old_p" id="old_p" >回到舊地點</button>          
          </td>
          <td colspan="2" rowspan="2">
          <select name="workwhere" id="workwhere">
          <option value="未選擇">未選擇</option>
          <option value="目前沒有在工作">目前沒有在工作</option>
          <option value="目前已有工作">目前已有工作</option>
          </select>
          </td>
          <td>新增日期</td>
          <td>修改日期</td>
      </tr>
        <tr>
          <td height="21" colspan="2">*居住地址：
            <input type="text" name="address" id="address" size="25"></td>
          <td colspan="2"><p>*工作經驗:
          <select name="workyears">
          <option value="有">有</option>
          <option value="無">無</option>
          </select>
             </p></td>
          <td><input type="text" name="date" id="date"  size="18" value="<?php echo date("Y-m-d"); ?>" class="datetimepicker"></td>
          <td><input type="text" name="amendDate" id="amendDate"  size="18" class="datetimepicker"></td>
      </tr>
    </table>
<input type="hidden" name="id" id="id">
<input type="hidden" name="MM_insert" value="form1">
      </form>
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