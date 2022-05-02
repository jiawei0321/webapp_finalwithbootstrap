<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include 'headicon.php';
    ?>
    <title>
        Product_Update
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
    <div class="container me-7">
        <main class="main-content position-relative border-radius-lg ">
            <!-- Navbar -->
            <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
                <div class="container-fluid py-1 px-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Products</a></li>
                            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Update Product</li>
                        </ol>
                        <h3 class="font-weight-bolder text-white mb-0">Update Product</h3>
                    </nav>
                    <main class="main-content position-relative border-radius-lg ">
                        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line bg-white"></i>
                                    <i class="sidenav-toggler-line bg-white"></i>
                                    <i class="sidenav-toggler-line bg-white"></i>
                                </div>
                            </a>
                        </li>
                </div>
            </nav>
            <?php
            // isset() is a PHP function used to verify if a value is there or not
            $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
            // include database connection
            include 'database/connection.php';
            include 'function/function.php';

            if (!$_POST) {

                // read current record's data
                try {
                    // prepare select query
                    $query = "SELECT id, name, description, price FROM products WHERE id = ? LIMIT 0,1";
                    $stmt = $con->prepare($query);

                    // this is the first question mark
                    $stmt->bindParam(1, $id);

                    // execute our query
                    $stmt->execute();

                    // store retrieved row to a variable
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    // values to fill up our form
                    $name = $row['name'];
                    $description = $row['description'];
                    $price = $row['price'];
                }

                // show error
                catch (PDOException $exception) {
                    die('ERROR: ' . $exception->getMessage());
                }
            }
            ?>


            <!-- HTML form to update record will be here -->
            <!-- PHP post to update record will be here -->
            <?php
            // check if form was submitted
            if ($_POST) {

                if (!empty($_POST['name']) && !empty($_POST['description']) && !empty($_POST['price'])) {

                    if (ctype_alpha($_POST['name'])) {

                        if (is_numeric($_POST['price'])) {

                            try {
                                // write update query
                                // in this case, it seemed like we have so many fields to pass and
                                // it is better to label them and not use question marks
                                $query = "UPDATE products
                        SET name=:name, description=:description,
                        price=:price WHERE id = :id";
                                // prepare query for excecution
                                $stmt = $con->prepare($query);

                                // posted values
                                $name = htmlspecialchars(strip_tags($_POST['name']));
                                $description = htmlspecialchars(strip_tags($_POST['description']));
                                $price = htmlspecialchars(strip_tags($_POST['price']));

                                // bind the parameters
                                $stmt->bindParam(':name', $name);
                                $stmt->bindParam(':description', $description);
                                $stmt->bindParam(':price', $price);
                                $stmt->bindParam(':id', $id);

                                // Execute the query
                                if ($stmt->execute()) {
                                    header('Location: product_read.php?action=saved');
                                    //echo "<div class='alert alert-success'>Record was updated.</div>";
                                }
                            }
                            // show errors
                            catch (PDOException $exception) {
                                die('ERROR: ' . $exception->getMessage());
                            }
                        } else {
                            echo "<div class='alert alert-danger'>Please only key in number in price</div>";
                        }
                    } else {
                        echo "<div class='alert alert-danger'>Please only key in letters in name</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'><p class='text-white mb-0'>Please fill in name, description and price.</p></div>";

                }
            }
            ?>
            <!-- End Navbar -->
            <!-- note:py-4 control distance above the button-->

            <?php
            include 'nav.php';
            ?>
            <div class="card mb-4">
                <div class="card-body px-7 py-5">
                    <!--we have our html form here where new record information can be updated-->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="post">
                        <table class='table table-hover table-responsive'>
                            <tr>
                            <td class="text-end text-uppercase text-secondary text-sm font-weight-bolder px-3 col-1">Name</th>
                                <td><input type='text' name='name' value="<?php echo htmlspecialchars($name, ENT_QUOTES);  ?>" class='form-control' /></td>
                            </tr>
                            <tr>
                            <td class="text-end text-uppercase text-secondary text-sm font-weight-bolder px-3 col-1">Description</th>
                                <td><textarea name='description' class='form-control'><?php echo htmlspecialchars($description, ENT_QUOTES);  ?></textarea></td>
                            </tr>
                            <tr>
                            <td class="text-end text-uppercase text-secondary text-sm font-weight-bolder px-3 col-1">Price</th>
                                <td><input type='text' name='price' value="<?php echo htmlspecialchars($price, ENT_QUOTES);  ?>" class='form-control' /></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                   
                                    <input type='submit' value='Save Changes' class='btn btn-primary btn bg-gradient-primary mb-0' />
                                    <a class="btn bg-gradient-dark mb-0" href="product_read.php"><i class="fas fa-angle-left"></i>&nbsp;&nbsp;Back to Product List</a>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>

            <?php
            include("footer.php");
            ?>
        </main>
    </div>
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