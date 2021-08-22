<?php

include_once '../inc/config.php';
if(!isset($_GET['url'])||!isset($_GET['message'])||!isset($_GET['return_url'])){

	echo '未接收到參數';
	exit();
}
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>刪除確認頁面</title>
</head>
<body>
	<div style="margin:0px auto;">
		<span>選擇刪除</span>		
		<span><?php echo $_GET['message'] ?></span>
		<a style="color: red;" href="<?php echo $_GET['url'] ?>">確定刪除</a>  |||
		<a href="<?php echo $_GET['return_url'] ?>">取消</a>
	</div>
	

</body>
</html>