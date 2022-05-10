<?php


require 'connect_DB.php';


?>

<html>
<head>
<title>Registration </title>
<link rel="stylesheet" type="text/css" href="sstyle.css">
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
	<div class="box" >
		<div class="login-box">
	
			<h2> Registration  </h2>
			<form method='post'>
				<div>
                    <select name="type" class="form-control">
                        <option value="Teacher" >Teacher</option>
                        <option value="Student" >Student</option>
                    </select>
        
                </div>
            
                <div class="form-group">
					<label>Email</label>
					<input type="email" name="email" class="form-control" required>
				</div>

				<div class="form-group">
					<label>password</label>
					<input type="password" name="password" class="form-control" required>
				</div>
                <div class="form-group">
					<label>Secret Code</label>
					<input type="password" name="code" class="form-control" required>
				</div>
                <div class="form-group">
					<label>Name</label>
					<input type="text" name="name" class="form-control" required>
				</div>
                <div class="form-group">
					<label>Phone Number</label>
					<input type="text" name="phone" class="form-control" value="">
				</div>
                <div class="form-group">
					<label>Department Name</label>
					<input type="text" name="dept" class="form-control"  value="">
				</div>

				<button type="submit" class="btn btn-primary  btn-block" name="loginSubmit" > Login</button>

			</form> 
		</div>
        
            

	</div>

    <?php 




if(isset($_POST["loginSubmit"]))
{

    $datatableLogin ="login";


    $email = $_POST['email'];
    $pass = $_POST['password'];
    $type = $_POST['type'];
    $code = $_POST['code'];
    $name = $_POST['name'];
    $dept = $_POST['dept'];
    $phone = $_POST['phone'];
    
    $s = "select * from $datatableLogin where email='$email' ";
    $result = mysqli_query($con,$s);
    $num = mysqli_num_rows($result);

   




    if($num==0&&($code==47&&$type=="Teacher")||($code==67&&$type=="Student"))
    {
        session_start();


        $query = "INSERT INTO $datatableLogin VALUES('','$email','$pass','$type','$name','$dept','$phone','') ";

        mysqli_query($con,$query);


        $s = "select * from $datatableLogin where email='$email' && password = '$pass' && type='$type' ";
        $result = mysqli_query($con,$s);
        $var = mysqli_fetch_assoc($result);


        $_SESSION['id']= $var["id"];
        $_SESSION['email']= $email ;
        $_SESSION['pass']= $pass ;
        $_SESSION['name']= $name ;
        $_SESSION['dept']=$dept ;
        $_SESSION['phone']=$phone ;
        $_SESSION['type']=$type;

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
        echo "Secret code wrong or Email already exist";
    }



}




  
?>





</body>


</html>