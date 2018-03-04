<?php
/*
 * 博客评论功能
 * 防止sql注入
 * 返回json格式
 */
header("Content-Type:text/html;charset = utf-8");
require "conn.php";

$article_id = trim($_POST['article_id']);     //文章id
$user_id = trim($_POST['user_id']);           //用户id
$content = trim($_POST['content']);          //评论内容
$create_time = date("D F d Y",time());  //评论时间
//转义，防sql注入
$article_id = mysqli_real_escape_string($article_id);
$user_id = mysqli_real_escape_string($user_id);
$content = mysqli_real_escape_string($content);
$create_time = mysqli_real_escape_string($create_time);

$sql = "INSERT INTO comment (user_id,article_id,content,create_time)
        VALUES ('$user_id','$article_id','$content','$create_time')";
$query = mysqli_query($conn,$sql);
$count = mysqli_num_rows($query);
//1表示添加失败，0表示添加成功
if($count > 0){
    $res = array("status"=>1,"msg"=>'评论失败');
    exit(json_encode($res));
}
else{
    $res = array("status"=>0,"msg"=>'评论成功');
    exit(json_encode($res));
}
mysqli_close();
?>