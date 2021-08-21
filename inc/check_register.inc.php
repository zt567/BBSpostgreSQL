<?php
if(empty($_POST['name'])){
	skip('register.php','用戶名不得為空');
}
if(empty($_POST['pw'])||mb_strlen($_POST['pw'])<6||mb_strlen($_POST['pw'])>15){
	skip('register.php','密碼6到15位,不得為空');
}

if($_POST['confirm_pw']!=$_POST['pw']){
	skip('register.php','確認密碼錯誤');
}

if(strtolower($_POST['vcode'])!=strtolower($_SESSION['vcode'])){

	skip('register.php','驗證碼錯誤');
}

$_POST=escape($link,$_POST);
$query = "select * from sfk_member where name='{$_POST['name']}'";
$res = execute($link,$query);
if(mysqli_num_rows($res)){
	skip('register.php','用戶名已被註冊');
}
?>
	