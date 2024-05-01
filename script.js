document.addEventListener("DOMContentLoaded", function() {
    const navLinks = document.querySelectorAll('.nav-link');
    const popups = document.querySelectorAll('.popup-container');

    navLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const target = this.getAttribute('data-target');
            const popup = document.getElementById(target);

            // Toggle visibility of popup
            if (popup) {
                if (popup.style.display === 'block') {
                    popup.style.display = 'none';
                } else {
                    // Hide other popups before showing this one
                    popups.forEach(popup => {
                        popup.style.display = 'none';
                    });
                    popup.style.display = 'block';
                }
            }
        });
    });
});
