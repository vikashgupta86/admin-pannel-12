document.addEventListener("DOMContentLoaded", function () {

    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');

    const proceedBtn = document.getElementById('proceedBtn');
    const categorySelect = document.getElementById('categorySelect');

    const posProceedBtn = document.getElementById('posProceedBtn');
    const posCategorySelect = document.getElementById('posCategorySelect');

    const validationAlert = document.getElementById('validationAlert');
    const dataTableSection = document.getElementById('dataTableSection');

    const changePasswordForm = document.getElementById('changePasswordForm');
    const feedbackForm = document.getElementById('feedbackForm');


    function toggleSidebar() {
        if (window.innerWidth <= 768) {
            sidebar.classList.toggle('mobile-active');
            overlay.classList.toggle('active');
        } else {
            sidebar.classList.toggle('desktop-collapsed');
        }
    }

    if (sidebarToggle && sidebar && overlay) {
        sidebarToggle.addEventListener('click', toggleSidebar);

        overlay.addEventListener('click', function () {
            if (window.innerWidth <= 768) {
                sidebar.classList.remove('mobile-active');
                overlay.classList.remove('active');
            }
        });

        window.addEventListener('resize', function () {
            if (window.innerWidth > 768) {
                sidebar.classList.remove('mobile-active');
                overlay.classList.remove('active');
            }
        });
    }


    function handleProceed(selectElement) {
        if (!selectElement) return;

        if (selectElement.value === "") {
            validationAlert.classList.remove('d-none');
            dataTableSection.classList.add('d-none');
        } else {
            validationAlert.classList.add('d-none');
            dataTableSection.classList.remove('d-none');
        }
    }

    if (proceedBtn) {
        proceedBtn.addEventListener('click', function () {
            if (feedbackForm && !feedbackForm.checkValidity()) {
                feedbackForm.reportValidity();
                return;
            }
            handleProceed(categorySelect);
        });
    }

    if (posProceedBtn) {
        posProceedBtn.addEventListener('click', function () {
            handleProceed(posCategorySelect);
        });
    }


    if (changePasswordForm) {
        changePasswordForm.addEventListener('submit', function (e) {
            e.preventDefault();
            alert("Password change submitted. Backend integration required.");
        });
    }

});

