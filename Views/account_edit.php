<?php
    $template = 'layouts/base.php';
    $title = 'Mon profil';
?>

<div class="d-flex mb-3">
    <h2>Mon profil</h2>
    <a href="<?= ROUTE . '/account'; ?>" class="btn btn-primary ml-auto">
        <i class="fa fa-user-alt"></i>
        Voir mon profil
    </a>
</div>

<div class="col-md-12">
    <div class="content-panel">
        <form action="" method="POST">
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
                    Nom de l'utilisateur
                </label>
                <input class="form-control" type="text" id="nom" name="nom" placeholder="Doe" value="<?= $user->nom ?? null; ?>" required />
            </div>

            <div class="form-group">
                <label for="prenom" class="form-label">
                    Prenom de l'utilisateur
                </label>
                <input class="form-control" type="text" id="prenom" name="prenom" placeholder="John" value="<?= $user->prenom ?? null; ?>" required />
            </div>

            <div class="form-group">
                <label for="mdp" class="form-label">
                    Mot de passe de l'utilisateur
                </label>
                <input class="form-control" type="password" id="mdp" name="mdp" placeholder="******" />
            </div>

            <div class="form-group">
                <label for="mdp_confirm" class="form-label">
                    Confirmer mot de passe de l'utilisateur
                </label>
                <input class="form-control" type="password" id="mdp_confirm" name="mdp_confirm" placeholder="******" />
            </div>

            <div class="form-group">
                <label for="email" class="form-label">
                    Email de l'utilisateur
                </label>
                <input class="form-control" type="text" disabled id="email" name="email" placeholder="John.Doe@email.com" value="<?= $user->email ?? null; ?>" />
            </div>

            <div class="form-group">
                <label for="role_id" class="form-label">
                    Role de l'utilisateur
                </label>
                <select name="role_id" id="role_id" class="form-control">
                    <option value="" selected disabled>
                        Selectionner un role
                    </option>
                    <?php foreach ($roles as $key => $value): ?>
                        <option value="<?= $key; ?>">
                            <?= $value; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="flex">
                <button class="btn btn-primary" type="submit">
                    Modifier
                </button>
                <button class="btn btn-secondary ml-auto" type="reset">
                    Reset
                </button>
            </div>
        </form>
    </div>
</div>
