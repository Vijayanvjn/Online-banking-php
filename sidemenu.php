<?php require_once('function.php'); ?>
<?php include("profile.php")?>
<input type="checkbox" id="check" checked>
    <label for="check">
      <i class="fa fa-bars" id="btn"></i>
      <i class="fa fa-times" id="cancel"></i>
    </label>
<div class="sidebar">

    <div class="side-header">
    <label for="profile">
    <?php
    $user=$_GET['user'];
    $user_id=$_GET['user_id'];
    $con=mysqli_connect("localhost","root","","online_banking");
    $res_fetch=fetch("user","id='$user_id'")['row'];
    // $fetch_profile="SELECT image FROM user WHERE id='$user_id'";
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
		
			<!-- <li><a href="<?php echo "transfer.php?user=".$_GET['user']."&user_id=".$_GET['user_id']; ?>">
			<i class="fa fa-rupee"></i>Transfer</a></li> -->
			<li><a href="<?php echo "request.php?user=".$_GET['user']."&user_id=".$_GET['user_id']; ?>"><i class="fas fa-hand-holding"></i> Request </a> </li>
			<li><a href="<?php echo "mini.php?user=".$_GET['user']."&user_id=".$_GET['user_id']; ?>"><i class="fa fa-book"></i> Mini Statement
			</a> </li>
			<li><a href="<?php echo "upi.php?user=".$_GET['user']."&user_id=".$_GET['user_id']; ?>"><i class="fa fa-plus"></i> Generate UPI
			</a> </li>
			<li><a href="<?php echo "changeupi.php?user=".$_GET['user']."&user_id=".$_GET['user_id']; ?>"><i class="fa fa-undo"></i> Change UPI
			</a> </li>
			<li><a href="<?php echo "loan.php?user=".$_GET['user']."&user_id=".$_GET['user_id']; ?>"><i class="fa fa-money"></i> Loan
			</a> </li>
</ul>
</div>

 