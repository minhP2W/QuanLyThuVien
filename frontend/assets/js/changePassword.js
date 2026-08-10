// Xử lý ẩn/hiện mật khẩu
function togglePassword(inputId, iconId) {
    const password = document.getElementById(inputId);
    const togglePassword = document.getElementById(iconId);

    togglePassword.addEventListener("click", () => {
        if (password.type === "password") {
            password.type = "text";
            togglePassword.classList.remove("bi-eye-slash");
            togglePassword.classList.add("bi-eye");
        } else {
            password.type = "password";
            togglePassword.classList.remove("bi-eye");
            togglePassword.classList.add("bi-eye-slash");
        }
    });
}

togglePassword("old-password", "toggleOldPassword");
togglePassword("new-password", "toggleNewPassword");
togglePassword("confirm-password", "toggleConfirmPassword");