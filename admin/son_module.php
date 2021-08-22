<?php
include_once '../inc/config.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$templete['title']='子板塊列表';
$link = connect();
if(isset($_POST['submit'])){
	foreach($_POST['sort'] as $key=>$val){
		if(!is_numeric($key)||!is_numeric($val)){
			skip('son_module.php','排序須為數字');
		}
		$query = "update sfk_son_module set sort={$val} where id={$key}";
		execute($link,$query);
	}
	skip('son_module.php','修改排序完成');
}
?>
<?php include 'inc/header.inc.php'?>

<div>子板塊列表</div>
<form method="post">
	<table>
		<tr>
			<th>排序</th>
			<th>板塊名</th>
			<th>&nbsp;所屬父板塊</th>
			<th>&nbsp;板主</th>
			<th>&nbsp;操作</th>
		</tr>
		<?php

		$link = connect();
		$query = "select ssm.id,ssm.sort,ssm.module_name,sfm.module_name fmn,ssm.member_id from sfk_son_module ssm,sfk_father_module sfm where ssm.father_module_id=sfm.id order by sfm.id";
		$res = execute($link, $query);
		while($son_data = mysqli_fetch_assoc($res)){		
			$url = urlencode("son_module_delete.php?id={$son_data['id']}");
			$return_url =  urlencode($_SERVER['REQUEST_URI']);
			$message = "板塊名稱:{$son_data['module_name']}";
			$delete_url = "confirm.php?url={$url}&return_url={$return_url}&message={$message}";
$html=<<<EOF
			<tr>
				<td><input type="text" name="sort[{$son_data['id']}]" value="{$son_data['sort']}"></td>
				<td align="center">[{$son_data['module_name']}]&nbsp;[id:{$son_data['id']}]</td>
				<td align="center">{$son_data['fmn']}</td>
				<td align="center">{$son_data['member_id']}</td>
				<td>&nbsp;<a href="#">訪問</a>&nbsp;<a href="son_module_update.php?id={$son_data['id']}">編輯</a>&nbsp;<a href="$delete_url">刪除</a></td>
			</tr>
EOF;
			echo $html;
		}
?>
	</table>
	<input style="color: gray;" type="submit" name="submit" value="修改排序">
</form>