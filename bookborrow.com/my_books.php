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
            <li class="active">My Books</li>
        </ol>
        <hr/>

        <div class="col-lg-12">
            <h2 style="text-align: center;">My Books</h2>
            <a style="margin-bottom: 10px;" class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                Add Book
            </a>
            <div class="collapse" id="collapseExample">
                <div class="well">
                    <?php
                    if (isset($_POST['addBook_btn'])){

                        $book_imageName = $_FILES['book_image']['name'];
                        $book_image_type =pathinfo($book_imageName,PATHINFO_EXTENSION);

                        $book->setBookName($_POST['bookName']);
                        $book->setAuthor($_POST['author']);
                        $book->setISBN($_POST['ISBN']);
                        $book->setPublicationDate($_POST['publicationDate']);
                        $book->setPublisher($_POST['publisher']);
                        $book->setBookDescription($_POST['bookDescription']);
                        $book->setbookImage($book_imageName);
                        $book->setBookGenre($_POST['book_genre']);
                        $book->setLearnerId($_SESSION['id']);
                        $book->setMaxBorrow($_POST['max_borrow']);

                        if($book_image_type=="jpg" || $book_image_type=="png" || $book_image_type=="JPG" || $book_image_type=="PNG"){
                            move_uploaded_file($_FILES['book_image']['tmp_name'],'assets/images/'.$book_imageName);
                            $book->addBook();
                        }else{
                            echo "UnSupported File!";
                        }



                    }
                    ?>

                    <form method="post" enctype="multipart/form-data">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Enter Book Name</label>
                                <input name="bookName"  type="text" placeholder="Book Name" class="form-control" required="required">
                            </div>
                            <div class="form-group">
                                <label>Enter ISBN</label>
                                <input name="ISBN" type="text" placeholder="ISBN" class="form-control" required="required">
                            </div>
                            <div class="form-group">
                                <label>Enter Publisher</label>
                                <input name="publisher" type="text" placeholder="Publisher" class="form-control" required="required">
                            </div>
                            <div class="form-group">
                                <label>Enter Maximum Borrow Days for this book</label>
                                <input type="number" name="max_borrow" placeholder="Maximum Borrow Days" class="form-control" required="required">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Enter Author Name</label>
                                <input  name="author" type="text" placeholder="Author Name" class="form-control" required="required">
                            </div>
                            <div class="form-group">
                                <label>Enter Publication Date</label>
                                <input name="publicationDate" type="date" class="form-control" required="required">
                            </div>
                            <div class="form-group">
                                <label>Select Genre</label>
                                <Select class="form-control" name="book_genre" required="required">
                                    <option value="Science Fiction">Science Fiction</option>
                                    <option value="Romance">Romance</option>
                                    <option value="Action Drama">Action Drama</option>
                                    <option value="Adventure">Adventure</option>
                                </Select>
                            </div>
                            <div class="form-group">
                                <label>Select Picture</label>
                                <input name="book_image" type="file" class="form-control" required="required">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label>Enter Book Description</label>
                            <textarea name="bookDescription" placeholder="Book Description..." rows="8"  required="required" class="form-control"></textarea>
                        </div>
                        <div class="row">
                            <button name="addBook_btn" type="submit" class="btn btn-success" style="margin-left: 30px;margin-top: 10px;">Add Book</button>
                            <button class="btn btn-danger" type="button" data-toggle="collapse" style="margin-top: 10px;" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                Close
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <hr/>

        <div class="col-lg-12">
            <h3>Book List</h3>
            <table class="table table-bordered" style="font-size: small;">
                <thead>
                <tr>
                    <th>S.N.</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Details</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $delete_message = "'Are you sure to delete?'";
                if(!$book->selectBookLearnerName($_SESSION['id'])){
                    echo '<div class="alert alert-danger">0 Book added till now</div>';
                }else{
                    $fetchBooks= $book->selectBookLearnerName($_SESSION['id']);
                    foreach($fetchBooks as $fetchBooksRow){
                        echo' <tr>';
                        echo' <td>'.$fetchBooksRow["book_id"].'</td>';
                        echo' <td><img style="max-width: 100px;max-height: 100px;" src="assets/images/'.$fetchBooksRow["book_image"].'"></td>';
                        echo'<td style="width: 120px;">'.$fetchBooksRow["book_name"].'</td>';
                        echo'<td style="width: 200px;">
                                <strong>Author : </strong>'.$fetchBooksRow["author"].'<br/>
                                <strong>ISBN : </strong>'.$fetchBooksRow["ISBN"].'<br/>
                                <strong>Publication Date : </strong>'.$fetchBooksRow["publication_date"].'<br/>
                                <strong>Publisher : </strong>'.$fetchBooksRow["publisher"].'<br/>
                                <strong>Genre : </strong>'.$fetchBooksRow["book_genre"].'<br/>
                                <strong>Max Borrow : </strong>'.$fetchBooksRow["max_borrow"].'<br/>
                                <strong>Rating : </strong>'.$fetchBooksRow["rating"].'<br/>                                
                                </td>';
                        echo' <td>'.$fetchBooksRow["book_description"].'</td>';
                        echo' <td style="width: 85px;">'.$fetchBooksRow["created_date"].'</td>';
                        echo'<td style="width: 90px;">
                            <a href="edit_book.php?book_id='.$fetchBooksRow["book_id"].'" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-edit"></span></a>
                            <a onclick ="return confirm('.$delete_message.')" href="delete_book.php?book_id='.$fetchBooksRow["book_id"].'" class="btn btn-danger btn-sm" title="Delete">
                                <span class="glyphicon glyphicon-trash"></span>
                            </a>                            
                            </td>';
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