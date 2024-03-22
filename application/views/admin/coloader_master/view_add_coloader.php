<?php include(dirname(__FILE__).'/../admin_shared/admin_header.php'); ?>
    <!-- END Head-->
<style>
    .form-control{
      color:black!important;
      border: 1px solid var(--sidebarcolor)!important;
      height: 27px;
      font-size: 10px;
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
                  <div class="col-12">
                      <div class="col-12 col-sm-12 mt-3">
                      <div class="card">
					  
                          <div class="card-header">                               
                              <h4 class="card-title">Add Coloader</h4>
                          </div>
						    <div class="card-content">
                          <div class="card-body">
						   <div class="row">                                           
                      <div class="col-12">
                               <form role="form" action="admin/insert_coloader" method="post" >
                								  <div class="box-body">                								 
                									 <div class="form-group row">
                  									  <label for="ac_name" class="col-sm-3 col-form-label">Coloader Name</label>
                  								    <div class="col-sm-3">
                                          <input type="text" class="form-control" name="coloader_name" value="" placeholder="Enter Coloader Name" required>             									  
                    									</div>	
												<label for="ac_name" class="col-sm-3 col-form-label">Company Name</label>
                  								    <div class="col-sm-3">
                                          <input type="text" class="form-control" name="company_name" value="" placeholder="Enter Company Name" required>             									  
                    									</div>															
                								  </div>
                                 <!--  <div class="form-group row">
                                      <label for="ac_name" class="col-sm-3 col-form-label">Rate Type</label>
                                      <div class="col-sm-3">
                                        <select class="form-control" name="rate_type" id="rate_type">
                                          <option value="Min">Min</option>
                                          <option value="Per Kg">Per Kg</option>
                                        </select>
                                      </div>                  
                                  </div>
                                  <div class="form-group row">
                                      <label for="ac_name" class="col-sm-3 col-form-label">Rate</label>
                                      <div class="col-sm-3">
                                        <input type="text" class="form-control" name="rate" placeholder="Enter Rate" required>
                                      </div>                  
                                  </div>        -->     
                                   <div class="form-group row">
										<label for="ac_name" class="col-sm-3 col-form-label">Company Address</label>
                  						<div class="col-sm-3">
											<input type="text" class="form-control" name="company_add" value="" placeholder="Enter Company Address" required>
											</div>	
											<label for="ac_name" class="col-sm-3 col-form-label">Contact No</label>
                  							<div class="col-sm-3">
												<input type="text" class="form-control" name="company_contact" value="" placeholder="Enter Contact No" required>
											</div>	
								   </div>
								   <div class="form-group row">
										<label for="ac_name" class="col-sm-3 col-form-label">Contact Person</label>
                  						<div class="col-sm-3">
											<input type="text" class="form-control" name="contact_person" value="" placeholder="Enter Contact Person" required>
										</div>	
										
										<label for="ac_name" class="col-sm-3 col-form-label">GST No</label>
                  						<div class="col-sm-3">
											<input type="text" class="form-control" name="gst_no" value="" placeholder="Enter GST No" required>
										</div>	
								   </div>
                                   <!-- <div class="form-group row">
                                      <label for="ac_name" class="col-sm-3 col-form-label">Min Rate</label>
                                      <div class="col-sm-3">
                                        <input type="text" class="form-control" name="min_rate" placeholder="Enter Rate" required>
                                      </div>                  
                                
                                      <label for="ac_name" class="col-sm-3 col-form-label">Per KG Rate</label>
                                      <div class="col-sm-3">
                                        <input type="text" class="form-control" name="per_kg_rate" placeholder="Enter Rate" required>
                                      </div>                  
                                  </div> 
						                      <div class="form-group row">
                                      <label for="ac_name" class="col-sm-3 col-form-label">Location</label>
                                      <div class="col-sm-3">
                                        <input type="text" class="form-control" name="location" placeholder="Enter Location" required>
                                      </div>                  
                                  </div>  -->

                                  <div class="col-md-12">
                                    <table class="table"> 
                                        <thead>
                                          <tr>
                                            <th>#</th>
                                            <th>From City</th>
                                            <th>To City</th>
                                            <th>Min Amount</th>
                                            <th>Rate Per KG</th>
                                            <th>Applicable From Date</th>
                                            <th>Action</th>
                                          </tr>
                                        </thead>
                                        <tbody id="city_rate">
                                          <tr>
                                            <td>1</td>
                                            <td>
                                              <select name="from_city[]" required>
                                                  <?php 
                                                      echo "<option value=''>Select City</option>";
                                                      if (!empty($city)) {
                                                        foreach ($city as $key => $value) {
                                                          echo "<option value='".$value->id."'>".$value->city."</option>";
                                                        }
                                                        
                                                      }
                                                  ?>
                                              </select>
                                            </td>
                                            <td>
                                              <select name="to_city[]" required>
                                                  <?php 
                                                      echo "<option value=''>Select City</option>";
                                                      if (!empty($city)) {
                                                        foreach ($city as $key => $value) {
                                                          echo "<option value='".$value->id."'>".$value->city."</option>";
                                                        }
                                                        
                                                      }
                                                  ?>
                                              </select>
                                            </td>
                                            <td>
                                              <input type="number" name="min_amount[]">
                                            </td>
                                            <td>
                                              <input type="number" name="per_kg[]">
                                            </td>
                                            <td>
                                              <input type="date" name="applicable_date[]">
                                            </td>

                                            <td>
                                              <div class="btn-group" role="group" aria-label="Basic example">
                                                
                                                <button type="button" onClick="add_city_row_new(this);" class="btn btn-success">Add</button>
                                                <button type="button" onclick="remove_city_row(this);" class="btn btn-danger">Remove</button>
                                                
                                              </div>
                                            </td>


                                          </tr>
                                        </tbody>
                                    </table>
                                  </div>								  
                								  <div class="col-md-2">
                    								  <div class="box-footer">
                    									<button type="submit"  class="btn btn-primary">Add Coloader</button>
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

      function remove_city_row(obj){
          var cnt = $('#city_rate tr').length;

          if (cnt <=1) {
            alert('You Cannot Remove last Row!');
            return false;
          }

          var tr = $(obj).closest('tr');
          $(tr).remove();
      }
      function add_city_row_new(obj){

        var cnt = $('#city_rate tr').length;

        var tr = $(obj).closest('tr');

        $(tr).clone().insertAfter("#city_rate tr:last");

        // $('#city_rate').append(tr);

        // var html = '';
        // html += '<tr>';
        // html += '  <td>1</td>';
        // html += '  <td>'
        // html += '    <select name="from_city[]" required>';
        // html += '        <?php 
        //             echo "<option value=''>Select City</option>";
        //             if (!empty($city)) {
        //               foreach ($city as $key => $value) {
        //                 echo "<option value='".$value->id."'>".$value->city."</option>";
        //               }
                      
        //             }
        //         ?>';
        // html += '    </select>';
        // html += '  </td>';
        // html += '  <td>';
        // html += '    <select name="to_city[]" required>';
        // html += '        <?php 
        //             echo "<option value=''>Select City</option>";
        //             if (!empty($city)) {
        //               foreach ($city as $key => $value) {
        //                 echo "<option value='".$value->id."'>".$value->city."</option>";
        //               }
                      
        //             }
        //         ?>';
        // html += '    </select>';
        // html += '  </td>';
        // html += '  <td>';
        // html += '    <input type="number" name="min_amount[]">';
        // html += '  </td>';
        // html += '  <td>';
        // html += '    <input type="number" name="per_kg[]">';
        // html += '  </td>';
        // html += '  <td>';
        // html += '    <input type="date" name="applicable_date[]">';
        // html += '  </td>';

        // html += '  <td>';
        // html += '    <div class="btn-group" role="group" aria-label="Basic example">';
              
        // html += '      <button type="button" class="btn btn-success">Add</button>';
              
        // html += '    </div>';
        // html += '  </td>';


        // html += '</tr>';
      }
    </script>
</html>
