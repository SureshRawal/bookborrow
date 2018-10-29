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
$fetchDiscussion = array(array(
    "discussion"=>""
));
$fetchDiscussion = $discussion->selectDiscussionById($_GET['discussion_id']);
$fetchReplierName = array(array(
    "name"=>""
));
$discussion->increaseVisit($_GET['discussion_id']);
?>

<!DOCTYPE html>
<html lang="en">
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
            <li><a href="discussion.php">Discussion</a></li>
            <li class="active">Discussion Reply</li>
        </ol>
        <hr/>

        <div class="col-md-10 col-md-offset-1">
            <h2 style="text-align: center;">Discussion Reply</h2>
            <hr/>
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-1 col-lg-offset-1">
                            <h3>Reply: </h3>
                        </div>
                        <div class="col-lg-9">
                            <?php
                            if (isset($_POST['answer'])){
                                $discussion->setLearnerId($_SESSION['id']);
                                $discussion->setDiscussionId($_GET['discussion_id']);
                                $discussion->setReply($_POST['text_answer']);

                                $discussion->discussionReply();
                            }
                            ?>
                            <form style="margin-top: 15px;margin-left: 15px;margin-bottom: 15px;" method="post">
                                <div class="form-group">
                                    <input class="form-control" type="text" readonly="readonly"
                                           value="<?php
                                           echo $fetchDiscussion[0]['discussion'];
                                           ?>"
                                    >
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" name="text_answer"></textarea>
                                </div>
                                <button type="submit" class="btn btn-success" name="answer">Answer</button>
                                <button type="reset" class="btn btn-danger">Cancel</button>
                            </form>
                            <hr/>
                            <?php
                            if(!$discussion->selectDiscussionReplyById($_GET['discussion_id'])){
                                echo '<div class="alert alert-danger">0 Answer</div>';
                            }else{
                                $fetchDiscussionReply= $discussion->selectDiscussionReplyById($_GET['discussion_id']);
                                foreach($fetchDiscussionReply as $fetchDiscussionReplyRow){
                                    $fetchReplierName = $discussion->getLearner()->selectLearnerByID($fetchDiscussionReplyRow['replier_id']);
                                    echo '<div style="margin-top: 15px;margin-left: 15px;" class="panel panel-default">';
                                    echo '<div class="panel-body">';
                                    echo $fetchDiscussionReplyRow['reply']."<br>";
                                    echo $fetchDiscussionReplyRow['reply_date']."<br>";
                                    echo "<strong><span class='glyphicon glyphicon-user'></span>: </strong> ".$fetchReplierName[0]['name'];
                                    echo "</div>";
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