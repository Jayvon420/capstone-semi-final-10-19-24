<?php
require 'dbcon.php';

if (isset($_POST['product_id'], $_POST['sell_quantity'])) {
    $product_id = $_POST['product_id'];
    $sell_quantity = intval($_POST['sell_quantity']);

    // Fetch current quantity
    $query = "SELECT quantity, name FROM products WHERE id = '$product_id'";
    $query_run = mysqli_query($con, $query);
    $product = mysqli_fetch_assoc($query_run);

    if ($product) {
        // Ensure the product name is retrieved
        $product_name = $product['name'];

        if ($sell_quantity > 0 && $sell_quantity <= $product['quantity']) {
            $new_quantity = $product['quantity'] - $sell_quantity;

            // Update the quantity in the database
            $update_query = "UPDATE products SET quantity = '$new_quantity' WHERE id = '$product_id'";
            if (mysqli_query($con, $update_query)) {
                // Log the sale in the transaction history
                $log_query = "INSERT INTO transaction_history (product_id, product_name, action, quantity, date_time) VALUES ('$product_id', '$product_name', 'Out', '$sell_quantity', NOW())";
                mysqli_query($con, $log_query);

                // Redirect back to the product list with a success message
                header("Location: index.php?message=Product sold successfully!");
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

<?php include("includes/footer.php") ?>
