<?php
include "class/giveaway.php";
$giveaway = new giveaway();
$giveaway->deleteGiveaway($_GET['giveaway_id']);
header("location:giveaway.php");