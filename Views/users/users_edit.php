<?php
$template = 'layouts/base.php';
$title = "Gestion des salles";
?>

<div class="d-flex mb-3">
    <h2>Gestion des salles</h2>
    <a href="<?= ROUTE . '/salles'; ?>" class="btn btn-primary ml-auto">
        <i class="fa fa-list"></i>
        Liste des salles
    </a>
</div>

<div class="col-md-12">
    <div class="content-panel">
        <form action="<?= ROUTE . '/salles/edit/' . $salle->id; ?>" method="POST">
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
                    Nom de la salle
                </label>
                <input class="form-control" type="text" id="nom" name="nom" placeholder="Salle 1" value="<?= $salle->nom ?? null; ?>" required />
            </div>

            <div class="form-group">
                <label for="capacite" class="form-label">
                    Capacité de la salle
                </label>
                <input class="form-control" type="text" id="capacite" name="capacite" placeholder="ex: 30" value="<?= $salle->capacite ?? null; ?>" />
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
