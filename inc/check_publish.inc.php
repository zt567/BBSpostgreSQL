<?php
if(empty($_POST['module_id'])||!is_numeric($_POST['module_id'])){
	skip('publish.php','所屬板塊id不合法');
}
$query = "select * from sfk_son_module where id={$_POST['module_id']}";
$res = execute($link,$query);
if(mysqli_num_rows($res)!=1){
	skip('publish.php','請選擇所屬板塊');
}
if(empty($_POST['title'])||mb_strlen($_POST['title'])>255){
	skip('publish.php','標題不得為空,上限255字節');
}
?>
