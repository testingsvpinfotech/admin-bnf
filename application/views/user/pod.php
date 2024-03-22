     <?php $this->load->view('user/admin_shared/admin_header'); ?>
    <!-- END Head-->

    <!-- START: Body-->
    <body id="main-container" class="default">
<style>
  .buttons-copy{display: none;}
  .buttons-csv{display: none;}
  /*.buttons-excel{display: none;}*/
  .buttons-pdf{display: none;}
  .buttons-print{display: none;}
  /*#example_filter{display: none;}*/
  .input-group{
    width: 60%!important;
  }
</style>
        
        <!-- END: Main Menu-->
    <?php $this->load->view('user/admin_shared/admin_sidebar');
   // include('admin_shared/admin_sidebar.php'); ?>
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
                              <h4 class="card-title">POD Search</h4>
                          </div>
                          <div class="card-content">
                                <div class="card-body">
								
                               <div class="row">
								<div class="form-group col-md-6">
									
									<div class="search-bx">
										<form role="search" method="post" action="<?php echo base_url()?>users/pod" enctype="multipart/form-data">
											<div class="input-group">
												<input name="pod_no" type="text" class="form-control" placeholder="Airway Number">
												
												<button type="submit" name="submit" class="btn btn-primary">Search</button>
                        <a href="<?= base_url('users/pod');?>" class="btn btn-info">Reset</a>
												
											</div>
										</form>
									</div>
								</div>
						</div>	
						<div class="row">
<br>
		    <?php 
				  if (!empty ($pod)){
					  ?>
			  <table border='1px'>
                <thead>
                <tr width="5%">
                   Airway Number :
				</tr>
                </thead>
				<tbody>
				<tr>
					<?=$info->pod_no?>  <?php
                    foreach ($pod as $value) {
                            ?>
                <!-- <td><?php// echo $value['image'];?></td>-->
                            <br><br>

                      <a href="assets/pod/<?php echo $value['image']; ?>" src="assets/pod/<?php echo $value['image']; ?>" title="<?php echo $row->pod_no; ?>" onclick="show_image(this);return false;" style="color:blue; margin-top:20px; margin-left:40px;">View Pod Image</a>

                          </tr>
                    <?php 
                      }
                   ?>
				</tr>
				</tbody>
			  </table>
              <table border='1px'>
                <thead class='thead'>
                <tr>
					
				</tr>
                </thead>
                <tbody>
                <tr>
                 
                </tbody>
              </table>
			  <?php
			    }
				?>
						</div>
					</div>
				</div>
				</div>
				
			</div>
                      </div>
                    </div> 

                </div>
               
    </main>
    <!-- END: Content-->
    <!-- START: Footer-->
    <?php $this->load->view('user/admin_shared/admin_footer');
     //include('admin_shared/admin_footer.php'); ?>
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

