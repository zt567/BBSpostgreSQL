<?php
include_once 'inc/config.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$templete['title']='登入頁面';
$link = connect();
if($member_id= is_login($link)){
	skip('index.php','勿重複登入');
}
if(isset($_POST['submit'])){
	include 'inc/check_login.inc.php';		
	escape($link,$_POST);
	$query = "select * from sfk_member where name='{$_POST['name']}' and pw=md5('{$_POST['pw']}')";
	$res = execute($link,$query);
	if(mysqli_num_rows($res)==1){
		setcookie('sfk[name]',$_POST['name'],time()+$_POST['time']);
		setcookie('sfk[pw]',sha1(md5($_POST['pw'])),time()+$_POST['time']);

		skip('index.php','登入成功');
	}else{
		skip('login.php','用戶名或密碼錯誤');
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
	<title>會員登入頁面</title>
	<style type="text/css">
	</style>
</head>
<body>
	<div class="container">
		<h2>登入頁面
			<?php 
			if(isset($_COOKIE['sfk']['name'])){
				echo $_COOKIE['sfk']['name'];
			} ?>	
		</h2>
		<form method="post" class="">
			<div class="">
				<label for="txtUID" class="">預設帳號</label>
				<div class="">
					<input type="text" class="" id="name" name="name" value="123123">
				</div>
			</div>
			<div class="form-group">
				<label for="txtPWD" class="">密碼</label>
				<div class="">
					<input type="password" class="" id="pw" name="pw" placeholder="password" value="123123">
				</div>
			</div>
			<div class="">
				<div class="">
					<label>驗證碼<input type="text" name="vcode" class=""></label>
					<img src="inc/show_code.php" style="margin-bottom: 5px;"></br>
					<label>自動登入
						<select name="time" class="">
							<option value="3600">1小時內</option>
							<option value="86400">1天內</option>
							<option value="259200">3天內</option>
							<option value="2592000">30天內</option>
						</select>
					</label>
					<input type="submit" name="submit" value="登入" style="cursor: pointer;" class="">
				</div>
			</div>
			
				
		</form>
	</div>
</body>
</html>