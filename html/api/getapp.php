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
$param_appid = (!empty($_REQUEST["appid"])) ? $_REQUEST["appid"] : "";

if ($param_email=='' || $param_appid=='') {
	$msg = "ส่ง parameter มาไม่ครบค่ะ"; 
    $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
}else{
    $havemember = $member->havemember($param_email);
    if ($havemember) {
		$price = $app->getprice($param_appid);
		$mprice = $member->getprice($param_email);
		$mpoint = $member->getpoint($param_email);
		$mcode = $member->getcodebyemail($param_email);
		if ($mprice<$price) {
			$msg ="ยอด Point ของท่าน มีจำนวนไม่พอกับราคาสินค้า หรือบริการที่ท่านต้องการ กรุณาเติม Point เพิ่ม";
		    $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
		}else{
			$recomapplist = $app->getdetail ($param_appid);
			$recomapplistrows = count($recomapplist);
			for ($b=0;$b<$recomapplistrows;$b++) {   
				 $db_id = $recomapplist[$b]['p_id'];
				 $db_title = stripslashes($recomapplist[$b]['p_title']);
				 $db_code = stripslashes($recomapplist[$b]['p_code']);
				 $db_apk = stripslashes($recomapplist[$b]['p_apk']);
				 $db_recom = stripslashes($recomapplist[$b]['p_recommended']);
				 $db_partner = stripslashes($recomapplist[$b]['p_partnerid']);
				 $db_type = stripslashes($recomapplist[$b]['p_type']);
				 $db_price = stripslashes($recomapplist[$b]['p_price']);
				 $db_url = stripslashes($recomapplist[$b]['p_url']);
				 if ($db_type=='F') {
					 $price = "0";
				 }else{
					 $price = $db_price;
				 }
			}

			if ($db_apk=='') {
				if ($db_url=='') {
                   $apkurl = "";
				}else{
                   $apkurl = $db_url;
				}
			}else{
                $apkurl = "https://www.easycard.club/apk/" . $db_apk;
			}

			$historyapp = $payment->getapphistory($db_id,$param_email);
			if ($historyapp>0) {
			   $db_price = '0';
			   $reinstall = 'Y';
			}else{
			   $reinstall = 'N';
			}

			$partnercode = $partner->getcode($db_partner);

			$resultpayment = $payment->insert($partnercode,$db_id,$db_code,'B',$price,'',$db_partner,'',$reinstall,$param_email,'','');
			$resultmemner = $payment->usedcardno($mcode,$price);
			$dataarray = array("result"=>"OK","result_desc"=>"","product_id"=>$db_id,"product_code"=>$db_code,"product_name"=>$String->tis2utf8($db_title),"product_price"=>$price,"product_file"=>$apkurl);
		}
	}else{
		$msg = "สมาชิกท่านนี้ ไม่ได้รับอนุญาติให้ใช้งานระบบค่ะ";
		$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
	}
}

$xmldata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($xmldata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

print $resultxml;
?>