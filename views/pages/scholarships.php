<?php require APPROOT . '/views/layouts/header.php'; ?>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    body { background-color: #f0f2f5; font-family: 'Plus Jakarta Sans', sans-serif; }
    .page-header { margin-bottom: 2.5rem; text-align: center; padding: 40px 0; background: white; border-radius: 0 0 40px 40px; box-shadow: 0 4px 20px rgba(0,0,0,0.02); margin-top: -24px; }
    .page-title { font-weight: 800; font-size: 2.8rem; color: #001219; letter-spacing: -1px; margin-bottom: 10px; }
    
    .data-card { background: white; border: none; border-radius: 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); overflow: hidden; height: 100%; transition: all 0.3s ease; border: 1px solid rgba(0,0,0,0.02); display: flex; flex-direction: column; }
    .data-card:hover { transform: translateY(-5px); box-shadow: 0 12px 30px rgba(0,0,0,0.08); }
    .card-banner { height: 100px; background: linear-gradient(90deg, #2b9348 0%, #005BFF 100%); position: relative; }
    .avatar-wrapper { width: 90px; height: 90px; border-radius: 24px; background: white; padding: 6px; position: absolute; bottom: -45px; left: 24px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); }
    .avatar-img { width: 100%; height: 100%; border-radius: 18px; object-fit: cover; }
    .avatar-placeholder { width: 100%; height: 100%; border-radius: 18px; background: #f8f9fa; color: #2b9348; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; font-weight: 800; }
    
    .card-content { padding: 55px 24px 24px; flex-grow: 1; display: flex; flex-direction: column; }
    .data-name { font-weight: 700; font-size: 1.3rem; color: #001219; margin-bottom: 0.2rem; }
    .data-meta { font-size: 0.85rem; color: #6c757d; margin-bottom: 1.2rem; display: flex; align-items: center; gap: 8px; }
    .badge-class { padding: 4px 10px; border-radius: 6px; background: #ebfbee; color: #2b8a3e; font-weight: 700; font-size: 0.7rem; text-transform: uppercase; }
    
    .student-about { font-size: 0.9rem; color: #555; line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 1.5rem; }
    
    .card-actions { display: grid; grid-template-columns: 1fr; gap: 10px; margin-top: auto; }
    .btn-sponsor { background: #2b9348; color: white; border-radius: 12px; padding: 12px; font-weight: 700; text-align: center; text-decoration: none; transition: all 0.2s; border: none; }
    .btn-sponsor:hover { background: #1e6632; color: white; transform: scale(1.02); }
    .btn-portfolio { background: #f8f9fa; color: #444; border: 1px solid #eee; border-radius: 12px; padding: 10px; font-weight: 600; font-size: 0.9rem; text-align: center; text-decoration: none; transition: all 0.2s; }
    .btn-portfolio:hover { border-color: #005BFF; color: #005BFF; }

    .modal-content { border-radius: 24px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.1); }
    .modal-header { border-bottom: 1px solid #eee; padding: 25px 30px; }
    .modal-body { padding: 30px; }
    .form-control { border-radius: 12px; padding: 12px 15px; border: 1px solid #eee; }
    .form-control:focus { border-color: #2b9348; box-shadow: 0 0 0 4px rgba(43, 147, 72, 0.1); }
</style>

<div class="page-header animate-up">
    <div class="container">
        <h1 class="page-title">Change a Life Today</h1>
        <p class="text-muted lead m-0">Browse our scholars awaiting sponsorship and start a journey of impact.</p>
    </div>
</div>

<div class="container py-5">
    <?php flash('scholarship_message'); ?>

    <?php if(empty($data['students'])) : ?>
        <div class="text-center py-5 animate-up">
            <div class="mb-4">
                <i class="fa-solid fa-heart-circle-check text-success" style="font-size: 5rem;"></i>
            </div>
            <h3>All Scholars Currently Sponsored!</h3>
            <p class="text-muted">Thank you for your heart to help. Please check back later or contact us to find other ways to support.</p>
            <a href="<?php echo URLROOT; ?>" class="btn btn-primary mt-3" style="border-radius: 12px; padding: 10px 25px;">Back to Home</a>
        </div>
    <?php else : ?>
        <div class="row g-4">
            <?php foreach($data['students'] as $student) : ?>
                <div class="col-md-6 col-lg-4 animate-up">
                    <div class="data-card">
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
                        <div class="card-content">
                            <div class="data-name"><?php echo $student->first_name . ' ' . $student->surname; ?></div>
                            <div class="data-meta">
                                <span class="badge-class"><?php echo $student->class; ?></span>
                                <span class="text-muted small">&bull; <?php echo $student->age; ?> Years Old</span>
                            </div>
                            
                            <p class="student-about"><?php echo $student->about; ?></p>

                            <div class="card-actions">
                                <button type="button" class="btn-sponsor" onclick="openInterestModal(<?php echo $student->id; ?>, '<?php echo $student->first_name . ' ' . $student->surname; ?>')">
                                    <i class="fa-solid fa-hand-holding-heart me-2"></i> Sponsor This Student
                                </button>
                                <a href="<?php echo URLROOT; ?>/pages/portfolio/<?php echo $student->id; ?>" class="btn-portfolio" target="_blank">
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
                        <a class="page-link shadow-sm border-0 px-3" href="<?php echo URLROOT; ?>/pages/scholarships?page=<?php echo $data['currentPage'] - 1; ?>" style="border-radius: 10px 0 0 10px;">
                            <i class="fa-solid fa-chevron-left me-1"></i> Previous
                        </a>
                    </li>
                    
                    <?php for($i = 1; $i <= $data['totalPages']; $i++) : ?>
                        <li class="page-item <?php echo ($data['currentPage'] == $i) ? 'active' : ''; ?>">
                            <a class="page-link shadow-sm border-0 px-3 mx-1 <?php echo ($data['currentPage'] == $i) ? 'bg-primary text-white' : 'bg-white text-dark'; ?>" href="<?php echo URLROOT; ?>/pages/scholarships?page=<?php echo $i; ?>" style="border-radius: 8px;">
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <li class="page-item <?php echo ($data['currentPage'] >= $data['totalPages']) ? 'disabled' : ''; ?>">
                        <a class="page-link shadow-sm border-0 px-3" href="<?php echo URLROOT; ?>/pages/scholarships?page=<?php echo $data['currentPage'] + 1; ?>" style="border-radius: 0 10px 10px 0;">
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
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">I'm Interested in Sponsoring</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo URLROOT; ?>/pages/interested_sponsorship" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="student_id" id="modal_student_id">
                    <p class="text-muted mb-4">You are expressing interest in <strong id="modal_student_name" class="text-dark"></strong>. Please provide your contact details so our admin can reach out to you.</p>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-uppercase">Full Name</label>
                        <input type="text" name="sponsor_name" class="form-control" placeholder="Enter your name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-uppercase">Email Address</label>
                        <input type="email" name="sponsor_email" class="form-control" placeholder="Enter your email" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-uppercase">Additional Message (Optional)</label>
                        <textarea name="message" class="form-control" rows="3" placeholder="Any questions or notes?"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4" style="background-color: #2b9348; border: none;">Submit Interest</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openInterestModal(id, name) {
        document.getElementById('modal_student_id').value = id;
        document.getElementById('modal_student_name').innerText = name;
        var myModal = new bootstrap.Modal(document.getElementById('interestModal'));
        myModal.show();
    }
</script>

<?php require APPROOT . '/views/layouts/footer.php'; ?>
