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
        <div>
            <h3>Nom</h3>
            <p>
                <?= $user->nom; ?>
            </p>
        </div>
        <div>
            <h3>Prenom</h3>
            <p>
                <?= $user->prenom; ?>
            </p>
        </div>
        <div>
            <h3>Email</h3>
            <p>
                <?= $user->email; ?>
            </p>
        </div>
        <div>
            <h3>Formations</h3>
            <div>
                <ul>
                    <li>
                        => Formation (active)
                    </li>
                    <li>
                        => Formation
                    </li>
                </ul>
            </div>
        </div>
        <div>
            <h3>Planning</h3>
            <div>
                <ul>
                    <li>
                        => Date 1
                    </li>
                </ul>
            </div>
        </div>
        <div>
            <h3>Absences</h3>
            <div>
                <ul>
                    <li>
                        => Date 1
                    </li>
                </ul>
            </div>
        </div>
        <div class="mt-5 flex justify-between">
            <a href="<?= ROUTE . '/users/edit/' . $user->id; ?>" class="btn btn-primary">
                <i class="fa fa-pencil-alt mr-2"></i>
                Editer
            </a>

            <form action="<?= ROUTE . '/users/user/' . $user->id; ?>" method="POST" style="display: inline-block" onsubmit="return confirm('Voulez vous vraiment supprimer cet utilisateur ?')">
                <input type="hidden" name="_method" value="DELETE" />
                <button type="submit" href="<?= ROUTE . '/users/user/' . $user->id; ?>" class="btn btn-danger btn-xs">
                    <i class="fa fa-trash-alt mr-2"></i>
                    Supprimer
                </button>
            </form>
        </div>
    </div>
</div>
