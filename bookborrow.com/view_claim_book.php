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
include "class/giveaway.php";
$giveaway = new giveaway();
?>

<html>
<head>
    <title>BookBorrow.com | Claim</title>
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
                    <li class="dropdown active">
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
                    <li class="dropdown">
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

    <!--    content-->

    <!--    carousel-->
    <div class="content content-padding">
        <ol class="breadcrumb">
            <li><a href="dashboard.php">Home</a></li>
            <li class="active">Claim Books</li>
        </ol>
        <hr/>

        <div class="col-lg-12">
            <h2 style="text-align: center;">Claim Books</h2>
        </div>
        <hr/>

        <div class="col-lg-12">
            <h3>Claim List</h3>
            <table class="table table-bordered" style="font-size: small;">
                <thead>
                <tr>
                    <th>S.N.</th>
                    <th>Book Name</th>
                    <th>Points</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(!$giveaway->selectClaimBooks($_SESSION['id'])){
                    echo '<div class="alert alert-danger">0 Book claimed till now</div>';
                }else{
                    $fetchBooks= $giveaway->selectClaimBooks($_SESSION['id']);
                    foreach($fetchBooks as $fetchBooksRow){
                        echo' <tr>';
                        echo' <td>'.$fetchBooksRow["claim_id"].'</td>';
                        echo' <td>'.$fetchBooksRow["book_name"].'</td>';
                        echo' <td>'.$fetchBooksRow["points"].'</td>';
                        echo' <td>'.$fetchBooksRow["claim_date"].'</td>';
                        echo' </tr>';
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <!--search end-->

    <!--    content end-->



    <footer>
        © 2018 BookBorrow.com
    </footer>

</div>
</body>
</html>