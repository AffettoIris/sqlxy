<?php
    try {
        $servername = 'localhost';
        $username = 'root';
        $password = 'PYthon123@';
        $dbname = 'sqlxy';
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//        建库sqlxy
//        $sql = "create database sqlxy";
//        $conn->exec($sql);
//        echo '数据库创建成功'.PHP_EOL;

//        建表student
//        $sql = "create table `student` (
//                `id` int(6) unsigned auto_increment primary key,
//                `number` int(15) not null unique,
//                `password` varchar(256) not null ,
//                `name` varchar(20) not null
//)";
//        $conn->exec($sql);
//        echo '建表student成功';

//        建表teacher
//        $sql = "create table `Teacher` (
//                `id` int(6) unsigned auto_increment primary key,
//                `password` varchar(256) not null ,
//                `name` varchar(20) not null
//)";
//        $conn->exec($sql);
//        echo '建表teacher成功';

//        建表type 知识点类型
//        $sql = "create table `type` (
//                `id` int(6) unsigned auto_increment primary key,
//                `typename` varchar(30) not null
//)";
//        $conn->exec($sql);
//        echo '建表type成功';

//        删表
//        $sql = "drop table `Teacher`";
//        $conn->exec($sql);
//        echo '删表'.$sql.'成功'.PHP_EOL;

//        建表exercise 题目
//        之前teacherid没加unsigned，导致can't add foreign key
//        $sql = "create table `exercise` (
//                `id` int(10) unsigned auto_increment primary key,
//                `description` varchar(100) not null,
//                `title` varchar(50) not null ,
//                `answer` varchar(5000) not null ,
//                `keyword` varchar(100) not null ,
//                `score` int(6) not null,
//                `teacherid` int(6) unsigned not null,
//                `typeid` int(6) unsigned not null,
//                foreign key(teacherid) references Teacher(id),
//                foreign key(typeid) references type(id)
//);";
//        $conn->exec($sql);
//        echo '建表exercise成功';

//        建表answer 知识点类型
//        $sql = "create table `answer` (
//                `id` int(10) unsigned auto_increment primary key,
//                `studentid` int(6) unsigned not null ,
//                `exerciseid` int(10) unsigned not null ,
//                `date` timestamp not null,
//                `solution` varchar(5000) not null ,
//                `score` int(6) not null,
//                foreign key (studentid) references student (id),
//                foreign key (exerciseid) references Teacher (id)
//)";
//        $conn->exec($sql);
//        echo '建表answer成功';

//        修改表结构
//        $sql = "alter table Teacher drop number";
//        $conn->exec($sql);
//        echo '删字段teacher::number成功';
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    $conn = null;
?>