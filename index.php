<?php   

header("content-type:text/html;charset=utf-8");
include_once('conn.php');

  $sql = "SELECT * FROM comment order by id desc";
  $query = mysqli_query($conn,$sql) or die('Error!!');
  mysqli_close($conn);
  ?>

  <style>
  .mycenter{
	margin-top: 5px;
	margin-left: auto;
	margin-right: auto;
	width:500px;
	padding: 5%;
	padding-left: 5%;
	padding-right: 5%;
}

</style>
        <div class="mycenter">

		<form action="messageSub.php" method="post" enctype="multipart/form-data">
			
				<div class="col-lg-11 text-center text-info">
					<h2>msgboard</h2>
				</div>

				<div class="col-lg-10">
					<input type="text" class="form-control" name="username" placeholder="username<10" id="username"/>
				</div>

				<div class="col-lg-10"></div>
               
                <div class="col-lg-10">
					<input type="file" class="form-control" id="file" name="file">
					<?php echo "(less than 1mb,1000px,1000px)"; ?>
				</div>


				<div class="col-lg-10">
        <textarea class="form-control" rows="5" id="textArea" name="message" placeholder="message<255"></textarea>
    </div>

				<div class="col-lg-10"></div>
				<div class="col-lg-10"></div>
				<div class="col-lg-10">
					<input type="submit" name="submit" value="submit" class="btn btn-success col-lg-12">
				</div>
			

		</form>



<div class="container">
  <div class="bs-example table-responsive">
	<table class="table table-striped table-hover ">
	<?php
while($com = mysqli_fetch_array($query)) {

	$html['username'] = strip_tags(htmlspecialchars($com['username'],ENT_QUOTES));
	$html['message'] = strip_tags(htmlspecialchars($com['message'],ENT_QUOTES));
	$pub_date=$com['pub_date'];
	$photo=strip_tags(htmlspecialchars($com['photo'],ENT_QUOTES));
	echo '<tr>';
	echo '<th>username:</th>';
	echo '<td>'.$html['username'].'</td>';
	echo '</tr>';

	echo '<tr>';
	echo '<th>message:</th>';
	echo '<td>'.$html['message'].'</td>';
	echo '</tr>';

if($photo){
	echo '<tr>';
	echo '<th></th>';
	echo '<td><img src='.$photo.'></td>';
	echo '</tr>';
}
	echo '<tr>';
	echo '<th>date:</th>';
	echo '<td>'.$pub_date.'</td>';
	echo '</tr>';
}
?>
</table>
</div>
</div>

		
</div>





