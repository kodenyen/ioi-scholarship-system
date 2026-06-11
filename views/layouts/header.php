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

        /* Remove faint border from User account dropdowns (Admin, Student, etc) */
        .ms-lg-3 .dropdown-menu li {
            border-bottom: none !important;
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

        /* User Actions Visibility */
        .main-navbar .nav-item.dropdown .nav-link.bg-light {
            color: #000 !important;
            font-weight: 700;
        }
        .main-navbar .nav-item.dropdown .nav-link.bg-light::after {
            color: #000 !important;
        }

        /* Mobile specific adjustments */
        @media (max-width: 991.98px) {
            .nav-link.active::after { display: none; }
            .top-info-bar { text-align: center; }
            .top-info-bar .contact-item { margin: 5px 10px; font-size: 0.75rem; }
            
            /* Floating Mobile Menu Styling */
            .navbar-collapse {
                background: white;
                position: fixed;
                top: 15px;
                left: 15px;
                right: 15px;
                width: calc(100% - 30px);
                max-height: 85vh;
                border-radius: 15px;
                padding: 0;
                z-index: 2000;
                overflow: hidden;
                box-shadow: 0 15px 50px rgba(0,0,0,0.3);
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                display: block !important;
                visibility: hidden;
                opacity: 0;
                transform: translateY(-20px);
            }
            .navbar-collapse.show {
                visibility: visible;
                opacity: 1;
                transform: translateY(0);
            }

            /* Mobile Menu Header (White Bar) */
            .mobile-menu-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 15px 20px;
                background: white;
                border-bottom: 1px solid #eee;
            }
            .mobile-menu-header img { height: 45px; width: auto; }
            .mobile-menu-close {
                font-size: 1.8rem;
                color: #333;
                cursor: pointer;
                background: none;
                border: none;
                padding: 0;
            }
            
            .navbar-nav {
                width: 100%;
                background: #1e2a4a; /* Dark navy for menu body */
                padding: 0;
            }
            .nav-item {
                border-bottom: 1px solid rgba(255, 255, 255, 0.05);
                width: 100%;
            }
            .nav-item:last-child { border-bottom: none; }

            .nav-link {
                padding: 18px 25px !important;
                font-size: 1.1rem !important;
                color: white !important;
                text-transform: uppercase;
                font-weight: 700;
                letter-spacing: 0.5px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                transition: background 0.2s;
            }
            
            /* Bright Blue for Home/Active */
            .nav-link.active, .nav-link:hover {
                background: #005BFF !important;
                color: white !important;
            }
            
            .dropdown-menu {
                background: rgba(0, 0, 0, 0.2);
                padding: 0;
                margin: 0;
                box-shadow: none;
                display: none;
                visibility: visible;
                opacity: 1;
                transform: none;
                pointer-events: auto;
                position: static;
                border-radius: 0;
            }
            .dropdown-menu.show {
                display: block;
            }
            .dropdown-item {
                color: rgba(255, 255, 255, 0.8) !important;
                padding: 15px 40px;
                font-size: 0.95rem;
                text-transform: uppercase;
                border-bottom: 1px solid rgba(255, 255, 255, 0.05);
                background: transparent !important;
            }
            .dropdown-item:hover {
                color: white !important;
                background: rgba(255, 255, 255, 0.1) !important;
            }
            
            /* Custom Mobile Actions (Header) */
            .mobile-actions {
                display: flex;
                align-items: center;
                gap: 15px;
            }
            .mobile-donate-btn {
                background: #005BFF;
                color: white !important;
                font-weight: 800;
                border-radius: 50px;
                padding: 8px 22px !important;
                text-decoration: none;
                text-transform: uppercase;
                font-size: 0.8rem;
                box-shadow: 0 4px 12px rgba(0, 91, 255, 0.3);
            }
            .navbar-toggler {
                padding: 0;
                font-size: 2rem;
                color: #333;
                line-height: 1;
            }
            
            /* Hide desktop items on mobile */
            .main-navbar .btn-donate { display: none; }
            /* Hide original toggler when menu is open to use the internal one */
            .main-navbar.menu-open .mobile-actions { visibility: hidden; }
        }
        
        @media (min-width: 992px) {
            .mobile-actions { display: none; }
            .mobile-menu-header { display: none; }
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
                    if($logo) : 
                ?>
                <img src="<?php echo asset($logo); ?>" alt="Logo">
                <?php else : ?>
                    <span class="fw-800 fs-4 text-dark"><?php echo SITE_NAME; ?></span>
                <?php endif; ?>
            </a>

            <!-- MOBILE ACTIONS + TOGGLE -->
            <div class="mobile-actions">
                <a href="<?php echo getSetting('donate_url'); ?>" target="_blank" class="mobile-donate-btn">DONATE</a>
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>

            <!-- MENU ITEMS -->
            <div class="collapse navbar-collapse" id="mainNav">
                <!-- Mobile Only Header -->
                <div class="mobile-menu-header">
                    <div class="d-flex align-items-center gap-3">
                        <?php if($logo) : ?>
                            <img src="<?php echo asset($logo); ?>" alt="Logo">
                        <?php endif; ?>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <a href="<?php echo getSetting('donate_url'); ?>" target="_blank" class="mobile-donate-btn">DONATE</a>
                        <button class="mobile-menu-close" data-bs-toggle="collapse" data-bs-target="#mainNav">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </div>

                <ul class="navbar-nav ms-auto align-items-center">
                    <?php 
                        $menuItems = getMenuItems();
                        $currentUrl = $_SERVER['REQUEST_URI'];
                        foreach($menuItems as $item) : 
                            $hasChildren = !empty($item->children);
                            $itemUrl = ($item->url == '/') ? '/' : $item->url;
                            // Exact match or active parent
                            $isActive = ($currentUrl == $itemUrl || ($itemUrl != '/' && strpos($currentUrl, $itemUrl) === 0)) ? 'active' : '';
                    ?>
                        <li class="nav-item <?php echo $hasChildren ? 'dropdown' : ''; ?>">
                            <a class="nav-link <?php echo $isActive; ?> <?php echo $hasChildren ? 'dropdown-toggle' : ''; ?>" 
                               href="<?php echo ($item->url == '/') ? URLROOT : (strpos($item->url, 'http') === 0 ? $item->url : URLROOT . $item->url); ?>"
                               <?php echo $hasChildren ? 'data-bs-toggle="dropdown" aria-expanded="false"' : ''; ?>>
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
                    <?php 
                        $url = $_SERVER['REQUEST_URI'];
                        $isStudentPath = (strpos($url, '/student') !== false);
                        $isSponsorPath = (strpos($url, '/sponsor') !== false);
                        $isAdminPath = (strpos($url, '/admin') !== false);
                    ?>

                    <?php if($isStudentPath && isset($_SESSION['student_id'])) : ?>
                        <li class="nav-item dropdown ms-lg-3">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-graduation-cap text-primary me-1"></i> Student
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/student/dashboard">Dashboard</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="<?php echo URLROOT; ?>/student/logout">Logout</a></li>
                            </ul>
                        </li>
                    <?php elseif($isSponsorPath && isset($_SESSION['sponsor_id'])) : ?>
                        <li class="nav-item dropdown ms-lg-3">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-hand-holding-heart text-primary me-1"></i> Sponsor
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <?php $token = isset($_GET['token']) ? $_GET['token'] : ''; ?>
                                    <a class="dropdown-item" href="<?php echo URLROOT; ?>/sponsor/dashboard<?php echo $token ? '?token='.$token : ''; ?>">Dashboard</a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="<?php echo URLROOT; ?>/sponsor/logout">Logout</a></li>
                            </ul>
                        </li>
                    <?php elseif(isset($_SESSION['admin_id'])) : ?>
                        <li class="nav-item dropdown ms-lg-3">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
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
                        <!-- Fallback for sponsor if not on sponsor path -->
                        <li class="nav-item dropdown ms-lg-3">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-hand-holding-heart text-primary me-1"></i> Sponsor
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/sponsor/dashboard">Dashboard</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="<?php echo URLROOT; ?>/sponsor/logout">Logout</a></li>
                            </ul>
                        </li>
                    <?php elseif(isset($_SESSION['student_id'])) : ?>
                        <!-- Fallback for student if not on student path -->
                        <li class="nav-item dropdown ms-lg-3">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
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
