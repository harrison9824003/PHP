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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE recruited SET name=%s, sex=%s, phone=%s, cellphone=%s, traffic=%s, license=%s, address=%s, job=%s, timeStart=%s, timeEnd=%s, workyears=%s, workwhere=%s, recruited=%s, `date`=%s, amendDate=%s, ps=%s, callPs=%s WHERE id=%s",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['sex'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['cellphone'], "text"),
                       GetSQLValueString($_POST['traffic'], "text"),
                       GetSQLValueString($_POST['license'], "text"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['job'], "text"),
                       GetSQLValueString($_POST['timeStart'], "text"),
                       GetSQLValueString($_POST['timeEnd'], "text"),
                       GetSQLValueString($_POST['workyears'], "text"),
                       GetSQLValueString($_POST['workwhere'], "text"),
                       GetSQLValueString($_POST['recruited'], "text"),
                       GetSQLValueString($_POST['date'], "date"),
                       GetSQLValueString($_POST['amendDate'], "date"),
                       GetSQLValueString($_POST['ps'], "text"),
                       GetSQLValueString($_POST['callPs'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_db, $db);
  $Result1 = mysql_query($updateSQL, $db) or die(mysql_error());

  $updateGoTo = "work_record.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));}



$colname_record = "-1";
if (isset($_GET['id'])) {
  $colname_record = $_GET['id'];
}
mysql_select_db($database_db, $db);
$query_record = sprintf("SELECT * FROM recruited WHERE id = %s", GetSQLValueString($colname_record, "int"));
$record = mysql_query($query_record, $db) or die(mysql_error());
$row_record = mysql_fetch_assoc($record);
$totalRows_record = mysql_num_rows($record);
?>
<!doctype html>
<html><!-- InstanceBegin template="/Templates/layout.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>???????????????????????????</title>
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
function formSubmit(){
	if(form1.submit()){
		alert("???????????????!!");
		};
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
<p>????????????:????????????????????????</p>
<form method="POST" action="<?php echo $editFormAction; ?>" name="form1">
<table width="100%" style="table-layout: fixed" border="1">
      <tr align="left">
        <td colspan="9">
        <input type="submit" name="Submit" id="Submit" value="????????????" />
        </td>
      </tr>
        <tr>
          <td colspan="2">???????????????</td>
          <td colspan="2">???????????????</td>
          <td colspan="2">???????????????</td>
          <td colspan="2">????????????</td>
          <td>??????</td>
          </tr>
        <tr>
          <td>??????</td>
          <td>??????</td>
          <td>????????????</td>
          <td>????????????</td>
          <td>????????????</td>
          <td>????????????</td>
          <td colspan="2" rowspan="3"><textarea name="ps" id="ps" rows="3" cols="35"><?php echo $row_record['ps']; ?></textarea></td>
          <td rowspan="5"><textarea name="callPs" id="callPs" rows="6" cols="18"><?php echo $row_record['callPs']; ?></textarea></td>
          </tr>
        
        <tr>
          <td><input type="text" name="name" id="name" size="18" value="<?php echo $row_record['name']; ?>"></td>
          <td>
          <select name="sex" id="sex">
          <option value="?????????" <?php echo $row_record['sex']=='?????????'?'selected="selected"':'' ?>>?????????</option>
          <option value="???" <?php echo $row_record['sex']=='???'?'selected="selected"':'' ?>>???</option>
          <option value="???" <?php echo $row_record['sex']=='???'?'selected="selected"':'' ?>>???</option>
          </select>
          </td>
          <td>
		  <select name="job" id="job">
          <option value="?????????" <?php echo $row_record['job']=='?????????'?'selected="selected"':'' ?>>?????????</option>
          <option value="????????????" <?php echo $row_record['job']=='????????????'?'selected="selected"':'' ?>>????????????</option>
          <option value="????????????" <?php echo $row_record['job']=='????????????'?'selected="selected"':'' ?>>????????????</option>
          </select>
		  </td>
          <td>
          ??????:
          <input type="time" name="timeStart" id="timeStart" value="<?php echo $row_record['timeStart']; ?>"/>
          ??????:
          <input type="time" name="timeEnd" id="timeEnd" value="<?php echo $row_record['timeEnd']?>" />
          
          </td>
          <td>
          <select name="license" id="license">
          <option value="?????????" <?php echo $row_record['license']=='?????????'?'selected="selected"':'' ?>>?????????</option>
          <option value="??????" <?php echo $row_record['license']=='??????'?'selected="selected"':'' ?>>??????</option>
          <option value="??????" <?php echo $row_record['license']=='??????'?'selected="selected"':'' ?>>??????</option>
          <option value="?????????" <?php echo $row_record['license']=='?????????'?'selected="selected"':'' ?>>?????????</option>
          </select>
          </td>
          <td><select name="traffic" id="traffic">
          <option value="?????????" <?php echo $row_record['traffic']=='?????????'?'selected="selected"':'' ?>>?????????</option>
          <option value="??????" <?php echo $row_record['traffic']=='??????'?'selected="selected"':'' ?>>??????</option>
          <option value="??????" <?php echo $row_record['traffic']=='??????'?'selected="selected"':'' ?>>??????</option>
          <option value="?????????" <?php echo $row_record['traffic']=='?????????'?'selected="selected"':'' ?>>?????????</option>
          </select></td>
          </tr>
        <tr>
          <td>????????????</td>
          <td>????????????</td>
          <td colspan="2">??????????????????</td>
          <td colspan="2">????????????</td>
          </tr>
        <tr>
          <td><input type="text" name="phone" id="phone" size="18" value="<?php echo $row_record['phone']; ?>"></td>
          <td><input type="text" name="cellphone" id="cellphone" size="18" value="<?php echo $row_record['cellphone']; ?>"></td>
          <td colspan="2"><input type="text" name="recruited" id="recruited" size="35" value="<?php echo $row_record['recruited']; ?>"></td>
          <td colspan="2" rowspan="2"><input type="text" name="workwhere" id="workwhere" size="35" value="<?php echo $row_record['workwhere']; ?>"></td>
          <td>????????????</td>
          <td>????????????</td>
          </tr>
        <tr>
          <td height="21" colspan="2"><p>???????????????<input type="text" name="address" id="address" size="25" value="<?php echo $row_record['address']; ?>"></p></td>
          <td colspan="2">????????????:
          <select name="workyears">
          <option value="???" <?php echo  $row_record['workyears']=='???'?'selected="selected"':'' ?>>???</option>
          <option value="???" <?php echo  $row_record['workyears']=='???'?'selected="selected"':'' ?>>???</option>
          </select>
          </td>
          <td><input type="text" name="date" id="date"  size="18" class="datetimepicker" value="<?php echo $row_record['date']; ?>"></td>
          <td><input type="text" name="amendDate" id="amendDate"  size="18" value="<?php echo date("Y-m-d"); ?>" class="datetimepicker"></td>
          </tr>
      </table>
      <input  type="hidden" name="id" id="id" value="<?php echo $row_record['id']; ?>"  />
      <input type="hidden" name="MM_update" value="form1">
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
<?php
mysql_free_result($record);
?>
