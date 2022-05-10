<!DOCTYPE html>
<html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<title>Q3 loop</title>

<body>
    <div class="row container-fluid justify-content-center">
        <div class="col-sm-12 col-lg-4 mt-5">
            <div class="shadow p-5 border border-secondary border-4 rounded text-secondary">

                <div class=" d-flex aligns-items-center justify-content-center">


                    <form>
                        <!--day-->

                        <!--default select, -->
                        <div class="dropdown w-100">

                            <div class="w-20 p-2">
                                <p class="fw-bold text-secondary">
                                    <label for="day">Day:</label>
                                </p>
                                <select name='day' class="form-control" id="day">

                                    <?php
                                    $selected_day = date('d');

                                    for ($i_day = 1; $i_day <= 31; $i_day++) {
                                        $selected = ($selected_day == $i_day ? ' selected' : '');

                                        echo '<option value="' . $i_day . '"' . $selected . '>' . $i_day . '</option>' . "\n";
                                    }
                                    ?>


                                </select>
                            </div>

                            <!--month-->
                            <div class="w-20 p-2">
                                <p class="fw-bold text-secondary">
                                    <label for="day">Month:</label>
                                </p>
                                <select name='month' class="form-control" id="month">

                                    <?php
                                    $selected_month = date('m');

                                    for ($i_month = 1; $i_month <= 12; $i_month++) {
                                        $selected = ($selected_month == $i_month ? ' selected' : '');
                                        echo '<option value="' . $i_month . '"' . $selected . '>' . date('F', mktime(0, 0, 0, $i_month)) . '</option>' . "\n";
                                    }
                                    ?>


                                </select>
                            </div>



                            <!--year-->
                            <div class="w-20 p-2">
                                <p class="fw-bold text-secondary">
                                    <label for="day">Year:</label>
                                </p>
                                <select name='year' class="form-control" id="year">

                                    <?php
                                    $year_start  = 2022;
                                    $year_end = date('Y'); // current Year
                                    $user_selected_year = 2022;

                                    for ($i_year = $year_start; $i_year >= 2010; $i_year--) {
                                        $selected = ($user_selected_year == $i_year ? ' selected' : '');

                                        echo '<option value="' . $i_year . '"' . $selected . '>' . $i_year . '</option>' . "\n";
                                    }
                                    ?>


                                </select>
                            </div>


                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>