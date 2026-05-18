<?php require APPROOT . '/views/layouts/header.php'; ?>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    body { background-color: #f0f2f5; font-family: 'Plus Jakarta Sans', sans-serif; }
    .page-header { margin-bottom: 2rem; }
    .page-title { font-weight: 800; font-size: 2.2rem; color: #001219; letter-spacing: -1px; margin: 0; }
    
    .filter-bar { background: white; padding: 20px; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); margin-bottom: 2rem; display: flex; gap: 15px; flex-wrap: wrap; align-items: flex-end; }
    .filter-group { flex: 1; min-width: 200px; }
    .filter-label { font-size: 0.7rem; font-weight: 700; color: #888; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; display: block; }
    .filter-control { border-radius: 12px; border: 1px solid #eee; padding: 10px 15px; font-size: 0.9rem; width: 100%; transition: all 0.3s; }
    .filter-control:focus { border-color: #005BFF; box-shadow: 0 0 0 4px rgba(0,91,255,0.1); outline: none; }
    
    .btn-filter { background: #005BFF; color: white; border: none; border-radius: 12px; padding: 10px 25px; font-weight: 700; height: 45px; transition: all 0.3s; }
    .btn-filter:hover { background: #4FA242; transform: translateY(-2px); }

    .btn-add { background: #005BFF; color: white; border: none; border-radius: 12px; padding: 0.75rem 1.5rem; font-weight: 600; transition: all 0.3s; display: flex; align-items: center; gap: 8px; }
    .btn-add:hover { background: #4FA242; color: white; transform: translateY(-2px); }
    
    .data-card { background: white; border: none; border-radius: 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); overflow: hidden; height: 100%; transition: all 0.3s ease; border: 1px solid rgba(0,0,0,0.02); }
    .data-card:hover { transform: translateY(-5px); box-shadow: 0 12px 30px rgba(0,0,0,0.08); }
    .card-banner { height: 80px; background: linear-gradient(135deg, #2b9348 0%, #005BFF 100%); position: relative; }
    .avatar-wrapper { width: 80px; height: 80px; border-radius: 20px; background: white; padding: 5px; position: absolute; bottom: -40px; left: 24px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); }
    .avatar-img { width: 100%; height: 100%; border-radius: 15px; object-fit: cover; }
    .avatar-placeholder { width: 100%; height: 100%; border-radius: 15px; background: #f8f9fa; color: #2b9348; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 800; }
    
    .card-content { padding: 55px 24px 24px; }
    .data-name { font-weight: 700; font-size: 1.2rem; color: #001219; margin-bottom: 0.2rem; }
    .data-meta { font-size: 0.85rem; color: #6c757d; margin-bottom: 1.2rem; display: flex; align-items: center; gap: 8px; }
    .badge-class { padding: 4px 10px; border-radius: 6px; background: #ebfbee; color: #2b8a3e; font-weight: 700; font-size: 0.7rem; text-transform: uppercase; }
    
    .student-about-container { position: relative; margin-bottom: 1.5rem; }
    .student-about { font-size: 0.85rem; color: #555; line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; transition: all 0.3s ease; }
    .student-about.expanded { -webkit-line-clamp: unset; display: block; }
    .btn-read-more { font-size: 0.75rem; font-weight: 700; color: #005BFF; cursor: pointer; background: none; border: none; padding: 0; margin-top: 5px; text-transform: uppercase; }
    
    .link-box { background: #f8f9fa; border-radius: 12px; padding: 12px; margin-bottom: 1.5rem; border: 1px solid #eee; }
    .link-label { font-size: 0.65rem; font-weight: 700; color: #888; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px; display: block; }
    .link-input-group { display: flex; gap: 8px; }
    .link-input { border: none; background: transparent; font-size: 0.8rem; color: #444; width: 100%; outline: none; }
    .btn-copy { background: white; border: 1px solid #ddd; border-radius: 8px; padding: 4px 10px; font-size: 0.75rem; font-weight: 600; color: #555; transition: all 0.2s; }
    .btn-copy:hover { background: #005BFF; color: white; border-color: #005BFF; }
    
    .card-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: auto; }
    .btn-view-full { grid-column: span 2; background: #005BFF; color: white; border-radius: 12px; padding: 10px; font-weight: 600; text-align: center; text-decoration: none; transition: all 0.2s; border: none; margin-bottom: 5px; }
    .btn-view-full:hover { background: #0046cc; transform: scale(1.01); }
    .btn-edit { background: #f8f9fa; color: #444; border: 1px solid #eee; border-radius: 10px; padding: 8px; font-weight: 600; font-size: 0.85rem; text-align: center; text-decoration: none; transition: all 0.2s; }
    .btn-edit:hover { border-color: #005BFF; color: #005BFF; }
    .btn-delete-data { background: #fff1f0; color: #d00000; border: none; border-radius: 10px; padding: 8px; font-weight: 600; font-size: 0.85rem; transition: all 0.2s; }
    .btn-delete-data:hover { background: #d00000; color: white; }
</style>

<div class="container py-4">
    <div class="page-header d-flex justify-content-between align-items-center animate-up">
        <div>
            <h1 class="page-title">Students</h1>
            <p class="text-muted m-0">Manage beneficiaries and their academic portfolios.</p>
        </div>
        <a href="<?php echo URLROOT; ?>/admin/add_student" class="btn-add">
            <i class="fa-solid fa-graduation-cap"></i> Add New Student
        </a>
    </div>

    <!-- Search & Sort Filter Bar -->
    <div class="filter-bar animate-up delay-1">
        <form action="<?php echo URLROOT; ?>/admin/students" method="get" class="d-flex gap-3 flex-wrap w-100">
            <div class="filter-group">
                <label class="filter-label">Search Beneficiaries</label>
                <input type="text" name="search" class="filter-control" placeholder="Name, Email or Class..." value="<?php echo $data['search']; ?>">
            </div>
            
            <div class="filter-group" style="max-width: 250px;">
                <label class="filter-label">Sort By</label>
                <select name="sort" class="filter-control">
                    <option value="newest" <?php echo $data['sort'] == 'newest' ? 'selected' : ''; ?>>Recently Added</option>
                    <option value="oldest" <?php echo $data['sort'] == 'oldest' ? 'selected' : ''; ?>>Oldest First</option>
                    <option value="class" <?php echo $data['sort'] == 'class' ? 'selected' : ''; ?>>Class (A-Z)</option>
                    <option value="age_asc" <?php echo $data['sort'] == 'age_asc' ? 'selected' : ''; ?>>Age (Youngest)</option>
                    <option value="age_desc" <?php echo $data['sort'] == 'age_desc' ? 'selected' : ''; ?>>Age (Oldest)</option>
                    <option value="assigned" <?php echo $data['sort'] == 'assigned' ? 'selected' : ''; ?>>Assignment Date</option>
                </select>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn-filter">
                    <i class="fa-solid fa-filter me-2"></i> Filter
                </button>
                <?php if(!empty($data['search']) || $data['sort'] != 'newest') : ?>
                    <a href="<?php echo URLROOT; ?>/admin/students" class="btn btn-light border d-flex align-items-center justify-content-center" style="border-radius: 12px; width: 45px; height: 45px;">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <?php flash('student_message'); ?>

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
                        
                        <div class="student-about-container">
                            <p class="student-about" id="about-<?php echo $student->id; ?>"><?php echo $student->about; ?></p>
                            <?php if(strlen($student->about) > 100) : ?>
                                <button type="button" class="btn-read-more" onclick="toggleAbout(<?php echo $student->id; ?>)" id="btn-<?php echo $student->id; ?>">Read More</button>
                            <?php endif; ?>
                        </div>

                        <div class="link-box">
                            <span class="link-label">Student Portal Link</span>
                            <div class="link-input-group">
                                <input type="text" class="link-input" value="<?php echo URLROOT; ?>/student/dashboard?token=<?php echo $student->access_token; ?>" readonly id="token-student-<?php echo $student->id; ?>">
                                <button class="btn-copy" onclick="copyStudentToken(<?php echo $student->id; ?>)">
                                    <i class="fa-regular fa-copy"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-actions">
                            <a href="<?php echo URLROOT; ?>/admin/student_profile/<?php echo $student->id; ?>" class="btn-view-full">
                                <i class="fa-solid fa-user-check me-2"></i> Manage Profile
                            </a>
                            <a href="<?php echo URLROOT; ?>/admin/edit_student/<?php echo $student->id; ?>" class="btn-edit">
                                <i class="fa-solid fa-pencil"></i> Edit
                            </a>
                            <form action="<?php echo URLROOT; ?>/admin/delete_student/<?php echo $student->id; ?>" method="post" onsubmit="return confirm('Delete this student?')">
                                <button type="submit" class="btn-delete-data w-100">
                                    <i class="fa-solid fa-trash-can"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <?php if($data['totalPages'] > 1) : ?>
        <nav class="mt-5 animate-up delay-2">
            <ul class="pagination justify-content-center">
                <li class="page-item <?php echo ($data['currentPage'] <= 1) ? 'disabled' : ''; ?>">
                    <a class="page-link shadow-sm border-0 px-3" href="<?php echo URLROOT; ?>/admin/students?page=<?php echo $data['currentPage'] - 1; ?>&search=<?php echo $search; ?>&sort=<?php echo $sort; ?>" style="border-radius: 10px 0 0 10px;">
                        <i class="fa-solid fa-chevron-left me-1"></i> Previous
                    </a>
                </li>
                
                <?php for($i = 1; $i <= $data['totalPages']; $i++) : ?>
                    <li class="page-item <?php echo ($data['currentPage'] == $i) ? 'active' : ''; ?>">
                        <a class="page-link shadow-sm border-0 px-3 mx-1 <?php echo ($data['currentPage'] == $i) ? 'bg-primary text-white' : 'bg-white text-dark'; ?>" href="<?php echo URLROOT; ?>/admin/students?page=<?php echo $i; ?>&search=<?php echo $search; ?>&sort=<?php echo $sort; ?>" style="border-radius: 8px;">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <li class="page-item <?php echo ($data['currentPage'] >= $data['totalPages']) ? 'disabled' : ''; ?>">
                    <a class="page-link shadow-sm border-0 px-3" href="<?php echo URLROOT; ?>/admin/students?page=<?php echo $data['currentPage'] + 1; ?>&search=<?php echo $search; ?>&sort=<?php echo $sort; ?>" style="border-radius: 0 10px 10px 0;">
                        Next <i class="fa-solid fa-chevron-right ms-1"></i>
                    </a>
                </li>
            </ul>
        </nav>
    <?php endif; ?>
</div>

<script>
function toggleAbout(id) {
    const aboutEl = document.getElementById('about-' + id);
    const btnEl = document.getElementById('btn-' + id);
    
    if (aboutEl.classList.contains('expanded')) {
        aboutEl.classList.remove('expanded');
        btnEl.innerText = 'Read More';
    } else {
        aboutEl.classList.add('expanded');
        btnEl.innerText = 'Show Less';
    }
}

function copyStudentToken(id) {
    var copyText = document.getElementById("token-student-" + id);
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(copyText.value);
    
    // Feedback
    const btn = event.currentTarget;
    const originalIcon = btn.innerHTML;
    btn.innerHTML = '<i class="fa-solid fa-check text-success"></i>';
    setTimeout(() => { btn.innerHTML = originalIcon; }, 2000);
}
</script>

<?php require APPROOT . '/views/layouts/footer.php'; ?>
