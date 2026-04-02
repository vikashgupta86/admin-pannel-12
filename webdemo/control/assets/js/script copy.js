
        const proceedBtn = document.getElementById('proceedBtn');
        const categorySelect = document.getElementById('categorySelect');
        const validationAlert = document.getElementById('validationAlert');
        const dataTableSection = document.getElementById('dataTableSection');

        
        const posProceedBtn = document.getElementById('posProceedBtn');
        const posCategorySelect = document.getElementById('posCategorySelect');

    document.addEventListener("DOMContentLoaded", function() {
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('mobile-active');
                overlay.classList.toggle('active');
            } else {
                sidebar.classList.toggle('desktop-collapsed');
            }
        }

        sidebarToggle.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                sidebar.classList.remove('mobile-active');
                overlay.classList.remove('active');
            }
        }); 
        
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                sidebar.classList.remove('mobile-active');
                overlay.classList.remove('active');
            }
        });


        proceedBtn.addEventListener('click', function() {
            if (categorySelect.value === "") {
                validationAlert.classList.remove('d-none');
                dataTableSection.classList.add('d-none');
            } else {
                validationAlert.classList.add('d-none');
                dataTableSection.classList.remove('d-none');
            }
        });



        document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert("Password change submitted. (Backend integration required)");
        });




        proceedBtn.addEventListener('click', function() {
            const form = document.getElementById('feedbackForm');
            if(form.checkValidity()) {
                dataTableSection.classList.remove('d-none');
            } else {
                form.reportValidity();
            }
        });
    });
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	    document.addEventListener("DOMContentLoaded", function() {


        function toggleSidebar() {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }

        sidebarToggle.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar); 
    });
	
	
	
	
	
	    document.addEventListener("DOMContentLoaded", function() {



        posProceedBtn.addEventListener('click', function() {
            if (posCategorySelect.value === "") {
                validationAlert.classList.remove('d-none');
                dataTableSection.classList.add('d-none');
            } else {
                validationAlert.classList.add('d-none');
                dataTableSection.classList.remove('d-none');
            }
        });
    });
	
	
	
	
	
	
	
	
	
	
	
	
	