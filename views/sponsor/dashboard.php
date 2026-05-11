<?php require APPROOT . '/views/layouts/header.php'; ?>
<div class="row">
    <div class="col-md-12 mb-4">
        <h1>Welcome, <?php echo $data['sponsor']->name; ?></h1>
        <p class="lead">Your Assigned Students</p>
    </div>
</div>

<?php flash('sponsor_message'); ?>

<div class="row">
    <div class="col-md-8">
        <h3>Students</h3>
        <div class="row">
            <?php foreach($data['students'] as $student) : ?>
                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $student->first_name . ' ' . $student->surname; ?></h5>
                            <p class="card-text small"><?php echo $student->class; ?></p>
                            <a href="<?php echo URLROOT; ?>/sponsor/send_message/<?php echo $student->id; ?>?token=<?php echo $_GET['token']; ?>" class="btn btn-primary w-100">Send Message</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="col-md-4 mt-4 mt-md-0">
        <h3>Message History</h3>
        <div class="list-group">
            <?php if(empty($data['messages'])) : ?>
                <p class="text-muted">No approved messages yet.</p>
            <?php endif; ?>
            <?php foreach($data['messages'] as $message) : ?>
                <div class="list-group-item">
                    <div class="d-flex w-100 justify-content-between">
                        <h6 class="mb-1">From: <?php echo $message->sender_name; ?></h6>
                        <small><?php echo date('M d', strtotime($message->created_at)); ?></small>
                    </div>
                    <p class="mb-1 small"><?php echo $message->content; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/layouts/footer.php'; ?>
