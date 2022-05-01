<?php
// include database connection
include 'database/connection.php';

$query = "SELECT products.id FROM products LEFT JOIN orderdetail ON orderdetail.product_id = products.id WHERE orderdetail.product_id = products.id";
// prepare query for execution
$stmt = $con->prepare($query);
//$stmt->bindParam('id', $id);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$num = $stmt->rowCount();

if ($num > 0) {
    //echo "<div class='alert alert-danger'>User not found.</div>";
    header('Location: product_read.php?action=deleteerror');
}

    try {
        // get record ID
        // isset() is a PHP function used to verify if a value is there or not
        $id = isset($_GET['id']) ? $_GET['id'] :  die('ERROR: Record ID not found.');


        // delete query
        $query = "DELETE FROM products WHERE id = ?";
        $stmt = $con->prepare($query);
        $stmt->bindParam(1, $id);

        if ($stmt->execute()) {

            // redirect to read records page and
            // tell the user record was deleted
            header('Location: product_read.php?action=deleted');
        } else {
            die('Unable to delete record.');
        }
    }
    // show error
    catch (PDOException $exception) {
        die('ERROR: ' . $exception->getMessage());
    }