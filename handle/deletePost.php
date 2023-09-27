<?php

require_once '../inc/conn.php';

if(! isset($_SESSION['user_id'])){
    header("location:../login.php");
  }else{

if(! isset($_GET['id'])){
    header("location:index.php");
  }
 $id = $_GET['id'];
  $query = "select * from posts where id=$id";
  $result =  mysqli_query($conn,$query);

 if(mysqli_num_rows($result)==1){
 $oldImage =   mysqli_fetch_assoc($result)['image'];

    if(! empty($oldImage)){
        unlink("../assets/images/postImage/$oldImage");
    }

    $query = "delete from posts where id=$id";

    $result =  mysqli_query($conn,$query);

    if($result){
        $_SESSION['success'] = ["post deleted successfuly"];
        header("location:../index.php");
    }else{
        $_SESSION['errors'] = ["error shile delete"];
        header("location:../index.php");
    }
 }else{
    $_SESSION['errors'] = ["post not found"];
    header("location:../index.php");
 }}