<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {

$id=$_GET['id'];
$name = filter_var(($_POST['name']), FILTER_SANITIZE_STRING);
$start = filter_var(($_POST['start']), FILTER_SANITIZE_NUMBER_INT);
$shipped = filter_var(($_POST['shipped']), FILTER_SANITIZE_NUMBER_INT);
$hand = filter_var(($_POST['hand']), FILTER_SANITIZE_NUMBER_INT);
$received = filter_var(($_POST['received']), FILTER_SANITIZE_NUMBER_INT);
$min = filter_var(($_POST['min']), FILTER_SANITIZE_STRING);



/* Perform Query */
$query = "UPDATE products SET  Product_Name = :name, Starting_Inventory = :start, Inventory_Received = :received, Inventory_Shipped = :shipped, Inventory_OnHand = :hand ,Minimum_Req =:min WHERE Prod_ID = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":name", $name, PDO::PARAM_STR);
$stmt->bindParam(":start", $start, PDO::PARAM_INT);
$stmt->bindParam(":received", $received, PDO::PARAM_INT);
$stmt->bindParam(":shipped", $shipped, PDO::PARAM_INT);
$stmt->bindParam(":hand", $hand, PDO::PARAM_STR);
$stmt->bindParam(":min", $min, PDO::PARAM_INT);
$stmt->bindParam(":id", $id, PDO::PARAM_INT);


$stmt->execute();

$msg = 'updated successfully';


      
    }
    
    
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM products WHERE Prod_ID = ?');
    $stmt->execute([$_GET['id']]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$product) {
        exit('Contact doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>


<?php include('header.php');?>
<div class="content update">
	<h2>Update Product #<?=$product['Prod_ID']?></h2>
    <form action="update.php?id=<?=$product['Prod_ID']?>" method="post">
         <label for="id">Name</label>
        <label for="name">Start</label>
        <input type="text" name="name" placeholder="26" value="<?=$product['Product_Name']?>" id="name" >
        <input type="number" name="start" placeholder="John Doe"value="<?=$product['Starting_Inventory']?>"  id="start" type="number">
        <label for="shipped">Shipped</label>
        <label for="hand">Hand</label>
        <input type="number" name="shipped" placeholder="johndoe@example.com" value="<?=$product['Inventory_Shipped']?>" id="shipped" type="number">
        <input type="number" name="hand" placeholder="2025550143" value="<?=$product['Inventory_OnHand']?>"id="hand" type="number">
        <label for="title">received</label>
        <label for="created">min</label>
        <input type="number" name="received" placeholder="Employee" value="<?=$product['Inventory_Received']?>" id="received" type="number">
        <input type="number" name="min" placeholder="2025550143" value="<?=$product['Minimum_Req']?>" id="min" type="number">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?php include('footer.php');?>
