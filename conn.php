<?php

$mysrv="localhost"; //数据库服务器名称
$myuser="root"; // 连接数据库用户名
$mypwd="root"; // 连接数据库密码
$mydb='ml7';
$conn = mysqli_connect($mysrv,$myuser,$mypwd,$mydb) or die("error".mysql_error());

?>