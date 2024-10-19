<?php
// getProductData.php

// Database connection
$con = mysqli_connect("localhost","root","","inventorydb");

if(!$con){
    die('Connection Failed' . mysqli_connect_error());
}

// Fetch product data
$query = "SELECT name, quantity FROM products";
$result = mysqli_query($con, $query);

$products = [];
$quantities = [];

while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row['name'];
    $quantities[] = $row['quantity'];
}

mysqli_close($con);

// Output data as JSON
echo json_encode([
    'labels' => $products,
    'data' => $quantities
]);
?>