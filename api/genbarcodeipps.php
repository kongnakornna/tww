<?php
include '../leone.php';
include '../admin/controller/member.php';
include '../admin/controller/payment.php';
include './IPPS/ipps.php';
include './barcode-master/includes/BarcodeBase.php';
include './barcode-master/includes/Code128.php';
header('Content-Type: application/json; charset=utf-8');
$member = new member();
$payment = new payment();
$ipps = new ipps();
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";
$param_price = (!empty($_REQUEST["price"])) ? $_REQUEST["price"] : "";
$param_posname = (!empty($_REQUEST["posname"])) ? $_REQUEST["posname"] : "";
$modulename = 'genbarcodeipps.php[IPPS]'; 
$request=$payment->loggingandroid($_REQUEST);
$refcode = $String->GenKey("12");
$resultlogging = $payment->insertlog($refcode,$param_email,'FE:REQ',$modulename,$String->utf82tis($request));
$membercode = $member->getcodefromemail($param_email);
$memberemail = $param_email;
#$memberresult = $payment->checkfirstpaymentandupdate($memberemail);

        //Sync Balance IPPS
        $m_balance_new = ceil($param_price);
        $m_balance_nodecimal = $m_balance_new * 100;
        if ($param_posname == 'COUNTER SERVICE') 
           $reqstr = $ipps->direct_topup_request_msg($membercode,$refcode,'Barcode','CS',$m_balance_new);
        else
           $reqstr = $ipps->direct_topup_request_msg($membercode,$refcode,'Barcode','PARTNER',$m_balance_new);
        #$urlstr = "https://test.payforu.com/payforuservice.svc/APIDirectTopupRequest";
        $urlstr  = "https://www.payforu.com/webservice/payforuservice.svc/APIDirectTopupRequest";
        $module_name_detail=$modulename.":direct_topup_request";
        $resultlogging = $payment->insertlog($refcode,$memberemail,'BE:REQ',$module_name_detail,$String->utf82tis($reqstr)); //Logging
        $resstr = $ipps->ipps_submit_req($urlstr,$reqstr);
        $resultlogging = $payment->insertlog($refcode,$memberemail,'BE:RES',$module_name_detail,$String->utf82tis($resstr)); //Logging
        $result_array = $ipps->extractresult($resstr);

        if ($result_array['type'] == 'Barcode' && $result_array['status'] == '01') {
            $barcodetxt = $result_array['responsedata'];
            if ($param_posname != '7/11, COUNTER SERVICE') {
            $my_string = preg_replace(array('/\n/', '/\r/'), '#PH#', $barcodetxt);
            $barcodetxt_arr = explode('#PH#', $my_string);
              if (!empty($barcodetxt_arr)) {
                        $setdata = $barcodetxt_arr[0]."".$barcodetxt_arr[1]."".$barcodetxt_arr[2]."".$barcodetxt_arr[3];
                        #$setdata_txt = $barcodetxt_arr[0]." ".$barcodetxt_arr[1]." ".$barcodetxt_arr[2]." ".$barcodetxt_arr[3];
                        $setdata_txt = "";
                        if ($param_posname == 'BIGC') {
                        $logoimg = "https://www.easycard.club/logo/".$param_posname.".png";
                        $barcodeimg = "https://www.easycard.club/photo/barcode/BIGC/".$refcode.".png";
                        $barcodetmp_file = "/tmp/".$refcode.".txt";
                        $barcodeimg_file = "/www/easycard.club/html/photo/barcode/BIGC/".$refcode.".png";
                        }
                        else if ($param_posname == 'Lotus') {
                        $logoimg = "https://www.easycard.club/logo/LOTUS.png";
                        $barcodeimg = "https://www.easycard.club/photo/barcode/LOTUS/".$refcode.".png";
                        $barcodetmp_file = "/tmp/".$refcode.".txt";
                        $barcodeimg_file = "/www/easycard.club/html/photo/barcode/LOTUS/".$refcode.".png";
                        }
                        $myfile = fopen($barcodetmp_file, "w+");
                        fwrite($myfile, $barcodetxt_arr[0]);
                        fwrite($myfile, "\r");
                        fwrite($myfile, $barcodetxt_arr[1]);
                        fwrite($myfile, "\r");
                        fwrite($myfile, $barcodetxt_arr[2]);
                        fwrite($myfile, "\r");
                        fwrite($myfile, $barcodetxt_arr[3]);
                        fclose($myfile);
                        $cmdpath = "./zint-2.4.2/frontend/genbarcode.sh";
                        $runcmd = $cmdpath." ".$barcodetmp_file." ".$barcodeimg_file;
                        $mylog=shell_exec("$runcmd 2>&1 >>/tmp/mylog.txt");
                        $dataarray = array("result"=>"OK","result_desc"=>"","name"=>$param_posname,"barcode"=>$setdata_txt,"logo"=>$logoimg,"barimg"=>$barcodeimg); 
                        /*} 
                        else {
                        $errmsg = "Cannot open the file for writing Barcode Image";
                        $dataarray = array("result"=>"FAIL","result_desc"=>$errmsg); 
                        }*/
              }
              else {
                    $dataarray = array("result"=>"FAIL","result_desc"=>"Missing some parameter"); 
              }  
           }

            else { 
                        $logoimg = "https://www.easycard.club/logo/71101.png";
                        $barcodeimg = "https://www.easycard.club/photo/barcode/71101/".$refcode.".png";
                        $barcodetmp_file = "/tmp/".$refcode.".txt";
                        $barcodeimg_file = "/www/easycard.club/html/photo/barcode/71101/".$refcode.".png";
                        $myfile = fopen($barcodetmp_file, "w+");
                        fwrite($myfile, $barcodetxt);
                        fclose($myfile);
                        $cmdpath = "./zint-2.4.2/frontend/genbarcode.sh";
                        $runcmd = $cmdpath." ".$barcodetmp_file." ".$barcodeimg_file;
                        $mylog=shell_exec("$runcmd 2>&1 >>/tmp/mylog.txt");
                        $dataarray = array("result"=>"OK","result_desc"=>"","name"=>$param_posname,"barcode"=>"","logo"=>$logoimg,"barimg"=>$barcodeimg); 
                }
           }

           else {
                 $error_mesg=$payment->geterrormesg('payforu_request_topup.php','IPPS',$result_array['status']); 
                 $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($error_mesg));
          }
$resultlogging = $payment->insertlog($refcode,$param_email,'FE:RES',$modulename,$String->utf82tis(json_encode($dataarray)));
$carddata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($carddata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
print $resultxml;

?>
