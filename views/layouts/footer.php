    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navbarCollapse = document.getElementById('mainNav');
            const mainNavbar = document.querySelector('.main-navbar');
            const body = document.body;

            if (navbarCollapse) {
                // Handle Open
                navbarCollapse.addEventListener('show.bs.collapse', function() {
                    mainNavbar.classList.add('menu-open');
                    body.style.overflow = 'hidden';
                });

                // Handle Close
                navbarCollapse.addEventListener('hide.bs.collapse', function() {
                    mainNavbar.classList.remove('menu-open');
                    body.style.overflow = '';
                });
            }

            // Enhanced Mobile Dropdown Logic
            // Allows both: 1. Clicking text to navigate, 2. Clicking arrow to toggle
            const dropdownToggles = document.querySelectorAll('.nav-link.dropdown-toggle');
            dropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    if (window.innerWidth < 992) {
                        // Check if the click was on the right side (where the arrow/pseudo-element is)
                        const rect = this.getBoundingClientRect();
                        const clickX = e.clientX - rect.left;
                        const threshold = rect.width - 50; // 50px from the right is the toggle zone

                        if (clickX > threshold) {
                            e.preventDefault();
                            e.stopPropagation();
                            const menu = this.nextElementSibling;
                            if (menu) {
                                menu.classList.toggle('show');
                                this.classList.toggle('arrow-up'); // For custom arrow styling if needed
                            }
                        }
                        // Otherwise, let the default link navigation happen
                    }
                });
            });

            // Close menu when clicking outside of the floating box
            document.addEventListener('click', function(e) {
                if (window.innerWidth < 992 && 
                    navbarCollapse.classList.contains('show') && 
                    !navbarCollapse.contains(e.target) && 
                    !e.target.closest('.navbar-toggler')) {
                    const bsCollapse = new bootstrap.Collapse(navbarCollapse);
                    bsCollapse.hide();
                }
            });
        });
    </script>
    <script src="<?php echo URLROOT; ?>/js/main.js"></script>
</body>
</html>
