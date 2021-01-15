<?php
    
   if(isset($_POST['profile'])){

       // Getting file name
       $filename = $_FILES['image']['name'];
         
       // Valid extension
       $valid_ext = array('png','jpeg','jpg');

			
	   $photoExt1 = @end(explode('.', $filename)); // explode the image name to get the extension
	   $phototest1 = strtolower($photoExt1);
			
	   $new_profle_pic = time().'.'.$phototest1;
			
       // Location
       $location = "uploads/".$new_profle_pic;

       // file extension
       $file_extension = pathinfo($location, PATHINFO_EXTENSION);
       $file_extension = strtolower($file_extension);

       // Check extension
       if(in_array($file_extension,$valid_ext)){  

            // Compress Image
            compressedImage($_FILES['image']['tmp_name'],$location,60);	
    		    $conn=mysqli_connect("localhost","root","","online_banking");
            update("user","image='$new_profle_pic'","id='$user_id'");
      			// $profile_sql="UPDATE user SET image='$new_profle_pic' WHERE id='$user_id'";
      			// mysqli_query($conn,$profile_sql);

        }
	    else
        {
                echo "File format is not correct.";
        }
    }

    // Compress image
    function compressedImage($source, $path, $quality) {

            $info = getimagesize($source);

            if ($info['mime'] == 'image/jpeg') 
                $image = imagecreatefromjpeg($source);

            elseif ($info['mime'] == 'image/gif') 
                $image = imagecreatefromgif($source);

            elseif ($info['mime'] == 'image/png') 
                $image = imagecreatefrompng($source);

            imagejpeg($image, $path, $quality);

    }

 ?>