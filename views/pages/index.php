<?php require APPROOT . '/views/layouts/header.php'; ?>
<div class="row">
    <div class="col-md-8 mx-auto text-center">
        <h1 class="display-4"><?php echo $data['title']; ?></h1>
        <p class="lead">Secure and moderated communication platform for sponsors and students.</p>
        <hr class="my-4">
        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
            <a href="<?php echo URLROOT; ?>/admin/login" class="btn btn-primary btn-lg px-4 gap-3">Admin Login</a>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/layouts/footer.php'; ?>
