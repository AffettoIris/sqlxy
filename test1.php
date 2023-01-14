<?php
$test3 = fopen('test3.php', 'w+');
$str = <<<EOL
fefs‘”"'\/的味道
EOL;

file_put_contents('test2.php', $str);