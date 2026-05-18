<?php require APPROOT . '/views/layouts/header.php'; ?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5 shadow-sm">
            <h2 class="text-center">Sponsor Login</h2>
            <p class="text-center text-muted">Please enter your credentials to access your dashboard</p>
            <form action="<?php echo URLROOT; ?>/sponsor/login" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address: <sup>*</sup></label>
                    <input type="email" name="email" class="form-control form-control-lg <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>" required>
                    <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password: <sup>*</sup></label>
                    <input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" required>
                    <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
                </div>
                <div class="d-grid gap-2">
                    <input type="submit" class="btn btn-primary btn-lg" value="Login">
                </div>
            </form>
            <div class="mt-3 text-center">
                <small class="text-muted">Or use the special access link provided by the admin.</small>
            </div>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/layouts/footer.php'; ?>
