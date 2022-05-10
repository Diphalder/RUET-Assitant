<?php

require 'connect_DB.php';

session_start();
$id =    $_SESSION['id'];


$dtPhoto='photo';


$dtlogin='login';
$s = "select * from $dtlogin where id=$id   ";
$r = mysqli_query($con,$s);
$v = mysqli_fetch_assoc($r);
$name=$v['name'];
$email= $v['email'];
$pass= $v['password'];
$type=$v['type'];
if($type=='Student')
{
    $roll=$v['roll'];
}
$dept=$v['dept'];
$phone=$v['phone'];



?>







<html>
<head>
<title>Edit Profile </title>
<link rel="stylesheet" type="text/css" href="sstyle.css">
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
     
	<div class="box" >
    
		<div class="login-box">
	
			<h2> Edit Profile  </h2>
            <label>Profile picture</label>

            <div class="minibox"  >
          

<?php 

    
    $sql = "SELECT * FROM $dtPhoto WHERE personID=$id ORDER BY id DESC";
    $res = mysqli_query($con,  $sql);

    if (mysqli_num_rows($res) != 0) {
          $image = mysqli_fetch_assoc($res) 
            ?>

            <div class="d-flex justify-content-center" >
             <img src="uploads/<?=$image['image_url']?>" height="150"  >
        </div>
        <?php 
    }
    else
    {
        ?>
        <div class="d-flex justify-content-center" >
        <img src="uploads/blank.webp"  height="150" >
   </div>
   <?php 

    }
        
?>
</div>

<div class="minibox"  >

<form class="" method="post" enctype="multipart/form-data">

    <div class="form-group"><input type="file" name="my_image"></div>
    <div class="form-group"> <input type="submit"  name="submitPhoto" value="Upload"></div>
     

</form>
</div>







			<form method='post'>
            

				<div class="form-group">
					<label>password</label>
					<input type="password" name="password" class="form-control"  value="<?php echo $pass ?>" required>
				</div>
                <div class="form-group">
					<label>Re-password</label>
					<input type="password" name="repassword" class="form-control"  value="<?php echo $pass ?>" required>
				</div>
                <div class="form-group">
					<label>Name</label>
					<input type="text" name="name" class="form-control"  value="<?php echo $name ?>" required>
				</div>

                <?php
                if($type=='Student')
                {
                    ?>
                      <div class="form-group">
					<label>Roll</label>
					<input type="text" name="roll" class="form-control"  value="<?php echo $roll ?>">
				    </div>

                    <?php
                    
                }
                
                ?>
                <div class="form-group">
					<label>Phone Number</label>
					<input type="text" name="phone" class="form-control"  value="<?php echo $phone ?>">
				</div>
                <div class="form-group">
					<label>Department Name</label>
					<input type="text" name="dept" class="form-control" value="<?php echo $dept ?>" required>
				</div>

				<button type="submit" class="btn btn-primary  btn-block" name="loginSubmit" > SAVE</button>

			</form> 
		</div>
        
            

	</div>

    <?php 


if (isset($_POST['submitPhoto']) && isset($_FILES['my_image'])) {



	$img_name = $_FILES['my_image']['name'];
	$img_size = $_FILES['my_image']['size'];
	$tmp_name = $_FILES['my_image']['tmp_name'];
	$error = $_FILES['my_image']['error'];

	if ($error === 0) {
		if ($img_size > 12500000) {
            echo "<script> alert('Sorry, your file is too large.');</script>";

		    //header("Location:  student.php?error=$em");
		}else {
			$img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
			$img_ex_lc = strtolower($img_ex);

			$allowed_exs = array("jpg", "jpeg", "png"); 

			if (in_array($img_ex_lc, $allowed_exs)) {
				$new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
				$img_upload_path = 'uploads/'.$new_img_name;
				move_uploaded_file($tmp_name, $img_upload_path);

				// Insert into Database
				$sql = "INSERT INTO $dtPhoto  VALUES('',$id,'$new_img_name')";
				mysqli_query($con, $sql);
                echo "<script> alert('Image saved');</script>";
				header("Location:  editProfile.php");
			}else {
                echo "<script> alert('You can't upload files of this type');</script>";
		        //header("Location:  student.php?error=$em");
			}
		}
	}
    else {
        echo "<script> alert('unknown error occurred!');</script>";
		//header("Location:  student.php?error=$em");
	}

}


if(isset($_POST["loginSubmit"]))
{

    $datatableLogin ="login";

    $pass = $_POST['password'];
    $repass = $_POST['repassword'];
    $name = $_POST['name'];
    $dept = $_POST['dept'];
    $phone = $_POST['phone'];

    if($pass==$repass)
    {  
        
        
        $s = "UPDATE $dtlogin SET name='$name',dept='$dept', phone='$phone', password='$pass'  where id=$id ";
        mysqli_query($con,$s);

        if($type=='Student')
        {
               $s = "UPDATE $dtlogin SET roll='$roll'  where id=$id ";
                 mysqli_query($con,$s);
        }
    
        if($type=="Teacher"){
    
            header('location:teacher.php');
    
        }
        if($type=="Student")
        {
            header('location:student.php');
    
        }

    }
    else
    {
        echo "<script>alert('password is diffrent');</script>";

    }
    
  



}




  
?>





</body>


</html>