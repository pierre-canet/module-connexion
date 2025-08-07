<?php
    $mysqli = new mysqli("localhost", "root", "", "moduleconnexion");

    if($mysqli->connect_error){
        die("Erreur de connexion: ".$mysqli->connect_error);
    };

    $query ="SELECT * FROM utilisateurs";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
</head>

<body>
    <nav>
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="inscription.php">Inscription/Connexion</a></li>
            <li><a href="profil.php">Profil</a></li>
            <li class="adminBar"><a href="admin.php">Admin</a></li>
        </ul>
    </nav>
    <h1>Accueil</h1>
    <article>
        <h3>Bienvenue sur notre site !</h3>
        <p>
            Sur ce site, vous allez pouvoir vous créer un compte, gérer votre profil,
            ainsi que vous connecter à votre compte une fois ce dernier créé.
        </p>        
    </article>
    <?php
        /*Vous décidez de créer un module de connexion permettant aux utilisateurs de créer leur
        compte, de se connecter et de modifier leurs informations.
        Pour commencer, créez votre base de données nommée “moduleconnexion” à l’aide de
        phpmyadmin. Dans cette bdd, créez une table “utilisateurs” qui contient les champs
        suivants :
        ● id, int, clé primaire et Auto Incrément
        ● login, varchar de taille 255
        ● prenom, varchar de taille 255
        ● nom, varchar de taille 255
        ● password, varchar de taille 255
        Créez un utilisateur qui aura la possibilité d’accéder à l’ensemble des informations. Son
        login, prénom, nom et mot de passe sont “admin”.
        Maintenant que la base de données est prête, vous allez avoir besoin de créer
        différentes pages :
        ● Une page d’accueil qui présente votre site (index.php)
        ● Une page contenant un formulaire d’inscription (inscription.php) :
        Le formulaire doit contenir l’ensemble des champs présents dans la table
        “utilisateurs” (sauf “id”) + une confirmation de mot de passe. Dès qu’un
        utilisateur remplit ce formulaire, les données sont insérées dans la base de
        données et l’utilisateur est redirigé vers la page de connexion.
        ● Une page contenant un formulaire de connexion (connexion.php) :
        Le formulaire doit avoir deux inputs : “login” et “password”. Lorsque le formulaire
        est validé, s’il existe un utilisateur en bdd correspondant à ces informations, alors

        l’utilisateur est considéré comme connecté et une (ou plusieurs) variables de
        session sont créées.
        ● Une page permettant de modifier son profil (profil.php) :
        Cette page possède un formulaire permettant à l’utilisateur de modifier ses
        informations. Ce formulaire est par défaut pré-rempli avec les informations qui
        sont actuellement stockées en base de données.
        ● Une page d’administration (admin.php) :
        Cette page est accessible UNIQUEMENT pour l’utilisateur “admin”. Elle permet
        de lister l’ensemble des informations des utilisateurs présents dans la base de
        données.
        Il va de soi que le site doit avoir une structure html correcte et un design soigné à l’aide
        de css. Vous avez la liberté de choisir un thème à l’image de votre groupe.
        Vous devez également rendre la structure et le contenu de votre base de données dans
        un fichier nommé “moduleconnexion.sql”.*/
    ?>
</body>
</html>