<?php
    include '../../static/common/php/teaConn.php';
    include '../../static/common/php/ajaxserver.php';
    $number = $_POST['number'] ?? '';
    $type = $_REQUEST['type'] ?? 'search';
//    数据库也有个password，不要重名
    $pwd = $_POST['password'] ?? '';
    $name = $_POST['name'] ?? '';

    if (empty($number) || strlen($name) > 20) {
        echo "<script>alert(\"更改失败，请检查输入是否合法\")</script>";
        header('refresh:0.3;url=UserCenter.php');
        die();
    }
    if ($type === 'search') {
        try {
            include '../../static/common/php/adminConn.php';
            $tConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $tConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "select * from sqlxy.`student` where `number` = ".$number.";";
            $result = $tConn->query($sql)->fetch();
            if ($result) {
                echo "该生姓名为".$result['name'].'（姓名默认值等于学号）';
                die();
            } else {
                echo '查无此人';
                die();
            }
        } catch (PDOException $e) { }
    } else {
        if (empty($name) && empty($pwd)) {
            header('Location:UserCenter.php');
            die();
        }
        try {
            $tConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $tConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $result = $tConn->query("select * from sqlxy.`student` where number  = '".$number."';")->fetch();
            if (!$result) {
                echo "<script>alert(\"查无此人\")</script>";
                header('refresh:0.3;url=UserCenter.php');
                die();
            }
            if (strlen($pwd) > 16 || ((strlen($pwd) < 6) && (strlen($pwd) > 0)) || (strlen($pwd) < 0)) {
                echo "<script>alert(\"密码须6~16位\")</script>";
                header('refresh:0.3;url=UserCenter.php');
                die();
            }
            $sql = "update sqlxy.`student` set `reg_time` = reg_time";
            if (!empty($pwd)) {
                $pwd = md5($pwd);
                $sql .= ", `password` = '".$pwd."'";
            }
            if (!empty($name)) {
                $sql .= ", name = '".$name."'";
            }
            $sql .= " where number = '".$number."';";
            $tConn->exec($sql);
            header('Content-Type:text/html;charset=utf-8');
            echo "<script>alert(\"更改成功\")</script>";
            header('refresh:0.3;url=UserCenter.php');
        } catch (PDOException $e) {
            echo "<script>alert(\"更改失败！\")</script>";
            header('refresh:0.3;url=UserCenter.php');
            header('refresh:0.3;url=UserCenter.php');
        }
    }
    $tConn = null;
?>