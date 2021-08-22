<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $templete['title'] ?></title>
</head>
<body>
	<?php include 'nav.inc.php' ?>
	<div>
		<div>
			<ul style="background-color:gray;">
				<li><h3>管理中心</h3></li>
				<li ><a href="#">網站首頁</a>|<a href="#">註銷</a></li>
			</ul>		
		</div>
		<div>
			<div style="background-color: gray;width: 100px;text-align: center;">系統</div>
			<ul>
				<li><a href="#">系統訊息</a></li>
				<li><a href="#">管理員</a></li>
				<li><a href="#">添加管理員</a></li>
				<li><a href="#">站點設置</a></li>
			</ul>			
		</div>
		<div>
			<div style="background-color: gray;width: 100px;text-align: center;">內容管理</div>
			<ul>
				<li <?php if(basename($_SERVER['SCRIPT_NAME'])=='father_module.php'){echo 'style="list-style:disc"';} ?> ><a href="father_module.php">父板塊列表</a></li>
				<li <?php if(basename($_SERVER['SCRIPT_NAME'])=='father_module_add.php'){echo 'style="list-style:disc"';} ?> ><a href="father_module_add.php">添加父板塊</a></li>
				<?php if(basename($_SERVER['SCRIPT_NAME'])=='father_module_update.php'){echo '<li style="list-style:disc"><a>編輯父板塊</a></li>';} ?>				
				<li <?php if(basename($_SERVER['SCRIPT_NAME'])=='son_module.php'){echo 'style="list-style:disc"';} ?>><a href="son_module.php">子板塊列表</a></li>
				<?php if(basename($_SERVER['SCRIPT_NAME'])=='son_module_update.php'){echo '<li style="list-style:disc"><a>編輯子板塊</a></li>';} ?>	
				<li><a href="son_module_add.php">添加子板塊</a></li>
				<li><a href="#">帖子管理</a></li>
				<li><a href="#">敏感詞管理</a></li>
			</ul>
		</div>
		<div>
			<div style="background-color: gray;width: 100px;text-align: center;">用戶管理</div>
			<ul>
				<li><a href="#">用戶列表</a></li>
			</ul>		
		</div>
	</div>
</body>
</html>
