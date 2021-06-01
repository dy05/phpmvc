<?php
    if ($error !== null) {
        $title = 'Blogs | Page Not Found';
    }else{
        $title = ucfirst($blog->name);
    }
    $template = 'layouts/app.php';
?>

<?php
if ($error === null):
?>
<h2><?= $blog->name; ?></h2>
<?php
else:
?>
<strong>
    Article Not Found
</strong>
<?php
endif;
