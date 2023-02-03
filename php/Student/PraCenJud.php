<?php
    session_start();
    $studentId = $_SESSION['studentId'] ?? '';
// 接受typeid和dPage，返回前端以表格的内容。即题目。负责首页 上下页 尾页
    include '../../static/common/php/teaConn.php';
    $tConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $tConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $typeid= $_POST['typeid'] ?? '';
    $dPage= $_POST['dPage'] ?? '1';
    $option = $_POST['option'] ?? '';
    $amount = 10;
    if (!empty($typeid) && !empty($dPage) &&!empty($studentId) && $option === 'show') {
        try {
            $sql = <<<EOL
select * from sqlxy.`exercise` where status = 'usable' and `typeid` = $typeid and `id` not in (select distinct `exerciseid` from sqlxy.`answer` where `studentid` = '$studentId');
EOL;
            $result = $tConn->query($sql)->fetchAll();
            $resultPart = array_slice($result, ($dPage - 1) * $amount, $amount, true);
            foreach ($resultPart as $k=>$v) {
                $exerxiseId = $v['id'];
                echo "<tr data-id=\"$exerxiseId\">";
                    echo '<td>'.$v['title'].'</td>';
                    echo '<td>'.$v['description'].'</td>';
                    echo '<td>'.$v['score'].'</td>';
                    $teacherid =  $v['teacherid'];
                    $sql = "select * from sqlxy.`teacher` where id = $teacherid;";
                    $teaResult = $tConn->query($sql)->fetch();
                    echo '<td>'.$teaResult['name'].'</td>';
                    echo '<td>'.$v['reg_time'].'</td>';
                echo "</tr>";
            }  
        } catch (PDOException $e) {
            echo "加载题目数据时发生错误，请联系管理员！";
        }
    }

// 分页功能,传递共几页几条
    if (!empty($typeid) && !empty($dPage) && ($option === 'divide')) {
        $flag = false;
        $sql = <<<EOL
select * from sqlxy.`exercise` where status = 'usable' and `typeid` = $typeid and `id` not in (select distinct `exerciseid` from sqlxy.`answer` where `studentid` = '$studentId');
EOL;
        $result = $tConn->query($sql)->fetchAll();
        $data = array('countPage'=>ceil(count($result) / $amount), 'countData'=>count($result));
        echo json_encode($data);
    }


// 接受exerciseId和option，成立则生成该生答题页面，生成成功则告知前端跳转过去，否则告知失败
    $exerciseId = $_POST['exerciseId'] ?? '';
    $studentNumber = $_SESSION['studentNumber'] ?? '';
    $timestamp = $_POST['timestamp'] ?? '';
    if ($option === 'answer' && !empty($exerciseId) && !empty($studentNumber) && !empty($timestamp)) {
        try {
            if (!is_dir('../../temp/'.$studentNumber)) {
                mkdir('../../temp/'.$studentNumber, 0777, true);
            }
            $file = fopen('../../temp/'.$studentNumber.'/'.$timestamp.'.php', 'w+');
            fclose($file);
            $contents = <<<EOL
<?php include '../../php/Student/ExamTemplate.php'; ?>
EOL;
            file_put_contents('../../temp/'.$studentNumber.'/'.$timestamp.'.php', $contents);
            $arr = array("href"=>"../../temp/".$studentNumber."/".$timestamp.".php");
            echo json_encode($arr);
        } catch (Exception $e) {
            echo 'failed';
        }
    }
    $tConn = null;
?>