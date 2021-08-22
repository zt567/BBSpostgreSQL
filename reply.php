<?php
include_once 'inc/config.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
include_once 'inc/page.inc.php';
$link = connect();
if(!$member_id = is_login($link)){
	skip('login.php','請先登入後再回覆');
}
if(!isset($_GET['id'])||!is_numeric($_GET['id'])){
	skip('index.php','id參數不合法');
}
//回覆提交
if(isset($_POST['submit'])){
	include 'inc/check_reply.inc.php';
	//刪除干擾查詢語句字符 mysql.inc.php
	$_POST=escape($link,$_POST);
	$query = "insert into sfk_reply(content_id,content,time,member_id) values({$_GET['id']},'{$_POST['content']}',now(),{$member_id})";
	execute($link,$query);
	if(mysqli_affected_rows($link)==1){
		skip("show.php?id={$_GET['id']}",'回覆成功');
	}else{
		skip($_SERVER['REQUEST_URI'],'回覆失敗');
	}
}
$query= "select sc.id,sc.title,sc.content,sm.name,sm.photo from sfk_content sc,sfk_member sm where sc.id={$_GET['id']} and sc.member_id=sm.id";
$res_content = execute($link,$query);
if(mysqli_num_rows($res_content)==0){
 skip('index.php','此文章不存在');
}
$data_content = mysqli_fetch_assoc($res_content);
$data_content['title'] = htmlspecialchars($data_content['title']);
?>

<?php
include_once 'admin/inc/nav.inc.php';
?>
<title>文章回覆</title>

<div>回覆用戶:&nbsp;<?php echo $data_content['name'] ?>&nbsp;發布文章:&nbsp;<?php echo $data_content['title'] ?></div>
<form method="post">
		<textarea name="content" placeholder="請輸入文章內容" style="resize: none;width: 600px;height: 200px;border: green 3px solid;"></textarea></br>
		<input style="color: gray;" type="submit" name="submit" value="回覆">
</form>