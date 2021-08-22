<?php 
include_once '../inc/pgsql.inc.php';
include_once '../inc/tool.inc.php';
if(isset($_POST['submit'])){
// 	$link = connect();

// 	//驗證填寫欄位
// 	$check_flag = 'add'; 
// 	include 'inc/check_father_module.inc.php';

 $query = "INSERT INTO sfk_father_module (module_name,sort) VALUES ('{$_POST['module_name']}','{$_POST['sort']}')";
  // $query1 = "select * from sfk_father_module";
 $_POST['module_name'] = pg_escape_string($_POST['module_name']);

 if(empty($_POST['module_name'])||empty($_POST['sort'])||!is_numeric($_POST['sort'])){
 	skip($_SERVER['REQUEST_URI'],'名稱不得為空,sort需為0或1');
 }
 $result=pg_query($conn, $query);
  if  (!$result) {
    echo "query did not execute";
  }
  $rs = pg_fetch_assoc($result);
  if (!$rs) {
    echo "no records";
  }
  // var_dump($result);
  // var_dump($rs);
// 	$query = "insert into sfk_father_module(module_name,sort) value('{$_POST['module_name']}','{$_POST['sort']}')";	
// 	execute($link,$query);
	if(pg_affected_rows($result)==1){
		skip($_SERVER['REQUEST_URI'],'添加成功');
	}else{
		skip($_SERVER['REQUEST_URI'],'添加失敗');
	}
 // var_dump($_POST['submit']);
 // var_dump($_POST['module_name']);
}
?>
<?php
include_once 'inc/nav.inc.php';
?>
<title>admin父板塊添加</title>
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