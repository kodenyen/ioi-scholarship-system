<?php require APPROOT . '/views/layouts/header.php'; ?>

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">

<audio id="pageFlipSound" preload="auto">
    <source src="https://www.soundjay.com/misc/sounds/page-flip-01a.mp3" type="audio/mpeg">
</audio>

<style>
:root {
    --book-width: 450px;
    --book-height: 600px;
    --book-cover-color: #2b9348; /* Green */
    --book-spine-color: #005BFF; /* New Blue */
    --page-bg: #FFFFFF; /* Pure White */
    --page-border: #f0f0f0;
    --title-font: 'Playfair Display', serif;
    --body-font: 'Montserrat', sans-serif;
}

.portfolio-title-container {
    margin-bottom: 50px;
    position: relative;
}

.portfolio-title {
    font-family: var(--title-font);
    font-weight: 900;
    font-size: 3.5rem;
    color: #005BFF;
    text-transform: uppercase;
    letter-spacing: 4px;
    margin-bottom: 10px;
    background: linear-gradient(to right, var(--book-cover-color), #005BFF, var(--book-cover-color));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.05);
    display: inline-block;
}

.title-underline {
    width: 100px;
    height: 4px;
    background: var(--book-cover-color);
    margin: 0 auto;
    border-radius: 2px;
}

.portfolio-nav-buttons {
    margin-top: 20px;
    display: flex;
    justify-content: center;
    gap: 15px;
}

.btn-primary {
    background-color: #005BFF !important;
    border-color: #005BFF !important;
}

.btn-primary:hover {
    background-color: #0046cc !important;
    border-color: #0046cc !important;
}

@media print {
    .no-print { display: none !important; }
    .print-only { display: block !important; }
    body { background: white !important; }
}
.print-only { display: none; }

.portfolio-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 90vh;
    background: radial-gradient(circle, #f8f9fa 0%, #e9ecef 100%);
    padding: 40px 0;
    overflow: hidden;
}

.book-viewport {
    perspective: 2000px;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: var(--book-height);
    transition: transform 1s cubic-bezier(0.645, 0.045, 0.355, 1);
}

.book-viewport.is-open {
    transform: translateX(calc(var(--book-width) / 2));
}

.book {
    width: var(--book-width);
    height: var(--book-height);
    position: relative;
    transform-style: preserve-3d;
    transition: transform 1s;
}

/* 3D Stacking Effect replaced by real base */
.book-base {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: var(--page-bg);
    border-radius: 0 5px 5px 0;
    z-index: 0;
    box-shadow: 10px 10px 20px rgba(0,0,0,0.1);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    border: 1px solid var(--page-border);
}

.book-base::after {
    content: '';
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    background: repeating-linear-gradient(90deg, transparent, transparent 2px, rgba(0,0,0,0.03) 3px);
    pointer-events: none;
}

/* Spine */
.book::before {
    content: '';
    position: absolute;
    width: 50px;
    height: 100%;
    left: -25px;
    background: var(--book-spine-color);
    transform: rotateY(-90deg);
    transform-origin: right;
    box-shadow: inset -10px 0 30px rgba(0,0,0,0.5), 
                inset 10px 0 10px rgba(255,255,255,0.1);
    border-radius: 5px 0 0 5px;
}

.page {
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    background-color: var(--page-bg);
    transform-origin: left center;
    transition: transform 1.2s cubic-bezier(0.645, 0.045, 0.355, 1);
    transform-style: preserve-3d;
    cursor: pointer;
    user-select: none;
    border-radius: 0 5px 5px 0;
    box-shadow: inset 10px 0 30px rgba(0,0,0,0.05);
}

.page-front, .page-back {
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0; left: 0;
    backface-visibility: hidden;
    padding: 40px;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    border: 1px solid rgba(0,0,0,0.05);
}

.page-back {
    transform: rotateY(180deg);
    background: linear-gradient(to right, var(--page-bg) 0%, #f7f7e9 100%);
    border-radius: 5px 0 0 5px;
    box-shadow: inset -10px 0 30px rgba(0,0,0,0.05);
}

.page.flipped {
    transform: rotateY(-178deg) translateZ(1px);
}

/* Realistic Shadow on flipped pages */
.page.flipped .page-back::after {
    content: '';
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    background: linear-gradient(to left, rgba(0,0,0,0.05) 0%, transparent 100%);
    pointer-events: none;
}

.book-cover {
    background: linear-gradient(135deg, var(--book-cover-color) 0%, var(--book-spine-color) 100%);
    color: white;
    text-align: center;
    justify-content: center;
    border-radius: 0 10px 10px 0;
    border: none;
    box-shadow: inset 5px 0 10px rgba(255,255,255,0.2), inset -5px 0 10px rgba(0,0,0,0.2);
}

.book-cover::before {
    content: '';
    position: absolute;
    top: 0; left: 15px; width: 2px; height: 100%;
    background: rgba(255,255,255,0.1);
}

.student-img-large {
    width: 220px;
    height: 220px;
    object-fit: cover;
    border-radius: 50%;
    border: 10px solid rgba(255,255,255,0.2);
    margin: 0 auto 30px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.3);
}

.page-title {
    color: var(--book-spine-color);
    border-bottom: 2px solid rgba(43, 147, 72, 0.2);
    padding-bottom: 12px;
    margin-bottom: 25px;
    font-weight: 800;
    text-transform: uppercase;
    font-size: 1.2rem;
    letter-spacing: 2px;
}

.page-number {
    position: absolute;
    bottom: 20px;
    right: 30px;
    font-size: 0.8rem;
    color: #a0a090;
    font-weight: bold;
}

.page-back .page-number {
    left: 30px;
    right: auto;
}

.gallery-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
}

.gallery-item-wrapper {
    background: white;
    padding: 3px;
    border: 1px solid var(--page-border);
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.gallery-item {
    height: 110px;
    object-fit: cover;
    border-radius: 3px;
    width: 100%;
    transition: transform 0.3s;
    display: block;
}

.gallery-caption {
    font-size: 0.6rem;
    color: #666;
    text-align: center;
    padding-top: 4px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    font-family: var(--body-font);
}

.gallery-item:hover {
    transform: scale(1.05);
}

.verse-box {
    background: #fdfdf5;
    padding: 25px;
    border-left: 5px solid var(--book-cover-color);
    font-style: italic;
    margin: 25px 0;
    border-radius: 0 10px 10px 0;
    font-size: 1.1rem;
    line-height: 1.6;
    color: #444;
}

.prayer-box {
    background: #f0f7f2;
    padding: 25px;
    border-radius: 12px;
    border: 2px dashed var(--book-cover-color);
    color: #1e6632;
}

.badge.bg-success {
    background-color: var(--book-cover-color) !important;
}
</style>

<div class="portfolio-wrapper">
    <div class="container text-center no-print portfolio-title-container">
        <h1 class="portfolio-title">Your Student Portfolio</h1>
        <div class="title-underline"></div>
        
        <div class="portfolio-nav-buttons">
            <button onclick="downloadPDF()" class="btn btn-primary shadow-sm px-4">
                <i class="fa fa-download"></i> Download Report
            </button>
            <?php if(isset($data['is_preview']) && $data['is_preview']) : ?>
                <a href="<?php echo URLROOT; ?>/admin/student_profile/<?php echo $data['student']->id; ?>" class="btn btn-outline-secondary shadow-sm px-4">
                    <i class="fa fa-arrow-left"></i> Back to Admin
                </a>
            <?php else : ?>
                <a href="<?php echo URLROOT; ?>/sponsor/dashboard?token=<?php echo $_GET['token']; ?>" class="btn btn-outline-secondary shadow-sm px-4">
                    <i class="fa fa-chevron-left"></i> Dashboard
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Printable Version (Modern Report Layout) -->
    <div id="printable-profile" class="print-only">
        <style>
            @media print {
                .print-only { display: block !important; visibility: visible !important; }
                .page-break { page-break-before: always; clear: both; display: block; height: 1px; }
                body { background: white !important; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 0; margin: 0; }
                @page { margin: 2cm; size: A4; }
                .no-print { display: none !important; }
            }
            .print-container { width: 100%; max-width: 800px; margin: 0 auto; color: #333; }
            .print-header {
                text-align: center;
                border-bottom: 4px solid var(--book-cover-color);
                padding-bottom: 30px;
                margin-bottom: 40px;
            }
            .print-section {
                margin-bottom: 40px;
                page-break-inside: avoid;
            }
            .print-section h3 {
                color: var(--book-cover-color);
                border-bottom: 2px solid #f0f0f0;
                padding-bottom: 12px;
                text-transform: uppercase;
                font-size: 1.4rem;
                font-weight: 800;
                margin-bottom: 20px;
            }
            .print-grid {
                display: flex;
                flex-wrap: wrap;
                gap: 20px;
                margin-top: 20px;
            }
            .print-photo-wrapper {
                width: calc(50% - 10px);
                margin-bottom: 20px;
                page-break-inside: avoid;
            }
            .print-photo {
                width: 100%;
                height: 280px;
                object-fit: cover;
                border-radius: 12px;
                border: 1px solid #eee;
                box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            }
            .print-badge {
                display: inline-block;
                padding: 6px 18px;
                background: #f8f9fa;
                border-radius: 30px;
                font-size: 0.95rem;
                font-weight: 600;
                margin: 5px;
                border: 1px solid #eee;
            }
            .story-content {
                line-height: 1.8;
                font-size: 1.15rem;
                color: #444;
                text-align: justify;
            }
        </style>

        <div class="print-container">
            <!-- PAGE 1: COVER & BIO -->
            <div class="print-header">
                <?php 
                    $logo = getSetting('site_logo');
                    if($logo && file_exists(APPROOT . '/' . $logo)) : 
                ?>
                    <img src="<?php echo URLROOT . '/' . $logo; ?>" style="max-height: 60px; margin-bottom: 30px;">
                <?php endif; ?>
                
                <div style="margin-bottom: 30px;">
                    <img src="<?php echo !empty($data['student']->profile_photo) ? URLROOT . '/' . $data['student']->profile_photo : ''; ?>" style="width: 180px; height: 180px; border-radius: 50%; border: 8px solid #f8f9fa; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                </div>
                
                <h1 style="margin: 0; font-size: 3rem; font-weight: 900; color: #001219;"><?php echo $data['student']->first_name . ' ' . $data['student']->surname; ?></h1>
                <p style="font-size: 1.3rem; color: #666; margin-top: 10px;">Official Student Portfolio | Heaven of Hope Academy</p>
                
                <div style="margin-top: 30px;">
                    <span class="print-badge">Class: <?php echo $data['student']->class; ?></span>
                    <span class="print-badge">Age: <?php echo $data['student']->age; ?> Years</span>
                    <span class="print-badge">ID: SCH-<?php echo str_pad($data['student']->id, 4, '0', STR_PAD_LEFT); ?></span>
                </div>
            </div>

            <div class="print-section">
                <h3>My Story</h3>
                <div class="story-content"><?php echo nl2br($data['student']->about); ?></div>
            </div>

            <div class="print-section">
                <h3>Educational Goals</h3>
                <div class="story-content"><?php echo nl2br($data['student']->educational_goals); ?></div>
            </div>

            <!-- PAGE 2: FAITH & GALLERY -->
            <div class="page-break"></div>
            
            <div class="print-section">
                <h3>Faith & Prayer</h3>
                <div style="background: #fdfdf5; padding: 30px; border-left: 6px solid var(--brand-green); border-radius: 0 15px 15px 0; margin-bottom: 25px; border: 1px solid #f0f0e0;">
                    <h4 style="margin-top: 0; color: var(--brand-green); text-transform: uppercase; font-size: 0.9rem; letter-spacing: 1px;">Favorite Memory Verse</h4>
                    <p style="font-style: italic; font-size: 1.4rem; color: #333; margin: 15px 0 0;">"<?php echo $data['student']->memory_verse; ?>"</p>
                </div>
                <div style="background: #f0f7ff; padding: 30px; border-radius: 20px; border: 2px dashed #005BFF;">
                    <h4 style="margin-top: 0; color: #005BFF; text-transform: uppercase; font-size: 0.9rem; letter-spacing: 1px;">Current Prayer Needs</h4>
                    <p style="font-size: 1.1rem; color: #333; margin: 15px 0 0;"><?php echo nl2br($data['student']->prayer_needs); ?></p>
                </div>
            </div>

            <div class="print-section">
                <h3>Photo Gallery</h3>
                <div class="print-grid">
                    <?php foreach($data['gallery'] as $photo) : ?>
                        <div class="print-photo-wrapper">
                            <img src="<?php echo URLROOT . '/' . $photo->photo_path; ?>" class="print-photo">
                            <?php if(!empty($photo->caption)) : ?>
                                <p style="font-size: 0.9rem; text-align: center; color: #666; margin-top: 10px; font-weight: 600;"><?php echo $photo->caption; ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- PAGE 3: OFFICIAL RESULTS -->
            <?php if(!empty($data['uploads'])) : ?>
                <div class="page-break"></div>
                <div class="print-section">
                    <h3>Official Results & Certificates</h3>
                    <?php foreach($data['uploads'] as $up) : ?>
                        <div style="margin-bottom: 40px; text-align: center; page-break-inside: avoid;">
                            <h4 style="text-align: left; background: #f8f9fa; padding: 10px 20px; border-radius: 8px; border-left: 4px solid #001219;"><?php echo $up->file_name; ?></h4>
                            <img src="<?php echo URLROOT . '/' . $up->file_path; ?>" style="max-width: 100%; border: 2px solid #eee; border-radius: 10px; margin-top: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div style="margin-top: 60px; text-align: center; color: #aaa; border-top: 1px solid #eee; padding-top: 30px; page-break-inside: avoid;">
                <p style="font-weight: 600;">Thank you for your support. Together we are changing lives.</p>
                <p style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;">Generated on <?php echo date('M d, Y'); ?> | IOI Global Scholarship Program</p>
            </div>
        </div>
    </div>

    <div class="book-viewport" id="viewport">
        <div class="book" id="book">
            <!-- PAGE 1: COVER & STORY -->
            <div class="page" id="page1" style="z-index: 10;" onclick="flipPage(1)">
                <div class="page-front book-cover">
                    <img src="<?php echo !empty($data['student']->profile_photo) ? URLROOT . '/' . $data['student']->profile_photo : 'https://via.placeholder.com/200'; ?>" class="student-img-large shadow" alt="Student">
                    <h2 class="fw-bold"><?php echo $data['student']->first_name . ' ' . $data['student']->surname; ?></h2>
                    <p class="opacity-75">Your Student Portfolio 2026</p>
                    <div class="mt-5 small text-uppercase" style="letter-spacing: 2px;">Click to Open</div>
                </div>
                <div class="page-back">
                    <div class="page-title">My Story</div>
                    <p style="line-height: 1.6; font-size: 0.95rem; color: #444;">
                        <?php echo nl2br($data['student']->about); ?>
                    </p>
                    <div class="page-number">1</div>
                </div>
            </div>

            <!-- PAGE 2: PROFILE & GOALS -->
            <div class="page" id="page2" style="z-index: 9;" onclick="flipPage(2)">
                <div class="page-front">
                    <div class="page-title">Academic Profile</div>
                    <table class="table table-sm mt-3">
                        <tr><th class="text-muted small">NAME</th><td><?php echo $data['student']->first_name; ?></td></tr>
                        <tr><th class="text-muted small">SURNAME</th><td><?php echo $data['student']->surname; ?></td></tr>
                        <tr><th class="text-muted small">CLASS</th><td><?php echo $data['student']->class; ?></td></tr>
                        <tr><th class="text-muted small">AGE</th><td><?php echo $data['student']->age; ?> Years</td></tr>
                        <tr><th class="text-muted small">STATUS</th><td><span class="badge bg-success">Active</span></td></tr>
                    </table>
                    <div class="page-number">2</div>
                </div>
                <div class="page-back">
                    <div class="page-title">Educational Goals</div>
                    <p style="line-height: 1.6; font-size: 0.95rem;">
                        <?php echo nl2br($data['student']->educational_goals); ?>
                    </p>
                    <div class="page-number">3</div>
                </div>
            </div>

            <!-- PAGE 3: FAITH & NEEDS -->
            <div class="page" id="page3" style="z-index: 8;" onclick="flipPage(3)">
                <div class="page-front">
                    <div class="page-title">Best Memory Verse</div>
                    <div class="verse-box">
                        "<?php echo $data['student']->memory_verse; ?>"
                    </div>
                    <div class="page-number">4</div>
                </div>
                <div class="page-back">
                    <div class="page-title">Prayer Needs</div>
                    <div class="prayer-box">
                        <?php echo nl2br($data['student']->prayer_needs); ?>
                    </div>
                    <div class="page-number">5</div>
                </div>
            </div>

            <!-- PAGE 4: GALLERY (LIFE AT HEAVEN OF HOPE ACADEMY) -->
            <div class="page" id="page4" style="z-index: 7;" onclick="flipPage(4)">
                <div class="page-front">
                    <div class="page-title">Life at Heaven of Hope Academy</div>
                    <div class="gallery-grid">
                        <?php if(!empty($data['gallery'])) : ?>
                            <?php foreach(array_slice($data['gallery'], 0, 4) as $photo) : ?>
                                <div class="gallery-item-wrapper">
                                    <img src="<?php echo URLROOT . '/' . $photo->photo_path; ?>" class="gallery-item">
                                    <?php if(!empty($photo->caption)) : ?>
                                        <div class="gallery-caption"><?php echo $photo->caption; ?></div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <p class="text-muted small">No gallery photos yet.</p>
                        <?php endif; ?>
                    </div>
                    <?php if(count($data['gallery']) > 4) : ?>
                        <small class="text-muted mt-2 d-block">+ <?php echo count($data['gallery']) - 4; ?> more photos</small>
                    <?php endif; ?>
                    <div class="page-number">6</div>
                </div>
                <div class="page-back">
                    <div class="page-title">More Moments</div>
                    <div class="gallery-grid mt-2">
                        <?php if(count($data['gallery']) > 4) : ?>
                            <?php foreach(array_slice($data['gallery'], 4, 4) as $photo) : ?>
                                <div class="gallery-item-wrapper">
                                    <img src="<?php echo URLROOT . '/' . $photo->photo_path; ?>" class="gallery-item">
                                    <?php if(!empty($photo->caption)) : ?>
                                        <div class="gallery-caption"><?php echo $photo->caption; ?></div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <p class="small text-muted text-center py-5">Photos capturing the daily life and smiles of our scholars.</p>
                        <?php endif; ?>
                    </div>
                    <div class="page-number">7</div>
                </div>
            </div>

            <!-- PAGE 5: RESULTS -->
            <div class="page" id="page5" style="z-index: 6;" onclick="flipPage(5)">
                <div class="page-front">
                    <div class="page-title">Official Results</div>
                    <div class="results-gallery" style="overflow-y: auto; max-height: 400px;">
                        <?php if(empty($data['uploads'])) : ?>
                            <p class="text-muted small">No result images uploaded.</p>
                        <?php else : ?>
                            <?php foreach($data['uploads'] as $up) : ?>
                                <div class="mb-3 border-bottom pb-2">
                                    <small class="text-primary fw-bold d-block mb-1"><?php echo $up->file_name; ?></small>
                                    <img src="<?php echo URLROOT . '/' . $up->file_path; ?>" class="img-fluid rounded shadow-sm" style="width: 100%;">
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <div class="page-number">8</div>
                </div>
                <div class="page-back">
                    <!-- Blank dummy page -->
                    <div class="d-flex align-items-center justify-content-center h-100 opacity-25">
                        <i class="fa-solid fa-book-open-reader fa-3x"></i>
                    </div>
                    <div class="page-number">9</div>
                </div>
            </div>

            <!-- PAGE 6: DUMMY LOGO & BACK COVER -->
            <div class="page" id="page6" style="z-index: 5;" onclick="flipPage(6)">
                <div class="page-front">
                    <div class="d-flex flex-column align-items-center justify-content-center h-100">
                        <?php 
                            $logo = getSetting('site_logo');
                            if($logo && file_exists(APPROOT . '/' . $logo)) : 
                        ?>
                            <img src="<?php echo URLROOT . '/' . $logo; ?>" alt="Logo" style="max-height: 80px; max-width: 80%; object-fit: contain; opacity: 0.5; filter: grayscale(100%);">
                        <?php endif; ?>
                        <p class="text-muted small mt-3">Empowering the next generation.</p>
                    </div>
                    <div class="page-number">10</div>
                </div>
                <div class="page-back book-cover" style="border-radius: 10px 0 0 10px;">
                    <?php 
                        $logo = getSetting('site_logo');
                        if($logo && file_exists(APPROOT . '/' . $logo)) : 
                    ?>
                        <div class="mb-4 d-flex justify-content-center w-100">
                            <img src="<?php echo URLROOT . '/' . $logo; ?>" alt="Logo" style="max-height: 100px; max-width: 80%; object-fit: contain;">
                        </div>
                    <?php endif; ?>
                    <h3 class="fw-bold">Thank You</h3>
                    <p class="small px-4 mt-2">Your support is building a bright future for <?php echo $data['student']->first_name; ?>.</p>
                    
                    <div class="mt-5 no-print">
                        <a href="https://ioiglobal.org/thaddeus-scholarship/" target="_blank" class="btn btn-light btn-sm fw-bold px-4 py-2 shadow-sm" style="color: var(--book-cover-color); border-radius: 30px;">
                            Support Another Student
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    
    <p class="mt-5 text-muted small"><i class="fa fa-hand-pointer-o"></i> Click pages to flip forward and backward</p>
</div>

<script>
const sound = document.getElementById('pageFlipSound');
const viewport = document.getElementById('viewport');
const totalPages = 6;

function flipPage(pageNum) {
    const page = document.getElementById('page' + pageNum);
    if (!page) return;

    // Play Sound
    if (sound) {
        sound.currentTime = 0;
        sound.play().catch(e => {
            console.log("Audio playback blocked or failed");
        });
    }

    // Flip logic
    page.classList.toggle('flipped');

    // Viewport shift for centering
    if (pageNum === 1) {
        if (page.classList.contains('flipped')) {
            viewport.classList.add('is-open');
        } else {
            viewport.classList.remove('is-open');
        }
    }

    // Dynamic Z-index to prevent overlapping
    updateZIndices();
}

function updateZIndices() {
    for (let i = 1; i <= totalPages; i++) {
        const page = document.getElementById('page' + i);
        if (page.classList.contains('flipped')) {
            page.style.zIndex = i;
        } else {
            page.style.zIndex = (totalPages - i) + 1 + 5;
        }
    }
}

function downloadPDF() {
    window.print();
}

// Initial z-index setup
updateZIndices();
</script>

<?php require APPROOT . '/views/layouts/footer.php'; ?>
