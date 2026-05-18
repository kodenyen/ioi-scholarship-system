<?php require APPROOT . '/views/layouts/header.php'; ?>
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex align-items-center">
                <?php if(!empty($data['sponsor']->profile_photo)) : ?>
                    <img src="<?php echo URLROOT . '/' . $data['sponsor']->profile_photo; ?>" alt="Sponsor Photo" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover; border: 2px solid white;">
                <?php endif; ?>
                <h4 class="mb-0">Message to <?php echo $data['sponsor']->name; ?></h4>
            </div>
            <div class="card-body">
                <form action="<?php echo URLROOT; ?>/student/send_message/<?php echo $data['sponsor']->id; ?>" method="post">
                    <div class="mb-3">
                        <label for="content" class="form-label">Your Message: <sup>*</sup></label>
                        <textarea name="content" class="form-control" rows="5" required placeholder="Write your message to your sponsor..."></textarea>
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
                        <button type="submit" class="btn btn-primary btn-lg">Send Message</button>
                        <a href="<?php echo URLROOT; ?>/student/dashboard" class="btn btn-light">Cancel</a>
                    </div>
                </form>
                <div class="mt-3">
                    <small class="text-muted"><i class="fa fa-info-circle"></i> Note: All messages are reviewed by the IOI Scholarship Admin before being sent to your sponsor.</small>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/layouts/footer.php'; ?>
