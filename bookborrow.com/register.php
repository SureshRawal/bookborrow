

<?php
include "class/learner.php";
$learner = new learner();
session_start();
if(isset($_SESSION['id'])){
    $id=$_SESSION["id"];
    if($id=="admin"){
        header('location: admin.php');
    }else{
        header('location:dashboard.php');
    }

}
?>

<html>
<head>
    <title>BookBorrow.com | Register</title>
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="assets/images/bookborrow.png" type="image/x-icon"/>
</head>
<body>
<div class="container">
    <header>
        <a href="index.html"><img src="assets/images/logo.png"></a>
        <div class="navigation-search pull-right">
            <div class="navigation">
                <ul class="pull-right">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="login.php">Login</a></li>
                    <li class="active"><a href="register.php">Register</a></li>
                </ul>
            </div>

        </div>
    </header>

    <div class="content">
        <div class="col-md-6 col-md-offset-3">
            <div class="book-borrow-panel content-padding">

                <?php
                if(isset($_POST['register'])){
                    $learner->setName($_POST['name']);
                    $learner->setEmail($_POST['email']);
                    $learner->setPassword($_POST['password']);
                    $learner->setConfirmPassword($_POST['confirmPassword']);

                    $learner->register();
                }
                ?>

                <h2>Register</h2>
                <hr>
                <form method="post">
                    <div class="form-group">
                        <label>Name</label>
                        <input name="name" type="text" class="form-control" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input name="email" type="email" class="form-control" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input name="password" type="password" class="form-control" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input name="confirmPassword" type="password" class="form-control" placeholder="Confirm Password">
                    </div>
                    <button name="register" type="submit" class="btn theme-success-button">Register</button>
                </form>
            </div>
        </div>
    </div>

    <footer>
        © 2018 BookBorrow.com
    </footer>

</div>
</body>
</html>