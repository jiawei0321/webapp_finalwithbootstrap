<!DOCTYPE html>
<html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<title>Q2 date</title>

<body>

    <div class="container mt-5">
        <div class="row text-center">
            <!--1st calendar-->
            <div class="col">
                <div class="row justify-content-center">
                    <div class="col-sm-12 col-md-8 col-lg-4">
                        <div class="display-2">
                            <?php
                            echo "<strong>";
                            echo date("d");
                            echo "</strong>";
                            ?>
                        </div>
                        <div class="border-top border-dark text-center pb-1">
                            <div class="h6 text-uppercase d-inline">
                                <?php
                                echo date("M Y");
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>



            <!--2st calendar-->
            <div class="col ">
                <div class="row justify-content-center">
                    <div class="col-sm-12 col-md-8 col-lg-4">
                        <div class="border border-dark border-2 border-bottom-0">
                            <div class="display-2">
                                <?php
                                echo "<strong>";
                                echo date("d");
                                echo "</strong>";
                                ?>
                            </div>
                        </div>
                        <div class="h6 text-uppercase border bg-dark text-white p-1">
                            <?php
                            echo date("M Y");
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <!--3rd calendar-->
            <div class="col">
                <div class="row justify-content-center">
                    <div class="col-sm-12 col-md-8 col-lg-4 d-flex">
                        <div class="display-2">
                            <?php
                            echo "<strong>";
                            echo date("d");
                            echo "</strong>";
                            ?>
                        </div>

                        <div class="h6 text-uppercase pt-3">
                            <?php
                            echo "<strong>";
                            echo date("M");
                            echo "<br>";
                            echo date("Y");
                            echo "</strong>";
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
</body>

</html>