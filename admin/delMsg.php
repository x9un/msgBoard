<?php
include_once('../conn.php');
session_start();
if (isset($_SESSION['admin']) && !empty($_GET['id'])) {
	$id = htmlspecialchars($_GET['id']);

	try{
            $dsn="mysql:host=$mysrv;dbname=$mydb;";
            $pdo=new PDO($dsn,$myuser,$mypwd);
	    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $pdo->setAttribute(PDO::MYSQL_ATTR_MULTI_STATEMENTS, false);
	        $sql=$pdo->prepare("DELETE FROM comment WHERE id = ? LIMIT 1");
            $res=$sql->execute(array($id));
            if($res){
            	echo "<script>alert('delete success');history.go(-1);</script>";
            }else{
            	echo "<script>alert('delete fail');history.go(-1);</script>";
            }

		    
	}catch(PDOException $e){
	    echo $e->getMessage().'<br>';
	    echo $e->getLine().'<br>';
	    echo $e->__toString().'<br>';
    }
}
else {
	echo "error";
}	
?>
