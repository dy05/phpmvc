<?php
$template = 'layouts/app.php';
?>

<!--<section id="main-content">-->
<!--    <section class="wrapper">-->
<!--        <div class="row-mt"></br></br></br>-->

<div class="col-md-8">

    <div class="card">
        <div class="card-body">
            <form method="POST" class="row" action="">
                <div class="container">
                    <h3 class="text-primary">Add new User</h3>

                    <br/>

                    <div class="form-group">
                        <label for="nom">
                            Nom
                        </label>
                        <input type="text" name="nom" id="nom" required />
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                        <i class="fa fa-check"></i>
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--        </div>-->
<!--    </section>-->
<!--</section>-->
