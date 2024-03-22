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
                              <h4 class="card-title">Edit Airlines Flight</h4>
                          </div>
						    <div class="card-content">
                          <div class="card-body">
						   <div class="row">                                           
                            <div class="col-12">
                             <form role="form" action="admin/updateairlinesFlight/<?php echo $Flight_info->af_id; ?>" method="post" >
								<div class="box-body">
									<div class="form-group row">
										<label  class="col-sm-1 col-form-label">Select Airlines:</label>
										<div class="col-sm-2">
											<select class="form-control"  name="aid" required id="customer_account_id">
												<option value="">Select Branch Name</option>
												<?php 
												if(!empty($airlines_company))
												{
												foreach ($airlines_company as $rows ) 
												{ 		 
												?>
												<option value="<?php echo $rows->a_id; ?>" <?php echo ($Flight_info->aid == $rows->a_id)?'selected':'';?>><?php echo $rows->ac_name; ?></option>
												<?php 
												}
												}
												else
												{
												echo "<option>No Airlines Found</option>";
												}
												?>
											</select>
										</div>
									
										<label  class="col-sm-1 col-form-label">Origin Code:</label>
										<div class="col-sm-2">
											<input type="text" class="form-control" id="search-box" name="origin_code" placeholder="Enter Origin Code" value="<?php echo $Flight_info->origin_code; ?>"  required autocomplete="off">
											<div id="suggesstion-box"></div>
										</div>
									
										<label  class="col-sm-1 col-form-label">Destination Code:</label>
										<div class="col-sm-2">
											<input type="text" class="form-control" name="destination_code" id="search-boxx" placeholder="Enter Destination Code" value="<?php echo $Flight_info->destination_code; ?>"  required autocomplete="off">
											<div id="suggesstion-boxx"></div>
										</div>
									
									
										<label  class="col-sm-1 col-form-label">Flight Code:</label>
										<div class="col-sm-2">
											<input type="text" class="form-control" name="flight_code" placeholder="Enter Flight Code" value="<?php echo $Flight_info->flight_code; ?>"  required>
										</div>
									
										<label  class="col-sm-1 col-form-label">Flight Frequcny:</label>
										<div class="col-sm-2">
											<input type="text" class="form-control" name="frequency" placeholder="Enter Flight Frequcny" value="<?php echo $Flight_info->frequency; ?>"  required>
										</div>
									
									<label  class="col-sm-1 col-form-label">ETD:</label>
										<div class="col-sm-2">
											<input type="time" class="form-control" name="etd" placeholder="Enter ETD" value="<?php echo $Flight_info->etd; ?>"  required>
										</div>
									
										<label  class="col-sm-1 col-form-label">ETA:</label>
										<div class="col-sm-2">
											<input type="time" class="form-control" name="eta" placeholder="Enter ETA" value="<?php echo $Flight_info->eta; ?>"  required>
										</div>
									
										<div class="col-sm-2">
											<button type="submit"  class="btn btn-primary">Update Airlines Flight</button>
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