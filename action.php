<?php
include('server/connection.php');
// m
$username = $_POST['user_name'];
$email = $_POST['user_email'];
$password = ($_POST['user_password']);

$query = "INSERT INTO users VALUES('','$username','$email','$password','','','','')";

mysqli_query($conn, $query);
// sasd
header("location:register.html");
die();
// saas
// msms