<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- Scripts -->
    <script src="<?= ROUTE . '/js/app.js'; ?>" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="<?= ROUTE . '/css/app.css'; ?>" rel="stylesheet">
    <link href="<?= ROUTE . '/css/all.min.css'; ?>" rel="stylesheet">
    <title><?= isset($title) ? $title : 'RBAC' ?></title>
</head>
<body>
<div id="app">
    <main>
        <div class="container mt-3">
            <?= isset($content) ? $content : '<div class="text-center"><h1>Welcome</h1></div>' ?>
        </div>
    </main>
</body>
</html>
