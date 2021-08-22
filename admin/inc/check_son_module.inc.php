<?php
//以下submit後執行
	if(empty($_POST['module_name'])||!is_numeric($_POST['sort'])||mb_strlen($_POST['module_name'])>66){
		skip('son_module.php','名稱不得為空且上限為66字節，排序需為數字');
	}
	$query = "select * from sfk_father_module where id={$_POST['father_module_id']}";
	$res = execute($link,$query);
	if(mysqli_num_rows($res)==0){	
		skip('son_module.php','無此父板塊');
	}
	if(empty($_POST['module_name'])||mb_strlen($_POST['module_name'])>66){
		skip('son_module.php','名稱不得為空,上限為66字符');		
	}
	if(empty($_POST['info'])||mb_strlen($_POST['info'])>66){
		skip('son_module.php','簡介不得為空,上限為66字符');	
	}
	switch ($check_flag) {
		case 'add':
			$query = "select * from sfk_son_module where module_name='{$_POST['module_name']}'";
			break;
		case 'update':
			//查詢是否重複名稱且不同id,若有直接返回已有此板塊,沒有則可單獨修改sort值
			$query = "select * from sfk_son_module where module_name='{$_POST['module_name']}' and id!={$_GET['id']}";
			break;
		
		default:
			skip('father_module.php','$check_flag參數錯誤');
			break;
	}
	$res = execute($link,$query);
	if(mysqli_num_rows($res)){	
		skip('son_module.php','已有此子板塊');
	}
	if(mb_strlen($_POST['info'])>66){
		skip('son_module.php','板塊資訊不得超過66字符');
	}

?>
