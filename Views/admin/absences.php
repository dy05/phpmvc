<?php
$template = 'dashboard.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= isset($title) ? $title : "Page d'accueil" ?></title>
    <!-- Styles -->
    <link href="<?= ROUTE . '/css/app.css'; ?>" rel="stylesheet">
    <link href="<?= ROUTE . '/css/all.min.css'; ?>" rel="stylesheet">
    <link href="<?= ROUTE . '/css/main.css'; ?>" rel="stylesheet">
</head>
<body>
<header>
    <h1 class="gtitre"> <a href="<?= ROUTE . '/home'; ?>"><img src="logo.png"></a> Système de gestion de l'EFREI</h1>
</header>

<nav>
    <ul>
        <li>
            <a href="<?= ROUTE . '/home'; ?>">
                Accueil
            </a>
        </li>
        <li>
            <a href="<?= ROUTE . '/formations'; ?>">
                Formations
            </a>
        </li>
        <li>
            <a href="<?= ROUTE . '/cours'; ?>">
                Cours
            </a>
        </li>
        <li>
            <a href="<?= ROUTE . '/salles'; ?>">
                Salles
            </a>
        </li>
        <li>
            <a href="<?= ROUTE . '/horaires'; ?>">
                Horaires
            </a>
        </li>
        <li>
            <a href="<?= ROUTE . '/absences'; ?>">
                Absences
            </a>
        </li>
        <li>
            <a href="<?= ROUTE . '/etudiants'; ?>">
                Étudiants
            </a>
        </li>
        <li>
            <a href="<?= ROUTE . '/enseignants'; ?>">
                Enseignants
            </a>
        </li>
    </ul>
</nav>

<main>
    <h2>Bienvenue dans la page d'administration</h2>
    <h>Gestion des absences</h>
</main>

<footer>
    <p>&copy; 2023 EFREI. Tous droits réservés.</p>
</footer>
</body>
</html>
