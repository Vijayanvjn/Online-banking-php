<?php require_once('function.php'); ?>
<?php
$con=mysqli_connect("localhost","root","","online_banking");
$user_sql=fetch("user","balance<=500",'AND',"acctype='savings'");
$user_res=$user_sql['result'];
$row=$user_sql['row'];
$count=$user_sql['count'];
$user_sql="SELECT * FROM user WHERE balance<=500 AND acctype='savings'"; 
$user_res=mysqli_query($con,$user_sql);
$date=date("d");
$month=date("m");
$cur_date=date("Y-m-d");
$cur_time=date("h:i:a");
if($date==2){
	if($count!=0){
		do{
		$id=$row['id'];
		$check_sql="SELECT * FROM transaction WHERE status='minimum balance fine' AND sender_id='$id' AND cur_date='$cur_date'";
		$check_res=mysqli_query($con,$check_sql);
		$count_row=mysqli_num_rows($check_res);
		if($count_row==0){ //checking if already fine deducted	
		$deduct_sql="UPDATE user SET balance=balance-200 WHERE id='$id'";
		$deduct_res=mysqli_query($con,$deduct_sql);
		$insert_sql="INSERT INTO transaction (sender_id,receiver,accno,bank,ifsc,amount,cur_date,cur_time,status) VALUES ('$id','Bank','-','-','-','200','$cur_date','$cur_time','minimum balance fine')";
		$insert_res=mysqli_query($con,$insert_sql);
		}
		}while($row=mysqli_fetch_assoc($user_res));
	}
	
}

?>