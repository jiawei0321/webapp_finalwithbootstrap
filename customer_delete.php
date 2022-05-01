<?php
// include database connection
include 'database/connection.php';
$customer_id = isset($_GET['id']) ? $_GET['id'] :  die('ERROR: Record ID not found.');
$query = "SELECT customer_id FROM ordersummary WHERE customer_id = :id";
// prepare query for execution
$stmt = $con->prepare($query);
$stmt->bindParam(':id', $customer_id);
$stmt->execute();
$num = $stmt->rowCount();
echo $num;
if ($num > 0) {
    header('Location: customer_read.php?action=deleteerror');  
}
try {
    // get record ID
    // isset() is a PHP function used to verify if a value is there or not
    $id = isset($_GET['id']) ? $_GET['id'] :  die('ERROR: Record ID not found.');

    // delete query
    $query = "DELETE FROM customers WHERE customer_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bindParam(1, $id);

    if ($stmt->execute()) {
        // redirect to read records page and
        // tell the user record was deleted
        header('Location: customer_read.php?action=deleted');
    } else {
        die('Unable to delete record.');
    }
}
// show error
catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
}
