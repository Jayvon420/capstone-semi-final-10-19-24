<?php
session_start();
require 'dbcon.php';

// Handle form submission for adding a product
if (isset($_POST['add_product'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $quantity = mysqli_real_escape_string($con, $_POST['quantity']);
    $categoryId = mysqli_real_escape_string($con, $_POST['category_id']);
    $newCategory = mysqli_real_escape_string($con, trim($_POST['new_category']));

    // Check if new category is provided
    if (!empty($newCategory)) {
        // Check if the category already exists
        $check_query = "SELECT * FROM categories WHERE cat_name = '$newCategory'";
        $check_result = mysqli_query($con, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            $_SESSION['error'] = "Category already exists!";
        } else {
            // Insert new category
            $query = "INSERT INTO categories (cat_name) VALUES ('$newCategory')";
            $query_run = mysqli_query($con, $query);

            if ($query_run) {
                $_SESSION['message'] = "Category added successfully!";
                $categoryId = mysqli_insert_id($con); // Get the ID of the newly added category
            } else {
                $_SESSION['error'] = "Failed to add category!";
                header("Location: addProduct.php");
                exit(0);
            }
        }
    }

    // If no new category is added, use the selected category
    if (empty($newCategory) && empty($categoryId)) {
        $_SESSION['error'] = "Please select an existing category.";
        header("Location: addProduct.php");
        exit(0);
    }

    // Check if the product already exists within the same category
    $checkQuery = "SELECT * FROM products WHERE name = '$name' AND category_id = '$categoryId'";
    $checkResult = mysqli_query($con, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        $_SESSION['error'] = "Product already exists in the selected category.";
        header("Location: addProduct.php");
        exit(0);
    } 

    // Insert new product
    $query = "INSERT INTO products (name, quantity, category_id) VALUES ('$name', '$quantity', '$categoryId')";
    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        $product_id = mysqli_insert_id($con); // Get the ID of the newly added product

        // Log the addition in transaction history
        $log_query = "INSERT INTO transaction_history (product_id, product_name, action, quantity) VALUES ('$product_id', '$name', 'Added', '$quantity')";
        mysqli_query($con, $log_query);

        $_SESSION['message'] = "Product added successfully!";
    } else {
        $_SESSION['fail'] = "Failed to add product!";
    }

    header("Location: addProduct.php");
    exit(0);
}

// End of product addition =======================================================>

// Handle form submission for updating a product
if (isset($_POST['updateProduct'])) {
    $product_id = mysqli_real_escape_string($con, $_POST['product_id']);
    $product_name = mysqli_real_escape_string($con, $_POST['name']);
    $product_quantity = mysqli_real_escape_string($con, $_POST['quantity']);
    $category_id = mysqli_real_escape_string($con, $_POST['category_id']);

    // Fetch current category of the product
    $query = "SELECT category_id FROM products WHERE id='$product_id'";
    $result = mysqli_query($con, $query);
    $current_category = mysqli_fetch_assoc($result)['category_id'];

    // Check if the product name already exists in the same category
    $duplicate_query = "SELECT * FROM products WHERE name='$product_name' AND category_id='$category_id' AND id != '$product_id'";
    $duplicate_result = mysqli_query($con, $duplicate_query);

    if (mysqli_num_rows($duplicate_result) > 0) {
        $_SESSION['error'] = "Product name already exists in this category!";
        header("Location: updateProduct.php?id=$product_id");
        exit(0);
    }

    // Update the product
    $update_query = "UPDATE products SET name='$product_name', quantity='$product_quantity', category_id='$category_id' WHERE id='$product_id'";
    $update_result = mysqli_query($con, $update_query);

    if ($update_result) {
        // Log the update in transaction history
        $log_query = "INSERT INTO transaction_history (product_id, product_name, action, quantity) VALUES ('$product_id', '$product_name', 'Updated', '$product_quantity')";
        mysqli_query($con, $log_query);

        $_SESSION['message'] = "Product updated successfully!";
        header("Location: addProduct.php");
        exit(0);
    } else {
        $_SESSION['error'] = "Failed to update product!";
        header("Location: updateProduct.php?id=$product_id");
        exit(0);
    }
}

// End of product update =========================================================>

if (isset($_POST['deleteProduct'])) {
    $product_id = mysqli_real_escape_string($con, $_POST['product_id']);

    // Get product details before deletion for logging
    $get_product_query = "SELECT * FROM products WHERE id='$product_id'";
    $product_result = mysqli_query($con, $get_product_query);
    $product = mysqli_fetch_assoc($product_result);

    if ($product) {
        $product_name = $product['name'];
        $quantity = $product['quantity'];

        // Log the deletion in the transaction history
        $log_query = "INSERT INTO transaction_history (product_id, product_name, quantity, action, date_time) 
                      VALUES ('$product_id', '$product_name', '$quantity', 'Deleted', NOW())";
        mysqli_query($con, $log_query);
    }

    // Proceed with deleting the product
    $delete_query = "DELETE FROM products WHERE id='$product_id'";
    $delete_result = mysqli_query($con, $delete_query);

    if ($delete_result) {
        $_SESSION['message'] = "Product deleted successfully!";
        header("Location: addProduct.php");
        exit(0);
    } else {
        $_SESSION['error'] = "Error deleting product!";
        header("Location: addProduct.php");
        exit(0);
    }
}


// End of product deletion =======================================================>
?>
