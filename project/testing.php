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
        Create_Product
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
        // include database connection
        include 'database/connection.php';
        include 'function/function.php';

        //if (!isset($_SESSION['username'])) {
        //header("Location: index.php?action=nologin");
        //go to the first page if the person didnt log in
        //}
        // keep value in form after submit
        $name = $description = $price = $product_image = "";
        if ($_POST) {
            if (!empty($_POST['name']) || !empty($_POST['description']) || !empty($_POST['price'])) {
                //product create
                $name = test_input($_POST["name"]);
                $description = test_input($_POST["description"]);
                $price = test_input($_POST["price"]);
            }
            
            // now, if image is not empty, try to upload the image
            // new 'image' field
            $product_image = !empty($_FILES["product_image"]["name"])
                ? sha1_file($_FILES['product_image']['tmp_name']) . "-" . basename($_FILES["product_image"]["name"])
                : "";
            $product_image = test_input($product_image);
            if ($product_image) {
                $target_directory = "uploads/";
                // make sure the 'uploads' folder exists
                // if not, create it
                if (!is_dir($target_directory)) {
                    mkdir($target_directory, 0777, true);
                }
                $target_file = $target_directory . $product_image;

                // make sure file does not exist
                if (file_exists($target_file)) {
                    $file_upload_error_messages = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><p class='text-white mb-0'><strong>Image already exists.</strong> Try to change file name.</p></div>";
                }
                // check the extension of the upload file
                $file_type = pathinfo($target_file, PATHINFO_EXTENSION);
                // make sure only certain file types are allowed
                $allowed_file_types = array("jpg", "jpeg", "png");
                if (!in_array($file_type, $allowed_file_types)) {
                    $file_upload_error_messages = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><p class='text-white mb-0'>Only JPEG,JPG or PNG files are allowed.</p></div>";
                }
                // make sure submitted file is not too large
                if ($_FILES['product_image']['size'] > (5120000)) {
                    $file_upload_error_messages = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><p class='text-white mb-0'>Image must be less than 5 MB in size.</p></div>";
                }

                if (empty($file_upload_error_messages)) {
                    // it means there are no errors, so try to upload the file (now only start uploading)
                    if (!move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
                        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'><p class='text-white mb-0'>Unable to upload photo.</p></div>";
                    }
                } else {
                    // it means there are some errors, so show them to user

                    echo $file_upload_error_messages;
                }
                //if no image
            } else {
                $file_upload_error_messages = "";
            }
            if (!empty($_POST['name']) && !empty($_POST['description']) && !empty($_POST['price'])) {

                if ($file_upload_error_messages == "") {

                    //let letter and space ok pass
                    if (ctype_alpha(str_replace(' ', '', $name))) {

                        if (is_numeric($_POST['price'])) {

                            // posted values
                            //$name = $_POST['name'];
                            //$description = $_POST['description'];
                            //$price = $_POST['price'];

                            try {
                                // insert query
                                $query = "INSERT INTO products
                                SET name=:name, description=:description,
                                price=:price, product_image=:product_image, created=:created";

                                // prepare query for execution
                                $stmt = $con->prepare($query);

                                //$name = htmlspecialchars(strip_tags($_POST['name']));
                                //$description = htmlspecialchars(strip_tags($_POST['description']));
                                //$price = htmlspecialchars(strip_tags($_POST['price']));
                                //$product_image = htmlspecialchars(strip_tags($product_image));

                                // bind the parameters
                                $stmt->bindParam(':name', $name);
                                $stmt->bindParam(':description', $description);
                                $stmt->bindParam(':price', $price);
                                $stmt->bindParam(':product_image', $product_image);

                                // specify when this record was inserted to the database
                                $created = date('Y-m-d H:i:s');
                                $stmt->bindParam(':created', $created);

                                // Execute the query
                                if ($stmt->execute()) {

                                    //echo "<div class='alert alert-success'>Record was saved.</div>";
                                    header('Location: product_read.php?action=saved');
                                    // now, if image is not empty, try to upload the image
                                } else {
                                    echo "<div class='alert alert-danger'>Unable to save record.</div>";
                                }
                            }
                            // show error
                            catch (PDOException $exception) {
                                die('ERROR: ' . $exception->getMessage());
                            }
                        } else {
                            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'><p class='text-white mb-0'>Please only key in number in price.</p></div>";
                        }
                    } else {
                        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'><p class='text-white mb-0'>Please only key in letters in name.</p></div>";
                    }
                }
            } else {
                //echo "<div class='container me-5 pt-3'>";
                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'><p class='text-white mb-0'>Please fill in name, description and price.</p></div>";
                //echo "</div>";
            }
        }
        ?>
    </div>
    <!-- Navbar -->
    <!-- End Navbar -->
    <!-- note:py-4 control distance above the button-->
    <!-- Navbar -->
    <?php
    include 'nav.php';
    ?>
    <main class="main-content position-relative border-radius-lg ">
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Products</a></li>
                        <li class="breadcrumb-item text-sm text-white active" aria-current="page">Create Product</li>
                    </ol>
                    <h3 class="font-weight-bolder text-white mb-0">Create Product</h3>
                </nav>
                <?php
                include 'hamburger.php';
                ?>
            </div>
        </nav>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <table class='table table-hover table-responsive'>
                <tbody>
                    <div class="container-fluid py-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <!--<div class="card-header pb-0">
                                <div class="d-flex align-items-center">
                                    <p class="mb-0">Product</p>
                                    <button class="btn btn-primary btn-sm ms-auto">Settings</button>
                                </div>
                            </div>-->
                                    <div class="card-body">
                                        <!--<p class="text-uppercase text-sm">User Information</p>-->
                                        <div class="row">
                                            <!--<div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Username</label>
                                            <input class="form-control" type="text" value="lucky.jesse">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Email address</label>
                                            <input class="form-control" type="email" value="jesse@example.com">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">First name</label>
                                            <input class="form-control" type="text" value="Jesse">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Last name</label>
                                            <input class="form-control" type="text" value="Lucky">
                                        </div>
                                    </div>-->
                                        </div>
                                        <hr class="horizontal dark">
                                        <!--<p class="text-uppercase text-sm">Contact Information</p>-->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="name" class="form-control-label">Name</label>
                                                    <input class="form-control" type="text" name="name" value="<?php echo $name; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="description" class="form-control-label">Description</label>
                                                    <input class="form-control" type="text" textarea name="description" value="<?php echo $description; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="price" class="form-control-label">Price</label>
                                                    <input class="form-control" type="text" name="price" value="<?php echo $price; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="photo" class="form-control-label">Photo (Optional)</label>
                                                    <input type="file" name="prouct_image">
                                                </div>

                                                <input type='submit' value='Save' class='btn btn-primary btn bg-gradient-primary mb-0' />
                                                <a class="btn bg-gradient-dark mb-0" href="product_read.php"><i class="fas fa-angle-left"></i>&nbsp;&nbsp;Back to Product List</a>

                                            </div>
                                            <!--<div class="col-md-4">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">City</label>
                                            <input class="form-control" type="text" value="New York">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Country</label>
                                            <input class="form-control" type="text" value="United States">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Postal code</label>
                                            <input class="form-control" type="text" value="437300">
                                        </div>
                                    </div>
                                </div>
                                <hr class="horizontal dark">
                                <p class="text-uppercase text-sm">About me</p>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">About me</label>
                                            <input class="form-control" type="text" value="A beautiful Dashboard for Bootstrap 5. It is Free and Open Source.">
                                        </div>
                                    </div>
                                </div>-->
                            </div>
                        </div>
                    </div>
                </tbody>
            </table>
        </form>
<?php
include("footer.php");
?>
</main>

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