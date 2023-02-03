<?php
$host = '47.115.218.216';
$username = 'teacher';
$password = 'zhang134679';
$dbname = 'envxy'; // 默认数据库为envxy，用于老师给题目初始化
$tConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$tConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$temp = $tConn->query("select `id` from sqlxy.`answer` where `exerciseid` = '88';")->fetch();
var_dump($temp);