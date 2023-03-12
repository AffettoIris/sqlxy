<?php
    session_start();
    $operation = $_POST['operation'] ?? '';
    $id = $_POST['id'] ?? '';
    $title = $_POST['title'] ?? null;
    $description = $_POST['description'] ?? null;
    $keyword = $_POST['keyword'] ?? null;
    $typeid = $_POST['typeid'] ?? null;
    $score = $_POST['score'] ?? null;
    $answer = $_POST['answer'] ?? null;
    $hiddenId = $_POST['hiddenId'] ?? null;
    $qInit = $_POST['q_init'] ?? null; // $qInit是建表框被表单提交时的值。下面的$init是建表框被点击执行按钮时，被ajax提交的值

//    向表修改题目数据
    if (isset($title) && isset($description) && isset($keyword) && isset($typeid) && isset($score) && isset($answer) && isset($hiddenId) &&isset($qInit)) {
        try {
            include '../../static/common/php/teaConn.php';
            $tConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $tConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $teacherId = $_SESSION['teacherId'] ?? 1; // 当用户未登录进入出题页面时，默认用id=1的教师号
            // 有一种恰好，老师停留在题目管理页面，题目还没人做，显示编辑，期间某学生做题了，题目应该成查看，但老师不刷新就不知道，会导致编辑成功。
            $sql = "select `id` from sqlxy.`answer` where `exerciseid` = '$hiddenId';";
            $temp = $tConn->query($sql)->fetch();
            if ($temp) { // 查不到东西fetch()会返回false
                throw new PDOException('该题已经有学生做过啦！不方便修改呦~');
            }
            $tResult = createDropTable($tConn, $qInit, $answer)['tResult'];
            // SQL语句中极可能带有英文单引号，而且不能过滤。SQL中连续两个单引号，不会引起单引号包闭，而且作为一个单引号被插入数据库
            // 注意，将被exec()和quer()的SQL语句不要一个单引号替换成两个，比如createDropTable()的后两个参数。
            // 作为values时再替换。
            $qInit = str_replace('\'', '\\\'', $qInit);
            $answer = str_replace('\'', '\\\'', $answer);
            $description = str_replace('\'', '\\\'', $description);
            $title = str_replace('\'', '\\\'', $title);
            $keyword = str_replace('\'', '\\\'', $keyword);
            $sql = <<<EOL
    update sqlxy.`exercise` set `description` = '$description', `title`='$title', `answer`='$answer', `keyword`='$keyword', `score`='$score', `typeid`='$typeid', `reg_time`=reg_time, `init`='$qInit',`tresult`='$tResult' where `id` = '$hiddenId';
    EOL;
            $tConn->exec($sql);
            echo '<script>alert("您已成功编辑题目！");</script>';
            header('refresh:0.3;url=ExerciseCenter.php');
        } catch (PDOException $e) {
            $msg = $e->getMessage();
            echo "<script>alert(\"哎呀，出错了！\" + \"$msg\");</script>";
            header('refresh:0.3;url=ExerciseCenter.php');
        }
    }

//    接受dPage参数以查询题目后显示在页面上，负责 刚加载 首页 上下页 尾页
    $dPage = $_POST['dPage'] ?? '1';
    $option = $_POST['option'] ?? '';
    $amount = 10;
    if (!empty($dPage) && ($option === 'show')) {
        try {
            include '../../static/common/php/teaConn.php';
            $tConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $tConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "select * from sqlxy.`exercise` where `status` = 'usable';";
            $arr = $tConn->query($sql)->fetchAll();
            $arrPart = array_slice($arr, ($dPage - 1) * $amount, $amount);
            $typeName = ['null' ,'INSERT', 'DELETE', 'SELECT', 'UPDATE'];
            $sql = "select `id`, `name` from sqlxy.`teacher`"; // 用于从exerciseid转成教师名
            $temp = $tConn->query($sql)->fetchAll();
            $teacherName = []; // 教师名组成的数组
            for ($i = 0; $i < count($temp); $i++) {
                $teacherName[$temp[$i]['id']] = $temp[$i]['name'];
            }
            $sql = "select distinct sqlxy.answer.`exerciseid` from sqlxy.`answer`;";
            $temp = $tConn->query($sql)->fetchAll();
            $doneExerciseId = [];
            for ($i = 0; $i < count($temp); $i++) {
                $doneExerciseId[] = $temp[$i]['exerciseid'];
            }
            for ($i = 0; $i < count($arrPart); $i++) {
                $dataId = $arrPart[$i]['id'];
                echo "<tr data-id=\"$dataId\">";
                echo '<td class="ellipsis">'.$arrPart[$i]['title'].'</td>';
                echo '<td>'.$typeName[$arrPart[$i]['typeid']].'</td>';
                echo '<td>'.$arrPart[$i]['score'].'</td>';
                echo '<td>'.$teacherName[$arrPart[$i]['teacherid']].'</td>';
                echo '<td>'.$arrPart[$i]['reg_time'].'</td>';
                // answer表中有记录的练习题，只可查看；answer表中无记录的练习题，可编辑；
                if (in_array($arrPart[$i]['id'], $doneExerciseId)) {
                    echo '<td><button class="edit">查看</button></td>';
                } else {
                    echo '<td><button class="edit">编辑</button></td>';
                }
                echo '<td><button class="del">删除</button></td>';
                echo '</tr>';
            }
        } catch (PDOException $e) {
            echo "加载题目数据时发生错误，请联系管理员！";
        }
    }

//    分页功能,传递第几页共几页几条
    if (!empty($dPage) && ($option === 'divide')) {
        include '../../static/common/php/teaConn.php';
        $tConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $tConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "select * from sqlxy.`exercise`  where `status` = 'usable';";
        $arr = $tConn->query($sql)->fetchAll();
        $arrPart = array_slice($arr, ($dPage - 1) * $amount, $amount, true);
        $data = array('countPage'=>ceil(count($arr) / $amount), 'countData'=>count($arr));
        echo json_encode($data);
    }

//    后端的删除操作
    $delete = $_POST['delete'] ?? '';
    if (!empty($delete)) {
        try {
            include '../../static/common/php/teaConn.php';
            $tConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $tConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // 下方的SQl语句不要忘了加上timestamp列，不然时间会被更新
            $sql = <<<EOL
    update sqlxy.`exercise` set `status` = 'unusable', `reg_time` = reg_time  where `id` = '$delete';
    EOL;
            $tConn->exec($sql);
        } catch (PDOException $e) {
            // 没想好如果报错了怎么反馈，就先不反馈了吧
        }
    }

//    题目初始化
    // 表中没有name='init'的表单，所以上述题目初始化 和 插入数据不互影响，即每次只会执行一2段代码
    $init = $_POST['init'] ?? '';
    if (!empty($init)) {
        try {
            include '../../static/common/php/teaConn.php';
            $tConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $tConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            createDropTable($tConn, $init);
            echo '该语句可以被正常执行！';
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

// 该函数，给予连接的数据库和将被执行的SQl建表语句，执行该SQl语句后drop table，第三个参数可选，
// 用于在drop前执行另一种（insert delete update select）SQL语句，随后select整个表。函数返回数组，值分别是参数二建表的表名和参数三的查询结果。
    function createDropTable($conn, $createSql, $answer = ''): array | bool {
        // 正则表达式，create前匹配0次或多次空格，table前后匹配至少一次空格，随后匹配至少一次的非空格字符（即表名），
        preg_match("{ *[cC][rR][eE][aA][tT][eE] +[tT][Aa][bB][lL][Ee] +[^ ]+}", $createSql, $matches);
        if (count($matches) === 0) {
            throw new PDOException("输入不合规矩！");
            return false; // 所匹配不到，数组$matches是空数组，不支持非建表的语句哦！
        }
        $arr = explode(' ',$matches[0]); // 用分隔符空格切割字符串成数组
        $tableName = end($arr); // 数组的最后一个值就是表名
        $tempTableName = 'xy'.strtotime(date("Y-m-d H:i:s"));
        $createSql = str_replace($tableName, $tempTableName, $createSql);
        $conn->exec($createSql);
        $tResult = '';
        if (!empty($answer)) {
            try {
                $answer = str_replace($tableName, $tempTableName, $answer);
                $conn->query($answer);
            } catch (PDOException $e) {
                throw new PDOException('无法执行正确答案的SQL语句！'.$e->getMessage());
            }
            $tResult = $conn->query("select * from $tempTableName;")->fetchAll();
            // fetchAll()会把同一行记录，记录两次，一个保留其键，一个从0排序其键。不过这儿无所谓。
            $tResult = json_encode($tResult, JSON_UNESCAPED_UNICODE);
        }
        $conn->exec("drop table $tempTableName;");
        return ["tableName"=>$tableName, "tResult"=>$tResult];
    }

//    将指定id的题目的数据传给前端以展示，方便老师编辑
    $display = $_POST['display'] ?? 'false';
    $exerciseId = $_POST['exerciseId'] ?? '';
    if (!empty($display) && $exerciseId) {
        try {
            include '../../static/common/php/teaConn.php';
            $tConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $tConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "select * from sqlxy.`exercise` where id = '".$exerciseId."';";
            $content = $tConn->query($sql)->fetch();
            echo json_encode($content);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

//  接收到前端发来的operation=statistics就返回该题的已答题中的满分人数占总答题人数
    if (!empty($id) && $operation === 'statistics') {
        try {
            include '../../static/common/php/teaConn.php';
            $tConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $tConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql1 = <<<EOL
            select count(`id`) from sqlxy.`answer` where `score` = 0 and `exerciseid` = '$id';
EOL;
            $sql2 = <<<EOL
            select count(`id`) from sqlxy.`answer` where `exerciseid` = '$id';
EOL;
            $result1 = $tConn->query($sql1)->fetch()[0];
            $result2 = $tConn->query($sql2)->fetch()[0];
            echo json_encode(['full'=>intval($result2) - intval($result1), 'zero'=>intval($result1)]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    $tConn = null;
?>