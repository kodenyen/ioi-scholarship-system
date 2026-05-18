<?php require APPROOT . '/views/layouts/header.php'; ?>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    body { background-color: #f0f2f5; font-family: 'Plus Jakarta Sans', sans-serif; }
    .page-title { font-weight: 800; font-size: 2.2rem; color: #001219; letter-spacing: -1px; }
    .card-modern { background: white; border: none; border-radius: 24px; box-shadow: 0 8px 30px rgba(0,0,0,0.05); overflow: hidden; height: 100%; }
    .card-header-modern { background: linear-gradient(135deg, #2b9348 0%, #005BFF 100%); color: white; padding: 1.5rem 2rem; border: none; }
    .form-label { font-weight: 600; font-size: 0.85rem; color: #444; text-transform: uppercase; letter-spacing: 0.5px; }
    .form-select { border-radius: 12px; padding: 0.75rem 1rem; border: 1px solid #e0e0e0; background-color: #f8f9fa; transition: all 0.3s; }
    .form-select:focus { background-color: white; border-color: #005BFF; box-shadow: 0 0 0 4px rgba(0,91,255,0.1); }
    .btn-assign { background: #005BFF; color: white; border: none; border-radius: 12px; padding: 0.8rem; font-weight: 700; width: 100%; transition: all 0.3s; }
    .btn-assign:hover { background: #4FA242 !important; border-color: #4FA242 !important; transform: translateY(-2px); }
    
    .table-container { background: white; border-radius: 24px; padding: 1.5rem; box-shadow: 0 8px 30px rgba(0,0,0,0.05); }
    .table thead th { background: transparent; border-bottom: 2px solid #f0f0f0; color: #888; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; padding: 1.2rem; }
    .table tbody td { padding: 1.2rem; vertical-align: middle; border-bottom: 1px solid #f8f9fa; color: #444; font-weight: 500; }
    
    .assignment-badge { display: flex; align-items: center; gap: 10px; padding: 8px 12px; background: #f8f9fa; border-radius: 12px; border: 1px solid #eee; }
    .badge-icon { width: 30px; height: 30px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; }
    .icon-sponsor { background: #e7f5ff; color: #005BFF; }
    .icon-student { background: #ebfbee; color: #2b8a3e; }
    
    .btn-unassign { background: #fff1f0; color: #d00000; border: none; border-radius: 10px; padding: 6px 15px; font-size: 0.8rem; font-weight: 700; transition: all 0.2s; }
    .btn-unassign:hover { background: #d00000; color: white; }
</style>

<div class="container py-4">
    <div class="mb-5 animate-up">
        <h1 class="page-title">Scholar Assignments</h1>
        <p class="text-muted">Connect sponsors with their assigned students.</p>
    </div>

    <?php flash('assignment_message'); ?>

    <div class="row g-4">
        <div class="col-lg-4 animate-up delay-1">
            <div class="card-modern">
                <div class="card-header-modern">
                    <h5 class="mb-0"><i class="fa-solid fa-link me-2"></i> New Assignment</h5>
                </div>
                <div class="card-body p-4">
                    <form action="<?php echo URLROOT; ?>/admin/assignments" method="post">
                        <div class="mb-4">
                            <label class="form-label">Sponsor</label>
                            <select name="sponsor_id" class="form-select">
                                <option value="" disabled selected>Choose a sponsor...</option>
                                <?php foreach($data['sponsors'] as $sponsor) : ?>
                                    <option value="<?php echo $sponsor->id; ?>"><?php echo $sponsor->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Student / Beneficiary</label>
                            <select name="student_id" class="form-select">
                                <option value="" disabled selected>Choose a student...</option>
                                <?php foreach($data['students'] as $student) : ?>
                                    <option value="<?php echo $student->id; ?>"><?php echo $student->first_name . ' ' . $student->surname; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn-assign">
                            <i class="fa-solid fa-plus-circle me-2"></i> Confirm Assignment
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8 animate-up delay-2">
            <div class="table-container">
                <h5 class="fw-bold mb-4 px-3">Active Assignments</h5>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sponsor</th>
                                <th>Student</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($data['assignments'])) : ?>
                                <tr>
                                    <td colspan="3" class="text-center py-5 text-muted small">No assignments found.</td>
                                </tr>
                            <?php endif; ?>
                            <?php foreach($data['assignments'] as $assignment) : ?>
                                <tr>
                                    <td>
                                        <div class="assignment-badge">
                                            <div class="badge-icon icon-sponsor"><i class="fa-solid fa-hand-holding-heart"></i></div>
                                            <span><?php echo $assignment->sponsor_name; ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="assignment-badge">
                                            <div class="badge-icon icon-student"><i class="fa-solid fa-graduation-cap"></i></div>
                                            <span><?php echo $assignment->first_name . ' ' . $assignment->surname; ?></span>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <a href="<?php echo URLROOT; ?>/admin/unassign/<?php echo $assignment->sponsor_id; ?>/<?php echo $assignment->student_id; ?>" class="btn-unassign" onclick="return confirm('Remove this assignment?')">
                                            <i class="fa-solid fa-link-slash me-1"></i> Unassign
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/layouts/footer.php'; ?>
