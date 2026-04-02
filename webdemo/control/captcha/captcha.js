function refreshCaptcha() {
    var captchaImg = document.getElementById('captcha');
    if (captchaImg) {
        captchaImg.src = 'captcha/login_captcha.php?sid=' + Math.random();
    }
}
