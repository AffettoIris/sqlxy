<?php
    session_start();
    $operation = $_POST['operation'] ?? '';
    $studentId = $_SESSION['studentId'] ?? '';
    $studentNumber = $_SESSION['studentNumber'] ?? '';
    $exerciseId = $_POST['exerciseId'] ?? '';

// 接受前端发来的加载页面请求，返回题目内容
    if ($operation === 'load' && !empty($studentNumber) && !empty($exerciseId)) {
        try {
            include '../../static/common/php/stuConn.php';
            $sConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $sConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = <<<EOL
select * from sqlxy.`exercise` where `id` = '$exerciseId';
EOL;
            $result = $sConn->query($sql)->fetch();
            $arr = array('title'=>$result['title'], "description"=>$result['description'], "keyword"=>$result['keyword'], "init"=>$result['init']);
            echo json_encode($arr, JSON_UNESCAPED_UNICODE);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

// 接受前端发来的答案，然后判定，返回结果
    $sAnswer = $_POST['sAnswer'] ?? '';
    $timestamp = $_POST['timestamp'] ?? '';
    if ($operation === 'answer' && !empty($sAnswer) && !empty($exerciseId) && !empty($timestamp)) {
        try {
            $determine = execute($exerciseId, $sAnswer, $timestamp);
            if ($determine=== 'right') {
                echo '答案正确！';
            } elseif ($determine === 'wrong') {
                echo '答案错误！';
            }
        } catch (PDOException $e) {
//            dropTable($sConn, $tableName[1]); // 这儿其实不方便删表，万一在生成$tableName[1]之前脚本就报错，这儿就没$tableName变量。暂时无视。
            echo $e->getMessage();
        }
    }

// 接受前端发来的提交请求，准备向数据库answer表插入，返回得分
    if ($operation === 'submit' && !empty($sAnswer) && !empty($exerciseId) && !empty($timestamp) && !empty($studentId)) {
        try {
            try {
                $determine = execute($exerciseId, $sAnswer, $timestamp);
            } catch (PDOException $e) {
                $determine = 'exception';
            }
            // 根据$exerciseId去查找题目的总分
            $sql = <<<EOL
select `score` from sqlxy.`exercise` where `id` = '$exerciseId';
EOL;
            $score = $sConn->query($sql)->fetch()['score'];
            // 还需要对solution中出现的单引号前缀转义符
            $sAnswer = str_replace("'", "\\'", $sAnswer);
            if ($determine=== 'right') {
                $sql = <<<EOL
insert into sqlxy.`answer` (studentid, exerciseid, solution, score) values ('$studentId', '$exerciseId', '$sAnswer', '$score');
EOL;
                $GLOBALS['sConn']->exec($sql);
                echo json_encode(["score"=>"得分：".$score, "msg"=>"提交成功！"], JSON_UNESCAPED_UNICODE);
            } elseif ($determine === 'wrong' || $determine === 'exception') {
                $sql = <<<EOL
insert into sqlxy.`answer` (studentid, exerciseid, solution, score) values ('$studentId', '$exerciseId', '$sAnswer', '0');
EOL;
                $sConn->exec($sql);
                echo json_encode(["score"=>"得分：".'0', "msg"=>"提交成功！"], JSON_UNESCAPED_UNICODE);
            }
        } catch (PDOException $e) {
            echo json_encode(["score"=>"", "msg"=>"提交失败！"], JSON_UNESCAPED_UNICODE);
        }
    }

    function execute($exerciseId, $sAnswer, $timestamp) : string | int {
        include '../../static/common/php/stuConn.php';
        include 'JudgeAuto.php';
        global $sConn;
        $sConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $sConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = <<<EOL
select * from sqlxy.`exercise` where `id` = '$exerciseId';
EOL;
        $info = $sConn->query($sql)->fetch();
        $typeId = $info['typeid'];
        $init = $info['init'];
        $tResult = $info['tresult'];
        $tableName = '';
        $determine = judgeAuto($typeId, $sConn, $init, $sAnswer, $timestamp, $tResult, $tableName);
        dropTable($sConn, $tableName[1]);
        return $determine;
    }

    $sConn = null;
?>