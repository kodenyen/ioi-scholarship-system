<?php require APPROOT . '/views/layouts/header.php'; ?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-white mt-5 shadow-sm">
            <h2 class="text-center mb-4">Student Login</h2>
            <p class="text-center">Enter your registered email to access your dashboard</p>
            <form action="<?php echo URLROOT; ?>/student/login" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address:</label>
                    <input type="email" name="email" class="form-control <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" required>
                    <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                </div>
                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary btn-lg">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/layouts/footer.php'; ?>
