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
                  <div class="col-12  align-self-center">
                      <div class="col-12 col-sm-12 mt-3">
                      <div class="card">
                          <div class="card-header justify-content-between align-items-center">                               
                              <h4 class="card-title">Domestic Rate</h4>
                              <span style="float: right;"><a href="admin/insert-domestic-state-rate" class="fa fa-plus btn btn-primary">Add Domestic Rate</a></span>
                          </div>
                          <div class="card-body">
                          <div class="col-12"  id="state_div" style="display: none;">
                            <form role="form" action="admin/insert-domestic-state-rate" method="post" >
                               <div class="box-body" > 
                                <h5>Add State</h5>
                                  <div class="form-group row">
                                    <input type="hidden" name="zone_id" value="<?php echo $z_id; ?>">
                                      <label for="ac_name" class="col-sm-2 col-form-label">State Name</label>
                                      <div class="col-sm-2">
                                          <select class="form-control"  name="state_id" id="state" required="">
                                            <option value="">Select State</option>           
                                            <?php
                                            foreach ($states as $row) 
                                            {
                                              ?>
                                              <option value="<?php echo $row['id'];?>"><?php echo $row['state'];?></option>
                                              <?php
                                            }
                                            ?>
                                          </select>
                                      </div>    
                                       <label for="ac_name" class="col-sm-1 col-form-label">Rate</label>
                                        <div class="col-sm-2">
                                          <input type="text" name="from_rate" id="state_from_rate" class="form-control" placeholder="From">
                                        </div>
                                        <div class="col-sm-2">
                                          <input type="text" name="to_rate" id="state_to_rate" class="form-control" placeholder="To">
                                        </div>
                                      <button type="submit"  class="btn btn-primary">Add Rate</button>
                                    </div>
                                  </div>
                                </form>
                            </div>
                            <div class="col-12"  id="city_div" style="display: none;">
                            <form role="form" action="admin/insert-domestic-city-rate" method="post" >
                               <div class="box-body" > 
                                  <input type="hidden" name="zone_id" value="<?php echo $z_id; ?>">
                                <h5>Add City</h5>
                                  <div class="form-group row">
                                    <input type="hidden" name="zone_id" value="<?php echo $z_id; ?>">
                                      <label for="ac_name" class="col-sm-2 col-form-label">State Name</label>
                                      <div class="col-sm-2">
                                          <select class="form-control"  name="state_id" id="state_city" onchange="return getCityList();"  required="">
                                            <option value="">Select State</option>           
                                            <?php
                                            foreach ($states as $row) 
                                            {
                                              ?>
                                              <option value="<?php echo $row['id'];?>"><?php echo $row['state'];?></option>
                                              <?php
                                            }
                                            ?>
                                          </select>                                          
                                      </div>   
                                       <label for="ac_name" class="col-sm-1 col-form-label">City</label>
                                        <div class="col-sm-2">
                                          <select class="form-control"  name="city_id" id="city" required="">
                                          <option value="">Select City</option>                                        
                                       </select>
                                        </div>
                                       <label for="ac_name" class="col-sm-1 col-form-label">Rate</label>
                                        <div class="col-sm-2">
                                          <input type="text" name="from_rate" id="city_from_rate" class="form-control" placeholder="From">
                                        </div>
                                        <div class="col-sm-2">
                                          <input type="text" name="to_rate" id="city_to_rate" class="form-control" placeholder="To">
                                        </div>
                                      <button type="submit"  class="btn btn-primary">Add Rate</button>
                                    </div>
                                  </div>
                                </form>
                            </div>
                              <div class="table-responsive">
                                  <table class="table layout-primary table-bordered">
                                      <thead>
                                          <tr>
                                               <th scope="col">Sr.</th>
                                               <th scope="col">zone</th>
                                               <th scope="col">State</th>
                                               <th scope="col">City</th>
                      											  <!--  <th scope="col">Action</th> -->
                                          </tr>
                                      </thead>
                                      <tbody>
                                              <?php 
                                              if (!empty($domestic_rate_list))
                            									{
                            										$cnt = 0;
                                                foreach ($domestic_rate_list as $value) {
                                                  $cnt++;
                                              ?>
                            									<tr>
                            										<td scope="col"><?php echo $cnt; ?></td> 
                                                <td><?php echo $value['region_name']; ?></td> 
                                                <td> <a href="#" onclick="return show_div('state_div');" class="fa fa-plus btn btn-primary"><i class="icon-plus"></i>Add State Rate</a>
                                                  <br>
                                                  <?php 
                                                  if($domestic_state_rate_list)
                                                  {
                                                    foreach ($domestic_state_rate_list as $ds) {
                                                      echo "<br><b>".$ds['state'].": Rate ".$ds['from_rate']." To ".$ds['to_rate']."</b>"; ?>&nbsp;&nbsp;&nbsp;
                                                      <a href="#" onclick="return show_ajax_div('state_div',<?php echo $ds['id']; ?>);" class="btn btn-primary"><i class="icon-pencil"></i></a> 
                                                        </i></a>
                                                </td>
                                                      <?php
                                                    }
                                                  }
                                                  ?>

                                                </td> 
                                                 <td><a href="#" onclick="return show_div('city_div');" class="fa fa-plus btn btn-primary"><i class="icon-plus"></i>Add City Rate</a>
                                                  <br>
                                                  <?php 
                                                  if($domestic_city_rate_list)
                                                  {
                                                    foreach ($domestic_city_rate_list as $ds) {
                                                      echo "<br><b>".$ds['state'].":".$ds['city'].": Rate ".$ds['from_rate']." To ".$ds['to_rate']."</b>";
                                                      ?>&nbsp;&nbsp;&nbsp;
                                                       <a href="#" onclick="return show_ajax_div('city_div',<?php echo $ds['id']; ?>);" class="btn btn-primary"><i class="icon-pencil"></i></a> 
                                                       <?php
                                                    }
                                                  }
                                                  ?>

                                                </td> 
                            									  <!-- <td>                            										
                                                <a href="admin/view-edit-domestic-rate/<?php echo $value['rate_id'];?>" class="btn btn-primary"><i class="icon-pencil"></i></a> |
                            										
                                                <a href="admin/delete-domestic-rate/<?php echo $value['rate_id'];?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?');"><i class="icon-trash"></i></a>
                            									  </td> -->
                            									  </tr>
                                              <?php 
                                            }
                                         }
                                         else{
                                        echo "<p>No Data Found</p>";
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
<script type="text/javascript">
   function getCityList()
        {
            var state = $('#state_city').val();  
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() ?>Admin_ratemaster/getCityList',
                data: 'state=' + state,
                dataType: "json",
                success: function(data) {
                    var option = '';
                    $.each(data, function(i, city) {                       
                        option += '<option value="'+city.id+'">'+city.city+'</option>';
                    });
                    $('#city').html(option);
                    
                }
            });  
        }
        function show_div(val)
        {
          if(val=="state_div"){
            $("#state_div").show();
            $("#city_div").hide();
            return  false;

          }else if(val=="city_div"){
            $("#city_div").show();
            $("#state_div").hide();
            return  false;
          }
        }
        function show_ajax_div(val,edit_id)
        {
           if(val=="state_div"){
            $("#state_div").show();
            $("#city_div").hide();

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() ?>Admin_domestic_rate_manager/getDomesticStateDetails',
                data: 'edit_id=' + edit_id,
                dataType: "json",
                success: function(data) {
                    //var option = '';
                    // $.each(data, function(i, city) {                       
                    //     option += '<option value="'+city.id+'">'+city.city+'</option>';
                    // });
                    //$('#state').html(option);
                    $('#from_rate').val(data.from_rate);
                    $('#to_rate').val(data.to_rate);
                    
                }
            }); 
            return  false;

          }else if(val=="city_div"){
            $("#city_div").show();
            $("#state_div").hide();
            return  false;
          }
        }
</script>