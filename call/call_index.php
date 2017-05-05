<?php require_once("session.php"); ?>
<?php require_once('../Connections/db.php'); 
		require_once('../list_name.php');
			
?>
<!doctype html>
<html><!-- InstanceBegin template="/Templates/layout.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>網站與電話記錄管理</title>
<link href="../css/call.css" rel="stylesheet" type="text/css">
<link href="../css/sale.css" rel="stylesheet" type="text/css">
<!-- InstanceEndEditable -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<link href="../css/layout.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js/layout.js"></script>
<script type="text/javascript" src="../js/minwt.auto_full_height.mini.js"></script>
<!-- InstanceBeginEditable name="head" -->
<link rel="stylesheet" type="text/css" href="../js/jqcool.net-datetimepicke/jquery.datetimepicker.css"/ >
<script src="../js/jqcool.net-datetimepicke/jquery.js"></script>
<script src="../js/jqcool.net-datetimepicke/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="../js/ajax.js"></script>
<script type="text/javascript" src="../js/call.js"></script>
<script type="text/javascript">
	selectSendAjax('call','','','未處理');
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
<div class="demo_select">
<form method="post" name="form1">
	<fieldset>
    <legend>=篩選=</legend>
    <div class='formBox'>
        <label for="class">資料(來電/電訪):</label>
        <select name="class" id="class" onChange="selectAjax();">        	
            <option value="call">來電紀錄</option>
            <option value="phonesale">電訪紀錄</option>
        </select>
    </div>
    <div class='formBox'>
        <label for="status">狀態(處理/未處理):</label>
        <select name="status" id="status" onChange="selectAjax();">
        	<option value="未處理">未處理</option>
            <option value="已處理">已處理</option>
            <option value="預備勘查">預備勘查</option>
        </select>
    </div>
    <div class='formBox'> 
        <label for="Date">日期:</label>
        <input type="text" name="Date" id="Date" value="" class="datetimepicker"  size="15" onBlur="selectAjax();"/>
    </div>
    <div class='formBox'> 
        <label for="days">幾天前(以日期為基準往前推):</label>
        <!--<input type="text" name="days" id="days"  value="" size="5" onChange="selectAjax();"/>-->
        <select name="days" id="days" onChange="selectAjax();">
        	<option value="">未選擇</option>
            <option value="7">7天</option>
            <option value="14">14天</option>
            <option value="30">30天</option>
            <option value="45">45天</option>
            <option value="60">60天</option>
        </select>
    </div>       
    </fieldset>
</form>
</div>
<div id="demo">
		
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

