<?php

//$RECAPTCHA_SECRET_KEY = '"6LdjsBQTAAAAAFkMnI3w446dhzrRByGFXZQmM2tW"';
//$RECAPTCHA_SITE_KEY = '"6LdjsBQTAAAAAIRCKio6y3V0xywNqNQ6EDYv4YQT"';

function connect_phpBB(){
	$servername = "127.0.0.1";	//資料庫位址
	$username = "admin_phpbb";	//資料庫帳號
	$password = "sSzBT1TU96";	//資料庫密碼
	$dbname = "admin_phpbb";	//資料庫名稱
	$conn = mysql_connect($servername, $username, $password);
	mysql_query("SET NAMES 'utf8'");
	mysql_select_db($dbname);	
}


function recaptcha_vertify($response){

    $url = 'https://www.google.com/recaptcha/api/siteverify?secret=%s&response=%s&remoteip=%s';
    $url = sprintf($url, "6LdjsBQTAAAAAFkMnI3w446dhzrRByGFXZQmM2tW", $response, $_SERVER['REMOTE_ADDR']); //自行替換 serectkey
    $status = file_get_contents($url);
    $r = json_decode($status);
    return (isset($r->success) && $r->success) ? true : false;
}

function recaptcha_display(){
	
	return '<script src="https://www.google.com/recaptcha/api.js" async defer></script>
		<div class="g-recaptcha" data-sitekey="6LdjsBQTAAAAAIRCKio6y3V0xywNqNQ6EDYv4YQT"></div>'; //自行替換 sitekey

}

function mail2user($account,$email){
	include("class.phpmailer.php"); //匯入PHPMailer類別
////////////////////////////////////////////////////////////	
	$gmail_Account="becoder.org@gmail.com";  	//Gmail 帳號
	$gmail_Password="win123702109q";        			//Gmail 密碼
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
			echo $mail->ErrorInfo;
			$Message = "Wrang"; 
		} 
	
	}
	

?>