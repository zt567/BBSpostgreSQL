<?php 

function skip($url,$message){
$html=<<<EOF
<!DOCTYPE html>
 <html>
 <head>
 	<meta charset="utf-8">
	<meta http-equiv="refresh" content="2,URL={$url}";>
 	<title>refreshing...</title>
 </head>
 <body>
 <div>{$message}...2秒後跳轉...</div>
 
 </body>
 </html>
EOF;
echo $html;
exit();
}

function is_login($link){
    if(isset($_COOKIE['sfk']['name'])&&isset($_COOKIE['sfk']['pw'])){
        $query = "select * from sfk_member where name='{$_COOKIE['sfk']['name']}' and sha1(pw)='{$_COOKIE['sfk']['pw']}'";
        $res = execute($link,$query);
        if(mysqli_num_rows($res)==1){
        $data = mysqli_fetch_assoc($res);
        return $data['id'];
        }else{
            return false;
        }
    }
    else{
        return false;
    }
}


function check_user($member_id,$content_member_id){
    if($member_id==$content_member_id){
        return true;
    }else{
        return false;
    }
}

 ?>