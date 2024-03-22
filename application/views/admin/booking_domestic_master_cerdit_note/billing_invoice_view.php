<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Credit Note Invoice</title>
    <base href="<?php echo base_url(); ?>">
    <link rel="shortcut icon" href="assets/admin_assets/dist/images/favicon.ico" />
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="assets/admin_assets/dist/vendors/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/admin_assets/dist/vendors/jquery-ui/jquery-ui.min.css">
    <style type="text/css">
        .table-bordered td,
        .table-bordered th {
            /*padding: 0.25px;*/
            padding: 3px 10px;
           font-size: 13px;
        }

        .table-th-font td,
        .table-th-font th {
            /*padding: 0.25px;*/
            padding: 3px 10px;
           font-size: 11px;
           
        }

        .extra-border td, .extra-border th  {
           border:none;
        }

        /* body {
            font-size: 12px;
        } */

        .table-bordered {
            border: 1px solid #212529;
            margin-bottom: 0;
            font-family: sans-serif;
        }
        /* b{
            font-size: 17px; 
        } */
    </style>

    <style>
        @media print {

            tbody tr:nth-child(5n + 50) {
                page-break-before: always;
            }
        }


        .page-number {
            content: counter(page)
        }
    </style>
</head>

<body>
    <div class="container mt-3">
        <div class="row">
            <div class="col-12">
                <!-- <div class="card"> -->
                <!-- <div class="card-body"> -->

                <?php

                $company_name = $company_details->company_name;
                $company_address = $company_details->address;
                $company_gst = $company_details->gst_no;
                $company_pan = $company_details->pan;
                $website = $company_details->website;
                $email = $company_details->email;
                $msme_regno = $company_details->udhyam_no;

                ?>

                <?php
                $cust_details1 = $this->db->get_where('tbl_customers', ['customer_id' => $customer->customer_id])->row();
                $cust_name = $customer->customer_name;
                $cust_address = $cust_details1->address;
                $cust_gstno = $cust_details1->gstno;
                $state_code  =  substr($cust_gstno,0,2);
                $sac_code = $cust_details1->sac_code;
                $cus_code = $cust_details1->cid;
                $credit_days = $cust_details1->credit_days;

                $state_data = $this->db->get_where('state', ['id' => $cust_details1->state])->row();
                $state_name = $state_data->state;
               
                $invoiceNumebr = $customer->invoice_number;
                // if (!$customer->invoice_number) {
                //     $invoiceNumebr = 'OMCS/' . $year . '-' . ($year + 1) . '/' . $customer->id;
                // }

                $invoiceDate = $customer->invoice_date;
                if (!$invoiceDate) {
                    $invoiceDate = date('Y-m-d');
                }
                $invoice_from_date = $customer->invoice_from_date;
                if (!$invoice_from_date) {
                    $invoice_from_date = '';
                }
                $fromDate = date('d-m-y', strtotime($invoice_from_date));

                $invoice_to_date = $customer->invoice_to_date;
                if (!$invoice_to_date) {
                    $invoice_to_date = '';
                }
                $toDate = date('d-m-y', strtotime($invoice_to_date));

                $total_amount = $customer->total_amount;
                $sub_total = $customer->sub_total;
                $grand_total = $customer->grand_total;

                $isIGst = 0;
                $cmpGst = substr($company_details->gst_no, 0, 2);
                $custpGst = substr($cust_details1->gstno, 0, 2);
                if ($cmpGst == $custpGst) {
                    $isIGst = 1;
                }

               
              
                $get_mode = $this->db->get_where('tbl_domestic_booking', ['pod_no' => $allpoddata[0]['pod_no']])->row_array();
               // print_r($get_mod['mode_dispatch']);
                $mode_name12 = $this->db->get_where('transfer_mode', array('transfer_mode_id' => $get_mode['mode_dispatch']))->row_array();


                ?>
                <div class="page-number"></div>
                <table class="table table-bordered" cellpadding="5">
                    <tr>
                        <td width="35%" rowspan="4" style="padding: 14px;"><b>Supplier Name & Address :</b><br><b> <?= $company_name ?> </b><br/> <b>Address : </b><?= $company_address; ?><br /><b>GSTIN : <?= $company_gst; ?></b></td>
                        <td width="20%"><b>STATE </b></td>
                        <td width="20%">Maharashtra</td>
                        <td width="25%" rowspan="4"><img class="logo-css" src="<?php echo base_url(); ?>./assets/company/<?php echo $company_details->logo; ?>" alt="" style="height: auto;width: 225px;padding: 20px;"></td>
                    </tr>
                    <tr>
                        <td width="20%"><b>STATE CODE </b></td>
                        <td width="20%">27</td>
                    </tr>
                    <tr>
                        <td width="20%"><b>PAN NO </b></td>
                        <td width="20%"><?= $company_pan; ?></td>
                    </tr>
                    <tr>
                        <td width="20%"> <b>MSME REG NO. </b></td>
                        <td width="20%"><?= $msme_regno; ?></td>
                    </tr>


                    <tr>
                        <td width="100%" colspan="4" style="background: #ddd; font-weight: bold; text-align: center;padding: 10px"><span style="font-size:25px;">CREDIT NOTE</span></td>
                    </tr>
                    <tr>
                        <td width="25%" rowspan="6"><b>Customer Name & Address </b> :<br/><br/><b><?= $cust_name; ?></b><br /><b> Address : </b><?= $cust_address; ?><br />
                        <b>GSTIN : <?= $cust_gstno; ?></b><br />
                        </td>

                        <td width="30%" style=""><b>Customer A/C. :</b> <?php echo $cus_code ;?> </td>
                        
                        <td width="25%" style=""><b>Credit Note No. : </b><?= $customer->credit_note_no; ?></td>
                        <td width="20%" rowspan="6">
                        <?php if(!empty($customer->AckNo)){ ?>
                            <img src="<?= base_url().'assets/qrcode/'.$customer->AckNo.'.png' ?>" width="180"><?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%" style=""><b>Credit Date : </b><?= date('d-m-Y', strtotime($customer->createDtmcredit)); ?></td>
                        <td width="20%" style=""> <b>Invoice No : </b> <?= $invoiceNumebr; ?></td>
                       
                    </tr>
                    <tr>
                        <td width="20%" style=""><b>Invoice Date : </b><?= date('d-m-Y', strtotime($invoiceDate)); ?></td>
                        <td width="20%" style=""> <b>SAC/HSN Code : </b> <?= $sac_code; ?></td>
                       
                    </tr>
                    <tr>
                        <td width="20%" style=""><b> Service Period : </b><br><?= $fromDate . ' to ' . $toDate; ?></td>
                        <td width="20%" style=""><b>Description of Service : <?= $mode_name12['mode_name'];?></b></td>
                    </tr>
                   
                    <tr>
                        <td width="20%" style=""> <b> Credit Period : </b> <?=  $credit_days;?></td>
                        <td width="20%" style=""> <b>State Code : </b><?= $state_code; ?></td>
                    </tr>
                    <tr>
                        <?php $due_date = date('d-m-y' , strtotime( $invoiceDate . "+".$credit_days." days"));?>
                        <?php //$due_date = date('d-m-y',strtotime($invoiceDate) + $credit_days.'day');?>

                        <td width="20%" style=""> <b>Due Date :</b> <?php !empty($due_date)?$due_date:'';?></td>
                        <td width="20%" style=""> <b> Place of Supply : </b><?= $state_name; ?></td>
                    </tr>
                    <tr>
                        <td width="30%" colspan="2" class="text-center" style="padding: 10px;background-color: #ddd;font-size:20px;"><b>Chargeable(Booking Consignment)</b></td>
                        <td width="70%" colspan="2" class="text-center" style="padding: 10px;background-color: #ddd; font-size:20px;"><b>Chargeable of CN Amount</b></td>
                    </tr>
                    <?php $total_pkg = 0; 
                                $total_pcs = 0;
                                $total_taxable_amount1 = 0;
                                $total_chwt = 0;
                                $total_freight = 0;
                                $delivery_charges =0;
                                $awb_charges =0;
                                $sub_total =0;
                                $total_awb_charges = 0; $total_trans_charges= 0; $total_other_charges = 0;
                            if(!empty($allpoddata)){
                                foreach($allpoddata as $key => $value){  
                                    $total_pcs += $value['no_of_pack'];
                                    $total_chwt += $value['chargable_weight'];
                                    $total_freight += $value['amount'];
                                    $total_awb_charges += $value['awb_charges'];
                                    $total_trans_charges += $value['transportation_charges'];
                                    $total_other_charges += $value['other_charges'];
                                    $delivery_charges += $value['delivery_charges'];
                                    $awb_charges += $value['awb_charges'];

                                    $whr_c1 = array('pod_no' => $value['pod_no']);
                                    $cust_details1 = $this->basic_operation_m->get_table_row('tbl_domestic_booking', $whr_c1);
                                    

                                      $total =  $value['frieht'] + $value['awb_charges'] + $value['transportation_charges'] + $value['other_charges'] + $cust_details1->appt_charges+ $value['delivery_charges'] + $cust_details1->pickup_charges +  $cust_details1->green_tax;
                                    //   $total =  $value['frieht'] + $value['awb_charges'] + $value['transportation_charges'] + $value['other_charges'] + $cust_details1->appt_charges+ $value['delivery_charges'] + $cust_details1->pickup_charges +  $cust_details1->green_tax + $cust_details1->insurance_charges + $cust_details1->fov_charges + $cust_details1->courier_charges;

                                      $total_taxable_amount1 += $total;

                                    
                        } } ?>
                       <tr>
                         <td width="30%" colspan="2" rowspan="4" style="padding:30px;">
                           <b> No. of AWB : </b> <span style="float: right;"><?= count($allpoddata); ?></span><br />
                           <b> No. of Packages : </b><span style="float: right;"><?= $total_pcs; ?></span><br />
                           <b> Chargable Weight : </b> <span style="float: right;"><?= $total_chwt; ?></span>
                        </td>
                        <?php   $fuel = array_column($allpoddata, 'fuel_subcharges');
                    $fuel_subcharges = array_sum($fuel); ?>
                       </tr>
                           <tr>
                             <td width="70%" colspan="2" style="text-align:center; font-size:16px;"><b>Final Charges </b> <span style="float: right;"></span></td>
                           </tr>
                            <tr>
                              <td width="70%" colspan="2"> <b>Total CN Amount : </b><span style="float: right;"><?= number_format($total_freight, 2); ?></span></td>
                            </tr>
                           
                         
                    

                    <?php
                    $fuel = array_column($allpoddata, 'fuel_subcharges');
                    $fuel_subcharges = array_sum($fuel);

                    $total_taxable_amount123 = $total_taxable_amount1 + $fuel_subcharges;
                    ?>
                    <?php $whr_c = array('customer_id' => $customer->customer_id);
                    $cust_details = $this->basic_operation_m->get_table_row('courier_fuel', $whr_c); ?>
                    <!-- <tr>
                        <td width="70%" colspan="2"><b>Sub Total <span style="float: right;"><?= number_format($customer->sub_total, 2); ?></span></b></td>
                    </tr> -->
                    <tr>
                        <td width="70%" colspan="2"><b>Taxable Amount <span style="float: right;"><?= number_format($customer->sub_total, 2); ?></span></b></td>
                    </tr>
                    <?php
                    $account_name = $company_details->account_name;
                    $account_number = $company_details->account_number;
                    $ifsc = $company_details->ifsc;
                    $branch_name = $company_details->branch_name;
                    $bank_name = $company_details->bank_name;
                    $mrcs = $company_details->mrcs;
                    $terms = $company_details->invoice_term_condition;

                    $sgst_per = $customer->sgst_per;
                    $cgst_per = $customer->cgst_per;
                    $igst_per = $customer->igst_per;


                    $gst  = $customer->sub_total;

                    $tototal_gst =  $customer->cgst + $customer->sgst  + $customer->igst;
                    $tototal_amount = $gst + $customer->cgst + $customer->sgst  + $customer->igst;
                    // $in_word = ucwords(displaywords(round($tototal_amount, 0)));
                    ?>
                    <tr>
                        <td width="30%" colspan="2" rowspan="4">
                            <b>Bank Details :</b><br/></br>
                           <b> A/C No.: </b> <?= $account_number; ?><br />
                           <b>IFSC: </b> <?= $ifsc; ?><br />
                           <b> Bank: </b> <?= $bank_name; ?><br />
                           <b> Branch: </b> <?= $branch_name; ?>
                        </td>


                        <td width="70%" colspan="2">
                        <b> IGST TAX - <?=  $igst_per;?>%  </b><span style="float: right;"><?= number_format($customer->igst, 2); ?></span><br />
                        <b>  CGST TAX - <?=  $cgst_per;?>%  </b><span style="float: right;"><?= number_format($customer->cgst, 2); ?></span><br />
                        <b>   SGST TAX - <?=  $sgst_per;?>%  </b><span style="float: right;"><?= number_format($customer->sgst, 2); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td width="70%" colspan="2">Total GST<span style="float: right;"><?= $tototal_gst ;?></span></td>
                    </tr>
                    <tr>
                        <td width="70%" colspan="2">Round Off<span style="float: right;">0</span></td>
                    </tr>
                    <tr>
                        <td width="70%" colspan="2"><b>Grand Total <span style="float: right;"><?= number_format($tototal_amount, 2); ?></span></b></td>
                    </tr>

                    <tr>
                        <td width="100%" colspan="4" style="padding: 20px;"><b>Rupees :</b> <?= ucwords(displaywords(round($tototal_amount, 0))); ?></td>
                    </tr>
                    <!-- <tr>
                        <td width="100%" colspan="4">TERMS & CONDITIONS : <br /><?= $terms; ?></td>
                    </tr> -->
                </table>
                <table class="table-bordered table">
                    <tr>
                        <td width="35%" style="padding: 16px;">
                            <b>Registered Office :</b><br/>
                            <b><?= $company_name ?></b><br />
                            <b>Address</b> <?= $company_address; ?><br /> <b>GST NO</b><?= $company_gst; ?>
                        </td>
                        <td width="30%">
                            <b>RECEIVER'S SEAL & SIGNATURE </b><br /><br /><br /></br>
                        </td>
                        <td width="35%">
                            <b>For <?php echo $company_name; ?> :</b><br /><br />

                            <img class="logo-css" src="<?php echo base_url();?>./assets/company/<?php echo $company_details->stamp;?>" alt="" style="width: 110px; "><br>
                            AUTHORISED SIGNATURE
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: center;font-weight: bold; padding: 25px;">Contact # : <?=$company_details->phone_no;?>  | Email Id : <?php echo $email; ?> | Website : <?php echo $website; ?> </td>
                    </tr>
                </table>

                <div style="page-break-before:always"></div>

                <!-- <table class="table"> -->
                <table class="table table-bordered  table-th-font">
                    <thead>
                        <tr>
                            <td colspan="4" style="font-size:18px; font-weight:bold;"><?= $customer->credit_note_no; ?></td>
                            <td colspan="14" style="text-align: center;font-size:18px;"><b><?= $company_name; ?></b></td>

                        </tr>
                        <!-- </table> -->



                        <tr>
                        <th width="5%">SR</th>
                            <th width="8%">Bkg. Stn.</th>
                            <th class="text-center" width="10%">AWBNO</th>
                            <th class="text-center" width="12%">DATE</th>
                            <th class="text-center" width="12%">Inv. Value</th>
                            <th class="text-center" width="12%">Inv. No.</th>
                            <th class="text-center" width="12%">Rate</th>
                            <th class="text-center" width="10%">DLY Stn.</th>
                            <th class="text-center"width="5%">PKT</th>
                            <th class="text-right" width="10%">WT.CH.</th>
                            <th class="text-center" width="10%">Mode</th>
                            <!-- <th class="text-right">Rate</th> -->
                            <th class="text-right" width="10%">Freight CH.</th>
                            <th class="text-right" width="10%">AWB CH.</th>
                            <th class="text-right" width="10%">Pick-UP</th>
                            <th class="text-right">Delivery</th>
                            <th class="text-right" width="10%">Spe. Del</th>
                            <th class="text-right" width="10%">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                     <?php
                        $cnt = 1;
                        $total_taxable_amount = 0;
                        $total_igst = 0;
                        $total_cgst = 0;
                        $total_sgst = 0;
                        $total_roundoff = 0;
                        $total_final_amount = 0;
                        if (!empty($allpoddata)) {
                            foreach ($allpoddata as $key => $value) {
                                $pod = $value['pod_no'];
                                $date = date('d-m-Y', strtotime($value['booking_date']));
                                $pcs = $value['no_of_pack'];
                                $ch_weight = $value['chargable_weight'];
                                $whr_u2 = array('booking_id' => $value['booking_id']);
                                $branch_details2 = $this->db->query("select * from  tbl_domestic_weight_details where booking_id  = '".$value['booking_id']."'")->row_array();


                                $actual_weight =  number_format(substr($branch_details2['actual_weight'], 0, 20), 3);
                                $whr_u = array('pod_no' => $value['pod_no']);
                                $branch_details = $this->basic_operation_m->get_table_row('tbl_domestic_booking', $whr_u);
                                $whr_u1 = array('id' => $branch_details->sender_city);
                                $branch_details1 = $this->basic_operation_m->get_table_row('city', $whr_u1);
                                $origin = substr($branch_details1->city, 0, 20);
                                $destination = $value['reciever_city'];
                                $freight = number_format($value['frieht'], 2);
                               

                                $current_date = date('d-m-Y', strtotime($value['booking_date']));
                                $whr_c1 = array('pod_no' => $value['pod_no']);
                                $cust_details1 = $this->basic_operation_m->get_table_row('tbl_domestic_booking', $whr_c1);
                                $cust_details3 = $this->db->query("select * from tbl_domestic_booking where pod_no = '".$value['pod_no']."'")->row_array();
                                $whr_c2 = array('id' => $cust_details1->sender_city);
                                $cust_details2 = $this->basic_operation_m->get_table_row('city', $whr_c2);

                                $receiver_zone_id = $cust_details1->receiver_zone_id;
                                $reciever_state = $cust_details1->reciever_state;
                                $recieverCity = $cust_details1->reciever_city;
                                $doc = $cust_details1->doc_nondoc;
                                $c_courier_id = $cust_details1->courier_company_id;
                                $mode_id = $cust_details1->mode_dispatch;
                                $mode_name = $this->db->get_where('transfer_mode', array('transfer_mode_id' => $mode_id))->row_array();
                                $customer_id = -$cust_details1->customer_id;

                                $sender_city = $cust_details1->sender_city;
                                $senderCity = $this->db->get_where('city', array('id' => $sender_city))->row_array();
                                $company = $this->db->get_where('courier_company', array('c_id' => $c_courier_id))->row_array();
                                $sender_state = $cust_details1->sender_state;
                                $invoice_value = $cust_details1->invoice_value;
                                $invoice_no = $cust_details1->invoice_no;
                                $rate_d = $cust_details1->rate;

                              
                                $awb_charges12 = $cust_details3['awb_charges'];
                                $frieht = number_format($cust_details3['frieht'], 2);
                                $transportation_charges = round($cust_details3['transportation_charges'], 2);
                                $pickup_charges = $cust_details3['pickup_charges'];
                                $delivery_charges = $cust_details3['delivery_charges'];
                                $courier_charges = $cust_details3['courier_charges'];
                                $fov_charges = $cust_details3['fov_charges'];
                                $other_charges = $cust_details3['other_charges'];
                                $fuel_subcharges12 = $cust_details3['fuel_subcharges'];
                                $insurance_charges = $cust_details3['insurance_charges'];
                                $green_tax = $cust_details3['green_tax'];
                                $appt_charges = $cust_details3['appt_charges'];
                              
                                $subtotal12 = $cust_details3['sub_total'];
                                $whr1            = array('state' => $sender_state,'city' => $sender_city);
                                $res1           = $this->basic_operation_m->selectRecord('region_master_details', $whr1);   
                                $sender_zone_id         = $res1->row()->regionid;

                                $whr_c3 =array(
                                    'customer_id'=>$cust_details1->customer_id,
                                    'DATE(`applicable_from`)>='=>$current_date,
                                    'mode_id' => $mode_id,
                                    'c_courier_id' => $c_courier_id,
                                    'weight_range_from <='=>$value['chargable_weight'],
                                    'weight_range_to >='=>$value['chargable_weight'],
                                    'from_zone_id' => $sender_zone_id,
                                    'to_zone_id' => $receiver_zone_id,
                                );
                                $current_date1 = date('Y-m-d', strtotime($current_date));
                                $cust_details3 = $this->db->query("SELECT * from tbl_domestic_rate_master where (city_id = 0 OR city_id=$recieverCity) AND customer_id='$cust_details1->customer_id' AND from_zone_id='$sender_zone_id' AND to_zone_id='$receiver_zone_id'  AND ( c_courier_id='$c_courier_id' OR c_courier_id=0) AND mode_id='$mode_id' AND DATE(`applicable_from`)<='$current_date1'AND (".$value['chargable_weight']." BETWEEN weight_range_from AND weight_range_to)ORDER BY rate_id DESC LIMIT 1")->row();

                                // echo $this->db->last_query();
                               $rate1 = $cust_details3->rate;

                              ?> 
                        
                                <tr>
                                    <td width="5%"><?= $cnt; ?></td>
                                    <td><?= $senderCity['city']; ?></td>
                                    <td><?= $pod; ?></td>
                                    <td><?= $date; ?></td>   
                                    <td><?= $invoice_value; ?></td>                                  
                                    <td><?= $invoice_no; ?></td>                                  
                                    <td><?= $rate1; ?></td>                                  
                                    <td><?= $destination; ?></td>
                                    <td><?= $pcs; ?></td>
                                    <td class="text-right"><?= $ch_weight; ?></td>
                                    <td><?= $mode_name['mode_name'];?></td>
                                    <!-- <td><?= $get_sender_customer_rate['rate'];?></td> -->
                                    <td class="text-right"><?= $freight; ?></td>
                                    <td class="text-right"><?= $awb_charges12; ?></td>
                                    <td class="text-right"><?= $pickup_charges; ?></td>
                                    <td class="text-right"><?= $delivery_charges; ?></td>
                                    <td class="text-right"><?= $transportation_charges; ?></td>
                                    <td class="text-right"><?= $value['amount']; ?></td>
                                </tr>
                    </tbody>
            <?php $cnt++;
                            }
                        } ?>
                </table>






                <table class="table table-bordered">
                    <tr>
                        <td colspan="10"></td>
                        <td width="30%">
                            <b>Taxable Amount : </b><span style="float: right;"><?= number_format($total_freight, 2); ?></span><br />
                            <b>IGST <?= $igst_per;?>% </b><span style="float: right;"><?= number_format($customer->igst, 2); ?></span><br />
                            <b>CGST <?= $cgst_per;?>% </b><span style="float: right;"><?= number_format($customer->cgst, 2); ?></span><br />
                            <b>SGST <?= $sgst_per;?>% </b><span style="float: right;"><?= number_format($customer->sgst, 2); ?></span><br />
                            <!-- <b>Round Off </b><span style="float: right;">0</span><br /> -->
                            <b>Total Amount </b><span style="float: right;"><?= number_format($customer->grand_total, 2); ?></span>
                            <!-- Total Amount <span style="float: right;"><?= $grand_total; ?></span> -->
                        </td>
                       
                    </tr>
                    
                    <tr class="border-bottom remove-extra-border"> <td colspan='16' class="extra-border"><b>TERMS & CONDITIONS : </b><br /><?php echo $company_details->invoice_term_condition; ?></td></tr>
                </table>
                
                <!-- </div> -->
                <!-- </div> -->
            </div>

        </div>
    </div>
    </div>
</body>

</html>