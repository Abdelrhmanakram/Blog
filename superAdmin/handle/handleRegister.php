<?php

//connection
require_once '../../inc/conn.php';
// submit 

if(isset($_POST['submit'])){

// catch 
    $name = trim(htmlspecialchars($_POST['name']));
    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim(htmlspecialchars($_POST['password']));
    $phone = trim(htmlspecialchars($_POST['phone']));

//validation  -> 
$passwordHashed = password_hash($password,PASSWORD_DEFAULT);

// 1 way 
//insert 
$query = "insert into users(`name`,`email`,`password`,`phone`) values('$name','$email','$passwordHashed','$phone')";
$result = mysqli_query($conn,$query);
if($result){

    header("location:../../login.php");
}else{
    $_SESSION['errors'] = ["error whiel register"];
    header("location:../register.php");

}
//done -> login

}else{
    header("location:../register.php");
}