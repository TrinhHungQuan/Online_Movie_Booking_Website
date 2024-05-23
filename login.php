<?php

   @include 'config.php';

   session_start();

   if(isset($_POST['submit'])){

      $email = $_POST['email'];
      $email = filter_var($email, FILTER_SANITIZE_STRING);
      $pass = md5($_POST['pass']);
      $pass = filter_var($pass, FILTER_SANITIZE_STRING);

      $sql = "SELECT * FROM `users` WHERE email = ? AND password = ?";
      $stmt = $conn->prepare($sql);
      $stmt->execute([$email, $pass]);
      $rowCount = $stmt->rowCount();  

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      if($rowCount > 0){

         if($row['user_type'] == 'admin'){

            $_SESSION['admin_id'] = $row['id'];
            header('location:admin_page.php');

         }elseif($row['user_type'] == 'user'){

            $_SESSION['user_id'] = $row['id'];
            header('location:home.php');

         }else{
            $message[] = 'No user found!';
         }

      }else{
         $message[] = 'Inputted email or password wrong!';
      }

   }

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>
   <link rel="stylesheet" href="css/form.css">
</head>
<body>

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

<section class="form-container">

   <form action="" method="POST">
      <h3>Login now</h3>
      <input type="email" name="email" class="box" placeholder="Enter your email" required>
      <input type="password" name="pass" class="box" placeholder="Enter your password" required>
      <input type="submit" value="login now" class="btn" name="submit">
      <p>Don't have an account? <a href="register.php">Register now</a></p>
   </form>

</section>


</body>
</html>