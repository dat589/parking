<?php
    session_start();
    unset($_SESSION['datnvSaid']);
    header('Location: login.php');
?>