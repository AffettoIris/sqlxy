<?php
    include '../../static/common/php/ajaxserver.php';
// 学生端
    $studentNumber = $_POST['studentNumber'] ?? ''; // 学生学号
    $studentPwd = $_POST['studentPwd'] ?? ''; // 学生密码
    // 为防止SQL注入攻击，对学号检查是否纯数字且<=15位。后期发现，对于用户的输入里出现的单双引号，前缀转义符\即可
    if (!empty($studentNumber)) {
        if (!is_numeric($studentNumber) || (strlen($studentNumber) > 15)) {
            echo '学号须是纯数字，位数小于等于15位';
            die();
        }
    }

    if (!empty($studentPwd)) {
        //    如果密码长度小于6,大于16，脚本终止
        if (strlen($studentPwd) > 16 || strlen($studentPwd) < 6) {
            echo '密码须6~16位，不能有单双引号或反斜杠';
            die();
        }

        //    为防止SQL注入攻击，对密码检查是否包含单引号、双引号、转义字符
        if (substr_count($studentPwd, "'") || substr_count($studentPwd, '"') || substr_count($studentPwd, '\\')) {
            echo '密码须6~16位，不能有单双引号或反斜杠';
            exit();
        }
    }

// 教师端
    $teacherName = $_POST['teacherName'] ?? ''; // 教师姓名
    $teacherPwd = $_POST['teacherPwd'] ?? ''; // 教师密码

    if (!empty($teacherName)) {
        if ((strlen($teacherName) > 20 || substr_count($teacherName, "'") || substr_count($teacherName, '"') || substr_count($teacherName, '\\'))) {
            echo '教师名须位数小于等于20位，不限中英文，不能有单双引号或反斜杠';
            die();
        }
    }

    if (!empty($teacherPwd)) {
        //    如果密码长度小于6,大于16，脚本终止
        if (strlen($teacherPwd) > 16 || strlen($teacherPwd) < 6) {
            echo '密码须6~16位，不带单双引号或反斜杠';
            die();
        }

        //    为防止SQL注入攻击，对密码检查是否包含单引号、双引号、转义字符
        if (substr_count($teacherPwd, "'") || substr_count($teacherPwd, '"') || substr_count($teacherPwd, '\\')) {
            echo '密码须6~16位，不带单双引号或反斜杠';
            die();
        }
    }
?>