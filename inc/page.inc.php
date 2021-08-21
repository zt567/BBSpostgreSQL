<?php 
/*
調用$page=page(100,10,9);
返回值:array('limit','html')
參數
$count:總筆數
$page_size:每頁顯示筆數
$num_btn:頁碼按鈕個數
$page:分頁get參數

*/

function page($count, $page_size, $num_btn=10, $page='page'){
	if(!isset($_GET[$page])||!is_numeric($_GET[$page])||$_GET[$page]<1){
		$_GET[$page]=1;
	}
	if($count==0){
		$data=array(
			'limit'=>'',
			'html'=>''
		);
		return $data;
	}
	$page_num_all = ceil($count/$page_size);
	if($_GET[$page]>$page_num_all){
		$_GET[$page] = $page_num_all;
	}
	$start=($_GET[$page]-1)*$page_size;
	$limit="limit {$start},{$page_size}";

	//sfkbbs/test.php?querystring...
	$current_url = $_SERVER['REQUEST_URI'];

	//sfkbbs/test.php?querystring...
	//拆分存到array [path=>sfkbbs/test.php , query=>page=...]
	$arr_current = parse_url($current_url);

	//sfkbbs/test.php
	$current_path = $arr_current['path'];


	$url='';
	if(isset($arr_current['query'])){
		parse_str($arr_current['query'],$array_query);
		unset($array_query[$page]);
		//傳空值
		if(empty($array_query)){
			$url = "{$current_path}?{$page}=";
		}else{
			$other_query=http_build_query($array_query);
			$url =  "{$current_path}?{$other_query}&{$page}=";
		}
	}else{
		$url = "{$current_path}?{$page}=";
	} 
	$html=array();
	if($num_btn>=$page_num_all){ 
		for ($i=1; $i <=$page_num_all; $i++) { 
			if($i==$_GET[$page]){
				$html[$i]="<span>{$i}</span> ";	
			}else{
				$html[$i]="<a href='{$url}{$i}'>{$i}</a> ";
			}			
		}
	}else{
		$num_left=floor(($num_btn-1)/2);
		$start=$_GET[$page]-$num_left;
		$end=$start+($num_btn-1);
		if($start<1){
			$start = 1;
		}
		if($end>$page_num_all){
			$start = $page_num_all-($num_btn-1);
		}
		for ($i=0; $i <$num_btn; $i++) { 
			if($_GET[$page]==$start){
				$html[$start]="<span>{$start}</span> ";
			}else{
				$html[$start]="<a href='{$url}{$start}'>{$start}</a> ";
			}
			$start++;
		}
		if(count($html)>=3){
			reset($html);
			$key_first=key($html);
			end($html);
			$key_end=key($html);
			if($key_first!=1){
				array_shift($html);
				array_unshift($html, "<a href='{$url}1'>1...</a>");
			}
			if($key_end!=$page_num_all){
				array_pop($html);
				array_push($html, "<a href='{$url}{$page_num_all}'>...{$page_num_all}</a>");
			}
		}
	}
	if($_GET[$page]!=1){
		$prev = $_GET[$page]-1;
		array_unshift($html,"<a href='{$url}{$prev}'>前一頁</a>");
	}

	if($_GET[$page]!=$page_num_all){
		$next = $_GET[$page]+1; 
		array_push($html,"<a href='{$url}{$next}'>後一頁</a>");
	}
	$html = implode(' ', $html);
	$data=array(
		'limit'=>$limit,
		'html'=>$html
	);
	return $data;  
}
?>