<?php
include '../leone.php';
include '../admin/controller/app.php';
include '../admin/controller/partner.php';
include '../admin/controller/payment.php';
include '../admin/controller/member.php';
header('Content-Type: application/json; charset=utf-8');
$app = new app();
$member = new member();
$partner = new partner();
$payment = new payment();
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";

if ($param_email=='') {
	$msg = "ส่ง parameter มาไม่ครบค่ะ"; 
    $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg),"datalist"=>"");
}else{
	$iNum = 0;
    $havemember = $member->havemember($param_email);
    if ($havemember) {
		$memberdata = $payment->getbookforapp($param_email);
		for ($p=0;$p<count($memberdata);$p++) {
			  $iNum++;
			  $db_id = stripslashes($memberdata[$p]['p_id']);
			  $db_type = stripslashes($memberdata[$p]['p_type']);
			  $db_detail = stripslashes($memberdata[$p]['p_detail']);
			  $db_price = stripslashes($memberdata[$p]['p_price']);
			  $db_productid = stripslashes($memberdata[$p]['p_productid']);
			  $db_ref2 = stripslashes($memberdata[$p]['p_ref2']);
			  $db_email = stripslashes($memberdata[$p]['p_email']);	  
			  $db_paydate = $DT->ShowDateTime($memberdata[$p]['p_adddate'],'en');

			  if ($db_type=='A') {
				  $moneyin = $db_price;
				  $moneyout = "";
				  $remark = $db_ref2;
				  $totalpay = $totalpay + $db_price;
			  }else if ($db_type=='R') {
				  $moneyin = "";
				  $moneyout = $db_price;
				  $remark = "ยกเลิกการเติมเงิน";
				  $totalpay = $totalpay - $db_price;
			  }else if ($db_type=='B') {
				  $moneyin = "";
				  $moneyout = $db_price;
				  $apptitle = $app->gettitle($db_productid);
				  $remark = "ซื้อสินค้า" . $apptitle;
				  $totalpay = $totalpay - $db_price;
			  }else if ($db_type=='I') {
				  $moneyin = "";
				  $moneyout = $db_price;
				  $remark = "ซื้อสินค้า" . $db_detail;
				  $totalpay = $totalpay - $db_price;
			  }

			  $darray[$p] = array ("date"=>$db_paydate,"money_in"=>number_format($moneyin,2,'.',','),"money_out"=>number_format($moneyout,2,'.',','),"money_total"=>number_format($totalpay,2,'.',','),"remark"=>$String->tis2utf8($remark));
    	}
		$dataarray = array("result"=>"OK","result_desc"=>"","datalist"=>$darray);
	}else{
		$msg = "สมาชิกท่านนี้ ไม่ได้รับอนุญาติให้ใช้งานระบบค่ะ";
		$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg),"datalist"=>"");
	}
}

$xmldata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($xmldata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

print $resultxml;
?>
