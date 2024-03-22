<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('booking_status'))
{
    function booking_status($podno)
    {
        //get main CodeIgniter object
       $ci =& get_instance();
       
       //load databse library
       $ci->load->database();
       
       //get data from database
       $query = $ci->db->from('tbl_international_tracking')->where('pod_no',$podno)->order_by('id', 'DESC')->get();
       
       if($query->num_rows() > 0){
           $result = $query->row();
           return $result;
       }else{
           return false;
       }
    }   
}

function franchise_id(){
  return $id = 'FBI';
}

function sendsms($number,$enmsg){
    $msg2 = urlencode($enmsg);
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL, "http://sms.wiantech.net/api/mt/SendSMS?APIKey=FVutSRqWyEC5AEa3qYxRJA&senderid=BFREGT&channel=2&DCS=0&flashsms=1&number=$number&text=$msg2&route=31");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 0);
    $response = curl_exec($ch);
    curl_close($ch);
}



function displaywords($number){
  $no = (int)floor($number);
  $point = (int)round(($number - $no) * 100);
  $hundred = null;
  $digits_1 = strlen($no);
  $i = 0;
  $str = array();
  $words = array('0' => '', '1' => 'one', '2' => 'two',
  '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
  '7' => 'seven', '8' => 'eight', '9' => 'nine',
  '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
  '13' => 'thirteen', '14' => 'fourteen',
  '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
  '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
  '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
  '60' => 'sixty', '70' => 'seventy',
  '80' => 'eighty', '90' => 'ninety');
  $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
  while ($i < $digits_1) {
   $divider = ($i == 2) ? 10 : 100;
   $number = floor($no % $divider);
   $no = floor($no / $divider);
   $i += ($divider == 10) ? 1 : 2;


   if ($number) {
    $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
    $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
    $str [] = ($number < 21) ? $words[$number] .
      " " . $digits[$counter] . $plural . " " . $hundred
      :
      $words[floor($number / 10) * 10]
      . " " . $words[$number % 10] . " "
      . $digits[$counter] . $plural . " " . $hundred;
   } else $str[] = null;
  }
  $str = array_reverse($str);
  $result = implode('', $str);


  if ($point > 20) {
  $points = ($point) ?
    "" . $words[floor($point / 10) * 10] . " " . 
      $words[$point = $point % 10] : ''; 
  } else {
    $points = $words[$point];
  }
  if($points != ''){        
    echo ucfirst($result) . "rupees  " . $points . " paise only";
  } else {

    echo ucfirst($result) . "rupees only";
  }
}

function mis_formate_columns($type){
  
  if($type == '1')
  {
    $columsArr = array('SR.No', 'Date', 'Consigner', 'Consignee', 'Destination', 'Pincode', 'Invoice No', 'Invoice Value', 'Contact NO', 'DOC No', 'Shipment Type', 'Mode', 'Delivery Type', 'NOP', 'A.W.', 'C.W.', 'ODA', 'Delivery Date', 'TAT', 'EDD', 'Status', 'Status Description');
  }
  if($type == '2')
  {
    $columsArr = array('SR.No', 'Date', 'Consigner', 'Pincode', 'Pickup From', 'Consignee', 'Pincode','Contact No', 'Doc NO', 'Forwording NO', 'Forworder Name', 'Destination', 'No. of pcs', 'Invoice No', 'Invoice Value', 'Weight', 'Delivery Date', 'TAT', 'EDD', 'Status', 'Description');
  }
  if($type == '3')
  {
    $columsArr = array('SR.No', 'Date', 'Consigner', 'Pincode', 'Pickup From', 'Consignee', 'Pincode','Destination', 'Doc NO.', 'No. of Pcs', 'Invoice No', 'Invoice Value', 'Weight', 'EDD', 'Status', 'Description');
  }

  return $columsArr;
}

if(!function_exists('getBrowserAgent'))
{
    function getBrowserAgent()
    {
        $CI = get_instance();
        $CI->load->library('user_agent');

        $agent = '';

        if ($CI->agent->is_browser())
        {
            $agent = $CI->agent->browser().' '.$CI->agent->version();
        }
        else if ($CI->agent->is_robot())
        {
            $agent = $CI->agent->robot();
        }
        else if ($CI->agent->is_mobile())
        {
            $agent = $CI->agent->mobile();
        }
        else
        {
            $agent = 'Unidentified User Agent';
        }

        return $agent;
    }
}

  function get_state($state_id=''){
    $ci =& get_instance();
    $ci->load->database();
    $state_name =  $ci->db->get_where('state',['id' => $state_id])->row('state');
    return $state = 'REST OF '.$state_name;
  }

  function get_city($city_id=''){
    $ci =& get_instance();
    $ci->load->database();
    return $state_name =  $ci->db->get_where('city',['id' => $city_id])->row('city');
  }

  function tat_day_count($sender_state= '',$sender_city='',$reciver_state = '',$reciever_city ='',$mode_details=''){
    $ci =& get_instance();
    $ci->load->database();
    $sender_state_name = get_state($sender_state);
    $reciver_state_name = get_state($reciver_state);
    $sender_city_name = get_city($sender_city);
    $reciever_city_name = get_city($reciever_city);
  //  return $tat_master =  $ci->db->query("select tat,tat_from,tat_to from tbl_tat_master where  mode = '$mode_details' and ( tat_from = '$sender_state_name' and tat_to ='$reciver_state_name' ) or (tat_to = '$reciever_city_name' and tat_from = '$sender_city_name')")->row();
    // $state_tat_master =  $ci->db->query("select tat,tat_from,tat_to from tbl_tat_master where  mode = '$mode_details' and ( tat_from = '$sender_state_name' and tat_to ='$reciver_state_name')")->row();
    $tat_master =  $ci->db->query("select tat,tat_from,tat_to from tbl_tat_master where mode = '$mode_details' AND tat_from != '$sender_state_name' AND tat_to != '$reciver_state_name'")->result();
    $dd_tat_from = array(); $dd_tat_to = array();
    $tt = '';
		if(!empty($tat_master)){
      foreach ($tat_master as $key => $value) {
        $tat_master1[] = array(
          'tat' => $value->tat,
          'tat_from1' => str_replace(' / ',',', $value->tat_from),
          'tat_to1' => str_replace(' / ',',', $value->tat_to),
        );
  		}

      foreach ($tat_master1 as $v) {
        // if(($v['tat_to1'] == $reciever_city_name || preg_match('/\b' . $reciever_city_name . '\b/', $v['tat_to1'])) && ($v['tat_from1'] == $sender_city_name || preg_match('/\b' . $sender_city_name . '\b/', $v['tat_from1']))){
        if(($v['tat_to1'] == $reciever_city_name) && ($v['tat_from1'] == $sender_city_name)){
          $tt = $v['tat'];
        }
        // else if(( preg_match('/\b' . $reciever_city_name . '\b/', $v['tat_to1'])) && (preg_match('/\b' . $sender_city_name . '\b/', $v['tat_from1']))){
        //   $tt = $v['tat'];
        // }
      }
      if(empty($tt)){
        $tt =  $ci->db->query("select tat,tat_from,tat_to from tbl_tat_master where  mode = '$mode_details' and ( tat_from = '$sender_state_name' and tat_to ='$reciver_state_name')")->row('tat');
      }
    }
    return $tt;
  }

// public function cargo_exchange_api($url, $method, $param){
function cargo_exchange_api(){
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://app-qa.cxipl.com/api/v2/eway-bill/'.$url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => $method,
		  CURLOPT_POSTFIELDS =>$param,
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json',
		    'authkey: YZD7VV6JTC25XK5P3CJTC9V9Q5AZ7TB4'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		return $response;
}