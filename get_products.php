<?php
include 'db_config.php';

$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 1;

$sql = "SELECT IId, Name, Description, 0 AS Price, 'E:/pics/' + CAST(IId AS VARCHAR) + '.jpg' AS ImagePath 
        FROM Item 
        WHERE CategoryId = ?";
$params = array($category_id);
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

$products = [];
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $products[] = $row;
}

header('Content-Type: application/json');
echo json_encode($products);

sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>
