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
include "class/selectFunction.php";
$selectFunction = new selectFunction();
?>

<html>
<head>
    <title>BookBorrow.com | Welcome</title>
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
                    <li class="active"><a href="index.php">Home</a></li>
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
    <div class="content carousel-padding">
        <style>
            h1,h2,h3,h5{
                text-align: center;
            }
        </style>
        <?php
        $fetchLearners = array(array(
            "good_points"=>""
        ));
        //getting learner details
        $fetchLearners= $learner->selectLearnerByID($_SESSION['id']);

        $fetchGiveaway = array(array(
            "points"=>"",
        ));
        //getting giveaway details
        $fetchGiveaway = $learner->getDatabase()->select($selectFunction->selectGiveaway($_GET['giveawayId']));

        if($fetchLearners[0]["good_points"]>=$fetchGiveaway[0]['points']){
        $checkClaim = $learner->getDatabase()->select($selectFunction->checkLearnerClaim($_SESSION['id'],$_GET['giveawayId']));
            if($checkClaim>0){
                echo '<h1>Congratulations! You are eligible for this claim</h1>';
                echo '<h1>But you have already claim this book on '.$checkClaim[0]["claim_date"].'</h1>';
                echo '<h2>Thank you for using our website.</h2>';
            }else{
                $learner->getDatabase()->insert($selectFunction->claimGiveaway($_SESSION['id'],$_GET['giveawayId']));
                echo '<h1>Congratulations! You are eligible for this claim</h1>';
                echo '<h2>Thank you for using our website.</h2>';
            }
        }else{
            echo '<h1>Sorry! You are not eligible for this claim.</h1>';
            echo '<h2>You need to increase your good points.</h2>';
            echo '<h5><strong>Note : </strong>Those learner whose good points has crossed '.$fetchGiveaway[0]['points'].' points can claim this book</h5>';
        }
        ?>
    </div>
    <!--search end-->


    <footer>
        © 2018 BookBorrow.com
    </footer>

</div>
</body>
</html>