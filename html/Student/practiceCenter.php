<?php
session_start();
?>

<!DOCTYPE html>
<html lang="zh" xmlns:th="http://www.thymeleaf.org">

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
    <link rel="stylesheet" href="../../css/Student/practiceCenter.css">
    <script src="../../static/common/js/animate.js"></script>
    <script src="../../js/Student/practiceCenter.js"></script>
</head>

<body>
    <?php include '../../static/common/Student/header.html'?>
    <div th:replace="common::second_top"></div>
    <!-- 练习中心 -->
    <!-- 最大的外围黑色盒子 -->
    <section class="w practice_sort clearfix">
        <span class="cloud" id="cloud"></span>
        <ul>
            <li>Create</li>
            <li>Delete</li>
            <li>Read</li>
            <li>Update</li>
        </ul>
    </section>
    <section class="crud w">
        <ul>
            <li class="current">
                <ol class="test_set">
                    <li>
                        <span>测试1</span>
                        <span class="start_answer"><a href="create/create1.html" th:href="@{/exam/create/1}">开始答题</a></span>
                    </li>
                    <li>
                        <span>测试2</span>
                        <span class="start_answer"><a href="#">开始答题</a></span>
                    </li>
                    <li>
                        <span>测试3</span>
                        <span class="start_answer"><a href="#">开始答题</a></span>
                    </li>
                </ol>
            </li>
            <li>
                <ol class="test_set">
                    <li>
                        <span>测试1</span>
                        <span class="start_answer"><a href="delete/delete1.html" th:href="@{/exam/delete/1}">开始答题</a></span>
                    </li>
                </ol>
            </li>
            <li>
                <ol class="test_set">
                    <li>
                        <span>测试1</span>
                        <span class="start_answer"><a href="read/read1.html" th:href="@{/exam/read/1}">开始答题</a></span>
                    </li>
                </ol>
                <ol class="test_set">
                    <li>
                        <span>测试2</span>
                        <span class="start_answer"><a href="read/read1.html" th:href="@{/exam/read/2}">开始答题</a></span>
                    </li>
                </ol>
                <ol class="test_set">
                    <li>
                        <span>测试3</span>
                        <span class="start_answer"><a href="read/read1.html" th:href="@{/exam/read/3}">开始答题</a></span>
                    </li>
                </ol><ol class="test_set">
                    <li>
                        <span>测试4</span>
                        <span class="start_answer"><a href="read/read1.html" th:href="@{/exam/read/4}">开始答题</a></span>
                    </li>
                </ol><ol class="test_set">
                    <li>
                        <span>测试5</span>
                        <span class="start_answer"><a href="read/read1.html" th:href="@{/exam/read/5}">开始答题</a></span>
                    </li>
                </ol>


            </li>
            <li>
                <ol class="test_set">
                    <li>
                        <span>测试1</span>
                        <span class="start_answer"><a href="update/update1.html" th:href="@{/exam/update/1}">开始答题</a></span>
                    </li>
                </ol>
            </li>
        </ul>
    </section>
</body>

</html>