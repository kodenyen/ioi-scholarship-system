<?php require APPROOT . '/views/layouts/header.php'; ?>
<div class="row">
    <div class="col-md-5">
        <div class="card card-body bg-light">
            <h2>Form Builder</h2>
            <p>Add custom fields for message forms</p>
            <form action="<?php echo URLROOT; ?>/admin/forms" method="post">
                <div class="mb-3">
                    <label for="label" class="form-label">Field Label: <sup>*</sup></label>
                    <input type="text" name="label" class="form-control <?php echo (!empty($data['label_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['label']; ?>">
                    <span class="invalid-feedback"><?php echo $data['label_err']; ?></span>
                </div>
                <div class="mb-3">
                    <label for="type" class="form-label">Field Type:</label>
                    <select name="type" class="form-select">
                        <option value="text">Text Input</option>
                        <option value="textarea">Text Area</option>
                        <option value="dropdown">Dropdown</option>
                        <option value="file">File Upload</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="assigned_to" class="form-label">Assigned To:</label>
                    <select name="assigned_to" class="form-select">
                        <option value="sponsor">Sponsor Form</option>
                        <option value="student">Student Form</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="options" class="form-label">Options (for Dropdown, comma separated):</label>
                    <input type="text" name="options" class="form-control" value="<?php echo $data['options']; ?>">
                </div>
                <div class="d-grid">
                    <input type="submit" class="btn btn-primary" value="Add Field">
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-7 mt-4 mt-md-0">
        <h3>Existing Fields</h3>
        <?php flash('form_message'); ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover mt-3">
                <thead>
                    <tr>
                        <th>Label</th>
                        <th>Type</th>
                        <th>Target</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data['fields'] as $field) : ?>
                        <tr>
                            <td><?php echo $field->label; ?></td>
                            <td><?php echo ucfirst($field->type); ?></td>
                            <td><?php echo ucfirst($field->assigned_to); ?></td>
                            <td>
                                <form action="<?php echo URLROOT; ?>/admin/delete_field/<?php echo $field->id; ?>" method="post">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/layouts/footer.php'; ?>
