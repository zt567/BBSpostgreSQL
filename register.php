<?php
include_once 'inc/config.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$templete['title']='註冊頁面';
$link = connect();
if($member_id = is_login($link)){
	echo '已登入,用戶id:';
	var_dump(is_login($link));
	skip('index.php','註冊需先登出');
}
if(isset($_POST['submit'])){
	include_once 'inc/check_register.inc.php';
	$_POST = escape($link,$_POST);
	$query = "insert into sfk_member(name,pw,register_time) values('{$_POST['name']}',md5('{$_POST['pw']}'),now())";
	execute($link,$query);
	if(mysqli_affected_rows($link)==1){
		setcookie('sfk[name]',$_POST['name']);
		setcookie('sfk[pw]',sha1(md5($_POST['pw'])));
		skip('admin/father_module.php','註冊成功,跳轉主頁');
	}else{
		skip('register.php','註冊失敗,跳轉註冊頁面');
	}
}
?>
<?php
include_once 'admin/inc/nav.inc.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>會員註冊頁面</title>
	<style type="text/css">
	</style>
</head>
<body>
	<h2>歡迎註冊</h2>

	<form method="post">
		<label>用戶名:<input type="text" name="name">

		</label></br>
		<label>密碼:<input type="password" name="pw"></label></br>
		<label>確認密碼:<input type="password" name="confirm_pw"></label></br>
		<label>驗證碼:<input type="text" name="vcode"></label><img style="margin-left: 20px;" src="inc/show_code.php"></br>
		<input type="submit" name="submit" value="註冊" style="cursor: pointer;">
	</form>


</body>
</html>