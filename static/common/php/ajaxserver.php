<?php
    // 以下是ajax与php交互数据，server端必须加的报文头
    // 客户端要传post，客户端还必须加xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    // 注意，在php中使用js的alert（）需要header('Content-Type:text/html;charset=utf-8');，而下方设成了json头

// 下方的是偶然百度到的。特点是指定了数据类型为json。这导致在火狐浏览器打开，现实的不是一个网页，而是一个类似cmd的黑窗口。
//    //json头
//    header("Content-type: application/json");
//    //跨域
//    header("Access-Control-Allow-Credentials: true");
//    header("Access-Control-Allow-Origin:*");
//    //CORS实现跨域访问
//    header("Access-Control-Request-Methods:GET, POST, PUT, DELETE, OPTIONS");
//    header('Access-Control-Allow-Headers:x-requested-with,content-type,test-token,test-sessid');

        header("Access-Control-Allow-Origin:*");
        header("ccess-Control-Allow-Headers:*");
?>