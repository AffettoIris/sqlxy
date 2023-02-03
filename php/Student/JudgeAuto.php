<?php
    function judgeAuto($typeId, $conn, $init, $sAnswer, $timestamp, $tResult, &$tableName) : string {
        switch ($typeId) {
            case 1:
            case 2:
            case 4:
                return judgeUpdate($conn, $init, $sAnswer, $timestamp, $tResult, $tableName);
            case 3:
                return judgeSelect($conn, $init, $sAnswer, $timestamp, $tResult, $tableName);
        }
        return '';
    }

    function judgeSelect($conn, $init, $sAnswer, $timestamp, $tResult, &$tableName) : string {
        // 采用引用赋值的方式向外界传递临时表名，不能return，因为万一半路执行异常，都跑不到return那儿
        $tableName = createTable($conn, $init, $timestamp);
        // 学生自己写的语句里，凡出现原表名，一律替换成临时表名。bug是，如果语句里出现与原表名相同的字符串且该字符串不是在表名位置，也被替换，概率小，不管。
        $sAnswer = str_replace($tableName[0], $tableName[1], $sAnswer);
        $sResult = $conn->query($sAnswer)->fetchAll();
        // 将数据库拿到的JSOn答案转成数组
        // $tResult = json_decode($tResult); 这样写是不对的，这样出来的二维数组，一维角度的每个值是object，而$sResult的一维角度的每个值是数组
        $tResult = json_decode($tResult, true);
        if ($sResult == $tResult) {
            return 'right';// 答案正确
        } else {
            return 'wrong';// 答案能正常运行，但不对
        }
//        dropTable($conn, $tableName); // 不应该在这儿删表，因为执行异常，会报错导致这儿不被执行，所以应该在examJud.php的try末和catch那儿删表
    }

    function judgeUpdate($conn, $init, $sAnswer, $timestamp, $tResult, &$tableName) : string {
        $tableName = createTable($conn, $init, $timestamp);
        // 学生自己写的语句里，凡出现原表名，一律替换成临时表名。bug是，如果语句里出现与原表名相同的字符串且该字符串不是在表名位置，也被替换，概率小，不管。
        $sAnswer = str_replace($tableName[0], $tableName[1], $sAnswer);
        $conn->exec($sAnswer);
        $sResult = $conn->query("select * from $tableName[1];")->fetchAll();
        $tResult = json_decode($tResult, true);
        if ($sResult == $tResult) {
            return 'right';// 答案正确
        } else {
            return 'wrong';// 答案能正常运行，但不对
        }
    }

    // 接受数据库，题目的建表语句和时间戳，将语句中的表名随机重命名，返回原表名和临时表名
    function createTable($conn ,$init, $timestamp) : array {
        preg_match("{ *[cC][rR][eE][aA][tT][eE] +[tT][Aa][bB][lL][Ee] +[^ ]+}", $init, $matches);
        if (count($matches) === 0) {
            throw new PDOException("题目无法初始化，老师未提供建表语句！");
            return ''; // 所匹配不到，数组$matches是空数组，不支持非建表的语句哦！
        }
        $arr = explode(' ',$matches[0]); // 用分隔符空格切割字符串成数组
        $preTableName = end($arr); // 保留原表名
        $init = str_replace($preTableName, 'xy'.$timestamp, $init); // 自此，将$init代表的初始化建表语句中的表名，随机重命名
        $conn->exec($init);
        return [$preTableName, 'xy' . $timestamp];
    }

    function dropTable($conn, string $tableName):void {
        if (!empty($tableName)) {
            $conn->exec("drop table " . $tableName);
        }
    }
?>