<?php require APPROOT . '/views/layouts/header.php'; ?>
<div class="row mb-3">
    <div class="col-md-6">
        <h1>Students</h1>
    </div>
    <div class="col-md-6 text-end">
        <a href="<?php echo URLROOT; ?>/admin/add_student" class="btn btn-primary">
            <i class="fa fa-plus"></i> Add Student
        </a>
    </div>
</div>
<?php flash('student_message'); ?>
<div class="row">
    <?php foreach($data['students'] as $student) : ?>
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; font-size: 1.5rem;">
                            <?php echo substr($student->first_name, 0, 1) . substr($student->surname, 0, 1); ?>
                        </div>
                        <div>
                            <h5 class="card-title mb-0"><?php echo $student->first_name . ' ' . $student->surname; ?></h5>
                            <p class="text-muted small mb-0"><?php echo $student->class; ?></p>
                        </div>
                    </div>
                    <p class="card-text small text-truncate"><?php echo $student->about; ?></p>
                    <div class="d-grid">
                        <a href="<?php echo URLROOT; ?>/admin/student_profile/<?php echo $student->id; ?>" class="btn btn-outline-primary btn-sm">View Profile</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php require APPROOT . '/views/layouts/footer.php'; ?>
