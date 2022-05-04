<?php

$dataBaseName="ruet";
$con = mysqli_connect('localhost','root','', $dataBaseName);

session_start();
$id =    $_SESSION['id'];
$email=$_SESSION['email'];
$pass=$_SESSION['pass'];
$type=$_SESSION['type'];
$name=$_SESSION['name'];
$dept=$_SESSION['dept'];
$phone=$_SESSION['phone'];

echo $id."<br>";
echo $email."<br>";
echo $pass."<br>";
echo $type."<br>";
echo $name."<br>";
echo $dept."<br>";
echo $phone."<br>";


?>





<html>
<head>
<title> login and registration </title>
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<body>
    <div>
        <form  method='post'>
            <button type="submit" class="viewCourse" name="viewCourse" >View Courses</button>
        </form>

    </div>



    <div>
        <div >
            <form  method='post'>
                <button type="submit" class="Attendance" name="attendance" >Attendance</button>
            </form>
        </div>
        <div >
            <form  method='post'>
                <button type="submit" class="ctmark" name="ctmark" >Class-Test Mark</button>
            </form>
        </div>
    </div>
           
    
    <?php
        if(isset($_POST["viewCourse"]))
        {
            showCourse();
            ?>
            <div >
                <form  method='post'>
                    <button type="submit" name="addCourse" >Add Course</button>
                </form>
            </div>
            
            <?php

        }
        if(isset($_POST["addCourse"]))
        {
            showCourse();
            ?>
            <form  method='post'>
                <?php 
                
                for($i=0;$i<10;$i++) 
                { ?>

                    <input type="text" name="course<?php echo $i?>" class="form-control" value="">

                    <?php 
                }?>

                <button type="submit" name="saveCourse" >Save</button>
            </form>
            
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
                    $s = "INSERT INTO $datatable VALUES('','$id','$newCourse')";
                    mysqli_query($con,$s);

                }

            }
           


            showCourse();
            ?>
             <div >
                <form  method='post'>
                    <button type="submit" name="addCourse" >Add Course</button>
                </form>
            </div>
            
            <?php





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
                <ul>
                <?php

                while( $var = mysqli_fetch_assoc($result))
                {
                    ?>
                        <li><?php echo $var['course']?></li>  
                    <?php
    
                }

                ?>
                   </ul>
                <?php
              
            }
            else
            {
                ?>
                
                <p>No Course are available</p><br>
                
                
                <?php

            }



        }

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
           <p>No Course are available. Please add Course</p><br>
            
            <?php

        }
     
    }


    function showAttendanceform()
    {
        ?>

        <form method='post'>
            <div>
                <select name="course">
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

            <div class="form-group">
                <label>Cycle</label>
                <input type="text" name="cycle" class="form-control" required>
            </div>

            <div>
                <select name="day">
                    <option value="Saturday" >Saturday</option>
                    <option value="Sunday" >Sunday</option>
                    <option value="Monday" >Monday</option>
                    <option value="Tuesday" >Tuesday</option>
                    <option value="Wednesday" >Wednesday</option>
                </select>
    
            </div>
            

            <button type="submit" class="takeAttendance" name="takeAttendance" >NEXT</button>

        </form> 
    
    
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
        <form method='post'>
                <input type="hidden" name="rollStart" value="<?php echo $rollStart?>">
                <input type="hidden" name="rollEnd" value="<?php echo $rollEnd?>">
                <input type="hidden" name="cycle" value="<?php echo $cycle?>">
                <input type="hidden" name="day" value="<?php echo $day?>">
                <input type="hidden" name="course" value="<?php echo $course?>">

        
            <table>
                <tr>
                    <td>Roll</td>
                    <td>Attendance Status</td>
                </tr>
        
        <?php
        for($i=$rollStart;$i<=$rollEnd;$i++)
        {
            ?>

				<tr>
                    <td><?php echo $i?></td>
                    <td style="text-align: center;"><input type="checkbox" value="<?php echo $i?>" name="attendanceStatus[]"></td>
                </tr>
                   
            <?php

        }

        ?>
        </table>

            <button type="submit" class="takeAttendanceDone" name="takeAttendanceDone" >DONE</button>

        </form>
        
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
            $status=$attendance[$i-$rollStart];
            $s = "INSERT INTO $datatable VALUES('','$i','$course','$cycle','$day','$status','$name')";
            mysqli_query($con,$s);

        }

        ?>
        
        <p>Data Store successfully</p>
        <?php

    }


    if(isset($_POST["ctmark"]))
    {

        
    }


    
    
    ?>

	


</body>

</head>

</html>