<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php
    $numbers = array("34", "4", "5", "-23", "45", "100");
    ?>
    <div class="container mt-5">
        <div class="row text-center">
            <?php
            for ($i = 0; $i <= count($numbers) - 1; $i++) {
            ?>
                <div class="col">
                    <div class="row justify-content-center">
                        <div class="col-4 numberCircle border border-5 border-primary">
                            <p class="fs-5 text-primary">
                                <?php
                                
                                echo $numbers[$i];
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>

    <?php
    $numbers = array("34", "4", "5", "-23", "45", "100");
    $temp = $numbers[0];
    $numbers[0] = $numbers[4];
    $numbers[4] = $temp;
    ?>

    <div class="container mt-5">
    <div class="row text-center">
        <?php
        for ($i = 0; $i <= count($numbers) - 1; $i++) {
        ?>
            <div class="col">
                <div class="row justify-content-center">
                    <div class="col-4 numberCircle border border-5 border-success">
                        <p class="fs-5 text-success">
                            <?php
                            echo $numbers[$i];
                            ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>

</body>

</html>