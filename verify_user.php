<?php
function verify_user($username,$pw){
include_once 'inc/pgsql.inc.php';
$pw = md5($pw);
$query = "select * from sfk_member where name='{$username}' and pw='{$pw}'";
$result_pg_query=pg_query($conn, $query);
	$result = null;
	if($result_pg_query){
		if(pg_num_rows($result_pg_query)==1){
			$result = true;
		}
	}else{
		echo "query not working";
	}
	return $result;
}
$checked = verify_user($_POST['un'],$_POST['pw']);
if($checked){
	echo "ok";
}else{
	echo "no";
}

?>