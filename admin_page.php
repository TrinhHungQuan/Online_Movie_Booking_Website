<?php

   @include 'config.php';

   session_start();

   $admin_id = $_SESSION['admin_id'];

   if(!isset($admin_id)){
      header('location:login.php');
   }

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin page</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/styleadmin.css">
</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="dashboard">
   <h1 class="title">OVERVIEW</h1>
   <div class="box-container">
      <div class="box">
      <?php
         $select_orders = $conn->prepare("SELECT * FROM `orders`");
         $select_orders->execute();
         $number_of_orders = $select_orders->rowCount();
      ?>
      <h3><?= $number_of_orders; ?></h3>
      <p>Booked tickets</p>
      <a href="admin_tickets.php" class="btn">See booked tickets</a>
      </div>

      <div class="box">
      <?php
         $select_movies = $conn->prepare("SELECT * FROM `movies`");
         $select_movies->execute();
         $number_of_movies = $select_movies->rowCount();
      ?>
      <h3><?= $number_of_movies; ?></h3>
      <p>Movies showing</p>
      <a href="admin_movies.php" class="btn">See movies</a>
      </div>
      <div class="box">
      <?php
         $select_accounts = $conn->prepare("SELECT * FROM `users`");
         $select_accounts->execute();
         $number_of_accounts = $select_accounts->rowCount();
      ?>
      <h3><?= $number_of_accounts; ?></h3>
      <p>Total accounts</p>
      <a href="admin_users.php" class="btn">See accounts</a>
      </div>

      <div class="box">
      <?php
         $select_messages = $conn->prepare("SELECT * FROM `message`");
         $select_messages->execute();
         $number_of_messages = $select_messages->rowCount();
      ?>
      <h3><?= $number_of_messages; ?></h3>
      <p>Total messages</p>
      <a href="admin_contacts.php" class="btn">See messages</a>
      </div>

   </div>

</section>

<script src="js/script.js"></script>

</body>
</html>