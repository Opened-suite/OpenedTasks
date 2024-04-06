<?php 
    session_start(); // Démarrage de la session
    require_once 'config.php'; // On inclut la connexion à la base de données

    if(!empty($_POST['prenom']) && !empty($_POST['password'])) // Si il existe les champs email, password et qu'il sont pas vident
    {
        // Patch XSS
        $prenom = htmlspecialchars($_POST['prenom']); 
        $password = htmlspecialchars($_POST['password']);
        
        $prenom = strtolower($prenom); // email transformé en minuscule
        
        // On regarde si l'utilisateur est inscrit dans la table utilisateurs
        $check = $bdd->prepare('SELECT pseudo, email, password, token FROM utilisateurs WHERE pseudo = ?');
        $check->execute(array($prenom));
        $data = $check->fetch();
        $row = $check->rowCount();
        
        

        // Si > à 0 alors l'utilisateur existe
        if($row > 0)
        {
            // Si le mail est bon niveau format
            
                // Si le mot de passe est le bon
                if(password_verify($password, $data['password']))
                {
                    // On créer la session et on redirige sur landing.php
                    $_SESSION['token'] = $data['token'];
                    $_SESSION['pseudo'] = $data['pseudo'];
                    $_SESSION['email'] = $data['email'];
                    $_SESSION['ip'] = $data['ip'];
                    header('Location: v1/panel/');
                    die();
                }else{ header('Location: index.php?login_err=password'); die(); }
            
        }else{ header('Location: index.php?login_err=not_exist'); die(); }
    }else{ header('Location: index.php'); die();} 
