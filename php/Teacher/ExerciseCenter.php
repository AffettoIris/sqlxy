<!DOCTYPE html>
<html lang="zh" xmlns:th="http://www.thymeleaf.org">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>题目管理</title>
    <meta name="description" content="数据库原理实验评判系统-在线评判和打分，提供成绩分析功能，节省教师时间成本和工作量">
    <meta name="keywords" content="数据库课程，实验，打分，成绩，统计">
    <link rel="shortcut icon" href="../../static/img/logo/logo.ico">
    <link rel="stylesheet" href="../../static/common/css/init.css">
    <link rel="stylesheet" href="../../static/common/Student/header.css">
    <link rel="stylesheet" href="../../css/Teacher/ExerciseCenter.css">
    <script src="../../static/libraries/EventListene.js"></script>
    <script src="../../static/common/js/echarts.min.js"></script>
    <script src="../../js/Teacher/ExerciseCenter.js"></script>
</head>
<body>
<!-- 教师端就不做防SQL注入了，都是自己人，不做了。但是要判空 -->
<?php include '../../static/common/Teacher/header.html';?>
<!-- 主体 -->
<section class="w questionsManageMain">
    <table class="q_table">
        <thead>
        <tr>
            <th>题目标题</th>
            <th>题目分类</th>
            <th>满分</th>
            <th>作者</th>
            <th>创建日期</th>
            <th>操作</th>
            <th>操作</th>
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
    <!-- 删除成功遮罩 -->
    <div class="deleteMsg"></div>
</section>
<!-- 定义遮罩 -->
<div class="mask">
    <div class="question_info_fa w clearfix">
        <!-- 左盒子 -->
        <div class="question_info_left">
            <ul class="question_info_left_ul">
                <li class="question_info_current">基本信息</li>
                <li>为题目建表</li>
                <li>标准答案</li>
            </ul>
        </div>
        <!-- 右盒子 -->
        <div class="question_info_right" id="question_info_right">
            <form action="ExerciseJudge.php" class="q_form" id="q_form" method="post">
                <!-- 表单的第一块 -->
                <div class="form_one">
                    <label class="q_field__label" for="title">题目标题</label>
                    <input type="text" class="q_field__native" name="title" required placeholder="请勿将英文的单双引号或反斜杠输入本页面">
                    <label class="q_detail_label" style="margin: 20px 0 10px;" for="description">题目详情</label>
                    <textarea name="description" id="q_detail" class="qDetail" cols="30" rows="10" required></textarea>
                    <label class="q_field__label" for="keyword">答案关键词</label>
                    <input type="text" class="q-keys" name="keyword" required>
                    <label for="typeid" class="q_sort_label" style="margin: 20px 0 10px;">题目分类</label>
                    <select type="number" class="qSort" name="typeid">
                        <option value="1">INSERT</option>
                        <option value="2">DELETE</option>
                        <option value="3">SELECT</option>
                        <option value="4">UPDATE</option>
                    </select>
                    <label for="score" class="q_score_label" style="margin: 20px 0 10px;">得分</label>
                    <input type="number" class="score" name="score" required>
                    <!-- input:hidden，传递题目的id -->
                    <input type="hidden" id="hiddenId" name="hiddenId">
                </div>
                <!-- 表单的第二块 -->
                <div class="form_two">
                    <textarea id="q_init" class="q_init" name="q_init" style="line-height: 20px;height: 50vh;" required placeholder="请老师在此输入create table和insert into values语句以搭建题目环境,输入至少需带有create table语句，否则无法正确评判答案！本题目仅支持在单表操作！"></textarea>
                    <input type="button" class="exec" value="执行"><br>
                    <pre><textarea disabled class="result">执行结果将展示在这里！</textarea></pre>
                </div>
                <!-- 表单的第三块 -->
                <div class="form_third">
                    <textarea name="answer" id="q_answer" class="answer" style="line-height: 20px;height: 50vh;width: 100%;resize: none;" required></textarea>
                </div>
                <div class="tail">
                    <input type="button" class="tail_cancel" id="tail_cancel" value="取消">
                    <input type="submit" class="submit" value="提交">
                </div>
            </form>
        </div>
    </div>
</div>
<div class="statistics"></div>
<div class="x">X</div>
<?php
    include('../../static/common/php/footer.html');
?>
