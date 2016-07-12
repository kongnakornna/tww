<?php
include '../leone.php';
include '../admin/controller/product.php';
header('Content-Type: application/json; charset=utf-8');
$product = new product();
$param_brandid = (!empty($_REQUEST["brandid"])) ? $_REQUEST["brandid"] : "";
$param_typeid = (!empty($_REQUEST["typeid"])) ? $_REQUEST["typeid"] : "";
if ($param_brandid=='') {
	$msg = $String->tis2utf8("ไม่ได้ส่งค่า brandid มาค่ะ");
    $returnData = getJSonData('FAIL',$msg,'','');
}else{
	$productdata = $product->getmodeldata($param_brandid,$param_typeid);
	if (sizeof($productdata) > 0) {		
		for ($p=0;$p<count($productdata);$p++) {
			$cid[$p] = $productdata[$p]['m_id'];
			$ctitle[$p] = str_replace("\"","'",stripslashes($productdata[$p]['m_title']));
			$typeid = stripslashes($productdata[$p]['m_model_type']);
			$typeidarr[$p] = stripslashes($productdata[$p]['m_model_type']);
            $ctype[$p] = $product->getmodeltype($typeid);
		}
		$returnData = getJSonData('OK','',$cid,$ctype,$typeidarr,$ctitle); 
	}else{
		$msg ="ไม่พบข้อมูลค่ะ";
		$returnData = getJSonData('FAIL',$msg,'','','');
	}
}
print $returnData;

function getJSonData ($status='',$status_detail='',$modelid='',$modeltype='',$modeltypeid='',$modelname='') {
  $data = "{";
  $data .= "\"resultdata\": {";
  $data .= "\"result\": \"".$status."\",";
  $data .= "\"result_desc\": \"".$status_detail."\",";
  $data .= "\"modellist\": [";
  $msgdb = count($modelid);
  for ($i=0;$i<$msgdb;$i++) {
	  if ($i==($msgdb-1)) {
         $data .= "{\"model_id\":\"".$modelid[$i]."\",\"model_type_id\":\"".$modeltypeid[$i]."\",\"model_type\":\"".$modeltype[$i]."\",\"model_name\":\"".$modelname[$i]."\"}";
	  }else{
           $data .= "{\"model_id\":\"".$modelid[$i]."\",\"model_type_id\":\"".$modeltypeid[$i]."\",\"model_type\":\"".$modeltype[$i]."\",\"model_name\":\"".$modelname[$i]."\"},";
	  }
  }
  $data .= "]";
  $data .= "}}";
  return $data;
}
?>