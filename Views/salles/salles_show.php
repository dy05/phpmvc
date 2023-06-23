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
        <div>
            <h3>Nom</h3>
            <p>
                <?= $salle->nom; ?>
            </p>
        </div>
        <div>
            <h3>Capacité</h3>
            <p>
                <?= $salle->capacite ?? null; ?>
            </p>
        </div>
        <div class="mt-5 flex justify-between">
            <a href="<?= ROUTE . '/salles/edit/' . $salle->id; ?>" class="btn btn-primary">
                <i class="fa fa-pencil-alt mr-2"></i>
                Editer
            </a>

            <form action="<?= ROUTE . '/salles/salle/' . $salle->id; ?>" method="POST" style="display: inline-block" onsubmit="return confirm('Voulez vous vraiment supprimer cette salle ?')">
                <input type="hidden" name="_method" value="DELETE" />
                <button type="submit" href="<?= ROUTE . '/salles/salle/' . $salle->id; ?>" class="btn btn-danger btn-xs">
                    <i class="fa fa-trash-alt mr-2"></i>
                    Supprimer
                </button>
            </form>
        </div>
    </div>
</div>
