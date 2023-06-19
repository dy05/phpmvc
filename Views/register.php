<?php
$title = 'Register';
$template = 'layouts/app.php';
?>

<h1>
    S'inscrire
</h1>
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <p>
            Des erreurs sont survenus lors de l'envoi de votre requete
        </p>
        <ul class="">
            <?php foreach ($errors as $error): ?>
                <!--                <li class="list-group-item bg-transparent border-0 align-items-end mr-0">--><?//= $error; ?><!--</li>-->
                <li class="">
                    <?= $error; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php elseif (isset($alert)): ?>
    <div class="alert alert-success">
        <p>L'inscription s'est terminee avec succes, veuillez verifier votre boite email.</p>
    </div>
<?php endif; ?>

<form action="" method="post">
    <div class="form-group">
        <label for="nom">
            Nom
        </label>
        <input type="text" name="nom" id="nom" class="form-control" value="<?= $old['nom'] ?? null; ?>" required />
    </div>
    <div class="form-group">
        <label for="prenom">
            Prenom
        </label>
        <input type="text" name="prenom" id="prenom" class="form-control" value="<?= $old['prenom'] ?? null; ?>" required />
    </div>
    <div class="form-group">
        <label for="mdp">
            Mot de passe
        </label>
        <input type="password" name="mdp" id="mdp" class="form-control" required />
    </div>
    <div class="form-group">
        <label for="mdp_confirm">
            Confirmer Mot de passe
        </label>
        <input type="password" name="mdp_confirm" id="mdp_confirm" class="form-control" required />
    </div>
    <button type="submit" class="btn btn-primary">
        S'inscrire
    </button>
</form>
