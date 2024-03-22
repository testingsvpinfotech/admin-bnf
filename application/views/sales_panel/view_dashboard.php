   <?php include('admin_shared/admin_header.php'); ?>
    <!-- END Head-->

    <!-- START: Body-->
    <body id="main-container" class="default">
       
        <!-- END: Main Menu-->
		<?php include('admin_shared/admin_sidebar.php'); ?>
        <!-- END: Main Menu-->
		
        <!-- START: Main Content-->
        <main>
            <div class="container-fluid site-width">
                <!-- START: Breadcrumbs-->
                <div class="row">
                    <div class="col-12  align-self-center">
                        <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
                            <div class="w-sm-100 mr-auto"><h6 class="mb-0">Dashboard</h6> <p>Welcome to admin panel</p></div>
                            <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- END: Breadcrumbs-->

                <!-- START: Card Data-->
            <div class="row"> 
                <div class="col-12 col-md-4 col-lg-4 mt-3">
                    <div class="card">                            
                        <div class="card-content">
                            <div class="card-body">  
                                
                              <h6>Total FTL Request</h6>
                              <h5><?php echo $total_ftl_request_data->total; ?></h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4 col-lg-4 mt-3">
                    <div class="card">                            
                        <div class="card-content">
                            <div class="card-body">  
                                
                              <h6>Total Customer</h6>
                              <h5><?php echo $total_customer->total1 ; ?></h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4 col-lg-4 mt-3">
                    <div class="card">                            
                        <div class="card-content">
                            <div class="card-body">  
                                
                              <h6>Today Approved FTL</h6>
                              <h5></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row"> 
               
               <div class="col-12 col-md-4 col-lg-4 mt-3">
                    <div class="card">                            
                        <div class="card-content">
                            <div class="card-body">  
                                
                              <h6>Today Cancel FTL</h6>
                              <h5></h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4 col-lg-4 mt-3">
                    <div class="card">                            
                        <div class="card-content">
                            <div class="card-body">  
                                
                              <h6>Today Pending FTL</h6>
                              <h5></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row"> 
                    <div class="col-12 col-md-6 col-lg-4 mt-3">
                        <div class="card">                            
                            <div class="card-content">
                                <div class="card-body">  
                                    <div class="d-flex"> 
                                        <div class="media-body align-self-center ">
                                            <span class="mb-0 h5 font-w-600">Montly Shippment</span><br>
                                            <p class="mb-0 font-w-500 tx-s-12"></p>                                                    
                                        </div>
                                        <!-- <div class="ml-auto border-0 outline-badge-warning circle-50"><span class="h5 mb-0">$</span></div> -->
                                    </div>
                                    <div id="flot-report" class="height-175 w-100 mt-3"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Card DATA-->                 
            </div>
        </main>
        <!-- END: Content-->
        <!-- START: Footer-->
        <?php include('admin_shared/admin_footer.php'); ?>
        <!-- START: Footer-->
    </body>
    <!-- END: Body-->
</html>
