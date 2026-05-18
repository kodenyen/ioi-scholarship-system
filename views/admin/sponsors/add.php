<?php require APPROOT . '/views/layouts/header.php'; ?>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    body { background-color: #f0f2f5; font-family: 'Plus Jakarta Sans', sans-serif; }
    .page-title { font-weight: 800; font-size: 2.2rem; color: #001219; letter-spacing: -1px; }
    .card-modern { background: white; border: none; border-radius: 24px; box-shadow: 0 8px 30px rgba(0,0,0,0.05); overflow: hidden; }
    .card-header-modern { background: linear-gradient(135deg, #2b9348 0%, #005BFF 100%); color: white; padding: 1.5rem 2rem; border: none; }
    .form-label { font-weight: 600; font-size: 0.85rem; color: #444; text-transform: uppercase; letter-spacing: 0.5px; }
    .form-control, .form-select { border-radius: 12px; padding: 0.75rem 1rem; border: 1px solid #e0e0e0; background-color: #f8f9fa; transition: all 0.3s; }
    .form-control:focus { background-color: white; border-color: #005BFF; box-shadow: 0 0 0 4px rgba(0,91,255,0.1); }
    .btn-save { background: #005BFF; color: white; border: none; border-radius: 12px; padding: 12px 30px; font-weight: 700; transition: all 0.3s; }
    .btn-save:hover { background: #0046cc; transform: translateY(-2px); }
</style>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-5 animate-up">
        <div>
            <h1 class="page-title">Add Sponsor</h1>
            <p class="text-muted m-0">Create a new scholarship sponsor account.</p>
        </div>
        <a href="<?php echo URLROOT; ?>/admin/sponsors" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="fa fa-times me-2"></i> Cancel
        </a>
    </div>

    <div class="row">
        <div class="col-lg-6 mx-auto animate-up delay-1">
            <div class="card-modern">
                <div class="card-header-modern">
                    <h5 class="mb-0"><i class="fa-solid fa-user-plus me-2"></i> Sponsor Details</h5>
                </div>
                <div class="card-body p-4">
                    <form action="<?php echo URLROOT; ?>/admin/add_sponsor" method="post" enctype="multipart/form-data">
                        <div class="mb-4">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" placeholder="e.g. John Doe" value="<?php echo $data['name']; ?>">
                            <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" placeholder="sponsor@example.com" value="<?php echo $data['email']; ?>">
                            <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Account Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Create a secure password" required>
                            <small class="text-muted">Sponsor will use this for traditional login.</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Profile Photo</label>
                            <input type="file" name="profile_photo" class="form-control" accept="image/*">
                        </div>

                        <div class="mt-5 pt-3 border-top">
                            <button type="submit" class="btn-save w-100">
                                <i class="fa-solid fa-check-circle me-2"></i> Create Sponsor Account
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/layouts/footer.php'; ?>
