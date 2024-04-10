<?php
session_start();
$pseudo = $_SESSION['pseudo'];
if(!isset($pseudo)){
    header('Location: ../../index.php');
}
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "openedtasks";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  
  $reqnb = $conn->query("SELECT COUNT(*) FROM task_list");
  
  
  $stmtusers = $conn->prepare("SELECT * FROM utilisateurs");
  $stmtusers->execute();
  $users = $stmtusers->fetchAll(PDO::FETCH_ASSOC);
  

  
}
catch (PDOException $e) {
  echo "Erreur lors de la connexion : " . $e->getMessage();
}


$heureActuelle = time();

?>


<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css">
    <title>Admin PANEL - <?= $pseudo ?></title>
</head>
<body>

<div id="popup1" class="overlay popup" >
	<div class="popup">
		<h2>Add A New Task</h2>
		<a class="close" href="#">&times;</a>
		<div class="content">
      <form action="addtask.php" method="post">
        <p>If Task User is null, the task will be assigned to the user who took it</p>
			  <p>Task Name: <input type="text" name="taskname"></p>
        <p>Task User: <input type="text" name="taskuser"></p>
        <p>Send Task: <input type="submit" name="sendtask"></p>
      </form>
		</div>
	</div>
</div>
    

    <div class="app-container">
  <div class="app-header">
    <div class="app-header-left">
      <span class="app-icon"></span>
      <p class="app-name">Task</p>
      <div class="search-wrapper">
        <input class="search-input" type="text" placeholder="Search">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="feather feather-search" viewBox="0 0 24 24">
          <defs></defs>
          <circle cx="11" cy="11" r="8"></circle>
          <path d="M21 21l-4.35-4.35"></path>
        </svg>
      </div>
    </div>
    <div class="app-header-right">
      <button class="mode-switch" title="Switch Theme">
        <svg class="moon" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" width="24" height="24" viewBox="0 0 24 24">
          <defs></defs>
          <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"></path>
        </svg>
      </button>
      <a  href="#popup1">
      <button class="add-btn" title="Add New Project" >
        <svg class="btn-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
          <line x1="12" y1="5" x2="12" y2="19" />
          <line x1="5" y1="12" x2="19" y2="12" /></svg>
      </button>
      </a>
      <button class="notification-btn">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell">
          <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
          <path d="M13.73 21a2 2 0 0 1-3.46 0" /></svg>
      </button>
      <button class="profile-btn">
	  <img src="https://img.icons8.com/ios-filled/50/administrator-male--v1.png"></a>

        <span><?= $pseudo ?></span>
      </button>
    </div>
    
  </div>
  <div class="app-content">
    <div class="app-sidebar">
      <a href="" class="app-sidebar-link active">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
          <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
          <polyline points="9 22 9 12 15 12 15 22" /></svg>
      </a>
      <a href="" class="app-sidebar-link">
        <svg class="link-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="feather feather-pie-chart" viewBox="0 0 24 24">
          <defs />
          <path d="M21.21 15.89A10 10 0 118 2.83M22 12A10 10 0 0012 2v10z" />
        </svg>
      </a>
      <a href="" class="app-sidebar-link">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar">
          <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
          <line x1="16" y1="2" x2="16" y2="6" />
          <line x1="8" y1="2" x2="8" y2="6" />
          <line x1="3" y1="10" x2="21" y2="10" /></svg>
      </a>
      <a href="" class="app-sidebar-link">
        <svg class="link-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="feather feather-settings" viewBox="0 0 24 24">
          <defs />
          <circle cx="12" cy="12" r="3" />
          <path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z" />
        </svg>
      </a>
    </div>
    <div class="projects-section">
      <div class="projects-section-header">
        <p>Projects</p>
        <p class="time">December, 12</p>
      </div>
      <div class="projects-section-line">
        <div class="projects-status">
          <div class="item-status">
            <span class="status-number"><?= $reqnb?></span>
            <span class="status-type">In Progress</span>
          </div>
          <div class="item-status">
            <span class="status-number">24</span>
            <span class="status-type">Upcoming</span>
          </div>
          <div class="item-status">
            <span class="status-number">62</span>
            <span class="status-type">Total Projects</span>
          </div>
        </div>
        <div class="view-actions">
          <button class="view-btn list-view" title="List View">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list">
              <line x1="8" y1="6" x2="21" y2="6" />
              <line x1="8" y1="12" x2="21" y2="12" />
              <line x1="8" y1="18" x2="21" y2="18" />
              <line x1="3" y1="6" x2="3.01" y2="6" />
              <line x1="3" y1="12" x2="3.01" y2="12" />
              <line x1="3" y1="18" x2="3.01" y2="18" /></svg>
          </button>
          <button class="view-btn grid-view active" title="Grid View">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-grid">
              <rect x="3" y="3" width="7" height="7" />
              <rect x="14" y="3" width="7" height="7" />
              <rect x="14" y="14" width="7" height="7" />
              <rect x="3" y="14" width="7" height="7" /></svg>
          </button>
        </div>
      </div>
      <div class="project-boxes jsGridView">
<?php 
require"taskforeach.php";

?>
      </div>


  

  </div>
</div>
</div>
</div>
</body>
</html>
<style>

.overlay {
	 position: absolute;
	 top: 0;
	 bottom: 0;
	 left: 0;
	 right: 0;
	 background: rgba(0, 0, 0, 0.5);
	 transition: opacity 200ms;
	 visibility: hidden;
	 opacity: 0;
}
 .overlay.light {
	 background: rgba(255, 255, 255, 0.5);
}
 .overlay .cancel {
	 position: absolute;
	 width: 100%;
	 height: 100%;
	 cursor: default;
}
 .overlay:target {
	 visibility: visible;
	 opacity: 1;
}
 .popup {
	 margin: 75px auto;
	 padding: 20px;
	 background: #fff;
	 border: 1px solid #666;
	 width: 300px;
	 box-shadow: 0 0 50px rgba(0, 0, 0, 0.5);
	 position: relative;
   
}
 .light .popup {
	 border-color: #aaa;
	 box-shadow: 0 2px 10px rgba(0, 0, 0, 0.25);
}
 .popup h2 {
	 margin-top: 0;
	 color: #666;
	 font-family: "Trebuchet MS", Tahoma, Arial, sans-serif;
}
 .popup .close {
	 position: absolute;
	 width: 20px;
	 height: 20px;
	 top: 20px;
	 right: 20px;
	 opacity: 0.8;
	 transition: all 200ms;
	 font-size: 24px;
	 font-weight: bold;
	 text-decoration: none;
	 color: #666;
}
 .popup .close:hover {
	 opacity: 1;
}
 .popup .content {
	 max-height: 400px;
	 overflow: auto;
}
 .popup p {
	 margin: 0 0 1em;
}
 .popup p:last-child {
	 margin: 0;
}
 </style>
  <script src="index.js" defer></script>
