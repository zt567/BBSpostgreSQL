<?php
include_once 'inc/config.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$link = connect();
//目前登入帳戶id
if(!$member_id = is_login($link)){
	skip('login.php','請先登入');
}
if(isset($_POST['submit'])){
	$link = connect();
	include 'inc/check_publish.inc.php';
	$_POST['title'] = htmlspecialchars($_POST['title']);
	$_POST['content'] =nl2br(htmlspecialchars($_POST['content']));
	$query = "insert into sfk_content(module_id,title,content,time,member_id) values({$_POST['module_id']},'{$_POST['title']}','{$_POST['content']}',now(),{$member_id})";
	execute($link,$query);
	if(mysqli_affected_rows($link)==1){
		skip('index.php','發布成功');
	}else{
		skip($_SERVER['REQUEST_URI'],'發布失敗');
	}
}
?>
<?php include_once 'admin/inc/nav.inc.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>發布文章</title>
</head>
<body>
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
			$where = '';
			//先判斷父板塊再子板塊
			if(isset($_GET['father_module_id']) && is_numeric($_GET['father_module_id'])){
				$where = "where id={$_GET['father_module_id']} ";
			}
			$query = "select * from sfk_father_module {$where}order by sort desc ";
			$res_father = execute($link,$query);
			while($data_father = mysqli_fetch_assoc($res_father)){ 
				echo "<optgroup label='{$data_father['module_name']}'>";
				$query = "select * from sfk_son_module where father_module_id={$data_father['id']} order by sort desc";
				$res_son = execute($link,$query);
				while($data_son = mysqli_fetch_assoc($res_son)){
					if(isset($_GET['son_module_id']) && $_GET['son_module_id']==$data_son['id']){
					echo "<option selected='selected' style='color:red;' value='{$data_son['id']}'>{$data_son['module_name']}</option>";
					}else{
					echo "<option style='color:red;' value='{$data_son['id']}'>{$data_son['module_name']}</option>";
					}
					echo '</optgroup>';
				}
			}
			?>
		</select></br>
		<input style="border: 1px gray solid;" type="text" name="title" placeholder="請輸入標題"></br>
		<textarea name="content" placeholder="請輸入文章內容" style="resize: none;width: 600px;height: 200px;border: green 3px solid;"></textarea></br>
		<input style="color: gray;" type="submit" name="submit" value="發布文章">
	</form>

</body>
</html>