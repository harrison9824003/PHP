<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>無標題文件</title>
</head>

<body>
<?php 
	
	if(isset($_POST['mailto'])){ 
	$id = $_POST['id'];
	$who = $_POST['who'];
	$from = $_POST['from'];
	$date = $_POST['date'];
	$company = $_POST['company'];
	$contactP = $_POST['contactP'];
	$phone = $_POST['phone'];
	$cellPhone = $_POST['cellPhone'];
	$service = $_POST['service'];
	$contents = $_POST['contents'];
	$address = $_POST['address'];
	$repalyP = $_POST['repalyP'];
	$repalyDate = $_POST['repalyDate'];
	$repalyPs = $_POST['repalyPs'];
	$viewP = $_POST['viewP'];
	$viewDate = $_POST['viewDate'];
	$viewPs = $_POST['viewPs'];
	$sendwho = $_POST['sendwho'];
	$sendPPs = $_POST['sendPPs'];//寄件者備註
	if(empty($sendPPs)){$sendPPs = "無備註";}
	if(empty($phone)){$phone = "未留";}
	if(empty($cellPhone)){$cellPhone = "未留";}
	?>
    <?php	
	echo "進線公司：".$from." | 進線時間：".$date."<br />" ;
	echo "公司名稱：".$company." | 聯絡人：".$contactP." | 室內電話：".$phone." | 手機：".$cellPhone."<br />" ;
	echo "服務項目：".$service." | 服務內容：".$contents."<br />";
	echo "地址：".$address."<br />" ;
	echo "回覆人員：".$repalyP." | 回覆時間：".$repalyDate." | 回覆備註：".$repalyPs."<br />";
	echo "勘查人員：".$viewP." | 勘查時間：".$viewDate." | 勘查備註：".$viewPs."<br />";
	

	if(isset($sendwho)){	
		if(isset($_POST['other_email'])&&!empty($_POST['other_email'])){
		array_push($sendwho,$_POST['other_email']);
			}
foreach($sendwho as $name){                
mb_internal_encoding("UTF-8");  //中文編碼問題
$to      = $name ;  //改為收件者地址
$subject = "".$company." - ".$service." - ".$from." - ".$date;  //郵件主旨
$message = "<html></body>";
$message .="<table border='1' cellpadding='5' cellspacing='3'>";
$message .="<tr style='color:#666666'><td><strong>進線公司</strong></td><td><strong>進線時間</strong></td><td><strong>公司名稱</strong></td><td><strong>聯絡人</strong></td><td><strong>連絡電話</strong></td></tr>";
$message .="<tr style='color:#000000'><td>".$from."</td><td>".$date."</td><td>".$company."</td><td>".$contactP."</td><td>".$phone." | ".$cellPhone."</td></tr>";
$message .= "<tr style='color:#666666'><td><strong>建檔人員</strong></td><td><strong>服務</strong></td><td><strong>服務項目</strong></td><td colspan='2'><strong>地址</strong></td></tr>";
$message .="<tr style='color:#000000'><td>".$who."</td><td>".$service."</td><td>".$contents."</td><td colspan='2'>".$address."</td></tr>";
$message .="<tr style='color:#000000'><td><strong style='color:#666666'>id序號：</strong>".$id."</td><td colspan='4'><strong style='color:#666666'>備註：</strong>".$sendPPs."</td></tr>";
$message .="</table>";
$message .="</body></html>";
 ;   //郵件本文
$headers = 'From:  harrison@brighten.com.tw'. "\r\n" ;
$headers .='Reply-To: 公司電話紀錄' . "\r\n";
$headers .= "Content-Type: text/html; charset=utf-8\r\n";

	/*for($i=1;$i<sizeof($sendwho);$i++){         
		$headers .= "Cc: ".$sendwho[$i]. "\r\n";
	}*/
	if(mb_send_mail($to, $subject, $message, $headers)){  //系統畫面
	echo "<p>給".$name."郵件發送成功!</p>";
	echo "等待五秒自動跳轉轉";
	header('refresh: 5;url="call_page.php"');
}else{
	echo "<p>不好意思，郵件發送失敗!請嘗試用電話與我們聯絡：(02)8919-1628</p>";
}
}

}
	}else{ echo "尚未接收資料，回到首頁再次連結-->[<a href='mail.php?id=".$id."'>回首頁</a>]";}	
	
?>
</body>
</html>

