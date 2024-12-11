<?php
// Connexion à la base de données (à adapter selon votre configuration)
$pdo = new PDO('mysql:host=localhost;dbname=openedtasks;charset=utf8', 'root', 'root');

function getEvents($month, $year) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM evenements WHERE MONTH(date) = :month AND YEAR(date) = :year");
    $stmt->execute(['month' => $month, 'year' => $year]);
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $eventsByDay = [];
    foreach ($events as $event) {
        $day = date('j', strtotime($event['date']));
        $eventsByDay[$day][] = $event;
    }
    return $eventsByDay;
}

function generateCalendar($month = null, $year = null) {
    $month = $month ?? date('n');
    $year = $year ?? date('Y');
    
    $firstDay = mktime(0, 0, 0, $month, 1, $year);
    $daysInMonth = date('t', $firstDay);
    $dayOfWeek = date('w', $firstDay);
    
    $events = getEvents($month, $year);
    
    $calendar = "<table id='calendar'>";
    $calendar .= "<caption>" . date('F Y', $firstDay) . "</caption>";
    $calendar .= "<tr><th>Dim</th><th>Lun</th><th>Mar</th><th>Mer</th><th>Jeu</th><th>Ven</th><th>Sam</th></tr>";
    
    $currentDay = 1;
    $calendar .= "<tr>";
    
    for ($i = 0; $i < $dayOfWeek; $i++) {
        $calendar .= "<td></td>";
    }
    
    while ($currentDay <= $daysInMonth) {
        if ($dayOfWeek == 7) {
            $dayOfWeek = 0;
            $calendar .= "</tr><tr>";
        }
        
        $today = $currentDay == date('j') && $month == date('n') && $year == date('Y') ? " class='today'" : "";
        $calendar .= "<td$today>
                        <span>$currentDay</span>
                        <button class='add-event' data-date='$year-" . str_pad($month, 2, '0', STR_PAD_LEFT) . "-" . str_pad($currentDay, 2, '0', STR_PAD_LEFT) . "'>+</button>
                        <ul class='events'>";
        
        if (isset($events[$currentDay])) {
            foreach ($events[$currentDay] as $event) {
                $calendar .= "<li onclick='seeEvent(" . json_encode($event) . ")'>" . htmlspecialchars($event['titre']) . "</li>";
            }
        }
        
        $calendar .= "</ul></td>";
        
        $currentDay++;
        $dayOfWeek++;
    }
    
    while ($dayOfWeek < 7) {
        $calendar .= "<td></td>";
        $dayOfWeek++;
    }
    
    $calendar .= "</tr></table>";
    
    return $calendar;
}

// Traitement de l'ajout d'événement
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_event') {
    $date = $_POST['date'];
    $titre = $_POST['title'];
    $description = $_POST['description'];
    
    $stmt = $pdo->prepare("INSERT INTO evenements (titre, description, date, heure_debut, heure_fin, personne) VALUES (:titre, :description, :date, :heure_debut, :heure_fin, :personne)");
    $stmt->execute([
        'titre' => $titre,
        'description' => $description,
        'date' => $date,
        'heure_debut' => $heure_debut ?? '00:00:00',
        'heure_fin' => $heure_fin ?? '23:59:59',
        'personne' => $_SESSION['pseudo'] ?? 'none'
        
    ]);
    
    // Rediriger pour éviter la soumission multiple du formulaire
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

$calendar = generateCalendar();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Calendrier avec Ajout d'Événements</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        #calendar {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        #calendar th, #calendar td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            vertical-align: top;
        }
        #calendar th {
            background-color: #f2f2f2;
        }
        .today {
            background-color: #e6f3ff;
            font-weight: bold;
        }
        .add-event {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            margin-top: 5px;
        }
        .events {
            list-style-type: none;
            padding: 0;
            margin: 5px 0 0 0;
        }
        .events li {
            background-color: #f0f0f0;
            margin: 2px 0;
            padding: 2px;
            font-size: 0.8em;
        }
        #event-form {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
            z-index: 1000;
        }
        #event-form input, #event-form textarea {
            width: 100%;
            margin-bottom: 10px;
            padding: 5px;
        }
        #event-form button {
            padding: 5px 10px;
            margin-right: 10px;
        }
        .popupSeeEvent {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
            z-index: 1000;
        }
    </style>
</head>
<body>
    <?php echo $calendar; ?>

    <div id="event-form">
        <h3>Ajouter un événement</h3>
        <form id="add-event-form" method="POST">
            <input type="hidden" name="action" value="add_event">
            <input type="hidden" id="event-date" name="date">
            <input type="text" id="event-title" name="title" placeholder="Titre de l'événement" required>
            <textarea id="event-description" name="description" placeholder="Description"></textarea>
            <input type="time" id="event-start" name="heure_debut">
            <input type="time" id="event-end" name="heure_fin">
            <button type="submit">Ajouter</button>
            <button type="button" onclick="closeEventForm()">Annuler</button>
        </form>
    </div>
    <div class="popupSeeEvent">
        <h3>Evenement</h3>
        <p id="event-titre">Titre : </p>
        <p id="event-description">Description : </p>
        <p id="event-heure-debut">Heure de début : </p>
        <p id="event-heure-fin">Heure de fin : </p>
        <p id="event-personne">Personne : </p>
    </div>

    <script>
        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('add-event')) {
                var date = e.target.getAttribute('data-date');
                document.getElementById('event-date').value = date;
                document.getElementById('event-form').style.display = 'block';
            }
        });

        function closeEventForm() {
            document.getElementById('event-form').style.display = 'none';
        }
        
        function seeEvent(event) {
            var popup = document.querySelector('.popupSeeEvent');
            var titre = event.titre;
            var description = event.description;
            var heure_debut = event.heure_debut;
            var heure_fin = event.heure_fin;
            var personne = event.personne;
            popup.querySelector('p#event-titre').textContent = titre;
            popup.querySelector('p#event-description').textContent = description;
            popup.querySelector('p#event-heure-debut').textContent = heure_debut;
            popup.querySelector('p#event-heure-fin').textContent = heure_fin;
            popup.querySelector('p#event-personne').textContent = personne;
            popup.style.display = 'block';
        }
    </script>
</body>
</html>