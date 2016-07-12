<?php
require './leone.php';
header('Content-Type: text/html; charset=tis-620');
$param_code = trim($_REQUEST['code']);
$barcode->gen($param_code);
?>