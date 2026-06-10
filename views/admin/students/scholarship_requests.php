<?php require APPROOT . '/views/layouts/header.php'; ?>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    body { background-color: #f0f2f5; font-family: 'Plus Jakarta Sans', sans-serif; }
    .page-header { margin-bottom: 2rem; }
    .page-title { font-weight: 800; font-size: 2.2rem; color: #001219; letter-spacing: -1px; margin: 0; }
    
    .data-card { background: white; border: none; border-radius: 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); overflow: hidden; height: 100%; transition: all 0.3s ease; border: 1px solid rgba(0,0,0,0.02); display: flex; flex-direction: column; }
    .data-card:hover { transform: translateY(-5px); box-shadow: 0 12px 30px rgba(0,0,0,0.08); }
    .card-banner { height: 80px; background: linear-gradient(90deg, #2b9348 0%, #005BFF 100%); position: relative; }
    .avatar-wrapper { width: 80px; height: 80px; border-radius: 20px; background: white; padding: 5px; position: absolute; bottom: -40px; left: 24px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); }
    .avatar-img { width: 100%; height: 100%; border-radius: 15px; object-fit: cover; }
    .avatar-placeholder { width: 100%; height: 100%; border-radius: 15px; background: #f8f9fa; color: #2b9348; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 800; }
    
    .card-content { padding: 55px 24px 24px; flex: 1; display: flex; flex-direction: column; }
    .data-name { font-weight: 700; font-size: 1.2rem; color: #001219; margin-bottom: 0.2rem; }
    .data-meta { font-size: 0.85rem; color: #6c757d; margin-bottom: 1.2rem; display: flex; align-items: center; gap: 8px; }
    .badge-class { padding: 4px 10px; border-radius: 6px; background: #fff9db; color: #f08c00; font-weight: 700; font-size: 0.7rem; text-transform: uppercase; }
    
    .student-about { font-size: 0.85rem; color: #555; line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 1.5rem; }
    
    .card-actions { margin-top: auto; display: flex; flex-direction: column; gap: 10px; }
    
    .btn-profile { 
        background: #ffffff !important; 
        color: #005BFF !important; 
        border: 2px solid #005BFF !important; 
        border-radius: 12px !important; 
        padding: 12px !important; 
        font-weight: 700 !important; 
        font-size: 0.9rem !important; 
        text-align: center !important; 
        text-decoration: none !important; 
        transition: all 0.2s !important; 
        display: block !important;
        width: 100% !important;
        box-shadow: 0 4px 10px rgba(0,91,255,0.1) !important;
    }
    .btn-profile:hover { background: #005BFF !important; color: white !important; }
</style>

<div class="container py-4">
    <div class="page-header animate-up">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>">Home</a></li>
                <li class="breadcrumb-item active">Scholarship Requests</li>
            </ol>
        </nav>
        <h1 class="page-title">Change a Life Today</h1>
        <p class="text-muted m-0">Browse our scholars awaiting sponsorship and start a journey of impact (Total: <?php echo $data['totalCount']; ?>).</p>
    </div>

    <?php flash('student_message'); ?>

    <?php if(empty($data['students'])) : ?>
        <div class="text-center py-5 animate-up">
            <div class="mb-4">
                <i class="fa-solid fa-circle-check text-success" style="font-size: 5rem;"></i>
            </div>
            <h3>All Students Assigned!</h3>
            <p class="text-muted">There are no students currently awaiting sponsorship.</p>
            <a href="<?php echo URLROOT; ?>" class="btn btn-primary mt-3" style="border-radius: 12px; padding: 10px 25px;">Back to Home</a>
        </div>
    <?php else : ?>
        <div class="row g-4">
            <?php foreach($data['students'] as $student) : ?>
                <div class="col-md-6 col-lg-4 animate-up">
                    <div class="data-card position-relative">
                        <!-- High Visibility Interest Badge -->
                        <?php if(isset($student->has_interest) && $student->has_interest > 0) : ?>
                            <div class="position-absolute top-0 end-0 mt-3 me-3" style="z-index: 10;">
                                <span class="badge bg-warning text-dark fw-bold px-3 py-2 shadow-sm rounded-pill border border-warning">
                                    <i class="fa-solid fa-star text-danger me-1"></i> Interest Indicated
                                </span>
                            </div>
                        <?php endif; ?>
                        
                        <div class="card-banner">
                            <div class="avatar-wrapper">
                                <?php if(!empty($student->profile_photo)) : ?>
                                    <img src="<?php echo asset($student->profile_photo); ?>" alt="Student" class="avatar-img">
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
                                <button type="button" class="btn btn-success fw-bold rounded-pill py-2" style="background-color: #2b9348 !important; border: none !important;" onclick="openInterestModal(<?php echo $student->id; ?>, '<?php echo $student->first_name . ' ' . $student->surname; ?>')">
                                    <i class="fa-solid fa-hand-holding-heart me-2"></i> Sponsor This Student
                                </button>
                                <a href="<?php echo URLROOT; ?>/pages/portfolio/<?php echo $student->id; ?>" class="btn-profile" target="_blank">
                                    <i class="fa-solid fa-book-open me-2"></i> View Student Portfolio
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
                        <a class="page-link shadow-sm border-0 px-3" href="?page=<?php echo $data['currentPage'] - 1; ?>" style="border-radius: 10px 0 0 10px;">
                            <i class="fa-solid fa-chevron-left me-1"></i> Previous
                        </a>
                    </li>
                    
                    <?php for($i = 1; $i <= $data['totalPages']; $i++) : ?>
                        <li class="page-item <?php echo ($data['currentPage'] == $i) ? 'active' : ''; ?>">
                            <a class="page-link shadow-sm border-0 px-3 mx-1 <?php echo ($data['currentPage'] == $i) ? 'bg-primary text-white' : 'bg-white text-dark'; ?>" href="?page=<?php echo $i; ?>" style="border-radius: 8px;">
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <li class="page-item <?php echo ($data['currentPage'] >= $data['totalPages']) ? 'disabled' : ''; ?>">
                        <a class="page-link shadow-sm border-0 px-3" href="?page=<?php echo $data['currentPage'] + 1; ?>" style="border-radius: 0 10px 10px 0;">
                            Next <i class="fa-solid fa-chevron-right ms-1"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>
    <?php endif; ?>
</div>

<!-- Interest Modal -->
<div class="modal fade" id="interestModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 24px; border: none;">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo URLROOT; ?>/pages/interested_sponsorship" method="POST">
                <div class="modal-body p-4">
                    <h4 class="fw-bold text-center mb-4">Sponsorship Interest</h4>
                    <input type="hidden" name="student_id" id="modal_student_id">
                    <p class="text-muted text-center mb-4">You are interested in sponsoring <strong id="modal_student_name"></strong>. Please leave your details.</p>
                    
                    <div class="mb-3">
                        <input type="text" name="sponsor_name" class="form-control" placeholder="Your Full Name" required style="border-radius: 12px; padding: 12px;">
                    </div>
                    <div class="mb-3">
                        <input type="email" name="sponsor_email" class="form-control" placeholder="Your Email" required style="border-radius: 12px; padding: 12px;">
                    </div>
                    <div class="mb-3">
                        <textarea name="message" class="form-control" rows="3" placeholder="Additional notes..." style="border-radius: 12px; padding: 12px;"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100 rounded-pill py-3 fw-bold mt-2" style="background: #2b9348; border: none;">Send Interest</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openInterestModal(id, name) {
        document.getElementById('modal_student_id').value = id;
        document.getElementById('modal_student_name').innerText = name;
        new bootstrap.Modal(document.getElementById('interestModal')).show();
    }
</script>

<?php require APPROOT . '/views/layouts/footer.php'; ?>
