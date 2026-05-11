<?php require APPROOT . '/views/layouts/header.php'; ?>
<h1>Message Moderation</h1>
<p class="lead">Approve or reject messages before they are delivered.</p>
<?php flash('moderation_message'); ?>

<div class="row mt-4">
    <?php if(empty($data['messages'])) : ?>
        <div class="col-md-12">
            <div class="alert alert-info">No pending messages to moderate.</div>
        </div>
    <?php endif; ?>

    <?php foreach($data['messages'] as $message) : ?>
        <div class="col-md-12 mb-4">
            <div class="card shadow-sm border-primary">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <span>From: <strong><?php echo $message->sender_name; ?></strong> (<?php echo ucfirst($message->sender_type); ?>)</span>
                    <span class="badge bg-light text-primary"><?php echo $message->created_at; ?></span>
                </div>
                <div class="card-body">
                    <p class="mb-2">To: <strong><?php echo $message->receiver_name; ?></strong></p>
                    <div class="p-3 bg-light rounded mb-3">
                        <?php echo nl2br($message->content); ?>
                    </div>
                    
                    <?php if(!empty($message->responses)) : ?>
                        <h6>Additional Details:</h6>
                        <ul class="list-group list-group-flush mb-3">
                            <?php foreach($message->responses as $resp) : ?>
                                <li class="list-group-item bg-transparent">
                                    <strong><?php echo $resp->label; ?>:</strong> <?php echo $resp->value; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <div class="d-flex gap-2 sticky-md-bottom bg-white p-2 border-top">
                        <a href="<?php echo URLROOT; ?>/admin/approve/<?php echo $message->id; ?>" class="btn btn-success flex-grow-1">Approve & Deliver</a>
                        <a href="<?php echo URLROOT; ?>/admin/reject/<?php echo $message->id; ?>" class="btn btn-danger flex-grow-1">Reject Message</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php require APPROOT . '/views/layouts/footer.php'; ?>
