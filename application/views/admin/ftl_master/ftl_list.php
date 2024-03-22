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
    <?php include(dirname(__FILE__).'/../admin_shared/admin_sidebar.php'); ?>
        <!-- START: Main Content-->
        <main>
            <div class="container-fluid site-width">
                <!-- START: Listing-->
                <div class="row">                 
                  <div class="col-12  align-self-center">
                      <div class="col-12 col-sm-12 mt-3">
                      <div class="card">
                          <div class="card-header justify-content-between align-items-center">   
							 <br><br>                            
                              <h4 class="card-title">FTL List</h4>
                               <span style="float: right;"><a href="admin/add-lr" class="fa fa-plus btn btn-primary">+ Add LR</a></span> 
                             <!--<span style="float: right;">-->
                             <!--    <a href="admin/view-add-domestic-shipment" class="btn btn-primary">Add Domestic Shipment</a>-->
                             <!--	<button type="button" id="select_multiple_camp" class="btn btn-primary">Print Selected Shipment</button>-->
                             <!--</span>-->
                          </div>

						  <div class="card-header">
                          <div class="card-body">
                              	<?php if($this->session->flashdata('notify') != '') {?>
                                  <div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
                                  <?php  unset($_SESSION['class']); unset($_SESSION['notify']); } ?> 
                              <div class="table-responsive">
                                 <table class="display table dataTable table-striped table-bordered layout-primary" data-sorting="true">
                                      <thead>
                                          <tr>
										    <th  scope="col">lr.No.</th>
										    <th  scope="col">Sender Name</th>
										    <th  scope="col">Sender city</th>
										    <th  scope="col">Pincode</th>
										    <th  scope="col">Receiver Name</th>
										    <th  scope="col">Receiver Pincode</th>
										    <th  scope="col">Receiver City</th>
										    <th  scope="col">Order Number</th>
										    <th  scope="col">Vehicle Type</th>
										    <th  scope="col">Booking date</th>
											<th  scope="col">Product Name</th>
											<th  scope="col">Product Weight</th>
											<th  scope="col">Invoice No</th>
											<th  scope="col">Invoice Amount</th>
											<th  scope="col">Bill Type</th>
											<th>Action</th>
                                          </tr>
                                      </thead>
                                      <?php // print_r($ftl_list);?>
                                   <tbody>
                                          <?php if(!empty($ftl_list)){?>
                                           <?php foreach($ftl_list as $value):?>
                                           <tr>
                                             <td><?= $value->lr_number ;?></td>
                                             <td><?= $value->sender_name ;?></td>
                                             <td><?= $value->sender_city ;?></td>
                                             <td><?= $value->sender_pincode ;?></td>
                                             <td><?= $value->reciever_name ;?></td>
                                             <td><?= $value->reciever_pincode ;?></td>
                                             <td><?= $value->reciever_city ;?></td>
                                             <td><?= $value->order_number ;?></td>
                                             <?php $dd1 = $this->db->query("select vehicle_name from vehicle_type_master where id='".$value->type_of_vehicle."'")->row_array();?>
                                             <td><?= $dd1['vehicle_name'] ;?></td>
                                             <td><?= $value->booking_date ;?></td>
                                             <td><?= $value->product_name ;?></td>
                                             <td><?= $value->product_weight ;?></td>
                                             <td><?= $value->invoice_number ;?></td>
                                             <td><?= $value->invoice_value ;?></td>
                                             <td><?= $value->dispatch_details ;?></td>
                                             <td><a href="<?= base_url('admin/lr-printlabel/'.$value->lr_id);?>"><i class="fa fa-print" style="font-size:24px;color:blue;"></i></a></td>
                                            </tr>
                                           <?php endforeach;?>  
                                         <?php }else{ ?>
                                         <tr><td class="text-red text-center" colspan="20">No Data</td></tr>
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
        <!-- END: Content-->
        <!-- START: Footer-->
        
        <?php  include(dirname(__FILE__).'/../admin_shared/admin_footer.php'); ?>
        <!-- START: Footer-->
    </body>
    <!-- END: Body-->
</html>
<script>
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
				window.location = 'Admin_domestic_shipment_manager/all_printpod/'+favorite+'-'+nes;
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
				window.location = 'Admin_domestic_shipment_manager/all_printpod/'+favorite;
			}
			else
			{
				alert('Pleaese choose at least one Shipment');
			}
		}	
	});
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
				window.location = 'Admin_domestic_shipment_manager/all_printpod/'+favorite+'-'+nes;
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
				window.location = 'Admin_domestic_shipment_manager/all_printpod/'+favorite;
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
                <form name="filterpod" id="filterpod" action="Admin_domestic_shipment_manager/all_printpod" method="POST">
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
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.full.js"></script>
<script>
function matchStart (term, text) {
  if (text.toUpperCase().indexOf(term.toUpperCase()) == 0) {
    return true;
  }
 
  return false;
}
 
$.fn.select2.amd.require(['select2/compat/matcher'], function (oldMatcher) {
  $("#user_id").select2({
    matcher: oldMatcher(matchStart)
  })

});
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
			   		url: baseurl+'Admin_domestic_shipment_manager/delete_domestic_shipment',
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