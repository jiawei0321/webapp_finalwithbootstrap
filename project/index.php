<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/shopfavicon.png">
  <title>
    Login
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
</head>
<?php
include 'database/connection.php';


// if it was redirected from delete.php
$action = isset($_GET['action']) ? $_GET['action'] : "";
// if it was redirected from delete.php
if ($action == 'nologin') {
  echo "<div class='container pt-3'>";
  echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'><p class='text-white mb-0'>Please log in first to browse the website.</p></div>";
  echo "</div>";
}
if ($action == 'nonavsignin') {
  echo "<div class='container pt-3'>";
  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'><p class='text-white mb-0'><strong>You have created an account.</strong> Log In to start shopping.</p></div>";
  echo "</div>";
}

//if submit button is pressed only do these
if ($_POST) {

  if (empty($_POST['username']) || empty($_POST['password'])) {
    echo "<div class='container pt-3'>";
    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'><p class='text-white mb-0'>Please fill in username and password.</p></div>";
    echo "</div>";
  } else {
    $username = $_POST['username'];
    $password = $_POST['password'];

    /*if (!preg_match('/^((?:\s*[A-Za-z]\s*){6,})$/', $username)) {
                    echo "<div class='alert alert-danger'>Username must not contain space with minimum 6 characters</div>";
                } else if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z]{6,}$/', $password)) {
                    echo "<div class='alert alert-danger'>Password must be minimum 6 characters, contain at least a number, a capital letter and a small letter</div>";
                }else{*/
    // include database connection

    // delete message prompt will be here

    $query = "SELECT username, password, status FROM customers WHERE username = ?";
    // prepare query for execution
    $stmt = $con->prepare($query);
    $stmt->bindParam('1', $username);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $num = $stmt->rowCount();

    if ($num == 0) {
      //echo "<div class='alert alert-danger' role='alert'>User not found.</div>";
      echo "<div class='container pt-3'>";
      echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'><p class='text-white mb-0'><strong>Oh No! </strong> User not found.</p></div>";
      echo "</div>";

    } else if ($_POST['password'] != $password) {
      echo "<div class='container pt-3'>";
      echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'><p class='text-white mb-0'><strong>Try Again! </strong>Password is incorrect.</p></div>";
      echo "</div>";
    } else if ($row['status'] != "active") {
      echo "<div class='container pt-3'>";
      echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'><p class='text-white mb-0'>This account is disabled.</p></div>";
      echo "</div>";
    } else {
      // Set session variables
      $_SESSION["username"] = $_POST['username'];
      header("Location:welcome.php");
    }
    //}
  }
}

?>

<body>
  <main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
              <div class="card card-plain">
                <div class="card-header pb-0 text-start">
                  <h4 class="font-weight-bolder">Log In</h4>
                  <p class="mb-0">Enter your username and password to log in</p>
                </div>
                <div class="card-body">
                  <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
                    <div class="mb-3">
                      <label for="inputUsername" class="sr-only">Username</label>
                      <input type="username" id="inputUsername" name="username" class="form-control form-control-lg" placeholder="Username" aria-label="username">
                    </div>
                    <div class="mb-3">
                      <label for="inputPassword" class="sr-only">Password</label>
                      <input type="password" id="inputPassword" name="password" class="form-control form-control-lg" placeholder="Password" aria-label="password">
                    </div>
                    <!-- <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="rememberMe">
                      <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div>-->
                    <div class="text-center">
                      <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Log in</button>
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  <p class="mb-4 text-sm mx-auto">
                    Don't have an account?
                    <a href="nonav_customer_create.php" class="text-primary text-gradient font-weight-bold">Create a customer account</a>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
              <!--<div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden" 
              style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signin-ill.jpg'); background-size: cover;">-->
           <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden" style="background-image: url('../project/assets/img/indexpic.jpg'); background-size: cover;">
                <span class="mask bg-gradient-primary opacity-6"></span>
                <h4 class="mt-5 text-white font-weight-bolder position-relative">"Good quality product at affordable price"</h4>
                <p class="text-white position-relative">Start Shopping on JW shop.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
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