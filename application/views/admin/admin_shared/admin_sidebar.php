<!-- START: Pre Loader
        <div class="se-pre-con">
            <div class="loader"></div>
        </div>
        START: Header-->
<style>
    .sidebar .sidebar-menu>li ul li:hover>.sub-menu {
        max-height: 200px;
        opacity: 1;
        display: block;
        overflow-y: scroll;
    }

    .dot {
        font-size: 8px;
        color: red;
        margin: 0px;
        padding: 0px;
        top: -5px;
        left: -4px;
        position: relative;
    }
</style>
<div id="header-fix" class="header fixed-top ">
    <div class="site-width">
        <nav class="navbar navbar-expand-lg  p-0">
            <div class="navbar-header  h-100 h4 mb-0 align-self-center logo-bar text-left">
                <a href="javascript:void(0);" class="horizontal-logo text-left">
                    <?php $company_details = $this->basic_operation_m->get_table_row('tbl_company', array('id' => 1)); ?>
                    <img src="assets/company/<?php echo $company_details->logo; ?>" class="portfolioImage img-fluid">
                </a>
            </div>


            <div class="navbar-right">
                <!-- START: Main Menu-->
                <div class="sidebar">
                    <div class="site-width">

                        <!-- START: Menu-->
                        <ul id="side-menu" class="sidebar-menu">
                            <?php $user_type = $this->session->userdata("userType");
                            if ($user_type == '1') { ?>
                                <form role="form" action="<?php echo base_url(); ?>admin/view-internal-status" method="post"
                                    autocomplete="off" style="margin-left: 15px; margin-right: 15px; float:left;">
                                    <!--     <form action = "https://boxnfreight.in/admin/view-internal-status" method="post" autocomplete="off" style="margin-left: 15px;"> -->
                                    <label>POD</label>

                                    <input type="text" name="filter_value" placeholder="Search LR Here..">
                                    <input type="submit" name="submit" value="Search">
                                </form>
                                <form role="form" action="<?php echo base_url(); ?>admin/pincode-service-status" method="post"
                                    autocomplete="off" style="margin-left: 15px !important;">
                                    <input type="text" name="filter_value" placeholder="Pincode Service..">
                                    <input type="submit" name="submit"  value="Search">
                                </form>
                               
                            <?php
                            }
                            $userType = $this->session->userdata("userType");
                            $userId = $this->session->userdata("userId");
                            $branch_id = $this->session->userdata("branch_id");

                            $currentURL = current_url();
                            $menu_url = str_replace(base_url(), "", $currentURL);

                            $check_menu_rights = $this->basic_operation_m->get_query_result("select * from menu_allotment left join all_menu on all_menu.am_id = menu_allotment.am_id where menu_status = 1 AND menu_allotment.user_id = '$userId' AND menu_url='$menu_url' order by menu_seq,menu_sub_seq asc");
                            // print_r($_SESSION);  echo $this->db->last_query();die;
                            
                            if (empty($check_menu_rights)) {
                                // echo "<script>alert('this menu Not assigned to you!.');window.location.replace('".base_url('admin')."');</script>";exit();
                            }

                            $company_details = $this->basic_operation_m->get_query_result("select * from menu_allotment left join all_menu on all_menu.am_id = menu_allotment.am_id where menu_status = 1 AND menu_allotment.user_id = '$userId' order by menu_seq,menu_sub_seq asc");
                            // 
                            

                            // if (1) {
                            // 	// code...
                            // }
                            
                            ?>
                            <li class="dropdown  active">
                                <ul>
                                    <?php
                                    $close_status = false;
                                    $menu_name = 'Dashboard';
                                    foreach ($company_details as $key => $values) {

                                        if ($user_type == '1') {
                                            $get_close_prq = $this->db->query("select count(pickup_status) as total from tbl_pickup_request_data where pickup_status != '1'")->row_array();
                                        } else {
                                            $get_close_prq = $this->db->query("select count(pickup_status) as total from tbl_pickup_request_data where pickup_status != '1' AND branch_id = ' $branch_id'")->row_array();
                                        }
                                        //print_r($get_close_prq['total']);
                                        if ($menu_name != $values->menu_name) {
                                            if ($close_status == true) {
                                                echo '</ul>';
                                                echo '</ll>';
                                            }
                                            if ($get_close_prq['total'] != '0') {
                                                if ($values->menu_name == 'PRQ') {
                                                    echo '<li class="dropdown"><a href="#" style="margin: 0px;padding:0px;">' . $values->menu_name . '<i class="fa fa-circle dot"></i></a>';
                                                    echo '<ul class="sub-menu">';
                                                    $close_status = true;
                                                    ;
                                                } else {
                                                    echo '<li class="dropdown"><a href="#">' . $values->menu_name . '</a>';
                                                    echo '<ul class="sub-menu">';
                                                    $close_status = true;
                                                }
                                            } else {
                                                echo '<li class="dropdown"><a href="#">' . $values->menu_name . '</a>';
                                                echo '<ul class="sub-menu">';
                                                $close_status = true;

                                            }

                                        }

                                        $menu_name = $values->menu_name;
                                        if ($values->menu_name == 'Dashboard') {
                                            echo '<li class="active"><a href="' . $values->menu_url . '">' . $values->menu_title . '</a></li>';
                                        } elseif ($values->menu_subtitle == 'Pickup Request List') {
                                            $hello = $get_close_prq['total'];
                                            echo '<li class="active"><a href="' . $values->menu_url . '">' . $values->menu_title . '<b style="color:red;padding-left:1px;"> (' . $hello . ')</b></a></li>';
                                            //echo 'hello';
                                    
                                        } else {
                                            echo '<li><a href="' . $values->menu_url . '">' . $values->menu_title . '</a></li>';
                                        }
                                        // echo '<li><a href="'.base_url('admin_domestic_shipment_manager/track_shipment').'">Track Shipment</a></li>';
                                    

                                    } ?>

                                </ul>
                            </li>

                        </ul>
                    </div>
                </div>
                <!-- END: Main Menu-->

                <ul id="top-menu" class="top-menu">

                    <li class="dropdown user-profile align-self-center d-inline-block">
                        <a href="#" class="nav-link py-0" data-toggle="dropdown" aria-expanded="false">
                            <div class="media">
                                <img src="assets/image/avtar.png" alt=""
                                    title="<?php echo $this->session->userdata('userName'); ?>"
                                    class="d-flex img-fluid rounded-circle" width="29">
                            </div>
                        </a>
                        <center><b>
                                <?php echo $this->session->userdata('userName'); ?>
                            </b></center>
                        <div class="dropdown-menu border dropdown-menu-right p-0">
                            <!-- <script> document.addEventListener('contextmenu', function(e) {e.preventDefault();}); </script> -->

                            <a href="admin/edit-user/<?php echo $this->session->userdata("userId"); ?>"
                                class="dropdown-item px-2 align-self-center d-flex">
                                <span class="icon-pencil mr-2 h6 mb-0"></span> Edit Profile</a>
                            <a href="admin_logout" class="dropdown-item px-2 text-danger align-self-center d-flex">
                                <span class="icon-logout mr-2 h6  mb-0"></span> Sign Out</a>
                        </div>

                    </li>

                </ul>
                <div>
                    <?php
                    $username = $this->session->userdata("userName");
                    $whr = array('username' => $username);
                    $res = $this->basic_operation_m->getAll('tbl_users', $whr);
                    $branch_id = $res->row()->branch_id;
                    $whr = array('branch_id' => $branch_id);
                    $res = $this->basic_operation_m->getAll('tbl_branch', $whr);
                    $branch_name = $res->row()->branch_name; ?>
                    <h6><b>Branch
                            <?php echo $branch_name; ?>
                        </b></h6>
                </div>
            </div>
        </nav>
        <?php $alert = $this->db->query("select * from tbl_news where  status = '1' order by id desc limit 1")->row();
        if (!empty($alert)) { ?>
            <b>
                <marquee style="color:red;">
                    <?= $alert->news_details; ?>
                </marquee>
            </b>
        <?php } ?>
    </div>
    <!-- Search Pincode -->
    <div class="modal fade" id="pincodeModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Check Servicable Pincode
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="icon-close"></i>
                    </button>
                </div>
                <form action="<?= base_url() . 'franchise/pincode-track'; ?>" method="GET">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="contact-occupation">
                                    <label for="contact-occupation" class="col-form-label">Enter Pincode</label>
                                    <input type="text" name="pincode" placeholder="Enter Pincode" class="form-control"
                                        maxlenth="6" minlength="6" required>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="filter" class="btn btn-primary add-todo">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- <p style ="background:red;"> hello</p> -->
</div>
<!-- END: Header-->