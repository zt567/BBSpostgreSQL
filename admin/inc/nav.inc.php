<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
	
	<link rel="icon" href="/sfkbbs/admin/inc/icon.png" type="image/x-icon" >
</head>
<body class="bg-gray-700">
<nav>
	<div class="text-2xl bg-blue-800 ">
		<ul class="flex flex-row">
			<li><a href="/sfkbbs/index.php">BBS</a></li>
			<li><a href="/sfkbbs/index.php">首頁</a></li>
			<li>
				<input class="rounded-lg " type="search" name="search" placeholder="搜尋文章">
			</li>
			<li class="flex flex-auto"> 
			<?php 
			//存在且為true
			if(isset($member_id) && $member_id){
$str=<<<EOF
<li>用戶:
<a href="/sfkbbs/member.php?id={$member_id}">{$_COOKIE['sfk']['name']}</a> || <a href="/sfkbbs/logout.php">登出</a>
</li>
EOF;
			echo $str;

			}else{		

$str=<<<EOF
<li >
<a href='/sfkbbs/login.php'>登入</a>&nbsp;
</li>
<li class="">
<a href='/sfkbbs/register.php'>註冊</a>
</li>
EOF;
			echo $str;
			}?>				
			</li>		
		</ul>
	</div>
</nav>
</body>
</html>