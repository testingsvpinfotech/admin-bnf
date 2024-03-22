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
                              <h4 class="card-title">Details Coloader</h4>
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
                                  <!-- <div class="form-group row">
                                      <label for="ac_name" class="col-sm-3 col-form-label">Min Rate</label>
                                      <div class="col-sm-3">
                                        <input type="text" class="form-control" name="min_rate" value="<?php echo $coloader_list->min_rate;?>" placeholder="Enter Rate" required>
                                      </div>                  
                                 
                                      <label for="ac_name" class="col-sm-3 col-form-label">Per KG Rate</label>
                                      <div class="col-sm-3">
                                        <input type="text" class="form-control" name="per_kg_rate" value="<?php echo $coloader_list->per_kg_rate;?>" placeholder="Enter Rate" required>
                                      </div>                  
                                  </div>     
                                  <div class="form-group row">
                                      <label for="ac_name" class="col-sm-3 col-form-label">Location</label>
                                      <div class="col-sm-3">
                                        <input type="text" class="form-control" name="location" placeholder="Enter Location"  value="<?php //echo $coloader_list->location;?>"  required>
                                      </div>                  
                                  </div>   -->

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

                                                
                                              </tr>
                                            <?php  }
                                             }
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
      }
    </script>
    <!-- END: Body-->
</html>
