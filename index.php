<?php
    session_start();
    spl_autoload_register(function ($class) {
        require __DIR__ . "/src/$class.php";
    });

    $conn = new Database();
    $vehicle = new Control($conn);

    $getClass = $vehicle->getClass();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Parking System</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">

</head>

<body>
    <?php if(isset($_SESSION['datnvSaid'])):
        include_once('assets/includes/sidebar.php');
        include_once('assets/includes/header.php');
    ?>

        <div class="content">
            <!-- Animated -->
            <div class="animated fadeIn">
                <!-- Widgets  -->
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-1">
                                        <i class="pe-7s-car"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="text-left dib">
                                            <div class="stat-text"><span class="count"><?= $vehicle->todayEntries() ?></span></div>
                                            <div class="stat-heading">Todays Vehicle Entries</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-2">
                                        <i class="pe-7s-car"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="text-left dib">
                                            <div class="stat-text"><span class="count"><?= $vehicle->yesterdayEntries() ?></span></div>
                                            <div class="stat-heading">Yesterdays Vehicle Entries</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-3">
                                        <i class="pe-7s-car"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="text-left dib">
                                            <div class="stat-text"><span class="count"><?= $vehicle->last7dayEntries() ?></span></div>
                                            <div class="stat-heading">Last 7 days Vehicle Entries</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-4">
                                        <i class="pe-7s-car"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="text-left dib">
                                            <div class="stat-text"><span class="count"><?= $vehicle->totalEntries() ?></span></div>
                                            <div class="stat-heading">Total Vehicle Entries</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Widgets -->

            </div>
            <!-- .animated -->
            <div class="container-flex  bg-white">
                <div class="main-info">
                    <h5>Available Parking Lot:
                        <strong><?= $vehicle->availableSlot() ?></strong>/<strong><?= $vehicle->totalSlot() ?></strong>
                    </h5>
                </div>

                <?php while ($numClass = $getClass->fetch_array()) :
                    $slots = $vehicle->getSlot($numClass[0]) ?>
                    <div class="d-flex justify-content-center flex-wrap">

                        <?php while ($row = $slots->fetch_assoc()) {
                            if ($row['status'] == 0) : ?>
                                <div class="link">
                                    <a href="add-vehicle.php?park=<?= $row['parking_number'] ?>">
                                        <?= $row['parking_number'] ?>
                                    </a>
                                </div>
                            <?php else :
                                $viewId = $vehicle->getLink($row['parking_number']); ?>
                                <div class="link active">
                                    <a href="view-incomingvehicle.php?viewId=<?= $viewId ?>" title="<?= $vehicle->viewPlate($row['number_plate']) ?>">
                                        <?= $row['parking_number'] ?>
                                    </a>
                                </div>
                            <?php endif;
                        } ?>
                    </div>
                <?php endwhile; ?>

            </div>
        </div>

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
</body>

</html>