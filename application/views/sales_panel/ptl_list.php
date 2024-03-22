<?php include('admin_shared/admin_header.php'); ?>

<body id="main-container" class="default">

    <!-- END: Main Menu-->
    <?php include('admin_shared/admin_sidebar.php'); ?>
    <!-- END: Main Menu-->

    <!-- START: Main Content-->
    <main>
        <div class="container-fluid site-width">
            <!-- START: Listing-->
            <div class="row">
                <div class="col-12  align-self-center">
                    <div class="col-12 col-sm-12 mt-3">
                        <div class="card">
                            <div class="card-header justify-content-between align-items-center">
                                <h4 class="card-title">PTL Request List</h4>
                                <a href="<?php echo base_url();?>Admin_sales/ptl_createExcel" class="btn btn-success float-right">Excel</a>
                            </div>

                            <div class="card-header justify-content-between align-items-center">
                                <span>

                                </span>
                            </div>
                            <div class="card-body">
<div id="message"></div> 
                                <?php if ($this->session->flashdata('notify') != '') { ?>
                                    <div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
                                <?php unset($_SESSION['class']);
                                    unset($_SESSION['notify']);
                                } ?>
                                <div class="table-responsive">
                                    <table class="table  table-striped table-bordered layout-primary" data-sorting="true" id="table_id">
                                        <!-- id="example"-->
                                        <thead>
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th scope="col">AWB NO</th>
                                                <th scope="col">Customer Name</th>
                                                <th scope="col">Customer ID</th>
                                                <th scope="col">Booking Date</th>  
                                                <th scope="col">Origin Pincode</th>
                                                <th scope="col">Origin City</th>
                                                <th scope="col">Destination Pincode</th>
                                                <th scope="col">Destination City </th>
                                                <th scope="col">Rate</th>
                                                <th scope="col">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          
                                            <?php if (!empty($get_customer_shipment)) {
                                                $cnt = 1;
                                                foreach ($get_customer_shipment as $value) : ?>
                                                    <tr>
                                                        <td><?php echo  $cnt++; ?></td>
                                                        <td><?php echo $value['pod_no']; ?></td>
                                                        <td><?php echo $value['customer_name']; ?></td>
                                                        <td><?php echo $value['customer_id']; ?></td>
                                                        <td><?php echo $value['booking_date']; ?></td>
                                                        <td><?php echo $value['sender_pincode']; ?></td>
                                                        <?php
                                                         $sender_city = $value['sender_city'];
                                                         $scity = $this->db->query("SELECT city FROM city where id = $sender_city")->row(); ?>
                                                        <td><?php  echo $scity->city; ?></td>
                                                        <td><?php echo $value['reciever_pincode']; ?></td>
                                                        <?php   $receiver_city = $value['reciever_city'];
                                                         $rcity = $this->db->query("SELECT city FROM city where id = $receiver_city")->row(); ?>
                                                        <td><?php echo $rcity->city; ?></td>
                                                        <td><?php echo $value['rate']; ?></td>
                                                        <td><?php echo $value['sub_total']; ?></td>
                                                      
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php } else { ?>
                                                <tr>
                                                    <td colspan="10" style="color:red;">No Data Found</td>
                                                </tr>
                                            <?php } ?>

                                        </tbody>

                                    </table>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- END: Listing-->
        </div>
    </main>
    <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script>

        $(document).ready(function() {
     

	// DataTable initialisation
	$('#table_id').DataTable({
        "aLengthMenu": [ [2, 4, 8, -1], [2, 4, 8, "All"] ],
              "iDisplayLength": 20,  
	});
});
    
    </script>
    <?php include('admin_shared/admin_footer.php'); ?>
   
    <!-- START: Footer-->
</body>
<!-- END: Body-->

</html>



