<?php
    session_start();
    include '../../static/common/php/ajaxserver.php';
    $title = $_POST['title'] ?? null;
    $description = $_POST['description'] ?? null;
    $keyword = $_POST['keyword'] ?? null;
    $typeid = $_POST['typeid'] ?? null;
    $score = $_POST['score'] ?? null;
    $answer = $_POST['answer'] ?? null;
    $qInit = $_POST['q_init'] ?? null; // $qInit是建表框被表单提交时的值。下面的$init是建表框被点击执行按钮时，被ajax提交的值

    //  测试发现悬浮框先提交，然后再分页查询，处理分页查询的后端不会有悬浮窗提交的数据，因为两次擎起了两个页面，所以不是同一个后端页面
//    向表插入题目数据
    if (isset($title) && isset($description) && isset($keyword) && isset($typeid) && isset($score) && isset($answer) &&isset($qInit)) {
        try {
            include '../../static/common/php/teaConn.php';
            $tConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $tConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $teacherId = $_SESSION['teacherId'] ?? 1; // 当用户未登录进入出题页面时，默认用id=1的教师号
            // 下面获取执行老师的答案，得到的答案，将作为结果的二维数组json化，即作为字符串可存入数据库。
            $tResult = createDropTable($tConn, $qInit, $answer)['tResult'];
            // 其实，与其两个单引号来表达一个单引号，还不如用转义符\，单双引号都能转移，功能强大且方便
            $qInit = str_replace('\'', '\'\'', $qInit);
            $answer = str_replace('\'', '\'\'', $answer);
            $description = str_replace('\'', '\\\'', $description);
            $title = str_replace('\'', '\\\'', $title);
            $keyword = str_replace('\'', '\\\'', $keyword);
            $sql = <<<EOL
insert into sqlxy.`exercise` (`description`, `title`, `answer`, `keyword`, `score`, `teacherid`, `typeid`, `init`, `tresult`, `status`) values ('$description', '$title', '$answer',
 '$keyword', '$score', '$teacherId', '$typeid', '$qInit', '$tResult', 'usable');
EOL;
            $tConn->exec($sql);
            echo '<script>alert("您成功添加新题目！");</script>';
            header('refresh:0.3;url=Issue.php');
        } catch (PDOException $e) {
            $msg = $e->getMessage();
            echo "<script>alert(\"哎呀，出错了！\" + \"$msg\");</script>";
            header('refresh:0.3;url=Issue.php');
        }
    }

//    接受dPage参数以查询题目后显示在页面上，负责首页 上下页 尾页
    $dPage = $_POST['dPage'] ?? '1';
    $option = $_POST['option'] ?? '';
    $amount = 10;
    if (!empty($dPage) && ($option === 'show')) {
        try {
            include '../../static/common/php/teaConn.php';
            $tConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $tConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "select * from sqlxy.`exercise`  where `status` = 'usable';";
            $arr = $tConn->query($sql)->fetchAll();
            $arrPart = array_slice($arr, ($dPage - 1) * $amount, $amount);
            $typeName = ['null' ,'INSERT', 'DELETE', 'SELECT', 'UPDATE'];
            for ($i = 0; $i < count($arrPart); $i++) {
                $dataId = $arrPart[$i]['id'];
                echo "<tr data-id=\"$dataId\">";
                echo '<td class="ellipsis">'.$arrPart[$i]['title'].'</td>';
                echo '<td>'.$typeName[$arrPart[$i]['typeid']].'</td>';
                echo '<td>'.$arrPart[$i]['score'].'</td>';
                echo '<td>'.$arrPart[$i]['reg_time'].'</td>';
                echo '<td><button>删除</button></td>';
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
            $sql = <<<EOL
delete from sqlxy.`exercise` where `id` = '$delete';
EOL;
            $tConn->exec($sql);
        } catch (PDOException $e) {
            // 没想好如果报错了怎么反馈，就先不反馈了吧
            echo $e->getMessage();
        }
    }

//    为题目建表
    // 表中没有name='init'的表单，所以上述题目初始化 和 插入数据不互影响，即每次只会执行一2段代码
    $init = $_POST['init'] ?? '';
//    下方代码弃用，原本是准备的老师可以较自由地执行sql语句，包括增删查改建表删表，但一是回滚失败导致bug太多，二是现在改思路：只允许老师create table
//    if (!empty($init)) {
//        include '../../static/common/php/ajaxserver.php';
//        try {
//            include '../../static/common/php/teaConn.php';
//            $tConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
//            $tConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//            // 最新发现，写类SQL语句(delete update insert)要用exec()执行，读类操作(select)用query（）才能fetch()，
//            // 否则会发生主从读写错乱的情况。报错：SQLSTATE[HY000]: General error
//            // 解决：try里嵌套try，内层try，先query（），执行失败转到内存catch里执行exec（）。
//            // 若语句是错误语句，会从内层catch那儿报错，被外层catch到
//            try {
//                $tConn->beginTransaction();
//                if (!substr_count(strtolower($init), 'select')) {
//                    $tConn->exec($init);
//                    $tConn->commit();
//                    echo '执行成功！';
//                } else {
//                    throw new PDOException("代码包含select，需要改用query()方法来执行。");
//                }
//            } catch (PDOException $e) {
//                // 上段执行失败了一定要回滚，不然比如insert，会被执行两遍
//                $tConn->rollBack();
//                $tConn->beginTransaction();
//                $result = $tConn->query($init)->fetchAll();
//                $tConn->commit();
//                // 由于当不含select时，$result为空，不能打印。匹配语句是否包含select单词，要不区分大小写
//                if (substr_count(strtolower($init), 'select') && $result) {
//                    foreach ($result[0] as $k=>$v) {
//                        if (!is_numeric($k)) {
//                            echo $k."\t";
//                        }
//                    }
//                    for ($i = 0; $i < count($result); $i++) {
//                        echo "\n";
//                        for ($j = 0; $j < (count($result[$i]) / 2); $j++) {
//                            echo $result[$i][$j]."  ";
//                        }
//                    }
//                } else {
//                    echo '执行成功！';
//                }
//            }
//        } catch (PDOException $e) {
//            $tConn->rollBack();
//            echo "错误的SQL语句，系统已回滚\n".$e->getMessage();
//        }
//    }
    if (!empty($init)) {
        try {
            include '../../static/common/php/teaConn.php';
            $tConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $tConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // $init = str_replace('\'', '\'\'', $init); 这儿不用将单引号克隆一份，我是直接exec($sql)！不是insert into values ('$sql')
            // 如果上行代码加上了，我将exec(insert into test1 values(''1''););
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

    $tConn = null;
?>