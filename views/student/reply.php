<?php require APPROOT . '/views/layouts/header.php'; ?>
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4>Reply to Sponsor: <?php echo $data['sponsor']->name; ?></h4>
            </div>
            <div class="card-body">
                <form action="<?php echo URLROOT; ?>/student/reply/<?php echo $data['sponsor']->id; ?>" method="post">
                    <div class="mb-3">
                        <label for="content" class="form-label">Your Reply:</label>
                        <textarea name="content" class="form-control" rows="5" required placeholder="Write your reply here..."></textarea>
                        <small class="form-text text-muted">Your reply will be moderated by admin before delivery.</small>
                    </div>

                    <?php foreach($data['fields'] as $field) : ?>
                        <div class="mb-3">
                            <label class="form-label"><?php echo $field->label; ?>:</label>
                            <?php if($field->type == 'text') : ?>
                                <input type="text" name="field_<?php echo $field->id; ?>" class="form-control">
                            <?php elseif($field->type == 'textarea') : ?>
                                <textarea name="field_<?php echo $field->id; ?>" class="form-control" rows="3"></textarea>
                            <?php elseif($field->type == 'dropdown') : ?>
                                <select name="field_<?php echo $field->id; ?>" class="form-select">
                                    <?php 
                                        $options = explode(',', $field->options);
                                        foreach($options as $option) :
                                    ?>
                                        <option value="<?php echo trim($option); ?>"><?php echo trim($option); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">Submit for Approval</button>
                        <a href="<?php echo URLROOT; ?>/student/dashboard" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/layouts/footer.php'; ?>
