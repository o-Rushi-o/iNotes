<?php
$showAlert = false;
$showError = false;
if($_SERVER["REQUEST_METHOD"] == 'POST'){
    include('partials/dbconnect.php');
    $username= $_POST['username'];
    $password= $_POST['password'];
    $cpassword= $_POST['cpassword'];
    // $exists=false;
    // /check whether this username Exists
    $existSql = "SELECT * from users where username = '$username'";
    $result = mysqli_query($conn, $existSql);
    $numExistRows=mysqli_num_rows($result);
    if($numExistRows>0){
      $exists=true;
      $showError='User is Already Exists!';

    }else{
      $exists=false;
      if(($password==$cpassword)){
          $sql="INSERT INTO `users` (`username`, `password`, `dt`) VALUES ('$username', '$password', current_timestamp())";
          $result = mysqli_query($conn, $sql);
          if($result){
              $showAlert=true;
          }
      }else{
            $showError='Password not match!';
      }
    }
  }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
  </head>
  <body>
    <!-- navbar imported -->
    <?php
    require("partials/navbar.php");
    if($showAlert){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        user created
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    if($showError){
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'.$showError.'
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    ?>
    <!-- form -->
    <div class="container my-4">
        <h1 class="text-center">Signup to our website</h1>
      <form action="/login-sys/signup.php" method="POST">
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control" name="username" id="username" />
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input
            type="password"
            class="form-control"
            name="password"
            id="password"
            aria-describedby="emailHelp"
          />
        </div>
        <div class="mb-3">
          <label for="cpassword" class="form-label">Confirm Password</label>
          <input
            type="password"
            class="form-control"
            name="cpassword"
            id="cpassword"
            aria-describedby="emailHelp"
          />
        </div>
        <button type="submit" class="btn btn-primary">Sign Up</button>
      </form>
    </div>
  </body>
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"
  ></script>
</html>
