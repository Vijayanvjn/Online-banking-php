<?php require_once('function.php'); ?>
<?php

	$con=mysqli_connect("localhost","root","","online_banking");
	$pending_sql=fetch("loan_transaction","status='Monthly-Deduction-Pending'");
	$pending_res=$pending_sql['result'];
	$pending_row=$pending_sql['row'];
	$pending_count=$pending_sql['count'];
	// $pending_sql="SELECT * FROM loan_transaction WHERE status='Monthly-Deduction-Pending'";
	// $pending_res=mysqli_query($con,$pending_sql);
	if($pending_count!=0){
		do{
		$trans_id=$pending_row['id'];
		$loan_id=$pending_row['user_id'];
		$user_row=fetch("user","id='$loan_id'")['row'];
		// $user_sql="SELECT * FROM user WHERE id='$loan_id'";
		// $user_res=mysqli_query($con,$user_sql);
		// $user_row=mysqli_fetch_assoc($user_res);
		$balance=$user_row['balance'];
		$deduction=$pending_row['amount'];
		if($deduction<$balance){
			update("loan_transaction","status='Monthly-Deduction'","id='$trans_id'");
			// $deduct_sql="UPDATE loan_transaction SET status='Monthly-Deduction' WHERE id='$trans_id'";
			// $deduction_res=mysqli_query($con,$deduct_sql);
			update("user","balance=balance-$deduction","id=$loan_id");
			// $balance_sql="UPDATE user SET balance=balance-$deduction WHERE id='$loan_id'";
			// $balance_res=mysqli_query($con,$balance_sql);
		}	
		}while($pending_row=mysqli_fetch_assoc($pending_res));	
	}
	

?>