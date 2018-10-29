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
include "class/discussion.php";
$discussion = new discussion();
$fetchLearnerName = array(array(
   "name"=>""
));
?>

<html>
<head>
    <title>BookBorrow.com | Discussion</title>
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
                        <li class="active"><a href="discussion.php">Discussion</a></li>
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
        <div class="content content-padding">
            <ol class="breadcrumb">
                <li><a href="dashboard.php">Home</a></li>
                <li class="active">Discussion</li>
            </ol>

            <hr/>

            <div class="col-md-10 col-md-offset-1">
                <h2 style="text-align: center;">Discussion</h2>

                <!--Ask Question-->
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#myModal">
                    Ask Questions
                </button>

                <!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Ask Questions</h4>
                            </div>
                            <?php
                            if (isset($_POST['post'])){
                                $discussion->setDiscussion($_POST['question']);
                                $discussion->setLearnerId($_SESSION['id']);
                                $discussion->postDiscussion();
                            }
                            ?>
                            <form method="post">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Your Question:</label>
                                        <input type="text" class="form-control" name="question" placeholder="Your Question" required="required">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" name="post" class="btn btn-primary">Post Question</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                <!--Ask Question-->

                <!--View Questions-->
                <div class="row">
                    <div class="col-lg-12">
                        <h3>Questions</h3>
                        <hr>
                        <div class="row">
                            <div class="col-lg-1"></div>
                            <div class="col-lg-10">
                                <?php
                                if(!$discussion->selectDiscussion()){
                                    echo '<div class="alert alert-danger">0 question added till now</div>';
                                }else{
                                    $fetchDiscussion= $discussion->selectDiscussion();
                                    foreach($fetchDiscussion as $fetchDiscussionRow){
                                        $fetchLearnerName = $discussion->getLearner()->selectLearnerByID($fetchDiscussionRow['learner_id']);
                                        echo "<div class='list-group'>";
                                        echo "<a href='answer.php?discussion_id=$fetchDiscussionRow[discussion_id]' class='list-group-item'>";
                                        echo "<h4 class='list-group-item-heading'><strong>Question: </strong>".$fetchDiscussionRow['discussion']."</h4>";
                                        echo "<p class='list-group-item-text pull-right' style='margin-left: 10px;'>
                                    <strong><span class='glyphicon glyphicon-user'></span> : </strong> "
                                            .$fetchLearnerName[0]['name'].
                                            "</p><p class='list-group-item-text pull-right' style='margin-left: 10px;'>
                                    <strong><span class='glyphicon glyphicon-eye-open'></span> : </strong> "
                                            .$fetchDiscussionRow['visited'].
                                            "</p><p class='list-group-item-text pull-right' style='margin-left: 10px;'>
                                    <strong><span class='glyphicon glyphicon-pencil'></span> : </strong> "
                                            .$fetchDiscussionRow['replied'].
                                            "</p>
                            ";
                                        echo "<p class='list-group-item-text'><strong>".$fetchDiscussionRow['post_date']."</strong></p>";
                                        echo "</a>";
                                        echo "</div>";

                                    }
                                }
                                ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <footer>
            © 2018 BookBorrow.com
        </footer>




    </div>
</body>
</html>
