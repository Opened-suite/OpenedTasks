<?php
session_start();


$role = $_SESSION['role'];


if(!isset($_SESSION['pseudo'])){
    header('Location: /index.php');
    die();
}


?>


<!DOCTYPE html>
<html>
<head>
    <title>Liste de Tâches</title>
    <link rel="stylesheet" href="style.css">
    

</head>
<body>

<nav class="nav">
        <div class="container">
            <div class="logo">
                <a href="#">OpenedTasks</a>
            </div>
            <div id="mainListDiv" class="main_list">
                <ul class="navlinks">
                    <li><a href="#">My Account</a></li>
                    <li><a href="#">Calendar</a></li>
                    <li><a href="tasks/index.php">Tasks</a></li>
                    <?php if ($role == "Admin") {
                        echo '<li><a href="adminpanel/index.php">Admin PANEL</a></li>';
                    }
                    if ($role == null) {
                        echo '<li><a href="tasks/">User PANEL</a></li>';
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


<section>
    <div class="container">
        <h1>Welcome <?php echo $_SESSION['pseudo'] ?> to your User Panel</h1>
        <p>Here you can manage your tasks</p>
    </div>
</section>



   
    
</body>
</html>
<style>
