<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  include 'headicon.php';
  ?>
  <title>
    Customer_Detail
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
if (isset($_GET['id'])) {
  $id = $_GET['id'];
} else {
  die('ERROR: Record ID not found.');
}

// include database connection
include 'database/connection.php';
include 'function/function.php';
// read current record's data
try {
  // prepare select query

  $query = "SELECT username, email, firstname, lastname, gender, dob, cust_image FROM customers WHERE customer_id = ? LIMIT 0,1";
  //$query = "SELECT id, name, description, price FROM products WHERE id = :id "; find the same id from database n key in
  $stmt = $con->prepare($query);

  // this is the first question mark
  //$stmt->bindParam(1, $id);
  $stmt->bindParam(1, $id);

  // execute our query
  $stmt->execute();

  // store retrieved row to a variable
  //only call 1 product no need while loop
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  // values to fill up our form
  $username = $row['username'];
  $email = $row['email'];
  $firstname = $row['firstname'];
  $lastname = $row['lastname'];
  $cust_image = $row['cust_image'];

  //create new date time chai chu lai
  //$query = "SELECT*, YEAR(dob) as year, MONTH(dob) as month, DAY(dob) as day,FROM customers ~~ (write like this also can or below 4 line)
  $dob = new DateTime($row['dob']);
  $year = $dob->format('Y');
  $month = $dob->format('m');
  $day = $dob->format('d');
  $animal = $year % 12;
}

// show error
catch (PDOException $exception) {
  die('ERROR: ' . $exception->getMessage());
}
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
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Customers</a></li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Customer Details</li>
          </ol>
          <h3 class="font-weight-bolder text-white mb-0">Customer Details</h3>
        </nav>
        <!--<div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
        </div>-->
      </div>
    </nav>
    <!-- End Navbar -->
    <!-- note:py-4 control distance above the button-->
    <div class="container-fluid py-4">
      <div class="col-12 text-start pb-4">
        <a class="btn bg-gradient-dark mb-0" href="customer_read.php"><i class="fas fa-angle-left"></i>&nbsp;&nbsp;Back to Customer List</a>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Customer Details table</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">

                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Username</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Profile Image</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Firstname</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Lastname</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Gender</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Horoscope</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Zodiac</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr>
                      <td>
                        <div class="d-flex px-4 py-3">
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><?php echo htmlspecialchars($username, ENT_QUOTES);  ?></h6>
                          </div>
                        </div>

                      </td>
                      <td>
                        <div class='d-flex px-2 py-3'>
                          <div>
                            <?php
                            //$image = htmlspecialchars($row['image'], ENT_QUOTES);
                            if ($cust_image == "") {
                              echo "<img src ='uploads/default_profile_image.jpg' class='rounded' width='80px' height='80px'>";
                            } else {
                              echo "<img src ='uploads/{$cust_image}' class='avatar' width='100px' height='100px'>";
                            }
                            ?>
                      </td>

                      <td class="align-middle text-center text-sm">
                        <span class="text-secondary text-s font-weight-bold"><?php echo htmlspecialchars($email, ENT_QUOTES);  ?></span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-s font-weight-bold"><?php echo htmlspecialchars($firstname, ENT_QUOTES);  ?></span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-s font-weight-bold"><?php echo htmlspecialchars($lastname, ENT_QUOTES);  ?></span>
                      </td>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-s font-weight-bold">
                          <?php
                          extract($row);
                          checkgender($gender);
                          ?></span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-s font-weight-bold">
                          <?php starsign($month, $day);
                          ?></span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-s font-weight-bold">
                          <?php //zodiac
                          $animal_c = array("Monkey", "Chicken", "Dog", "Pig", "Mouse", "Cow", "Tiger", "Rabbit", "Dragon", "Snake", "Horse", "Goat");
                          echo htmlspecialchars($animal_c[$animal], ENT_QUOTES);  
                          ?></span>
                      </td>

                      <!--//</tr>
                  //</tbody>-->
                </table>
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