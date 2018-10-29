<?php
session_start();
$learnerId = $_SESSION['id'];
include "class/database.php";
$database = new database();
include "class/borrow.php";
$borrow = new borrow();
if(isset($_GET['return']) && isset($_GET['borrowId']) ){
    if($_GET['return']=="Good"){
        $database->update($borrow->increaseGoodPoints($learnerId));
        $database->update($borrow->setBorrowerPoints($_GET['borrowId'],$_GET['return']));
    }else{
        $database->update($borrow->increaseBadPoints($learnerId));
        $database->update($borrow->setBorrowerPoints($_GET['borrowId'],$_GET['return']));
    }
    $database->update($borrow->returnBookBorrow($_GET["borrowId"]));
    header("location:borrow_books.php");
}