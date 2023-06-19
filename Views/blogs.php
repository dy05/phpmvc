<?php
    $title = 'Blogs';
    $template = 'layouts/app.php';
?>
<h2>Blogs</h2>

<?php

if (isset($_SESSION['auth']) && (string)($_SESSION['auth'])->id === '1'):
?>
    <form action="<?= ROUTE . '/blogs/new'; ?>" method="post">
        <input type="text" name="name" required><br/>
        <input type="text" name="slug" required><br/>
        <textarea name="contenu" cols="30" rows="10" placeholder="Entrer le contenu" required></textarea>
        <br/>
        <hr/>
        <br/>
        <input type="submit" name="send" value="Ajouter">
        <br/>
        <br/>
        <br/>
    </form>
<?php
endif;

foreach ($blogs as $key => $blog):
    if ($key !== 0) {
        echo "<hr/>";
    }
    print_r($blog);
if (isset($_SESSION['auth']) && (string)($_SESSION['auth'])->id === '1'):
?>
    <form action="<?= ROUTE . '/blogs/delete/'.$blog->id; ?>" method="post">
        <input type="hidden" name="deleteid" value="<?= $blog->id; ?>">
        <button type="submit" name="delete">supprimer l'article</button>
    </form>
<?php
endif;
?>
<a href="<?= ROUTE . '/blogs/' . $blog->id; ?>">Voir l'article</a>
<?php
endforeach;

