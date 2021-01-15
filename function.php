<?php

//not passing parameter is the reason for unsupported method overloading
function fetch(){ 
	$con=mysqli_connect("localhost","root","","online_banking");
	$args=func_get_args();
	$args_count=count($args);
	switch($args_count){
		case 1:
		$fetch_sql="SELECT * FROM $args[0]";
		break;
		case 2:
		$fetch_sql="SELECT * FROM $args[0] WHERE $args[1]";
		break;
		case 4:
		$fetch_sql="SELECT * FROM $args[0] WHERE $args[1] $args[2] $args[3]";
		break;
		case 6:
		$fetch_sql="SELECT * FROM $args[0] WHERE $args[1] $args[2] $args[3] $args[4] $args[5]";
		break;
		case 8:
		$fetch_sql="SELECT * FROM $args[0] WHERE $args[1] $args[2] $args[3] $args[4] $args[5] $args[6] $args[7]";
		break;
	}
	$fetch_exec=mysqli_query($con,$fetch_sql);
	if(!$fetch_exec){
		echo "select error";
	}
	$fetch_count=mysqli_num_rows($fetch_exec);
	if($fetch_count!=0){
		$fetch_row=mysqli_fetch_assoc($fetch_exec);	
		$fetch_count=mysqli_num_rows($fetch_exec);	
		return array("sql"=>$fetch_sql,"result"=>$fetch_exec,"row"=>$fetch_row,"count"=>$fetch_count);
	}
	else{
		return array("sql"=>"","result"=>$fetch_exec,"row"=>"","count"=>0);
	}
	
}

function update(){
	$con=mysqli_connect("localhost","root","","online_banking");
	$args=func_get_args();
	$args_count=count($args);
	switch ($args_count) {
		case 3:
			$update_exec=mysqli_query($con,"UPDATE $args[0] SET $args[1] WHERE $args[2]");
			break;
		case 5:
			$update_exec=mysqli_query($con,"UPDATE $args[0] SET $args[1] WHERE $args[2] $args[3] $args[4]");
			break;
	}
	
	if(!$update_exec){
			echo "update error";
			die();
		}
}

function insert($table,$array){
	$con=mysqli_connect("localhost","root","","online_banking");
	$key=array_keys($array);
	$val=array_values($array);
	$insert_sql="INSERT INTO $table(" . implode(',', $key) . ") ". "VALUES ('" . implode("', '", $val) . "')";
	$insert_exec=mysqli_query($con,$insert_sql);
	if(!$insert_exec){
		echo "insert error";
		die();
	}
	return $insert_sql;
}

function delete($table,$condition){
	$con=mysqli_connect("localhost","root","","online_banking");
	$delete_sql="DELETE FROM $table WHERE $condition";
	$delete_exec=mysqli_query($con,$delete_sql);
	if(!$delete_exec){
		print_r($delete_sql);
		echo "delete error";
		die();
	}
}

?>
