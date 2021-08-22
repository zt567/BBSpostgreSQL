<?php
include_once 'inc/config.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
include_once 'inc/page.inc.php';
$link = connect();
$member_id = is_login($link);

if(!isset($_GET['id'])||!is_numeric($_GET['id'])||empty($_GET['id'])){
	skip('index.php','子板塊id參數錯誤');
}
//是否有此id
$query = "select * from sfk_son_module where id={$_GET['id']}";
$res_son = execute($link,$query);
if(mysqli_num_rows($res_son)!=1){
	echo '無此板塊';
}
//子板塊資料
$data_son = mysqli_fetch_assoc($res_son);

//當前子板塊所屬父板塊資料
$query = "select * from sfk_father_module where id={$data_son['father_module_id']}";
$res_father = execute($link, $query);
$data_father = mysqli_fetch_assoc($res_father);

//當前子板塊文章總數,今日文章總數
$query = "select count(*) from sfk_content where module_id={$_GET['id']}";
$count_all = num($link,$query);
$query = "select count(*) from sfk_content where module_id={$_GET['id']} and time>CURDATE()";
$count_today = num($link,$query);

//查sfk_member表id  當前子板塊版主id
$query = "select * from sfk_member where id={$data_son['member_id']}";
$res_member = execute($link,$query);

?>


<?php
include_once 'admin/inc/nav.inc.php';
?>
<title>子板塊文章</title>
<a href="index.php">首頁</a>▶
<a href="list_father.php?id=<?php echo $data_father['id'] ?>">
	<?php echo $data_father['module_name'] ?></a>▶
	<span style="color: skyblue;"><?php echo $data_son['module_name'] ?></span>
<a href="list_father.php?id="></a>

<div class="moduleInfo" style="border: 1px solid gray;">
    <div><?php echo $data_son['module_name'] ?></div>
    <div>今日: <?php echo $count_today ?></div>
    <div>總貼文: <?php echo $count_all ?></div>
    <div>版主:
    	<span>
    		<?php
    			if(mysqli_num_rows($res_member)==0){
    				echo '暫無版主';
    			}else{
    				$data_member = mysqli_fetch_assoc($res_member);
    				echo $data_member['name'];
    			}
    		?>
    		</span>
    </div>
    <div>板塊資訊:<?php echo $data_son['info'] ?></div>
</div>
 

 <div class="pages_wrap"  style="border: 1px solid green;">
    <div class="btn_publish"><a href="publish.php?son_module_id=<?php echo $_GET['id']?>" target="_blank"><<<發表文章>>></a></div>
    <div class="pages">
        <?php
        //array
        $page = page($count_all,5);
        echo $page['html'];
         ?>
 </div>


 <ul class="postList">
    <?php 
    //取文章標題,內容,文章id,發文時間,最後編輯時間,作者,用戶大頭照;
    $query = "select sfk_content.title, sfk_content.content,sfk_content.id,sfk_content.time,sfk_content.times,sfk_content.member_id,sfk_member.name,sfk_member.photo from sfk_content,sfk_member where sfk_content.module_id={$_GET['id']} and sfk_content.member_id=sfk_member.id {$page['limit']}";
    $res_content = execute($link,$query);
    while($data_content = mysqli_fetch_assoc($res_content)){
        $query = "select time from sfk_reply where content_id={$data_content['id']} order by id desc limit 1";
        $res_last_reply = execute($link,$query );
        if(mysqli_num_rows($res_last_reply)==0){
            $last_time = '暫無回覆';
        }else{
            $data_last_reply = mysqli_fetch_assoc($res_last_reply);
            $last_time = $data_last_reply['time'];
        }
    ?>
     <li>
         <div class="titlePic">
            <a target="_blank" href="member.php?id=<?php echo $data_content['member_id'] ?>">
                <img src="
                <?php 
                if($data_content['photo']!=''){
                    echo $data_content['photo'];
                }
                else{echo'inc/pic/rgm.png';
                } ?>">
            </a>
        </div>
        <div class="subject">
            <div class="titleWrap">
                <a target="_blank" href="show.php?id=<?php echo $data_content['id']; ?>"><?php echo $data_content['title'] ?></a>
            </div>
            <p>作者:<?php echo $data_content['name'] ?></p>
            <p>內容:<?php echo $data_content['content'] ?></p>
            <p>發文時間:<?php echo $data_content['time'] ?></p>
            <p>文章id:<?php echo $data_content['id'] ?></p>
        </div>
        <div>
            <p>回覆:<?php
                $query = "select count(*) from sfk_reply where content_id={$data_content['id']}";
                echo num($link,$query);
                ?>
            </p>
            <p>瀏覽:<?php echo $data_content['times'] ?></p>
            <p>最後回覆:<?php echo $last_time; ?></p>
        </div>
     </li>
<?php }?>
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