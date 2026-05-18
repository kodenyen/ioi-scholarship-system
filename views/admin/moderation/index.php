<?php require APPROOT . '/views/layouts/header.php'; ?>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    body { background-color: #f0f2f5; font-family: 'Plus Jakarta Sans', sans-serif; }
    .page-title { font-weight: 800; font-size: 2.2rem; color: #001219; letter-spacing: -1px; margin-bottom: 0.5rem; }
    .message-card { background: white; border: none; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); overflow: hidden; margin-bottom: 2rem; transition: transform 0.3s ease; }
    .message-card:hover { transform: translateY(-3px); }
    .message-header { padding: 1.5rem; border-bottom: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center; }
    .sender-info { display: flex; align-items: center; gap: 12px; }
    .sender-avatar { width: 45px; height: 45px; border-radius: 12px; background: #e7f5ff; color: #005BFF; display: flex; align-items: center; justify-content: center; font-weight: 700; }
    .status-badge { padding: 6px 12px; border-radius: 8px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; }
    .message-body { padding: 2rem; }
    .message-content { background: #f8f9fa; padding: 1.5rem; border-radius: 15px; color: #444; line-height: 1.7; position: relative; }
    .message-content::before { content: '"'; position: absolute; top: -10px; left: 10px; font-family: serif; font-size: 4rem; color: #dee2e6; opacity: 0.5; }
    .details-list { margin-top: 1.5rem; border-top: 1px solid #eee; padding-top: 1.5rem; }
    .detail-item { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px dashed #eee; font-size: 0.9rem; }
    .btn-approve { background: #005BFF; color: white; border: none; border-radius: 12px; padding: 0.8rem 2rem; font-weight: 600; transition: all 0.3s; }
    .btn-approve:hover { background: #0046cc; transform: scale(1.02); }
    .btn-reject { background: #fff1f0; color: #d00000; border: none; border-radius: 12px; padding: 0.8rem 2rem; font-weight: 600; transition: all 0.3s; }
    .btn-reject:hover { background: #ffd8d6; }
</style>

<div class="container py-4">
    <div class="mb-5 animate-up">
        <h1 class="page-title">Message Moderation</h1>
        <p class="text-muted">Review and approve communication before it reaches its destination.</p>
        <?php flash('moderation_message'); ?>
    </div>

    <div class="row">
        <?php if(empty($data['messages'])) : ?>
            <div class="col-12 text-center py-5">
                <div class="bg-white p-5 rounded-4 shadow-sm">
                    <i class="fa-solid fa-check-circle text-success fa-4x mb-4"></i>
                    <h3>All caught up!</h3>
                    <p class="text-muted">There are no pending messages to moderate at this time.</p>
                    <a href="<?php echo URLROOT; ?>/admin/dashboard" class="btn btn-outline-primary mt-3 px-4">Back to Dashboard</a>
                </div>
            </div>
        <?php endif; ?>

        <?php foreach($data['messages'] as $message) : ?>
            <div class="col-12 animate-up">
                <div class="message-card">
                    <div class="message-header">
                        <div class="sender-info">
                            <div class="sender-avatar">
                                <?php echo substr($message->sender_name, 0, 1); ?>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold"><?php echo $message->sender_name; ?></h6>
                                <small class="text-muted"><?php echo ucfirst($message->sender_type); ?> &rarr; <?php echo $message->receiver_name; ?></small>
                            </div>
                        </div>
                        <span class="text-muted small"><i class="fa-regular fa-clock me-1"></i> <?php echo date('M d, Y h:i A', strtotime($message->created_at)); ?></span>
                    </div>
                    <div class="message-body">
                        <div class="message-content">
                            <?php echo nl2br($message->content); ?>
                        </div>
                        
                        <?php if(!empty($message->responses)) : ?>
                            <div class="details-list">
                                <h6 class="fw-bold mb-3 small text-uppercase letter-spacing-1">Custom Form Data</h6>
                                <?php foreach($message->responses as $resp) : ?>
                                    <div class="detail-item">
                                        <span class="text-muted"><?php echo $resp->label; ?></span>
                                        <span class="fw-600"><?php echo $resp->value; ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <div class="d-flex justify-content-end gap-3 mt-4 pt-3 border-top">
                            <a href="<?php echo URLROOT; ?>/admin/reject/<?php echo $message->id; ?>" class="btn-reject" onclick="return confirm('Are you sure you want to reject this message?')">
                                <i class="fa-solid fa-xmark me-2"></i> Reject
                            </a>
                            <a href="<?php echo URLROOT; ?>/admin/approve/<?php echo $message->id; ?>" class="btn-approve">
                                <i class="fa-solid fa-check me-2"></i> Approve & Send
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require APPROOT . '/views/layouts/footer.php'; ?>
