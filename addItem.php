<?php

require 'dbcon.php';

if (isset($_POST['product_id'], $_POST['add_quantity'])) {
    $product_id = $_POST['product_id'];
    $add_quantity = intval($_POST['add_quantity']);

    // Fetch current quantity and product name
    $query = "SELECT quantity, name FROM products WHERE id = '$product_id'";
    $query_run = mysqli_query($con, $query);
    $product = mysqli_fetch_assoc($query_run);

    if ($product) {
        $product_name = $product['name']; // Get product name for logging

        if ($add_quantity > 0) {
            $new_quantity = $product['quantity'] + $add_quantity;

            // Update the quantity in the database
            $update_query = "UPDATE products SET quantity = '$new_quantity' WHERE id = '$product_id'";
            if (mysqli_query($con, $update_query)) {
                // Log the addition in the transaction history
                $log_query = "INSERT INTO transaction_history (product_id, product_name, action, quantity, date_time) VALUES ('$product_id', '$product_name', 'Added', '$add_quantity', NOW())";
                mysqli_query($con, $log_query);

                // Redirect back to the product list with a success message
                header("Location: index.php?message=Product quantity added successfully!");
                exit;
            } else {
                echo "Error updating product: " . mysqli_error($con);
            }
        } else {
            echo "Invalid quantity!";
        }
    } else {
        echo "Product not found!";
    }
}

?>

<?php include("includes/footer.php"); ?>
