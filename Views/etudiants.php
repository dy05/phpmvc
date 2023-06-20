<?php
$template = 'layouts/base.php';
$title = "Gestion des etudiants";
?>

<div class="d-flex mb-3">
    <h2>Gestion des etudiants</h2>
    <a href="<?= ROUTE . '/etudiants/new'; ?>" class="btn btn-primary ml-auto">
        <i class="fa fa-plus"></i>
        Ajouter un etudiant
    </a>
</div>

<div class="col-md-12">
    <div class="content-panel">
        <table class="table table-striped table-advance table-hover">
            <thead>
            <tr>
                <th>Noms</th>
                <th>Prenoms</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($etudiants as $student): ?>
                <tr>
                    <td><?= ucfirst($student->nom); ?></td>
                    <td><?= ucfirst($student->prenom); ?></td>
                    <td><?= ucfirst($student->email); ?></td>
                    <td>
                        <a href="<?= ROUTE . '/etudiants/'.$student->id; ?>" class="btn btn-outline-primary btn-xs">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a href="<?= ROUTE . '/etudiants/delete/'.$student->id; ?>" class="btn btn-danger btn-xs">
                            <i class="fa fa-trash-alt "></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
