<?php include(dirname(__FILE__) . '/../admin_shared/admin_header.php'); 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?>
<!-- END Head-->
<style>
	.form-control {
		color: black !important;
		border: 1px solid var(--sidebarcolor) !important;
		height: 27px;
		font-size: 10px;
	}

	.select2-container--default .select2-selection--single {
		background: lavender !important;
	}

	/*.frmSearch {border: 1px solid #A8D4B1;background-color: #C6F7D0;margin: 2px 0px;padding:40px;border-radius:4px;}*/
	/*#city-list{float:left;list-style:none;margin-top:-3px;padding:0;width:190px;position: absolute;z-index: 7;}*/
	/*#city-list li{padding: 10px; background: #F0F0F0; border-bottom: #BBB9B9 1px solid;}*/
	/*#city-list li:hover{background:#ece3d2;cursor: pointer;}*/
	/*#reciever_city{padding: 10px;border: #A8D4B1 1px solid;border-radius:4px;}*/
	form .error {
		color: #ff0000;
	}

	.compulsory_fields {
		color: #ff0000;
		font-weight: bolder;
	}

	.select2-container *:focus {
		border: 1px solid #3c8dbc !important;
		border-radius: 8px 8px !important;
		background: #ffff8f !important;
	}

	input:focus {
		background-color: #ffff8f !important;
	}

	select:focus {
		background-color: #ffff8f !important;
	}

	textarea:focus {
		background-color: #ffff8f !important;
	}

	.btn:focus {
		color: red;
		background-color: #ffff8f !important;
	}


	input,
	textarea {
		text-transform: uppercase;
	}

	::-webkit-input-placeholder {
		/* WebKit browsers */
		text-transform: none;
	}

	:-moz-placeholder {
		/* Mozilla Firefox 4 to 18 */
		text-transform: none;
	}

	::-moz-placeholder {
		/* Mozilla Firefox 19+ */
		text-transform: none;
	}

	:-ms-input-placeholder {
		/* Internet Explorer 10+ */
		text-transform: none;
	}

	::placeholder {
		/* Recent browsers */
		text-transform: none;
	}

	.card .card-header {
		background-color: transparent;
		border-color: var(--bordercolor);
		padding: 15px;
		background-color: #ea5a2a;
		color: #fff;
	}
</style>
<!-- START: Body-->

<body id="main-container" class="default">

	<!-- END: Main Menu-->

	<?php include(dirname(__FILE__) . '/../admin_shared/admin_sidebar.php'); ?>
 <main>
 <div class="container-fluid site-width" style="margin-top:50px;">
            <!-- START: Listing-->
            <div class="row">
                <div class="col-12  align-self-center">
                    <div class="col-12 col-sm-12 mt-3">
                        <div class="card">
                            <div class="card-header justify-content-between align-items-center">
                               <div class="float-left"><h4 class="card-title" style="color: #fff;">Pickup Requests List</h4></div>
                               <form method ="POST"  action="admin/view-pickup-request">
                                <div class="float-right"><button  type="submit" value="Download Report" name="download_report" class="btn btn-primary">Download Excel</button></div>
                               </form>
                            </div>


                   
                <?php if ($this->session->flashdata('notify') != '') { ?>
                    <div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
                <?php unset($_SESSION['class']);
                    unset($_SESSION['notify']);
                } ?>
           
           <div class="table-responsive">
            <table id="id1" class="display table  table-responsive table-striped table-bordered">
          <thead>
                  <tr>
                        <th  scope="col">Sr.no</th>
                        <th  scope="col">Consignee Name</th>
                        <th  scope="col">Pickup Request_id</th>
                        <th  scope="col">Consignee Contact</th>
                        <th  scope="col">Consignee Address1</th>
                        <th  scope="col">Consignee Address2</th>
                        <th  scope="col">Consignee Address3</th>
                        <th  scope="col">Consignee Email</th>
                        <th  scope="col">Pickup Pincode</th>
                        <th  scope="col">Destination Pincode</th>
                        <th  scope="col">Pickup Location</th>
                        <th  scope="col">Pickup Date</th>
                        <th  scope="col">Destination City</th>
                        <th  scope="col">Instruction</th>
                        <th  scope="col">Mode</th>
                        <th  scope="col">Weight</th>
                        <th  scope="col">Type Of Package</th>
                        <th  scope="col">NOP </th>
                        <th  scope="col">PRQ Generate Date </th>
                       
                  </tr>
              </thead>
              <tbody>
         <?php 
            if (!empty($all_request))
            {
                $cnt = 1;
                foreach ($all_request as $value) 
                {

            ?>
                    <tr>
                        <td><?php echo $cnt++; ?></td>
                        <td><?php echo $value->consigner_name; ?></td>
                        <td><?php echo $value->pickup_request_id; ?></td>
                        <td><?php echo $value->consigner_contact; ?></td>
                        <td><?php echo $value->consigner_address1; ?></td>
                        <td><?php echo $value->consigner_address2; ?></td>
                        <td><?php echo $value->consigner_address3; ?></td>
                        <td><?php echo $value->consigner_email; ?></td>
                        <td><?php echo $value->pickup_pincode; ?></td>
                        <td><?php echo $value->destination_pincode; ?></td>
                        <td><?php echo $value->pickup_location; ?></td>
                        <td><?php echo $value->pickup_date; ?></td>
                        <td><?php echo $value->city; ?></td>
                        <td><?php echo $value->instruction; ?></td>
                        <?php $mode_id =$value->mode_id; $DD = $this->db->query("select mode_name from transfer_mode where transfer_mode_id = '$mode_id'")->row();?>
                        <td><?php echo $DD->mode_name; ?></td>
                        <td><?php echo $value->actual_weight; ?></td>
                        <td><?php echo $value->type_of_package; ?></td>
                        
                        <td><?php echo $value->no_of_pack; ?></td>
                        <td><?php echo $value->create_date; ?></td>
                        
                     </tr>
            <?php 
                
                }
            }else{?>
                <tr><td colspan="12" style="color:red;">No Data Found</td></tr>
          <?php  } ?>
            
         </tbody>
         <!-- <input type="hidden" name="selected_campaing" id="selected_campaingss" value=""> -->
         </table>
</div>
                </div>
            </div>

        </div>
    </div>
    <!-- END: Card DATA-->
</div>
</main>

<?php include(dirname(__FILE__) . '/../admin_shared/admin_footer.php'); ?>


