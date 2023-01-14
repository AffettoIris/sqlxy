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
    <link rel="stylesheet" href="../../static/common/css/css初始化代码.css">
    <link rel="stylesheet" href="../../static/common/Student/header.css">
    <link rel="stylesheet" href="../../css/Teacher/Issue.css">
    <script src="../../js/Teacher/Issue.js"></script>
</head>

<body>
<!-- 教师端就不做防SQL注入了，都是自己人，不做了。但是要判空 -->
    <?php include '../../static/common/Teacher/header.php';?>
    <div th:replace="common::teacher_top"></div>
    <!-- 发布题目页面 -->
    <section class="w questionsManageMain">
        <button class="jiahao"><strong style="font-size: 24px;">+</strong> &nbsp;&nbsp;&nbsp;新增题目</button>
        <br><br>
        <table class="q_table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>题目分类</th>
                    <th>题目标题</th>
                    <th>得分</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody class="tbody">
                <tr>
                    <td>1</td>
                    <td>create</td>
                    <td>增加学生</td>
                    <td>10</td>
                    <td>
                        <button>删除</button>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>delete</td>
                    <td>删除学生年龄</td>
                    <td>10</td>
                    <td>
                        <button>删除</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- 翻页按钮 -->
        <div class="fanye_fa">
            <button class="fanye">1</button>
        </div>
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
                <form action="" class="q_form" id="q_form">
                    <!-- 表单的第一块 -->
                    <div class="form_one">
                        <label class="q_field__label">题目标题</label>
                        <input type="text" class="q_field__native" name="qTitle" required>
                        <label class="q_detail_label" style="margin: 20px 0 10px;">题目详情</label>
                        <textarea name="q_detail" id="q_detail" class="qDetail" cols="30" rows="10" required></textarea>
                        <label class="q_field__label" for="qKeys">答案关键词</label>
                        <input type="text" class="q-keys" name="qKeys">
                        <label for="" class="q_sort_label" style="margin: 20px 0 10px;">题目分类</label>
                        <select type="number" class="qSort" name="q_sort">
                            <option>CREATE</option>
                            <option>DELETE</option>
                            <option>READ</option>
                            <option>UPDATE</option>
                        </select>
                        <label for="" class="q_score_label" style="margin: 20px 0 10px;">得分</label>
                        <input type="number" class="qScore" required>
                    </div>
                    <!-- 表单的第二块 -->
                    <div class="form_two">
                        <textarea name="qInit" id="q_init" class="q_init" cols="30" rows="10" required></textarea>
                        <button class="exec">执行</button>
                    </div>
                    <!-- 表单的第三块 -->
                    <div class="form_third">
                        <textarea name="qAnswer" id="q_answer" class="q_answer" cols="30" rows="10" required></textarea>
                </div>
                <!-- 表单尾巴，取消和确定 -->
                <!-- 我弄了个删除按钮的浅实现：点击删除按钮能在当前页面不显示该题目， -->
                <!-- 但咱的数据库数据没变，html文件的结构也没变。所以我后来想了下， -->
                <!-- 这页面应该是动态的从数据库里读取题目才对，所以等秋后我很可能会重构删除按钮的内部实现 -->
                <div class="tail">
                    <button name="tail_cancel" class="tail_cancel" id="tail_cancel">取消</button>
                    <input type="submit" value="确定" name="tail_sure">
                </div>
                </form>
            </div>
        </div>


    </div>
</body>

</html>