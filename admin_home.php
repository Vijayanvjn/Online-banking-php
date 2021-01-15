<?php session_start(); ?>
<?php require("session.php"); ?>
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
	<div class="transfer">
				<?php include "admin-sidemenu.php" ?>
				<div class="body-cntn">
				    <?php include "header.php" ?>
		            <div class="container-fluid transfer-entry">
                      <div class="row">
                          <div class="col-md-6">
                            <div class="acc-trans">
                              <i class="fa fa-bank"></i>
                              <a href="<?php echo "transfer-acc.php?user=$user&user_id=$user_id"  ?>" class="btn lg-btn">Transfer to Account Number</a>
                            </div>
                          </div>
                          <div class="col-md-6">
                              <div class="rec-trans">
                                  <i class="fa fa-users"> </i>
                                  <a href="<?php echo "transfer-res.php?user=$user&user_id=$user_id"  ?>" class="btn lg-btn">Transfer to recipient</a>
                              </div>
                          </div>
                      </div>
                    </div>  
				</div>	
	</div>
</body>
</html>
								