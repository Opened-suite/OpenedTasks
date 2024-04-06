<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "openedtasks";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT id, task_text, task_status, task_user FROM task_list");
    $stmt->execute();

    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des tâches : " . $e->getMessage();
}
foreach ($tasks as $task) {
    

echo '


        <div class="project-box-wrapper">
          <div class="project-box" style="background-color: #fee4cb;">
            <div class="project-box-header">
              <span>December 10, 2020</span>
              <div class="more-wrapper">
                <button class="project-btn-more">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical">
                    <circle cx="12" cy="12" r="1" />
                    <circle cx="12" cy="5" r="1" />
                    <circle cx="12" cy="19" r="1" /></svg>
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
            <span class="box-progress" style="width: '. $task["percent"] .'; background-color: #ff942e"></span>
          </div>
          <p class="box-progress-percentage">'. $task["percent"] .'</p>
        </div>
        <div class="project-box-footer">
          <div class="participants">
            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=2550&q=80" alt="participant">
            <img src="https://images.unsplash.com/photo-1503023345310-bd7c1de61c7d?ixid=MXwxMjA3fDB8MHxzZWFyY2h8MTB8fG1hbnxlbnwwfHwwfA%3D%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=900&q=60" alt="participant">
            <button class="add-participant" style="color: #ff942e;">
              <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                <path d="M12 5v14M5 12h14" />
              </svg>
            </button>
          </div>
          <div class="days-left" style="color: #ff942e;">
            2 Days Left
          </div>
        </div>
      </div>
    ';
    echo '<style>
    .project-boxes {
        margin: 0 -8px;
        overflow-y: auto;
   }
    .project-boxes.jsGridView {
        display: flex;
        flex-wrap: wrap;
   }
    .project-boxes.jsGridView .project-box-wrapper {
        width: 33.3%;
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
    </style>';
}

    ?>