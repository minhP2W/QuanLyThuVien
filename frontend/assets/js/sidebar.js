// Xử lý hiển thị màn hình popup xác nhận đăng xuất
document.addEventListener("DOMContentLoaded", function () {
    const logoutBtn = document.getElementById("logout");
    const modal = document.getElementById("logout-modal");
    const cancelBtn = document.getElementById("logout-cancel");

    if (!logoutBtn || !modal) return;

    // Mở popup
    logoutBtn.addEventListener("click", function (e) {
        e.preventDefault();
        modal.classList.add("show");
    });

    // Đóng popup
    cancelBtn.addEventListener("click", function () {
        modal.classList.remove("show");
    });

    // Click ra ngoài để đóng
    modal.addEventListener("click", function (e) {
        if (e.target === modal) {
            modal.classList.remove("show");
        }
    });

    // ESC để đóng
    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape") {
            modal.classList.remove("show");
        }
    });
});