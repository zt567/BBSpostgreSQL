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
$query= "select sc.id,sc.title,sc.content,sm.name,sm.photo from sfk_content sc,sfk_member sm where sc.id={$_GET['id']} and sc.member_id=sm.id";
$res_content = execute($link,$query);
if(mysqli_num_rows($res_content)!=1){
 skip('index.php','此文章不存在');
}
//回覆提交
if(isset($_POST['submit'])){
	include 'inc/check_reply.inc.php';
	//刪除干擾查詢語句字符 mysql.inc.php
	$_POST=escape($link,$_POST);
	$query = "insert into sfk_reply(content_id,quote_id,content,time,member_id)
	 values(
	 {$_GET['id']},{$_GET['reply_id']},'{$_POST['content']}',now(),{$member_id})
	 ";
	execute($link,$query);
	if(mysqli_affected_rows($link)==1){
		skip("show.php?id={$_GET['id']}",'回覆成功');
	}else{
		skip($_SERVER['REQUEST_URI'],'回覆失敗');
	}
}

$data_content = mysqli_fetch_assoc($res_content);
$data_content['title'] =  htmlspecialchars($data_content['title']);


if(!isset($_GET['reply_id'])||!is_numeric($_GET['reply_id'])){
	skip('index.php','引用回覆id參數不合法');
}
$query= "select sfk_reply.content,sfk_member.name from sfk_reply,sfk_member where sfk_reply.id ={$_GET['reply_id']} and sfk_reply.content_id={$_GET['id']} and sfk_reply.member_id=sfk_member.id";
$res_reply = execute($link,$query);
$data_reply = mysqli_fetch_assoc($res_reply);
$data_reply['content'] = nl2br(htmlspecialchars($data_reply['content']));
if(mysqli_num_rows($res_reply)!=1){
 skip('index.php','引用文章不存在');
}





$query ="select count(*) from sfk_reply where content_id={$_GET['id']} and id<={$_GET['reply_id']}";
$floor = num($link,$query);

?>

<?php
include_once 'admin/inc/nav.inc.php';
?>
<title>引用回復</title>
<div>引用<?php echo $floor ?>樓&nbsp;<?php echo $data_content['name'] ?>&nbsp;標題:&nbsp;<?php echo $data_content['title'] ?>
</div>
<div>內容:<?php echo $data_reply['content']; ?></div>
<form method="post">
		<textarea name="content" placeholder="請輸入文章內容" style="resize: none;width: 600px;height: 200px;border: green 3px solid;"></textarea></br>
		<input style="color: gray;" type="submit" name="submit" value="回覆">
</form>