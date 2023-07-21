<?php
    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        spl_autoload_register(function ($class){
            require __DIR__ . "/src/$class.php";
        });
    
        $conn = new Database();
        $vehicle = new Control($conn);
        $car = $vehicle->getVehicle($_GET['vid']);

        $status = $car['status'];
        $isMember = $vehicle->isMember($car['number_plate']);
    }
    else header('Location: login.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
</head>

<body>
    <div class="around">
        <div class="wrapper">
            <h1>Vehicle Parking Receipt</h1>

            <table border="1" class="table table-bordered mg-b-3">
                <tr>
                    <th>Number Plate</th>
                    <td><?= $car['number_plate'] ?></td>
                </tr>
                <tr>
                    <th>Parking Number</th>
                    <td><?= $car['parking_number'] ?></td>
                </tr>
                <tr>
                    <th>In Time</th>
                    <td><?= $car['in_time'] ?></td>
                </tr>
                <?php if($status == 0): ?>
                    <tr>
                        <th>Member</th>
                        <td><?php if($isMember) echo "Yes"; else echo "No" ?></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>Vehicle In</td>
                    </tr>
                <?php endif; ?>

                <?php if($status == 1): $diff = $vehicle->dateDiff($car['in_time'], $car['out_time']);?>
                    <tr>
                        <th>Out Time</th>
                        <td><?= $car['out_time'] ?></td>
                    </tr>
                    <tr>
                        <th>Period</th>
                        <td><?= $diff ?></td>
                    </tr>
                    <tr>
                        <th>Member</th>
                        <td><?php if(! $isMember) echo "No"; elseif($isMember == 1) echo "Yes"; else echo "No (Out of member)" ?></td>
                    </tr>
                    <tr>
                        <th>Parking Fee</th>
                        <td><?= number_format($car['parking_fee'],0,',','.') ?> VND</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</body>

</html>