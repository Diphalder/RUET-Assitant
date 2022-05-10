<?php

require 'connect_DB.php';

session_start();
$id =    $_SESSION['id'];
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




$dtPhoto='photo';


if($type!="Teacher"){

    header('location:main.php');

}


?>





<html>
<head>
<title> login and registration </title>
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="sstyle.css">
</head>
<body>



<div class="list">

 

    <div class="row">
            <div class="col-sm-3">
                <div class="minibox">
                    <div class="d-flex justify-content-center">
                        <p><h4><?php echo $name ?></h4></p>
                    </div>
                </div>
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
        

            </div>
            <div class="col-sm-7">
                <div class="minibox">
                    <div style="padding-left: 50px; padding-right :50px " >   
                        <table >
                        <tr>
                            <td><h6><p>Email  </p></h6></td>
                            <td><h6><p>:    <?php echo $email ;?></p></h6></td>
                        </tr>
                        <tr>
                            <td><h6><p>Phone No.  </p></h6></td>
                            <td><h6><p>:    <?php echo $phone; ?></p></h6></td>
                        </tr>
                        <tr>
                            <td><h6><p>Dept.  </p></h6></td>
                            <td><h6><p>:    <?php echo $dept ;?></p></h6></td>
                        </tr>
                      

                        </table>
                    </div>
                </div>


                <div class="d-flex justify-content-end" style="margin: 10px;">
                    <a href="editProfile.php"><button class="btn btn-success ">Edit Profile</button> </a>    
                </div>
                
            </div>
            <div class="col-sm-2">

                <div class="d-flex justify-content-end" style="margin: 10px;">
                    <a href="logout.php"><button class="btn btn-danger btn-block">logout</button> </a>
                </div>
            



            </div>
           

    </div>


</div>
  
<div class="list" >
    <div class="d-flex justify-content-center">
    <div class="btn-group">
        <form  method='post'>
            <button type="submit" class="btn btn-primary" name="viewCourse" >view Courses list</button>
        </form>
    </div>

    <div class="btn-group">
    <form  method='post'>
                <button type="submit" class="btn btn-primary" name="attendance" >take Attendance</button>
            </form>
       
    </div>
    <div class="btn-group">
        <form  method='post'>
                <button type="submit" class="btn btn-primary"  name="viewAttendance" >view Attendance-Sheet</button>
            </form>

    </div>
    <div class="btn-group">
            <form  method='post'>
                <button type="submit" class="btn btn-primary" name="ctmark" >store CT Mark</button>
            </form>
        </div>
        <div class="btn-group">
            <form  method='post'>
                <button type="submit" class="btn btn-primary" name="viewCTmarks" >view CT-Mark Sheet</button>
            </form>
        </div>
        
        <div class="btn-group">
            <form  method='post'>
                <button type="submit" class="btn btn-primary" name="viewResult" >View Result</button>
            </form>
        </div>
    </div>
    </div>
   
         
        
    <?php


   




//______________view attendance sheet_____________
    if(isset($_POST["viewAttendance"]))
    {

        global $id,$con;
        $datatable ="course";
        $s = "select * from $datatable where  personID = '$id' ";
        $result = mysqli_query($con,$s);
        $num = mysqli_num_rows($result);
        if($num!=0)
        {

            ?>


        <div class="list" style="max-width: 500px;" >
        <h2> Attendance Sheet  </h2>
        <form method='post'>
            <div>
            <label>Course Code</label>
                <select name="course" class="form-control" required>
                    <?php  
                     global $id,$con;
                     $datatable ="course";
                     $s = "select * from $datatable where  personID = '$id' ";
                     $result = mysqli_query($con,$s);
                     $num = mysqli_num_rows($result);
         
                     
                    while( $var = mysqli_fetch_assoc($result))
                        { ?><option value="<?php echo $var['course']?>" ><?php echo $var['course']?></option>
                            <?php
                        }
                
                        ?>
                </select>
    
            </div>
        
            <div class="form-group">
                <label>Roll range</label>
                <input type="text" name="rollStart" class="form-control" required>
                <br>
                <input type="text" name="rollEnd" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success" name="showAttendance" >NEXT</button>

        </form> 
    
    
        <?php


            
        }
        else
        {
            ?>

        <div class="d-flex justify-content-center">
            
        <div class='list'>
            <div class="minibox">
                <h3>No Course are available</h3>

            </div>
            <div class="minibox">
                <div class="form-group"> 
                    <form  method='post'>
                        <button type="submit" class="btn btn-success btn-block " name="addCourse" >Add Course</button>
                    </form>
                </div>
            </div>
        </div>
           
        </div>
  
          <?php

        }

    }

    if(isset($_POST["showAttendance"]))
    {
        $rollStart = $_POST['rollStart'];
        $rollEnd = $_POST['rollEnd'];
        $course = $_POST['course'];

        global $id,$con;
        $datatable ="attendance";
       

        $days = ['Saturday','Sunday','Monday','Tuesday' ,'Wednesday'];



        ?><?php

        ?>
        
       

        <div class="outer-wrapper">
            <div class="table-wrapper" >
            <table class="table table-striped table-bordered" style="margin: 10px;">
                <tr>
                    <td><h5>Roll</h5></td>
                    <?php 
                    for($j=1;$j<=15;$j++)
                    {
                        foreach($days as $k)
                        {
                            echo "<td ><h5>$j $k[0]$k[1]$k[2]</h5></td>"; 
                        }
                        if($j%3==0)
                        {
                           echo"<td><h5>Roll</h5></td>";

                        }

                    } 
                    ?>
                    <td><h5>Total class</h5></td>
                    <td><h5>Present</h5></td>
                    <td><h5>Percentage</h5></td>
                </tr>

        <?php
        for($i=$rollStart;$i<=$rollEnd;$i++)
        {
            echo "<tr>";
            echo "<td><h5>$i</h5></td>";

            $total=0;
            $prsnt=0;

            for($j=1;$j<=15;$j++)
            {
                $zz=0;
                foreach($days as $k)
                {     
                    $zz++;             
                    $s = "select * from $datatable where day='$k' && cycle='$j' && course='$course' && roll='$i'  ORDER BY id DESC";
                    $result = mysqli_query($con,$s);
                    $num = mysqli_num_rows($result);
                    $ans=0;

                    if($num==0)
                    {
                        echo "<td></td>";
                        if($j%3==0&&$zz==5)
                        {
                            echo "<td><h5>$i</h5></td>";

                        }
                        continue;
                    }
                    $total++;
                    
                    $var = mysqli_fetch_assoc($result);
                    $ans=$var['attendance'];
                    $tcrName=$var['teacher'];
    
                    
                    if($ans==1)
                    {
                        $prsnt++;
                    }
                    echo "<td title='$tcrName'>$ans</td>";
                    if($j%3==0&&$zz==5)
                        {
                            echo "<td><h5>$i</h5></td>";

                        }
                    
                } 
    
            }
            echo "<td>$total</td>";
            echo "<td>$prsnt</td>";
            if($total==0)
            {
                $percentage=0;
            }
            else
            {
                $percentage=round(($prsnt/$total)*100,2);
            }
            echo "<td>$percentage%</td>";
            echo "</tr>";
            
        }

        ?></table>
        </div>
        </div>
        <?php


       






    }



    //____________view course_____________

        if(isset($_POST["viewCourse"]))
        {
            showCourse();

        }


        //________________add course______________
        if(isset($_POST["addCourse"]))
        {
            ?>
            <div class="list" style="max-width: 300px;" >
            <div class="container">
            <div class="d-flex justify-content-center">
            <div class="form-group" ">
            <form  method='post'>
            <label>Enter Course Code:</label>
                <?php 
                
                for($i=0;$i<10;$i++) 
                {
                    $ii=$i+1; ?>
      
                <div class="form-group">
                    <label><?php echo "$ii : "; ?></label>
                    <input type="text"  name="course<?php echo $i?>" class="form-control" value="">
                    </div>
                    <?php 
                }?>
      
                <button type="submit" class="btn btn-success btn-block" name="saveCourse" >Save</button>
            </form>
            </div>
            </div>
            </div>
            </div>
            
            <?php
        }

        if(isset($_POST["saveCourse"]))
        { 
            global $id,$con;

            $datatable ="course";
           



            for($i=0;$i<10;$i++)
            {
                $x="course".$i;
                $newCourse=$_POST[$x];
                if($newCourse!="")
                {
                    $s = "INSERT INTO $datatable VALUES('','$id','$newCourse','$type')";
                    mysqli_query($con,$s);

                }

            }
           
            showCourse();

        }



        function showCourse()
        {
            global $id,$con;
            $datatable ="course";
            $s = "select * from $datatable where  personID = '$id' ";
            $result = mysqli_query($con,$s);
            $num = mysqli_num_rows($result);

            if($num!=0)
            {
                ?>
                 <div class="list" style="max-width: 300px;" >
                    <table class="table table-striped table-bordered"  >
                        <tr>
                            <td><h3>Course Code</h3></td>
                        </tr>
                <?php

                while( $var = mysqli_fetch_assoc($result))
                {
                    ?>
                        <tr>
                             <td><?php echo $var['course']?></td>  </tr>
                    <?php
    
                }

                ?>
                    </table>

                    <div class="minibox" >
                <div class="form-group"> 
                    <form  method='post'>
                        <button type="submit" class="btn btn-success btn-block " name="addCourse" >Add Course</button>
                    </form>
                </div>
                <div class="form-group"> 
                    <form  method='post'>
                        <button type="submit" class="btn btn-danger btn-block " name="deleteCourse" >Delete Course</button>
                    </form>
                </div>
            </div>


                    </div>

                <?php
              
            }
            else
            {
                ?>

        <div class="d-flex justify-content-center">
            
        <div class='list'>
            <div class="minibox">
                <h3>No Course are available</h3>

            </div>
            <div class="minibox">
                <div class="form-group"> 
                    <form  method='post'>
                        <button type="submit" class="btn btn-success btn-block " name="addCourse" >Add Course</button>
                    </form>
                </div>
            </div>
        </div>
           
        </div>
  
          <?php


            }



        }

        //__________delete course_____________

if(isset($_POST["deleteCourse"]))
{


    global $id,$con,$datatablelogin;
    $datatable ="course";
    $s = "select * from $datatable where  personID = '$id' ";
    $result = mysqli_query($con,$s);
    $num = mysqli_num_rows($result);


    if($num!=0)
    {
        ?>
            <div class="d-flex justify-content-center">
            <div class="list">
            <form method='post'>

                <table class="table table-striped table-bordered" ">
                    <tr>
                        <td>Course</td>
                        <td>select for Delete</td>
                    </tr>
            
            <?php
            while( $var = mysqli_fetch_assoc($result))
            {
                $c= $var['course'];
                ?>
    
                    <tr>
                        <td><?php echo $c?></td>
                        <div class="checkbox" ><td style="text-align: center;"><input type="checkbox"  value="<?php echo $c?>" name="courses[]"></td></div>
                    </tr>
                       
                <?php
    
            }
    
            ?>
            </table>
            <button type="submit" class="btn btn-danger btn-block" name="courseDeleteDone" >Delete</button>

    
            </form>
            </div>
            </div>
            
            <?php

    }
    else
    {
        ?>
        <div class="d-flex justify-content-center">
            <div class="list">
                <h3>No Course are available</h3>
            </div>
        </div>
        <?php
    }


}

if(isset($_POST["courseDeleteDone"]))
{

        $courses=$_POST['courses'];

        global $id,$con;
        $datatable ="course";
     
        foreach ($courses as $c)
        {
            $s = "DELETE FROM $datatable where  personID = '$id' && course='$c' ";
            mysqli_query($con,$s);
    
        }
    
        ?>
    
        <div class="d-flex justify-content-center">
            <div class="list">
                <h3>Delete successfully</h3>
            </div>
        </div>
          
          
          <?php

showCourse();


}




        




        //_____________input attendance___________________

    if(isset($_POST["attendance"]))
    {

        global $id,$con;
        $datatable ="course";
        $s = "select * from $datatable where  personID = '$id' ";
        $result = mysqli_query($con,$s);
        $num = mysqli_num_rows($result);
        if($num!=0)
        {

            showAttendanceform();
            
        }
        else
        {
            ?>

        <div class="d-flex justify-content-center">
            
        <div class='list'>
            <div class="minibox">
                <h3>No Course are available</h3>

            </div>
            <div class="minibox">
                <div class="form-group"> 
                    <form  method='post'>
                        <button type="submit" class="btn btn-success btn-block " name="addCourse" >Add Course</button>
                    </form>
                </div>
            </div>
        </div>
           
        </div>
  
          <?php


        }
     
    }


    function showAttendanceform()
    {
        ?>
        <div class="list" style="max-width: 500px;" >
        <h2> take Attendance  </h2>
        <form method='post'>
            <div>
            <label>Course Code</label>
                <select class="form-control" name="course"  required>
                    <?php  
                     global $id,$con;
                     $datatable ="course";
                     $s = "select * from $datatable where  personID = '$id' ";
                     $result = mysqli_query($con,$s);
                     
                    while( $var = mysqli_fetch_assoc($result))
                        { ?><option value="<?php echo $var['course']?>" ><?php echo $var['course']?></option>
                            <?php
                        }
                
                        ?>
                </select>
    
            </div>
        
            <div class="form-group">
                <label>Roll range</label>
                <input type="text" name="rollStart" class="form-control" required>
                <br>
                <input type="text" name="rollEnd" class="form-control" required>
            </div>

            <div>
                <label>Cycle</label>
                <select name="cycle" class="form-control">
                <?php 
                for($i=1;$i<=15;$i++)
                {
                    echo "<option value='$i' >  $i  </option>";
                }
                ?>
                </select>
    
            </div>

            <div>
            <label>Course Code</label>
                <select name="day" class="form-control">
                    <option value="Saturday" >Saturday</option>
                    <option value="Sunday" >Sunday</option>
                    <option value="Monday" >Monday</option>
                    <option value="Tuesday" >Tuesday</option>
                    <option value="Wednesday" >Wednesday</option>
                </select>
    
            </div>
            

            <button type="submit" class="btn btn-success" name="takeAttendance" >NEXT</button>

        </form> 
        </div>
    
    
        <?php

    }



    if(isset($_POST["takeAttendance"]))
    {
        $rollStart = $_POST['rollStart'];
        $rollEnd = $_POST['rollEnd'];
        $cycle = $_POST['cycle'];
        $day = $_POST['day'];
        $course = $_POST['course'];



        ?>
        <div class="d-flex justify-content-center">
        <div class="list">
        <form method='post'>
                <input type="hidden" name="rollStart" value="<?php echo $rollStart?>">
                <input type="hidden" name="rollEnd" value="<?php echo $rollEnd?>">
                <input type="hidden" name="cycle" value="<?php echo $cycle?>">
                <input type="hidden" name="day" value="<?php echo $day?>">
                <input type="hidden" name="course" value="<?php echo $course?>">

        
                
          
            <table class="table table-striped table-bordered" ">
                <tr>
                    <td>Roll</td>
                    <td>Attendance Status</td>
                </tr>
        
        <?php
        
        $datatable ="attendance";
        for($i=$rollStart;$i<=$rollEnd;$i++)
        {
            $click="";


            $s = "select * from $datatable where day='$day' && cycle='$cycle' && course='$course' && roll='$i'  ORDER BY id DESC";
            $result = mysqli_query($con,$s);
            $num = mysqli_num_rows($result);
            $ans=0;

            
            if($num!=0)
            {
                $var = mysqli_fetch_assoc($result);
                $ans=$var['attendance'];
            }
            
            if($ans==1)
            {
                $click='checked';
            }
            ?>

				<tr>
                    <td><?php echo $i?></td>
                    <div class="checkbox" ><td style="text-align: center;"><input type="checkbox" <?php echo $click?>  value="<?php echo $i?>" name="attendanceStatus[]"></td></div>
                </tr>
                   
            <?php

        }

        ?>
        </table>
        <button type="submit" class="btn btn-success  btn-block" name="takeAttendanceDone" >DONE</button>
      

           

        </form>
        </div>
        </div>
        
        <?php




        
    }

    if(isset($_POST["takeAttendanceDone"]))
    {

        $rollStart = $_POST['rollStart'];
        $rollEnd = $_POST['rollEnd'];
        $cycle = $_POST['cycle'];
        $day = $_POST['day'];
        $course = $_POST['course'];
        $rolls = $_POST['attendanceStatus'];

        $attendance = Array($rollEnd-$rollStart+1);
        for($i=$rollStart;$i<=$rollEnd;$i++)
        {
            $attendance[$i-$rollStart]=0;
        }


        foreach($rolls as $roll)
        {
            $attendance[$roll-$rollStart]=1;
        }

        global $con,$name;
        $datatable ="attendance";

        for($i=$rollStart;$i<=$rollEnd;$i++)
        {

            $s = "select * from $datatable where day='$day' && cycle='$cycle' && course='$course' && roll='$i'  ORDER BY id DESC";
            $result = mysqli_query($con,$s);
            $num = mysqli_num_rows($result);

            $status=$attendance[$i-$rollStart];
            if($num==0)
            {  
                $s = "INSERT INTO $datatable VALUES('','$i','$course','$cycle','$day','$status','$name')";
                mysqli_query($con,$s);
            }
            else
            {
                $var = mysqli_fetch_assoc($result);
                $newID=$var['id'];

                $s = "UPDATE $datatable SET attendance=$status , teacher='$name' WHERE id=$newID  ";
                mysqli_query($con,$s);


            }
    

        }

        ?>
        <div class="d-flex justify-content-center">
        <div class="list">
        <h3>Data Store successfully</h3>
        </div></div>
        <?php

    }



    //_____ input ct marks_______________
    if(isset($_POST["ctmark"]))
    {
        global $id,$con;
        $datatable ="course";
        $s = "select * from $datatable where  personID = '$id' ";
        $result = mysqli_query($con,$s);
        $num = mysqli_num_rows($result);
        if($num!=0)
        {

            ?>
            <div class="list" style="max-width: 500px;" >
        <form method='post'>
        <h2> input CT marks  </h2>
            <div>
            <label>Course Code</label>
                <select class="form-control" name="course" required>
                    <?php  
                     global $id,$con;
                     $datatable ="course";
                     $s = "select * from $datatable where  personID = '$id' ";
                     $result = mysqli_query($con,$s);
                     $num = mysqli_num_rows($result);        
                     
                    while( $var = mysqli_fetch_assoc($result))
                        { ?><option value="<?php echo $var['course']?>" ><?php echo $var['course']?></option>
                            <?php
                        }
                
                        ?>
                </select>
    
            </div>
        
            <div class="form-group">
                <label>Roll range</label>
                <input type="text" name="rollStart" class="form-control" required>
                <br>
                <input type="text" name="rollEnd" class="form-control" required>
            </div>

            
            <div>
             <label>Class-Test No.</label>
                <select class="form-control" name="ctno">
                <?php 
                for($i=1;$i<=5;$i++)
                {
                    echo "<option value='$i' >  $i  </option>";
                }
                ?>
                </select>
    
            </div>
            

            <button type="submit" class="btn btn-success" name="showCTmarkForm" >NEXT</button>

        </form> 
        </div>
    
    
        <?php

                   
        }
        else
        {
            ?>

            <div class="d-flex justify-content-center">
                
            <div class='list'>
                <div class="minibox">
                    <h3>No Course are available</h3>
    
                </div>
                <div class="minibox">
                    <div class="form-group"> 
                        <form  method='post'>
                            <button type="submit" class="btn btn-success btn-block " name="addCourse" >Add Course</button>
                        </form>
                    </div>
                </div>
            </div>
               
            </div>
      
              <?php
    
        }

        
    }

    if(isset($_POST["showCTmarkForm"]))
    {

        $rollStart = $_POST['rollStart'];
        $rollEnd = $_POST['rollEnd'];
        $course = $_POST['course'];
        $ctno = $_POST['ctno'];



        ?>
         <div class="d-flex justify-content-center" >
             <div class="list">
        <form method='post'>
                <input type="hidden" name="rollStart" value="<?php echo $rollStart?>">
                <input type="hidden" name="rollEnd" value="<?php echo $rollEnd?>">
                <input type="hidden" name="course" value="<?php echo $course?>">
                <input type="hidden" name="ctno" value="<?php echo $ctno?>">

        
            <table class="table table-striped table-bordered" style="max-width: 500px;">
                <tr>
                    <td>Roll</td>
                    <td>Marks</td>
                </tr>
        
        <?php
        $datatable='marks';
        for($i=$rollStart;$i<=$rollEnd;$i++)
        {

            $s = "select * from $datatable where ctNo='$ctno' && course='$course' && roll='$i' ORDER BY id DESC";
            $result = mysqli_query($con,$s);
            $num = mysqli_num_rows($result);

            $value;
            if($num==0)
            {
                $value=''; 
            }
            else
            {
                $var = mysqli_fetch_assoc($result);         
                $value=$var['marks'];
            }


            ?>

				<tr>
                    <td><?php echo $i?></td>
                    <td style="text-align: center;"><input type="text" value="<?php echo $value?>" name="<?php echo $i?>"></td>
                </tr>
                   
            <?php

        }

        ?>
        </table>

            <button type="submit" class="btn btn-success  btn-block" name="takeCTmarksDone" >DONE</button>

        </form>
         </div>
         </div>
        
        <?php
        

    }


    if(isset($_POST["takeCTmarksDone"]))
    {
        global $name;
        global $con;

        $rollStart = $_POST['rollStart'];

        $rollEnd = $_POST['rollEnd'];
        $course = $_POST['course'];
        $ctno = $_POST['ctno'];


        $datatable="marks";
       
        for($i=$rollStart;$i<=$rollEnd;$i++)
        {

            $x=$_POST[$i];
            if($x=="")
            {
                $x='A';
            }

            $s = "select * from $datatable where ctNo='$ctno' && course='$course' && roll='$i' ORDER BY id DESC";
            $result = mysqli_query($con,$s);
            $num = mysqli_num_rows($result);

            if($num==0)
            {
                $query = "INSERT INTO $datatable VALUES('','$i','$course','$ctno','$x','$name') ";

                mysqli_query($con,$query);
      
            }
            else
            {
                $var = mysqli_fetch_assoc($result);         
                $newID=$var['id'];

                $query = "UPDATE $datatable  SET marks='$x',teacher='$name' WHERE id=$newID";

                mysqli_query($con,$query);


            }

        }


        ?>
        <div class="d-flex justify-content-center">
        <div class="list">
        <h3>Data Store successfully</h3>
        </div></div>
        <?php

       

    }
   
    
    //_________ view ct marks__________

    if(isset($_POST["viewCTmarks"]))
    {
        
        global $id,$con;
        $datatable ="course";
        $s = "select * from $datatable where  personID = '$id' ";
        $result = mysqli_query($con,$s);
        $num = mysqli_num_rows($result);
        if($num!=0)
        {

            ?>
            <div class="list" style="max-width: 500px;" >
            <h2> view CT marks sheet  </h2>
            <form method='post'>
                <div>
                <label>Course Code</label>
                    <select class="form-control" name="course" required>
                        <?php  
                         global $id,$con;
                         $datatable ="course";
                         $s = "select * from $datatable where  personID = '$id' ";
                         $result = mysqli_query($con,$s);
                         $num = mysqli_num_rows($result);
    
                         if($num==0)
                         {
                             echo "<script>alert('please add Course')</script>";
    
                         }
             
                         
                        while( $var = mysqli_fetch_assoc($result))
                            { ?><option value="<?php echo $var['course']?>" ><?php echo $var['course']?></option>
                                <?php
                            }
                    
                            ?>
                    </select>
        
                </div>
            
                <div class="form-group">
                    <label>Roll range</label>
                    <input type="text" name="rollStart" class="form-control" required>
                    <br>
                    <input type="text" name="rollEnd" class="form-control" required>
                </div>
                
    
                <button type="submit" class="btn btn-success" name="showCTmarks" >NEXT</button>
    
            </form> 
         </div>
        
        <?php
    
            
        }
        else
        {
            ?>

        <div class="d-flex justify-content-center">
            
        <div class='list'>
            <div class="minibox">
                <h3>No Course are available</h3>

            </div>
            <div class="minibox">
                <div class="form-group"> 
                    <form  method='post'>
                        <button type="submit" class="btn btn-success btn-block " name="addCourse" >Add Course</button>
                    </form>
                </div>
            </div>
        </div>
           
        </div>
  
          <?php

        }

        
    }

    if(isset($_POST["showCTmarks"]))
    {

        $rollStart = $_POST['rollStart'];
        $rollEnd = $_POST['rollEnd'];
        $course = $_POST['course'];




        $datatable='marks';
        ?>
                <div class="d-flex justify-content-center">
        <div class="list">
            <table class="table table-striped table-bordered"  style="text-align: center;" >
                <tr>
                    <td>Roll</td>
                    <?php 
                    for($j=1;$j<=5;$j++)
                    {
                        
                        echo "<td >CT-$j </td>"; 
                        
                    } 
                    ?>
                    <td>best of three avg.</td>
                </tr>

        <?php
        for($i=$rollStart;$i<=$rollEnd;$i++)
        {
            echo "<tr>";
            echo "<td>$i</td>";

            $marksList=array(6);
            for($j=0;$j<=5;$j++)
            {
                $marksList[$j]=0;
            }
            
            for($j=1;$j<=5;$j++)
            {
                $ans=0;              
                    $s = "select * from $datatable where ctNo='$j' && course='$course' && roll='$i' ORDER BY id DESC ";
                    $result = mysqli_query($con,$s);
                    $num = mysqli_num_rows($result);
                    

                    if($num==0)
                    {
                        echo "<td></td>";
                        continue;
                    }
    
                    else
                    {
                        $var = mysqli_fetch_assoc($result);
                        
                        $ans=$var['marks'];
                        $tcrName=$var['teacher'];
                        echo "<td title='$tcrName'>$ans</td>";  
                        if($ans=='A')
                        {
                            $ans=0;
                        }
                        
                    }
                     
                    $marksList[$j]=$ans;     
    
            }


            rsort($marksList);
            $ans=$marksList[0]+$marksList[1]+$marksList[2];

            $m=ceil($ans/3);
            echo "<td>$m</td>";
            echo "</tr>";
            
        }

        ?></table>
        </div> </div><?php






    }
    
    

    //__________view all result___________
    if(isset($_POST["viewResult"]))
    {

        global $id,$con;
        $datatable ="course";
        $s = "select * from $datatable where  personID = '$id' ";
        $result = mysqli_query($con,$s);
        $num = mysqli_num_rows($result);
        if($num!=0)
        {

            ?>

        <div class="list" style="max-width: 500px;" >
        <h3 style="text-align: center;"> view Result </h3>
        <form method='post'>
            <div>
            <label>Course Code</label>
                <select class="form-control" name="course" required>
                    <?php  
                     global $id,$con;
                     $datatable ="course";
                     $s = "select * from $datatable where  personID = '$id' ";
                     $result = mysqli_query($con,$s);
                     $num = mysqli_num_rows($result);        
                     
                    while( $var = mysqli_fetch_assoc($result))
                        { ?><option value="<?php echo $var['course']?>" ><?php echo $var['course']?></option>
                            <?php
                        }
                
                        ?>
                </select>
    
            </div>
        
            <div class="form-group">
                <label>Roll range</label>
                <input type="text" name="rollStart" class="form-control" required>
                <br>
                <input type="text" name="rollEnd" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success" name="showResultSheet" >NEXT</button>

        </form> 
    
        </div>
        <?php

                   
        }
        else
        {
            ?>

        <div class="d-flex justify-content-center">
            
        <div class='list'>
            <div class="minibox">
                <h3>No Course are available</h3>

            </div>
            <div class="minibox">
                <div class="form-group"> 
                    <form  method='post'>
                        <button type="submit" class="btn btn-success btn-block " name="addCourse" >Add Course</button>
                    </form>
                </div>
            </div>
        </div>
           
        </div>
  
          <?php


        }


    }

    if(isset($_POST["showResultSheet"]))
    {

        $rollStart = $_POST['rollStart'];
        $rollEnd = $_POST['rollEnd'];
        $course = $_POST['course'];

        $datatableMarks='marks';
        $datatableAttendance ="attendance";

        $days = ['Saturday','Sunday','Monday','Tuesday' ,'Wednesday'];

        




        ?>
          <div class="d-flex justify-content-center">
              <div class="list">

              <h3 style="text-align: center;">Result Sheet</h3>
              <h5 style="text-align: center;">Course code : <?php echo $course ?></h5>
            <table class="table table-striped table-bordered " >
                <tr>
                    <td><h5>Roll</h5></td>
                    <td><h5>Percentage of Attendance</h5></td>
                    <td><h5>Attendance Marks</h5></td>
                    <td><h5>CT Marks</h5></td>
                    <td><h5>Total Marks</h5></td>
                </tr>

        <?php
        for($i=$rollStart;$i<=$rollEnd;$i++)
        {
            echo "<tr>";
            echo "<td><h6>$i</h6></td>";

            $total=0;
            $prsnt=0;

            for($j=1;$j<=15;$j++)
            {
                foreach($days as $k)
                {                  
                    $s = "select * from $datatableAttendance where day='$k' && cycle='$j' && course='$course' && roll='$i'  ORDER BY id DESC";
                    $result = mysqli_query($con,$s);
                    $num = mysqli_num_rows($result);
                    $ans=0;

                    if($num==0)
                    {
                        continue;
                    }
                    $total++;
                    
                    $var = mysqli_fetch_assoc($result);
                    $ans=$var['attendance'];
                     
                    if($ans==1)
                    {
                        $prsnt++;
                    }
                    
                } 
    
            }
            if($total==0)
            {
                $percentage=0;
            }
            else
            {
                $percentage=round(($prsnt/$total)*100,2);
            }
            
            echo "<td>$percentage%</td>";

            $Amark=0;
            if($percentage>=90)
            {
                $Amark=8;
            }
            else if($percentage>=85)
            {
                $Amark=7;
            }
            else if($percentage>=80)
            {
                $Amark=6;
            }
            else if($percentage>=70)
            {
                $Amark=5;
            }
            else if($percentage>=60)
            {
                $Amark=4;
            }
            echo "<td> $Amark</td>";
            //_________________CT MARKS_______________

            $marksList=array(6);
            for($j=0;$j<=5;$j++)
            {
                $marksList[$j]=0;
            }
            
            for($j=1;$j<=5;$j++)
            {
                $ans=0;              
                    $s = "select * from $datatableMarks where ctNo='$j' && course='$course' && roll='$i' ORDER BY id DESC ";
                    $result = mysqli_query($con,$s);
                    $num = mysqli_num_rows($result);
                    

                    if($num==0)
                    {
                        continue;
                    }
    
                    else
                    {
                        $var = mysqli_fetch_assoc($result);
                        
                        $ans=$var['marks'];
                        if($ans=='A')
                        {
                            $ans=0;
                        }
                        
                    }
                     
                    $marksList[$j]=$ans;     
    
            }


            rsort($marksList);
            $ans=$marksList[0]+$marksList[1]+$marksList[2];

            $CTmarks=ceil($ans/3);
            echo "<td>$CTmarks</td>";

            $totalmarks=$CTmarks+$Amark;
            echo "<td>$totalmarks</td>";


            echo "</tr>";
            
        }

        ?></table>
          </div>
          </div>
        <?php

    }

    
    ?>

</body>


</html>