<?php 
include_once '../inc/config.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$templete['title']='添加父板塊頁面';
if(isset($_POST['submit'])){
	$link = connect();

	//驗證填寫欄位
	$check_flag = 'add'; 
	include 'inc/check_father_module.inc.php';

	$query = "insert into sfk_father_module(module_name,sort) value('{$_POST['module_name']}','{$_POST['sort']}')";	
	execute($link,$query);
	if(mysqli_affected_rows($link)==1){
		skip('father_module.php','添加成功');
	}else{
		skip('father_module.php','添加失敗');
	}
}
?>

<?php include 'inc/header.inc.php' ?>
<div  style="border-width:3px;border-style:dashed;border-color:#FFAC55;padding:5px;text-align: center;">添加父板塊</div>

<form action="" method="post">
	<table>
		<tr>
			<td>添加板塊名稱:</td>
			<td><input type="text" name="module_name" placeholder="請輸入板塊名稱"></td>
			<td>不得為空</td>
		</tr>

		<tr>
			<td>排序:</td>
			<td><input type="text" name="sort" value="0" placeholder="請輸入排序"></td>
			<td>0或1</td>
		</tr>		
	</table>
	<input type="submit" name="submit" value="添加" style="cursor: pointer;">
</form>