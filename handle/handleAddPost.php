<?php
require_once '../inc/conn.php';

// insert (submit , catch , validation , errors empty , insert)

if(isset($_POST['submit']) && isset($_SESSION['user_id'])){

        $user_id = $_SESSION['user_id'];
    

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
        $newName = null;
    }


    if(empty($errors)){
        $query = "insert into posts(`title`,`body`,`image`,`user_id`) values('$title','$body','$newName',$user_id)";
        $result =    mysqli_query($conn,$query);

        if($result){
            if( isset($_FILES['image']) && $_FILES['image']['name']){
                move_uploaded_file($image_tmpname,"../assets/images/postImage/$newName");
            }

            $_SESSION['success'] = "post inserted successfuly";
            header("location:../index.php");
        }else{
            $_SESSION['errors'] = ["error while insert"];
        }

    }else{
        $_SESSION['errors'] = $errors;
        header("location:../addPost.php");
    }


}else{
    header("location:../addPost.php");
}