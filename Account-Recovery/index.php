<?php
require('function.php');
	
	if(isset($_POST["submit"])){
		$email = ($_POST["email"]);
		
		$response = $_POST['g-recaptcha-response'];
		if (!recaptcha_vertify($response))
			$errRecaptcha = "<div class='alert alert-danger'>請驗證是否為機器人！</div>";
				
		if(!$_POST["email"] || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
			$errEmail = "<div class='alert alert-danger'>電子郵件格式有誤！請重試一次！</div>";
		
		if( !$errRecaptcha && !$errEmail){
			connect_phpBB();
			$sql = "select username from phpbb_users where user_email=\"$email\";";
			$result = mysql_query("$sql") or die('MySQL query error2');
	
			while ($row = mysql_fetch_array($result)){
				$account = $row['username'];
			}
				
			if($account != ""){
				mail2user($account,$email);
				if(!$Message)
					$Message = "<div class='alert alert-success'>救援成功！已將帳號寄至您的信箱！</div>";
				else
					$Message = "<div class='alert alert-danger'>系統發生錯誤！請通知管理員！</div>"; 
			}
			else{
				$Message = "<div class='alert alert-danger'>查無此Email紀錄！</div>";	
			}
			
		}					
	}
?>

<html lang="zh-tw">
<head>
	<title>東大論壇救援系統</title> 
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<style>
	::-webkit-input-placeholder {
		text-align: center;
	}

	:-moz-placeholder { /* Firefox 18- */
		text-align: center;  
	}

	::-moz-placeholder {  /* Firefox 19+ */
		text-align: center;  
	}

	:-ms-input-placeholder {  
		text-align: center; 
	}
	
	label {
		font-size:2rem;
	}
	</style>
	
</head>
<body>
<nav class="navbar navbar-inverse">
	<div class="container-fluid">
		
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#MyNavbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href=".">東大論壇救援系統</a>
		</div>
		
		<div class="collapse navbar-collapse" id="MyNavbar">
			<ul class="nav navbar-nav">
				<li><a href="#"></span> 帳號救援</a></li>
			</ul>
			
			<ul class="nav navbar-nav navbar-right">
				<li><a href="#"><span class="glyphicon glyphicon-info-sign"></span> 關於</a></li>
			</ul>
		</div>
			
	</div>
</nav>

<div class="container">
	<h2><center>帳號查詢</center></h2>
	<br>
	<p></p>
	<form role="form"  method="POST" action="index.php">
		<div class="form-group">
			<label for="email">Email:</label>
			<input type="email" class="form-control input-lg" id="email" name="email" placeholder="mail@gmail.com" value="<?php echo htmlspecialchars($_POST['email']); ?>">
			<?php echo "$Message$errEmail$errRecaptcha";?>
			<br>
			<center><?php echo recaptcha_display(); ?></center> 
			<br>
			<input id="submit" name="submit" type="submit" class="btn btn-default btn-lg btn-block" value="送出查詢">
		</div>
	</form>
</div>


</body>
</html>