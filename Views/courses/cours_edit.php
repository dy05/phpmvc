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
        <form action="<?= ROUTE . '/cours/edit/' . $course->id; ?>" method="POST">
            <input type="hidden" name="_method" value="PUT" />

            <?php if (! empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <?= "<li>$error</li>"; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label for="nom" class="form-label">
                    Nom du cours
                </label>
                <input class="form-control" type="text" id="nom" name="nom" placeholder="RGPD" value="<?= $course->nom ?? null; ?>" required />
            </div>

            <div class="form-group">
                <label for="code" class="form-label">
                    Code du cours
                </label>
                <input class="form-control" type="text" id="code" name="code" placeholder="RGPD" value="<?= $course->code ?? null; ?>" />
            </div>

            <div class="form-group">
                <label for="duree" class="form-label">
                    Duree du cours (en heures)
                </label>
                <input class="form-control" type="text" id="duree" name="duree" placeholder="24" value="<?= $course->duree ?? null; ?>" />
            </div>

            <div class="form-group">
                <label for="niveau" class="form-label">
                    Niveau du cours (1, 2, 3, ...)
                </label>
                <input class="form-control" type="text" id="niveau" name="niveau" placeholder="1" value="<?= $course->niveau ?? null; ?>" />
            </div>

            <div class="flex">
                <button class="btn btn-info" type="submit">
                    Modifier
                </button>
                <button class="btn btn-secondary ml-auto" type="reset">
                    Reset
                </button>
            </div>
        </form>
    </div>
</div>
