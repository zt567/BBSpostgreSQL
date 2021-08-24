<?php
include_once 'inc/pgsql.inc.php';
include_once 'inc/tool.inc.php';
$templete['title']='登入頁面';
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
		<div class="row">
			<div class="col-xs-12 col-sm-4 col-sm-offset-4">
				<form class="login">
					<div class="form-group">
						<label>預設帳號</label>
						<input type="text" class="form-control" id="username" name="username" value="123123">
					</div>
					<div class="form-group">
						<label>密碼</label>
						<input type="password" class="form-control" id="pw" name="pw" placeholder="password" value="123123">
					</div>
					<input id="login_submit" type="submit" name="submit" value="登入" class="btn btn-default">
						<div>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script>
$(document).on("ready", function(){
	//提交驗證
	$("form.login").on("submit", function(){
		$.ajax({
            type : "POST",
            url : "verify_user.php",
            data : {
            un : $("#username").val(), //使用者帳號
            pw : $("#pw").val() //使用者密碼
            },
            dataType : 'html' //設定該網頁回應的會是 html 格式
          }).done(function(data){
            //成功的時候
            console.log(data);
            if(data.toString()=='ok'){
              //註冊新增成功，轉跳到登入頁面。
              window.location.href = "index.php"; 
            }else{
              alert("登入失敗，請確認帳號密碼");
            }
        }).fail(function(jqXHR, textStatus, errorThrown){
            //失敗的時候
            alert("有錯誤產生，請看 console log");
            console.log(jqXHR.responseText);
          });
	        //回傳 false 為了要阻止 from 繼續送出去。由上方ajax處理即可
          return false;
		});
});
</script>