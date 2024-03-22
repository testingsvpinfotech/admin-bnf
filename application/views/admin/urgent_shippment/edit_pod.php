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
                                <h4 class="card-title">Edit Shipment</h4>                                
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">                                           
                                        <div class="col-12">
                                           <!--  <form role="form" action="<?php echo base_url();?>Admin_company_manager/updatecompany/<?php //echo $booking[0]['id'];?>" method="post" enctype="multipart/form-data"> -->

                                <form role="form" action="<?php echo base_url(); ?>generatepod/updatepodnew/<?php echo $booking[0]['booking_id']; ?>" method="post">
                                     <h3 class="box-title">Consigner</h3>
                                    <div class="form-row">
                                        <div class="col-3 mb-3">
                                            <label for="username">Address</label>

                                     <input type="text" name="sender_address" id="sender_address" value="<?php echo $booking[0]['sender_address']; ?>" class="form-control my-colorpicker1">
                                    </div>
                                    <div class="col-3 mb-3"> 
                                            <label for="email">City</label>    
                                            <select class="form-control"  name="sender_city" id="sender_city" required>
                                        <option value="">Select City</option>
                                        <?php
                                        if (count($cities)) {
                                            foreach ($cities as $rows) {
                                                ?>
                                                <option value="<?php echo $rows['city_id']; ?>" <?php if($booking[0]['sender_city'] == $rows['city_id']) { echo 'selected="selected"';} ?>>
                                                    <?php echo $rows['city_name']; ?> 
                                                </option>
                                                <?php
                                            }
                                        } else {
                                            echo "<p>No Data Found</p>";
                                        }
                                        ?>
                                    </select>
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label for="username">Pincode No</label>
										 <input type="text" name="sender_pincode" id="sender_pincode" value="<?php echo $booking[0]['sender_pincode']; ?>" class="form-control my-colorpicker1">
                                    </div>
                                    <div class="col-3 mb-3"> 
                                        <label for="email">Contact No</label>       
                                         <input type="text" name="sender_contactno" id="sender_contactno" value="<?php echo $booking[0]['sender_contactno']; ?>" class="form-control my-colorpicker1">
                                    </div>

                                    <div class="col-3 mb-3">
                                        <label for="username">Sender GST NO</label>
                                       <span><input type="text" name="sender_gstno" id="sender_gstno" value="<?php echo $booking[0]['sender_gstno'] ?>" class="form-control my-colorpicker1"></span>
                                    </div>
                                  </div>
                                       <div class="form-row">
                                            <h3 class="box-title">Consignee</h3>
                                        </div>
                                             <div class="form-row">
                                            <div class="col-3 mb-3">
                                                <label for="username">Name</label>
                                               <input type="text" name="reciever_name" id="reciever"  value="<?php echo $booking[0]['reciever_name']; ?>" class="form-control my-colorpicker1">
                                            </div> 
                                            <div class="col-3 mb-3">
                                                <label for="username">Address</label>
                                                <input type="text" name="reciever_address" id="reciever_address" value="<?php echo $booking[0]['reciever_address']; ?>" class="form-control my-colorpicker1">
                                            </div> 

                                            <div class="col-3 mb-3">
                                                <label for="username">Pincode No</label>
                                              <input type="text" name="reciever_pincode" id="reciever_pincode" value="<?php echo $booking[0]['reciever_pincode']; ?>" class="form-control my-colorpicker1 reciever_pincode">
                                            </div> 

                                            <div class="col-3 mb-3">
                                                <label for="username">City</label>
                                                <select class="form-control" name="reciever_city" id="reciever_city" required>
                                                    <option value="">Select City</option>
                                                    <?php
                                                    foreach ($cities as $rows) {
                                                    ?>
                                                        <option value="<?php echo $rows['city_id']; ?>" <?php if($booking[0]['reciever_city'] == $rows['city_id']) { echo 'selected="selected"';} ?>>
                                                            <?php echo $rows['city_name']; ?> 
                                                        </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div> 

                                            <div class="col-3 mb-3">
                                                <label for="username">Contact No</label>
                                                <input type="text" name="reciever_contact" id="reciever_contactno" value="<?php echo $booking[0]['reciever_contact']; ?>" class="form-control my-colorpicker1">
                                            </div> 

                                            <div class="col-3 mb-3">
                                             <label for="username">Reciever GST NO</label>
                                             <input type="text" name="receiver_gstno" id="reciever_gstno" value="<?php echo $booking[0]['receiver_gstno']; ?>" class="form-control my-colorpicker1">
                                            </div> 
                                            <div class="col-3 mb-3">
                                                <label for="username">INV No</label>
                                               <input type="text" name="inv_no" class="form-control my-colorpicker1">
                                            </div> 

                                            <div class="col-3 mb-3">
                                                <label for="username">Ins. Value</label>
                                             <input type="text" name="insurance_value" value="<?php echo $booking[0]['insurance_value']; ?>" class="form-control my-colorpicker1">
                                            </div> 
                                             <div class="col-12 mb-3">
                                    <table>
                                    <thead>
                                    <th>Actual Weight:</th>
                                    <th>Valumetric Weight</th>
                                    <th>L</th>
                                    <th>B</th>
                                    <th>H</th>
                                    <th>1CFT(kg)</th>
                                    <th>Inch L</th>
                                    <th>B</th>
                                    <th>H</th>
                                    <th>1CFT(kg)</th>
                                    <th>ChargeableWeight</th>
                                    <thead>
                                    <tbody>
                                    <td><input type="text" name="actual_weight" value="<?php echo $weight[0]['actual_weight']; ?>" class="form-control my-colorpicker1" id="actual_weight"></td>
                                    <td><input type="text" name="valumetric_weight" value="<?php echo $weight[0]['valumetric_weight']; ?>" class="form-control my-colorpicker1" id="valumetric_weight"></td>
                                    <td><input type="text" name="length" value="<?php echo $weight[0]['length']; ?>" class="form-control my-colorpicker1" id="length"></td>
                                    <td><input type="text" name="breath" value="<?php echo $weight[0]['breath']; ?>" class="form-control my-colorpicker1" id="breath"></td>
                                    <td><input type="text" name="height" value="<?php echo $weight[0]['height']; ?>" class="form-control my-colorpicker1" id="height"></td>
                                    <td><input type="text" name="one_cft_kg" value="<?php echo $weight[0]['one_cft_kg']; ?>" class="form-control my-colorpicker1" id="one_cft_kg"></td>
                                    <td><input type="text" name="inch_l" value="<?php echo $weight[0]['length']; ?>" class="form-control my-colorpicker1" readonly="readonly"></td>
                                    <td><input type="text" name="breath" value="<?php echo $weight[0]['breath']; ?>" class="form-control my-colorpicker1" readonly="readonly"></td>
                                    <td><input type="text" name="height" value="<?php echo $weight[0]['height']; ?>" class="form-control my-colorpicker1" readonly="readonly"></td>
                                    <td><input type="text" name="one_cft_kg" value="<?php echo $weight[0]['one_cft_kg']; ?>" class="form-control my-colorpicker1" readonly="readonly"></td>
                                    <td><input type="text" name="chargable_weight1" value="<?php echo $weight[0]['chargable_weight']; ?>" readonly="readonly" class="form-control my-colorpicker1"></td>
                                    </tbody>
                                </table>
                                </div> 

                                    <div class="col-3 mb-3">
                                                <label for="username">Special Instruction</label>
                                              <textarea name="special_instruction" value="<?php echo $weight[0]['special_instruction']; ?>" class="form-control my-colorpicker1"></textarea>
                                            </div> 

                                            <div class="col-3 mb-3">
                                                <label for="username">No. of Pack</label>
                                            <input type="text" name="no_of_pack" value="<?php echo $weight[0]['no_of_pack']; ?>" class="form-control my-colorpicker1" id="no_of_pack">
                                            </div>
                                            <div class="col-3 mb-3">
                                                <label for="username">Type of Pack</label>
                                               <input type="text" name="type_of_pack" value="<?php echo $weight[0]['type_of_pack']; ?>" class="form-control my-colorpicker1">
                                            </div> 

                                            <div class="col-3 mb-3">
                                                <label for="username">Booking Date</label>
                                            <input type="text" name="booking_date" value="<?php echo date('d/m/Y',strtotime( $booking[0]['booking_date']));?>" id="booking_date" class="form-control my-colorpicker1 datepicker">
                                            </div>
                                             <div class="col-3 mb-3">
                                                <label for="username">Delivery Date</label>
                                            <input type="text" name="delivery_date" value="<?php echo $booking[0]['delivery_date'];?>" id="eod" class="form-control my-colorpicker1 datepicker">
                                            </div>














                                            

                                            <div class="col-12">
                                                <input type="submit" class="btn btn-primary" name="submit" value="Submit">  
                                                <!--  <button type="submit" class="btn btn-outline-warning">Reset</button> -->
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


		
		
		
		
		