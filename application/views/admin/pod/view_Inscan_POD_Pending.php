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
                     <h4 class="card-title">Inscan POD Pending</h4>
                     <!-- <span style="float: left;"><a href="admin/add-bulk-pod" class="fa fa-plus btn btn-primary">Upload Bulk POD</a></span>
                     <span style="float: right;"><a href="admin/add-pod" class="fa fa-plus btn btn-primary">Add POD</a></span> -->
                   </div>
                   <div class="card-body">
                     <div class="table-responsive">
                       <table id="example" class="display table dataTable table-striped table-bordered layout-primary" data-sorting="true">
                       <!-- id="example"  -->
                       <thead>
                           <tr>
                             <th>Sr.No.</th>
                             <th>Booking Date</th>
                              <th>AWB No.</th>
                              <th>Origin</th>
                             <th>Destinstion</th>
                             <th>Customer Name</th>
                             <th>Consigner Name</th>
                             <th>Consignee Name</th>
                             <th>Delivery Date</th>
                             <th>Delivery Branch</th>
                             <!-- <th>POD Upload By</th>
                            
                             <th>View Pod</th> -->
                           
                           </tr>
                         </thead>
                         <tbody>

                           <?php //echo'<pre>'; print_r($pod);
                            if (!empty($pod)) {
                              $cnt = 1;
                              foreach ($pod as $row) {
                            ?>
                               <tr class="odd">
                               
                                  <?php 
                                      ini_set('display_errors', '0');
                                      ini_set('display_startup_errors', '0');
                                      error_reporting(E_ALL);
                                  //  $whr = array('pod_no'=>$row->pod_no);
                                  //   $res1=$this->basic_operation_m->getAll('tbl_domestic_booking',$whr);
                                  //  $whr = array('pod_no'=>$row->pod_no);
                                  //   $res2=$this->basic_operation_m->getAll('tbl_domestic_deliverysheet',$whr);
                                   // print_r($res2->row()->branch_id);
                                   $whr = array('branch_id'=>$row->branch_id);
                                    $res3=$this->basic_operation_m->getAll('tbl_branch',$whr);
                                    $whre = array('customer_id'=>$row->customer_id);
                                    $customer=$this->basic_operation_m->getAll('tbl_customers',$whre);
                                    // print_r($res3->row()->branch_name);die;
                                    $res = $this->db->query("select sender_city from tbl_domestic_booking where pod_no = '$row->pod_no'")->row_array();
                                    $recivery_city = $res['sender_city'];
                                    $whr = array('id'=>$recivery_city);
                                     $res=$this->basic_operation_m->getAll('city',$whr);
                                     $city1 = $res->row();
                                 
                                  ?>
                                  <td><?php echo $cnt; ?></td>
                                  <td><?php echo $row->booking_date; ?></td>
                                  <td><?php echo $row->pod_no; ?></td>
                                  <td><?php echo $city1->city; ?></td>
                                  <td><?php echo $res3->row()->branch_name; ?></td>
                                  <td><?php echo $customer->row()->customer_name; ?></td>
                                  <td><?php echo $row->sender_name; ?></td>
                                  <td><?php echo $row->reciever_name; ?></td>
                                  <td><?php echo $row->delivery_date; ?></td>
                                  <td><?php echo $res3->row()->branch_name; ?></td>
                                  <!-- <td><?php echo $row->deliveryboy_id; ?></td>                          
                                  <td><a href="assets/pod/<?php echo $row->image; ?>" src="assets/pod/<?php echo $row->image; ?>" title="<?php echo $row->pod_no; ?>" onclick="show_image(this);return false;">View Pod Image</a></td> -->
                               




















                                
                                 
                               </tr>
                           <?php
                                $cnt++;
                              }
                            } else {
                              echo "<p>No Data Found</p>";
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
     <script>
      function getPod123(getid) {
        // alert(id);
        var baseurl = '<?php echo base_url(); ?>'
			swal({
				title: 'Are you sure?',
				text: "You won't be able to revert this!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, delete it!',
			}).then((result) => {
				if (result.value) {
					$.ajax({
							url: baseurl + 'Admin_pod/pod_delete',
							type: 'POST',
							data: 'getid=' + getid,
							dataType: 'json'
						})
						.done(function(response) {
							swal('Deleted!', response.message, response.status)

								.then(function() {
									location.reload();
								})

						})
						.fail(function() {
							swal('Oops...', 'Something went wrong with ajax !', 'error');
						});
				}
      });
    }
	// $(document).ready(function() {
	// 	$('.deletepod').click(function() {
	// 		var getid = $(this).attr("relid");
	// 		alert(getid);
			

	// 		})

	// 	});

	// });
</script>
     <!-- END: Body-->