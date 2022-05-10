<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/shopfavicon.png">
    <link rel="icon" type="image/png" href="assets/img/shopfavicon.png">
    <title>
        Order_detail
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="assets/css/argon-dashboard.css?v=2.0.2" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<?php
$id = isset($_GET['id']) ? $_GET['id'] :  die('ERROR: Record ID not found.');

// include database connection
include 'database/connection.php';
include 'function/function.php';

if (!isset($_SESSION['username'])) {
    header("Location: index.php?action=nologin");
    //go to the first page if the person didnt log in
}

$query = "SELECT orderdetail_id, order_id, product_id, price, name, quantity 
FROM orderdetail 
INNER JOIN products
ON orderdetail.product_id = products.id WHERE order_id  = ?
ORDER BY order_id ASC";
//prepare above variable
$stmt = $con->prepare($query);
$stmt->bindParam(1, $id);
$stmt->execute();

// this is how to get number of rows returned
//see total how many product
$num = $stmt->rowCount();
?>

<body class="g-sidenav-show   bg-gray-100">
    <div class="min-height-300 bg-primary position-absolute w-100"></div>
    <?php
    include 'nav.php';
    ?>
    <main class="main-content position-relative border-radius-lg ">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Orders</a></li>
                        <li class="breadcrumb-item text-sm text-white active" aria-current="page">Order Details</li>
                    </ol>
                    <h3 class="font-weight-bolder text-white mb-0">Order Details</h3>
                </nav>
                <?php
                include 'hamburger.php';
                ?>
            </div>
        </nav>
        <!-- End Navbar -->
        <!-- note:py-4 control distance above the button-->
        <div class="container-fluid py-4">
            <div class="col-12 text-start pb-4">
                <a class="btn bg-gradient-dark mb-0" href="order_summary.php"><i class="fas fa-angle-left"></i>&nbsp;&nbsp;Back to Order List</a>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Order Details Table</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">

                                <?php if ($num > 0) { ?>
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">OrderDetail ID</th>
                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Order ID</th>
                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product</th>
                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Quantity</th>
                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Price</th>
                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Price</th>
                                                <th class="text-secondary opacity-7"></th>
                                            </tr>
                                        </thead>
                                    <?php
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        extract($row);
                                        echo "<tbody>";
                                        //echo "<tr>";
                                        echo "<td>";
                                        echo "<div class='d-flex px-4 py-3'>";
                                        echo "<div class='d-flex flex-column justify-content-center'>";
                                        echo "<h6 class='mb-0 text-sm'>{$orderdetail_id}</h6>";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "</td>";

                                        echo "<td class='align-middle text-center text-sm'>";
                                        //<span class="badge badge-sm bg-gradient-success">Online</span>
                                        echo "<span class='text-secondary text-xs font-weight-bold'>{$order_id}</span>";
                                        echo "</td>";
                                        echo "<td class='align-middle text-center'>";
                                        echo "<span class='text-secondary text-xs font-weight-bold'>{$name}</span>";
                                        echo "</td>";
                                        echo "<td class='align-middle text-center'>";
                                        echo "<span class='text-secondary text-xs font-weight-bold'>{$quantity}</span>";
                                        echo "</td>";
                                        echo "<td class='align-middle text-center'>";
                                        echo "<span class='text-secondary text-xs font-weight-bold'>{$price}</span>";
                                        echo "</td>";
                                        echo "<td class='align-middle text-center'>";
                                        $totalprice = (int)$quantity * (int)$price;
                                        echo "<span class='text-secondary text-xs font-weight-bold'>{$totalprice}</span>";
                                        echo "</td>";
                                        //echo "</tr>";
                                        echo "</tbody>";
                                    }


                                    echo "</table>";
                                }
                                // if no records found
                                else {
                                    echo "<div class='alert alert-danger'>No records found.</div>";
                                }
                                    ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            include("footer.php");
            ?>
            <!--   Core JS Files   -->
            <script src="assets/js/core/popper.min.js"></script>
            <script src="assets/js/core/bootstrap.min.js"></script>
            <script src="assets/js/plugins/perfect-scrollbar.min.js"></script>
            <script src="assets/js/plugins/smooth-scrollbar.min.js"></script>
            <script>
                var win = navigator.platform.indexOf('Win') > -1;
                if (win && document.querySelector('#sidenav-scrollbar')) {
                    var options = {
                        damping: '0.5'
                    }
                    Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
                }
            </script>
            <!-- Github buttons -->
            <script async defer src="https://buttons.github.io/buttons.js"></script>
            <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
            <script src="assets/js/argon-dashboard.min.js?v=2.0.2"></script>

</body>

</html>