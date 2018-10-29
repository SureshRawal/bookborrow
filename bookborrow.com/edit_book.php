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
$fetchBookDetails = array(array(
    "book_name"=>"",
    "author"=>"",
    "ISBN"=>"",
    "publication_date"=>"",
    "publisher"=>"",
    "book_description"=>"",
    "book_genre"=>""
));
$fetchBookDetails = $book->selectBookByID($_GET['book_id']);
if (isset($_POST['edit_book_btn'])){
    $book->setBookName($_POST['book_name']);
    $book->setAuthor($_POST['author']);
    $book->setISBN($_POST['ISBN']);
    $book->setPublicationDate($_POST['publication_date']);
    $book->setPublisher($_POST['publisher']);
    $book->setBookDescription($_POST['book_description']);
    $book->setBookGenre($_POST['book_genre']);

    $book->editBook($_GET['book_id']);

}
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
            <li><a href="my_books.php">My Books</a></li>
            <li class="active">Edit Book</li>
        </ol>
        <hr/>

        <div class="col-lg-12">
            <h2 style="text-align: center;">Edit Book</h2>
            <form method="post">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Book Name</label>
                        <input class="form-control" name="book_name" type="text" value="<?php echo $fetchBookDetails[0]['book_name'] ?>">
                    </div>
                    <div class="form-group">
                        <label>ISBN</label>
                        <input class="form-control" name="ISBN" type="text" value="<?php echo $fetchBookDetails[0]['ISBN']?>">
                    </div>
                    <div class="form-group">
                        <label>Publisher</label>
                        <input class="form-control" name="publisher" type="text" value="<?php echo $fetchBookDetails[0]['publisher']?>">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea rows="5" class="form-control" name="book_description"><?php echo $fetchBookDetails[0]['book_description'] ?></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Edit" class="btn btn-success" name="edit_book_btn">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Author</label>
                        <input class="form-control" name="author" type="text" value="<?php echo $fetchBookDetails[0]['author']?>" >
                    </div>
                    <div class="form-group">
                        <label>Publication Date</label>
                        <input class="form-control" name="publication_date" type="date" value="<?php echo $fetchBookDetails[0]['publication_date']?>">
                    </div>
                    <div class="form-group">
                        <label>Select Genre</label>
                        <Select name="book_genre" class="form-control">
                            <option value="<?php echo $fetchBookDetails[0]['book_genre'] ?>"><?php echo $fetchBookDetails[0]['book_genre'] ?></option>
                            <option value="Science Fiction">Science Fiction</option>
                            <option value="Romance">Romance</option>
                            <option value="Action Drama">Action Drama</option>
                            <option value="Adventure">Adventure</option>
                        </Select>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <footer>
        © 2018 BookBorrow.com
    </footer>
</div>
</body>
</html>

