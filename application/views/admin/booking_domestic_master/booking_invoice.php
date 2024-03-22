<?php $this->load->view('admin/admin_shared/admin_header'); ?>
    <!-- END Head-->
<style>
  	.form-control{
  		color:black!important;
  		border: 1px solid var(--sidebarcolor)!important;
  		height: 27px;
  		font-size: 10px;
  }
  .select2-container--default .select2-selection--single {
    background: lavender!important;
    }
    form .error {
	  color: #ff0000;
	}	
  </style>   
    <!-- START: Body-->
    <body id="main-container" class="default">
        
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
                              <h4 class="card-title">View Invoice</h4>
                          </div>
                          <div class="card-body">
                            <div class="row">                                           
                          <div class="col-12">
                              <form role="form" action="<?php echo base_url(); ?>admin/list-domestic-booking" method="post" autocomplete="off">
                                  <div class="col-12">
                                    <div class="form-row">
											                        <div class="col-2 mb-3">
                                                <label for="username">Company</label>
                                                <select class="form-control"  name="company_id" id="company_id" required>
													                        <!-- <option value="">-Select-</option> -->
                                                  <?php 
                                                  foreach($company_list AS $cl){ ?>
                                                  <option value="<?php echo $cl['id'];?>" <?php echo ($company_id == $cl['id']) ? 'selected=""' : ''; ?>><?php echo $cl['company_name'];?></option>
                                                  <?php } ?>
                                                </select>
											                        </div>
                                              <div class="col-3 mb-3">
                                                <label for="username">Branch Name</label>
                                                <?php if(empty($branch_id)){ ?>
                                                <select class="form-control"  name="branch_id" id="branch_id" required>
													                        <option value=""> Select Branch </option>
                                                  <?php 
                                                  foreach($branches AS $cl){ ?>
                                                  <option value="<?php echo $cl['branch_id'];?>" <?php echo ($_POST['branch_id'] == $cl['branch_id']) ? 'selected=""' : ''; ?>><?php echo $cl['branch_name'];?></option>
                                                  <?php } ?>                                                 
                                                </select>
                                                <?php }else{ ?>
                                                  <input type="hidden" name="branch_id" required readonly value="<?php echo $branch_id; ?>" class="form-control" />
                                                  <input type="text"  readonly value="<?php echo $branch_name; ?>" class="form-control" />
                                                  <?php } ?>
											                        </div>
                                            <div class="col-3 mb-3">
                                                <label for="username">Customer Name</label>
                                                <select class="form-control"  name="customer_account_id" required id="customer_account_id">
                                                  <option value="">Select Customer</option>
                                                  <?php
                                               
                                                  if (count($customers)) {
                                                      foreach ($customers as $rows) {
                                                        if(!empty($customer_account_id)){
                                                        if($customer_account_id == $rows['customer_id']){
                                                        ?>
                                                          <option <?php echo 'selected'?> value="<?php echo $rows['customer_id']; ?>">
                                                              <?php echo $rows['customer_name']; ?>--<?php echo $rows['cid']; ?> 
                                                          </option>
                                                          <?php
                                                      }}else
                                                      { ?>
                                                        <option value="<?php echo $rows['customer_id']; ?>">
                                                        <?php echo $rows['customer_name']; ?>--<?php echo $rows['cid']; ?> 
                                                    </option>
                                                    <?php  }
                                                    }
                                                  } else {
                                                      echo "<p>No Data Found</p>";
                                                  }
                                                  ?>
                                              </select>
                                            </div>
                                             <div class="col-2 mb-3">
                                                <label for="username">Booking Form Date</label>
                                                 <input type="date" name="from" value="<?php echo set_value('from') ?>" class="form-control" />
                                            </div>
                                            <div class="col-2 mb-3">
                                                <label for="username">Booking To Date</label>
                                               <input type="date" name="to" value="<?php echo set_value('to') ?>" class="form-control" />
                                            </div>
                                            <div class="col-3 mb-3">
                                                 <input type="submit" name="submit" style="margin-top: 26px;" value="Search" class="btn btn-sm btn-primary">
                                                 <?php   if (!empty($_POST)) { ?>
                                                <a href="<?=base_url('admin/list-domestic-booking');?>" style="margin-top: 26px;" class="btn btn-sm btn-success">Reset</a>
                                              <?php } ?>    
                                             </div>
                                            
                                      </div>
                                 
                                  </div>
                                
                                <div class="col-12">
                                  <div class="form-row">                                      
                                         <b>Total Results: <?php echo count($getAllInvoices); ?></b>
                                  </div>
                                </div>
                                <div class="col-12">
                                  <div class="form-row">  
                                   <div class="col-3 mb-3">
                                        <?php   if (!empty($getAllInvoices)) { ?>
                                        <button type="submit" name="submit_print" value="print" style="margin-top: 26px;" class="btn btn-sm btn-primary">Create Invoice</button>
                            <?php } ?>    
                                  </div>
                                </div>
                                  <div class="form-row">                                      
                                        
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" value="all" name="all_docket" class="check_all" /></th>
                                        <th>AWB</th>
                                        <th>Sender Name</th>
                                        <th>Receiver Name </th>
                                        <th>Receiver City</th>
                                        <th>Booking date</th>
                                        <th>Mode of Dispatch</th>
                                    </tr>
                                </thead>
                                <tbody>
                  
                                    <tr>
                                        <?php                                        
                                        if (!empty($getAllInvoices)) {
                                            foreach ($getAllInvoices as $value) {
                                                ?>
                                       <td><input type="checkbox" name="selected_dockets[]" value="<?php echo $value['booking_id']; ?>" class="row_check" />
                                        <input type="hidden" name="customer_id" value="<?php echo $value['customer_id']; ?>">
                                     </td>
                                                <td><?php echo $value['pod_no']; ?></td>
                                                <td><?php echo $value['sender_name']; ?></td>
                                                <td><?php echo $value['reciever_name']; ?></td>
                                                <td><?php echo $value['city']; ?></td>
                                                <td><?php echo date('d/m/Y', strtotime($value['booking_date'])); ?></td>

                                                <td><?php echo $value['mode_name']; ?></td>
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
                </form>
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
    <!-- END: Body-->
<script type="text/javascript">
  
  $('.datepicker').datepicker({
      format : 'dd/mm/yyyy' 
    });
  $(".check_all").click(function(){
      if($(this).prop('checked'))
      {
        $(".row_check").prop('checked', true);
      }
      else
      {
        $(".row_check").prop('checked', false);
      }
    });

    $('#customer_account_id').select2();
    $('#company_id').select2();
    $('#branch_id').select2();
  
	$("#branch_id").change(function (){
        var branch_id =$("#branch_id").val();
       //alert(bill_type) ;
         $.ajax({
				type: 'POST',
				url: '<?php echo base_url() ?>Admin_domestic_booking/getCustomer',
				data: 'branch_id=' + branch_id,
				dataType: "json",
				success: function (data) {
					//console.log(d);
					var option;					
					option ='<option value="">-Select Customer-</option>';
					for(var i=0;i < data.customer_details.length;i++)
					{
						option += '<option value="' + data.customer_details[i].customer_id + '" >' + data.customer_details[i].customer_name +'--'+data.customer_details[i].cid+ '</option>';
					}
					
					$('#customer_account_id').html(option);
				}
			});
    });
</script>