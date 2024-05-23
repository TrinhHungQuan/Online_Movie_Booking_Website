<?php

   @include 'config.php';

   session_start();

   $admin_id = $_SESSION['admin_id'];

   if(!isset($admin_id)){
      header('location:login.php');
   }

   if(isset($_POST['add_product'])){

      $name = $_POST['name'];
      $name = filter_var($name, FILTER_SANITIZE_STRING);
      $price = $_POST['price'];
      $price = filter_var($price, FILTER_SANITIZE_STRING);
      $category = $_POST['category'];
      $category = filter_var($category, FILTER_SANITIZE_STRING);
      $details = $_POST['details'];
      $details = filter_var($details, FILTER_SANITIZE_STRING);
      $trailer = $_POST['trailer'];
      $trailer = filter_var($trailer, FILTER_SANITIZE_STRING);

      $image = $_FILES['image']['name'];
      $image = filter_var($image, FILTER_SANITIZE_STRING);
      $image_size = $_FILES['image']['size'];
      $image_tmp_name = $_FILES['image']['tmp_name'];
      $image_folder = 'uploaded_img/'.$image;

      $select_movies = $conn->prepare("SELECT * FROM `movies` WHERE name = ?");
      $select_movies->execute([$name]);

      if($select_movies->rowCount() > 0){
         $message[] = 'Movie name already existed!';
      }else{

         $insert_movies = $conn->prepare("INSERT INTO `movies`(name, category, details, price, image, trailer) VALUES(?,?,?,?,?,?)");
         $insert_movies->execute([$name, $category, $details, $price, $image, $trailer]);

         if($insert_movies){
            if($image_size > 2000000){
               $message[] = 'Size too large!';
            }else{
               move_uploaded_file($image_tmp_name, $image_folder);
               $message[] = 'New movie has been added!';
            }

         }
      }
   };

   if(isset($_GET['delete'])){

      $delete_id = $_GET['delete'];
      $select_delete_image = $conn->prepare("SELECT image FROM `movies` WHERE id = ?");
      $select_delete_image->execute([$delete_id]);
      $fetch_delete_image = $select_delete_image->fetch(PDO::FETCH_ASSOC);
      unlink('uploaded_img/'.$fetch_delete_image['image']);
      $delete_movies = $conn->prepare("DELETE FROM `movies` WHERE id = ?");
      $delete_movies->execute([$delete_id]);
      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
      $delete_cart->execute([$delete_id]);
      header('location:admin_movies.php');
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin movies</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/styleadmin.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="add-movies">
   <h1 class="title">ADD NEW MOVIE</h1>
   <form action="" method="POST" enctype="multipart/form-data">
      <div class="flex">
         <div class="inputBox">
         <input type="text" name="name" class="box" required placeholder="Enter movie name">
         <select name="category" class="box" required>
            <option value="" selected disabled>Select Movie Category</option>
               <option value="2D">2D</option>
               <option value="3D">3D</option>
               <option value="4D">4D</option>
               <option value="5D">5D</option>
         </select>
         </div>
         <div class="inputBox">
         <input type="number" min="0" name="price" class="box" required placeholder="Enter ticket price">
         <input type="text" name="trailer" class="box" required placeholder="Enter link trailer">
         <input type="file" name="image" required class="box" accept="image/jpg, image/jpeg, image/png">
         </div>
      </div>
      <textarea name="details" class="box" required placeholder="Enter movie details" cols="30" rows="10"></textarea>
      <input type="submit" class="btn" value="add movie" name="add_product">
   </form>
</section>

<section class="show-movies">
   <h1 class="title">MOVIE added</h1>
   <div class="box-container">
   <?php
      $show_movies = $conn->prepare("SELECT * FROM `movies`");
      $show_movies->execute();
      if($show_movies->rowCount() > 0){
         while($fetch_movies = $show_movies->fetch(PDO::FETCH_ASSOC)){  
   ?>
   <div class="box">
      <div class="price"><?= $fetch_movies['price']; ?>$</div>
      <img src="uploaded_img/<?= $fetch_movies['image']; ?>" alt="">
      <div class="name"><?= $fetch_movies['name']; ?></div>
      <div class="cat"><?= $fetch_movies['category']; ?></div>
      
      <div class="details"><?= $fetch_movies['details']; ?></div>
      <div>
         <a href="<?= $fetch_movies['trailer']; ?>" class="btn">Trailer</a>
      </div>
      <div class="flex-btn">
         <a href="admin_update_movie.php?update=<?= $fetch_movies['id']; ?>" class="option-btn">Update</a>
         <a href="admin_movies.php?delete=<?= $fetch_movies['id']; ?>" class="delete-btn" onclick="return confirm('Delete this movie?');">Delete</a>
      </div>
   </div>
   <?php
      }
   }else{
      echo '<p class="empty">Movie added!</p>';
   }
   ?>
   </div>
</section>

<script src="js/script.js"></script>

</body>
</html>