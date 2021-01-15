<?php require_once('function.php'); ?>
<?php
session_start();
$usererr="";
$passerr="";
$user="";
$pass="";
$count=0;
$admin_password="";
$con=mysqli_connect("localhost","root","");
mysqli_select_db($con,"online_banking");
if(!$con){
	echo "Not connected with server";
}
if(isset($_POST['login'])){
	$user=$_POST['username'];
	$pass=$_POST['password'];
    $sql=fetch("user","username='$user'");
    $row=$sql['row'];
    $num=$sql['count'];
	// $sql="SELECT * FROM user WHERE username='$user'";
    $sql2=fetch("user","username='$user'",'AND',"password='$pass'");
    $num2=$sql2['count'];
	// $sql2="SELECT * FROM user WHERE username='$user'&&password='$pass'";
    $admin_sql=fetch("admin","username='$user'");
    $admin_row=$admin_sql['row'];
    $admin_num=$admin_sql['count'];
    // $admin_sql="SELECT * FROM admin";
    // $admin_res=mysqli_query($con,$admin_sql);
    // $admin_row=mysqli_fetch_assoc($admin_res);
    if($admin_num!=0){
        $admin_password=$admin_row['password'];    
    }
    
    // $admin_num=mysqli_num_rows($admin_res);
	// $admin="SELECT * FROM admin WHERE username='$user'&&password='$pass'";
	// $exec_admin=mysqli_query($con,$admin);
	// $res_admin=mysqli_fetch_assoc($exec_admin);
	// echo $res_admin['username'];
	// echo $res_admin['password'];
	// $num_admin=mysqli_num_rows($exec_admin);
	// $res=mysqli_query($con,$sql);
 //    $row=mysqli_fetch_assoc($res);
	// $res2=mysqli_query($con,$sql2);
 //    // $num=mysqli_num_rows($res);
 //    $num2=mysqli_num_rows($res2);
	if($user==""){
		$usererr="Username should not be empty";
		$count=$count+1;
	}
	else
	// if($num==0&&$num_admin==0){
		if($num==0 && $admin_num==0){
    	$usererr="Username not exists";
    	$count=$count+1;
    }
    else{
    	$usererr="";
    }
    if($pass==""){
    	$passerr="Password should not be empty";
    	$count=$count+1;
    }
    else
    	
    	if($num2==0 && $admin_password!=$pass) {
    		$passerr="Password is incorrect";
    		$count=$count+1;
    	}
	    else{
	    	$passerr="";
	    }
    if($count==0){
        $_SESSION['logged_in']='$user';
        $_SESSION['login_id']='$user_id';
        $_SESSION['time']=time();
        
        if($user==$admin_row['username']){
            $user_id=$admin_row['id'];
            $user=$admin_row['username'];
            header('location:users_list.php?user='.$user."&user_id=".$user_id);
        }
        else{
            $user_id=$row['id'];    
            header('location:savings_home.php?user='.$user."&user_id=".$user_id);
        }
    
    	}
}
?>