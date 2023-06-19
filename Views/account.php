<?php
    $template = 'layouts/app.php';
?>
<h2>Bienvenue d'accueil</h2>

<?php

foreach ($users as $key => $user) {
    if ($key !== 0) {
        echo "<hr/>";
    }
    echo $user['username'].' ====>  '.$user['email'].$key;
}
