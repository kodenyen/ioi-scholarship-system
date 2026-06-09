<?php require APPROOT . '/views/layouts/header.php'; ?>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    body { background-color: #f0f2f5; font-family: 'Plus Jakarta Sans', sans-serif; }
    .page-title { font-weight: 800; font-size: 2.2rem; color: #001219; letter-spacing: -1px; margin-bottom: 0.5rem; }
    
    .settings-container { display: grid; grid-template-columns: 280px 1fr; gap: 2rem; margin-top: 2rem; }
    
    .settings-nav { background: white; border-radius: 24px; padding: 1.5rem; box-shadow: 0 8px 30px rgba(0,0,0,0.05); height: fit-content; }
    .settings-nav-item { display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: 12px; color: #6c757d; font-weight: 600; text-decoration: none; transition: all 0.2s; margin-bottom: 5px; cursor: pointer; }
    .settings-nav-item:hover { background: #f8f9fa; color: #005BFF; }
    .settings-nav-item.active { background: #e7f5ff; color: #005BFF; }
    
    .settings-card { background: white; border-radius: 24px; box-shadow: 0 8px 30px rgba(0,0,0,0.05); padding: 2.5rem; border: 1px solid rgba(0,0,0,0.02); }
    .settings-section-title { font-weight: 700; font-size: 1.25rem; color: #001219; margin-bottom: 2rem; border-bottom: 1px solid #f0f0f0; padding-bottom: 1rem; display: flex; align-items: center; gap: 10px; }
    
    .logo-preview-box { width: 100%; max-width: 400px; height: 180px; border-radius: 20px; background: #f8f9fa; border: 2px dashed #dee2e6; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; margin-bottom: 1.5rem; transition: all 0.3s; }
    .logo-preview-box:hover { border-color: #005BFF; background: #f0f7ff; }
    .logo-img-preview { max-width: 80%; max-height: 80%; object-fit: contain; }
    
    .btn-save-settings { background: #001219; color: white; border: none; border-radius: 12px; padding: 12px 30px; font-weight: 700; transition: all 0.3s; }
    .btn-save-settings:hover { background: #005BFF; transform: translateY(-2px); }
    
    .btn-delete-logo { position: absolute; top: 15px; right: 15px; background: rgba(208,0,0,0.1); color: #d00000; border: none; width: 35px; height: 35px; border-radius: 10px; display: flex; align-items: center; justify-content: center; transition: all 0.2s; }
    .btn-delete-logo:hover { background: #d00000; color: white; }
</style>

<div class="container py-4">
    <div class="animate-up">
        <h1 class="page-title">System Settings</h1>
        <p class="text-muted">Configure your platform's global appearance and behavior.</p>
    </div>

    <?php flash('settings_message'); ?>

    <div class="settings-container">
        <!-- Sidebar Navigation -->
        <div class="settings-nav animate-up delay-1">
            <div class="settings-nav-item active" onclick="showSection('branding')">
                <i class="fa-solid fa-palette"></i> Branding & Logo
            </div>
            <a href="<?php echo URLROOT; ?>/admin/menu_manager" class="settings-nav-item">
                <i class="fa-solid fa-bars"></i> Menu Manager
            </a>
            <div class="settings-nav-item" onclick="showSection('email')">
                <i class="fa-solid fa-envelope"></i> Email/SMTP Settings
            </div>
            <div class="settings-nav-item" onclick="showSection('admins')">
                <i class="fa-solid fa-user-shield"></i> Admin Management
            </div>
            <a href="#" class="settings-nav-item opacity-50">
                <i class="fa-solid fa-shield-halved"></i> Security
            </a>
        </div>

        <!-- Main Settings Form -->
        <div class="settings-card animate-up delay-2">
            <form action="<?php echo URLROOT; ?>/admin/settings" method="post" enctype="multipart/form-data">
                
                <!-- Branding Section -->
                <div id="section-branding">
                    <div class="settings-section-title">
                        <i class="fa-solid fa-circle-nodes text-primary"></i> Platform Branding
                    </div>

                    <div class="row mb-5">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase mb-3">Organization Logo</label>
                            <div class="logo-preview-box">
                                <?php if(!empty($data['site_logo'])) : ?>
                                    <img src="<?php echo asset($data['site_logo']); ?>" class="logo-img-preview" id="logoPreview">
                                    <button type="submit" name="delete_logo" class="btn-delete-logo" onclick="return confirm('Remove logo?')">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                <?php else : ?>
                                    <div class="text-center text-muted" id="logoPlaceholder">
                                        <i class="fa-solid fa-image fa-3x mb-2 opacity-25"></i>
                                        <p class="small m-0">No logo uploaded or file missing.</p>
                                    </div>
                                    <img src="" class="logo-img-preview d-none" id="logoPreview">
                                <?php endif; ?>
                            </div>
                            <input type="file" name="site_logo" class="form-control" id="logoInput" accept="image/*">
                        </div>
                    </div>

                    <div class="settings-section-title">
                        <i class="fa-solid fa-book-open text-primary"></i> 3D Portfolio Final Page
                    </div>

                    <div class="row g-4 mb-5">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase mb-3">Ending Banner Image</label>
                            <div class="logo-preview-box" style="height: 140px;">
                                <?php 
                                    $banner = getSetting('book_base_banner');
                                    if(!empty($banner)) : 
                                ?>
                                    <img src="<?php echo asset($banner); ?>" class="logo-img-preview" id="bannerPreview">
                                    <button type="submit" name="delete_banner" class="btn-delete-logo" onclick="return confirm('Remove banner?')">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                <?php else : ?>
                                    <div class="text-center text-muted" id="bannerPlaceholder">
                                        <p class="small m-0">No banner uploaded or file missing.</p>
                                    </div>
                                    <img src="" class="logo-img-preview d-none" id="bannerPreview">
                                <?php endif; ?>
                            </div>
                            <input type="file" name="book_base_banner" class="form-control" id="bannerInput" accept="image/*">
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-uppercase">Button Text</label>
                                <input type="text" name="book_base_btn_text" class="form-control" value="<?php echo getSetting('book_base_btn_text'); ?>">
                            </div>
                            <div>
                                <label class="form-label fw-bold small text-uppercase">Button Link URL</label>
                                <input type="url" name="book_base_btn_url" class="form-control" value="<?php echo getSetting('book_base_btn_url'); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="settings-section-title">
                        <i class="fa-solid fa-info-circle text-primary"></i> Other Information
                    </div>
                    <div class="row g-4">
                        <div class="col-md-12">
                            <label class="form-label fw-bold small text-uppercase">Announcement Text</label>
                            <input type="text" name="top_bar_text" class="form-control" value="<?php echo $data['top_bar_text']; ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase">Contact Phone</label>
                            <input type="text" name="contact_phone" class="form-control" value="<?php echo $data['contact_phone']; ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase">Contact Email</label>
                            <input type="email" name="contact_email" class="form-control" value="<?php echo $data['contact_email']; ?>">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold small text-uppercase">Donate Button Link</label>
                            <input type="url" name="donate_url" class="form-control" value="<?php echo $data['donate_url']; ?>">
                        </div>
                    </div>
                </div>

                <!-- Email/SMTP Section -->
                <div id="section-email" class="d-none">
                    <div class="settings-section-title">
                        <i class="fa-solid fa-envelope-circle-check text-primary"></i> SMTP Server Configuration
                    </div>
                    <p class="text-muted small mb-4">Configure your SMTP settings to enable email notifications.</p>
                    
                    <div class="row g-4">
                        <div class="col-md-8">
                            <label class="form-label fw-bold small text-uppercase">SMTP Host</label>
                            <input type="text" name="smtp_host" class="form-control" value="<?php echo $data['smtp_host']; ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small text-uppercase">SMTP Port</label>
                            <input type="text" name="smtp_port" class="form-control" value="<?php echo $data['smtp_port']; ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase">SMTP Username</label>
                            <input type="text" name="smtp_user" class="form-control" value="<?php echo $data['smtp_user']; ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase">SMTP Password</label>
                            <input type="password" name="smtp_pass" class="form-control" value="<?php echo $data['smtp_pass']; ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase">Encryption</label>
                            <select name="smtp_encryption" class="form-select">
                                <option value="ssl" <?php echo $data['smtp_encryption'] == 'ssl' ? 'selected' : ''; ?>>SSL (465)</option>
                                <option value="tls" <?php echo $data['smtp_encryption'] == 'tls' ? 'selected' : ''; ?>>TLS (587)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase">From Name</label>
                            <input type="text" name="smtp_from_name" class="form-control" value="<?php echo $data['smtp_from_name']; ?>">
                        </div>
                    </div>
                </div>

                <!-- Admin Management Section -->
                <div id="section-admins" class="d-none">
                    <div class="settings-section-title d-flex justify-content-between align-items-center">
                        <div><i class="fa-solid fa-user-shield text-primary"></i> Administrative Accounts</div>
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addAdminModal">
                            <i class="fa fa-plus"></i> Add Admin
                        </button>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Created</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($data['admins'] as $admin) : ?>
                                    <tr>
                                        <td><strong><?php echo $admin->name; ?></strong></td>
                                        <td><?php echo $admin->email; ?></td>
                                        <td><span class="small text-muted"><?php echo date('M d, Y', strtotime($admin->created_at)); ?></span></td>
                                        <td class="text-end">
                                            <button type="button" class="btn btn-sm btn-outline-primary me-2" onclick='openEditAdmin(<?php echo json_encode($admin); ?>)'>
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <?php if($admin->id != $_SESSION['admin_id']) : ?>
                                                <a href="<?php echo URLROOT; ?>/admin/delete_admin/<?php echo $admin->id; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Remove this administrator?')">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-5 pt-4 border-top">
                    <button type="submit" class="btn btn-save-settings">
                        <i class="fa-solid fa-check-double me-2"></i> Update Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function showSection(section) {
        document.getElementById('section-branding').classList.add('d-none');
        document.getElementById('section-email').classList.add('d-none');
        document.getElementById('section-admins').classList.add('d-none');
        document.getElementById('section-' + section).classList.remove('d-none');
        
        document.querySelectorAll('.settings-nav-item').forEach(el => el.classList.remove('active'));
        // Find the clicked item using event or section name
        if(event) {
            event.currentTarget.classList.add('active');
        }
    }

    function openEditAdmin(admin) {
        document.getElementById('edit_admin_id').value = admin.id;
        document.getElementById('edit_admin_name').value = admin.name;
        document.getElementById('edit_admin_email').value = admin.email;
        document.getElementById('editAdminForm').action = '<?php echo URLROOT; ?>/admin/edit_admin/' + admin.id;
        new bootstrap.Modal(document.getElementById('editAdminModal')).show();
    }

    // Live preview of uploaded images
    function initPreview(inputId, previewId, placeholderId) {
        document.getElementById(inputId).addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById(previewId);
                    const placeholder = document.getElementById(placeholderId);
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                    if(placeholder) placeholder.classList.add('d-none');
                }
                reader.readAsDataURL(file);
            }
        });
    }

    initPreview('logoInput', 'logoPreview', 'logoPlaceholder');
    initPreview('bannerInput', 'bannerPreview', 'bannerPlaceholder');
</script>

<?php require APPROOT . '/views/layouts/footer.php'; ?>

<!-- Add Admin Modal -->
<div class="modal fade" id="addAdminModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 20px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.1);">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Add Administrator</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo URLROOT; ?>/admin/add_admin" method="post">
                <div class="modal-body py-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Full Name</label>
                        <input type="text" name="name" class="form-control rounded-3" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Email Address</label>
                        <input type="email" name="email" class="form-control rounded-3" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Password</label>
                        <input type="password" name="password" class="form-control rounded-3" required>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-3 px-4">Create Admin</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Admin Modal -->
<div class="modal fade" id="editAdminModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 20px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.1);">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Edit Administrator</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editAdminForm" action="" method="post">
                <input type="hidden" name="id" id="edit_admin_id">
                <div class="modal-body py-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Full Name</label>
                        <input type="text" name="name" id="edit_admin_name" class="form-control rounded-3" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Email Address</label>
                        <input type="email" name="email" id="edit_admin_email" class="form-control rounded-3" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">New Password (leave blank to keep current)</label>
                        <input type="password" name="password" class="form-control rounded-3">
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-3 px-4">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
