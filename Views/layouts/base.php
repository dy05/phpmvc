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
    <a class="flex" href="<?= ROUTE . '/home'; ?>">
        <img src="<?= ROUTE . '/logo.png'; ?>" alt="logo" />
        <h1 class="gtitre ml-2">
            Système de gestion de l'EFREI
        </h1>
    </a>
</header>

<nav>
    <ul>
        <li>
            <a href="<?= ROUTE . '/home'; ?>">
                Accueil
            </a>
        </li>
        <?php if (isset($_SESSION['auth'])): ?>
        <li>
            <a href="<?= ROUTE . '/cours'; ?>">
                Cours
            </a>
        </li>
        <li>
            <a href="<?= ROUTE . '/formations'; ?>">
                Formations
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
        <li>
            <a href="<?= ROUTE . '/logout'; ?>" onclick="document.getElementById('formLogout')?.submit(); return false;">
                Se deconnecter
            </a>
            <form action="<?= ROUTE . '/logout'; ?>" method="post" class="hidden" id="formLogout"></form>
        </li>
        <?php else: ?>
            <li>
                <a href="<?= ROUTE . '/login'; ?>">
                    Se connecter
                </a>
            </li>
            <li>
                <a href="<?= ROUTE . '/register'; ?>">
                    S'inscrire
                </a>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<?php if (isset($alert)): ?>
<div class="alert alert-success">
    <p><?= $alert; ?></p>
</div>
<?php endif; ?>

<main>
    <?= isset($content) ? $content : ''; ?>
</main>

<footer>
    <p>&copy; 2023 EFREI. Tous droits réservés.</p>
</footer>
</body>
</html>
