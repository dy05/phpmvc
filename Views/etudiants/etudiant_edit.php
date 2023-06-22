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
        <form action="<?= ROUTE . '/etudiants/edit/' . $etudiant->id; ?>" method="POST">
            <input type="hidden" name="_method" value="PUT" />

            <?php if (! empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <?= "<li>$error</li>"; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label for="nom" class="form-label">
                    Nom
                </label>
                <input class="form-control" type="text" id="nom" name="nom" placeholder="RGPD" value="<?= $old['nom'] ?? null; ?>" required />
            </div>

            <div class="form-group">
                <label for="prenom" class="form-label">
                    Prenom
                </label>
                <input class="form-control" type="text" id="prenom" name="prenom" placeholder="RGPD" value="<?= $old['prenom'] ?? null; ?>" required />
            </div>

            <div class="form-group">
                <label for="email" class="form-label">
                    Email
                </label>
                <input class="form-control" type="text" id="email" name="email" placeholder="RGPD" value="<?= $old['email'] ?? null; ?>" required />
            </div>

            <div class="form-group">
                <label for="mdp" class="form-label">
                    Mot de passe
                </label>
                <input class="form-control" type="text" id="mdp" name="mdp" placeholder="RGPD" value="<?= $old['email'] ?? null; ?>" required />
            </div>

            <div class="form-group">
                <label for="status" class="form-label">
                    Status
                </label>
                <input class="form-control" type="text" id="status" name="status" placeholder="RGPD" value="<?= $old['status'] ?? null; ?>" required />
            </div>

            <div class="flex">
                <button class="btn btn-info" type="submit">
                    Modifier
                </button>
                <button class="btn btn-secondary ml-auto" type="reset">
                    Reset
                </button>
            </div>
        </form>
    </div>
</div>
