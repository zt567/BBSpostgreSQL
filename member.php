<?php
include_once 'inc/config.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
include_once 'inc/page.inc.php';
$link = connect();
$member_id = is_login($link);
if(!isset($_GET['id'])||!is_numeric($_GET['id'])){
	skip('index.php','會員id參數不合法');
}
$query = "select * from sfk_member where id={$_GET['id']}";
$res_member = execute($link,$query);
$data_member = mysqli_fetch_assoc($res_member);
if(mysqli_num_rows($res_member)!=1){
	skip('index.php','無此會員資料');
}
$query = "select count(*) from sfk_content where member_id={$_GET['id']}";
$count_all = num($link,$query);
$page = page($count_all,5);
?>
<?php
include_once 'admin/inc/nav.inc.php';
?>
<title>會員中心</title>

<div><?php echo $page['html'] ?></div>
<ul class="postList">
<?php 

$query = "select sc.title,sc.id,sc.time,sc.member_id,sc.times,sm.name,sm.photo from sfk_content sc, sfk_member sm where sc.member_id={$_GET['id']} and sc.member_id=sm.id order by id desc {$page['limit']}";
$res_content = execute($link,$query);
while($data_content = mysqli_fetch_assoc($res_content)){
	$data_content['title']=htmlspecialchars($data_content['title']);
	$query = "select time from sfk_reply where content_id={$data_content['id']} order by id desc limit 1";
    $res_last_reply = execute($link,$query );
    if(mysqli_num_rows($res_last_reply)==0){
        $last_time = '暫無回覆';
    }else{
        $data_last_reply = mysqli_fetch_assoc($res_last_reply);
        $last_time = $data_last_reply['time'];
    };
?>
	<li>
		<div class="smlPic">
		<img style="width:120px;height: 120px;"
		 src="<?php if($data_content['photo']!=''){echo $data_content['photo'];}else{echo 'inc/pic/rgm.png';} ?>">
		</div>
		<div class="subject">
			<a href="show.php?id=<?php echo $data_content['id']?>"></a>
			<p>文章標題:<?php echo $data_content['title'] ?></p>
			<p>
				<?php
				if(check_user($member_id,$data_content['member_id'])){
					$url = urlencode("content_delete.php?id={$data_content['id']}");
					$return_url =  urlencode($_SERVER['REQUEST_URI']);
					$message = "是否刪除文章:{$data_content['title']}";
					$delete_url = "confirm.php?url={$url}&return_url={$return_url}&message={$message}";
					echo "<a href='content_update.php?id={$data_content['id']}'>[編輯]</a><a href='{$delete_url}'>[刪除]</a>";
				}
				?>
				發布時間:<?php echo $data_content['time'] ?>
			</p>
			<p>最後回覆:<?php echo $last_time ?></p>
		</div>
		<div>
			<div>瀏覽:<?php 
    					$query = "select count(*) from sfk_reply where content_id={$data_content['id']}";
						echo num($link,$query);
					?>			
			</div>
			<div>回覆:<?php echo $data_content['times']; ?></div>
		</div>
	</li>
<?php } ?>
</ul>

<div style="position: absolute;top: 100px;right: 100px;">
	<div class="member_big">
		<dl>
			<dt>
				<img width="180" height="180" src="<?php if($data_content['photo']!=''){echo $data_content['photo'];}else{echo 'inc/pic/rgm.png';} ?>">
			</dt>
			<dd>用戶:<?php echo $data_member['name'] ?></dd>
			<dd>文章總數 : <?php echo $count_all ?></dd>
			<dd>修改頭像<a href="member_photo_update.php"></a></dd>
			<dd>修改密碼<a href=""></a></dd>
		</dl>
	</div>
	
</div>

