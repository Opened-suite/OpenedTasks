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
  
  $reqnb_query = $conn->query("SELECT COUNT(*) FROM task_list");
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
    <div class="modal" id="modal">
      <p>Delete</p>
      <p>Edit</p>
      <p>View</p>
    </div>
    <div class="project-box-wrapper">
        <div class="project-box" style="background-color: #fee4cb;">
            <div class="project-box-header">
                <span>' . $task["date_created"] . '</span>
                <div class="more-wrapper" onclick="openModal()">
                    <button class="project-btn-more">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical">
                            <circle cx="12" cy="12" r="1" />
                            <circle cx="12" cy="5" r="1" />
                            <circle cx="12" cy="19" r="1" />
                        </svg>
                    </button>
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
                ' 
                .
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

                    
                    '
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
    .project-boxes {
        margin: 0 -8px;
        overflow-y: auto;
}
    .project-boxes.jsGridView {
        display: flex;
            flex-wrap: wrap;
            width: 90%;
    }
    
    .project-boxes.jsListView .project-box {
        display: flex;
        border-radius: 10px;
        position: relative;
}
    .project-boxes.jsListView .project-box > * {
        margin-right: 24px;
}
    .project-boxes.jsListView .more-wrapper {
        position: absolute;
        
}
    .project-boxes.jsListView .project-box-content-header {
        order: 1;
        max-width: 120px;
}
    .project-boxes.jsListView .project-box-header {
        order: 2;
}
    .project-boxes.jsListView .project-box-footer {
        order: 3;
        padding-top: 0;
        flex-direction: column;
        justify-content: flex-start;
}
    .project-boxes.jsListView .project-box-footer:after {
        display: none;
}
    .project-boxes.jsListView .participants {
        margin-bottom: 8px;
}
    .project-boxes.jsListView .project-box-content-header p {
        text-align: center;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
}
    .project-boxes.jsListView .project-box-header > span {
        position: absolute;
        bottom: 16px;
        left: 16px;
        font-size: 12px;
}
    .project-boxes.jsListView .box-progress-wrapper {
        order: 3;
        flex: 1;
}
    .project-box {
        --main-color-card: #dbf6fd;
        border-radius: 30px;
        padding: 16px;
        background-color: var(--main-color-card);
}
    .project-box-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
        color: var(--main-color);
}
    .project-box-header span {
        color: #4a4a4a;
        opacity: 0.7;
        font-size: 14px;
        line-height: 16px;
}
    .project-box-content-header {
        text-align: center;
        margin-bottom: 16px;
}
    .project-box-content-header p {
        margin: 0;
}
    .project-box-wrapper {
        padding: 8px;
        transition: 0.2s;
}
    .project-btn-more {
        padding: 0;
        height: 14px;
        width: 24px;
        height: 24px;
        position: relative;
        background-color: transparent;
        border: none;
        flex-shrink: 0;
    
    
}
    .more-wrapper {
        position: relative;
}
    .box-content-header {
        font-size: 16px;
        line-height: 24px;
        font-weight: 700;
        opacity: 0.7;
}
    .box-content-subheader {
        font-size: 14px;
        line-height: 24px;
        opacity: 0.7;
}
    .box-progress {
        display: block;
        height: 4px;
        border-radius: 6px;
}
    .box-progress-bar {
        width: 100%;
        height: 4px;
        border-radius: 6px;
        overflow: hidden;
        background-color: #fff;
        margin: 8px 0;
}
    .box-progress-header {
        font-size: 14px;
        font-weight: 700;
        line-height: 16px;
        margin: 0;
}
    .box-progress-percentage {
        text-align: right;
        margin: 0;
        font-size: 14px;
        font-weight: 700;
        line-height: 16px;
}
    .project-box-footer {
        display: flex;
        justify-content: space-between;
        padding-top: 16px;
        position: relative;
}
    .project-box-footer:after {
        
        position: absolute;
        background-color: rgba(255, 255, 255, 0.6);
        width: calc(100% + 32px);
        top: 0;
        left: -16px;
        height: 1px;
}
    .participants {
        display: flex;
        align-items: center;
}
    .participants img {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        overflow: hidden;
        object-fit: cover;
}
    .participants img {
        margin-left: -8px;
}
    .add-participant {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: none;
        background-color: rgba(255, 255, 255, 0.6);
        margin-left: 6px;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 0;
}
    .days-left {
        background-color: rgba(255, 255, 255, 0.6);
        font-size: 12px;
        border-radius: 20px;
        flex-shrink: 0;
        padding: 6px 16px;
        font-weight: 700;
}
    .mode-switch.active .moon {
        fill: var(--main-color);
}

    @media screen and (max-width: 980px) {
        .project-boxes.jsGridView .project-box-wrapper {
            width: 50%;
    }
        .status-number, .status-type {
            font-size: 14px;
    }
        .status-type:after {
            width: 4px;
            height: 4px;
    }
        .item-status {
            margin-right: 0;
    }
}
    

    @media screen and (max-width: 720px) {
        .app-name, .profile-btn span {
            display: none;
    }
        .add-btn, .notification-btn, .mode-switch {
            width: 20px;
            height: 20px;
    }
        .add-btn svg, .notification-btn svg, .mode-switch svg {
            width: 16px;
            height: 16px;
    }
        .app-header-right button {
            margin-left: 4px;
    }
}
    @media screen and (max-width: 520px) {
        .projects-section {
            overflow: auto;
    }
        .project-boxes {
            overflow-y: visible;
    }
        .app-sidebar, .app-icon {
            display: none;
    }
        .app-content {
            padding: 16px 12px 24px 12px;
    }
        .status-number, .status-type {
            font-size: 10px;
    }
        .view-btn {
            width: 24px;
            height: 24px;
    }
        .app-header {
            padding: 16px 10px;
    }
        .search-input {
            max-width: 120px;
    }
        .project-boxes.jsGridView .project-box-wrapper {
            width: 100%;
    }
        .projects-section {
            padding: 24px 16px 0 16px;
    }
        .profile-btn img {
            width: 24px;
            height: 24px;
    }
        .app-header {
            padding: 10px;
    }
        .projects-section-header p, .projects-section-header .time {
            font-size: 18px;
    }
        .status-type {
            padding-right: 4px;
    }
        .status-type:after {
            display: none;
    }
        .search-input {
            font-size: 14px;
    }
    
        .box-content-header {
            font-size: 12px;
            line-height: 16px;
    }
        .box-content-subheader {
            font-size: 12px;
            line-height: 16px;
    }
        .project-boxes.jsListView .project-box-header > span {
            font-size: 10px;
    }
        .box-progress-header {
            font-size: 12px;
    }
        .box-progress-percentage {
            font-size: 10px;
    }
        .days-left {
            font-size: 8px;
            padding: 6px 6px;
            text-align: center;
    }
        .project-boxes.jsListView .project-box > * {
            margin-right: 10px;
    }
        .project-boxes.jsListView .more-wrapper {
            right: 2px;
            top: 10px;
    }
}
    </style>
<script>
    function openModal() {
        document.querySelector(".modal").classList.toggle("active");
    }
</script>
  <script src="index.js" defer></script>
