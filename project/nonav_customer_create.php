<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include 'headicon.php';
    ?>
    <title>
        Create_Customer
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
    <div class="min-height-500 bg-primary position-absolute w-100"></div>

    <div class="container pt-3">
        <?php
        // include database connection
        include 'database/connection.php';
        include 'function/function.php';

        // keep value in form after submit
        $username = $password = $confirmpassword = $email = $firstname = $lastname = $dob = $gender = $status = $image = $cust_image = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //customer create
            $username = test_input($_POST['username']);
            //$password = md5(test_input($_POST['password']));
            //$confirmpassword = md5(test_input($_POST['confirmpassword']));
            $password = test_input($_POST['password']);
            $confirmpassword = test_input($_POST['confirmpassword']);
            $email = test_input($_POST['email']);
            $firstname = test_input($_POST['firstname']);
            $lastname = test_input($_POST['lastname']);
            $dob = test_input($_POST['year'] . "-" . $_POST['month'] . "-" . $_POST['day']);
            $gender = isset($_POST['gender']) ? $_POST['gender'] : "";
            $status = isset($_POST['status']) ? $_POST['status'] : "";
            $cust_image = htmlspecialchars(strip_tags($cust_image));
            $age = (int)date('Y') - (int)$_POST['year'];
            $error = "";
            // now, if image is not empty, try to upload the image
            // new 'image' field
            $cust_image = !empty($_FILES["cust_image"]["name"])
                ? sha1_file($_FILES['cust_image']['tmp_name']) . "-" . basename($_FILES["cust_image"]["name"])
                : "";
            $cust_image = test_input($cust_image);
            if ($cust_image) {
                $target_directory = "uploads/";
                // make sure the 'uploads' folder exists
                // if not, create it
                if (!is_dir($target_directory)) {
                    mkdir($target_directory, 0777, true);
                }
                $target_file = $target_directory . $cust_image;

                // make sure file does not exist
                if (file_exists($target_file)) {
                    $file_upload_error_messages = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><p class='text-white mb-0'>Image already exists. Try to change file name.</p></div>";
                }
                // check the extension of the upload file
                $file_type = pathinfo($target_file, PATHINFO_EXTENSION);
                // make sure only certain file types are allowed
                $allowed_file_types = array("jpg", "jpeg", "png");
                if (!in_array($file_type, $allowed_file_types)) {
                    $file_upload_error_messages = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><p class='text-white mb-0'>Only JPEG,JPG or PNG files are allowed.</p></div>";
                }
                // make sure submitted file less than 5mb
                if ($_FILES['cust_image']['size'] > (5120000)) {
                    $file_upload_error_messages = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><p class='text-white mb-0'>Image must be less than 5 MB in size.</p></div>";
                }
                if (empty($file_upload_error_messages)) {
                    // it means there are no errors, so try to upload the file (now only start uploading)
                    if (!move_uploaded_file($_FILES["cust_image"]["tmp_name"], $target_file)) {
                        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'><p class='text-white mb-0'>Unable to upload photo.</p></div>";
                    }
                } else {
                    // if there are some errors, so show them to user
                    echo $file_upload_error_messages;
                }
                //if no image
            } else {
                $file_upload_error_messages = "";
            }
            // posted values

            //$password = md5($_POST['password']); //md5 encrypt password
            //$confirmpassword = md5($_POST['confirmpassword']);

            //$username = $_POST['username'];
            //$password = $_POST['password']; //md5 encrypt password
            //$confirmpassword = $_POST['confirmpassword'];
            //$email = $_POST['email'];
            //$firstname = $_POST['firstname'];
            //$lastname = $_POST['lastname'];
            //$dob = $_POST['year'] . "-" . $_POST['month'] . "-" . $_POST['day'];

            //if not empty continue, if got 1 empty, go error.
            if (empty($_POST['username']) || empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['gender']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['confirmpassword']) || empty($_POST['status'])) {
                $error = $error . "<div class='alert alert-danger alert-dismissible fade show' role='alert'><p class='text-white mb-0'>Please fill in all the information.</p></div>";
            }
            if ($file_upload_error_messages == "") {

                //Starting ^,And end $, in the string there has to be at least 1 number(?=.*\d), and at least one letter(?=.*[A-Za-z])and it has to be a number, a letter or one of the following: !@#$% -> [0-9A-Za-z!@#$%]and there have to be 8-12 characters -> {6,15} '/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{6,15}$/'
                //if match these continue, if not, go error.
                if (!preg_match('/^[a-zA-Z0-9]{6,}$/', $username) && !preg_match('/^(?!.* )$/', $username)) {
                    $error = $error . "<div class='alert alert-danger alert-dismissible fade show' role='alert'><p class='text-white mb-0'>Username must only be at least 6 characters and no space.</p></div>";
                }
                if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{6,}$/', $password)) {
                    $error = $error . "<div class='alert alert-danger alert-dismissible fade show' role='alert'><p class='text-white mb-0'>Password must be minimum 6 characters, contain at least a number, a small letter and a capital letter.</p></div>";
                }

                if ($password  != $confirmpassword) {
                    $error = $error . "<div class='alert alert-danger alert-dismissible fade show' role='alert'><p class='text-white mb-0'>Password and confirm password does not match.</p></div>";
                }

                if ($age <= 18) {
                    $error = $error . "<div class='alert alert-danger alert-dismissible fade show' role='alert'><p class='text-white mb-0'>Customer must be above 18 years old.</p></div>";
                }
                $query = "SELECT * FROM customers WHERE username=:username";
                $stmt = $con->prepare($query);
                $stmt->bindParam(':username', $username);
                //fix error execute the statement
                $stmt->execute();
                //fix error fetch result
                $numRow = $stmt->rowCount();

                if ($numRow > 0) {
                    $error = $error . "<div class='alert alert-danger alert-dismissible fade show' role='alert'><p class='text-white mb-0'>Username is taken by others.</p></div>";
                }
                echo $error;

                if ($error == "") {
                    try {
                        $password = md5($_POST['password']);
                        $confirmpassword = md5($_POST['confirmpassword']);

                        // insert query
                        $query = "INSERT INTO customers SET 
                            username =:username, 
                            password =:password,
                            email =:email,
                            firstname =:firstname, 
                            lastname =:lastname, 
                            dob =:dob,
                            gender =:gender,
                            status =:status,
                            cust_image=:cust_image";


                        // prepare query for execution
                        $stmt = $con->prepare($query);

                        // bind the parameters
                        $stmt->bindParam(':username', $username);
                        $stmt->bindParam(':password', $password);
                        $stmt->bindParam(':email', $email);
                        $stmt->bindParam(':firstname', $firstname);
                        $stmt->bindParam(':lastname', $lastname);
                        $stmt->bindParam(':dob', $dob);
                        $stmt->bindParam(':gender', $gender);
                        $stmt->bindParam(':status', $status);
                        $stmt->bindParam(':cust_image', $cust_image);

                        // Execute the query
                        if ($stmt->execute()) {

                            //$customer_id = $con->lastInsertId();
                            //echo "<div class='alert alert-success'>Record was saved.</div>";
                            header('Location: index.php?action=nonavsignin');
                        } else {
                            echo "<div class='alert alert-danger'>Unable to save record.</div>";
                        }
                    }
                    // show error
                    catch (PDOException $exception) {
                        die('ERROR: ' . $exception->getMessage());
                    }
                }
            }
        }
        ?>

        <!-- Navbar -->
        <!-- End Navbar -->
        <!-- note:py-4 control distance above the button-->
        <!-- Navbar -->
        <main class="main-content position-relative border-radius-lg ">
            <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
                <div class="container-fluid py-1 px-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Customers</a></li>
                            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Create Customer</li>
                        </ol>
                        <h3 class="font-weight-bolder text-white mb-0">Create Customer</h3>
                    </nav>
                    <?php
                    include 'hamburger.php';
                    ?>
                </div>
            </nav>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                <div class="card mb-4 mx-4">
                    <div class="card-body px-7 py-5">

                        <table class="table table-hover table-responsive">
                            <tbody>
                                <tr>
                                    <td class="text-end text-uppercase text-secondary text-sm font-weight-bolder px-3 col-1">Username</th>
                                    <td><input type='text' name='username' class='form-control col-11' value="<?php echo $username; ?>" /></td>
                                </tr>
                                <tr>
                                    <td class="text-end text-uppercase text-secondary text-sm font-weight-bolder px-3 col-1">Password</th>
                                    <td><input type='password' name='password' class='form-control' value="<?php echo $password; ?>" />
                                </tr>
                                <tr>
                                    <td class="text-end text-uppercase text-secondary text-sm font-weight-bolder px-3 col-1">Confirm Password</td>
                                    <td><input type='password' name='confirmpassword' class='form-control' value="<?php echo $confirmpassword; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end text-uppercase text-secondary text-sm font-weight-bolder px-3 col-1">Email</td>
                                    <td><input type='text' name='email' class='form-control' value="<?php echo $email; ?>" /></td>
                                </tr>
                                <tr>
                                    <td class="text-end text-uppercase text-secondary text-sm font-weight-bolder px-3 col-1">First Name</td>
                                    <td><input type='text' name='firstname' class='form-control' value="<?php echo $firstname; ?>" /></td>
                                </tr>
                                <tr>
                                    <td class="text-end text-uppercase text-secondary text-sm font-weight-bolder px-3 col-1">Last Name</td>
                                    <td><input type='text' name='lastname' class='form-control' value="<?php echo $lastname; ?>" /></td>
                                </tr>
                                <tr>
                                    <div class="<d-flex flex-row mb-3">
                                        <td class="text-end text-uppercase text-secondary text-sm font-weight-bolder px-3 col-1">Date of Birth</td>
                                        <td class="btn-group w-100">
                                            <div class="w-30 p-2">
                                                <label for="day">Day:</label>

                                                <?php
                                                $selected = isset($_POST["day"]) ? (int)$_POST["day"] : "";
                                                ?>
                                                <select name='day' class="form-control" id="day">
                                                    <option value="">--- Choose day ---</option>
                                                    <?php

                                                    for ($day = 1; $day < 31; $day++) { ?>
                                                        <option value="<?php echo $day; ?>" <?php if ($day === $selected) echo "selected"; ?>>
                                                            <?php echo $day; ?>
                                                        </option>
                                                    <?php } ?>

                                                </select>
                                            </div>

                                            <div class="w-40 p-2">
                                                <label for="month ">Month: </label>

                                                <?php
                                                // (int) to convert the posted month into integer or else it will be come a string
                                                $selected = isset($_POST["month"]) ? (int)$_POST["month"] : "";
                                                ?>
                                                <select name='month' class="form-control" id="month">
                                                    <option value="">--- Choose month ---</option>
                                                    <?php
                                                    $month = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
                                                    for ($m = 0; $m < count($month); $m++) { ?>
                                                        <option value="<?php echo $m + 1; ?>" <?php if ($m + 1 === $selected) echo "selected"; ?>>
                                                            <?php echo $month[$m]; ?>
                                                        </option>
                                                    <?php } ?>
                                                    <!--triple = :To check the data type and also the value inside. In PHP, 0 is same as '', but 0 is integer, and '' is a string, so using triple = is to differentiate them-->
                                                </select>
                                            </div>

                                            <div class="w-30 p-2">
                                                <label for="year">Year:</label>
                                                <?php
                                                $selected = isset($_POST["year"]) ? (int)$_POST["year"] : "";
                                                ?>
                                                <select name='year' class="form-control" id="year">
                                                    <option value="">--- Choose year ---</option>
                                                    <?php

                                                    for ($year = 1990; $year <= date("Y"); $year++) { ?>
                                                        <option value="<?php echo $year; ?>" <?php if ($year === $selected) echo "selected"; ?>>
                                                            <?php echo $year; ?>
                                                        </option>
                                                    <?php } ?>

                                                </select>
                                            </div>

                                        </td>
                                    </div>
                                </tr>
                                <tr>
                                    <td class="text-end text-uppercase text-secondary text-sm font-weight-bolder px-3 col-1">Gender</td>
                                    <td>
                                        <!-- must use id -->
                                        <div class="pe-1">
                                            <input class="form-check-input" type="radio" id="male" name="gender" <?php if (isset($gender) && $gender == "male") echo "checked"; ?> value="male">
                                            <label class="from-check-label" for="Radio1">

                                                Male
                                            </label>
                                        </div>
                                        <div class="pe-1">
                                            <input class="form-check-input" type="radio" id="female" name="gender" <?php if (isset($gender) && $gender == "female") echo "checked"; ?> value="female">
                                            <label class="from-check-label" for="Radio2">
                                                Female
                                            </label>
                                        </div>

                                        <div class="pe-1">
                                            <input class="form-check-input" type="radio" id="other" name="gender" <?php if (isset($gender) && $gender == "other") echo "checked"; ?> value="other">
                                            <label class="from-check-label" for="Radio3">
                                                Other
                                            </label>
                                        </div>

                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end text-uppercase text-secondary text-sm font-weight-bolder px-3 col-1">Status</td>
                                    <td>
                                        <!-- must use id -->
                                        <div class="pe-1">
                                            <input class="form-check-input" type="radio" id="active" name="status" <?php if (isset($status) && $status == "active") echo "checked"; ?> value="active">
                                            <label class="from-check-label" for="Radio1">
                                                Active
                                            </label>
                                        </div>

                                        <div class="pe-1">
                                            <input class="form-check-input" type="radio" id="deactivate" name="status" <?php if (isset($status) && $status == "deactivate") echo "checked"; ?> value="deactivate">
                                            <label class="from-check-label" for="Radio2">
                                                Deactivate
                                            </label>
                                        </div>

                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end text-uppercase text-secondary text-sm font-weight-bolder px-3 col-1">Photo (optional)</td>
                                    <td><input type="file" name="cust_image" />
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <input type='submit' value='Save' class='btn btn-primary btn bg-gradient-primary mb-0' />
                                        <a class="btn bg-gradient-dark mb-0" href="customer_read.php"><i class="fas fa-angle-left"></i>&nbsp;&nbsp;Back to Customer List</a>
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