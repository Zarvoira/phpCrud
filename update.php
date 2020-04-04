<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
      
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $start = isset($_POST['start']) ? $_POST['start'] : '';
    $shipped = isset($_POST['shipped']) ? $_POST['shipped'] : '';
    $hand = isset($_POST['hand']) ? $_POST['hand'] : '';
    $received = isset($_POST['received']) ? $_POST['received'] : '';
    $min = isset($_POST['min']) ? $_POST['min'] : '';

        // Update the record
        $stmt = $pdo->prepare('UPDATE products SET  Product_Name = ?, Starting_Inventory = ?, Inventory_Received = ?, Inventory_Shipped = ?, Inventory_OnHand = ? ,Minimum_Req =? WHERE Prod_ID = ?');
        $stmt->execute([$name, $start, $received, $shipped, $hand,$min, $_GET['id']]);
        $msg = 'Updated Successfully!';
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


<?=template_header('Read')?>

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
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
