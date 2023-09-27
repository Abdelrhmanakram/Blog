<?php

require_once '../inc/conn.php';

// submt , id , check , catch , validation , update 

if(isset($_POST['submit']) && isset($_GET['id']) && isset($_SESSION['user_id'])){
    
    $id = $_GET['id'];
    $title = trim(htmlspecialchars($_POST['title']));
    $body = trim(htmlspecialchars($_POST['body']));
    $errors = [];

    if(empty($title)){
        $errors[] = "title is requreid";
    }elseif(is_numeric($title)){
        $errors[] = "title must be string";
    }
    
    if(empty($body)){
        $errors[] = "body is requreid";
    }elseif(is_numeric($body)){
        $errors[] = "body must be string";
    }

    $query = "select * from posts where id=$id";
    $result =  mysqli_query($conn,$query);

   if(mysqli_num_rows($result)==1){
    $oldImage =  mysqli_fetch_assoc($result)['image'];


    if( isset($_FILES['image']) && $_FILES['image']['name']){
        $image = $_FILES['image'];
        $image_name = $image['name'];
        $image_tmpname = $image['tmp_name'];
        $ext = strtolower(pathinfo($image_name,PATHINFO_EXTENSION));
        $image_error = $image['error'];
        $image_size = $image['size']/(1024*1024);

        if($image_error !=0){
            $errors[] = "image requried";
        }elseif($image_size>1){
            $errors[] = "image large size";
        }elseif(!in_array($ext,["jpg","jpeg","gif","png"])){
            $errors[] = "image not correct";
        }
        $newName = uniqid().".".$ext;
    }else{
        $newName = $oldImage;
    }

    if(empty($errors)){

        $query = "update posts set `title`='$title' , `body`='$body',`image`='$newName' where id=$id";
        $result =  mysqli_query($conn,$query);

        if($result){
            if( isset($_FILES['image']) && $_FILES['image']['name']){

                unlink("../assets/images/postImage/$oldImage");
                move_uploaded_file($image_tmpname,"../assets/images/postImage/$newName") ;  
            }

            $_SESSION['success'] = "post updated successfuly";
            header("location:../viewPost.php?id=$id");
        }else{
            $_SESSION['errors'] = ["error while update"];
            header("location:../editPost.php?id=$id");
        }
    }else{
        $_SESSION['errors'] = $errors;
    header("location:../editPost.php?id=$id");
    }

   }else{
    $_SESSION['errors'] = ["post not found"];
    header("location:../index.php");
   }

}else{
    header("location:../index.php");
}