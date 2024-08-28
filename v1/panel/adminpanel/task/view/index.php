<?php
session_start();
$pseudo = $_SESSION['pseudo'];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin PANEL - <?= $pseudo ?></title>
</head>
<body>
    <h1>Liste de Tâches</h1>
    <form action="add_task.php" method="POST">
        <input type="text" name="task_text" placeholder="Nouvelle Tâche" required />
        <select name="task_status">
            <option value="En cours">En cours</option>
            <option value="Terminé">Terminé</option>
            <option value="Pas fait">Pas fait</option>
        </select>
        <button type="submit">Ajouter</button>
    </form>
</body>
</html>