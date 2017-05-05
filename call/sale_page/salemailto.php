<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>無標題文件</title>
</head>

<body>
<?php if(isset($_POST['good'])&&isset($_POST['bad'])){
    
  	$date = $_POST['date'];
	$callP = $_POST['callP'];
	$callnum = $_POST['callnum'];
	$good = $_POST['good'];
	$bad = $_POST['bad'];
	$fax = $_POST['fax'];
	$realmail = $_POST['realmail'];
	$mail = $_POST['mail'];
	$access = $_POST['access'];
	$ps = $_POST['ps'];
  
   foreach($_POST["sendwho"] as $value) 
        {                        
mb_internal_encoding("UTF-8");  //中文編碼問題
$to      = "$value" ;  //改為收件者地址
$subject = "".$client."電訪紀錄，建檔人-".$callP;  //郵件主旨
$message = "<html></body>";
$message .="<table border='1' cellpadding='5' cellspacing='3' bordercolor='#000000'>";
$message .="<tr bgcolor='#00FFFF'>
         <td width='10%'>日期</td>
         <td width='10%'>電訪員</td>
         <td width='10%'>撥打通數</td>
         <td width='10%'>報價追蹤</td>
         <td width='10%'>無效客戶</td>
         <td width='10%'>客戶回訪</td>
         <td width='10%'>DM</td>
         <td width='10%'>MAIL</td>
         <td width='10%'>傳真</td>
         </tr>";
$message .="<tr bgcolor='#00CCFF'>";
$message .="<td>".$date."</td>";
$message .="<td>".$callP."</td>";
$message .="<td>".$callnum."</td>";
$message .="<td>".$good."</td>";
$message .="<td>".$bad."</td>";
$message .="<td>".$access."</td>";
$message .="<td>".$realmail."</td>";
$message .="<td>".$mail."</td>";
$message .="<td>".$fax."</td>";
$message .="</tr>";  
$message .="<tr>";
$message .="<td>寄件者備註</td>";
$message .="<td colspan='8'>".$ps."</td>";
$message .="</tr>";
$message .="</table>";
$message .="</body></html>";
 ;   //郵件本文
$headers = 'From:  PhoneSales@brighten.com.tw'. "\r\n" ;
$headers .='Reply-To: 公司電訪紀錄' . "\r\n";
$headers .="Content-Type: text/html; charset=utf-8\r\n";

	if(mb_send_mail($to, $subject, $message, $headers)){  //系統畫面
	echo "<p>給".$value."郵件發送成功!-->[<a href='index.php'>回首頁</a>]</p>";
}else{
	echo "<p>寄件失敗-->[<a href='index.php'>回首頁</a>]</p>";
}}
  
    } ?>
    <?php if(isset($_POST['clientnum'])&&isset($_POST['client'])){
		$callP = $_POST['callP'];
	$clientnum = $_POST['clientnum'];
	$client = $_POST['client'];
	$responsible = $_POST['responsible'];
	$phone = $_POST['phone'];
	$cellphone = $_POST['cellphone'];
	$saleDate = $_POST['saleDate'];
	$saleP = $_POST['saleP'];
	$salePs = $_POST['salePs'];
	$date = $_POST['date'];
	$serviceC = $_POST['serviceC'];
	$address = $_POST['address'];
	$lookP = $_POST['lookP'];
	$lookDate = $_POST['lookDate'];
	$lookPs = $_POST['lookPs'];
	$ps = $_POST['ps'];
	
	 foreach($_POST["sendwho"] as $value) 
        {                        
mb_internal_encoding("UTF-8");  //中文編碼問題
$to      = "$value" ;  //改為收件者地址
$subject = "".$client."電訪資料，建檔人-".$callP;  //郵件主旨
$message = "<html></body>";
$message .="<table border='1' cellpadding='5' cellspacing='3' bordercolor='#000000'>";
$message .=" <tr bgcolor='#00FFFF' >
         <td width='10%'>電訪員</td>
         <td width='10%'>客戶編號</td>
         <td width='20%'>公司名稱</td>
         <td width='10%'>聯絡人</td>
         <td width='15%' >聯絡電話</td>
         <td width='10%'>回復人員</td>
         <td width='10%'>回覆時間</td>
         <td width='15%'>回復備註</td>
         </tr>";
$message .="<tr bgcolor='#00CCFF'>";
$message .="<td>".$callP."</td>";
$message .="<td>".$clientnum."</td>";
$message .="<td>".$client."</td>";
$message .="<td>".$responsible."</td>";
$message .="<td align='left' ><img src='http://call.exclean.com.tw/img/phone33.png' width='16' height='16'>：".$phone."<hr />";            
$message .="<img src='http://call.exclean.com.tw/img/cellphone87.png' width='16' height='16'>：".$cellphone."</td>";
$message .="<td>".$saleP."</td>";
$message .="<td>".$saleDate."</td>";
$message .="<td >".$salePs."</td>";
$message .="</tr><tr bgcolor='#00FFFF'>
         <td>日期</td>
         <td colspan='2'>洽談內容</td>
         <td colspan='2'>地址</td>
         <td>勘查人員</td>
         <td>勘查時間</td>
         <td>勘查備註</td>
         </tr>";
$message .="<tr bgcolor='#00CCFF'>";
$message .="<td>".$date."</td>";
$message .="<td colspan='2'>".$serviceC."</td>";
$message .="<td colspan='2'>".$address."</td>";
$message .="<td>".$lookP."</td>";
$message .="<td>".$lookDate."</td>";
$message .="<td >".$lookPs."</td>";
$message .="</tr>";
$message .="<tr><td colspan='8'>".$ps."</td></tr>";
$message .="</table>";
$message .="</body></html>";
 ;   //郵件本文
$headers = 'From:  PhoneSales@brighten.com.tw'. "\r\n" ;
$headers .='Reply-To: 公司電訪資料' . "\r\n";
$headers .= "Content-Type: text/html; charset=utf-8\r\n";

	if(mb_send_mail($to, $subject, $message, $headers)){  //系統畫面
	echo "<p>給".$value."郵件發送成功!-->[<a href='slae_page.php'>回首頁</a>]</p>";
}else{
	echo "<p>寄件失敗-->[<a href='slae_page.php'>回首頁</a>]</p>";
}} 
      } ?>
</body>
</html>