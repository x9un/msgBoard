
<?php
include_once('../conn.php');
session_start();//启动会话
session_unset();//删除会话
session_destroy();//结束会话
echo "<script>
        alert('logout success');
        window.location.href='../index.php';
        </script>";
exit();
?>