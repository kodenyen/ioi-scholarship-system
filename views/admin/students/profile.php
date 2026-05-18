<?php require APPROOT . '/views/layouts/header.php'; ?>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    body { background-color: #f0f2f5; font-family: 'Plus Jakarta Sans', sans-serif; }
    .profile-header-card { background: white; border: none; border-radius: 24px; box-shadow: 0 8px 30px rgba(0,0,0,0.05); overflow: hidden; margin-bottom: 2rem; }
    .profile-banner-admin { height: 140px; background: linear-gradient(135deg, #001219 0%, #005BFF 100%); position: relative; }
    .profile-avatar-admin { width: 140px; height: 140px; border-radius: 35px; background: white; padding: 6px; position: absolute; bottom: -70px; left: 40px; box-shadow: 0 12px 25px rgba(0,0,0,0.1); }
    .profile-avatar-img { width: 100%; height: 100%; border-radius: 28px; object-fit: cover; }
    .profile-avatar-placeholder { width: 100%; height: 100%; border-radius: 28px; background: #f8f9fa; color: #005BFF; display: flex; align-items: center; justify-content: center; font-size: 3rem; font-weight: 800; }
    
    .header-content-admin { padding: 80px 40px 30px; display: flex; justify-content: space-between; align-items: flex-end; }
    .student-main-title { font-weight: 800; font-size: 2.2rem; color: #001219; letter-spacing: -1px; margin-bottom: 0.2rem; }
    .student-sub-meta { font-size: 0.9rem; color: #6c757d; font-weight: 500; display: flex; align-items: center; gap: 15px; }
    
    .nav-tabs-modern { border-bottom: 1px solid #eee; gap: 20px; margin-bottom: 2rem; }
    .nav-tabs-modern .nav-link { 
        border: none; 
        border-radius: 0;
        padding: 12px 0; 
        font-weight: 700; 
        color: #6c757d; 
        transition: all 0.3s ease; 
        position: relative;
        background: transparent !important;
    }
    .nav-tabs-modern .nav-link:hover { color: #2b9348; }
    .nav-tabs-modern .nav-link.active { 
        color: #2b9348; 
    }
    .nav-tabs-modern .nav-link::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 3px;
        background: #2b9348;
        transition: width 0.3s ease;
        border-radius: 2px;
    }
    .nav-tabs-modern .nav-link.active::after {
        width: 100%;
    }

    .content-card-admin { background: white; border: none; border-radius: 24px; box-shadow: 0 8px 30px rgba(0,0,0,0.05); padding: 2rem; min-height: 400px; }
    
    .stat-mini { background: #f8f9fa; padding: 15px; border-radius: 16px; border: 1px solid #eee; height: 100%; }
    .stat-mini-label { font-size: 0.65rem; font-weight: 800; color: #888; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px; display: block; }
    .stat-mini-value { font-weight: 700; color: #001219; }

    /* Gallery Styling */
    .admin-gallery-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; }
    .gallery-card-admin { position: relative; border-radius: 18px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); aspect-ratio: 1/1; }
    .gallery-img-admin { width: 100%; height: 100%; object-fit: cover; }
    .gallery-overlay-admin { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, transparent 40%); padding: 15px; display: flex; flex-direction: column; justify-content: space-between; opacity: 0; transition: opacity 0.3s; }
    .gallery-card-admin:hover .gallery-overlay-admin { opacity: 1; }
    .delete-btn-overlay { width: 32px; height: 32px; border-radius: 8px; background: rgba(208,0,0,0.9); color: white; border: none; display: flex; align-items: center; justify-content: center; align-self: flex-end; }

    /* Results Table */
    .results-table thead th { border: none; background: #f8f9fa; color: #888; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; padding: 15px; }
    .results-table tbody td { padding: 15px; vertical-align: middle; }
    
    .btn-action-admin { border-radius: 10px; font-weight: 600; padding: 8px 16px; font-size: 0.85rem; transition: all 0.2s; border: none; display: flex; align-items: center; gap: 8px; }
    .btn-upload { background: #005BFF; color: white; }
    .btn-upload:hover { background: #0046cc; transform: scale(1.02); }
</style>

<div class="container py-4">
    <!-- Header Section -->
    <div class="profile-header-card animate-up">
        <div class="profile-banner-admin">
            <div class="profile-avatar-admin">
                <?php if(!empty($data['student']->profile_photo)) : ?>
                    <img src="<?php echo URLROOT . '/' . $data['student']->profile_photo; ?>" alt="Student" class="profile-avatar-img">
                <?php else : ?>
                    <div class="profile-avatar-placeholder">
                        <?php echo substr($data['student']->first_name, 0, 1); ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="p-4 text-end">
                <a href="<?php echo URLROOT; ?>/admin/preview_portfolio/<?php echo $data['student']->id; ?>" class="btn btn-light btn-sm fw-bold px-3 py-2 rounded-pill shadow-sm" target="_blank">
                    <i class="fa-solid fa-eye me-1"></i> Preview Portfolio
                </a>
            </div>
        </div>
        <div class="header-content-admin">
            <div>
                <h1 class="student-main-title"><?php echo $data['student']->first_name . ' ' . $data['student']->surname; ?></h1>
                <div class="student-sub-meta">
                    <span><i class="fa-solid fa-graduation-cap me-1 text-primary"></i> <?php echo $data['student']->class; ?></span>
                    <span><i class="fa-solid fa-calendar me-1 text-primary"></i> <?php echo $data['student']->age; ?> Years Old</span>
                    <span><i class="fa-solid fa-id-badge me-1 text-primary"></i> SCH-<?php echo str_pad($data['student']->id, 4, '0', STR_PAD_LEFT); ?></span>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="<?php echo URLROOT; ?>/admin/edit_student/<?php echo $data['student']->id; ?>" class="btn btn-outline-secondary btn-action-admin">
                    <i class="fa-solid fa-pencil"></i> Edit Student
                </a>
                <a href="<?php echo URLROOT; ?>/admin/students" class="btn btn-dark btn-action-admin">
                    <i class="fa-solid fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content Tabs -->
    <div class="row">
        <div class="col-lg-12">
            <ul class="nav nav-tabs nav-tabs-modern animate-up delay-1" id="studentTabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab">Overview</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="messages-tab" data-bs-toggle="tab" data-bs-target="#messages" type="button" role="tab">Messages</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="gallery-tab" data-bs-toggle="tab" data-bs-target="#gallery" type="button" role="tab">Photo Gallery</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="results-tab" data-bs-toggle="tab" data-bs-target="#results" type="button" role="tab">Official Results</button>
                </li>
            </ul>

            <div class="tab-content animate-up delay-2" id="studentTabsContent">
                <!-- Overview Tab -->
                <div class="tab-pane fade show active" id="overview" role="tabpanel">
                    <div class="content-card-admin">
                        <div class="row g-4 mb-5">
                            <div class="col-md-3">
                                <div class="stat-mini">
                                    <span class="stat-mini-label">Email Address</span>
                                    <div class="stat-mini-value"><?php echo $data['student']->email; ?></div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stat-mini">
                                    <span class="stat-mini-label">Academic Status</span>
                                    <div class="stat-mini-value text-success"><i class="fa-solid fa-circle-check"></i> Active Scholar</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="stat-mini">
                                    <span class="stat-mini-label">Assigned Sponsors</span>
                                    <div class="stat-mini-value">
                                        <?php if(!empty($data['sponsors'])) : ?>
                                            <?php foreach($data['sponsors'] as $sponsor) : ?>
                                                <span class="badge bg-white text-dark border me-1"><?php echo $sponsor->name; ?></span>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <span class="text-muted">No sponsors assigned.</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-12">
                                <h5 class="fw-bold mb-3 border-bottom pb-2">Biography & Story</h5>
                                <p class="text-muted" style="line-height: 1.8;"><?php echo nl2br($data['student']->about); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Messages Tab -->
                <div class="tab-pane fade" id="messages" role="tabpanel">
                    <div class="content-card-admin">
                        <h5 class="fw-bold mb-4">Communication History</h5>
                        <?php if(!empty($data['messages'])) : ?>
                            <div class="table-responsive">
                                <table class="table results-table">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Sender</th>
                                            <th>Content Preview</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($data['messages'] as $message) : ?>
                                            <tr>
                                                <td class="small"><?php echo date('M d, Y', strtotime($message->created_at)); ?></td>
                                                <td class="fw-bold"><?php echo $message->sender_name; ?></td>
                                                <td class="small text-muted text-truncate" style="max-width: 300px;"><?php echo $message->content; ?></td>
                                                <td>
                                                    <span class="badge <?php echo $message->status == 'approved' ? 'bg-success' : 'bg-warning'; ?> rounded-pill">
                                                        <?php echo ucfirst($message->status); ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else : ?>
                            <div class="text-center py-5">
                                <p class="text-muted">No message history for this student.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Gallery Tab -->
                <div class="tab-pane fade" id="gallery" role="tabpanel">
                    <div class="content-card-admin">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold m-0">Student Gallery</h5>
                            <button class="btn btn-action-admin btn-upload" data-bs-toggle="modal" data-bs-target="#uploadPhotoModal">
                                <i class="fa-solid fa-cloud-arrow-up"></i> Add Photo
                            </button>
                        </div>
                        
                        <div class="admin-gallery-grid">
                            <?php foreach($data['gallery'] as $photo) : ?>
                                <div class="gallery-card-admin">
                                    <img src="<?php echo URLROOT . '/' . $photo->photo_path; ?>" class="gallery-img-admin">
                                    <div class="gallery-overlay-admin">
                                        <form action="<?php echo URLROOT; ?>/admin/delete_gallery_photo/<?php echo $photo->id; ?>/<?php echo $data['student']->id; ?>" method="post" onsubmit="return confirm('Delete this photo?')">
                                            <button type="submit" class="delete-btn-overlay"><i class="fa-solid fa-trash-can"></i></button>
                                        </form>
                                        <div class="text-white small fw-bold text-truncate"><?php echo $photo->caption; ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Results Tab -->
                <div class="tab-pane fade" id="results" role="tabpanel">
                    <div class="content-card-admin">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold m-0">Academic Certificates & Results</h5>
                            <button class="btn btn-action-admin btn-upload" data-bs-toggle="modal" data-bs-target="#uploadResultModal">
                                <i class="fa-solid fa-cloud-arrow-up"></i> Upload Result
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table results-table">
                                <thead>
                                    <tr>
                                        <th>Document Name</th>
                                        <th>Upload Date</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($data['uploads'] as $result) : ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="bg-light p-2 rounded"><i class="fa-solid fa-file-image text-primary"></i></div>
                                                    <span class="fw-bold"><?php echo $result->file_name; ?></span>
                                                </div>
                                            </td>
                                            <td class="text-muted small"><?php echo date('M d, Y', strtotime($result->created_at)); ?></td>
                                            <td class="text-end">
                                                <div class="d-flex justify-content-end gap-2">
                                                    <a href="<?php echo URLROOT . '/' . $result->file_path; ?>" target="_blank" class="btn btn-sm btn-light border"><i class="fa-solid fa-external-link"></i></a>
                                                    <form action="<?php echo URLROOT; ?>/admin/delete_result/<?php echo $result->id; ?>/<?php echo $data['student']->id; ?>" method="post" onsubmit="return confirm('Delete this result?')">
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash-can"></i></button>
                                                    </form>
                                                </div>
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
    </div>
</div>

<!-- Modal: Upload Photo -->
<div class="modal fade" id="uploadPhotoModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-none">
            <div class="modal-header border-bottom-0 p-4">
                <h5 class="modal-title fw-bold">Add Gallery Photo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo URLROOT; ?>/admin/upload_gallery/<?php echo $data['student']->id; ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body p-4 pt-0">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase">Select Image</label>
                        <input type="file" name="gallery_photo" class="form-control" required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-bold small text-uppercase">Caption</label>
                        <input type="text" name="caption" class="form-control" placeholder="Describe this moment...">
                    </div>
                </div>
                <div class="modal-footer border-top-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-3 px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-3 px-4">Upload Photo</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Upload Result -->
<div class="modal fade" id="uploadResultModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-none">
            <div class="modal-header border-bottom-0 p-4">
                <h5 class="modal-title fw-bold">Upload Official Result</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo URLROOT; ?>/admin/upload_results/<?php echo $data['student']->id; ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body p-4 pt-0">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase">Document Title</label>
                        <input type="text" name="file_name" class="form-control" placeholder="e.g. Grade 4 Term 1 Report" required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-bold small text-uppercase">Select Document (Image)</label>
                        <input type="file" name="result_file" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer border-top-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-3 px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-3 px-4">Upload Result</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/layouts/footer.php'; ?>
