<?php
    include '../../static/common/php/adminConn.php';
    $studentNumber = $_POST['studentNumber'] ?? null; // 学生学号
    $studentPwd = $_POST['studentPwd'] ?? null; // 学生密码
    $choose = $_GET['choose'] ?? 'login'; // 选择：登录/注册

    if (isset($studentNumber) && isset($studentPwd)) {
    //    为防止SQL注入攻击，对学号检查是否纯数字且<=15位，
        if (!is_numeric($studentNumber) || (strlen($studentNumber) > 15)) {
            // 当时不知道ajax，用cookie传值，盲目了
            setcookie('number_error', '学号须纯数字，位数小于等于15位', time() + 60 * 2, '/');
            header("Location:StudentLogin.php");
            die();
        }

        setcookie('number_error', '', time() + 60 * 2, '/');

    //    如果密码长度小于6,大于16，脚本终止
        if (strlen($studentPwd) > 16 || strlen($studentPwd) < 6) {
            setcookie('pwd_error', '密码须6~16位，不能有单双引号或反斜杠', time() + 60 * 2, '/');
            header("Location:StudentLogin.php");
            die();
        }

    //    为防止SQL注入攻击，对密码检查是否包含单引号、双引号、转义字符
        if (substr_count($studentPwd, "'") || substr_count($studentPwd, '"') || substr_count($studentPwd, '\\')) {
            setcookie('pwd_error', '密码须6~16位，不能有单双引号或反斜杠', time() + 60 * 2, '/');
            header("Location:StudentLogin.php");
            die();
        }

        setcookie('pwd_error', '', time() + 60 * 2, '/');

        if ($choose == 'register') { // 学生选择了注册
            try {
                $aConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                $aConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $studentPwd = md5($studentPwd); // md5加密密码
                $sql = "insert into sqlxy.`student` (`number`, `password`, `name`) values ('$studentNumber', '$studentPwd', '$studentNumber');";
                $aConn->exec($sql);
                $message = '注册'.$studentNumber.'成功';
                echo "<script>alert(\"$message\")</script>";
    //       重定向，经测试，要想alert，不能用header("Location:");不显示弹窗，不知道是不是离开的太快弹窗没跟上。
                header("refresh:0.5;url=StudentLogin.php");
            } catch (PDOException $e) {
                echo "<script>alert('注册失败,可能是该账号已注册');</script>";
                header("refresh:0.5;url=StudentLogin.php");
            }
        } elseif ($choose == 'login') { // 学生选择登录
            try {
                $aConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                $aConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $studentPwd = md5($studentPwd);
                $sql = "select * from sqlxy.`student` where `number` = '".$studentNumber."' and `password` = '".$studentPwd."';";
                $result = $aConn->query($sql)->fetch();
    //            $aConn->query($sql)->fetch()查得到返回结果组成的数组，反之bool(false)
                if ($result) {
                    session_start();
                    $_SESSION['studentId'] = $result['id']; // 设置学生id的Session
                    $_SESSION['studentNumber'] = $studentNumber; // 设置学生学号的Session
                    $_SESSION['studentName'] = $result['name']; // 设置学生姓名的Session
                    $message = '登录'.$studentNumber.'成功,将自动跳转主页';
                    echo "<script>alert(\"$message\")</script>";
                    header("refresh:0.5;url=../Student/Home.php"); // 重定向
                } else {
                    $message = '登陆失败，请检查账号或密码';
                    echo "<script>alert(\"$message\")</script>";
                    header("refresh:0.3;url=StudentLogin.php");
                }
            } catch (PDOException $e) {
                $message = $e->getMessage();
                echo "<script>alert(\"登录失败 \" + \"$message\");</script>";
                header("refresh:0.5;url=StudentLogin.php");
            }
        }
    } else {
        header("Location:StudentLogin.php");
    }
    $aConn = null;
?>
