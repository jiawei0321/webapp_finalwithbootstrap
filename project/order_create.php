<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include 'headicon.php';
    ?>
    <title>
        Create_Order
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

<body class="g-sidenav-show bg-gray-100">
    <div class="min-height-300 bg-primary position-absolute w-100"></div>
    <?php
    include 'nav.php';
    ?>
    <main class="main-content position-relative border-radius-lg">
        <?php
        // include database connection
        include 'database/connection.php';
        include 'function/function.php';

        if (!isset($_SESSION['username'])) {
            header("Location: index.php?action=nologin");
            //go to the first page if the person didnt log in
        }
        $product_id = array("");
        $customer_id = $username = $quantity = "";
        if ($_POST) {

            //post value
            $username = $_POST['username'];
            $product_id = $_POST['product_id'];
            $quantity = $_POST['quantity'];
            //$quantity[] = $_POST['quantity'];

            //$productchosen = array($_POST['product_id']);
            //$productchosen = array($product_id[0], $product_id[1], $product_id[2]);
            $productchosen = array_values($product_id);
            $total = count($productchosen);

            if (empty($_POST['username']) || empty(array_filter($_POST['product_id'])) || empty(array_filter($_POST['quantity']))) {
                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'><p class='text-white mb-0'>Please fill in all the information.</p></div>";
            }
            if (count(array_unique($productchosen)) != $total) {
                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'><p class='text-white mb-0'>Please choose different items.</p></div>";
                //echo count($productchosen);
            } else {

                if (count($quantity) != 0) {
                    try {
                        $query = "INSERT INTO `ordersummary` (`customer_id`) VALUES (?)";

                        // prepare query for execution
                        $stmt = $con->prepare($query);

                        // bind the parameters
                        $stmt->bindParam(1, $username);

                        // Execute the query
                        if ($stmt->execute()) {
                            $order_id = $con->lastInsertId();
                            $orderdetail_id = $con->lastInsertId();

                            //foreach ($product_id as $x => $oneproductid) {
                            for ($x = 0; $x < count($product_id); $x++) {
                                $query = "INSERT INTO `orderdetail` (`order_id`, `product_id`, `quantity`) VALUES (?, ?, ?)";
                                // prepare query for execution
                                $stmt = $con->prepare($query);
                                // posted values
                                $stmt->bindParam(1, $order_id);
                                //$stmt->bindParam(2, $oneproductid);
                                $stmt->bindParam(2, $product_id[$x]);
                                $stmt->bindParam(3, $quantity[$x]);
                                // Execute the query
                                if ($stmt->execute()) {
                                    if ($x == (count($product_id)) - 1) {
                                        //echo "<div class='alert alert-success'>Record was updated.</div>";
                                        header('Location: order_summary.php?action=saved');
                                    }
                                } else {
                                    if ($x == (count($product_id)) - 1) {
                                        echo "<div class='alert alert-danger'><p class='text-white mb-0'>Unable to update record.</p></div>";
                                    }
                                }
                            }
                        }

                        //show error after submit
                    } catch (PDOException $exception) {
                        die('ERROR: ' . $exception->getMessage());
                    }
                }
            }
        }

        //fetch product info
        $product = array();
        $query = "SELECT name, id FROM products";
        $stmt = $con->prepare($query);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $product[] = $row;
        }
        //fecth customer info
        $query = "SELECT username, customer_id FROM customers";
        $stmt = $con->prepare($query);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $user[] = $row;
        }
        ?>
        <!-- Navbar -->
        <!-- End Navbar -->
        <!-- note:py-4 control distance above the button-->
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Orders</a></li>
                        <li class="breadcrumb-item text-sm text-white active" aria-current="page">Create Order</li>
                    </ol>
                    <h3 class="font-weight-bolder text-white mb-0">Create Order</h3>
                </nav>
                <?php
                include 'hamburger.php';
                ?>
            </div>
        </nav>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <div class="card mb-4 mx-4">
                <div class="card-body px-7 py-5">
                    <table class='table table-hover table-responsive'>
                        <tbody>
                            <tr>
                                <div class="<d-flex flex-row mb-3">
                                    <td>Username</td>
                                    <td class="btn-group w-100">
                                        <div class="w-50 p-2">
                                            <label for="username">Username</label>
                                            <?php
                                            $selected = isset($_POST["username"]) ? $_POST["username"] : "";
                                            ?>
                                            <select name='username' class="form-control" id="username">
                                                <option value="">--- Choose username ---</option>
                                                <?php
                                                foreach ($user as $u) { ?>
                                                    <option value="<?php echo $u['customer_id']; ?>" <?php if ($u['customer_id'] == $selected) echo "selected"; ?>>
                                                        <?php echo $u['username']; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </td>
                            </tr>

                            <?php for ($i = 0; $i < count($product_id); $i++) { ?>
                                <tr class="productrow">
                                    <td>Products</td>
                                    <td class="btn-group w-100">
                                        <div class="w-50 p-2">
                                            <label for="product1">Item 1</label>
                                            <?php
                                            $selected = isset($_POST['product_id']) ? $product_id[$i] : "";
                                            ?>
                                            <select name='product_id[]' class="form-control" id="product1">
                                                <option value="">--- Choose item ---</option>
                                                <?php
                                                foreach ($product as $p) { ?>
                                                    <option value="<?php echo $p['id']; ?>" <?php if ($p['id'] == $selected) echo "selected"; ?>>
                                                        <?php echo $p['name']; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="w-20 p-2">
                                            <label for="quantity">Quantity</label>
                                            <input type='number' min=0 name='quantity[]' class="form-control" value="<?php if ($_POST) echo $quantity[$i]  ?>" />
                                        </div>
                                    <?php } ?>

                                <tr>
                                    <td></td>
                                    <td>
                                        <!--chech bootstrap not working-->
                                        <button type="button" class="add_one btn btn-outline-dark">Add More Product</button>
                                        <button type="button" class="del_last btn btn-outline-dark">Delete Last Product</button>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <input type='submit' value='Save' class='btn btn-primary' />
                                        <a href='order_summary.php' class='btn btn-danger'>Back</a>
                                    </td>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
        <?php
        include("footer.php");
        ?>

        </div>
    </main>
    <!--   Core JS Files   -->
    <script>
        document.addEventListener('click', function(event) {
            if (event.target.matches('.add_one')) {
                var element = document.querySelector('.productrow');
                var clone = element.cloneNode(true);
                element.after(clone);
            }
            if (event.target.matches('.del_last')) {
                var total = document.querySelectorAll('.productrow').length;
                if (total > 1) {
                    var element = document.querySelector('.productrow');
                    element.remove(element);
                }
            }
        }, false);
    </script>
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