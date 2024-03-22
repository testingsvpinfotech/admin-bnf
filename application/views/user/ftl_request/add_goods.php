<?php include(dirname(__FILE__) . '/../admin_shared/admin_header.php'); ?>
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
    <main>
        <div class="container-fluid site-width">


            <!-- START: Card Data-->
            <div class="row" style="margin-top: 100px;">
                <div class="col-12 mt-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-12 col-md-12 mt-3">
                                <div class="card p-4">
                                    <div class="card-body">
                                        <form action="<?php echo base_url(); ?>User_panel/goods_type" enctype="multipart/form-data" method="POST">
                                            <div class="" style="margin-bottom:20px; background-color:#1e3d5d;color:#fff;padding:10px;">
                                                <h6 class="mb-0 text-uppercase font-weight-bold">Add Goods Type</h6>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Goods Name</label>
                                                        <input type="text" name="goods_name" placeholder="Enter Goods Name" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" name="submit" class="btn  btn-lg btn-primary mt-2">Submit</button>
                                        </form>

                                        <div class = "mt-2">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <td>ID</td>
                                                        <td>Goods Name</td>
                                                        <td>Action</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($goods_name)) { ?>
                                                        <?php $i = 1; foreach ($goods_name as $value) : ?>
                                                            <tr>
                                                                <td><?= $i++;?></td>
                                                                <td><?=  $value->goods_name;?></td>
                                                                <td><a href=<?php echo base_url()."User_panel/update_goods_type/".$value->id;?> class="btn btn-success">Edit</a></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
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

    </main>
    <style>
        input:read-only {
            background-color: #ddd;
        }

        .form-group {
            margin-bottom: 20px !important;
        }
    </style>
    </main>
    <?php include(dirname(__FILE__) . '/../admin_shared/admin_footer.php'); ?>
    <!-- START: Footer-->
</body>

</html>