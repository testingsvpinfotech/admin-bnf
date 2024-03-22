<?php include(dirname(__FILE__) . '/../admin_shared/admin_header.php'); ?>
<!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAJfzOqR9u2eyXv6OaiuExD3jzoBGGIVKY&libraries=geometry,places&v=weekly"></script>

<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script> -->
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
</style>
<!-- START: Body-->

<body id="main-container" class="default">

    <!-- END: Main Menu-->

    <?php include(dirname(__FILE__) . '/../admin_shared/admin_sidebar.php'); ?>
    <!-- END: Main Menu-->

    <!-- START: Main Content-->

    <style>
        span .fa {
            color: red;
            font-size: 8px;
            position: relative;
            top: -5px;
            margin-top: 16px;
        }

        .form-control {
            height: 36px !important;
            font-size: 14px !important;
            border: 1px solid #000;
            border-radius: 0.2rem;
            -webkit-border-radius: 0.2rem;
            -moz-border-radius: 0.2rem;
            -ms-border-radius: 0.2rem;
            -o-border-radius: 0.2rem;
        }
    </style>
    <main>
        <div class="container-fluid site-width">


            <!-- START: Card Data-->
            <div class="row" style="margin-top: 100px;">
                <div class="col-12 mt-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row p-2">
                            <div class="col-12 col-md-12 mt-3">
                                <div class="card p-4">
                                    <div class="card-body">



                                        <form action="<?php echo base_url("admin/upload-trip-documents/".$ftl_id['id']); ?>" enctype="multipart/form-data" method="POST">


                                            <div class="" style="margin-bottom:20px;color:#e95320;padding:10px;">
                                                <h5 class="mb-0 text-uppercase font-weight-bold">Upload Pickup Documents</h5>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Ftl Request No.</label>
                                                        <input type="text"  class="form-control" name="ftl_id" value="<?php echo $ftl_id['ftl_request_id'] ?>" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Loading Slip Upload <span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></span></label>
                                                        <input type="file" name="loding_slip_upload" class="form-control" value="<?php echo set_value('loding_slip_upload') ?>" required="">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="control-label">Before Seal Photo Of Goods <span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></span></label>
                                                    <input type="file" name="before_seal_photo" class="form-control" value="<?php echo set_value('before_seal_photo') ?>" required="">
                                                </div>

                                                <div class="col-md-3">
                                                    <label class="control-label">After Seal Photo Of Goods <span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></span></label>
                                                    <input type="file" name="after_seal_photo" class="form-control" value="<?php echo set_value('after_seal_photo') ?>" required="">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="control-label">Empty Lorry Photo <span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></span></label>
                                                    <input type="file" name="empty_lorry_photo" class="form-control" value="<?php echo set_value('empty_lorry_photo') ?>" required="">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="control-label">Loaded Lorry Photo <span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></span></label>
                                                    <input type="file" name="loaded_lorry_photo" class="form-control" value="<?php echo set_value('loaded_lorry_photo') ?>" required="">
                                                </div>


                                                <div class="col-md-2 mt-4">
                                                    <button type="submit" name="submit" class="btn  btn-lg btn-primary mt-2">Submit</button>
                                                </div>
                                            </div>
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

    </main>
    <style>
        input:read-only {
            background-color: #ddd;
        }

        .form-group {
            margin-bottom: 20px !important;
        }


        #map-canvas {
            /* margin-top:80%; */
            display: none;
            height: 100%;
            margin: 0;
            padding: 0
        }

        canvas[resize] {
            width: 100%;
            height: 100%;
        }

        .controls {
            margin-top: 16px;
            border: 1px solid transparent;
            border-radius: 2px 0 0 2px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            height: 32px;
            outline: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        }

        #pac-input {
            bacground-color: #fff;
            font-family: Roboto;
            font-size: 15px;
            font-weight: 300;
            margin-left: 12px;
            padding: 0 11px 0 13px;
            text-overflow: ellipsis;
            width: 400px;
        }

        #pac-input:focus {
            border-color: #4d90fe;
        }

        .pac-container {
            font-family: Roboto;
        }

        #type-selector {
            color: #fff;
            background-color: #4d90fe;
            padding: 5px 11px 0px 11px;
        }

        #type-selector label {
            font-family: Roboto;
            font-size: 13px;
            font-weight: 300;
        }
    </style>
    </main>
    <?php include(dirname(__FILE__) . '/../admin_shared/admin_footer.php'); ?>
    <!-- START: Footer-->
</body>
<!-- END: Body-->

<script src="assets/js/domestic_shipment.js"></script>

</html>