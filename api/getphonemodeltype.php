<?php
include '../leone.php';
include '../admin/controller/product.php';
header('Content-Type: application/json; charset=utf-8');
$product = new product();

$typedata = $product->getmodeltypedata();
if (sizeof($typedata) > 0) {		
	for ($p=0;$p<count($typedata);$p++) {
		$cid[$p] = $typedata[$p]['t_id'];
		$ctitle[$p] = stripslashes($typedata[$p]['t_title']);
	}
	$returnData = getJSonData('OK','',$cid,$ctitle); 
}else{
	$msg = "äÁè¾º¢éÍÁÙÅ¤èÐ";
	$returnData = getJSonData('FAIL',$msg,'','');
}
print $returnData;

function getJSonData ($status='',$status_detail='',$typeid='',$typename='') {
  $data = "{";
  $data .= "\"resultdata\": {";
  $data .= "\"result\": \"".$status."\",";
  $data .= "\"result_desc\": \"".$status_detail."\",";
  $data .= "\"typelist\": [";
  $msgdb = count($typeid);
  for ($i=0;$i<$msgdb;$i++) {
	  if ($i==($msgdb-1)) {
         $data .= "{\"type_id\":\"".$typeid[$i]."\",\"type_name\":\"".$typename[$i]."\"}";
	  }else{
           $data .= "{\"type_id\":\"".$typeid[$i]."\",\"type_name\":\"".$typename[$i]."\"},";
	  }
  }
  $data .= "]";
  $data .= "}}";
  return $data;
}
?>