<?php
if(empty($_POST['content'])||mb_strlen($_POST['content'])<10||mb_strlen($_POST['content'])>255){
	skip($_SERVER['REQUEST_URI'],'內容至少10字,上限255字');
}
