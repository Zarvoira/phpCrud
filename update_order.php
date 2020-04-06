
<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';


// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {


$id =$_GET['id'] ;
$prod = filter_var(($_POST['prod']), FILTER_SANITIZE_NUMBER_INT);
$name = filter_var(($_POST['name']), FILTER_SANITIZE_STRING);
$shipped = filter_var(($_POST['shipped']), FILTER_SANITIZE_NUMBER_INT);
$date = filter_var(($_POST['date']), FILTER_SANITIZE_STRING);
    

/* Perform Query */

$query = "UPDATE Orders SET Prod_ID=:prod, Customer_Name=:name, Number_Shipped=:shipped, Order_Date=:date WHERE Order_ID = :id";

$stmt = $pdo->prepare($query);
$stmt->bindParam(":prod", $prod, PDO::PARAM_INT);
$stmt->bindParam(":name", $name, PDO::PARAM_STR);
$stmt->bindParam(":shipped", $shipped, PDO::PARAM_INT);
$stmt->bindParam(":date", $date, PDO::PARAM_STR);
$stmt->bindParam(":id", $id, PDO::PARAM_INT);
$stmt->execute();


$msg='success';
$stmt->execute();

$msg = 'updated successfully';
    }




// Get the contact from the contacts table
    
    $stmt = $pdo->prepare('SELECT * FROM orders WHERE Order_ID = ?');
    $stmt->execute([$_GET['id']]);
    $orders = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$orders) {
        exit('Contact doesn\'t exist with that ID!');
    }
    
} else {
    exit('No ID specified!');
}



?>



<?php include('header.php');?>


<div class="content update">
    <h2>Create Product</h2>
        <form action="update_order.php?id=<?=$orders['Order_ID']?>" method="post">
        <label for="id">Order_ID</label>
  <input type="text" name="id" value="<?=$orders['Order_ID']?>" id="id" >
    <label for="id">prod_ID</label>
  <input type="text" name="prod" value="<?=$orders['Prod_ID']?>" id="prod" >
        <label for="name">Customer Name</label>
        <input type="text" name="name" value="<?=$orders['Customer_Name']?>" id="name" >
        <label for="Shipped">Shipped</label>
        <input type="number" name="shipped" value="<?=$orders['Number_Shipped']?>" id="shipped" >
        <label for="created">Date</label>
        <input type="date" name="date" value="<?=$orders['Order_Date']?>" id="date" >

        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?php include('footer.php');?>
