<?php include(dirname(__FILE__).'/../admin_shared/admin_header.php'); ?>
    <!-- END Head-->
<style>

.frmSearch {border: 1px solid #a8d4b1;background-color: #c6f7d0;margin: 2px 0px;padding:40px;border-radius:4px;}
#country-list{float:left;list-style:none;margin-top:-3px;padding:0;width:190px;position: absolute;z-index: 7;}
#country-list li{padding: 10px; background: #f0f0f0; border-bottom: #bbb9b9 1px solid;}
#country-list li:hover{background:#ece3d2;cursor: pointer;}
#search-box{padding: 10px;border: #a8d4b1 1px solid;border-radius:4px;}
#search-boxx{padding: 10px;border: #a8d4b1 1px solid;border-radius:4px;}
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
                  <div class="col-12">
                      <div class="col-12 col-sm-12 mt-3">
                      <div class="card">
					  
                          <div class="card-header">                               
                              <h4 class="card-title">Add Airlines Charge</h4>
                          </div>
						    <div class="card-content">
                          <div class="card-body">
						   <div class="row">                                           
                            <div class="col-12">
                             <form role="form" action="admin/insertairlinescharges" method="post" >
								<div class="box-body">
									<div class="form-group row">					
									  
										  <label class="col-sm-1 col-form-label">Charge Name:</label>
										 <div class="col-sm-2">
										  <input type="text" class="form-control" name="charge_name" placeholder="Enter Charge Name" required>
										</div>
										
									   
										  <label class="col-sm-1 col-form-label">Flight type:</label>
										<div class="col-sm-2">
										  <select class="form-control"  name="flight_type" required >
										  <option value="All">All</option>
											<?php 
											if(!empty($flight_type))
											{
												foreach ($flight_type as $rows ) 
												{ 		 
												?>
													<option value="<?php echo $rows->type_name; ?>"><?php echo $rows->type_name; ?></option>
												<?php 
												}
											}
											else
											{
											  echo "<option>No Flight type Found</option>";
											}
											?>
										  </select>
										</div>
										
									  
									  
										  <label class="col-sm-1 col-form-label">Effective Date:</label>
										 <div class="col-sm-2">
										  <input type="date" class="form-control" name="effective_date" placeholder="Enter Effective Date" >
										
										
									  </div>
									   
										  <label class="col-sm-1 col-form-label">Inbound Min Weight:</label>
										 <div class="col-sm-2">
										  <input type="text" class="form-control" name="inbound_min_weight" placeholder="Enter Min Weight" required>
										</div>
										
									  
									  
										  <label class="col-sm-1 col-form-label">Inbound Per KG Charge:</label>
										 <div class="col-sm-2">
										  <input type="text" class="form-control" name="inbound_per_kg_charge" placeholder="Enter Per KG Charge" required>
										</div>
										

									 
										  <label class="col-sm-1 col-form-label">Inbound Minimum Charge:</label>
										 <div class="col-sm-2">
										  <input type="text" class="form-control" name="inbound_minimum_charge" placeholder="Enter Minimum Charge" required>
										</div>

									 
									 
										  <label class="col-sm-1 col-form-label">Outbound Min Weight:</label>
										 <div class="col-sm-2">
										  <input type="text" class="form-control" name="outbound_min_weight" placeholder="Enter Min Weight" required>
										</div>
										
									 
									 
										  <label class="col-sm-1 col-form-label">Outbound Per KG Charge:</label>
										 <div class="form-group">
										  <input type="text" class="form-control" name="outbound_per_kg_charge" placeholder="Enter Per KG Charge" required>
										</div>
										
									  
									  
										  <label class="col-sm-1 col-form-label">Outbound Minimum Charge:</label>
										 <div class="col-sm-2">
										  <input type="text" class="form-control" name="outbound_minimum_charge" placeholder="Enter Minimum Charge" required>
										</div>
										
									  
									  
										  <label class="col-sm-1 col-form-label">Destination:</label>
										 <div class="col-sm-2">
										  <input type="text" class="form-control" id="search-box"  name="destination" placeholder="Enter Destination Charge" >
										   <div id="suggesstion-box"></div>
										</div>
										
									  
									 
									  
										  <label class="col-sm-1 col-form-label">Is Commodities Charge:</label>
										 <div class="col-sm-2">
										  <input type="checkbox"  name="commodities" >
										 
										</div>
										<input type="hidden" name="airline_id" value="<?php echo $airline_id; ?>">
									  
									
										<div class="col-sm-2">
											<button type="submit"  class="btn btn-primary">Add Airlines Flight</button>
										</div>
									</div>
									<!-- /.box-body -->


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
        
        <?php  include(dirname(__FILE__).'/../admin_shared/admin_footer.php'); ?>
        <!-- START: Footer-->
    </body>
    <!-- END: Body-->
</html>
<script type="text/javascript">
 
  // AJAX call for autocomplete 
	
		$("#search-box").keyup(function(){
			$.ajax({
			type: "POST",
			url: "Admin_airlines_manager/getairportcode",
			data: {'keyword':$(this).val(),'box':'1'},
			beforeSend: function(){
				$("#search-box").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
			},
			success: function(data){
				$("#suggesstion-box").show();
				$("#suggesstion-box").html(data);
				$("#search-box").css("background","#FFF");
			}
			});
		});

	//To select country name
	function selectCountry(val) 
	{
		$("#search-box").val(val);
		$("#suggesstion-box").hide();
	}

	$("#search-boxx").keyup(function(){
			$.ajax({
			type: "POST",
			url: "Admin_airlines_manager/getairportcode",
			data: {'keyword':$(this).val(),'box':'2'},
			beforeSend: function(){
				$("#search-box").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
			},
			success: function(data){
				$("#suggesstion-boxx").show();
				$("#suggesstion-boxx").html(data);
				$("#search-boxx").css("background","#FFF");
			}
			});
		});

	//To select country name
	function selectCountryy(val) 
	{
		$("#search-boxx").val(val);
		$("#suggesstion-boxx").hide();
	}
  
</script>