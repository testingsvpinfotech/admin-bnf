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
                              <h4 class="card-title">Add Signed Quatation</h4>
                          </div>
						    <div class="card-content">
                          <div class="card-body">
						   <div class="row">                                           
                      <div class="col-12">
                               <form role="form" action="admin/add-signed-quatation" method="post" enctype="multipart/form-data">
                								  <div class="box-body">                								 
                									
								   <div class="form-group row">
                                      <label for="ac_name" class="col-sm-1 col-form-label">Contact Person </label>
                                      <div class="col-sm-3">
                                        <input type="text" class="form-control" name="contact_person" value="" placeholder="Enter Contact Person" required>
                                      </div>                  
                                 
                                      <label for="ac_name" class="col-sm-1 col-form-label">Contact No </label>
                                      <div class="col-sm-3">
                                        <input type="text" class="form-control" name="contact_no" value="" placeholder="Enter Contact No" required>
                                      </div>                  
                                  </div>
								  <br>
								   <div class="form-group row">
                                      <label for="ac_name" class="col-sm-1 col-form-label">Email</label>
                                      <div class="col-sm-3">
                                        <input type="email" class="form-control" name="email" value="" placeholder="Enter Email" required>
                                      </div>
									<label for="ac_name" class="col-sm-1 col-form-label">Attechment</label>
                                      <div class="col-sm-3">
                                        <input type="file" class="form-control" name="attechment[]" accept="application/pdf" multiple required>
                                      </div>									  
                                               
                                  </div>
								   <br>
									  <div class="col-md-2">
										  <div class="box-footer">
											<button type="submit"  class="btn btn-primary">Add Quatation</button>
										  </div>
									  </div>
									  <!-- /.box-body -->                								  
									</div>
									<input type="hidden" value="<?php echo $customer_id; ?>" name="customer_id" >
									<input type="hidden" value="<?php echo $c_courier_id; ?>" name="c_courier_id" >
									<input type="hidden" value="<?php echo $applicable_from; ?>" name="applicable_from" >
									
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
