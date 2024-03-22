<?php $this->load->view('admin/admin_shared/admin_header'); ?>
<!-- END Head-->

<!-- START: Body-->

<body id="main-container" class="default">

<style>
    .btn1{padding:8px;background-color:#fff;}
    .table.layout-primary tbody td:last-child i {
    color: rgb(0 0 0 / 160%) !important;
    font-size: 0.875rem;
    padding: 0.25rem 0.5rem;
}
</style>

  <!-- END: Main Menu-->
  <?php $this->load->view('admin/admin_shared/admin_sidebar');
  // include('admin_shared/admin_sidebar.php'); 
  ?>
  <!-- END: Main Menu-->

  <!-- START: Main Content-->
  <main>
    <div class="container-fluid site-width">
      <!-- START: Listing-->
      <div class="row">
        <div class="col-12  align-self-center">
          <div class="col-12 col-sm-12 mt-3">
            <div class="card">
              <div class="card-header justify-content-between align-items-center">

                <span style="float: right;"><a href="<?php echo base_url('admin/add_route');?>" class="fa fa-plus btn btn-primary">Add Route</a></span>
              </div>
              <div class="card-body">
              <?php if (!empty($this->session->flashdata('msg'))) {?>
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert">X</button>
                    <?php echo $this->session->flashdata('msg'); ?>
                </div>
              <?php } ?>
                <div class="table-responsive">
                  <table class="display table dataTable table-striped table-bordered layout-primary" data-sorting="true">
                    <thead>
                      <tr>
                        <th>Sr.No.</th>
                        <th>Route Name</th>
                        <!-- <th>City List</th> -->
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                 
                      <?php

                    
                      if (!empty($route_list)) {
                        $i = 1;
                        foreach ($route_list as $row) { ?>
                      
                          <tr class="odd">
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $row->route_name; ?></td>
                           
                            <td>
                               <a href="#" class="btn1" style=" color: red ;"><i class="fa fa-eye" aria-hidden="true"></i></a>
                               <a href="<?= base_url('admin/find_route/'.$row->id);?>" class="btn1" style=" color: #07b143;"><i class="fa fa-edit" style="font-size:20px"></i></a>
                               <a href="<?= base_url('admin/delete_route/'.$row->id);?>" class="btn1" style=" color: #fc960f;"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </td>
                          </tr>
                      <?php
                          $cnt++;
                        }
                      } else {
                        echo "<p>No Data Found</p>";
                      }  ?>
                     
                    </tbody>
                  </table>
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
  //include('admin_shared/admin_footer.php'); 
  ?>
  <!-- START: Footer-->

  <div id="myModal" class="modal">
    <span class="close-image-modal">&times;</span>
    <img class="modal-content" id="img01">
    <div id="caption"></div>
  </div>
  <style type="text/css">
    /* The Modal (background) */
    .modal {
      display: none;
      /* Hidden by default */
      position: fixed;
      /* Stay in place */
      z-index: 1;
      /* Sit on top */
      padding-top: 100px;
      /* Location of the box */
      left: 0;
      top: 0;
      width: 100%;
      /* Full width */
      height: 100%;
      /* Full height */
      overflow: auto;
      /* Enable scroll if needed */
      background-color: rgb(0, 0, 0);
      /* Fallback color */
      background-color: rgba(0, 0, 0, 0.9);
      /* Black w/ opacity */
    }

    /* Modal Content (image) */
    .modal-content {
      margin: auto;
      display: block;
      width: 50%;
      max-width: 700px;
    }

    /* Caption of Modal Image */
    #caption {
      margin: auto;
      display: block;
      width: 80%;
      max-width: 700px;
      text-align: center;
      color: #ccc;
      padding: 10px 0;
      height: 150px;
    }

    /* Add Animation */
    .modal-content,
    #caption {
      -webkit-animation-name: zoom;
      -webkit-animation-duration: 0.6s;
      animation-name: zoom;
      animation-duration: 0.6s;
    }

    @-webkit-keyframes zoom {
      from {
        -webkit-transform: scale(0)
      }

      to {
        -webkit-transform: scale(1)
      }
    }

    @keyframes zoom {
      from {
        transform: scale(0)
      }

      to {
        transform: scale(1)
      }
    }

    /* The Close Button */
    .close-image-modal {
      position: absolute;
      /*top: 15px;*/
      right: 35px;
      color: #f1f1f1;
      font-size: 40px;
      font-weight: bold;
      transition: 0.3s;
    }

    .close-image-modal:hover,
    .close-image-modal:focus {
      color: #bbb;
      text-decoration: none;
      cursor: pointer;
    }

    /* 100% Image Width on Smaller Screens */
    @media only screen and (max-width: 700px) {
      .modal-content {
        width: 100%;
      }
    }
  </style>
</body>

<script>
  // Get the modal
  var modal = document.getElementById("myModal");

  function show_image(obj) {
    var captionText = document.getElementById("caption");
    var modalImg = document.getElementById("img01");
    modal.style.display = "block";
    // alert(obj.tagName);
    if (obj.tagName == 'A') {
      modalImg.src = obj.href;
      captionText.innerHTML = obj.title;
    }
    if (obj.tagName == 'img') {
      modalImg.src = obj.src;
      captionText.innerHTML = obj.alt;
    }

    // modalImg.src = 'http://www.safedart.in/assets/pod/pod_1.jpg';

  }
  var span = document.getElementsByClassName("close-image-modal")[0];

  // When the user clicks on <span> (x), close the modal
  span.onclick = function() {
    modal.style.display = "none";
  }


  // Get the image and insert it inside the modal - use its "alt" text as a caption




  // Get the <span> element that closes the modal
</script>
<!-- END: Body-->