<?php
$template = 'layouts/base.php';
$title = "Gestion des utilisateurs";
?>

<div class="d-flex mb-3">
    <h2>Gestion des utilisateurs</h2>
    <a href="<?= ROUTE . '/users/new'; ?>" class="btn btn-primary ml-auto">
        <i class="fa fa-plus"></i>
        Ajouter un utilisateur
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
                <th>Role</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($users as $user): ?>
                <tr>
                    <td><?= ucfirst($user->nom); ?></td>
                    <td><?= ucfirst($user->prenom); ?></td>
                    <td><?= ucfirst($user->email); ?></td>
                    <td><?= ucfirst($user->role ?? ''); ?></td>
                    <td>
                        <a href="<?= ROUTE . '/users/user/' . $user->id; ?>" class="btn btn-info btn-xs">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a href="<?= ROUTE . '/users/edit/' . $user->id; ?>" class="btn btn-outline-primary btn-xs">
                            <i class="fa fa-pencil-alt"></i>
                        </a>
                        <form action="<?= ROUTE . '/users/user/' . $user->id; ?>" method="POST" style="display: inline-block" onsubmit="return confirm('Voulez vous vraiment supprimer cet utilisateur ?')">
                            <input type="hidden" name="_method" value="DELETE" />
                            <button type="submit" href="<?= ROUTE . '/users/user/' . $user->id; ?>" class="btn btn-danger btn-xs">
                                <i class="fa fa-trash-alt "></i>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
