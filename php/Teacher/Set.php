<!DOCTYPE html>
<html lang="zh" xmlns:th="http://www.thymeleaf.org">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>账号管理</title>
    <meta name="description" content="数据库原理实验评判系统-在线评判和打分，提供成绩分析功能，节省教师时间成本和工作量">
    <meta name="keywords" content="数据库课程，实验，打分，成绩，统计">
    <link rel="shortcut icon" href="../../static/img/logo/logo.ico">
    <link rel="stylesheet" href="../../static/common/css/init.css">
    <link rel="stylesheet" href="../../static/common/Student/header.css">
    <link rel="stylesheet" href="../../css/Teacher/Set.css">
    <script src="../../static/libraries/EventListene.js"></script>
    <script src="../../js/Teacher/Set.js"></script>
</head>
<body>
    <?php include '../../static/common/Teacher/header.html';?>
    <!-- 登录页面 -->
    <div class="login_area-fa clearfix">
        <section class="login_area">
            <div class="login_hd clearfix">
                <div class="logo">
                    <img src="../../static/img/logo/logo.png" alt="">
                </div>
                <i>三体舰队欢迎尊上归来！</i>
            </div>
            <div class="login_bd">
                <form action="SetJudge.php" class="login_form" method="post">
                    <ul>
                        <li>
                            <label for="studentID">更改姓名</label> <em class="number-error" id="numberError"></em>
                            <br>
                            <input type="text" name="teaName" id="studentID" class="inp teaName" placeholder="选填，不填则不更改！" autocomplete="autocomplete">
                        </li>
                        <li>
                            <label for="studentPwd">更改密码</label> <em class="number-error" id="pwdError"></em>
                            <input type="password" name="teaPwd" id="studentPwd" class="inp teaPwd" placeholder="选填，不填则不更改！" autocomplete="autocomplete">
                            <span class="wrong_login">用户名或密码有误</span>
                        </li>
                        <li>
                            <button name="studentLogin">
                                <b class="login-register-button">保存</b>
                            </button>
                        </li>
                    </ul>
                </form>
            </div>
        </section>
        <section class="login_area-sibling">
            <div class="mask"></div>
            <h4>自然选择号欢迎您登舰！</h4>
        </section>
    </div>
<?php
    include('../../static/common/php/footer.html');
?>
