<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?></title>
    <!-- Google Fonts: Plus Jakarta Sans & Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --brand-green: #2b9348;
            --brand-green-dark: #1e6632;
            --brand-blue: #005BFF;
            --top-bar-height: 40px;
        }

        body { font-family: 'Plus Jakarta Sans', sans-serif; overflow-x: hidden; }

        /* Global Button Override */
        .btn-primary, .btn-success, .btn-info {
            background-color: #005BFF !important;
            border-color: #005BFF !important;
            color: white !important;
        }
        .btn-primary:hover, .btn-success:hover, .btn-info:hover {
            background-color: #0046cc !important;
            border-color: #0046cc !important;
        }
        
        .btn-outline-primary {
            color: #005BFF !important;
            border-color: #005BFF !important;
        }
        .btn-outline-primary:hover {
            background-color: #005BFF !important;
            color: white !important;
        }

        /* --- TOP INFO BAR --- */
        .top-info-bar {
            background: linear-gradient(90deg, var(--brand-green) 0%, var(--brand-blue) 100%);
            color: white;
            padding: 8px 0;
            font-size: 0.85rem;
            font-weight: 500;
        }
        .top-info-bar a { color: white; text-decoration: none; transition: opacity 0.2s; }
        .top-info-bar a:hover { opacity: 0.8; }
        .top-info-bar .contact-item { display: inline-flex; align-items: center; gap: 8px; margin-left: 20px; }

        /* --- MAIN NAVIGATION --- */
        .main-navbar {
            background: white;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            padding: 10px 0;
            transition: all 0.3s;
        }
        .navbar-brand img { height: 60px; width: auto; }
        
        .nav-link {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            color: #333 !important;
            font-size: 0.9rem;
            padding: 10px 15px !important;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
            transition: color 0.3s;
        }
        .nav-link:hover, .nav-link.active { color: var(--brand-green) !important; }
        
        /* Green Underline for Active/Home */
        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 5px;
            left: 15px;
            right: 15px;
            height: 3px;
            background: var(--brand-green);
            border-radius: 2px;
        }

        /* --- DROPDOWNS & MULTI-LEVEL --- */
        .dropdown-menu {
            background-color: #2f4668;
            border: none;
            border-radius: 0; /* Rectangular shape */
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            padding: 0;
            margin-top: 0 !important;
            min-width: 260px;
            display: block;
            visibility: hidden;
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.3s ease;
            pointer-events: none;
        }

        .dropdown:hover > .dropdown-menu,
        .dropdown-submenu:hover > .dropdown-menu {
            visibility: visible;
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }

        .dropdown-item {
            color: rgba(255, 255, 255, 0.9) !important;
            font-size: 0.85rem;
            font-weight: 600;
            padding: 12px 20px;
            border-radius: 0;
            transition: all 0.2s;
            border: none !important; /* Remove direct border */
        }

        .dropdown-menu li {
            border-bottom: 1px solid rgba(255, 255, 255, 0.2); /* Visible divider on the list item */
        }

        .dropdown-menu li:last-child {
            border-bottom: none;
        }

        .dropdown-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white !important;
            padding-left: 25px; /* Subtle slide effect on hover */
        }

        /* Multi-level CSS */
        .dropdown-submenu { position: relative; }
        .dropdown-submenu > .dropdown-menu {
            top: 0;
            left: 100%;
            margin-top: 0 !important;
            margin-left: 0px;
        }
        
        /* Remove Bootstrap default arrow */
        .dropdown-toggle::after { 
            font-size: 0.7rem; 
            vertical-align: middle; 
            margin-left: 8px;
            border: none;
            content: "\f107";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
        }

        /* --- DONATE BUTTON --- */
        .btn-donate {
            background-color: #005BFF;
            color: white !important;
            font-weight: 800;
            border-radius: 50px;
            padding: 10px 28px !important;
            margin-left: 15px;
            box-shadow: 0 4px 15px rgba(0, 91, 255, 0.3);
            transition: all 0.3s;
            border: none;
            text-transform: uppercase;
            font-size: 0.9rem;
        }
        .btn-donate:hover {
            background-color: #0046cc;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 91, 255, 0.4);
            color: white !important;
        }

        /* Mobile specific adjustments */
        @media (max-width: 991.98px) {
            .nav-link.active::after { display: none; }
            .btn-donate { margin-left: 0; margin-top: 15px; display: inline-block; width: 100%; text-align: center; }
            .top-info-bar { text-align: center; }
            .top-info-bar .contact-item { margin: 5px 10px; font-size: 0.75rem; }
            .dropdown-submenu > .dropdown-menu { left: 0; position: static; margin-left: 15px; box-shadow: none; border-left: 2px solid #eee; }
        }
    </style>
</head>
<body>
    <!-- --- TOP INFO BAR --- -->
    <div class="top-info-bar no-print">
        <div class="container-fluid px-lg-5 d-md-flex justify-content-between align-items-center text-center text-md-start">
            <div class="small fw-600 mb-2 mb-md-0">
                <?php 
                    $topText = getSetting('top_bar_text');
                    $topText = str_replace([' to ', ' for '], [' <i>to</i> ', ' <i>for</i> '], $topText);
                    echo $topText; 
                ?>
            </div>
            <div class="d-flex justify-content-center justify-content-md-end flex-wrap">
                <div class="contact-item">
                    <i class="fa-solid fa-phone"></i>
                    <a href="tel:<?php echo str_replace(' ', '', getSetting('contact_phone')); ?>"><?php echo getSetting('contact_phone'); ?></a>
                </div>
                <div class="contact-item">
                    <i class="fa-solid fa-envelope"></i>
                    <a href="mailto:<?php echo getSetting('contact_email'); ?>"><?php echo getSetting('contact_email'); ?></a>
                </div>
            </div>
        </div>
    </div>

    <!-- --- MAIN NAVIGATION BAR --- -->
    <nav class="navbar navbar-expand-lg main-navbar sticky-top no-print">
        <div class="container-fluid px-lg-5">
            <!-- LOGO -->
            <a class="navbar-brand" href="<?php echo URLROOT; ?>">
                <?php 
                    $logo = getSetting('site_logo');
                    if($logo && file_exists(APPROOT . '/' . $logo)) : 
                ?>
                    <img src="<?php echo URLROOT . '/' . $logo; ?>" alt="IOI Logo">
                <?php else : ?>
                    <span class="fw-800 fs-4 text-dark"><?php echo SITE_NAME; ?></span>
                <?php endif; ?>
            </a>

            <!-- MOBILE TOGGLE -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- MENU ITEMS -->
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <?php 
                        $menuItems = getMenuItems();
                        $currentUrl = $_SERVER['REQUEST_URI'];
                        foreach($menuItems as $item) : 
                            $hasChildren = !empty($item->children);
                            // Check if current URL starts with item URL (for subpages) or exact match
                            $itemUrl = ($item->url == '/') ? '/' : $item->url;
                            $isActive = ($currentUrl == $itemUrl || ($itemUrl != '/' && strpos($currentUrl, $itemUrl) === 0)) ? 'active' : '';
                    ?>
                        <li class="nav-item <?php echo $hasChildren ? 'dropdown' : ''; ?>">
                            <a class="nav-link <?php echo $isActive; ?> <?php echo $hasChildren ? 'dropdown-toggle' : ''; ?>" 
                               href="<?php echo ($item->url == '/') ? URLROOT : (strpos($item->url, 'http') === 0 ? $item->url : URLROOT . $item->url); ?>"
                               <?php echo $hasChildren ? 'data-bs-toggle="dropdown"' : ''; ?>>
                                <?php echo $item->label; ?>
                            </a>
                            
                            <?php if($hasChildren) : ?>
                                <ul class="dropdown-menu">
                                    <?php foreach($item->children as $child) : 
                                        $hasGrandchildren = !empty($child->children);
                                    ?>
                                        <li class="<?php echo $hasGrandchildren ? 'dropdown-submenu' : ''; ?>">
                                            <a class="dropdown-item <?php echo $hasGrandchildren ? 'dropdown-toggle' : ''; ?>" 
                                               href="<?php echo strpos($child->url, 'http') === 0 ? $child->url : URLROOT . $child->url; ?>">
                                                <?php echo $child->label; ?>
                                            </a>
                                            <?php if($hasGrandchildren) : ?>
                                                <ul class="dropdown-menu">
                                                    <?php foreach($child->children as $grandchild) : ?>
                                                        <li>
                                                            <a class="dropdown-item" href="<?php echo strpos($grandchild->url, 'http') === 0 ? $grandchild->url : URLROOT . $grandchild->url; ?>">
                                                                <?php echo $grandchild->label; ?>
                                                            </a>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>

                    <!-- USER ACTIONS (LOGIN/LOGOUT) -->
                    <?php if(isset($_SESSION['admin_id'])) : ?>
                        <li class="nav-item dropdown ms-lg-3">
                            <a class="nav-link dropdown-toggle bg-light rounded-pill px-3" href="#" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-user-shield text-primary me-1"></i> Admin
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/admin/dashboard">Dashboard</a></li>
                                <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/admin/settings">Settings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="<?php echo URLROOT; ?>/admin/logout">Logout</a></li>
                            </ul>
                        </li>
                    <?php elseif(isset($_SESSION['sponsor_id'])) : ?>
                        <li class="nav-item dropdown ms-lg-3">
                            <a class="nav-link dropdown-toggle bg-light rounded-pill px-3" href="#" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-hand-holding-heart text-primary me-1"></i> Sponsor
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/sponsor/dashboard">Dashboard</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="<?php echo URLROOT; ?>/sponsor/logout">Logout</a></li>
                            </ul>
                        </li>
                    <?php elseif(isset($_SESSION['student_id'])) : ?>
                        <li class="nav-item dropdown ms-lg-3">
                            <a class="nav-link dropdown-toggle bg-light rounded-pill px-3" href="#" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-graduation-cap text-primary me-1"></i> Student
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/student/dashboard">Dashboard</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="<?php echo URLROOT; ?>/student/logout">Logout</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <!-- DONATE BUTTON -->
                    <li class="nav-item">
                        <a href="<?php echo getSetting('donate_url'); ?>" target="_blank" class="nav-link btn-donate">DONATE</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
