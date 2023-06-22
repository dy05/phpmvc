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
        <form action="" method="POST">
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
                <input class="form-control" type="text" id="nom" name="nom" placeholder="Architecte WEB" value="<?= $old['nom'] ?? null; ?>" required />
            </div>

            <div class="form-group">
                <label for="code" class="form-label">
                    Code de la formation
                </label>
                <input class="form-control" type="text" id="code" name="code" placeholder="WEB_ARCHI" value="<?= $old['code'] ?? null; ?>" />
            </div>

            <div class="form-group">
                <label for="duree" class="form-label">
                    Duree de la formation (en mois)
                </label>
                <input class="form-control" type="text" id="duree" name="duree" placeholder="24" value="<?= $old['duree'] ?? null; ?>" />
            </div>

            <div class="form-group">
                <label for="niveau" class="form-label">
                    Niveau de la formations (bac +1, +2, etc...)
                </label>
                <select name="niveau" id="niveau" class="form-control">
                    <option value="" <?= empty($old['niveau'] ?? '') ? 'selected' : '' ;?> disabled>
                        Selectionner un niveau
                    </option>
                    <?php foreach(['Bac + 1', 'Bac + 2', 'Bac + 3'] as $item): ?>
                    <option value="<?= $item; ?>" <?= isset($old['niveau']) && $old['niveau'] === $item ? 'selected' : '' ;?>>
                        <?= $item; ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="flex">
                <button class="btn btn-primary" type="submit">
                    Creer
                </button>
                <button class="btn btn-secondary ml-auto" type="reset">
                    Reset
                </button>
            </div>
        </form>
    </div>
</div>
