<?php
$template = 'layouts/base.php';
$title = "Gestion des etudiants";
?>

<h2>Gestion des etudiants</h2>


<table>
    <thead>
    <tr>
        <th>Noms</th>
        <th>Prenoms</th>
        <th>Email</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($etudiants as $etudiant):?>
    <tr>
        <td>
            <?= ((object)$etudiant)->nom; ?>
        </td>
        <td>
            <?= ((object)$etudiant)->prenom; ?>
        </td>
        <td>
            <?= ((object)$etudiant)->email; ?>
        </td>
        <td>
            <?= ((object)$etudiant)->id; ?>
        </td>
    </tr>
    <?php endforeach; ?>

    </tbody>
</table>



