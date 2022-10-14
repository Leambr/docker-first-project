<?php
require('../includes/pdo.php');

$id = filter_input(INPUT_GET, 'id');
$delete = $pdo->prepare("DELETE FROM posts WHERE id = '$id'");
$delete->execute();

header('Location: ../pages/home.php');
