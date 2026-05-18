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
    
    .edit-avatar-preview { width: 120px; height: 120px; border-radius: 30px; object-fit: cover; border: 5px solid white; box-shadow: 0 8px 20px rgba(0,0,0,0.1); margin-bottom: 1.5rem; }
</style>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-5 animate-up">
        <div>
            <h1 class="page-title">Edit Sponsor</h1>
            <p class="text-muted m-0">Update account details for <strong><?php echo $data['name']; ?></strong>.</p>
        </div>
        <a href="<?php echo URLROOT; ?>/admin/sponsors" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="fa-solid fa-arrow-left me-2"></i> Back to List
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-7 animate-up delay-1">
            <div class="card-modern">
                <div class="card-header-modern">
                    <h5 class="mb-0"><i class="fa-solid fa-user-pen me-2"></i> Account Information</h5>
                </div>
                <div class="card-body p-4">
                    <form action="<?php echo URLROOT; ?>/admin/edit_sponsor/<?php echo $data['id']; ?>" method="post" enctype="multipart/form-data">
                        <div class="text-center">
                            <?php if(!empty($data['profile_photo'])) : ?>
                                <img src="<?php echo URLROOT . '/' . $data['profile_photo']; ?>" alt="Avatar" class="edit-avatar-preview">
                            <?php endif; ?>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['name']; ?>">
                            <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">
                            <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">New Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current">
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Update Profile Photo</label>
                            <input type="file" name="profile_photo" class="form-control" accept="image/*">
                        </div>

                        <div class="mt-5 pt-3 border-top">
                            <button type="submit" class="btn-save w-100">
                                <i class="fa-solid fa-cloud-arrow-up me-2"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5 animate-up delay-2">
            <div class="card-modern border-danger" style="border: 1px solid #ffd8d6 !important;">
                <div class="card-header-modern bg-danger">
                    <h5 class="mb-0"><i class="fa-solid fa-triangle-exclamation me-2"></i> Danger Zone</h5>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted small">Deleting this sponsor will permanently remove their access and all communication history. This action cannot be undone.</p>
                    <form action="<?php echo URLROOT; ?>/admin/delete_sponsor/<?php echo $data['id']; ?>" method="post" onsubmit="return confirm('Are you sure? This is permanent!')">
                        <button type="submit" class="btn btn-outline-danger w-100 fw-bold rounded-pill">
                            <i class="fa-solid fa-trash-can me-2"></i> Delete Sponsor Permanently
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/layouts/footer.php'; ?>
