<?php require_once('function.php'); ?>
     <?php
            $count=0;
            $usererr="";
            $passerr="";
            $emailerr="";
            $confirmerr="";
            $accnoerr="";
            $brancherr="";
            $phoneerr="";
            $addresserr="";
            $acctypeerr="";
            $username="";
            $password="";
            $email="";
            $confirm="";
            $accno="";
            $branch="";
            $phone="";
            $address="";
            $acctype="";
            $ifsc="";
            $ifscerr="";
            $con=mysqli_connect('localhost','root','','online_banking');
            mysqli_select_db($con,'online_banking');
            if(!$con){
                die("Cannot connect with server");
            }

        if (isset($_POST['signup'])){
            $username=$_POST['username'];
            $password=$_POST['password'];
            $email=$_POST['email'];
            $confirm=$_POST['confirm'];
            $accno=$_POST['accno'];
            $branch=$_POST['branch'];   
            $phone=$_POST['phone'];
            $address=$_POST['address'];
            $acctype=$_POST['acctype'];
            $ifsc=$_POST['ifsc'];
            $balance= "0";
            $sql=fetch("user","username='$username'");
            $row=$sql['row'];
            $count=$sql['count'];
            // $sql= "SELECT * FROM user WHERE username='$username'";
            $accsql=fetch("user","accno='$accno'");
            $res2=$accsql['result'];
            $num2=$accsql['count'];
            // $accsql="SELECT * FROM user WHERE accno='$accno'";
            // $res=mysqli_query($con,$sql);
            // $res2=mysqli_query($con,$accsql);
            // $row=mysqli_fetch_assoc($res);
            // $num=mysqli_num_rows($res);
            // $num2=mysqli_num_rows($res2);
            $length=strlen($username);
            if ($length<3){
                $usererr="Username must contain 4 letters";
                $count=$count+1;
            }
            else
            if($num==1){
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
            
            if($password==""){
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

            if($confirm==""){
                $confirmerr="Confirm password should not empty";
                $count=$count+1;
            }
            else
                if($password!=$confirm){
                    $confirmerr="Password and confirm password doesn't match";
                    $count=$count+1;
                }
            else{
                $confirmerr="";
            }
            if($phone==""){
                $phoneerr="Phone number should not be empty";
                $count=$count+1;
            }
            else     

                if(!preg_match("/^[6-9]\d{9}$/", $phone)) {
                    $phoneerr="Phone number is invalid";
                    $count=$count+1;
                }
            else{
                $phoneerr="";
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
                if($num2==1){
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
            if($count==0){
                $user_array=array("username"=>$username,"password"=>$password,"email"=>$email,"phone"=>$phone,"address"=>$address,"branch"=>$branch,"accno"=>$accno,"acctype"=>$acctype,"balance"=>$balance,"ifsc"=>$ifsc);
                insert("user",$user_array);
                // $sql2= "INSERT INTO user (username, password,email,phone,address,branch,accno,acctype,balance,ifsc) 
                //         VALUES ('$username','$password',
                //         '$email','$phone','$address','$branch','$accno','$acctype','$balance','$ifsc')";
                // mysqli_query($con,$sql2);
                header('location:login.php');
            }

            }   
    ?>