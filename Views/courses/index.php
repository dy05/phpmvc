<?php
$template = 'layouts/base.php';
$title = "Gestion des cours";
?>

<div class="d-flex mb-3">
    <h2>Gestion des cours</h2>
    <a href="<?= ROUTE . '/cours/new'; ?>" class="btn btn-primary ml-auto">
        <i class="fa fa-plus"></i>
        Ajouter un cours
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
            <?php foreach($courses as $course): ?>
                <tr>
                    <td><?= ucfirst($course->nom); ?></td>
                    <td><?= ucfirst($course->code ?? ''); ?></td>
                    <td><?= $course->duree ?? ''; ?></td>
                    <td><?= $course->niveau ?? ''; ?></td>
                    <td>
                        <a href="<?= ROUTE . '/cours/course/'.$course->id; ?>" class="btn btn-info btn-xs">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a href="<?= ROUTE . '/cours/edit/'.$course->id; ?>" class="btn btn-outline-primary btn-xs">
                            <i class="fa fa-pencil-alt"></i>
                        </a>
                        <form action="<?= ROUTE . '/cours/course/'.$course->id; ?>" method="POST" style="display: inline-block" onsubmit="return confirm('Voulez vous vraiment supprimer ce cours ?')">
                            <input type="hidden" name="_method" value="DELETE" />
                            <button type="submit" href="<?= ROUTE . '/cours/course/'.$course->id; ?>" class="btn btn-danger btn-xs">
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
