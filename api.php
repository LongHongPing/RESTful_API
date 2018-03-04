<?php
/*
 * 博客用户注册登陆功能
 * 信息采用MD5加密
 * 0为成功，1位失败
 * 返回json格式
 */
//请求
require 'conn.php';
header('Content-Type:/html;charset=utf-8');

$action = $_POST['action'];
//判断行为
switch ($action){
    //注册
    case "register":
        $username = lib_repalce_end_tag(trim($_POST['username']));
        $password2 = lib_repalce_end_tag(trim($_POST['password']));
        $password = md5("password2".all_ps);
        $email = lib_replace_end_tag(trim($_POST['email']));

        if($username == ' ' || $password2 = ' ' || $password = ' ' ){
            $res = array("status"=>2,"msg"=>'注册信息有误');
            exit(json_encode($res));
        }
        $sql = "select * from member where username = '$username'";
        $query = mysqli_query($conn,$sql);
        $count = mysqli_num_rows($query);
//0表示注册成功, 1表示注册失败
        if($count > 0){
            $res = array("status"=>1,"msg"=>'注册失败');
            exit(json_encode($res));
        }
        else{
            $addsql = "insert into member (username,password,email)
                        VALUES ('$username','$password','$email') ";
            mysqli_query($conn,$addsql);
            $res = array("status"=>0,"msg"=>'注册成功');
            exit(json_encode($res));
        }
        break;

        //登陆
    case "login":
        $username = lib_repalce_end_tag(trim($_POST['username']));
        $password2 = lib_repalce_end_tag(trim($_POST['password']));
        $password = md5("password2".all_ps);
        $sqluser = "select * from member where username = '".$username."'and password = '".$password."'";
        $queryuser = mysqli_query($conn,$sqluser);
        $rowuser = mysqli_fetch_array($queryuser);
       // 0表示登陆成功，1表示登录失败
        if($rowuser && is_array($rowuser) && !empty($rowuser)){
            if($rowuser['username'] == $username && $rowuser['password'] == $password){
                $response = array("status"=>0,"msg"=>'登陆成功');
                exit(json_encode($res));
        }
           else{
               $response = array("status"=>1,"msg"=>'用户名或密码错误');
               exit(json_encode($res));
            }
        }
        break;

    default:
        $res = array("status"=>1,"msg"=>'操作错误');
        exit(json_encode($res));
}
mysqli_close();
?>