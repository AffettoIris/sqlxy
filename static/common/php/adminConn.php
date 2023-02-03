<?php
// 权限分配：
//student对sqlxy.answer all privilege、对envxy all privilege;
//teacher 对sqlxy.answer和sqlxy.exercise和envxy all privilege
//admin 对sql.* env.*的all
// 注意，写的SQL代码要区分操作哪个库。
    $host = '47.115.218.216';
    $username = 'admin';
    $password = 'zhang134679'; 
    $dbname = 'sqlxy';
//    $aConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
//    $aConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>