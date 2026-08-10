// Xử lý hiển thị thông báo sau khi đăng nhập thành công (load trang xong mới hiển thị)
document.addEventListener("DOMContentLoaded", function () {
    const alertSuccess = document.getElementById("alert-success");

    if (alertSuccess) {
        setTimeout(() => {
            alertSuccess.style.transition = "opacity 0.5s ease";
            alertSuccess.style.opacity = "0";
            alertSuccess.style.transform = "translateX(120%)";

            setTimeout(() => {
                alertSuccess.remove();
            }, 500);

        }, 3000);
    }
});

// Xử lý hiển thị cảnh báo khi chưa đăng nhập (load trang xong mới hiển thị)
document.addEventListener("DOMContentLoaded", function () {
    const alertSuccess = document.getElementById("alert-warning");

    if (alertSuccess) {
        setTimeout(() => {
            alertSuccess.style.transition = "opacity 0.5s ease";
            alertSuccess.style.opacity = "0";
            alertSuccess.style.transform = "translateX(120%)";

            setTimeout(() => {
                alertSuccess.remove();
            }, 500);

        }, 3000);
    }
});