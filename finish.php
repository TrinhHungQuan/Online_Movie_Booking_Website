<?php

   @include 'config.php';

   session_start();

   $user_id = $_SESSION['user_id'];

   if(!isset($user_id)){
      header('location:login.php');
   };
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finish</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="css/styleuser.css">
</head>
<body>
    <?php 
        include 'header.php';
    ?>
    <div class="ship" style = "text-align: center">
        <h2>YOUR BOOKING TICKET HAVE BEEN SENT TO THE SYSTEM: </h2>
        <br>
        <p>Name: <?php echo $_SESSION['name']; ?></p>
        <br>
        <p>Theater: <?php echo $_SESSION['flat']; ?></p>
        <br>
        <p>Phone Number: <?php echo $_SESSION['number']; ?></p>
        <br>
        <p>Email: <?php echo $_SESSION['email']; ?></p>
        <br>
        <p>Payment method: <?php echo $_SESSION['method']; ?></p>
        <br>
        <?php $total_movies = $_GET['total_movies']; ?>
        <p>Movie: <?php echo $total_movies; ?></p>
        <br>
        <?php $total_price = $_GET['total_price']; ?>
        <p>Total Price: <?php echo $total_price; ?></p>
        <br><br><br>

        
        
    </div>

    <form id="my-form" action="vnpay_php/index.php" method="post">
        <h2 style = "text-align: center">IF YOU CHOOSE THE METHOD 'VNPAY'. PLEASE CLICK HERE TO FINISH THE TRANSACTION...</h2>
        <div style="display: flex; justify-content: center; align-items: center;">
            <button type="submit" class="option-btn" style="width: 30%;">VN Pay</button>
        </div>
        <input type="hidden" id="amount-input" name="total_amount" value="<?php echo  $total_price*24000?>">
        <input type="hidden" id="name-use" name="user_name" value="<?php echo $_SESSION['name']?>">
        <input type="hidden" id="email-use" name="user_email" value="<?php echo $_SESSION['email']?>">
        <input type="hidden" id="phone-use" name="user_phone" value="<?php echo $_SESSION['number']?>">
        <input type="hidden" id="address-use" name="user_address" value="<?php echo $_SESSION['flat']?>">
        <input type="hidden" id="content-use" name="user_content" value=" <?php echo $total_price ?> <?php echo $_SESSION['name']?> <?php echo $_SESSION['flat']?>">
    </form>


    
</body>
</html>
