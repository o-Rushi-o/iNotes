<?php

// session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true) {
    $loggedin=true;
}else{
  $loggedin = false;
}

echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>
        <!-- navbar -->
        <nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark border-bottom border-body" data-bs-theme="dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="/login-sys">iNotes</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="/login-sys/welcome.php">Home</a>
            </li>';

          if(!$loggedin){
          echo  '<li class="nav-item">
              <a class="nav-link" href="/login-sys/login.php">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/login-sys/signup.php">Sign Up</a>
            </li>';}
            
            if($loggedin){
              echo'<li class="nav-item">
              <a class="nav-link" href="/login-sys/logout.php">Logout</a>
            </li>';}

          echo'</ul>
        </div>
      </div>
    </nav>
</body>
</html>';
?>