<?php
include 'functions.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 5;

// Prepare the SQL statement and get records from our products table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM products ORDER BY Prod_id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();

// Fetch the records so we can display them in our template.
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Get the total number of products, this is so we can determine whether there should be a next and previous button
$num_products = $pdo->query('SELECT COUNT(*) FROM products')->fetchColumn();
?>

<?=template_header('Read')?>

<div class="content read">
	<h2>Display All products</h2>
	<a href="create.php" class="create-contact">Create product</a>
	<table id="keywords">
        <thead>
            <tr>
                <td>id</td>
                <td>Name</td>
                <td>Starting Inventory</td>
                <td>Inventory Shipped</td>
                <td>Inventory On hand</td>
                <td>Inventory On Received</td>
                <td>Minimum Required</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
            <tr>
                <td><?=$product['Prod_ID']?></td>
                <td><?=$product['Product_Name']?></td>
                <td><?=$product['Starting_Inventory']?></td>
                <td><?=$product['Inventory_Shipped']?></td>
                <td><?=$product['Inventory_OnHand']?></td>
                <td><?=$product['Inventory_Received']?></td>
                <td><?=$product['Minimum_Req']?></td>
                <td class="actions">
                    
                    <a href="update.php?id=<?=$product['Prod_ID']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a onclick="return confirm('Are you sure you want to delete this entry?')" href="delete.php?id=<?=$product['Prod_ID']?> " class="trash"><i class="fas fa-trash fa-xs"></i></a>
                
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_products): ?>
		<a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>