<?php
// Connexion à la base de données (à personnaliser avec vos informations)
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "tasks";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupération de l'état et de la nouvelle tâche depuis le formulaire
    $taskText = $_POST['task_text'];
    $taskStatus = $_POST['task_status'];

    // Préparation de la requête d'insertion
    $stmt = $conn->prepare("INSERT INTO task_list (task_text, task_status) VALUES (:taskText, :taskStatus)");
    $stmt->bindParam(':taskText', $taskText);
    $stmt->bindParam(':taskStatus', $taskStatus);

    // Exécution de la requête
    $stmt->execute();

    header('Location: index.php'); // Rediriger vers la page d'accueil

} catch (PDOException $e) {
    echo "Erreur lors de l'ajout de la tâche : " . $e->getMessage();
}

$conn = null;
?>
