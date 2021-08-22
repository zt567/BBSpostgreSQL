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
$query = "select * from sfk_content where id={$_GET['id']}";
$res_content = execute($link,$query);
if(mysqli_num_rows($res_content)==1){
	$data_content = mysqli_fetch_assoc($res_content);
	if(check_user($member_id,$data_content['member_id'])){
		if(isset($_POST['submit'])){
			include_once 'inc/check_publish.inc.php';
			$_POST = escape($link,$_POST);
			$query = "update sfk_content set module_id={$_POST['module_id']},title='{$_POST['title']}' where id={$_GET['id']}";
			execute($link,$query);
			if(mysqli_affected_rows($link)==1){
				skip("member.php?id={$member_id}",'編輯成功');
			}else{
				skip("member.php?id={$member_id}",'編輯失敗');
			}
		}
	}else{
		skip('index.php','權限不足');
	}
}else{
	skip('index.php','文章不存在');	
}

?>
<?php include_once 'admin/inc/nav.inc.php'; ?>

<title>文章編輯</title>
	<?php
	if(isset($_COOKIE['sfk']['name'])){
		echo '目前用戶:'.$_COOKIE['sfk']['name'];
	}else{
		echo '尚未登入<a href="login.php">去登入</a>';
	}


?> 
<form method="post">
<span>選擇發佈板塊:</span>
	<select style="color: gray;" name="module_id">
		<option value="-1">請選擇子板塊</option>
		<?php
		$query = "select * from sfk_father_module order by sort desc ";
		$res_father = execute($link,$query);
		while($data_father = mysqli_fetch_assoc($res_father)){ 
			echo "<optgroup label='{$data_father['module_name']}'>";
			$query = "select * from sfk_son_module where father_module_id={$data_father['id']} order by sort desc";
			$res_son = execute($link,$query);
			while($data_son = mysqli_fetch_assoc($res_son)){
				if($data_son['id']==$data_content['module_id']){
				echo "<option selected='selected' style='color:red;' value='{$data_son['id']}'>{$data_son['module_name']}</option>";
				}else{
				echo "<option style='color:red;' value='{$data_son['id']}'>{$data_son['module_name']}</option>";
				}
				echo '</optgroup>';
			}
		}
		?>
	</select></br>
	<input type="text" name="title" placeholder="請輸入標題" value="<?php echo $data_content['title'] ?>"></br>
	<textarea name="content" placeholder="請輸入文章內容" style="resize: none;width: 600px;height: 200px;border: green 3px solid;"><?php echo $data_content['content'] ?>" 
	</textarea></br>
	<input style="color: gray;" type="submit" name="submit" value="確定">
</form>