<?php
require_once('function.php'); 
$loan_id=$_GET['loan_id'];
$user_id=$_GET['user_id'];
$user=$_GET['user'];
$amount=$_GET['amount'];
date_default_timezone_set('Asia/Kolkata');
$process_time=date("h:i:a");
$process_date=date("Y-m-d");
$sql=update("loan","status='Approved'","user_id='$loan_id'");
$credit_sql=update("user","balance=balance+$amount","id='$loan_id'");
// $credit_sql="UPDATE user SET balance=balance+$amount WHERE id='$loan_id'";
// $credit_res=mysqli_query($con,$credit_sql);
$track_array=array("user_id"=>$loan_id,"amount"=>$amount,"process_date"=>$process_date,"process_time"=>$process_time,"status"=>"Loan-Allocated");
insert("loan_transaction",$track_array);
// $track_sql="INSERT INTO loan_transaction (user_id,amount,process_date,process_time,status) VALUES ('$loan_id','$amount','$process_date','$process_time','Loan-Allocated')";
// $track_res=mysqli_query($con,$track_sql);
$notification_array=array("title"=>"Loan Allocated","content"=>"Your account is credited with Rs. ".$amount,"post_date"=>$process_date,"post_time"=>$process_time,"sender"=>"bank","receiver"=>$loan_id);
insert("notification",$notification_array);
 // $notification_sql="INSERT INTO notification (title,content,post_date,post_time,sender,receiver) VALUES ('Loan Allocated','Your account is Credited with Rs. $amount','$process_time','$process_date','bank','$loan_id')";
 // $notification_res=mysqli_query($con,$notification_sql); 
$last_notification="SELECT * FROM notification ORDER BY id DESC LIMIT 1";
$last_res=mysqli_query($con,$last_notification);
$last_notification_row=mysqli_fetch_assoc($last_res);
$last_notification_id=$last_notification_row['id'];

$log_array=array("notification_id"=>$last_notification_id,"user_id"=>$loan_id);
insert("notification_log",$log_array);
    // $log_sql="INSERT INTO notification_log (notification_id,user_id) VALUES ('$last_notification_id','$loan_id')";
    // $log_res=mysqli_query($con,$log_sql);   
header("location:loan_list.php?user=$user&user_id=$user_id");
?>