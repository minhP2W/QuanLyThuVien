// Xử lý hiển thị và chỉnh sửa hồ sơ thông tin
const profileView = document.getElementById("profile-view");
const viewActions = document.getElementById("view-actions");
const editForm = document.getElementById("edit-profile-form");

const editBtn = document.getElementById("edit-profile-btn");
const cancelBtn = document.getElementById("cancel-edit");

const title = document.getElementById("profile-title");

if (editBtn && cancelBtn) {

    editBtn.addEventListener("click", () => {

        profileView.style.display = "none";
        viewActions.style.display = "none";
        editForm.style.display = "block";

        title.innerHTML = 'Chỉnh sửa hồ sơ';

        // Cuộn lên đầu khung
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });

    });

    cancelBtn.addEventListener("click", () => {
        editForm.reset(); // Khôi phục giá trị ban đầu
        editForm.style.display = "none";
        profileView.style.display = "block";
        viewActions.style.display = "flex";
        title.innerHTML = 'Hồ sơ cá nhân';
    });
}