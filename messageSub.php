<?php

header("content-type:text/html;charset=utf-8");
include_once('conn.php');
session_start();

if(isset($_POST['code'])&&isset($_POST['submit'])){
    if($_POST['code']==$_SESSION['code']){


$dir="img";
$is_upload = false;
$msg = null;
$img_path=null;
$temp_path=null;

if($_FILES['file']['name']>=88){
    echo "<script>alert('文件上传失败');history.go(-1)</script>";
                exit();
}

if(!empty($_FILES['file']['size'])&&($_FILES['file']['size'])<1048577){
    //检查MIME
    $allow_type = array('image/jpeg','image/png');
    if(!in_array($_FILES['file']['type'],$allow_type)){
        echo "<script>alert('禁止上传该类型文件');history.go(-1)</script>";
    }else{
        //检查文件名
        $file =  $_FILES['file']['name'];
       
        $file = explode('.', strtolower($file));
       

        $ext = end($file);
        $allow_suffix = array('jpg','png','jpeg');
        if (!in_array($ext, $allow_suffix)) {
            echo "<script>alert('禁止上传该后缀文件');history.go(-1)</script>";
        }else{
            $file_name = reset($file) . '.' . $file[count($file) - 1];
            $temp_file = $_FILES['file']['tmp_name'];
            $temp_path=$_FILES['file']['tmp_name'];
            $img_path = $dir . '/' .$file_name;


            if( $_FILES['file']['type'] == 'image/jpeg' ) {
                $img = imagecreatefromjpeg( $temp_file );
                imagejpeg( $img, $temp_path, 100);
            }
            else if($_FILES['file']['type'] == 'image/png') {
                $img = imagecreatefrompng( $temp_file );
                imagepng( $img, $temp_path);
            }

            imagedestroy( $img );

            $size=getimagesize($temp_path);
            $width=$size[0];
            $height=$size[1];



            if($width>1000||$height>1000){
                echo "<script>alert('文件上传失败');</script>";
                exit();
            }else if (move_uploaded_file($temp_path, $img_path)) {
     
                echo "<script>alert('文件上传成功');</script>";
                $is_upload = true;
            } else {
                echo "<script>alert('文件上传失败');</script>";
            }

            //删除临时图片文件
            if( file_exists( $temp_path ) ) {
                unlink( $temp_path );
            }


        }
    }
}


$message = htmlspecialchars($_POST['message'],ENT_QUOTES, 'UTF-8', false);
$username=htmlspecialchars($_POST['username'],ENT_QUOTES, 'UTF-8', false);

if((!$message)&&(!$is_upload)){
    echo "<script>alert('留言与图片不能皆为空');history.go(-1)</script>";
    exit();
}

if($username==null){
    echo "<script>alert('用户名不能为空');history.go(-1)</script>";
    exit();
}

if (strlen($username)>=255){
    echo "<script>alert('用户名过长');history.go(-1)</script>";
    exit();
}

if(strlen($message)>=255){
        echo "<script>alert('留言内容过长');history.go(-1)</script>";
    exit();
}

date_default_timezone_set("Asia/Shanghai");
$pub_date = date("Y/m/d H:i:s");

try{
$dsn="mysql:host=$mysrv;dbname=$mydb;";
$pdo=new PDO($dsn,$myuser,$mypwd);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$pdo->setAttribute(PDO::MYSQL_ATTR_MULTI_STATEMENTS, false);
if ($is_upload){
  $sql = $pdo->prepare("insert into comment (username,message,photo,pub_date) values (?,?,?,?)");
  $sql->execute(array($username,$message,$img_path,$pub_date));
  $is_upload=false;
}else{
	  $sql = $pdo->prepare("insert into comment (username,message,pub_date) values (?,?,?)");
  $sql->execute(array($username,$message,$pub_date));
}
  if ($sql->rowCount()) {
    header('Location:index.php');
   }else{
   	echo'<script>alert("message failed");
	history.go(-1);</script>';
   }

}catch(PDOException $e){
    echo $e->getMessage().'<br>';
    echo $e->getLine().'<br>';
    echo $e->__toString().'<br>';
    }

unset($_SESSION["code"]);

}else{
    echo '<script>alert("please do not resubmit");
    history.go(-1);</script>';
 }
}else{
    echo '<script>alert("error");
    history.go(-1);</script>';
}

?>
