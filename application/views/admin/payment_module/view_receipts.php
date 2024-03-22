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
  /*#example_filter{display: none;}*/
  .input-group{
    width: 60%!important;
  }
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
                              <h4 class="card-title">Recieved Payment Entry</h4>                              
                          </div>
                           <div class="card-body border" id="div_transaction" >                                          
                             <div class="row" >   
                              <div class="col-12"> 
                                 <form role="form" action="admin/save-received-payments" method="post"  enctype="multipart/form-data">
                                <div class="box-body">      
								 <?php if($this->session->flashdata('notify') != '') {?>
  <div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
  <?php  unset($_SESSION['class']); unset($_SESSION['notify']); } ?> 
                                 <div class="form-group row"> 
									  <label class="col-sm-1">Entry No</label>
                                      <div class="col-sm-2">                                       
                                        <input type="text" readonly class="form-control" name="entry_no" id="entry_no" value="<?php if(!empty($entry_no)){echo $entry_no;}else{echo "";} ?>" placeholder="Entry No">
										 <input type="hidden" readonly class="form-control" name="inc_num" id="inc_num" value="<?php if(!empty($inc_num)){echo $inc_num;} ?>" >
										  <input type="hidden" readonly class="form-control" name="edit_id" id="edit_id" >
                                      </div> 
									  <label class="col-sm-1">Entry Date</label>
                                      <div class="col-sm-2">
                                        <input type="date" class="form-control" name="entry_date" id="entry_date" placeholder="Entry Date">
                                      </div> 
									  <label class="col-sm-1">Customer</label>
                                      <div class="col-sm-2">
                                        <select class="form-control"  name="customer_id" id="customer_id">
											<option value="">Select Customer</option>
											<?php
												if (count($customers)) {
													foreach ($customers as $rows) 
													{	?>
													<option value="<?php echo $rows['customer_id']; ?>">
														<?php echo $rows['customer_name']; ?>--<?php echo $rows['cid']; ?> 
													</option>
													<?php
													}
												} 
												?>
										</select>
                                      </div> 
									  <label class="col-sm-1">Pay By</label>
                                       <div class="col-sm-2">
                                       <select class="form-control" name="payment_method" id="payment_method" required>
												<option value="">-Select-</option>
												<?php foreach($payment_method as $pm){ ?>
												<option value="<?php echo $pm['id'];?>" ><?php echo $pm['method'];?></option>
												<?php } ?>
										</select>
                                      </div> 
								  </div>
								   <div class="form-group row"> 
										<label class="col-sm-1">Bank</label>
                                      <div class="col-sm-2">                                       
                                        <input type="text" class="form-control" name="bank_name" id="bank_name" placeholder="Bank Name">
                                      </div> 
									  <label class="col-sm-1">AccountNo</label>
                                      <div class="col-sm-2">
                                        <input type="text" class="form-control" name="account_no" id="account_no" placeholder="Account No">
                                      </div> 
									  <label class="col-sm-1">Ref No</label>
                                      <div class="col-sm-2">
                                        <input type="text" class="form-control" name="reference_no" id="reference_no" placeholder="Reference No">
                                      </div> 
									  <label class="col-sm-1">Reference Date</label>
                                       <div class="col-sm-2">
                                       <input type="date" class="form-control" name="reference_date" id="reference_date" placeholder="Reference Date">
                                      </div> 
								   </div>
								   <div class="form-group row"> 
									 <label class="col-sm-1">Amount</label>
                                      <div class="col-sm-2">                                       
                                        <input type="text" class="form-control" name="amount_recieved" id="amount_recieved" required placeholder="Amount Recieved">
                                      </div> 
									  <label class="col-sm-1">Payment Type</label>
                                      <div class="col-sm-2">
                                        <select class="form-control" name="payment_type" id="payment_type" required>
												<option value="">-Select-</option>
												<option value="Advance" >Advance</option>
												<option value="Full Payment" >Full Payment</option>
												<option value="Part Payment" >Part Payment</option>
										</select>	
                                      </div> 
									  <label class="col-sm-1">Deposited At</label>
                                      <div class="col-sm-2">
										 <select class="form-control" name="deposited_at" id="deposited_at" required>
												<option value="">-Select-</option>
												<option value="Bank of India" >Bank of India</option>
												<option value="Thane Bharat Sahakari Bank Ltd" >Thane Bharat Sahakari Bank Ltd</option>
										</select>	
                                      </div> 
									  <label class="col-sm-1">Deposited Date</label>
                                       <div class="col-sm-2">
                                       <input type="date" class="form-control" name="deposited_date" id="deposited_date"  placeholder="Deposited Date">
                                      </div> 
								   </div>
								   <div class="form-group row"> 
                                      <div class="col-sm-12">                                        
                                         <input type="submit" class="btn btn-primary" style="float:right" name="submit" id="submit" value="Submit">
                                      </div>          
                                  </div>       
                              </div>    
                             </form>     
                              </div>
                            </div>
                          </div>
                          <div class="card-body">
                              <div class="table-responsive">
                                  <table id="example" class="display table dataTable table-striped table-bordered layout-primary" data-sorting="true">
                                      <thead>
                                          <tr>   
                                              <th scope="col">Sr No</th>
                                              <th scope="col">Entry No</th>
                                              <th scope="col">Entry Date</th>
                                              <th scope="col">Customer</th>
                                              <th scope="col">Pay By</th>
                                              <th scope="col">Bank Name</th>
                                              <th scope="col">AccountNo</th>
                                              <th scope="col">ReferenceNo</th>                        
                                              <th scope="col">Date</th>
                                              <th scope="col">Amount</th>
                                              <th scope="col">Payment Type</th>
                                              <th scope="col">Deposited At</th>
                                              <th scope="col">Deposited Date</th>
                                              <th scope="col">Status</th>
                                              <th scope="col">Action</th>
                                          </tr>
                                      </thead>
                                      <tbody>                                        
                                      <tr>
                                         <?php
										 $cnt=0;
                                          if (!empty($receipt_details)) {
                                          foreach ($receipt_details as $value) {
											  $cnt++;
                                              ?>
											  <td><?php echo $cnt; ?></td>
                                              <td>
                                                <!-- <a href="<?php echo base_url('booking/view_payment/'.$value['id'])?>"> -->
												<?php echo $value['entry_no']; ?>
                                              </td>
                                              <td><?php echo date('d-m-Y', strtotime($value['entry_date'])); ?></td>
                                              <td><?php echo $value['customer_name']; ?></td>
                                              <td><?php
													$whr = array('id'=>$value['payment_method']);
													$payment_method_details  = $this->basic_operation_m->get_table_row('payment_method',$whr);

											  echo $payment_method_details->method; ?></td>
											  <td><?php echo $value['bank_name']; ?></td>
											  <td><?php echo $value['account_no']; ?></td>
											  <td><?php echo $value['reference_no']; ?></td>
                                              <td><?php echo date('d-m-Y', strtotime($value['reference_date'])); ?></td>
                                              <td><?php echo $value['amount_recieved']; ?></td>
                                              <td><?php echo $value['payment_type']; ?></td>
                                              <td><?php echo $value['deposited_at']; ?></td>
                                              <td><?php echo date('d-m-Y',strtotime($value['deposited_date'])); ?></td>
                                              <td><?php if($value['receipt_status']=='1'){echo 'Unavailable';}else{echo 'Available';}?></td>
											  <td>
											  <?php 
											  if ($this->session->userdata("userType") == '1') {
												  if($value['receipt_status']!='1'){ ?>
												  <a onclick="return show_edit_id(<?php echo $value['id']; ?>);" title="Edit" ><i class="ion-edit" style="color:var(--primarycolor)"></i></a> | 
												  <!--<a href="admin/delete-invoice-receipt/<?php echo $value['id'];?>" onclick="return confirm('Are you sure you want to delete this item?');" ><i class="ion-trash-b" style="color:var(--danger)"></i></a>-->
												  <a href="javascript:void" relid = "<?php echo $value['id'];?>" class="deletedata" ><i class="ion-trash-b" style="color:var(--danger)"></i></a>
												  <?php }
											  } ?>
											  </td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        echo "<p>No Data Found</p>";
                                    }
                                    ?>
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
    <!-- END: Content-->
    <!-- START: Footer-->
    <?php $this->load->view('admin/admin_shared/admin_footer');
     //include('admin_shared/admin_footer.php'); ?>
    <!-- START: Footer-->
</body>
<!-- END: Body-->
<script type="text/javascript">
   function show_edit_id(id)
   {
	   $("#edit_id").val(id);
		$.ajax({
				type: 'POST',
				url: 'Admin_payment/get_receipt',
				data: 'edit_id=' + id,
				dataType: "json",
				success: function (data) {
					//alert(data);					
					$('#entry_no').val(data.receipt_details.entry_no);					
					$('#entry_date').val(data.receipt_details.entry_date);					
					$('#customer_id').val(data.receipt_details.customer_id);					
					$('#inc_num').val(data.receipt_details.inc_num);					
					$('#payment_method').val(data.receipt_details.payment_method);					
					$('#bank_name').val(data.receipt_details.bank_name);					
					$('#account_no').val(data.receipt_details.account_no);					
					$('#reference_no').val(data.receipt_details.reference_no);					
					$('#reference_date').val(data.receipt_details.reference_date);					
					$('#amount_recieved').val(data.receipt_details.amount_recieved);					
					$('#payment_type').val(data.receipt_details.payment_type);					
					$('#deposited_at').val(data.receipt_details.deposited_at);					
					$('#deposited_date').val(data.receipt_details.deposited_date);					
				}
			});
	   
   }
   function hide_transaction_div()
  {
      $("#div_transaction").hide();  
      return false; 
  }
  function show_transaction(id){
      $("#div_transaction").show();  
      $("#invoice_id").val(id);
      return false; 
  }
</script>

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
			   		url: baseurl+'Admin_payment/delete_receipts',
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
