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
        <h4 class="card-title">Update Regionwise Rate</h4>                                
    </div>
    <div class="card-content">
        <div class="card-body">
            <div class="row">                                           
                <div class="col-12">                
                   <form role="form" action="<?php echo base_url();?>admin/show_regionwise_rate/<?php echo $rate->rate_master_id;?>" method="post">

                        <div class="form-group row">
                            <div class="col-3 mb-3">
                                <label for="username">Customer</label>
                                <input type="text" class="form-control" name="customer_name" value="<?php echo $customer->customer_name;?>">
                                  <input type="hidden" class="form-control" name="customer_id" id="customerId" value="<?php echo $customer->customer_id;?>">
                                  <input type="hidden" class="form-control" name="rate_master_id" id="rateMasterId" value="<?php echo $rate->rate_master_id;?>">

                            </div>
                            <div class="col-3 mb-3"> 
                                <label for="email">Region</label>    
                                <select class="form-control " id="zone" name="region_id" required >
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
								                <select class="form-control" id="jq-validation-email" name="mode_name">
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
                                 <input type="text" class="form-control" id="jq-validation-email" name="rate" placeholder="Rate" value="<?php echo $rate->rate;?>" required>
                            </div>
            							</div>
            							 <div class="form-group row">
                                <div class="col-3 mb-3">
                                    <label for="username">Weight Range</label>
                                     <input type="text" name="weight_range" value="<?php echo $rate->weight_range; ?>" class="form-control" id="jq-validation-email" placeholder="Kg">
                                </div> 
                                 <div class="col-3 mb-3"> 
                                    <label for="email">DOC Charge</label>      
                                     <input type="text" name="dod_doac" class="form-control" id="dod_doac" placeholder="DOC Charge" value="<?php echo $rate->dod_doac; ?>">
                                </div>
            							</div>
            							<div class="form-group row">
                              <div class="col-3 mb-3">
                                <label for="username">Type</label>
                                 <select class="form-control" id="rate_type_sel" name="rate_type_sel" onchange="tgl(this.value)">
                                    <option value="" required>SELECT</option>
                                    <option value="0" <?php if($rate->price_type=="0"){echo "selected";} ?> >NON-DOC</option>
                                    <option value="1" <?php if($rate->price_type=="1"){echo "selected";} ?> >DOC</option>   
                                  </select>
                            </div>
                          </div>
						  
                           <div id="cons"  class="form-group row" style="display:none;" >
                             <div class="col-3 mb-3"> 
                                <label for="email">Loading Unloading</label>      
                                 <input type="text" value="<?php echo $rate->loading_unloading; ?>" name="loading_unloading" class="form-control" id="loading_unloading" placeholder="Loading/Unloading">
                            </div>
                            <div class="col-3 mb-3">
                                 <label for="packing">Packing</label>
                                 <input type="text" value="<?php echo $rate->packing; ?>" name="packing" class="form-control" id="Packing" placeholder="Packing">
                            </div> 
                            <div class="col-3 mb-3">
                                 <label for="handling">Handling</label>
                                 <input type="text" value="<?php echo $rate->handling; ?>" name="handling" class="form-control" id="handling" placeholder="Handling">
                            </div> 
                            <div class="col-3 mb-3">
                                 <label for="insurance">FOV</label>
                                  <input type="text" value="<?php echo $rate->fov; ?>" name="fov" class="form-control" id="insurance" placeholder="FOV">
                                </div>
                                <div class="col-3 mb-3">
                                     <label for="mimimum_insurance">Minimum FOV</label>
                                     <input type="text" name="minimum_fov" value="<?php echo $rate->min_fov; ?>" class="form-control" id="mimimum_insurance" placeholder="Minimum FOV">
                                </div> 
                                <div class="col-3 mb-3">
                               <label for="cft">CFT</label>
                               <input type="text" value="<?php echo $rate->cft; ?>" name="cft" class="form-control" id="cft" placeholder="CFT">
                            </div> 
                            <div class="col-3 mb-3">
                               <label for="fuel_charges">Fuel Charges</label>
                               <input type="text"value="<?php echo $rate->fuel_charges; ?>"  name="fuel_charges" class="form-control" id="fuel_charges" placeholder="Fuel Charges">
                            </div> 
                             <div class="col-3 mb-3">
                                <label for="exampleInputEmail1">No Of Pack:</label>
                                <?php $i = 1; 

                                if(!empty($rate_pack)) { 
                                  foreach($rate_pack as $rate_pack_value) { ?>
                                <div class="input-group control-group <?php if($i == count($rate_pack)) { echo'after-add-more';} ?> col-sm-12" style="margin-bottom:10px">
                                        <input type="text" name="nopackmorefrom[]" class="col-sm-3 custom-text" placeholder="From" value="<?php echo $rate_pack_value['from']; ?>">
                                        <input type="text" name="nopackmoreto[]" class="col-sm-3 custom-text" placeholder="To" value="<?php echo $rate_pack_value['to'] ?>">
                                        <input type="text" name="nopackrate[]" class="col-sm-3 custom-text" placeholder="Rate" value="<?php echo $rate_pack_value['rate']; ?>">
                                    <div class="input-group-btn col-sm-3">
                                        <?php if($i == 1) { ?>
                                        <button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                        <?php } else {  ?>
                                        <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php $i++; 
                              }
                            } ?>
                            </div> 
                          </div> 
                <div class="table-responsive form-group row" id="cont" style="display:none;">                  
                  <input type="button" value="Add Rate" class="btn btn-primary" onclick="addRow('dataTable')" />&nbsp;
                  <input type="button" value="Delete Rate" class="btn btn-danger" onclick="deleteRow('dataTable')" />

                  <table id="dataTable" class="table layout-primary bordered">
                    <tr>
                      <th scope="col">-</th>
                      <th scope="col"> Addition</th>
                      <th scope="col"> Lower Weight</th>
                      <th scope="col"> Upper Weight</th>
                      <th scope="col"> Rate</th>
                    </tr>                    
                    <?php                    
                    $CI=&get_instance();
                   $query = $CI->db->query("select * from `rate_master` where `rate_id` = '".$rate->rate_master_id."'");
                   $data = $query->result();
                    if(count($data))
                    {
                      foreach($data as $row)
                      {
                         ?>
                      <tr>
                        <td scope="col">
                        <input value="<?php echo $row->rate_master_id; ?>" type="checkbox" id="minimal-checkbox-11">
                        <label for="minimal-checkbox-11"></label></td>
                        <td> <input value="<?php echo $row->addition; ?>" style="width:70px" name="addition[]" type="text" class="form-control" /> </td>
                        <td> <input value="<?php echo $row->lower; ?>" style="width:70px" name="lower[]" type="text" class="form-control"/> </td>
                        <td> <input value="<?php echo $row->upper; ?>" style="width:70px" name="upper[]" type="text" class="form-control"/> </td>
                        <td> <input value="<?php echo $row->rate_amt; ?>" style="width:70px" name="rate_amt[]" type="text" class="form-control" /> </td>
                      </tr>
                         <?php
                      }
                    }
                    else
                    {
                     ?>
                     <tr>
                      <td scope="col"><input value="" type="checkbox" name="chk"/></td>
                      <td> <input value="" style="width:70px" name="addition[]" type="text" class="form-control"/> </td>
                      <td> <input value="" style="width:70px" name="lower[]" type="text" class="form-control"/> </td>
                      <td> <input value="" style="width:70px" name="upper[]" type="text" class="form-control" /> </td>
                      <td> <input value="" style="width:70px" name="rate_amt[]" type="text" class="form-control" /> </td>
                     </tr>
                   <?php
                    }
                    ?>
                  </table>
                 </div>
                 <!-- </div> -->
                  <div class="col-12">
                      <input type="submit" class="btn btn-primary" name="submit" value="Submit">
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
	<?php if($rate->price_type=="0"){ ?> $("#cons").show(); <?php } ?>
	<?php if($rate->price_type=="1"){ ?> $("#cont").show(); <?php } ?>
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
                      element2.style = "width:70px;";
                      cell2.appendChild(element2);

                      var cell3 = row.insertCell(2);
                      var element3 = document.createElement("input");
                      element3.type = "text";
                      element3.name = "lower[]";
                      element3.style = "width:70px;";
                      cell3.appendChild(element3);  


                      var cell4 = row.insertCell(3);
                      var element4 = document.createElement("input");
                      element4.type = "text";
                      element4.name = "upper[]";
                      element4.style = "width:70px;";
                      cell4.appendChild(element4);  

                      var cell5 = row.insertCell(4);
                      var element5 = document.createElement("input");
                      element5.type = "text";
                      element5.name = "rate_amt[]";
                      element5.style = "width:70px;";
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
      element2.style = "width:70px;";
      cell2.appendChild(element2);

      var cell3 = row.insertCell(2);
      var element3 = document.createElement("input");
      element3.type = "text";
      element3.name = "lower_state[]";
      element3.style = "width:70px;";
      cell3.appendChild(element3);  

      var cell4 = row.insertCell(3);
      var element4 = document.createElement("input");
      element4.type = "text";
      element4.name = "upper_state[]";
      element4.style = "width:70px;";
      cell4.appendChild(element4);  

      var cell5 = row.insertCell(4);
      var element5 = document.createElement("input");
      element5.type = "text";
      element5.name = "rate_amt_state[]";
      element5.style = "width:70px;";
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

  </script>


		
		
		
		
		