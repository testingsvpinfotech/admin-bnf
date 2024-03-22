<?php $this->load->view('admin/admin_shared/admin_header'); ?>
     <!-- END Head-->

     <!-- START: Body-->

     <body id="main-container" class="default">


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
                     <h4 class="card-title">Other Branch Out Scan </h4>
                   </div>
                   <div class="card-body">
                     <div class="table-responsive">
                       <table id="example" class="display table dataTable table-striped table-bordered layout-primary" data-sorting="true">
                         <thead>
                           <tr>
                             <th>Sr.No.</th>
                             <th>AWB No.</th>
                             <th>Booking Date</th>
                             <th>Origin</th>
                             <th>Destination</th>
                             <th>Mode</th>
                             <th>Type Of Parcel</th>
                             <th>Action</th>
                           </tr>
                         </thead>
                         <tbody>

                           <?php
                            if (!empty($allpoddata)) {
                              $cnt = 1; //echo '<pre>'; print_r($allpoddata);
                              foreach ($allpoddata as $value) {
                                
                            ?>
                               <tr class="odd">
                                 <td><?php echo $cnt; ?></td>
                                 <td><?php echo $value['pod_no']; ?></td>
                                 <?php
                                 $whr = $value['pod_no'];
                                 $row = $this->db->query("SELECT * FROM tbl_domestic_booking WHERE pod_no = '$whr'")->row_array();
                                //  echo $this->db->last_query();die();
                                 ?>
                                 <td><?php echo date("d-m-Y", strtotime($row['booking_date'])); ?></td>
                                 <?php $whr = array('id'=>$row['sender_city']);
                                 $res=$this->basic_operation_m->getAll('city',$whr);
                                 $city = $res->row()->city; ?>
                                 <?php $whr = array('id'=>$row['reciever_city']);
                                 $res=$this->basic_operation_m->getAll('city',$whr);
                                 $reciever_city = $res->row()->city; ?>
                                 <?php $whr = array('transfer_mode_id'=>$row['mode_dispatch']);
                                 $res=$this->basic_operation_m->getAll('transfer_mode',$whr);
                                 $mode_name = $res->row()->mode_name; ?>
                                 <td><?php echo $city; ?></td>
                                 <td><?php echo $reciever_city; ?></td>
                                 <td><?php echo $mode_name; ?></td>
                                 <td><?php echo $row['type_shipment']; ?></td>
                                 <td><a href="admin/domestic_printpod/<?php echo $row['booking_id'];?>" target="_blank" title="Print"><i class="fas fa-print" style="color:var(--success)"></i></a></td>
                               
                               </tr>
                           <?php
                                $cnt++;
                              }
                            } else {
                              // echo "<p>No Data Found</p>";
                            }
                            ?>
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
        <script>
         $(document).ready(function(){
          var table = $('#custom').DataTable({
            "lengthMenu": [ [2, 4, 8, -1], [2, 4, 8, "All"] ],
            "pageLength": 50
          });
         });
          
        </script>
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