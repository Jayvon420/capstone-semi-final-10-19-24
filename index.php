
<?php include("includes/header.php")?>
<?php include("includes/navBar.php")?>
<?php include("includes/sideNav.php")?>

            <!-- main content -->
            <main>
                <div class="container-fluid px-4">

                    <h1 class="mt-4">Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>

                    <div class="row justify-content-between">
                        <div class="col-xl-6 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">Add Product</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="addProduct.php">See more..</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body">Reports</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="report.php">See more..</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>  

                    <!-- bar graph -->

                        <div class="col-xl-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-bar me-1"></i>
                                    Bar Chart Example
                                </div>
                                <div class="card-body">
                                    <!-- Add a scrollable container for the bar chart -->
                                    <div id="productBarChartContainer" style="overflow-x: auto;">
                                        <canvas id="productBarChart" width="100%" height="40"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                  
                    <!-- add content here or table bar graphs etc... -->
                    
                </div>    
            </main>
            <!-- main content -->

<?php include("includes/footer.php")?>