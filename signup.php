<?php require("deductions.php"); ?>
<?php require_once('function.php'); ?>
<?php include('server.php'); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Signup</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="css/signup.css" />
        
    </head>
    <body>
        <h1 class="text-center">Signup Here</h1>
        <form action="signup.php" method="POST">
        	<div class="wrapper">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" value="<?php echo $username ?>" />
                            <span> <?php echo $usererr; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" value="<?php echo $password ?>"/>
                            <span> <?php echo $passerr; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" name="confirm" class="form-control" value="<?php echo $confirm ?>"/>
                            <span> <?php echo $confirmerr; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Account Number</label>
                            <input type="text" name="accno" class="form-control" value="<?php echo $accno ?>"/>
                            <span> <?php echo $accnoerr; ?></span>
                        </div>
                        <div class="form-group">
                            <label>IFSC</label>
                            <input type="text" name="ifsc" class="form-control" value="<?php echo $ifsc ?>"/>
                            <span> <?php echo $ifscerr; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Branch</label>
                            <input type="text" name="branch" class="form-control" value="<?php echo $branch ?>"/>
                            <span> <?php echo $brancherr; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control" value="<?php echo $email ?>"/>
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
                            <input type="text" name="phone" class="form-control" value="<?php echo $phone ?>"/>
                            <span> <?php echo $phoneerr; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea class="form-control" name="address"><?php echo $address;?></textarea>
                            <span> <?php echo $addresserr; ?></span>
                        </div>
                        <input type="submit" name="signup" id="signup" value="Signup" class="btn btn-primary text-center"/>
                        <p id="login"> Already have a account <a href="login.php"> Login </a> </p> 
       		</div>
        </form>

    </body>
</html>
