<?php
$template = 'layouts/base.php';
$title = "Gestion des etudiants";
?>

<div class="d-flex mb-3">
    <h2>Gestion des etudiants</h2>
    <a href="<?= ROUTE . '/etudiants'; ?>" class="btn btn-primary ml-auto">
        <i class="fa fa-list"></i>
        Liste des etudiants
    </a>
</div>

<div class="col-md-12">
    <div class="content-panel">
        <div>
            <h3>Nom</h3>
            <p>
                <?= $etudiant->nom; ?>
            </p>
        </div>
        <div>
            <h3>Prenom</h3>
            <p>
                <?= $etudiant->prenom; ?>
            </p>
        </div>
        <div>
            <h3>Email</h3>
            <p>
                <?= $etudiant->email; ?>
            </p>
        </div>
        <div>
            <h3>Mot de passe</h3>
            <p>
                <?= $etudiant->mdp; ?>
            </p>
        </div>
        <div>
            <h3>Status</h3>
            <p>
                <?= $etudiant->status; ?>
            </p>
        </div>

        <div class="mt-5">
            <a href="<?= ROUTE . '/etudiant/edit/' . $etudiant->id; ?>" class="btn btn-primary">
                Editer
            </a>
        </div>
    </div>
</div>
