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
    
    .menu-card { background: white; border-radius: 24px; box-shadow: 0 8px 30px rgba(0,0,0,0.05); padding: 2.5rem; border: 1px solid rgba(0,0,0,0.02); }
    .section-title { font-weight: 700; font-size: 1.25rem; color: #001219; margin-bottom: 2rem; border-bottom: 1px solid #f0f0f0; padding-bottom: 1rem; display: flex; align-items: center; gap: 10px; }
    
    .menu-list { list-style: none; padding: 0; }
    .menu-item-row { display: flex; align-items: center; justify-content: space-between; padding: 12px 20px; background: #f8f9fa; border-radius: 12px; margin-bottom: 10px; border: 1px solid #eee; transition: all 0.2s; }
    .menu-item-row:hover { border-color: #005BFF; background: white; }
    .menu-item-info { display: flex; align-items: center; gap: 15px; }
    .menu-drag-handle { color: #ccc; cursor: grab; }
    .menu-label { font-weight: 700; color: #001219; font-size: 0.95rem; }
    .menu-url { font-size: 0.75rem; color: #888; font-family: monospace; }
    
    .submenu-list { padding-left: 40px; margin-top: -5px; margin-bottom: 15px; border-left: 2px solid #e7f5ff; }
    
    .btn-delete-menu { background: #fff1f0; color: #d00000; border: none; width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; transition: all 0.2s; }
    .btn-delete-menu:hover { background: #d00000; color: white; }
    
    .add-menu-form { background: #f8f9fa; border-radius: 20px; padding: 1.5rem; margin-top: 2rem; border: 1px dashed #dee2e6; }
</style>

<div class="container py-4">
    <div class="animate-up">
        <h1 class="page-title">Navigation Manager</h1>
        <p class="text-muted">Customize your website's header menu and sub-menu structure.</p>
    </div>

    <?php flash('menu_message'); ?>

    <div class="settings-container">
        <!-- Sidebar Navigation -->
        <div class="settings-nav animate-up delay-1">
            <a href="<?php echo URLROOT; ?>/admin/settings" class="settings-nav-item">
                <i class="fa-solid fa-palette"></i> Branding & Logo
            </a>
            <a href="<?php echo URLROOT; ?>/admin/menu_manager" class="settings-nav-item active">
                <i class="fa-solid fa-bars"></i> Menu Manager
            </a>
            <a href="#" class="settings-nav-item opacity-50">
                <i class="fa-solid fa-shield-halved"></i> Security
            </a>
        </div>

        <!-- Main Menu Manager -->
        <div class="menu-card animate-up delay-2">
            <div class="section-title">
                <i class="fa-solid fa-layer-group text-primary"></i> Current Menu Structure
            </div>

            <div class="menu-list">
                <?php 
                function renderAdminMenu($items, $level = 0) {
                    foreach($items as $item) : ?>
                        <div class="menu-item-row" style="margin-left: <?php echo $level * 20; ?>px">
                            <div class="menu-item-info">
                                <i class="fa-solid fa-grip-vertical menu-drag-handle"></i>
                                <div>
                                    <div class="menu-label"><?php echo $item->label; ?></div>
                                    <div class="menu-url"><?php echo $item->url; ?></div>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <form action="<?php echo URLROOT; ?>/admin/delete_menu_item/<?php echo $item->id; ?>" method="post" onsubmit="return confirm('Delete this menu item and all its sub-items?')">
                                    <button type="submit" class="btn-delete-menu"><i class="fa-solid fa-trash-can"></i></button>
                                </form>
                            </div>
                        </div>
                        <?php if(!empty($item->children)) renderAdminMenu($item->children, $level + 1); ?>
                    <?php endforeach;
                }
                renderAdminMenu($data['menu_items']);
                ?>
            </div>

            <!-- Add New Item Form -->
            <div class="add-menu-form">
                <h6 class="fw-800 mb-3"><i class="fa-solid fa-plus-circle text-success me-2"></i> Add Menu Item</h6>
                <form action="<?php echo URLROOT; ?>/admin/menu_manager" method="post">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-uppercase">Item Label</label>
                            <input type="text" name="label" class="form-control" placeholder="e.g. SERVICES" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-uppercase">URL / Link</label>
                            <input type="text" name="url" class="form-control" placeholder="/services or #">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-uppercase">Parent Item</label>
                            <select name="parent_id" class="form-select">
                                <option value="">None (Top Level)</option>
                                <?php foreach($data['flat_items'] as $flat) : ?>
                                    <option value="<?php echo $flat->id; ?>"><?php echo $flat->label; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small fw-bold text-uppercase">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" value="0">
                        </div>
                        <div class="col-md-10 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary fw-bold px-4 rounded-pill">
                                <i class="fa-solid fa-save me-2"></i> Add to Menu
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/layouts/footer.php'; ?>
