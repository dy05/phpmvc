<?php
$template = 'layouts/app.php';
$title = 'Users List';
?>

<!--<section id="main-content">-->
<!--    <section class="wrapper">-->
<!--        <div class="row-mt"></br></br></br>-->

<div class="col-md-12">
    <div class="content-panel">
        <div class="d-flex mb-3">
            <h3><i class="fa fa-angle-right"></i>Users Lists </h3>
            <a href="<?= ROUTE . '/users/new'; ?>" class="btn btn-primary ml-auto">
                <i class="fa fa-plus"></i>
                Ajouter un user
            </a>
        </div>
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
            <?php if (isset($users)): ?>
                <?php foreach($users as $user): ?>
                    <tr>
                        <td><?= ucfirst($user->nom); ?></td>
                        <td><?= ucfirst($user->prenom); ?></td>
                        <td><?= ucfirst($user->email); ?></td>
                        <td>
                            <a href="<?= ROUTE . '/users/'.$user->id; ?>" class="btn btn-outline-primary btn-xs">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="<?= ROUTE . '/users/delete/'.$user->id; ?>" class="btn btn-danger btn-xs">
                                <i class="fa fa-trash-alt "></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!--        </div>-->
<!--    </section>-->
<!--</section>-->
