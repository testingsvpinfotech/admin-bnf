<?php include(dirname(__FILE__).'/../admin_shared/admin_header.php'); ?>
    <!-- END Head-->
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
</style>
    <!-- START: Body-->
    <body id="main-container" class="default">

        
        <!-- END: Main Menu-->
   
    <?php include(dirname(__FILE__).'/../admin_shared/admin_sidebar.php'); ?>
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
                              <h4 class="card-title">All Shipment</h4>
                            <!--   <span style="float: right;"><a href="admin/view-add-international-shipment" class="fa fa-plus btn btn-primary">Add International Shipment</a></span> -->
                          </div>
                          <div class="card-body">
                              <div class="table-responsive">
                                   <table id="example" class="display table dataTable table-striped table-bordered layout-primary" data-sorting="true">
                                      <thead>
                                          <tr>
												<!-- <th  scope="col"><input type="checkbox" onchange="checkAll(this)" name="chk[]" /> </th> -->
											    <th  scope="col">DOC No.</th>
											    <th  scope="col">Sender</th>
											    <th  scope="col">Receiver</th>
											    <th  scope="col">Country</th>
											    <th  scope="col">ForwordNo</th>
											    <th  scope="col">Forworder</th>
											    <th  scope="col">Date</th>
												<th  scope="col">Mode</th>
												<th  scope="col">Payment</th>
												<th scope="col">Amount</th>											
                                          </tr>
                                      </thead>
                                      <tbody>
                                 <?php 
                                    if (!empty($all_pending_forworder))
									{
										$cnt = 1;
										foreach ($all_pending_forworder as $value) 
										{
                                    ?>
											<tr class="odd gradeX">
												<!-- <td>
													
													<div class="custom-control custom-checkbox custom-control-inline">
														<input type="checkbox" class="custom-control-input multiple_campings" value="<?php echo $value['booking_id'];?>" name="multiple_delete[]">
														<label class="custom-control-label" for="customCheck1"></label>                                       
													</div>
												</td> -->
												<td>
													<a href="admin/view-edit-domestic-shipment/<?php echo $value['booking_id'];?>" class="btn btn-primary btn-sm"><?php echo $value['pod_no'];?></a>
												</td>
												<td style="width: 15%;"><?php echo $value['sender_name'];?></td>
												<td style="width: 15%;"><?php echo $value['reciever_name'];?></td>
												<td style="width: 5%;"><?php 
												$whr = array('id'=>$value['reciever_city']);
												$city_details = $this->basic_operation_m->get_table_row("city",$whr);

												echo $city_details->city;?></td>
												<td>
													<?php 
													echo $value['forwording_no'];
													if($value['forworder_name'] == 'delhivery_c2c')
													{
														$serviceType = 'b2c';
														$number = $value['forwording_no'];
													}
													else
													{
														$serviceType = 'b2b';
														$number = $value['booking_id'];
													}
													?>
												</td>
												<td><?php echo ucfirst($value['forworder_name']);?></td>
												<td style="width: 11%;"><?php echo date('d-m-Y',strtotime($value['booking_date']));?>
												<td><?php
												$whr = array('transfer_mode_id'=>$value['mode_dispatch']);
                        $mode_list = $this->basic_operation_m->get_table_row('transfer_mode',$whr);
                        echo $mode_list->mode_name; ?></td>
												<td><?php echo $value['dispatch_details'];?></td>
												<td><?php echo round($value['grand_total']);?></td>											
											 </tr>
									<?php 
										$cnt++;
										}
									}
									else
									{
										?>
										<tr>
											<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
										</tr>
										<?php
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
        
        <?php  include(dirname(__FILE__).'/../admin_shared/admin_footer.php'); ?>
        <!-- START: Footer-->
    </body>
    <!-- END: Body-->
</html>
<script >
			// this function is use for redirecting page on preseleted campaing on schedule page  
			
			function checkAll(ele) {
     var checkboxes = document.getElementsByTagName('input');
     if (ele.checked) {
         for (var i = 0; i < checkboxes.length; i++) {
             if (checkboxes[i].type == 'checkbox') {
                 checkboxes[i].checked = true;
             }
         }
     } else {
         for (var i = 0; i < checkboxes.length; i++) {
             console.log(i)
             if (checkboxes[i].type == 'checkbox') {
                 checkboxes[i].checked = false;
             }
         }
     }
 }
 
	$('.multiple_campings').click(function()
	{
		var new_sel_cam		 	= $(this).val();
		var pre_selected_cam 	= $('#selected_campaingss').val();
		if($(this).prop("checked") == true)
		{
			$('#selected_campaingss').val(new_sel_cam+'-'+pre_selected_cam);
		}
		else if($(this).prop("checked") == false)
		{
			pre_selected_cam = pre_selected_cam.replace(new_sel_cam+'-','');
			$('#selected_campaingss').val(pre_selected_cam);
		}
		
	});
	
	// this function is use for redirecting page on preseleted campaing on schedule page  
	$('#select_multiple_camp').click(function()
	{
		var pre_selected_cam 	= $('#selected_campaingss').val();
		
		if(pre_selected_cam !== null)
		{
			var nes = 		pre_selected_cam.slice(0,-1);
			var favorite = [];
            $.each($("input[name='multiple_delete[]']:checked"), function(){            
                favorite.push($(this).val());
            });
			favorite = favorite.join("-");
			
			if(favorite != '')
			{
				window.location = 'generatepod/all_printpod/'+favorite+'-'+nes;
			}
			else
			{
				alert('Pleaese choose at least one Shipment');
			}	
		}
		else
		{
			var favorite = [];
            $.each($("input[name='multiple_delete[]']:checked"), function(){            
                favorite.push($(this).val());
            });
			favorite = favorite.join("-");
			
			if(favorite != '')
			{
				window.location = 'generatepod/all_printpod/'+favorite;
			}
			else
			{
				alert('Pleaese choose at least one Shipment');
			}
		}
		
			
	});
	
  
/* $("#filterpod").validate({
   rules: {
		from_date: "required",
		to_date: "required"
	},
	errorPlacement: function(error, element) {
		error.insertAfter(element);
	},
	messages: {
		 //email: "Please provide email address"       
	},      
	submitHandler: function(form)
	{
		form.submit();
	}     
}); */
</script>
<div class="modal fade in" id="modal-default" style="padding-right: 17px;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Print Bulk Shipment</h4>
              </div>
                <form name="filterpod" id="filterpod" action="generatepod/all_printpod" method="POST">
              <div class="modal-body">
						<div class="col-md-4">
							<label>Customer</label>
							<select class="form-control" name="user_id">
							<?php if(!empty($customer))
							{
								foreach($customer as $key => $values)
								{ ?>
									<option value="<?php echo $values->customer_id; ?>" ><?php echo $values->customer_name; ?></option>
									<?php
								}
							} ?>
							</select>

						</div>
						<div class="col-md-4">
							<label>From Date</label>
							<input type="date" class="form-control" name="from_date" value="<?php echo $_GET['from_date'];?>" />
						</div>
						<div class="col-md-4">
							<label>To Date</label>
							<input type="date" class="form-control" name="to_date" value="<?php echo $_GET['to_date'];?>" />
						</div>
						<div class="col-md-4">
							
						</div>
              </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Print</button>
			  </div>
					</form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
		