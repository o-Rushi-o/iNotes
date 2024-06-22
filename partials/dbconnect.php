<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "users";
$conn = mysqli_connect($servername, $username, $password, $database);
if(!$conn){
    die( 'connection failed'.mysqli_connect_error($conn));
}
// else{
//     echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
//       database connected
//       <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
//     </div>';
// }
?>