<?php
session_start();
if(isset($_SESSION['id'])){
    $id=$_SESSION['id'];
    if($id=="admin"){
        header('location:admin.php');
    }
}else{
    header('location:index.php');
}
include "class/learner.php";
$learner = new learner();
?>

<html>
<head>
    <title>BookBorrow.com | Profile</title>
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <link rel="shortcut icon" href="assets/images/bookborrow.png" type="image/x-icon"/>
</head>
<body>
<div class="container">

    <!--    header-->
    <header>
        <a href="index.php"><img src="assets/images/logo.png"></a>
        <div class="navigation-search pull-right">
            <div class="navigation">
                <ul class="pull-right">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="discussion.php">Discussion</a></li>
                    <li class="dropdown">
                        <a href="#"class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            Books
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" style="padding: 0px;">
                            <li style="padding: 0px;"><a href="my_books.php">My Books</a></li>
                            <li style="padding: 0px;"><a href="borrow_books.php">Borrow Books</a></li>
                            <li style="padding: 0px;"><a href="view_claim_book.php">Claim Books</a></li>
                        </ul>
                    </li>
                    <li class="dropdown active">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            Hy <?php echo $_SESSION['name']?>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" style="padding: 0px;">
                            <li style="padding: 0px;"><a href="profile.php">Your Profile</a></li>
                            <li style="padding: 0px;"><a href="change_password.php">Change Password</a></li>
                            <li style="padding: 0px;"><a href="logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <!--    header end-->


    <div class="content content-padding">
        <ol class="breadcrumb">
            <li><a href="dashboard.php">Home</a></li>
            <li class="active">Change Password</li>
        </ol>
        <hr/>

        <div class="col-md-6 col-md-offset-3">
            <h2 style="text-align: center;">Change Password</h2>
            <hr>
            <?php
            if(isset($_POST['change_btn'])){
                $learner->setPassword($_POST['old_password']);
                $learner->setConfirmPassword($_POST['confirm_password']);
                $learner->setNewPassword($_POST['new_password']);

                $learner->changePassword($_SESSION['id']);
            }
            ?>

            <form method="post">
                <div class="form-group">
                    <label>Password</label>
                    <input name="old_password" type="password" class="form-control" placeholder="Old Password">
                </div>
                <div class="form-group">
                    <label>New Password</label>
                    <input name="new_password" type="password" class="form-control" placeholder="New Password">
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input name="confirm_password" type="password" class="form-control" placeholder="Confirm Password">
                </div>
                <button name="change_btn" type="submit" class="btn theme-success-button">Register</button>
            </form>

        </div>

        <hr/>

    </div>




    <footer>
        © 2018 BookBorrow.com
    </footer>

</div>
</body>
</html>