<?php
include 'functions.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 5;

// Prepare the SQL statement and get records from our products table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM orders ORDER BY Order_ID LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();

// Fetch the records so we can display them in our template.
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Get the total number of products, this is so we can determine whether there should be a next and previous button
$num_products = $pdo->query('SELECT COUNT(*) FROM orders')->fetchColumn();
?>

<?php include('header.php')?>
<div class="content read">
	<h2>Display All products</h2>
	<a href="create_order.php" class="create-contact">New Order Entry</a>
	<table id="keywords">
        <thead>
            <tr>
                <td>Order_ID</td>
                <td>Prod_ID</td>
                <td>Customer Name</td>
                <td>Shipped</td>
                <td>Order Date</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
            <tr>
                <td><?=$order['Order_ID']?></td>
                <td><?=$order['Prod_ID']?></td>
                <td><?=$order['Customer_Name']?></td>
                <td><?=$order['Number_Shipped']?></td>
                <td><?=$order['Order_Date']?></td>
                <td class="actions">
                    
                    <a href="update_order.php?id=<?=$order['Order_ID']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a onclick="return confirm('Are you sure you want to delete this entry?')" href="delete_order.php?id=<?=$order['Order_ID']?> " class="trash"><i class="fas fa-trash fa-xs"></i></a>
                
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

<?php include('footer.php')?>

