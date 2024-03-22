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
                              <h4 class="card-title">Update Coloader</h4>
                          </div>
						    <div class="card-content">
                          <div class="card-body">
						   <div class="row">                                           
                           <div class="col-12">
                             <form role="form" action="admin/edit-coloader/<?php echo $coloader_list->id; ?>" method="post" >
            								  <div class="box-body">	
                               <div class="form-group row">
                                  <label for="ac_name" class="col-sm-3 col-form-label">Coloader Name</label>
                                  <div class="col-sm-3">
                                   <input type="text" class="form-control" name="coloader_name" value="<?php echo $coloader_list->coloader_name; ?>" placeholder="Enter Coloader Name" required>
                                </div>  
	
												<label for="ac_name" class="col-sm-3 col-form-label">Company Name</label>
                  								    <div class="col-sm-3">
                                          <input type="text" class="form-control" name="company_name" value="<?php echo $coloader_list->company_name; ?>" placeholder="Enter Company Name" required>             									  
                    									</div>		
	</div>															
                              </div>     
<div class="form-group row">
										<label for="ac_name" class="col-sm-3 col-form-label">Company Address</label>
                  						<div class="col-sm-3">
											<input type="text" class="form-control" name="company_add" value="<?php echo $coloader_list->company_add; ?>" placeholder="Enter Company Address" required>
											</div>	
											<label for="ac_name" class="col-sm-3 col-form-label">Contact No</label>
                  							<div class="col-sm-3">
												<input type="text" class="form-control" name="company_contact" value="<?php echo $coloader_list->company_contact; ?>" placeholder="Enter Contact No" required>
											</div>	
								   </div>
								   <div class="form-group row">
										<label for="ac_name" class="col-sm-3 col-form-label">Contact Person</label>
                  						<div class="col-sm-3">
											<input type="text" class="form-control" name="contact_person" value="<?php echo $coloader_list->contact_person; ?>" placeholder="Enter Contact Person" required>
										</div>	
										
										<label for="ac_name" class="col-sm-3 col-form-label">GST No</label>
                  						<div class="col-sm-3">
											<input type="text" class="form-control" name="gst_no" value="<?php echo $coloader_list->gst_no; ?>" placeholder="Enter GST No" required>
										</div>	
								   </div>							  
                                  

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
                                            <th>Action
                                              <div class="btn-group" role="group" aria-label="Basic example">
                                                
                                                <button type="button"  data-toggle="modal" data-target="#myModal" class="btn btn-success">Add</button>
                                                
                                                
                                              </div>
                                            </th>
                                          </tr>
                                        </thead>
                                        <tbody id="city_rate1">

                                          <?php 

                                          // echo "<pre>";

                                          // print_r($city_rate_list);exit();
                                          if (!empty($city_rate_list)) {
                                              foreach ($city_rate_list as $key2 => $value2) { ?>
                                                <tr>
                                                <td>1</td>
                                                <td>
                                                  <select name="from_city[]" required>
                                                      <?php 
                                                          echo "<option value=''>Select City</option>";
                                                          if (!empty($city)) {
                                                            foreach ($city as $key => $value)
                                                            {
                                                              $select = "";
                                                              if ($value2->from_city==$value->id) {
                                                                $select = "selected";
                                                              }
                                                              echo "<option value='".$value->id."' ".$select.">".$value->city."</option>";
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

                                                              $select = "";
                                                              if ($value2->to_city==$value->id) {
                                                                $select = "selected";
                                                              }
                                                              echo "<option value='".$value->id."' ".$select.">".$value->city."</option>";
                                                            }
                                                            
                                                          }
                                                      ?>
                                                  </select>
                                                </td>
                                                <td>
                                                  <input type="number" name="min_amount[]" value="<?php echo $value2->min_amt;?>">
                                                </td>
                                                <td>
                                                  <input type="number" name="per_kg[]" value="<?php echo $value2->per_kg_rate;?>">
                                                </td>
                                                <td>
                                                  <input type="date" name="applicable_date[]" value="<?php echo $value2->applicable_date;?>">
                                                </td>

                                                <td>
                                                  <div class="btn-group" role="group" aria-label="Basic example">
                                                    
                                                    <!-- <button type="button" onClick="add_city_row_new(this);" class="btn btn-success">Edit</button> -->
                                                    <button type="button" onClick="update_city_row(this,<?php echo $value2->clr_id;?>);" class="btn btn-success">update</button>
                                                    <button type="button" onclick="remove_city_row(this);" class="btn btn-danger">Add</button>
                                                    
                                                  </div>
                                                </td>


                                              </tr>
                                            <?php  }
                                             }else{?>


                                  
                                          

                                          <?php  }
                                          ?>
                                        </tbody>
                                    </table>
                                  </div>

                                  <?php 
                                    if (!empty($city_rate_list)) {
                                      # code...
                                    }else{?>


                                  <?php  }
                                  ?>							  
            								  <div class="col-md-2">
            								  	<div class="box-footer">
            										<button type="submit" class="btn btn-primary">Update Coloader</button>
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


        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog modal-xl">

            <!-- Modal content-->
            <div class="row">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Add Rate</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  
                </div>
                <form role="form" action="Admin_coloader/add_rate/<?php echo $coloader_list->id; ?>" method="post" >
                  <div class="modal-body">

                    
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
                        <tbody class="city_rate">

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
                                <button type="button" onclick="remove_city_row(this);" class="btn btn-danger">Add</button>
                                
                              </div>
                            </td>


                          </tr>

                          
                        </tbody>
                      </table>
                    
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" >Save</button>
                  </div>
                </form>
              </div>

            </div>
              
          </div>
        </div>
        
        <?php  include(dirname(__FILE__).'/../admin_shared/admin_footer.php'); ?>
        <!-- START: Footer-->
    </body>

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
        $(tr).clone().insertAfter(".city_rate tr:last");
      }

      function update_city_row(obj,clr_id){

        y = confirm('Are you Sure Do You Want To Update? ');

        if (y) {
          var tr = $(obj).closest('tr');

          var from_city = $(tr).find('select[name="from_city[]"] option:selected').val();
          var to_city = $(tr).find('select[name="to_city[]"] option:selected').val();
          var min_amount = $(tr).find('input[name="min_amount[]"]').val();
          var per_kg = $(tr).find('input[name="per_kg[]"]').val();
          var applicable_date = $(tr).find('input[name="applicable_date[]"]').val();

          $.ajax({
            url : '<?php echo base_url('Admin_coloader/update_city_rate');?>',
            method : 'POST',
            data : {
              clr_id:clr_id,
              from_city:from_city,
              to_city:to_city,
              min_amount:min_amount,
              per_kg:per_kg,
              applicable_date:applicable_date,
            },
            success : function (data){
              data= data.trim();
              console.log(data);
              if (data=='1') {
                alert('Rate Updated Successfully!');
                // $('#username').val('');
              }else{
                alert('Rate Updated Successfully!');
              }
            }
          });
        }
        
        
        // var dd = $(tr).find('select[name="country"] option:selected').val();

        // alert(applicable_date);

        
      }
    </script>
    <!-- END: Body-->
</html>
