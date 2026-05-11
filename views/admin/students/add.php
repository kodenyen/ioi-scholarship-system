<?php require APPROOT . '/views/layouts/header.php'; ?>
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card card-body bg-light mt-5">
            <h2>Add Student</h2>
            <p>Create a new student profile</p>
            <form action="<?php echo URLROOT; ?>/admin/add_student" method="post">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="first_name" class="form-label">First Name: <sup>*</sup></label>
                        <input type="text" name="first_name" class="form-control <?php echo (!empty($data['first_name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['first_name']; ?>">
                        <span class="invalid-feedback"><?php echo $data['first_name_err']; ?></span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="surname" class="form-label">Surname: <sup>*</sup></label>
                        <input type="text" name="surname" class="form-control <?php echo (!empty($data['surname_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['surname']; ?>">
                        <span class="invalid-feedback"><?php echo $data['surname_err']; ?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="age" class="form-label">Age:</label>
                        <input type="number" name="age" class="form-control" value="<?php echo $data['age']; ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="class" class="form-label">Class:</label>
                        <input type="text" name="class" class="form-control" value="<?php echo $data['class']; ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" name="email" class="form-control" value="<?php echo $data['email']; ?>">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="about" class="form-label">About Section:</label>
                    <textarea name="about" class="form-control" rows="4"><?php echo $data['about']; ?></textarea>
                </div>
                <div class="d-grid gap-2">
                    <input type="submit" class="btn btn-primary" value="Create Student Profile">
                    <a href="<?php echo URLROOT; ?>/admin/students" class="btn btn-light">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/layouts/footer.php'; ?>
