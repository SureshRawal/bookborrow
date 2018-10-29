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
include "class/learnerDetail.php";
$learnerDetail = new learnerDetail();
?>

<html>
<head>
    <title>BookBorrow.com | Profile</title>
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
                    <li class="dropdown active">
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
            <li class="active">Profile</li>
        </ol>
        <hr/>

        <div class="col-md-8 col-md-offset-2">

            <?php
            if (isset($_POST['save_profile'])){
                $learnerDetail->setAddress($_POST['address']);
                $learnerDetail->setDateOfBirth($_POST['DoB']);
                $learnerDetail->setGender($_POST['gender']);
                $learnerDetail->setMobileNumber($_POST['mobileNumber']);
                $learnerDetail->setEducationLevel($_POST['education']);
                $learnerDetail->setCollege($_POST['college']);
                $learnerDetail->setDetailsOneSelf($_POST['details']);
                $learnerDetail->setFavoriteQuotation($_POST['quotation']);
                $learnerDetail->getLearner()->setLearnerId($_SESSION['id']);

                $learnerDetail->saveProfile();
            }

            $fetchLearnerDetails = array(array(
                "address"=>"",
                "date_of_birth"=>"",
                "gender"=>"",
                "mobile_number"=>"",
                "education_level"=>"",
                "college"=>"",
                "details_oneself"=>"",
                "favorite_quotation"=>"",
                "good_points"=>"",
                "bad_points"=>""
            ));
            $fetchLearnerDetails = $learnerDetail->selectProfile($_SESSION['id']);

            if (isset($_POST['edit_profile'])){
                $learnerDetail->setAddress($_POST['address']);
                $learnerDetail->setDateOfBirth($_POST['DoB']);
                $learnerDetail->setGender($_POST['gender']);
                $learnerDetail->setMobileNumber($_POST['mobileNumber']);
                $learnerDetail->setEducationLevel($_POST['education']);
                $learnerDetail->setCollege($_POST['college']);
                $learnerDetail->setDetailsOneSelf($_POST['details']);
                $learnerDetail->setFavoriteQuotation($_POST['quotation']);
                $learnerDetail->getLearner()->setLearnerId($_SESSION['id']);

                $learnerDetail->editLearnerProfile($_SESSION['id']);
                $fetchLearnerDetails = $learnerDetail->selectProfile($_SESSION['id']);
            }

            ?>


            <?php
            if($learnerDetail->checkLearnerProfile($_SESSION['id']) > 0){
                ?>
                <h2 style="text-align: center;">Your Profile</h2>
                <hr>
                <form method="post">
                <fieldset>
                    <legend style="text-align: center">Overview</legend>
                        <div class="form-inline">
                            <label>Your Good Points : </label>
                            <input name="education" disabled="disabled" type="text" class="form-control" value="<?php echo $fetchLearnerDetails[0]['good_points'] ?>">
                            <label>Your Bad Points : </label>
                            <input name="college" disabled="disabled" type="text" class="form-control" value="<?php echo $fetchLearnerDetails[0]['bad_points'] ?>">
                        </div>
                        <label>Lives in : </label>
                        <input name="address" type="text" class="form-control" value="<?php echo $fetchLearnerDetails[0]['address'] ?>">
                        <label>Date of Birth : </label>
                        <input name="DoB" type="date" class="form-control" value="<?php echo $fetchLearnerDetails[0]['date_of_birth'] ?>">
                        <label>Gender : </label>
                        <select class="form-control" name="gender">
                            <option value="<?php echo $fetchLearnerDetails[0]['gender'] ?>"><?php echo $fetchLearnerDetails[0]['gender'] ?></option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Others">Others</option>
                        </select>
                    <label>Mobile Number : </label>
                    <input name="mobileNumber" type="number" class="form-control" value="<?php echo $fetchLearnerDetails[0]['mobile_number'] ?>">
                    <label>Studies </label>
                    <div class="form-inline">
                        <input name="education" type="text" class="form-control" value="<?php echo $fetchLearnerDetails[0]['education_level'] ?>">
                        <label>At : </label>
                        <input name="college" type="text" class="form-control" value="<?php echo $fetchLearnerDetails[0]['college'] ?>">
                    </div>
                    <label>About me : </label>
                    <textarea name="details" class="form-control"><?php echo $fetchLearnerDetails[0]['details_oneself'] ?></textarea>
                    <label>Favorite Quotation : </label>
                    <textarea name="quotation" class="form-control"><?php echo $fetchLearnerDetails[0]['favorite_quotation'] ?></textarea>
                    <button name="edit_profile" class="btn btn-success" type="submit" style="margin-top: 10px;">Edit Profile</button>
                </fieldset>
                </form>

                <?php
            }else{
                ?>
                <h2 style="text-align: center;">Create Profile</h2>
                <hr>
                <form method="post">
                    <fieldset>
                        <legend style="text-align: center;">Contact and Basic Info</legend>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Address</label>
                                <input name="address" type="text" class="form-control" placeholder="Address" required="required">
                            </div>
                            <div class="form-group">
                                <label>Gender</label>
                                <select class="form-control" name="gender">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Mobile Number</label>
                                <input name="mobileNumber" type="number" class="form-control" placeholder="Mobile Number" required="required">
                            </div>
                            <div class="form-group">
                                <label>Details about yourself</label>
                                <textarea name="details" rows="5" class="form-control" placeholder="Details about yourself...." required="required"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="save_profile" value="Save" class="btn btn-success">
                                <input type="reset" value="Reset" class="btn btn-warning">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="form-group">
                                    <label>Date of Birth</label>
                                    <input name="DoB" type="date" class="form-control" required="required">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>College</label>
                                <input name="college" type="text" class="form-control" placeholder="College" required="required">
                            </div>
                            <div class="form-group">
                                <label>Education Level</label>
                                <input name="education" type="text" class="form-control" placeholder="Education Level" required="required">
                            </div>
                            <div class="form-group">
                                <label>Favorite Quotation</label>
                                <textarea name="quotation" rows="5" class="form-control" placeholder="Favorite Quotation" required="required"></textarea>
                            </div>
                        </div>
                    </fieldset>
                </form>

            <?php
            }
            ?>


        </div>

        <hr/>

    </div>




    <footer>
        © 2018 BookBorrow.com
    </footer>

</div>
</body>
</html>