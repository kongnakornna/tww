<?php
include "../leone.php";
include "../admin/controller/app.php";
include "../admin/controller/content.php";
include "../admin/controller/partner.php";
include "../admin/controller/payment.php";
header('Content-Type: application/json; charset=utf-8');
$app = new app();
$content = new content();
$partner = new partner();
$payment = new payment();
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";
$param_email = (!empty($_REQUEST["email "])) ? $_REQUEST["email "] : "";

$recomapplist = $app->getdetail ($param_id);
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
	 $db_detail = stripslashes($recomapplist[$b]['p_detail']);
 	 $db_url = stripslashes($recomapplist[$b]['p_url']);
	 $db_clipurl = stripslashes($recomapplist[$b]['p_clipurl']);
	 $db_whatnew = stripslashes($recomapplist[$b]['p_whatnew']);
	 $db_gallery = stripslashes($recomapplist[$b]['p_gallery']);

	 $catecode = $db_cate;
	 $catename = $content->gettitle($db_cate);
	 $partnername = $partner->getname($db_partner);

	 $historyapp = $payment->getapphistory($db_id,strtolower($param_email));
	 if ($historyapp>0) {
		 $bought = "Y";
	 }else{
		 $bought = "N";
	 }

	 $fileimg = explode ("|",$db_gallery);
     $knum = 0;
	 $image = "https://www.easycard.club/photo/gallery/".$fileimg[0];
	 for ($k=1;$k<count($fileimg);$k++) {		
        $galleryimg = "https://www.easycard.club/photo/gallery/" . $fileimg[$k];
		$imggallery[$knum] = array ("photo_" . $k =>$galleryimg);
	    $knum++;
	 }
}

$no = 0;
$totalrate = 0;
$apprate = 0;
$commentdata = $app->getcommentdata($param_id);
$commentdata_rows = count($commentdata);
for ($p=0;$p<$commentdata_rows;$p++) {
	$no++;
    $c_msg = stripslashes(nl2br($commentdata[$p]['c_message']));
    $c_postby = stripslashes($commentdata[$p]['c_postby']);
    $c_rate = stripslashes($commentdata[$p]['c_rate']);

	$totalrate = $totalrate + $c_rate;

	$commentarray[$p] = array ("comment_msg_" . $no=>$String->tis2utf8($c_msg),"comment_postby_" . $no=>$String->tis2utf8($c_postby),"comment_rate_" . $no=>$String->tis2utf8($c_rate));
}

$apprate = ceil($totalrate / $commentdata_rows);


$filearray = array("result"=>"OK","result_desc"=>"","product_id"=>$db_id,"product_code"=>$String->tis2utf8($db_code),"product_showtype"=>$String->tis2utf8($db_showtype),"product_name"=>$String->tis2utf8($db_title),"product_url"=>$String->tis2utf8($db_url),"product_detail"=>$String->tis2utf8($db_detail),"product_whatnew"=>$String->tis2utf8($db_whatnew),"rateing"=>$String->tis2utf8($apprate),"hilight"=>$String->tis2utf8($db_recom),"bought"=>$String->tis2utf8($bought),"product_type"=>$String->tis2utf8($db_type),"owner"=>$String->tis2utf8($partnername),"categorie_code"=>$String->tis2utf8($catecode),"categorie_name"=>$String->tis2utf8($catename),"product_price"=>$String->tis2utf8($db_price),"product_thumb"=>$String->tis2utf8($image),"comment"=>$commentarray,"photogallery"=>$imggallery);
$carddata = array ("resultdata"=>$filearray);
$resultxml = json_encode($carddata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
print $resultxml;
?>