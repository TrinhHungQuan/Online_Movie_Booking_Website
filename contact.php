<?php

   @include 'config.php';

   session_start();

   $user_id = $_SESSION['user_id'];

   if(!isset($user_id)){
      header('location:login.php');
   };

   if(isset($_POST['send'])){

      $name = $_POST['name'];
      $name = filter_var($name, FILTER_SANITIZE_STRING);
      $email = $_POST['email'];
      $email = filter_var($email, FILTER_SANITIZE_STRING);
      $number = $_POST['number'];
      $number = filter_var($number, FILTER_SANITIZE_STRING);
      $msg = $_POST['msg'];
      $msg = filter_var($msg, FILTER_SANITIZE_STRING);

      $select_message = $conn->prepare("SELECT * FROM `message` WHERE name = ? AND email = ? AND number = ? AND message = ?");
      $select_message->execute([$name, $email, $number, $msg]);

      if($select_message->rowCount() > 0){
         $message[] = 'already sent message!';
      }else{

         $insert_message = $conn->prepare("INSERT INTO `message`(user_id, name, email, number, message) VALUES(?,?,?,?,?)");
         $insert_message->execute([$user_id, $name, $email, $number, $msg]);

         $message[] = 'sent message successfully!';

      }

   }  

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Contact</title>
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
<section class="contact">
   <form action="" method="POST">
      <input type="text" name="name" class="box" required placeholder="Enter your name">
      <input type="email" name="email" class="box" required placeholder="Enter your email">
      <input type="text" name="number" class="box" required placeholder="Enter your phone number">
      <textarea name="msg" class="box" required placeholder="Enter your message" cols="30" rows="10"></textarea>
      <input type="submit" value="Send" class="btn" name="send">
   </form>

</section>
<br>
<br>
<section class="system" style="text-align: center">
         <h1>CINEMA SYSTEM</h1>
        <img src="uploaded_img/logo_cinema.jpg" style="height: 70px; width: 70px">
        <div>________</div>
        <h2>Ho Chi Minh City</h2>
        <p>District 1 Cinema: Floor 3, Vincom Dong Khoi Center</p>
        <p>District 7 Cinema: Floor 5, SC VivoCity</p>
   
        <div>________</div>
        <h2>Quy Nhon City</h2>
        <p>Quy Nhon Cinema: Floor 3, Kim Cuc Plaza</p>

        <div>________</div>
        <h2>Phu Yen</h2>
        <p>Tuy Hoa Cinema: Floor 3, Vincom Center, Hung Vuong</p>
        <div>________</div>
    </section>

<script src="js/script.js"></script>
<?php include 'footer.php'; ?>
</body>
</html>