let registerForm = document.getElementById("registerForm");

registerForm.addEventListener("submit", function(e) {
    e.preventDefault();

    let warningModal = new bootstrap.Modal(document.getElementById("warningModal"));
    
    warningModal.show();
})