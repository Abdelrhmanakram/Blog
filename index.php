
<?php require_once 'inc/header.php' ?>
    <!-- Page Content -->
    <!-- Banner Starts Here -->
    <div class="banner header-text">
      <div class="owl-banner owl-carousel">
        <div class="banner-item-01">
          <div class="text-content">
            <!-- <h4>Best Offer</h4> -->
            <!-- <h2>New Arrivals On Sale</h2> -->
          </div>
        </div>
        <div class="banner-item-02">
          <div class="text-content">
            <!-- <h4>Flash Deals</h4> -->
            <!-- <h2>Get your best products</h2> -->
          </div>
        </div>
        <div class="banner-item-03">
          <div class="text-content">
            <!-- <h4>Last Minute</h4> -->
            <!-- <h2>Grab last minute deals</h2> -->
          </div>
        </div>
      </div>
    </div>
    <!-- Banner Ends Here -->


    <?php

    require_once 'inc/conn.php';

    if(isset($_GET['page'])){
      $page = $_GET['page'];
    }else{
      $page = 1;
    }

    $limit  = 3;


    $offset = ($page -1)*$limit;

    $query = "select count(id) as total from posts";
    $result =   mysqli_query($conn,$query);
    $total =  mysqli_fetch_assoc($result)['total'];

    $numberOfPages = ceil($total / $limit);


    if($page > $numberOfPages) {
      header("location:".$_SERVER['PHP_SELF']."?page=$numberOfPages");
    }elseif($page <1) {
      header("location:".$_SERVER['PHP_SELF']."?page=1");

    }


    $query = "select id , image , title,created_at  from posts  
    order by id limit $limit offset $offset  ";
    $result =  mysqli_query($conn,$query);

    if(mysqli_num_rows($result)>0){

     $posts =  mysqli_fetch_all($result,MYSQLI_ASSOC);

    }else{

     $msg =  "posts not found";
    }

    ?>

    <div class="latest-products">
      <div class="container">

    <?php 
    require_once 'inc/success.php';
    ?>

        <div class="row">
          <div class="col-md-12">
            <div class="section-heading">
              <h2>Latest Posts</h2>
            </div>
          </div>

          <?php 
              if(!empty($posts)):
              foreach($posts as $post): 
          ?>
          <div class="col-md-4">
            <div class="product-item">
              <a href="#"><img src="assets/images/postImage/<?php echo $post['image'] ?>" alt=""></a>
              <div class="down-content">
                <a href="#"><h4><?php echo $post['title'] ?></h4></a>
                <p> <?php echo $post['created_at'] ?></p>
                
                <div class="d-flex justify-content-end">
                  <a href="viewPost.php?id=<?php echo $post['id'] ?>" class="btn btn-info "> view</a>
                </div>
                
              </div>
            </div>
          </div>

          <?php 
            endforeach;
            else:
              echo $msg;
            endif;
          ?>
         
        </div>
      </div>
    </div>

 
<div class="container d-flex justify-content-center">
  <nav aria-label="Page navigation example">
    <ul class="pagination">
      <li class="page-item  <?php if($page ==1) echo "disabled" ?> ">
        <a class="page-link" href="<?php echo $_SERVER['PHP_SELF']."?page=".$page-1 ?>" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
          <span class="sr-only">Previous</span>
        </a>
      </li>
      <li class="page-item"><a class="page-link"><?php echo $page ."of".$numberOfPages ?></a></li>
      <li class="page-item  <?php if($page ==$numberOfPages) echo "disabled" ?> ">
        <a class="page-link" href="<?php echo $_SERVER['PHP_SELF']."?page=".$page+1 ?>" aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
          <span class="sr-only">Next</span>
        </a>
      </li>
    </ul>
  </nav>
</div>
    
<?php require_once 'inc/footer.php' ?>
