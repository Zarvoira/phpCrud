<?php

include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank

    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables


    
    $id = isset($_POST['Prod_ID']) ? $_POST['Prod_ID'] : '';
    $sup = isset($_POST['Supplier_ID']) ? $_POST['start'] : '';
    $received = isset($_POST['Number_Received']) ? $_POST['received'] : '';
    $date = isset($_POST['Purchase_Date']) ? $_POST['date'] : '';

    // Insert new record into the contacts table
    $stmt = $pdo->prepare('    INSERT INTO `purchases` (`Purchase_id`, `Prod_ID`, `Supplier_ID`, `Number_Received`, `Purchase_Date`) VALUES (NULL, '?', '?', '?', '?')
');
    $stmt->execute([$name, $start, $received, $shipped, $hand,$min]);
    // Output message
    $msg = 'Created Successfully!';

    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

}
?>
<?=template_header('Create')?>



<div class="content update">
	<h2>Create Product</h2>
    <form action="create.php" method="post">
        <label for="id">prod_ID</label>

         <?php foreach ($products as $product): ?>
        
                <td><?=$product['Prod_ID']?></td>
                <td><?=$product['Product_Name']?></td>
               
                    
         
            <?php endforeach; ?>

         <label for="name">Start</label>
        <input type="number" name="start" id="start">
        <label for="Shipped">Shipped</label>
        <input type="number" name="shipped"  id="shipped">
        <label for="created">Minimum</label>
        <input type="date" name="date"  id="date">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>