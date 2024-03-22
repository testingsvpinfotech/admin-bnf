    <!-- Content -->
    <div class="page-content">

    <style type="text/css">
       
        #counter{
            width: 300px;
            background: black;
            /* box-shadow: 0px 2px 9px 0px black; */
        }
    </style> 

        <!-- Client logo -->
        <div class="section-full dez-we-find bg-img-fix m-t50 p-b50" style="margin-top: 70px;">
            <div class="container">




                <div class="section-content">
                    <div class="row">
                        <div class="col-md-12 Card" style="box-shadow: 2px 3px 10px 5px rgb(0 0 0 / 9%);">

                            <?php
                           
                            $actual_date = $ftl_request_data[0]['time_limit'];
                            $request_date = $ftl_request_data[0]['request_date'];

                            $selectedTime =    $actual_date;
                            $endtiming = strtotime("+30 minutes", strtotime($selectedTime));
                            $ac = date('h:i:s:a', $endtiming);

                            $starttime1 =  $request_date . ' ' . $ac;
                          
                           
                          ?>

                           
                            <?php  //if ($date <= $ftl_request_data[0]['time_limit']) { ?>
                                <!-- <div style="color:#fff;float: right;background-color: #e95421;padding: 10px;">
                                    <h4>Request Active</h4> <span id="timer"></span>
                                </div> -->

                            <?php //} else { // ?>

                                <!-- <div style="color:#fff;float: right;background-color: #333;padding:2px;"> -->
                                    <div style="float: right;">
                                    <!-- <h4 style="color: #fff; margin-bottom: 0px;">Remaining Bid Time </h4><span id="timer"></span> -->
                                    <h1 id="counter"  class="text-center mt-5 m-auto p-3 text-white"></h1>
                                </div>

                            <?php //} ?>

                            <form class="p-a30 dez-form" action="<?php echo base_url('vendor-request-for-truck'); ?>" method="POST">
                                <h4 style="color: #e95421;"> <i class="fa fa-star" aria-hidden="true"></i> Order Truck </h4>
                                <!--  date('Y-m-d H:i:s')  -->

                                <div class="row">
                                    <?php $dd = $this->session->userdata('customer_id'); ?>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Pickup Location</label>
                                            <input class="form-control" value="<?php echo $ftl_request_data[0]['pickup_address']; ?>" placeholder="Enter Vehicle Name" type="text" readonly>
                                            <input class="form-control" name="request_id" value="<?php echo $ftl_request_data[0]['id']; ?>" placeholder="Enter Vehicle Name" type="hidden">
                                            <input class="form-control" name="vendor_customer_id" value="<?php echo $dd; ?>" placeholder="Enter Vehicle Name" type="hidden">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Drop Location</label>
                                            <input class="form-control" value="<?php echo $ftl_request_data[0]['delivery_address']; ?>" placeholder="Enter Vehicle Body Type" type="text" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Pickup Date Time</label>
                                            <input type="text" value="<?php echo $ftl_request_data[0]['request_date_time']; ?>" required="" class="form-control " placeholder="Enter Vehicle Number" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Vehicle Capacity</label>
                                            <input class="form-control" value="<?php echo $ftl_request_data[0]['vehicle_capacity']; ?>" placeholder="Enter Vehicle Name" type="text" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Vehicle Type</label>
                                            <?php $vehicle_id = $ftl_request_data[0]['type_of_vehicle'];
                                            $get_vehicle_type = $this->db->query("select vehicle_name from vehicle_type_master where id = '$vehicle_id'")->row_array(); ?>
                                            <?php //echo $this->db->last_query();
                                            ?>
                                            <input class="form-control" value="<?php echo $get_vehicle_type['vehicle_name']; ?>" placeholder="Enter Vehicle capacity" type="text" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Goods Type</label>

                                            <?php $goods_type = $ftl_request_data[0]['goods_type'];
                                            $get_goods_type = $this->db->query("select goods_name from goods_type_tbl where id = '$goods_type'")->row_array(); ?>
                                            <?php // print_r($get_goods_type);
                                            ?>
                                            <input type="text" class="form-control" value="<?php echo $get_goods_type['goods_name']; ?>" placeholder="Enter Vehicle Registration" />
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>GPS</label>
                                            <input class="form-control" value="<?php echo $ftl_request_data[0]['vehicle_gps']; ?>" placeholder="Enter Vehicle Name" type="text" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Vehicle Floor Type</label>
                                            <input class="form-control" value="<?php echo $ftl_request_data[0]['vehicle_floor_type']; ?>" placeholder="Enter Vehicle Floor Type" type="text" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Vehicle Body Type</label>
                                            <input type="text" class="form-control" value="<?php echo $ftl_request_data[0]['vehicle_body_type']; ?>" placeholder="Enter Vehicle Body Type" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Goods Weight</label>
                                            <input class="form-control" value="<?php echo $ftl_request_data[0]['goods_weight']; ?>" placeholder="Enter Vehicle Name" type="text" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Vehicle Wheel Type</label>
                                            <input class="form-control" value="<?php echo $ftl_request_data[0]['vehicle_wheel_type']; ?>" placeholder="Enter Vehicle Floor Type" type="text" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Loading</label>
                                            <input class="form-control" value="<?php echo $ftl_request_data[0]['loading_type']; ?>" placeholder="Enter Vehicle Floor Type" type="text" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>UnLoading</label>
                                            <input class="form-control" value="<?php echo $ftl_request_data[0]['unloading_type']; ?>" placeholder="Enter Vehicle Floor Type" type="text" readonly>
                                        </div>
                                    </div>

                                </div>

                                <div>
                                    <h4 style="color: #e95421;"> <i class="fa fa-star" aria-hidden="true"></i> Fill Enter Below Details</h4>
                                </div>
                                <div class="row">
                                 
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Amount</label>
                                            <input type="text" name="vendor_amount" id="vendor_amount" placeholder="Enter Advance Amount" required="" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Advance Percentage</label>
                                            <input type="text" name="advance_amount_percentage" placeholder="Enter Advance In Percentage" id="vendor_per_amount" required="" max="90" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Advance Amount </label>
                                            <input type="text" name="advance_amount" id="total_amount" required="" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Remaining Amount </label>
                                            <input type="text" name="remaining_amount" id="remaining_amount" required="" class="form-control" />
                                        </div>
                                    </div>


                                </div>
                               
                                <div class="form-group text-left m-0">
                                    <button type="submit" name="submit" id ="hide_btn" class="site-button dz-xs-flex  m-r10">Submit</button>
                                </div>
                             
                            </form>

                            <p><b>Payment Terms : </b> 80% Advance payment and remaining 20% payment after delivery</p>
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

        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }
    </style>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

    <script>
        $('#vendor_amount, #vendor_per_amount').keyup(function() {
            var value1 = parseFloat($('#vendor_amount').val()) || 0;
            var value2 = parseFloat($('#vendor_per_amount').val())||0;

            if( value2 <= '90'){
            var d = value1 / 100 * value2
            $('#total_amount').val(d);
            }else{
                // alert ('Max advance Amount 90%');
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Advance Can not be more than 90%',
                    showConfirmButton: true
                                  }).then(function(){
                                      window.location.reload();
                 });
                
              
            }

        });

        $('#total_amount, #vendor_amount').keyup(function() {
            var value1 = parseFloat($('#total_amount').val()) || 0;
            var value2 = parseFloat($('#vendor_amount').val()) || 0;
            $('#remaining_amount').val(value2 - value1);
        });
    </script>


<script>
        <?php 
        //    $dateTime = strtotime('April 11, 2022 19:00:00');
           $getDateTime =  $starttime1;
        ?>
        var countDownDate = new Date("<?php echo "$getDateTime"; ?>").getTime();
        // Update the count down every 1 second
        var x = setInterval(function() {
            var now = new Date().getTime();
            // Find the distance between now an the count down date
            var distance = countDownDate - now;
            console.log(now);
            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            // Output the result in an element with id="counter"11
            document.getElementById("counter").innerHTML = days + "Day : " + hours + "h " +
            minutes + "m " + seconds + "s ";
            // If the count down is over, write some text 
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("counter").innerHTML = "EXPIRED";
                document.getElementById("hide_btn").style.display = "none";
                
            }
        }, 1000);

    </script>







    <!-- <script>
        // Set the date we're counting down to
        // var countDownDate = new Date("1 23, 2023 12:37:25").getTime();
        //var countDownDate = <?php // echo $diff; 
                                ?>
        // Update the count down every 1 second


        var countDownDate = <?php
                            echo strtotime("$date $h:$m:$s") ?> * 1000;
        var now = <?php echo time() ?> * 1000;

        var x = setInterval(function() {

            now = now + 1000;

            // Get today's date and time
            //   var now = new Date().getTime();

            // Find the distance between now and the count down date


            var distance = countDownDate - now;


            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Output the result in an element with id="demo"
            document.getElementById("demo").innerHTML = days + "d " + hours + "h " +
                minutes + "m " + seconds + "s ";

            // If the count down is over, write some text 
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("timer").innerHTML = "EXPIRED";
            }
        }, 1000);
    </script> -->
<!-- 
    <script>
        var h4 = document.getElementsByTagName("h4");

        <?php // $selectedTime = $actual_date;
        ?>
        // var endtiming <?php strtotime("+30 minutes", strtotime($selectedTime)); ?>


        // $starttime = strtotime($selectedTime);
        var sec = 1800,
            countspan = document.getElementById("timer"),
            secpass,
            countDown = setInterval(function() {
                secpass();
            }, 1000);

        function secpass() {


            var min = Math.floor(sec / 60),
                remSec = sec % 60;

            if (remSec < 10) {

                remSec = '0' + remSec;

            }
            if (min < 10) {

                min = '0' + min;

            }
            countspan.innerHTML = min + ":" + remSec;

            if (sec > 0) {

                sec = sec - 1;

            } else {

                clearInterval(countDown);

                countspan.innerHTML = 'Card Expire';

            }
        }
    </script> -->