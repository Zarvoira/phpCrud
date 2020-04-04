<?php

include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank

    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $start = isset($_POST['start']) ? $_POST['start'] : '';
    $shipped = isset($_POST['shipped']) ? $_POST['shipped'] : '';
    $hand = isset($_POST['hand']) ? $_POST['hand'] : '';
    $received = isset($_POST['received']) ? $_POST['received'] : '';
    $min = isset($_POST['min']) ? $_POST['min'] : '';

    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO `products` (`Prod_ID`, `Product_Name`, `Starting_Inventory`, `Inventory_Received`, `Inventory_Shipped`, `Inventory_OnHand`, `Minimum_Req`)'
            . 'VALUES (NULL, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$name, $start, $received, $shipped, $hand,$min]);
    // Output message
    $msg = 'Created Successfully!';
}
?>
<?=template_header('Create')?>



<div class="content update">
	<h2>Create Product</h2>
    <form action="create.php" method="post">
        <label for="id">Product</label>
        <input type="text" name="name"  id="name">
         <label for="name">Start</label>
        <input type="number" name="start" id="start">
        <label for="Shipped">Shipped</label>
        <input type="number" name="shipped"  id="shipped">
        <label for="phone">On-Hand</label>
        <input type="number" name="hand"  id="hand">
        <label for="title">Received</label>
        <input type="number" name="received"  id="received">
        <label for="created">Minimum</label>
        <input type="number" name="min"  id="min">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>