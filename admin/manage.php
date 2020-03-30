<head>
		<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="http://apps.bdimg.com/libs/bootstrap/3.3.4/css/bootstrap.min.css">
		<script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
		<script src="http://apps.bdimg.com/libs/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</head>
<?php 
include_once('../conn.php');
session_start();

if (isset($_SESSION['admin'])) {
	$query = "SELECT * FROM comment ORDER BY id";
	$data = mysqli_query($conn,$query) or die('Error');
	mysqli_close($conn);
?>
<table class="items table">
<thead>
<tr>
<th id="yw0_c0">留言</th>
<th id="yw0_c0">用户</th>
<th id="yw0_c0">时间</th>
<th id="yw0_c0">图片</th>
<th id="yw0_c4">管理</th>
</thead>
<tbody>
<?php 
	//打印数据
	while ($msg = mysqli_fetch_array($data)) {
	$html['username'] = strip_tags(htmlspecialchars($msg['username'],ENT_QUOTES));
	$html['message'] = strip_tags(htmlspecialchars($msg['message'],ENT_QUOTES));
	$pub_date=$msg['pub_date'];
	$img=strip_tags(htmlspecialchars($msg['photo']));
?>
	<tr>
		<td><?php echo $html['message'] ;?></td>
		<td><?php echo $html['username'];?></td>
		<td><?php echo $pub_date;?></td>
		<td><?php echo $img;?></td>
		<td><a href="delMsg.php?id=<?php echo $msg['id'];?>">删除</a></td>
	</tr>
<?php } 
?>
</tbody>
</table>
<a href="loginFront.html">返回</a>
<a href="logout.php">退出</a>
<?php 
}
else {
	echo "please login";
}

 ?>