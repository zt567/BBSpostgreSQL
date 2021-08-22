<?php
include_once 'inc/config.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$templete['title']='登入頁面';
$link = connect();
if(!$member_id= is_login($link)){
	skip('index.php','尚未登入');	
	}
setcookie('sfk[name]','',time()-3600);
setcookie('sfk[pw]','',time()-3600);
skip('index.php','已登出');
?>