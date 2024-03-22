     <?php $this->load->view('admin/admin_shared/admin_header'); ?>
    <!-- END Head-->

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
                              <h4 class="card-title">Change Shipment Status</h4>  
					  
                          </div>
                          <div class="card-body">
                              <div class="table-responsive">
                                 <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="<?php if(isset($_GET['filter']) && $_GET['filter'] != 'customerwise'){ echo 'active'; } ?>"><a href="#individual" data-toggle="tab" class="btn btn-primary">Individual</a></li>
                                <li><a href="#bulk_update" data-toggle="tab" class="btn btn-primary">Bulk Update</a></li>
                                <li class="<?php if(isset($_GET['filter']) && $_GET['filter'] == 'customerwise'){ echo 'active'; } ?>"><a href="#customerwise" data-toggle="tab" class="btn btn-primary">Customer Wise</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane <?php if(isset($_GET['filter']) && $_GET['filter'] != 'customerwise'){ echo 'active'; } ?>" id="individual">


                                        <form role="form" action="admin/change-shipment-status" method="post" enctype="multipart/form-data">
                                            <div class="box-body">
                                                <div class="col-md-7">

                                                    <div class="form-group">
                                                        <label>Doc No.:</label>
                                                        <select class="form-control"  name="pod_no" id="selectsingle"  required>
                                                            <option value="">Airway No</option>
                                                            <?php
                                                            if (count($deliverysheet)) {
                                                                foreach ($deliverysheet as $rows) {
                                                                    $podno = $rows['pod_no'];
                                                                    $res = $this->db->query("select count(pod_no) as total from tbl_tracking where pod_no='$podno' and status='delivered'");
                                                                    $total = $res->row()->total;
                                                                    // echo $total;
                                                                    if ($total == 0) {
                                                                        ?>
                                                                        <option value="<?php echo $rows['pod_no']; ?>">

                                                                            <?php echo $rows['pod_no']; ?> 
                                                                        </option>
                                                                        <?php
                                                                    }
                                                                }
                                                            }


                                                            if (count($currentbooking)) {
                                                                foreach ($currentbooking as $rows) {
                                                                    $podno = $rows['pod_no'];
                                                                    $res = $this->db->query("select count(pod_no) as total from tbl_tracking where pod_no='$podno' and status='delivered'");
                                                                    $total = $res->row()->total;
                                                                    // echo $total;
                                                                    if ($total == 0) {
                                                                        ?>
                                                                        <option value="<?php echo $rows['pod_no']; ?>">

                                                                            <?php echo $rows['pod_no']; ?> 
                                                                        </option>
                                                                        <?php
                                                                    }
                                                                }
                                                            } else {
                                                                //	echo "<p>No Data Found</p>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div id="trackinghistory" class="col-md-12"></div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Date</label>
                                                        <input type="datetime-local" class="form-control" id="jq-validation-email" name="currentdate" placeholder="Date">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Status</label>
                                                        <select class="form-control" name="status" id="" required>
                                                            <option value="Intransit">Intransit</option>
                                                            <option value="Delivered">Delivered</option>
                                                            <option value="Out for Delivery">Out for Delivery</option>
                                                            <option value="Short Delivered">Short Delivered</option>
                                                            <option value="Undelivered">Undelivered</option>
                                                            <option value="Pending">Pending</option>
                                                            <option value="Hold">Hold</option>
                                                            <option value="Miss Route">Miss Route</option>
                                                            <option value="Incomplete Address">Incomplete Address</option>
                                                            <option value="Wrong Address">Wrong Address</option>
                                                            <option value="No Service Area">No service area</option>
                                                            <option value="Return to Origin">Return to Origin</option>
                                                            <option value="Lossed">Lossed</option>
                                                            
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Comment</label>
                                                        <textarea name="comment" class="form-control" placeholder="Add comment here ..."></textarea>

                                                    </div>
                                                    
                                                     <div class="form-group">
                                                        <label>Remarks</label>
                                                        <textarea name="remarks" class="form-control" placeholder="Add Remarks here ..."></textarea>

                                                    </div>
                                                    
                                                    <div class="col-md-7">
                                                    </div>
                                                    <div class="col-md-4">	
                                                        <div class="box-footer">
                                                            <button type="submit" name="submit"  class="btn btn-primary">Submit</button>
                                                        </div>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
<!--                                    </div>-->
                                </div>
								 <div class="tab-pane" id="bulk_update">
                                    <div class="box">


                                        <div class="row"><div class="col-md-5"><label>AWB NO.</label><input type="text" class="form-control" id="awb_no"></div><div class="col-md-4" style="margin-top:27px;"><button id="custome_data">Submit</button></div></div>
                                        <div class="box-body table-responsive">

                                            <form id="frm-example" action="admin/change-bulk-shipment-status" method="POST">
    
<table id="example1" class="table table-bordered table-hover">
   <thead>
      <tr>

          <th></th>
         <th>Awb No</th>
         <th>Sender Name</th>
         <th>Sender City</th>
         <th>Receiver Name </th>
		 <th>Receiver City</th>
         <th>Forworder Name</th>
         <th>Forwording Name</th>
		 <th>Booking date</th>
		 <th>EDD</th>
         <th>Status</th>
		 <th>Status Description</th>
          <th>Action</th>
		 
      </tr>
   </thead>
   <tbody id="change_status_id">
      
                
   </tbody>
</table>
                                                <div class="col-md-6">

                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Date</label>
                                                        <input type="datetime-local" class="form-control" id="jq-validation-email" name="currentdate" placeholder="Date">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Status</label>
                                                        <select class="form-control" name="status" id="" required>
                                                            <option value="Intransit">Intransit</option>
                                                            <option value="Delivered">Delivered</option>
                                                            <option value="Out for Delivery">Out for Delivery</option>
                                                            <option value="Short Delivered">Short Delivered</option>
                                                            <option value="Undelivered">Undelivered</option>
                                                            <option value="Pending">Pending</option>
                                                            <option value="Hold">Hold</option>
                                                            <option value="Miss Route">Miss Route</option>
                                                            <option value="Incomplete Address">Incomplete Address</option>
                                                            <option value="Wrong Address">Wrong Address</option>
                                                            <option value="No Service Area">No service area</option>
                                                            <option value="Return to Origin">Return to Origin</option>
                                                            <option value="Lossed">Lossed</option>
                                                            
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Comment</label>
                                                        <textarea name="comment" class="form-control" placeholder="Add comment here ..."></textarea>

                                                    </div>
                                                    
                                                     <div class="form-group">
                                                        <label>Remarks</label>
                                                        <textarea name="remarks" class="form-control" placeholder="Add Remarks here ..."></textarea>

                                                    </div>
                                                    <div class="col-md-7">
                                                    </div>
                                                    <div class="col-md-4">	
                                                        <div class="box-footer">
                                                            <button type="submit" name="submit"  class="btn btn-primary">Submit</button>
                                                        </div>
                                                    </div>
                                                </div>
</form>
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                    <!-- /.box -->
                                </div>
								<div class="tab-pane <?php if(isset($_GET['filter']) && $_GET['filter'] == 'customerwise'){ echo 'active'; } ?>" id="customerwise">
                                    <div class="box">

										<form  method="get" action="admin/change-shipment-status" autocomplete="off">
											
										<div class="box-header">
											<div class="pull-right">
												<div class="col-sm-2">
												</div>
												<div class="col-sm-3">
													<div class="form-group">
														<label>Customer Name:</label>
														<select class="form-control"  name="customer_account_id" id="customer_account_id">
															<option value="">Select Customer</option>
															<?php
															if (count($customers)) {
																foreach ($customers as $rows) {
																	?>
																	<option <?php echo (isset($_GET['customer_account_id'] ) && $_GET['customer_account_id'] == $rows['customer_id']) ? 'selected=""' : ''; ?> value="<?php echo $rows['customer_id']; ?>">
																		<?php echo $rows['customer_name']; ?>--<?php echo $rows['cid']; ?> 
																	</option>
																	<?php
																}
															} else {
																echo "<p>No Data Found</p>";
															}
															?>
														</select>
													</div>
												</div>
												<div class="col-sm-3">
													<div class="form-group">
														<label>Booking Form Date :</label>
														<input type="text" name="from" value="<?php echo (isset($_GET['from']))?$_GET['from']:''; ?>" class="form-control datepicker" />
													</div>
												</div>
												<div class="col-sm-3">
													<div class="form-group">
														<label>Booking To Date :</label>
														<input type="text" name="to" value="<?php echo (isset($_GET['to']))?$_GET['to']:''; ?>" class="form-control datepicker" />
													</div>
												</div>
												<div class="col-sm-1">
													<button type="submit" style="margin-top: 26px;" class="btn btn-sm btn-primary">Apply</button>
												</div>
											</div>
										</div>
										<input type="hidden" name="filter" value="customerwise" />
										</form>
										<form action="admin/change-bulk-shipment-status" method="POST" autocomplete="off"  enctype="multipart/form-data"> 
                                        <div class="box-body table-responsive">
										<table id="example2" class="table table-bordered table-hover">
										   <thead>
											  <tr>

          <th></th>
         <th>Doc No</th>
         <th>Sender Name</th>
         <th>Sender City</th>
         <th>Receiver Name </th>
         <th>Receiver City</th>
         <th>Forworder Name</th>
         <th>Forwording No.</th>
		 <th>Booking date</th>
		 <th>EDD</th>
         <th>Status</th>
         <th>Status Description</th>
         
      </tr>
   </thead>
   <tbody>
       <?php
	   if(!empty($allpoddata))
	   {
             foreach ($allpoddata as $booking_row) {
                                                                       
       ?>
                <tr>
                    <td>
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup" name="checkbox[]"
                                                        class="custom-control-input"
                                                        id="checkbox-<?php echo $booking_row['pod_no']; ?>"
                                                        value="<?php echo $booking_row['pod_no']; ?>">
                                                    <label for="checkbox-<?php echo $booking_row['pod_no']; ?>"
                                                        class="custom-control-label">&nbsp;</label>
                                                </div>
                                            </td>
                  <td><?php echo $booking_row['pod_no'];?></td>
                  <td><?php echo $booking_row['sender_name']?></td>
                  <?php
                  foreach ($citydata as $sender_city) {
                      if($sender_city['city_id'] == $booking_row['sender_city']){
                  ?>
                        <td><?php echo $sender_city['city_name']?></td>
                  <?php
                        }
                    }

                  ?>
                  <td><?php echo $booking_row['reciever_name']?></td>
                  <?php
                  foreach ($citydata as $reciever_city) {
                      if($reciever_city['city_id'] == $booking_row['reciever_city']){
                  ?>
                        <td><?php echo $reciever_city['city_name']?></td>
                  <?php
                        }
                    }

				  ?>
				  <td><?php echo $booking_row['forworder_name']?></td>
				  <td><?php echo $booking_row['forwording_no']?></td>

				<td><?php echo date('d-m-Y H:i:s',strtotime($booking_row['booking_date']));?></td>
				<td><?php echo date('d-m-Y', strtotime($booking_row['delivery_date'])); ?></td>	
				  <td><?php echo $booking_row['delivery_status']?></td>
				  <td><?php echo $booking_row['comment']?></td>
				  
                </tr>
                
        <?php
              }
              }

        ?>
                
   </tbody>
</table>
                                                <div class="col-md-6">

                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Date</label>
                                                        <input type="datetime-local" class="form-control" id="jq-validation-email" name="currentdate" placeholder="Date">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Status</label>
                                                        <select class="form-control" name="status" id="" required>
                                                            <option value="Intransit">Intransit</option>
                                                            <option value="Delivered">Delivered</option>
                                                            <option value="Out for Delivery">Out for Delivery</option>
                                                            <option value="Short Delivered">Short Delivered</option>
                                                            <option value="Undelivered">Undelivered</option>
                                                            <option value="Pending">Pending</option>
                                                            <option value="Hold">Hold</option>
                                                            <option value="Miss Route">Miss Route</option>
                                                            <option value="Incomplete Address">Incomplete Address</option>
                                                            <option value="Wrong Address">Wrong Address</option>
                                                            <option value="No Service Area">No service area</option>
                                                            <option value="Return to Origin">Return to Origin</option>
                                                            <option value="Lossed">Lossed</option>
                                                            
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Comment</label>
                                                        <textarea name="comment" class="form-control" placeholder="Add comment here ..."></textarea>

                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label>Remark</label>
                                                        <textarea name="Remark" class="form-control" placeholder="Add Remark here ..."></textarea>

                                                    </div>
                                                    
                                                    <div class="col-md-7">
													<div class="form-group">
					<label for="exampleInputEmail1">Pod csv:</label>
					<input type="file" class="form-control" id="jq-validation-email" name="csv_zip" accept=".csv" placeholder="Slider Image">
				</div>
                                                    </div>
                                                    <div class="col-md-4">	
                                                        <div class="box-footer">
                                                            <button type="submit" name="submit"  class="btn btn-primary">Submit</button>
                                                        </div>
                                                    </div>
                                                </div>

                                        </div>
										</form>
                                        <!-- /.box-body -->
                                    </div>
                                    <!-- /.box -->
                                </div>
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

<script>
		
$(document).ready(function() {
    
      $("#custome_data").click(function(){


       var awb_no = $("#awb_no").val();
       
        $.ajax({
           url: "Admin_tracking/awbnodata",
           type: 'POST',
           dataType: "html",
           data: {awb_no: awb_no},
           error: function() {
              alert('Please Try Again Later');
           },
           success: function(data) {
            //console.log(data);
            $("#change_status_id").append(data);
            if(data !=""){
                
            }
                
                //alert("Record added successfully");  
           }
        });


    });

	$('.datepicker').datepicker({
		format : 'dd/mm/yyyy' 
	});
	
    $('#selectsingle').select2();
    
    
    $("#selectsingle").change(function(){
        
        var customer_name=$(this).val();
        if (customer_name!=null || customer_name!='') {
            
            $.ajax({
              type:'POST',
              url:'Admin_tracking/showinfo',
              data:'pod_no='+customer_name,
              success:function(d){
               $('#trackinghistory').html(d);
              }
            });
        }else{

        }

    });
   $(document).on('click', '.remove-rec', function() {
        
        $(this).parent().parent().remove();
        

    });

    
});	

$(function () {
    // $('#example1').DataTable({
    //     'paging'      : true,
    //   'lengthChange': true,
    //   "pageLength": 100,
    //   'searching'   : true,
    //   'ordering'    : true,
    //   'info'        : true,
    //   'autoWidth'   : false
    // });
	$('#example2').DataTable({
        'paging'      : true,
      'lengthChange': true,
      "pageLength": 100,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })		
	</script>
