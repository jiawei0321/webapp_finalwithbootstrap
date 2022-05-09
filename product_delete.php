<?php
// include database connection
include 'database/connection.php';

$product_id = isset($_GET['id']) ? $_GET['id'] :  die('ERROR: Record ID not found.');
$query = "SELECT product_id FROM orderdetail WHERE product_id = :id";
// prepare query for execution
$stmt = $con->prepare($query);
$stmt->bindParam(':id', $product_id);
$stmt->execute();
$num = $stmt->rowCount();

if ($num > 0) {
    //echo "<div class='alert alert-danger'>User not found.</div>";
    header('Location: product_read.php?action=deleteerror');
} else {
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
}
