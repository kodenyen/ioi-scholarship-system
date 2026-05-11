<?php require APPROOT . '/views/layouts/header.php'; ?>
<div class="row">
    <div class="col-md-4">
        <!-- Profile Card -->
        <div class="card shadow-sm mb-4">
            <div class="student-banner" style="background-image: linear-gradient(135deg, #005BFF 0%, #4FA242 100%);"></div>
            <div class="card-body text-center pt-0">
                <div class="bg-primary text-white student-profile-photo d-flex align-items-center justify-content-center mx-auto" style="font-size: 2rem; font-weight: bold;">
                    <?php echo substr($data['student']->first_name, 0, 1) . substr($data['student']->surname, 0, 1); ?>
                </div>
                <h5 class="mt-2"><?php echo $data['student']->first_name . ' ' . $data['student']->surname; ?></h5>
                <p class="small text-muted mb-2"><?php echo $data['student']->class; ?></p>
                <div class="d-flex justify-content-center gap-2 mb-3">
                    <span class="badge bg-light text-primary border"><?php echo $data['student']->age; ?> Years</span>
                    <span class="badge bg-light text-success border">Active Student</span>
                </div>
            </div>
            <div class="card-body border-top">
                <h6>About Me</h6>
                <p class="small text-muted"><?php echo $data['student']->about; ?></p>
                <hr>
                <h6>Contact Info</h6>
                <p class="small text-muted mb-0"><?php echo $data['student']->email; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <h3>My Messages</h3>
        <?php flash('student_message'); ?>
        <div class="list-group">
            <?php if(empty($data['messages'])) : ?>
                <div class="alert alert-light border shadow-sm">No approved messages yet. All communication is moderated by admin.</div>
            <?php endif; ?>
            
            <?php foreach($data['messages'] as $message) : ?>
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <h6 class="text-primary mb-0">From: <?php echo $message->sender_name; ?></h6>
                            <small class="text-muted"><?php echo date('M d, Y', strtotime($message->created_at)); ?></small>
                        </div>
                        <p class="mb-3"><?php echo nl2br($message->content); ?></p>
                        
                        <?php if($message->sender_type == 'sponsor') : ?>
                            <div class="d-grid d-md-flex justify-content-md-end">
                                <a href="<?php echo URLROOT; ?>/student/reply/<?php echo $message->sender_id; ?>" class="btn btn-outline-primary btn-sm">Reply</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/layouts/footer.php'; ?>
