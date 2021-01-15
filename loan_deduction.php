
	<?php require_once('function.php'); ?>
	<?php 
			$allocated_sql=fetch("loan_transaction","status='Loan-Allocated'");
			$allocated_res=$allocated_sql['result'];
			$allocated_row=$allocated_sql['row'];
			$allocated_count=$allocated_sql['count'];
			// $allocated="SELECT * FROM loan_transaction WHERE  status='Loan-Allocated'";
			// $allocated_res=mysqli_query($con,$allocated);
			if($allocated_count!=0){
				do{
				$user_id=$allocated_row['user_id'];
				$cur_date=date('Y-m-d');
				$cur_time=date('h:i:a');
				$allocated_amt=$allocated_row['amount'];
				if($allocated_amt<=10000){
					$total_month=5;
				}
				else{
					$total_month=8;
				}
				$loan_date=$allocated_row['process_date'];
				$user_detail_row=fetch("user","id='$user_id'")['row'];
				// $user_detail_sql="SELECT * FROM user WHERE id='$user_id'"; // fetching user details
				// $user_detail_res=mysqli_query($con,$user_detail_sql);
				// $user_detail_row=mysqli_fetch_assoc($user_detail_res);
				$balance=$user_detail_row['balance'];
				$user_loan_sql=fetch("loan","user_id='$user_id'");
				$user_loan_count=$user_loan_sql['count'];
				// $user_loan_sql="SELECT * FROM loan WHERE user_id='$user_id'";
				// $user_loan_res=mysqli_query($con,$user_loan_sql);
				// $user_loan_count=mysqli_num_rows($user_loan_res);
				if($user_loan_count!=0){
				$user_loan_row=$user_loan_sql['row'];
				$deduct_amt=$user_loan_row['monthly_deduction'];  //monthly deduction amount	
				}
				$last_sql="SELECT * FROM loan_transaction WHERE user_id='$user_id'  ORDER BY id DESC LIMIT 1"; //fetching last transaction of user
				$last_res=mysqli_query($con,$last_sql);								
				$last_row=mysqli_fetch_assoc($last_res);
				$last_deduction=$last_row['process_date'];
				$cur_deduction=	date('d-m-Y',strtotime('+1 Days',strtotime($last_deduction)));	
				$user_transaction_count=fetch("loan_transaction","user_id='$user_id'")['count'];					
				// $user_transaction_sql="SELECT * FROM loan_transaction WHERE user_id='$user_id'";
				// $user_transaction_res=mysqli_query($con,$user_transaction_sql);
				// $user_transaction_count=mysqli_num_rows($user_transaction_res); //counting the number of transaction of user
				if($cur_deduction==$cur_date&&$user_transaction_count<=$total_month+1){
						if($balance>$deduct_amt){
							update("user","balance=balance-$deduct_amt","id='$user_id'");
							// $deduction_sql="UPDATE user SET balance=balance-$deduct_amt WHERE id='$user_id'";
							// $deduction_res=mysqli_query($con,$deduction_sql);
							$loan_transaction_array=array("user_id"=>$user_id,"amount"=>$deduct_amt,"process_date"=>$cur_date,"process_time"=>$cur_time,"status"=>"Monthly-Deduction");
							insert("loan_transaction",$loan_transaction_array);
							// $loan_transaction_sql="INSERT INTO loan_transaction (user_id,amount,process_date,process_time,status) VALUES ('$user_id','$deduct_amt','$cur_date','$cur_time','Monthly-Deduction')";
							// $loan_transaction_res=mysqli_query($con,$loan_transaction_sql);	
							$notification_array=array("title"=>"Loan Due Deducted","content"=>"Your account is Debited with Rs. ".$deduct_amt,"post_date"=>$cur_date,"post_time"=>$cur_time,"sender"=>$user_id,"receiver"=>"bank");
							insert("notification",$notification_array);
							// $notification_sql="INSERT INTO notification (title,content,post_date,post_time,sender,receiver) VALUES ('Loan Due Deducted','Your account is Debited with Rs. $deduct_amt','$cur_time','$cur_date','$user_id','bank')";
 						// 	$notification_res=mysqli_query($con,$notification_sql); 	
 							$last_notification="SELECT * FROM notification ORDER BY id DESC LIMIT 1";
							$last_res=mysqli_query($con,$last_notification);
							$last_notification_row=mysqli_fetch_assoc($last_res);
							$last_notification_id=$last_notification_row['id'];
							$log_array=array("notification_id"=>$last_notification_id,"user_id"=>$user_id);
							insert("notification_log",$log_array);
						    // $log_sql="INSERT INTO notification_log (notification_id,user_id) VALUES ('$last_notification_id','$user_id')";
						    // $log_res=mysqli_query($con,$log_sql);   	
						}
						else{
							$loan_transaction_array=array("user_id"=>$user_id,"amount"=>$deduct_amt,"process_date"=>$cur_date,"process_time"=>$cur_time,"status"=>"Monthly-Deduction-Pending");
							insert("loan_transaction",$loan_transaction_array);
							// $loan_transaction_sql="INSERT INTO loan_transaction (user_id,amount,process_date,process_time,status) VALUES ('$user_id','$deduct_amt','$cur_date','$cur_time','Monthly-Deduction-Pending')";
							// $loan_transaction_res=mysqli_query($con,$loan_transaction_sql);	
						}
				}

			}while($allocated_row=mysqli_fetch_assoc($allocated_res));
			}
			

	?>