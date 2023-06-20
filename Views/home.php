<?php
$template = 'layouts/base.php';
$title = "Page d'accueil";
?>

<h2>Bienvenue sur la plateforme de gestion de l'EFREI</h2>
<p>Ici, vous pouvez accéder aux différentes fonctionnalités en fonction de votre rôle :</p>

<div class="role-section">
    <h3>Élève</h3>
    <p>En tant qu'étudiant, vous pouvez consulter vos notes et les informations liées à votre emploi du temps.
    </p>
    <a href="<?= ROUTE . '/notes'; ?>">
        Consulter vos notes
    </a>
    <a href="<?= ROUTE . '/emploi-du-temps'; ?>">
        Voir votre emploi du temps
    </a>
</div>

<div class="role-section">
    <h3>
        Enseignant
    </h3>
    <p>
        En tant qu'enseignant, vous pouvez saisir les notes des étudiants et accéder aux informations sur vos cours.
    </p>
    <a href="<?= ROUTE . '/saisie-notes'; ?>">
        Saisir les notes des étudiants
    </a>
    <a href="<?= ROUTE . '/mes-cours'; ?>">
        Voir mes cours
    </a>
</div>

<div class="role-section">
    <h3>
        Administrateur
    </h3>
    <p>
        En tant qu'administrateur, vous avez accès à toutes les fonctionnalités du système.
    </p>
    <a href="<?= ROUTE . '/gestion-utilisateurs'; ?>">
        Gérer les utilisateurs
    </a>
    <a href="<?= ROUTE . '/config-systeme'; ?>">
        Configurer le système
    </a>
</div>
