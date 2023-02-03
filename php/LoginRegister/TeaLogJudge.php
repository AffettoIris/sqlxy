<?php
include '../../static/common/php/adminConn.php';
$teacherName = $_POST['teacherNumber'] ?? null;
$teacherPwd = $_POST['teacherPwd'] ?? null;

if (isset($teacherName) && isset($teacherPwd)) {
    if ((strlen($teacherName) > 20 || substr_count($teacherName, "'") || substr_count($teacherName, '"') || substr_count($teacherName, '\\'))) {
        setcookie('number_error', '教师名须位数小于等于20位，不限中英文，不能有单双引号或反斜杠', time() + 60 * 2, '/');
        header("refresh:0.5;url=TeacherLogin.php");
        die();
    }
    setcookie('number_error', '', time() + 60 * 2, '/');

//    如果密码长度小于6,大于16，脚本终止
    if (strlen($teacherPwd) > 16 || strlen($teacherPwd) < 6) {
        setcookie('pwd_error', '密码须6~16位，不带单双引号或反斜杠', time() + 60 * 2, '/');
        header("refresh:0.5;url=TeacherLogin.php");
        die();
    }

//    为防止SQL注入攻击，对密码检查是否包含单引号、双引号、转义字符
    if (substr_count($teacherPwd, "'") || substr_count($teacherPwd, '"') || substr_count($teacherPwd, '\\')) {
        setcookie('pwd_error', '密码须6~16位，不带单双引号或反斜杠', time() + 60 * 2, '/');
        header("refresh:0.5;url=TeacherLogin.php");
        die();
    }
    setcookie('pwd_error', '', time() + 60 * 2, '/');

    try {
        $aConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $aConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "select * from sqlxy.`teacher` where `name` = '".$teacherName."' and `password` = '".$teacherPwd."';";
        $result = $aConn->query($sql)->fetch();
//            $aConn->query($sql)->fetch()查得到返回结果组成的数组，反之bool(false)
        if ($result) {
            session_start();
            $_SESSION['teacherName'] = $teacherName;
            $_SESSION['teacherId'] = $result['id'];
            $message = '登录'.$teacherName.'成功';
            echo "<script>alert(\"$message\")</script>";
            header("refresh:0.5;url=../Teacher/ExerciseCenter.php");
        } else {
            $message = '登陆失败，请检查账号或密码';
            echo "<script>alert(\"$message\")</script>";
            header("refresh:0.5;url=TeacherLogin.php");
        }
    } catch (PDOException $e) {
        $message = $e->getMessage();
        echo "<script>alert(\"登录失败\" + \"$message\");</script>";
        header("refresh:0.5;url=TeacherLogin.php");
    }
} else {
    header("refresh:0.5;url=TeacherLogin.php");
}
$aConn = null;
?>