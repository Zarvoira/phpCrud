

<?php
include 'functions.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();

// Prepare the SQL statement and get records from our products table, LIMIT will determine the page
$statement = $pdo->prepare('SELECT Product_Name,(Starting_Inventory+Inventory_Received-Inventory_Shipped) AS Inventory_OnHands FROM products ');
$statement->execute();
	
/* Manipulate the query result */
$json = "[";
if ($statement->rowCount() > 0)
{
    /* Get field information for all fields */
    $isFirstRecord = true;
    $result = $statement->fetchAll(PDO::FETCH_OBJ);
    foreach ($result as $row)
    {
        if(!$isFirstRecord)
        {
            $json .= ",";
        }
        
        /* NOTE: json strings MUST have double quotes around the attribute names, as shown below */
        $json .= '{"name":"' . $row->Product_Name . '","Inventory":"' . $row->Inventory_OnHands  . '"}';
       
        $isFirstRecord = false;
    }  
}     
$json .= "]";





/* Send the $json string back to the webpage that sent the AJAX request */
echo $json;
?>