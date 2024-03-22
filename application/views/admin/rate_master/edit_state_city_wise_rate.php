 <?php $this->load->view('admin/admin_shared/admin_header'); ?>
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
        <h4 class="card-title">Update State/City wise Rate</h4>                                
    </div>
    <div class="card-content">
        <div class="card-body">
            <div class="row">                                           
                <div class="col-12">                
                   <form name="form1" id="form1" action="<?php echo base_url();?>admin/add_state_wise_rate/<?php echo $rate->rate_master_id;?>" method="post">
                        <div class="form-group row">
                            <div class="col-3 mb-3">
                                <label for="username">Customer</label>
                                <input type="text" class="form-control" readonly name="customer_name" value="<?php echo $customer->customer_name;?>">
                                  <input type="hidden" class="form-control" name="customer_id" id="customerId" value="<?php echo $customer->customer_id;?>">
                                  <input type="hidden" class="form-control" name="rate_master_id" id="rateMasterId" value="<?php echo $rate->rate_master_id;?>">

                            </div>
                            <div class="col-3 mb-3"> 
                                <label for="email">Region</label>    
                                <select class="form-control " id="zone" name="region_id" required disabled>
                                    <option selected="selected" value="">Region</option>
                                    <?php foreach ($region as $row1){ ?>
                                    <option value="<?php echo $row1['region_id'];?>"<?php if($row1['region_id'] == $rate->region_id) { echo 'selected'; } ?>>
                                      <?php echo $row1['region_name'];?>                                      
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-3 mb-3">  
                                <label for="username">Mode of Transport</label>
								                <select class="form-control" id="jq-validation-email" name="mode_name" disabled>
                                    <option value="">Select Id</option>
                                      <?php
                                    foreach ($transfer_mode as $roww1) {
                                    ?>
                                      <option value="<?php echo $roww1['mode_name']; ?>" <?php if($roww1['mode_name']==$rate->mode_of_transport){echo "selected";} ?> ><?php echo $roww1['mode_name']; ?></option>
                                    <?php
                                    }
                                    ?>                                        
                                </select>
                            </div>
                            <div class="col-3 mb-3"> 
                                <label for="email">Rate</label>      
                                 <input type="text" class="form-control" id="jq-validation-email" name="rate" placeholder="Rate" value="<?php echo $rate->rate;?>" required disabled>
                            </div>
            							</div>
            							 <div class="form-group row">
                                <div class="col-3 mb-3">
                                    <label for="username">Weight Range</label>
                                     <input type="text" name="weight_range" value="<?php echo $rate->weight_range; ?>" class="form-control" id="jq-validation-email" placeholder="Kg" disabled>
                                </div> 
                                 <div class="col-3 mb-3"> 
                                    <label for="email">DOC Charge</label>      
                                     <input type="text" name="dod_doac" class="form-control" id="dod_doac" placeholder="DOC Charge" value="<?php echo $rate->dod_doac; ?>">
                                </div>
            							
                              <div class="col-3 mb-3">
                                <label for="username">Type</label>
                                <input type="hidden" name="doc_type" value="<?php echo $rate->price_type;?>">
                                 <select class="form-control" id="rate_type_sel" name="rate_type_sel" onchange="tgl(this.value)" disabled required>
                                    <option value="" >SELECT</option>
                                    <option value="0" <?php if($rate->price_type==0){echo "selected";} ?>>NON-DOC</option>
                                    <option value="1" <?php if($rate->price_type==1){echo "selected";} ?> >DOC</option>   
                                  </select>
                            </div>
                          </div>						  
                 <div class="form-group row">
                  <div class="col-12">
                  <h3>Rate Master In Detail For State <?php //echo "====".$rate->state_id; ?></h3>
                </div>
                </div>
                  <div class="form-group row">
                 
                   <?php $state_list = $this->basic_operation_m->get_all_result('tbl_state',['region_id' => $rate->region_id]); ?>

                              <div class="col-3 mb-3">
                                <label for="username">State List</label>
                                <input type="hidden" name="mode_of_transport"  value="<?php echo $state_rate->state_id; ?>" >
                                <select class="form-control" id="zone-rate-state" disabled onchange="return getCityList();"  name="mode_of_transport1" disabled>
                                    <option value="">Select State</option>
                                    <?php 
                                      foreach ($state_list as $sl) {
                                        ?>
                                        <option value="<?php echo $sl['state_id'];?>" <?php if($state_rate->state_id == $sl['state_id']){echo "selected";} ?> ><?php echo $sl['state_name'];?></option>
                                        <?php
                                      }
                                    ?>
                                </select>                                
                            </div>
                            <div class="col-3 mb-3">
                                <label for="username">State Rate</label>
                               <input type="text" class="form-control" name="zoneRateState" class="zoneRateState" id="zoneRateState" placeholder="Rate" value="<?php echo $state_rate->rate;?>" required>                          
                            </div>
                            <div class="col-3 mb-3">
                                <label for="username">To Pay charges</label>
                                <input type="text" name="state_to_pay_charges" class="form-control" id="state_to_pay_charges" placeholder="To Pay charges" value="<?php echo $state_rate->to_pay_charges;?>">                              
                            </div>
                            <div class="col-3 mb-3">
                                <label for="username">COD</label>
                               <input type="text" name="state_cod" class="form-control" value="<?php echo $state_rate->cod;?>" id="state_cod" placeholder="COD">                             
                            </div>
                             <div class="col-3 mb-3">
                                <label for="username">EDD</label>
                              <input type="text" name="state_edd" class="form-control" id="state_edd" value="<?php echo $state_rate->edd;?>" placeholder="EDD">                           
                            </div>
                      </div>
                      <div>
                      <div class="form-group row">
                        <div class="col-12">
                              <input type="button" class="btn btn-info" value="Add Rate" onclick="addRow1('dataTable1')" />
                              <input type="button" class="btn btn-danger" value="Delete Rate" onclick="deleteRow1('dataTable1')" />
                            </div>
                         <div class="col-12">   
                  <table id="dataTable1" class="table table-bordered">                  
                    <tr>
                      <th>-</th>                      
                      <th> Addition</th>
                      <th> Lower Weight</th>
                      <th> Upper Weight</th>
                      <th> Rate</th>                      
                    </tr>
                    <?php 
                    if(count($doc_state_rate) >=1)
                    {
                    foreach($doc_state_rate as $sr)
                    {
                       ?>
                    <tr>
                      <td><input value="<?php echo $sr['rate_master_id']; ?>" type="checkbox" name="chk"/></td>
                      <td> <input  class="form-control" value="<?php echo $sr['addition']; ?>" name="addition_state[]" type="text" /> </td>
                      <td> <input class="form-control" value="<?php echo $sr['lower']; ?>" name="lower_state[]" type="text" /> </td>
                      <td> <input class="form-control" value="<?php echo $sr['upper']; ?>" name="upper_state[]" type="text" /> </td>
                      <td> <input class="form-control" value="<?php echo $sr['rate_amt']; ?>" name="rate_amt_state[]" type="text" /> </td>
                     </tr> 
                     <?php } 
                   }else{
                      ?>
                      <tr>
                      <td><input value="" type="checkbox" name="chk"/></td>
                      <td> <input  class="form-control" value="" name="addition_state[]" type="text" /> </td>
                      <td> <input class="form-control" value="" name="lower_state[]" type="text" /> </td>
                      <td> <input class="form-control" value="" name="upper_state[]" type="text" /> </td>
                      <td> <input class="form-control" value="" name="rate_amt_state[]" type="text" /> </td>
                     </tr>                           
                   
                   <?php } ?>
                  </table>
                </div>

                  </div>
                  <!-- ================================= City Code=======================-->
                   <div class="form-group row">
                          <div class="col-12">
                          <h3>Rate Master In Detail For City</h3>
                        </div>
                    </div>
                    <div class="form-group row">                   

                              <div class="col-3 mb-3">
                                <label for="username">City List</label>
                                <?php 
                                if(!empty($city_rate)){ ?>

                                  <input type="text" name="city"  value="<?php echo $city_rate->id; ?> " >
                                 <select class="form-control" id="zone-rate-city" disabled name="city1">
                                    <option value=""><?php echo $city_rate->city; ?></option>
                                </select> 
                            <?php
                              }else{
                              $city_list = $this->basic_operation_m->get_all_result('city',['state_id' => $state_rate->state_id]);
                              ?>
                                 <select class="form-control" id="zone-rate-city" name="city">
                                   <option value="">Select City</option>
                                    <?php 
                                      foreach ($city_list as $cl) {
                                        ?>
                                        <option value="<?php echo $cl['id'];?>"><?php echo $cl['city'];?></option>
                                        <?php
                                      }
                                    ?>
                                </select>    

                            <?php } ?>
                                                       
                            </div>
                            <div class="col-3 mb-3">
                                <label for="username">City Rate</label>
                               <input type="text" class="form-control" name="rate" class="zoneRateCity" id="zoneRateCity" placeholder="Rate" value="<?php if(!empty($city_rate)){echo $city_rate->rate;} ?>" required>                
                            </div>
                            <div class="col-3 mb-3">
                                <label for="username">To Pay charges</label>
                                <input type="text" name="to_pay_charges" value="<?php if(!empty($city_rate)){echo $city_rate->to_pay_charges;} ?>" class="form-control" id="city_to_pay_charges" placeholder="To Pay charges">                           
                            </div>
                            <div class="col-3 mb-3">
                                <label for="username">COD</label>
                               <input type="text" name="cod" class="form-control" value="<?php if(!empty($city_rate)){echo $city_rate->cod;} ?>" id="city_cod" placeholder="COD">                             
                            </div>
                             <div class="col-3 mb-3">
                                <label for="username">EDD</label>
                                <input type="text" name="edd" class="form-control" value="<?php if(!empty($city_rate)){echo $city_rate->edd;} ?>" id="city_edd" placeholder="EDD">                           
                            </div>
                      </div>
                      <div>
                      <div class="form-group row">
                        <div class="col-12">
                              <input type="button" class="btn btn-info" value="Add Rate" onclick="addRow1('dataTable2')" />
                              <input type="button" class="btn btn-danger" value="Delete Rate" onclick="deleteRow1('dataTable2')" />
                            </div>
                         <div class="col-12">   
                        <table id="dataTable2" class="table table-bordered">                  
                          <tr>
                            <th>-</th>                      
                            <th> Addition</th>
                            <th> Lower Weight</th>
                            <th> Upper Weight</th>
                            <th> Rate</th>                      
                          </tr>
                           <?php 
                    if(count($doc_city_rate) >=1)
                    {
                    foreach($doc_city_rate as $cr)
                    {
                       ?>
                          <tr>
                            <td><input value="<?php echo $cr['rate_master_id']; ?>" type="checkbox" name="chk"/></td>
                            <td> <input  class="form-control" value="<?php echo $cr['addition']; ?>" name="addition_city[]" type="text" /></td>
                            <td> <input class="form-control" value="<?php echo $cr['lower']; ?>" name="lower_city[]" type="text" /></td>
                            <td> <input class="form-control" value="<?php echo $cr['upper']; ?>" name="upper_city[]" type="text" /></td>
                            <td> <input class="form-control" value="<?php echo $cr['rate_amt']; ?>" name="rate_amt_city[]" type="text" /></td>
                           </tr>
                            <?php } 
                   }else{
                      ?>
                        <tr>
                            <td><input value="" type="checkbox" name="chk"/></td>
                            <td> <input  class="form-control" value="" name="addition_city[]" type="text" /></td>
                            <td> <input class="form-control" value="" name="lower_city[]" type="text" /></td>
                            <td> <input class="form-control" value="" name="upper_city[]" type="text" /></td>
                            <td> <input class="form-control" value="" name="rate_amt_city[]" type="text" /></td>
                           </tr>


                       <?php } ?>
                        </table>
                      </div>
                  </div>

                <!-- ======================================end city code===================================-->
                <div class="form-group row">
                         <div class="col-12">                            
                            <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                        </div>
                  </div>
                    </form>
                    </div>                
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
        <?php $this->load->view('admin/admin_shared/admin_footer');
         //include('admin_shared/admin_footer.php'); ?>
        <!-- START: Footer-->
    </body>
    <!-- END: Body-->
<script type="text/javascript">  
    function tgl(val) {     
      var cont = document.getElementById('cont');
      var cons = document.getElementById('cons');
    //  alert(val);
      if (val==1) {        
		 $("#cont").show();        
		 $("#cons").hide();
      }
      if(val==0) {
          //alert('kk');
          //cont.style.removeProperty("display");
        $("#cont").hide();
        $("#cons").show();
      }
    }
    //========
    function addRow(tableID) {      

                      var table = document.getElementById(tableID);                     

                      var rowCount = table.rows.length;
                      var row = table.insertRow(rowCount);                      

                      var cell1 = row.insertCell(0);
                      var element1 = document.createElement("input");
                      element1.type = "checkbox";
                      element1.name="chkbox[]";
                      cell1.appendChild(element1);

                      /*var cell2 = row.insertCell(1);
                      cell2.innerHTML = rowCount + 1;*/

                      var cell2 = row.insertCell(1);
                      var element2 = document.createElement("input");
                      element2.type = "text";
                      element2.name = "addition[]";
                      element2.className = "form-control";
                      cell2.appendChild(element2);

                      var cell3 = row.insertCell(2);
                      var element3 = document.createElement("input");
                      element3.type = "text";
                      element3.name = "lower[]";
                      element3.className = "form-control";
                      cell3.appendChild(element3);  


                      var cell4 = row.insertCell(3);
                      var element4 = document.createElement("input");
                      element4.type = "text";
                      element4.name = "upper[]";
                      element4.className = "form-control";
                      cell4.appendChild(element4);  

                      var cell5 = row.insertCell(4);
                      var element5 = document.createElement("input");
                      element5.type = "text";
                      element5.name = "rate_amt[]";
                      element5.className = "form-control";
                      cell5.appendChild(element5);  

                    }

                    function deleteRow(tableID) {                     
                      try {
                      var table = document.getElementById(tableID);                      
                      var rowCount = table.rows.length;
                      for(var i=0; i<rowCount; i++) {
                        var row = table.rows[i];
                        var chkbox = row.cells[0].childNodes[0];
                        if(null != chkbox && true == chkbox.checked) {
                          table.deleteRow(i);
                          rowCount--;
                          i--;
                        }
                      }
                      }catch(e) {
                        alert(e);
                      }
                    }
    //================
   function addRow1(tableID) {

                      var table = document.getElementById(tableID);

                      var rowCount = table.rows.length;
                      var row = table.insertRow(rowCount);

                      var cell1 = row.insertCell(0);
                      var element1 = document.createElement("input");
                      element1.type = "checkbox";
                      element1.name="chkbox[]";
                      cell1.appendChild(element1);                    

                      var cell2 = row.insertCell(1);
                      var element2 = document.createElement("input");
                      element2.type = "text";
                      element2.name = "addition_state[]";
                      element2.className = "form-control";
                      cell2.appendChild(element2);

                      var cell3 = row.insertCell(2);
                      var element3 = document.createElement("input");
                      element3.type = "text";
                      element3.name = "lower_state[]";
                      element3.className = "form-control";
                      cell3.appendChild(element3);  


                      var cell4 = row.insertCell(3);
                      var element4 = document.createElement("input");
                      element4.type = "text";
                      element4.name = "upper_state[]";
                      element4.className = "form-control";
                      cell4.appendChild(element4);  

                      var cell5 = row.insertCell(4);
                      var element5 = document.createElement("input");
                      element5.type = "text";
                      element5.name = "rate_amt_state[]";
                      element5.className = "form-control";
                      cell5.appendChild(element5);  

                    }

                    function deleteRow1(tableID) {
                      try {
                      var table = document.getElementById(tableID);
                      var rowCount = table.rows.length;

                      for(var i=0; i<rowCount; i++) {
                        var row = table.rows[i];
                        var chkbox = row.cells[0].childNodes[0];
                        if(null != chkbox && true == chkbox.checked) {
                          table.deleteRow(i);
                          rowCount--;
                          i--;
                        }


                      }
                      }catch(e) {
                        alert(e);
                      }
                    }

    //====================================
    function addRow2(tableID) {

                      var table = document.getElementById(tableID);

                      var rowCount = table.rows.length;
                      var row = table.insertRow(rowCount);

                      var cell1 = row.insertCell(0);
                      var element1 = document.createElement("input");
                      element1.type = "checkbox";
                      element1.name="chkbox[]";
                      cell1.appendChild(element1);

                      /*var cell2 = row.insertCell(1);
                      cell2.innerHTML = rowCount + 1;*/

                      var cell2 = row.insertCell(1);
                      var element2 = document.createElement("input");
                      element2.type = "text";
                      element2.name = "addition_city[]";
                      element2.className = "form-control";
                      cell2.appendChild(element2);

                      var cell3 = row.insertCell(2);
                      var element3 = document.createElement("input");
                      element3.type = "text";
                      element3.name = "lower_city[]";
                      element3.className = "form-control";
                      cell3.appendChild(element3);  


                      var cell4 = row.insertCell(3);
                      var element4 = document.createElement("input");
                      element4.type = "text";
                      element4.name = "upper_city[]";
                      element4.className = "form-control";
                      cell4.appendChild(element4);  

                      var cell5 = row.insertCell(4);
                      var element5 = document.createElement("input");
                      element5.type = "text";
                      element5.name = "rate_amt_city[]";
                      element5.className = "form-control";
                      cell5.appendChild(element5);  

                    }

                    function deleteRow2(tableID) {
                      try {
                      var table = document.getElementById(tableID);
                      var rowCount = table.rows.length;

                      for(var i=0; i<rowCount; i++) {
                        var row = table.rows[i];
                        var chkbox = row.cells[0].childNodes[0];
                        if(null != chkbox && true == chkbox.checked) {
                          table.deleteRow(i);
                          rowCount--;
                          i--;
                        }


                      }
                      }catch(e) {
                        alert(e);
                      }
                    }

    //======== Insert State rate ============

    // $('.save-rate-state').on('click',function() {
    //         var state = $('#zone-rate-state').val();
    //         var rate = $('#zoneRateState').val();
    //   var to_pay_charges = $('#state_to_pay_charges').val();
    //   var cod = $('#state_cod').val();
    //   var edd = $('#state_edd').val();
    //         var rateMasterId = $('#rateMasterId').val();
    //         var customerId = $('#customerId').val();
            
    //         var formData = $("#form1");
    //         $.ajax({             
    //             cache: false,
    //             dataType: "json",
    //              url: '<?php echo base_url() ?>ratemaster/saveStateRateMaster',
    //              type: "POST",
    //              data: formData.serialize(),
    //             success: function(data) {
    //                alert(data.message);
    //                return false;
                    
    //             }
    //         });  
    //     });

//====================Insert city rate==============
$('.save-rate-city').on('click',function() {
      
            var city = $('#zone-rate-city').val();
            var rate = $('#zoneRateCity').val();
            var to_pay_charges = $('#city_to_pay_charges').val();
            var cod = $('#city_cod').val();
            var edd = $('#city_edd').val();
            var rateMasterId = $('#rateMasterId').val();
            var customerId = $('#customerId').val();
            
            var formData = $("#form2");
            
            $.ajax({
                cache: false,
                dataType: "json",
                 url: '<?php echo base_url() ?>ratemaster/saveCityRateMaster',
                 type: "POST",
                 data: formData.serialize(),
                
                success: function(data) {
                   alert(data.message);
                   return false; 
                }
            });  
        });

function get_state_rates(){
    var zoneId = $('#zone').val();
    var rateMasterId = $("#rateMasterId").val();
    var stateId = $("#zone-rate-state").val();

    $.ajax({
      type: 'POST',
      url: '<?php echo base_url() ?>ratemaster/getStateRates',
      data: {zoneId:zoneId, rateMasterId:rateMasterId, stateId:stateId},
      dataType: "json",
      success: function(data) {
        var option = '';
        
        $("#zoneRateState").val(data.rate);
        $("#state_to_pay_charges").val(data.to_pay_charges);
        $("#state_cod").val(data.cod);
        $("#state_edd").val(data.edd);
        get_city_rates();
      }
    });  
  }

  function get_city_rates(){
    var zoneId = $('#zone').val();
    var rateMasterId = $("#rateMasterId").val();
    var cityId = $("#zone-rate-city").val();

    $.ajax({
      type: 'POST',
      url: '<?php echo base_url() ?>ratemaster/getCityRates',
      data: {zoneId:zoneId, rateMasterId:rateMasterId, cityId:cityId},
      dataType: "json",
      success: function(data) {
        var option = '';

        $("#zoneRateCity").val(data.rate);
        $("#city_to_pay_charges").val(data.to_pay_charges);
        $("#city_cod").val(data.cod);
        $("#city_edd").val(data.edd);
      }
    });  
  }
  //======================
   function getCityList()
        {
            var state = $('#zone-rate-state').val();           
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
                    $('#zone-rate-city').html(option);
                    
                }
            });  
        }
        

    
  </script>


		
		
		
		
		