<?php include("includes/header.php")?>
<?php include("includes/navBar.php")?>
<?php include("includes/sideNav.php")?>

<div class="px-4">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="my-5">Inventory System</h1>
       <a href="javascript:void(0);" class="my-5 button" onclick="window.history.back();">
            <i class="h1 text-dark fa-solid fa-arrow-left"></i>
        </a>

    </div>

<!-- Add Product Form -->
<form action="code.php" method="POST" onsubmit="return validateForm()">
    <?php include('alerts/fail.php'); ?>
    <?php include('alerts/message.php'); ?>
    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="productName"><strong>Product Name</strong></label>
                <input type="text" class="form-control" id="productName" name="name" required>
            </div>
        </div>
        <div class="col-md-2"> 
            <div class="form-group">  
                <label for="productQty"><strong>Quantity</strong></label>
                <input type="number" class="form-control" id="productQty" name="quantity" required>
            </div>
        </div>
    </div>

    <!-- Category Selection -->
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="productCategory"><strong>Category</strong></label>
                <select class="form-control" id="productCategory" name="category_id">
                    <option value="" disabled selected>Select a Category</option>
                    <?php
                    // Fetch categories from the database
                    $categories = mysqli_query($con, "SELECT * FROM categories");
                    while($row = mysqli_fetch_assoc($categories)) {
                        echo "<option value='{$row['id']}'>{$row['cat_name']}</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="newCategory"><strong>Or Add New Category</strong></label>
                <input type="text" class="form-control" id="newCategory" name="new_category" placeholder="Enter New Category">
            </div>
        </div>
    </div>

    <!-- Submit Button -->
    <div class="my-4">
        <button type="submit" name="add_product" class="btn btn-success">Add Item</button>
    </div>
</form>


<!-- Display Products -->
<h2>Product List</h2>
    <div class="table-responsive">
        <table class="table table-striped table-bordered" id="myTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Category</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // Query to include category information
                    $query = "SELECT products.id, products.name, products.quantity, categories.cat_name
                              FROM products 
                              INNER JOIN categories ON products.category_id = categories.id";

                    $query_run = mysqli_query($con, $query);

                    if (!$query_run) {
                        echo "Error: " . mysqli_error($con);
                        exit();
                    }

                    if (mysqli_num_rows($query_run) > 0) {
                        foreach ($query_run as $product) {
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($product['id']) ?></td>
                                <td><strong><?= htmlspecialchars($product['name']) ?></strong></td>
                                <td><?= htmlspecialchars($product['quantity']) ?></td>
                                <td><?= htmlspecialchars($product['cat_name']) ?></td>
                                <td class="text-center">
                                    <a class="btn btn-success btn-sm" href="updateProduct.php?id=<?= $product['id'] ?>">Update</a>
                                <form action="code.php" method="POST" class="d-inline deleteForm">
                                    <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']); ?>"> <!-- Escaping product ID -->
                                    <button type="button" class="btn btn-danger btn-sm deleteBtn">Delete</button>
                                </form>
                                    <button type="button" class="btn btn-info btn-sm addItemBtn" 
                                            data-id="<?= $product['id'] ?>" 
                                            data-name="<?= htmlspecialchars($product['name']) ?>" 
                                            data-quantity="<?= htmlspecialchars($product['quantity']) ?>" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#addItemModal">Add
                                    </button>
                                    <button type="button" class="btn btn-warning btn-sm sellBtn" 
                                            data-id="<?= $product['id'] ?>" 
                                            data-name="<?= htmlspecialchars($product['name']) ?>" 
                                            data-quantity="<?= htmlspecialchars($product['quantity']) ?>" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#sellModal">Out
                                    </button>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>



    <!-- Modal for Adding Item -->
<div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="addItemModalLabel">Add Item Quantity</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <!-- Modal Body with the form -->
      <div class="modal-body">
        <form action="addItem.php" method="POST">
          
          <input type="hidden" name="product_id" id="addProductId">

          <div class="mb-3">
            <label for="addProductName" class="form-label"><strong>Product Name</strong></label>
            <input type="text" class="form-control" id="addProductName" readonly>
          </div>

          <div class="mb-3">
            <label for="currentQuantity" class="form-label"><strong>Current Quantity</strong></label>
            <input type="number" class="form-control" id="currentQuantity" readonly>
          </div>

          <div class="mb-3">
            <label for="quantityToAdd" class="form-label"><strong>Quantity to Add</strong></label>
            <input type="number" class="form-control" id="quantityToAdd" name="add_quantity" min="1" required>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Confirm Add</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

    <!-- Modal for Selling Product -->
    <div class="modal fade" id="sellModal" tabindex="-1" aria-labelledby="sellModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          
          <!-- Modal Header -->
          <div class="modal-header">
            <h5 class="modal-title" id="sellModalLabel">Sell Product</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          
          <!-- Modal Body with the form -->
          <div class="modal-body">
            <form action="sellProduct.php" method="POST">
              
              <!-- Hidden input to store product ID -->
              <input type="hidden" name="product_id" id="sellProductId">

              <!-- Display the product name -->
              <div class="mb-3">
                <label for="sellProductName" class="form-label"><strong>Product Name</strong></label>
                <input type="text" class="form-control" id="sellProductName" readonly>
              </div>

              <!-- Display the available quantity -->
              <div class="mb-3">
                <label for="sellQuantity" class="form-label"><strong>Quantity Available</strong></label>
                <input type="number" class="form-control" id="sellAvailableQuantity" readonly>
              </div>

              <!-- Input to allow the user to specify how many units to sell -->
              <div class="mb-3">
                <label for="quantityToSell" class="form-label"><strong>Quantity to Sell</strong></label>
                <input type="number" class="form-control" id="quantityToSell" name="sell_quantity" min="1" required>
              </div>

              <!-- Modal footer with action buttons -->
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Confirm Sell</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div><div class="modal fade" id="sellModal" tabindex="-1" aria-labelledby="sellModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      
      <!-- Modal Header -->
      <div class="modal-header">
        <!-- Title of the Modal -->
        <h5 class="modal-title" id="sellModalLabel">Sell Product</h5>
        <!-- Close button for the modal -->
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <!-- Modal Body where the form is placed -->
      <div class="modal-body">
        <!-- Form that sends data to sellProduct.php for processing the sale -->
        <form action="sellProduct.php" method="POST">
          
          <!-- Hidden input to store the product ID (needed to update the correct product) -->
          <input type="hidden" name="product_id" id="sellProductId">

          <!-- Display the product name in a read-only input field -->
          <div class="mb-3">
            <label for="sellProductName" class="form-label"><strong>Product Name</strong></label>
            <!-- This input is populated with the product name using JavaScript (readonly to prevent editing) -->
            <input type="text" class="form-control" id="sellProductName" readonly>
          </div>

          <!-- Display the available quantity of the product in a read-only input field -->
          <div class="mb-3">
            <label for="sellQuantity" class="form-label"><strong>Quantity Available</strong></label>
            <!-- This input is populated with the available quantity using JavaScript (readonly to prevent editing) -->
            <input type="number" class="form-control" id="sellAvailableQuantity" readonly>
          </div>

          <!-- Input to allow the user to specify how many units of the product they want to sell -->
          <div class="mb-3">
            <label for="quantityToSell" class="form-label"><strong>Quantity to Sell</strong></label>
            <!-- The user inputs the quantity they want to sell. Ensure the value is between 1 and the available quantity. -->
            <input type="number" class="form-control" id="quantityToSell" name="sell_quantity" min="1" required>
          </div>

          <!-- Modal Footer with action buttons -->
          <div class="modal-footer">
            <!-- Button to close the modal without making changes -->
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <!-- Button to submit the form and process the sale -->
            <button type="submit" class="btn btn-primary">Confirm Sell</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>


<!-- modal code end -->



</div>

<?php include("includes/footer.php")?>

