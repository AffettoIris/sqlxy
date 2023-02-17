<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户管理</title>
    <meta name="description" content="数据库原理实验评判系统-在线评判和打分，提供成绩分析功能，节省教师时间成本和工作量">
    <meta name="keywords" content="数据库课程，实验，打分，成绩，统计">
    <link rel="shortcut icon" href="../../static/img/logo/logo.ico">
    <link rel="stylesheet" href="../../static/common/css/init.css">
    <link rel="stylesheet" href="../../static/common/Student/header.css">
    <link rel="stylesheet" href="../../css/Teacher/UserCenter.css">
    <script src="../../static/libraries/EventListene.js"></script>
    <script src="../../js/Teacher/UserCenter.js"></script>
</head>

<body>
    <?php include '../../static/common/Teacher/header.html';?>
<!--  老师给学生改密码改姓名，学号就不改了，不然怎么定位到学生账号  -->
    <section class="newstudents">
        <div class="newstudents_hd">
            <h3>管理学生</h3>
        </div>
        <form action="UserCenterJudge.php?type=insert" method="post">
            <ul>
                <li style="position: relative">
                    <label for="newstuID">学号：</label><input type="text" class="inp" id="newstuID" name="number" required>
                    <input type="text" disabled class="nameHint" value="">
                </li>
                <li>
                    <label for="changehispwd">更改该生密码：</label><input type="password" class="inp" id="changehispwd" name="password"
                        placeholder="选填，不填则不会更改密码">
                    <br> <span id="pwdError" style="color: red;font-size: 1em;line-height: calc(1em + 2px);margin-left: 100px;display: none;">密码须6~16位</span>
                </li>
                <li>
                    <label for="changehisname">更改该生姓名：</label><input type="text" class="inp" id="changehisname" name="name"
                        placeholder="选填，不填则不会更改姓名" autocomplete="">
                </li>
                <li>
                    <input type="submit" name="over" value="修改学生信息" class="over" id="over">
                </li>
            </ul>
        </form>
    </section>
<?php
    include('../../static/common/php/footer.html');
?>