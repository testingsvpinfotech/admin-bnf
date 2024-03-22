<?php $this->load->view('admin/admin_shared/admin_header'); ?>
<!-- END Head-->
<style>
  .buttons-copy {
    display: none;
  }

  .buttons-csv {
    display: none;
  }

  /*.buttons-excel{display: none;}*/
  .buttons-pdf {
    display: none;
  }

  .buttons-print {
    display: none;
  }

  /*#example_filter{display: none;}*/
  .input-group {
    width: 60% !important;
  }

  .form-control {
    color: black !important;
    border: 1px solid var(--sidebarcolor) !important;
    height: 27px;
    font-size: 10px;
  }


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
    background-color: rgb(0, 0, 0) !important;
    /* Fallback color */
    background-color: rgba(0, 0, 0, 0.4) !important;
    /* Black w/ opacity */
  }

  /* Modal Content */
  .modal-content {
    position: absolute;
    top: 25% !important;
    left: 27% !important;
    background-color: #fefefe;
    margin: auto;
    padding: 20px 40px;
    border: 1px solid #888;
    width: 50%;
  }

  /* The Close Button */
  .close {
    color: #aaaaaa;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer !important;
    position: relative;
    right: 0 !important;
  }


  .close:hover,
  .close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
  }
</style>

<!-- START: Body-->

<body id="main-container" class="default">


  <!-- END: Main Menu-->

  <?php include(dirname(__FILE__) . '/../admin_shared/admin_sidebar.php'); ?>
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
                <h4 class="card-title">Petty Cash Report</h4>

                </span>
              </div>

              <div class="card-header justify-content-between align-items-center">
                <span>
                 
                  
                </span>
              </div>
              <div class="card-body">

                <div class="table-responsive">
                  <table class="display table dataTable table-striped table-bordered layout-primary" data-sorting="true">
                    <thead>
                      <tr>
                        <!-- <th scope="col"><input type="checkbox" onchange="checkAll(this)" name="chk[]" /> </th> -->
                        <th scope="col">SR No.</th>
                        <th scope="col">Booking Date</th>
                        <th scope="col">AWB</th>
                        <th scope="col">Origin</th>
                        <th scope="col">Destination</th>
                        <th scope="col">Sender Name</th>
                        <th scope="col">Contact No</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                 
                    <?php  if($show_data){
                      $i= 1;
                       foreach( $show_data as $value ){?>
                      <tr>
                        <!-- <td></td> -->
                        <td><?= $i++;?></td>
                        <td><?= $value['booking_date']; ?></td>
                        <td><?= $value['pod_no']; ?></td>
                        <td><?php $whr_u =array('id'=>$value['sender_city']);$user_details = $this->basic_operation_m->get_table_row('city', $whr_u);echo substr($user_details->city,0,20);?></td>
                        <td><?php $whr_u =array('id'=>$value['reciever_city']);$user_details = $this->basic_operation_m->get_table_row('city', $whr_u);echo substr($user_details->city,0,20);?></td>
                        <td><?= $value['sender_name']; ?></td>
                        <td><?= $value['sender_contactno']; ?></td>
                        <td><?= $value['grand_total'];?></td>

                       
                        <td>Paid</td>
                      <?php  }} ?>
                       
                      </tr>
                    </tbody>
                    <input type="hidden" name="selected_campaing" id="selected_campaingss" value="">
                  </table>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <?php //echo $this->pagination->create_links(); 
                    ?>
                  </div>
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
  <?php $this->load->view('admin/admin_shared/admin_footer'); ?>
</body>
<!-- END: Body-->

</html>


</div>
<div id="model" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <div class="paynow">
      <form action="">
        <div class="form-row">
          <label for="">AWB</label>
          <input type="text" class="form-control" name="" Placeholder="Search Name" value="">
        </div>
        <div class="form-row">
          <label for="">Origin</label>
          <input type="text" class="form-control" name="" Placeholder="Origin" value="">
        </div>
        <div class="form-row">
          <label for="">Destination</label>
          <input type="text" class="form-control" name="" Placeholder="Destination" value="">
        </div>
        <div class="form-row">
          <label for="">Amount</label>
          <input type="text" class="form-control" name="" Placeholder="Amount" value="">
        </div>
        <div class="form-row">
          <label for="">Pay By</label>
          <select name="" class="form-control" id="">
            <option value="">--Select--</option>
          </select>
        </div>
        <div class="form-row">
          <label for="">Ref No</label>
          <input type="text" class="form-control" name="" Placeholder="Ref No" value="">
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Submit</button>

      </form>
    </div>
  </div>
</div>

</div>

<script>
  $(function() {

    $('#myBtn,.close').on('click', function() {
      $('#model').toggle();

    });

  });
</script>