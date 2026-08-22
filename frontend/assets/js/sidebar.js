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

// Lưu vị trí cuộn khi bấm chức năng yêu cầu đăng nhập
document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.querySelector(".reader-sidebar");

    const isReaderLoggedIn = sidebar?.dataset.loggedIn === "true"; // Kiểm tra trạng thái đăng nhập

    const links = document.querySelectorAll(".reader-login-required");

    // Đã đăng nhập:
    // xóa vị trí cũ và không lưu nữa
    if (isReaderLoggedIn) {
        sessionStorage.removeItem("scrollPosition");
        return;
    }

    // Chưa đăng nhập:
    // lưu vị trí hiện tại để phục vụ alert-warning
    links.forEach(link => {
        link.addEventListener("click", function () {
            sessionStorage.setItem("scrollPosition", window.scrollY);
        });
    });
});

// Chỉ khôi phục vị trí khi trang hiện tại thực sự có alert-warning
window.addEventListener("load", function () {
    const sidebar = document.querySelector(".reader-sidebar");

    const isReaderLoggedIn = sidebar?.dataset.loggedIn === "true"; // Kiểm tra trạng thái đăng nhập

    // Đã đăng nhập → luôn ở đầu trang
    if (isReaderLoggedIn) {
        sessionStorage.removeItem("scrollPosition"); // Xoá đi để không ảnh hưởng lần chuyển trang tiếp theo
        window.scrollTo(0, 0);
        return;
    }

    // Chưa đăng nhập:
    // Chỉ khôi phục khi trang hiện tại có alert-warning
    // Chuyển trang bình thường → không restore || Bị chặn vì chưa đăng nhập → có alert-warning → restore
    const warningAlert = document.getElementById("alert-warning");

    if (!warningAlert) {
        return;
    }

    // Lưu vị trí đã lưu
    const scrollPosition = sessionStorage.getItem("scrollPosition");

    if (scrollPosition !== null) {
        window.scrollTo(0, parseInt(scrollPosition, 10));
        sessionStorage.removeItem("scrollPosition"); // Xoá đi để không ảnh hưởng lần chuyển trang tiếp theo
    }
});