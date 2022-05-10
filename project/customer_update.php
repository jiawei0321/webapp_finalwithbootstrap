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
        Update_Customer_Info
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
                            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Customers</a></li>
                            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Update Customer Info</li>
                        </ol>
                        <h3 class="font-weight-bolder text-white mb-0">Update Customer Info</h3>
                    </nav>
                    <?php
                    include 'hamburger.php';
                    ?>
                </div>
            </nav>
            <?php
            // get passed parameter value, in this case, the record ID
            // isset() is a PHP function used to verify if a value is there or not
            $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

            //include database connection
            include 'database/connection.php';
            include 'function/function.php';
            if (!isset($_SESSION['username'])) {
                header("Location: index.php?action=nologin");
                //go to the first page if the person didnt log in
              }

            if (!$_POST) {
                // read current record's data

                try {
                    // prepare select query
                    $query = "SELECT username, password, email, firstname, lastname, YEAR(dob) as year, MONTH(dob) as month, DAY(dob) as day, gender, status FROM customers WHERE customer_id = ? ";
                    $stmt = $con->prepare($query);

                    // this is the first question mark
                    $stmt->bindParam(1, $id);

                    // execute our query
                    $stmt->execute();

                    // store retrieved row to a variable
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    // values to fill up our form

                    $username = $row['username'];
                    $password = $row['password'];
                    $confirmpassword = $row['password'];
                    $email = $row['email'];
                    $firstname = $row['firstname'];
                    $lastname = $row['lastname'];
                    $yy = $row['year'];
                    $mm = $row['month'];
                    $dd = $row['day'];
                    $gender = isset($row['gender']) ? $row['gender'] : "";
                    $status = isset($row['status']) ? $row['status'] : "";
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

                // posted values
                $username = htmlspecialchars(strip_tags($_POST['username']));
                $password = htmlspecialchars(strip_tags($_POST['password']));
                $confirmpassword = htmlspecialchars(strip_tags($_POST['password']));
                $email = htmlspecialchars(strip_tags($_POST['email']));
                $firstname = htmlspecialchars(strip_tags($_POST['firstname']));
                $lastname = htmlspecialchars(strip_tags($_POST['lastname']));
                $dob = htmlspecialchars(strip_tags($_POST['year'])) . "-" . htmlspecialchars(strip_tags($_POST['month'])) . "-" . htmlspecialchars(strip_tags($_POST['day']));
                $gender = htmlspecialchars(strip_tags($_POST['gender']));
                $status = htmlspecialchars(strip_tags($_POST['status']));
                $age = (int)date('Y') - (int)$_POST['year'];
                $error = "";

                if (empty($_POST['username']) || empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['gender']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['confirmpassword']) || empty($_POST['status'])) {
                    $error = $error . "<div class='alert alert-danger alert-dismissible fade show' role='alert'><p class='text-white mb-0'>Please fill in all the information.</p></div>";
                }

                //Starting ^,And end $, in the string there has to be at least 1 number(?=.*\d), and at least one letter(?=.*[A-Za-z])and it has to be a number, a letter or one of the following: !@#$% -> [0-9A-Za-z!@#$%]and there have to be 8-12 characters -> {6,15} '/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{6,15}$/'
                //if match these continue, if not, go error.
                if (!preg_match('/^[a-zA-Z0-9]{6,}$/', $username) && !preg_match('/^(?!.* )$/', $username)) {
                    $error = $error . "<div class='alert alert-danger alert-dismissible fade show' role='alert'><p class='text-white mb-0'>Username must not contain space with minimum 6 characters.</p></div>";
                }

                if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{6,}$/', $password)) {
                    $error = $error . "<div class='alert alert-danger alert-dismissible fade show' role='alert'><p class='text-white mb-0'>Password must be minimum 6 characters, contain at least a number, a capital letter and a small letter.</p></div>";
                }

                if ($password  != $confirmpassword) {
                    $error = $error . "<div class='alert alert-danger alert-dismissible fade show' role='alert'><p class='text-white mb-0'>Password and confirm password does not match.</p></div>";
                }

                if ($age <= 18) {
                    $error = $error . "<div class='alert alert-danger alert-dismissible fade show' role='alert'><p class='text-white mb-0'>Customer must be above 18 years old.</p></div>";
                }

                $query = "SELECT username FROM customers WHERE username=?";
                $stmt = $con->prepare($query);
                $stmt->execute();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $name[] = $row;
                    if ($username == $name['username']) {
                        $error = $error . "<div class='alert alert-danger alert-dismissible fade show' role='alert'><p class='text-white mb-0'>Username had been used.</p></div>";
                    }
                }
                echo $error;

                if ($error == "") {
                    try {
                        $password = md5($_POST['password']);
                        $confirmpassword = md5($_POST['confirmpassword']);
                        // write update query
                        // in this case, it seemed like we have so many fields to pass and
                        // it is better to label them and not use question marks
                        $query = "UPDATE customers SET 
                            username=:username, 
                            password=:password,
                            email=:email,
                            firstname=:firstname, 
                            lastname=:lastname,
                            dob = :dob,
                            status=:status,
                            gender=:gender WHERE customer_id = :customer_id";

                        // prepare query for excecution
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
                        $stmt->bindParam(':customer_id', $id);

                        // Execute the query
                        if ($stmt->execute()) {
                            header('Location: customer_read.php?action=saved');
                            //echo "<div class='alert alert-success'>Record was updated.</div>";
                        }
                    }
                    // show errors
                    catch (PDOException $exception) {
                        die('ERROR: ' . $exception->getMessage());
                    }
                }
            }
            ?>

            <?php
            include 'nav.php';
            ?>
            <div class="card mb-4">
                <div class="card-body px-7 py-5">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="post">
                        <table class='table table-hover table-responsive'>
                            <tbody>
                                <tr>
                                    <td class="text-end text-uppercase text-secondary text-sm font-weight-bolder px-3 col-1">Username</th>
                                    <td><input type='text' name='username' class='form-control col-11' value="<?php echo htmlspecialchars($username, ENT_QUOTES); ?>" /></td>
                                </tr>
                                <tr>
                                    <td class="text-end text-uppercase text-secondary text-sm font-weight-bolder px-3 col-1">Password</th>
                                    <td><input type='password' name='password' class='form-control' />
                                </tr>
                                <tr>
                                    <td class="text-end text-uppercase text-secondary text-sm font-weight-bolder px-3 col-1">Confirm Password</td>
                                    <td><input type='password' name='confirmpassword' class='form-control' /></td>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end text-uppercase text-secondary text-sm font-weight-bolder px-3 col-1">Email</td>
                                    <td><input type='text' name='email' value="<?php echo htmlspecialchars($email, ENT_QUOTES); ?>" class='form-control' />
                                </tr>
                                <tr>
                                    <td class="text-end text-uppercase text-secondary text-sm font-weight-bolder px-3 col-1">First Name</td>
                                    <td><input type='text' name='firstname' value="<?php echo htmlspecialchars($firstname, ENT_QUOTES); ?>" class='form-control' />
                                </tr>
                                <tr>
                                    <td class="text-end text-uppercase text-secondary text-sm font-weight-bolder px-3 col-1">Last Name</td>
                                    <td><input type='text' name='lastname' value="<?php echo htmlspecialchars($lastname, ENT_QUOTES); ?>" class='form-control' />
                                </tr>
                                <tr>

                                    <div class="<d-flex flex-row mb-3">
                                        <td class="text-end text-uppercase text-secondary text-sm font-weight-bolder px-3 col-1">Date of Birth</td>
                                        <td class="btn-group w-100">
                                            <div class="w-30 p-2">
                                                <label for="day">Day:</label>

                                                <?php

                                                $selected = isset($_POST["day"]) ? (int)$_POST["day"] : "$dd";

                                                ?>
                                                <select name='day' class="form-control" id="day">
                                                    <option value="">--- Choose day ---</option>
                                                    <?php

                                                    for ($day = 1; $day < 31; $day++) { ?>
                                                        <option value="<?php echo $day ?>" <?php if ($day == $selected) echo "selected"; ?>>
                                                            <?php echo $day; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="w-40 p-2">
                                                <label for="month ">Month: </label>

                                                <?php
                                                // (int) to convert the posted month into integer or else it will be come a string
                                                $selected = isset($_POST["month"]) ? (int)$_POST["month"] : "$mm";

                                                ?>
                                                <select name='month' class="form-control" id="month">
                                                    <option value="">--- Choose month ---</option>
                                                    <?php
                                                    $month = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
                                                    for ($m = 0; $m < count($month); $m++) { ?>
                                                        <option value="<?php echo $m + 1; ?>" <?php if ($m + 1 == $selected) echo "selected"; ?>>
                                                            <?php echo $month[$m]; ?>
                                                        </option>
                                                    <?php } ?>
                                                    <!--triple = :To check the data type and also the value inside. In PHP, 0 is same as '', but 0 is integer, and '' is a string, so using triple = is to differentiate them-->
                                                </select>
                                            </div>
                                            <div class="w-30 p-2">
                                                <label for="year">Year:</label>
                                                <?php
                                                $selected = isset($_POST["year"]) ? (int)$_POST["year"] : "$yy";
                                                ?>
                                                <select name='year' class="form-control" id="year">
                                                    <option value="">--- Choose year ---</option>
                                                    <?php

                                                    for ($year = 1990; $year <= date("Y"); $year++) { ?>
                                                        <option value="<?php echo $year; ?>" <?php if ($year == $selected) echo "selected"; ?>>
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
                                    <td></td>
                                    <td>
                                        <input type='submit' value='Save Changes' class='btn btn-primary btn bg-gradient-primary mb-0' />
                                        <a class="btn bg-gradient-dark mb-0" href="customer_read.php"><i class="fas fa-angle-left"></i>&nbsp;&nbsp;Back to Customer List</a>
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