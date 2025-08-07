<?php
    session_start();    
    $mysqli = new mysqli("localhost", "root", "", "moduleconnexion");
    $message ='';
    $formToShow = 'register';
    //vérifie si on a appuyé sur le bouton "déjà connecté ?"    
    if(isset($_POST['goToLogin'])){
        $formToShow = 'login';
    }
    //vérifie si on a appuyé sur le bouton "déjà connecté ?"    
    if(isset($_POST['goToRegister'])){
        $formToShow = 'register';
    }
    if($mysqli->connect_error){
        die("Erreur de connexion: ".$mysqli->connect_error);
    };    
    // logique d'inscription
    if (isset($_POST['register'])) {
        //lien des champs du formulaires à des variables
        $login = htmlspecialchars(trim($_POST['login']));
        $nom = htmlspecialchars(trim($_POST['name']));
        $prenom = htmlspecialchars(trim($_POST['firstName']));
        //on vérifie que les deux mots de passe soient identiques
        if($_POST['password'] !== $_POST['passwordConfirm']){
            $message = "Les mots de passe doivent être identiques";
        }
        else{
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $check = $mysqli->prepare("SELECT id FROM utilisateurs WHERE login = ?");
            $check->bind_param("s", $login);
            $check->execute();
            $check->store_result();
            //on vérifie que le login n'est pas déjà pris
            if($check->num_rows > 0){
                $message = "Ce login est déjà utilisé.";
            }
            //les conditions sont vérifiées donc on ajoute un nouvel utilisateur
            else{
                $statement = $mysqli->prepare("INSERT INTO utilisateurs (login, prenom, nom, password) VALUES (?, ?, ?, ?)");
                $statement->bind_param("ssss", $login, $prenom, $nom, $password);
                $statement->execute();
                header("Location: inscription.php?success=1");
                exit();
            }
        }
    }
    
    // logique de connexion
    if(isset($_POST['loginSubmit'])){
        //champs du formulaire
        $login = htmlspecialchars(trim($_POST['login']));
        $password = trim($_POST['password']);

        //initialisation de la requête
        $check = $mysqli->prepare("SELECT * FROM utilisateurs WHERE login = ?");
        $check->bind_param("s", $login);
        $check ->execute();
        
        // 3. Résultat
        $result = $check->get_result();
        $user = $result->fetch_assoc();
        
        //Vérification
        if($user && password_verify($password, $user['password'])){            
            /*Si les identifiants sont bon on initialise une session et on redirige
            vers la page de profil*/        
            $_SESSION['id'] = $user['id'];
            $_SESSION['login'] = $user['login'];
            $_SESSION['prenom'] = $user['prenom'];
            $_SESSION['nom'] = $user['nom'];
            if(isset($user['admin']) && $user['admin'] == 1){
                header("Location: admin.php");
                exit();
            }
            else{
                header("Location: profil.php");
                exit();
            }            
        }            
        else{
            $message = "Login ou mot de passe incorrect.";            
        }
        
    };
    /*en appuyant sur le bouton deconnexion on supprime la session et on est redirigé
    vers l'accueil*/
    if(isset($_POST['logout'])){
        session_destroy();
        header("Location: index.php"); 
        exit();
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>

<body>
    <h1>Bienvenue</h1>
    <?php if(isset($_SESSION['login'])): ?>
        <!-- UTILISATEUR CONNECTÉ -->
        <p>Bonjour <?php echo htmlspecialchars($_SESSION['login']); ?> !</p>
        <form method="POST">
            <button type="submit" name="logout">Déconnexion</button>
        </form>
    <?php elseif ($formToShow === 'login'): ?>
        <!-- Formulaire connexion -->
        <form action="" method="POST">
            <input type="hidden" name="form_type" value="login">
            Login : <input type="text" name="login" required>
            Mot de passe : <input type="password" name="password" required>
            <button type="submit" name="loginSubmit">Connexion</button>
        </form>
        <form action="" method="POST">
            <button type="submit" name="goToRegister">Pas encore de compte ?</button>
        </form>
    <?php else: ?>
        <!-- Formulaire inscription -->
        <form method="POST">
            <input type="hidden" name="form_type" value="register">
            Login : <input type="text" name="login" required>
            Prénom : <input type="text" name="firstName" required>
            Nom : <input type="text" name="name" required>
            Mot de passe : <input type="password" name="password" required>
            Confirmation de mot de passe : <input type="password" name="passwordConfirm" required>
            <button type="submit" name="register">Inscription</button>            
        </form>
        <form action="" method="POST">
            <button type="submit" name="goToLogin">Déjà inscrit ?</button>
        </form>
        <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
            <p style="color:green;">Inscription réussie ! Vous pouvez maintenant vous 
                connecter.</p>
        <?php endif; ?>      
    <?php endif; ?>
    <?php if(!empty($message)):?>
            <p style="color:red;"><?php echo $message; ?></p>
    <?php endif; ?>    
</body>
</html>