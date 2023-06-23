<?php
$template = 'layouts/base.php';
$title = "Gestion des enseignants";
?>

<div class="d-flex mb-3">
    <h2>Gestion des enseignants</h2>
    <a href="<?= ROUTE . '/users/new/teacher'; ?>" class="btn btn-primary ml-auto">
        <i class="fa fa-plus"></i>
        Ajouter un enseignant
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
            <?php foreach($enseignants as $user): ?>
                <tr>
                    <td><?= ucfirst($user->nom); ?></td>
                    <td><?= ucfirst($user->prenom); ?></td>
                    <td><?= ucfirst($user->email); ?></td>
                    <td>
                        <a href="<?= ROUTE . '/users/user/' . $user->id; ?>" class="btn btn-outline-primary btn-xs">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a href="<?= ROUTE . '/users/user/' . $user->id; ?>" class="btn btn-danger btn-xs">
                            <i class="fa fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
