<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/shopfavicon.png">
    <link rel="icon" type="image/png" href="assets/img/shopfavicon.png">
    <title>
        Order_summary
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
// include database connection
include 'database/connection.php';

// delete message prompt will be here
$action = isset($_GET['action']) ? $_GET['action'] : "";

// if it was redirected from delete.php
if ($action == 'deleted') {
    echo "<div class='container me-5 pt-3'>";
    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'><p class='text-white mb-0'>Order record was deleted.</p></div>";
    echo "</div>";
}

if ($action == 'saved') {
    echo "<div class='container me-5 pt-3'>";
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'><p class='text-white mb-0'>Order record was saved.</p></div>";
    echo "</div>";
}
if ($action == 'deleteerror') {
    echo "<div class='container me-5 pt-3'>";
    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'><p class='text-white mb-0'>Order record unable to delete. Only never purchased product can be deleted.</p></div>";
    echo "</div>";
}

// select all data

$query = "SELECT order_id, customer_id, orderdate FROM ordersummary ORDER BY order_id ASC";
//prepare above variable
$stmt = $con->prepare($query);
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
                        <li class="breadcrumb-item text-sm text-white active" aria-current="page">Order List</li>
                    </ol>
                    <h3 class="font-weight-bolder text-white mb-0">Order List</h3>
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
                <a class="btn bg-gradient-dark mb-0" href="order_create.php"><i class="fas fa-plus"></i>&nbsp;&nbsp;Create New Order</a>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Order List table</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">

                                <?php if ($num > 0) { ?>
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Order ID</th>
                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Customer ID</th>
                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">OrderDate</th>
                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                                                <th class="text-secondary opacity-7"></th>
                                            </tr>
                                        </thead>
                                    <?php
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        extract($row);
                                        echo "<tbody>";
                                        echo "<tr>";
                                        echo "<td>";
                                        echo "<div class='d-flex px-4 py-3'>";
                                        echo "<div class='d-flex flex-column justify-content-center'>";
                                        echo "<h6 class='mb-0 text-sm'>{$order_id}</h6>";
                                        echo "</div>";
                                        echo "</div>";

                                        echo "</td>";
                                        echo "<td class='align-middle text-center text-sm'>";
                                        //<span class="badge badge-sm bg-gradient-success">Online</span>
                                        echo "<span class='text-secondary text-xs font-weight-bold'>{$customer_id}</span>";
                                        echo "</td>";
                                        echo "<td class='align-middle text-center'>";
                                        echo "<span class='text-secondary text-xs font-weight-bold'>{$orderdate}</span>";
                                        echo "</td>";

                                        echo "<td class='align-middle text-center'>";
                                        echo "<a class='btn btn-link text-info text-gradient px-3 mb-0' href='order_detail.php?id={$order_id}'><i class='fas fa-search me-2'></i>View</a>";
                                        echo "<a class='btn btn-link text-dark text-gradient px-3 mb-0' href='order_update.php?id={$order_id}'><i class='fas fa-pencil-alt text-dark me-2'></i>Edit</a>";
                                        //echo "<a class='btn btn-link text-dark px-3 mb-0' href='order_update.php?id={$order_id}><i class='fas fa-pencil-alt text-dark me-2' aria-hidden='true'></i>Edit</a>";
                                        echo "<a class='btn btn-link text-danger text-gradient px-3 mb-0' onclick='delete_user({$order_id})'><i class='far fa-trash-alt me-2'></i>Delete</a>";
                                        echo "</td>";
                                    }
                                    //</tr>
                                    //</tbody>
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

                //confirm delete record will be here
                // confirm record deletion
                function delete_user(id) {
                    var answer = confirm('Are you sure?');
                    if (answer) {
                        // if user clicked ok,
                        // pass the id to delete.php and execute the delete query
                        window.location = 'order_delete.php?id=' + id;
                    }
                }
            </script>
            <!-- Github buttons -->
            <script async defer src="https://buttons.github.io/buttons.js"></script>
            <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
            <script src="assets/js/argon-dashboard.min.js?v=2.0.2"></script>

</body>

</html>