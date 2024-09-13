<?php
header('Content-Type: application/json');

$products = [
    ['id' => 2, 'name' => "Organic Banana", 'price' => 0.99, 'description' => "Fresh organic bananas"],
    ['id' => 3, 'name' => "Organic Carrot", 'price' => 0.99, 'description' => "Crunchy organic carrots"],
    ['id' => 4, 'name' => "Organic Lettuce", 'price' => 0.60, 'description' => "Fresh organic lettuce"],
    ['id' => 14, 'name' => "Mango Juice", 'price' => 5.99, 'description' => "Fresh organic mango juice"],
    ['id' => 15, 'name' => "Lemon Juice", 'price' => 4.99, 'description' => "Fresh organic lemon juice"],
    ['id' => 16, 'name' => "Strawberry Juice", 'price' => 6.49, 'description' => "Fresh organic strawberry juice"],
    ['id' => 23, 'name' => "Organic Face Cream", 'price' => 10.0, 'description' => "Nourishing organic face cream"],
    ['id' => 25, 'name' => "Organic Sunscreen", 'price' => 8.0, 'description' => "Protective organic sunscreen"],
    ['id' => 26, 'name' => "Scalp Treatment", 'price' => 8.0, 'description' => "Organic scalp treatment product"],
    ['id' => 27, 'name' => "Nourishing Hair Oil", 'price' => 10.0, 'description' => "Organic nourishing hair oil"],
    ['id' => 29, 'name' => "Organic Body Lotion", 'price' => 8.0, 'description' => "Hydrating organic body lotion"],
    ['id' => 30, 'name' => "Organic Hair Spray", 'price' => 10.0, 'description' => "Description of Organic Hair Spray"]
];

echo json_encode($products);
?>
