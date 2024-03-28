<?php
// Connexion à la base de données (à personnaliser avec vos informations)
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "tasks";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $taskId = $_POST['task_id'];
    $newTaskStatus = $_POST['new_task_status'];
    

    // Mettre à jour l'état de la tâche
    $stmt = $conn->prepare("UPDATE task_list SET task_status = :newTaskStatus WHERE id = :taskId;");
    $stmt->bindParam(':newTaskStatus', $newTaskStatus);
    $stmt->bindParam(':taskId', $taskId);
    

    // Exécution de la requête
    $stmt->execute();

    header('Location: index.php'); // Rediriger vers la page d'accueil
} catch (PDOException $e) {
    echo "Erreur lors de la mise à jour de l'état de la tâche : " . $e->getMessage();
    die();
}

$conn = null;
?>
