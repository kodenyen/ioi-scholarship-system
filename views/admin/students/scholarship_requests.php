<?php require APPROOT . '/views/layouts/header.php'; ?>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    body { background-color: #f0f2f5; font-family: 'Plus Jakarta Sans', sans-serif; }
    .page-header { margin-bottom: 2rem; }
    .page-title { font-weight: 800; font-size: 2.2rem; color: #001219; letter-spacing: -1px; margin: 0; }
    
    .data-card { background: white; border: none; border-radius: 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); overflow: hidden; height: 100%; transition: all 0.3s ease; border: 1px solid rgba(0,0,0,0.02); }
    .data-card:hover { transform: translateY(-5px); box-shadow: 0 12px 30px rgba(0,0,0,0.08); }
    .card-banner { height: 80px; background: linear-gradient(135deg, #ffb703 0%, #fb8500 100%); position: relative; }
    .avatar-wrapper { width: 80px; height: 80px; border-radius: 20px; background: white; padding: 5px; position: absolute; bottom: -40px; left: 24px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); }
    .avatar-img { width: 100%; height: 100%; border-radius: 15px; object-fit: cover; }
    .avatar-placeholder { width: 100%; height: 100%; border-radius: 15px; background: #f8f9fa; color: #fb8500; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 800; }
    
    .card-content { padding: 55px 24px 24px; }
    .data-name { font-weight: 700; font-size: 1.2rem; color: #001219; margin-bottom: 0.2rem; }
    .data-meta { font-size: 0.85rem; color: #6c757d; margin-bottom: 1.2rem; display: flex; align-items: center; gap: 8px; }
    .badge-class { padding: 4px 10px; border-radius: 6px; background: #fff9db; color: #f08c00; font-weight: 700; font-size: 0.7rem; text-transform: uppercase; }
    
    .student-about { font-size: 0.85rem; color: #555; line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 1.5rem; }
    
    .card-actions { display: grid; grid-template-columns: 1fr; gap: 10px; margin-top: auto; }
    .btn-assign { background: #005BFF; color: white; border-radius: 12px; padding: 12px; font-weight: 700; text-align: center; text-decoration: none; transition: all 0.2s; border: none; }
    .btn-assign:hover { background: #4FA242; color: white; transform: scale(1.02); }
    .btn-profile { background: #f8f9fa; color: #444; border: 1px solid #eee; border-radius: 12px; padding: 10px; font-weight: 600; font-size: 0.9rem; text-align: center; text-decoration: none; transition: all 0.2s; }
    .btn-profile:hover { border-color: #005BFF; color: #005BFF; }
</style>

<div class="container py-4">
    <div class="page-header animate-up">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/admin/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">Scholarship Requests</li>
            </ol>
        </nav>
        <h1 class="page-title">Scholarship Requests</h1>
        <p class="text-muted m-0">Students currently awaiting a sponsor assignment (Total: <?php echo $data['totalCount']; ?>).</p>
    </div>

    <?php flash('student_message'); ?>

    <?php if(empty($data['students'])) : ?>
        <div class="text-center py-5 animate-up">
            <div class="mb-4">
                <i class="fa-solid fa-circle-check text-success" style="font-size: 5rem;"></i>
            </div>
            <h3>All Students Assigned!</h3>
            <p class="text-muted">There are no students currently awaiting sponsorship.</p>
            <a href="<?php echo URLROOT; ?>/admin/students" class="btn btn-primary mt-3" style="border-radius: 12px; padding: 10px 25px;">View All Students</a>
        </div>
    <?php else : ?>
        <div class="row g-4">
            <?php foreach($data['students'] as $student) : ?>
                <div class="col-md-6 col-lg-4 animate-up">
                    <div class="data-card">
                        <div class="card-banner">
                            <div class="avatar-wrapper">
                                <?php if(!empty($student->profile_photo)) : ?>
                                    <img src="<?php echo URLROOT . '/' . $student->profile_photo; ?>" alt="Student" class="avatar-img">
                                <?php else : ?>
                                    <div class="avatar-placeholder">
                                        <?php echo substr($student->first_name, 0, 1) . substr($student->surname, 0, 1); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="card-content d-flex flex-column h-100">
                            <div class="data-name"><?php echo $student->first_name . ' ' . $student->surname; ?></div>
                            <div class="data-meta">
                                <span class="badge-class"><?php echo $student->class; ?></span>
                                <span class="text-muted small">&bull; <?php echo $student->age; ?> Years Old</span>
                            </div>
                            
                            <p class="student-about"><?php echo $student->about; ?></p>

                            <div class="card-actions">
                                <a href="<?php echo URLROOT; ?>/admin/assignments?student_id=<?php echo $student->id; ?>" class="btn-assign">
                                    <i class="fa-solid fa-link me-2"></i> Assign a Sponsor
                                </a>
                                <a href="<?php echo URLROOT; ?>/admin/student_profile/<?php echo $student->id; ?>" class="btn-profile">
                                    <i class="fa-solid fa-user me-2"></i> View Profile
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if($data['totalPages'] > 1) : ?>
            <nav class="mt-5 animate-up">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?php echo ($data['currentPage'] <= 1) ? 'disabled' : ''; ?>">
                        <a class="page-link shadow-sm border-0 px-3" href="<?php echo URLROOT; ?>/admin/scholarship_requests?page=<?php echo $data['currentPage'] - 1; ?>" style="border-radius: 10px 0 0 10px;">
                            <i class="fa-solid fa-chevron-left me-1"></i> Previous
                        </a>
                    </li>
                    
                    <?php for($i = 1; $i <= $data['totalPages']; $i++) : ?>
                        <li class="page-item <?php echo ($data['currentPage'] == $i) ? 'active' : ''; ?>">
                            <a class="page-link shadow-sm border-0 px-3 mx-1 <?php echo ($data['currentPage'] == $i) ? 'bg-primary text-white' : 'bg-white text-dark'; ?>" href="<?php echo URLROOT; ?>/admin/scholarship_requests?page=<?php echo $i; ?>" style="border-radius: 8px;">
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <li class="page-item <?php echo ($data['currentPage'] >= $data['totalPages']) ? 'disabled' : ''; ?>">
                        <a class="page-link shadow-sm border-0 px-3" href="<?php echo URLROOT; ?>/admin/scholarship_requests?page=<?php echo $data['currentPage'] + 1; ?>" style="border-radius: 0 10px 10px 0;">
                            Next <i class="fa-solid fa-chevron-right ms-1"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php require APPROOT . '/views/layouts/footer.php'; ?>
