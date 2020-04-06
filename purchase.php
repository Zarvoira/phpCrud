<?php
include 'functions.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 10;

// Prepare the SQL statement and get records from our products table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM purchases ORDER BY Purchase_id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();

// Fetch the records so we can display them in our template.
$purchases = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Get the total number of purchases, this is so we can determine whether there should be a next and previous button
$num_purchases = $pdo->query('SELECT COUNT(*) FROM purchases')->fetchColumn();
?>

<?php include('header.php');?>
<div class="content read">
	<h2>Display All purchases</h2>
	<a href="create_purchase.php" class="create-contact">New Purchase Entry</a>
	<table id="keywords">
        <thead>
            <tr>
                <td>id</td>
                <td>Product ID</td>
                <td>Supplier ID</td>
                <td>Number_Received</td>
                <td>Purchase_Date</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($purchases as $purchase): ?>
            <tr>
                <td><?=$purchase['Purchase_id']?></td>
                <td><?=$purchase['Prod_ID']?></td>
                <td><?=$purchase['Supplier_ID']?></td>
                <td><?=$purchase['Number_Received']?></td>
                <td><?=$purchase['Purchase_Date']?></td>
                <td class="actions">
                    
                    <a href="update_purchase.php?id=<?=$purchase['Purchase_id']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a onclick="return confirm('Are you sure you want to delete this entry?')" href="delete_Purchase.php?id=<?=$purchase['Purchase_id']?> " class="trash"><i class="fas fa-trash fa-xs"></i></a>
                
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_purchases): ?>
		<a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?php include('footer.php');?>
