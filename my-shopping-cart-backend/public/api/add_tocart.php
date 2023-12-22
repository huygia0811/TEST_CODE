<?php
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Nhận dữ liệu từ yêu cầu POST
    $productId = isset($_GET['product_id']) ? $_GET['product_id'] : null;

    // Kiểm tra xem product_id đã được chuyển đúng chưa
    if ($productId === null) {
        echo json_encode(['error' => 'Product ID is required']);
        die(); // Dừng thực hiện mã khi có lỗi
    }

    // Thực hiện truy vấn SQL
    $conn->query("INSERT INTO cart (product_id, quantity) VALUES ($productId, 1)");

    // Trả về thông báo hoặc dữ liệu khác nếu cần
    echo json_encode(['message' => 'Product added to cart successfully']);
} else {
    header('HTTP/1.1 405 Method Not Allowed');
}
?>
