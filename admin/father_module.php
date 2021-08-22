<?php
include_once '../inc/config.php';
include_once '../inc/pgsql.inc.php';
include_once '../inc/tool.inc.php';

$templete['title']='父板塊列表';
$link = connect();
if(isset($_POST['submit'])){
	foreach($_POST['sort'] as $key=>$val){
		if(!is_numeric($key)||!is_numeric($val)){
			skip('father_module.php','排序須為數字');
		}
		$query = "update sfk_father_module set sort={$val} where id={$key}";
		execute($link,$query);
	}
	skip('father_module.php','修改排序完成');

}
?>
<?php include 'inc/header.inc.php'?>
	<div>父板塊列表</div>
	<form method="post">
		<table>
			<tr>
				<th>排序</th>
				<th>&nbsp;板塊名</th>
				<th>&nbsp;操作</th>
			</tr>
			<?php
			$link = connect();
			$query = "select * from sfk_father_module";
			$res = execute($link, $query);
			while($data = mysqli_fetch_assoc($res)){		
				$url = urlencode("father_module_delete.php?id={$data['id']}");
				$return_url =  urlencode($_SERVER['REQUEST_URI']);
				$message = "板塊名稱:{$data['module_name']}";
				$delete_url = "confirm.php?url={$url}&return_url={$return_url}&message={$message}";
$html=<<<EOF
				<tr>
					<td><input type="text" name="sort[{$data['id']}]" value="{$data['sort']}"></td>
					<td>{$data['module_name']}ID:{$data['id']}</td>
					<td>&nbsp;<a href="#">訪問</a>&nbsp;<a href="father_module_update.php?id={$data['id']}">編輯</a>&nbsp;<a href="$delete_url">刪除</a></td>
				</tr>
EOF;
				echo $html;
			}
			?>
		</table>
		<input style="color: gray;" type="submit" name="submit" value="修改排序">
	</form>
</div>
