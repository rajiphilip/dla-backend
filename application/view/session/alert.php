<?php if (isset($_GET['msg'])) { ?>
    <div class="alert alert-success  alert-block" role="alert"><a class="close" data-dismiss="alert" href="#">×</a>
        <h4 class="alert-heading">Thank you!</h4>
        <?= $_GET['msg']; ?>
    </div>
<?php } ?>

<?php if (isset($_GET['dan'])) { ?>
    <div class="alert alert-danger  alert-block" role="alert"><a class="close" data-dismiss="alert" href="#">×</a>
        <h4 class="alert-heading">Oh snap!!</h4>
        <?= $_GET['dan']; ?>
    </div>
<?php } ?>

<?php if (isset($_GET['inf'])) { ?>
    <div class="alert alert-info  alert-block" role="alert"><a class="close" data-dismiss="alert" href="#">×</a>
        <h4 class="alert-heading">Heads up!</h4>
        <?= $_GET['inf']; ?>
    </div>
<?php } ?>

<?php if (isset($_GET['wan'])) { ?>
    <div class="alert alert-warning  alert-block" role="alert"><a class="close" data-dismiss="alert" href="#">×</a>
        <h4 class="alert-heading">Warning!</h4>
        <?= $_GET['wan']; ?>
    </div>
<?php } ?>


