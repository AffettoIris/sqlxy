<?php
    session_start();
    $studentNumber = $_SESSION['studentNumber'];
    $name = $_POST['name'] ?? '';
    $originalpwd = $_POST['originalpwd'] ?? '';
    $newpwd = $_POST['newpwd'] ?? '';
    $surepwd = $_POST['surepwd'] ?? '';
    include '../../static/common/php/stuConn.php';
    $sConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $sConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!empty($name) && !empty($studentNumber)) {

        if (strlen($name) > 39) {
            $message = "姓名位数需要小于13位，不能有单双引号或反斜杠！";
            echo "<script>alert(\"$message\")</script>";
            header("refresh:0.3;url=ChangeInfo.php");
            die();
        }    

        if (substr_count($name, "'") || substr_count($name, '"') || substr_count($name, '\\')) {
            $message = "姓名位数需要小于13位，不能有单双引号或反斜杠！";
            echo "<script>alert(\"$message\")</script>";
            header("refresh:0.3;url=ChangeInfo.php");
            die();
        }

        try {
            $sql = <<<EOL
update sqlxy.`student` set `name` = '$name' where `number` = '$studentNumber';
EOL;
            $sConn->exec($sql);
            $message = '成功修改姓名！';
            $_SESSION['studentName'] = $name;
            echo "<script>alert(\"$message\")</script>";
            header("refresh:0.3;url=ChangeInfo.php");
        } catch (PDOException $e) {
            $message = '未能修改姓名！';
            echo "<script>alert(\"$message\")</script>";
            header("refresh:0.3;url=ChangeInfo.php");
        }
    }

    if (!empty($originalpwd) && !empty($newpwd) && !empty($surepwd) && !empty($studentNumber)) {

        if($newpwd != $surepwd) {
            $message = "新密码与确认密码不一致";
            echo "<script>alert(\"$message\")</script>";
            header("refresh:0.3;url=ChangeInfo.php");
            die();
        }

        if (strlen($originalpwd) > 16 || strlen($newpwd) > 16 || strlen($surepwd) > 16 || strlen($originalpwd) < 6 || strlen($newpwd) < 6 || strlen($surepwd) < 6) {
            $message = "密码须6~16位，不能有单双引号或反斜杠！";
            echo "<script>alert(\"$message\")</script>";
            header("refresh:0.3;url=ChangeInfo.php");
            die();
        }    

        if (substr_count($originalpwd, "'") || substr_count($originalpwd, '"') || substr_count($originalpwd, '\\')) {
            $message = "密码须6~16位，不能有单双引号或反斜杠！";
            echo "<script>alert('$message')</script>";
            header("refresh:0.3;url=ChangeInfo.php");
            die();
        }

        if (substr_count($newpwd, "'") || substr_count($newpwd, '"') || substr_count($newpwd, '\\')) {
            $message = "密码须6~16位，不能有单双引号或反斜杠！";
            echo "<script>alert(\"$message\")</script>";
            header("refresh:0.3;url=ChangeInfo.php");
            die();
        }

        if (substr_count($surepwd, "'") || substr_count($surepwd, '"') || substr_count($surepwd, '\\')) {
            $message = "密码须6~16位，不能有单双引号或反斜杠！";
            echo "<script>alert(\"$message\")</script>";
            header("refresh:0.3;url=ChangeInfo.php");
            die();
        }

        try {
            $sql = "select `password`	 from sqlxy.`student` where `number` = '$studentNumber';";
            $result = $sConn->query($sql)->fetch();
            if ($result['password'] != md5($originalpwd)) {
                $message = '错误的旧密码！';
                echo "<script>alert(\"$message\")</script>";
                header("refresh:0.3;url=ChangeInfo.php");
                die();
            }
        } catch (PDOException $e) {
            $message = '未能修改密码！';
            echo "<script>alert(\"$message\")</script>";
            header("refresh:0.3;url=ChangeInfo.php");
        }

        try {
            $password = md5($newpwd);
            $sql = <<<EOL
update sqlxy.`student` set `password` = '$password' where `number` = '$studentNumber';
EOL;
            $sConn->exec($sql);
            $message = '成功修改密码！';
            echo "<script>alert(\"$message\")</script>";
            header("refresh:0.3;url=ChangeInfo.php");
        } catch (PDOException $e) {
            $message = '未能修改密码！';
            echo "<script>alert(\"$message\")</script>";
            header("refresh:0.3;url=ChangeInfo.php");
        }
    }

    $sConn = null;
?>