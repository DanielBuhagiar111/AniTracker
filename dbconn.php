<?php
function connectToDb()
{
    $conn = mysqli_connect('localhost', 'root', '', 'id20799918_webapplication')
        or die("<p style='color:red;'>Error connecting to the database</p>");
    return $conn;
}

function logout()
{
    session_start();
    session_destroy();
    echo "<script>window.location.href='index.php';</script>";
}

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    logout();
}
