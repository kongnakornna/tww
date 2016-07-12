<?php
include '../leone.php';
header('Content-Type: application/json; charset=utf-8');

$param_membercode = "15070000001";

$resultbarcode = $barcode->genfor711($param_membercode);

?>