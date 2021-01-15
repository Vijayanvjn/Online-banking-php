<?php require("deductions.php"); ?>
<?php require_once('function.php'); ?>
<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Student</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="css/savings_home.css" />
    <link rel="stylesheet" type="text/css" href="css/transfer.css" />
    <link rel="stylesheet" type="text/css" href="css/index.css" />
    <link rel="stylesheet" type="text/css" href="css/media.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Satisfy&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
</head>
<body>
	<?php
		$user=$_GET['user'];
		$user_id=$_GET['user_id'];
		$edit_id=$_GET['edit_id'];
		$con=mysqli_connect("localhost","root","","online_banking");
        $row=fetch("user","id='$edit_id'")['row'];
		// $sql="SELECT * FROM user WHERE id='$edit_id'";
		// $res=mysqli_query($con,$sql);
		// $row=mysqli_fetch_assoc($res);
		$username=$row['username'];
		$pass=$row['password'];
		$conf_pass="";
		$email=$row['email'];
		$mobile=$row['phone'];
		$address=$row['address'];
		$branch=$row['branch'];;
		$accno=$row['accno'];
		$recovery=$row['recovery_mail'];
		$ifsc=$row['ifsc'];
		$pin=$row['pin'];

		$usererr="";
		$passerr="";
		$conf_passerr="";
		$emailerr="";
		$mobileerr="";
		$addresserr="";
		$brancherr="";
		$accnoerr="";
		$recoveryerr="";
		$ifscerr="";
		$pinerr="";
		$count=0;
		if(isset($_POST['change'])){
			$username=$_POST['username'];
			$password=$_POST['password'];
			$conf_pass=$_POST['conf-pass'];
			$email=$_POST['email'];
			$mobile=$_POST['mobile'];
			$address=$_POST['address'];
			$branch=$_POST['branch'];
			$accno=$_POST['accno'];
			$recover=$_POST['address'];
			$branch=$_POST['branch'];
			$accno=$_POST['accno'];
			$recovery=$_POST['recovery'];
			$ifsc=$_POST['ifsc'];
			$pin=$_POST['pin'];
            $sql=fetch("user","username='$username'");
            $row=$sql['row'];
            $num=$sql['count'];
			// $sql= "SELECT * FROM user WHERE username='$username'";
            $accsql=fetch("user","accno='$accno'");
            $num2=$accsql['count'];
            // $accsql="SELECT * FROM user WHERE accno='$accno'";
            $idsql=fetch("user","id='$edit_id'");
            $row_id=$idsql['row'];
            // $idsql="SELECT * FROM user WHERE id='$edit_id'";
            // $res_id=mysqli_query($con,$idsql);
            // $row_id=mysqli_fetch_assoc($res_id);
            
            // $res=mysqli_query($con,$sql);
            // $res2=mysqli_query($con,$accsql);
            // $num=mysqli_num_rows($res);
            // $num2=mysqli_num_rows($res2);
            $length=strlen($username);
            if ($length<3){
                $usererr="Username must contain 4 letters";
                $count=$count+1;
            }
            else
            if($num==1&&$username!=$row_id['username']){
                $usererr="Username already taken";
                $count=$count+1;
            }
            else
                if($username==""){
                    $usererr="Username should not empty";
                    $count=$count+1;
                }
            else{
                $usererr="";
            }
            
            if($pass==""){
                $passerr="Password should not empty";
                $count=$count+1;
            }
            else
                if(!preg_match('/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/',$password)){
                    $passerr="Password Must contain 8 characters, Must have with one Special-character and one Uppercase";
                    $count=$count+1;
                }
            else{
                $passerr="";
            }

            if($email==""){
                $emailerr="Email should not empty";
                $count=$count+1;
            }
            else

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailerr="Invalid Email";
                $count=$count+1;
            }

            else{
                $emailerr="";
            }

            if($conf_pass==""){
                $conf_passerr="Confirm password should not empty";
                $count=$count+1;
            }
            else
                if($pass!=$conf_pass){
                    $confirmerr="Password and confirm password doesn't match";
                    $count=$count+1;
                }
            else{
                $confirmerr="";
            }
            if($mobile==""){
                $mobileerr="Phone number should not be empty";
                $count=$count+1;
            }
            else     

                if(!preg_match("/^[6-9]\d{9}$/", $mobile)) {
                    $mobileerr="Phone number is invalid";
                    $count=$count+1;
                }
            else{
                $mobileerr="";
            }
            if($address==""){
                $addresserr="Address Should not be empty";
                $count=$count+1;
            }
            else{
                $addresserr="";
            }
            if($branch==""){
                $brancherr="Branch should not be empty";
                $count=$count+1;
            }
            else
                if(!preg_match("/^[A-Za-z]+$/", $branch)){
                    $brancherr="Please enter valid branch";
                    $count=$count+1;
                }
            else{
                $brancherr="";
            }
            if($ifsc==""){
                $ifscerr="Ifsc should not be empty";
                $count=$count+1;
            }
            else
                if((substr($accno,-4,4))!=(substr($ifsc,-4,4))){
                    $ifscerr="Incorrect IFSC";
                    $count=$count+1;
            }
            else{
                $ifscerr="";
            }
            if($accno==""){
                $accnoerr="Account Number should not be empty";
                $count=$count+1;
            }
            else
                if($num2==1&&$accno!=$row_id['accno']){
                    $accnoerr="Account Number already exists";
                    $count=$count+1;
                }
            else
                if(!preg_match("/^[0-9]{16}$/", $accno)){
                    $accnoerr="Invalid Account Number";
                    $count=$count+1;
                }
            else{
                $accnoerr="";
            }
            if($pin==""){
				$pinerr="Please enter Your UPI Pin";
				$count=$count+1;
			}
			else
				if(!preg_match("/^[0-9]{4}$/",$pin)){
					$pinerr="Your pin should be 4 digit number";
					$count=$count+1;
				}
			else{
				$pinerr="";
			}

			if($count==0){
                update("user","username='$username',password='$pass',email='$email',phone='$mobile',address='$address',branch='$branch',ifsc='$ifsc',accno='$accno',pin='$pin'","id='$edit_id'");
				// $sql="UPDATE user SET username='$username',password='$pass',email='$email',phone='$mobile',address='$address',branch='$branch',ifsc='$ifsc',accno='$accno',pin='$pin' WHERE id='$edit_id'";
				// $res=mysqli_query($con,$sql);
				header("location:users_list.php?user=$user&user_id=$user_id");
			}
		}
	?>
	<div>
				<?php include "admin-sidemenu.php" ?>
				<div class="body-cntn">
					<?php include "admin_header.php" ?>
						<form class="form-custom" method="POST">
							<label>Username</label>
							<input type="text" name="username" value="<?php echo $username; ?>">
							<p class="err"><?php echo $usererr; ?></p>
							<label>Password</label>
							<input type="text" name="password" value="<?php echo $pass; ?>">
							<p class="err"><?php echo $passerr; ?></p>
							<label>Confirm Password</label>
							<input type="text" name="conf-pass" value="<?php echo $pass; ?>">
							<p class="err"><?php echo $conf_passerr; ?></p>
							<label>Email</label>
							<input type="text" name="email" value="<?php echo $email; ?>">
							<p class="err"><?php echo $emailerr; ?></p>
							<label>Mobile</label>
							<input type="text" name="mobile" value="<?php echo $mobile; ?>">
							<p class="err"><?php echo $mobileerr; ?></p>
							<label>Address</label>
							<input type="text" name="address" value="<?php echo $address; ?>">
							<p class="err"><?php echo $addresserr; ?></p>
							<label>Branch</label>
							<input type="text" name="branch" value="<?php echo $branch; ?>">
							<p class="err"><?php echo $brancherr; ?></p>		
							<label>Account Number</label>
							<input type="text" name="accno" value="<?php echo $accno; ?>">
							<p class="err"><?php echo $accnoerr; ?></p>			
							<label>Recovery Email</label>
							<input type="text" name="recovery" value="<?php echo $recovery; ?>">
							<p class="err"><?php echo $recoveryerr; ?></p>
							<label>IFSC</label>
							<input type="text" name="ifsc" value="<?php echo $ifsc; ?>">
							<p class="err"><?php echo $ifscerr; ?></p>
							<label>UPI-Pin</label>
							<input type="text" name="pin" value="<?php echo $pin; ?>">
							<p class="err"><?php echo $pinerr; ?></p>
							<input class="btn" type="submit" name="change" value="Change">
						</form>	
				</div>	
	</div>
</body>
</html>