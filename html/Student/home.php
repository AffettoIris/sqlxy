<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>数据库原理实验评判系统主页</title>
    <meta name="description" content="数据库原理实验评判系统-在线评判和打分，提供成绩分析功能，节省教师时间成本和工作量">
    <meta name="keywords" content="数据库课程，实验，打分，成绩，统计">
    <link rel="shortcut icon" href="../../static/img/logo/logo.ico">
    <link rel="stylesheet" href="../../static/common/css/css初始化代码.css">
    <link rel="stylesheet" href="../../static/common/Student/header.css">
    <style>
        #sakura {
            position: absolute;
            /*display: none;*/
            top: 0;
            left: 0;
            z-index: 999;
            transform: rotateY(180deg);
            opacity: 0.4;
            pointer-events: none;
            list-style-type: none;
        }
    </style>
</head>

<body>
    <!-- 在刷题页面放置账号中心，可以改密，通向changepwd.html -->
    <?php include '../../static/common/Student/header.html'?>

    <!-- 雪花飘落 -->
    <canvas id="sakura" width="1707" height="811"></canvas>
    <?php include '../../static/common/js/漫天爱心雪花飘落特效.js.htm'?>
</body>
</html>