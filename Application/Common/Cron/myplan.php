<?php
/**
 * Created by PhpStorm.
 * User: zzz94
 * Date: 2019/5/9
 * Time: 14:24
 */



echo date("Y-m-d H:i:s")."执行定时任务！" . "\r\n<br>";
file_put_contents('time.txt',date('Y-M-D H:i:s',time()).PHP_EOL,FILE_APPEND);
//run();
//
//function run() {
//    $res=A('Admin');
//    print_r($res);
//}