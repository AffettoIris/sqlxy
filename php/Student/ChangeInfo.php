<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>个人中心</title>
    <meta name="description" content="数据库原理实验评判系统-在线评判和打分，提供成绩分析功能，节省教师时间成本和工作量">
    <meta name="keywords" content="数据库课程，实验，打分，成绩，统计">
    <link rel="shortcut icon" href="../../static/img/logo/logo.ico">
    <link rel="stylesheet" href="../../static/common/css/init.css">
    <link rel="stylesheet" href="../../static/common/Student/header.css">
    <link rel="stylesheet" href="../../css/Student/changepwd.css">
    <script src="../../static/libraries/EventListene.js"></script>
    <script src="../../js/Student/changepwd.js"></script>
</head>

<body>
    <!-- 头部 -->
    <?php include '../../static/common/Student/header.html' ?>
    <!-- 主体 -->
    <section class="stuChangePwd">
        <div class="stuChangePwd_hd">
            <ul>
                <li>
                    <!-- 个人信息板块 -->
                    <span class="stuChangePwd_hd_span" id="personalInfo_nav" autofocus="autofocus"> 个人信息</span>
                    <div class="personalInfo">
                        <form action="ChangeInfoJud.php" method="post">
                            <ul>
                                <li>基本信息</li>
                                <li>
                                    <label for="name" style="font-family: 'icomoon';"> 姓名：</label>
                                    <input type="text" name="name" class="inp" id="username" autocomplete required>
                                </li>
                                <li>
                                    <input type="submit" value=" 保存" style="font-family: 'icomoon';">
                                </li>
                            </ul>
                        </form>
                    </div>
                </li>
                <li>
                    <!-- 安全板块 -->
                    <span class="stuChangePwd_hd_span" id="safety_nav"> 安全</span>
                    <div class="safety">
                        <form action="ChangeInfoJud.php" method="post">
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
                                    <input type="submit" id="submit_safety" value=" 保存" style="font-family: 'icomoon';">
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