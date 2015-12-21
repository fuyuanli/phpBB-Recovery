<?php
include("db.php");

$conn = mysql_connect($servername, $username, $password);
mysql_query("SET NAMES 'utf8'");
mysql_select_db($dbname);

$account = $_POST["account"];
$email = $_POST["email"];
$sql = "select username from phpbb_users where username=\"$account\" and user_email=\"$email\";";
$result = mysql_query("$sql") or die('MySQL query error2');
	
if ($account!="" && $email!=""){

	while ($row = mysql_fetch_array($result)){
        $yes = $row['username'];
    }
	if ($yes!=""){
		echo "你的帳號為 : ",$account,"<br>";
		echo "Email 為 : ",$email,"<br>";
		$new_passwd = md5(123456789);
		$change_passwd = "update phpbb_users set user_password=\"$new_passwd\" where username=\"$account\";";
		mysql_query("$change_passwd");
		echo "資料輸入正確，密碼已改為 123456789";
	}
	else{
		echo "帳號、Email有誤！";
	}
}
?>
