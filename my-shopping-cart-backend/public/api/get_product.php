<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

require_once '../../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $result = $conn->query("SELECT * FROM product");
    $products = array();

    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($products);
} else {
    header('HTTP/1.1 405 Method Not Allowed');
}
?>
