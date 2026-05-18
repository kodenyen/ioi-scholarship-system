<?php require APPROOT . '/views/layouts/header.php'; ?>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    body { background-color: #f0f2f5; font-family: 'Plus Jakarta Sans', sans-serif; }
    .profile-card { background: white; border: none; border-radius: 24px; box-shadow: 0 8px 30px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid rgba(0,0,0,0.02); }
    .profile-banner { height: 120px; background: linear-gradient(135deg, #005BFF 0%, #2b9348 100%); }
    .profile-avatar-wrapper { width: 120px; height: 120px; border-radius: 30px; background: white; padding: 6px; margin: -60px auto 1rem; box-shadow: 0 12px 25px rgba(0,0,0,0.1); }
    .profile-avatar-img { width: 100%; height: 100%; border-radius: 24px; object-fit: cover; }
    .profile-avatar-placeholder { width: 100%; height: 100%; border-radius: 24px; background: #f8f9fa; color: #005BFF; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; font-weight: 800; }
    
    .status-pill { padding: 6px 15px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; background: #ebfbee; color: #2b8a3e; display: inline-block; margin-bottom: 1.5rem; }
    
    .info-section { padding: 1.5rem; border-top: 1px solid #f0f0f0; }
    .info-label { font-size: 0.7rem; font-weight: 700; color: #888; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem; display: block; }
    
    .sponsor-mini-card { display: flex; align-items: center; gap: 12px; padding: 10px; border-radius: 12px; background: #f8f9fa; margin-bottom: 10px; border: 1px solid transparent; transition: all 0.2s; }
    .sponsor-mini-card:hover { border-color: #005BFF; background: white; }
    .sponsor-mini-avatar { width: 35px; height: 35px; border-radius: 8px; background: #e7f5ff; color: #005BFF; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.8rem; }
    
    .message-bubble { background: white; border-radius: 20px; padding: 1.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.03); margin-bottom: 1.5rem; border: 1px solid rgba(0,0,0,0.01); position: relative; }
    .message-bubble.from-sponsor { border-left: 5px solid #005BFF; }
    .message-bubble.to-sponsor { border-left: 5px solid #2b9348; }
    .msg-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem; }
    
    .btn-reply { background: #005BFF; color: white; border: none; border-radius: 10px; padding: 6px 15px; font-size: 0.8rem; font-weight: 600; transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px; }
    .btn-reply:hover { background: #2b9348; color: white; transform: translateY(-1px); }
    .student-about-text { font-size: 0.85rem; color: #444; line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; transition: all 0.3s ease; }
    .student-about-text.expanded { -webkit-line-clamp: unset; display: block; }
    .btn-toggle-about { font-size: 0.75rem; font-weight: 700; color: #005BFF; cursor: pointer; background: none; border: none; padding: 0; margin-top: 8px; text-transform: uppercase; }
</style>

<div class="container py-4">
    <div class="row g-4">
        <div class="col-lg-4 animate-up">
            <div class="profile-card">
                <div class="profile-banner"></div>
                <div class="card-body text-center p-4">
                    <div class="profile-avatar-wrapper">
                        <?php if(!empty($data['student']->profile_photo)) : ?>
                            <img src="<?php echo URLROOT . '/' . $data['student']->profile_photo; ?>" alt="Me" class="profile-avatar-img">
                        <?php else : ?>
                            <div class="profile-avatar-placeholder">
                                <?php echo substr($data['student']->first_name, 0, 1); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <h4 class="fw-bold mb-1"><?php echo $data['student']->first_name . ' ' . $data['student']->surname; ?></h4>
                    <p class="text-muted small mb-3"><?php echo $data['student']->class; ?> Student &bull; <?php echo $data['student']->age; ?> Years</p>
                    <div class="status-pill">Active Scholar</div>
                    
                    <div class="text-start info-section">
                        <span class="info-label">My Sponsors</span>
                        <?php if(!empty($data['sponsors'])) : ?>
                            <?php foreach($data['sponsors'] as $sponsor) : ?>
                                <div class="sponsor-mini-card">
                                    <div class="sponsor-mini-avatar"><?php echo substr($sponsor->name, 0, 1); ?></div>
                                    <div class="flex-grow-1">
                                        <div class="fw-bold small"><?php echo $sponsor->name; ?></div>
                                    </div>
                                    <a href="<?php echo URLROOT; ?>/student/send_message/<?php echo $sponsor->id; ?>" class="btn-reply">
                                        <i class="fa-solid fa-paper-plane small"></i> Message
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <p class="text-muted small">No sponsors assigned yet.</p>
                        <?php endif; ?>
                    </div>

                    <div class="text-start info-section">
                        <span class="info-label">About Me</span>
                        <p class="student-about-text" id="about-text"><?php echo $data['student']->about; ?></p>
                        <?php if(strlen($data['student']->about) > 150) : ?>
                            <button type="button" class="btn-toggle-about" onclick="toggleStudentAbout()" id="btn-toggle">Read More</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
        function toggleStudentAbout() {
            const textEl = document.getElementById('about-text');
            const btnEl = document.getElementById('btn-toggle');
            
            if (textEl.classList.contains('expanded')) {
                textEl.classList.remove('expanded');
                btnEl.innerText = 'Read More';
            } else {
                textEl.classList.add('expanded');
                btnEl.innerText = 'Show Less';
            }
        }
        </script>

        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4 animate-up">
                <h4 class="fw-bold m-0">Recent Messages</h4>
            </div>

            <?php flash('student_message'); ?>

            <div class="animate-up delay-1">
                <?php if(empty($data['messages'])) : ?>
                    <div class="bg-white p-5 rounded-4 text-center shadow-sm border border-dashed">
                        <i class="fa-regular fa-comments fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No messages yet. Start a conversation with your sponsors!</p>
                    </div>
                <?php else : ?>
                    <div id="student-msg-container">
                        <?php foreach($data['messages'] as $index => $message) : ?>
                            <div class="message-bubble <?php echo $message->sender_type == 'sponsor' ? 'from-sponsor' : 'to-sponsor'; ?> <?php echo $index >= 5 ? 'd-none hidden-student-msg' : ''; ?>">
                                <div class="msg-header">
                                    <div>
                                        <span class="fw-bold text-dark"><?php echo $message->sender_name; ?></span>
                                        <small class="text-muted ms-2">&bull; <?php echo date('M d, Y', strtotime($message->created_at)); ?></small>
                                    </div>
                                    <?php if($message->sender_type == 'sponsor') : ?>
                                        <a href="<?php echo URLROOT; ?>/student/reply/<?php echo $message->sender_id; ?>" class="btn-reply">Reply</a>
                                    <?php endif; ?>
                                </div>
                                <p class="m-0 text-muted small" style="line-height: 1.7;">
                                    <?php echo nl2br($message->content); ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <?php if(count($data['messages']) > 5) : ?>
                        <div class="text-center pb-4">
                            <button id="btn-student-view-more" class="btn btn-link btn-sm text-primary fw-bold text-decoration-none">
                                <i class="fa-solid fa-chevron-down me-1"></i> View More History
                            </button>
                        </div>
                        <script>
                            document.getElementById('btn-student-view-more').addEventListener('click', function() {
                                const hiddenMsgs = document.querySelectorAll('.hidden-student-msg');
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
