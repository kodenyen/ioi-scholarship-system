<?php require APPROOT . '/views/layouts/header.php'; ?>

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    :root {
        --primary: #005BFF;
        --success: #2b9348;
        --warning: #ffb703;
        --danger: #d00000;
        --dark: #001219;
        --light: #f8f9fa;
        --glass: rgba(255, 255, 255, 0.9);
        --shadow: 0 8px 30px rgba(0,0,0,0.05);
    }

    body {
        background-color: #f0f2f5;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .dashboard-header {
        margin-bottom: 2rem;
        padding: 2rem 0;
    }

    .dashboard-title {
        font-weight: 800;
        font-size: 2.5rem;
        color: var(--dark);
        letter-spacing: -1px;
    }

    .stat-card {
        background: var(--glass);
        border: none;
        border-radius: 20px;
        padding: 1.5rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: var(--shadow);
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.1);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .icon-pending { background: #fff4e6; color: #f08c00; }
    .icon-sponsors { background: #e7f5ff; color: #1c7ed6; }
    .icon-students { background: #ebfbee; color: #2b8a3e; }

    .stat-value {
        font-weight: 800;
        font-size: 2.2rem;
        margin-bottom: 0.2rem;
        color: var(--dark);
    }

    .stat-label {
        font-weight: 600;
        color: #6c757d;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
    }

    .action-card {
        background: white;
        border: none;
        border-radius: 24px;
        padding: 2rem;
        box-shadow: var(--shadow);
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        border: 1px solid rgba(0,0,0,0.02);
    }

    .action-card h5 {
        font-weight: 700;
        font-size: 1.25rem;
        margin-bottom: 1rem;
        color: var(--dark);
    }

    .action-card p {
        color: #6c757d;
        font-size: 0.95rem;
        line-height: 1.6;
    }

    .btn-action {
        border-radius: 12px;
        padding: 0.8rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .btn-main {
        background: #005BFF;
        color: white;
        border: none;
    }

    .btn-main:hover {
        background: #4FA242;
        color: white;
        transform: scale(1.02);
    }

    .quick-link-icon {
        font-size: 2rem;
        margin-bottom: 1.5rem;
        background: linear-gradient(135deg, var(--primary), var(--success));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Animation */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-up {
        animation: fadeInUp 0.6s ease forwards;
    }

    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }
</style>

<div class="dashboard-header animate-up">
    <h1 class="dashboard-title">Admin Dashboard</h1>
    <p class="text-muted">Welcome back, <strong><?php echo $_SESSION['admin_name']; ?></strong>. Here's what's happening today.</p>
</div>

<div class="row">
    <!-- Pending Messages -->
    <div class="col-md-4 mb-4 animate-up delay-1">
        <div class="stat-card">
            <div class="stat-icon icon-pending">
                <i class="fa-solid fa-envelope-open-text"></i>
            </div>
            <div class="stat-value"><?php echo $data['pending_count']; ?></div>
            <div class="stat-label">Pending Moderation</div>
            <a href="<?php echo URLROOT; ?>/admin/moderation" class="stretched-link"></a>
        </div>
    </div>

    <!-- Total Sponsors -->
    <div class="col-md-4 mb-4 animate-up delay-2">
        <div class="stat-card">
            <div class="stat-icon icon-sponsors">
                <i class="fa-solid fa-hand-holding-heart"></i>
            </div>
            <div class="stat-value"><?php echo $data['sponsor_count']; ?></div>
            <div class="stat-label">Total Sponsors</div>
            <a href="<?php echo URLROOT; ?>/admin/sponsors" class="stretched-link"></a>
        </div>
    </div>

    <!-- Total Students -->
    <div class="col-md-4 mb-4 animate-up delay-3">
        <div class="stat-card">
            <div class="stat-icon icon-students">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <div class="stat-value"><?php echo $data['student_count']; ?></div>
            <div class="stat-label">Total Students</div>
            <a href="<?php echo URLROOT; ?>/admin/students" class="stretched-link"></a>
        </div>
    </div>
</div>

<div class="row mt-4 mb-5">
    <!-- Form Builder -->
    <div class="col-md-6 mb-4 animate-up delay-3">
        <div class="action-card">
            <div>
                <i class="fa-solid fa-list-check quick-link-icon"></i>
                <h5>Dynamic Form Builder</h5>
                <p>Customize the communication experience by adding dynamic fields to sponsor and student messaging forms.</p>
            </div>
            <a href="<?php echo URLROOT; ?>/admin/forms" class="btn btn-action btn-main">
                <i class="fa-solid fa-pen-ruler"></i> Open Form Builder
            </a>
        </div>
    </div>

    <!-- Assignments -->
    <div class="col-md-6 mb-4 animate-up delay-3">
        <div class="action-card">
            <div>
                <i class="fa-solid fa-link quick-link-icon"></i>
                <h5>Manage Assignments</h5>
                <p>Seamlessly link sponsors with their assigned students to facilitate and moderate their communication.</p>
            </div>
            <a href="<?php echo URLROOT; ?>/admin/assignments" class="btn btn-action btn-main">
                <i class="fa-solid fa-user-group"></i> Manage Assignments
            </a>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/layouts/footer.php'; ?>
