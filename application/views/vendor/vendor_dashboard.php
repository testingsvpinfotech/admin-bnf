    <!-- Content -->
    <div class="page-content">

        <!-- Client logo -->
        <div class="section-full dez-we-find bg-img-fix m-t50 p-b50" style="margin-top: 70px;">
            <div class="container">
                <div class="section-content">
                    <div class="row">

                        <div class="col-md-5">
                            <?php if (!empty($this->session->flashdata('msg'))) { ?>
                                <div class="alert alert-success" role="alert">
                                    <button type="button" class="close" data-dismiss="alert">X</button>
                                    <?php echo $this->session->flashdata('msg'); ?>
                                </div>
                            <?php } ?>

                        </div>
                        
                        <div class="col-md-12">

                            <div class="row">
                                <div class="col-md-5">


                                    <div class="card" style="box-shadow: 2px 3px 10px 5px rgb(0 0 0 / 9%);">
                                        <div class="card-content">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="media-body align-self-center ">
                                                        <span class="mb-0 h5 font-w-600">Total Posted Truck List</span><br>
                                                        <p class="mb-0 font-w-500 tx-s-12">2</p>
                                                    </div>
                                                    <!-- <div class="ml-auto border-0 outline-badge-warning circle-50"><span class="h5 mb-0">$</span></div> -->
                                                </div>
                                                <div id="flot-report" class="height-175 w-100 mt-3"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="card" style="box-shadow: 2px 3px 10px 5px rgb(0 0 0 / 9%);">
                                        <div class="card-content">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="media-body align-self-center ">
                                                        <span class="mb-0 h5 font-w-600"> Truck Order</span><br>
                                                        <? php // print_r($total_order);
                                                        ?>
                                                        <p class="mb-0 font-w-500 tx-s-12"><?php echo  $total_order[0]['total']; ?></p>
                                                    </div>
                                                    <!-- <div class="ml-auto border-0 outline-badge-warning circle-50"><span class="h5 mb-0">$</span></div> -->
                                                </div>
                                                <div id="flot-report" class="height-175 w-100 mt-3"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

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