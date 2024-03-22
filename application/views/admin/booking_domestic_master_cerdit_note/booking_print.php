<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>file_1664012585239</title>
    <meta name="author" content="jai" />
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
            text-indent: 0;
        }

        .s1 {
            color: #00F;
            font-family: Arial, sans-serif;
            font-style: italic;
            font-weight: bold;
            text-decoration: none;
            font-size: 20pt;
        }

        .s2 {
            color: black;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 9pt;
        }

        .s3 {
            color: #F00;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 9pt;
        }

        .s4 {
            color: black;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 13pt;
        }

        .s5 {
            color: black;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 9pt;
        }

        .s6 {
            color: black;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: underline;
            font-size: 9pt;
        }

        .s7 {
            color: black;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: underline;
            font-size: 9pt;
        }

        .s8 {
            color: black;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 7pt;
        }

        .s9 {
            color: black;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 9pt;
        }

        .s11 {
            color: black;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 8pt;
        }

        .s12 {
            color: black;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 11pt;
        }

        .s13 {
            color: black;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 7pt;
        }

        table,
        tbody {
            vertical-align: top;
            overflow: visible;
        }
    </style>
      
</head>

<body>
      
    <table style="width:100%;" cellspacing="0">
        <tr>
            <td style="border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:2pt"
               >
                <img class="logo-css" src="<?php echo base_url();?>./assets/company/<?php echo $company_details->logo; ?>" alt="" style="width: 400px;">
            </td>
            <td style="border-top-style:solid;border-top-width:1pt">
                      <p class="s2" style="text-indent: 0pt;text-align: right;">Invoice No.  <?php
                                    $invoiceNumebr = $customer->invoice_number;
                                    echo $invoiceNumebr;
                                ?> </p>
            </td>
           
        </tr>
        <tr style="height:10pt">
            <td
                style="border-left-style:solid;border-left-width:2pt;border-bottom-style:solid;border-bottom-width:2pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td style="border-bottom-style:solid;border-bottom-width:2pt" colspan="4">
                <p class="s2" style="padding-top: 4pt;padding-left: 60pt;text-indent: 0pt;text-align: left;">GSTIN
                    NUMBER : <?php echo $branch_info->gst_number;?></p>
            </td>
            <td style="border-bottom-style:solid;border-bottom-width:2pt" colspan="2">
                <p class="s2" style="padding-top: 4pt;padding-left: 2pt;text-indent: 0pt;text-align: left;">PAN :
                <?php echo $company_details->website;?></p>
            </td>
            <td style="border-bottom-style:solid;border-bottom-width:2pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td style="border-bottom-style:solid;border-bottom-width:2pt" colspan="2">
                <p class="s2" style="padding-top: 4pt;padding-left: 2pt;text-indent: 0pt;text-align: left;">SAC CODE :
                    </p>
            </td>
            <td
                style="border-bottom-style:solid;border-bottom-width:2pt;border-right-style:solid;border-right-width:2pt">
                <p style="text-indent: 0pt;text-align: left;"><br /><?=$customer->sac_code;?></p>
            </td>
            <td
                style="border-top-style:solid;border-top-width:2pt;border-left-style:solid;border-left-width:2pt;border-right-style:solid;border-right-width:2pt">
                <p class="s4" style="padding-left: 2pt;text-indent: 0pt;line-height: 14pt;text-align: left;">INVOICE</p>
            </td>
        </tr>
        <tr style="height:11pt">
            <td
                style="border-left-style:solid;border-left-width:2pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td 
                colspan="4">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td 
                colspan="2">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td
               >
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td 
                colspan="2">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td
                >
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td
                style="border-right-style:solid;border-right-width:2pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
        </tr>
        <tr style="height:11pt">
            <td
                style="border-left-style:solid;border-left-width:2pt;">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td 
                colspan="4">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td 
                colspan="2">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td
                >
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td  colspan="2">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td >
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td
                style="border-right-style:solid;border-right-width:2pt;">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
        </tr>
        <tr style="height:11pt">
            
            <td style="border-left-style:solid;border-left-width:2pt;border-right-style:solid;border-right-width:2pt;border-bottom-style:solid;border-bottom-width:2pt"
                colspan="2">
                <p style="text-align:center;">Customer
                </p>
            </td>
            <td
                style="border-top-style:solid;border-top-width:2pt;border-left-style:solid;border-left-width:2pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td style="border-top-style:solid;border-top-width:2pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td style="border-top-style:solid;border-top-width:2pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td style="border-top-style:solid;border-top-width:2pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td style="border-top-style:solid;border-top-width:2pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td style="border-top-style:solid;border-top-width:2pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td >
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td style="border-right-style:solid;border-right-width:2pt;border-bottom-style:solid;border-bottom-width:2pt" colspan="2">
                <p style="text-align:center;">Misc</p>
            </td>
            <td
                style="border-top-style:solid;border-top-width:2pt;border-left-style:solid;border-left-width:2pt;border-right-style:solid;border-right-width:2pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
        </tr>
        <tr style="margin:4px;">
            <td style="border-left-style:solid;border-left-width:2pt" colspan="2">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <p class="s5" style="text-align: center; font-size: 14px;">Company
                    Name</p> 
            </td>
            <td 
                colspan="2">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <p class="s6" style="text-indent: 0pt;line-height: 10pt;text-align: left;"> 
                <?php echo $company_details->company_name;?> 
                </p>
            </td>
            <td style="border-bottom-style:solid;border:0px;">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td style="border-bottom-style:solid;border:0px;">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td style="border-bottom-style:solid;border:0px;">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td style="border-bottom-style:solid;border:0px;">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td >
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td colspan="2">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <p class="s5" style="padding-left: 48pt;text-indent: 0pt;line-height: 10pt;text-align: left;font-size:14px;">Date</p>
            </td>
            <td
                style="border-right-style:solid;border-right-width:2pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <p class="s7" style="text-align: left; font-size:14px;">  <?php
                                $invoiceDate = $customer->invoice_date;
                                if(!$invoiceDate)
                                {
                                    $invoiceDate = date('Y-m-d');
                                }
                                echo date('d/m/y', strtotime($invoiceDate));
                                ?></p>
            </td>
        </tr>
        <tr style="height:20pt;margin-top: 10px;">
            <td style="border-left-style:solid;border-left-width:2pt" colspan="2">
                <p class="s5" style="text-align:center; font-size: 14px; padding-top:10px ;">Address
                </p>
            </td>
            <td style="border-top-style:solid;border-top-width:1pt;border-top-color:#ffff;"
                colspan="3">
                <p class="s8" style="padding-top:10px ;padding-left: 2pt;font-size:14px;text-align: left;"><?php echo $customer->address; ?></p>
                <p class="s8" style="padding-top:10px ;padding-left: 2pt;font-size:14px;text-align: left;">City :  <?=$customer->city;?>     &nbsp; State: <?php	$whr_c =array('customer_id'=>$customer->customer_id);
                            $cust_details = $this->basic_operation_m->get_table_row('tbl_customers', $whr_c);
                            
                            $whr_u =array('id'=>$cust_details->state);
                            $state_details = $this->basic_operation_m->get_table_row('state', $whr_u);
                            echo $state_details->state; ?>       &nbsp; Pin Code : <?=$customer->pincode;?>
                  </p>
                    
            </td>
            <td
                style="border-top-style:solid;border-top-width:1pt;border-top-color:#fff;border-bottom-style:solid;border-bottom-width:1pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td
                style="border-top-style:solid;border-top-width:1pt;border-top-color:#fff;border-bottom-style:solid;border-bottom-width:1pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td
                style="border-top-style:solid;border-top-width:1pt;border-top-color:#fff;border-bottom-style:solid;border-bottom-width:1pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td >
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td  colspan="2">
                <p class="s5" style="padding-left: 48pt;text-indent: 0pt;line-height: 10pt;font-size:14px;text-align: left; padding-top:10px;">Period
                    From.</p>
                <p class="s5" style="padding-left: 48pt;text-indent: 0pt;line-height: 10pt;font-size:14px;text-align: left; padding-top:10px;">
                    Period To,</p>
               
            </td>
            <td
                style="border-top-style:solid;border-top-width:1pt;border-top-color:#fff;border-right-style:solid;border-right-width:2pt">
                <p class="s5" style="padding-left: 8pt;text-indent: 0pt;;text-align: left;padding-top:10px; font-size: 14px; text-decoration: none;"><?php
                                $invoice_from_date = $customer->invoice_from_date;
                                if(!$invoice_from_date)
                                {
                                    $invoice_from_date = '';
                                }
                                $fromDate = date('d/m/y', strtotime($invoice_from_date));
                                
                                $invoice_to_date = $customer->invoice_to_date;
                                if(!$invoice_to_date)
                                {
                                    $invoice_to_date = '';
                                }
                                $toDate = date('d/m/y', strtotime($invoice_to_date));
                                
                                echo $fromDate;
                            ?>
                </p> <br>
                <p class="s5" style="padding-left: 8pt;text-indent: 0pt;;text-align: left;padding-top:10px; font-size: 14px; text-decoration: none;"><?= $toDate; ?>
                </p>
                
            </td>
        </tr>
        
      
        <tr style="height:14pt">
            <td style="border-left-style:solid;border-left-width:2pt" colspan="2">
                <p class="s5" style="padding-top: 2pt;padding-left: 19pt;text-indent: 0pt;text-align: left; padding-top: 10px; font-size: 12px;">Customer
                    GST No.</p>
            </td>
            <td style="border-top-style:solid;border-top-width:1pt;"
                colspan="2">
                <p class="s12" style="padding-left: 2pt;line-height: 13pt;text-align: left; padding-top: 10px; padding-bottom: 10px; font-size: 14px;">
                <?=$customer->gstno;?></p>
            </td>
            <td
                style="border-top-style:solid;border-top-width:1pt;border-bottom-style:solid;border-bottom-width:1pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td
                style="border-top-style:solid;border-top-width:1pt;border-bottom-style:solid;border-bottom-width:1pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td
                style="border-top-style:solid;border-top-width:1pt;border-bottom-style:solid;border-bottom-width:1pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td
                style="border-top-style:solid;border-top-width:1pt;border-bottom-style:solid;border-bottom-width:1pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td >
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td>
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td>
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td
                style="border-top-style:solid;border-top-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:2pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
        </tr>
        <tr style="height:23pt">
            <td
                style="border-top-style:solid;border-top-width:2pt;border-left-style:solid;border-left-width:2pt;border-bottom-style:solid;border-bottom-width:2pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <p class="s2" style="padding-left: 2pt;text-indent: 0pt;line-height: 10pt;text-align: center;">S.No.</p>
            </td>
            <td
                style="border-top-style:solid;border-top-width:2pt;border-bottom-style:solid;border-bottom-width:2pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <p class="s2" style="padding-left: 25pt;text-indent: 0pt;line-height: 10pt;text-align: left;">DATE</p>
            </td>
            <td
                style="border-top-style:solid;border-top-width:2pt;border-bottom-style:solid;border-bottom-width:2pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <p class="s2"
                    style="padding-left: 18pt;padding-right: 8pt;text-indent: 0pt;line-height: 10pt;text-align: center;">
                    AWB NO.</p>
            </td>
            <td
                style="border-top-style:solid;border-top-width:2pt;border-bottom-style:solid;border-bottom-width:2pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <p class="s2"
                    style="padding-left: 11pt;padding-right: 3pt;text-indent: 0pt;line-height: 10pt;text-align: center;">
                    FROM</p>
            </td>
            <td
                style="border-top-style:solid;border-top-width:2pt;border-bottom-style:solid;border-bottom-width:2pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <p class="s2" style="text-indent: 0pt;line-height: 10pt;text-align: center;">TO</p>
            </td>
            <td
                style="border-top-style:solid;border-top-width:2pt;border-bottom-style:solid;border-bottom-width:2pt">
                <p class="s13" style="padding-left: 14pt;text-indent: -10pt;line-height: 10pt;text-align: left;">
                    CHARGEABLE WEIGHT</p>
            </td>
            <td
                style="border-top-style:solid;border-top-width:2pt;border-bottom-style:solid;border-bottom-width:2pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <p class="s2"
                    style="padding-left: 9pt;padding-right: 15pt;text-indent: 0pt;line-height: 10pt;text-align: center;">
                    PIECE</p>
            </td>
            <td
                style="border-top-style:solid;border-top-width:2pt;border-bottom-style:solid;border-bottom-width:2pt">
                <p class="s2"
                    style="padding-left: 2pt;padding-right: 2pt;text-indent: 0pt;line-height: 8pt;text-align: center;">
                    RATE PER</p>
                <p class="s2"
                    style="padding-top: 1pt;padding-left: 2pt;padding-right: 2pt;text-indent: 0pt;text-align: center;">
                    KG</p>
            </td>
            <td
                style="border-top-style:solid;border-top-width:2pt;border-bottom-style:solid;border-bottom-width:2pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <p class="s2" style="padding-right: 3pt;text-indent: 0pt;line-height: 10pt;text-align: right;">FRIGHT
                </p>
            </td>
            <td
                style="border-top-style:solid;border-top-width:2pt;border-bottom-style:solid;border-bottom-width:2pt">
                <p class="s2"
                    style="padding-left: 3pt;padding-right: 1pt;text-indent: 0pt;line-height: 8pt;text-align: center;">
                    FUEL</p>
                <p class="s2"
                    style="padding-top: 1pt;padding-left: 3pt;padding-right: 1pt;text-indent: 0pt;text-align: center;">
                    CHARGE</p>
            </td>
            <td
                style="border-top-style:solid;border-top-width:2pt;border-bottom-style:solid;border-bottom-width:2pt">
                <p class="s2" style="padding-left: 9pt;text-indent: 0pt;line-height: 8pt;text-align: left;">DOCKET</p>
                <p class="s2" style="padding-top: 1pt;padding-left: 9pt;text-indent: 0pt;text-align: left;">CHARGE</p>
            </td>
            <td
                style="border-top-style:solid;border-top-width:2pt;border-bottom-style:solid;border-bottom-width:2pt;border-right-style:solid;border-right-width:2pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <p class="s2" style="padding-left: 11pt;text-indent: 0pt;line-height: 10pt;text-align: left;">AMOUNT</p>
            </td>
        </tr>
       
        <tr style="height:12pt">
            <td style="border-left-style:solid;border-left-width:2pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td >
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td >
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td >
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td >
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td >
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td >
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td >
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td >
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td >
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td >
                <p class="s8" style="padding-top: 1pt;text-indent: 0pt;text-align: right;">Page-1-6</p>
            </td>
            <td style="border-right-style:solid;border-right-width:2pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
        </tr>
    </table>
    <p style="text-indent: 0pt;text-align: left;" />
    <p style="text-indent: 0pt;text-align: left;" />
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <table style="border-collapse:collapse;margin-left:6.685pt" cellspacing="0">
        <tr style="height:10pt">
            <td style="border-top-style:solid;border-top-width:2pt;border-left-style:solid;border-left-width:2pt;border-right-style:solid;border-right-width:1pt"
                colspan="6" rowspan="6">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <p class="s2" style="padding-left: 29pt;text-indent: 0pt;text-align: left;">Payment</p>
            </td>
            <td
                style="border-top-style:solid;border-top-width:2pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                <p class="s5" style="padding-left: 1pt;text-indent: 0pt;line-height: 9pt;text-align: left;">Total</p>
            </td>
            <td
                style="border-top-style:solid;border-top-width:2pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:2pt">
                <p class="s5" style="text-indent: 0pt;line-height: 9pt;text-align: right;">64905.60</p>
            </td>
        </tr>
        <tr style="height:11pt">
            <td
                style="border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                <p class="s5" style="padding-left: 1pt;text-indent: 0pt;line-height: 9pt;text-align: left;">S GST 6%</p>
            </td>
            <td style="border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:2pt"
                bgcolor="#FFFFCC">
                <p class="s5" style="text-indent: 0pt;line-height: 9pt;text-align: right;">3894.34</p>
            </td>
        </tr>
        <tr style="height:11pt">
            <td
                style="border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                <p class="s5" style="padding-left: 1pt;text-indent: 0pt;line-height: 9pt;text-align: left;">C GST 6%</p>
            </td>
            <td style="border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:2pt"
                bgcolor="#FFFFCC">
                <p class="s5" style="text-indent: 0pt;line-height: 9pt;text-align: right;">3894.34</p>
            </td>
        </tr>
        <tr style="height:11pt">
            <td
                style="border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                <p class="s5" style="padding-left: 1pt;text-indent: 0pt;line-height: 9pt;text-align: left;">I GST 12%
                </p>
            </td>
            <td style="border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:2pt"
                bgcolor="#FFFFCC">
                <p class="s5" style="text-indent: 0pt;line-height: 9pt;text-align: right;">0.00</p>
            </td>
        </tr>
        <tr style="height:11pt">
            <td
                style="border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td style="border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:2pt"
                bgcolor="#FFFFCC">
                <p class="s5" style="text-indent: 0pt;line-height: 10pt;text-align: right;">0.89</p>
            </td>
        </tr>
        <tr style="height:11pt">
            <td
                style="border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                <p class="s5" style="padding-left: 1pt;text-indent: 0pt;line-height: 10pt;text-align: left;">Grand Total
                </p>
            </td>
            <td
                style="border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:2pt">
                <p class="s2" style="text-indent: 0pt;line-height: 10pt;text-align: right;">72695.16</p>
            </td>
        </tr>
        <tr style="height:23pt">
            <td style="border-left-style:solid;border-left-width:2pt;border-right-style:solid;border-right-width:2pt"
                colspan="8">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
        </tr>
        <tr style="height:23pt">
            <td
                style="border-left-style:solid;border-left-width:2pt;border-right-style:solid;border-right-width:1pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td style="border-left-style:solid;border-left-width:1pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <p class="s5" style="text-indent: 0pt;line-height: 10pt;text-align: right;">Amount in words</p>
            </td>
            <td  colspan="2">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <p class="s11" style="padding-left: 2pt;text-indent: 0pt;text-align: left;">FIVE LAKH NINTEEN THOUSAND
                    FIVE HUNDRED</p>
            </td>
            <td style="border-right-style:solid;border-right-width:1pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td style="border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-right-style:solid;border-right-width:2pt"
                colspan="3">
                <p class="s2" style="padding-left: 9pt;text-indent: 0pt;text-align: left;">For AIR POINT INTERNATIONAL
                </p>
            </td>
        </tr>
        <tr style="height:11pt">
            <td
                style="border-left-style:solid;border-left-width:2pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td style=";border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt"
                colspan="4">
                <p style="padding-left: 73pt;text-indent: 0pt;line-height: 1pt;text-align: left;" />
                <p class="s11" style="padding-left: 74pt;text-indent: 0pt;line-height: 9pt;text-align: left;">FIFTY FIVE
                    ONLY</p>
            </td>
            <td style="border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:2pt"
                colspan="3">
                <p class="s5" style="padding-left: 29pt;text-indent: 0pt;line-height: 10pt;text-align: left;">Authorised
                    Signitory</p>
            </td>
        </tr>
        <tr style="height:11pt">
            <td style="border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:2pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:2pt"
                colspan="8">
                <p class="s2" style="padding-left: 29pt;text-indent: 0pt;line-height: 9pt;text-align: left;">BANK
                    DETAILS</p>
            </td>
        </tr>
        <tr style="height:11pt">
            <td
                style="border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:2pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td style="border-top-style:solid;border-top-width:1pt">
                <p class="s2" style="padding-right: 1pt;text-indent: 0pt;line-height: 10pt;text-align: right;">A/C NAME
                    :</p>
            </td>
            <td style="border-top-style:solid;border-top-width:1pt">
                <p class="s2" style="padding-left: 2pt;text-indent: 0pt;line-height: 10pt;text-align: left;">AIR POINT
                    INTERNATIONAL</p>
            </td>
            <td style="width:58pt;border-top-style:solid;border-top-width:1pt">
                <p class="s2" style="padding-right: 9pt;text-indent: 0pt;line-height: 10pt;text-align: right;">IFSC :
                </p>
            </td>
            <td style="border-top-style:solid;border-top-width:1pt">
                <p class="s2" style="padding-left: 11pt;text-indent: 0pt;line-height: 10pt;text-align: left;">
                    HDFC0001206</p>
            </td>
            <td style="width:47pt;border-top-style:solid;border-top-width:1pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td style="border-top-style:solid;border-top-width:1pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td
                style="border-top-style:solid;border-top-width:1pt;border-right-style:solid;border-right-width:2pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
        </tr>
        <tr style="height:12pt">
            <td
                style="border-left-style:solid;border-left-width:2pt;border-bottom-style:solid;border-bottom-width:1pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td style="border-bottom-style:solid;border-bottom-width:1pt">
                <p class="s2" style="padding-right: 1pt;text-indent: 0pt;line-height: 10pt;text-align: right;">A/C
                    NUMBER :</p>
            </td>
            <td style="border-bottom-style:solid;border-bottom-width:1pt">
                <p class="s2" style="padding-left: 2pt;text-indent: 0pt;line-height: 10pt;text-align: left;">
                    50200063122453</p>
            </td>
            <td style="border-bottom-style:solid;border-bottom-width:1pt">
                <p class="s2" style="padding-right: 9pt;text-indent: 0pt;line-height: 10pt;text-align: right;">BRANCH :
                </p>
            </td>
            <td style="border-bottom-style:solid;border-bottom-width:1pt">
                <p class="s2" style="padding-left: 11pt;text-indent: 0pt;line-height: 10pt;text-align: left;">KH ROAD
                    BANGALORE</p>
            </td>
            <td style="border-bottom-style:solid;border-bottom-width:1pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td style="border-bottom-style:solid;border-bottom-width:1pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td
                style="border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:2pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
        </tr>
        <tr style="height:11pt">
            <td style="border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:2pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:2pt"
                colspan="8">
                <p class="s5" style="padding-left: 29pt;text-indent: 0pt;line-height: 10pt;text-align: left;">PAYMENT
                    SHOULD BE MADE IN FAVOUR OF AIR POINT INTERNATIONAL AT PUNE</p>
            </td>
        </tr>
        <tr style="height:11pt">
            <td style="border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:2pt;border-bottom-style:solid;border-bottom-width:2pt;border-right-style:solid;border-right-width:2pt"
                colspan="8">
                <p class="s8" style="padding-left: 46pt;text-indent: 0pt;text-align: left;">#19/2, OLD SOMWARPETH / 418
                    NEW MANGALWARPETH, PUNE 411011 H.O. #157/158, 4TH CROSS, LALBAGH ROAD, KS GARDEN, BANGALORE 560027
                    Ph 080-4092 3919</p>
            </td>
        </tr>
        <tr style="height:295pt">
            <td style="border-top-style:solid;border-top-width:2pt" colspan="8">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <p class="s8" style="padding-right: 63pt;text-indent: 0pt;line-height: 7pt;text-align: right;">Page-6-6
                </p>
            </td>
        </tr>
    </table>
    <p style="text-indent: 0pt;text-align: left;" />
</body>

</html>