<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";

$title = $_POST['title'];
$descr = $_POST['description'];
$visibility = $_POST['visibility'];
$lat = $_POST['lat'];
$long = $_POST['long'];

Event::constructEvent($_POST);

 ?>
