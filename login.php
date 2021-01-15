<?php include('loginval.php')?>
<?php  
    $name=$user;
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="css/login.css" />
        <link rel="stylesheet" type="text/css" href="css/media.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Satisfy&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />

    </head>
    <body>

        <h1 class="text-center">Login Here</h1>
        <form action="login.php" method="POST">
            <div class="wrapper">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" value="<?php echo "$user"; ?>" />
                            <span> <?php echo $usererr; ?> </span>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" value="<?php echo "$pass"; ?>"/>
                            <span> <?php echo $passerr; ?> </span>
                        </div>
                        <input type="submit" name="login" id="login" value="login" class="btn btn-primary text-center"/>
                        <p id="signup"><a href="email_recovery.php">Forget Password</a></p>
                        <p id="signup"> Not have a account Yet!  <a href="signup.php"> Signup </a> </p> 
            </div>
        </form>

    </body>
</html>
