<?php $this->load->view('admin/admin_shared/admin_header'); ?>
<!-- END Head-->

<!-- START: Body-->

<body id="main-container" class="default">


  <!-- END: Main Menu-->
  <?php $this->load->view('admin/admin_shared/admin_sidebar');
  // include('admin_shared/admin_sidebar.php'); 
  ?>
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
                <h4 class="card-title">Add Pod</h4>
                <a href="<?php echo base_url('Admin_pod/update_uploaded_pod'); ?>" style="float:right;"><button
                    class="btn btn-danger">Update Pod</button></a>
              </div>
              <div class="card-body">

                <div class="row">
                  <div class="col-12">
                    <form role="form" action="admin/insert-pod" method="post" enctype="multipart/form-data">
                      <div class="box-body">
                        <div class="form-group row">
                          <label class="col-sm-2 col-form-label">Booking Date DRS:</label>
                          <div class="col-sm-2">
                            <input type="datetime-local" class="form-control"
                              value="<?php echo Date('Y-m-d\TH:i', time()) ?>" required name="booking_date"
                              id="mastermenifest_back" max="<?= date('Y-m-d') . 'T' . date('H:i'); ?>">
                          </div>
                          <label class="col-sm-2 col-form-label">Airway No Delivery Perosn:</label>
                          <div class="col-sm-2">
                            <select class="form-control" name="pod_no" id="selectsingle" required>
                              <option value="">Airway No</option>
                              <?php
                              if (count($deliverysheet)) {
                                foreach ($deliverysheet as $rows) {
                                  $podno = $rows['pod_no'];
                                  $res = $this->db->query("select count(pod_no) as total from tbl_domestic_tracking where pod_no='$podno' and status='delivered'");
                                  $total = $res->row()->total;
                                  //echo $total;
                                  if ($total >= 0) {
                                    ?>
                                    <option value="<?php echo $rows['pod_no']; ?>">
                                      <?php echo $rows['pod_no']; ?>-
                                      <?php echo $rows['sender_name']; ?>-
                                      <?php echo $rows['reciever_name']; ?>
                                    </option>
                                    <?php
                                  }
                                }
                              } else {
                                echo "<p>No Data Found</p>";
                              }
                              ?>
                            </select>
                          </div>
                          <label style="display:none;" class="col-sm-2 col-form-label">Booking Date DRS:</label>
                          <div style="display:none;" class="col-sm-2">
                            <input type="datetime-local" class="form-control" id="booking_date"
                              value="<?php echo date('Y-m-d H:i:s'); ?>" name="booking_date">
                          </div>
                          <!-- <label class="col-sm-2 col-form-label">Delivery Date :</label>
                               <div class="col-sm-2">
                                 <input type="datetime-local" class="form-control" id="jq-validation-email" name="delivery_date" >
                               </div> -->
                          <label class="col-sm-2 col-form-label">Upload Image:</label>
                          <div class="col-sm-2">
                            <input type="file" class="form-control" id="jq-validation-email" name="image"
                              placeholder="Slider Image">
                          </div>
                          <label  class="col-sm-2 col-form-label menimaster_check" >Remark<span class="compulsory_fields" >*</span></label>
												<div class="col-sm-2 menimaster_check">
													<textarea type="text" name="remark" id="masterm_reason" class="form-control" value="<?php //echo $bid; ?>"></textarea>
												</div>
                          <div class="col-md-12 mt-3 ml-5">
                            <div class="box-footer">
                              <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            </div>
                          </div>
                    </form>
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
  //include('admin_shared/admin_footer.php'); 
  ?>
  <!-- START: Footer-->
</body>
<!-- END: Body-->
<script type="text/javascript">
  $("#selectsingle").select2();
  $("#mastermenifest_back").change(function(){
		let dt = $("#mastermenifest_back").val();
		var bdt = new Date(dt);
		var bmonth = bdt.getMonth()+1; var bday = bdt.getDate();
		var boutput = bdt.getFullYear() + '/' + (bmonth<10 ? '0' : '') + bmonth + '/' +  (bday<10 ? '0' : '') + bday;

		var d = new Date();
		var month = d.getMonth()+1; var day = d.getDate();

		var output = d.getFullYear() + '/' + (month<10 ? '0' : '') + month + '/' +  (day<10 ? '0' : '') + day;
		if(output == boutput){
			// $("#bkdate_reason").attr("required", "false");
			$("#masterm_reason").removeAttr("required");
			// $('.menimaster_check').css({"display":"none"});
		}else{
			$("#masterm_reason").attr("required", "true");
			$('.menimaster_check').css({"display":"flex"});
		}
	});
</script>