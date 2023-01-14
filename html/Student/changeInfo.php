<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>修改密码</title>
    <meta name="description" content="数据库原理实验评判系统-在线评判和打分，提供成绩分析功能，节省教师时间成本和工作量">
    <meta name="keywords" content="数据库课程，实验，打分，成绩，统计">
    <link rel="shortcut icon" href="../static/images/logo.ico">
    <link rel="stylesheet" href="../static/css/css初始化代码.css">
    <link rel="stylesheet" href="../static/css/common.css">
    <link rel="stylesheet" href="../static/css/changepwd.css">
    <script src="../static/javascript/changepwd.js"></script>
</head>

<body>
    <!-- 头部 -->
    <header>
        <div class="home_top w clearfix">
            <div class="logo">
                <h1>
                    <a href="home.php" title="数据库原理实验评判系统">数据库原理实验评判系统</a>
                </h1>
            </div>
            <span class="SQL">SQL</span>
            <ul>
                <li><a href="home.php">首页</a></li>
                <li><a href="practiceCenter.php" class="lianxizhongxin">练习中心</a></li>
                <li><a href="myGrades.php" class="wodechengji">我的成绩</a></li>
                <li><a href="collectedQuestions.php">收藏·错题集</a></li>
            </ul>
            <div class="header_service">
                <a href="javascript:;" class="welcomeYou">welcome <i>学号</i></a>
                <a href="changepwd.html" class="changepwd">账号设置</a>
                <a href="../../index.html" class="goToLogin">退出登录</a>
            </div>
        </div>
    </header>
    <!-- 添加一个返回按钮，改密后回到home.html -->
    <!-- 要改密码、改姓名（因为没人看学号知道叫什么名字）、密保问题和答案，
    密保是方便忘记密码，又不想麻烦老师改密 
    密码还要确认一次-->
    <section class="stuChangePwd">
        <div class="stuChangePwd_hd">
            <ul>
                <li>
                    <!-- 个人信息板块 -->
                    <span class="stuChangePwd_hd_span" id="personalInfo_nav" autofocus="autofocus"> 个人信息</span>
                    <div class="personalInfo">
                        <form action="home.php">
                            <ul>
                                <li>基本信息</li>
                                <li>
                                    <label for="username" style="font-family: 'icomoon';"> 姓名：</label>
                                    <input type="text" name="username" class="inp" id="username" autocomplete required>
                                </li>
                                <li>
                                    <input type="submit" name="submit_personalInfo" value=" 保存" style="font-family: 'icomoon';">
                                </li>
                            </ul>
                        </form>
                    </div>
                </li>
                <li>
                    <!-- 安全板块 -->
                    <span class="stuChangePwd_hd_span" id="safety_nav"> 安全</span>
                    <div class="safety">
                        <form action="home.php">
                            <ul>
                                <li>修改密码</li>
                                <li>
                                    <label for="originalpwd" style="font-family: 'icomoon';"> 原密码：</label>
                                    <input type="password" name="originalpwd" class="inp" id="originalpwd" required>
                                </li>
                                <li>
                                    <label for="newpwd" style="font-family: 'icomoon';"> 新密码：</label>
                                    <input type="password" name="newpwd" class="inp" id="newpwd" required placeholder="请输入6~16位新密码">
                                    <span class="check_pwd" name="newpwd_check" id="newpwd_check">密码 必须>=6个字符且<=16个字符</span>
                                </li>
                                <li>
                                    <label for="surepwd" style="font-family: 'icomoon';"> 确认密码：</label>
                                    <input type="password" name="surepwd" class="inp" id="surepwd" required placeholder="请输入6~16位新密码">
                                    <span class="check_pwd" id="surepwd_check">密码 必须和 确认密码 一致</span>
                                </li>
                                <li>
                                    <input type="submit" name="submit_safety" id="submit_safety" value=" 保存" style="font-family: 'icomoon';">
                                </li>
                            </ul>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </section>
</body>

</html>