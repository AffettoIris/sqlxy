<?php
    $teaName = $_POST['teaName'] ?? null;
    $teaPwd = $_POST['teaPwd'] ?? null;
    $option = $_POST['option'] ?? null;

    if ($option) {
        if ($option === 'judgeName') {
            if (strlen($teaName) > 39) {
                echo "姓名位数需要小于13位";
            }
        } elseif ($option === 'judgePwd') {
            if (strlen($teaPwd) > 16 || ((strlen($teaPwd) < 6) && (strlen($teaPwd) > 0))) {
                echo "密码须6~16位";
            }
        }
    } else {
        if (isset($teaName) || isset($teaPwd)) {
            judgeName($teaName);
            judgePwd($teaPwd);
            try {
                session_start();
                include '../../static/common/php/teaConn.php';
                $tConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                $tConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $teacherId = $_SESSION['teacherId'] ?? 1;
                $sql = <<<EOL
    update sqlxy.`teacher` set `id` = '$teacherId' 
    EOL;
                if (!empty($teaName)) {
                    $sql .= ", `name` = '$teaName'";
                }
                if (!empty($teaPwd)) {
                    // 老师密码没有md5()加密
                    $sql .= ", `password` = '$teaPwd'";
                }
                $sql .= "where `id` = '$teacherId';";
                $tConn->exec($sql);
                $message = '保存成功！';
                echo "<script>alert(\"$message\")</script>";
                header("refresh:0.5;url=Set.php");
            } catch (PDOException $e) {
                $message = $e->getMessage();
                echo "<script>alert(\"$message\");</script>";
                header("refresh:0.5;url=Set.php");
            }
        }
    }

    function judgeName($teaName) {
        if (strlen($teaName) > 13) {
            echo "<script>alert(\"姓名位数需要小于13位\")</script>";
            header("refresh:0.3;url=Set.php");
            die();
        }
    }

    function judgePwd($teaPwd) {
        //    如果密码长度小于6,大于16，脚本终止
        if (strlen($teaPwd) > 16 || ((strlen($teaPwd) < 6) && (strlen($teaPwd) > 0))) {
            echo "<script>alert(\"密码须6~16位\")</script>";
            header("refresh:0.3;url=Set.php");
            die();
        }
    }

$tConn = null;
?>
