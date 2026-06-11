    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navbarCollapse = document.getElementById('mainNav');
            const menuIcon = document.getElementById('menuIcon');
            const mainNavbar = document.querySelector('.main-navbar');
            const body = document.body;

            if (navbarCollapse && menuIcon) {
                // Handle Toggler Click
                navbarCollapse.addEventListener('show.bs.collapse', function() {
                    menuIcon.classList.replace('fa-bars', 'fa-xmark');
                    mainNavbar.classList.add('menu-open');
                    body.style.overflow = 'hidden'; // Prevent scroll
                });

                navbarCollapse.addEventListener('hide.bs.collapse', function() {
                    menuIcon.classList.replace('fa-xmark', 'fa-bars');
                    mainNavbar.classList.remove('menu-open');
                    body.style.overflow = ''; // Restore scroll
                });
            }

            // Handle mobile dropdown clicks (override default Bootstrap for the overlay)
            const dropdownToggles = document.querySelectorAll('.nav-link.dropdown-toggle');
            dropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    if (window.innerWidth < 992) {
                        e.preventDefault();
                        e.stopPropagation();
                        const menu = this.nextElementSibling;
                        if (menu) {
                            menu.classList.toggle('show');
                        }
                    }
                });
            });
        });
    </script>
    <script src="<?php echo URLROOT; ?>/js/main.js"></script>
</body>
</html>
