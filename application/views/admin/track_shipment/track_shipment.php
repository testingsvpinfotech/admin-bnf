<?php 
// echo "<pre>";
// print_r($weight_details);exit();

?>
<?php include(dirname(__FILE__).'/../admin_shared/admin_header.php'); ?>
    <!-- END Head-->

    <!-- START: Body-->
    <body id="main-container" class="default">

        
        <!-- END: Main Menu-->
   
    <?php include(dirname(__FILE__).'/../admin_shared/admin_sidebar.php'); ?>
        <!-- END: Main Menu-->


        <!-- START: Main Content-->
        <main>

          <br>
          <br>
          <br>
          <br>
         
          <br>
            <div class="container-fluid site-width">

              <div class="row">

                <div class="col-3">
                  <form action="" method="post">
                    AWB No. <input type="text" name="pod_no" value="<?php echo @$_GET['pod_no'];?>"> <input type="submit" name="submit" value="Go" ><br>
                    Booking Branch. <?php echo @$info->pod_no;?><br><br>
                    Booking Date. <?php echo @$info->booking_date;?><br><br>
                    Shipper. <?php echo @$info->sender_name;?><br><br>
                    Consignee. <?php echo @$info->reciever_name;?><br><br>
                    Forwarder Name. <?php echo @$info->forworder_name;?><br><br>
                    Last Status. <?php echo @$info->pod_no;?><br><br>
                  </form>
                   
                </div> 

                <div class="col-3">
              
                  Issue Date. <?php echo @$info->pod_no;?><br><br>
                  Pincode. <?php echo @$info->pod_no;?><br><br>
                  Act. Weight. <?php echo @$weight_details[0]->actual_weight;?><br><br>
                  Pieces. <?php echo @$weight_details[0]->no_of_pack;?><br><br>
                  Product. <?php echo @$info->pod_no;?><br><br>
                  Bill No. <?php echo @$info->pod_no;?><br><br>
                  
                  Forwader Number. <?php echo @$info->forwording_no;?><br><br>
                  Status Date. <?php echo @$info->pod_no;?><br><br>
                </div>

                <div class="col-3">
                     CHG. Weight. <?php echo @$weight_details[0]->chargable_weight_detail;?><br><br>
                     Goods Value. <?php echo @$info->pod_no;?><br><br>
                     Mode. <?php echo @$info->mode_name;?><br><br>
                     Volume. Weight. <?php echo @$weight_details[0]->actual_weight;?><br><br>
                     
                     Risk Amt. <?php echo @$info->pod_no;?><br><br>
                     Bill Date. <?php echo @$info->pod_no;?><br><br>
                </div>
                
              </div>


              <div class="row">
                <div class="col-12">

                  <table class="table table-striped">
                    <tr>
                      <th>Sr No.</th>
                      <th>Activity </th>
                      <th>Activity Date</th>
                      <th>Office name</th>
                      <th>Description</th>
                      <!-- <th>Entry Date</th> -->
                      <th>Entry Details</th>
                    </tr>

                    <?php
                      if (!empty($pod)) {
                        foreach ($pod as $key => $value) {

                          $status = '';
                          if ($value->status=='shifted')
                          {
                            $status = "Forworded From ".$value->comment;
                            //$status = "<br>";
                            $status = " ".str_replace("B4 EXPRESS-","",$value->branch_name);
                          }elseif ($value->status=='forworded')
                          {
                            $status = "In transit To ".$value->comment;
                            //$status = "<br>";
                            $status = " ".str_replace("B4 EXPRESS-","",$value->branch_name);
                          }elseif ($value->status=='recieved')
                          {
                            $status = "Recieved In";
                            // $status = "<br>";
                            $status = " ".str_replace("B4 EXPRESS-","",$value->branch_name);
                          }elseif ($value->status=='booked')
                          {
                              $status = "Booking At ".$value->comment;
                              // $status = "<br>";
                              $status = " ".str_replace("B4 EXPRESS-","",$value->branch_name);
                          }elseif ($value->status=='Delivered' || $value->status=='DELIVERED')
                          {
                            $status = "Delivered ".$value->comment;
                            //echo "<br>";
                            if(!empty($podimg))
                            {}
                          }



                          echo "<tr>";
                          echo "  <td>".($key+1)."</td>";
                          echo "  <td>".$status."</td>";
                          echo "  <td>".date('d/m/Y  H:i', strtotime($value->tracking_date))."</td>";
                          echo "  <td>".($value->forworder_name=='DHL') ? $value->status : str_replace("B4 EXPRESS-","",$value->branch_name)."</td>";

                          
                          echo "  <td>".$value->branch_name."</td>";
                          echo "  <td></td>";
                          echo "  <td>--</td>";
                          echo "</tr>";
                        }
                      }else{
                        echo "<tr>";
                        echo "  <td colspan='7'>No Activity Found!</td>";
                        echo "</tr>";
                      }
                    ?>
                  </table>
                  
                </div>
              </div>
                
              
        </main>
        <!-- END: Content-->
        <!-- START: Footer-->
        
        <?php  include(dirname(__FILE__).'/../admin_shared/admin_footer.php'); ?>
        <!-- START: Footer-->
    </body>
    <!-- END: Body-->
</html>
