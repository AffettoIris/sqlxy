<?php
$name = $_POST['name'] ?? '';
$comment = $_POST['comment'] ?? '';
$operation = $_POST['operation'] ?? '';

// 插入评论
if (!empty($name) && !empty($comment)) {
    try {
        include '../../static/common/php/stuConn.php';
        $sConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $sConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $comment = str_replace("'", "\\'", $comment);
        $name = str_replace("'", "\\'", $name);
        $sql = <<<EOL
insert into sqlxy.`discuss` (`name`, `content`) values ('$name', '$comment');
EOL;
        $sConn->exec($sql);
        echo json_encode(["code"=>1], JSON_UNESCAPED_UNICODE); // code=1代表插入成功，code=0代表插入失败
    } catch (PDOException $e) {
        echo json_encode(["code"=>0, "msg"=>$e->getMessage()], JSON_UNESCAPED_UNICODE);
    }
}

// 查询评论
if ($operation === 'load') {
    try {
        include '../../static/common/php/stuConn.php';
        $sConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $sConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = <<<EOL
select * from sqlxy.`discuss`;
EOL;
        $result = $sConn->query($sql)->fetchAll();
        $result['code'] = 1; // code=1代表查询成功
        $result['length'] = count($result) + 1;
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    } catch (PDOException $e) {
        echo json_encode(["code"=>0, "msg"=>$e->getMessage()], JSON_UNESCAPED_UNICODE);
    }
}

$sConn = null;