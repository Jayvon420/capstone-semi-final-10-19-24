<?php include("includes/header.php")?>
<?php include("includes/navBar.php")?>
<?php include("includes/sideNav.php")?>

<div class="px-4">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="my-5">Product Update</h1>
        <a href="javascript:void(0);" class="my-5 button" onclick="window.history.back();">
            <i class="h1 text-dark fa-solid fa-arrow-left"></i>
        </a>

    </div>

    <?php
    if (isset($_GET['id'])) {
        $product_id = mysqli_real_escape_string($con, $_GET['id']);
        $query = "SELECT * FROM products WHERE id='$product_id'";
        $query_run = mysqli_query($con, $query);

        if (mysqli_num_rows($query_run) > 0) {
            $product = mysqli_fetch_array($query_run);

            // Fetch categories for the dropdown
            $categories_query = "SELECT * FROM categories";
            $categories_result = mysqli_query($con, $categories_query);
    ?>
    
    <!-- form inside the php -->
    <form action="code.php" method="POST">
        <?php include('alerts/fail.php'); ?>
        <?php include('alerts/message.php'); ?>
        
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="productID"></label>
                    <input type="hidden" name="product_id" value="<?= $product_id ?>">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="productName">Product Name</label>
                    <input type="text" class="form-control" id="productName" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="productQty">Quantity</label>
                    <input type="number" class="form-control" id="productQty" name="quantity" value="<?= htmlspecialchars($product['quantity']) ?>" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="productCategory">Category</label>
                    <select class="form-control" id="productCategory" name="category_id" required>
                        <option value="" disabled>Select a Category</option>
                        <?php
                        while ($row = mysqli_fetch_assoc($categories_result)) {
                            $selected = ($row['id'] == $product['category_id']) ? 'selected' : '';
                            echo "<option value='{$row['id']}' $selected>{$row['cat_name']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="my-2">
            <button type="submit" name="updateProduct" class="btn btn-success">Update</button>
        </div>
    </form>
    <!-- form inside the php end -->

    <?php
        } else {
            echo "<h3>No such ID found</h3>";
        }
    }
    ?>
</div>

<?php include("includes/footer.php")?>
