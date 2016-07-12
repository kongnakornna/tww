<?php
require '../leone.php';
header('Content-Type: text/html; charset=tis-620');
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$param_com_1 = (!empty($_REQUEST["com_1"])) ? $_REQUEST["com_1"] : "";
$param_com_2 = (!empty($_REQUEST["com_2"])) ? $_REQUEST["com_2"] : "";
$param_tp_1 = (!empty($_REQUEST["tp_1"])) ? $_REQUEST["tp_1"] : "";
$param_tp_2 = (!empty($_REQUEST["tp_2"])) ? $_REQUEST["tp_2"] : "";
$param_tpf_1 = (!empty($_REQUEST["tpf_1"])) ? $_REQUEST["tpf_1"] : "";
$param_tpf_2 = (!empty($_REQUEST["tpf_2"])) ? $_REQUEST["tpf_2"] : "";
$param_tpa_1 = (!empty($_REQUEST["tpa_1"])) ? $_REQUEST["tpa_1"] : "";
$param_tpa_2 = (!empty($_REQUEST["tpa_2"])) ? $_REQUEST["tpa_2"] : "";
$param_tpfa_1 = (!empty($_REQUEST["tpfa_1"])) ? $_REQUEST["tpfa_1"] : "";
$param_tpfa_2 = (!empty($_REQUEST["tpfa_2"])) ? $_REQUEST["tpfa_2"] : "";

$SqlCheck = "insert into tbl_commission_config (c_com_1,c_com_2,c_tp_1,c_tp_2,c_tpf_1,c_tpf_2,c_tpa_1,c_tpa_2,c_tpfa_1,c_tpfa_2,c_create_by,c_create_date,c_status) values ('".$param_com_1."','".$param_com_2."','".$param_tp_1."','".$param_tp_2."','".$param_tpf_1."','".$param_tpf_2."','".$param_tpa_1."','".$param_tpa_2."','".$param_tpfa_1."','".$param_tpfa_2."','".$_SESSION['mPayUsername']."',now(),'1')";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);

$DatabaseClass->DBClose();
$Web->AlertWinGo("เพิ่มข้อมูลเรียบร้อย.","commissionconfig_view.php");
die();
?>