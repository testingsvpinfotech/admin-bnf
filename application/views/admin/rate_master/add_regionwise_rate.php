 <?php  $this->load->view('admin/admin_shared/admin_header'); ?>
    <!-- END Head-->

    <!-- START: Body-->
    <body id="main-container" class="default">

    	 <!-- END: Main Menu-->
    <?php $this->load->view('admin/admin_shared/admin_sidebar'); ?>

        <!-- END: Main Menu-->
    <?php $this->load->view('admin/admin_shared/admin_sidebar');
   // include('admin_shared/admin_sidebar.php'); ?>
        <!-- END: Main Menu-->
    
        <!-- START: Main Content-->
<main>
<div class="container-fluid site-width">
<!-- START: Listing-->
<div class="row">
<div class="col-12 mt-3">
<div class="card">
    <div class="card-header">                               
        <h4 class="card-title">Add Regionwise Rate</h4>                                
           </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="row">                                           
                        <div class="col-12">
                            <form role="form" action="<?php echo base_url();?>admin/add-regionwise-rate/<?php echo $customer->customer_id; ?>" method="post" enctype="multipart/form-data">

                                <div class="form-group row">
                                  <div class="col-3 mb-3">
                                        <label for="username">Customer Name</label>
                                        <input type="text" class="form-control" name="customer_name" readonly value="<?php echo $customer->customer_name; ?>">
                                       <input type="hidden" class="form-control" name="customer_id" value="<?php echo $customer->customer_id; ?>">
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label for="username">Region</label>
                                        <select class="form-control" id="jq-validation-email" name="region_id">
                                          <option selected="selected" value="">Region</option>
                                          <?php
                                          foreach ($region as $row1) {

                                          ?>
                                            <option value="<?php echo $row1['region_id']; ?>">

                                              <?php echo $row1['region_name']; ?>
                                            </option>
                                          <?php
                                          }
                                          ?>
                                        </select>
                                    </div>
                                    <div class="col-3 mb-3"> 
                                        <label for="email">Mode of Transport</label>    
                                       <select class="form-control" id="jq-validation-email" name="mode_of_transport">
                                          <option value="">Select Id</option>
                                            <?php
                                          foreach ($transfer_mode as $roww1) {
                                          ?>
                                            <option value="<?php echo $roww1['mode_name']; ?>"><?php echo $roww1['mode_name']; ?></option>
                                          <?php
                                          }
                                          ?>                                        
                                        </select>
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label for="username">Rate</label>
									                       <input type="number" class="form-control" id="jq-validation-email" name="rate" placeholder="Rate">
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                    <div class="col-3 mb-3"> 
                                        <label for="number">Min. Weight</label> 
                                         <input type="number" name="weight_range" class="form-control" id="jq-validation-email" placeholder="Kg">

                                    </div>
                                    <div class="col-3 mb-3">
                                        <label for="username">DOC Charge</label>
                                       <input type="number" name="dod_doac" class="form-control" id="dod_doac" placeholder="DOC Charge">
                                    </div> 

                                  </div>
                                  <div class="form-group row">
                                     <div class="col-3 mb-3">
                                      <label for="username">Type</label>
                                       <select class="form-control" id="rate_type_sel" name="rate_type_sel" onchange="tgl(this.value)">
                                          <option value="5" selected disabled required>SELECT</option>
                                          <option value="0">NON-DOC</option>
                                          <option value="1" >DOC</option>   
                                        </select>
                                  </div>
                                </div>
                                    <div class="form-group row">
                                     <div class="col-3 mb-3">
                                        <label for="username">Loading Unloading</label>
                                        <input type="number" name="loading_unloading" class="form-control" id="loading_unloading" placeholder="Loading/Unloading">
                                    </div>
                                     <div class="col-3 mb-3">
                                        <label for="username">Packing</label>
                                       <input type="number" name="packing" class="form-control" id="Packing" placeholder="Packing">
                                    </div>
                                     <div class="col-6 mb-3">
                                      <label for="username">Handling Charge Type</label>
                                      <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" checked="checked" name="hc_type" id="customCheck1">
                                        <label class="custom-control-label" for="customCheck1">Fixed</label>
                                      </div>                                    
                                     <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" name="hc_type" class="custom-control-input"  id="customCheck2">
                                        <label class="custom-control-label" for="customCheck2">Per Kg.</label>
                                    </div>
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                   <div class="col-3 mb-3">
                                    <label for="username">Handling</label>
                                    <input type="number" name="handling" class="form-control" id="handling" placeholder="Handling">  
                                  </div>
                                                             
                                  <div class="col-3 mb-3">
                                        <label for="username">FOV</label>
                                        <input type="number" name="fov" class="form-control" id="insurance" placeholder="FOV">
                                </div>
                                 <div class="col-3 mb-3">
                                  <label for="username">Minimum FOV</label>
                                  <input type="number" name="minimum_fov" class="form-control" id="mimimum_insurance" placeholder="Minimum FOV">
                                </div>
                             
                                <div class="col-3 mb-3">
                                  <label for="username">CFT</label>
                                  <input type="number" name="cft" class="form-control" id="cft" placeholder="CFT">
                                </div>
                              </div>
                              <div class="form-group row">
                                <div class="col-3 mb-3">
                                      <label for="username">Calculate Fuel Charge based on</label>
                                       <div class="custom-control custom-radio custom-control-inline">
                                          <input type="radio" class="custom-control-input" checked="checked" name="fc_type" id="fc_type">
                                          <label class="custom-control-label" for="fc_type">Freight</label>
                                     </div>
                                     <div class="custom-control custom-radio custom-control-inline">
                                          <input type="radio" name="fc_type" class="custom-control-input"  id="fc_type1">
                                          <label class="custom-control-label" for="fc_type1">Total Amount</label>
                                      </div>
                                  </div>
                                  <div class="col-3 mb-3">
                                      <label for="username">Fuel Charges</label>
                                       <input type="number" name="fuel_charges" class="form-control" id="fuel_charges" placeholder="Fuel Charges">
                                  </div>                                
                                   <div class="col-3 mb-3">
                                      <label for="username"><b>Minimum Amount</b></label>
                                      <input type="number" name="min_amt" class="form-control" id="min_amt" placeholder="Minimum Amount">  
                                    </div> 
                                                                      
                                    <div class="col-3 mb-3">
                                        <label for="username">GST%</label>
                                        <select class="form-control" id="gst_rate" name="gst_rate">
                                          <option value="">Select GST%</option>
                                          <option value="5">5%</option>
                                          <option value="12">12%</option>
                                          <option value="18">18%</option>
                                        </select>
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                
                                   <div class="col-3 mb-3">
                                      <label for="username"><b>Roundoff Method</b></label>
                                      <select class="form-control" id="roundoff_type" name="roundoff_type">
                                        <option value="">Select Roundoff Method</option>
                                        <option value="1">Half Round (10.25 => 10, 10.5=>11)</option>
                                        <option value="2">Round up next(10.25 => 11, 10.5=>11)</option>
                                      </select> 
                                    </div>  

                                   <div class="col-3 mb-3">
                                      <label for="username"><b>Local</b></label>
                                      <select class="form-control" id="jq-validation-email" name="state_id" value="<?php echo $state->state_name; ?>">
                                      <option value="">Local</option>
                                      <?php
                                      foreach ($state as $row1) {
                                      ?>
                                        <option value="<?php echo $row1['state_id']; ?>">

                                          <?php echo $row1['state_name']; ?>
                                        </option>
                                      <?php
                                      }
                                      ?>
                                    </select> 
                                    </div>  
                                    </div>
                            <div class="form-group row"> 
                              <div class="col-2 mb-3">
                                <label for="username">No Of Pack</label>
                              </div>
                            </div>
                          <div class="form-group row after-add-more">                               
                              <div class="col-3 mb-3">                              
                                <input type="text" name="nopackmorefrom[]" class="form-control" placeholder="From" />
                              </div>
                              <div class="col-3 mb-3">
                                <input type="text" name="nopackmoreto[]" class="form-control" placeholder="To" />
                              </div>
                              <div class="col-3 mb-3">
                                <input type="text" name="nopackrate[]" class="form-control" placeholder="Rate"/>
                              </div>
                              <div class="input-group-btn col-sm-3">
                                <button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                              </div>                              
                         </div>  

                        <div class="form-group row"> 
                            <div class="col-3 mb-3">
                              <label for="min_freight">To Pay charges</label>
                              <input type="text" name="to_pay_charges" class="form-control" id="to_pay_charges" placeholder="To Pay charges">
                            </div>
                            <div class="col-3 mb-3">
                              <label for="min_freight">COD</label>
                              <input type="text" name="cod" class="form-control" id="cod" placeholder="COD">
                            </div>
                            <div class="col-3 mb-3">
                              <label for="min_freight">EDD</label>
                              <input type="text" name="edd" class="form-control" id="edd" placeholder="EDD">
                            </div>  
                       </div> 
                           <div class="form-group row"> 
                                <div class="col-12">
                                    <input type="submit" class="btn btn-primary" name="submit" value="Submit"> 
                                </div>
                            </div>
                        </form>
                      </div>
                        <!-- -->
                        <!-- -->
                        <!-- Copy Fields -->
                        <div class="copy hide" style="display: none;">
                          <div class="form-group row" style="margin-top:10px">
                              <div class="col-3 mb-3">                              
                                <input type="text" name="nopackmorefrom[]" class="form-control" placeholder="From" />
                              </div>
                              <div class="col-3 mb-3">
                                <input type="text" name="nopackmoreto[]" class="form-control" placeholder="To" />
                              </div>
                              <div class="col-3 mb-3">
                                <input type="text" name="nopackrate[]" class="form-control" placeholder="Rate"/>
                              </div>
                              <div class="input-group-btn col-sm-3">
                              <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> X</button>
                            </div>
                          </div>
                     </div>
              <!-- Copy Fields End -->
                    </div>
                    
      <!-- End Row -->
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
<?php $this->load->view('admin/admin_shared/admin_footer');
 //include('admin_shared/admin_footer.php'); ?>
<!-- START: Footer-->
    </body>
    <!-- END: Body-->
<script type="text/javascript">
  $(document).ready(function() {
    $(".add-more").click(function() {

      var html = $(".copy").html();
      $(".after-add-more").after(html);
    });
    $("body").on("click", ".remove", function() {
      $(this).parents(".control-group").remove();
    });
  });

  function validate_assignrate() {
    if ($('input[name="hc_type"]:checked').length == 0) {
      alert("Please choose Handling Charge Type");
      $('input[name="hc_type"]').focus();
      return false;
    }

    if ($('input[name="fc_type"]:checked').length == 0) {
      alert("Please choose 'Fuel Charge based'");
      $('input[name="fc_type"]').focus();
      return false;
    }

    if ($('#min_freight').val() != "") {
      var value = $('#min_freight').val().replace(/^\s\s*/, '').replace(/\s\s*$/, '');
      var intRegex = /^\d+$/;
      if (!intRegex.test(value)) {
        alert("Please enter a numeric value for 'Minimum Freight'");
        $('#min_freight').focus();
        return false;
      }
    } else {
      alert("Please enter 'Minimum Freight'");
      $('#min_freight').focus();
      return false;
    }

    if ($('#mimimum_insurance').val() != "") {
      var value = $('#mimimum_insurance').val().replace(/^\s\s*/, '').replace(/\s\s*$/, '');
      var intRegex = /^\d+$/;
      if (!intRegex.test(value)) {
        alert("Please enter a numeric value for 'Minimum FOV'");
        $('#mimimum_insurance').focus();
        return false;
      }
    } else {
      alert("Please enter 'Minimum FOV'");
      $('#mimimum_insurance').focus();
      return false;
    }

    if ($('#gst_rate').val() == "") {
      alert("Please select 'GST Rate'");
      $('#gst_rate').focus();
      return false;
    }
    if ($('#roundoff_type').val() == "") {
      alert("Please select 'Roundoff methode'");
      $('#roundoff_type').focus();
      return false;
    }
    return true;
  }
</script>
		
		
		
		
		