<?php

include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank

    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables

    $name = filter_var(($_POST['name']), FILTER_SANITIZE_STRING);
    $start = filter_var(($_POST['start']), FILTER_SANITIZE_NUMBER_INT);
$shipped = filter_var(($_POST['shipped']), FILTER_SANITIZE_NUMBER_INT);
$hand = filter_var(($_POST['hand']), FILTER_SANITIZE_NUMBER_INT);
$received = filter_var(($_POST['received']), FILTER_SANITIZE_NUMBER_INT);
$min = filter_var(($_POST['min']), FILTER_SANITIZE_STRING);



/* Perform Query */
$query = "INSERT INTO products (Prod_ID, Product_Name, Starting_Inventory, Inventory_Received, Inventory_Shipped, Inventory_OnHand, Minimum_Req) VALUES (NULL, :name, :start, :received, :shipped, :hand, :min)";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":name", $name, PDO::PARAM_STR);
$stmt->bindParam(":start", $start, PDO::PARAM_INT);
$stmt->bindParam(":received", $received, PDO::PARAM_INT);
$stmt->bindParam(":shipped", $shipped, PDO::PARAM_INT);
$stmt->bindParam(":hand", $hand, PDO::PARAM_STR);
$stmt->bindParam(":min", $min, PDO::PARAM_INT);

$stmt->execute();
    

    // Output message
    $msg = 'Created Successfully!';
}
?>
<?php include('header.php');?>



<div class="content update">
	<h2>Create Product</h2>
    <form action="create.php" method="post">
        <label for="id">Product</label>
        <input type="text" name="name" required="required"  id="name">
         <label for="name">Start</label>
        <input type="number" name="start"required="required" id="start">
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

<?php include('footer.php');?>
