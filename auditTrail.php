<?php include("includes/header.php")?>
<?php include("includes/navBar.php")?>
<?php include("includes/sideNav.php")?>
<?php
$history_query = "SELECT * FROM transaction_history ORDER BY date_time DESC";
$history_result = mysqli_query($con, $history_query);
?>


<div class="container-fluid px-4">
<!-- Transaction History Section -->
<div class="d-flex justify-content-between align-items-center">
        <h1 class="my-5">Transaction History</h1>
       <a href="javascript:void(0);" class="my-5 button" onclick="window.history.back();">
            <i class="h1 text-dark fa-solid fa-arrow-left"></i>
        </a>

    </div>
<div class="table-responsive">
    <table class="table table-striped table-bordered" id="myTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Action</th>
                <th>Quantity</th>
                <th>Date and Time</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $history_query = "SELECT * FROM transaction_history ORDER BY date_time DESC";
            $history_result = mysqli_query($con, $history_query);

            if (mysqli_num_rows($history_result) > 0) {
                while ($history = mysqli_fetch_assoc($history_result)) {
                    echo "<tr>";
                    echo "<td>" . $history['id'] . "</td>";
                    echo "<td>" . $history['product_name'] . "</td>";
                    echo "<td>" . $history['action'] . "</td>";
                    echo "<td>" . $history['quantity'] . "</td>";
                    echo "<td>" . $history['date_time'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='text-center'>No transaction history available.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</div>

<?php include("includes/footer.php")?>