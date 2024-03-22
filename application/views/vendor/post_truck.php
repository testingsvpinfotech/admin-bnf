    <!-- Content -->
    <div class="page-content">

        <!-- Client logo -->
        <div class="section-full dez-we-find bg-img-fix m-t50 p-b50" style="margin-top: 70px;">
            <div class="container">
                <div class="section-content">
                    <div class="row">
                    <div class="col-md-10">
                    <?php if (!empty($this->session->flashdata('msg'))) { ?>
                                <div class="alert alert-success" role="alert">
                                    <button type="button" class="close" data-dismiss="alert">X</button>
                                    <?php echo $this->session->flashdata('msg'); ?>
                                </div>
                            <?php } ?>

                    </div> 
                        <div class="col-md-12" style="box-shadow: 2px 3px 10px 5px rgb(0 0 0 / 9%);">
                            
                            <form class="p-a30 dez-form" action="<?php echo base_url('truck-post'); ?>" method="POST">
                                <h3 class="form-title m-t0" style="color:black;">POST YOUR TRUCK <span class="blink_data">LOCATION</span></h3>

                                <!-- <div class="form-group">
                                    <span style="margin-right: 40px;">Return Trip </span>
                                    <input type="radio" name="return_tip" value="1">yes
                                    <input type="radio" name="return_tip" value="2">No
                                </div> -->

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Vehicle Name</label>
                                            <input name="vehicle_name" required="" class="form-control" placeholder="Enter Vehicle Name" type="text" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                           <label>Vehicle Body Type</label>
                                            <input name="vehicle_body_type" required="" autocomplete="off" class="form-control" placeholder="Enter Vehicle Body Type" type="text" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                           <label>Vehicle capacity</label>
                                            <input name="vehicle_capacity" required="" autocomplete="off" class="form-control" placeholder="Enter Vehicle capacity" type="text" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Fuel Type</label>
                                            <select class="form-control" name="fuel_type" required="">
                                                <option>Select Fuel Type</option>
                                                <option value="Petrol">Petrol</option>
                                                <option value="Diesel">Diesel</option>
                                                <option value="CNG">CNG</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Vehicle Registration</label>
                                            <input type="text" name="vehicle_registeration" required="" class="form-control " placeholder="Enter Vehicle Registration" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>vehicle Number</label>
                                            <input type="text" name="truck_number" required="" class="form-control " placeholder="Enter Vehicle Number" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Vehicle Chassis</label>
                                            <input type="text" name="vehicle_chesis" required="" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Vehicle Model</label>
                                            <input type="text" name="vehicle_model" required="" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Vehicle PUC Date</label>
                                            <input type="date" name="vehicle_puc_date" required="" class="form-control" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Vehicle Fitness Expiry Date</label>
                                            <input type="date" name="vehicle_fitnes_expiry_date" required="" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Vehicle Permit Date</label>
                                            <input type="date" name="vehicle_prmit_date" required="" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Vehicle Insurance Renew</label>
                                            <input type="date" name="vehicle_insurance_renew" required="" class="form-control" />
                                        </div>
                                    </div>
                                </div>



                                <div class="form-group text-left m-0">
                                    <button type="submit" name="submit" class="site-button dz-xs-flex m-r10">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Client logo END -->
    </div>
    <!-- Content END-->
    <style>
    .blink_data {
    animation: blinker 1s linear infinite;
    font-weight: normal;
    color: #e95421;
}
@keyframes blinker{
50% {
    opacity: 0;
}
}
    </style>
  