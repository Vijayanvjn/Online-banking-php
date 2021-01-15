
<?php include("profile.php")?>
<?php require("deductions.php"); ?>
<?php require("session.php"); ?>
<?php require_once('function.php'); ?>
<input type="checkbox" id="check" checked>
    <label for="check">
      <i class="fa fa-bars admin-bar" id="btn"></i>
      <i class="fa fa-times" id="cancel"></i>
    </label>
<div class="sidebar">

    <div class="side-header">
    <label for="profile">
    <?php
    $user=$_GET['user'];
    $con=mysqli_connect("localhost","root","","online_banking");
   	$res_fetch=fetch("admin","username='$user'")['row'];
    // $fetch_profile="SELECT image FROM admin WHERE username='$user'";
    // $exec_fetch=mysqli_query($con,$fetch_profile);
    // $res_fetch=mysqli_fetch_assoc($exec_fetch);
    if($res_fetch['image']==""){
    echo "<i class='fa fa-user welcome_user'></i>";
	}
	else{
		echo 	"<div class='profile-box'>",
				"<img src='uploads/".$res_fetch['image']."'>",
				"</div>";
	}
    ?>
    </label>
    <p>WELCOME</p>
    <p> 
	<?php 
		if(isset($_GET['user'])){
		$user_id=$_GET['user_id'];
		$user=$_GET['user'];
		echo $_GET['user'];
		}
		else{
			echo "User";
		} 
	?>
	</p>
	<form method="POST" enctype="multipart/form-data">
	<input type="file" name="image" id="profile">
	<input type="submit" name="profile" value="Upload" id="upload">
	</form>
    </div>
	 
 <ul class="sidemenu_list">
			<li><a href="<?php echo "users_list.php?user=".$_GET['user']."&user_id=".$_GET['user_id']; ?>"><i class="fa fa-user"></i>Users
			</a></li>
			<li><a href="<?php echo "transaction_list.php?user=".$_GET['user']."&user_id=".$_GET['user_id']; ?>"><i class="fa fa-bank"></i> Transactions </a> </li>
			<li><a href="<?php echo "loan_list.php?user=".$_GET['user']."&user_id=".$_GET['user_id']; ?>"><i class="fas fa-hand-holding"></i> Loan Requests
			</a> </li>
			<li><a href="<?php echo "add_post.php?user=".$_GET['user']."&user_id=".$_GET['user_id']; ?>"><i class="fa fa-sticky-note"></i> Posts
			</a> </li>
</ul>
</div>

 