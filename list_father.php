<?php
include_once 'inc/pgsql.inc.php';
include_once 'inc/tool.inc.php';
include_once 'inc/page.inc.php';
// $link = connect();
// $member_id = is_login($link);

// if(!isset($_GET['id'])||!is_numeric($_GET['id'])||empty($_GET['id'])){
// 	skip('index.php','父板塊id參數錯誤');
}
//資料庫父板塊是否有此id
// $query = "select * from sfk_father_module where id={$_GET['id']}";
// $res_father = execute($link,$query);
// if(mysqli_num_rows($res_father)==0){
// 	echo '無此板塊';
// }
// $data_father =  mysqli_fetch_assoc($res_father);


// $query = "select * from sfk_son_module where father_module_id={$_GET['id']}";
// $res_son = execute($link,$query);
// $id_son = '';
// $son_list = '';
// while($data_son = mysqli_fetch_assoc($res_son)){
//  $id_son.=$data_son['id'].',';
//  $son_list.="<a href='list_son.php?id={$data_son['id']}'>{$data_son['module_name']}</a> ";
// }
// $id_son = trim($id_son,',');
// if($id_son==''){
//     $id_son = '-1';
// }
// // $son_list = trim($son_list,',');
// $query = "select count(*) from sfk_content where module_id in({$id_son})";
// $count_all = num($link,$query);
// $query = "select count(*) from sfk_content where module_id in({$id_son}) and time>CURDATE()";
// $count_today = num($link,$query);
?>

<?php
include_once 'admin/inc/nav.inc.php';
?>

<title>父板塊文章</title>
<a href="index.php">首頁</a>
<a href="list_father.php?id=<?php echo $data_father['id']; ?>"><?php echo $data_father['module_name']; ?></a>

<div style="border: 1px solid gray;">
    <div>當前父板塊:<?php echo $data_father['module_name']; ?></div>
    <div>今日: <?php echo $count_today ?></div>
    <div>總貼文: <?php echo $count_all ?></div>
    <div>子板塊:<?php echo $son_list ?></div>
</div>
 
<div class="pages_wrap"  style="border: 1px solid green;">
    <div class="btn_publish"><a href="publish.php?father_module_id=<?php echo $_GET['id']?>" target="_blank"><<<發表文章>>></a></div>
    <div class="pages">
        <?php
        //array
        $page = page($count_all,20);
        // echo $page['html'];
        ?>
 </div>


 <ul class="postList">
    <?php 
    // $query = "select sfk_content.title,sfk_content.id,sfk_content.time,sfk_content.times,sfk_content.member_id,sfk_member.name,sfk_member.photo,sfk_son_module.module_name,sfk_son_module.id ssm_id from sfk_content,sfk_member,sfk_son_module where  sfk_content.module_id in({$id_son}) and sfk_content.member_id=sfk_member.id and sfk_content.module_id=sfk_son_module.id {$page['limit']}";
    // $res_content = execute($link,$query);
    // while($data_content = mysqli_fetch_assoc($res_content)){
    //     $data_content['title']=htmlspecialchars($data_content['title']);
        
    //     $query = "select time from sfk_reply where content_id={$data_content['id']} order by id desc limit 1";
    //     $res_last_reply = execute($link,$query );
    //     if(mysqli_num_rows($res_last_reply)==0){
    //         $last_time = '暫無回覆';
    //     }else{
    //         $data_last_reply = mysqli_fetch_assoc($res_last_reply);
    //         $last_time = $data_last_reply['time'];
    //     }
    ?>
     <li>
        <div class="subject" style="width: 700px; height: 150px; background-color: skyblue; margin-top: 20px;">
         <div class="titlePic">
            <a target="_blank" href="member.php?id=
            <?php
            // echo $data_content['member_id'];
            ?>">
                <img style="float: left;"
                src="
                <?php 
                // if($data_content['photo']!=''){
                //     echo $data_content['photo'];
                // }
                // else{echo'inc/pic/rgm.png';
                // }
                ?>">
            </a>
        </div>
            <div class="titleWrap" style="float: left;">
                <a href="list_son.php?id=<?php echo $data_content['ssm_id'] ?>">[<?php echo $data_content['module_name'] ?>]</a>
                <a target="_blank" href="show.php?id=<?php echo $data_content['id']; ?>"><?php echo $data_content['title'] ?></a>
                <p>樓主:<?php echo $data_content['name'] ?></p>
                <p>發文時間:<?php echo $data_content['time'] ?></p>
                <p>最後回覆:<?php echo $last_time; ?></p>
            </div>
        <div style="float: right;">
            <div style="background-color: #C9C9C9; color: black;">
                回覆:
                <?php
                $query = "select count(*) from sfk_reply where content_id={$data_content['id']}";
                echo num($link,$query);
                ?>

            </div>
            <div style="background-color: #C9C9C9;margin-top: 10px; color: black;">瀏覽:<?php echo $data_content['times'] ?></div>
        </div>
        </div>
     </li>
<?php } ?>
 </ul>


 <div style="position: absolute;right: 100px;top: 100px;">板塊列表
    <?php
    $query = "select * from sfk_father_module";
    $res_father = execute($link,$query);
    while($data_father = mysqli_fetch_assoc($res_father)){
    ?>
    <li style="list-style: none;">
        <h2><a href="list_father.php?id=<?php echo $data_father['id'] ?>"><?php  echo $data_father['module_name'];?></a></h2>
        <ul style="list-style: square;">
            <?php
            $query = "select * from sfk_son_module where father_module_id={$data_father['id']}";
            $res_son = execute($link,$query);
            while($data_son = mysqli_fetch_assoc($res_son)){
            ?>
            <li><a href="list_son.php?id=<?php echo $data_son['id'] ?>"><?php echo $data_son['module_name'] ?></a></li>
            <?php } ?>
        </ul>
    </li>

    <?php } ?>
 </div>