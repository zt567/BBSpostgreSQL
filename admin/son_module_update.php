<?php 
include_once '../inc/config.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$templete['title']='編輯子版塊';
$link = connect();

//檢查id傳值
if(!isset($_GET['id'])||!is_numeric($_GET['id'])){
     skip('son_module.php','id參數錯誤!');
 }
$query = "select * from sfk_son_module where id={$_GET['id']}";
$res = execute($link , $query);
 if(!mysqli_num_rows($res)){
 	skip('son_module_update.php','這條子板塊不存在');
 }


if(isset($_POST['submit'])){
	//驗證填寫欄位
	$check_flag = 'update'; 
	include 'inc/check_son_module.inc.php';
	$query = "update sfk_son_module set father_module_id={$_POST['father_module_id']},module_name='{$_POST['module_name']}',info='{$_POST['info']}',member_id={$_POST['member_id']},sort={$_POST['sort']} where id={$_GET['id']}";	

	execute($link,$query);
	if(mysqli_affected_rows($link)==1){
		skip('son_module.php','編輯子板塊成功');
	}else{
		skip('son_module.php','編輯子板塊失敗');
	}
}

$son_data = mysqli_fetch_assoc($res);
?>
<?php include 'inc/head.inc.php'?>


<div  style="border-width:3px;border-style:dashed;border-color:seagreen;padding:5px;text-align: center;">編輯子板塊</div>

<form method="post">
	<table>

		<tr>
			<td>編輯所屬父板塊名稱:</td>
			<td>
				<select name="father_module_id" style="color:gray;">
					<option value="0">=請選擇一個父板塊=</option>
					<?php

					$query = "select * from sfk_father_module";
					$res_father = execute($link, $query);
					while($father_data = mysqli_fetch_assoc($res_father)){
						if($father_data['id']==$son_data['father_module_id']){
						echo "<option selected='selected' value='{$father_data['id']}'>{$father_data['module_name']}<<當前父板塊</option>";	
						}else{	
						echo "<option value='{$father_data['id']}'>{$father_data['module_name']}</option>";
						}
					}
					?>
			</td>
			<td>text</td>
		</tr>
		<tr>
			<td>編輯子板塊名稱:</td>
			<td><input type="text" name="module_name" value='<?php echo "{$son_data['module_name']}" ?>'></td>
			<td>不得為空</td>
		</tr>
		<tr>
			<td>編輯板塊簡介</td>
			<td><textarea name="info" style="border:red 3px solid;"><?php echo "{$son_data['info']}" ?></textarea></td>
			<td>上限66字符</td>
		</tr>

		<tr>
			<td>編輯選擇版主</td>
			<td>
				<select name="member_id" style="color:gray;">s
					<option value="0">=請選擇一個版主=</option>
					<?php

					$query = "select * from sfk_son_module";
					$res = execute($link, $query);
					while($son_data = mysqli_fetch_assoc($res)){
						echo "<option>{$son_data['member_id']}</option>";
					}
					?>
				</select>
			</td>
			<td>text</td>
		</tr>
		<tr>
			<td>編輯排序:</td>
			<td><input type="text" name="sort" value="0" placeholder="請輸入排序"></td>
			<td>0或1</td>
		</tr>		
	</table>
	<input type="submit" name="submit" value="確定修改" style="cursor: pointer;color: gray;">
</form>