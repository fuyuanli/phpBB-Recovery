<?php
header("Content-Type:text/html; charset=utf-8");
include("db.php");

$conn = mysql_connect($servername, $username, $password);
mysql_query("SET NAMES 'utf8'");
mysql_select_db($dbname);

$email = $_POST["email"];
$sql = "select username from phpbb_users where user_email=\"$email\";";
$result = mysql_query("$sql") or die('MySQL query error2');

if ($email!=""){
	while ($row = mysql_fetch_array($result)){
        $account = $row['username'];
    }
	if ($account!=""){
		include("class.phpmailer.php"); //匯入PHPMailer類別

////////////////////////////////////////////////////////////	
		$gmail_Account="mail@gmail.com";  	//Gmail 帳號
		$gmail_Password="";        			//Gmail 密碼
////////////////////////////////////////////////////////////
				
		$mail= new PHPMailer(); //建立新物件
		
		$mail->IsSMTP(); //設定使用SMTP方式寄信
		$mail->SMTPAuth = true; //設定SMTP需要驗證
		$mail->SMTPSecure = "ssl"; // Gmail的SMTP主機需要使用SSL連線
	   	$mail->Host = "smtp.gmail.com"; //Gamil的SMTP主機
		$mail->Port = 465;  //Gamil的SMTP主機的埠號(Gmail為465)。
		$mail->CharSet = "utf-8"; //郵件編碼								        
		
		$mail->Username = "$gmail_Account";
		$mail->Password = "$gmail_Password";												        
	
		$mail->From = "$gmail_Account"; //寄件者信箱														        
		$mail->FromName = "東大論壇帳號救援系統"; //寄件者姓名														        
		$mail->Subject ="東大論壇帳號救援系統";  //郵件標題																        
		$mail->Body = "<h2 align=center>東大論壇帳號救援系統</h2><br><br>同學你好～<br><br>這是你的帳號 : ".$account."<br><br>以後不要忘記帳號囉～啾咪<br><br><br>--東大論壇帳號救援系統"; //郵件內容																	        
		
		$mail->IsHTML(true); //郵件內容為html ( true || false)																        
		$mail->AddAddress("$email"); //收件者郵件及名稱																        
		
		if(!$mail->Send()) {																			                
			echo "發送錯誤，請通知管理員。 " . $mail->ErrorInfo;																		
		} 
		else{
			echo "<div align=center>救援成功～已經將帳號寄到信箱囉～XD<br><br>如果沒收到信，請找一下由 ".$gmail_Account." 發送的信件，謝謝！</div>";
		}
	}
}
?>
