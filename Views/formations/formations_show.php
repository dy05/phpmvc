<?php
$template = 'layouts/base.php';
$title = "Gestion des formations";
?>

<div class="d-flex mb-3">
    <h2>Gestion des formations</h2>
    <a href="<?= ROUTE . '/formations'; ?>" class="btn btn-primary ml-auto">
        <i class="fa fa-list"></i>
        Liste des formations
    </a>
</div>

<div class="col-md-12">
    <div class="content-panel">
        <div>
            <h3>Nom</h3>
            <p>
                <?= $formation->nom; ?>
            </p>
        </div>
        <div>
            <h3>Code</h3>
            <p>
                <?= $formation->code ?? null; ?>
            </p>
        </div>
        <div>
            <h3>Duree</h3>
            <p>
                <?= $formation->duree ?? null; ?>
            </p>
        </div>
        <div>
            <h3>Niveau</h3>
            <p>
                <?= $formation->niveau ?? null; ?>
            </p>
        </div>

        <div class="mt-5 flex justify-between">
            <a href="<?= ROUTE . '/formations/edit/' . $formation->id; ?>" class="btn btn-primary">
                <i class="fa fa-pencil-alt mr-2"></i>
                Editer
            </a>

            <form action="<?= ROUTE . '/formations/delete/'.$formation->id; ?>" method="POST" style="display: inline-block" onsubmit="return confirm('Voulez vous vraiment supprimer cette formation ?')">
                <input type="hidden" name="_method" value="DELETE" />
                <button type="submit" href="<?= ROUTE . '/formations/delete/'.$formation->id; ?>" class="btn btn-danger btn-xs">
                    <i class="fa fa-trash-alt mr-2"></i>
                    Supprimer
                </button>
            </form>
        </div>
    </div>
</div>
