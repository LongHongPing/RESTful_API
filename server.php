<?php
//设置页面
header('Content-Type:text/html;charset=utf-8');

function httppost($url,$parms){
    $url = $url . $parms;
    if(($ch = curl_init($url)) == false){
        throw new Exception(sprintf("curl_init error for url %s.",$url));     //抛出异常
    }
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  //设置获取的信息以文件流的形式返回
    curl_setopt($ch,CURLOPT_HEADER,0);  //设置头文件的信息作为数据流输出
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,500);    //发起连接前等待时间
    curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);    //返回location
    if(is_array($parms)){
        curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-Type:multipart/form-data'));    //设置HTTP头字段的数组
    }
    $postResult = @curl_exec($ch);                    //执行一个cURL会话。
    $http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);          //获取一个cURL连接资源句柄的信息---最后一个收到的HTTP代码
    if($postResult === false || $http_code != 200 || curl_errno($ch)){        //errno--返回最后一次的错误号。
        $error = curl_error($ch);                           //返回一个保护当前会话最近一次错误的字符串。
        curl_close($ch);
        throw new Exception("HTTP POST FAILED:$error");
    }
    else{
        switch (curl_getinfo($ch,CURLINFO_CONTENT_TYPE)){             //下载内容的Content-Type:值
            case 'application/json':
                $postResult = json_decode($postResult);
                break;
        }
        curl_close($ch);
        return $postResult;
    }
}

$postUrl = "http://localhost.restful API/api/server.php";

$p = $_POST['p'];
if($p == "register"){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $parms = "?action = register&username = ".$username."password = ".$password."";
}
elseif($p == "login"){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $parms = "?action = login&username = ".$username."password = ".$password."";
}
$res = httppost($postUrl,$parms);
$res = json_decode($res);
print_r(urldecode(json_encode($res)));
?>