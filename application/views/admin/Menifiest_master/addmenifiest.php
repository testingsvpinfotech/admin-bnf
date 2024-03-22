     <?php $this->load->view('admin/admin_shared/admin_header'); ?>
    <!-- END Head-->
<style>
  	.input:focus {
    outline: outline: aliceblue !important;
    border:2px solid red !important;
    box-shadow: 2px #719ECE;
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
                              <h4 class="card-title">Add Menifiest</h4>  
                          </div>
                          <div class="card-body">
                          	 <?php if($this->session->flashdata('notify') != '') {?>
  <div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
  <?php  unset($_SESSION['class']); unset($_SESSION['notify']); } ?>                             
						   <div class="row">                                           
                            <div class="col-12"> 
								<form role="form" action="admin/insert-menifiest" method="post" enctype="multipart/form-data">

								<div class="form-group row" >
									
									<label  class="col-sm-2 col-form-label">Manifiest Date</label>
									<div class="col-sm-2">
										<!--<input type="datetime-local" class="form-control" name="datetime" id="col-sm-1 col-form-label" >-->

										<?php 
											$datec = date('Y-m-d H:i');

											// $tracking_data[0]['tracking_date'] = date('Y-m-d H:i',strtotime($tracking_data[0]['tracking_date']));
                                      		$datec  = str_replace(" ", "T", $datec);
											

											// $datec = dateTimeValue($datec);
											// $datec = str_replace(' ', 'T', $datec);
										?>
										<input type="datetime-local" readonly required class="form-control"  name="datetime" value="<?php echo $datec;?>" id="menifest_back" min="<?= date('Y-m-d', strtotime("-1 days")).'T'.date('H:i'); ?>" max="<?= date('Y-m-d').'T'.date('H:i'); ?>">
									</div>
									
									<label  class="col-sm-2 col-form-label">Vehicle No</label>
									<div class="col-sm-2">
										<input type="text" name="lorry_no" class="form-control" />
									</div>
									<label  class="col-sm-2 col-form-label">Route Name</label>
									<div class="col-sm-2">
										<select name="route_id" class="form-control" id="route_id" required>
											<option>Select Route</option>
											<?php foreach ($allroute as $value) {
												?>
												<option value="<?php echo $value['route_id'];?>"><?php echo $value['route_name'];?></option>
												<?php 
											} ?>
										</select>
									</div>
								</div>
								<div class="form-group row">
															
									<label  class="col-sm-2 col-form-label">Driver Name</label>
									<div class="col-sm-2">
										<input type="text" name="driver_name" class="form-control" />
									</div>
									<label  class="col-sm-2 col-form-label"> Driver Contact No</label>
									<div class="col-sm-2">
										<input type="text" name="contact_no" class="form-control manifest_driver_contact"  maxlength="10" minlength="10"/>
									</div>
									<label  class="col-sm-2 col-form-label">Destination Branch</label>
									<div class="col-sm-2">
									<select name="destination_branch" class="form-control" id="destination_branch" required>
										<!-- <select name="destination_branch" class="form-control" id="destination_branch"  required> -->
											<option value="">Select Branch</option>
											<?php 
												$branch_id = $_SESSION['branch_id'];
												$franchise1 = $this->db->query("select *,tbl_franchise.cmp_area as cmp_area from tbl_customers join tbl_franchise on tbl_franchise.fid = tbl_customers.customer_id where branch_id = '$branch_id' AND (customer_type ='1' OR customer_type ='2') ")->result();
															
											foreach ($all_branch as $value) {
												if($value->branch_id != 39 && $value->branch_id != 70){
												?>
												<option value="<?php echo $value->branch_name;?>"><?php echo $value->branch_name;?></option>
												<?php 
											}}?>
											<?php foreach($franchise1 as $val){ ?>
											<option value = "<?= $val->customer_id; ?>">To <?= " ".$val->customer_name."_".$val->cmp_area;?> Franchise</option>
										  <?php } ?>
										</select>
									</div>
									
								</div>
								<div class="form-group row">
								<label  class="col-sm-2 col-form-label">Vendor</label>
									<div class="col-sm-2">
										<select name="vendor_id" class="form-control" id="vendor_id" required>
											<option>Select Vendor</option>
											<?php foreach ($all_vendor as $value) {
												?>
												<option value="<?php echo $value->tv_id;?>"><?php echo $value->vendor_name;?></option>
												<?php 
											} ?>
										</select>
									</div>
									 <label  class="col-sm-2 col-form-label">Forworder Name</label>
									<div class="col-sm-2">
										<select name="forwarder_name" class="form-control" id="forwarderName" required>
											<option value="">Select Forworder Name</option>
											<?php foreach ($courier_company as $value) {
												?>
												<option value="<?php echo $value['c_company_name'];?>" selected><?php echo $value['c_company_name'];?></option>
												<?php 
											} ?>
										</select>
									</div>
										<label  class="col-sm-2 col-form-label">Coloader</label>
									<div class="col-sm-2">
										<select name="coloader" class="form-control" id="coloader" >
											<option value="">Select Coloader </option>
											<?php foreach ($coloader_list as $value) {
												?>
												<option value="<?php echo $value['coloader_name'];?>"><?php echo $value['coloader_name'];?></option>
												<?php 
											} ?>
										</select>
									</div>	
								    <label  class="col-sm-2 col-form-label">Coloader Contact</label>
									<div class="col-sm-2">
										<input type="text" name="coloder_contact" class="form-control manifest_coloader_contact" maxlength="10" minlength="10"/>
									</div>										
								    <label  class="col-sm-2 col-form-label">CD No</label>
									<div class="col-sm-2">
										<input type="text" name="cd_no" class="form-control" />
									</div>										
									<label  class="col-sm-2 col-form-label">Mode</label>
									<div class="col-sm-2">
									<select name="forwarder_mode"  class="form-control" id="forwarder_mode" required>
										<option value="">Select Forworder Mode</option>
										<option value="All">All</option>
										<?php foreach ($mode_list as $value) {
										?>
										<option value="<?php echo $value['mode_name'];?>"><?php echo $value['mode_name'];?></option>
										<?php 
									} ?>
									</select>
									</div>
									<label  class="col-sm-2 col-form-label">Supervisor</label>
									<div class="col-sm-2"> 
									<select name="supervisor" class="form-control" id="supervisor" required>
										<option value="">Select Supervisor</option>
										<?php foreach ($supervisor as $value) {
										?>
										<option value="<?php echo $value['full_name'];?>"><?php echo $value['full_name'];?></option>
										<?php 
									} ?>
									</select>
									</div>
									<label  class="col-sm-2 col-form-label">Minifested By</label>
									<div class="col-sm-2">										
										<input type="text" readonly name="username" required value="<?= $username;?>" class="form-control"/>
									</div>
									<label  class="col-sm-2 col-form-label">Total Pcs</label>
									<div class="col-sm-2">										
										<input type="text" readonly name="total_pcs" required id="total_pcs" class="form-control"/>
									</div>
									<label  class="col-sm-2 col-form-label">Total Weight</label>
									<div class="col-sm-2">
										<input type="text" readonly name="total_weight" required id="total_weight" class="form-control"/>
									</div>
									<label  class="col-sm-2 col-form-label">Remark</label>
									<div class="col-sm-2">
										<textarea class="form-control" name="note"> </textarea>
									</div>
								
												<label  class="col-sm-2 col-form-label bkdate_meni_check" id="bkdate_meni_check" style="display:none;">Back Date Reason<span class="compulsory_fields" >*</span></label>
												<div class="col-sm-2 bkdate_meni_check" id="bkdate_meni_check" style="display:none;">
													<textarea type="text" name="bkdate_reason" id="bkdate_meni_reason" class="form-control" value="<?php //echo $bid; ?>"></textarea>
												</div>
										
								<!-- 	
									<label  class="col-sm-2 col-form-label">Pod csv</label>
									<div class="col-sm-2">
										<input type="file" class="form-control" id="jq-validation-email" name="csv_zip" accept=".csv" placeholder="Slider Image">
									</div> -->
								</div>
								
								<div class="col-md-3">
								<div class="box-footer pull right">
								<button type="submit" name="submit"  class="btn btn-primary">Submit</button>
								</div>

								</div>
								<div class="col-md-12" id="search" style="display: none;">
								<input type="text" id="search_data" placeholder="Enter Bag No" style="float: right;" >
								<input type="button" id="btn_search" style="float: right;"  value="Search">
								<br>
								</div>
								<div class="col-md-12">

								<!--  col-sm-4--> 
									<table class="table table-bordered table-striped">
										<thead>
										<tr>
											<th></th>
											<th>Bag No.</th>
											<th>Weight</th>
											<th>Mode</th>
											<th>NOP</th>
											
										</tr>
										</thead>
										<tbody id="change_status_id">
										</tbody>

									</table> 
								<!--  box body-->
								</div>
								</form> 
                      </div>
                    </div> 

                </div>
            </div>
            <!-- END: Listing-->
        </div>
    </main>
    <!-- END: Content--> <?php ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');
error_reporting(E_ALL); ?>
    <!-- START: Footer-->
    <?php $this->load->view('admin/admin_shared/admin_footer');
	
     //include('admin_shared/admin_footer.php'); ?>
	 <script src="assets/js/domestic_shipment.js"></script>
    <!-- START: Footer-->
</body>
<script type="text/javascript" src="<?php echo base_url();?>assets/jQueryScannerDetectionmaster/jquery.scannerdetection.js"></script>
<script type="text/javascript">
$(document).scannerDetection({
	timeBeforeScanTest: 200, // wait for the next character for upto 200ms
	startChar: [120], // Prefix character for the cabled scanner (OPL6845R)
	endChar: [13], // be sure the scan is complete if key 13 (enter) is detected
	avgTimeByChar: 40, // it's not a barcode if a character takes longer than 40ms
	onComplete: function(barcode, qty){ 
		var forwording_no= barcode;
			
			var forwarderName  = $("#forwarderName").val();
			var forwarder_mode  = $("#forwarder_mode").val();

			var message = '';

				$("input[name='pod_no[]']").map(function(){
					var numbers = $(this).val();

					var number = numbers.split("|");

					if (number[0]==forwording_no) {
						message ='This Forwording No Already Exist In The List!';
						// return false;
					}
				}).get();

				if (message!='') {
					alert(message);
					return false;
				}
				$.ajax({
					   url: "<?php  echo base_url().'Admin_domestic_menifiest/bagdata'; ?>",
					   type: 'POST',
					   dataType: "html",
					   data: {forwording_no: forwording_no,forwarderName:forwarderName,forwarder_mode:forwarder_mode},
					   error: function() {
						  alert('Please Try Again Later');
					   },
					   success: function(data) {
						console.log(data);
						
						if(data !=""){
						  $("#change_status_id").prepend(data);  
						  var array = []; 
						
							tw=0;
							tp =0;
				
						$("input.cb[type=checkbox]:checked").each(function() { 
							
							tw = tw + parseFloat($(this).attr("data-tw"));
							tp = tp + parseFloat($(this).attr("data-tp"));
						
								 }); 
						 
							document.getElementById('total_weight').value = tw;
							document.getElementById('total_pcs').value = tp;
						 
						}
						else{
						  $("#change_status_id").prepend('');  
						}
						 $("#search_data").val('');  
							$( "#search_data" ).focus();
							//alert("Record added successfully");  
					   },
					   error:function(response)
						{
							console.log(response);
						}
					});
		} // main callback function	
});
</script>
<!-- END: Body-->
        <script type="text/javascript">
          $(document).ready(function()
		  {

			   $(".desti").prop('required',true);

			   $("form[name='generatePOD']").validate({
				rules: {
					destination_branch: "required",
				},
				minimumField: {
					min: function(element){
						return $("#destination_branch").val()!="";
					}
				},
				messages: {
					destination_branch: "required"
				},
				
				submitHandler: function(form) {
					form.submit();
				}
			});

		$("form[name='generatePOD']").validate();


			   $(window).keydown(function(event)
			  {
				if(event.keyCode == 13) 
				{
					 //var awb_no=$(this).val();
					var forwording_no=$("#search_data").val();
					var forwarderName  = $("#forwarderName").val();
					var forwarder_mode  = $("#forwarder_mode").val();
			
					if(forwording_no!=""){	 


						var message = '';

				$("input[name='pod_no[]']").map(function(){
					var numbers = $(this).val();

					var number = numbers.split("|");

					if (number[0]==forwording_no) {
						message ='This Forwording No Already Exist In The List!';
						// return false;
					}
				}).get();

				if (message!='') {
					alert(message);
					return false;
				}
					 $.ajax({
					 	url: "Admin_domestic_menifiest/bagdata",
					    type: 'POST',
					    dataType: "html",
					    data: {forwording_no: forwording_no,forwarderName:forwarderName,forwarder_mode:forwarder_mode},
					    success: function(data) {
							console.log(data);							
									if(data !=""){
									  $("#change_status_id").prepend(data);  
									  var array = []; 
									
										tw=0;
										tp =0;
							
									$("input.cb[type=checkbox]:checked").each(function() { 
										
										tw = tw + parseFloat($(this).attr("data-tw"));
										tp = tp + parseFloat($(this).attr("data-tp"));
									
											 }); 
									 
										document.getElementById('total_weight').value = tw.toFixed(2);
										document.getElementById('total_pcs').value = tp;
									}
									else{
									  $("#change_status_id").prepend('');  
									}
						$("#search_data").val('');  
						}

					 });
					 
				}else{
				    alert("Please enter Forwording no");
				}
				
				}
			  });
			  
			  
			   $("#btn_search").click(function()
				{
					 //var awb_no=$(this).val();
					var forwording_no=$("#search_data").val();
					var forwarderName  = $("#forwarderName").val();
					var forwarder_mode  = $("#forwarder_mode").val();

					

					// console.log(all);
			
					if(forwording_no!=""){	

						forwording_no = forwording_no.trim(); 

						var message = '';

						$("input[name='pod_no[]']").map(function(){
							var numbers = $(this).val();

							var number = numbers.split("|");

							if (number[0]==forwording_no) {
								message ='This AWB No Already Exist In The List!';
								// return false;
							}
						}).get();

						if (message!='') {
							alert(message);
							return false;
						}
					 $.ajax({
					 	url: "Admin_domestic_menifiest/bagdata",
					    type: 'POST',
					    dataType: "html",
					    data: {forwording_no: forwording_no,forwarderName:forwarderName,forwarder_mode:forwarder_mode},
					    success: function(data) {
							console.log(data);							
									if(data !=""){
									  $("#change_status_id").prepend(data);  
									  var array = []; 
									
										tw=0;
										tp =0;
							
									$("input.cb[type=checkbox]:checked").each(function() { 
										
										tw = tw + parseFloat($(this).attr("data-tw"));
										tp = tp + parseFloat($(this).attr("data-tp"));
									
											 }); 
									 
										document.getElementById('total_weight').value = tw.toFixed(2);
										document.getElementById('total_pcs').value = tp;
										 $("#search_data").val('');  
									}
									else{
									  $("#change_status_id").prepend('');  
									}
									$( "#search_data" ).focus();
									
						}

					 });
					 
				}else{
				    alert("Please enter Forwording no");
				}
			
			
						
			});

        $("#podbox").change(function(){
        
        var podno=$(this).val();
        if (podno!=null || podno!='') {
            
            $.ajax({
              type:'POST',
              url:'<?php echo base_url()?>menifiest/getPODDetails',
              data:'podno='+podno,
              success:function(d)
              {
                //alert(d);
                  var x=d.split("-");
                //alert(x);
                   $(".consignername").val(x[0]);
                  
                   $(".pieces").val(x[2]);
                   $(".weight").val(x[3]);
              }
            });
        }else{

        }

    });
    
    
    var tw ;
    var tp ;
    
	$(document).on("click", ".cb", function () {
     
         
            var array = []; 
            
			tw=0;
			tp =0;
    
            $("input.cb[type=checkbox]:checked").each(function() { 
                
                tw = tw + parseFloat($(this).attr("data-tw"));
                tp = tp + parseFloat($(this).attr("data-tp"));
		
            
                     }); 
             
                document.getElementById('total_weight').value = tw;
                document.getElementById('total_pcs').value = tp;

        });
        
        
    
     $('#example1').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true
      
    });
  });
  $(document).keypress(
  function(event){
    if (event.which == '13') {
      event.preventDefault();
    }
});

$("#forwarder_mode").change(function(){

$('#search').show();
});

$('#bkdate_meni_check').css({"display":"none"});
	$("#menifest_back").change(function(){
		let dt = $("#menifest_back").val();
		var bdt = new Date(dt);
		var bmonth = bdt.getMonth()+1; var bday = bdt.getDate();
		var boutput = bdt.getFullYear() + '/' + (bmonth<10 ? '0' : '') + bmonth + '/' +  (bday<10 ? '0' : '') + bday;

		var d = new Date();
		var month = d.getMonth()+1; var day = d.getDate();

		var output = d.getFullYear() + '/' + (month<10 ? '0' : '') + month + '/' +  (day<10 ? '0' : '') + day;
		if(output == boutput){
			// $("#bkdate_reason").attr("required", "false");
			$("#bkdate_meni_reason").removeAttr("required");
			$('.bkdate_meni_check').css({"display":"none"});
		}else{
			$("#bkdate_meni_reason").attr("required", "true");
			$('.bkdate_meni_check').css({"display":"flex"});
		}
	});


</script>

<?php 

function dateTimeValue($timeStamp)
{
    $date = date('d-m-Y',$timeStamp);
    $time = date('H:i:s',$timeStamp);
    return $date.'T'.$time;
}

?>