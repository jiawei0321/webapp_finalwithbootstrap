<?php
function findCircleArea($radius)
{
    echo 3.14 * (int)$radius * (int)$radius;
}

function findCirclePerimeter($radius)
{
    echo 2 * 3.14 * (int)$radius;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>formCalculateAreaPerimeter</title>
</head>

<body>
    <div class="row container-fluid justify-content-center">
        <div class="col-sm-12 col-md-8 col-lg-4 mt-5">
            <div class="shadow-lg p-3 mb-5 bg-white rounded text-secondary">
                <form action="formCalculateAreaPerimeter.php" method="post">

                    <div class="form-group text-dark">
                        <label>Radius</label>
                        <input type="text" class="form-control" name="radius" placeholder="please give a number">
                    </div>
                    <div class="text-center my-4">

                        <button type="submit" class="btn btn-info text-white">Submit</button>
                    </div>
                </form>

                <div class="text-dark">
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $radius = $_POST['radius'];

                        echo "<center>";
                        echo "Area of circle = ";
                        echo findCircleArea($radius);
                        echo "<br>";
                        echo "Perimeter of circle = ";
                        echo findCirclePerimeter($radius);
                        echo "</center>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>