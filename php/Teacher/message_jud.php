<?php
    $operation = $_POST['operation'] ?? '1';
    if (!empty($operation)) {
        try {
            include '../../static/common/php/teaConn.php';
            $tConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $tConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql1 = <<<EOL
select count(`typeid`) from sqlxy.`exercise` where `typeid` = 1;
EOL;
            $sql2 = <<<EOL
            select count(`typeid`) from sqlxy.`exercise` where `typeid` = 2;
            EOL;
            $sql3 = <<<EOL
            select count(`typeid`) from sqlxy.`exercise` where `typeid` = 3;
            EOL;
            $sql4 = <<<EOL
            select count(`typeid`) from sqlxy.`exercise` where `typeid` = 4;
            EOL;
            $result1 = $tConn->query($sql1)->fetch()[0];
            $result2 = $tConn->query($sql2)->fetch()[0];
            $result3 = $tConn->query($sql3)->fetch()[0];
            $result4 = $tConn->query($sql4)->fetch()[0];
            $response = json_encode(["insert"=>$result1, "delete"=>$result2, "select"=>$result3, "update"=>$result4], JSON_UNESCAPED_UNICODE);
            echo $response;
        } catch (PDOException $e) {
            echo $e->getMessage();
            echo $e->getLine();
        }
    } 
?>