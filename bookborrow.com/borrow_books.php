<?php
session_start();
include "class/book.php";
$book = new book();
include "class/borrow.php";
$borrow = new borrow();
if(isset($_SESSION['id'])){
    $id=$_SESSION['id'];
    if($id=="admin"){
        header('location:admin.php');
    }
}else{
    header('location:index.php');
}
?>

<html>
<head>
    <title>BookBorrow.com | Borrow</title>
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

    <div class="content content-padding">
        <ol class="breadcrumb">
            <li><a href="dashboard.php">Home</a></li>
            <li class="active">Borrow Books</li>
        </ol>
        <hr/>

        <div class="col-md-12">
            <h2 style="text-align: center;">Your Borrow List</h2>
            <?php
            $today  = date('Y-m-d');
            echo '<h5 style="text-align: center;">Today : '.$today.'</h5>';
            ?>
            <hr>
            <table class="table table-bordered" style="font-size: small;">
                <thead>
                <tr>
                    <th>S.N.</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Borrow Days</th>
                    <th>Max Borrow Days</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $delete_message = "'Are you sure to return this book?'";
                if(!$book->getLearner()->getDatabase()->select($borrow->getLearnerBorrowBooks($_SESSION['id']))){
                    echo '<div class="alert alert-danger">0 Book borrowed till now</div>';
                }else{
                    $fetchBorrowedBooks= $book->getLearner()->getDatabase()->select($borrow->getLearnerBorrowBooks($_SESSION['id']));
                    foreach ($fetchBorrowedBooks as $fetchBorrowedBookRow){
                        echo '<tr>';
                        echo '<td>'.$fetchBorrowedBookRow["borrow_id"].'</td>';
                        echo' <td><img style="max-width: 100px;max-height: 100px;" src="assets/images/'.$fetchBorrowedBookRow["book_image"].'"></td>';
                        echo '<td>'.$fetchBorrowedBookRow["book_name"].'</td>';
                        $remainingDaysDiff = abs(strtotime($fetchBorrowedBookRow['borrow_end_date']) - strtotime($date = date('Y/m/d')));
                        $remainingDaysYears = floor($remainingDaysDiff / (365*60*60*24));
                        $remainingDaysMonths = floor(($remainingDaysDiff - $remainingDaysYears * 365*60*60*24) / (30*60*60*24));
                        $remainingDays = floor(($remainingDaysDiff - $remainingDaysYears - $remainingDaysMonths)/ (60*60*24));
                        if($fetchBorrowedBookRow["status"]){
                            if($today <= $fetchBorrowedBookRow["borrow_end_date"]){
                                echo '<td>
                                  <strong>Start Date : </strong>'.$fetchBorrowedBookRow["borrow_start_date"].'<br/>
                                  <strong>End Date : </strong>'.$fetchBorrowedBookRow["borrow_end_date"].'<br/>
                                  <strong>Remaining Days : </strong>'.$remainingDays.'<br/>                                  
                                </td>';
                            }else{
                                echo '<td>
                                  <strong>Start Date : </strong>'.$fetchBorrowedBookRow["borrow_start_date"].'<br/>
                                  <strong>End Date : </strong>'.$fetchBorrowedBookRow["borrow_end_date"].'<br/>
                                </td>';
                            }
                        }else{
                                echo '<td>
                                  <strong>Start Date : </strong>'.$fetchBorrowedBookRow["borrow_start_date"].'<br/>
                                  <strong>End Date : </strong>'.$fetchBorrowedBookRow["borrow_end_date"].'<br/>
                                </td>';
                        }
                        echo '<td>'.$fetchBorrowedBookRow["borrow_days"].'</td>';
                        echo '<td>'.$fetchBorrowedBookRow["max_borrow"].'</td>';
                        $diff = abs(strtotime($date = date('Y/m/d')) - strtotime($fetchBorrowedBookRow['borrow_end_date']));
                        $years = floor($diff / (365*60*60*24));
                        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                        $days = floor(($diff - $years - $months)/ (60*60*24));
                        if(!$fetchBorrowedBookRow["status"]){
                            if($fetchBorrowedBookRow["borrower_points"]=="Good"){
                                echo '<td style="width: 180px;">
                                        <span style="margin-left: 10px;" class="label label-success">Already Returned with '.$fetchBorrowedBookRow["borrower_points"].' points</span><br/>
                                   </td>';
                            }else{
                                echo '<td style="width: 180px;">
                                        <span style="margin-left: 10px;" class="label label-danger">Already Returned with '.$fetchBorrowedBookRow["borrower_points"].' points</span><br/>
                                   </td>';
                            }

                            echo '<td>
                                    <button disabled="disabled" class="btn btn-info">Return</button>
                                </td>';
                        }else{
                            if($today > $fetchBorrowedBookRow["borrow_end_date"]){
                                echo '<td style="width: 180px;">
                                    <span style="margin-left: 40px;" class="label label-warning">Not Returned</span><br/>
                                    <h6>You are '.$days.' days delay to return this book</h6>
                                    <h6>Please return the book in time</h6>
                                    </td>';
                                echo '<td><a href="return.php?return=Bad&&borrowId='.$fetchBorrowedBookRow["borrow_id"].'" class="btn btn-info">Return</a></td>';
                            }else{
                                echo '<td style="width: 180px;">
                                    <span style="margin-left: 40px;" class="label label-warning">Not Returned</span><br/>
                                    <h6>Please return the book in time</h6>
                                    </td>';
                                echo '<td><a onclick ="return confirm('.$delete_message.')" href="return.php?return=Good&&borrowId='.$fetchBorrowedBookRow["borrow_id"].'" class="btn btn-info">Return</a></td>';
                            }
                        }

                        echo '</tr>';
                    }
                }
                ?>
                </tbody>
            </table>
        </div>

    </div>



    <footer>
        © 2018 BookBorrow.com
    </footer>

</div>
</body>
</html>