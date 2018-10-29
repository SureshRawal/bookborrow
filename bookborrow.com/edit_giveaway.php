<?php
session_start();
if(isset($_SESSION['id'])){
    $id=$_SESSION['id'];
    if($id!="admin"){
        header('location:dashboard.php');
    }
}else{
    header('location:index.php');
}
include "class/giveaway.php";
$giveaway = new giveaway();
include "class/selectFunction.php";
$selectFunction = new selectFunction();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Area | Dashboard</title>
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
                <li class="active"><a href="giveaway.php">Giveaway</a></li>
                <li><a href="view_book.php">Books</a></li>
                <li><a href="users.php">Users</a></li>
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
                <h1><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Books </h1>
            </div>
        </div>
    </div>
</header>

<section id="breadcrumb">
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="admin.php">Dashboard</a></li>
            <li><a href="giveaway.php">Giveaway</a></li>
            <li class="active">Edit Giveaway</li>
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
                            <?php echo $giveaway->getDatabase()->checkRows($selectFunction->countBorrow()); ?>
                        </span></a>
                    <a href="giveaway.php" class="list-group-item active main-color-bg"><span class="glyphicon glyphicon-gift" aria-hidden="true"></span> Giveaway <span class="badge">
                            <?php echo $giveaway->getDatabase()->checkRows($selectFunction->countGiveaway()); ?>
                        </span></a>
                    <a href="view_book.php" class="list-group-item"><span class="glyphicon glyphicon-book" aria-hidden="true"></span> Books <span class="badge">
                            <?php echo $giveaway->getDatabase()->checkRows($selectFunction->countBooks()); ?>
                        </span></a>
                    <a href="users.php" class="list-group-item"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Users <span class="badge">
                            <?php echo $giveaway->getDatabase()->checkRows($selectFunction->countLearners()); ?>
                    </span></a>
                </div>

            </div>
            <div class="col-md-9">
                <!-- Website Overview -->
                <div class="panel panel-default panel-min-height">
                    <div class="panel-heading main-color-bg">
                        <h3 class="panel-title">Edit Giveaway</h3>
                    </div>
                    <div class="panel-body">
                        <br>
                        <?php
                        if (isset($_POST['edit_btn'])){

                            $giveaway->setBookName($_POST['book_name']);
                            $giveaway->setAuthor($_POST['author']);
                            $giveaway->setISBN($_POST['ISBN']);
                            $giveaway->setPublicationDate($_POST['publication_date']);
                            $giveaway->setPublisher($_POST['publisher']);
                            $giveaway->setBookDescription($_POST['book_description']);
                            $giveaway->setBookGenre($_POST['book_genre']);
                            $giveaway->setPoints($_POST['points']);
                            $giveaway->setCarouselIndex($_POST['carousel_index']);

                            $giveaway->editGiveaway($_GET['giveaway_id']);
                            echo '<div class="alert alert-success" role="alert">';
                            echo 'Successfully Updated';
                            echo '</div>';
                        }
                        $fetchGiveaway = array(array(
                            "book_name"=>"",
                            "author"=>"",
                            "ISBN"=>"",
                            "publication_date"=>"",
                            "publisher"=>"",
                            "book_description"=>"",
                            "book_genre"=>"",
                            "carousel_index"=>"",
                            "points"=>""
                        ));
                        $fetchGiveaway = $giveaway->selectGiveawayById($_GET['giveaway_id']);
                        ?>
                        <form method="post">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Book Name</label>
                                            <input type="text" class="form-control" placeholder="Book Name" required="required" name="book_name" value="<?php echo $fetchGiveaway[0]["book_name"]  ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Author</label>
                                            <input type="text" class="form-control" placeholder="Author" required="required" name="author" value="<?php echo $fetchGiveaway[0]["author"]  ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>ISBN</label>
                                            <input type="text" class="form-control" placeholder="ISBN" required="required" name="ISBN" value="<?php echo $fetchGiveaway[0]["ISBN"]  ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Publication Date</label>
                                            <input type="date" class="form-control" required="required" name="publication_date" value="<?php echo $fetchGiveaway[0]["publication_date"]  ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Publisher</label>
                                            <input type="text" class="form-control" placeholder="Publisher" required="required" name="publisher" value="<?php echo $fetchGiveaway[0]["publisher"]  ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Points</label>
                                            <input type="number" class="form-control" placeholder="Points" required="required" name="points" value="<?php echo $fetchGiveaway[0]["points"]  ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea class="form-control" placeholder="Description" rows="5" required="required" name="book_description"><?php echo $fetchGiveaway[0]["book_description"]  ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Select Genre</label>
                                            <Select class="form-control" name="book_genre" required="required">
                                                <option value="<?php echo $fetchGiveaway[0]["book_name"]  ?>"><?php echo $fetchGiveaway[0]["book_genre"]  ?></option>
                                                <option value="Science Fiction">Science Fiction</option>
                                                <option value="Romance">Romance</option>
                                                <option value="Action Drama">Action Drama</option>
                                                <option value="Adventure">Adventure</option>
                                            </Select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="edit_btn" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>

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




