<?php
    $mysqli = new mysqli("localhost", "root", "", "moduleconnexion");

    if($mysqli->connect_error){
        die("Erreur de connexion: ".$mysqli->connect_error);
    };
    $query ="SELECT * FROM utilisateurs";
    $result = $mysqli->query($query);
    $firstRow = $result->fetch_assoc();
    $columns = array_keys($firstRow);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>job13</title>
    <link rel="stylesheet" href="index.css" />
</head>
<body>
    <h1>Admin</h1>
    <p>Bienvenue administrateur.</p>
    <table>
        <thead>
            <tr>
                <?php foreach ($columns as $col): ?>
                    <th><?= $col ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <!-- Affiche la première ligne -->
            <tr>
                <?php foreach ($firstRow as $val): ?>
                    <td><?= $val ?></td>
                <?php endforeach; ?>
            </tr>

            <!-- Affiche les lignes suivantes -->
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <?php foreach ($row as $val): ?>
                        <td><?= $val ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    
</body>
</html>