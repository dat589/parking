<?php
    session_start();
    spl_autoload_register(function ($class) {
        require __DIR__ . "/src/$class.php";
    });

    $conn = new Database();
    $vehicle = new Control($conn);

    $thisTime = $vehicle->addMonth(0);
    $out = $vehicle->getOutgoing($thisTime);
    $field = $vehicle->fieldMonth();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parked Car</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</head>

<body>
    <?php
        if(isset($_SESSION['datnvSaid'])):
        include_once('assets/includes/sidebar.php');
        include_once('assets/includes/header.php');
    ?>

        <div class="breadcrumbs">
            <div class="breadcrumbs-inner">
                <div class="row m-0">
                    <div class="col-sm-4">
                        <div class="page-header float-left">
                            <div class="page-title">
                                <h1>Dashboard</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="page-header float-right">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="index.php">Dashboard</a></li>
                                    <li><a href="outgoing-vehicle.php">Manage Vehicle</a></li>
                                    <li class="active">Manage Outgoing Vehicle</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <!-- <strong class="card-title">Outgoing Vehicle</strong> -->
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect01">
                                            <strong>Outgoing Vehicle of Month</strong>
                                        </label>
                                    </div>
                                    <select class="custom-select" id="selectMonth" onchange="Outgoing()">
                                        <?php while($eachField = $field->fetch_array()){ ?>
                                            <option value="<?= $eachField[0] ?>" <?php if($eachField[0] == $thisTime) echo 'selected' ?>>
                                                <?= $eachField[0] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Number Plate</th>
                                            <th>Parking.No</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="outGoingBody">
                                        <?php
                                            $count = 1;
                                            while ($row = $out->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td><?php echo $count; ?></td>
                                            <td><?php echo $vehicle->viewPlate($row['number_plate']); ?></td>
                                            <td style="padding-left:45px"><?php echo $row['parking_number']; ?></td>
                                            <td>
                                                <a href="view-outgoingvehicle.php?viewId=<?php echo $row['id']; ?>">View</a> | 
                                                <a href="print.php?vid=<?php echo $row['id']; ?>" style="cursor:pointer" target="_blank">Print</a>
                                            </td>
                                        </tr>
                                        <?php
                                            $count ++;
                                        } ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>

                </div>
            </div><!-- .animated -->
        </div><!-- .content -->

        <div class="clearfix"></div>

    <?php
        include_once('assets/includes/footer.php');
        else: echo "<script>window.location = 'login.php'</script>";
        endif;
    ?>

    <!-- Script -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script>
        function Outgoing(){
            let month = document.getElementById('selectMonth').value;
            // console.log(month);
            $.ajax({
                url: 'assets/ajax/outgoing.php',
                type: 'POST',
                data: {
                    month_data: month
                },
                success: function(result){
                    $('#outGoingBody').html(result)
                }
            })
        }
    </script>
</body>

</html>