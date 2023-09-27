<?php

require_once '../inc/conn.php';

// submit , catch , validation , check , msg 

if(isset($_POST['submit'])){

    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim(htmlspecialchars($_POST['password']));

    //validation

    //check 
    $query = "select * from users where `email`='$email'";
    $result =  mysqli_query($conn,$query);

    if(mysqli_num_rows($result)==1){

       $user =  mysqli_fetch_assoc($result);
       $oldPassword = $user['password'];
       $name = $user['name'];
       $id = $user['id'];
       $is_verify =   password_verify($password,$oldPassword);

       if($is_verify){
        $_SESSION['success'] = "welcome  $name";
        $_SESSION['user_id'] = $id;
        header("location:../index.php");
       }else{
        $_SESSION['errors'] = ["credinatioals not correct"];
        header("location:../login.php");
       }
    }else{
        $_SESSION['errors'] = ["this account not exist"];
        header("location:../login.php");
    }

}else{
    header("location:../login.php");
}