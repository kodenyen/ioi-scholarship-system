<?php require APPROOT . '/views/layouts/header.php'; ?>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    body { background-color: #f0f2f5; font-family: 'Plus Jakarta Sans', sans-serif; }
    .page-title { font-weight: 800; font-size: 2.2rem; color: #001219; letter-spacing: -1px; }
    .card-modern { background: white; border: none; border-radius: 24px; box-shadow: 0 8px 30px rgba(0,0,0,0.05); overflow: hidden; }
    .card-header-modern { background: #001219; color: white; padding: 1.5rem 2rem; border: none; }
    .form-label { font-weight: 600; font-size: 0.85rem; color: #444; text-transform: uppercase; letter-spacing: 0.5px; }
    .form-control, .form-select { border-radius: 12px; padding: 0.75rem 1rem; border: 1px solid #e0e0e0; background-color: #f8f9fa; transition: all 0.3s; }
    .form-control:focus { background-color: white; border-color: #005BFF; box-shadow: 0 0 0 4px rgba(0,91,255,0.1); }
    .btn-save { background: #005BFF; color: white; border: none; border-radius: 12px; padding: 12px 30px; font-weight: 700; transition: all 0.3s; }
    .btn-save:hover { background: #0046cc; transform: translateY(-2px); }
</style>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-5 animate-up">
        <div>
            <h1 class="page-title">Edit Beneficiary</h1>
            <p class="text-muted m-0">Update information for <strong><?php echo $data['first_name']; ?></strong>.</p>
        </div>
        <a href="<?php echo URLROOT; ?>/admin/students" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="fa-solid fa-arrow-left me-2"></i> Back to List
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-8 animate-up delay-1">
            <div class="card-modern mb-4">
                <div class="card-header-modern">
                    <h5 class="mb-0"><i class="fa-solid fa-user-pen me-2"></i> Personal & Academic Details</h5>
                </div>
                <div class="card-body p-4">
                    <form action="<?php echo URLROOT; ?>/admin/edit_student/<?php echo $data['id']; ?>" method="post" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">First Name</label>
                                <input type="text" name="first_name" class="form-control <?php echo (!empty($data['first_name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['first_name']; ?>">
                                <span class="invalid-feedback"><?php echo $data['first_name_err']; ?></span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Surname</label>
                                <input type="text" name="surname" class="form-control <?php echo (!empty($data['surname_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['surname']; ?>">
                                <span class="invalid-feedback"><?php echo $data['surname_err']; ?></span>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Age</label>
                                <input type="number" name="age" class="form-control" value="<?php echo $data['age']; ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Class</label>
                                <input type="text" name="class" class="form-control" value="<?php echo $data['class']; ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-control" value="<?php echo $data['email']; ?>" required>
                            </div>
                            
                            <div class="col-md-12 mt-4">
                                <label class="form-label">Account Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current">
                            </div>

                            <div class="col-md-12 mt-4">
                                <label class="form-label">Profile Photo</label>
                                <?php if(!empty($data['profile_photo'])) : ?>
                                    <div class="mb-2">
                                        <img src="<?php echo URLROOT . '/' . $data['profile_photo']; ?>" class="rounded-3 shadow-sm" style="max-height: 100px;">
                                    </div>
                                <?php endif; ?>
                                <input type="file" name="profile_photo" class="form-control" accept="image/*">
                            </div>

                            <div class="col-md-12 mt-4">
                                <label class="form-label">My Story (About)</label>
                                <textarea name="about" class="form-control" rows="4"><?php echo $data['about']; ?></textarea>
                            </div>

                            <div class="col-md-12 mt-4">
                                <label class="form-label">Educational Goals</label>
                                <textarea name="educational_goals" class="form-control" rows="3"><?php echo isset($data['educational_goals']) ? $data['educational_goals'] : ''; ?></textarea>
                            </div>

                            <div class="col-md-6 mt-4">
                                <label class="form-label">Best Memory Verse</label>
                                <textarea name="memory_verse" class="form-control" rows="2"><?php echo isset($data['memory_verse']) ? $data['memory_verse'] : ''; ?></textarea>
                            </div>

                            <div class="col-md-6 mt-4">
                                <label class="form-label">Prayer Needs</label>
                                <textarea name="prayer_needs" class="form-control" rows="2"><?php echo isset($data['prayer_needs']) ? $data['prayer_needs'] : ''; ?></textarea>
                            </div>
                        </div>

                        <div class="mt-5 pt-3 border-top text-end">
                            <button type="submit" class="btn-save px-5">
                                <i class="fa-solid fa-save me-2"></i> Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4 animate-up delay-2">
            <div class="card-modern border-danger" style="border: 1px solid #ffd8d6 !important;">
                <div class="card-header-modern bg-danger">
                    <h5 class="mb-0"><i class="fa-solid fa-trash-can me-2"></i> Delete Student</h5>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted small">Deleting this beneficiary will permanently remove their academic record and interactive portfolio. This cannot be undone.</p>
                    <form action="<?php echo URLROOT; ?>/admin/delete_student/<?php echo $data['id']; ?>" method="post" onsubmit="return confirm('Delete this profile permanently?')">
                        <button type="submit" class="btn btn-outline-danger w-100 fw-bold rounded-pill">
                            Confirm Permanent Deletion
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/layouts/footer.php'; ?>
