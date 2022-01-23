<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    $x = 0; 
    $y = 0;
    require('dbconnect.php');
    session_start();

    if(isset($_POST['Email']))
    {
        $email = $_POST['Email'];
        $password = $_POST['Password'];
        $radio_select = $_POST['radio_select'];

        if($radio_select=="User"){
            $sql = "select * from users where email = '$email' AND password = '$password'";
            $x++;
        }
        else{
            $sql = "select * from employees where email = '$email' AND password = '$password'";
            $y++;
        }

        $result = mysqli_query($con,$sql);
        $rows = mysqli_num_rows($result);
        $row = mysqli_fetch_row($result);
    if($rows == 1)
    {
        $_SESSION['email'] = $email;
        $_SESSION['first_name'] = $row[1];
        $_SESSION['last_name'] = $row[2];
        if($x!=0){
            $_SESSION['user_id'] = $row[0];
            $_SESSION['employee_id'] = 0;
            $x = 0;
        }
        if($y!=0){
            $_SESSION['employee_id'] = $row[0];
            $_SESSION['user_id'] = 0;
            $y = 0;
        }
        header("Location: home.php");
    }
        else
        {
            echo "<div class='form'>
                <h3>Incorrect username or password!</h3><br/>
                <p class='link'><a href='login.php'>Click to Login Again</a></p>
                 </div>";
        }

    }
    else {
    ?>

    <form class = "form" action="" method="post" name="login">
        <h1 class="login-title">Login</h1>
        <input type="email" name="Email" class="login-input" id="email" placeholder="Email" required>
        <input type="password" name="Password" class="login-input" id="Password" placeholder = "Password" required>
        <p>Please select anyone:</p>
            <input type="radio" id="user" name="radio_select" value="User" required>
            <label for="user">User</label>
            <input type="radio" id="employee" name="radio_select" value="Employee">
            <label for="employee">Employee</label><br>
        <input type="submit" value="Login" name="submit" class="login-button">
        <p class="link"><a href="registration.php">Click to Registration</a></p>
    </form>
    
    <?php
    }

    ?>
    
</body>
</html>

