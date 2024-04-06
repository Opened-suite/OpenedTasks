<?php
session_start();
// Connexion à la base de données (à personnaliser avec vos informations)
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "openedtasks";

// Les données de la personne qui a appuyé sur le boutton "Prendre en charge"
$usertaketask = $_SESSION['pseudo'];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $taskId = $_POST['task_id'];
    
    $taskusertake = $_POST['task_user_take'];

    // Mettre à jour l'état de la tâche
    $stmt = $conn->prepare("UPDATE task_list SET task_user = :taskusertake WHERE id = :taskId;");
    $stmt->bindParam(':taskId', $taskId);
    $stmt->bindParam(':taskusertake', $usertaketask);

    // Exécution de la requête
    $stmt->execute();
    echo "tache bien modifiée";
    echo "Log : ";
    echo $usertaketask;
    echo "id : ";
    echo $taskId;
    
    header('Location: index.php'); // Rediriger vers la page d'accueil
} catch (PDOException $e) {
    echo "Erreur lors de la mise à jour de l'état de la tâche : " . $e->getMessage();
}

$conn = null;
?>
