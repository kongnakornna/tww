<?php
include '../leone.php';
include '../admin/controller/product.php';
header('Content-Type: application/json; charset=utf-8');
$product = new product();

$productdata = $product->getbranddata();
if (sizeof($productdata) > 0) {		
	for ($p=0;$p<count($productdata);$p++) {
		$cid[$p] = $productdata[$p]['p_id'];
		$ctitle[$p] = stripslashes($productdata[$p]['p_title']);
	}
	$returnData = getJSonData($cid,$ctitle); 
}
print $returnData;

function getJSonData ($brandid='',$brandname='') {
  $data = "{";
  $data .= "\"resultdata\": {";
  $data .= "\"brandlist\": [";
  $msgdb = count($brandid);
  for ($i=0;$i<$msgdb;$i++) {
	  if ($i==($msgdb-1)) {
         $data .= "{\"brand_id\":\"".$brandid[$i]."\",\"brand_name\":\"".$brandname[$i]."\"}";
	  }else{
           $data .= "{\"brand_id\":\"".$brandid[$i]."\",\"brand_name\":\"".$brandname[$i]."\"},";
	  }
  }
  $data .= "]";
  $data .= "}}";
  return $data;
}
?>