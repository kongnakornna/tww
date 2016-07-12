<?php
require '../leone.php';
header('Content-Type: application/json; charset=utf-8');
require '../admin/controller/imei.php';
require '../admin/controller/member.php';
require '../admin/controller/payment.php';
require '../class.phpmailer.php';
$imei = new imei();
$member = new member();
$payment = new payment();
error_reporting(E_ALL);
ini_set("display_errors", 1); 
$storearr = array ("71103","TWZ");
$storename = array ("7-11 (�դ�Һ�ԡ������Թ)","TWZ");


$param_imeino = (!empty($_REQUEST["imeino"])) ? $_REQUEST["imeino"] : "";
$param_mobileno = (!empty($_REQUEST["mobileno"])) ? $_REQUEST["mobileno"] : "";
$param_fname = (!empty($_REQUEST["fname"])) ? $_REQUEST["fname"] : "";
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";
$param_address = (!empty($_REQUEST["address"])) ? $_REQUEST["address"] : "";
$param_province = (!empty($_REQUEST["province"])) ? $_REQUEST["province"] : "";
$param_type = (!empty($_REQUEST["type"])) ? $_REQUEST["type"] : "";
$param_saleid = (!empty($_REQUEST["saleid"])) ? $_REQUEST["saleid"] : "";
$param_cardid = (!empty($_REQUEST["cardid"])) ? $_REQUEST["cardid"] : "";
$param_bdate = (!empty($_REQUEST["bdate"])) ? $_REQUEST["bdate"] : "";
$param_pass = (!empty($_REQUEST["pass"])) ? $_REQUEST["pass"] : "";
$param_dcode = (!empty($_REQUEST["dcode"])) ? $_REQUEST["dcode"] : "";
$param_bank = (!empty($_REQUEST["bank"])) ? $_REQUEST["bank"] : "";
$param_bankcode = (!empty($_REQUEST["bankcode"])) ? $_REQUEST["bankcode"] : "";




$param_fname = $String->utf82tis($param_fname);
$param_address = $String->utf82tis($param_address);
$param_saleid = strtoupper($param_saleid);
$param_dcode = strtoupper($param_dcode);

foreach($_REQUEST as $name => $value) {
	$params[$name] = $value;
}

foreach($params as $name => $value) {
	$basedata .= $name . "  :  " . $value . "\n";
}

if ($param_fname=='' || $param_imeino=='' || $param_email=='' ||  $param_province=='') {
	$msg = "��سҢ��������ú�������˹����¤��";
    $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
}else{
	$SqlCheck = "select * from tbl_member where m_email='".trim(strtolower($param_email))."' order by m_id";
	$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
	$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
	if ($RowsCheck>0) {
        $msg = "�ѭ�չ�� �����¡�������";
        $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
	}else{
		$haveimei = $imei->getcheckregister($param_imeino);

		$pattern = "/^[a-zA-Z0-9]*$/i";
		if(preg_match($pattern, $param_pass) || strlen ($param_pass) > 7 ) {          
			if ($param_saleid=='' && $param_dcode==''){
               $personal = "Y";
			}else{
               $personal = "N";
			}

            $keyid = $String->GenPassword(27);
			$bdate = $DT->ConvertDateForSql($param_bdate);
			$param_pincode = $String->GenPassword(6);

			if ($haveimei=="0") {
				$imeicheckoth = $member->imeicheck($param_imeino);
				if ($imeicheckoth) {
					$msg = "�������öŧ����¹�� ��س� �Դ��͡�Ѻ���˹�ҷ��";
                    $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
				}else{
					$xcode = "OTH";
					$mcode = $member->runid ("01");
					$SqlAdd = "insert into tbl_member (m_key,m_bankid,m_bankcode,m_pin,m_type,m_code,m_cardid,m_bdate,m_password,m_saleid,m_dcode,m_registerdate,m_fullname,m_address,m_province,m_mobile,m_imei,m_email,m_status,m_addby,m_adddate,m_producttype,m_productbrand,m_productmodel,m_personal) values ('".$keyid."','".$String->sqlEscape($param_bank)."','".$String->sqlEscape($param_bankcode)."','".$param_pincode."','".$xcode."','".$mcode."','".$param_cardid."','".$bdate."',MD5('".$param_pass."'),'".$String->sqlEscape($param_saleid)."','".$String->sqlEscape($param_dcode)."',now(),'".$String->sqlEscape($param_fname)."','".$String->sqlEscape($param_address)."','".$String->sqlEscape($param_province)."','".$String->sqlEscape($param_mobileno)."','".$String->sqlEscape($param_imeino)."','".$String->sqlEscape(strtolower($param_email))."','0','Mobile',now(),'".$String->sqlEscape($param_type)."','".$String->sqlEscape($param_brand)."','".$String->sqlEscape($param_model)."','".$personal."')";
					$ResultAdd = $DatabaseClass->DataExecute($SqlAdd);

					$imei->update($String->sqlEscape($param_imeino));

					for ($k=0;$k<count($storearr);$k++) {
						if ($storearr[$k]=='71101') {
							$cardno = '36001' . $mcode . '210010';
							$resultbarcode = $barcode->genfor71101($cardno);
						}else if ($storearr[$k]=='71103') {
							$cardno = '36003' . $mcode . '210010';
							$resultbarcode = $barcode->genfor71103($cardno);
						}else if ($storearr[$k]=='BIGC') {
							$cardno = $mcode;
							$resultbarcode = $barcode->genforbigc($cardno);
						}else if ($storearr[$k]=='LOTUS') {
							$cardno = $mcode;
							$resultbarcode = $barcode->genforlotus($cardno);
						}else{
							$cardno = $mcode;
							$resultbarcode = $barcode->genfor($cardno);
						}

						$SqlPayment = "insert into tbl_member_payment (p_title,p_membercode,p_memberemail,p_cardtype,p_cardnumber) values ('".$storename[$k]."','".$mcode."','".strtolower($param_email)."','".$storearr[$k]."','".$cardno."')";
						$ResultPayment = $DatabaseClass->DataExecute($SqlPayment);
					}

					$Subject = "�Դ��ҹ Easy Card";

					$mailbody = "���¹ �س ".$param_fname."<br/>";
					$mailbody .= "&nbsp;&nbsp;�ͺ�س������͡���ԡ�� Easy Card ������͡����ҹ Easy Card �ͧ��ҹ<br/> ���ӡ�ä�ԡ��� �Դ��ҹ Easy Card ���ͷ���� Easy Card �ͧ��ҹ����ö��ҹ ��<br/><br/> <a href=\"https://www.easycard.club/activate.php?i=".$keyid."\" target=\"_blank\">�Դ��ҹ Easy Card</a><br/><br/>(��ѧ�ҡ�ӡ���Դ��ҹ Easy Card ���� ��ҹ����ö Log in �������ԡ����)<br/>�ͺ�س������ԡ�� Easy Card<br/><br/>";
					$mailbody .= "���ʴ������Ѻ���<br/>";

					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=tis-620' . "\r\n";
					$headers .= 'From: ���´�����Ҫԡ Easy Card <service-member@easycard.club>' . "\r\n";
					
                                        $res = mail($param_email, $Subject, $mailbody, $headers);
                                        error_log("register mail => ".$res."\n",3,"/tmp/mylog.txt"); 

				    $msg = "��س��׹�ѹ�����Ѥ���Ҫԡ �ա���駷ҧ ����������ŧ����¹ �ҡ���ӡ���׹�ѹ ʶҹ���Ҫԡ���������ó� ��Ш��������ö���ԡ����";
					$dataarray = array("result"=>"OK","result_desc"=>$String->tis2utf8($msg));
				}
			}else if ($haveimei=="N") {
				$xcode = "TWZ";
				$mcode = $member->runid ("01");
				$SqlAdd = "insert into tbl_member (m_key,m_bankid,m_bankcode,m_pin,m_type,m_code,m_cardid,m_bdate,m_password,m_saleid,m_dcode,m_registerdate,m_fullname,m_address,m_province,m_mobile,m_imei,m_email,m_status,m_addby,m_adddate,m_producttype,m_productbrand,m_productmodel,m_personal) values ('".$keyid."','".$String->sqlEscape($param_bank)."','".$String->sqlEscape($param_bankcode)."','".$param_pincode."','".$xcode."','".$mcode."','".$param_cardid."','".$bdate."',MD5('".$param_pass."'),'".$String->sqlEscape($param_saleid)."','".$String->sqlEscape($param_dcode)."',now(),'".$String->sqlEscape($param_fname)."','".$String->sqlEscape($param_address)."','".$String->sqlEscape($param_province)."','".$String->sqlEscape($param_mobileno)."','".$String->sqlEscape($param_imeino)."','".$String->sqlEscape(strtolower($param_email))."','0','Mobile',now(),'".$String->sqlEscape($param_type)."','".$String->sqlEscape($param_brand)."','".$String->sqlEscape($param_model)."','".$personal."')";
				$ResultAdd = $DatabaseClass->DataExecute($SqlAdd);

				$imei->update($String->sqlEscape($param_imeino));

				for ($k=0;$k<count($storearr);$k++) {
					if ($storearr[$k]=='71101') {
						$cardno = '36001' . $mcode . '210010';
						$resultbarcode = $barcode->genfor71101($cardno);
					}else if ($storearr[$k]=='71103') {
						$cardno = '36003' . $mcode . '210010';
						$resultbarcode = $barcode->genfor71103($cardno);
					}else if ($storearr[$k]=='BIGC') {
						$cardno = $mcode;
						$resultbarcode = $barcode->genforbigc($cardno);
					}else if ($storearr[$k]=='LOTUS') {
						$cardno = $mcode;
						$resultbarcode = $barcode->genforlotus($cardno);
					}else{
						$cardno = $mcode;
						$resultbarcode = $barcode->genfor($cardno);
					}

					 $SqlPayment = "insert into tbl_member_payment (p_title,p_membercode,p_memberemail,p_cardtype,p_cardnumber) values ('".$storename[$k]."','".$mcode."','".strtolower($param_email)."','".$storearr[$k]."','".$cardno."')";
					 $ResultPayment = $DatabaseClass->DataExecute($SqlPayment);
				}	

				$Subject = "�Դ��ҹ Easy Card";

				$mailbody = "���¹ �س ".$param_fname."<br/>";
				$mailbody .= "&nbsp;&nbsp;�ͺ�س������͡���ԡ�� Easy Card ������͡����ҹ Easy Card �ͧ��ҹ<br/> ���ӡ�ä�ԡ��� �Դ��ҹ Easy Card ���ͷ���� Easy Card �ͧ��ҹ����ö��ҹ ��<br/><br/> <a href=\"https://www.easycard.club/activate.php?i=".$keyid."\" target=\"_blank\">�Դ��ҹ Easy Card</a><br/><br/>(��ѧ�ҡ�ӡ���Դ��ҹ Easy Card ���� ��ҹ����ö Log in �������ԡ����)<br/>�ͺ�س������ԡ�� Easy Card<br/><br/>";
				$mailbody .= "���ʴ������Ѻ���<br/>";
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=tis-620' . "\r\n";
				$headers .= 'From: ���´�����Ҫԡ Easy Card <service-member@easycard.club>' . "\r\n";
				$res=mail($param_email, $Subject, $mailbody, $headers);
                             
                                error_log("register mail => ".$res."\n",3,"/tmp/mylog.txt"); 
				
                                $msg = "��س��׹�ѹ�����Ѥ���Ҫԡ �ա���駷ҧ ����������ŧ����¹ �ҡ���ӡ���׹�ѹ ʶҹ���Ҫԡ���������ó� ��Ш��������ö���ԡ����";
                $dataarray = array("result"=>"OK","result_desc"=>$String->tis2utf8($msg));
			}else{
				$msg = "�������öŧ����¹�� ��س� �Դ��͡�Ѻ���˹�ҷ��";
                $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
			}
		}else{
			$msg = "���ʼ�ҹ���١��ͧ����ٻẺ";
            $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
		}
	}
}
$basedata .= "Have IMEI : " .$haveimei . "\n";

$bookdata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($bookdata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

$basedata .= "\n\n" .$resultxml;

$SqlAddLogs = "insert into tbl_logs (l_parameter,l_program) values ('".$basedata."','register.php')";
$ResultAddLogs = $DatabaseClass->DataExecute($SqlAddLogs);
$DatabaseClass->DBClose();
print $resultxml;
?>

