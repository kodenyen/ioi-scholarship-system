<?php require APPROOT . '/views/layouts/header.php'; ?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-white mt-5 shadow-sm border-0 rounded-4 p-5">
            <div class="text-center mb-4">
                <?php 
                    $logo = getSetting('site_logo');
                    if($logo && file_exists(APPROOT . '/public/' . $logo)) : 
                ?>
                    <img src="<?php echo URLROOT . '/' . $logo; ?>" alt="Logo" class="mb-3" style="max-height: 80px; width: auto;">
                <?php endif; ?>
                <h2 class="fw-bold">Admin Login</h2>
                <p class="text-muted small">Please enter your credentials to manage the platform.</p>
            </div>
            <form action="<?php echo URLROOT; ?>/admin/login" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address: <sup>*</sup></label>
                    <input type="email" name="email" class="form-control <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">
                    <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password: <sup>*</sup></label>
                    <input type="password" name="password" class="form-control <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['password']; ?>">
                    <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
                </div>
                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary btn-lg" style="background-color: #005BFF !important; border-color: #005BFF !important;">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/layouts/footer.php'; ?>
