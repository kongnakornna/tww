<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";
$param_rec = (!empty($_REQUEST["rec"])) ? $_REQUEST["rec"] : "";
$param_catid = (!empty($_REQUEST["catid"])) ? $_REQUEST["catid"] : "";
$param_page = (!empty($_REQUEST["page"])) ? $_REQUEST["page"] : "";
$param_keyword = (!empty($_REQUEST["keyword"])) ? $_REQUEST["keyword"] : "";


$SqlUpdate = "update tbl_product set p_recommended='".$param_rec."' where p_id='".trim($param_id)."'";
$ResultUpdate = $DatabaseClass->DataExecute($SqlUpdate);

$DatabaseClass->DBClose();
$Web->Redirect("product_view.php?keyword=".$param_keyword."&page=".$param_page."&catid=" . $param_catid);
die();
?>