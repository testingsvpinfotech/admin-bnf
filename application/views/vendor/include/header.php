<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="keywords" content="" />
    <meta name="author" content="" />
    <meta name="robots" content="" />
    <meta name="description" content="CargoZone - Transport and Cargo Template" />
    <meta property="og:title" content="CargoZone - Transport and Cargo Template" />
    <meta property="og:description" content="CargoZone - Transport and Cargo Template" />
    <meta property="og:image" content="" />
    <meta name="format-detection" content="telephone=no"> -->

    <!-- FAVICONS ICON -->
    <link rel="icon" href="<?php echo base_url(); ?>vendor_assets/images/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>vendor_assets/images/favicon.png" />
    <!-- PAGE TITLE HERE -->
    <title>Boxn-Freight</title>
    <!-- MOBILE SPECIFIC -->
    <meta name="viewport" content="width=device-width">
    <!-- STYLESHEETS -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>vendor_assets/css/plugins.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>vendor_assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>vendor_assets/css/templete.css">
    <link rel="stylesheet" type="text/css" class="skin" href="<?php echo base_url(); ?>vendor_assets/css/skin/skin-2.css">

    <!-- REVOLUTION SLIDER CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>vendor_assets/plugins/revolution/revolution/css/settings.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>vendor_assets/plugins/revolution/revolution/css/navigation.css">

</head>
<style>
    .dropbtn {
        background-color: #4CAF50;
        color: white;
        padding: 16px;
        font-size: 16px;
        border: none;
        cursor: pointer;
    }

    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown-content a:hover {
        background-color: #f1f1f1
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }

    .dropdown:hover .dropbtn {
        background-color: #3e8e41;
    }
</style>


<body id="bg">
    <div class="page-wraper">
        <div id="loading-area"></div>
        <!-- Header -->
        <header class="site-header header-style-4 mo-left">
            <!-- Top Bar -->
            <div class="top-bar">
                <div class="fluid-container">
                    <div class="container">
                        <div class="row justify-content-between">
                            <div class="dez-topbar-left">
                                <ul class="social-line text-center pull-right">
                                    <li><a href="javascript:void(0);"><i class="fa fa-map-marker"></i> <span>Goregaon (East), Mumbai 400063</span> </a></li>
                                </ul>
                            </div>
                            <?php if(empty($this->session->userdata('customer_id') && $this->session->userdata('vcode'))){?>
                            <div class="dez-topbar-right">
                                <ul class="social-line text-center pull-right">
                                    <li><a href="<?php echo base_url('login'); ?>">Login</a></li>
                                    <li><a href="<?php echo base_url('add-vendor'); ?>">Registration</a></li>

                                </ul>
                            </div>
                            <?php } ?>
                            <div class="dez-topbar-right">
                                <ul class="social-line text-center pull-right">
                                    <li><a href="javascript:void(0);" class="fa fa-facebook"></a></li>
                                    <li><a href="javascript:void(0);" class="fa fa-twitter"></a></li>
                                    <li><a href="javascript:void(0);" class="fa fa-linkedin"></a></li>
                                    <li><a href="javascript:void(0);" class="fa fa-google-plus"></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Top Bar END-->
            <!-- Main Header -->
            <div class="sticky-header main-bar-wraper navbar-expand-lg">
                <div class="main-bar clearfix">
                    <div class="fluid-container header-contant-block">
                        <div class="container">
                            <div class="row">
                                <div class="col-xl-4 col-lg-3 d-flex">
                                    <div class="logo-header align-self-center">
                                        <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>vendor_assets/images/boxn.png" width="193" height="89" alt=""></a>
                                    </div>
                                </div>
                                <div class="col-xl-8 col-lg-9">
                                    <ul class="contact-info clearfix">
                                        <li>
                                            <h6 class="text-primary"><i class="fa fa-phone"></i> Call Us</h6>
                                            <span>+91-9819598197</span>
                                        </li>
                                        <li>
                                            <h6 class="text-primary"><i class="fa fa-envelope-o"></i> Send us an Email</h6>
                                            <span>customercare@boxnfreight.com</span>
                                        </li>



                                        <!-- <ul class="nav navbar-nav">
                                        <li><a href="javascript:;"><?php echo  $this->session->Userdata('username'); ?><i class="fa fa-chevron-down"></i></a>
                                            <ul class="sub-menu">
                                                <li><a href="construct-home-style-1.html">Dashboard</a></li>
                                                <li><a href="construct-home-style-2.html">Truck Posted List</a></li>
                                                <li><a href="construct-home-style-3.html">User Profile</a></li>
                                                <li><a href="construct-home-style-4.html">Logout</a></li>
                                            </ul>
                                        </li>
                                    </ul> -->
                                    <?php if(!empty($this->session->userdata('customer_id') && $this->session->userdata('vcode'))){?>

                                        <div class="dropdown" style="float: right;">
                                            <a href="#"><img src="<?php echo base_url(); ?>vendor_assets/profile_icon.png" style="width:50px;height:50px;"> <?php echo  $this->session->Userdata('username'); ?><i class="fa fa-chevron-down"></i>
                                                <div class="dropdown-content">
                                                    <!-- <ul class="sub-menu"> -->
                                                    <a href="<?php echo base_url('dashboard'); ?>">Dashboard</a>
                                                    <a href="<?php echo base_url('posted-list'); ?>">Truck Posted List</a>
                                                    <a href="<?php echo base_url('user-profile'); ?>">User Profile</a>
                                                    <a href="<?php echo base_url('logout'); ?>">Logout</a>
                                                    <!-- </ul> -->
                                                </div>
                                        </div>
                                        <style>
                                            .dropdown-content {
                                                display: none;
                                                position: absolute;
                                                background-color: #f9f9f9;
                                                min-width: 196px;
                                                box-shadow: 0px 8px 16px 0px rgb(0 0 0 / 20%);
                                                z-index: 1;
                                            }
                                        </style>
                                          
                                        <div class="dropdown" style="float: right;">
                                        <?php $date = date('Y-m-d'); ?>



                                            <?php
                                             $total_order = $this->db->query(" SELECT count(ftl_request_id) as total   FROM `ftl_request_tbl` WHERE request_date >= '$date' AND  status = '1'")->result_array(); 
                                             $customer_id = $this->session->userdata('customer_id');
                                             $order_request = $this->db->query("SELECT count(order_request_tabel.ftl_request_id) as total_quotation   FROM `order_request_tabel` LEFT JOIN ftl_request_tbl ON ftl_request_tbl.id = order_request_tabel.ftl_request_id  WHERE vendor_customer_id =' $customer_id' AND  request_status = '1'")->result_array(); 
                                             $total_request = $total_order[0]['total'] - $order_request[0]['total_quotation'];


                                             $Vehicle_capacity = $this->db->query("SELECT * FROM `ftl_request_tbl` WHERE id NOT IN(SELECT ftl_request_id FROM order_request_tabel WHERE vendor_customer_id =   $customer_id) AND status ='1' AND request_date >= '$date'")->result_array(); 
                                             $total_request = $this->db->query("SELECT  COUNT(ftl_request_id) as total FROM `ftl_request_tbl` WHERE id NOT IN(SELECT ftl_request_id FROM order_request_tabel WHERE vendor_customer_id =   $customer_id) AND status ='1' AND request_date >= '$date'")->result_array(); 
                                            //  print_r($total_request);
                                             ?>
                                           
                                            <span style="color: #ffff; padding: 5px;border-radius: 100%;background-color: #ee5a27;position: relative;left: 26px;top: -16px;"><?php echo $total_request[0]['total']; ?></span>
                                            <img src="<?php echo base_url(); ?>vendor_assets/notification_icon.png" style="width:50px;height:50px;margin-right: 25px;">
                                            <div class="dropdown-content">
                                                <?php if (!empty($Vehicle_capacity)) { ?>
                                                    <?php foreach ($Vehicle_capacity as $value) : ?>
                                                        <a href="<?php echo base_url('truck-order/'.$value['id']); ?>">Required Vehicle Capacity <?php echo $value['vehicle_capacity']; ?> </a>
                                                    <?php endforeach; ?>
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <?php }?>

                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="slide-up">
                        <div class="fluid-container clearfix bg-primary">
                            <div class="container">
                                <!-- Website Logo -->
                                <div class="logo-header mostion">
                                    <a href="index.html"><img src="<?php echo base_url(); ?>vendor_assets/images/logo-white.png" width="193" height="89" alt=""></a>
                                </div>
                                <!-- Nav Toggle Button -->
                                <button class="navbar-toggler collapsed navicon justify-content-end" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </button>
                                <!-- Extra Nav -->
                                <!-- <div class="extra-nav">
                            <div class="extra-cell">
                                <button id="quik-search-btn" type="button" class="site-button bg-primary-dark"><i class="fa fa-search"></i></button>
                            </div>
                        </div> -->
                                <!-- Quik Search -->
                                <!-- <div class="dez-quik-search bg-primary">
                            <form action="#">
                                <input name="search" value="" type="text" class="form-control" placeholder="Type to search">
                                <span  id="quik-search-remove"><i class="fa fa-remove"></i></span>
                            </form>
                        </div> -->
                                <!-- Main Nav -->
                                <div class="header-nav navbar-collapse collapse justify-content-start" id="navbarNavDropdown">
                                    <ul class="nav navbar-nav">
                                        <li class="active"> <a href="javascript:;">Home<i class="fa fa-chevron-down"></i></a></li>
                                        <li><a href="<?php echo base_url('truck-post');?>">Post Truck Location<i class="fa fa-chevron-down"></i></a></li>
                                        <li><a href="<?php echo base_url('vendor/quotation-request-list');?>">Quotation Requested list<i class="fa fa-chevron-down"></i></a></li>
                                        <li><a href="calculate-freight">Calculate Freight <i class="fa fa-chevron-down"></i></a></li>
                                        <li><a href="javascript:;">Buy & Sell<i class="fa fa-chevron-down"></i></a>
                                            <!-- <ul class="sub-menu">
												<li><a href="construct-home-style-1.html">Home 1</a></li>
												<li><a href="construct-home-style-2.html">Home 2</a></li>
												<li><a href="construct-home-style-3.html">Home 3</a></li>
												<li><a href="construct-home-style-4.html">Home 4</a></li>
											</ul> -->
                                        </li>
                                        <li> <a href="javascript:;">Truck Driver <i class="fa fa-chevron-down"></i></a>
                                            <!-- <ul class="sub-menu">
										<li><a href="contact.html">Contact us 1</a></li>
										<li><a href="contact-2.html">Contact us 2</a></li>
										<li><a href="contact-3.html">Contact us 3</a></li>
										<li><a href="contact-4.html">Contact us 4</a></li>
									</ul> -->
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main Header END -->
        </header>
        <!-- Header END -->>