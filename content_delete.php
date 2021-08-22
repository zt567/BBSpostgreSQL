<?php
include_once 'inc/config.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
include_once 'inc/page.inc.php';
$link = connect();
if(!$member_id = is_login($link)){
	skip('login.php','請先登入');
}
if(!isset($_GET['id'])||!is_numeric($_GET['id'])){
	skip('index.php','id參數不合法');
}
$query = "select member_id from sfk_content where id={$_GET['id']}";
$res_content = execute($link,$query);
if(mysqli_num_rows($res_content)==1){
	$data_content = mysqli_fetch_assoc($res_content);
	if(check_user($member_id,$data_content['member_id'])){
		$query = "delete from sfk_content where id={$_GET['id']}";
		execute($link,$query);
		if(mysqli_affected_rows($link)==1){
			skip('member.php?id={$member_id}','刪除成功');
		}else{
			skip('member.php?id={$member_id}','刪除失敗');
		}
	}else{
		skip('index.php','權限不足');
	}
}else{
	skip('index.php','文章不存在');	
}

?>