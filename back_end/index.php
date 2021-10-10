<?php
    include 'db_connect.php';
    include 'getairlines.php';
    include 'viewAirlines.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=<<, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $airlines = new viewUser();
        $airlines->showAirlines()
    ?>
</body>
</html>