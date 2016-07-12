<?php
require '../leone.php';
header('Content-Type: application/json; charset=utf-8');
require '../admin/controller/member.php';
require '../admin/controller/payment.php';
require '../class.phpmailer.php';
$member = new member();
$payment = new payment();

$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";
$param_servicename = (!empty($_REQUEST["servicename"])) ? $_REQUEST["servicename"] : "";
$param_mailto = (!empty($_REQUEST["mailto"])) ? $_REQUEST["mailto"] : "";
$param_refid = (!empty($_REQUEST["refid"])) ? $_REQUEST["refid"] : "";
$param_paiddate = (!empty($_REQUEST["paiddate"])) ? $_REQUEST["paiddate"] : "";

$havepayment = $payment->checkpayment($param_refid,$param_email);
if ($havepayment) {
    $paymentarray = $payment->getpaymentdata($param_refid,$param_email);
    for ($b=0;$b<count($paymentarray);$b++) {
                        $tt_id = $paymentarray[$b]['p_id'];
                        $tt_price = stripslashes($paymentarray[$b]['p_price']);
                        $tt_msisdn = stripslashes($paymentarray[$b]['p_msisdn']);
                        $tt_productid = stripslashes($paymentarray[$b]['p_productid']);
                        $tt_email = stripslashes($paymentarray[$b]['p_email']);
                        $tt_total = stripslashes($paymentarray[$b]['p_total']);
                        $tt_charge = stripslashes($paymentarray[$b]['p_charge']);
    }
}

$Subject = "�Դ��ҹ Easy Card";
$mailbody = "<p>���¹�س�١���</p>";
$mailbody .= "<p>�͡����׹�ѹ��÷���¡�èҡ��ԡ�� <strong>Easy CARD&nbsp;</strong>��Ѻ��� �١�����ѵ��ѵ� ���ʴ���������´��÷���¡�âͧ��ҹ��ҹ��ԡ��&nbsp;<strong>Easy CARD </strong>�ѧ���</p>";
$mailbody .=  "<p>��¡�ê��� ".$String->utf82tis($param_servicename)."</p>";
$mailbody .=  "<p>�Ţ�����ҧ�ԧ (���ʡ�ê����Թ)  ".$param_refid."&nbsp;</p>";
$mailbody .=  "<p>�ӹǹ�Թ &nbsp;".$tt_total." �ҷ (�����Ҹ������� ".$tt_charge." �ҷ)&nbsp;</p>";
$mailbody .=  "<p>�ѹ��� &nbsp; &nbsp; ".$param_paiddate."&nbsp;</p>";
$mailbody .=  "<p>�͢ͺ�س������ԡ�� <strong>Easy CARD</strong> &nbsp;���</p>";
$mailbody .=  '<p>������ &nbsp; <a href="mailto:theboxes.info@gmail.com">theboxes.info@gmail.com</a></p>';
$mailbody .=  "<p>�ٹ���١�������ѹ�� &nbsp;02-953-9400 ��� 129, 097-099-9922, 097-099-9955 &nbsp;&nbsp;</p>";
$mailbody .=  "<p>(* ��س��������쩺Ѻ����������ѡ�ҹ &nbsp; &nbsp;����ѷ ��к͡���� �ӡѴ 18/1 ����Ⱥ��ʧ������ �ǧ�Ҵ��� ࢵ��بѡ� ��ا෾� 10900&nbsp;�繵��᷹ mPAY STATION 㹡���Ѻ���Ф���Թ�����к�ԡ�õ�ҧ�)</p>";

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=tis-620' . "\r\n";
$headers .= 'From: ���´�����Ҫԡ Easy Card <service-member@easycard.club>' . "\r\n";
mail($param_mailto, $Subject, $mailbody, $headers);

$msg = "��س��׹�ѹ�����Ѥ���Ҫԡ �ա���駷ҧ ����������ŧ����¹ �ҡ���ӡ���׹�ѹ ʶҹ���Ҫԡ���������ó� ��Ш��������ö���ԡ����";
$dataarray = array("result"=>"OK","result_desc"=>"");
$bookdata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($bookdata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
print $resultxml;
?>

