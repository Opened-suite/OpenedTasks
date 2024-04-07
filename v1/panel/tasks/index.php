<?php
session_start();


$role = $_SESSION['role'];


if(!isset($_SESSION['pseudo'])){
    header('Location:index.php');
    die();
}
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "openedtasks";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$reqnb = $conn->exec("SELECT COUNT(*) FROM task_list");

$nbtask = $reqnb;


?>


<!DOCTYPE html>
<html>
<head>
    <title>Liste de Tâches</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
    <style></style>
    

</head>
<body>

<nav class="nav">
    <div class="logo">
        <a href="#">PANEL</a>
    </div>
        <div class="container">
            <div id="mainListDiv" class="main_list">
                <ul class="navlinks">
                    <li><a href="#">My Account</a></li>
                    <li><a href="#">Information</a></li>
                    <li><a href="tasks/index.php">Tasks</a></li>
                    <?php if ($role == "Admin") {
                        echo '<li><a href="/adminpanel/index.php">Admin PANEL</a></li>';
                    }
                    if ($role == null) {
                        echo '<li><a href="/userpanel/index.php">User PANEL</a></li>';
                    }
                        ?>
                    
                </ul>
            </div>
            <span class="navTrigger">
                <i></i>
                <i></i>
                <i></i>
            </span>
    </div>
</nav>








  
</div>



    <span style="font-size:30px;cursor:pointer" onclick="openNav()" position="fixed" top="10px" left="10px">&#9776; </span>

<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}
</script>

<?php
include "taskforeach.php";
?>


<article>

    </article>
