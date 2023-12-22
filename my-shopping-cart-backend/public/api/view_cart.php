<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

require_once '../../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Thực hiện truy vấn SQL để lấy thông tin giỏ hàng và tổng giá tiền
    $result = $conn->query("SELECT p.color, p.image, c.product_id, p.name, p.price, c.quantity, (p.price * c.quantity) as total_price
                            FROM cart c
                            JOIN product p ON c.product_id = p.id");

    // Tính tổng giá tiền
    $totalPrice = 0;
    $cartItems = [];
    while ($row = $result->fetch_assoc()) {
        $row['total_price'] = number_format($row['total_price'], 2); // Định dạng tổng giá tiền
        $cartItems[] = $row;
        $totalPrice += $row['total_price'];
    }

    // Định dạng tổng giá tiền
    $totalPrice = number_format($totalPrice, 2);

    // Trả về mảng JSON chứa thông tin giỏ hàng và tổng giá tiền
    echo json_encode(['cart_items' => $cartItems, 'total_price' => $totalPrice]);
} else {
    header('HTTP/1.1 405 Method Not Allowed');
}
?>
