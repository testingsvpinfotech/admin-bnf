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
                            <h4 class="card-title" style="color:brown">Franchise Topup Details</h4>
                            <span style="float: right;"><a href="<?php base_url(); ?>admin/franchise-topup-balance" class="btn btn-primary">
                            Add Franchise Topup </a></span>
                            <span style="float: right;margin-right: 10px;"><a href="<?php base_url(); ?>admin/filter-franchise-topup" class="btn btn-primary">
                            Filter </a></span>
                        </div>
                        <div class="card-body">
                            <?php if ($this->session->flashdata('notify') != '') { ?>
                                <div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
                            <?php unset($_SESSION['class']);
                                unset($_SESSION['notify']);
                            } ?>
                            <div class="table-responsive">
                                <table  class="display table dataTable table-striped table-bordered layout-primary" data-sorting="true">
                                    <thead>
                                        <tr>
                                            <th scope="col">SrNo</th>
                                            <th scope="col">F.Code</th>
                                            <th scope="col">Transaction ID</th>
                                            <th scope="col">Transaction Date</th>
                                            <th scope="col">Credit Amount</th>
                                            <th scope="col">Debit Amount</th>
                                            <th scope="col">balance_amount</th>
                                            <th scope="col">Payment Mode</th>
                                            <th scope="col">Bank name</th>
                                            <th scope="col">Refrence Number</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php  
                                        if (!empty($topup_details)) {

                                         
                                            $cnt = 0;
                                            foreach ($topup_details as $cust) {
                                                $cnt++;
                                        ?>
                                                <tr>
                                                    <td scope="row"><?php echo $cnt; ?></td>
                                                    <td><?php echo $cust['franchise_id']; ?></td>
                                                    <td><?php echo $cust['transaction_id']; ?></td>
                                                    <td><?php echo $cust['payment_date']; ?></td>
                                                    <td><?php echo $cust['credit_amount']; ?></td>
                                                    <td><?php echo $cust['debit_amount']; ?></td>
                                                    <td><?php echo $cust['balance_amount']; ?></td>
                                                    <td><?php echo $cust['payment_mode']; ?></td>
                                                    <td><?php echo $cust['bank_name']; ?></td>
                                                    <td><?php echo $cust['refrence_no']; ?></td>
                                                    <td>
                                                        <a href="<?php echo base_url('admin/update-franchise-topup/'.$cust['topup_balance_id']);?>" class="btn btn-success">Edit</a>
                                                        <button  relid="<?php echo $cust['topup_balance_id']; ?>"class="btn deletedata btn-danger">Delete</button>
                                                    </td>
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