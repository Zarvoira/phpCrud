<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';



// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {

$id = filter_var(($_POST['id']), FILTER_SANITIZE_NUMBER_INT);
$supplier = filter_var(($_POST['supplier']), FILTER_SANITIZE_NUMBER_INT);
$shipped = filter_var(($_POST['shipped']), FILTER_SANITIZE_NUMBER_INT);
$date = filter_var(($_POST['date']), FILTER_SANITIZE_STRING);
$prod = filter_var(($_POST['prod']), FILTER_SANITIZE_NUMBER_INT);


//* Perform Query */

$query="UPDATE purchases SET Prod_ID = :prod, Number_Received = :shipped,`Supplier_ID` =:supplier, Purchase_Date = :date WHERE Purchase_id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":prod", $prod, PDO::PARAM_INT);
$stmt->bindParam(":shipped", $shipped, PDO::PARAM_INT);
$stmt->bindParam(":supplier", $supplier, PDO::PARAM_INT);
$stmt->bindParam(":date", $date, PDO::PARAM_STR);
$stmt->bindParam(":id", $id, PDO::PARAM_INT);
 $stmt->execute();

$msg='success';
$stmt->execute();

$msg = 'updated successfully';
    }

// Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM purchases WHERE Purchase_id = ?');
    $stmt->execute([$_GET['id']]);
    $purchases = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$purchases) {
        exit('purchase doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}

?>
<?php include('header.php');?>
<div class="content update">
	<h2>Update Purchase</h2>
    <form action="update_purchase.php?id=<?=$purchases['Purchase_id']?>" method="post">
    <label for="id">Purchase_ID</label>
    <input type ="text" name="id" value="<?=$purchases['Purchase_id']?>" id="id" >
    <label for="id">prod_ID</label>
    <input type ="text" name="prod" value="<?=$purchases['Prod_ID']?>" id="prod" >
    <label for="id">prod_ID</label>
    <input type ="text" name="prod" value="<?=$purchases['Prod_ID']?>" id="prod" >
    <label for="Supplier_ID">Supllier_ID</label>
    <input type="text" name="supplier" value="<?=$purchases['Supplier_ID']?>" id="supplier" >
    <label for="Shipped">Shipped</label>
    <input type="text" name="shipped" value="<?=$purchases['Number_Received']?>" id="shipped" >
     <label for="created">Date</label>
    <input type="date" name="date" value="<?=$purchases['Purchase_Date']?>" id="date" >

     <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?php include('footer.php');?>
