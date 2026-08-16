// Tạo biểu đồ cột thống kê lượt mượn và trả sách theo tháng bằng Chart.js
document.addEventListener("DOMContentLoaded", function () {
    // Lấy thẻ canvas để vẽ biểu đồ
    const canvas = document.getElementById("borrowReturnChart");

    // Nếu không có canvas hoặc Chart.js chưa tải → dừng
    if (!canvas || typeof Chart === "undefined") {
        return;
    }

    // Lấy tên các tháng
    const labels = borrowReturnData.map(item => item.month_name);

    // Lấy số lượt mượn
    const borrowData = borrowReturnData.map(item => {
        return Number(item.borrow_count);
    });

    // Lấy số lượt trả
    const returnData = borrowReturnData.map(item => {
        return Number(item.return_count);
    });

    // Tạo biểu đồ dạng cột
    new Chart(canvas, {
        type: "bar", // Biểu đồ cột

        data: {
            labels: labels,
            
            // 2 cột "Lượt mượn" và "Lượt trả"
            datasets: [
                {
                    label: "Lượt mượn",
                    data: borrowData,
                    backgroundColor: "#3975db",
                    borderRadius: 5,
                    barPercentage: 0.65,
                    categoryPercentage: 0.7
                },

                {
                    label: "Lượt trả",
                    data: returnData,
                    backgroundColor: "#20a486",
                    borderRadius: 5,
                    barPercentage: 0.65,
                    categoryPercentage: 0.7
                }
            ]
        },

        // Cấu hình biểu đồ
        options: {
            responsive: true,           // Biểu đồ tự co giãn theo kích thước màn hình
            maintainAspectRatio: false, // Không giữ tỷ lệ mặc định, cho phép CSS quyết định chiều cao
            interaction: {
                mode: "index",          // Hover vào một tháng → hiện dữ liệu cả mượn và trả
                intersect: false        // Không cần rê chuột đúng vào cột vẫn hiện tooltip
            },

            plugins: {
                // Cấu hình chú thích
                legend: {
                    position: "top",

                    labels: {
                        boxWidth: 10,
                        boxHeight: 10,
                        padding: 15,
                        font: {
                            size: 13
                        }
                    }
                },
                
                // Cấu hình tooltip
                tooltip: {
                    padding: 10
                }

            },

            // Cấu hình trục x/y
            scales: {
                x: {
                    grid: {
                        display: false
                    },

                    ticks: {
                        color: "#777",
                        font: {
                            size: 12
                        }
                    }
                },

                y: {
                    beginAtZero: true,

                    ticks: {
                        precision: 0,
                        color: "#777",
                        font: {
                            size: 12
                        }
                    },

                    grid: {
                        color: "#edf0f3"
                    }
                }
            }
        }
    });
});