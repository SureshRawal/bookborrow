<?php
include "class/giveaway.php";
$giveaway = new giveaway();
include "class/selectFunction.php";
$selectFunction = new selectFunction();
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
            <li class="active">Giveaway</li>
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
                        <h3 class="panel-title">Giveaway</h3>
                    </div>
                    <div class="panel-body">
                        <br>

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                            Add Giveaway
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Giveaway</h4>
                                    </div>
                                    <?php
                                    if (isset($_POST['save_changes'])){

                                        $book_imageName = $_FILES['book_image']['name'];
                                        $book_image_type =pathinfo($book_imageName,PATHINFO_EXTENSION);

                                        $giveaway->setBookName($_POST['book_name']);
                                        $giveaway->setAuthor($_POST['author']);
                                        $giveaway->setISBN($_POST['ISBN']);
                                        $giveaway->setPublicationDate($_POST['publication_date']);
                                        $giveaway->setPublisher($_POST['publisher']);
                                        $giveaway->setBookDescription($_POST['book_description']);
                                        $giveaway->setbookImage($book_imageName);
                                        $giveaway->setBookGenre($_POST['book_genre']);
                                        $giveaway->setPoints($_POST['points']);

                                        if($book_image_type=="jpg" || $book_image_type=="png" || $book_image_type=="JPG" || $book_image_type=="PNG"){
                                            move_uploaded_file($_FILES['book_image']['tmp_name'],'assets/images/'.$book_imageName);
                                        $giveaway->addGiveaway();
                                        }else{
                                            echo "UnSupported File!";
                                        }
                                    }
                                    ?>
                                    <form method="post" enctype="multipart/form-data">
                                    <div class="modal-body">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Book Name</label>
                                                        <input type="text" class="form-control" placeholder="Book Name" required="required" name="book_name">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Author</label>
                                                        <input type="text" class="form-control" placeholder="Author" required="required" name="author">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>ISBN</label>
                                                        <input type="text" class="form-control" placeholder="ISBN" required="required" name="ISBN">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Publication Date</label>
                                                        <input type="date" class="form-control" required="required" name="publication_date">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Publisher</label>
                                                        <input type="text" class="form-control" placeholder="Publisher" required="required" name="publisher">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Book Image</label>
                                                        <input type="file" class="form-control" required="required" name="book_image">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Select Genre</label>
                                                        <Select class="form-control" name="book_genre" required="required">
                                                            <option value="Science Fiction">Science Fiction</option>
                                                            <option value="Romance">Romance</option>
                                                            <option value="Action Drama">Action Drama</option>
                                                            <option value="Adventure">Adventure</option>
                                                        </Select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Points</label>
                                                        <input type="number" class="form-control" placeholder="Points" required="required" name="points">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Description</label>
                                                        <textarea class="form-control" placeholder="Description" required="required" name="book_description"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" name="save_changes" class="btn btn-primary">Save changes</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>S.N.</th>
                                <th>Image</th>
                                <th>Book</th>
                                <th>Details</th>
                                <th>Description</th>
                                <th>Upload Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $delete_message = "'Are you sure to delete this book?'";
                            if(!$giveaway->selectGiveaway()){
                                echo '<div class="alert alert-danger">0 Giveaway added till now</div>';
                            }else {
                                $fetchGiveaway = $giveaway->selectGiveaway();
                                foreach ($fetchGiveaway as $fetchGiveawayRow) {
                                    echo '<tr>';
                                    echo '<td>'.$fetchGiveawayRow["giveaway_id"].'</td>';
                                    echo' <td><img style="max-width: 100px;max-height: 100px;" src="assets/images/'.$fetchGiveawayRow["book_image"].'"></td>';
                                    echo '<td>'.$fetchGiveawayRow["book_name"].'</td>';
                                    echo'<td style="width: 200px;">
                                        <strong>Author : </strong>'.$fetchGiveawayRow["author"].'<br/>
                                        <strong>ISBN : </strong>'.$fetchGiveawayRow["ISBN"].'<br/>
                                        <strong>Publication Date : </strong>'.$fetchGiveawayRow["publication_date"].'<br/>
                                        <strong>Publisher : </strong>'.$fetchGiveawayRow["publisher"].'<br/>
                                        <strong>Genre : </strong>'.$fetchGiveawayRow["book_genre"].'<br/>
                                        <strong>Carousel Index : </strong>'.$fetchGiveawayRow["carousel_index"].'<br/>
                                        <strong>Points : </strong>'.$fetchGiveawayRow["points"].'<br/>
                                        </td>';
                                    echo '<td>'.$fetchGiveawayRow["book_description"].'</td>';
                                    echo '<td style="width: 95px;">'.$fetchGiveawayRow["created_date"].'</td>';
                                    if($fetchGiveawayRow["carousel_index"]==1){
                                        echo '<td>No Action</td>';
                                    }else{
                                        echo '<td style="width: 90px;">
                                                <a href="edit_giveaway.php?giveaway_id='.$fetchGiveawayRow["giveaway_id"].'" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-edit"></span></a>
                                                <a onclick ="return confirm('.$delete_message.')"  href="delete_giveaway.php?giveaway_id='.$fetchGiveawayRow["giveaway_id"].'"  class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></a>
                                            </td>';
                                    }
                                    echo '</tr>';
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




