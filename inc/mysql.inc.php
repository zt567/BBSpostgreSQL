<?php

function connect($host=DB_HOST, $user=DB_USER, $password=DB_PASSWORD,$database=DB_DATABASE, $port=DB_PORT){
	$link = @mysqli_connect($host, $user, $password,$database, $port);
	mysqli_set_charset($link,'utf8');
	return $link;
}

function execute($link, $query){
	// if($data = mysqli_query($link, $query)){
	// 	return $data;
	// }
	// else{
	// 	return mysql_error();
	// }
	$res = mysqli_query($link, $query);
	if(mysqli_errno($link)){
		exit(mysqli_error($link));
	}
	return $res;
}

function num($link,$sql_count){
	$res = execute($link,$sql_count);
	$count = mysqli_fetch_row($res);
	return $count[0];
}

function execute_bool($link, $query){
	$bool = mysqli_real_query($link, $query);
	return $bool;
}
function escape($link, $data){
    if(is_string($data)){
        return mysqli_real_escape_string($link, $data);
    }
    if(is_array($data)){
        foreach ($data as $key => $value) {
            $data[$key] = escape($link, $value);
        }
    }
    return $data;
}



?>