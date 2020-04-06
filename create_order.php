<?php

include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

// Prepare the SQL statement and get records from our products table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM orders ORDER BY Order_ID');
$stmt->execute();

// Fetch the records so we can display them in our template.
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare('SELECT * FROM products ORDER BY Prod_ID');
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Check if POST data is not empty
if (!empty($_POST)) {

$id = filter_var(($_POST['id']), FILTER_SANITIZE_NUMBER_INT);
$name = filter_var(($_POST['name']), FILTER_SANITIZE_STRING);
$shipped = filter_var(($_POST['shipped']), FILTER_SANITIZE_NUMBER_INT);
$date = filter_var(($_POST['date']), FILTER_SANITIZE_STRING);
    

/* Perform Query */
$query = "INSERT INTO Orders (Order_ID, Prod_ID,Customer_Name, Number_Shipped, Order_Date) VALUES (NULL, :id, :name, :shipped, :date)";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $id, PDO::PARAM_INT);
$stmt->bindParam(":name", $name, PDO::PARAM_STR);
$stmt->bindParam(":shipped", $shipped, PDO::PARAM_INT);
$stmt->bindParam(":date", $date, PDO::PARAM_STR);
$stmt->execute();

$msg='success';
}
?>
<?php include('header.php');?>


<div class="content update">
	<h2>New Order Entry</h2>
    <form action="create_order.php" method="post">
    <label for="id">prod_ID</label>
    <select id="id" name="id">

    <?php foreach ($products as $product): ?>

                   <option value="<?=$product['Prod_ID']?>"><?=$product['Product_Name']?></option>

    <?php endforeach; ?>
</select>

        <label for="customer name">Customer Name</label>
        <input type="text" name="name" required="required"  id="shipped">
        <label for="Shipped" required="required">Shipped</label>
        <input type="number" required="required" name="shipped"  id="shipped">
        <label for="created">Date</label>
        <input type="date" required="required"name="date"  id="date">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?php include('footer.php');?>
