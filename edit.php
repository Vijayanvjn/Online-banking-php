<?php require("deductions.php"); ?>
<?php require("session.php"); ?>
<?php require_once('function.php'); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Signup</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="css/signup.css" />
        
    </head>
    <body>
        <?php

        $user_id=$_GET['user_id'];
        $user=$_GET['user'];
        $con=mysqli_connect("localhost","root","","online_banking");
        $user_row=fetch("user","id='$user_id'");
        // $user_sql="SELECT * FROM user WHERE id='$user_id'";
        // $user_res=mysqli_query($con,$user_sql);
        // $user_row=mysqli_fetch_assoc($user_res);
        $username=$user_row['username'];
        $password=$user_row['password'];
        $conf_pass=$user_row['password'];
        $email=$user_row['email'];
        $phone=$user_row['phone'];
        $address=$user_row['address'];
        $branch=$user_row['branch'];
        $accno=$user_row['accno'];
        $acctype=$user_row['acctype'];
        $ifsc=$user_row['ifsc'];
        $usererr="";
        $passerr="";
        $confirmerr="";
        $accnoerr="";
        $ifscerr="";
        $brancherr="";
        $emailerr="";
        $phoneerr="";
        $addresserr="";
        if(isset($_POST['update'])){
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
            $sql=fetch("user","username='$username'");
            $accsql=fetch("user","accno='$accno'");
            // $sql= "SELECT * FROM user WHERE username='$username'";
            // $accsql="SELECT * FROM user WHERE accno='$accno'";
            if(!$sql){
                echo "Not connected query";
            }
            $row=$sql['row'];
            // $res2=mysqli_query($con,$accsql);
            // $row=mysqli_fetch_assoc($res);
            if(!$res){
                echo "error";
            }
            $num=$sql['count'];
            $num2=$accsql['count'];
            $length=strlen($username);
            if ($length<3){
                $usererr="Username must contain 4 letters";
                $count=$count+1;
            }
            else
            if($num==1){
                $usererr=$row['username'];
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
        }
        ?>
        <h1 class="text-center">Signup Here</h1>
        <form method="POST">
        	<div class="wrapper">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" value="<?php 
                            if($_POST){
                                echo $_POST['username'];
                            }
                            else 
                            if($_GET){
                            echo $username; 
                            } 
                            ?>" />
                            <span> <?php echo $usererr; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" value="<?php 
                            if($_POST){
                                echo $_POST['password'];
                            }
                            else 
                            if($_GET){
                            echo $password; 
                            } 
                            ?>" />
                            <span> <?php echo $passerr; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" name="confirm" class="form-control" value="<?php 
                            if($_POST){
                                echo $_POST['confirm'];
                            }
                            else 
                            if($_GET){
                            echo $conf_pass; 
                            } 
                            ?>" />
                            <span> <?php echo $confirmerr; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Account Number</label>
                            <input type="text" name="accno" class="form-control" value="<?php 
                            if($_POST){
                                echo $_POST['accno'];
                            }
                            else 
                            if($_GET){
                            echo $accno; 
                            } 
                            ?>"/>
                            <span> <?php echo $accnoerr; ?></span>
                        </div>
                        <div class="form-group">
                            <label>IFSC</label>
                            <input type="text" name="ifsc" class="form-control" value="<?php if($_POST){
                                echo $_POST['ifsc'];
                            }
                            else 
                            if($_GET){
                            echo $ifsc; 
                            } 
                            ?>"/>
                            <span> <?php echo $ifscerr; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Branch</label>
                            <input type="text" name="branch" class="form-control" value="<?php if($_POST){
                                echo $_POST['branch'];
                            }
                            else 
                            if($_GET){
                            echo $branch; 
                            } 
                            ?>"/>
                            <span> <?php echo $brancherr; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control" value="<?php if($_POST){
                                echo $_POST['email'];
                            }
                            else 
                            if($_GET){
                            echo $email; 
                            } 
                            ?>"/>
                            <span> <?php echo $emailerr; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Account Type</label>
                            <select class="form-control acc-type" name="acctype" id="acctype">
                                <option value="savings" name="savings">Savings Account</option>
                                <option value="salary"  name="salary"> Salary Account </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control" value="<?php if($_POST){
                                echo $_POST['phone'];
                            }
                            else 
                            if($_GET){
                            echo $phone; 
                            } 
                            ?>"/>
                            <span> <?php echo $phoneerr; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea class="form-control" name="address"><?php
                                    if($_POST){
                                        echo $_POST['address'];
                                    }
                                    else
                                        if($_GET){
                                            echo trim($address);      
                                        }
                                ?>        
                            </textarea>
                            <span> <?php echo $addresserr; ?></span>
                        </div>
                        <input type="submit" name="signup" id="signup" value="Update" class="btn btn-primary text-center"/>
       		</div>
        </form>

    </body>
</html>
