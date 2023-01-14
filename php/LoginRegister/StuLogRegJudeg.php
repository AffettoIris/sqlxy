<?php
$servername = 'localhost';
$username = 'root';
$password = 'PYthon123@';
$dbname = 'sqlxy';
$studentNumber = $_POST['studentNumber'] ?? null;
$studentPwd = $_POST['studentPwd'] ?? null;
$choose = $_GET['choose'] ?? 'login';

if (isset($studentNumber) && isset($studentPwd)) {
//    为防止SQL注入攻击，对学号检查是否纯数字且<=15位，
    if (!is_numeric($studentNumber) || (strlen($studentNumber) > 15)) {
        setcookie('number_error', '学号须纯数字，位数小于等于15位', time() + 60 * 2, '/');
        header("Location:../../html/LoginRegister/StudentLogin.php");
        die();
    }

    setcookie('number_error', '', time() + 60 * 2, '/');

//    如果密码长度小于6,大于16，脚本终止
    if (strlen($studentPwd) > 16 || strlen($studentPwd) < 6) {
        setcookie('pwd_error', '密码须6~16位，不能有单双引号或反斜杠', time() + 60 * 2, '/');
        header("Location:../../html/LoginRegister/StudentLogin.php");
        die();
    }

//    为防止SQL注入攻击，对密码检查是否包含单引号、双引号、转义字符
    if (substr_count($studentPwd, "'") || substr_count($studentPwd, '"') || substr_count($studentPwd, '\\')) {
        setcookie('pwd_error', '密码须6~16位，不能有单双引号或反斜杠', time() + 60 * 2, '/');
        header("Location:../../html/LoginRegister/StudentLogin.php");
        die();
    }

    setcookie('pwd_error', '', time() + 60 * 2, '/');

    if ($choose == 'register') {
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $studentPwd = md5($studentPwd);
            $sql = "insert into `student` (`number`, `password`, `name`) values ('$studentNumber', '$studentPwd', '$studentNumber');";
            $conn->exec($sql);
            $message = '注册'.$studentNumber.'成功,将自动跳转登录页面';
            echo "<script>alert(\"$message\")</script>";
//       重定向，经测试，要想alert，不能用header("Location:");不显示弹窗，不知道是不是离开的太快弹窗没跟上。
            header("refresh:0.5;url=../../html/LoginRegister/StudentLogin.php");
        } catch (PDOException $e) {
//        $error = PHP_EOL.$e->getMessage();
//        尝试把$error输出到alert（）里，结果报错信息带单引号，把我单引号闭包了
            echo "<script>alert('注册失败,可能是该账号已注册,将自动跳转登录页面');</script>";
            header("refresh:0.5;url=../../html/LoginRegister/StudentLogin.php");
        }
    } elseif ($choose == 'login') {
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $studentPwd = md5($studentPwd);
            $sql = "select * from student where `number` = '".$studentNumber."' and `password` = '".$studentPwd."';";
            $result = $conn->query($sql)->fetch();
//            $conn->query($sql)->fetch()查得到返回结果组成的数组，反之bool(false)
            if ($result) {
                session_start();
                $_SESSION['studentNumber'] = $studentNumber;
                $message = '登录'.$studentNumber.'成功,将自动跳转主页';
                echo "<script>alert(\"$message\")</script>";
                header("refresh:0.5;url=../../html/Student/home.php");
            } else {
                $message = '登陆失败，请检查账号或密码';
                echo "<script>alert(\"$message\")</script>";
                header("refresh:0.3;url=../../html/LoginRegister/StudentLogin.php");
            }
        } catch (PDOException $e) {
            $message = $e->getMessage();
            echo "<script>alert(\"登录失败\" + \"$message\");</script>";
            header("refresh:0.5;url=../../html/LoginRegister/StudentLogin.php");
        }
    }
} else {
    header("Location:../../html/LoginRegister/StudentLogin.php");
}
$conn = null;
?>
