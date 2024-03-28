
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Madimi+One&display=swap" rel="stylesheet">
    <title>Formulaire beau</title>
    <style>
    body {
            background: url(https://indieground.net/wp-content/uploads/2023/03/Freebie-GradientTextures-Preview-04.jpg);
            animation: animbackground 18s ease-in-out infinite;
           display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: "Madimi One", sans-serif;
            font-weight: 400;
            font-style: normal;
    }
    

    @keyframes animbackground {
        0% {
            background-position: center;
        }

        50% {
            background-position: right;
        }

        100% {
            background-position: center;
        }
   }

        .modal {
            /*centering*/
            display: flex;
            flex-wrap: wrap;
            justify-content: space-evenly;
            align-items: center;

            /*modal styles*/
            position: fixed;
            top: 25%;
            right: 20%;
            bottom: 25%;
            left: 20%;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            width: 60%;
            height: 50%;

        }

        input[type=text],
        input[type=password] {
            width: 45%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 45%;
            border-radius: 4px;
        }

        button:hover {
            background-color: #45a049;
        }
        .error {
            background-color: red;
            color: white;
            padding: 10px;
            position: fixed;
            top: 1%;
            border-radius: 5px;
            margin-bottom: 10px;
            z-index: 9999;
        }
    </style>
</head>
<?php 
                if(isset($_GET['login_err']))
                {
                    $err = htmlspecialchars($_GET['login_err']);
                    if($err == 'not_exist') {
                        echo "<div class='error'>Erreur : Utilisateur inconnu</div>";
                    }
                    else {
                    echo "<div class='error'>Erreur : $err</div>";
                    }
                }
?> 
<body>
    <div class="modal">
        <h3>Connexion à votre espace<br>professionnel OpenedTasks</h1>
        <form action="connexion.php" method="post">
            <label for="fname">Prénom:</label>
            <input type="text" id="fname" name="prenom"><br><br>
            
            <label for="pwd">Mot de passe:</label>
            <input type="password" id="pwd" name="password"><br><br>
            <button type="submit">Envoyer</button>
        </form>
    </div>
</body>

</html>

