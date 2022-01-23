<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php

    require('dbconnect.php');

    if(isset($_POST['submit']))
    {
        $first_name = $_POST['First_name'];
        $last_name = $_POST['Last_name'];
        $email = $_POST['Email']; 
        $password = $_POST['Password'];
        $address = $_POST['Address'];
        $contact_no = $_POST['Contact_no'];
        $radio_select = $_POST['radio_select'];

        if($radio_select=="User"){
            $sql = "insert into users (first_name,last_name,email,password,address,contact_number) values('$first_name','$last_name','$email','$password','$address','$contact_no')";
        }
        else{
            $sql = "insert into employees (first_name,last_name,email,password,address,contact_number) values('$first_name','$last_name','$email','$password','$address','$contact_no')";
        }
        

        $result = mysqli_query($con,$sql);

        if($result)
        {
            echo "<div class='form'>
                <h3>You are registered successfully!</h3><br/>
                <p class='link'><a href='login.php'>Click to Login</a></p>
                 </div>";
        }
        else
        {
            echo "<div class='form'>
                <h3>Required fields are missing.</h3><br/>
                <p class='link'><a href='registration.php'>Click to Register Again</a></p>
                 </div>";
        }
    }

    ?>

    <form class = "form" action="" method="post">
        <h1 class="login-title">Registration</h1>
        <input type="text" name="First_name" class="login-input" id="first_name" placeholder="First Name"  required>
        <input type="text" name="Last_name" class="login-input" id="last_name" placeholder="Last Name"  required>
        <input type="email" name="Email" class="login-input" id="Email" placeholder = "Email"  required>
        <input type="password" name="Password" class="login-input" id="Password" placeholder = "Password" minlength="6" required>
        <br><label for='joining_date'>Joining Date:</label><br>
                <input type='date' name='Joining_date' class='login-input' id='joining_date' required>
        <input type="text" name="Address" class="login-input" id="address" placeholder="Address"  required>
        <input type="text" name="Contact_no" class="login-input" id="contact_no" placeholder="Contact Number"  required>
        <p>Please select anyone:</p>
            <input type="radio" id="user" name="radio_select" value="User" required>
            <label for="user">User</label>
            <input type="radio" id="employee" name="radio_select" value="Employee">
            <label for="employee">Employee</label><br>
        <input type="submit" value="Register" name="submit" class="login-button">
        <p class="link"><a href="login.php">Click to Login</a></p>
    </form>
    
</body>
</html>

