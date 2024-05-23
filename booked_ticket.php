<?php

   @include 'config.php';

   session_start();

   $user_id = $_SESSION['user_id'];

   if(!isset($user_id)){
      header('location:login.php');
   }

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Booked Tickets</title>
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

<section class="placed-orders">

   <h1 class="title">Your Tickets</h1>

   <div class="box-container">

   <?php
      $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
      $select_orders->execute([$user_id]);
      if($select_orders->rowCount() > 0){
         while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <div class="box">
      <p> Date: <span><?= $fetch_orders['placed_on']; ?></span> </p>
      <p> Name: <span><?= $fetch_orders['name']; ?></span> </p>
      <p> Phone: <span><?= $fetch_orders['number']; ?></span> </p>
      <p> Email: <span><?= $fetch_orders['email']; ?></span> </p>
      <p> Theater: <span><?= $fetch_orders['address']; ?></span> </p>
      <p> Payment method: <span><?= $fetch_orders['method']; ?></span> </p>
      <p> Your choosen movie: <span><?= $fetch_orders['total_movies']; ?></span> </p>
      <p> Total price: <span>$<?= $fetch_orders['total_price']; ?>/-</span> </p>
      <p> Payment status: <span style="color:<?php if($fetch_orders['payment_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; }; ?>"><?= $fetch_orders['payment_status']; ?></span> </p>
   </div>
   <?php
      }
   }else{
      echo '<p class="empty">No Booked Tickets!!</p>';
   }
   ?>

   </div>

</section>

<div>___</div>

<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>