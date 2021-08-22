<?php
include_once 'inc/pgsql.inc.php';
include_once 'inc/tool.inc.php';
// $link = connect();
// $member_id=is_login($link);
?>
<?php
include_once 'admin/inc/nav.inc.php';
?>
<title>首頁</title>
<div class="ml-56 w-2/3 bg-blue-300">
<div class="bg-green-700">熱門板塊</div>
<?php 
// $query ="select * from sfk_father_module order by sort desc";
// $res_father = execute($link,$query);
// while ($data_father = mysqli_fetch_assoc($res_father)) {
?>
<div class="">
	<div class="">
		<a href="list_father.php?id=
        <?php
        // echo $data_father['id']
        ?>">
		<?php
        // echo $data_father['module_name']
        ?>
		</a>
	</div>
<?php 
//     $query= "select * from sfk_son_module where father_module_id={$data_father['id']}";
// 	$res_son = execute($link,$query);
// 	//可能沒有子板塊,所以用if輸出
// 	if($data_son = mysqli_num_rows($res_son)){
// 		while($data_son = mysqli_fetch_assoc($res_son)){
// 			$query = "select count(*) from sfk_content where module_id={$data_son['id']} and time > CURDATE()";
// 			$res = execute($link,$query);
// 					//tool.inc.php
// 			$count_today = num($link,$query);
// 			$query = "select count(*) from sfk_content where module_id={$data_son['id']}";
// 			$res = execute($link,$query);
// 			$count_all = num($link,$query);
// $html=<<<EOF
// <div class="inline-flex">				
// 	<div class="bg-blue-200 m-5 w-48 rounded-md">
// 		<div>
// 			<img src="admin/inc/Spurs.png" class="rounded-md">
// 			<a href="list_son.php?id={$data_son['id']}">{$data_son['module_name']}</a>
// 			(今日:{$count_today})
// 			帖子:{$count_all}
// 		</div>
// 	</div>
// </div>
// EOF;
// echo $html;
// 		}
// 	}else{
// 		echo '<div>...暫無子板塊 ...</div>' ;
// 	}
// 	echo '</br>';
?>
<?php
// }
?>
</div>
</div>