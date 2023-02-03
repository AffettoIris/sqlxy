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
    <?php include '../../static/common/Student/header.html' ?>
    <!-- 练习中心,分左（第几题）右（第N题详情） -->
    <div class="exam_main clearfix">
        <div class="left">
            <h1 class="title"></h1>
            <hr>
            <p class="description"></p>
            <hr>
            <div>
                <h2>题目环境</h2>
                <div class="env"></div>
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
</body>

</html>