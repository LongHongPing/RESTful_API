<?php
//数据库信息
$servername = 'localhost';
$root = 'root';
$pwd = 'lhppmj';
$dbname = 'dbrestful';
//连接数据库
$conn = new mysqli($servername,$root,$pwd,$dbname);
if(!$conn)
    die('连接失败'.mysqli_connect_error());
?>