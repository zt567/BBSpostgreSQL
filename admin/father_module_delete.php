<?php
include_once '../inc/config.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';

$templete['title']='父板塊刪除頁面';
if(!isset($_GET['id'])||!is_numeric($_GET['id'])){
    skip('father_module.php','刪除失敗!');
}

$link = connect();
$query = "select * from sfk_son_module where father_module_id={$_GET['id']}";
$res = execute($link,$query);
if(mysqli_num_rows($res)){
    skip('father_module.php','存在子板塊');
}

$query = "delete from sfk_father_module where id ={$_GET['id']}";
execute($link, $query);
if(mysqli_affected_rows($link)==1){
    skip('father_module.php','刪除成功!');
}else{
  echo '刪除失敗';
}
?>