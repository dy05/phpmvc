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
        <form action="<?= ROUTE . '/formations/edit/' . $formation->id; ?>" method="POST">
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
                    Nom de la formation
                </label>
                <input class="form-control" type="text" id="nom" name="nom" placeholder="Architecte WEB" value="<?= $formation->nom ?? null; ?>" required />
            </div>

            <div class="form-group">
                <label for="code" class="form-label">
                    Code de la formation
                </label>
                <input class="form-control" type="text" id="code" name="code" placeholder="WEB_ARCHI" value="<?= $formation->code ?? null; ?>" />
            </div>

            <div class="form-group">
                <label for="duree" class="form-label">
                    Duree de la formation
                </label>
                <input class="form-control" type="text" id="duree" name="duree" placeholder="24" value="<?= $formation->duree ?? null; ?>" />
            </div>

            <div class="form-group">
                <label for="niveau" class="form-label">
                    Niveau de la formation
                </label>
                <select name="niveau" id="niveau" class="form-control">
                    <option value="" <?= empty($formation->niveau ?? '') ? 'selected' : '' ;?> disabled>
                        Selectionner un niveau
                    </option>
                    <?php foreach(['Bac + 1', 'Bac + 2', 'Bac + 3'] as $item): ?>
                        <option value="<?= $item; ?>" <?= isset($formation->niveau) && $formation->niveau === $item ? 'selected' : '' ;?>>
                            <?= $item; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="courses" class="form-label">
                    Cours
                </label>
                <select name="courses[]" id="courses" class="form-control" multiple>
                    <option value="" disabled>
                        Selectionner un ou plusieurs courses
                    </option>
                    <?php foreach($courses as $course): ?>
                        <option value="<?= $course->id; ?>" <?= in_array($course->id, $formationCourseIds) ? 'selected' : ''; ?>>
                            <?= $course->nom; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
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
