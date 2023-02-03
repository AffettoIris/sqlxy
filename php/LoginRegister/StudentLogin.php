<?php
    $number_error = $_COOKIE['number_error'] ??  '';
    $pwd_error = $_COOKIE['pwd_error'] ?? '';
?>

<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>学生 - 登录</title>
    <meta name="description" content="数据库原理实验评判系统-在线评判和打分，提供成绩分析功能，节省教师时间成本和工作量">
    <meta name="keywords" content="数据库课程，实验，打分，成绩，统计">
    <link rel="shortcut icon" href="../../static/img/logo/logo.ico">
    <link rel="stylesheet" href="../../static/common/css/init.css">
    <link rel='stylesheet' href="../../static/common/LoginRegister/header.css">
    <link rel="stylesheet" href="../../css/LoginRegister/StudentLogin.css">
    <script src="../../static/libraries/EventListene.js"></script>
    <script src="../../js/LoginRegister/StudentLogin.js"></script>
</head>

<body>
    <!-- 成功后通向home.html,失败则停留本页面。 -->
    <?php
        include('../../static/common/LoginRegister/header.html');
    ?>
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
                <form action="StuLogRegJudeg.php?choose=login" class="login_form" method="post">
                    <ul>
                        <li>
                            <label for="studentID"> 学号</label> <em class="number-error" id="numberError"><?php echo $number_error ?></em>
                            <br>
                            <input type="text" name="studentNumber" id="studentID" class="inp" required="required" autocomplete="autocomplete">
                        </li>
                        <li>
                            <label for="studentPwd"> 密码</label> <br> <em class="number-error" id="pwdError"><?php echo $pwd_error ?></em>
                            <input type="password" name="studentPwd" id="studentPwd" class="inp" required="required" autocomplete="autocomplete">
                            <span class="wrong_login">用户名或密码有误</span>
                        </li>
                        <li>
                            <input type="checkbox" name="agree_cbx" required>
                            <em class="agree">同意登录</em>
                        </li>
                        <li>
                            <button name="studentLogin">
                                <span class="icon1"></span>
                                <b class="login-register-button">登录</b>
                            </button>
                        </li>
                    </ul>
                </form>
            </div>
        </section>
        <section class="login_area-sibling">
            <div class="mask"></div>
            <h4>自然选择号欢迎您登舰！</h4>
            <p class="login_area-sibling-p">如果您没有账号，您现在想要注册一个吗？</p>
            <button class="switch-btn">注册</button>
        </section>
    </div>
    <script src="../../static/common/js/dancing_ribbon.js"></script>
</body>

</html>