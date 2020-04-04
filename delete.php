<?php
include 'functions.php';
$pdo = pdo_connect_mysql();

$id = $_GET['id'];

$query = 'DELETE FROM products WHERE Prod_ID=:id';

$statement = $pdo->prepare($query);
if ($statement->execute([':id' => $id])) {
  header("Location: /PhpProject2/read.php");
}
