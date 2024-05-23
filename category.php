<?php

   @include 'config.php';

   session_start();

   $user_id = $_SESSION['user_id'];

   if(!isset($user_id)){
      header('location:login.php');
   };


   if(isset($_POST['add_to_cart'])){

      $pid = $_POST['pid'];
      $pid = filter_var($pid, FILTER_SANITIZE_STRING);
      $p_name = $_POST['p_name'];
      $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
      $p_price = $_POST['p_price'];
      $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
      $p_image = $_POST['p_image'];
      $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);
      $p_qty = $_POST['p_qty'];
      $p_qty = filter_var($p_qty, FILTER_SANITIZE_STRING);

      $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
      $check_cart_numbers->execute([$p_name, $user_id]);

      if($check_cart_numbers->rowCount() > 0){
         $message[] = 'already added to cart!';
      }else{
         $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
         $insert_cart->execute([$user_id, $pid, $p_name, $p_price, $p_qty, $p_image]);
         $message[] = 'added to cart!';
      }

   }

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Category</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/styleuser.css">

</head>
<body>
<?php include 'header.php'; ?>
<font>
      <marquee direction="left" style="background: rgb(121, 134, 238)">
         <b>WELCOME TO OUR CINEMA. THE BEST CHOICE FOR YOUR FREE TIME!</b>
      </marquee>
   </font>
<section class="p-category">
   <a href="category.php?category=2D">2D</a>
   <a href="category.php?category=3D">3D</a>
   <a href="category.php?category=4D">4D</a>
   <a href="category.php?category=5D">5D</a>
</section>

<section class="movies">
   <h1 class="title">Movies</h1>
   <div class="box-container">
   <?php
      $category_name = $_GET['category'];
      $select_movies = $conn->prepare("SELECT * FROM `movies` WHERE category = ?");
      $select_movies->execute([$category_name]);
      if($select_movies->rowCount() > 0){
         while($fetch_movies = $select_movies->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <form action="" class="box" method="POST">
      <div class="price"><span><?= $fetch_movies['price']; ?></span>$</div>
      <a href="view_page.php?pid=<?= $fetch_movies['id']; ?>" class="fas fa-eye"></a>
      <img src="uploaded_img/<?= $fetch_movies['image']; ?>" alt="">
      <div class="name"><?= $fetch_movies['name']; ?></div>
      <input type="hidden" name="pid" value="<?= $fetch_movies['id']; ?>">
      <input type="hidden" name="p_name" value="<?= $fetch_movies['name']; ?>">
      <input type="hidden" name="p_price" value="<?= $fetch_movies['price']; ?>">
      <input type="hidden" name="p_image" value="<?= $fetch_movies['image']; ?>">
      <input type="number" min="1" value="1" name="p_qty" class="qty">
      <input type="submit" value="Book Ticket" class="btn" name="add_to_cart">
   </form>
   <?php
         }
      }else{
         echo '<p class="empty" style="text-align: center">There are no movie of this type... See you soon!</p>';
      }
   ?>

   </div>

</section>

<script src="js/script.js"></script>

</body>
</html>