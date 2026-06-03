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
    margin-bottom: 60px;
    position: relative;
    padding-top: 20px;
}

.portfolio-title {
    font-family: var(--title-font);
    font-weight: 900;
    font-size: 3.8rem;
    color: #005BFF;
    text-transform: uppercase;
    letter-spacing: 6px;
    margin-bottom: 15px;
    background: linear-gradient(135deg, var(--book-cover-color) 0%, #005BFF 50%, var(--book-cover-color) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-shadow: 4px 4px 10px rgba(0,0,0,0.08);
    display: inline-block;
}

.title-underline {
    width: 120px;
    height: 5px;
    background: linear-gradient(to right, var(--book-cover-color), #005BFF);
    margin: 0 auto;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,91,255,0.2);
}

.portfolio-nav-buttons {
    margin-top: 35px;
    display: flex;
    justify-content: center;
    gap: 20px;
}

.btn-download {
    background: linear-gradient(135deg, #005BFF 0%, #0046cc 100%);
    color: white !important;
    border: none !important;
    padding: 12px 30px !important;
    border-radius: 50px !important;
    font-weight: 700 !important;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-size: 0.9rem;
    box-shadow: 0 10px 20px rgba(0,91,255,0.25);
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) !important;
    display: flex;
    align-items: center;
    gap: 10px;
}

.btn-back-nav {
    background: white;
    color: #444 !important;
    border: 1px solid #ddd !important;
    padding: 12px 25px !important;
    border-radius: 50px !important;
    font-weight: 600 !important;
    font-size: 0.9rem;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    transition: all 0.3s ease !important;
}

.btn-primary {
    background-color: #005BFF !important;
    border-color: #005BFF !important;
}

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

.book-base {
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
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

.page {
    width: 100%; height: 100%;
    position: absolute; top: 0; left: 0;
    background-color: var(--page-bg);
    transform-origin: left center;
    transition: transform 1.2s cubic-bezier(0.645, 0.045, 0.355, 1);
    transform-style: preserve-3d;
    cursor: pointer;
    user-select: none;
    border-radius: 0 5px 5px 0;
}

.page-front, .page-back {
    width: 100%; height: 100%;
    position: absolute; top: 0; left: 0;
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
}

.page.flipped {
    transform: rotateY(-178deg) translateZ(1px);
}

.book-cover {
    background: linear-gradient(135deg, var(--book-cover-color) 0%, var(--book-spine-color) 100%);
    color: white;
    text-align: center;
    justify-content: center;
    border-radius: 0 10px 10px 0;
}

.student-img-large {
    width: 200px; height: 200px;
    object-fit: cover; border-radius: 50%;
    border: 10px solid rgba(255,255,255,0.2);
    margin: 0 auto 30px;
}

.page-title {
    color: var(--book-spine-color);
    border-bottom: 2px solid rgba(43, 147, 72, 0.2);
    padding-bottom: 12px;
    margin-bottom: 25px;
    font-weight: 800;
    text-transform: uppercase;
    font-size: 1.2rem;
}

.page-number {
    position: absolute; bottom: 20px; right: 30px;
    font-size: 0.8rem; color: #a0a090; font-weight: bold;
}

.gallery-grid {
    display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px;
}

.gallery-item {
    height: 110px; width: 100%;
    object-fit: cover; border-radius: 5px;
}

.verse-box {
    background: #fdfdf5; padding: 25px;
    border-left: 5px solid var(--book-cover-color);
    font-style: italic; margin: 25px 0; border-radius: 0 10px 10px 0;
}

.prayer-box {
    background: #f0f7f2; padding: 25px; border-radius: 12px;
    border: 2px dashed var(--book-cover-color);
}

.modal-content { border-radius: 24px; border: none; }
.form-control { border-radius: 12px; padding: 12px; }

@media (max-width: 768px) {
    :root { --book-width: 300px; --book-height: 450px; }
    .book-viewport.is-open { transform: translateX(calc(var(--book-width) / 2.2)) scale(0.65); }
    .portfolio-title { font-size: 1.8rem; }
}
</style>

<div class="portfolio-wrapper">
    <div class="container text-center portfolio-title-container">
        <h1 class="portfolio-title">Student Portfolio</h1>
        <div class="title-underline"></div>
        
        <div class="portfolio-nav-buttons">
            <a href="<?php echo URLROOT; ?>/pages/scholarships" class="btn btn-back-nav">
                <i class="fa fa-chevron-left"></i> Back to Scholars
            </a>
            <button class="btn btn-download" onclick="window.print()">
                <i class="fa fa-print"></i> Print Portfolio
            </button>
        </div>
    </div>

    <div class="book-viewport" id="viewport">
        <div class="book" id="book">
            <div class="book-base">
                <p class="text-muted small">Empowering Scholars at</p>
                <h4 class="fw-bold text-success">Heaven of Hope</h4>
            </div>

            <!-- PAGE 1: COVER & STORY -->
            <div class="page" id="page1" style="z-index: 10;" onclick="flipPage(1)">
                <div class="page-front book-cover">
                    <img src="<?php echo !empty($data['student']->profile_photo) ? URLROOT . '/' . $data['student']->profile_photo : 'https://via.placeholder.com/200'; ?>" class="student-img-large shadow" alt="Student">
                    <h2 class="fw-bold"><?php echo $data['student']->first_name . ' ' . $data['student']->surname; ?></h2>
                    <p class="opacity-75">Student Portfolio</p>
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
                        <tr><th class="text-muted small">CLASS</th><td><?php echo $data['student']->class; ?></td></tr>
                        <tr><th class="text-muted small">AGE</th><td><?php echo $data['student']->age; ?> Years</td></tr>
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

            <!-- PAGE 3: GALLERY -->
            <div class="page" id="page3" style="z-index: 8;" onclick="flipPage(3)">
                <div class="page-front">
                    <div class="page-title">Gallery</div>
                    <div class="gallery-grid">
                        <?php foreach(array_slice($data['gallery'], 0, 4) as $photo) : ?>
                            <img src="<?php echo URLROOT . '/' . $photo->photo_path; ?>" class="gallery-item">
                        <?php endforeach; ?>
                    </div>
                    <div class="page-number">4</div>
                </div>
                <div class="page-back">
                    <div class="page-title">Faith & Prayer</div>
                    <div class="verse-box">"<?php echo $data['student']->memory_verse; ?>"</div>
                    <div class="prayer-box"><?php echo nl2br($data['student']->prayer_needs); ?></div>
                    <div class="page-number">5</div>
                </div>
            </div>

            <!-- PAGE 4: BACK COVER -->
            <div class="page" id="page4" style="z-index: 7;" onclick="flipPage(4)">
                <div class="page-front">
                    <div class="page-title">Results</div>
                    <div style="overflow-y: auto; max-height: 400px;">
                        <?php foreach($data['uploads'] as $up) : ?>
                            <img src="<?php echo URLROOT . '/' . $up->file_path; ?>" class="img-fluid rounded mb-2">
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="page-back book-cover">
                    <h3 class="fw-bold">Make a Difference</h3>
                    <p class="small px-4 mt-3">You can help <?php echo $data['student']->first_name; ?> achieve their dreams by becoming a sponsor.</p>
                    <button class="btn btn-light fw-bold rounded-pill px-4 mt-4" onclick="openInterestModal(<?php echo $data['student']->id; ?>, '<?php echo $data['student']->first_name . ' ' . $data['student']->surname; ?>')" style="color: var(--book-cover-color);">
                        Sponsor This Student
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Interest Modal -->
<div class="modal fade" id="interestModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo URLROOT; ?>/pages/interested_sponsorship" method="POST">
                <div class="modal-body">
                    <h4 class="fw-bold text-center mb-4">Sponsorship Interest</h4>
                    <input type="hidden" name="student_id" id="modal_student_id">
                    <p class="text-muted text-center mb-4">You are interested in sponsoring <strong id="modal_student_name"></strong>. Please leave your details.</p>
                    
                    <div class="mb-3">
                        <input type="text" name="sponsor_name" class="form-control" placeholder="Your Full Name" required>
                    </div>
                    <div class="mb-3">
                        <input type="email" name="sponsor_email" class="form-control" placeholder="Your Email" required>
                    </div>
                    <div class="mb-3">
                        <textarea name="message" class="form-control" rows="3" placeholder="Additional notes..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100 rounded-pill py-3 fw-bold mt-2" style="background: #2b9348; border: none;">Send Interest</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
const sound = document.getElementById('pageFlipSound');
const viewport = document.getElementById('viewport');

function flipPage(pageNum) {
    const page = document.getElementById('page' + pageNum);
    if (sound) { sound.currentTime = 0; sound.play().catch(e => {}); }
    page.classList.toggle('flipped');
    if (pageNum === 1) {
        if (page.classList.contains('flipped')) viewport.classList.add('is-open');
        else viewport.classList.remove('is-open');
    }
}

function openInterestModal(id, name) {
    document.getElementById('modal_student_id').value = id;
    document.getElementById('modal_student_name').innerText = name;
    new bootstrap.Modal(document.getElementById('interestModal')).show();
}
</script>

<?php require APPROOT . '/views/layouts/footer.php'; ?>
