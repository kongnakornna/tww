<?php
include '../leone.php';
include '../admin/controller/product.php';
header('Content-Type: application/json; charset=utf-8');
$product = new product();

$productdata = $product->getdata();
if (sizeof($productdata) > 0) {		
	for ($p=0;$p<count($productdata);$p++) {
		$cid[$p] = $productdata[$p]['t_code'];
		$ctitle[$p] = stripslashes($productdata[$p]['t_title']);
	}
	$returnData = getJSonData($cid,$ctitle); 
}
print $returnData;

function getJSonData ($productcode='',$productname='') {
  $data = "{";
  $data .= "\"resultdata\": {";
  $data .= "\"lcdlist\": [";
  $msgdb = count($productcode);
  for ($i=0;$i<$msgdb;$i++) {
	  if ($i==($msgdb-1)) {
         $data .= "{\"code\":\"".$productcode[$i]."\",\"title\":\"".$productname[$i]."\"}";
	  }else{
           $data .= "{\"code\":\"".$productcode[$i]."\",\"title\":\"".$productname[$i]."\"},";
	  }
  }
  $data .= "]";
  $data .= "}}";
  return $data;
}
?>