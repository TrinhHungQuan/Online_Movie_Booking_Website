<?php

   include 'config.php';

   if(isset($_POST['submit'])){

      $name = $_POST['name'];
      $name = filter_var($name, FILTER_SANITIZE_STRING);
      $email = $_POST['email'];
      $email = filter_var($email, FILTER_SANITIZE_STRING);
      $pass = md5($_POST['pass']);
      $pass = filter_var($pass, FILTER_SANITIZE_STRING);
      $cpass = md5($_POST['cpass']);
      $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

      $image = $_FILES['image']['name'];
      $image = filter_var($image, FILTER_SANITIZE_STRING);
      $image_size = $_FILES['image']['size'];
      $image_tmp_name = $_FILES['image']['tmp_name'];
      $image_folder = 'uploaded_img/'.$image;

      $select = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
      $select->execute([$email]);

      if($select->rowCount() > 0){
         $message[] = 'User email already exist!';
      }else{
         if($pass != $cpass){
            $message[] = 'Confirm password not matched!';
         }else{
            $insert = $conn->prepare("INSERT INTO `users`(name, email, password, image) VALUES(?,?,?,?)");
            $insert->execute([$name, $email, $pass, $image]);

            if($insert){
               if($image_size > 2000000){
                  $message[] = 'Image size is too large!';
               }else{
                  move_uploaded_file($image_tmp_name, $image_folder);
                  $message[] = 'Register successfully!';
                  header('location:login.php');
               }
            }

         }
      }

   }

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register now</title>
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

<form action="" enctype="multipart/form-data" method="post">
   <h3>Register now</h3>
   <input type="text" name="name"  placeholder="Enter your full name" class="box" required>
   <input type="email" name="email" placeholder="Enter your email" class="box" required>
   <input type="password" name="pass"  placeholder="Enter your password" class="box" required>
   <input type="password" name="cpass" placeholder="Re-enter your password" class="box" required>
   <input type="file" name="image"  class="box" required accept="image/jpg,image/jpeg,image/png">
   <input type="submit" name="submit" class="btn" value="Register">
   <p>Already have an account? <a href="login.php">Login here</a></p>
</form>

</section>
</body>
</html>