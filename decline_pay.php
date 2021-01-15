<?php require_once('function.php'); ?>
<?php
$user_id=$_GET['user_id'];
$user=$_GET['user'];
$req_id=$_GET['req_id'];
$con=mysqli_connect("localhost","root","","online_banking");
delete("message","id='$req_id'");
// $decline_sql="DELETE FROM message WHERE id='$req_id'";
// $res=mysqli_query($con,$decline_sql);
header("location:received_request.php?user=$user&user_id=$user_id");
?>