<?php require_once('function.php'); ?>
<?php
$del_id=$_GET['del_id'];
$user=$_GET['user'];
$user_id=$_GET['user_id'];
$con=mysqli_connect("localhost","root","","online_banking");
delete("recipients","id='$del_id'");
// $sql="DELETE FROM recipients WHERE id=$del_id";
// $res=mysqli_query($con,$sql);
header("location:recipient.php?user=$user&user_id=$user_id");
?>