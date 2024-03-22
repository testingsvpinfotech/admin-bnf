<?php $this->load->view('admin/admin_shared/admin_header'); ?>


<body id="main-container">

    <!-- END: Main Menu-->
    <?php $this->load->view('admin/admin_shared/admin_sidebar');?>
    <!-- END: Main Menu-->
    <!-- START: Main Content-->
    <main>
        <div class="container-fluid site-width">
            <!-- START: Listing-->
            <div class="row">
                <div class="col-12 mt-3">
                    <!-- <div class="col-12 col-sm-12 mt-3"> -->
                    <div class="card">
                        <!-- bg-primary-light -->
                        <div class="card-header justify-content-between align-items-center">
                            <h4 class="card-title" style="color:brown">Franchise Credit Topup List</h4>
                           
                        </div>
                        <div class="card-body">
                        <form role="form" action="admin/view-franchise-topup-credit-list" method="post" enctype="multipart/form-data" style="margin-bottom: 55px;">
                                <div class="form-row">

                                    <!-- <div class="col-sm-1">
                                        <label for="">Payment Mode</label>
                                        <select class="form-control" name="payment_mode">
                                            <option value="ALL">ALL</option>
                                            <option value="credit">Credit</option>
                                            <option value="debit">Debit</option>
                                        </select>
                                    </div> -->

                                    
                                    <div class="col-md-1">
                                        <label for="">Filter</label>
                                        <select class="form-control" name="filter">
                                            <option selected disabled>Select Filter</option>
                                            <option value="pod_no" <?php echo (isset($filter) && $filter == 'pod_no') ? 'selected' : ''; ?>>Pod No</option>
                                        </select>
                                    </div>

                                    <div class="col-md-1">
                                        <label for="">Filter Value</label>
                                        <input type="text" class="form-control" value="<?php echo (isset($filter_value)) ? $filter_value : ''; ?>" name="filter_value" />
                                    </div>

                                    <div class="col-md-1">
                                        <label for="">Customer</label>
                                        <select class="form-control" name="user_id" id="user_id">
                                            <option value="">Selecte Customer</option>
                                            <?php if (!empty($customer)) {
                                                foreach ($customer as $key => $values) { ?>
                                                    <option value="<?php echo $values['customer_id']; ?>" <?php echo (isset($user_id) && $user_id == $values['customer_id']) ? 'selected' : ''; ?>><?php echo $values['customer_name']; ?></option><?php }
                                                                                                                                                                                                                                            } ?>
                                        </select>
                                    </div>

                                    <div class="col-sm-1">
                                        <label for="">From Date</label>
                                        <input type="date" name="from_date" value="<?php echo (isset($from_date)) ? $from_date : ''; ?>" id="from_date" autocomplete="off" class="form-control">
                                    </div>

                                    <div class="col-sm-1">
                                        <label for="">To Date</label>
                                        <input type="date" name="to_date" value="<?php echo (isset($to_date)) ? $to_date : ''; ?>" id="to_date" autocomplete="off" class="form-control">
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="submit" class="btn btn-primary mt-4" name="submit" value="Filter">
                                        <input type="submit" class="btn btn-primary mt-4" name="download_report" value="Download Report">
                                        <a href="admin/view-franchise-topup-credit-list" class="btn btn-info mt-4">Reset</a>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <table  class="display table dataTable table-striped table-bordered layout-primary" data-sorting="true">
                                    <thead>
                                        <tr>
                                            <th scope="col">SrNo</th>
                                            <th scope="col">C.ID</th>
                                            <th scope="col">Franchise Name</th>
                                            <th scope="col">Pod Number</th>
                                            <th>Credit Amount</th>
                                            <th>Debit Amount</th>
                                            <th>Balance Amount</th>
                                            <th>payment Mode</th>
                                            <th>payment Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php  
                                        if (!empty($franchise_topup)) {

                                         
                                            $cnt = 0;
                                            foreach ($franchise_topup as $cust) {
                                                $cnt++;
                                        ?>
                                                <tr>
                                                    <td scope="row"><?php echo $cnt; ?></td>
                                                    <td><?php echo $cust['cid']; ?></td>
                                                    <td><?php echo $cust['customer_name']; ?></td>
                                                    <td><?php echo $cust['refrence_no']; ?></td>
                                                    <td><?php echo $cust['credit_amount']; ?></td>
                                                    <td><?php echo $cust['debit_amount']; ?></td>
                                                    <td><?php echo $cust['balance_amount']; ?></td>
                                                    <td><?php echo $cust['payment_mode']; ?></td>
                                                    <td><?php echo $cust['payment_date']; ?></td>                                                   
                                                </tr>
                                        <?php
                                            }
                                        } else {
                                            echo "<p>No Data Found</p>";
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- </div> -->
                </div>
            </div>
            <!-- END: Listing-->
        </div>
    </main>
    <!-- END: Content-->
    <!-- START: Footer-->
    <?php $this->load->view('admin/admin_shared/admin_footer');
    //include('admin_shared/admin_footer.php'); 
    ?>
    <!-- START: Footer-->
</body>
<!-- END: Body-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
      $('.deletedata').click(function(){
        var getid = $(this).attr("relid");
      // alert(getid);
       var baseurl = '<?php echo base_url();?>'
       	swal({
		  	title: 'Are you sure?',
		  	text: "You won't be able to revert this!",
		  	icon: 'warning',
		  	showCancelButton: true,
		  	confirmButtonColor: '#3085d6',
		  	cancelButtonColor: '#d33',
		  	confirmButtonText: 'Yes, delete it!',
		}).then((result) => {
		  	if (result.value){
		  		$.ajax({
			   		url: baseurl+'FranchiseController/delete_franchise_topup',
			    	type: 'POST',
			       	data: 'getid='+getid,
			       	dataType: 'json'
			    })
			    .done(function(response){
			     	swal('Deleted!', response.message, response.status)
			     	
			      .then(function(){ 
                    location.reload();
                   })
			    })
			    .fail(function(){
			     	swal('Oops...', 'Something went wrong with ajax !', 'error');
			    });
		  	}
 
		})
 
	});
       
 });
</script>

</html>