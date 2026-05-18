<?php require APPROOT . '/views/layouts/header.php'; ?>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    body { background-color: #f0f2f5; font-family: 'Plus Jakarta Sans', sans-serif; }
    .welcome-section { margin-bottom: 2.5rem; }
    .welcome-title { font-weight: 800; font-size: 2.2rem; color: #001219; letter-spacing: -1px; }
    
    .student-card { background: white; border: none; border-radius: 24px; box-shadow: 0 8px 30px rgba(0,0,0,0.05); overflow: hidden; transition: all 0.3s ease; border: 1px solid rgba(0,0,0,0.02); }
    .student-card:hover { transform: translateY(-5px); box-shadow: 0 12px 40px rgba(0,0,0,0.08); }
    .card-banner { height: 100px; background: linear-gradient(135deg, #2b9348 0%, #005BFF 100%); position: relative; }
    .card-avatar-wrapper { width: 90px; height: 90px; border-radius: 24px; background: white; padding: 5px; position: absolute; bottom: -45px; left: 24px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); }
    .card-avatar-img { width: 100%; height: 100%; border-radius: 20px; object-fit: cover; }
    .card-avatar-placeholder { width: 100%; height: 100%; border-radius: 20px; background: #f8f9fa; color: #2b9348; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; font-weight: 800; }
    
    .card-main-content { padding: 60px 24px 24px; }
    .student-name { font-weight: 700; font-size: 1.25rem; color: #001219; margin-bottom: 0.2rem; }
    .student-class { font-size: 0.85rem; font-weight: 600; color: #2b9348; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem; }
    
    .student-about-preview { font-size: 0.8rem; color: #666; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 1.5rem; transition: all 0.3s; }
    .student-about-preview.expanded { -webkit-line-clamp: unset; display: block; }
    .btn-read-about { font-size: 0.7rem; font-weight: 800; color: #005BFF; cursor: pointer; background: none; border: none; padding: 0; margin-bottom: 1rem; text-transform: uppercase; display: block; }
    
    .btn-portal { background: #005BFF; color: white; border: none; border-radius: 12px; padding: 0.75rem; font-weight: 600; width: 100%; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 10px; }
    .btn-portal:hover { background: #0046cc; color: white; }
    .btn-msg { background: #e7f5ff; color: #005BFF; border: none; border-radius: 12px; padding: 0.75rem; font-weight: 600; width: 100%; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 8px; }
    .btn-msg:hover { background: #005BFF; color: white; }
    
    .history-card { background: white; border: none; border-radius: 24px; box-shadow: 0 8px 30px rgba(0,0,0,0.05); padding: 1.5rem; }
    .history-header { font-weight: 700; font-size: 1.1rem; color: #001219; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px; }
    .msg-item { padding: 1rem; border-radius: 16px; background: #f8f9fa; margin-bottom: 1rem; border: 1px solid #f0f0f0; transition: all 0.2s; }
    .msg-item:hover { border-color: #005BFF; background: white; }
    .msg-meta { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem; }
    .msg-tag { font-size: 0.65rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; padding: 4px 8px; border-radius: 6px; }
    .tag-sent { background: #ebfbee; color: #2b8a3e; }
    .tag-from { background: #e7f5ff; color: #005BFF; }
</style>

<div class="container py-4">
    <div class="welcome-section animate-up">
        <h1 class="welcome-title">Hello, <?php echo explode(' ', $data['sponsor']->name)[0]; ?>!</h1>
        <p class="text-muted lead">Welcome to your scholar management portal.</p>
    </div>

    <?php flash('sponsor_message'); ?>

    <div class="row g-4">
        <div class="col-lg-8">
            <h5 class="fw-bold mb-4 text-dark d-flex align-items-center gap-2">
                <i class="fa-solid fa-graduation-cap text-primary"></i>
                Assigned Students
            </h5>
            <div class="row g-4">
                <?php foreach($data['students'] as $student) : ?>
                    <div class="col-md-6 animate-up delay-1">
                        <div class="student-card">
                            <div class="card-banner">
                                <div class="card-avatar-wrapper">
                                    <?php if(!empty($student->profile_photo)) : ?>
                                        <img src="<?php echo URLROOT . '/' . $student->profile_photo; ?>" alt="Student" class="card-avatar-img">
                                    <?php else : ?>
                                        <div class="card-avatar-placeholder">
                                            <?php echo substr($student->first_name, 0, 1) . substr($student->surname, 0, 1); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="card-main-content">
                                <div class="student-name"><?php echo $student->first_name . ' ' . $student->surname; ?></div>
                                <div class="student-class"><?php echo $student->class; ?> Scholar</div>
                                
                                <div class="student-about-preview" id="about-<?php echo $student->id; ?>">
                                    <?php echo $student->about; ?>
                                </div>
                                <?php if(strlen($student->about) > 80) : ?>
                                    <button class="btn-read-about" onclick="toggleStudentAbout(<?php echo $student->id; ?>)" id="btn-<?php echo $student->id; ?>">Read Bio</button>
                                <?php endif; ?>
                                
                                <a href="<?php echo URLROOT; ?>/sponsor/student_profile/<?php echo $student->id; ?>?token=<?php echo $_GET['token']; ?>" class="btn-portal">
                                    <i class="fa-solid fa-book-open"></i> View Portfolio
                                </a>
                                <a href="<?php echo URLROOT; ?>/sponsor/send_message/<?php echo $student->id; ?>?token=<?php echo $_GET['token']; ?>" class="btn-msg">
                                    <i class="fa-solid fa-paper-plane"></i> Send Message
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="col-lg-4">
            <h5 class="fw-bold mb-4 text-dark d-flex align-items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left text-primary"></i>
                Message History
            </h5>
        <div class="history-card animate-up delay-2">
                <?php if(empty($data['messages'])) : ?>
                    <div class="text-center py-4">
                        <p class="text-muted small">No message yet.</p>
                    </div>
                <?php else : ?>
                    <div id="message-container">
                        <?php foreach($data['messages'] as $index => $message) : ?>
                            <div class="msg-item <?php echo $index >= 5 ? 'd-none hidden-msg' : ''; ?>">
                                <div class="msg-meta">
                                    <?php if($message->sender_type == 'sponsor') : ?>
                                        <span class="msg-tag tag-sent">Sent to <?php echo explode(' ', $message->receiver_name)[0]; ?></span>
                                    <?php else : ?>
                                        <span class="msg-tag tag-from">From <?php echo explode(' ', $message->sender_name)[0]; ?></span>
                                    <?php endif; ?>
                                    <small class="text-muted" style="font-size: 0.7rem;"><?php echo date('M d', strtotime($message->created_at)); ?></small>
                                </div>
                                <p class="m-0 small text-dark" style="line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    <?php echo $message->content; ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <?php if(count($data['messages']) > 5) : ?>
                        <div class="text-center mt-3">
                            <button id="btn-view-more" class="btn btn-link btn-sm text-primary fw-bold text-decoration-none">
                                <i class="fa-solid fa-chevron-down me-1"></i> View More
                            </button>
                        </div>
                        <script>
                            document.getElementById('btn-view-more').addEventListener('click', function() {
                                const hiddenMsgs = document.querySelectorAll('.hidden-msg');
                                hiddenMsgs.forEach(msg => msg.classList.remove('d-none'));
                                this.parentElement.remove();
                            });
                        </script>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/layouts/footer.php'; ?>
<script>
function toggleStudentAbout(id) {
    const aboutEl = document.getElementById('about-' + id);
    const btnEl = document.getElementById('btn-' + id);
    
    if (aboutEl.classList.contains('expanded')) {
        aboutEl.classList.remove('expanded');
        btnEl.innerText = 'Read Bio';
    } else {
        aboutEl.classList.add('expanded');
        btnEl.innerText = 'Show Less';
    }
}
</script>
