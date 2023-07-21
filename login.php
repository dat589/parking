<?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        session_start();
        spl_autoload_register(function ($class){
            require __DIR__ . "/src/$class.php";
        });
        
        $conn = new Database();
        $vehicle = new Control($conn);

        if(empty($_POST['username']) || empty($_POST['password'])) $err = "Invalid Values!";
        else{
            $result = $vehicle->login($_POST['username'], $_POST['password']);
            if($result){
                $_SESSION['datnvSaid'] = $result['id'];
                header('Location: index.php');
            }
            else $err = "Not Match!";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="bg-dark">
    <div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <div class="login-logo">
                    <h2>Parking System</h2>
                </div>

                <div class="login-form">
                    <form method="post">
                        <p style="font-size:16px; color:red" align="center">
                            <?php if(isset($err)) echo $err; ?>
                        </p>

                        <div class="form-group">
                            <label>User Name</label>
                            <input class="form-control" type="text" name="username" value="<?= isset($_POST['username']) ? $_POST['username'] : '' ?>">
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password">
                        </div>

                        <div class="checkbox">
                            <label class="full-right">
                                <a href="forgot-password.php" style="color: black;">Forgotten Password?</a>
                            </label>
                        </div>

                        <button type="submit" name="login" class="btn btn-primary btn-lg btn-block">Sign in</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>