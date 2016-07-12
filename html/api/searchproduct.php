<?php
include "../leone.php";
include "../admin/controller/app.php";
include "../admin/controller/content.php";
include "../admin/controller/partner.php";
header('Content-Type: application/json; charset=utf-8');
$app = new app();
$content = new content();
$partner = new partner();
$param_keyword = (!empty($_REQUEST["keyword"])) ? $_REQUEST["keyword"] : "";
$param_email = (!empty($_REQUEST["email "])) ? $_REQUEST["email "] : "";

if ($param_keyword=='') {
	$msg = "กรุณาข้อมูลให้ครบตามที่กำหนดด้วยค่ะ";
    $filearray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg),"keyword"=>$String->tis2utf8($param_keyword),"productlist"=>"");
}else{
    $param_keyword = $String->utf82tis($param_keyword);

	$productlist = $app->getfinddata ($param_keyword);
	$productlistrows = count($productlist);
	for ($b=0;$b<$productlistrows;$b++) {   
		 $db_id = $productlist[$b]['p_id'];
		 $db_title = stripslashes($productlist[$b]['p_title']);
		 $db_code = stripslashes($productlist[$b]['p_code']);
		 $db_recom = stripslashes($productlist[$b]['p_recommended']);
		 $db_partner = stripslashes($productlist[$b]['p_partnerid']);
		 $db_type= stripslashes($productlist[$b]['p_type']);
		 $db_cate = stripslashes($productlist[$b]['p_categorie']);
		 $db_gallery = stripslashes($productlist[$b]['p_gallery']);
		 $db_price = stripslashes($productlist[$b]['p_price']);
		 $catecode = $db_cate;
		 $catename = $content->gettitle($db_cate);
		 $partnername = $partner->getname($db_partner);

		 $fileimg = explode ("|",$db_gallery);

		 $image = "https://www.easycard.club/photo/gallery/".$fileimg[0];

		 $dataarray[$b] = array ("product_id"=>$db_id,"product_code"=>$db_code,"product_name"=>$String->tis2utf8($db_title),"hilight"=>$db_recom,"product_type"=>$db_type,"owner"=>$String->tis2utf8($partnername),"categorie_code"=>$catecode,"categorie_name"=>$String->tis2utf8($catename),"db_price"=>$catecode,"product_thumb"=>$String->tis2utf8($image));
	}
    $filearray = array("result"=>"OK","result_desc"=>"","keyword"=>$String->tis2utf8($param_keyword),"productlist"=>$dataarray);
}

$carddata = array ("resultdata"=>$filearray);
$resultxml = json_encode($carddata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
print $resultxml;
?>