<?php
include "../leone.php";
include "../admin/controller/app.php";
include "../admin/controller/content.php";
include "../admin/controller/partner.php";
header('Content-Type: application/json; charset=utf-8');
$app = new app();
$content = new content();
$partner = new partner();
$param_cat = (!empty($_REQUEST["cat"])) ? $_REQUEST["cat"] : "";
$param_type = (!empty($_REQUEST["type"])) ? $_REQUEST["type"] : "";
$param_sort = (!empty($_REQUEST["sort"])) ? $_REQUEST["sort"] : "";
$param_email = (!empty($_REQUEST["email "])) ? $_REQUEST["email "] : "";

if ($param_sort=='') $param_sort = '1';

$recomapplist = $app->getrecomdata ($param_cat,$param_type,$param_sort,0,200);
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
	 $catename = $content->gettitle($db_cate);
	 $partnername = $partner->getname($db_partner);

	 $fileimg = explode ("|",$db_gallery);

	 $image = "https://www.easycard.club/photo/gallery/".$fileimg[0];

	 $dbarray[$b] = array ("product_id"=>$db_id,"product_showtype"=>$String->tis2utf8($db_showtype),"product_code"=>$String->tis2utf8($db_code),"product_name"=>$String->tis2utf8($db_title),"hilight"=>$String->tis2utf8($db_recom),"product_type"=>$String->tis2utf8($db_type),"owner"=>$String->tis2utf8($partnername),"categorie_code"=>$String->tis2utf8($catecode),"categorie_name"=>$String->tis2utf8($catename),"product_price"=>$String->tis2utf8($db_price),"product_thumb"=>$String->tis2utf8($image));
}
$filearray = array("result"=>"OK","result_desc"=>"","totalrecs"=>$recomapplistrows,"productlist"=>$dbarray);
$carddata = array ("resultdata"=>$filearray);
$resultxml = json_encode($carddata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
print $resultxml;
?>