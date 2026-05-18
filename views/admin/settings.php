<?php require APPROOT . '/views/layouts/header.php'; ?>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    body { background-color: #f0f2f5; font-family: 'Plus Jakarta Sans', sans-serif; }
    .page-title { font-weight: 800; font-size: 2.2rem; color: #001219; letter-spacing: -1px; margin-bottom: 0.5rem; }
    
    .settings-container { display: grid; grid-template-columns: 280px 1fr; gap: 2rem; margin-top: 2rem; }
    
    .settings-nav { background: white; border-radius: 24px; padding: 1.5rem; box-shadow: 0 8px 30px rgba(0,0,0,0.05); height: fit-content; }
    .settings-nav-item { display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: 12px; color: #6c757d; font-weight: 600; text-decoration: none; transition: all 0.2s; margin-bottom: 5px; }
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
            <a href="<?php echo URLROOT; ?>/admin/settings" class="settings-nav-item active">
                <i class="fa-solid fa-palette"></i> Branding & Logo
            </a>
            <a href="<?php echo URLROOT; ?>/admin/menu_manager" class="settings-nav-item">
                <i class="fa-solid fa-bars"></i> Menu Manager
            </a>
            <a href="#email-settings" class="settings-nav-item" onclick="showSection('email-settings')">
                <i class="fa-solid fa-envelope"></i> Email/SMTP Settings
            </a>
            <a href="#" class="settings-nav-item opacity-50">
                <i class="fa-solid fa-shield-halved"></i> Security
            </a>
        </div>

        <!-- Main Settings Form -->
        <div class="settings-card animate-up delay-2">
            <form action="<?php echo URLROOT; ?>/admin/settings" method="post" enctype="multipart/form-data">
                
                <!-- Branding Section -->
                <div id="branding-section">
                    <div class="settings-section-title">
                        <i class="fa-solid fa-circle-nodes text-primary"></i> Platform Branding
                    </div>

                    <div class="row mb-5">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase mb-3">Organization Logo</label>
                            <div class="logo-preview-box">
                                <?php if(!empty($data['site_logo'])) : ?>
                                    <img src="<?php echo URLROOT . '/' . $data['site_logo']; ?>" class="logo-img-preview" id="logoPreview">
                                    <button type="submit" name="delete_logo" class="btn-delete-logo" onclick="return confirm('Remove logo and use site name text?')">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                <?php else : ?>
                                    <div class="text-center text-muted" id="placeholderText">
                                        <i class="fa-solid fa-image fa-3x mb-2 opacity-25"></i>
                                        <p class="small m-0">No logo uploaded.<br>Using "<?php echo SITE_NAME; ?>" text.</p>
                                    </div>
                                    <img src="" class="logo-img-preview d-none" id="logoPreview">
                                <?php endif; ?>
                            </div>
                            
                            <div class="mb-4">
                                <input type="file" name="site_logo" class="form-control" id="logoInput" accept="image/*">
                            </div>
                        </div>
                    </div>

                    <div class="settings-section-title">
                        <i class="fa-solid fa-info-circle text-primary"></i> Top Header Information
                    </div>

                    <div class="row g-4 mb-5">
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
                <div id="email-section" class="d-none">
                    <div class="settings-section-title">
                        <i class="fa-solid fa-envelope-circle-check text-primary"></i> SMTP Server Configuration
                    </div>
                    <p class="text-muted small mb-4">Configure your SMTP settings to enable email notifications for sponsors and students.</p>
                    
                    <div class="row g-4">
                        <div class="col-md-8">
                            <label class="form-label fw-bold small text-uppercase">SMTP Host</label>
                            <input type="text" name="smtp_host" class="form-control" placeholder="smtp.example.com" value="<?php echo $data['smtp_host']; ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small text-uppercase">SMTP Port</label>
                            <input type="text" name="smtp_port" class="form-control" placeholder="465 or 587" value="<?php echo $data['smtp_port']; ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase">SMTP Username (Email)</label>
                            <input type="text" name="smtp_user" class="form-control" value="<?php echo $data['smtp_user']; ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase">SMTP Password</label>
                            <input type="password" name="smtp_pass" class="form-control" value="<?php echo $data['smtp_pass']; ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase">Encryption</label>
                            <select name="smtp_encryption" class="form-select">
                                <option value="ssl" <?php echo $data['smtp_encryption'] == 'ssl' ? 'selected' : ''; ?>>SSL (Port 465)</option>
                                <option value="tls" <?php echo $data['smtp_encryption'] == 'tls' ? 'selected' : ''; ?>>TLS (Port 587)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase">From Name</label>
                            <input type="text" name="smtp_from_name" class="form-control" placeholder="IOI Scholarship Admin" value="<?php echo $data['smtp_from_name']; ?>">
                        </div>
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
    function showSection(id) {
        if(id === 'email-settings') {
            document.getElementById('branding-section').classList.add('d-none');
            document.getElementById('email-section').classList.remove('d-none');
            event.target.closest('.settings-nav').querySelectorAll('.settings-nav-item').forEach(el => el.classList.remove('active'));
            event.target.classList.add('active');
        } else {
            document.getElementById('branding-section').classList.remove('d-none');
            document.getElementById('email-section').classList.add('d-none');
        }
    }

    // Live preview of uploaded logo
    </div>
</div>

<script>
    // Live preview of uploaded logo
    document.getElementById('logoInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('logoPreview');
                const placeholder = document.getElementById('placeholderText');
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                if(placeholder) placeholder.classList.add('d-none');
            }
            reader.readAsDataURL(file);
        }
    });
</script>

<?php require APPROOT . '/views/layouts/footer.php'; ?>
