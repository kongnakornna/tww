<?php
require '../leone.php';
require './controller/app.php';
require './controller/member.php.new';
require './controller/payment.php';
require './controller/partner.php';
require './controller/wallet.php';
header('Content-Type: text/html; charset=tis-620');
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
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
error_log("my log => ".print_r($dtype_array,true)."\n",3,"/tmp/mylog.txt");
				
$period = $param_sdate . " ถึง " . $param_edate;
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
                    //$DataList .= "<tr bgcolor=\"".$iColor."\"><td align=\"right\" class=\"tblist\">".$inum1."</td><td align=\"center\" class=\"tblist\">".$mpayarray[$inum]['dbdate']."</td><td align=\"left\" class=\"tblist\">".$mpayarray[$inum]['custname']."</td><td align=\"center\" class=\"tblist\">".$mpayarray[$inum]['dbemail']."</td><td align=\"left\" class=\"tblist\">".$mpayarray[$inum]['custmobile']."</td><td align=\"center\" class=\"tblist\">MPAY</td><td align=\"left\" class=\"tblist\">".$mpayarray[$inum]['dbdetail']."</td><td align=\"left\" class=\"tblist\">".$db_msisdn."</td><td align=\"center\" class=\"tblist\">".number_format($mpayarray[$inum]['dbtotal'],2,'.',',')."</td><td align=\"center\" class=\"tblist\">0</td><td align=\"center\" class=\"tblist\">0</td><td align=\"center\" class=\"tblist\">".number_format($mpayarray[$inum]['dbtotal'],2,'.',',')."</td></tr>";
                    $db_refill_amt = $mpayarray[$inum]['dbtotal'];
                    $db_bill_amt = 0; 
					$db_transfer_amt = 0;
			         $inum1 = $inum1 + 1;
				}
				else if ($myfilterservice[$mpayarray[$inum]['dbcode']]== '11'&& ($param_servicetype == '01' || $param_servicetype == '03') && (($param_postype == '01') || ($param_postype == '02' && array_key_exists($mpayarray[$inum]['dbemail'],$dtype_array)) || ($param_postype == '03' && !array_key_exists($mpayarray[$inum]['dbemail'],$dtype_array)))){
                   
				    //$DataList .= "<tr bgcolor=\"".$iColor."\"><td align=\"right\" class=\"tblist\">".$inum1."</td><td align=\"center\" class=\"tblist\">".$mpayarray[$inum]['dbdate']."</td><td align=\"left\" class=\"tblist\">".$mpayarray[$inum]['custname']."</td><td align=\"center\" class=\"tblist\">".$mpayarray[$inum]['dbemail']."</td><td align=\"left\" class=\"tblist\">".$mpayarray[$inum]['custmobile']."</td><td align=\"center\" class=\"tblist\">MPAY</td><td align=\"left\" class=\"tblist\">".$mpayarray[$inum]['dbdetail']."</td><td align=\"left\" class=\"tblist\">".$db_msisdn."</td><td align=\"center\" class=\"tblist\">0</td><td align=\"center\" class=\"tblist\">".number_format($mpayarray[$inum]['dbtotal'],2,'.',',')."</td><td align=\"center\" class=\"tblist\">0</td><td align=\"center\" class=\"tblist\">".number_format($mpayarray[$inum]['dbtotal'],2,'.',',')."</td></tr>";
                    $db_bill_amt = $mpayarray[$inum]['dbtotal'];
         			$db_transfer_amt = 0;		
			         $inum1 = $inum1 + 1;
				}
				 $mydate = date_create_from_format('d/m/Y H:i:s',$mpayarray[$inum]['dbdate']);
				 //error_log("my log =>after ".$mpayarray[$inum]['dbdate']."\n",3,"/tmp/mylog.txt");
  	      	     $myDateTime = date_format($mydate, 'd/m/Y');
				 error_log("my log => ".$myDateTime."\n",3,"/tmp/mylog.txt");
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
		       
				 //$DataList .= "<tr bgcolor=\"#ffffe0\"><td colspan=\"8\" align=\"right\" class=\"tblist\">ยอดรวม  (MPAY): </td><td align=\"center\" class=\"tblist\"><strong>".number_format($grandrefill1,2,'.',',')."</strong></td><td align=\"center\" class=\"tblist\"><strong>".number_format($grandbill1,2,'.',',')."</strong></td><td align=\"center\" class=\"tblist\"><strong>".number_format($grandtransfer1,2,'.',',')."</strong></td><td align=\"center\" class=\"tblist\"><strong>".number_format($grandtotal1,2,'.',',')."</strong></td></tr>";
                

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
                    //$DataList .= "<tr bgcolor=\"".$iColor."\"><td align=\"right\" class=\"tblist\">".$inum1."</td><td align=\"center\" class=\"tblist\">".$woparray[$inum]['dbdate']."</td><td align=\"left\" class=\"tblist\">".$woparray[$inum]['custname']."</td><td align=\"center\" class=\"tblist\">".$woparray[$inum]['dbemail']."</td><td align=\"left\" class=\"tblist\">".$woparray[$inum]['custmobile']."</td><td align=\"center\" class=\"tblist\">WOP</td><td align=\"left\" class=\"tblist\">".$woparray[$inum]['dbdetail']."</td><td align=\"left\" class=\"tblist\">".$woparray[$inum]['dbmsisdn']."</td><td align=\"center\" class=\"tblist\">".number_format($woparray[$inum]['dbtotal'],2,'.',',')."</td><td align=\"center\" class=\"tblist\">0</td><td align=\"center\" class=\"tblist\">0</td><td align=\"center\" class=\"tblist\">".number_format($woparray[$inum]['dbtotal'],2,'.',',')."</td></tr>";

                    $db_refill_amt = $woparray[$inum]['dbtotal'];
                    $db_bill_amt = 0; 
					$db_transfer_amt = 0;
					$inum1 = $inum1 + 1; 
				   }
				    else if ($myfilterservice[$woparray[$inum]['dbcode']] == '21' && ($param_servicetype == '01' || $param_servicetype == '03') && (($param_postype == '01') || ($param_postype == '02' && array_key_exists($woparray[$inum]['dbemail'],$dtype_array)) || ($param_postype == '03' && !array_key_exists($woparray[$inum]['dbemail'],$dtype_array)))){
                    //$DataList .= "<tr bgcolor=\"".$iColor."\"><td align=\"right\" class=\"tblist\">".$inum1."</td><td align=\"center\" class=\"tblist\">".$woparray[$inum]['dbdate']."</td><td align=\"left\" class=\"tblist\">".$woparray[$inum]['custname']."</td><td align=\"center\" class=\"tblist\">".$woparray[$inum]['dbemail']."</td><td align=\"left\" class=\"tblist\">".$woparray[$inum]['custmobile']."</td><td align=\"center\" class=\"tblist\">WOP</td><td align=\"left\" class=\"tblist\">".$woparray[$inum]['dbdetail']."</td><td align=\"left\" class=\"tblist\">".$woparray[$inum]['dbmsisdn']."</td><td align=\"center\" class=\"tblist\">0</td><td align=\"center\" class=\"tblist\">".number_format($woparray[$inum]['dbtotal'],2,'.',',')."</td><td align=\"center\" class=\"tblist\">0</td><td align=\"center\" class=\"tblist\">".number_format($woparray[$inum]['dbtotal'],2,'.',',')."</td></tr>";
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
				 error_log("my log => ".$myDateTime."\n",3,"/tmp/mylog.txt");
			
				 $perdatetime[$myDateTime]['WOP']['refill'] =   $perdatetime[$myDateTime]['WOP']['refill'] + $db_refill_amt;
				 $perdatetime[$myDateTime]['WOP']['bill'] =   $perdatetime[$myDateTime]['WOP']['bill'] + $db_bill_amt;
				 $perdatetime[$myDateTime]['WOP']['transfer'] = $perdatetime[$myDateTime]['WOP']['transfer'] + $db_transfer_amt;
				 $perdatetime[$myDateTime]['WOP']['total'] =   $perdatetime[$myDateTime]['WOP']['refill'] +  $perdatetime[$myDateTime]['WOP']['bill'] + $perdatetime[$myDateTime]['WOP']['transfer'];
			         $inum = $inum + 1; 
                 }
		       
 			     //$DataList .= "<tr bgcolor=\"#ffffe0\"><td colspan=\"8\" align=\"right\" class=\"tblist\">ยอดรวม  (WOP): </td><td align=\"center\" class=\"tblist\">".number_format($grandrefill2,2,'.',',')."</td><td align=\"center\" class=\"tblist\">".number_format($grandbill2,2,'.',',')."</td><td align=\"center\" class=\"tblist\"><strong>".number_format($grandtransfer2,2,'.',',')."</strong></td><td align=\"center\" class=\"tblist\"><strong>".number_format($grandtotal2,2,'.',',')."</strong></td></tr>";
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
                    //$DataList .= "<tr bgcolor=\"".$iColor."\"><td align=\"right\" class=\"tblist\">".$iNum1."</td><td align=\"center\" class=\"tblist\">".$myworldarray[$inum]['dbdate']."</td><td align=\"left\" class=\"tblist\">".$myworldarray[$inum]['custname']."</td><td align=\"center\" class=\"tblist\">".$myworldarray[$inum]['dbemail']."</td><td align=\"left\" class=\"tblist\">".$myworldarray[$inum]['custmobile']."</td><td align=\"center\" class=\"tblist\">Myworld</td><td align=\"left\" class=\"tblist\">".$myworldarray[$inum]['$dbdetail']."</td><td align=\"left\" class=\"tblist\">".$myworldarray[$inum]['dbmsisdn']."</td><td align=\"center\" class=\"tblist\">".number_format($myworldarray[$inum]['$dbtotal'],2,'.',',')."</td><td align=\"center\" class=\"tblist\">0</td><td align=\"center\" class=\"tblist\">0</td><td align=\"center\" class=\"tblist\">".number_format($myworldarray[$inum]['dbtotal'],2,'.',',')."</td></tr>";
                    $db_refill_amt = $myworldarray[$inum]['dbtotal'];
                    $db_bill_amt = 0; 
					$db_transfer_amt = 0;
			         $inum1 = $inum1+ 1; 
					}
				    else if ($myfilterservice[$myworldarray[$inum]['dbcode']] == '31' && ($param_servicetype == '01' || $param_servicetype == '03') && (($param_postype == '01') || ($param_postype == '02' && array_key_exists($myworldarray[$inum]['dbemail'],$dtype_array)) || ($param_postype == '03' && !array_key_exists($myworldarray[$inum]['dbemail'],$dtype_array)))){
                    //$DataList .= "<tr bgcolor=\"".$iColor."\"><td align=\"right\" class=\"tblist\">".$inum1."</td><td align=\"center\" class=\"tblist\">".$myworldarray[$inum]['dbdate']."</td><td align=\"left\" class=\"tblist\">".$myworldarray[$inum]['custname']."</td><td align=\"center\" class=\"tblist\">".$myworldarray[$inum]['dbemail']."</td><td align=\"left\" class=\"tblist\">".$myworldarray[$inum]['custmobile']."</td><td align=\"center\" class=\"tblist\">Myworld</td><td align=\"left\" class=\"tblist\">".$myworldarray[$inum]['dbdetail']."</td><td align=\"left\" class=\"tblist\">".$myworldarray[$inum]['dbmsisdn']."</td><td align=\"center\" class=\"tblist\">0</td><td align=\"center\" class=\"tblist\">".number_format($myworldarray[$inum]['dbtotal'],2,'.',',')."</td><td align=\"center\" class=\"tblist\">0</td><td align=\"center\" class=\"tblist\">".number_format($myworldarray[$inum]['dbtotal'],2,'.',',')."</td></tr>";
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
				    //error_log("my log myworld=> ".print_r($myworldarray[$inum],2)."\n",3,"/tmp/mylog.txt");
				    //error_log("my log myworld=> ".$myDateTime."\n",3,"/tmp/mylog.txt");
			
				 $perdatetime[$myDateTime]['myworld']['refill'] =   $perdatetime[$myDateTime]['myworld']['refill'] + $db_refill_amt;
				 $perdatetime[$myDateTime]['myworld']['bill'] =   $perdatetime[$myDateTime]['myworld']['bill'] + $db_bill_amt;
				 $perdatetime[$myDateTime]['myworld']['transfer'] = $perdatetime[$myDateTime]['myworld']['transfer'] + $db_transfer_amt;
				 $perdatetime[$myDateTime]['myworld']['total'] =   $perdatetime[$myDateTime]['myworld']['refill'] +  $perdatetime[$myDateTime]['myworld']['bill'] + $perdatetime[$myDateTime]['myworld']['transfer'];
                    $inum = $inum + 1;   
				 }
				  
                 }
                 //$DataList .= "<tr bgcolor=\"#ffffe0\"><td colspan=\"8\" align=\"right\" class=\"tblist\">ยอดรวม  (Myworld): </td><td align=\"center\" class=\"tblist\">".number_format($grandrefill3,2,'.',',')."</td><td align=\"center\" class=\"tblist\">".number_format($grandbill3,2,'.',',')."</td><td align=\"center\" class=\"tblist\"><strong>".number_format($grandtransfer3,2,'.',',')."</strong></td><td align=\"center\" class=\"tblist\"><strong>".number_format($grandtotal,2,'.',',')."</strong></td></tr>";
                 
                 $grandrefill = $grandrefill1 + $grandrefill2 + $grandrefill3;
				 $grandbill = $grandbill1 + $grandbill2 + $grandbill3;
				 $grandtransfer = $grandtransfer1 + $grandtransfer2 + $grandtransfer3;
				 $grandtotal = $grandrefill + $grandbill + $grandtransfer;
				 //$DataList .= "<tr bgcolor=\"#ffffff\"><td colspan=\"8\" align=\"right\" class=\"tblist\">ยอดรวม  (ทั้งหมด): </td><td align=\"center\" class=\"tblist\">".number_format($grandrefill,2,'.',',')."</td><td align=\"center\" class=\"tblist\">".number_format($grandbill,2,'.',',')."</td><td align=\"center\" class=\"tblist\"><strong>".number_format($grandtransfer,2,'.',',')."</strong></td><td align=\"center\" class=\"tblist\"><strong>".number_format($grandtotal,2,'.',',')."</strong></td></tr>";
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
                    //$DataList .= "<tr bgcolor=\"".$iColor."\"><td align=\"right\" class=\"tblist\">".$inum1."</td><td align=\"center\" class=\"tblist\">".$mpayarray[$inum]['dbdate']."</td><td align=\"left\" class=\"tblist\">".$mpayarray[$inum]['custname']."</td><td align=\"center\" class=\"tblist\">".$mpayarray[$inum]['dbemail']."</td><td align=\"left\" class=\"tblist\">".$mpayarray[$inum]['custmobile']."</td><td align=\"center\" class=\"tblist\">MPAY</td><td align=\"left\" class=\"tblist\">".$mpayarray[$inum]['dbdetail']."</td><td align=\"left\" class=\"tblist\">".$db_msisdn."</td><td align=\"center\" class=\"tblist\">".number_format($mpayarray[$inum]['dbtotal'],2,'.',',')."</td><td align=\"center\" class=\"tblist\">0</td><td align=\"center\" class=\"tblist\">0</td><td align=\"center\" class=\"tblist\">".number_format($mpayarray[$inum]['dbtotal'],2,'.',',')."</td></tr>";
                    $db_refill_amt = $mpayarray[$inum]['dbtotal'];
                    $db_bill_amt = 0; 
					$db_transfer_amt = 0;
			         $inum1 = $inum1 + 1;
				}
				else if ($myfilterservice[$mpayarray[$inum]['dbcode']]== '11' && ($param_servicetype == '01' || $param_servicetype == '03')&& (($param_postype == '01') || ($param_postype == '02' && array_key_exists($mpayarray[$inum]['dbemail'],$dtype_array)) || ($param_postype == '03' && !array_key_exists($mpayarray[$inum]['dbemail'],$dtype_array)))){
                   
				    //$DataList .= "<tr bgcolor=\"".$iColor."\"><td align=\"right\" class=\"tblist\">".$inum1."</td><td align=\"center\" class=\"tblist\">".$mpayarray[$inum]['dbdate']."</td><td align=\"left\" class=\"tblist\">".$mpayarray[$inum]['custname']."</td><td align=\"center\" class=\"tblist\">".$mpayarray[$inum]['dbemail']."</td><td align=\"left\" class=\"tblist\">".$mpayarray[$inum]['custmobile']."</td><td align=\"center\" class=\"tblist\">MPAY</td><td align=\"left\" class=\"tblist\">".$mpayarray[$inum]['dbdetail']."</td><td align=\"left\" class=\"tblist\">".$db_msisdn."</td><td align=\"center\" class=\"tblist\">0</td><td align=\"center\" class=\"tblist\">".number_format($mpayarray[$inum]['dbtotal'],2,'.',',')."</td><td align=\"center\" class=\"tblist\">0</td><td align=\"center\" class=\"tblist\">".number_format($mpayarray[$inum]['dbtotal'],2,'.',',')."</td></tr>";
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
				 error_log("my log => ".$myDateTime."\n",3,"/tmp/mylog.txt");
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
		         error_log("my log => ".print_r($perdatetime,2)."\n",3,"/tmp/mylog.txt");
				 //$DataList .= "<tr bgcolor=\"#ffffe0\"><td colspan=\"8\" align=\"right\" class=\"tblist\">ยอดรวม  (MPAY): </td><td align=\"center\" class=\"tblist\"><strong>".number_format($grandrefill1,2,'.',',')."</strong></td><td align=\"center\" class=\"tblist\"><strong>".number_format($grandbill1,2,'.',',')."</strong></td><td align=\"center\" class=\"tblist\"><strong>".number_format($grandtransfer1,2,'.',',')."</strong></td><td align=\"center\" class=\"tblist\"><strong>".number_format($grandtotal1,2,'.',',')."</strong></td></tr>";
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
                    //$DataList .= "<tr bgcolor=\"".$iColor."\"><td align=\"right\" class=\"tblist\">".$inum1."</td><td align=\"center\" class=\"tblist\">".$woparray[$inum]['dbdate']."</td><td align=\"left\" class=\"tblist\">".$woparray[$inum]['custname']."</td><td align=\"center\" class=\"tblist\">".$woparray[$inum]['dbemail']."</td><td align=\"left\" class=\"tblist\">".$woparray[$inum]['dbmsisdn']."</td><td align=\"center\" class=\"tblist\">WOP</td><td align=\"left\" class=\"tblist\">".$woparray[$inum]['dbdetail']."</td><td align=\"left\" class=\"tblist\">".$woparray[$inum]['custmobile']."</td><td align=\"center\" class=\"tblist\">".number_format($woparray[$inum]['dbtotal'],2,'.',',')."</td><td align=\"center\" class=\"tblist\">0</td><td align=\"center\" class=\"tblist\">0</td><td align=\"center\" class=\"tblist\">".number_format($woparray[$inum]['dbtotal'],2,'.',',')."</td></tr>";
                    $db_refill_amt = $woparray[$inum]['dbtotal'];
                    $db_bill_amt = 0; 
					$db_transfer_amt = 0;
			        $inum1 = $inum1 + 1; 
					}
				    else if ($myfilterservice[$woparray[$inum]['dbcode']] == '21' && ($param_servicetype == '01' || $param_servicetype == '03') && (($param_postype == '01') || ($param_postype == '02' && array_key_exists($woparray[$inum]['dbemail'],$dtype_array)) || ($param_postype == '03' && !array_key_exists($woparray[$inum]['dbemail'],$dtype_array)))){
                    //$DataList .= "<tr bgcolor=\"".$iColor."\"><td align=\"right\" class=\"tblist\">".$inum1."</td><td align=\"center\" class=\"tblist\">".$woparray[$inum]['dbdate']."</td><td align=\"left\" class=\"tblist\">".$woparray[$inum]['custname']."</td><td align=\"center\" class=\"tblist\">".$woparray[$inum]['dbemail']."</td><td align=\"left\" class=\"tblist\">".$woparray[$inum]['dbmsisdn']."</td><td align=\"center\" class=\"tblist\">WOP</td><td align=\"left\" class=\"tblist\">".$woparray[$inum]['dbdetail']."</td><td align=\"left\" class=\"tblist\">".$woparray[$inum]['custmobile']."</td><td align=\"center\" class=\"tblist\">0</td><td align=\"center\" class=\"tblist\">".number_format($woparray[$inum]['dbtotal'],2,'.',',')."</td><td align=\"center\" class=\"tblist\">0</td><td align=\"center\" class=\"tblist\">".number_format($woparray[$inum]['dbtotal'],2,'.',',')."</td></tr>";
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
				 error_log("my log => ".$myDateTime."\n",3,"/tmp/mylog.txt");
			
				 $perdatetime[$myDateTime]['WOP']['refill'] =   $perdatetime[$myDateTime]['WOP']['refill'] + $db_refill_amt;
				 $perdatetime[$myDateTime]['WOP']['bill'] =   $perdatetime[$myDateTime]['WOP']['bill'] + $db_bill_amt;
				 $perdatetime[$myDateTime]['WOP']['transfer'] = $perdatetime[$myDateTime]['WOP']['transfer'] + $db_transfer_amt;
				 $perdatetime[$myDateTime]['WOP']['total'] =   $perdatetime[$myDateTime]['WOP']['refill'] +  $perdatetime[$myDateTime]['WOP']['bill'] + $perdatetime[$myDateTime]['WOP']['transfer'];
			           $inum = $inum + 1; 
                   
                 }
		          error_log("my log => ".print_r($perdatetime,2)."\n",3,"/tmp/mylog.txt");
			      //$DataList .= "<tr bgcolor=\"#ffffe0\"><td colspan=\"8\" align=\"right\" class=\"tblist\">ยอดรวม  (WOP): </td><td align=\"center\" class=\"tblist\">".number_format($grandrefill2,2,'.',',')."</td><td align=\"center\" class=\"tblist\">".number_format($grandbill2,2,'.',',')."</td><td align=\"center\" class=\"tblist\"><strong>".number_format($grandtransfer2,2,'.',',')."</strong></td><td align=\"center\" class=\"tblist\"><strong>".number_format($grandtotal2,2,'.',',')."</strong></td></tr>";
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
                    //$DataList .= "<tr bgcolor=\"".$iColor."\"><td align=\"right\" class=\"tblist\">".$iNum1."</td><td align=\"center\" class=\"tblist\">".$myworldarray[$inum]['dbdate']."</td><td align=\"left\" class=\"tblist\">".$myworldarray[$inum]['custname']."</td><td align=\"center\" class=\"tblist\">".$myworldarray[$inum]['dbemail']."</td><td align=\"left\" class=\"tblist\">".$myworldarray[$inum]['dbmsisdn']."</td><td align=\"center\" class=\"tblist\">Myworld</td><td align=\"left\" class=\"tblist\">".$myworldarray[$inum]['$dbdetail']."</td><td align=\"left\" class=\"tblist\">".$myworldarray[$inum]['custmobile']."</td><td align=\"center\" class=\"tblist\">".number_format($myworldarray[$inum]['$dbtotal'],2,'.',',')."</td><td align=\"center\" class=\"tblist\">0</td><td align=\"center\" class=\"tblist\">0</td><td align=\"center\" class=\"tblist\">".number_format($myworldarray[$inum]['dbtotal'],2,'.',',')."</td></tr>";
                    $db_refill_amt = $myworldarray[$inum]['dbtotal'];
                    $db_bill_amt = 0; 
					$db_transfer_amt = 0;
			            $inum1 = $inum1+ 1; 
					}
				    else if ($myfilterservice[$myworldarray[$inum]['dbcode']] == '31'&& ($param_servicetype == '01' || $param_servicetype == '03') && (($param_postype == '01') || ($param_postype == '02' && array_key_exists($myworldarray[$inum]['dbemail'],$dtype_array)) || ($param_postype == '03' && !array_key_exists($myworldarray[$inum]['dbemail'],$dtype_array)))){
                    //$DataList .= "<tr bgcolor=\"".$iColor."\"><td align=\"right\" class=\"tblist\">".$inum1."</td><td align=\"center\" class=\"tblist\">".$myworldarray[$inum]['dbdate']."</td><td align=\"left\" class=\"tblist\">".$myworldarray[$inum]['custname']."</td><td align=\"center\" class=\"tblist\">".$myworldarray[$inum]['dbemail']."</td><td align=\"left\" class=\"tblist\">".$myworldarray[$inum]['dbmsisdn']."</td><td align=\"center\" class=\"tblist\">Myworld</td><td align=\"left\" class=\"tblist\">".$myworldarray[$inum]['dbdetail']."</td><td align=\"left\" class=\"tblist\">".$myworldarray[$inum]['custmobile']."</td><td align=\"center\" class=\"tblist\">0</td><td align=\"center\" class=\"tblist\">".number_format($myworldarray[$inum]['dbtotal'],2,'.',',')."</td><td align=\"center\" class=\"tblist\">0</td><td align=\"center\" class=\"tblist\">".number_format($myworldarray[$inum]['dbtotal'],2,'.',',')."</td></tr>";
                    $db_refill_amt =0;
                    $db_bill_amt = $myworldarray[$inum]['dbtotal'];
         			$db_transfer_amt = 0;		
			            $inum1 = $inum1+ 1; 
					}
				    $grandrefill3= $grandrefill3 + $db_refill_amt;
		            $grandbill3 =   $grandbill3 + $db_bill_amt;
				    $grandtransfer3 = $grandtransfer3 + $db_transfer_amt;
		            $grandtotal3 =  $grandrefill3 + $grandbill3 + $grandtransfer3; 
				
				
				    //error_log("myworld log => ".$myworldarray[$inum]['dbdate']."\n",3,"/tmp/mylog.txt");
					$mydate = date_create_from_format('d/m/Y H:i:s',$myworldarray[$inum]['dbdate']);
			        $myDateTime = date_format($mydate, 'd/m/Y');
				    //error_log("myworld log => ".$myDateTime."\n",3,"/tmp/mylog.txt");
			
				    $perdatetime[$myDateTime]['myworld']['refill'] =   $perdatetime[$myDateTime]['myworld']['refill'] + $db_refill_amt;
				    $perdatetime[$myDateTime]['myworld']['bill'] =   $perdatetime[$myDateTime]['myworld']['bill'] + $db_bill_amt;
				    $perdatetime[$myDateTime]['myworld']['transfer'] = $perdatetime[$myDateTime]['myworld']['transfer'] + $db_transfer_amt;
				    $perdatetime[$myDateTime]['myworld']['total'] =   $perdatetime[$myDateTime]['myworld']['refill'] +  $perdatetime[$myDateTime]['myworld']['bill'] + $perdatetime[$myDateTime]['myworld']['transfer'];
                    $inum = $inum + 1;   
					
                    }
					//error_log("my log => ".print_r($perdatetime,2)."\n",3,"/tmp/mylog.txt");
			        //$DataList .= "<tr bgcolor=\"#ffffe0\"><td colspan=\"8\" align=\"right\" class=\"tblist\">ยอดรวม  (Myworld): </td><td align=\"center\" class=\"tblist\">".number_format($grandrefill3,2,'.',',')."</td><td align=\"center\" class=\"tblist\">".number_format($grandbill3,2,'.',',')."</td><td align=\"center\" class=\"tblist\"><strong>".number_format($grandtransfer3,2,'.',',')."</strong></td><td align=\"center\" class=\"tblist\"><strong>".number_format($grandtotal3,2,'.',',')."</strong></td></tr>";
                 }
			  
		 }	  
unset($RowCheck);

$DataList="";
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
	#$myworlddelta = $prevwallet_myworld-$currwallet_myworld+$currdeposit_myworld;
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
	$myworld_diff = 0;
	$ipps_diff = round($ipps_total,2) - round($ippsdelta,2);
	//$total_diff = round($easycard_total,2) - round(( $mpaydelta +  $wopdelta + $billdelta + $myworldelta + $ippsdelta),2);
	$total_diff = round($easycard_total,2) - round(( $mpaydelta +  $wopdelta + $billdelta + $myworld_total + $ippsdelta),2);
	
	
	/*error_log("my log report=> ".($wallet->checkdeposit($newdatetxt,"01"))."\n",3,"/tmp/mylog.txt");
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
	
	
	
	
    $DataList .=  "<tr bgcolor=\"".$iColor."\"><td align=\"right\" class=\"tblist\">".$newdate;
	$DataList .=  "</td><td align=\"center\" class=\"tblist\">".$currdeposit_mpay;
	$DataList .=  "</td><td align=\"center\" class=\"tblist\">".$mpaydelta;
	$DataList .=  "</td><td align=\"center\" class=\"tblist\">".$currwallet_mpay;
	$DataList .=  "</td><td align=\"center\" class=\"tblist\">".$totdepwop;
    $DataList .=  "</td><td align=\"center\" class=\"tblist\">".$wopdelta;
	$DataList .=  "</td><td align=\"center\" class=\"tblist\">".$totwalletwop;
	$DataList .=  "</td><td align=\"center\" class=\"tblist\">".$currdeposit_bill;
	$DataList .=  "</td><td align=\"center\" class=\"tblist\">".$billdelta;
	$DataList .=  "</td><td align=\"center\" class=\"tblist\">".$currwallet_bill;
	$DataList .=  "</td><td align=\"center\" class=\"tblist\">".$myworld_total;
	$DataList .=  "</td><td align=\"center\" class=\"tblist\">".$currdeposit_ipps;
	$DataList .=  "</td><td align=\"center\" class=\"tblist\">".$ippsdelta;
    $DataList .=  "</td><td align=\"center\" class=\"tblist\">".$currwallet_ipps;
	$DataList .=  "</td><td align=\"center\" class=\"tblist\">".$mpay_total;
	$DataList .=  "</td><td align=\"center\" class=\"tblist\">".$woprefill_total;
	$DataList .=  "</td><td align=\"center\" class=\"tblist\">".$wopbill_total;
	$DataList .=  "</td><td align=\"center\" class=\"tblist\">".$wop_total;
	$DataList .=  "</td><td align=\"center\" class=\"tblist\">".$myworld_total;
	$DataList .=  "</td><td align=\"center\" class=\"tblist\">".$ipps_total;
	$DataList .=  "</td><td align=\"center\" class=\"tblist\">".$easycard_total;
	$DataList .=  "</td><td align=\"center\" class=\"tblist\">".$mpay_diff;
	$DataList .=  "</td><td align=\"center\" class=\"tblist\">".$woprefill_diff;
	$DataList .=  "</td><td align=\"center\" class=\"tblist\">".$wopbill_diff;
	$DataList .=  "</td><td align=\"center\" class=\"tblist\">".$woptotal_diff;
	$DataList .=  "</td><td align=\"center\" class=\"tblist\">".$myworld_diff;
	$DataList .=  "</td><td align=\"center\" class=\"tblist\">".$ipps_diff;
	$DataList .=  "</td><td align=\"center\" class=\"tblist\">".$total_diff."</td>";
	
	//$DataList .= "<tr bgcolor=\"".$iColor."\"><td align=\"right\" class=\"tblist\">".$inum1."</td><td align=\"center\" class=\"tblist\">".$myworldarray[$inum]['dbdate']."</td><td align=\"left\" class=\"tblist\">".$myworldarray[$inum]['custname']."</td><td align=\"center\" class=\"tblist\">".$myworldarray[$inum]['dbemail']."</td><td align=\"left\" class=\"tblist\">".$myworldarray[$inum]['dbmsisdn']."</td><td align=\"center\" class=\"tblist\">Myworld</td><td align=\"left\" class=\"tblist\">".$myworldarray[$inum]['dbdetail']."</td><td align=\"left\" class=\"tblist\">".$myworldarray[$inum]['custmobile']."</td><td align=\"center\" class=\"tblist\">0</td><td align=\"center\" class=\"tblist\">".number_format($myworldarray[$inum]['dbtotal'],2,'.',',')."</td><td align=\"center\" class=\"tblist\">0</td><td align=\"center\" class=\"tblist\">".number_format($myworldarray[$inum]['dbtotal'],2,'.',',')."</td></tr>";
    $inum1 = $inum1 + 1;       	
}
$DatabaseClass->DBClose();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title><?php echo $webtitle;?></title>
<?php include('_function.inc.php');?>
<SCRIPT LANGUAGE="JavaScript">
<!--
$(document).ready(function() {
	$('.add').button({ icons: { primary: 'ui-icon-circle-plus' } });
    $('#btnSubmit').each(function(){
	   $(this).replaceWith('<button class="add1" type="' + $(this).attr('type') + '">' + $(this).val() + '</button>');
	});
	$('.add1').button({ icons: { primary: 'ui-icon-print' } });
});
//-->
</SCRIPT>
</head>

<body class="bgbd">
<?php
	include ("_header.inc.php");
?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="18" align="left" valign="top" background="images/obj_06.png" style="background-repeat:no-repeat;border:1px solid black;"><img src="images/spacer.gif" width="18" height="1" /></td>
    <td class="warea frameoutside"><table width="100%" border="0" cellpadding="2" cellspacing="3">
      <tr>
        <td width="200" class="sidearea">
        <?php
			include ("_sidebar.inc.php");
		?>        </td>
        <td height="480" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="txttopicpage">รายงานสรุปกระทบยอดเงิน Advance</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
              <tr>
                <td>
				 <tr><td colspan="11" valign="middle" border="1px"  style="height:30px;"><b>วันที่ </b><?php echo $period;?></td></tr>
                 <table width="99%" border="1px" align="center" cellpadding="3" cellspacing="1">
				     <tr>
			         <th rowspan="2" width="20%" bgcolor="#F5F5F5" class="txt1 tblist tablehead">วันที่</th>
					  <th colspan="3" width="5%" bgcolor="#F5F5F5" class="txt1 tblist tablehead">MPAY (Advance)</th>
				      <th colspan="6" width="5%" bgcolor="#F5F5F5" class="txt1 tblist tablehead">WOP (Advance)</th>
					  <th colspan="1" width="5%" bgcolor="#F5F5F5" class="txt1 tblist tablehead">Myworld (Advance)</th>
					  <th colspan="3" width="5%" bgcolor="#F5F5F5" class="txt1 tblist tablehead">IPPS (Advance)</th>
					  <th colspan="7" width="5%" bgcolor="#F5F5F5" class="txt1 tblist tablehead">Easy Card (ยอดใช้จ่าย)</th>
					  <th colspan="7" width="5%" bgcolor="#F5F5F5" class="txt1 tblist tablehead">สรุปยอดผลต่างระหว่างคู่ค้า</th>
    				</tr>
					<tr>
				      <th colspan="1" width="5%" bgcolor="#F5F5F5" class="txt1 tblist tablehead">เข้า</td>
                      <th colspan="1" width="5%" bgcolor="#F5F5F5" class="txt1 tblist tablehead">ออก</td>
                      <th colspan="1" width="5%" bgcolor="#F5F5F5" class="txt1 tblist tablehead">คงเหลือ</td>
                      <th colspan="1" width="5%" bgcolor="#F5F5F5" class="txt1 tblist tablehead">เข้า topup</td>
                      <th colspan="1" width="5%" bgcolor="#F5F5F5" class="txt1 tblist tablehead">ออก topup</td>
                      <th colspan="1" width="5%" bgcolor="#F5F5F5" class="txt1 tblist tablehead">คงเหลือ topup</td>
				      <th colspan="1" width="5%" bgcolor="#F5F5F5" class="txt1 tblist tablehead">เข้า bill</td>
                      <th colspan="1" width="5%" bgcolor="#F5F5F5" class="txt1 tblist tablehead">ออก bill</td>
                      <th colspan="1" width="5%" bgcolor="#F5F5F5" class="txt1 tblist tablehead">คงเหลือ bill</td>
                      <th colspan="1" width="5%" bgcolor="#F5F5F5" class="txt1 tblist tablehead">ออก</td>
                      <th colspan="1" width="5%" bgcolor="#F5F5F5" class="txt1 tblist tablehead">เข้า</td>
                      <th colspan="1" width="5%" bgcolor="#F5F5F5" class="txt1 tblist tablehead">ออก</td>
                      <th colspan="1" width="5%" bgcolor="#F5F5F5" class="txt1 tblist tablehead">คงเหลือ</td>
                      <th colspan="1" width="5%" bgcolor="#F5F5F5" class="txt1 tblist tablehead">MPAY รวม</td>
                      <th colspan="1" width="5%" bgcolor="#F5F5F5" class="txt1 tblist tablehead">WOP เติมเงิน</td>
                      <th colspan="1" width="5%" bgcolor="#F5F5F5" class="txt1 tblist tablehead">WOP จ่ายบิล</td>
                      <th colspan="1" width="5%" bgcolor="#F5F5F5" class="txt1 tblist tablehead">WOP รวม</td>
				      <th colspan="1" width="5%" bgcolor="#F5F5F5" class="txt1 tblist tablehead">Myworld รวม</td>
                      <th colspan="1" width="5%" bgcolor="#F5F5F5" class="txt1 tblist tablehead">IPPS รวม</td>
                      <th colspan="1" width="5%" bgcolor="#F5F5F5" class="txt1 tblist tablehead">EasyCard รวม</td>
					  <th colspan="1" width="5%" bgcolor="#F5F5F5" class="txt1 tblist tablehead">MPAY</td>
                      <th colspan="1" width="5%" bgcolor="#F5F5F5" class="txt1 tblist tablehead">WOP เติมเงิน</td>
                      <th colspan="1" width="5%" bgcolor="#F5F5F5" class="txt1 tblist tablehead">WOP จ่ายบิล</td>
                      <th colspan="1" width="5%" bgcolor="#F5F5F5" class="txt1 tblist tablehead">WOP รวม</td>
                      <th colspan="1" width="5%" bgcolor="#F5F5F5" class="txt1 tblist tablehead">Myworld</td>
					  <th colspan="1" width="5%" bgcolor="#F5F5F5" class="txt1 tblist tablehead">IPPS</td>
					  <th colspan="1" width="5%" bgcolor="#F5F5F5" class="txt1 tblist tablehead">ยอดรวม</td>
					 </tr>
				    <?php echo $DataList;?>
                </table>    
				
				<br/><br/>

				<form method="post" action="report_all_exec_csv_deposit2.php" name="frmToCsv" id="frmToCsv" target="csv">
				<input type="hidden" name="s_sdate" value="<?php echo $param_sdate;?>" />	
				<input type="hidden" name="s_edate" value="<?php echo $param_edate;?>" />	
				<input type="hidden" name="partner" value="<?php echo $param_partner;?>" />
				<input type="hidden" name="service_type" value="<?php echo $param_servicetype;?>" />
				<input type="hidden" name="pos_type" value="<?php echo $param_postype;?>" />
				<input type="hidden" name="member_name" value="<?php echo $param_membername;?>" />
				<table width="99%" border="0" align="center" cellpadding="3" cellspacing="1">
				<tr><td align="left"><input type="submit" name="btnSubmit" id="btnSubmit" value="นำออก CSV" /></td></tr>
				</table> 
				</form>
		
		</td>
              </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td class="sidearea"><img src="images/spacer.gif" width="200" height="1" /></td>
        <td align="left" valign="top"><img src="images/spacer.gif" width="772" height="1" /></td>
      </tr>
	<?php
		include ("_footer.inc.php");
	?>
    </table></td>
    <td width="18" align="left" valign="top" background="images/obj_08.png" style="background-repeat:no-repeat;"><img src="images/spacer.gif" width="18" height="1" /></td>
  </tr>
</table>
</body>
</html>
