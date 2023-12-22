<?php
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = isset($_GET['product_id']) ? $_GET['product_id'] : null;
    $action = isset($_GET['action']) ? $_GET['action'] : null;

    // Kiểm tra xem product_id và action đã được chuyển đúng chưa
    if ($productId === null || $action === null) {
        echo json_encode(['error' => 'Product ID and action are required']);
        die(); // Dừng thực hiện mã khi có lỗi
    }

    // Thực hiện truy vấn SQL theo action
    if ($action === 'increase') {
        $conn->query("UPDATE cart SET quantity = quantity + 1 WHERE product_id = $productId");
    } elseif ($action === 'decrease') {
        $conn->query("UPDATE cart SET quantity = GREATEST(quantity - 1, 0) WHERE product_id = $productId");

        // Kiểm tra số lượng, nếu bằng 0 thì xóa sản phẩm khỏi giỏ hàng
        $result = $conn->query("SELECT quantity FROM cart WHERE product_id = $productId");
        $row = $result->fetch_assoc();
        if ($row['quantity'] == 0) {
            $conn->query("DELETE FROM cart WHERE product_id = $productId");
        }
    } elseif ($action === 'delete') {
        // Xóa sản phẩm khỏi giỏ hàng
        $conn->query("DELETE FROM cart WHERE product_id = $productId");
    }

    // Trả về thông báo hoặc dữ liệu khác nếu cần
    echo json_encode(['message' => 'Action completed successfully']);
} else {
    header('HTTP/1.1 405 Method Not Allowed');
}
?>
