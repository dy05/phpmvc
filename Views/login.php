<?php
$title = 'Connexion';
$template = 'layouts/base.php';
?>


<div class="container mb-5">
    <div class="col-md-6 mt-5 mx-auto">
        <div class="card border-none">
            <div class="card-body">
                <form class="form-login" action="" method="post">
                    <h2 class="form-login-heading">
                        Sign In
                    </h2>

                    <?php if (! empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php foreach ($errors as $error): ?>
                                    <?= "<li>$error</li>"; ?>
                                <?php endforeach; ?>
                            </ul>
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
                            <input type="checkbox" class="form-check-inline" id="remember" name="remember" value="1" <?= isset($old['remember']) ? 'checked' : '';?> />
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
                            <a href="#">
                                Mot de passe oublie ?
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
