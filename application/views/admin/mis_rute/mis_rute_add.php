<?php $this->load->view('admin/admin_shared/admin_header'); ?>
    <!-- END Head-->
<style>
  	.input:focus {
    outline: outline: aliceblue !important;
    border:2px solid red !important;
    box-shadow: 2px #719ECE;
  }
  </style>
    <!-- START: Body-->
    <body id="main-container" class="default">

        
        <!-- END: Main Menu-->
    <?php $this->load->view('admin/admin_shared/admin_sidebar');
   // include('admin_shared/admin_sidebar.php'); ?>
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
                              <h4 class="card-title">Mis Rute Add</h4>  
                          </div>
                          <div class="card-body">
                          	 <?php if($this->session->flashdata('notify') != '') {?>
  <div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
  <?php  unset($_SESSION['class']); unset($_SESSION['notify']); } ?>                             
						  
								<div class="col-md-12">
                                    <form action="<?= base_url('admin/mis-rute'); ?>" method="post">
								<input type="text" id="search_data" name="awb_no" placeholder="Enter AWB No" style="float: right;" >
								<input type="submit" id="btn_search" name="submit" style="float: right;"  value="Search">
                                </form>
								<br>
								<!--  col-sm-4--> 
                                <form action="<?= base_url('admin/mis-rute'); ?>" method="post">
									<table class="table table-bordered table-striped">
										<thead>
										<tr>
											<th></th>
											<th>AWB No.</th>
											<th>Shipper Name </th> 
											<th>Consignee</th>
											<th>Mode</th>
											<th>Booking From</th>
											<th>Destination</th>
											<th>To Pay</th>
											<th>Qty/Pcs</th>
											<th>Actual Wt</th>
											<th>Charged Wt</th>
										</tr>
										</thead>
										<tbody >
                                            <?php if($result){ //print_r($result);
                                                foreach($result as $value){ ?>
                                                <tr>
                                            <td></td>
                                            <td><?=$value['pod_no']; ?></td>
                                            <td><?=$value['sender_name']; ?></td>
                                            <td><?=$value['reciever_name']; ?></td>
                                           <?php $whr =array("transfer_mode_id"=>$value['mode_dispatch']);
                                                    $country_details =$this->basic_operation_m->get_table_row("transfer_mode",$whr);
                                                 ?> 
                                            <td><?=$country_details->mode_name; ?></td>
                                           <?php $whr1 =array("id"=>$value['sender_city']);
                                                    $country_details1 =$this->basic_operation_m->get_table_row("city",$whr1);
                                                 ?> 
                                            <td><?=$country_details1->city; ?></td>
                                           <?php $whr2 =array("id"=>$value['reciever_city']);
                                                    $country_details2 =$this->basic_operation_m->get_table_row("city",$whr2);
                                                 ?> 
                                            <td><?=$country_details2->city; ?></td>
                                            <td><?=$value['dispatch_details']; ?></td>
                                            <?php $whr3 =array("booking_id"=>$value['booking_id']);
                                                    $country_details3 =$this->basic_operation_m->get_table_row("tbl_domestic_weight_details",$whr3);
                                                 ?> 
                                            <td><?=$country_details3->per_box_weight; ?></td>
                                            <td><?=$country_details3->actual_weight; ?></td>
                                            <td><?=$country_details3->chargable_weight; ?></td>

                                            </tr>
                                           <?php     }
                                            } ?>
										</tbody>

									</table> 
                                    <input type="hidden" name="awb" value="<?=$value['pod_no'];?>">
                                    <input type="hidden" name="branch_id" value="<?=$value['booking_id'];?>">
                                    <input type="hidden" name="branch" value="<?=$country_details1->city;?>">
                                    <button type="submit" name="submit" class="btn btn-primary" >Submit</button>
                                    </form>
								<!--  box body-->
								</div>
								</form> 
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


<?php 

function dateTimeValue($timeStamp)
{
    $date = date('d-m-Y',$timeStamp);
    $time = date('H:i:s',$timeStamp);
    return $date.'T'.$time;
}

?>