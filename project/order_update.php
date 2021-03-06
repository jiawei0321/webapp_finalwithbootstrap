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
        Update_Order_Info
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
    <div class="container me-1 pt-3 ps-7">
        <?php
        //include database connection
        include 'database/connection.php';
        include 'function/function.php';

        if (!isset($_SESSION['username'])) {
            header("Location: index.php?action=nologin");
            //go to the first page if the person didnt log in
        }

        $id = isset($_GET['id']) ? ($_GET['id']) : die('ERROR: Record ID not found.');

        if (!$_POST) {

            // read current record's data
            try {
                // prepare select query
                $query = "SELECT order_id, product_id, quantity, orderdetail_id FROM orderdetail WHERE order_id = ? ";

                // prepare query
                $stmt = $con->prepare($query);

                // bindparams
                $stmt->bindParam(1, $id);

                // execute query
                $stmt->execute();

                // store retrieved row to a variable
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    // values to fill up our form
                    $orderdetail_id[] = $row['orderdetail_id'];
                    $product_id[] = $row['product_id'];
                    $quantity[] = $row['quantity'];
                }

                $query = "SELECT customer_id FROM ordersummary WHERE order_id = ?";
                // prepare query
                $stmt = $con->prepare($query);

                // bindparams
                $stmt->bindParam(1, $id);

                // execute query
                $stmt->execute();

                // store retrieved row to a variable
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    // values to fill up our form
                    $customer_id = $row['customer_id'];
                }
            }
            // show error
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        }
        ?>
        <?php
        if ($_POST) {
            // values to fill up our form
            $customer_id =  htmlspecialchars(strip_tags($_POST['username']));
            $orderdetail_id = $_POST['orderdetail_id'];
            $product_id = $_POST['product_id'];
            $quantity =  $_POST['quantity'];

            //$productchosen = array($product_id[0], $product_id[1], $product_id[2]);

            $productchosen = array_values($product_id);
            $total = count($productchosen);
            //$total = count($product_id);
            //$uu = $row['customer_id'];
            //echo $total;
            $u = isset($row['username']) ? $row['username'] : "";

            if (empty($_POST['username']) || empty($_POST['product_id']) || empty($_POST['quantity'])) {
                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'><p class='text-white mb-0'>Please fill in all the information.</p></div>";
            } else {
                if (count($quantity) > 0) {
                    if (count(array_unique($productchosen)) != $total) {
                        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'><p class='text-white mb-0'>Please choose different items.</p></div>";
                    } else {

                        try {
                            // write update query

                            $query = "UPDATE ordersummary SET customer_id=:customer_id WHERE order_id = :order_id ";

                            // prepare query for excecution
                            $stmt = $con->prepare($query);

                            // bind the parameters
                            $stmt->bindParam(':customer_id', $customer_id);
                            $stmt->bindParam(':order_id', $id);

                            // Execute the query
                            if ($stmt->execute()) {
                                for ($x = 0; $x < count($product_id); $x++) {
                                    $query = "UPDATE orderdetail SET  product_id = ?, quantity = ? WHERE orderdetail_id = ?";
                                    $stmt = $con->prepare($query);
                                    $stmt->bindParam(1, $product_id[$x]);
                                    $stmt->bindParam(2, $quantity[$x]);
                                    $stmt->bindParam(3, $orderdetail_id[$x]);


                                    if ($stmt->execute()) {
                                        if ($x == (count($product_id)) - 1) {
                                            header('Location: order_summary.php?action=saved');
                                            //echo "<div class='alert alert-success'>Record was updated.</div>";
                                        }
                                    } else {
                                        if ($x == (count($product_id)) - 1) {
                                            echo "<div class='alert alert-danger'>Unable to update record.</div>";
                                        }
                                    }
                                }
                            }
                        }
                        // show errors
                        catch (PDOException $exception) {
                            die('ERROR: ' . $exception->getMessage());
                        }
                    }
                }
            }
        }

        //fetch product
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
    </div>
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
                        <li class="breadcrumb-item text-sm text-white active" aria-current="page">Update Order Info</li>
                    </ol>
                    <h3 class="font-weight-bolder text-white mb-0">Update Order Info</h3>
                </nav>
                <?php
                include 'hamburger.php';
                ?>
            </div>
        </nav>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="post">
            <div class="card mb-4 mx-4">
                <div class="card-body px-md-7 px-sm-2 py-5">

                    <table class='table table-hover table-responsive'>
                        <tbody>
                            <tr>
                                <div class="<d-flex flex-row mb-3">

                                    <td style="border: none" class="btn-group w-100">
                                        <div class="w-85 p-2">
                                            <label for="username" class="text-end text-uppercase text-secondary text-sm font-weight-bolder pt-4">Username</label>
                                            <?php
                                            $selected = isset($_POST["username"]) ? $_POST["username"] : $customer_id;
                                            ?>
                                            <select name='username' class="form-control" id="username">
                                                <option value="">-- Choose username --</option>
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
                                    <td class="btn-group w-100">
                                        <div class="w-60 p-2">
                                            <label for="prodcut1" class="text-end text-uppercase text-secondary text-sm font-weight-bolder pt-4">Item</label>
                                            <?php
                                            $selected = htmlspecialchars(strip_tags($product_id[$i]));
                                            ?>
                                            <select name='product_id[]' class="form-control" id="product1">
                                                <option value="">-- Choose item --</option>
                                                <?php
                                                foreach ($product as $p) { ?>
                                                    <option value="<?php echo $p['id']; ?>" <?php if ($p['id'] == $selected) echo "selected"; ?>>
                                                        <?php echo $p['name']; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>

                                        </div>

                                        <div class="w-25 p-2">
                                            <label for="quantity" class="text-end text-uppercase text-secondary text-sm font-weight-bolder pt-4">Quantity</label>
                                            <input type='number' min=0 name='quantity[]' class="form-control" value="<?php echo $quantity[$i] ?>" />
                                            <input type="hidden" name="orderdetail_id[]" value="<?php echo $orderdetail_id[$i] ?>">
                                        </div>
                                </tr>
                            <?php } ?>
                            
                            <td>
                                <!--chech bootstrap not working-->
                                <button type="button" class="add_one btn btn-outline-dark me-3">Add Product</button>
                                <button type="button" class="del_last btn btn-outline-dark">Delete Product</button>
                                </tr>
                                <tr>
                                  
                                    <td>
                                        <input type='submit' value='Save' class='btn btn-primary btn bg-gradient-primary mb-0 me-3' />
                                        <a class="btn bg-gradient-dark mb-0" href="order_summary.php"><i class="fas fa-angle-left"></i>&nbsp;&nbsp;Back to Order List</a>
                                    </td>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php
            include("footer.php");
            ?>
        </form>
    </main>
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