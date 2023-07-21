<?php
    session_start();

    spl_autoload_register(function ($class){
        require __DIR__ . "/src/$class.php";
    });

    $conn = new Database();
    $vehicle = new Control($conn);

    $price = $vehicle->getFee();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Price list</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
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
                                <li class="active">Price list</li>
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
                            <strong class="card-title">View Price List</strong>
                        </div>
                        <div class="card-body">
                            <table border="1" class="table table-bordered mg-b-0">
                                <tr>
                                    <th>In the first 2h</th>
                                    <td><?= number_format($price[1],0,',','.') ?> VND/time</td>
                                </tr>
                                <tr>
                                    <th>The next 24h</th>
                                    <td><?= number_format($price[2],0,',','.') ?> VND/hour</td>
                                </tr>
                                <tr>
                                    <th>Over the next 24h</th>
                                    <td><?= number_format($price[3],0,',','.') ?> VND/12 hours</td>
                                </tr>
                                <tr>
                                    <th rowspan="2">Monthly ticket</th>
                                    <td><?= number_format($price[4],0,',','.') ?> VND/car/month</td>
                                </tr>
                                <tr>
                                    <td><?= number_format($price[5],0,',','.') ?> VND/car/3 months</td>
                                </tr>
                                <tr>
                                    <th>Apply from the date</th>
                                    <td><?= $price[6] ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- <div class="col-lg-12">
                        <form action="" method="post">
                            <p style="color:red; text-align:center;"><?php if(isset($info)) echo $info; ?></p>
                            <button type="submit" class="btn btn-primary btn-block" name="submit">Change Price</button>
                        </form>
                    </div> -->

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
</body>

</html>