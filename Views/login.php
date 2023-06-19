<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <title><?= $title ?? 'Mvc App'; ?></title>

    <!-- Bootstrap CSS -->
    <link href="<?= ROUTE . '/css/app.css'; ?>" rel="stylesheet">
    <link href="<?= ROUTE . '/css/main.css'; ?>" rel="stylesheet">
    <link href="<?= ROUTE . '/css/all.min.css'; ?>" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="<?= ROUTE . '/css/app.css'; ?>" rel="stylesheet">
</head>
<body>
<div id="app">
    <div class="container">
        <div class="col-md-6 mt-5 mx-auto">
            <div class="card">
                <div class="card-body">
                    <form class="form-login" action="" method="post">
                        <h2 class="form-login-heading" >Sign In</h2>

                        <?php if (! empty($errors)): ?>
                            <div class="alert alert-danger">
                                <p>
                                    <ul>
                                        <?php foreach ($errors as $error): ?>
                                            <?= "<li>{$error}</li>"; ?>
                                        <?php endforeach; ?>
                                    </ul>
                                </p>
                            </div>
                        <?php endif; ?>

                        <div class="login-wrap mt-4">
                            <div class="form-group mb-3">
                                <label for="email">
                                    Email
                                </label>
                                <input type="text" class="form-control" id="email" name="email" value="<?= $old['email'] ?? '' ?>" placeholder="email@email.com" required />
                            </div>
                            <div class="form-group mb-3">
                                <label for="password">
                                    Password
                                </label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="********" required />
                            </div>
                            <div class="form-group d-flex">
                                <input type="checkbox" class="form-check-inline" id="remember" name="remember" value="1" <?= isset($old['remember']) ? 'checked' : '';?>/>
                                <label for="remember" class="mt-2">
                                    Remember Me
                                </label>
                            </div>
                            <!--                <div>-->
                            <!--                    <span class="pull-right">-->
                            <!--                        <a data-toggle="modal" href="#myModal"> Forgot Password?</a>-->
                            <!--                    </span>-->
                            <!--                </div>-->
                            <hr>
                            <div class="text-center">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fa fa-sign-in-alt"></i>
                                    SIGN IN
                                </button>
                                <hr>
                                <a href="<?= ROUTE . '/'; ?>">
                                    Home page
                                </a>
                            </div>
                            <!--                <div class="registration">-->
                            <!--                    Don't have an account yet?<br/>-->
                            <!--                    <a class="" href="<==?= ROUTE . '/register'; ?==>">-->
                            <!--                        Create an account-->
                            <!--                    </a>-->
                            <!--                </div>-->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= ROUTE . '/js/app.js'; ?>"></script>
<script src="<?= ROUTE . '/js/main.js'; ?>"></script>

</body>
</html>
