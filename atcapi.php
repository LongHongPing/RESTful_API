<?php
/*
 * 博客文章的增删改查
 * 0为成功，1为失败
 * 返回json格式
 */
require 'conn.php';
header('Content-Type:/html;charset=utf-8');

$action = $_POST['action'];

switch ($action){

    //增加文章
    case "add":
        $title = $_POST['titlt'];
        $type = $_POST['type'];
        $content = $_POST['content'];
        $sql = "insert into articles (atctitle,atctype,atccontent)
                VALUES ('$title','$type','$content')";
        $query = mysqli_query($conn,$sql);         //插入内容
        $count = mysqli_num_rows($query);
        //1表示添加失败，0表示添加成功
        if($count > 0){
            $res = array("status"=>1,"msg"=>'添加失败');
            exit(json_encode($res));
        }
        else{
            $res = array("status"=>0,"msg"=>'添加成功');
            exit(json_encode($res));
        }
        break;

        //删除文章
    case "del":
        $title = $_POST['title'];
        $sql = "delete from articles where atctitle='$title'";
        $query = mysqli_query($conn,$sql);
        $count = mysqli_num_rows($query);
        //1表示删除失败，0表示删除成功
        if($count > 0){
            $res = array("status"=>1,"msg"=>'删除失败');
            exit(json_encode($res));
        }
        else{
            $res = array("status"=>0,"msg"=>'删除成功');
            exit(json_encode($res));
        }
        break;

        //修改文章
    case "edi":
        $title = $_POST['titlt'];
        $type = $_POST['type'];
        $content = $_POST['content'];
        $sql = "update articles set atctitle = '".$title."' and atctype = '".$type."' and atccontent = '".$content."'";
        $query = mysqli_query($conn,$sql);
        $count = mysqli_num_rows($query);
        //1表示修改失败，0表示修改成功
        if($count > 0){
            $res = array("status"=>1,"msg"=>'修改失败');
            exit(json_encode($res));
        }
        else{
            $res = array("status"=>0,"msg"=>'修改成功');
            exit(json_encode($res));
        }
        break;

        //查询文章
    case "sea":
        $title = $_POST['title'];
        $sql = "select * from articles where atctitle = '$title'";
        $query = mysqli_query($conn,$sql);
        $array = mysqli_fetch_array($query);
        //1表示查询失败，0表示查询成功
        if($array){
            $res = array("status"=>1,"msg"=>'查询失败',"data"=>null);
            exit(json_encode($res));
        }
        else{
            $res = array("status"=>0,"msg"=>'查询成功',"data"=>$array);
            exit(json_encode($res));
        }

    default:
        $res = array("status"=>1,"msg"=>'操作错误');
        exit(json_encode($res));
}
mysqli_close();
?>