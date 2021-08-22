<?php
include_once 'inc/config.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
include_once 'inc/page.inc.php';
$link = connect();
$member_id = is_login($link);
if(!isset($_GET['id'])||!is_numeric($_GET['id'])){
	skip('index.php','id參數不合法');
}
//訪問時瀏覽次數+1
$query = "update sfk_content set times=times+1 where id={$_GET['id']}";
execute($link,$query);
//content表+member表
$query = "select  sc.id cid,sc.module_id,sc.title,sc.content,sc.time,sc.times,sc.member_id,sm.name,sm.photo from sfk_content sc,sfk_member sm where sc.id={$_GET['id']} and sc.member_id=sm.id";
$res_content = execute($link,$query);
$data_content = mysqli_fetch_assoc($res_content); 
if(mysqli_num_rows($res_content)!=1){
	skip('index.php','帖子不存在');
}
// $data_content['times'] = $data_content['times']+1;
$query ="select * from sfk_son_module where id={$data_content['module_id']}";
$res_son = execute($link,$query);
$data_son = mysqli_fetch_assoc($res_son);

$query = "select * from sfk_father_module where id={$data_son['father_module_id']}";
$res_father = execute($link,$query);
$data_father = mysqli_fetch_assoc($res_father);
$query = "select count(*) from sfk_reply where content_id={$_GET['id']}";
$count_reply = num($link,$query);
?>
<?php
include_once 'admin/inc/nav.inc.php';
?>
<!-- 當前位置導航 -->
<title>文章內容</title>
<div>
	<a href="index.php">首頁</a> &gt; 
	<a href="list_father.php?id=<?php echo $data_father['id'] ?>"><?php echo $data_father['module_name'] ?></a> &gt; 
	<a href="list_son.php?id=<?php echo $data_son['id'] ?>"><?php echo $data_son['module_name'] ?></a> &gt;
	<span style="color: skyblue;"><?php echo $data_content['title'] ?></span>
</div>
<!-- 分頁列表 -->
<div class="pages">
	<?php 
	//文章回覆筆數
	$query = "select count(*) from sfk_reply where content_id={$_GET['id']}";
	//mysql.inc.php 
	$count_reply = num($link,$query);
	//page.inc.php
	$page_size = 5;
	$page = page($count_reply,5);
	echo $page['html'];
	?>
</div>

<!-- 樓主文章 第2頁後不顯示-->
<?php 
if($_GET['page']==1){ 
?>
<div style="border: 3px solid black;background-color: green;">
	<div>樓主<img style="width:120px;height: 120px;" 
		src="<?php 
                if($data_content['photo']!=''){
                    echo $data_content['photo'];
                }
                else{echo'inc/pic/rgm.png';
                } ?>">
    </div>
	<div>用戶名:<?php echo $data_content['name']; ?></div>
	<?php 
	$data_content['title'] =  htmlspecialchars($data_content['title']);
	$data_content['content'] =  htmlspecialchars($data_content['content']);
	 ?>
	<div>文章標題:<?php echo $data_content['title']; ?></div>
	<div>發布時間:<?php echo $data_content['time']; ?></div>
	<div style="background-color: black;">文章內容:<?php echo $data_content['content']; ?></div>
	<div>瀏覽次數:<?php echo $data_content['times']; ?></div>
	<div>回覆數:<?php echo $count_reply; ?></div>
	<div style="background-color: gray;width: 65px;"><a href="reply.php?id=<?php echo $_GET['id'] ?>">回覆文章</a></div>
</div>
<?php } ?>
<!-- 回覆文章顯示 -->
<?php
$query = "select sm.name,sr.member_id,sr.quote_id,sm.photo,sr.time,sr.id,sr.content from sfk_reply sr,sfk_member sm where sr.member_id=sm.id and sr.content_id={$_GET['id']} order by id asc {$page['limit']}";
$res_reply = execute($link,$query);
$floor=($_GET['page']-1)*$page_size+1;
while($data_reply = mysqli_fetch_assoc($res_reply)){
?>
<div style="border: 3px solid black;background-color: skyblue;">
	<div><img style="width:120px;height: 120px;"
	 src="<?php 
                if($data_reply['photo']!=''){
                    echo $data_reply['photo'];
                }
                else{echo'inc/pic/rgm.png';
                } ?>">
	</div>
	<div style="background-color: orange;width: 65px;">
	<div><?php echo $floor++ ; ?>樓</div>
	<a target="_blank" href="quote.php?id=<?php echo $_GET['id']?>&reply_id=<?php echo $data_reply['id']?>">引用回覆</a>
	</div>
		<?php
		if($data_reply['quote_id']){
		$query ="select count(*) from sfk_reply where content_id={$_GET['id']} and id<={$data_reply['quote_id']}";
		$floor_reply = num($link,$query);
		$query= "select sfk_reply.content,sfk_member.name from sfk_reply,sfk_member where sfk_reply.id ={$data_reply['quote_id']} and sfk_reply.content_id={$_GET['id']} and sfk_reply.member_id=sfk_member.id";
		$res_quote = execute($link,$query);
		$data_quote = mysqli_fetch_assoc($res_quote);
		?>
		<div class="quote" style="background-color: gray;">
			<span>引用:<?php echo $floor_reply; ?>樓 || 用戶:<?php echo $data_quote['name']; ?></span>
			<span> : <?php echo nl2br(htmlspecialchars($data_quote['content'])); ?></span>
		</div>
		<?php } ?>

	<div>用戶:<?php echo $data_content['name']; ?></div>
	<div>回覆時間:<?php echo $data_reply['time']; ?></div>
	<div  style="background-color:gray ;">
		<?php
		$data_reply['content']=nl2br(htmlspecialchars($data_reply['content']));
		echo $data_reply['content'];
	  	?>
	</div>

</div>
<?php } ?>