<?php

$sites = array("Google", true);
if (in_array("PHP", $sites)){
    echo "值在数组中";
}
else{
    echo "值不在数组中";
}  // 输出"值在数组中",

var_dump("PHP" === true);
if ("PHP" === true) {
    echo 1;
} else {
    echo 2;
}
?>