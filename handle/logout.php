<?php

session_start();
if(! isset($_SESSION['user_id'])){
    header("location:../login.php");

}else{
    unset($_SESSION['user_id']);
    header("location:../login.php");
}