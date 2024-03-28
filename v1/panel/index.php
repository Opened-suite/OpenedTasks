<?php
session_start();


$role = $_SESSION['role'];


if(!isset($_SESSION['pseudo'])){
    header('Location:index.php');
    die();
}


?>


<!DOCTYPE html>
<html>
<head>
    <title>Liste de Tâches</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
    

</head>
<body>
<!-- Inspired by: https://codepen.io/natewiley/pen/Ciwyn -->

<div id="particle-container">
	<div class="particle"></div>
	<div class="particle"></div>
	<div class="particle"></div>
	<div class="particle"></div>
	<div class="particle"></div>
	<div class="particle"></div>
	<div class="particle"></div>
	<div class="particle"></div>
	<div class="particle"></div>
	<div class="particle"></div>
	<div class="particle"></div>
	<div class="particle"></div>
	<div class="particle"></div>
	<div class="particle"></div>
	<div class="particle"></div>
	<div class="particle"></div>
	<div class="particle"></div>
	<div class="particle"></div>
	<div class="particle"></div>
	<div class="particle"></div>
	<div class="particle"></div>
	<div class="particle"></div>
	<div class="particle"></div>
	<div class="particle"></div>
	<div class="particle"></div>
	<div class="particle"></div>
	<div class="particle"></div>
	<div class="particle"></div>
	<div class="particle"></div>
	<div class="particle"></div>
</div>
<nav class="nav">
        <div class="container">
            <div class="logo">
                <a href="#">PANEL</a>
            </div>
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


<section>

    
    <div id="titrepanel"></div>

  
  <script>
  // Créez une instance de Typed.js
  var options = {
    strings: ["Bienvenue dans votre panel", "Espace <?= $role ?> "],
    typeSpeed: 50, // Vitesse de frappe en millisecondes
    backSpeed: 10, // Vitesse de suppression en millisecondes
    startDelay: 500, // Délai avant le démarrage en millisecondes
    backDelay: 500, // Délai après la suppression en millisecondes
    loop: true, // Boucler l'animation
  };

  var typed = new Typed("#titrepanel", options);
</script>


   
    
</section>  
</body>
</html>
<style>
