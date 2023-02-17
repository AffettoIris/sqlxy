<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>我的成绩</title>
    <meta name="description" content="数据库原理实验评判系统-在线评判和打分，提供成绩分析功能，节省教师时间成本和工作量">
    <meta name="keywords" content="数据库课程，实验，打分，成绩，统计">
    <link rel="shortcut icon" href="../../static/img/logo/logo.ico">
    <link rel="stylesheet" href="../../static/common/css/init.css">
    <link rel="stylesheet" href="../../static/common/Student/header.css">
    <link rel="stylesheet" href="../../css/Student/ExamTemplate.css">
    <link rel="stylesheet" href="../../css/Student/myGrades.css">
    <script src="../../static/common/js/animate.js"></script>
    <script src="../../static/libraries/EventListene.js"></script>
    <script src="../../static/libraries/xhr.js"></script>
    <script src="../../js/Student/myGrades.js"></script>
</head>

<body>
    <!-- 头部 -->
    <?php include '../../static/common/Student/header.html' ?>
    <!-- 主体 -->
    <section class="w questionsManageMain">
        <table class="q_table">
            <thead>
            <tr>
                <th>题目标题</th>
                <th>题目分类</th>
                <th>出题教师</th>
                <th>得分</th>
                <th>创建日期</th>
                <th>答题日期</th>
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
    </section>
<!-- 详情页面 -->
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
            <br> <hr>
            <div class="implement_result">
                <p>标准答案</p>
                <pre><div class="tea-answer">
                    <br>
                </div></pre>
            </div>
        </div>
        <div class="right">
            <div class="implement_SQL clearfix">
                <p>您的答案</p>
                <div class="daima_box clearfix">
                    <textarea name="receive_code" class="receive_code" cols="30" rows="10"></textarea>
                    <button class="submit">重新提交</button>
                    <button class="zhixingBtn">执行</button>
                </div>
            </div>
            <div class="implement_result">
                <p>执行结果</p>
                <div class="result_content">
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
<?php
    include('../../static/common/php/footer.html');
?>