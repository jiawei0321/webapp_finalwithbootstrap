<?php
// include database connection
include 'database/connection.php';
try {
    // get record ID
    // isset() is a PHP function used to verify if a value is there or not
    $id = isset($_GET['id']) ? $_GET['id'] :  die('ERROR: Record ID not found.');

    // delete query
    $query = "DELETE orderdetail, ordersummary
    FROM orderdetail
    INNER JOIN ordersummary ON orderdetail.order_id = ordersummary.order_id
    WHERE orderdetail.order_id = ?";

    $stmt = $con->prepare($query);

    $stmt->bindParam(1, $id);

    if ($stmt->execute()) {
        // redirect to read records page and
        // tell the user record was deleted
        header('Location: order_summary.php?action=deleted');
    } else {
        die('Unable to delete record.');
    }
}
// show error
catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
}