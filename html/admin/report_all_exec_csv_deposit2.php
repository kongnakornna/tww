<?php
require '../leone.php';
require './controller/app.php';
require './controller/member.php.new';
require './controller/payment.php';
require './controller/partner.php';
require './controller/wallet.php';
header('Content-Type: text/html; charset=tis-620');
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$filename = "report_all_" . date("jmYHs") . ".csv";
$member = new member();
$payment = new payment();
$partner = new partner();
$wallet = new wallet();
$app = new app();
$param_sdate = (!empty($_REQUEST["s_sdate"])) ? $_REQUEST["s_sdate"] : "";
$param_edate = (!empty($_REQUEST["s_edate"])) ? $_REQUEST["s_edate"] : "";
$param_partner = (!empty($_REQUEST["partner"])) ? $_REQUEST["partner"] : "";
$param_servicetype = (!empty($_REQUEST["service_type"])) ? $_REQUEST["service_type"] : "";
$param_postype = (!empty($_REQUEST["pos_type"])) ? $_REQUEST["pos_type"] : "";
$param_membername = (!empty($_REQUEST["member_name"])) ? $_REQUEST["member_name"] : "";
$startdate = $DT->ConvertDate($param_sdate);
$enddate = $DT->ConvertDate($param_edate);
$iColor = '#eeeeee';
$DataList = "";
$num = 0;
$dtype_array = $member->getallmemberdcode();
//error_log("my log => ".print_r($dtype_array,true)."\n",3,"/tmp/mylog.txt");
$period = $param_sdate . " ถึง " . $param_edate;
$DataList = "รายงานสรุปกระทบยอดคู่ค้า\n\n";
$DataList .= "วันที่ : ".$period."\n";
$DataList .= "วันที่,mpay เข้า,mpay ออก,mpay คงเหลือ,wop เข้า,wop ออก,wop คงเหลือ,wop บิลเข้า,wop บิลออก,wop บิลคงเหลือ,myworld ออก, IPPS เข้า,IPPS ออก,IPPS คงเหลือ, MPAY รวม,WOP เติมเงิน,WOP จ่าบยบิล,WOP รวม,Myworld รวม,IPPS รวม,EasyCard รวม,กระทบยอด MPAY,กระทบยอด WOP เติมเงิน,กระทบยอด WOP จ่ายบิล,กระทบยอด WOP รวม,กระทบยอด Myworld,กระทบยอด IPPS,กระทบยอดรวม \n";
   
$RowCheck = array();
$myfilteservice = "";
if ($param_partner != '01') {
   if ($param_partner == '02') {
	   $myfilterservice['ES9996'] = 10;
       $myfilterservice['ES9998'] = 11;   
	   $myfilterservice['ES0018'] = 11;
	   $myfilterservice['ES1023'] = 11;
	   $myfilterservice['ES1024'] = 11;
	   $myfilterservice['ES1025'] = 11;
	   $myfilterservice['ES1026'] = 11;
   }
   else if ($param_partner == '03') {
       $myfilterservice['ES1001'] = 20;
	   $myfilterservice['ES1002'] = 20;
	   $myfilterservice['ES1011'] = 21;
	   $myfilterservice['ES1012'] = 21;
       $myfilterservice['ES1013'] = 21;
	   $myfilterservice['ES1014'] = 21;
	   $myfilterservice['ES1015'] = 21;
	   $myfilterservice['ES1016'] = 21;
	   $myfilterservice['ES1017'] = 21;
	   $myfilterservice['ES1018'] = 21;
	   $myfilterservice['ES1019'] = 21;
	   $myfilterservice['ES1020'] = 21;
	   $myfilterservice['ES1021'] = 21;
	   $myfilterservice['ES1022'] = 21;
	   $myfilterservice['ES1027'] = 21;
   }
   else if ($param_partner == '04') {
	   $myfilterservice['ES1028'] = 30;
       $myfilterservice['ES1029'] = 31; 	   
   }
} 
else {
	   $myfilterservice['ES9996'] = 10;
       $myfilterservice['ES9998'] = 11;   
	   $myfilterservice['ES0018'] = 11;
	   $myfilterservice['ES1023'] = 11;
	   $myfilterservice['ES1024'] = 11;
	   $myfilterservice['ES1025'] = 11;
	   $myfilterservice['ES1026'] = 11;
	   $myfilterservice['ES1001'] = 20;
	   $myfilterservice['ES1002'] = 20;
	   $myfilterservice['ES1011'] = 21;
	   $myfilterservice['ES1012'] = 21;
       $myfilterservice['ES1013'] = 21;
	   $myfilterservice['ES1014'] = 21;
	   $myfilterservice['ES1015'] = 21;
	   $myfilterservice['ES1016'] = 21;
	   $myfilterservice['ES1017'] = 21;
	   $myfilterservice['ES1018'] = 21;
	   $myfilterservice['ES1019'] = 21;
	   $myfilterservice['ES1020'] = 21;
	   $myfilterservice['ES1021'] = 21;
	   $myfilterservice['ES1022'] = 21;
	   $myfilterservice['ES1027'] = 21;
	   $myfilterservice['ES1028'] = 30;
       $myfilterservice['ES1029'] = 31; 
}

if ($param_membername != '' ) {
$myemail = $member->getemailbyname($param_membername);
//error_log("my log => ".$param_membername."\n",3,"/tmp/mylog.txt");
//error_log("my log => ".$myemail."\n",3,"/tmp/mylog.txt");				
if ($myemail != '') {
$SqlCheck = "select p_id,p_partnercode,p_adddate,p_productid,p_email,p_detail,p_price,p_charge,p_total,p_msisdn,p_ref2 from tbl_payment where (p_adddate>='".$startdate." 00:00:00' and p_adddate<='".$enddate." 23:59:59') and p_type IN ('I') and p_status = '1' and p_reinstall NOT IN ('Y') and p_partnercode not in ('P07201500000') and p_email in ('".$myemail."') order by p_adddate,p_partnercode";
}
else {
$SqlCheck = "select p_id,p_partnercode,p_adddate,p_productid,p_email,p_detail,p_price,p_charge,p_total,p_msisdn,p_ref2 from tbl_payment where (p_adddate>='".$startdate." 00:00:00' and p_adddate<='".$enddate." 23:59:59') and p_type IN ('I') and p_status = '1' and p_reinstall NOT IN ('Y') and p_partnercode not in ('P07201500000') and p_email not in ('jgodsonline@gmail.com','bancomsci@gmail.com','inoomok@gmail.com','havemoney1@twz.com','havemoney2@twz.com','havemoney3@twz.com','nomoney@twz.com') order by p_adddate,p_partnercode";
}
}
else {
$SqlCheck = "select p_id,p_partnercode,p_adddate,p_productid,p_email,p_detail,p_price,p_charge,p_total,p_msisdn,p_ref2 from tbl_payment where (p_adddate>='".$startdate." 00:00:00' and p_adddate<='".$enddate." 23:59:59') and p_type IN ('I') and p_status = '1' and p_reinstall NOT IN ('Y') and p_partnercode not in ('P07201500000') and p_email not in ('jgodsonline@gmail.com','bancomsci@gmail.com','inoomok@gmail.com','havemoney1@twz.com','havemoney2@twz.com','havemoney3@twz.com','nomoney@twz.com') order by p_adddate,p_partnercode";
}

#$SqlCheck = "select p_id,p_partnercode,p_adddate,p_productid,p_email,p_detail,p_price,p_charge,p_total,p_msisdn from tbl_payment where p_productid in ('ES0001','ES0002','ES0003') and  (p_adddate>='".$startdate." 00:00:00' and p_adddate<='".$enddate." 59:59:59') and p_type IN ('I') and p_status = '1' and p_reinstall NOT IN ('Y') and p_partnercode not in ('P07201500000') and p_email not in ('jgodsonline@gmail.com','bancomsci@gmail.com','inoomok@gmail.com','havemoney1@twz.com','havemoney2@twz.com','havemoney3@twz.com','nomoney@twz.com') order by p_adddate desc,p_partnercode";
#$SqlCheck = "select p_id,p_partnercode,p_adddate,p_productid,p_email,p_detail,p_price,p_charge,p_total,p_msisdn,p_ref2 from tbl_payment where (p_adddate>='".$startdate." 00:00:00' and p_adddate<='".$enddate." 59:59:59') and p_type IN ('I') and p_status = '1' and p_reinstall NOT IN ('Y') and p_partnercode not in ('P07201500000') and p_email not in ('jgodsonline@gmail.com','bancomsci@gmail.com','inoomok@gmail.com','havemoney1@twz.com','havemoney2@twz.com','havemoney3@twz.com','nomoney@twz.com') order by p_adddate desc,p_partnercode";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
$mpayindx = 0;
$wopindx = 0;
$myworldindx = 0;
$ippsindx = 0;
$mpayarray = "";
$woparray = "";
$myworldarray = "";
$perdatearray = "";
if ($RowsCheck>0) {
	$grandtotal = "0";
	for ($t=0;$t<$RowsCheck;$t++) {
		 $iNum++;
		 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$t);
		 $db_code = $RowCheck['p_productid'];
		 $db_pncode = $RowCheck['p_partnercode'];
		 $db_email = $RowCheck['p_email'];
		 $db_detail = $RowCheck['p_detail'];
		 //error_log("my log =>before  ".$RowCheck['p_adddate']."\n",3,"/tmp/mylog.txt");
  	     $db_date = $DT->ShowDateTime($RowCheck['p_adddate'],'th');
		 //error_log("my log =>after ".$db_date."\n",3,"/tmp/mylog.txt");
  	    
		 $db_price = $RowCheck['p_price'];
		 $db_charge = $RowCheck['p_charge'];
		 $db_total = $RowCheck['p_total'];
         $db_msisdn = $RowCheck['p_msisdn']; 
         $db_ref2 = $RowCheck['p_ref2'];
		  
		 $custname = $member->getnamefromemail($db_email);
		 $custmobile = $member->getmobilefromemail($db_email);
		 $custcode = $member->getcodefromemail($db_email);
		 $partnername = $partner->getnamebycode($db_pncode);
		 
		 if ($myfilterservice[$db_code] == '10' || $myfilterservice[$db_code] == '11') {
			 $mpayarray[$mpayindx]['dbcode'] = $db_code;
			 $mpayarray[$mpayindx]['dbpncode'] = $db_pncode;
			 $mpayarray[$mpayindx]['dbemail'] = $db_email;
			 $mpayarray[$mpayindx]['dbdetail'] = $db_detail;
			 $mpayarray[$mpayindx]['dbdate'] = $db_date; 
			 $mpayarray[$mpayindx]['dbprice'] = $db_price;
			 $mpayarray[$mpayindx]['dbcharge'] = $db_charge; 
			 $mpayarray[$mpayindx]['dbtotal'] = $db_total;
			 $mpayarray[$mpayindx]['dbmsisdn'] = $db_msisdn;
			 $mpayarray[$mpayindx]['dbref2'] = $db_ref2;
			 $mpayarray[$mpayindx]['custname'] = $custname;
			 $mpayarray[$mpayindx]['custmobile'] = $custmobile;
			 $mpayarray[$mpayindx]['custcode'] = $custcode;
			 $mpayarray[$mpayindx]['partnername'] = $partnername; 
			 $mpayindx = $mpayindx + 1;
		}
		 
		  
		 if ($myfilterservice[$db_code] == '20' || $myfilterservice[$db_code] == '21') {
			 $woparray[$wopindx]['dbcode'] = $db_code;
			 $woparray[$wopindx]['dbpncode'] = $db_pncode;
			 $woparray[$wopindx]['dbemail'] = $db_email;
			 $woparray[$wopindx]['dbdetail'] = $db_detail;
			 $woparray[$wopindx]['dbdate'] = $db_date; 
			 $woparray[$wopindx]['dbprice'] = $db_price;
			 $woparray[$wopindx]['dbcharge'] = $db_charge; 
			 $woparray[$wopindx]['dbtotal'] = $db_total;
			 $woparray[$wopindx]['dbmsisdn'] = $db_msisdn;
			 $woparray[$wopindx]['dbref2'] = $db_ref2;
			 $woparray[$wopindx]['custname'] = $custname;
			 $woparray[$wopindx]['custmobile'] = $custmobile;
			 $woparray[$wopindx]['custcode'] = $custcode;
			 $woparray[$wopindx]['partnername'] = $partnername; 
			 $wopindx = $wopindx + 1;
		}
		 
		   
		 if ($myfilterservice[$db_code] == '30' || $myfilterservice[$db_code] == '31') {
			 $myworldarray[$myworldindx]['dbcode'] = $db_code;
			 $myworldarray[$myworldindx]['dbpncode'] = $db_pncode;
			 $myworldarray[$myworldindx]['dbemail'] = $db_email;
			 $myworldarray[$myworldindx]['dbdetail'] = $db_detail;
			 $myworldarray[$myworldindx]['dbdate'] = $db_date; 
			 $myworldarray[$myworldindx]['dbprice'] = $db_price;
			 $myworldarray[$myworldindx]['dbcharge'] = $db_charge; 
			 $myworldarray[$myworldindx]['dbtotal'] = $db_total;
			 $myworldarray[$myworldindx]['dbmsisdn'] = $db_msisdn;
			 $myworldarray[$myworldindx]['dbref2'] = $db_ref2;
			 $myworldarray[$myworldindx]['custname'] = $custname;
			 $myworldarray[$myworldindx]['custmobile'] = $custmobile;
			 $myworldarray[$myworldindx]['custcode'] = $custcode;
			 $myworldarray[$myworldindx]['partnername'] = $partnername; 
			 $myworldindx = $myworldindx + 1;
		}
	}
}       
       	 //error_log("my log =>partner  ".$param_partner."\n",3,"/tmp/mylog.txt");
		 //error_log("my log =>mpay array".print_r($mpayarray,2)."\n",3,"/tmp/mylog.txt");
  	 
  	    if ($param_partner == '01') {
			 $arraysize = sizeof($mpayarray);
			 $inum = 0;
			 $inum1 = 1;
			 $grandbill = 0;
			 $grandtransfer = 0;
			 $grandrefill = 0;
			 $grandbill1 = 0;
			 $grandtransfer1 = 0;
			 $grandrefill1 = 0;
			 $grandbill2 = 0;
			 $grandtransfer2 = 0;
			 $grandrefill2 = 0;
			 $grandbill3 = 0;
			 $grandtransfer3 = 0;
			 $grandrefill3 = 0;
			 $iColor = "#eeeeee";
                if (!empty($mpayarray)) { 		 
                while($inum < $arraysize) {
                                $db_refill_amt = 0;
                                $db_bill_amt = 0; 
                                $db_transfer_amt = 0; 
				if ($iColor=='#ffffff') {
					$iColor = "#eeeeee";
				}else{
					$iColor = "#ffffff";
				}
			    if ($mpayarray[$inum]['dbcode'] == 'ES9997' || $mpayarray[$inum]['dbcode']== 'ES9999') {
					  $db_msisdn = $mpayarray[$inum]['dbref2'];
				} 
				else {
			          $db_msisdn = $mpayarray[$inum]['dbmsisdn']; 
  			    }
				//error_log("my log => ".$mpayarray[$inum]['dbpncode']."\n",3,"/tmp/mylog.txt");
				
				
				if ($myfilterservice[$mpayarray[$inum]['dbcode']] == '10' && ($param_servicetype == '01' || $param_servicetype == '02') && (($param_postype == '01') || ($param_postype == '02' && array_key_exists($mpayarray[$inum]['dbemail'],$dtype_array)) || ($param_postype == '03' && !array_key_exists($mpayarray[$inum]['dbemail'],$dtype_array)))) {
                    //$DataList .= "<tr bgcolor=\"".$iColor."\"><td align=\"right\" class=\"tblist\">".$inum1.",".$mpayarray[$inum]['dbdate']."</td><td align=\"left\" class=\"tblist\">".$mpayarray[$inum]['custname'].",".$mpayarray[$inum]['dbemail']."</td><td align=\"left\" class=\"tblist\">".$mpayarray[$inum]['custmobile'].",MPAY</td><td align=\"left\" class=\"tblist\">".$mpayarray[$inum]['dbdetail']."</td><td align=\"left\" class=\"tblist\">".$db_msisdn.",".number_format($mpayarray[$inum]['dbtotal'],2,'.',',').",0,0,".number_format($mpayarray[$inum]['dbtotal'],2,'.',',')."</td></tr>";
                    $db_refill_amt = $mpayarray[$inum]['dbtotal'];
                    $db_bill_amt = 0; 
					$db_transfer_amt = 0;
			         $inum1 = $inum1 + 1;
				}
				else if ($myfilterservice[$mpayarray[$inum]['dbcode']]== '11'&& ($param_servicetype == '01' || $param_servicetype == '03') && (($param_postype == '01') || ($param_postype == '02' && array_key_exists($mpayarray[$inum]['dbemail'],$dtype_array)) || ($param_postype == '03' && !array_key_exists($mpayarray[$inum]['dbemail'],$dtype_array)))){
                   
				    //$DataList .= "<tr bgcolor=\"".$iColor."\"><td align=\"right\" class=\"tblist\">".$inum1.",".$mpayarray[$inum]['dbdate']."</td><td align=\"left\" class=\"tblist\">".$mpayarray[$inum]['custname'].",".$mpayarray[$inum]['dbemail']."</td><td align=\"left\" class=\"tblist\">".$mpayarray[$inum]['custmobile'].",MPAY</td><td align=\"left\" class=\"tblist\">".$mpayarray[$inum]['dbdetail']."</td><td align=\"left\" class=\"tblist\">".$db_msisdn.",0,".number_format($mpayarray[$inum]['dbtotal'],2,'.',',').",0,".number_format($mpayarray[$inum]['dbtotal'],2,'.',',')."</td></tr>";
                    $db_bill_amt = $mpayarray[$inum]['dbtotal'];
         			$db_transfer_amt = 0;		
			         $inum1 = $inum1 + 1;
				}
				 $mydate = date_create_from_format('d/m/Y H:i:s',$mpayarray[$inum]['dbdate']);
				 //error_log("my log =>after ".$mpayarray[$inum]['dbdate']."\n",3,"/tmp/mylog.txt");
  	      	     $myDateTime = date_format($mydate, 'd/m/Y');
				 //error_log("my log => ".$myDateTime."\n",3,"/tmp/mylog.txt");
				 $grandrefill1 = $grandrefill1 + $db_refill_amt;
		         $grandbill1 =   $grandbill1 + $db_bill_amt;
				 $grandtransfer1 = $grandtransfer1 + $db_transfer_amt;
		         $grandtotal1 =  $grandrefill1 + $grandbill1 + $grandtransfer1; 
				 
				 
				 $perdatetime[$myDateTime]['MPAY']['refill'] =   $perdatetime[$myDateTime]['MPAY']['refill'] + $db_refill_amt;
				 $perdatetime[$myDateTime]['MPAY']['bill'] =   $perdatetime[$myDateTime]['MPAY']['bill'] + $db_bill_amt;
				 $perdatetime[$myDateTime]['MPAY']['transfer'] = $perdatetime[$myDateTime]['MPAY']['transfer'] + $db_transfer_amt;
				 $perdatetime[$myDateTime]['MPAY']['total'] =   $perdatetime[$myDateTime]['MPAY']['refill'] +  $perdatetime[$myDateTime]['MPAY']['bill'] + $perdatetime[$myDateTime]['MPAY']['transfer'];
				 $inum = $inum + 1;
				 
				
			}
		       
				 //$DataList .= "<tr bgcolor=\"#ffffe0\"><td colspan=\"8\" align=\"right\" class=\"tblist\">ยอดรวม  (MPAY): ,<strong>".number_format($grandrefill1,2,'.',',')."</strong>,<strong>".number_format($grandbill1,2,'.',',')."</strong>,<strong>".number_format($grandtransfer1,2,'.',',')."</strong>,<strong>".number_format($grandtotal1,2,'.',',')."</strong></td></tr>";
                

			  }  
                 $arraysize = sizeof($woparray);
                 $inum = 0;
				 $inum1 = 1;
			     $iColor = "#eeeeee";
		        if (!empty($woparray)) { 
                    while($inum < $arraysize) {
                                $db_refill_amt = 0;
                                $db_bill_amt = 0; 
                                $db_transfer_amt = 0; 
			        if ($iColor=='#ffffff') {
					$iColor = "#eeeeee";
				    }else{
					$iColor = "#ffffff";
				    }
                    if ($myfilterservice[$woparray[$inum]['dbcode']] == '20' && ($param_servicetype == '01' || $param_servicetype == '02') && (($param_postype == '01') || ($param_postype == '02' && array_key_exists($woparray[$inum]['dbemail'],$dtype_array)) || ($param_postype == '03' && !array_key_exists($woparray[$inum]['dbemail'],$dtype_array)))) {
                    //$DataList .= "<tr bgcolor=\"".$iColor."\"><td align=\"right\" class=\"tblist\">".$inum1.",".$woparray[$inum]['dbdate']."</td><td align=\"left\" class=\"tblist\">".$woparray[$inum]['custname'].",".$woparray[$inum]['dbemail']."</td><td align=\"left\" class=\"tblist\">".$woparray[$inum]['custmobile'].",WOP</td><td align=\"left\" class=\"tblist\">".$woparray[$inum]['dbdetail']."</td><td align=\"left\" class=\"tblist\">".$woparray[$inum]['dbmsisdn'].",".number_format($woparray[$inum]['dbtotal'],2,'.',',').",0,0,".number_format($woparray[$inum]['dbtotal'],2,'.',',')."</td></tr>";

                    $db_refill_amt = $woparray[$inum]['dbtotal'];
                    $db_bill_amt = 0; 
					$db_transfer_amt = 0;
					$inum1 = $inum1 + 1; 
				   }
				    else if ($myfilterservice[$woparray[$inum]['dbcode']] == '21' && ($param_servicetype == '01' || $param_servicetype == '03') && (($param_postype == '01') || ($param_postype == '02' && array_key_exists($woparray[$inum]['dbemail'],$dtype_array)) || ($param_postype == '03' && !array_key_exists($woparray[$inum]['dbemail'],$dtype_array)))){
                    //$DataList .= "<tr bgcolor=\"".$iColor."\"><td align=\"right\" class=\"tblist\">".$inum1.",".$woparray[$inum]['dbdate']."</td><td align=\"left\" class=\"tblist\">".$woparray[$inum]['custname'].",".$woparray[$inum]['dbemail']."</td><td align=\"left\" class=\"tblist\">".$woparray[$inum]['custmobile'].",WOP</td><td align=\"left\" class=\"tblist\">".$woparray[$inum]['dbdetail']."</td><td align=\"left\" class=\"tblist\">".$woparray[$inum]['dbmsisdn'].",0,".number_format($woparray[$inum]['dbtotal'],2,'.',',').",0,".number_format($woparray[$inum]['dbtotal'],2,'.',',')."</td></tr>";
                    $db_refill_amt =0;
                    $db_bill_amt = $woparray[$inum]['dbtotal'];
         			$db_transfer_amt = 0;		
                    $inum1 = $inum1 + 1; 			       
				   }
				    // $myDateTime = DateTime::createFromFormat('d/m/Y',$mpayarray[$inum]['dbdate'])."WOP";
  				    $grandrefill2 = $grandrefill2 + $db_refill_amt;
		            $grandbill2 =   $grandbill2 + $db_bill_amt;
				    $grandtransfer2 = $grandtransfer2 + $db_transfer_amt;
		            $grandtotal2 =  $grandrefill2 + $grandbill2 + $grandtransfer2; 
				   
						 $mydate = date_create_from_format('d/m/Y H:i:s',$woparray[$inum]['dbdate']);
			            // $mydate = date_create($woparray[$inum]['dbdate']);
				 $myDateTime = date_format($mydate, 'd/m/Y');
				 //error_log("my log => ".$myDateTime."\n",3,"/tmp/mylog.txt");
			
				 $perdatetime[$myDateTime]['WOP']['refill'] =   $perdatetime[$myDateTime]['WOP']['refill'] + $db_refill_amt;
				 $perdatetime[$myDateTime]['WOP']['bill'] =   $perdatetime[$myDateTime]['WOP']['bill'] + $db_bill_amt;
				 $perdatetime[$myDateTime]['WOP']['transfer'] = $perdatetime[$myDateTime]['WOP']['transfer'] + $db_transfer_amt;
				 $perdatetime[$myDateTime]['WOP']['total'] =   $perdatetime[$myDateTime]['WOP']['refill'] +  $perdatetime[$myDateTime]['WOP']['bill'] + $perdatetime[$myDateTime]['WOP']['transfer'];
			         $inum = $inum + 1; 
                 }
		       
 			     //$DataList .= "<tr bgcolor=\"#ffffe0\"><td colspan=\"8\" align=\"right\" class=\"tblist\">ยอดรวม  (WOP): ,".number_format($grandrefill2,2,'.',',').",".number_format($grandbill2,2,'.',',').",<strong>".number_format($grandtransfer2,2,'.',',')."</strong>,<strong>".number_format($grandtotal2,2,'.',',')."</strong></td></tr>";
   		 }
                  $arraysize = sizeof($myworldarray);
                 //echo $arraysize;
				 $inum = 0;
				 $inum1 = 1;
			     $iColor = "#eeeeee";
                            if (!empty($myworldarray)) {	
			     while($inum < $arraysize) {
                                $db_refill_amt = 0;
                                $db_bill_amt = 0; 
                                $db_transfer_amt = 0; 
			        if ($iColor=='#ffffff') {
					$iColor = "#eeeeee";
				    }else{
					$iColor = "#ffffff";
				    }
                    if ($myfilterservice[$myworldarray[$inum]['dbcode']] == '30' && ($param_servicetype == '01' || $param_servicetype == '02') && (($param_postype == '01') || ($param_postype == '02' && array_key_exists($myworldarray[$inum]['dbemail'],$dtype_array)) || ($param_postype == '03' && !array_key_exists($myworldarray[$inum]['dbemail'],$dtype_array)))) {
                    //$DataList .= "<tr bgcolor=\"".$iColor."\"><td align=\"right\" class=\"tblist\">".$iNum1.",".$myworldarray[$inum]['dbdate']."</td><td align=\"left\" class=\"tblist\">".$myworldarray[$inum]['custname'].",".$myworldarray[$inum]['dbemail']."</td><td align=\"left\" class=\"tblist\">".$myworldarray[$inum]['custmobile'].",Myworld</td><td align=\"left\" class=\"tblist\">".$myworldarray[$inum]['$dbdetail']."</td><td align=\"left\" class=\"tblist\">".$myworldarray[$inum]['dbmsisdn'].",".number_format($myworldarray[$inum]['$dbtotal'],2,'.',',').",0,0,".number_format($myworldarray[$inum]['dbtotal'],2,'.',',')."</td></tr>";
                    $db_refill_amt = $myworldarray[$inum]['dbtotal'];
                    $db_bill_amt = 0; 
					$db_transfer_amt = 0;
			         $inum1 = $inum1+ 1; 
					}
				    else if ($myfilterservice[$myworldarray[$inum]['dbcode']] == '31' && ($param_servicetype == '01' || $param_servicetype == '03') && (($param_postype == '01') || ($param_postype == '02' && array_key_exists($myworldarray[$inum]['dbemail'],$dtype_array)) || ($param_postype == '03' && !array_key_exists($myworldarray[$inum]['dbemail'],$dtype_array)))){
                    //$DataList .= "<tr bgcolor=\"".$iColor."\"><td align=\"right\" class=\"tblist\">".$inum1.",".$myworldarray[$inum]['dbdate']."</td><td align=\"left\" class=\"tblist\">".$myworldarray[$inum]['custname'].",".$myworldarray[$inum]['dbemail']."</td><td align=\"left\" class=\"tblist\">".$myworldarray[$inum]['custmobile'].",Myworld</td><td align=\"left\" class=\"tblist\">".$myworldarray[$inum]['dbdetail']."</td><td align=\"left\" class=\"tblist\">".$myworldarray[$inum]['dbmsisdn'].",0,".number_format($myworldarray[$inum]['dbtotal'],2,'.',',').",0,".number_format($myworldarray[$inum]['dbtotal'],2,'.',',')."</td></tr>";
                    $db_refill_amt =0;
                    $db_bill_amt = $myworldarray[$inum]['dbtotal'];
         			$db_transfer_amt = 0;		
			         $inum1 = $inum1+ 1; 
					}
				    $grandrefill3= $grandrefill3 + $db_refill_amt;
		            $grandbill3 =   $grandbill3 + $db_bill_amt;
				    $grandtransfer3 = $grandtransfer3 + $db_transfer_amt;
		            $grandtotal3 =  $grandrefill3 + $grandbill3 + $grandtransfer3; 
				
				    
				    $mydate = date_create_from_format('d/m/Y H:i:s',$myworldarray[$inum]['dbdate']);
			        //$mydate = date_create($myworldarray[$inum]['dbdate']);
				    $myDateTime = date_format($mydate, 'd/m/Y');
				    //error_log("my log => ".$myDateTime."\n",3,"/tmp/mylog.txt");
			
				 $perdatetime[$myDateTime]['myworld']['refill'] =   $perdatetime[$myDateTime]['myworld']['refill'] + $db_refill_amt;
				 $perdatetime[$myDateTime]['myworld']['bill'] =   $perdatetime[$myDateTime]['myworld']['bill'] + $db_bill_amt;
				 $perdatetime[$myDateTime]['myworld']['transfer'] = $perdatetime[$myDateTime]['myworld']['transfer'] + $db_transfer_amt;
				 $perdatetime[$myDateTime]['myworld']['total'] =   $perdatetime[$myDateTime]['myworld']['refill'] +  $perdatetime[$myDateTime]['myworld']['bill'] + $perdatetime[$myDateTime]['myworld']['transfer'];
                    $inum = $inum + 1;   
				 }
				  
                 }
                 //$DataList .= "<tr bgcolor=\"#ffffe0\"><td colspan=\"8\" align=\"right\" class=\"tblist\">ยอดรวม  (Myworld): ,".number_format($grandrefill3,2,'.',',').",".number_format($grandbill3,2,'.',',').",<strong>".number_format($grandtransfer3,2,'.',',')."</strong>,<strong>".number_format($grandtotal,2,'.',',')."</strong></td></tr>";
                 
                 $grandrefill = $grandrefill1 + $grandrefill2 + $grandrefill3;
				 $grandbill = $grandbill1 + $grandbill2 + $grandbill3;
				 $grandtransfer = $grandtransfer1 + $grandtransfer2 + $grandtransfer3;
				 $grandtotal = $grandrefill + $grandbill + $grandtransfer;
				 //$DataList .= "<tr bgcolor=\"#ffffff\"><td colspan=\"8\" align=\"right\" class=\"tblist\">ยอดรวม  (ทั้งหมด): ,".number_format($grandrefill,2,'.',',').",".number_format($grandbill,2,'.',',').",<strong>".number_format($grandtransfer,2,'.',',')."</strong>,<strong>".number_format($grandtotal,2,'.',',')."</strong></td></tr>";
			     //$inum = $inum + 1;
		         //error_log("my log => ".print_r($perdatetime,2)."\n",3,"/tmp/mylog.txt");
		
		}
        else if ($param_partner == '02') {
			 $arraysize = sizeof($mpayarray);
			 $inum = 0;
			 $inum1 = 1;
			 $grandbill = 0;
			 $grandtransfer = 0;
			 $grandrefill = 0;
			 $grandbill1 = 0;
			 $grandtransfer1 = 0;
			 $grandrefill1 = 0;
			 $grandbill2 = 0;
			 $grandtransfer2 = 0;
			 $grandrefill2 = 0;
			 $grandbill3 = 0;
			 $grandtransfer3 = 0;
			 $grandrefill3 = 0;
			 $iColor = "#eeeeee";
                if (!empty($mpayarray)) { 		 
                while($inum < $arraysize) {
                                $db_refill_amt = 0;
                                $db_bill_amt = 0; 
                                $db_transfer_amt = 0; 
				if ($iColor=='#ffffff') {
					$iColor = "#eeeeee";
				}else{
					$iColor = "#ffffff";
				}
			    if ($mpayarray[$inum]['dbcode'] == 'ES9997' || $mpayarray[$inum]['dbcode']== 'ES9999') {
					  $db_msisdn = $mpayarray[$inum]['dbref2'];
				} 
				else {
			          $db_msisdn = $mpayarray[$inum]['dbmsisdn']; 
  			    }
				
				if ($myfilterservice[$mpayarray[$inum]['dbcode']] == '10' && ($param_servicetype == '01' || $param_servicetype == '02') && (($param_postype == '01') || ($param_postype == '02' && array_key_exists($mpayarray[$inum]['dbemail'],$dtype_array)) || ($param_postype == '03' && !array_key_exists($mpayarray[$inum]['dbemail'],$dtype_array)))) {
                    //$DataList .= "<tr bgcolor=\"".$iColor."\"><td align=\"right\" class=\"tblist\">".$inum1.",".$mpayarray[$inum]['dbdate']."</td><td align=\"left\" class=\"tblist\">".$mpayarray[$inum]['custname'].",".$mpayarray[$inum]['dbemail']."</td><td align=\"left\" class=\"tblist\">".$mpayarray[$inum]['custmobile'].",MPAY</td><td align=\"left\" class=\"tblist\">".$mpayarray[$inum]['dbdetail']."</td><td align=\"left\" class=\"tblist\">".$db_msisdn.",".number_format($mpayarray[$inum]['dbtotal'],2,'.',',').",0,0,".number_format($mpayarray[$inum]['dbtotal'],2,'.',',')."</td></tr>";
                    $db_refill_amt = $mpayarray[$inum]['dbtotal'];
                    $db_bill_amt = 0; 
					$db_transfer_amt = 0;
			         $inum1 = $inum1 + 1;
				}
				else if ($myfilterservice[$mpayarray[$inum]['dbcode']]== '11' && ($param_servicetype == '01' || $param_servicetype == '03')&& (($param_postype == '01') || ($param_postype == '02' && array_key_exists($mpayarray[$inum]['dbemail'],$dtype_array)) || ($param_postype == '03' && !array_key_exists($mpayarray[$inum]['dbemail'],$dtype_array)))){
                   
				    //$DataList .= "<tr bgcolor=\"".$iColor."\"><td align=\"right\" class=\"tblist\">".$inum1.",".$mpayarray[$inum]['dbdate']."</td><td align=\"left\" class=\"tblist\">".$mpayarray[$inum]['custname'].",".$mpayarray[$inum]['dbemail']."</td><td align=\"left\" class=\"tblist\">".$mpayarray[$inum]['custmobile'].",MPAY</td><td align=\"left\" class=\"tblist\">".$mpayarray[$inum]['dbdetail']."</td><td align=\"left\" class=\"tblist\">".$db_msisdn.",0,".number_format($mpayarray[$inum]['dbtotal'],2,'.',',').",0,".number_format($mpayarray[$inum]['dbtotal'],2,'.',',')."</td></tr>";
                    $db_bill_amt = $mpayarray[$inum]['dbtotal'];
         			$db_transfer_amt = 0;		
                     $inum1 = $inum1 + 1;			   
			   }
				
				
				 $grandrefill1 = $grandrefill1 + $db_refill_amt;
		         $grandbill1 =   $grandbill1 + $db_bill_amt;
				 $grandtransfer1 = $grandtransfer1 + $db_transfer_amt;
		         $grandtotal1 =  $grandrefill1 + $grandbill1 + $grandtransfer1; 
				
				 
				 $mydate = date_create_from_format('d/m/Y H:i:s',$mpayarray[$inum]['dbdate']);
				 $myDateTime = date_format($mydate, 'd/m/Y');
				 //error_log("my log => ".$myDateTime."\n",3,"/tmp/mylog.txt");
				 $grandrefill1 = $grandrefill1 + $db_refill_amt;
		         $grandbill1 =   $grandbill1 + $db_bill_amt;
				 $grandtransfer1 = $grandtransfer1 + $db_transfer_amt;
		         $grandtotal1 =  $grandrefill1 + $grandbill1 + $grandtransfer1; 
				 
				 
				 $perdatetime[$myDateTime]['MPAY']['refill'] =   $perdatetime[$myDateTime]['MPAY']['refill'] + $db_refill_amt;
				 $perdatetime[$myDateTime]['MPAY']['bill'] =   $perdatetime[$myDateTime]['MPAY']['bill'] + $db_bill_amt;
				 $perdatetime[$myDateTime]['MPAY']['transfer'] = $perdatetime[$myDateTime]['MPAY']['transfer'] + $db_transfer_amt;
				 $perdatetime[$myDateTime]['MPAY']['total'] =   $perdatetime[$myDateTime]['MPAY']['refill'] +  $perdatetime[$myDateTime]['MPAY']['bill'] + $perdatetime[$myDateTime]['MPAY']['transfer'];
				 $inum = $inum + 1;
				
			}
		         //error_log("my log => ".print_r($perdatetime,2)."\n",3,"/tmp/mylog.txt");
				 //$DataList .= "<tr bgcolor=\"#ffffe0\"><td colspan=\"8\" align=\"right\" class=\"tblist\">ยอดรวม  (MPAY): ,<strong>".number_format($grandrefill1,2,'.',',')."</strong>,<strong>".number_format($grandbill1,2,'.',',')."</strong>,<strong>".number_format($grandtransfer1,2,'.',',')."</strong>,<strong>".number_format($grandtotal1,2,'.',',')."</strong></td></tr>";
   		    }  
		} 
         else if ($param_partner == '03') {
	                 $DataList = "";	
   	                 $arraysize = sizeof($woparray);
			 //echo ($arraysize);
			 $inum = 0;
			 $inum1 = 1;
			 $grandbill = 0;
			 $grandtransfer = 0;
			 $grandrefill = 0;
			 $grandbill1 = 0;
			 $grandtransfer1 = 0;
			 $grandrefill1 = 0;
			 $grandbill2 = 0;
			 $grandtransfer2 = 0;
			 $grandrefill2 = 0;
			 $grandbill3 = 0;
			 $grandtransfer3 = 0;
			 $grandrefill3 = 0;
			 $iColor = "#eeeeee"; 
			  if (!empty($woparray)) { 
                    while($inum < $arraysize) {
                                $db_refill_amt = 0;
                                $db_bill_amt = 0; 
                                $db_transfer_amt = 0; 
			        if ($iColor=='#ffffff') {
					$iColor = "#eeeeee";
				    }else{
					$iColor = "#ffffff";
				    }
                    //error_log("my log => ".print_r($woparray[$inum],true)."\n",3,"/tmp/mylog.txt");
					if ($myfilterservice[$woparray[$inum]['dbcode']] == '20' && ($param_servicetype == '01' || $param_servicetype == '02') && (($param_postype == '01') || ($param_postype == '02' && array_key_exists($woparray[$inum]['dbemail'],$dtype_array)) || ($param_postype == '03' && !array_key_exists($woparray[$inum]['dbemail'],$dtype_array)))) {
                    //$DataList .= "<tr bgcolor=\"".$iColor."\"><td align=\"right\" class=\"tblist\">".$inum1.",".$woparray[$inum]['dbdate']."</td><td align=\"left\" class=\"tblist\">".$woparray[$inum]['custname'].",".$woparray[$inum]['dbemail']."</td><td align=\"left\" class=\"tblist\">".$woparray[$inum]['dbmsisdn'].",WOP</td><td align=\"left\" class=\"tblist\">".$woparray[$inum]['dbdetail']."</td><td align=\"left\" class=\"tblist\">".$woparray[$inum]['custmobile'].",".number_format($woparray[$inum]['dbtotal'],2,'.',',').",0,0,".number_format($woparray[$inum]['dbtotal'],2,'.',',')."</td></tr>";
                    $db_refill_amt = $woparray[$inum]['dbtotal'];
                    $db_bill_amt = 0; 
					$db_transfer_amt = 0;
			        $inum1 = $inum1 + 1; 
					}
				    else if ($myfilterservice[$woparray[$inum]['dbcode']] == '21' && ($param_servicetype == '01' || $param_servicetype == '03') && (($param_postype == '01') || ($param_postype == '02' && array_key_exists($woparray[$inum]['dbemail'],$dtype_array)) || ($param_postype == '03' && !array_key_exists($woparray[$inum]['dbemail'],$dtype_array)))){
                    //$DataList .= "<tr bgcolor=\"".$iColor."\"><td align=\"right\" class=\"tblist\">".$inum1.",".$woparray[$inum]['dbdate']."</td><td align=\"left\" class=\"tblist\">".$woparray[$inum]['custname'].",".$woparray[$inum]['dbemail']."</td><td align=\"left\" class=\"tblist\">".$woparray[$inum]['dbmsisdn'].",WOP</td><td align=\"left\" class=\"tblist\">".$woparray[$inum]['dbdetail']."</td><td align=\"left\" class=\"tblist\">".$woparray[$inum]['custmobile'].",0,".number_format($woparray[$inum]['dbtotal'],2,'.',',').",0,".number_format($woparray[$inum]['dbtotal'],2,'.',',')."</td></tr>";
                    $db_refill_amt =0;
                    $db_bill_amt = $woparray[$inum]['dbtotal'];
         			$db_transfer_amt = 0;		
			        $inum1 = $inum1 + 1; 
					}
				    $grandrefill2 = $grandrefill2 + $db_refill_amt;
		            $grandbill2 =   $grandbill2 + $db_bill_amt;
				    $grandtransfer2 = $grandtransfer2 + $db_transfer_amt;
		            $grandtotal2 =  $grandrefill2 + $grandbill2 + $grandtransfer2; 
				  
				   
					 
						 $mydate = date_create_from_format('d/m/Y H:i:s',$woparray[$inum]['dbdate']);
			   	 $myDateTime = date_format($mydate, 'd/m/Y');
				 //error_log("my log => ".$myDateTime."\n",3,"/tmp/mylog.txt");
			
				 $perdatetime[$myDateTime]['WOP']['refill'] =   $perdatetime[$myDateTime]['WOP']['refill'] + $db_refill_amt;
				 $perdatetime[$myDateTime]['WOP']['bill'] =   $perdatetime[$myDateTime]['WOP']['bill'] + $db_bill_amt;
				 $perdatetime[$myDateTime]['WOP']['transfer'] = $perdatetime[$myDateTime]['WOP']['transfer'] + $db_transfer_amt;
				 $perdatetime[$myDateTime]['WOP']['total'] =   $perdatetime[$myDateTime]['WOP']['refill'] +  $perdatetime[$myDateTime]['WOP']['bill'] + $perdatetime[$myDateTime]['WOP']['transfer'];
			           $inum = $inum + 1; 
                   
                 }
		          //error_log("my log => ".print_r($perdatetime,2)."\n",3,"/tmp/mylog.txt");
			      //$DataList .= "<tr bgcolor=\"#ffffe0\"><td colspan=\"8\" align=\"right\" class=\"tblist\">ยอดรวม  (WOP): ,".number_format($grandrefill2,2,'.',',').",".number_format($grandbill2,2,'.',',').",<strong>".number_format($grandtransfer2,2,'.',',')."</strong>,<strong>".number_format($grandtotal2,2,'.',',')."</strong></td></tr>";
			  }
		 }
		  else if ($param_partner == '04') {
			       $DataList = "";	
   	                 $arraysize = sizeof($myworldarray);
			 //echo ($arraysize);
			 $inum = 0;
			 $inum1 = 1;
			 $grandbill = 0;
			 $grandtransfer = 0;
			 $grandrefill = 0;
			 $grandbill1 = 0;
			 $grandtransfer1 = 0;
			 $grandrefill1 = 0;
			 $grandbill2 = 0;
			 $grandtransfer2 = 0;
			 $grandrefill2 = 0;
			 $grandbill3 = 0;
			 $grandtransfer3 = 0;
			 $grandrefill3 = 0;
			 $iColor = "#eeeeee"; 
			  if (!empty($myworldarray)) { 
                    while($inum < $arraysize) {
                                $db_refill_amt = 0;
                                $db_bill_amt = 0; 
                                $db_transfer_amt = 0; 
			        if ($iColor=='#ffffff') {
					$iColor = "#eeeeee";
				    }else{
					$iColor = "#ffffff";
				    }
			   if ($myfilterservice[$myworldarray[$inum]['dbcode']] == '30' && ($param_servicetype == '01' || $param_servicetype == '02') && (($param_postype == '01') || ($param_postype == '02' && array_key_exists($myworldarray[$inum]['dbemail'],$dtype_array)) || ($param_postype == '03' && !array_key_exists($myworldarray[$inum]['dbemail'],$dtype_array)))) {
                    //$DataList .= "<tr bgcolor=\"".$iColor."\"><td align=\"right\" class=\"tblist\">".$iNum1.",".$myworldarray[$inum]['dbdate']."</td><td align=\"left\" class=\"tblist\">".$myworldarray[$inum]['custname'].",".$myworldarray[$inum]['dbemail']."</td><td align=\"left\" class=\"tblist\">".$myworldarray[$inum]['dbmsisdn'].",Myworld</td><td align=\"left\" class=\"tblist\">".$myworldarray[$inum]['$dbdetail']."</td><td align=\"left\" class=\"tblist\">".$myworldarray[$inum]['custmobile'].",".number_format($myworldarray[$inum]['$dbtotal'],2,'.',',').",0,0,".number_format($myworldarray[$inum]['dbtotal'],2,'.',',')."</td></tr>";
                    $db_refill_amt = $myworldarray[$inum]['dbtotal'];
                    $db_bill_amt = 0; 
					$db_transfer_amt = 0;
			            $inum1 = $inum1+ 1; 
					}
				    else if ($myfilterservice[$myworldarray[$inum]['dbcode']] == '31'&& ($param_servicetype == '01' || $param_servicetype == '03') && (($param_postype == '01') || ($param_postype == '02' && array_key_exists($myworldarray[$inum]['dbemail'],$dtype_array)) || ($param_postype == '03' && !array_key_exists($myworldarray[$inum]['dbemail'],$dtype_array)))){
                    //$DataList .= "<tr bgcolor=\"".$iColor."\"><td align=\"right\" class=\"tblist\">".$inum1.",".$myworldarray[$inum]['dbdate']."</td><td align=\"left\" class=\"tblist\">".$myworldarray[$inum]['custname'].",".$myworldarray[$inum]['dbemail']."</td><td align=\"left\" class=\"tblist\">".$myworldarray[$inum]['dbmsisdn'].",Myworld</td><td align=\"left\" class=\"tblist\">".$myworldarray[$inum]['dbdetail']."</td><td align=\"left\" class=\"tblist\">".$myworldarray[$inum]['custmobile'].",0,".number_format($myworldarray[$inum]['dbtotal'],2,'.',',').",0,".number_format($myworldarray[$inum]['dbtotal'],2,'.',',')."</td></tr>";
                    $db_refill_amt =0;
                    $db_bill_amt = $myworldarray[$inum]['dbtotal'];
         			$db_transfer_amt = 0;		
			            $inum1 = $inum1+ 1; 
					}
				    $grandrefill3= $grandrefill3 + $db_refill_amt;
		            $grandbill3 =   $grandbill3 + $db_bill_amt;
				    $grandtransfer3 = $grandtransfer3 + $db_transfer_amt;
		            $grandtotal3 =  $grandrefill3 + $grandbill3 + $grandtransfer3; 
				
				
				  
						 $mydate = date_create_from_format('d/m/Y H:i:s',$myworldarray[$inum]['dbdate']);
			              $myDateTime = date_format($mydate, 'd/m/Y');
				    //error_log("my log => ".$myDateTime."\n",3,"/tmp/mylog.txt");
			
				    $perdatetime[$myDateTime]['myworld']['refill'] =   $perdatetime[$myDateTime]['myworld']['refill'] + $db_refill_amt;
				    $perdatetime[$myDateTime]['myworld']['bill'] =   $perdatetime[$myDateTime]['myworld']['bill'] + $db_bill_amt;
				    $perdatetime[$myDateTime]['myworld']['transfer'] = $perdatetime[$myDateTime]['myworld']['transfer'] + $db_transfer_amt;
				    $perdatetime[$myDateTime]['myworld']['total'] =   $perdatetime[$myDateTime]['myworld']['refill'] +  $perdatetime[$myDateTime]['myworld']['bill'] + $perdatetime[$myDateTime]['myworld']['transfer'];
                    $inum = $inum + 1;   
					
                    }
					//error_log("my log => ".print_r($perdatetime,2)."\n",3,"/tmp/mylog.txt");
			        //$DataList .= "<tr bgcolor=\"#ffffe0\"><td colspan=\"8\" align=\"right\" class=\"tblist\">ยอดรวม  (Myworld): ,".number_format($grandrefill3,2,'.',',').",".number_format($grandbill3,2,'.',',').",<strong>".number_format($grandtransfer3,2,'.',',')."</strong>,<strong>".number_format($grandtotal3,2,'.',',')."</strong></td></tr>";
                 }
			  
		 }	  
unset($RowCheck);

//$DataList="";
$inum1 = 1;
foreach($perdatetime as $mydate => $postype)
{
    if ($iColor=='#ffffff') {
		$iColor = "#eeeeee";
	}else{
		$iColor = "#ffffff";
	}
    $splitdate = explode("/",$mydate);
	//error_log("my log => ".$mydate."\n",3,"/tmp/mylog.txt");
	
	$newdate = ($splitdate[2]-543)."-".$splitdate[1]."-".$splitdate[0];
	$newdatetxt = ($splitdate[2]-543).$splitdate[1].$splitdate[0];
	//error_log("my log => ".$newdate."\n",3,"/tmp/mylog.txt");
	$prevdate = date ("Ymd", strtotime("-1 day", strtotime($newdate)));
	//error_log("my log => ".$prevdate."\n",3,"/tmp/mylog.txt");
	$totdepwop = 0;
	$mpaydelta = 0;
	$dtacdelta = 0;
	$truedelta = 0;
	$billdeta = 0;
	$topwalletwop = 0;
	$myworldelta = 0;
	
	$currwallet_mpay = ($wallet->checkwallet($newdatetxt,"01"));
	if ($currwallet_mpay == -1)
	    $currwallet_mpay = 0;
	$currwallet_dtac = ($wallet->checkwallet($newdatetxt,"02"));
	if ($currwallet_dtac == -1)
	    $currwallet_dtac = 0;	
	$currwallet_true = ($wallet->checkwallet($newdatetxt,"03"));
	if ($currwallet_true == -1)
	    $currwallet_true = 0;
	$currwallet_bill = ($wallet->checkwallet($newdatetxt,"04"));
	if ($currwallet_bill == -1)
	    $currwallet_bill = 0;		
	$currwallet_myworld = ($wallet->checkwallet($newdatetxt,"05"));
	if ($currwallet_myworld == -1)
	    $currwallet_myworld = 0;
	$currwallet_ipps = ($wallet->checkwallet($newdatetxt,"06"));
	if ($currwallet_ipps == -1)
	    $currwallet_ipps = 0;

    $prevwallet_mpay = ($wallet->checkwallet($prevdate,"01"));
	if ($prevwallet_mpay == -1)
	    $prevwallet_mpay = 0;
	$prevwallet_dtac = ($wallet->checkwallet($prevdate,"02"));
	if ($prevwallet_dtac == -1)
	    $prevwallet_dtac = 0;	
	$prevwallet_true = ($wallet->checkwallet($prevdate,"03"));
	if ($prevwallet_true == -1)
	    $prevwallet_true = 0;
	$prevwallet_bill = ($wallet->checkwallet($prevdate,"04"));
	if ($prevwallet_bill == -1)
	    $prevwallet_bill = 0;		
	$prevwallet_myworld = ($wallet->checkwallet($prevdate,"05"));
	if ($prevwallet_myworld == -1)
	    $prevwallet_myworld = 0;
	$prevwallet_ipps = ($wallet->checkwallet($prevdate,"06"));
	if ($prevwallet_ipps == -1)
	    $prevwallet_ipps = 0;
		
        $currdeposit_mpay = ($wallet->checkdeposit($newdatetxt,"01"));
        $currdeposit_dtac = ($wallet->checkdeposit($newdatetxt,"02"));
        #$currdeposit_true = ($wallet->checkdeposit($newdatetxt,"03"));
        $currdeposit_true = 0;
        $currdeposit_bill = ($wallet->checkdeposit($newdatetxt,"04"));
        $currdeposit_myworld = ($wallet->checkdeposit($newdatetxt,"05"));
        $currdeposit_ipps = ($wallet->checkdeposit($newdatetxt,"06"));


		
	$mpaydelta =  $prevwallet_mpay-$currwallet_mpay+$currdeposit_mpay;
	$dtacdelta =  $prevwallet_dtac-$currwallet_dtac+$currdeposit_dtac;
	$truedelta =  $prevwallet_true-$currwallet_true+$currdeposit_true;
	$billdelta =  $prevwallet_bill-$currwallet_bill+$currdeposit_bill;
	//$myworlddelta = $prevwallet_myworld-$currwallet_myworld+$currdeposit_myworld;
	$myworlddelta = 0;
	$ippsdelta = $prevwallet_ipps-$currwallet_ipps+$currdeposit_ipps;
	
	
	$totdepwop = $currdeposit_dtac+$currdeposit_true;
	$totwalletwop = $currwallet_dtac+$currwallet_true;
	$wopdelta = $dtacdelta + $truedelta;
	$easycard_total = 0;
	$wop_total = 0;
	$mpay_diff = 0;
	
	$mpay_total = $perdatetime[$mydate]['MPAY']['refill']+$perdatetime[$mydate]['MPAY']['bill'];
	$woprefill_total = $perdatetime[$mydate]['WOP']['refill'];
	$wopbill_total = $perdatetime[$mydate]['WOP']['bill'];
	$wop_total = $woprefill_total + $wopbill_total; 
	$myworld_total = $perdatetime[$mydate]['myworld']['refill']+$perdatetime[$mydate]['myworld']['bill'];
	$ipps_total = $perdatetime[$mydate]['ipps']['transfer']+$perdatetime[$mydate]['ipps']['refill'];
	$easycard_total = $mpay_total + $wop_total + $myworld_total + $ipps_total;
	
	$mpay_diff = round($mpay_total,2) - round($mpaydelta,2);
	$woprefill_diff =  round($woprefill_total,2) - round($wopdelta,2);
	$wopbill_diff = round($wopbill_total,2) - round($billdelta,2);
	$woptotal_diff = $woprefill_diff + $wopbill_diff;
	//$myworld_diff = round($myworld_total,2) - round($myworldelta,2);
    $myword_diff = 0; 
	$ipps_diff = round($ipps_total,2) - round($ippsdelta,2);
	$total_diff = round($easycard_total,2) - round(( $mpaydelta +  $wopdelta + $billdelta + $myworld_total + $ippsdelta),2);
	/*
	error_log("my log report=> ".($wallet->checkdeposit($newdatetxt,"01"))."\n",3,"/tmp/mylog.txt");
	error_log("my log report=> ".($wallet->checkwallet($newdatetxt,"01"))."\n",3,"/tmp/mylog.txt");
	
	error_log("my log report=> ".($wallet->checkdeposit($newdatetxt,"02"))."\n",3,"/tmp/mylog.txt");
	error_log("my log report=> ".($wallet->checkwallet($newdatetxt,"02"))."\n",3,"/tmp/mylog.txt");
	
	error_log("my log report=> ".($wallet->checkdeposit($newdatetxt,"03"))."\n",3,"/tmp/mylog.txt");
	error_log("my log report=> ".($wallet->checkwallet($newdatetxt,"03"))."\n",3,"/tmp/mylog.txt");
	
	error_log("my log report=> ".($wallet->checkdeposit($newdatetxt,"04"))."\n",3,"/tmp/mylog.txt");
	error_log("my log report=> ".($wallet->checkwallet($newdatetxt,"04"))."\n",3,"/tmp/mylog.txt");
	
	error_log("my log report=> ".($wallet->checkdeposit($newdatetxt,"05"))."\n",3,"/tmp/mylog.txt");
	error_log("my log report=> ".($wallet->checkwallet($newdatetxt,"05"))."\n",3,"/tmp/mylog.txt");
	
	
	error_log("my log 1=> ".$mpaydelta."\n",3,"/tmp/mylog.txt");
	error_log("my log 2=> ".$dtacdelta."\n",3,"/tmp/mylog.txt");
	error_log("my log 3=> ".$truedelta."\n",3,"/tmp/mylog.txt");
	error_log("my log 4=> ".$totdepwop."\n",3,"/tmp/mylog.txt");
	error_log("my log 5=> ".$totwalletwop."\n",3,"/tmp/mylog.txt");
	
	
	
	error_log("my log report=> ".$perdatetime[$mydate]['MPAY']['refill']."\n",3,"/tmp/mylog.txt");
	error_log("my log report=> ".$perdatetime[$mydate]['MPAY']['bill']."\n",3,"/tmp/mylog.txt");
	*/
	
	
    $DataList .=  $newdate;
	$DataList .=  ",".$currdeposit_mpay;
	$DataList .=  ",".$mpaydelta;
	$DataList .=  ",".$currwallet_mpay;
	$DataList .=  ",".$totdepwop;
    $DataList .=  ",".$wopdelta;
	$DataList .=  ",".$totwalletwop;
	$DataList .=  ",".$currdeposit_bill;
	$DataList .=  ",".$billdelta;
	$DataList .=  ",".$currwallet_bill;
	$DataList .=  ",".$myworld_total;
	$DataList .=  ",".$currdeposit_ipps;
	$DataList .=  ",".$ippsdelta;
    $DataList .=  ",".$currwallet_ipps;
	$DataList .=  ",".$mpay_total;
	$DataList .=  ",".$woprefill_total;
	$DataList .=  ",".$wopbill_total;
	$DataList .=  ",".$wop_total;
	$DataList .=  ",".$myworld_total;
	$DataList .=  ",".$ipps_total;
	$DataList .=  ",".$easycard_total;
	$DataList .=  ",".$mpay_diff;
	$DataList .=  ",".$woprefill_diff;
	$DataList .=  ",".$wopbill_diff;
	$DataList .=  ",".$woptotal_diff;
	$DataList .=  ",".$myworld_diff;
	$DataList .=  ",".$ipps_diff;
	$DataList .=  ",".$total_diff."\n";
	
	//$DataList .= "<tr bgcolor=\"".$iColor."\"><td align=\"right\" class=\"tblist\">".$inum1.",".$myworldarray[$inum]['dbdate']."</td><td align=\"left\" class=\"tblist\">".$myworldarray[$inum]['custname'].",".$myworldarray[$inum]['dbemail']."</td><td align=\"left\" class=\"tblist\">".$myworldarray[$inum]['dbmsisdn'].",Myworld</td><td align=\"left\" class=\"tblist\">".$myworldarray[$inum]['dbdetail']."</td><td align=\"left\" class=\"tblist\">".$myworldarray[$inum]['custmobile'].",0,".number_format($myworldarray[$inum]['dbtotal'],2,'.',',').",0,".number_format($myworldarray[$inum]['dbtotal'],2,'.',',')."</td></tr>";
    $inum1 = $inum1 + 1;       	
}
unset($RowCheck);
$DatabaseClass->DBClose();


header('Content-Disposition: attachment; filename="' . $filename . '"');
header("Content-type: application/x-msexcel"); 
header('Pragma: no-cache');
print $DataList;
?>
