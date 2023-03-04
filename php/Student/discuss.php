<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>个人中心</title>
    <meta name="description" content="数据库原理实验评判系统-在线评判和打分，提供成绩分析功能，节省教师时间成本和工作量">
    <meta name="keywords" content="数据库课程，实验，打分，成绩，统计">
    <link rel="shortcut icon" href="../../static/img/logo/logo.ico">
    <link rel="stylesheet" href="../../static/common/css/init.css">
    <link rel="stylesheet" href="../../static/common/Student/header.css">
    <link rel="stylesheet" href="../../css/Student/discuss.css">
    <script src="../../static/libraries/EventListene.js"></script>
    <script src="../../static/libraries/xhr.js"></script>
    <script src="../../js/Student/discuss.js"></script>
</head>

<body>
    <!-- 头部 -->
    <?php include '../../static/common/Student/header.html' ?>

    <!-- 讨论区主体 -->
    <section class="w main">
        <div class="discuss clearfix template" style="display: none;">
            <div class="left">
                <img src="../../static/img/head_pic.png" style="width: 50px; height: 50px;">
            </div>
            <div class="right" style="width: calc(100% - 100px);">
                <div><i class="user-name">name</i><i class="discuss-date">date</i></div>
                <pre class="discuss-text">讨论内容</pre>
            </div>
        </div>
    </section>
    <!-- 发表评论区 -->
    <section class="issue">
        <textarea id="" class="issue-textarea"></textarea>
        <div><i style="color: black;float: left;font-size: 12px;color: #ff6800;line-height: 1.5;">请勿粘贴答案，否则将造成账号禁用后果！</i><div class="send-discuss" style="float: right;color: rgb(255, 255, 255);padding: 0 12px;background: #0152d9;font-size: 14px;height: 30px;line-height: 30px;
border-radius: 2px;font-weight: 400;">发送</div></div>
        <div class="edit"><svg style="width: 50px;height: 50px;" t="1677310084549" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2390" width="200" height="200"><path d="M938.666667 832a42.666667 42.666667 0 0 1 4.992 85.034667L938.666667 917.333333H85.333333a42.666667 42.666667 0 0 1-4.992-85.034666L85.333333 832h853.333334zM625.877333 55.168L147.584 534.058667a42.666667 42.666667 0 0 0-12.458667 30.122666v168.277334a42.666667 42.666667 0 0 0 42.666667 42.666666H346.88a42.666667 42.666667 0 0 0 30.165333-12.501333L855.082667 284.416a42.666667 42.666667 0 0 0 0-60.330667l-168.832-168.917333a42.666667 42.666667 0 0 0-60.373334 0z m30.208 90.496l108.458667 108.544L329.173333 689.749333H220.416v-107.904L656.085333 145.664z" fill="#d81e06" p-id="2391"></path></svg></div>
    </section>
    
<?php
    include('../../static/common/php/footer.html');
?>