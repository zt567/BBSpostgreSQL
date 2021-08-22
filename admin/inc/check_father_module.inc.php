<?php
//以下submit後執行
	if(empty($_POST['module_name'])||!is_numeric($_POST['sort'])||mb_strlen($_POST['module_name'])>66){
		skip('father_module_add.php','名稱不得為空且上限為66字節，排序需為數字');
	}
	//轉義字符
	$_POST = escape($link,$_POST);
	switch ($check_flag) {
		case 'add':
			$query = "select * from sfk_father_module where module_name='{$_POST['module_name']}'";
			break;
		case 'update':
			//查詢是否重複名稱且不同id,若有直接返回已有此板塊,沒有則可單獨修改sort值
			$query = "select * from sfk_father_module where module_name='{$_POST['module_name']}' and id!={$_GET['id']}";
			break;
		default:
			skip('father_module','$check_flag參數錯誤');
			break;
	}
	$res = execute($link,$query);
	if(mysqli_num_rows($res)){	
		skip('father_module_add.php','已有此板塊');
	}
?>
