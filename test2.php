<?php
function upload($save_path,$custom_upload_max_filesize,$key,$type=array('jpg','jpeg','png','gif')){
	$return_data=array();
	$phpini = ini_get('upload_max_filesize');

	$phpini_unit = strtoupper(substr($phpini, -1));
	$phpini_number= substr($phpini,0,-1);
	$phpini_multiple = get_multiple($phpini_unit);
	$phpini_bytes = $phpini_number*$phpini_multiple;

	$custom_unit = strtoupper(substr($custom_upload_max_filesize,-1));
	$custom_number = substr($custom_upload_max_filesize,0,-1); 
	$custom_multiple = get_multiple($custom_unit);
	$custom_bytes = $custom_number*$custom_multiple;

	if($custom_bytes>$phpini_bytes){
		$return_data['error'] = 'error! more than php.ini:'.$phpini;
		$return_data['return'] = false;
		return $return_data;
	}   
	$arr_errors = array(
		1=>'超過上限',
		2=>'超過html上限',
		3=>'部分上傳',
		4=>'沒有被上傳',
		6=>'找不到臨時文件夾',
		7=>'文件寫入失敗'
	);
	if(!isset($_FILES[$key]['error'])){
		$return_data['error'] = '上傳失敗';
		$return_data['return'] = false;
		return $return_data;
	}
	if($_FILES[$key]['error']!=0){
		$return_data['error']=$arr_errors[$_FILES['error']];
		$return_data['return'] = false;
		return $return_data; 
	}
	if($_FILES[$key]['size']>$custom_bytes){
		$return_data['error'] = 'custom_upload_max_filesize超過上限'.$custom_upload_max_filesize;
		$return_data['return'] = false;
		return $return_data;
	}
	//var_dump(pathinfo($_FILES['myfile']['name']));
	// array (size=4)
	//   'dirname' => string '.' (length=1)
	//   'basename' => string 'AA.png' (length=6)
	//   'extension' => string 'png' (length=3)
	//   'filename' => string 'AA' (length=2)
	
	//pathinfo($_FILES[$key]['name']['extension']); Warning: Illegal string offset
	
	$arr_filename = pathinfo($_FILES[$key]['name']);
	if(!isset($arr_filename['extension'])){
		$arr_filename['extension']='';
	}
	if(!in_array($arr_filename['extension'],$type)){
		$return_data['error'] = '上傳類型需為'.implode(',', $type);
		$return_data['return'] = false;
		return $return_data;
	}

	// var_dump($_FILES);
	// array (size=1)
	//   'myfile' => 
	//     array (size=5)
	//       'name' => string 'AA.png' (length=6)
	//       'type' => string 'image/png' (length=9)
	//       'tmp_name' => string 'D:\wamp2\tmp\phpA813.tmp' (length=24)
	//       'error' => int 0
	//       'size' => int 1106
	if(!file_exists($save_path)){
		if(!mkdir($save_path,0777,true)){ 
			$return_data['error'] = '目錄創建失敗';
			$return_data['return'] = false;
			return $return_data;
		}
		
	}
	var_dump($_FILES);

	$return_data['return'] = true;
	return $return_data;
}



function get_multiple($unit){
	switch ($unit) {
		case 'K':
			$multiple = 1024;
			return $multiple;
		case 'M':
			$multiple = 1024*1024;
			return $multiple;
		case 'G':
			$multiple = 1024*1024*1024;
			return $multiple;
		default:
			return false;
	}
}
header("Content-type:text/html;charset=utf8");
$upload = upload('a/','2M','myfile');
if(!$upload['return']){
	var_dump($upload['error']);
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>上傳頁面</title>
</head>
<body>
	<form action="" method="post" enctype="multipart/form-data">
		<input type="file" name="myfile"><br>
		<input type="submit" name="submit" value="開始上傳">
	</form>
</body>
</html>