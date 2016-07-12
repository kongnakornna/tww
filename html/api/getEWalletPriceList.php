<?php
include '../leone.php';
header('Content-Type: application/json; charset=utf-8');

$price_array = array ("100","200","500","1000","2000","5000");
for ($i=0;$i<count($price_array);$i++) {    
	 $pricedb[$i] = $price_array[$i];
}
$dataarray = array("result"=>"OK","result_desc"=>"","pricelist"=>$pricedb);

$bookdata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($bookdata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

print $resultxml;
?>