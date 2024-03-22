<?php include(dirname(__FILE__).'/../admin_shared/admin_header.php'); ?>
    <!-- END Head-->

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
                              <h4 class="card-title">Add Fuel</h4>
                          </div>
						    <div class="card-content">
                          <div class="card-body">
						   <div class="row">                                           
                      <div class="col-12">
                               <form role="form" action="admin/insert_fuel" method="post" >
                								  <div class="box-body">                								 
                									 <div class="form-group row">
                  									  <label for="ac_name" class="col-sm-1 col-form-label">Fuel Courier</label>
									<div class="col-sm-3">
                                        <select class="form-control" name="courier_id" required>
											<option value="" data-id="<?php echo "All" ?>" >--Please Select--</option>
                                            <optgroup label = "Domestic">
											<?php foreach ($courier_company as $cc) 
											{
												if($cc['company_type'] == 'Domestic')
												{
												?>
											<option value="<?php echo $cc['c_id']; ?>" ><?php echo $cc['c_company_name']; ?></option>
											<?php }  }?>
											</optgroup>
											 <optgroup label = "International">
											<?php foreach ($courier_company as $cc) 
											{
												if($cc['company_type'] == 'International')
												{
												?>
											<option value="<?php echo $cc['c_id']; ?>" ><?php echo $cc['c_company_name']; ?></option>
											<?php }  }?>
											</optgroup>
                                        </select>                    									  
									</div>									
                								 
                                  
                                      <label for="ac_name" class="col-sm-1 col-form-label">Fuel Price %</label>
                                      <div class="col-sm-3">
                                        <input type="text" class="form-control" name="fuel_price" value="" placeholder="Enter Fuel Price" required>
                                      </div>                  
                                  </div>
								  <br>
								   <div class="form-group row">
                                      <label for="ac_name" class="col-sm-1 col-form-label">Company Type </label>
                                      <div class="col-sm-3">
                                          <select class="form-control" name="company_type" required>
                                           <option value="Domestic">Domestic</option>
                                           <option value="International">International</option>
                                        </select> 
                                      </div>                  
                                 
                                      <label for="ac_name" class="col-sm-1 col-form-label">Docket Charge </label>
                                      <div class="col-sm-3">
                                        <input type="text" class="form-control" name="docket_charge" value="" placeholder="Enter Docket Charge" required>
                                      </div>                  
                                  </div>
								  <br>
								   <div class="form-group row">
                                      <label for="ac_name" class="col-sm-1 col-form-label">Customer</label>
                                      <div class="col-sm-3">
											  <select class="form-control" name="customer_id" required>
                                           <option value="" >--Please Select--</option>
                                          <?php foreach ($all_customer as $cc) { ?>
                                          <option value="<?php echo $cc['customer_id']; ?>" ><?php echo $cc['customer_name'].' -- '.$cc['cid']; ?></option>
                                         <?php } ?>
                                        </select> 
                                      </div>                  
                                
                                      <label for="ac_name" class="col-sm-1 col-form-label">Fov Min</label>
                                      <div class="col-sm-3">
                                        <input type="text" class="form-control" name="fov_min" value="" placeholder="Enter Fov Min" required>
                                      </div>                  
                                  </div>
								   <br>
								  <div class="form-group row">
								  <label for="ac_name" class="col-sm-1 col-form-label">Fov Above</label>
                                      <div class="col-sm-3">
                                        <input type="text" class="form-control" name="fov_above" value="" placeholder="Enter Fov Above" required>
                                      </div>                  
                                  </div>
								  <br>
								  <div class="form-group row">
                                      <label for="ac_name" class="col-sm-1 col-form-label">Fov Below</label>
                                      <div class="col-sm-3">
                                        <input type="text" class="form-control" name="fov_below" value="" placeholder="Enter Fov Below" required>
                                      </div>                  

                                      <label for="ac_name" class="col-sm-1 col-form-label">Fov Base</label>
                                      <div class="col-sm-3">
                                        <input type="text" class="form-control" name="fov_base" value="" placeholder="Enter Fov Base" required>
                                      </div>                  
                                  </div>
								  <br>
								  <div class="form-group row">
                                      <label for="ac_name" class="col-sm-1 col-form-label">Appointment Min</label>
                                      <div class="col-sm-3">
                                        <input type="text" class="form-control" name="appointment_min" value="" placeholder="Enter Appointment Min" required>
                                      </div>                  

                                      <label for="ac_name" class="col-sm-1 col-form-label">Appointment Per KG</label>
                                      <div class="col-sm-3">
                                        <input type="text" class="form-control" name="appointment_perkg" value="" placeholder="Enter Appointment Per KG" required>
                                      </div>                  
                                  </div>
								  <br>
                                  <div class="form-group row">
                                      <label for="ac_name" class="col-sm-1 col-form-label">Fuel From Date</label>
                                      <div class="col-sm-3">
                                        <input type="date" class="form-control" name="fuel_from" value="" placeholder="Enter Fuel From Date" required>
                                      </div>                  
                                
                                      <label for="ac_name" class="col-sm-1 col-form-label">Fuel To Date</label>
                                      <div class="col-sm-3">
                                        <input type="date" class="form-control" name="fuel_to" value="" placeholder="Enter Fuel To Date" required>
                                      </div>                  
                                  </div>
<br>
									<div class="form-group row">
                                      


                                                       
                                
                                      <label for="ac_name" class="col-sm-1 col-form-label">CFT</label>
                                      <div class="col-sm-3">
                                        <input type="text" class="form-control" name="cft" value="" placeholder="Enter CFT" required>
                                      </div> 


                                      <label for="ac_name" class="col-sm-1 col-form-label">Air CFT</label>
                                      <div class="col-sm-3">
                                        <input type="text" class="form-control" name="air_cft" value="" placeholder="Enter Air CFT" required>
                                      </div> 


                                                       
                                  </div>

                                  <br>

                                  <div class="form-group row">
                                      <label for="ac_name" class="col-sm-1 col-form-label">Calculate Fuel Charge On</label>
                                      <div class="col-sm-3">
                        <div class="radio">
                          <label style="padding-right:20px"><input type="radio" name="fc_type" value="freight" checked>Freight</label>

                          <label><input type="radio" name="fc_type" value="total">Total Amount</label>
                        </div>
                                      </div>
                                    </div>
								<br>
								 <div class="form-group row">
                                      <label for="ac_name" class="col-sm-1 col-form-label">COD Fixed</label>
                                      <div class="col-sm-3">
                                        <input type="text" class="form-control" name="cod" value="" placeholder="Enter COD" required>
                                      </div>                  
                                
                                      <label for="ac_name" class="col-sm-1 col-form-label">ToPay Fixed</label>
                                      <div class="col-sm-3">
                                        <input type="text" class="form-control" name="to_pay_charges" value="" placeholder="Enter To Pay Charges" required>
                                      </div>                  
                                  </div>
								  <div class="form-group row">
								   <div class="col-sm-6">
								   <table class="weight-table" style="border-collapse: separate;border-spacing: 13px;">
                                    <thead>
                                        <tr>
                                            <th>From:</th>
                                            <th>To :</th>
                                            <th>Rate%:</th>
                                            <th><a href="javascript:void(0)" class="add-weight-row btn-success"><i class="fa fa-plus" aria-hidden="true"></i></a>&nbsp;<a href="javascript:void(0)" class="remove-weight-row btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a></th>
                                        </tr>
                                    <thead>
                                    <tbody>
                                        <tr>
                                            <td><input type="text" name="cod_range_from[]" class="form-control col-md-6"  data-attr="1"  ></td>
                                            <td><input type="text" name="cod_range_to[]" class="form-control col-md-6"  data-attr="1"></td>
                                            <td><input type="text" name="cod_range_rate[]"  class="form-control col-md-6"  data-attr="1" ></td>
                                        </tr>
									
                                    </tbody>
                                </table>
								</div>
								 <div class="col-sm-6">
								 <table class="weight-table1" style="border-collapse: separate;border-spacing: 13px;">
                                    <thead>
                                        <tr>
                                            <th>From:</th>
                                            <th>To :</th>
                                            <th>Rate%:</th>
											 <th><a href="javascript:void(0)" class="add-weight-row1 btn-success"><i class="fa fa-plus" aria-hidden="true"></i></a>&nbsp;<a href="javascript:void(0)" class="remove-weight-row1 btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a></th>
                                        </tr>
                                    <thead>
                                    <tbody>
                                        <tr>
                                            <td><input type="text" name="topay_range_from[]" class="form-control col-md-6"  data-attr="1"  ></td>
                                            <td><input type="text" name="topay_range_to[]" class="form-control col-md-6"  data-attr="1"></td>
                                            <td><input type="text" name="topay_range_rate[]"  class="form-control col-md-6"  data-attr="1" ></td>
                                        </tr>
                                    </tbody>
                                </table>
                                                      
                                  </div>
                                  </div>
<br>

                								  <div class="col-md-2">
                    								  <div class="box-footer">
                    									<button type="submit"  class="btn btn-primary">Add Rate</button>
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
<script type="text/javascript">
$(document).ready(function () {
	$(".add-weight-row").on('click', function () {
		
		var allTrs = $('table.weight-table tbody').find('tr');
		var lastTr = allTrs[allTrs.length - 1];
		var $clone = $(lastTr).clone();

		var countrows = $(".one_cft_kg").length;
		$clone.find('td').each(function () {
			var el = $(this).find(':first-child');
			var id = el.attr('id') || null;
			if (id) {
				var i = id.substr(id.length - 1);

				var nextElament = countrows; //parseInt(i)+1;
				
				var remove = 1;
				if (countrows > 10) {
					var remove = 2;
				}
				var removeChar = (id.length - remove);
				var prefix = id.substr(0, removeChar);
				
				console.log('prefix:::' + prefix + '::::' + id + '::::' + removeChar);
				el.attr('id', prefix + (nextElament));
				el.attr('data-attr', (nextElament));
			}
		});
		$clone.find('input:text').val('');
		$('table.weight-table tbody').append($clone);
		var totalRow = $('table.weight-table tbody').find('tr').length;
		if (totalRow > 1) {
			$('.remove-weight-row').show();
		} else {
			$('.remove-weight-row').hide();
		}
		
	});

	$(".remove-weight-row").on('click', function () {
		var totalRow = $('table.weight-table tbody').find('tr').length;
		if (totalRow > 1) {
			$('table.weight-table tbody').find('tr:last').remove();
			totalRow--;

		}
		if (totalRow == 1) {
			$(this).hide();
		}
		

	});
	
	$(".add-weight-row1").on('click', function () {
		var allTrs = $('table.weight-table1 tbody').find('tr');
		var lastTr = allTrs[allTrs.length - 1];
		var $clone = $(lastTr).clone();

		var countrows = $(".one_cft_kg").length;
		$clone.find('td').each(function () {
			var el = $(this).find(':first-child');
			var id = el.attr('id') || null;
			if (id) {
				var i = id.substr(id.length - 1);

				var nextElament = countrows; //parseInt(i)+1;
				var remove = 1;
				if (countrows > 10) {
					var remove = 2;
				}
				var removeChar = (id.length - remove);
				var prefix = id.substr(0, removeChar);
				// prefix = id.substring(0,id.length - remove);
				// console.log(id.substring(0,id.length - remove));
				console.log('prefix:::' + prefix + '::::' + id + '::::' + removeChar);
				el.attr('id', prefix + (nextElament));
				el.attr('data-attr', (nextElament));
			}
		});
		$clone.find('input:text').val('');
		$('table.weight-table1 tbody').append($clone);
		var totalRow = $('table.weight-table1 tbody').find('tr').length;
		if (totalRow > 1) {
			$('.remove-weight-row').show();
		} else {
			$('.remove-weight-row').hide();
		}
		
	});

	$(".remove-weight-row1").on('click', function () {
		var totalRow = $('table.weight-table1 tbody').find('tr').length;
		if (totalRow > 1) {
			$('table.weight-table1 tbody').find('tr:last').remove();
			totalRow--;

		}
		if (totalRow == 1) {
			$(this).hide();
		}
		

	});
	});
	</script>
</html>
