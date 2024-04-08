<?php
session_start();
$pseudo = $_SESSION['pseudo'];


$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "openedtasks";


$taskname = $_POST['taskname'];
$taskuserold = $_POST['taskuser'];
echo $pseudo;
if ($taskuserold == null){
    $taskuser = "not yet assigned";
}
else {
    $taskuser = $taskuserold;
}

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("INSERT INTO task_list (task_text, task_user, create_by, percent) VALUES (:taskname, :taskuser, :create_by, 0)");
    $stmt->bindParam(':taskname', $taskname);
    $stmt->bindParam(':taskuser', $taskuser);
    $stmt->bindParam(':create_by', $pseudo);
    $stmt->execute();
    header("Location: index.php");
    

    
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des tâches : " . $e->getMessage();
}

$conn = null;
?>