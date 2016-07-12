<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
require './controller/member.php';
$member = new member();
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";

$memberdata = $member->getdata($param_id);
for ($p=0;$p<count($memberdata);$p++) {
	  $db_id = stripslashes($memberdata[$p]['m_id']);
	  $db_code = stripslashes($memberdata[$p]['m_code']);
}

$SqlCheck1 = "select * from tbl_member_payment where p_membercode='".$db_code."' order by p_id";
$ResultCheck1 = $DatabaseClass->DataExecute($SqlCheck1);
$RowsCheck1 = $DatabaseClass->DBNumRows($ResultCheck1);
if ($RowsCheck1>0) {
	for ($t=0;$t<$RowsCheck1;$t++) {
		 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$t);
		 $dbp_id = $RowCheck['p_id'];
	}
	$SqlPayment = "update tbl_member_payment set p_membercode='' where m_id='".trim($dbp_id)."'";
	$ResultPayment = $DatabaseClass->DataExecute($SqlPayment);
}

$SqlCheck = "delete from tbl_member where m_id='".trim($param_id)."'";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);

$DatabaseClass->DBClose();
$Web->AlertWinGo("ลบข้อมูลเรียบร้อย.","member_view.php");
die();
?>