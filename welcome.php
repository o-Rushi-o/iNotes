<?php

session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true) {
    header('location: login.php');
    exit;
}

?>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";
$insert = false;
$update = false;
$delete = false;
$conn = mysqli_connect($servername, $username, $password, $database);
if(!$conn){
die( 'connection failed'.mysqli_connect_error());
}
else{
  if(isset($_GET['delete'])){
    $d_sno = $_GET['delete'];
    $delete = true;
    $sql = "DELETE FROM `rushi` WHERE `no` = $d_sno";
    $result = mysqli_query($conn, $sql);
  }
if($_SERVER['REQUEST_METHOD'] == 'POST'){
if (isset($_POST['snoEdit'])) {
$snoEdit = $_POST['snoEdit'];
$title = $_POST['titleEdit'];
$desc = $_POST['descEdit'];
$sql = "UPDATE `rushi` SET `Title` = '$title' , `Description` = '$desc' WHERE `no` = $snoEdit";
$result = mysqli_query($conn, $sql);
if($result){
// echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  //   data has been inserted successfully.
  //   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
// </div>';
$update = true;
}
else{
echo 'error:'.mysqli_error($conn);
}
}
else{
$title = $_POST['title'];
$desc = $_POST['desc'];
$sql = "INSERT INTO `rushi` (`Title`, `Description`) VALUES ('$title', '$desc')";
$result = mysqli_query($conn, $sql);
if($result){
// echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  //   data has been inserted successfully.
  //   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
// </div>';
$insert = true;
}
else{
echo 'error:'.mysqli_error($conn);
}
}
}
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome <?php echo $_SESSION['username']?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.2/css/dataTables.dataTables.min.css">
</head>
<body>

<!-- navbar imported -->
    <?php 
    require("partials/navbar.php");
    ?>
    
    <!-- <div class="container my-4">
    <div class="alert alert-success" role="alert">
  <h4 class="alert-heading">Welcome <?php echo $_SESSION['username']?> !</h4>
  <p>Aww yeah, you successfully read this important alert message. This example text is going to run a bit longer so that you can see how spacing within an alert works with this kind of content.</p>
  <hr>
  <p class="mb-0">Whenever you need to logout from this account please use this link. ===> <a href="/login-sys/logout.php">logout</a></p>
</div>
    </div> -->

    <!-- Button trigger modal -->
    <!--  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Launch demo modal
    </button> -->
    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="editModalLabel">Edit note</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="/CRUD-APP/index.php" method="POST">
              <input type="hidden" name="snoEdit" id="snoEdit">
              <div class="from-group">
                <label for="title" class="form-label">Note Title</label>
                <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
              </div>
              <div class="mb-3">
                <label for="desc" class="form-label">Note Description</label>
                <textarea class="form-control" id="descEdit" name="descEdit" rows="3"></textarea>
              </div>
              <button type="submit" class="btn btn-primary">Update Note</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <?php
    if($insert){
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      Your note is added successfully.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
    ?>
    <?php
    if($update){
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      Your note is Updated successfully.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
    ?>
     <?php
    if($delete){
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      Your note is Deleted successfully.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
    ?>
    <div class="container mt-5">
      <h2>Add Notes</h2>
      <form action="/CRUD-APP/index.php" method="POST">
        <div class="mb-3">
          <label for="title" class="form-label">Note Title</label>
          <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
          <label for="desc" class="form-label">Note Description</label>
          <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Add Note</button>
      </form>
    </div>
    <div class="container my-4">
      <table class="table" id="myTable">
        <thead>
          <tr>
            <th scope="col">Sr no</th>
            <th scope="col">Title</th>
            <th scope="col">Description</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT * FROM `rushi`";
          $result = mysqli_query($conn, $sql);
          $sno = 1;
          while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>
            <th scope='row'>".$sno."</th>
            <td>".$row['Title']."</td>
            <td>".$row['Description']."</td>
            <td><button class='edit btn btn-sm btn-primary' id=".$row['no'].">Edit</button> <button class='delete btn btn-sm btn-primary' id=d".$row['no'].">Delete</button></td>
          </tr>";
          $sno +=1;
          }
          ?>
        </tbody>
      </table>
    </div>
    <hr>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>
    <script>
    let table = new DataTable('#myTable');
    </script>
    <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element)=>{
    element.addEventListener("click", (e)=>{
    console.log("edit ",);
    tr = e.target.parentNode.parentNode;
    title = tr.getElementsByTagName("td")[0].innerText;
    description = tr.getElementsByTagName("td")[1].innerText;
    console.log(title, description);
    titleEdit.value = title;
    descEdit.value = description;
    snoEdit.value = e.target.id;
    console.log(e.target.id);
    $('#editModal').modal('toggle');
    })
    })

    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element)=>{ 
    element.addEventListener("click", (e)=>{
    console.log("delete ",);
    no = e.target.id.substr(1,);
    if (confirm("Are you sure you want to delete this note!")) {
      console.log("yes");
      window.location = '/CRUD-APP/index.php?delete='+no;
    }
    else{
      console.log("no");
    }
    })
    })
    </script>
</body>
</html>