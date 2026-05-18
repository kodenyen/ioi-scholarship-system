<?php require APPROOT . '/views/layouts/header.php'; ?>
<style>
    .step-container { display: none; }
    .step-container.active { display: block; animation: fadeIn 0.5s; }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .step-indicator {
        display: flex;
        justify-content: space-between;
        margin-bottom: 30px;
        position: relative;
    }
    .step-indicator::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 2px;
        background: #e9ecef;
        z-index: 1;
        transform: translateY(-50%);
    }
    .step {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: white;
        border: 2px solid #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2;
        font-weight: bold;
        transition: all 0.3s;
        color: #adb5bd;
    }
    .step.active {
        border-color: #005BFF;
        color: #005BFF;
        box-shadow: 0 0 0 5px rgba(0, 91, 255, 0.1);
    }
    .step.completed {
        background: #005BFF;
        border-color: #005BFF;
        color: white;
    }
    .form-card {
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        border-radius: 15px;
    }
    .form-label {
        font-weight: 600;
        color: #495057;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .form-control {
        padding: 12px 15px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }
    .form-control:focus {
        box-shadow: 0 0 0 4px rgba(0, 91, 255, 0.1);
        border-color: #005BFF;
    }
</style>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="d-flex justify-content-between align-items-center mt-5 mb-4">
            <div>
                <h2 class="fw-bold mb-0">Add New Beneficiary</h2>
                <p class="text-muted">Fill in the details to create a comprehensive student profile</p>
            </div>
            <a href="<?php echo URLROOT; ?>/admin/students" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="fa fa-times"></i> Cancel
            </a>
        </div>

        <div class="step-indicator">
            <div class="step active" id="ind-1">1</div>
            <div class="step" id="ind-2">2</div>
            <div class="step" id="ind-3">3</div>
            <div class="step" id="ind-4">4</div>
        </div>

        <div class="card form-card card-body p-5 mb-5">
            <form id="multiStepForm" action="<?php echo URLROOT; ?>/admin/add_student" method="post" enctype="multipart/form-data">
                
                <!-- STEP 1: BASIC INFO -->
                <div class="step-container active" id="step-1">
                    <h4 class="mb-4 text-primary fw-bold">Step 1: Basic Information</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">First Name <sup>*</sup></label>
                            <input type="text" name="first_name" class="form-control" required placeholder="Enter first name">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Surname <sup>*</sup></label>
                            <input type="text" name="surname" class="form-control" required placeholder="Enter surname">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Age</label>
                            <input type="number" name="age" class="form-control" placeholder="Years">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Class</label>
                            <input type="text" name="class" class="form-control" placeholder="Current Level">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Email Address <sup>*</sup></label>
                            <input type="email" name="email" class="form-control" required placeholder="student@example.com">
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" class="btn btn-primary px-5 rounded-pill" onclick="nextStep(1)">Next Step <i class="fa fa-arrow-right ms-2"></i></button>
                    </div>
                </div>

                <!-- STEP 2: SECURITY & MEDIA -->
                <div class="step-container" id="step-2">
                    <h4 class="mb-4 text-primary fw-bold">Step 2: Security & Profile Photo</h4>
                    <div class="mb-4">
                        <label class="form-label">Account Password <sup>*</sup></label>
                        <input type="password" name="password" class="form-control" required placeholder="Create a secure password">
                        <small class="text-muted">Student will use this email and password for traditional login.</small>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Main Profile Photo</label>
                        <input type="file" name="profile_photo" class="form-control" accept="image/*">
                        <small class="text-muted">This will be the cover of their interactive portfolio.</small>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-light px-5 rounded-pill" onclick="prevStep(2)"><i class="fa fa-arrow-left me-2"></i> Back</button>
                        <button type="button" class="btn btn-primary px-5 rounded-pill" onclick="nextStep(2)">Next Step <i class="fa fa-arrow-right ms-2"></i></button>
                    </div>
                </div>

                <!-- STEP 3: STORY & GOALS -->
                <div class="step-container" id="step-3">
                    <h4 class="mb-4 text-primary fw-bold">Step 3: My Story & Goals</h4>
                    <div class="mb-4">
                        <label class="form-label">My Story (About Section)</label>
                        <textarea name="about" class="form-control" rows="5" placeholder="Tell the student's story..."></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Educational Goals</label>
                        <textarea name="educational_goals" class="form-control" rows="4" placeholder="What does this student hope to achieve academically?"></textarea>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-light px-5 rounded-pill" onclick="prevStep(3)"><i class="fa fa-arrow-left me-2"></i> Back</button>
                        <button type="button" class="btn btn-primary px-5 rounded-pill" onclick="nextStep(3)">Next Step <i class="fa fa-arrow-right ms-2"></i></button>
                    </div>
                </div>

                <!-- STEP 4: FAITH & NEEDS -->
                <div class="step-container" id="step-4">
                    <h4 class="mb-4 text-primary fw-bold">Step 4: Personal Faith & Needs</h4>
                    <div class="mb-4">
                        <label class="form-label">Best Memory Verse</label>
                        <textarea name="memory_verse" class="form-control" rows="2" placeholder="e.g., Philippians 4:13"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Prayer Needs</label>
                        <textarea name="prayer_needs" class="form-control" rows="4" placeholder="Specific prayer requests for this student..."></textarea>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-light px-5 rounded-pill" onclick="prevStep(4)"><i class="fa fa-arrow-left me-2"></i> Back</button>
                        <button type="submit" class="btn btn-success px-5 rounded-pill">Complete Registration <i class="fa fa-check-circle ms-2"></i></button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    function nextStep(current) {
        // Basic validation for current step
        const step = document.getElementById('step-' + current);
        const inputs = step.querySelectorAll('input[required]');
        let valid = true;
        inputs.forEach(input => {
            if(!input.value) {
                input.classList.add('is-invalid');
                valid = false;
            } else {
                input.classList.remove('is-invalid');
            }
        });

        if(!valid) return;

        // Transition steps
        document.getElementById('step-' + current).classList.remove('active');
        document.getElementById('step-' + (current + 1)).classList.add('active');
        
        // Update indicators
        document.getElementById('ind-' + current).classList.add('completed');
        document.getElementById('ind-' + current).classList.remove('active');
        document.getElementById('ind-' + (current + 1)).classList.add('active');
        
        window.scrollTo(0, 0);
    }

    function prevStep(current) {
        document.getElementById('step-' + current).classList.remove('active');
        document.getElementById('step-' + (current - 1)).classList.add('active');
        
        // Update indicators
        document.getElementById('ind-' + current).classList.remove('active');
        document.getElementById('ind-' + (current - 1)).classList.remove('completed');
        document.getElementById('ind-' + (current - 1)).classList.add('active');
        
        window.scrollTo(0, 0);
    }
</script>

<?php require APPROOT . '/views/layouts/footer.php'; ?>
