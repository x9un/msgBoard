<?php
/*
    $username = '4dm1nld';
    $password = 'fau578DW/A3*';

try{
$dsn="mysql:host=$mysrv;dbname=$mydb;";
$pdo=new PDO($dsn,$myuser,$mypwd);


    $regpwd_hash=password_hash($password,PASSWORD_BCRYPT);
	$regsql=$pdo->prepare("insert into admin (username,password) values (?,?)");
	$regsql->execute(array($username,$regpwd_hash));
	if ($regsql->rowCount()){
						echo 'y';
					}else
					{
						echo "no";
					}
}catch(PDOException $e){
    echo $e->getMessage().'<br>';
    echo $e->getLine().'<br>';
    echo $e->__toString().'<br>';
}
*/
include_once('../conn.php');
session_start();
if (isset($_POST['submit']) && !empty($_POST['username']) && !empty($_POST['password'])) {
    $username = strip_tags(htmlspecialchars($_POST['username'],ENT_QUOTES));

    $password = $_POST['password'];

	try{
            $dsn="mysql:host=$mysrv;dbname=$mydb;";
            $pdo=new PDO($dsn,$myuser,$mypwd);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

	        $sql=$pdo->prepare("select * from admin where username = ?");
            $sql->execute(array($username));
		    $rows=$sql->fetchAll(PDO::FETCH_ASSOC);
		    $count=count($rows);

            if ($count==0){
                echo "<script>alert('username or password is wrong');history.go(-1);</script>";
                exit();
            }

		    if(password_verify($password, $rows[0]['password']))
		    {
		    	$_SESSION['admin']=$username;
		    	echo "<script>alert('login success');</script>";
		        header('Location:manage.php');


		    } else {
		    	echo "<script>alert('username or password is wrong');history.go(-1);</script>";
                exit();
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
