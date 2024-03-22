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

                <span style="float: right;">
                <a href="<?php echo base_url('admin/add-modewise-pincode');?>" class="fa fa-plus btn btn-primary">Add Pincode</a>
                <a href="<?php echo base_url('admin/view-upload-modewise-pincode');?>" class="fa fa-plus btn btn-success">Upload Bulk Pincode</a>
              </span>
              </div>
              <div class="card-body">
              <?php if ($this->session->flashdata('notify') != '') {?>
  <div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
  <?php unset($_SESSION['class']);unset($_SESSION['notify']);}?>
                <div class="table-responsive">
                  <table class="display table dataTable table-striped table-bordered layout-primary" data-sorting="true">
                    <thead>
                      <tr>
                        <th>Sr.No.</th>
                        <th>Mode Name</th>
                        <th>Pincode</th>
                        <th>Type</th>
                        <th>Date Time</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                 
                      <?php

                    
                      if (!empty($pincode)) {
                        $i = 1;
                        foreach ($pincode as $row) { ?>
                      
                          <tr class="odd">
                            <td><?php echo $i++; ?></td>
                            <td><?php
                            $val = $this->db->query("select mode_name from transfer_mode where transfer_mode_id = '$row->mode'")->row();
                            echo $val->mode_name;
                            ?></td>
                            <td><?php echo $row->pincode; ?></td>
                            <td><?php echo $row->regularoda; ?></td>
                            <td><?php echo $row->date_time; ?></td>                           
                            <td>
                               <a href="<?= base_url('admin/edit-modewise-pincode/'.$row->id);?>" ><i class="fa fa-edit" style="font-size:15px; color:#fff ! important;"></i></a>
                               <a href="javascript:void(0)" title="Delete" class="deletedata" relid="<?php echo $row->id;?>"><i class="ion-trash-b" style="color:var(--danger);color:#fff ! important;"></i></a>
                               <!-- <a href="<?= base_url('admin/delete_route/'.$row->id);?>" ><i class="fa fa-trash" style="font-size:15px; color:#fff ! important;" aria-hidden="true"></i></a> -->
                            </td>
                          </tr>
                      <?php
                         
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $(document).ready(function() {
      $('.deletedata').click(function(){
        var getid = $(this).attr("relid");
      // alert(getid);
       var baseurl = '<?php echo base_url();?>'
       	swal({
		  	title: 'Are you sure?',
		  	text: "You won't be able to revert this!",
		  	icon: 'warning',
		  	showCancelButton: true,
		  	confirmButtonColor: '#3085d6',
		  	cancelButtonColor: '#d33',
		  	confirmButtonText: 'Yes, delete it!',
		}).then((result) => {
		  	if (result.value){
		  		$.ajax({
			   		url: baseurl+'Admin_modewise_pincode_manager/delete_pincode',
			    	type: 'POST',
			       	data: 'getid='+getid,
			       	dataType: 'json'
			    })
			     .done(function(response){
			     	swal('Deleted!', response.message, response.status)
			     	 
                   .then(function(){ 
                    location.reload();
                   })
			     
			    })
			    .fail(function(){
			     	swal('Oops...', 'Something went wrong with ajax !', 'error');
			    });
		  	}
 
		})
 
	});
       
 });
</script>
<!-- END: Body-->