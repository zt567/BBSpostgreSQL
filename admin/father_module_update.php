<?php
include_once '../inc/config.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$templete['title']='編輯父板塊頁面';
//檢查id傳值
if(!isset($_GET['id'])||!is_numeric($_GET['id'])){
     skip('father_module.php','id參數錯誤!');
 }

$link = connect();
//id傳值有誤直接返回
$query = "select * from sfk_father_module where id={$_GET['id']}";
$res = execute($link, $query);
if(!mysqli_num_rows($res)){
	skip("father_module_update.php","板塊不存在");
}
//於此頁面提交
if(isset($_POST['submit'])){
	//驗證填寫欄位
	$check_flag = 'update'; 
	include 'inc/check_father_module.inc.php';
	//執行更新
	$query = "update sfk_father_module set module_name='{$_POST['module_name']}',sort='{$_POST['sort']}' where id={$_GET['id']}";
	execute($link, $query);
	if(mysqli_affected_rows($link)==1){
		skip('father_module.php','編輯成功');
	}else{
		skip('father_module.php','編輯失敗');
	}
}
//取資料顯示於此頁面
$data = mysqli_fetch_assoc($res);
?>

<?php include 'inc/head.inc.php';?>

<div  style="border-width:3px;border-style:dashed;border-color:#FFAC55;padding:5px;text-align: center;">編輯父板塊</div>

<form  method="post">
	<table>
		<tr>
			<td>編輯板塊名稱:</td>
			<td>
				<input type="text" name="module_name" 
				placeholder="<?php echo $data['module_name']?>">
			</td>
			<td>不得為空</td>
		</tr>

		<tr>
			<td>排序:</td>
			<td><input name="sort" placeholder="<?php echo $data['sort']?>"></td>
			<td>0或1</td>
		</tr>		
	</table>
	<input type="submit" name="submit" value="確定修改" style="cursor: pointer;background-color: green;">
</form>