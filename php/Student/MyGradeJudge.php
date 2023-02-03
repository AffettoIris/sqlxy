<?php
    session_start();
    $studentId = $_SESSION['studentId'] ?? '';
    $title = $_POST['title'] ?? null;
    $description = $_POST['description'] ?? null;
    $keyword = $_POST['keyword'] ?? null;
    $typeid = $_POST['typeid'] ?? null;
    $score = $_POST['score'] ?? null;
    $answer = $_POST['answer'] ?? null;
    $hiddenId = $_POST['hiddenId'] ?? null;
    $qInit = $_POST['q_init'] ?? null; // $qInit是建表框被表单提交时的值。下面的$init是建表框被点击执行按钮时，被ajax提交的值
    $operation = $_POST['operation'] ?? '';
    $sAnswer = $_POST['sAnswer'] ?? '';
    $exerciseId = $_POST['exerciseId'] ?? '';
    $timestamp = $_POST['timestamp'] ?? '';

//    接受dPage参数以查询题目后显示在页面上，负责首页 上下页 尾页
    $dPage = $_POST['dPage'] ?? '1';
    $option = $_POST['option'] ?? '';
    $amount = 10;
    if (!empty($dPage) && ($option === 'show') && !empty($studentId)) {
        try {
            $arrPart = getArrayPart($dPage, $amount, $studentId)[0];
            $typeName = ['null' ,'INSERT', 'DELETE', 'SELECT', 'UPDATE'];
            // 上面从数据库拿到教师的id，下面根据id找到老师姓名
            $teacherIds = array();
            foreach ($arrPart as $k=>$v) {
                $teacherIds[] = $v['teacherid'];
            }
            // 数组去除重复值
            $teacherIds = array_unique($teacherIds);
            $teacherIds = implode(', ', $teacherIds);
            if (empty($teacherIds)) {
                $teacherIds = '-1'; // 当学生没做过题时，$teacherIds是''，这样会破坏下方的SQl语句
            }
            $sql = <<<EOL
select id, name from sqlxy.`teacher` where id in ($teacherIds);
EOL;
            $temp = $tConn->query($sql)->fetchAll();
            // 把二维数组$tNames的值提取成一维数组，用id对于name形式
            $tNames = [];
            foreach ($temp as $v) {
                foreach ($v as $value) {
                    $tNames[$v['id']] = $v['name'];
                    break;
                }
            }
            unset($temp);
            // 修改二维数组$arrPart，在里面填上name键值对和分类键值对
            foreach ($arrPart as $k=>$v) {
                $arrPart[$k]['name'] = $tNames[$v['teacherid']];
                $arrPart[$k]['typename'] = $typeName[$v['typeid']];
                // 发现一个问题，在这儿打印$v是有后加的两个键值对，但是出去打印$arrPart是没有的，why?
            }
            echo json_encode($arrPart, JSON_UNESCAPED_UNICODE);
        } catch (PDOException $e) {
            echo "加载题目数据时发生错误，请联系管理员！";
        }
    }

    //    分页功能,传递第几页共几页几条
    if (!empty($dPage) && ($option === 'divide')) {
        $temp = getArrayPart($dPage, $amount, $studentId);
        $data = array('countPage'=>ceil($temp[1] / $amount), 'countData'=>$temp[1]);
        echo json_encode($data);
    }

//  接受前端发来的显示题目详情的请求，返回json
    if ($operation === 'exhibit' && !empty($studentId) && !empty($exerciseId)) {
        try {
            include '../../static/common/php/teaConn.php';
            $tConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $tConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = <<<EOL
    select * from sqlxy.`exercise` where `id` = '$exerciseId';
    EOL;
            $result = $tConn->query($sql)->fetch();
            $arr = array("title"=>$result['title'], "description"=>$result['description'], "keyword"=>$result['keyword'], "init"=>$result['init'], "answer"=>$result["answer"]);
            $sql = <<<EOL
select sqlxy.`answer`.`solution` from sqlxy.`answer` where `exerciseid` = '$exerciseId' and `studentid` = '$studentId';
EOL;
            $result = $tConn->query($sql)->fetch();
            $arr["solution"] = $result['solution'];
            echo json_encode($arr, JSON_UNESCAPED_UNICODE);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

//  执行答案
    if ($operation === 'answer' && !empty($sAnswer) && !empty($exerciseId) && !empty($timestamp)) {
        try {
            $determine = execute($exerciseId, $sAnswer, $timestamp);
            if ($determine=== 'right') {
                echo '答案正确！';
            } elseif ($determine === 'wrong') {
                echo '答案错误！';
            }
        } catch (PDOException $e) {
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
    update sqlxy.`answer` set `solution` = '$sAnswer' , `score` = '$score' where `studentid` = '$studentId' and `exerciseid` = '$exerciseId';
    EOL;
                $GLOBALS['sConn']->exec($sql);
                echo json_encode(["score"=>"得分：".$score, "msg"=>"提交成功！"], JSON_UNESCAPED_UNICODE);
            } elseif ($determine === 'wrong' || $determine === 'exception') {
                $sql = <<<EOL
    update sqlxy.`answer` set `solution` = '$sAnswer' , `score` = '0' where `studentid` = '$studentId' and `exerciseid` = '$exerciseId';
    EOL;
                $sConn->exec($sql);
                echo json_encode(["score"=>"得分：".'0', "msg"=>"提交成功！"], JSON_UNESCAPED_UNICODE);
            }
        } catch (PDOException $e) {
            echo json_encode(["score"=>"", "msg"=>"提交失败！"], JSON_UNESCAPED_UNICODE);
        }
    }

    // 这段代码仅本页就重复两次
    function getArrayPart($dPage, $amount, $studentId) : array {
        include '../../static/common/php/teaConn.php';
        global $tConn; // 全局变量，方便在外边被使用
        $tConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $tConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // 为了防止这段代码跑崩了，导致视图建立了，但没删掉，视图名取随机值
        $viewName = 'envxy.' . '`xy_view'.strtotime(date("Y-m-d H:i:s")) . '`';
        $sql = <<<EOL
create view $viewName as select  sqlxy.`exercise`.`id`, sqlxy.`exercise`.`title`, sqlxy.`exercise`.`typeid`, sqlxy.`exercise`.`teacherid`, sqlxy.`exercise`.`reg_time`, 
sqlxy.`answer`.`score`, sqlxy.`answer`.`date`, sqlxy.`answer`.`studentid` from sqlxy.`exercise` right join sqlxy.`answer` on  sqlxy.`exercise`.`id` = sqlxy.`answer`.`exerciseid`;
EOL;
        $tConn->query($sql);
        $sql = <<<EOL
select * from $viewName where `studentid` = '$studentId';
EOL;
        $arr = $tConn->query($sql)->fetchAll();
        // 三串SQl语句还是得分开写啊，之前三串语句合在一个$sql里，运行倒不报错，就是fetch取不到值
        $sql = <<<EOL
drop view $viewName;
EOL;
        $tConn->exec($sql);
        return [array_slice($arr, ($dPage - 1) * $amount, $amount), count($arr)];
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

    $tConn = null;
?>