<?php
include "class/learner.php";
include "class/selectFunction.php";
$selectFunction = new selectFunction();
$learner = new learner();
session_start();
if(isset($_SESSION['id'])){
    $id=$_SESSION['id'];
    if($id!="admin"){
        header('location:dashboard.php');
    }
}else{
    header('location:index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Area | Users</title>
    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/admin-style.css" rel="stylesheet">
    <link rel="shortcut icon" href="assets/images/bookborrow.png" type="image/x-icon"/>
</head>
<body>

<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="admin.php">BookBorrow.com</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="admin.php">Dashboard</a></li>
                <li><a href="view_borrow.php">Borrow</a></li>
                <li><a href="giveaway.php">Giveaway</a></li>
                <li><a href="view_book.php">Books</a></li>
                <li class="active"><a href="users.php">Users</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="admin.php">Welcome, Admin</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<header id="header">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Users </h1>
            </div>
        </div>
    </div>
</header>

<section id="breadcrumb">
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="admin.php">Dashboard</a></li>
            <li class="active">Users</li>
        </ol>
    </div>
</section>

<section id="main">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="list-group">
                    <a href="admin.php" class="list-group-item">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Dashboard
                    </a>
                    <a href="view_borrow.php" class="list-group-item"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Borrow <span class="badge">
                            <?php echo $learner->getDatabase()->checkRows($selectFunction->countBorrow()); ?>
                        </span></a>
                    <a href="giveaway.php" class="list-group-item"><span class="glyphicon glyphicon-gift" aria-hidden="true"></span> Giveaway <span class="badge">
                            <?php echo $learner->getDatabase()->checkRows($selectFunction->countGiveaway()); ?>
                        </span></a>
                    <a href="view_book.php" class="list-group-item"><span class="glyphicon glyphicon-book" aria-hidden="true"></span> Books <span class="badge">
                            <?php echo $learner->getDatabase()->checkRows($selectFunction->countBooks()); ?>
                        </span></a>
                    <a href="users.php" class="list-group-item active main-color-bg"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Users <span class="badge">
                            <?php echo $learner->getDatabase()->checkRows($selectFunction->countLearners()); ?>
                    </span></a>
                </div>

            </div>
            <div class="col-md-9">
                <!-- Website Overview -->
                <div class="panel panel-default panel-min-height">
                    <div class="panel-heading main-color-bg">
                        <h3 class="panel-title">Users</h3>
                    </div>
                    <div class="panel-body">
                        <br>


                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>S.N.</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>

                            <?php
                            $fetchLearnerId=0;
                            if(!$learner->selectLearners()){
                                echo '<div class="alert alert-danger">There is no Learners registered till now</div>';
                            }else{
                                $fetchLearners= $learner->selectLearners();
                                foreach($fetchLearners as $fetchLearnersRow){
                                    $fetchLearnerId = $fetchLearnersRow["learnerId"];
                                    echo' <tr>';
                                    echo' <td>'.$fetchLearnersRow["learnerId"].'</td>';
                                    echo' <td>'.$fetchLearnersRow["name"].'</td>';
                                    echo'<td>'.$fetchLearnersRow["email"].'</td>';
                                    echo' </tr>';
                                }
                            }
                            ?>

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

<footer id="footer">
    <p>Copyright BookBorrow.com, &copy; 2018</p>
</footer>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
