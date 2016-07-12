<?php
include '../leone.php';
include '../admin/controller/member.php';
include '../admin/controller/province.php';
include '../admin/controller/payment.php';
include './IPPS/ipps.php';
$member = new member();
$province = new province();
$ipps = new ipps();
$payment = new payment();
$modulename = 'syncwallet.php[IPPS]';
if ($argv[1] == '') {
    $mdata_array = $member->getallmemberid('');
}
else {
    $mdata_array = $member->getdatabyemail($argv[1]);
    if (isset($argv[2])) 
        $req_price = $argv[2];       
}
if (count($mdata_array)>0) {
   foreach ($mdata_array as $mdata) { 
        	$m_id = $mdata['m_id'];
		$m_email = $mdata['m_email'];
		$m_fullname = $mdata['m_fullname'];
		$m_address = $mdata['m_address'];
		$m_province = $mdata['m_province'];
		$m_mobile = $mdata['m_mobile'];
		$m_cardid = $mdata['m_cardid'];
		$m_bdate = $mdata['m_bdate'];
		$m_code = $mdata['m_code'];
		$m_balance = $mdata['m_price'];
                
               //Sync Balance IPPS
        $refcode = $String->Genkey("12"); 
        if (isset($req_price))
            $m_balance_new = ceil($req_price);
        else
            $m_balance_new = ceil($mdata['m_price']);
        $m_balance_nodecimal = $m_balance_new * 100;
        $reqstr = $ipps->direct_topup_request_msg($m_code,$refcode,'Barcode','PARTNER',$m_balance_new);
        #$urlstr = "https://test.payforu.com/payforuservice.svc/APIDirectTopupRequest";
        $urlstr  = "https://test.payforu.com/webservice/payforuservice.svc/APIDirectTopupRequest";
       	$module_name_detail=$modulename.":direct_topup_request";
       	$resultlogging = $payment->insertlog($refcode,$m_email,'BE:REQ',$module_name_detail,$String->utf82tis($reqstr)); //Logging
        $resstr = $ipps->ipps_submit_req($urlstr,$reqstr);
        $resultlogging = $payment->insertlog($refcode,$m_email,'BE:RES',$module_name_detail,$String->utf82tis($resstr)); //Logging
        $result_array = $ipps->extractresult($resstr);  
                 
        if ($result_array['type'] == 'Barcode' && $result_array['status'] == '01') {
            $barcodetxt = $result_array['responsedata']; 
            $my_string = preg_replace(array('/\n/', '/\r/'), '#PH#', $barcodetxt);
            $barcodetxt_arr = explode('#PH#', $my_string);
            print_r($barcodetxt_arr); 
            if (!empty($barcodetxt_arr)) {
                $ipps_custid = $barcodetxt_arr[1];
                $refid_ipps = $barcodetxt_arr[2];
                $reqstr = $ipps->twz_topup_request_msg($ipps_custid,'Check',$refid_ipps,$refcode,$m_balance_nodecimal);
                $urlstr = "https://test.payforu.com/webservice/payforuservice.svc/partnerbillrequest";
       	        $module_name_detail=$modulename.":TWZ_topup_request";
       	        $resultlogging = $payment->insertlog($refcode,$m_email,'BE:REQ',$module_name_detail,$String->utf82tis($reqstr)); //Logging

                $resstr = $ipps->ipps_submit_req($urlstr,$reqstr);
                $resultlogging = $payment->insertlog($refcode,$m_email,'BE:RES',$module_name_detail,$String->utf82tis($resstr)); //Logging
                $result_array = $ipps->extractresult($resstr);  
              
				if ($result_array['status'] == '01') {
					$reqstr = $ipps->twz_topup_request_msg($ipps_custid,'Request',$refid_ipps,$refcode,$m_balance_nodecimal);
					$urlstr = "https://test.payforu.com/webservice/payforuservice.svc/partnerbillrequest";
					$module_name_detail=$modulename.":TWZ_topup_request";
					$resultlogging = $payment->insertlog($refcode,$m_email,'BE:REQ',$module_name_detail,$String->utf82tis($reqstr)); //Logging
					$resstr = $ipps->ipps_submit_req($urlstr,$reqstr);
					$resultlogging = $payment->insertlog($refcode,$m_email,'BE:RES',$module_name_detail,$String->utf82tis($resstr)); //Logging
					$result_array = $ipps->extractresult($resstr);  
					if ($result_array['status'] == '01') {
						print "Transfer Successfully";                  
					}
					else {
						print "Transfer Failed 5";                  
					}
                }
				else {
					print "Transfer Failed 4";  
				}			
            }
			else {
                print "Transfer Failed 3";                  
			}
		}   
		else {
                    print "Transfer Failed 2";                  
		}
	}
}
else {
     print "Transfer Failed 1";                  
       
}
?>
