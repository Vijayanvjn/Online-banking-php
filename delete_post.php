<?php require_once('function.php'); ?>
<?php
$con=mysqli_connect("localhost","root","","online_banking");
$user=$_GET['user'];
$user_id=$_GET['user_id'];
$post_id=$_GET['post_id'];
delete("notification","id='$post_id'");

// $delete_sql="DELETE FROM post WHERE id='$post_id'";
// $delete_res=mysqli_query($con,$delete_sql);
header("location:post_list.php?user=$user&user_id=$user_id");

?>