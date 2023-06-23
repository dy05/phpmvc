<?php
$template = 'layouts/base.php';
$title = "Gestion des salles";
?>

<div class="d-flex mb-3">
    <h2>Gestion des salles</h2>
    <a href="<?= ROUTE . '/salles/new'; ?>" class="btn btn-primary ml-auto">
        <i class="fa fa-plus"></i>
        Ajouter une salle
    </a>
</div>

<div class="col-md-12">
    <div class="content-panel">
        <table class="table table-striped table-advance table-hover">
            <thead>
            <tr>
                <th>Nom</th>
                <th>Capacité</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($salles as $salle): ?>
                <tr>
                    <td><?= ucfirst($salle->nom); ?></td>
                    <td><?= ucfirst($salle->capacite ?? ''); ?></td>
                    <td>
                        <a href="<?= ROUTE . '/salles/salle/' . $salle->id; ?>" class="btn btn-info btn-xs">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a href="<?= ROUTE . '/salles/edit/' . $salle->id; ?>" class="btn btn-outline-primary btn-xs">
                            <i class="fa fa-pencil-alt"></i>
                        </a>
                        <form action="<?= ROUTE . '/salles/salle/' . $salle->id; ?>" method="POST" style="display: inline-block" onsubmit="return confirm('Voulez vous vraiment supprimer cette salle ?')">
                            <input type="hidden" name="_method" value="DELETE" />
                            <button type="submit" href="<?= ROUTE . '/salles/salle/' . $salle->id; ?>" class="btn btn-danger btn-xs">
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
