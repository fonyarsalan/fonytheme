document.addEventListener("DOMContentLoaded", function () {
    if (window.location.pathname === '/login/index.php') {
        const labels = document.querySelectorAll('label.sr-only');
        const forgotPassword = document.querySelector(
          ".login-form-forgotpassword a"
        );
        const firstTimeText = document.querySelectorAll('.login-heading');
        
        if(labels){
            labels.forEach(function (label) {
                label.style.display = "contents";
            });
        }
        if (forgotPassword) {
            forgotPassword.innerHTML = "Forgot Your Password?";
        }
        if (firstTimeText) {
            firstTimeText[1].innerHTML = "First time using this site";
        }
    }
});