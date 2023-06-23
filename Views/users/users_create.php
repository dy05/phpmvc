<?php
$template = 'layouts/base.php';
$title = "Gestion des utilisateurs";
?>

<div class="d-flex mb-3">
    <h2>Gestion des utilisateurs</h2>
    <a href="<?= ROUTE . '/users'; ?>" class="btn btn-primary ml-auto">
        <i class="fa fa-list"></i>
        Liste des utilisateurs
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
                    Nom de l'utilisateur
                </label>
                <input class="form-control" type="text" id="nom" name="nom" placeholder="Doe" value="<?= $old['nom'] ?? null; ?>" required />
            </div>

            <div class="form-group">
                <label for="prenom" class="form-label">
                    Prenom de l'utilisateur
                </label>
                <input class="form-control" type="text" id="prenom" name="prenom" placeholder="John" value="<?= $old['prenom'] ?? null; ?>" required />
            </div>

            <div class="form-group">
                <label for="mdp" class="form-label">
                    Mot de passe de l'utilisateur
                </label>
                <input class="form-control" type="password" id="mdp" name="mdp" placeholder="******" required />
            </div>

            <div class="form-group">
                <label for="mdp_confirm" class="form-label">
                    Confirmer mot de passe de l'utilisateur
                </label>
                <input class="form-control" type="password" id="mdp_confirm" name="mdp_confirm" placeholder="******" required />
            </div>

            <div class="form-group hidden">
                <label for="email" class="form-label">
                    Email de l'utilisateur
                </label>
                <input class="form-control" type="text" id="email" name="email" placeholder="John.Doe@email.com" value="<?= $old['email'] ?? null; ?>" />
            </div>

            <div class="form-group">
                <label for="role_id" class="form-label">
                    Role de l'utilisateur
                </label>
                <select name="role_id" id="role_id" class="form-control">
                    <option value="" selected disabled>
                        Selectionner un role
                    </option>
                    <?php foreach ($roles as $role): ?>
                    <option value="<?= $role->id; ?>">
                        <?= $role->nom; ?>
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
