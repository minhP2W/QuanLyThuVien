CREATE DATABASE IF NOT EXISTS `librio` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci; -- chuẩn unicode
USE `librio`;

-- 1. XOÁ BẢNG NẾU TỒN TẠI
DROP TABLE IF EXISTS `favorites`;
DROP TABLE IF EXISTS `search_histories`;
DROP TABLE IF EXISTS `reservations`;
DROP TABLE IF EXISTS `reviews`;
DROP TABLE IF EXISTS `notifications`;
DROP TABLE IF EXISTS `return_details`;
DROP TABLE IF EXISTS `fines`;
DROP TABLE IF EXISTS `return_slips`;
DROP TABLE IF EXISTS `borrow_details`;
DROP TABLE IF EXISTS `borrow_slips`;
DROP TABLE IF EXISTS `books`;
DROP TABLE IF EXISTS `readers`;
DROP TABLE IF EXISTS `publishers`;
DROP TABLE IF EXISTS `categories`;
DROP TABLE IF EXISTS `authors`;
DROP TABLE IF EXISTS `users`;

-- 2. TẠO BẢNG
-- =========================
-- 1. USERS -- Bảng User (admin, thủ thư)
-- =========================
CREATE TABLE `users` (
    `user_id` INT AUTO_INCREMENT PRIMARY KEY,              -- Mã người dùng
    `username` VARCHAR(50) NOT NULL UNIQUE,                -- Tên đăng nhập
    `password` VARCHAR(255) NOT NULL,                      -- Mật khẩu (đã mã hóa)
    `full_name` VARCHAR(100) NOT NULL,                     -- Họ và tên
    `role` ENUM('admin','staff') DEFAULT 'staff' NOT NULL, -- Vai trò (Admin / Thủ thư)
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL -- Thời gian tạo tài khoản
);

-- =========================
-- 2. AUTHORS -- Bảng tác giả
-- =========================
CREATE TABLE `authors` (
    `author_id` INT AUTO_INCREMENT PRIMARY KEY,            -- Mã tác giả
    `author_name` VARCHAR(100) NOT NULL,                   -- Tên tác giả
    `biography` TEXT                                       -- Tiểu sử tác giả
);

-- =========================
-- 3. CATEGORIES -- Bảng thể loại
-- =========================
CREATE TABLE `categories` (
    `category_id` INT AUTO_INCREMENT PRIMARY KEY,          -- Mã thể loại
    `category_name` VARCHAR(100) NOT NULL UNIQUE,          -- Tên thể loại
    `icon` VARCHAR(50),                                    -- Icon thể loại
    `icon_color` VARCHAR(20)                               -- Màu icon thể loại
);

-- =========================
-- 4. PUBLISHERS -- Bảng nhà xuất bản
-- =========================
CREATE TABLE `publishers` (
    `publisher_id` INT AUTO_INCREMENT PRIMARY KEY,         -- Mã nhà xuất bản
    `publisher_name` VARCHAR(150) NOT NULL,                -- Tên nhà xuất bản
    `address` VARCHAR(255) NOT NULL,                       -- Địa chỉ
    `phone` VARCHAR(20) NOT NULL                           -- Số điện thoại
);

-- =========================
-- 5. BOOKS -- Bảng sách
-- =========================
CREATE TABLE `books` (
    `book_id` INT AUTO_INCREMENT PRIMARY KEY,              -- Mã sách
    `isbn` VARCHAR(20) UNIQUE,                             -- Mã ISBN
    `title` VARCHAR(255) NOT NULL,                         -- Tên sách
    `author_id` INT NOT NULL,                              -- Mã tác giả
    `publisher_id` INT NOT NULL,                           -- Mã nhà xuất bản
    `category_id` INT NOT NULL,                            -- Mã thể loại
    `publish_year` YEAR,                                   -- Năm xuất bản
    `total_quantity` INT NOT NULL DEFAULT 0,               -- Tổng số lượng sách
    `available_quantity` INT NOT NULL DEFAULT 0,           -- Số lượng sách còn có thể mượn
    `price` DECIMAL(10,2) NOT NULL DEFAULT 0,              -- Đơn giá sách
    `cover_image` VARCHAR(255) NOT NULL,                   -- Ảnh bìa sách
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL, -- Thời gian thêm sách

    CONSTRAINT `fk_book_author`
        FOREIGN KEY (`author_id`)
        REFERENCES `authors`(`author_id`),

    CONSTRAINT `fk_book_publisher`
        FOREIGN KEY (`publisher_id`)
        REFERENCES `publishers`(`publisher_id`),

    CONSTRAINT `fk_book_category`
        FOREIGN KEY (`category_id`)
        REFERENCES `categories`(`category_id`)
);

-- =========================
-- 6. READERS -- Bảng độc giả (người đọc)
-- =========================
CREATE TABLE `readers` (
    `reader_id` INT AUTO_INCREMENT PRIMARY KEY,            -- Mã độc giả
    `reader_code` VARCHAR(10) NOT NULL UNIQUE,             -- Mã độc giả (dùng để đăng nhập)
    `full_name` VARCHAR(100) NOT NULL,                     -- Họ và tên
    `gender` ENUM('Male','Female','Other') 
           DEFAULT 'Other' NOT NULL,                       -- Giới tính
    `birth_date` DATE,                                     -- Ngày sinh
    `email` VARCHAR(100) NOT NULL,                         -- Email
    `phone` VARCHAR(20) NOT NULL,                          -- Số điện thoại
    `password` VARCHAR(255) NOT NULL,                      -- Mật khẩu đã mã hóa
    `address` VARCHAR(255),                                -- Địa chỉ
    `status` ENUM('active','inactive') 
           DEFAULT 'active' NOT NULL,                      -- trạng thái tài khoản
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL -- Thời gian tạo hồ sơ
);

-- =========================
-- 7. BORROW SLIPS -- Bảng phiếu mượn
-- =========================
CREATE TABLE `borrow_slips` (
    `borrow_id` INT AUTO_INCREMENT PRIMARY KEY,            -- Mã phiếu mượn
    `reader_id` INT NOT NULL,                              -- Mã độc giả
    `staff_id` INT NOT NULL,                               -- Mã thủ thư lập phiếu
    `borrow_date` DATE NOT NULL,                           -- Ngày mượn
    `due_date` DATE NOT NULL,                              -- Hạn trả
    `status` ENUM('Borrowing','Returned') 
             DEFAULT 'Borrowing',                          -- Trạng thái phiếu

    CONSTRAINT `fk_borrow_reader`
        FOREIGN KEY (`reader_id`)
        REFERENCES readers(`reader_id`),

    CONSTRAINT `fk_borrow_staff`
        FOREIGN KEY (`staff_id`)
        REFERENCES `users`(`user_id`)
);

-- =========================
-- 8. BORROW DETAILS -- Bảng chi tiết phiếu mượn
-- =========================
CREATE TABLE `borrow_details` (
    `detail_id` INT AUTO_INCREMENT PRIMARY KEY,            -- Mã chi tiết phiếu mượn
    `borrow_id` INT NOT NULL,                              -- Mã phiếu mượn
    `book_id` INT NOT NULL,                                -- Mã sách
    `quantity` INT DEFAULT 1,                              -- Số lượng mượn

    UNIQUE (`borrow_id`, `book_id`),

    CONSTRAINT `fk_detail_borrow`
        FOREIGN KEY (`borrow_id`)
        REFERENCES borrow_slips(`borrow_id`),

    CONSTRAINT `fk_detail_book`
        FOREIGN KEY (`book_id`)
        REFERENCES `books`(`book_id`)
);

-- =========================
-- 9. RETURN SLIPS -- Bảng phiếu trả
-- =========================
CREATE TABLE `return_slips` (
    `return_id` INT AUTO_INCREMENT PRIMARY KEY,            -- Mã phiếu trả
    `borrow_id` INT NOT NULL UNIQUE,                       -- Mã phiếu mượn tương ứng
    `staff_id` INT NOT NULL,                               -- Mã thủ thư xử lý trả sách
    `return_date` DATE NOT NULL,                           -- Ngày trả
    `total_fine` DECIMAL(12,0) NOT NULL DEFAULT 0,         -- Tổng tiền phạt
    `note` TEXT,                                           -- Ghi chú

    CONSTRAINT `fk_return_borrow`
        FOREIGN KEY (`borrow_id`)
        REFERENCES `borrow_slips`(`borrow_id`),

    CONSTRAINT `fk_return_staff`
        FOREIGN KEY (`staff_id`)
        REFERENCES users(`user_id`)
);

-- =========================
-- 10. FINES -- Bảng tiền phạt
-- =========================
CREATE TABLE `fines` (
    `fine_id` INT AUTO_INCREMENT PRIMARY KEY,              -- Mã tiền phạt
    `overdue_days` INT NOT NULL DEFAULT 0,                 -- Số ngày trả quá hạn
    `condition_status` ENUM('Normal','Damaged','Lost')
                     DEFAULT 'Normal' NOT NULL,            -- Tình trạng sách
    `damage_note` TEXT,                                    -- Ghi chú thiệt hại
    `fine` DECIMAL(12,0) NOT NULL DEFAULT 0                -- Tiền phạt
);

-- =========================
-- 11. RETURN DETAILS -- Bảng chi tiết phiếu trả
-- =========================
CREATE TABLE `return_details` (
    `detail_id` INT AUTO_INCREMENT PRIMARY KEY,            -- Mã chi tiết phiếu trả
    `return_id` INT NOT NULL,                              -- Mã phiếu trả
    `book_id` INT NOT NULL,                                -- Mã sách
    `quantity` INT DEFAULT 1,                              -- Số lượng trả
    `fine_id` INT UNIQUE,                                  -- Mã tiền phạt

    UNIQUE (`return_id`, `book_id`),

    CONSTRAINT `fk_return_detail`
        FOREIGN KEY (`return_id`)
        REFERENCES `return_slips`(`return_id`),

    CONSTRAINT `fk_return_book`
        FOREIGN KEY (`book_id`)
        REFERENCES `books`(`book_id`),

    CONSTRAINT `fk_return_fine`
        FOREIGN KEY (`fine_id`)
        REFERENCES `fines`(`fine_id`)
);

-- =========================
-- 12. NOTIFICATIONS -- Bảng thông báo
-- =========================
CREATE TABLE `notifications` (
    `notification_id` INT AUTO_INCREMENT PRIMARY KEY,      -- Mã thông báo
    `reader_id` INT NOT NULL,                              -- Độc giả nhận thông báo
    `title` VARCHAR(255) NOT NULL,                         -- Tiêu đề
    `content` TEXT NOT NULL,                               -- Nội dung
    `is_read` BOOLEAN DEFAULT FALSE,                       -- Đã đọc hay chưa
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL, -- Thời gian tạo

    CONSTRAINT `fk_notification_reader`
        FOREIGN KEY (`reader_id`)
        REFERENCES `readers`(`reader_id`)
        ON DELETE CASCADE
);

-- =========================
-- 13. REVIEWS -- Bảng đánh giá sách
-- =========================
CREATE TABLE `reviews` (
    `review_id` INT AUTO_INCREMENT PRIMARY KEY,            -- Mã đánh giá
    `reader_id` INT NOT NULL,                              -- Người đánh giá
    `book_id` INT NOT NULL,                                -- Sách được đánh giá
    `rating` TINYINT NOT NULL CHECK (rating BETWEEN 1 AND 5), -- Số sao (1-5)
    `comment` TEXT,                                        -- Nhận xét
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL, -- Thời gian đánh giá

    UNIQUE (`reader_id`, `book_id`),                           -- Mỗi độc giả đánh giá 1 lần

    CONSTRAINT `fk_review_reader`
        FOREIGN KEY (`reader_id`)
        REFERENCES `readers`(`reader_id`)
        ON DELETE CASCADE,

    CONSTRAINT `fk_review_book`
        FOREIGN KEY (`book_id`)
        REFERENCES books(`book_id`)
);

-- =========================
-- 14. RESERVATIONS -- Bảng đặt trước sách
-- =========================
CREATE TABLE `reservations` (
    `reservation_id` INT AUTO_INCREMENT PRIMARY KEY,       -- Mã đặt trước
    `reader_id` INT NOT NULL,                              -- Độc giả đặt
    `book_id` INT NOT NULL,                                -- Sách được đặt
    `reservation_date` DATE NOT NULL,                      -- Ngày đặt
    `status` ENUM('Pending','Approved','Cancelled','Completed')
           DEFAULT 'Pending' NOT NULL,                   -- Trạng thái
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL, -- Thời gian tạo

    CONSTRAINT `fk_reservation_reader`
        FOREIGN KEY (`reader_id`)
        REFERENCES `readers`(`reader_id`)
        ON DELETE CASCADE,

    CONSTRAINT `fk_reservation_book`
        FOREIGN KEY (`book_id`)
        REFERENCES `books`(`book_id`)
);

-- =========================
-- 15. SEARCH HISTORIES -- Bảng lịch sử tìm kiếm
-- =========================
CREATE TABLE search_histories (
    `history_id` INT AUTO_INCREMENT PRIMARY KEY,          -- Mã lịch sử
    `reader_id` INT NOT NULL,                             -- Độc giả tìm kiếm
    `keyword` VARCHAR(255) NOT NULL,                      -- Từ khóa tìm kiếm
    `searched_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL, -- Thời gian tìm kiếm

    CONSTRAINT `fk_search_reader`
        FOREIGN KEY (`reader_id`)
        REFERENCES `readers`(`reader_id`)
        ON DELETE CASCADE
);

-- =========================
-- 16. FAVORITES -- Bảng sách yêu thích
-- =========================
CREATE TABLE `favorites` (
    `favorite_id` INT AUTO_INCREMENT PRIMARY KEY,          -- Mã yêu thích
    `reader_id` INT NOT NULL,                              -- Độc giả
    `book_id` INT NOT NULL,                                -- Sách yêu thích
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL, -- Thời gian thêm

    UNIQUE (`reader_id`, `book_id`),                       -- Không yêu thích trùng

    CONSTRAINT `fk_favorite_reader`
        FOREIGN KEY (`reader_id`)
        REFERENCES `readers`(`reader_id`)
        ON DELETE CASCADE,

    CONSTRAINT `fk_favorite_book`
        FOREIGN KEY (`book_id`)
        REFERENCES `books`(`book_id`)
        ON DELETE CASCADE
);

-- 3. TẠO DỮ LIỆU
-- =====================================
-- USERS
-- Password: 123456
-- =====================================

INSERT INTO `users` (`username`, `password`, `full_name`, `role`) VALUES
('admin', '$2y$10$sH/sRtKc4hAsAT/eBaqGR.5RfXN3PoBgQ97O.kyA6g5GgXHtMG/cS', 'Nguyễn Văn Admin', 'admin'),
('staff01', '$2y$10$sH/sRtKc4hAsAT/eBaqGR.5RfXN3PoBgQ97O.kyA6g5GgXHtMG/cS', 'Trần Minh Anh', 'staff'),
('staff02', '$2y$10$sH/sRtKc4hAsAT/eBaqGR.5RfXN3PoBgQ97O.kyA6g5GgXHtMG/cS', 'Lê Thu Hà', 'staff'),
('staff03', '$2y$10$sH/sRtKc4hAsAT/eBaqGR.5RfXN3PoBgQ97O.kyA6g5GgXHtMG/cS', 'Phạm Quốc Bảo', 'staff');

-- =====================================
-- AUTHORS
-- =====================================

INSERT INTO `authors` (`author_name`, `biography`) VALUES
('Nguyễn Nhật Ánh', 'Nhà văn Việt Nam nổi tiếng với nhiều tác phẩm dành cho thiếu nhi và tuổi mới lớn.'),
('Nam Cao', 'Nhà văn hiện thực nổi tiếng của Việt Nam trước Cách mạng tháng Tám.'),
('Tô Hoài', 'Nhà văn Việt Nam, nổi tiếng với tác phẩm Dế Mèn Phiêu Lưu Ký.'),
('Dale Carnegie', 'Tác giả người Mỹ nổi tiếng với các sách về giao tiếp và phát triển bản thân.'),
('Robert C. Martin', 'Kỹ sư phần mềm và tác giả nổi tiếng với các sách về phát triển phần mềm.'),
('J.K. Rowling', 'Nhà văn người Anh, tác giả bộ truyện Harry Potter.'),
('George Orwell', 'Nhà văn và nhà báo người Anh, nổi tiếng với 1984 và Animal Farm.'),
('Paulo Coelho', 'Nhà văn Brazil nổi tiếng với các tác phẩm mang tính triết lý và truyền cảm hứng.'),
('Haruki Murakami', 'Nhà văn Nhật Bản nổi tiếng với nhiều tiểu thuyết đương đại.'),
('Stephen King', 'Nhà văn Mỹ nổi tiếng với các tiểu thuyết kinh dị và kỳ ảo.'),
('Eric Ries', 'Doanh nhân và tác giả nổi tiếng với phương pháp Lean Startup.'),
('Robert Kiyosaki', 'Tác giả người Mỹ nổi tiếng với các sách về tài chính cá nhân và đầu tư.'),
('Napoleon Hill', 'Tác giả người Mỹ nổi tiếng với các tác phẩm về thành công và phát triển cá nhân.'),
('James Clear', 'Tác giả người Mỹ nổi tiếng với các nội dung về thói quen và phát triển bản thân.'),
('Yuval Noah Harari', 'Sử gia người Israel, tác giả nhiều sách về lịch sử và tương lai nhân loại.'),
('Stephen Hawking', 'Nhà vật lý lý thuyết người Anh, nổi tiếng với các công trình và sách phổ biến khoa học.'),
('Carl Sagan', 'Nhà thiên văn học và nhà khoa học Mỹ, nổi tiếng với các tác phẩm phổ biến khoa học.'),
('Cambridge University Press & Assessment', 'Đơn vị xuất bản các tài liệu học thuật và giáo trình tiếng Anh của Cambridge.'),
('Raymond Murphy', 'Tác giả nổi tiếng với các giáo trình ngữ pháp tiếng Anh.'),
('Norman Lewis', 'Tác giả và chuyên gia ngôn ngữ nổi tiếng với các tài liệu học tiếng Anh.'),
('Philip Kotler', 'Giáo sư và tác giả nổi tiếng trong lĩnh vực marketing.'),
('James C. Collins', 'Tác giả và nhà nghiên cứu nổi tiếng trong lĩnh vực quản trị và kinh doanh.');

-- =====================================
-- CATEGORIES
-- =====================================

INSERT INTO `categories` (`category_name`, `icon`, `icon_color`) VALUES
('Tiểu thuyết', 'bi-book', '#3975db'),
('Công nghệ thông tin', 'bi-laptop', '#20a486'),
('Kỹ năng sống', 'bi-person-check', '#e59a17'),
('Kinh tế', 'bi-graph-up', '#7656d6'),
('Văn học', 'bi-book-half', '#d95b86'),
('Thiếu nhi', 'bi-balloon', '#3c8dcc'),
('Ngoại ngữ', 'bi-translate', '#9b5dcc'),
('Khoa học', 'bi-lightbulb', '#55a94f');

-- =====================================
-- PUBLISHERS
-- =====================================

INSERT INTO `publishers` (`publisher_name`, `address`, `phone`) VALUES
('NXB Trẻ', '161B Lý Chính Thắng, TP.HCM', '02839316289'),
('NXB Kim Đồng', '55 Quang Trung, Hà Nội', '02439434730'),
('NXB Giáo Dục Việt Nam', '81 Trần Hưng Đạo, Hà Nội', '02438220801'),
('NXB Lao Động', '175 Giảng Võ, Hà Nội', '02438515380'),
('NXB Thống Kê', '98 Hoàng Quốc Việt, Hà Nội', '02437562633'),
('NXB Tổng Hợp TP.HCM', '62 Nguyễn Thị Minh Khai, TP.HCM', '02838296764'),
('NXB Văn Học', '18 Nguyễn Trường Tộ, Hà Nội', '02439438213'),
('NXB Hồng Đức', '65 Tràng Thi, Hà Nội', '02439260024'),
('NXB Thế Giới', '46 Trần Hưng Đạo, Hà Nội', '02439440634'),
('NXB Phụ Nữ Việt Nam', '39 Hàng Chuối, Hà Nội', '02439710717'),
('NXB Đại Học Kinh Tế Quốc Dân', '207 Giải Phóng, Hà Nội', '02436280280'),
('NXB Bách Khoa Hà Nội', 'Số 1 Đại Cồ Việt, Hà Nội', '02438683475'),
('NXB Cambridge University Press', 'Cambridge, United Kingdom', '+44 1223 358331');

-- =====================================
-- BOOKS
-- =====================================

INSERT INTO `books`
(`isbn`, `title`, `author_id`, `publisher_id`, `category_id`, `publish_year`,
`total_quantity`, `available_quantity`, `price`, `cover_image`)
VALUES

('9786041000011','Mắt Biếc',1,1,1,2019,10,7,95000,'mat_biec.jpg'),

('9786041000012','Cho Tôi Xin Một Vé Đi Tuổi Thơ',1,1,6,2020,8,4,88000,'cho_toi_xin_1_ve.jpg'),

('9786041000013','Cô Gái Đến Từ Hôm Qua',1,1,1,2018,12,10,92000,'co_gai_den_tu_hom_qua.jpg'),

('9786041000014','Chí Phèo',2,7,5,2017,15,12,65000,'chi_pheo.jpg'),

('9786041000015','Lão Hạc',2,7,5,2018,12,8,60000,'lao_hac.jpg'),

('9786041000016','Đời Thừa',2,7,5,2019,8,6,68000,'doi_thua.jpg'),

('9786041000017','Dế Mèn Phiêu Lưu Ký',3,2,6,2021,20,15,85000,'de_men.jpg'),

('9786041000018','Vợ Chồng A Phủ',3,7,5,2019,10,9,70000,'vo_chong_a_phu.jpg'),

('9786041000019','Đắc Nhân Tâm',4,1,3,2022,30,22,110000,'dac_nhan_tam.jpg'),

('9786041000020','Quẳng Gánh Lo Đi Và Vui Sống',4,1,3,2023,18,15,120000,'quang_ganh_lo_di.jpg'),

('9786041000021','Clean Code',5,6,2,2021,15,5,210000,'clean_code.jpg'),

('9786041000022','Clean Architecture',5,6,2,2022,12,6,230000,'clean_architecture.jpg'),

('9786041000023','The Clean Coder',5,6,2,2020,10,7,220000,'clean_coder.jpg'),

('9786041000024','Harry Potter Và Hòn Đá Phù Thủy',6,6,1,2020,25,20,180000,'hp1.jpg'),

('9786041000025','Harry Potter Và Phòng Chứa Bí Mật',6,6,1,2020,20,16,185000,'hp2.jpg'),

('9786041000026','Harry Potter Và Tên Tù Nhân Azkaban',6,6,1,2021,18,13,190000,'hp3.jpg'),

('9786041000027','1984',7,7,1,2019,12,0,145000,'1984.jpg'),

('9786041000028','Animal Farm',7,7,1,2018,10,3,130000,'animal_farm.jpg'),

('9786041000029','Nhà Giả Kim',8,7,1,2023,25,18,140000,'nha_gia_kim.jpg'),

('9786041000030','Veronika Quyết Chết',8,7,1,2021,10,8,135000,'veronika.jpg'),

('9786041000031','Rừng Na Uy',9,7,1,2022,15,11,165000,'rung_na_uy.jpg'),

('9786041000032','Kafka Bên Bờ Biển',9,7,1,2021,10,7,175000,'kafka.jpg'),

('9786041000033','IT',10,7,1,2020,8,2,240000,'it.jpg'),

('9786041000034','The Shining',10,7,1,2019,10,5,220000,'the_shining.jpg'),

('9786041000035','Cujo',10,7,1,2018,6,4,195000,'cujo.jpg'),

('9786041000036','Lập Trình PHP Cơ Bản',5,12,2,2023,15,12,165000,'php_basic.jpg'),

('9786041000037','PHP & MySQL Web Development',5,12,2,2022,12,8,215000,'php_mysql.jpg'),

('9786041000038','Java Programming',5,12,2,2021,18,15,195000,'java_programming.jpg'),

('9786041000039','Python Cơ Bản',5,12,2,2024,20,18,185000,'python_basic.jpg'),

('9786041000040','Python Nâng Cao',5,12,2,2024,10,9,225000,'python_advanced.jpg'),

('9786041000041','Learning SQL',5,12,2,2022,14,10,180000,'learning_sql.jpg'),

('9786041000042','Database System Concepts',5,12,2,2020,8,5,245000,'database_system.jpg'),

('9786041000043','HTML & CSS Design',5,12,2,2023,16,13,170000,'html_css.jpg'),

('9786041000044','JavaScript The Definitive Guide',5,12,2,2021,10,7,235000,'javascript.jpg'),

('9786041000045','You Don''t Know JS',5,12,2,2022,12,10,220000,'ydkjs.jpg'),

('9786041000046','Nguyên Lý Marketing',21,11,4,2020,15,12,150000,'marketing.jpg'),

('9786041000047','Khởi Nghiệp Tinh Gọn',11,11,4,2022,10,7,165000,'lean_startup.jpg'),

('9786041000048','Cha Giàu Cha Nghèo',12,11,4,2021,18,15,135000,'rich_dad.jpg'),

('9786041000049','Think And Grow Rich',13,11,4,2019,12,10,145000,'think_grow_rich.jpg'),

('9786041000050','Atomic Habits',14,10,3,2023,20,17,185000,'atomic_habits.jpg'),

('9786041000051','IELTS Cambridge 18',18,13,7,2024,25,20,210000,'cambridge18.jpg'),

('9786041000052','English Grammar In Use',19,13,7,2022,22,18,195000,'grammar_in_use.jpg'),

('9786041000053','Oxford Word Skills',20,13,7,2021,16,14,175000,'word_skills.jpg'),

('9786041000054','Basic English Conversation',18,13,7,2023,18,16,160000,'basic_english.jpg'),

('9786041000055','Vũ Trụ Trong Vỏ Hạt Dẻ',16,9,8,2019,10,8,170000,'universe.jpg'),

('9786041000056','Lược Sử Thời Gian',16,9,8,2020,12,10,180000,'brief_history_time.jpg'),

('9786041000057','Cosmos',17,9,8,2018,8,6,190000,'cosmos.jpg'),

('9786041000058','Sapiens',15,9,8,2023,18,15,220000,'sapiens.jpg'),

('9786041000059','Homo Deus',15,9,8,2022,15,11,225000,'homo_deus.jpg'),

('9786041000060','21 Bài Học Cho Thế Kỷ 21',15,9,8,2021,14,10,215000,'21_lessons.jpg');

-- =====================================
-- READERS (20 độc giả)
-- Password: 123456
-- =====================================

INSERT INTO `readers`
(`reader_code`, `full_name`, `gender`, `birth_date`, `email`, `phone`, `password`, `address`, `status`)
VALUES

('DG001','Nguyễn Văn An','Male','2001-03-15','an01@gmail.com','0911111111',
'$2y$10$sH/sRtKc4hAsAT/eBaqGR.5RfXN3PoBgQ97O.kyA6g5GgXHtMG/cS',
'Hà Nội','active'),

('DG002','Trần Thị Bình','Female','2002-05-20','binh02@gmail.com','0911111112',
'$2y$10$sH/sRtKc4hAsAT/eBaqGR.5RfXN3PoBgQ97O.kyA6g5GgXHtMG/cS',
'Hà Nội','active'),

('DG003','Lê Minh Cường','Male','2000-08-12','cuong03@gmail.com','0911111113',
'$2y$10$sH/sRtKc4hAsAT/eBaqGR.5RfXN3PoBgQ97O.kyA6g5GgXHtMG/cS',
'Hải Phòng','active'),

('DG004','Phạm Thu Dung','Female','2001-11-08','dung04@gmail.com','0911111114',
'$2y$10$sH/sRtKc4hAsAT/eBaqGR.5RfXN3PoBgQ97O.kyA6g5GgXHtMG/cS',
'Hà Nam','active'),

('DG005','Hoàng Quốc Đạt','Male','1999-06-30','dat05@gmail.com','0911111115',
'$2y$10$sH/sRtKc4hAsAT/eBaqGR.5RfXN3PoBgQ97O.kyA6g5GgXHtMG/cS',
'Nam Định','active'),

('DG006','Đỗ Thị Giang','Female','2002-09-17','giang06@gmail.com','0911111116',
'$2y$10$sH/sRtKc4hAsAT/eBaqGR.5RfXN3PoBgQ97O.kyA6g5GgXHtMG/cS',
'Thái Bình','active'),

('DG007','Vũ Đức Hải','Male','2001-01-09','hai07@gmail.com','0911111117',
'$2y$10$sH/sRtKc4hAsAT/eBaqGR.5RfXN3PoBgQ97O.kyA6g5GgXHtMG/cS',
'Hải Dương','active'),

('DG008','Bùi Ngọc Hương','Female','2003-04-14','huong08@gmail.com','0911111118',
'$2y$10$sH/sRtKc4hAsAT/eBaqGR.5RfXN3PoBgQ97O.kyA6g5GgXHtMG/cS',
'Bắc Ninh','active'),

('DG009','Ngô Văn Khang','Male','2000-12-21','khang09@gmail.com','0911111119',
'$2y$10$sH/sRtKc4hAsAT/eBaqGR.5RfXN3PoBgQ97O.kyA6g5GgXHtMG/cS',
'Hà Nội','active'),

('DG010','Lý Thị Lan','Female','2001-07-11','lan10@gmail.com','0911111120',
'$2y$10$sH/sRtKc4hAsAT/eBaqGR.5RfXN3PoBgQ97O.kyA6g5GgXHtMG/cS',
'Ninh Bình','active'),

('DG011','Phan Minh Long','Male','1998-10-10','long11@gmail.com','0911111121',
'$2y$10$sH/sRtKc4hAsAT/eBaqGR.5RfXN3PoBgQ97O.kyA6g5GgXHtMG/cS',
'Hà Nội','active'),

('DG012','Mai Thu Mai','Female','2002-03-18','mai12@gmail.com','0911111122',
'$2y$10$sH/sRtKc4hAsAT/eBaqGR.5RfXN3PoBgQ97O.kyA6g5GgXHtMG/cS',
'Hưng Yên','active'),

('DG013','Trịnh Quốc Nam','Male','2001-02-28','nam13@gmail.com','0911111123',
'$2y$10$sH/sRtKc4hAsAT/eBaqGR.5RfXN3PoBgQ97O.kyA6g5GgXHtMG/cS',
'Thanh Hóa','active'),

('DG014','Đặng Thị Ngọc','Female','2000-06-16','ngoc14@gmail.com','0911111124',
'$2y$10$sH/sRtKc4hAsAT/eBaqGR.5RfXN3PoBgQ97O.kyA6g5GgXHtMG/cS',
'Nghệ An','active'),

('DG015','Hà Văn Phúc','Male','1999-09-05','phuc15@gmail.com','0911111125',
'$2y$10$sH/sRtKc4hAsAT/eBaqGR.5RfXN3PoBgQ97O.kyA6g5GgXHtMG/cS',
'Vĩnh Phúc','active'),

('DG016','Lưu Thị Quỳnh','Female','2002-01-19','quynh16@gmail.com','0911111126',
'$2y$10$sH/sRtKc4hAsAT/eBaqGR.5RfXN3PoBgQ97O.kyA6g5GgXHtMG/cS',
'Hà Nội','inactive'),

('DG017','Chu Minh Sơn','Male','2001-12-25','son17@gmail.com','0911111127',
'$2y$10$sH/sRtKc4hAsAT/eBaqGR.5RfXN3PoBgQ97O.kyA6g5GgXHtMG/cS',
'Bắc Giang','inactive'),

('DG018','Đinh Thu Trang','Female','2003-05-09','trang18@gmail.com','0911111128',
'$2y$10$sH/sRtKc4hAsAT/eBaqGR.5RfXN3PoBgQ97O.kyA6g5GgXHtMG/cS',
'Hà Nội','inactive'),

('DG019','Tạ Quốc Trung','Male','2000-08-08','trung19@gmail.com','0911111129',
'$2y$10$sH/sRtKc4hAsAT/eBaqGR.5RfXN3PoBgQ97O.kyA6g5GgXHtMG/cS',
'Hải Phòng','inactive'),

('DG020','Phùng Thanh Vân','Female','2001-04-27','van20@gmail.com','0911111130',
'$2y$10$sH/sRtKc4hAsAT/eBaqGR.5RfXN3PoBgQ97O.kyA6g5GgXHtMG/cS',
'Hà Nội','inactive');

-- =====================================
-- BORROW_SLIPS (15 phiếu mượn)
-- =====================================

INSERT INTO `borrow_slips`
(`reader_id`, `staff_id`, `borrow_date`, `due_date`, `status`)
VALUES
(1,2,'2026-07-01','2026-07-15','Returned'),
(2,2,'2026-07-03','2026-07-17','Returned'),
(3,3,'2026-07-05','2026-07-19','Returned'),
(4,3,'2026-07-08','2026-07-22','Returned'),
(5,4,'2026-07-10','2026-07-24','Returned'),
(6,2,'2026-07-12','2026-07-26','Returned'),
(7,3,'2026-07-15','2026-07-29','Returned'),
(8,4,'2026-07-18','2026-08-01','Returned'),
(9,2,'2026-07-20','2026-08-03','Returned'),
(10,3,'2026-07-22','2026-08-05','Returned'),
(11,4,'2026-07-25','2026-08-08','Borrowing'),
(12,2,'2026-07-27','2026-08-10','Borrowing'),
(13,3,'2026-07-30','2026-08-13','Borrowing'),
(14,4,'2026-08-01','2026-08-15','Borrowing'),
(15,2,'2026-08-03','2026-08-17','Borrowing');

-- =====================================
-- BORROW_DETAILS (30 chi tiết)
-- =====================================

INSERT INTO `borrow_details`
(`borrow_id`, `book_id`, `quantity`)
VALUES
(1,1,1),
(1,11,1),

(2,2,1),
(2,17,1),

(3,7,1),
(3,21,1),

(4,14,1),
(4,29,1),

(5,18,1),
(5,31,1),

(6,9,1),
(6,36,1),

(7,10,1),
(7,37,1),

(8,24,1),
(8,38,1),

(9,25,1),
(9,39,1),

(10,30,1),
(10,40,1),

(11,41,1),
(11,42,1),

(12,43,1),
(12,44,1),

(13,45,1),
(13,46,1),

(14,47,1),
(14,48,1),

(15,49,1),
(15,50,1);

-- =====================================
-- RETURN_SLIPS (10 phiếu trả)
-- borrow_id từ 1 -> 10 đã Returned
-- =====================================

INSERT INTO `return_slips`
(`borrow_id`, `staff_id`, `return_date`, `total_fine`, `note`)
VALUES
(1,2,'2026-07-14',0,'Trả đúng hạn'),
(2,2,'2026-07-18',10000,'Trả quá hạn 1 ngày'),
(3,3,'2026-07-19',0,'Trả đúng hạn'),
(4,3,'2026-07-25',30000,'Trả quá hạn'),
(5,4,'2026-07-24',0,'Trả đúng hạn'),
(6,2,'2026-07-30',50000,'Sách bị hỏng'),
(7,3,'2026-07-29',0,'Trả đúng hạn'),
(8,4,'2026-08-05',200000,'Làm mất 1 quyển'),
(9,2,'2026-08-02',10000,'Quá hạn 1 ngày'),
(10,3,'2026-08-05',0,'Trả đúng hạn');

-- =====================================
-- FINES
-- =====================================

INSERT INTO `fines`
(`overdue_days`, `condition_status`, `damage_note`, `fine`)
VALUES
(1, 'Normal', NULL, 5000),
(1, 'Normal', NULL, 5000),

(3, 'Normal', NULL, 15000),
(3, 'Normal', NULL, 15000),

(0, 'Damaged', 'Bìa sách bị rách', 30000),
(0, 'Damaged', 'Trang sách bị nhàu', 20000),

(0, 'Lost', 'Độc giả làm mất sách', 180000),

(1, 'Normal', NULL, 5000),
(1, 'Normal', NULL, 5000);

-- =====================================
-- RETURN_DETAILS (20 chi tiết)
-- =====================================

INSERT INTO `return_details`
(`return_id`, `book_id`, `quantity`, `fine_id`)
VALUES

-- Return 1
(1,1,1,NULL),
(1,11,1,NULL),

-- Return 2
(2,2,1,1),
(2,17,1,2),

-- Return 3
(3,7,1,NULL),
(3,21,1,NULL),

-- Return 4
(4,14,1,3),
(4,29,1,4),

-- Return 5
(5,18,1,NULL),
(5,31,1,NULL),

-- Return 6
(6,9,1,5),
(6,36,1,6),

-- Return 7
(7,10,1,NULL),
(7,37,1,NULL),

-- Return 8
(8,24,1,7),
(8,38,1,8),

-- Return 9
(9,25,1,9),
(9,39,1,10),

-- Return 10
(10,30,1,NULL),
(10,40,1,NULL);

-- =====================================
-- 11. NOTIFICATIONS
-- =====================================

INSERT INTO `notifications`
(`reader_id`, `title`, `content`, `is_read`)
VALUES
(1,'Nhắc trả sách','Sách của bạn sắp đến hạn trả.',0),
(2,'Quá hạn trả sách','Bạn đã quá hạn trả sách, vui lòng trả sớm.',1),
(3,'Đặt sách thành công','Yêu cầu đặt trước của bạn đã được ghi nhận.',1),
(4,'Đặt sách được duyệt','Bạn có thể đến thư viện nhận sách.',0),
(5,'Đặt sách bị hủy','Yêu cầu đặt sách đã bị hủy.',1),
(6,'Đánh giá thành công','Cảm ơn bạn đã đánh giá sách.',1),
(7,'Có sách mới','Thư viện vừa bổ sung nhiều đầu sách mới.',0),
(8,'Gia hạn mượn sách','Yêu cầu gia hạn đã được chấp nhận.',1),
(9,'Tiền phạt','Bạn có khoản tiền phạt cần thanh toán.',0),
(10,'Hoàn tất trả sách','Phiếu trả sách của bạn đã hoàn tất.',1),
(11,'Sách sắp đến hạn','Vui lòng trả sách đúng thời hạn.',0),
(12,'Thông báo hệ thống','Hệ thống sẽ bảo trì lúc 22:00.',1),
(13,'Đặt trước thành công','Đơn đặt trước đã được tiếp nhận.',0),
(14,'Có sách sẵn sàng','Sách bạn đặt đã có sẵn.',1),
(15,'Nhắc trả sách','Còn 2 ngày nữa đến hạn trả.',0),
(16,'Đánh giá sách','Hãy chia sẻ cảm nhận sau khi đọc.',0),
(17,'Thông báo','Cập nhật chính sách mượn sách.',1),
(18,'Đăng nhập thành công','Bạn vừa đăng nhập hệ thống.',1),
(19,'Tài khoản','Thông tin tài khoản đã được cập nhật.',0),
(20,'Chào mừng','Chào mừng bạn đến với Librio.',1);

-- =====================================
-- REVIEWS
-- =====================================

INSERT INTO `reviews`
(`reader_id`, `book_id`, `rating`, `comment`)
VALUES
(1,1,5,'Rất hay, rất xúc động.'),
(2,2,5,'Đưa mình trở về tuổi thơ.'),
(3,7,4,'Tác phẩm thiếu nhi kinh điển.'),
(4,14,5,'Harry Potter mở đầu rất cuốn hút.'),
(5,18,4,'Animal Farm có nội dung sâu sắc và đáng suy ngẫm.'),
(6,21,5,'Clean Code rất hữu ích cho lập trình viên.'),
(7,29,5,'Python Cơ Bản dễ học, nhiều ví dụ.'),
(8,40,5,'Atomic Habits giúp thay đổi thói quen hiệu quả.'),
(9,42,4,'English Grammar In Use rất dễ hiểu.'),
(10,46,5,'Lược Sử Thời Gian cực kỳ thú vị.'),
(11,47,4,'Cosmos trình bày khoa học rất hấp dẫn.'),
(12,48,5,'Sapiens là cuốn sách đáng đọc.'),
(13,49,4,'Homo Deus có nhiều góc nhìn mới.'),
(14,50,5,'21 Bài Học Cho Thế Kỷ 21 rất thực tế.'),
(15,31,4,'Learning SQL phù hợp cho người mới.'),
(16,32,5,'Database System Concepts rất đầy đủ.'),
(17,33,5,'HTML & CSS Design trình bày đẹp và dễ hiểu.'),
(18,34,5,'JavaScript The Definitive Guide rất chi tiết.'),
(19,35,4,'You Don''t Know JS khá chuyên sâu.'),
(20,44,5,'Basic English Conversation rất hữu ích.'),
(1,36,5,'Nguyên Lý Marketing cung cấp kiến thức nền tảng tốt.'),
(2,37,4,'Khởi Nghiệp Tinh Gọn rất phù hợp cho startup.'),
(3,38,5,'Cha Giàu Cha Nghèo thay đổi tư duy tài chính.'),
(4,39,4,'Think And Grow Rich truyền nhiều động lực.'),
(5,44,5,'Basic English Conversation rất phù hợp để luyện giao tiếp.');

-- =====================================
-- RESERVATIONS
-- =====================================

INSERT INTO `reservations`
(`reader_id`, `book_id`, `reservation_date`, `status`)
VALUES
(1,17,'2026-08-01','Pending'),
(2,24,'2026-08-01','Approved'),
(3,29,'2026-08-02','Completed'),
(4,31,'2026-08-02','Cancelled'),
(5,36,'2026-08-03','Pending'),
(6,37,'2026-08-03','Approved'),
(7,38,'2026-08-03','Completed'),
(8,39,'2026-08-04','Pending'),
(9,40,'2026-08-04','Approved'),
(10,41,'2026-08-04','Cancelled'),
(11,48,'2026-08-05','Completed'),
(12,50,'2026-08-05','Pending');

-- =====================================
-- SEARCH_HISTORIES
-- =====================================

INSERT INTO `search_histories`
(`reader_id`, `keyword`)
VALUES
(1,'Harry Potter'),
(1,'Clean Code'),
(1,'PHP'),
(2,'Java'),
(2,'Python'),
(2,'SQL'),
(3,'Nguyễn Nhật Ánh'),
(3,'Mắt Biếc'),
(3,'Đắc Nhân Tâm'),
(4,'IELTS'),
(4,'Cambridge'),
(4,'English'),
(5,'Sapiens'),
(5,'Cosmos'),
(5,'Khoa học'),
(6,'Atomic Habits'),
(6,'Marketing'),
(6,'Kinh tế'),
(7,'HTML'),
(7,'CSS'),
(7,'JavaScript'),
(8,'Database'),
(8,'MySQL'),
(8,'PHP'),
(9,'Clean Architecture'),
(9,'The Clean Coder'),
(9,'Learning SQL'),
(10,'Harry Potter'),
(10,'1984'),
(10,'Animal Farm'),
(11,'Murakami'),
(11,'Kafka'),
(11,'Rừng Na Uy'),
(12,'Stephen King'),
(12,'IT'),
(12,'The Shining'),
(13,'Lão Hạc'),
(13,'Chí Phèo'),
(13,'Nam Cao'),
(14,'Dế Mèn'),
(14,'Tô Hoài'),
(14,'Thiếu nhi'),
(15,'Oxford'),
(15,'Grammar'),
(15,'IELTS'),
(16,'Python'),
(16,'Java'),
(16,'PHP'),
(17,'SQL'),
(17,'Database'),
(17,'Clean Code'),
(18,'Marketing'),
(18,'Atomic Habits'),
(18,'Think And Grow Rich'),
(19,'Harry Potter'),
(19,'Nhà Giả Kim'),
(19,'Sapiens'),
(20,'HTML'),
(20,'CSS'),
(20,'JavaScript');

-- =====================================
-- FAVORITES
-- =====================================

INSERT INTO `favorites`
(`reader_id`, `book_id`)
VALUES
(1,1),
(1,24),
(2,2),
(2,29),
(3,7),
(3,48),
(4,14),
(4,31),
(5,18),
(5,50),
(6,21),
(6,36),
(7,37),
(7,43),
(8,38),
(8,41),
(9,39),
(9,45),
(10,40),
(10,50),
(11,41),
(12,42),
(13,44),
(14,45),
(15,46),
(16,47),
(17,48),
(18,49),
(19,49),
(20,48);