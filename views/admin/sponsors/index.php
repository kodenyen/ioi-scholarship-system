<?php require APPROOT . '/views/layouts/header.php'; ?>
<div class="row mb-3">
    <div class="col-md-6">
        <h1>Sponsors</h1>
    </div>
    <div class="col-md-6 text-end">
        <a href="<?php echo URLROOT; ?>/admin/add_sponsor" class="btn btn-primary">
            <i class="fa fa-plus"></i> Add Sponsor
        </a>
    </div>
</div>
<?php flash('sponsor_message'); ?>
<div class="row">
    <?php foreach($data['sponsors'] as $sponsor) : ?>
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $sponsor->name; ?></h5>
                    <p class="card-text text-muted small"><?php echo $sponsor->email; ?></p>
                    <div class="mb-2">
                        <label class="form-label small fw-bold">Access Link:</label>
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" value="<?php echo URLROOT; ?>/sponsor/dashboard?token=<?php echo $sponsor->access_token; ?>" readonly id="token-<?php echo $sponsor->id; ?>">
                            <button class="btn btn-outline-secondary" type="button" onclick="copyToken(<?php echo $sponsor->id; ?>)">Copy</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script>
function copyToken(id) {
    var copyText = document.getElementById("token-" + id);
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(copyText.value);
    alert("Link copied to clipboard");
}
</script>
<?php require APPROOT . '/views/layouts/footer.php'; ?>
