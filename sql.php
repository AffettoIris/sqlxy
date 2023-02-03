<?php
    try {
        include '../static/common/php/adminConn.php';
        $aConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $aConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//        建库sqlxy
//        $sql = "create database sqlxy";
//        $aConn->exec($sql);
//        echo '数据库创建成功'.PHP_EOL;

//        注意，mysql8的timestamp默认值不是当前时间，而是null,
// SHOW GLOBAL VARIABLES LIKE "explicit_defaults_for_timestamp"; 查看值，on表示取null，off表示取当前时间
// SET persist explicit_defaults_for_timestamp=OFF; 设置成OFF

//        建表student
//        $sql = "create table `student` (
//                `id` int(10) unsigned auto_increment primary key,
//                `number` int(20) not null unique,
//                `password` varchar(256) not null ,
//                `name` varchar(40) not null,
//                `reg_time` timestamp
//)";
//        $aConn->exec($sql);
//        echo '建表student成功';

//        建表teacher
//        $sql = "create table `Teacher` (
//                `id` int(6) unsigned auto_increment primary key,
//                `name` varchar(40) not null,
//                `password` varchar(256) not null
//)";
//        $aConn->exec($sql);
//        echo '建表teacher成功';

//        建表type 知识点类型
//        $sql = "create table `type` (
//                `id` int(6) unsigned auto_increment primary key,
//                `typename` varchar(30) not null
//)";
//        $aConn->exec($sql);
//        echo '建表type成功';

//        删表
//        $sql = "drop table `Teacher`";
//        $aConn->exec($sql);
//        echo '删表'.$sql.'成功'.PHP_EOL;

//        建表exercise 题目，status取值usable / unusable，表示老师没删除，任何学生可见 / 老师已删除，老师不可见，只有已做过该题的学生可见
//        之前teacherid没加unsigned，导致can't add foreign key
//        $sql = "create table `exercise` (
//                `id` int(10) unsigned auto_increment primary key,
//                `description` varchar(5000) not null,
//                `title` varchar(500) not null ,
//                `answer` varchar(5000) not null ,
//                `keyword` varchar(500) not null ,
//                `score` int(6) not null,
//                `teacherid` int(6) unsigned not null,
//                `typeid` int(6) unsigned not null,
//                  `reg_time` timestamp,
//                `init` text not null,
//                `tresult` varchar(5000),
//                `status` varchar(10) not null,
//                foreign key(teacherid) references Teacher(id),
//                foreign key(typeid) references type(id)
//);";
//        $aConn->exec($sql);
//        echo '建表exercise成功';

//        建表answer 知识点类型,外键exerciseid需要级联删除
//        $sql = "create table `answer` (
//                `id` int(10) unsigned auto_increment primary key,
//                `studentid` int(6) unsigned not null ,
//                `exerciseid` int(10) unsigned not null ,
//                `date` timestamp not null,
//                `solution` varchar(5000) not null ,
//                `score` int(6) not null,
//                foreign key (studentid) references student (id),
//                foreign key (exerciseid) references exercise (id) on delete cascade
//)";
//        $aConn->exec($sql);
//        echo '建表answer成功';

//        修改表结构
//        $sql = "alter table Teacher drop number";
//        $aConn->exec($sql);
//        echo '删字段teacher::number成功';

//        建立用户，分配权限，密码省略,用root用户操作
//        $sql = "create user 'admin'@'%' identified by '......';";
//        $sql = "create user 'teacher'@'%' identified by '......';";
//        $sql = "create user 'student'@'%' identified by '......';";
//        $sql = "create database envxy;";
//        $sql = "grant all on sqlxy.student to teacher;";
//        $sql = "grant all on sqlxy.answer to teacher;";
//        $sql = "grant all on sqlxy.exercise to teacher;";
//        $sql = "grant all on envxy.* to teacher;";
//        $sql = "grant all on sqlxy.teacher to 'teacher'@'%' identified by '...';";
//        $sql = "grant all on envxy.* to student;";
//        $sql = "grant all on envxy.* to admin;";
//        $sql = "grant all on sqlxy.* to admin;";
//        $sql = "grant all on sqlxy.`student` to student;";
//        $sql = "grant all on sqlxy.`answer` to student;";
//        $sql = "grant all on sqlxy.`exercise` to student;";
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    $aConn = null;
?>