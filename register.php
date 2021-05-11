<?php
$res=0;
include "classes/Database.php";
include "classes/User.php";
$db=new Database();

$user=new User($db);
// user registration
if(isset($_POST['register'])){
    $fullName   =   $_POST['fullName'];
    $username   =   $_POST['username'];
    $email      =   $_POST['email'];
    $password   =   $_POST['password'];
    $res=$user->register($fullName, $username, $email, $password);
}
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <title>Register - Expenses</title>
  </head>
  <body>
    <?php
    if($res==1){
        ?>
        <div class="alert alert-primary" role="alert">
            <p class="text-center">Registration Success</p>
        </div>
        <?php
    }
    else if($res==2){
        ?>
        <div class="alert alert-danger" role="alert">
            <p class="text-center">Username or email already exist</p>
        </div>
        <?php
    }
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card my-5">
                    <h5 class="card-header">Registration</h5>
                    <div class="card-body">
                        <form method="post" action="">
                            <div class="mb-3">
                                <label for="fullName" class="form-label">Full Name</label>
                                <input type="text" autocomplete="off" name="fullName" class="form-control" id="fullName" required>
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" autocomplete="off" name="username" class="form-control" id="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" autocomplete="off" name="email" class="form-control" id="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" autocomplete="off" name="password" class="form-control" id="password" required>
                            </div>
                            <button type="submit" name="register" class="btn btn-primary">Register</button>
                            <p class="my-2">Already registred? <a href="login.php" class="text-decoration-none">Login Here</a> </p>
                        </form>
                        <p></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    -->
  </body>
</html>