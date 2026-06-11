<?php require APPROOT . '/views/layouts/header.php'; ?>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    body { background-color: #f0f2f5; font-family: 'Plus Jakarta Sans', sans-serif; }
    .page-title { font-weight: 800; font-size: 2.2rem; color: #001219; letter-spacing: -1px; margin-bottom: 0.5rem; }
    
    .settings-container { display: grid; grid-template-columns: 280px 1fr; gap: 2rem; margin-top: 2rem; }
    
    .settings-nav { background: white; border-radius: 24px; padding: 1rem; box-shadow: 0 8px 30px rgba(0,0,0,0.05); height: fit-content; position: sticky; top: 100px; z-index: 100; }
    .settings-nav-item { display: flex; align-items: center; gap: 12px; padding: 14px 20px; border-radius: 12px; color: #6c757d; font-weight: 600; text-decoration: none; transition: all 0.2s; margin-bottom: 8px; cursor: pointer; border: none; background: none; width: 100%; text-align: left; font-size: 0.95rem; }
    .settings-nav-item:hover { background: #f8f9fa; color: #005BFF; }
    .settings-nav-item.active { background: #e7f5ff; color: #005BFF; border-left: 4px solid #005BFF; border-radius: 4px 12px 12px 4px; }
    
    .settings-card { background: white; border-radius: 24px; box-shadow: 0 8px 30px rgba(0,0,0,0.05); padding: 2.5rem; border: 1px solid rgba(0,0,0,0.02); min-height: 400px; }
    .settings-section-title { font-weight: 700; font-size: 1.25rem; color: #001219; margin-bottom: 2rem; border-bottom: 1px solid #f0f0f0; padding-bottom: 1rem; display: flex; align-items: center; gap: 10px; }
    
    .logo-preview-box { width: 100%; max-width: 400px; height: 180px; border-radius: 20px; background: #f8f9fa; border: 2px dashed #dee2e6; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; margin-bottom: 1.5rem; transition: all 0.3s; }
    .logo-preview-box:hover { border-color: #005BFF; background: #f0f7ff; }
    .logo-img-preview { max-width: 80%; max-height: 80%; object-fit: contain; }
    
    .btn-save-settings { background: #001219; color: white; border: none; border-radius: 12px; padding: 16px 30px; font-weight: 700; transition: all 0.3s; width: 100%; font-size: 1rem; }
    @media (min-width: 768px) { .btn-save-settings { width: auto; min-width: 200px; } }
    .btn-save-settings:hover { background: #005BFF; transform: translateY(-2px); box-shadow: 0 10px 20px rgba(0,91,255,0.2); }
    
    .btn-delete-logo { position: absolute; top: 15px; right: 15px; background: rgba(208,0,0,0.1); color: #d00000; border: none; width: 35px; height: 35px; border-radius: 10px; display: flex; align-items: center; justify-content: center; transition: all 0.2s; }
    .btn-delete-logo:hover { background: #d00000; color: white; }

    /* Mobile Responsive Optimizations */
    @media (max-width: 991px) {
        .settings-container { grid-template-columns: 1fr; gap: 1.5rem; }
        .settings-nav { 
            position: relative; 
            top: 0; 
            display: flex; 
            overflow-x: auto; 
            white-space: nowrap; 
            padding: 0.5rem; 
            gap: 8px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            -webkit-overflow-scrolling: touch;
        }
        .settings-nav-item { margin-bottom: 0; flex: 0 0 auto; padding: 12px 20px; font-size: 0.9rem; width: auto; border-left: none; }
        .settings-nav-item.active { border-left: none; border-bottom: 3px solid #005BFF; border-radius: 0; }
        .settings-card { padding: 1.5rem; border-radius: 20px; }
        .page-title { font-size: 1.75rem; }
    }

    @media (max-width: 576px) {
        .settings-section-title { font-size: 1.1rem; margin-bottom: 1.5rem; }
        .logo-preview-box { height: 150px; }
        .form-control, .form-select { padding: 14px; border-radius: 12px; border: 1px solid #e0e0e0; }
        .form-control:focus { box-shadow: 0 0 0 4px rgba(0,91,255,0.1); border-color: #005BFF; }
    }
</style>

<div class="container py-4">
    <div class="animate-up mb-4">
        <h1 class="page-title">System Settings</h1>
        <p class="text-muted">Configure your platform's global appearance and behavior.</p>
    </div>

    <?php flash('settings_message'); ?>

    <div class="settings-container">
        <!-- Sidebar/Top Navigation -->
        <div class="settings-nav animate-up delay-1">
            <button type="button" class="settings-nav-item active" onclick="showSection('branding', this)">
                <i class="fa-solid fa-palette"></i> Branding & Logo
            </button>
            <a href="<?php echo URLROOT; ?>/admin/menu_manager" class="settings-nav-item">
                <i class="fa-solid fa-bars"></i> Menu Manager
            </a>
            <button type="button" class="settings-nav-item" onclick="showSection('email', this)">
                <i class="fa-solid fa-envelope"></i> Email/SMTP
            </button>
            <button type="button" class="settings-nav-item" onclick="showSection('admins', this)">
                <i class="fa-solid fa-user-shield"></i> Admin Management
            </button>
        </div>

        <!-- Main Settings Form -->
        <div class="settings-card animate-up delay-2">
            <form action="<?php echo URLROOT; ?>/admin/settings" method="post" enctype="multipart/form-data">
                
                <!-- Branding Section -->
                <div id="section-branding" class="settings-tab-content">
                    <div class="settings-section-title">
                        <i class="fa-solid fa-circle-nodes text-primary"></i> Platform Branding
                    </div>

                    <div class="row mb-5">
                        <div class="col-lg-6">
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
                                        <p class="small m-0 px-3">No logo uploaded</p>
                                    </div>
                                    <img src="" class="logo-img-preview d-none" id="logoPreview">
                                <?php endif; ?>
                            </div>
                            <input type="file" name="site_logo" class="form-control" id="logoInput" accept="image/*">
                        </div>
                    </div>

                    <div class="settings-section-title">
                        <i class="fa-solid fa-book-open text-primary"></i> Portfolio Final Page
                    </div>

                    <div class="row g-4 mb-5">
                        <div class="col-lg-6">
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
                                        <p class="small m-0">No banner uploaded</p>
                                    </div>
                                    <img src="" class="logo-img-preview d-none" id="bannerPreview">
                                <?php endif; ?>
                            </div>
                            <input type="file" name="book_base_banner" class="form-control" id="bannerInput" accept="image/*">
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-uppercase">Button Text</label>
                                <input type="text" name="book_base_btn_text" class="form-control" value="<?php echo getSetting('book_base_btn_text'); ?>" placeholder="e.g. Sponsor a student">
                            </div>
                            <div>
                                <label class="form-label fw-bold small text-uppercase">Button Link URL</label>
                                <input type="url" name="book_base_btn_url" class="form-control" value="<?php echo getSetting('book_base_btn_url'); ?>" placeholder="https://...">
                            </div>
                        </div>
                    </div>

                    <div class="settings-section-title">
                        <i class="fa-solid fa-info-circle text-primary"></i> Other Information
                    </div>
                    <div class="row g-4">
                        <div class="col-12">
                            <label class="form-label fw-bold small text-uppercase">Announcement Text</label>
                            <input type="text" name="top_bar_text" class="form-control" value="<?php echo $data['top_bar_text']; ?>">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label fw-bold small text-uppercase">Contact Phone</label>
                            <input type="text" name="contact_phone" class="form-control" value="<?php echo $data['contact_phone']; ?>">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label fw-bold small text-uppercase">Contact Email</label>
                            <input type="email" name="contact_email" class="form-control" value="<?php echo $data['contact_email']; ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small text-uppercase">Donate Button Link</label>
                            <input type="url" name="donate_url" class="form-control" value="<?php echo $data['donate_url']; ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small text-uppercase">Support Another Student Link</label>
                            <input type="url" name="sponsor_another_url" class="form-control" value="<?php echo getSetting('sponsor_another_url') ?: URLROOT . '/pages/scholarships'; ?>">
                            <div class="form-text">Used at the back of the student flipbook.</div>
                        </div>
                    </div>
                </div>

                <!-- Email/SMTP Section -->
                <div id="section-email" class="settings-tab-content d-none">
                    <div class="settings-section-title">
                        <i class="fa-solid fa-envelope-circle-check text-primary"></i> SMTP Configuration
                    </div>
                    <p class="text-muted small mb-4">Configure SMTP for automated email notifications.</p>
                    
                    <div class="row g-4">
                        <div class="col-lg-8">
                            <label class="form-label fw-bold small text-uppercase">SMTP Host</label>
                            <input type="text" name="smtp_host" class="form-control" value="<?php echo $data['smtp_host']; ?>">
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label fw-bold small text-uppercase">SMTP Port</label>
                            <input type="text" name="smtp_port" class="form-control" value="<?php echo $data['smtp_port']; ?>">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label fw-bold small text-uppercase">SMTP Username</label>
                            <input type="text" name="smtp_user" class="form-control" value="<?php echo $data['smtp_user']; ?>">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label fw-bold small text-uppercase">SMTP Password</label>
                            <input type="password" name="smtp_pass" class="form-control" value="<?php echo $data['smtp_pass']; ?>">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label fw-bold small text-uppercase">Encryption</label>
                            <select name="smtp_encryption" class="form-select">
                                <option value="ssl" <?php echo $data['smtp_encryption'] == 'ssl' ? 'selected' : ''; ?>>SSL (465)</option>
                                <option value="tls" <?php echo $data['smtp_encryption'] == 'tls' ? 'selected' : ''; ?>>TLS (587)</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label fw-bold small text-uppercase">From Name</label>
                            <input type="text" name="smtp_from_name" class="form-control" value="<?php echo $data['smtp_from_name']; ?>">
                        </div>
                    </div>
                </div>

                <!-- Admin Management Section -->
                <div id="section-admins" class="settings-tab-content d-none">
                    <div class="settings-section-title d-flex justify-content-between align-items-center">
                        <div class="text-truncate me-2"><i class="fa-solid fa-user-shield text-primary"></i> Administrators</div>
                        <button type="button" class="btn btn-sm btn-primary px-3 rounded-pill" data-bs-toggle="modal" data-bs-target="#addAdminModal">
                            <i class="fa fa-plus me-1"></i> Add
                        </button>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Admin</th>
                                    <th class="d-none d-sm-table-cell text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($data['admins'] as $admin) : ?>
                                    <tr>
                                        <td>
                                            <div class="fw-bold"><?php echo $admin->name; ?></div>
                                            <div class="small text-muted"><?php echo $admin->email; ?></div>
                                            <!-- Mobile Actions -->
                                            <div class="mt-2 d-sm-none">
                                                <button type="button" class="btn btn-sm btn-outline-primary py-1 px-2" onclick='openEditAdmin(<?php echo json_encode($admin); ?>)'>
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <?php if($admin->id != $_SESSION['admin_id']) : ?>
                                                    <a href="<?php echo URLROOT; ?>/admin/delete_admin/<?php echo $admin->id; ?>" class="btn btn-sm btn-outline-danger py-1 px-2 ms-1" onclick="return confirm('Remove administrator?')">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td class="text-end d-none d-sm-table-cell">
                                            <button type="button" class="btn btn-sm btn-outline-primary py-1 px-2" onclick='openEditAdmin(<?php echo json_encode($admin); ?>)'>
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <?php if($admin->id != $_SESSION['admin_id']) : ?>
                                                <a href="<?php echo URLROOT; ?>/admin/delete_admin/<?php echo $admin->id; ?>" class="btn btn-sm btn-outline-danger py-1 px-2 ms-2" onclick="return confirm('Remove administrator?')">
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
                        <i class="fa-solid fa-check-double me-2"></i> Save All Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function showSection(sectionId, btn) {
        // Hide all content areas
        document.querySelectorAll('.settings-tab-content').forEach(content => {
            content.classList.add('d-none');
        });
        
        // Show the target section
        const targetSection = document.getElementById('section-' + sectionId);
        if (targetSection) {
            targetSection.classList.remove('d-none');
        }
        
        // Update navigation active state
        document.querySelectorAll('.settings-nav-item').forEach(el => {
            el.classList.remove('active');
        });
        
        if (btn) {
            btn.classList.add('active');
            
            // On mobile, scroll the active item into view
            if(window.innerWidth < 992) {
                btn.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            }
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
