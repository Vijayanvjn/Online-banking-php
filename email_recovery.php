<?php require_once('function.php'); ?>

<!DOCTYPE html>
<html>
    <head>
        <title>Password Recovery</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="css/login.css" />
        <link rel="stylesheet" type="text/css" href="css/media.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Satisfy&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />

    </head>
    <body>
<?php
$usererr="";
$emailerr="";
$user="";
$email="";
$count=0;
$otp_count=0;
$status=0;
$admin_password="";
$otp="";
$otperr="";
$otpsuccess="";
$con=mysqli_connect("localhost","root","");
mysqli_select_db($con,"online_banking");
date_default_timezone_set("Asia/Kolkata");
if(!$con){
    echo "Not connected with server";
}
if(isset($_POST['send_otp'])){
    $user=$_POST['username'];
    $email=$_POST['email'];
    $sql=fetch("user","username='$user'");
    $row=$sql['row'];
    $id=$row['id'];
    $num=$sql['count'];
    // $sql="SELECT * FROM user WHERE username='$user'";
    // $sql2="SELECT * FROM user WHERE username='$user'&&password='$pass'";
    $admin_sql=fetch("admin","username='$user'");
    $admin_row=$admin_sql['row'];
    $admin_num=$admin_sql['count'];
    $match_user_count=fetch("user","username='$user'",'AND',"email='$email'")['count'];
    $match_admin_count=fetch("admin","username='$user'",'AND',"email='$email'")['count'];
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
    if($email==""){
        $emailerr="Email should not be empty";
        $count=$count+1;
    }
    else
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailerr="Invalid Email";
                $count=$count+1;
    }
    else
        if($match_user_count==0&&$match_admin_count==0){
            $emailerr="This email is not registered with your account";
            $count=$count+1;
        }
        else{
            $emailerr="";
        }
    if($count==0){
    $otp=rand(100000,999999);
    require 'PHPMailerAutoload.php';

    $mail = new PHPMailer;

    // $mail->SMTPDebug = 4;                               // Enable verbose debug output

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'vijayanpn1000@gmail.com';                 // SMTP username
    $mail->Password = 'Vijayanvjnpn@1000';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    $mail->setFrom('vijayanpn1000@gmail.com', 'Vijayan');
    $mail->addAddress($email);
    $mail->addReplyTo('vijayanpn1000@gmail.com', 'Vijayan');

    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = 'OTP Verification for Online Banking Login';
    $mail->Body    = 'Your OTP To Recover Online Banking is <b>'.$otp.'</b>';
    if(!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        $otp_success="OTP Successfully sent to your mobile number";
        $otp_array=array("otp"=>$otp,"is_expired"=>"0","create_at"=>date("Y-m-d H:i:s"),"belongs"=>$email);
        insert("otp_expiry",$otp_array);
    }    
    }
}
if(isset($_POST['otp'])){
    $user=$_POST['username'];
    $email=$_POST['email'];
    $otp_count=0;
    $otp=$_POST['otp'];
    $verify_otp=fetch("otp_expiry","otp='$otp'",'AND',"is_expired=0",'AND',"belongs='$email'",'AND',"NOW()<=DATE_ADD(create_at, INTERVAL 15 MINUTE)")['count'];
    if($otp==""){
        $otperr="Please enter OTP";
        $otp_count=$otp_count+1;
    }
    else
        if($verify_otp==0){
            $otperr="This OTP is Not valid";
            $otp_count=$otp_count+1;
        }
    else{
        $otperr="";
    }
}
?>  
        <h1 class="text-center">Recover with email</h1>
        <form action="email_recovery.php" method="POST">
            <div class="wrapper">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" value="<?php echo "$user"; ?>" />
                            <span> <?php echo $usererr; ?> </span>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control" value="<?php echo "$email"; ?>"/>
                            <span> <?php echo $emailerr; ?> </span>
                        </div>
                        <input type="submit" name="send_otp" id="login" value="Send OTP" class="btn btn-primary text-center"/>
                        <p class="success"><?php echo $otpsuccess; ?></p>
                        <div class="form-group">
                            <label>OTP</label>
                            <input type="text" name="otp" class="form-control" value="<?php echo "$otp"; ?>"/>
                            <span> <?php echo $otperr; ?> </span>
                        </div>
                        <input type="submit" name="verify" id="login" value="Verify" class="btn btn-primary text-center"/>
                        <p id="signup"> <a href="login.php"> Back to Login </a> </p> 
                        <p id="signup"> Not have a account Yet!  <a href="signup.php"> Signup </a> </p> 
            </div>
        </form>

    </body>
</html>
