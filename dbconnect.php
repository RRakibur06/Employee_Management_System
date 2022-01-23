<?php
$server = "localhost";
$username = "root";
$password = "";

$con = mysqli_connect($server, $username, $password, 'employee_management');

if(!$con){
    die("Connection failed : ".mysqli_connect_error());
}
else{
    echo "Connected Succesfully";
}

?>