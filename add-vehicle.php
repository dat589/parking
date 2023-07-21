<?php
    session_start();
    spl_autoload_register(function ($class){
        require __DIR__ . "/src/$class.php";
    });

    $conn = new Database();
    $vehicle = new Control($conn);

    $parking_place = $vehicle->getAllPlace();

    if(isset($_GET['park'])) $isPark = true;
    else $isPark = false;

    if($_SERVER["REQUEST_METHOD"] === "POST"){
        if(empty($_POST['numPlate']) || !isset($_POST['parkingNum'])) $info = "Invalid Value!";
        else{
            $numPlate = $vehicle->changePlate($_POST['numPlate']);

            if($vehicle->isParked($numPlate))
                $info = $_POST['numPlate']." is being parked in the parking lot!";
            else{
                $run = $vehicle->addVehicle($numPlate,$_POST['parkingNum']);

                if($run) header('Location: view-incomingvehicle.php?viewId='.$run);
                else $info = "Something went wrong!";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Vehicle</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
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
                                    <li><a href="add-vehicle.php">Vehicle</a></li>
                                    <li class="active">Add Vehicle</li>
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
                    <div class="col-lg-6">
                        <div class="card">
                            
                        </div> <!-- .card -->

                    </div><!--/.col-->

                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header"> <strong>Add</strong> Vehicle </div>
                            <div class="card-body card-block">
                                <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                    <p style="font-size:16px; color:red" align="center">
                                        <?php if(isset($info)) echo $info ?>
                                    </p>

                                    <div class="row form-group">
                                        <div class="col col-md-3"><label for="text-input" class=" form-control-label">Number Plate</label></div>
                                        <div class="col-12 col-md-9"><input type="text" id="vehcomp" name="numPlate" class="form-control" placeholder="Number Plate"></div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col col-md-3"><label for="select" class=" form-control-label">Parking Number</label></div>
                                        <div class="col-12 col-md-9">
                                            <select name="parkingNum" id="catename" class="form-control">
                                                <option value="0" disabled <?php if(!$isPark) echo 'selected' ?>>--Choose--</option>
                                                <?php while($row = $parking_place->fetch_assoc()) { ?>
                                                    <option value="<?php echo $row['parking_number']; ?>" <?php if($isPark && $_GET['park'] == $row['parking_number']) echo 'selected' ?>>
                                                        <?php echo $row['parking_number']; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <p style="text-align: center;"> <button type="submit" class="btn btn-primary btn-sm" name="submit">Add</button></p>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6"></div>
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
</body>

</html>