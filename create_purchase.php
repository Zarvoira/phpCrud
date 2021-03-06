<?php

include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

// Prepare the SQL statement and get records from our products table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM products ORDER BY Prod_ID');
$stmt->execute();

// Fetch the records so we can display them in our template.
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare('SELECT * FROM suppliers ORDER BY Supplier_ID');
$stmt->execute();
$suppliers = $stmt->fetchAll(PDO::FETCH_ASSOC);

$id='none';
// Check if POST data is not empty
if (!empty($_POST)) {

$id = filter_var(($_POST['id']), FILTER_SANITIZE_NUMBER_INT);
$supplier = filter_var(($_POST['supplier']), FILTER_SANITIZE_NUMBER_INT);
$shipped = filter_var(($_POST['shipped']), FILTER_SANITIZE_NUMBER_INT);
$date = filter_var(($_POST['date']), FILTER_SANITIZE_STRING);
    

/* Perform Query */
$query = "INSERT INTO purchases (Purchase_id, Prod_ID, Supplier_ID, Number_Received, Purchase_Date) VALUES (NULL, :id, :supplier, :shipped, :date)";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $id, PDO::PARAM_INT);
$stmt->bindParam(":supplier", $supplier, PDO::PARAM_INT);
$stmt->bindParam(":shipped", $shipped, PDO::PARAM_INT);
$stmt->bindParam(":date", $date, PDO::PARAM_STR);
$stmt->execute();

$msg='success';
}
?>
<?php include('header.php');?>


<div class="content update">
	<h2>Create Purchase</h2>
    <form action="create_purchase.php" method="post">
    <label for="id">prod_ID</label>
    <select id="id" name="id">

    <?php foreach ($products as $product): ?>

                   <option value="<?=$product['Prod_ID']?>"><?=$product['Product_Name']?></option>

    <?php endforeach; ?>
</select>

        <label for="Supplier_ID">Supllier_ID</label>
        <select id="supplier" name="supplier">

    <?php foreach ($suppliers as $supplier): ?>
                           <option value="<?=$supplier['Supplier_ID']?>"><?=$supplier['Name']?></option>

    <?php endforeach; ?>
</select>
        <label for="Shipped">Shipped</label>
        <input type="number"  required="required" name="shipped"  id="shipped">
        <label for="created">Date</label>
        <input type="date" required="required" name="date"  id="date">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?php include('footer.php');?>
