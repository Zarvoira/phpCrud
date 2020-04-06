<?php
include 'functions.php';
$pdo = pdo_connect_mysql();

$id = $_GET['id'];

$query = 'DELETE FROM purchases WHERE Purchase_id=:id';

$statement = $pdo->prepare($query);
if ($statement->execute([':id' => $id])) {
  header("Location: /PhpProject2/purchase.php");
}
