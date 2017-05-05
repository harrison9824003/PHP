<?php require_once("session.php"); ?>
<?php require_once('../../list_name.php'); ?>
<?php require_once('../../Connections/db.php'); ?>
<!doctype html>
<html><!-- InstanceBegin template="/Templates/layout.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>網站與電話記錄管理</title>
<link href="../../css/sale.css" rel="stylesheet" type="text/css">
<!-- InstanceEndEditable -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<link href="../../css/layout.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../js/layout.js"></script>
<script type="text/javascript" src="../../js/minwt.auto_full_height.mini.js"></script>
<!-- InstanceBeginEditable name="head" -->
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
<p><span class="gary_word">當前位置:</span>新增每日電訪紀錄</p>
<table width="100%" border="1">
  <tr>
    <td>日期</td>
    <td>電訪人員</td>
    <td>電話數量</td>
    <td>報價追蹤</td>
    <td>無效客戶</td>
    <td>客戶回訪</td>
    <td>DM</td>
    <td>MAIL</td>
    <td>傳真</td>
  </tr>
  
</table>

<!-- InstanceEndEditable -->
</article>
<footer  _height="none">
<!-- InstanceBeginEditable name="footer" -->
<?php require_once('sale_footer.php'); ?>
<!-- InstanceEndEditable -->
</footer>
</div>
</body>
<!-- InstanceEnd --></html>