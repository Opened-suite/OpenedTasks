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
$table = "task_list";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  
  $reqnb_query = $conn->query("SELECT COUNT(*) FROM ".$table);
  $reqnb_result = $reqnb_query->fetch(PDO::FETCH_ASSOC);
  $reqnb = $reqnb_result['COUNT(*)'];
  
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
  <script src="ts.ts"></script>
    <title>Admin PANEL - <?= $pseudo ?></title>

<style>

.overlay {
	position: fixed;
	top: 0;
	left: 0;
    width: 100%;
    height: 100%;
    z-index: 1000;
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
	/*margin: 75px auto;*/
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
	padding: 20px;
	background: #fff;
	border: 1px solid #666;
	width: 350px;
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
</head>
<body>

<div id="popup1" class="overlay" >
	<div class="popup">
		<h2>Add A New Task</h2>
		<a class="close" href="#">&times;</a>
		<div class="content">
      <form action="addtask.php" method="post">
        <p>If Task User is null, the task will be assigned to the user who took it</p>
			  <p>Task Name: <input type="text" name="taskname"></p>
        <p>Task User: <input type="text" name="taskuser"></p>
        <p>Deadline: <input type="date" name="deadline" style="display: inline;"><input type="time" name="time" style="display: inline;"></p>
        <input type="hidden" name="table" value="<?= $table ?>">
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
      <a href="" class="app-sidebar-link" >
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
            <span class="status-number"><?= $reqnb;?></span>
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
          <button class="view-btn list-view" title="List View" onclick="passToList()">
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

try {
    function convert_timestamp($timestamp) {
        // Number of seconds in a day, hour, and minute
        $dayInSeconds = 24 * 60 * 60;
        $hourInSeconds = 60 * 60;
        $minuteInSeconds = 60;

        // Calculate days
        $days = floor($timestamp / $dayInSeconds);
        $remainingSeconds = $timestamp % $dayInSeconds;

        // Calculate hours
        $hours = floor($remainingSeconds / $hourInSeconds);
        $remainingSeconds %= $hourInSeconds;

        // Calculate minutes
        $minutes = floor($remainingSeconds / $minuteInSeconds);
        
        $final_string = "";

        if($days != 0) {
            $final_string .= $days . "J";
        }

        if($hours != 0) {
            $final_string .= " " . $hours . "h";
        }

        if($minutes != 0) {
            $final_string .= " " . $minutes . "m";
        }

        return $final_string;
    }
    session_start();
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "openedtasks";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM task_list");
        $stmt->execute();

        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

        
    } catch (PDOException $e) {
        echo "Erreur lors de la récupération des tâches : " . $e->getMessage();
    }
    echo '';
foreach ($tasks as $task) {
    if ($task["task_status"] == "Terminé"){
        $taskstatus = "#ADD8E6";
    };
    if ($task["task_status"] == "En cours"){
        $taskstatus = "#ADD8E6";
    }
    if ($task["task_status"] == "Pas fait"){
        $taskstatus = "#FFB74D";
    };


    if ($task["percent"] <= 20){
        
        $taskcolor = "#EF5350";
    }
    if ($task["percent"] > 20 && $task["percent"] <= 50){
        $taskcolor = "#FFB74D";
    }
    if ($task["percent"] > 50 && $task["percent"] <= 80){
        $taskcolor = "#ED7F10";
        
    }
    if ($task["percent"] > 80){
        $taskcolor = "#00FF20";
    }
    if ($task["percent"] == 100){
        $taskcolor = "#ADD8E6";
    }

    echo '
    
    <div class="project-box-wrapper element-wrapper">
    
        <div class="project-box" style="background-color: #fee4cb;">
            <div class="project-box-header">
                <span>' . $task["date_created"] . '</span>
                <div class="more-wrapper">
                    <button class="project-btn-more"onclick="openMoreBtn(this)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical">
                            <circle cx="12" cy="12" r="1" />
                            <circle cx="12" cy="5" r="1" />
                            <circle cx="12" cy="19" r="1" />
                        </svg>
                    </button>
                    <ul class="more-dropdown-list hidden">
                        <li class="more-dropdown-item">Delete</li>
                        <li class="more-dropdown-item">Edit</li>
                        <li class="more-dropdown-item">View</li>
                    </ul>

                </div>
            </div>
            <div class="project-box-content-header">
                <p class="box-content-header">' . $task["task_text"]  . '</p>
                <p class="box-content-subheader">' . $task["task_status"] . '</p>
            </div>
            <div class="box-progress-wrapper">
                <p class="box-progress-header">Progress</p>
                <div class="box-progress-bar">
                    <span class="box-progress" style="width: ' . $task["percent"] . '%; background-color: ' .  $taskcolor .'"></span>
                </div>
                <p class="box-progress-percentage">' . $task["percent"] . ' %</p>
            </div>
            <div class="project-box-footer">
                <div class="participants">
                ';
                    $names = explode(";", $task["task_user"]);
                    // Affichage des noms d'utilisateur séparés en utilisant echo
                    foreach ($names as $username) {
                            if (is_string($username)) {
                                echo $username . '<br>';
                            } else {
                                echo "Element non valide : ";
                                var_dump($username);
                            }
                    }
                    echo '
                    <button class="add-participant" style="color: #ff942e;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                            <path d="M12 5v14M5 12h14" />
                        </svg>
                    </button>
                </div>
                <div class="days-left" style="color: #ff942e;">
                    <p>Fin dans ' . convert_timestamp($task["task_deadline"] - time()) . '</p>
                </div>
            </div>
        </div>
    </div>';    
    }
} catch(Exception $e) {
    echo "Error: " . $e->getMessage();
}
    ?>

      </div>


  

  </div>
</div>
</div>
</div>
</body>
</html>
<style>

    </style>
<script>
    
    function openMoreBtn(button) {
            let dropdown = button.nextElementSibling;
            if (dropdown.style.display === "block") {
                dropdown.style.display = "none";
            } else {
                dropdown.style.display = "block";
            }
        }

</script>
  <script src="app.js" defer></script>
