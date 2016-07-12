<?php
include "../leone.php";
include "../admin/controller/app.php";
include "../admin/controller/content.php";
include "../admin/controller/partner.php";
include "../admin/controller/payment.php";
$app = new app();
$content = new content();
$partner = new partner();
$payment = new payment();
$param_cat = (!empty($_REQUEST["cat"])) ? $_REQUEST["cat"] : "";
$param_type = (!empty($_REQUEST["type"])) ? $_REQUEST["type"] : "";
$param_sort = (!empty($_REQUEST["sort"])) ? $_REQUEST["sort"] : "";
$param_email = (!empty($_REQUEST["email "])) ? $_REQUEST["email "] : "";
if ($param_sort=='') $param_sort = '0';

$recomapplist = $app->getdata ("F",$param_cat,$param_sort);
$recomapplistrows = count($recomapplist);
for ($b=0;$b<$recomapplistrows;$b++) {   
	 $db_id = $recomapplist[$b]['p_id'];
	 $db_title = stripslashes($recomapplist[$b]['p_title']);
	 $db_code = stripslashes($recomapplist[$b]['p_code']);
	 $db_recom = stripslashes($recomapplist[$b]['p_recommended']);
	 $db_partner = stripslashes($recomapplist[$b]['p_partnerid']);
	 $db_type = stripslashes($recomapplist[$b]['p_type']);
	 $db_showtype = stripslashes($recomapplist[$b]['p_showtype']);
	 $db_cate = stripslashes($recomapplist[$b]['p_categorie']);
	 $db_gallery = stripslashes($recomapplist[$b]['p_gallery']);
	 $db_price = stripslashes($recomapplist[$b]['p_price']);
	 $catecode = $db_cate;
	 $catename= $content->gettitle($db_cate);
	 $partnername = $partner->getname($db_partner);

	 $historyapp = $payment->getapphistory($db_id[$b],$param_email);
	 if ($historyapp>0) {
		 $bought = "Y";
	 }else{
		 $bought = "N";
	 }

	 $fileimg = explode ("|",$db_gallery);

	 $image = "https://www.easycard.club/photo/gallery/".$fileimg[0];
     $dbarray[$b] = array ("product_id"=>$db_id,"product_code"=>$String->tis2utf8($db_code),"product_showtype"=>$String->tis2utf8($db_showtype),"product_name"=>$String->tis2utf8($db_title),"hilight"=>$db_recom,"product_type"=>$String->tis2utf8($db_type),"owner"=>$String->tis2utf8($partnername),"categorie_code"=>$catecode,"categorie_name"=>$String->tis2utf8($catename),"product_price"=>$String->tis2utf8($db_price),"bought"=>$bought,"product_thumb"=>$String->tis2utf8($image));
}

if ($param_cat!='') {
	$cdata = $content->getdatabycat($param_cat);
	for ($b=0;$b<count($cdata);$b++) {
		$tt_id = $cdata[$b]['c_id'];
		$tt_title = stripslashes($cdata[$b]['c_title']);
		$tt_banner = stripslashes($cdata[$b]['c_bannerapp']);

		if ($tt_banner=='') {
			$banner = "";
		}else{
			$banner = "https://www.easycard.club/photo/".$tt_banner;
		}
		$dataarray[$b] = array ("categorie_id"=>$tt_id,"categorie_name"=>$String->tis2utf8($tt_title),"categorie_banner"=>$banner);
	}
}




$filearray = array("result"=>"OK","result_desc"=>"","categorielist"=>$dataarray,"productlist"=>$dbarray);
$carddata = array ("resultdata"=>$filearray);
$resultxml = json_encode($carddata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
print $resultxml;
?>