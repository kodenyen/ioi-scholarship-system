<?php require APPROOT . '/views/layouts/header.php'; ?>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    body { background-color: #f0f2f5; font-family: 'Plus Jakarta Sans', sans-serif; }
    .page-title { font-weight: 800; font-size: 2.2rem; color: #001219; letter-spacing: -1px; }
    .interest-card { background: white; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: none; transition: transform 0.2s; }
    .interest-card:hover { transform: translateY(-3px); }
    .status-badge { padding: 5px 12px; border-radius: 50px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; }
    .status-pending { background: #fff4e6; color: #f08c00; }
    .status-reviewed { background: #ebfbee; color: #2b8a3e; }
    .btn-review { background: #005BFF; color: white; border-radius: 10px; font-weight: 600; padding: 8px 20px; border: none; transition: 0.3s; }
    .btn-review:hover { background: #2b9348; transform: scale(1.05); }
</style>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="page-title">Sponsorship Interests</h1>
            <p class="text-muted">Potential sponsors who have expressed interest in students.</p>
        </div>
        <a href="<?php echo URLROOT; ?>/admin/dashboard" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="fa fa-arrow-left me-2"></i> Dashboard
        </a>
    </div>

    <?php flash('interest_message'); ?>

    <?php if(empty($data['interests'])) : ?>
        <div class="text-center py-5">
            <i class="fa-solid fa-heart-pulse text-muted mb-3" style="font-size: 4rem;"></i>
            <h3>No interests recorded yet.</h3>
            <p class="text-muted">Interests from the public scholarship page will appear here.</p>
        </div>
    <?php else : ?>
        <div class="row g-4">
            <?php foreach($data['interests'] as $interest) : ?>
                <div class="col-md-6 col-lg-4">
                    <div class="interest-card p-4 h-100 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <span class="status-badge <?php echo $interest->status == 'pending' ? 'status-pending' : 'status-reviewed'; ?>">
                                <?php echo $interest->status; ?>
                            </span>
                            <small class="text-muted"><?php echo date('M d, Y', strtotime($interest->created_at)); ?></small>
                        </div>
                        
                        <h5 class="fw-bold mb-1"><?php echo $interest->sponsor_name; ?></h5>
                        <p class="text-primary small mb-3"><i class="fa fa-envelope me-1"></i> <?php echo $interest->sponsor_email; ?></p>
                        
                        <div class="bg-light p-3 rounded-3 mb-3 flex-grow-1">
                            <small class="text-muted d-block text-uppercase fw-bold mb-2" style="font-size: 0.65rem;">Interested In:</small>
                            <h6 class="fw-bold mb-2"><?php echo $interest->first_name . ' ' . $interest->surname; ?></h6>
                            <?php if(!empty($interest->message)) : ?>
                                <hr class="my-2">
                                <p class="small text-dark m-0 italic">"<?php echo $interest->message; ?>"</p>
                            <?php endif; ?>
                        </div>

                        <?php if($interest->status == 'pending') : ?>
                            <form action="<?php echo URLROOT; ?>/admin/interests" method="POST">
                                <input type="hidden" name="id" value="<?php echo $interest->id; ?>">
                                <button type="submit" class="btn-review w-100">
                                    <i class="fa fa-check-circle me-2"></i> Mark as Reviewed
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require APPROOT . '/views/layouts/footer.php'; ?>
