<?php
include("auth_session.php");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        .topnav {
            overflow: hidden;
            background-color: #333;
        }

        .topnav a {
            float: left;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
        }

        .topnav a:hover {
            background-color: #ddd;
            color: black;
        }

        .topnav a.active {
            background-color: #04AA6D;
            color: white;
        }
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 90%;
            margin-left: 10px ;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
        #employees{
            margin-top : 300px;
            margin-bottom : 200px;
        }
        .form{
            margin-left: 10px ;
            padding: 5px;
        }
        .login-input{
            font-size: 15px;
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 25px;
            height: 25px;
        }

        .login-input:focus{
            border-color: #6e8095;
            outline: none;
        }

        .login-button{
            color: #fff;
            background: #55a1ff;
            border: 0;
            outline: 0;
            width: 200px;
            height: 50px;
            font-size: 16px;
            text-align: center;
            cursor: pointer;
        }
        #description{
            width : 400px;
        }
</style>
</head>
<body>
    <?php 
    require('dbconnect.php');
    if($_SESSION['first_name']=="Admin" && $_SESSION['last_name']=="Admin")
    {
        //TOPBAR
        echo "<div class='topnav'>
                <a class='active' href='#Dashboard'>Dashboard</a>
                <a href='#employees'>Employees</a>
                <a href='#projects'>Projects</a>
                <a href='#attendance'>Attendance</a>
                <a href='#salaries'>Salaries</a>
              </div>";
        
        echo "<h3 style='margin-left:10px;'>Welcome ".$_SESSION['first_name'].".</h3>";
        
        //DASHBOARD
        $sql = "SELECT * FROM employees";
        $result = mysqli_query($con,$sql);
        $employee_number = mysqli_num_rows($result);
        $sql_ = "SELECT * FROM users";
        $result_ = mysqli_query($con,$sql_);
        $user_number = mysqli_num_rows($result_);
        $sql__ = "SELECT * FROM projects where project_remarks='Completed'";
        $sqll = "SELECT * FROM projects";
        $res = mysqli_query($con,$sql__);
        $res2 = mysqli_query($con,$sqll);
        $completed_projects = mysqli_num_rows($res);
        $total_projects = mysqli_num_rows($res2);
        echo "
        <h2 style='margin-left:10px; margin-top:100px;'>Dashboard :</h2>
        <h3 style='margin-left:10px;'>Total employees : $employee_number</h3>
        <h3 style='margin-left:10px;'>Total users : $user_number</h3>
        <h3 style='margin-left:10px;'>Projects completed : $completed_projects of $total_projects</h3>
        ";
        
        //EMPLOYEE_TABLE
        $sql = "select * from employees";
        $result = mysqli_query($con, $sql);

        echo "<div id='employees'>
        <h3 style='margin-left:10px;'>Employees Information : </h3>
        <table border='1'>
        <tr>
        <th>Employee ID</th>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Email</th>
        <th>Address</th>
        <th>Contact No</th>
        </tr>";
        
        while($row = mysqli_fetch_array($result))
        {
        echo "<tr>";
        echo "<td>" . $row['employee_id'] . "</td>";
        echo "<td>" . $row['first_name'] . "</td>";
        echo "<td>" . $row['last_name'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['address'] . "</td>";
        echo "<td>" . $row['contact_number'] . "</td>";
        echo "</tr>";
        }
        echo "</table></div>";

        //PROJECTS_TABLE
        $sql_ = "select * from projects";
        $result_ = mysqli_query($con, $sql_);

        echo "<div id='projects' style='margin-bottom:200px;'>
       <h3 style='margin-left:10px;'>Projects Information : </h3>
       <table border='1'>
       <tr>
       <th>Project ID</th>
       <th>Project Name</th>
       <th>Description</th>
       <th>Employee Name</th>
       <th>User Name</th>
       <th>Start Date</th>
       <th>End Date</th>
       <th>Project Remarks</th>
       </tr>";
       
       while($row = mysqli_fetch_array($result_))
       {
         $userId = $row['user_id'];
         $employeeId = $row['employee_id'];
         $user = "select * from users where user_id = '$userId'";
         $emp = "select * from employees where employee_id = '$employeeId'";
         $resultUser = mysqli_query($con, $user);
         $resultEmp = mysqli_query($con, $emp);
         $rowUser = mysqli_fetch_array($resultUser);
         $rowEmp = mysqli_fetch_array($resultEmp);
       echo "<tr>";
       echo "<td>" . $row['project_id'] . "</td>";
       echo "<td>" . $row['project_name'] . "</td>";
       echo "<td>" . $row['project_description'] . "</td>";
       echo "<td>" . $rowEmp['first_name']." ".$rowEmp['last_name']. "</td>";
       echo "<td>" . $rowUser['first_name']." ".$rowUser['last_name']. "</td>";
       echo "<td>" . $row['project_start_date'] . "</td>";
       echo "<td>" . $row['project_end_date'] . "</td>";
       echo "<td>" . $row['project_remarks'] . "</td>";
       echo "</tr>";
       }
       echo "</table></div>";
       //ATTENDANCE
       $y = 0;
       $y++;
       echo "
       <h3 style='margin-left:10px;'>Attendance : </h3>
       <form class='form' id='attendance' action='' method='post' name='attendance'>
       <input type='number' name='Employee_id' class='login-input' id='employee_id' placeholder='Employee ID' required>
       <input type='number' name='Project_id' class='login-input' id='project_id' placeholder='Project ID' required>
       <label for='date'>Date :</label>
       <input type='date' name='date' class='login-input' id='date' placeholder = 'Date' required>
       <p>Attendance Status:</p>
             <input type='radio' id='present' name='radio_select' value='Present' required>
             <label for='present'>Present</label>
             <input type='radio' id='absent' name='radio_select' value='Absent'>
             <label for='absent'>Absent</label>
         <input type='submit' value='Submit' name='submit' class='login-button'>
       </form>
       ";
       if(isset($_POST['submit']) && $y==1)
            {
                $employee_id = $_POST['Employee_id'];
                $project_id = $_POST['Project_id'];
                $date = $_POST['date']; 
                $radio_select = $_POST['radio_select'];

                $sql = "insert into on_duty (employee_id,project_id,attendance_status,date) values('$employee_id','$project_id','$radio_select','$date')";
               
                $result = mysqli_query($con,$sql);

                if($result)
                {
                    header("Location: home.php");
                }
                else
                {
                    echo "<br/><h3>Required fields are missing.</h3>";
                }
            }
        //SALARIES
        $x = 0;
        $x++;
        echo "
        <h3 style='margin-left:10px;'>Salary : </h3>
        <form class='form' id='salaries' action='' method='post' name='salaries'>
        <input type='number' name='Employee_id' class='login-input' id='employee_id' placeholder='Employee ID' required>
        <input type='submit' value='Submit' name='submit' class='login-button'>
        </form>";
        if(isset($_POST['submit']) && $x==1)
            {
                $x = 0;
                $employee_id = $_POST['Employee_id'];
                
                $sql = "select * from on_duty where employee_id = '$employee_id'";

                $result = mysqli_query($con,$sql);
                $total_day_present = mysqli_num_rows($result);
                
                $sql_ = "select * from leave_off where employee_id = '$employee_id'";
                
                $result_ = mysqli_query($con,$sql_);
                $row = mysqli_fetch_row($result_);
                $total_days_worked = $row[3] + $total_day_present;
                $salary = $total_days_worked * 1000;

                $sql = "insert into salaries (employee_id,total_days_worked,salary) values('$employee_id','$total_days_worked','$salary')";
               
                $resultt = mysqli_query($con,$sql);
                if($resultt)
                {
                    echo "<br/><h3>Salary submitted.</h3>";
                }
                else
                {
                    echo "<br/><h3>Required fields are missing.</h3>";
                }
            }

    }
    else if($_SESSION['user_id']!=0 && $_SESSION['employee_id']==0)
    {
        //TOPBAR
        echo "<div class='topnav'>
                <a class='active' href='#Dashboard'>Dashboard</a>
                <a href='#employees'>Employees</a>
                <a href='#projects'>Projects</a>
                <a href='#project_submission'>Project Submission</a>
              </div>";
        echo "<h3 style='margin-left:10px;'>Welcome ".$_SESSION['first_name']." ".$_SESSION['last_name'].".</h3>";      
        
        //DASHBOARD
        $sql = "SELECT * FROM employees";
        $result = mysqli_query($con,$sql);
        $employee_number = mysqli_num_rows($result);
        $sql_ = "SELECT * FROM users";
        $result_ = mysqli_query($con,$sql_);
        $user_number = mysqli_num_rows($result_);
        $sql__ = "SELECT * FROM projects where project_remarks='Completed'";
        $sqll = "SELECT * FROM projects";
        $res = mysqli_query($con,$sql__);
        $res2 = mysqli_query($con,$sqll);
        $completed_projects = mysqli_num_rows($res);
        $total_projects = mysqli_num_rows($res2);
        echo "
        <h2 style='margin-left:10px; margin-top:100px;'>Dashboard :</h2>
        <h3 style='margin-left:10px;'>Total employees : $employee_number</h3>
        <h3 style='margin-left:10px;'>Total users : $user_number</h3>
        <h3 style='margin-left:10px;'>Projects completed : $completed_projects of $total_projects</h3>
        ";

         //EMPLOYEE_TABLE
              $sql = "select * from employees";
              $result = mysqli_query($con, $sql);
    
              echo "<div id='employees'>
              <h3 style='margin-left:10px;'>Employees Information : </h3>
              <table border='1'>
              <tr>
              <th>Employee ID</th>
              <th>Firstname</th>
              <th>Lastname</th>
              <th>Email</th>
              <th>Address</th>
              <th>Contact No</th>
              </tr>";
              
              while($row = mysqli_fetch_array($result))
              {
              echo "<tr>";
              echo "<td>" . $row['employee_id'] . "</td>";
              echo "<td>" . $row['first_name'] . "</td>";
              echo "<td>" . $row['last_name'] . "</td>";
              echo "<td>" . $row['email'] . "</td>";
              echo "<td>" . $row['address'] . "</td>";
              echo "<td>" . $row['contact_number'] . "</td>";
              echo "</tr>";
              }
              echo "</table></div>";
            
            //PROJECTS_TABLE
               $sql_ = "select * from projects";
               $result_ = mysqli_query($con, $sql_);

               echo "<div id='projects' style='margin-bottom:200px;'>
              <h3 style='margin-left:10px;'>Projects Information : </h3>
              <table border='1'>
              <tr>
              <th>Project ID</th>
              <th>Project Name</th>
              <th>Description</th>
              <th>Employee Name</th>
              <th>User Name</th>
              <th>Start Date</th>
              <th>End Date</th>
              <th>Project Remarks</th>
              </tr>";
              
              while($row = mysqli_fetch_array($result_))
              {
                $userId = $row['user_id'];
                $employeeId = $row['employee_id'];
                $user = "select * from users where user_id = '$userId'";
                $emp = "select * from employees where employee_id = '$employeeId'";
                $resultUser = mysqli_query($con, $user);
                $resultEmp = mysqli_query($con, $emp);
                $rowUser = mysqli_fetch_array($resultUser);
                $rowEmp = mysqli_fetch_array($resultEmp);
              echo "<tr>";
              echo "<td>" . $row['project_id'] . "</td>";
              echo "<td>" . $row['project_name'] . "</td>";
              echo "<td>" . $row['project_description'] . "</td>";
              echo "<td>" . $rowEmp['first_name']." ".$rowEmp['last_name']. "</td>";
              echo "<td>" . $rowUser['first_name']." ".$rowUser['last_name']. "</td>";
              echo "<td>" . $row['project_start_date'] . "</td>";
              echo "<td>" . $row['project_end_date'] . "</td>";
              echo "<td>" . $row['project_remarks'] . "</td>";
              echo "</tr>";
              }
              echo "</table></div>";

              //PROJECT_SUBMISSION
              echo "
              <form class='form' id='project_submission' action='' method='post' name='project_submission'>
              <h3>Project Submission : </h3>
                <label for='project_name'>Project Name:</label>
                <input type='text' name='Project_name' class='login-input' id='project_name' placeholder='Project Name' required>
                <label for='start_date'>Start Date:</label>
                <input type='date' name='Start_date' class='login-input' id='start_date' placeholder = 'Starting Date'  required>
                <label for='end_date'>End Date:</label>
                <input type='date' name='End_date' class='login-input' id='end_date' placeholder = 'Ending Date' required>
                <label for='description'>Description:</label>
                <input type='text' name='Description' class='login-input' id='description' placeholder = 'Description' required>
                <label for='submitted_to'>Submitted to:</label>
                <input type='number' name='employee_id' class='login-input' id='submitted_to' placeholder = 'Employee ID' required>
                <p>Please select anyone:</p>
                    <input type='radio' id='completed' name='radio_select' value='Completed' required>
                    <label for='completed'>Completed</label>
                    <input type='radio' id='incomplete' name='radio_select' value='Incomplete'>
                    <label for='incomplete'>Incomplete</label>
                    <input type='radio' id='deathline_expired' name='radio_select' value='Deathline Expired'>
                    <label for='deathline_expired'>Deathline Expired</label>
                <input type='submit' value='Submit' name='submit' class='login-button'>
                </form>
              ";
            if(isset($_POST['submit']))
            {
                $project_name = $_POST['Project_name'];
                $start_date = $_POST['Start_date'];
                $end_date = $_POST['End_date']; 
                $description = $_POST['Description'];
                $employee_id = $_POST['employee_id'];
                $radio_select = $_POST['radio_select'];
                $userId = $_SESSION['user_id'];

                $sql = "insert into projects (employee_id,user_id,project_name,project_description,project_start_date,project_end_date,project_remarks) values('$employee_id','$userId','$project_name','$description','$start_date','$end_date','$radio_select')";
               
                $result = mysqli_query($con,$sql);

                if($result)
                {
                    header("Location: home.php");
                }
                else
                {
                    echo "<br/><h3>Required fields are missing.</h3>";
                }
            }
    }
    else if($_SESSION['employee_id']!=0 && $_SESSION['user_id']==0)
    {
        //TOPBAR
        echo "<div class='topnav'>
                <a class='active' href='#Dashboard'>Dashboard</a>
                <a href='#projects'>Projects</a>
                <a href='#project_submission'>Project Submission</a>
                <a href='#leave'>Leave</a>
              </div>";
        echo "<h3 style='margin-left:10px;'>Welcome ".$_SESSION['first_name']." ".$_SESSION['last_name'].".</h3>";
        
        //DASHBOARD
        $sql = "SELECT * FROM employees";
        $result = mysqli_query($con,$sql);
        $employee_number = mysqli_num_rows($result);
        $sql_ = "SELECT * FROM users";
        $result_ = mysqli_query($con,$sql_);
        $user_number = mysqli_num_rows($result_);
        $sql__ = "SELECT * FROM projects where project_remarks='Completed'";
        $sqll = "SELECT * FROM projects";
        $res = mysqli_query($con,$sql__);
        $res2 = mysqli_query($con,$sqll);
        $completed_projects = mysqli_num_rows($res);
        $total_projects = mysqli_num_rows($res2);
        echo "
        <h2 style='margin-left:10px; margin-top:100px;'>Dashboard :</h2>
        <h3 style='margin-left:10px;'>Total employees : $employee_number</h3>
        <h3 style='margin-left:10px;'>Total users : $user_number</h3>
        <h3 style='margin-left:10px;'>Projects completed : $completed_projects of $total_projects</h3>
        ";
        
        //PROJECTS_TABLE
               $empId = $_SESSION['employee_id'];
               $sql_ = "select * from projects where employee_id = '$empId'";
               $result_ = mysqli_query($con, $sql_);

               echo "<div id='projects' style='margin-bottom:200px;margin-top:300px;'>
              <h3 style='margin-left:10px;'>Projects Information : </h3>
              <table border='1'>
              <tr>
              <th>Project ID</th>
              <th>Project Name</th>
              <th>Description</th>
              <th>Employee Name</th>
              <th>User Name</th>
              <th>Start Date</th>
              <th>End Date</th>
              <th>Project Remarks</th>
              </tr>";
              
              while($row = mysqli_fetch_array($result_))
              {
                $userId = $row['user_id'];
                $employeeId = $row['employee_id'];
                $user = "select * from users where user_id = '$userId'";
                $emp = "select * from employees where employee_id = '$employeeId'";
                $resultUser = mysqli_query($con, $user);
                $resultEmp = mysqli_query($con, $emp);
                $rowUser = mysqli_fetch_array($resultUser);
                $rowEmp = mysqli_fetch_array($resultEmp);
              echo "<tr>";
              echo "<td>" . $row['project_id'] . "</td>";
              echo "<td>" . $row['project_name'] . "</td>";
              echo "<td>" . $row['project_description'] . "</td>";
              echo "<td>" . $rowEmp['first_name']." ".$rowEmp['last_name']. "</td>";
              echo "<td>" . $rowUser['first_name']." ".$rowUser['last_name']. "</td>";
              echo "<td>" . $row['project_start_date'] . "</td>";
              echo "<td>" . $row['project_end_date'] . "</td>";
              echo "<td>" . $row['project_remarks'] . "</td>";
              echo "</tr>";
              }
              echo "</table></div>";
        //PROJECT_SUBMISSION_BY_EMPLOYEE
              echo "
              <h3 style='margin-left:10px;'>Project Submission By Employee : </h3>
              <form class='form' id='project_submission' action='' method='post' name='project_submission'>
              <input type='number' name='Project_id' class='login-input' id='project_id' placeholder='Project ID' required>
              <p>Please select anyone:</p>
                    <input type='radio' id='completed' name='radio_select' value='Completed' required>
                    <label for='completed'>Completed</label>
                    <input type='radio' id='incomplete' name='radio_select' value='Incomplete'>
                    <label for='incomplete'>Incomplete</label>
                <input type='submit' value='Submit' name='submit' class='login-button'>
              </form>";
              if(isset($_POST['submit']))
            {
                $project_id = $_POST['Project_id'];
                $radio_select = $_POST['radio_select'];

                $sql = "UPDATE projects SET project_remarks='$radio_select' WHERE project_id='$project_id';";
               
                $result = mysqli_query($con,$sql);

                if($result)
                {
                    header("Location: home.php");
                }
                else
                {
                    echo "<br/><h3 style='margin-left:10px;'>Required fields are missing.</h3>";
                }
            }
        //LEAVE
        echo "
        <h3 style='margin-left:10px; margin-top:200px;'>Apply for leave : </h3>
        <form class='form' id='leave' action='' method='post' name='leave'>
        <input type='number' name='Employee_id' class='login-input' id='employee_id' placeholder='Employee ID' required>
        <input type='number' name='Project_id' class='login-input' id='project_id' placeholder='Project ID' required>
        <input type='number' name='leave_days' class='login-input' id='project_id' placeholder='How many days?' required>
        <input type='submit' value='Submit' name='submit' class='login-button'>
        </form>";
        if(isset($_POST['submit']))
            {
                $employee_id = $_POST['Employee_id'];
                $project_id = $_POST['Project_id'];
                $leave_days = $_POST['leave_days']; 

                $sql_ = "select * from leave_off where employee_id = '$employee_id'";
                $result = mysqli_query($con,$sql_);
                $row = mysqli_fetch_row($result);
                $leave_remaining = $row[3] - $leave_days;
                
                $sql = "insert into leave_off (employee_id,project_id,leave_remaining) values('$employee_id','$project_id','$leave_remaining')";
               
                $result_ = mysqli_query($con,$sql);

                if($result_)
                {
                    echo "<br/><h3 style='margin-left:10px;'>Leave request successful.</h3>";
                }
                else
                {
                    echo "<br/><h3 style='margin-left:10px;'>Required fields are missing.</h3>";
                }
            }  
    }
    
    ?>
    <p><a style='margin-left:20px;' href="logout.php">Logout</a></p>
</body>
</html>