     <?php $this->load->view('admin/admin_shared/admin_header'); ?>
     
    <!-- END Head-->

    <!-- START: Body-->
    <body id="main-container" class="default">
     <style>
    .buttons-copy{display: none;}
    .buttons-csv{display: none;}
    /*.buttons-excel{display: none;}*/
    .buttons-pdf{display: none;}
    .buttons-print{display: none;}
    .form-control{
      color:black!important;
      border: 1px solid var(--sidebarcolor)!important;
      height: 27px;
      font-size: 10px;
  }
  </style>     
        <!-- END: Main Menu-->
    <?php $this->load->view('admin/admin_shared/admin_sidebar');
   // include('admin_shared/admin_sidebar.php'); ?>
   <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
                              <h4 class="card-title">View Cancel Note Invoice</h4>         
                              <span style="float: right;">  
                            <!-- <a href="<?= base_url('admin/list-domestic-booking-credit-note')?>" style="width: 120px;float:right;" class="btn btn-primary btn-sm">Add Credit Note</a>     -->
                              </span>       
                          </div>
                          <div class="card-header justify-content-between align-items-center">
								<span>
									<form role="form" action="<?= base_url('admin/list-domestic-invoice-credit-note') ?>" method="get" enctype="multipart/form-data">
										<div class="form-row">
                                        <div class="col-md-2">
												<label for="">Customer</label>
												<select class="form-control" name="user_id" id="user_id">
													<option value="">Selecte Customer</option>
													<?php if (!empty($customer)) {
														foreach ($customer as $key => $values) { ?>
															<option value="<?php echo $values['customer_id']; ?>" <?php echo (isset($user_id) && $user_id == $values['customer_id']) ? 'selected' : ''; ?>><?php echo $values['customer_name']; ?></option><?php }
																																																													} ?>
												</select>
											</div>
											<div class="col-md-2">
												<label for="">Search Type</label>
												<select class="form-control" name="filter" id="type">
													<option  selected disabled>Select Type</option>
													<option value="cn_no" <?php echo (isset($filter) && $filter == 'cn_no') ? 'selected' : ''; ?>>CN No</option>
													<option value="invoice_no" <?php echo (isset($filter) && $filter == 'invoice_no') ? 'selected' : ''; ?>>Invoice No</option>
												</select>
											</div>
											<div class="col-md-2">
												<label for="">Filter Value</label>
												<input type="text" class="form-control" value="<?php echo (isset($filter_value)) ? $filter_value : ''; ?>" name="filter_value" />
											</div>

											

											<div class="col-sm-1">
												<label for="">From Date</label>
												<input type="date" name="from_date" value="<?php echo (isset($from_date)) ? $from_date : ''; ?>" id="from_date" autocomplete="off" class="form-control">
											</div>

											<div class="col-sm-1">
												<label for="">To Date</label>
												<input type="date" name="to_date" value="<?php echo (isset($to_date)) ? $to_date : ''; ?>" id="to_date" autocomplete="off" class="form-control">
											</div>
											<div class="col-sm-4">
                                                <br>
												<input type="submit" class="btn btn-primary btn-sm mt-2" name="submit" value="Search">
                                                <a href="<?= base_url('admin/list-domestic-invoice-credit-note')?>" class="btn btn-info btn-sm mt-2">Reset</a>
												<input type="submit" class="btn btn-success btn-sm mt-2" name="download_report" value="Download Excel">
											</div>
										</div>
									</form>
								</span>
							</div>
                         
                          <?php if($this->session->flashdata('notify') != '') {?>
                        <div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
                        <?php  unset($_SESSION['class']); unset($_SESSION['notify']); } ?>
                          <div class="card-body">
                              <div class="table-responsive">
                                  <table  class="display table table-bordered" data-sorting="true">
                                      <thead>
                                          <tr>  
                                              <th scope="col">Sr No</th>
                                              <th scope="col">Date</th>
                                              <th scope="col">Credit Note No</th>                                              
                                              <th scope="col">Invoice No</th>                                              
                                              <th scope="col">Customer ID</th>
                                              <th scope="col">Customer Name</th>
                                              <th scope="col">Total</th>
                                          
                                          </tr>
                                      </thead>
                                      <tbody>                                        
                                      <tr>
                                        <?php
                                        if (!empty($allpoddata)) {
                                          $cnt=0;
                                          // echo '<pre>';print_r($allpoddata);die;
                                            foreach ($allpoddata as $value) {
                                              $cnt++;
                                                ?>
                                                <td><?php echo $cnt; ?></td>
                                                <td><?php if($value['createDtm']!=""){ echo date("d-m-Y",strtotime($value['createDtm']) ); } ?></td>
                                                <td><a href="<?php base_url();?>admin/invoice-domestic-view-credit-note/<?php echo $value['id']; ?>" style="color:#2B9DE6;" target="_blank"><?php echo $value['credit_note_no']; ?></a></td>
                                                <td><?php echo $value['invoice_number']; ?></td>
                                                <td><?php echo $value['cid']; ?></td>
                                                <td><?php echo $value['customer_name']; ?></td>
                                                <td><?php echo $value['grand_total']; ?></td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        echo "<tr><td colspan='8'>No Data Found</td></tr>";
                                    }
                                    ?>
                                    </tbody>
                              </table> 
                          </div>
                          <div class="row">
									<div class="col-md-6">
										<?php echo $this->pagination->create_links(); ?>
									</div>
								</div>
                      </div>
                    </div> 

                </div>
                </div>
            </div>
            <!-- END: Listing-->
        </div>
    </main>
    <!-- END: Content-->
    <!-- START: Footer-->
    <?php $this->load->view('admin/admin_shared/admin_footer');
     //include('admin_shared/admin_footer.php'); ?>
    <!-- START: Footer-->
   
</body>
<script src="assets/js/domestic_shipment.js"></script>
<!-- END: Body-->

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
			   		url: baseurl+'Admin_domestic_booking/invoice_delete',
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

