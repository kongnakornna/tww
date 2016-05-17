<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
if ($_FILES['image1']['name']!='') {
	$no = 0;
    $GenCode = $param_type . "_" .$String->GenKey(6);
	$uploadpath = $files_folder . $Ext;
	list ($newfilename,$uploadresult) = $GC->uploadPhoto("image1",$GenCode,$uploadpath,'','txt','20480');
    if ($uploadresult!='ERROR') {
        $SqlAdd = "insert into tbl_mpayreport (m_date,m_paydate,m_service,m_customerid,m_taxid,m_ref1,m_ref2,m_ref3,m_ref4,m_ref5,m_ref6,m_product_amount	,m_fee_amount,m_total_amount,m_refunddate,m_refund_amount,m_file) values ";
		$fp = fopen($uploadpath.$newfilename,"r");
		while (!feof($fp)) {
		   $mline=fgets($fp,4096);
		   if (strlen($mline) > 5) {
			  list ($type,$datereceive,$servicename,$custid,$txid,$ref1,$ref2,$ref3,$ref4,$ref5,$ref6,$proamount,$feeamount,$totalamount,$refunddate,$refundamount) = explode ("|",$mline);
			  $newdatereceive = ConvertDocDate ($datereceive);
			  $newrefunddate = ConvertDocDate ($refunddate);
			  if (trim($type)=='D') {
				  $no++;
				  if ($no>1) {
					  $SqlAdd .= ",(now(),'".$newdatereceive."','".$String->sqlEscape(strtoupper($servicename))."','".$String->sqlEscape(strtoupper($custid))."','".$String->sqlEscape($txid)."','".$String->sqlEscape($ref1)."','".$String->sqlEscape($ref2)."','".$String->sqlEscape($ref3)."','".$String->sqlEscape($ref4)."','".$String->sqlEscape($ref5)."','".$String->sqlEscape($ref6)."','".$proamount."','".$feeamount."','".$totalamount."','".$newrefunddate."','".$refundamount."','".$_FILES['image1']['name']."')";
				  }else{
					  $SqlAdd .= "(now(),'".$newdatereceive."','".$String->sqlEscape(strtoupper($servicename))."','".$String->sqlEscape(strtoupper($custid))."','".$String->sqlEscape($txid)."','".$String->sqlEscape($ref1)."','".$String->sqlEscape($ref2)."','".$String->sqlEscape($ref3)."','".$String->sqlEscape($ref4)."','".$String->sqlEscape($ref5)."','".$String->sqlEscape($ref6)."','".$proamount."','".$feeamount."','".$totalamount."','".$newrefunddate."','".$refundamount."','".$_FILES['image1']['name']."')";
				  }
			  }
		   }
		}
		fclose($fp);print $SqlAdd;
        $ResultAdd = $DatabaseClass->DataExecute($SqlAdd);
	}

    $DatabaseClass->DBClose();
	$Web->AlertWinGo("นำเข้าข้อมูลข้อมูลเรียบร้อย จำนวน $no ข้อมูล","csvdata_view.php");	
}
die();

function ConvertDocDate ($value) {
   if ($value=='') {
	   return "";
   }else{
	   list ($ddate,$dtime) = explode (" ",$value);
	   list ($mdate,$mmonth,$myear) = explode ("/",$ddate);
	   $ndate = str_pad ($mdate,2, "0", STR_PAD_LEFT);
	   $nmonth = str_pad ($mmonth,2, "0", STR_PAD_LEFT);
	   $newdate = $myear . "-" . $nmonth . "-" . $ndate . " " . $dtime;
	   return $newdate;
   }
}
?>