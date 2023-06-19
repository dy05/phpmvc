<?php
$template = 'layouts/base.php';
$title = "Gestion des cours";
?>

<div class="d-flex mb-3">
    <h2>Gestion des cours</h2>
    <a href="<?= ROUTE . '/cours'; ?>" class="btn btn-primary ml-auto">
        <i class="fa fa-list"></i>
        Liste des cours
    </a>
</div>

<div class="col-md-12">
    <div class="content-panel">
        <div>
            <h3>Nom</h3>
            <p>
                <?= $course->nom; ?>
            </p>
        </div>
        <div>
            <h3>Code</h3>
            <p>
                <?= $course->code ?? null; ?>
            </p>
        </div>
        <div>
            <h3>Duree</h3>
            <p>
                <?= $course->duree ?? null; ?>
            </p>
        </div>
        <div>
            <h3>Niveau</h3>
            <p>
                <?= $course->niveau ?? null; ?>
            </p>
        </div>

        <div class="mt-5">
            <a href="<?= ROUTE . '/cours/edit/' . $course->id; ?>" class="btn btn-primary">
                Editer
            </a>
        </div>
    </div>
</div>
