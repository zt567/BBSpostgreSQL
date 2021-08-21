<?php
if(empty($_POST['name'])){
	skip('login.php','用戶名不得為空');
}
if(empty($_POST['pw'])||mb_strlen($_POST['pw'])<6||mb_strlen($_POST['pw'])>15){
	skip('login.php','密碼6到15位,不得為空');
}

if(strtolower($_POST['vcode'])!=strtolower($_SESSION['vcode'])){

	skip('login.php','驗證碼錯誤');
}
if(empty($_POST['time'])||!is_numeric($_POST['time'])||$_POST['time']>2592000){
	$_POST['time']=2592000;
}
?>
	