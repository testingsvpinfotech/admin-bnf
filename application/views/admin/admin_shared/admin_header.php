<!DOCTYPE html>
<html>
    <!-- START: Head-->
    <head>
        <meta charset="UTF-8">
        <title>Admin</title>
		<base href="<?php echo base_url(); ?>">
        <link rel="shortcut icon" href="assets/admin_assets/dist/images/favicon.ico" />
        <meta name="viewport" content="width=device-width,initial-scale=1"> 
		
        <!-- START: Template CSS-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.min.css" integrity="sha512-IXuoq1aFd2wXs4NqGskwX2Vb+I8UJ+tGJEu/Dc0zwLNKeQ7CW3Sr6v0yU3z5OQWe3eScVIkER4J9L7byrgR/fA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        
        <link rel="stylesheet" href="<?= base_url();?>assets/admin_assets/dist/vendors/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?= base_url();?>assets/admin_assets/dist/vendors/jquery-ui/jquery-ui.min.css">
        <link rel="stylesheet" href="<?= base_url();?>assets/admin_assets/dist/vendors/jquery-ui/jquery-ui.theme.min.css">
        <link rel="stylesheet" href="<?= base_url();?>assets/admin_assets/dist/vendors/simple-line-icons/css/simple-line-icons.css">        
        <link rel="stylesheet" href="<?= base_url();?>assets/admin_assets/dist/vendors/flags-icon/css/flag-icon.min.css">         
        <!-- END Template CSS-->

        <!-- START: Page CSS-->
        <link rel="stylesheet"  href="<?= base_url();?>assets/admin_assets/dist/vendors/chartjs/Chart.min.css">
        <!-- END: Page CSS-->

        <!-- START: Page CSS-->   
        <link rel="stylesheet" href="<?= base_url();?>assets/admin_assets/dist/vendors/morris/morris.css"> 
        <link rel="stylesheet" href="<?= base_url();?>assets/admin_assets/dist/vendors/weather-icons/css/pe-icon-set-weather.min.css"> 
        <link rel="stylesheet" href="<?= base_url();?>assets/admin_assets/dist/vendors/chartjs/Chart.min.css"> 
        <link rel="stylesheet" href="<?= base_url();?>assets/admin_assets/dist/vendors/starrr/starrr.css"> 
        <link rel="stylesheet" href="<?= base_url();?>assets/admin_assets/dist/vendors/fontawesome/css/all.min.css">
        <link rel="stylesheet" href="<?= base_url();?>assets/admin_assets/dist/vendors/ionicons/css/ionicons.min.css"> 
        <link rel="stylesheet" href="<?= base_url();?>assets/admin_assets/dist/vendors/jquery-jvectormap/jquery-jvectormap-2.0.3.css">
        <!-- END: Page CSS-->

        <!-- START: Custom CSS-->
        <link rel="stylesheet" href="<?= base_url();?>assets/admin_assets/dist/css/main.css">
         <!-- <link rel="stylesheet" href="assets/plugins/bootstrap-select/bootstrap-select.min.css"> -->
         <link rel="stylesheet" href="<?=base_url();?>assets/multiselect/bootstrap-multiselect.css" type="text/css">
        <!-- END: Custom CSS-->

        <script src="assets/js/sweetalert2.all.min.js"></script>
          <script src="assets/js/customsweetalert.js"></script>
         <link rel="stylesheet" href="<?= base_url();?>assets/dist/vendors/datatable/css/dataTables.bootstrap4.min.css" />
        <link rel="stylesheet" href="<?= base_url();?>assets/dist/vendors/datatable/buttons/css/buttons.bootstrap4.min.css"/>

         <link  href="<?php echo base_url(); ?>assets/dist/css/select2.min.css" rel="stylesheet" />
         <script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js" integrity="sha512-JnjG+Wt53GspUQXQhc+c4j8SBERsgJAoHeehagKHlxQN+MtCCmFDghX9/AcbkkNRZptyZU4zC8utK59M5L45Iw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    </head>
    <!-- END Head-->
    <style>
        .sidebar .sidebar-menu {
    padding: 0px;
    padding-top: 10px;
    padding-bottom: 10px;
    list-style: none;
}
main {
    margin-top: 132px !important;
}
.modal {
    margin-top: 50px ! important;
}
.sidebar .sidebar-menu > li ul {
    list-style: none;
    padding: 0px;
    margin: 0px;
    margin-top: 0px;
}

.sidebar .sidebar-menu {
    padding-bottom: 2px;
}
    </style>
    <!-- It's inspect tool hide added by pritesh  -->
    