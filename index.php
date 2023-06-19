
<?php
    session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Page d'accueil</title>
    <link rel="stylesheet" type="text/css" href="../CSS/index.css">
</head>

<body>
<header>
    <h1 class="gtitre"> <a href="index.php"><img src="logo.png"></a> Système de gestion de l'EFREI</h1>
</header>

    <nav>
        <ul>
            <li><a href="index.html">Accueil</a></li>
            <li><a href="cours.html">Cours</a></li>
            <li><a href="salles.html">Salles</a></li>
            <li><a href="horaires.html">Horaires</a></li>
            <li><a href="absences.html">Absences</a></li>
            <li><a href="etudiants.html">Étudiants</a></li>
            <li><a href="enseignants.html">Enseignants</a></li>
        </ul>
    </nav>

    <main>
        <h2>Bienvenue sur la plateforme de gestion de l'EFREI</h2>
        <p>Ici, vous pouvez accéder aux différentes fonctionnalités en fonction de votre rôle :</p>

        <div class="role-section">
            <h3>Élève</h3>
            <p>En tant qu'étudiant, vous pouvez consulter vos notes et les informations liées à votre emploi du temps.
            </p>
            <a href="notes.html">Consulter vos notes</a>
            <a href="emploi-du-temps.html">Voir votre emploi du temps</a>
        </div>

        <div class="role-section">
            <h3>Enseignant</h3>
            <p>En tant qu'enseignant, vous pouvez saisir les notes des étudiants et accéder aux informations sur vos
                cours.</p>
            <a href="saisie-notes.html">Saisir les notes des étudiants</a>
            <a href="mes-cours.html">Voir mes cours</a>
        </div>

        <div class="role-section">
            <h3>Administrateur</h3>
            <p>En tant qu'administrateur, vous avez accès à toutes les fonctionnalités du système.</p>
            <a href="gestion-utilisateurs.html">Gérer les utilisateurs</a>
            <a href="config-systeme.html">Configurer le système</a>
        </div>
    </main>

    <footer>
        <p>&copy; 2023 EFREI. Tous droits réservés.</p>
    </footer>
</body>

</html>