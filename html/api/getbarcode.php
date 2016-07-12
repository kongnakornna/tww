<?php
include '../leone.php';
include '../admin/controller/payment.php';
include '../admin/controller/member.php';
header('Content-Type: application/json; charset=utf-8');
$member = new member();
$payment = new payment();
$param_membercode = (!empty($_REQUEST["membercode"])) ? $_REQUEST["membercode"] : "";

if ($param_membercode=='') {
	$msg = "กรุณากรอกรหัสสมาชิก";
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg),"list"=>"");
}else{
	$havemember = $member->havememberbycode($param_membercode);
	if ($havemember) {
        $barcodearray = $member->getbarcode($param_membercode);
		if (count($barcodearray)>0) {
			 for ($t=0;$t<count($barcodearray);$t++) {
				 $cardtitle = $barcodearray[$t]['p_title'];
				 $cardtype = $barcodearray[$t]['p_cardtype'];
				 $cardnumber = $barcodearray[$t]['p_cardnumber'];

				 $logoimg = "https://www.easycard.club/logo/".$cardtype.".png";
				 $barcodeimg = "https://www.easycard.club/photo/barcode/".$cardtype."/".$cardnumber.".png";
                 $listarray[$t] = array ("name"=>$String->tis2utf8($cardtitle),"logo"=>$logoimg,"barcode"=>$cardnumber,"barimg"=>$barcodeimg);
			 }
		}
		$dataarray = array("result"=>"OK","result_desc"=>"","list"=>$listarray);
	}else{
		$msg = "คุณไม่ได้รับอนุญาติให้บริการค่ะ";
		$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg),"list"=>"");
	}
}
$memberdata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($memberdata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

print $resultxml;
?>