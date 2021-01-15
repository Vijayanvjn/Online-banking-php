<?php require_once('function.php'); ?>
<?php
$loan_id=$_GET['loan_id'];
$user_id=$_GET['user_id'];
$user=$_GET['user'];
$con=mysqli_connect("localhost","root","","online_banking");
delete("loan","user_id='$loan_id'");
// $sql="DELETE FROM loan  WHERE user_id='$loan_id'";
// $res=mysqli_query($con,$sql);
header("location:loan_list.php?user=$user&user_id=$user_id");
?>