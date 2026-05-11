<?php require APPROOT . '/views/layouts/header.php'; ?>
<div class="row mb-4">
    <div class="col-md-12">
        <h1>Dashboard</h1>
        <p class="lead">Welcome, <?php echo $_SESSION['admin_name']; ?>. Manage your system here.</p>
    </div>
</div>

<div class="row text-center">
    <div class="col-md-4 mb-3">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="card-title">Pending Messages</h5>
                <h2 class="display-4 text-primary">0</h2>
                <a href="<?php echo URLROOT; ?>/admin/moderation" class="btn btn-outline-primary mt-2">View Messages</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="card-title">Total Sponsors</h5>
                <h2 class="display-4 text-primary">0</h2>
                <a href="<?php echo URLROOT; ?>/admin/sponsors" class="btn btn-outline-primary mt-2">Manage Sponsors</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="card-title">Total Students</h5>
                <h2 class="display-4 text-primary">0</h2>
                <a href="<?php echo URLROOT; ?>/admin/students" class="btn btn-outline-primary mt-2">Manage Students</a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6 mb-3">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5>Form Builder</h5>
                <p>Create and customize communication forms for sponsors and students.</p>
                <a href="<?php echo URLROOT; ?>/admin/forms" class="btn btn-primary">Open Form Builder</a>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5>Assignments</h5>
                <p>Link sponsors to their assigned students for moderated communication.</p>
                <a href="<?php echo URLROOT; ?>/admin/assignments" class="btn btn-primary">Manage Assignments</a>
            </div>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/layouts/footer.php'; ?>
