<?php

   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }

?>

<header class="header">
   <div class="flex">
   <a href="home.php"><img id="logo"class="logo" src="uploaded_img/logo_admin.png" width="100px" height="90px"/></a>
      <nav class="navbar">
         <a href="home.php">HOME</a>
         <a href="list_movie.php">MOVIES</a>
         <a href="booked_ticket.php">YOUR TICKETS</a>
         <a href="contact.php">CONTACT</a>
      </nav>

      <div class="icons">
         <div id="menu-btn"></div>
         <div id="user-btn" class="fas fa-user"></div>
         <?php
            $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $count_cart_items->execute([$user_id]);
         ?>

         <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?= $count_cart_items->rowCount(); ?>)</span></a>
      </div>

      <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <img src="uploaded_img/<?= $fetch_profile['image']; ?>" alt="">
         <p><?= $fetch_profile['name']; ?></p>
         <a href="user_profile_update.php" class="btn">Update profile</a>
         <a href="logout.php" class="delete-btn">Logout</a>
         <div class="flex-btn">
            <a href="login.php" class="option-btn">Login</a>
            <a href="register.php" class="option-btn">Register</a>
         </div>
      </div>

   </div>

</header>