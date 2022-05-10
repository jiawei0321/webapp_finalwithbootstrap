<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>findCircleArea</title>
</head>

<body>

    <div class="row container-fluid justify-content-center">
        <div class="col-sm-12 col-md-8 col-lg-4 mt-5">
            <div class="shadow-lg p-3 mb-5 bg-white rounded text-secondary">

                    <?php
                    $radius = 2;

                    function findCircleArea($radius)
                    {
                        echo 3.14 * $radius * $radius;
                    }
                    echo "<center>";
                    echo "Area of circle = ";
                    echo findCircleArea($radius);
                    echo "</center>";

                    ?>
            </div>
        </div>
    </div>
</body>

</html>