<?php
$title = 'login';
$template = 'layouts/app.php';
?>

<h1>S'inscrire</h1>
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <p>Des erreurs sont survenus lors de l'envoie de votre requete</p>
        <ul class="">
            <?php foreach ($errors as $error): ?>
                <!--                <li class="list-group-item bg-transparent border-0 align-items-end mr-0">--><?//= $error; ?><!--</li>-->
                <li class=""><?= $error; ?></li>
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
        <label for="">Pseudo</label>
        <input type="text" name="username" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="">Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="">Mot de passe</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="">Confirmatipn de Mot de passe</label>
        <input type="password" name="password_confirm" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">S'inscrire</button>
</form>

