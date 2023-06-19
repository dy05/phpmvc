<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title><?= isset($title) ? $title : 'Dashboard' ?></title>
    <link href="style.css" rel="stylesheet" />
</head>

<body>
<?= isset($content) ? $content : '<div class="align-center"><h1>Welcome to Dashboard</h1></div>' ?>
</body>
</html>