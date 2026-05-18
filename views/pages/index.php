<?php require APPROOT . '/views/layouts/header.php'; ?>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    body { background-color: #f0f2f5; font-family: 'Plus Jakarta Sans', sans-serif; }
    
    .portal-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 0;
    }
    
    .portal-card {
        background: white;
        border-radius: 30px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.08);
        width: 100%;
        max-width: 900px;
        overflow: hidden;
        display: flex;
        flex-direction: row;
        border: 1px solid rgba(0,0,0,0.02);
    }
    
    .portal-branding {
        flex: 1;
        background: linear-gradient(135deg, #005BFF 0%, #2b9348 100%);
        padding: 60px;
        color: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
        text-align: left;
    }
    
    .portal-branding img {
        max-width: 150px;
        margin-bottom: 30px;
        filter: brightness(0) invert(1);
    }
    
    .portal-branding h1 {
        font-weight: 800;
        font-size: 2.5rem;
        letter-spacing: -1px;
        margin-bottom: 15px;
    }
    
    .portal-options {
        flex: 1.2;
        padding: 60px;
        background: white;
    }
    
    .portal-option-item {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 20px;
        border-radius: 20px;
        background: #f8f9fa;
        border: 1px solid #eee;
        text-decoration: none;
        color: inherit;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }
    
    .portal-option-item:hover {
        background: white;
        border-color: #005BFF;
        transform: translateX(10px);
        box-shadow: 0 10px 30px rgba(0,91,255,0.1);
    }
    
    .portal-icon {
        width: 60px;
        height: 60px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    
    .icon-admin { background: #fff1f0; color: #d00000; }
    .icon-sponsor { background: #e7f5ff; color: #005BFF; }
    .icon-student { background: #ebfbee; color: #2b9348; }
    
    .portal-text h6 { font-weight: 800; margin: 0; font-size: 1.1rem; }
    .portal-text p { font-size: 0.85rem; color: #6c757d; margin: 2px 0 0; }

    @media (max-width: 768px) {
        .portal-card { flex-direction: column; }
        .portal-branding { padding: 40px; text-align: center; align-items: center; }
        .portal-options { padding: 40px; }
    }
</style>

<div class="portal-container">
    <div class="portal-card animate-up">
        <div class="portal-branding">
            <?php 
                $logo = getSetting('site_logo');
                if($logo && file_exists(APPROOT . '/' . $logo)) : 
            ?>
                <img src="<?php echo URLROOT . '/' . $logo; ?>" alt="Logo">
            <?php endif; ?>
            <h1>Secure Portal</h1>
            <p class="opacity-75 lead">Welcome to the IOI Global Scholarship Management System. Please select your portal to continue.</p>
        </div>
        
        <div class="portal-options">
            <h4 class="fw-bold mb-4">Choose Your Portal</h4>
            
            <!-- Sponsor Portal -->
            <a href="<?php echo URLROOT; ?>/sponsor/login" class="portal-option-item">
                <div class="portal-icon icon-sponsor">
                    <i class="fa-solid fa-hand-holding-heart"></i>
                </div>
                <div class="portal-text">
                    <h6>Sponsor Portal</h6>
                    <p>Connect with your assigned scholars.</p>
                </div>
                <i class="fa-solid fa-chevron-right ms-auto opacity-25"></i>
            </a>
            
            <!-- Student Portal -->
            <a href="<?php echo URLROOT; ?>/student/login" class="portal-option-item">
                <div class="portal-icon icon-student">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <div class="portal-text">
                    <h6>Beneficiary Portal</h6>
                    <p>Manage your academic journey and updates.</p>
                </div>
                <i class="fa-solid fa-chevron-right ms-auto opacity-25"></i>
            </a>
            
            <!-- Admin Portal -->
            <a href="<?php echo URLROOT; ?>/admin/login" class="portal-option-item">
                <div class="portal-icon icon-admin">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
                <div class="portal-text">
                    <h6>System Administration</h6>
                    <p>Management and moderation console.</p>
                </div>
                <i class="fa-solid fa-chevron-right ms-auto opacity-25"></i>
            </a>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/layouts/footer.php'; ?>
