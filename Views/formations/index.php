<?php
$template = 'layouts/base.php';
$title = "Gestion des formations";
?>

<div class="d-flex mb-3">
    <h2>Gestion des formations</h2>
    <a href="<?= ROUTE . '/formations/new'; ?>" class="btn btn-primary ml-auto">
        <i class="fa fa-plus"></i>
        Ajouter une formation
    </a>
</div>

<div class="col-md-12">
    <div class="content-panel">
        <table class="table table-striped table-advance table-hover">
            <thead>
            <tr>
                <th>Nom</th>
                <th>Code</th>
                <th>Duree</th>
                <th>Niveau</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($formations as $formation): ?>
                <tr>
                    <td><?= ucfirst($formation->nom); ?></td>
                    <td><?= ucfirst($formation->code ?? ''); ?></td>
                    <td><?= $formation->duree ?? ''; ?></td>
                    <td><?= $formation->niveau ?? ''; ?></td>
                    <td>
                        <a href="<?= ROUTE . '/formations/formation/' . $formation->id; ?>" class="btn btn-info btn-xs">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a href="<?= ROUTE . '/formations/edit/' . $formation->id; ?>" class="btn btn-outline-primary btn-xs">
                            <i class="fa fa-pencil-alt"></i>
                        </a>
                        <form action="<?= ROUTE . '/formations/formation/' . $formation->id; ?>" method="POST" style="display: inline-block" onsubmit="return confirm('Voulez vous vraiment supprimer cette formation ?')">
                            <input type="hidden" name="_method" value="DELETE" />
                            <button type="submit" href="<?= ROUTE . '/formations/formation/' . $formation->id; ?>" class="btn btn-danger btn-xs">
                                <i class="fa fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
