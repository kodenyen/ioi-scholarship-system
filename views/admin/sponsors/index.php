<?php require APPROOT . '/views/layouts/header.php'; ?>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    body { background-color: #f0f2f5; font-family: 'Plus Jakarta Sans', sans-serif; }
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
    .page-title { font-weight: 800; font-size: 2.2rem; color: #001219; letter-spacing: -1px; margin: 0; }
    .btn-add { background: #005BFF; color: white; border: none; border-radius: 12px; padding: 0.75rem 1.5rem; font-weight: 600; transition: all 0.3s; display: flex; align-items: center; gap: 8px; }
    .btn-add:hover { background: #2b9348; color: white; transform: translateY(-2px); }
    
    .data-card { background: white; border: none; border-radius: 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); overflow: hidden; height: 100%; transition: all 0.3s ease; border: 1px solid rgba(0,0,0,0.02); }
    .data-card:hover { transform: translateY(-5px); box-shadow: 0 12px 30px rgba(0,0,0,0.08); }
    .card-banner { height: 80px; background: linear-gradient(135deg, #2b9348 0%, #005BFF 100%); position: relative; }
    .avatar-wrapper { width: 80px; height: 80px; border-radius: 20px; background: white; padding: 5px; position: absolute; bottom: -40px; left: 24px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); }
    .avatar-img { width: 100%; height: 100%; border-radius: 15px; object-fit: cover; }
    .avatar-placeholder { width: 100%; height: 100%; border-radius: 15px; background: #f8f9fa; color: #005BFF; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 800; }
    
    .card-content { padding: 55px 24px 24px; }
    .data-name { font-weight: 700; font-size: 1.2rem; color: #001219; margin-bottom: 0.2rem; }
    .data-meta { font-size: 0.85rem; color: #6c757d; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 5px; }
    
    .link-box { background: #f8f9fa; border-radius: 12px; padding: 12px; margin-bottom: 1.5rem; border: 1px solid #eee; }
    .link-label { font-size: 0.65rem; font-weight: 700; color: #888; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px; display: block; }
    .link-input-group { display: flex; gap: 8px; }
    .link-input { border: none; background: transparent; font-size: 0.8rem; color: #444; width: 100%; outline: none; }
    .btn-copy { background: white; border: 1px solid #ddd; border-radius: 8px; padding: 4px 10px; font-size: 0.75rem; font-weight: 600; color: #555; transition: all 0.2s; }
    .btn-copy:hover { background: #005BFF; color: white; border-color: #005BFF; }
    
    .card-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    .btn-edit { background: #f8f9fa; color: #444; border: 1px solid #eee; border-radius: 10px; padding: 8px; font-weight: 600; font-size: 0.85rem; text-align: center; text-decoration: none; transition: all 0.2s; }
    .btn-edit:hover { background: white; border-color: #005BFF; color: #005BFF; }
    .btn-delete-data { background: #fff1f0; color: #d00000; border: none; border-radius: 10px; padding: 8px; font-weight: 600; font-size: 0.85rem; transition: all 0.2s; }
    .btn-delete-data:hover { background: #d00000; color: white; }
</style>

<div class="container py-4">
    <div class="page-header animate-up">
        <div>
            <h1 class="page-title">Sponsors</h1>
            <p class="text-muted m-0">Manage and oversee all scholarship sponsors.</p>
        </div>
        <a href="<?php echo URLROOT; ?>/admin/add_sponsor" class="btn-add">
            <i class="fa-solid fa-user-plus"></i> Add New Sponsor
        </a>
    </div>

    <?php flash('sponsor_message'); ?>

    <div class="row g-4">
        <?php foreach($data['sponsors'] as $sponsor) : ?>
            <div class="col-md-6 col-lg-4 animate-up">
                <div class="data-card">
                    <div class="card-banner">
                        <div class="avatar-wrapper">
                            <?php if(!empty($sponsor->profile_photo)) : ?>
                                <img src="<?php echo URLROOT . '/' . $sponsor->profile_photo; ?>" alt="Sponsor" class="avatar-img">
                            <?php else : ?>
                                <div class="avatar-placeholder">
                                    <?php echo substr($sponsor->name, 0, 1); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="data-name"><?php echo $sponsor->name; ?></div>
                        <div class="data-meta">
                            <i class="fa-regular fa-envelope"></i> <?php echo $sponsor->email; ?>
                        </div>
                        
                        <div class="link-box">
                            <span class="link-label">Direct Access Link</span>
                            <div class="link-input-group">
                                <input type="text" class="link-input" value="<?php echo URLROOT; ?>/sponsor/dashboard?token=<?php echo $sponsor->access_token; ?>" readonly id="token-<?php echo $sponsor->id; ?>">
                                <button class="btn-copy" onclick="copyToken(<?php echo $sponsor->id; ?>)">
                                    <i class="fa-regular fa-copy"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-actions">
                            <a href="<?php echo URLROOT; ?>/admin/edit_sponsor/<?php echo $sponsor->id; ?>" class="btn-edit">
                                <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                            </a>
                            <form action="<?php echo URLROOT; ?>/admin/delete_sponsor/<?php echo $sponsor->id; ?>" method="post" onsubmit="return confirm('Delete this sponsor?')">
                                <button type="submit" class="btn-delete-data w-100">
                                    <i class="fa-solid fa-trash-can me-1"></i> Delete
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
                    <a class="page-link shadow-sm border-0 px-3" href="<?php echo URLROOT; ?>/admin/sponsors?page=<?php echo $data['currentPage'] - 1; ?>" style="border-radius: 10px 0 0 10px;">
                        <i class="fa-solid fa-chevron-left me-1"></i> Previous
                    </a>
                </li>
                
                <?php for($i = 1; $i <= $data['totalPages']; $i++) : ?>
                    <li class="page-item <?php echo ($data['currentPage'] == $i) ? 'active' : ''; ?>">
                        <a class="page-link shadow-sm border-0 px-3 mx-1 <?php echo ($data['currentPage'] == $i) ? 'bg-primary text-white' : 'bg-white text-dark'; ?>" href="<?php echo URLROOT; ?>/admin/sponsors?page=<?php echo $i; ?>" style="border-radius: 8px;">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <li class="page-item <?php echo ($data['currentPage'] >= $data['totalPages']) ? 'disabled' : ''; ?>">
                    <a class="page-link shadow-sm border-0 px-3" href="<?php echo URLROOT; ?>/admin/sponsors?page=<?php echo $data['currentPage'] + 1; ?>" style="border-radius: 0 10px 10px 0;">
                        Next <i class="fa-solid fa-chevron-right ms-1"></i>
                    </a>
                </li>
            </ul>
        </nav>
    <?php endif; ?>
</div>

<script>
function copyToken(id) {
    var copyText = document.getElementById("token-" + id);
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
