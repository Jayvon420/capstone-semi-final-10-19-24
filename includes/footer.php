        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; All rights reserve Dela Rosa & Orito 2024</div>
                    <div>
                        <a href="##">Privacy Policy</a>
                        &middot;
                        <a href="##">Terms &amp; Conditions</a>
                    </div>
                </div>
            </div>
        </footer>

            <!-- SIDE NAV content END -->
        </div> 
        <!-- SIDE NAV END -->
    </div>



<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>


<!-- Add JavaScript to populate the Add Item modal -->
<script>
    document.querySelectorAll('.addItemBtn').forEach(button => {
        button.addEventListener('click', () => {
            const productId = button.getAttribute('data-id');
            const productName = button.getAttribute('data-name');
            const productQuantity = button.getAttribute('data-quantity');

            document.getElementById('addProductId').value = productId;
            document.getElementById('addProductName').value = productName;
            document.getElementById('currentQuantity').value = productQuantity;
        });
    });

    document.querySelectorAll('.sellBtn').forEach(button => {
        button.addEventListener('click', () => {
            const productId = button.getAttribute('data-id');
            const productName = button.getAttribute('data-name');
            const productQuantity = button.getAttribute('data-quantity');

            document.getElementById('sellProductId').value = productId;
            document.getElementById('sellProductName').value = productName;
            document.getElementById('sellAvailableQuantity').value = productQuantity;
        });
    });
</script>

    <!-- JavaScript to populate the sell Item modal -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var sellButtons = document.querySelectorAll('.sellBtn');

            sellButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var productId = this.getAttribute('data-id');
                    var productName = this.getAttribute('data-name');
                    var productQuantity = this.getAttribute('data-quantity');

                    // Populate the modal fields
                    document.getElementById('sellProductId').value = productId;
                    document.getElementById('sellProductName').value = productName;
                    document.getElementById('sellAvailableQuantity').value = productQuantity;
                    document.getElementById('quantityToSell').max = productQuantity;
                });
            });
        });
    </script>


<!-- categories where catergory clear when user type in add new category -->
<script>
    // Clear the selected category when typing in the "Or Add New Category" field
    document.getElementById('newCategory').addEventListener('input', function() {
        document.getElementById('productCategory').selectedIndex = 0;
    });

    // Validate form to ensure a category is selected or a new one is entered
    function validateForm() {
        var categoryDropdown = document.getElementById('productCategory');
        var newCategoryInput = document.getElementById('newCategory').value.trim();

        // Ensure either a new category is entered or an existing one is selected
        if (newCategoryInput === "" && categoryDropdown.selectedIndex === 0) {
            alert("Please select an existing category or enter a new one.");
            return false; // Prevent form submission
        }
        return true;
    }
</script>


<!-- bargraph script -->

<script>

    document.addEventListener('DOMContentLoaded', function () {
    fetch('getProductData.php')
        .then(response => response.json())
        .then(data => {
            var ctx = document.getElementById('productBarChart').getContext('2d');
            var productCount = data.labels.length;

            // Adjust chart width dynamically based on the number of products
            function adjustChartWidth(count) {
                var chartCanvas = document.getElementById('productBarChart');
                if (count > 10) {
                    chartCanvas.style.width = count * 100 + 'px'; // 100px per product for wider charts
                } else {
                    chartCanvas.style.width = '100%'; // Default width for 10 or fewer products
                }
            }

            // Adjust the chart width based on product count
            adjustChartWidth(productCount);

            // Determine the background colors based on quantity
            const backgroundColors = data.data.map(quantity => {
                if (quantity <= 2) {
                    return 'rgba(255, 99, 132, 0.2)'; // Red
                } else if (quantity <= 5) {
                    return 'rgba(255, 159, 64, 0.2)'; // Orange
                } else {
                    return 'rgba(75, 192, 192, 0.2)'; // Green
                }
            });

            const borderColors = backgroundColors.map(color => color.replace('0.2', '1')); // Border color same as background color

            var myBarChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Quantity of Products',
                        data: data.data,
                        backgroundColor: backgroundColors,
                        borderColor: borderColors,
                        borderWidth: 2
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching data:', error));
});

</script>

<!-- bar graph end -->



<!-- validition of category kung add new categoy ignore select category if Input sa add new category bypass the select category -->

<script>
function validateForm() {
    const productCategory = document.getElementById('productCategory');
    const newCategory = document.getElementById('newCategory');

    // If new category is provided, clear any validation error for the product category
    if (newCategory.value.trim() !== "") {
        productCategory.setCustomValidity('');
    }

    // If both newCategory and productCategory are empty, prevent form submission
    if (newCategory.value.trim() === "" && productCategory.value === "") {
        productCategory.setCustomValidity('Please select an existing category or enter a new one.');
        productCategory.reportValidity();
        return false;
    }

    return true; // Allow form submission if validation passes
}
</script>
<!-- validittion of categoy end -->

<!-- script for zero value not accepted -->
<script>
function validateForm() {
    const quantityInput = document.getElementById('productQty');
    const quantity = quantityInput.value;

    // Check if the quantity starts with a zero or is less than or equal to zero
    if (quantity.startsWith('0') || quantity <= 0) {
        // Set a custom validation message
        quantityInput.setCustomValidity('Quantity must be a positive number and cannot start with zero.');
        
        // Trigger the invalid event to show the message
        quantityInput.reportValidity();
        
        return false; // Prevent form submission
    } else {
        // Clear the custom validation message if the input is valid
        quantityInput.setCustomValidity('');
    }

    return true; // Allow form submission if validation passes
}

// Add an event listener to clear the validation message when the input changes
document.getElementById('productQty').addEventListener('input', function() {
    this.setCustomValidity('');
});
</script>
<!-- script for zero value not accepted end -->


<script>
    $(document).ready( function () {
            $('#myTable').DataTable();
    });
</script>

<!-- Include SweetAlert for deleting-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.deleteBtn').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default button action

            const form = this.closest('.deleteForm'); // Get the closest form element

            Swal.fire({
                title: 'Are you sure?',
                text: "Are you sure you want to delete this data?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const input = document.createElement('input'); // Create a new input element
                    input.type = 'hidden';
                    input.name = 'deleteProduct'; // Set the name attribute
                    form.appendChild(input); // Append the input to the form

                    form.submit(); // Submit the form if confirmed
                }
            });
        });
    });
</script>


<!-- delete sweet alert -->




<script src="js/scripts.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    </body>
</html>