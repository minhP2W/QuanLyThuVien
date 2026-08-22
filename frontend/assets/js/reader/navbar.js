// Xử lý dropdown navbar cho độc giả
document.addEventListener("DOMContentLoaded", function () {
    // Lấy các phần tử
    const userBtn = document.getElementById("reader-user-btn");
    const profileDropdown = document.getElementById("reader-profile-dropdown");
    const notificationBtn = document.getElementById("reader-notification-btn");
    const notificationDropdown = document.getElementById("reader-notification-dropdown");

    // Dropdown thông tin độc giả
    if (userBtn && profileDropdown) {
        userBtn.addEventListener("click", function (e) {
            e.stopPropagation();

            profileDropdown.classList.toggle("show");

            // Đóng notification nếu đang mở
            if (notificationDropdown) {
                notificationDropdown.classList.remove("show");
            }
        });

        profileDropdown.addEventListener("click", function (e) {
            e.stopPropagation();
        });

    }

    // Dropdown thông báo
    if (notificationBtn) {
        notificationBtn.addEventListener("click", function (e) {
            e.stopPropagation();

            const isLoggedIn = notificationBtn.dataset.loggedIn === "true";

            // Chưa đăng nhập
            if (!isLoggedIn) {
                sessionStorage.setItem("scrollPosition", window.scrollY);

                const url = new URL(window.location.href);
                url.searchParams.set("notification", "login_required");

                window.location.href = url.toString();
                return;
            }

            // Đã đăng nhập
            if (notificationDropdown) {
                notificationDropdown.classList.toggle("show");
            }

            if (profileDropdown) {
                profileDropdown.classList.remove("show");
            }

            // Đóng profile
            if (profileDropdown) {
                profileDropdown.classList.remove("show");
            }
        });

        if (notificationDropdown) {
            notificationDropdown.addEventListener("click", function (e) {
                e.stopPropagation();
            });
        }
    }

    // Click ra ngoài
    document.addEventListener("click", function () {

        if (profileDropdown) {
            profileDropdown.classList.remove("show");
        }

        if (notificationDropdown) {
            notificationDropdown.classList.remove("show");
        }
    });
});