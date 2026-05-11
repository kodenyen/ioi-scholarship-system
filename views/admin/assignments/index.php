<?php require APPROOT . '/views/layouts/header.php'; ?>
<div class="row">
    <div class="col-md-5">
        <div class="card card-body bg-light">
            <h2>New Assignment</h2>
            <p>Assign a student to a sponsor</p>
            <form action="<?php echo URLROOT; ?>/admin/assignments" method="post">
                <div class="mb-3">
                    <label for="sponsor_id" class="form-label">Select Sponsor:</label>
                    <select name="sponsor_id" class="form-select">
                        <?php foreach($data['sponsors'] as $sponsor) : ?>
                            <option value="<?php echo $sponsor->id; ?>"><?php echo $sponsor->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="student_id" class="form-label">Select Student:</label>
                    <select name="student_id" class="form-select">
                        <?php foreach($data['students'] as $student) : ?>
                            <option value="<?php echo $student->id; ?>"><?php echo $student->first_name . ' ' . $student->surname; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="d-grid">
                    <input type="submit" class="btn btn-primary" value="Assign Student">
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-7 mt-4 mt-md-0">
        <h3>Current Assignments</h3>
        <?php flash('assignment_message'); ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover mt-3">
                <thead>
                    <tr>
                        <th>Sponsor</th>
                        <th>Student</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data['assignments'] as $assignment) : ?>
                        <tr>
                            <td><?php echo $assignment->sponsor_name; ?></td>
                            <td><?php echo $assignment->first_name . ' ' . $assignment->surname; ?></td>
                            <td>
                                <a href="<?php echo URLROOT; ?>/admin/unassign/<?php echo $assignment->sponsor_id; ?>/<?php echo $assignment->student_id; ?>" class="btn btn-danger btn-sm">Unassign</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/layouts/footer.php'; ?>
