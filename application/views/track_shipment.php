<?php include 'shared/web_header.php'; ?>
     
<body class="home  header-v4 hide-topbar-mobile">
    <div id="page">

        <!-- Preloader-->
       

        <?php include 'shared/web_menu.php'; ?>
        <!-- masthead end -->

       
      
<div class="page-title">
        <div class="container">
            <div class="padding-tb-120px">
                <h1>TRACK SHIPMENT</h1>
                <ol class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li class="active">TRACK SHIPMENT</li>
                </ol>
            </div>
        </div>
    </div>


        <!--contact pagesec-->
        <section class="contactpagesec secpadd">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="fh-section-title clearfix f25 text-left version-dark paddbtm40">
                            <h2>Track Shipment</h2>
                        </div>
                        <p class="margbtm30">If you have any questions about what we offer for consumers or for business, you can always email us or call us via the below details. We’ll reply within 24 hours.</p>
                        <div class="row">
                             <div class="col-md-11">
                        <div class="search-bx col-md-6">
                            
                            
                            <form role="search" method="get" action="<?php echo base_url();?>users/track_shipment">
                                <div class="input-group">
                                        <input name="pod_no" type="text" class="form-control" placeholder="Airway no" value="<?php if(isset($_GET['pod_no'])){echo $_GET['pod_no'];}?>">
                                        <span class="input-group-btn">
                                            <button type="submit" name="submit" class="btn btn-primary">Search</button>
                                        </span> 
                                </div>
                                </form>
                                    
                

           </div>
           <br>
           <?php 
                        if (!empty ($pod))
                        {
                            ?>
                             <br>
                            <table id="example1" class="table table-bordered " style="padding:3px;">
                             <tr><th style="padding:3px;">&nbsp; AWB NO.</th><td style="padding:3px;"><?=$info->pod_no?></td></tr>  
                             <tr><th style="padding:3px;">&nbsp; Consigner Name</th><td style="padding:3px;"><?php echo $info->sender_name; ?></td></tr>  
                              <tr><th style="padding:3px;">&nbsp; Consignee Name</th><td style="padding:3px;"><?php echo $info->reciever_name; ?></td></tr> 
                             <tr><th style="padding:3px;">&nbsp; Origin</th><td style="padding:3px;"><?php echo $info->sender_city_name; ?></td></tr> 
                             <tr><th style="padding:3px;">&nbsp; Destination</th><td style="padding:3px;"><?php echo $info->reciever_country_name; ?></td></tr>
                             <tr><th style="padding:3px;">&nbsp; Destination Service</th><td style="padding:3px;"><?php 
                             $pinocde = $this->db->query("select * from pincode where pin_code = '$info->reciever_pincode'")->row();
                             if(!empty($pinocde->isODA) && $pinocde->isODA !=0){ echo service_type[$pinocde->isODA];} ?></td> </tr>
						
                             <tr><th style="padding:3px;">&nbsp; Booking Date</th><td style="padding:3px;"><?php echo date('d/m/Y', strtotime($info->booking_date)); ?></td></tr>
                             <?php $branch_id = $info->branch_id  ;?>
                             <tr><th style="padding:3px;">&nbsp; Booking Branch </th><td style="padding:3px;"><?php $branch = $this->db->query("select * from tbl_domestic_tracking WHERE pod_no='$info->pod_no'order by id asc limit 1")->row();  echo $branch->branch_name; ?></td></tr>  
                             <!-- <tr><th style="padding:3&nbsp; px;">Booking Branch </th><td style="padding:3px;"><?php $branch = $this->db->query("select branch_name from tbl_branch where branch_id = '$branch_id'")->row(); echo $branch->branch_name; ?></td></tr>   -->
                             <!-- <th style="padding:3px;"&nbsp; >EDD</th><td style="padding:3px;"><?php  // echo date('d/m/Y', strtotime($info->delivery_date)); ?></td> -->
                             <tr><th style="padding:3px;">&nbsp; Status</th><td style="padding:3px;">
                                 <?php
								  
                    $status = $this->db->query("select * from tbl_domestic_tracking WHERE pod_no='$info->pod_no'order by id desc limit 1")->row(); 
                                             
                     if($status->status == 'In transit'){
                      echo $status->status.' To '.$status->branch_name;
                     }else{
                      echo $status->status;
                     }

							 ?>
                             </td></tr> 
                             <tr><th style="padding:3px;">&nbsp; Delivery Date & Time</th><td style="padding:3px;"> 
                             <?php 
                                if(isset($delivery_date))
        					   	{
        							echo date('d/m/Y',strtotime($delivery_date));
        						} ?>
        						</td></tr> 
                           
                              
					</tr>
				</table>
				<br>
				<div class="poddata">
					<div>
					<?php
						/* print_r($delivery_pod);
						print_r($podimg); */
						
						if(isset($delivery_pod[0]))
						{
					?>
					<center>
					<a href="javascript:void(0);" target="_blank" style="font-size: 20px;"><img id="myImg" src="<?php echo $delivery_pod[0]; ?>" alt="Snow" style="width:100%;max-width:300px"></a>
					

<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- The Close Button -->
  <span class="close">&times;</span>

  <!-- Modal Content (The Image) -->
  <img class="modal-content" id="img01">

  <!-- Modal Caption (Image Text) -->
  <div id="caption"></div>
</div>
					</center>
					<?php	
						}
					?>
					</div>
				</div>	

				<table><tr><td>
         
<center><b>Shipment Progress History</b></center></td></tr>
</table>
              <?php if(!empty($podimg)){ 
                  $ext = explode('.',$podimg->image);
                ?>
                        <table class="table  table-bordered">
                          <tr><td colspan="4" style="text-align:center;"><b>Pod Details</b></td></tr>
                          <tr>
                            <th>Uploaded Date</th>
                            <th>Uploaded Time</th>
                            <th>Branch Name</th>
                            <th>View Pod</th>
                          </tr>
                          <tr>
                            <td><?= date('d-m-Y', strtotime($podimg->booking_date)); ?></td>
                            <td><?= date('h:i A', strtotime($podimg->booking_date)); ?></td>
                            <td>
                            <?php
                               $branch = $this->db->query("select * from tbl_users where username = '$podimg->deliveryboy_id'")->row('branch_id');
                               echo $this->db->query("select * from tbl_branch where branch_id = '$branch'")->row('branch_name');
                            ?>

                            </td>
                            <td><?php if($ext[1] =='pdf'){?>
                                  <a href="<?= base_url('users/pod_download/'.$podimg->image);?>"><i class="fa fa-link" aria-hidden="true"> View Pod</i></a>
                                <?php }else{?>
                                  <img id="myImg" src="<?php echo base_url(); ?>assets/pod/<?php echo $podimg->image; ?>" alt="Snow" style="width:100%;max-width:100px">
                                <?php }?>
                            </td>
                          </tr>
                        </table>
                      <?php } ?>
                    <table class="table  table-bordered">
                        <thead>
                          <tr>
                             <th> Date</th>
                             <th>Time</th>
				            <th>Location</th>
                            <th>Comment</th>
                   <th>Status Description </th>
                            
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                      <?php 
                      if(empty($delhivery_data)) {
						  
						  
                      foreach ($pod as  $value) 
                      {
                        if (isset($value->city_name)) {
                          $value->branch_name = $value->city_name;
                        }
                      ?>
                        <td><?php echo date('d-m-Y', strtotime($value->tracking_date)); ?></td>
                        <td><?php echo date('h:i A', strtotime($value->tracking_date)); ?></td>
                        <td>
                            <?php
                        
                        if (!$value->comment) {
                            $value->comment = "";
                        }
                        if ($value->status=='In transit')
                        {
                            echo  $value->added_branch;
                            // echo " ".str_replace("B4 EXPRESS-","",$value->branch_name);
                        }else if($value->forworder_name=='DHL'){ 
                            echo $value->status; 
                        }else{
                            echo str_replace("B4 EXPRESS-","",$value->branch_name);
                        } ?></td>  

                        <td><?php echo $value->comment;?></td>
                        <td>
                        
                         <?php
						
						if ($value->status=='In transit')
						{
							echo "In transit To ".$value->comment;
							 //echo "<br>";
								echo " ".str_replace("B4 EXPRESS-","",$value->branch_name);
						}
						elseif ($value->status=='forworded')
						{
							echo "In transit To ".$value->comment;
							 //echo "<br>";
								 echo " ".str_replace("B4 EXPRESS-","",$value->branch_name);
						}
						elseif ($value->status=='recieved')
						{
							echo "Recieved In";
							// echo "<br>";
							echo " ".str_replace("B4 EXPRESS-","",$value->branch_name);
						}
						elseif ($value->status=='booked')
						{
								echo "Booking At ".$value->comment;
								// echo "<br>";
								echo " ".str_replace("B4 EXPRESS-","",$value->branch_name);
						}
						elseif ($value->status=='Delivered' || $value->status=='DELIVERED')
						{
							echo "Delivered ".$value->comment;
							 //echo "<br>";
							 if(!empty($podimg)){ 
                $ext = explode('.',$podimg->image);
                ?>
							
					
					
<div id="myModal" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="img01">
  <div id="caption"></div>
</div>

							 <?php  }
						}
						else
						{
						    
						     if($value->forworder_name=='Aramex'){ 
                                //echo '<b>'.ucfirst($value->status).' </b> &nbsp;:&nbsp; '.$value->comment;
                                echo ucfirst($value->status);
						     }
						     elseif($value->forworder_name=='DHL'){ 
                                //echo '<b>'.ucfirst($value->status).' </b> &nbsp;:&nbsp; '.$value->comment;
                                echo ucfirst($value->comment);
						     }else
						     {
                                echo $value->status;
						     }
                            
						}
				  ?>
                        </td>
                        
                          
                      
                    </tr>
                    <?php
                }
                } else { 
                    foreach($delhivery_data as $delhivery) {
                     $trackingData = json_decode($delhivery->details);
                    ?>
                       <tr>
                        <td><?=$trackingData->timestamp?></td>
                        <td><?= 'Status:-'. $trackingData->status.',' ?> <?= 'Location:-'. $trackingData->location.',' ?> <?= 'Remark:-'. $trackingData->scan_remark;?></td>
                        </tr>
                    <?php }
                    
                }
                ?>
                
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
        </section>
        <!--contact end-->

        <!--google map end-->
 <style>
 /* Style the Image Used to Trigger the Modal */
#myImg {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

#myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed;
    z-index: 99999;
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (Image) */
.modal-content {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
}

/* Caption of Modal Image (Image Text) - Same Width as the Image */
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

/* Add Animation - Zoom in the Modal */
.modal-content, #caption {
  animation-name: zoom;
  animation-duration: 0.6s;
}

@keyframes zoom {
  from {transform:scale(0)}
  to {transform:scale(1)}
}

/* The Close Button */
.close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .modal-content {
    width: 100%;
  }
}
 </style>       


<script>

   // Get the modal
var modal = document.getElementById("myModal");

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById("myImg");
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
img.onclick = function(){
  modal.style.display = "block";
  modalImg.src = this.src;
  captionText.innerHTML = this.alt;
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

</script>        

<?php include 'shared/web_footer.php'; ?>