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
include "class/book.php";
$book = new book();
include "class/borrow.php";
$borrow = new borrow();
$fetchBookDetails = array(array(
    "book_name"=>"",
    "author"=>"",
    "ISBN"=>"",
    "publication_date"=>"",
    "publisher"=>"",
    "book_description"=>"",
    "book_genre"=>"",
    "rating"=>""
));
$fetchBookDetails = $book->selectBookByID($_GET['book_id']);

?>

<html>
<head>
    <title>BookBorrow.com | Books</title>
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
    <div class="content content-padding">
            <ol class="breadcrumb">
                <li><a href="dashboard.php">Home</a></li>
                <li class="active">Books</li>
            </ol>
            <hr/>

        <div class="col-lg-12">
            <fieldset>
                <legend>
                    <?php echo $fetchBookDetails[0]['book_name'] ?>
                </legend>
                <div style="float: left;width: 30%;">
                    <img src="assets/images/<?php echo $fetchBookDetails[0]['book_image']?>">
                </div>
                <div style="float: left;width: 70%;">
                    <strong>Book Name : </strong><?php echo $fetchBookDetails[0]['book_name'] ?><br/>
                    <strong>Author Name : </strong><?php echo $fetchBookDetails[0]['author']?><br/>
                    <strong>ISBN : </strong><?php echo $fetchBookDetails[0]['ISBN']?><br/>
                    <strong>Publication Date : </strong><?php echo $fetchBookDetails[0]['publication_date']?><br/>
                    <strong>Publisher : </strong><?php echo $fetchBookDetails[0]['publisher']?><br/>
                    <strong>Genre : </strong><?php echo $fetchBookDetails[0]['book_genre'] ?><br/>
                    <strong>Maximum Borrow Days : </strong><?php echo $fetchBookDetails[0]['max_borrow'] ?><br/>
                    <strong>Rating : </strong><?php echo $fetchBookDetails[0]['rating'] ?><br/>
                    <strong>Description : </strong><br/>
                    <?php echo $fetchBookDetails[0]['book_description'] ?><br/>
                    <?php
                    if(isset($_POST['borrow_btn'])){
                        $borrow_days = $_POST['borrow_days'];
                        $max_borrow_days = $fetchBookDetails[0]['max_borrow'];
                        if($borrow_days>$max_borrow_days || $borrow_days==0){
                            echo "You can't borrow this book for this much days";
                        }else{
                            $borrow->setBorrowDays($borrow_days);
                            $borrow->setBorrowerId($_SESSION['id']);
                            $borrow->setBookId($_GET['book_id']);
                            $book->getLearner()->getDatabase()->insert($borrow->borrowBook());
                        }
                    }
                    ?>
                    <form class="form-inline" method="post">
                        <?php
                        $fetchBookBorrowDetails = array(array(
                            "status"=>""
                        ));
                        $learnerID = $fetchBookDetails[0]['learner_id'];
                        if($learnerID==$_SESSION['id']){
                            echo '<div class="alert alert-danger" role="alert">';
                            echo "This is your Book. You can't borrow your own book.";
                            echo '</div>';
                        }else{
                            $checkBookBorrow = $book->getLearner()->getDatabase()->checkRows($borrow->checkBookBorrow($_GET['book_id']));
                            if($checkBookBorrow>0){
                                $fetchBookBorrowDetails = $book->getLearner()->getDatabase()->select($borrow->checkBookBorrow($_GET['book_id']));
                                if(!$fetchBookBorrowDetails[0]['status']){
                                    echo '<div class="form-group">';
                                    echo '<label for="exampleInputDays3">Enter Days : </label>';
                                    echo '<input name="borrow_days" type="number" class="form-control" id="exampleInputDays3" style="margin: 0px 4px;">';
                                    echo '</div>';
                                    echo '<button type="submit" name="borrow_btn" class="btn btn-success">Borrow</button>';
                                }else{
                                    echo '<div class="alert alert-danger" role="alert">';
                                    echo "This book has been already borrowed";
                                    echo '</div>';
                                }
                            }else{
                                echo '<div class="form-group">';
                                echo '<label for="exampleInputDays3">Enter Days : </label>';
                                echo '<input name="borrow_days" type="number" class="form-control" id="exampleInputDays3" style="margin: 0px 4px;">';
                                echo '</div>';
                                echo '<button type="submit" name="borrow_btn" class="btn btn-success">Borrow</button>';
                            }
                        }
                        ?>
                    </form>
                    <?php
                    if(isset($_POST['rate_btn'])){
                        $rating = $_POST['rating'];
                        $book->rateBooks($rating,$_GET['book_id']);
                        echo '<div class="alert alert-success" role="alert">';
                        echo 'Thank you for rating';
                        echo '</div>';
                    }
                    ?>
                    <form method="post" class="form-inline">
                        <div class="form-group">
                            <label for="exampleInputRating">Rate Product :
                                <select class="form-control" name="rating" id="exampleInputRating">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                                <button type="submit" name="rate_btn" class="btn btn-success" >Rate</button>
                        </div>
                    </form>

                </div>
            </fieldset>
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