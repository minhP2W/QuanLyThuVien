// Xử lý hiển thị thông tin ở navbar cho độc giả
document.addEventListener("DOMContentLoaded", function () {
    const btn = document.getElementById("reader-user-btn");
    const dropdown = document.getElementById("reader-profile-dropdown");

    if (!btn || !dropdown) return;

    btn.addEventListener("click", function (e) {
        e.stopPropagation();
        dropdown.classList.toggle("show");
    });

    document.addEventListener("click", function () {
        dropdown.classList.remove("show");
    });

    dropdown.addEventListener("click", function (e) {
        e.stopPropagation();
    });
});