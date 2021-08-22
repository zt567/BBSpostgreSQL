<?php 
include_once '../inc/config.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$templete['title']='子版塊列表';
$link = connect();
if(isset($_POST['submit'])){
	//驗證填寫欄位
	$check_flag = 'add';
	include 'inc/check_son_module.inc.php';
	//寫入資料庫
	$query = "insert into sfk_son_module(father_module_id,module_name,info,member_id,sort) values({$_POST['father_module_id']},'{$_POST['module_name']}','{$_POST['info']}',{$_POST['member_id']},{$_POST['sort']})";	
	execute($link,$query);
	if(mysqli_affected_rows($link)==1){
		skip('son_module_add.php','添加子板塊成功');
	}else{
		skip('son_module_add.php','添加子板塊失敗');
	}
}

?>
<?php include 'inc/header.inc.php'?>


<div  style="border-width:3px;border-style:dashed;border-color:seagreen;padding:5px;text-align: center;">添加子板塊</div>

<form action="" method="post">
	<table>

		<tr>
			<td>選擇所屬父板塊名稱:</td>
			<td>
				<select name="father_module_id" style="color:gray;">
					<option value="0">=請選擇一個父板塊=</option>
					<?php
					$query = "select * from sfk_father_module";
					$result = execute($link, $query);
					while($rows = mysqli_fetch_assoc($result)){
							echo "<option value='{$rows["id"]}'>{$rows['module_name']}</option>";
				
					}

					// if($rows = mysqli_fetch_assoc($result)){
					// 		echo "<option>{$rows['module_name']}</option>";
					// 		$rows = mysqli_fetch_assoc($result);
					// 		echo "<option>{$rows['module_name']}</option>";
							
					// }
					?>
			</td>
			<td>text</td>
		</tr>
		<tr>
			<td>添加子板塊名稱:</td>
			<td><input type="text" name="module_name" placeholder="請輸入子板塊名稱"></td>
			<td>不得為空</td>
		</tr>
		<tr>
			<td>板塊簡介</td>
			<td><textarea name="info" style="border:red 3px solid;" placeholder="請輸入板塊簡介"></textarea></td>
			<td>上限66字符</td>
		</tr>

		<tr>
			<td>選擇版主</td>
			<td>
				<select name="member_id" style="color:gray;">
					<option value="0">=請選擇一個版主=</option>
				</select>
			</td>
			<td>text</td>
		</tr>
		<tr>
			<td>排序:</td>
			<td><input type="text" name="sort" value="0" placeholder="請輸入排序"></td>
			<td>0或1</td>
		</tr>		
	</table>
	<input type="submit" name="submit" value="添加" style="cursor: pointer;color: gray;">
</form>