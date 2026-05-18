<?php require APPROOT . '/views/layouts/header.php'; ?>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    body { background-color: #f0f2f5; font-family: 'Plus Jakarta Sans', sans-serif; }
    .page-title { font-weight: 800; font-size: 2.2rem; color: #001219; letter-spacing: -1px; }
    .card-modern { background: white; border: none; border-radius: 24px; box-shadow: 0 8px 30px rgba(0,0,0,0.05); overflow: hidden; }
    .card-header-modern { background: #001219; color: white; padding: 1.5rem 2rem; border: none; }
    .form-label { font-weight: 600; font-size: 0.85rem; color: #444; text-transform: uppercase; letter-spacing: 0.5px; }
    .form-control, .form-select { border-radius: 12px; padding: 0.75rem 1rem; border: 1px solid #e0e0e0; background-color: #f8f9fa; transition: all 0.3s; }
    .form-control:focus { background-color: white; border-color: #005BFF; box-shadow: 0 0 0 4px rgba(0,91,255,0.1); }
    .btn-add { background: #005BFF; color: white; border: none; border-radius: 12px; padding: 0.8rem; font-weight: 600; width: 100%; transition: all 0.3s; }
    .btn-add:hover { background: #4FA242 !important; border-color: #4FA242 !important; transform: translateY(-2px); }
    .table-container { background: white; border-radius: 24px; padding: 1.5rem; box-shadow: 0 8px 30px rgba(0,0,0,0.05); }
    .table thead th { background: transparent; border-bottom: 2px solid #f0f0f0; color: #888; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; padding: 1.2rem; }
    .table tbody td { padding: 1.2rem; vertical-align: middle; border-bottom: 1px solid #f8f9fa; color: #444; font-weight: 500; }
    .badge-target { padding: 6px 12px; border-radius: 8px; font-weight: 600; font-size: 0.7rem; }
    .badge-sponsor { background: #e7f5ff; color: #005BFF; }
    .badge-student { background: #ebfbee; color: #2b8a3e; }
    .btn-delete { width: 35px; height: 35px; border-radius: 10px; background: #fff1f0; color: #d00000; border: none; display: flex; align-items: center; justify-content: center; transition: all 0.3s; }
    .btn-delete:hover { background: #d00000; color: white; }
</style>

<div class="container py-4">
    <div class="mb-5 animate-up">
        <h1 class="page-title">Form Builder</h1>
        <p class="text-muted">Customize message forms with dynamic fields.</p>
    </div>

    <?php flash('form_message'); ?>

    <div class="row g-4">
        <div class="col-lg-4 animate-up delay-1">
            <div class="card-modern">
                <div class="card-header-modern">
                    <h5 class="mb-0"><i class="fa-solid fa-plus-circle me-2"></i> New Field</h5>
                </div>
                <div class="card-body p-4">
                    <form action="<?php echo URLROOT; ?>/admin/forms" method="post">
                        <div class="mb-4">
                            <label class="form-label">Field Label</label>
                            <input type="text" name="label" class="form-control <?php echo (!empty($data['label_err'])) ? 'is-invalid' : ''; ?>" placeholder="e.g. Prayer Request" value="<?php echo $data['label']; ?>">
                            <span class="invalid-feedback"><?php echo $data['label_err']; ?></span>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Field Type</label>
                            <select name="type" class="form-select">
                                <option value="text">Short Text</option>
                                <option value="textarea">Long Text / Paragraph</option>
                                <option value="dropdown">Dropdown Selection</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Target Form</label>
                            <select name="assigned_to" class="form-select">
                                <option value="sponsor">Sponsor Form</option>
                                <option value="student">Student Form</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Dropdown Options</label>
                            <input type="text" name="options" class="form-control" placeholder="Option 1, Option 2, Option 3" value="<?php echo $data['options']; ?>">
                            <small class="text-muted mt-2 d-block">Only required for 'Dropdown' type.</small>
                        </div>

                        <button type="submit" class="btn-add">
                            <i class="fa-solid fa-save me-2"></i> Save Field
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8 animate-up delay-2">
            <div class="table-container">
                <h5 class="fw-bold mb-4 px-3">Active Fields</h5>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Field Detail</th>
                                <th>Type</th>
                                <th>Assigned To</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data['fields'] as $field) : ?>
                                <tr>
                                    <td>
                                        <div class="fw-bold"><?php echo $field->label; ?></div>
                                        <?php if(!empty($field->options)) : ?>
                                            <small class="text-muted">Options: <?php echo $field->options; ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="text-muted small fw-bold text-uppercase"><?php echo $field->type; ?></span>
                                    </td>
                                    <td>
                                        <span class="badge-target <?php echo $field->assigned_to == 'sponsor' ? 'badge-sponsor' : 'badge-student'; ?>">
                                            <?php echo ucfirst($field->assigned_to); ?>
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <form action="<?php echo URLROOT; ?>/admin/delete_field/<?php echo $field->id; ?>" method="post" onsubmit="return confirm('Delete this field?')">
                                            <button type="submit" class="btn-delete ms-auto">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/layouts/footer.php'; ?>
