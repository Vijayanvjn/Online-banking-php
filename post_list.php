<?php require("deductions.php"); ?>
<?php require_once('function.php'); ?>
<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Student</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="css/savings_home.css" />
    <link rel="stylesheet" type="text/css" href="css/index.css" />
    <link rel="stylesheet" type="text/css" href="css/post.css" />
    <link rel="stylesheet" type="text/css" href="css/media.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Satisfy&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
</head>
<body>
	<?php
	$con=mysqli_connect("localhost","root","","online_banking");
	$user_id=$_GET['user_id'];
	$user=$_GET['user'];
	?>
				<?php include "admin-sidemenu.php" ?>
				<div class="body-cntn">
					<?php include "admin_header.php" ?>
					<table class="table table-responsive table-striped post_table">
						<tr>
							<th>Post No.</th>
							<th>Title</th>
							<th>Content</th>
							<th>Post-date</th>
							<th>Post-time</th>
							<th>Action</th>
						</tr>
						<?php
						$post_sql=fetch("notification","receiver='all'");
						$post_res=$post_sql['result'];
						$post_row=$post_sql['row'];
						$post_count=$post_sql['count'];
						// $post_sql="SELECT * FROM notification";
						// $post_res=mysqli_query($con,$post_sql);
						if($post_count!=0){
							do{
							$post_id=$post_row['id'];
							echo "<tr>",
							"<td>".$post_row['id']."</td>",
							"<td>".$post_row['title']."</td>",
							"<td>".$post_row['content']."</td>",
							"<td>".$post_row['post_date']."</td>",
							"<td>".$post_row['post_time']."</td>",
							"<td><a href='delete_post.php?user=$user&user_id=$user_id&post_id=$post_id' class='btn  btn-danger'>Delete</a></td>",
							
							"</tr>";
							}while($post_row=mysqli_fetch_assoc($post_res));	
						}
						
						?>
					</table>
				</div>	
</body>
</html>