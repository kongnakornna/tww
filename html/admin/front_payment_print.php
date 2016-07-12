<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
require './controller/member.php';
require './controller/payment.php';
require './bathtext.php';
header('Content-Type: text/html; charset=tis620');
$member = new member();
$payment = new payment();
$param_orid = (!empty($_REQUEST["orid"])) ? $_REQUEST["orid"] : "";
if ($param_orid=='') {
    $Web->AlertWinGo("เกิดปัญหาขึ้นกับระบบ กรุณาติดต่อผู้ดูแลระบบค่ะ","front_menu.php");
    die();
}else{
	$data = $payment->getdetailbyref($param_orid);
	for ($i=0;$i<count($data);$i++) {
		$db_id = $data[$i]['p_id'];
		$db_type = $data[$i]['p_type'];
		$db_price = $data[$i]['p_price'];
		$db_detail = $data[$i]['p_detail'];
		$db_email = $data[$i]['p_email'];
		$db_status = $data[$i]['p_status'];
		$db_by = $data[$i]['p_addby'];
		$db_date = $DT->ShowDate($data[$i]['p_adddate'],'th');

		$memberdata = $member->getdatabyemail($db_email);

		if ($db_type=='R') {
			$message = "ยกเลิกการเติมเงิน";
		}else{
			$message = "เติมเงิน";
		}
	}

	for ($m=0;$m<count($memberdata);$m++) {
		$m_id = $memberdata[$m]['m_id'];
		$m_fullname = stripslashes($memberdata[$m]['m_fullname']);
		$m_province = stripslashes($memberdata[$m]['m_province']);
		$m_mobile = stripslashes($memberdata[$m]['m_mobile']);
	}


	$baseline=join("",file("./templates/invoice.html"));
	$data1 = str_replace ("[BILLCODE]",$param_orid,$baseline);
	$data2 = str_replace ("[CUSTOMERNAME]",$m_fullname,$data1);
	$data3 = str_replace ("[CSCODE]",$db_by,$data2);
	$data4 = str_replace ("[PRODUCT1]",$message,$data3);
	$data5 = str_replace ("[quantity1]","1",$data4);
	$data6 = str_replace ("[PRICE1]",$db_price,$data5);
	$data7 = str_replace ("[TOTALPRICE1]",$db_price,$data6);
	$data8 = str_replace ("[MOBILE]",$m_mobile,$data7);
	$data9 = str_replace ("[TOTAL]",$db_price,$data8);
	$data10 = str_replace ("[VATPRICE]","0",$data9);
	$data11 = str_replace ("[PRODUCTPRICE]",$db_price,$data10);
	$data12 = str_replace ("[TOTALTEXT]",Cnv_TH_Money($db_price),$data11);
	$data13 = str_replace ("[DATE]",$db_date,$data12);
	$html = str_replace ("[MEMBERCODE]",$db_detail,$data13);
	$DatabaseClass->DBClose();
	print $html;
}
?>