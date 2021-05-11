<?php
session_start();
$res="";
$msg="";
$total=0;

include "../classes/Database.php";
include "../classes/Expense.php";

$db =   new Database();
$exp    =   new Expense($db);

if(isset($_GET['delete'])){
    $msg=$exp->deleteExpDet($_GET['delete']);
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

    <title>Hello, world!</title>
  </head>
  <body>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="dashboard.php">Expense</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="dashboard">Dashboard</a>
        </li>
        <?php
        if($_SESSION['userType']=='admin'){
            ?>
            <li class="nav-item">
                <a class="nav-link" href="all-user.php">All User</a>
            </li>
            <?php
        }
        ?>
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php echo $_SESSION['username']; ?>
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
          </ul>
        </li>
      </ul>
      
    </div>
  </div>
</nav>

    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card my-5">
                    <h5 class="card-header">Expense Details</h5>
                    <div class="card-body">
                        <?php
                        if($msg==1){
                            echo "Deleted";
                        }
                        if(isset($_POST['add'])){
                            $name=$_POST['name'];
                            $details=$_POST['details'];
                            $image=$_FILES['image'];
                            $amount=$_POST['amount'];
                            $expId=$_GET['id'];

                           

                            $res=$exp->createExpDet($name, $details, $image, $amount, $expId);

                            if($res==1){
                                ?>
                                <div class="alert alert-primary" role="alert">
                                    <p class="text-center">Expense Created</p>
                                </div>
                                <?php
                            }
                        }
                        ?>
                        <form method="post" action="" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" id="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="details" class="form-label">Details</label>
                                <textarea class="form-control" required name="details" id="details" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="amount" class="form-label">Amount</label>
                                <input type="number" name="amount" class="form-control" id="amount" required>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Image</label>
                                <input type="file" name="image" class="form-control" id="image">
                            </div>
                            <button type="submit" name="add" class="btn btn-primary">Add</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row mb-5">
            <div class="com-md-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                        <th scope="col">Serial</th>
                        <th scope="col">Name</th>
                        <th scope="col">Details</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Image</th>
                        <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $res=$exp->allExpDet($_GET['id']);
                        if($res==0){
                            echo "No expense list found!!!";
                        }
                        else{
                            foreach($res as $key=>$data){
                                $amount=(int)$data['amount'];
                                $total+=$amount;
                                ?>
                                <tr>
                                    <th scope="row"><?php echo $key+1; ?></th>
                                    <td><?php echo $data['name']; ?></td>
                                    <td><?php echo $data['details']; ?></td>
                                    <td><?php echo $data['amount']; ?></td>
                                    <td>
                                        <?php
                                        if($data['image']==null){
                                            echo "No Image";
                                        }
                                        else{
                                            ?>
                                            <img src="image/<?php echo $data['image']; ?>" alt="<?php echo $data['name']; ?>" width="80">
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td><a href="expense.php?delete=<?php echo $data['id']; ?>&&id=<?php echo $_GET['id']; ?>">Delete</a></td>
                                </tr>
                                <?php
                            }

                            echo $total;
                        }

                    ?>
                        <tfoot>
                            <th scope="col">Total</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col"><?php echo $total; ?></th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tfoot>
                        
                    </tbody>
                </table>
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