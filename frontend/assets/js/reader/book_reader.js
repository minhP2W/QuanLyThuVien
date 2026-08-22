// Xử lý nút yêu thích
const isLoggedIn = document.body.dataset.loggedIn === "true";
const baseUrl = document.body.dataset.baseUrl;

document.querySelectorAll(".reader-login-required").forEach(button => {
    button.addEventListener("click", function () {
        // Chưa đăng nhập
        if (!isLoggedIn) {
            const url = new URL(window.location.href);

            url.searchParams.set(
                "notification",
                "login_required"
            );

            sessionStorage.setItem(
                "scrollPosition",
                window.scrollY
            );

            window.location.href = url.toString();

            return;
        }

        // Đã đăng nhập
        const bookId = this.dataset.bookId;
        const returnPage = this.dataset.returnPage || "book_reader";

        // Lưu URL hiện tại + vị trí cuộn
        sessionStorage.setItem("favoriteReturnUrl", window.location.href);
        sessionStorage.setItem("favoriteScrollPosition", window.scrollY);

        // Tạo form POST
        const form = document.createElement("form");

        form.method = "POST";
        form.action = baseUrl + "/index.php?page=toggleFavorite";

        const bookInput = document.createElement("input");
        bookInput.type = "hidden";
        bookInput.name = "book_id";
        bookInput.value = bookId;

        const returnPageInput = document.createElement("input");
        returnPageInput.type = "hidden";
        returnPageInput.name = "return_page";
        returnPageInput.value = returnPage;

        form.appendChild(bookInput);
        form.appendChild(returnPageInput);

        const returnUrlInput = document.createElement("input");
        returnUrlInput.type = "hidden";
        returnUrlInput.name = "return_url";
        returnUrlInput.value = window.location.href;

        form.appendChild(returnUrlInput);

        document.body.appendChild(form);

        form.submit();
    });
});

// Khôi phục vị trí cuộn sau khi reload trang
window.addEventListener("load", function () {
    const savedUrl = sessionStorage.getItem("favoriteReturnUrl");
    const savedScroll = sessionStorage.getItem("favoriteScrollPosition");

    // Chỉ khôi phục nếu đang quay lại đúng trang sách
    if (savedUrl && savedScroll !== null && window.location.href === savedUrl) {
        window.scrollTo(0, parseInt(savedScroll, 10));

        sessionStorage.removeItem("favoriteReturnUrl");
        sessionStorage.removeItem("favoriteScrollPosition");
    }
});