<?php
include_once '../inc/config.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';

$templete['title']='板塊刪除頁面';
if(!isset($_GET['id'])||!is_numeric($_GET['id'])){

    skip('son_module.php','刪除失敗!');
}

$link = connect();
$query = "delete from sfk_son_module where id ={$_GET['id']}";
execute($link, $query);
if(mysqli_affected_rows($link)==1){
    skip('son_module.php','刪除成功!');
}else{
  echo '刪除失敗';
}
?>