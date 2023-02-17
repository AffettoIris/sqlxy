<!DOCTYPE html>
<html lang="zh" xmlns:th="http://www.thymeleaf.org">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>练习中心</title>
    <meta name="description" content="数据库原理实验评判系统-在线评判和打分，提供成绩分析功能，节省教师时间成本和工作量">
    <meta name="keywords" content="数据库课程，实验，打分，成绩，统计">
    <link rel="shortcut icon" href="../../static/img/logo/logo.ico">
    <link rel="stylesheet" href="../../static/common/css/init.css">
    <link rel="stylesheet" href="../../static/common/Student/header.css">
    <link rel="stylesheet" href="../../css/Student/practiceCenter.css">
    <script src="../../static/common/js/animate.js"></script>
    <script src="../../static/libraries/EventListene.js"></script>
    <script src="../../js/Student/practiceCenter.js"></script>
</head>

<body>
    <!-- 这个页面还有两个需求，一是点击题目任意地方，location.href到答题页面，二是做过的题目显示色不同，参照学习通 -->
    <!-- 其次需要提示或者显式告诉用户点击tr即可答题 -->
    <?php include '../../static/common/Student/header.html' ?>
    <!-- 最大的外围黑色盒子 -->
    <section class="w practice_sort clearfix">
        <span class="cloud" id="cloud"></span>
        <ul>
            <li>INSERT</li>
            <li>DELETE</li>
            <li>SELECT</li>
            <li>UPDATE</li>
        </ul>
    </section>
    <section class="w questionsManageMain">
        <table class="q_table">
            <thead>
                <tr>
                    <th>题目标题</th>
                    <th>题目描述</th>
                    <th>总分</th>
                    <th>出题教师</th>
                    <th>创建日期</th>
                </tr>
            </thead>
            <tbody class="tbody">
            </tbody>
        </table>
        <!-- 翻页按钮 -->
        <ul class="fan-ye">
            <li>当前第<i id="dPage"></i>页/共<i id="countPage"></i>页/共<i id="countData"></i>条数据</li>
            <li id="firstPage">首页</li>
            <li id="prePage">上一页</li>
            <li id="lastPage">下一页</li>
            <li id="endPage">尾页</li>
        </ul>
    </section> -->
<?php
    include('../../static/common/php/footer.html');
?>