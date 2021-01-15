<?php session_start(); ?>
<?php require("deductions.php"); ?>
<?php require("session.php"); ?>
<?php require_once('function.php'); ?>
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
	$title="";
	$titleerr="";
	$content="";
	$contenterr="";
	$count=0;
	if(isset($_POST['add_post'])){
		date_default_timezone_set("Asia/Kolkata");
		$post_time=date('h:i:a');
		$post_date=date('Y-m-d');
		$title=$_POST['title'];
		$content=$_POST['content'];
		if($title==""){
			$titleerr="Please enter the title";
			$count=$count+1;
		}
		else{
			$titleerr="";
		}
		if($content==""){
			$contenterr="Please enter the Content";
			$count=$count+1;
		}
		else{
			$contenterr="";
		}
		if($count==0){
			$notification_array=array("title"=>$title,"content"=>$content,"post_date"=>$post_date,"post_time"=>$post_time,"sender"=>"bank","receiver"=>"all");
			insert("notification",$notification_array);
			 // $notification_sql="INSERT INTO notification (title,content,post_date,post_time,sender,receiver) 
    //                 VALUES ('$title','$content','$post_date','$post_time','bank','all')";
    //          $notification_res=mysqli_query($con,$notification_sql); 
             $last_notification="SELECT * FROM notification ORDER BY id DESC LIMIT 1";
             $last_res=mysqli_query($con,$last_notification);
             $last_notification_row=mysqli_fetch_assoc($last_res);
             $last_notification_id=$last_notification_row['id'];
             $user_res=fetch("user")['result'];
             $user_row=fetch("user")['row'];
             // $user_sql="SELECT * FROM user";
             // $user_res=mysqli_query($con,$user_sql);
             do{
             	$receiver_id=$user_row['id'];
           		$log_array=array("notification_id"=>$last_notification_id,"user_id"=>$receiver_id);
				insert("notification_log",$log_array);
             	// $log_sql="INSERT INTO notification_log (notification_id,user_id) VALUES ('$last_notification_id','$receiver_id')";
             	// $log_res=mysqli_query($con,$log_sql);	
             }while ($user_row=mysqli_fetch_assoc($user_res));
             
			// header("Refresh:0");
		}

	}
	?>
				<?php include "admin-sidemenu.php" ?>
				<div class="body-cntn">
					<?php include "admin_header.php" ?>
					<a href="<?php echo 'post_list.php?user='.$user.'&user_id='.$user_id;?>" class="btn btn-success all-posts">All Posts</a>
					<div class="post-box">
					<form method="POST">
						<label><h3>Title</h3></label>
						<input type="text" name="title" class="title" value="<?php echo $title; ?>">
						<p class="err"><?php echo $titleerr; ?></p>
						<label><h3>Content</h3></label>
						<textarea rows="7" name="content" class="content"><?php echo $content; ?></textarea>
						<p class="err"><?php echo $contenterr; ?></p>
						<input type="submit" name="add_post" class="btn btn-success" value="Add Post">
					</form>	
					</div>
				</div>	
</body>
</html>