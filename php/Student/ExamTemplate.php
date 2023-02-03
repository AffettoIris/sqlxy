<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="shortcut icon" href="../../static/img/logo/logo.ico">
    <link rel="stylesheet" href="../../static/common/css/init.css">
    <link rel="stylesheet" href="../../static/common/Student/header.css">
    <link rel="stylesheet" href="../../css/Student/ExamTemplate.css">
    <script src="../../static/common/js/animate.js"></script>
    <script src="../../static/libraries/EventListene.js"></script>
    <script src="../../static/libraries/window.onbeforeunload.js"></script>
    <script src="../../static/libraries/xhr.js"></script>
    <script src="../../js/Student/ExamTemplate.js"></script>
</head>

<body>
    <header style="background-color: rgba(256, 256, 256, 0.5);">
        <div class="home_top w clearfix">
            <div class="logo">
                <h1>
                    <a href="../../php/Student/Home.php" title="数据库原理实验评判系统">数据库原理实验评判系统</a>
                </h1>
            </div>
            <span class="SQL">SQLXY</span>
            <ul>
                <li><a href="../../php/Student/Home.php">首页</a></li>
                <li><a href="../../php/Student/PracticeCenter.php" class="lianxizhongxin">练习中心</a></li>
                <li><a href="../../php/Student/MyGrades.php" class="wodechengji">我的成绩</a></li>
            </ul>
            <div class="header_service">
                <!-- 当用户未登录时进入页面，studentNumber，用抑错符，免得影响布局-->
                <a href="javascript:;" class="welcomeYou">welcome <i><?php session_start();echo @$_SESSION['studentNumber']; ?></i></a>
                <a href="../../php/Student/ChangeInfo.php" class="changepwd">设置</a>
                <a href="../../index.html" class="goToLogin">退出登录</a>
            </div>
        </div>
    </header>
<!--  主体  -->
    <section class="exam_main clearfix">
        <div class="left">
            <h1 class="title"></h1>
            <hr>
            <pre style="display: block;"><p class="description"></p></pre>
            <hr>
            <div>
                <h2 style="padding: 10px 10px 0;">题目环境</h2>
                <pre style="display: block;"><div class="env" style="padding: 10px 10px;"></div></pre>
            </div>
            <hr>
            <div class="keyword clearfix">
                <div class="key-son1">关键词</div>
                <div class="key-son2"></div>
            </div>
        </div>
        <div class="right">
            <div class="implement_SQL clearfix">
                <p>SQL执行</p>
                <div class="daima_box clearfix">
                    <textarea name="receive_code" class="receive_code" cols="30" rows="10"></textarea>
                    <button class="submit">提交</button>
                    <button class="zhixingBtn">执行</button>
                </div>
            </div>
            <!-- 感觉显示报错信息比较麻烦，现统一将执行结果显示在下面的栏里 -->
            <div class="implement_result">
                <p>执行结果</p>
                <div class="result_content">
                    <!-- 我想让执行结果框，没有内容时有默认高度，有内容时随内容自动适应高度 -->
                    <!-- 想不出来，姑且用换行产生高度吧 -->
                    <br>
                </div>
            </div>
        </div>
        <div class="X">X</div>
        <!-- 当用户点提交时，弹窗，询问确定吗？ -->
        <div class="query">
            <div>
                <h2>您是否确认提交？</h2>
                <br>
                <button class="query-submit">提交</button>
                <button class="query-cancel">取消</button>
            </div>
        </div>
    </section>
</body>

</html>