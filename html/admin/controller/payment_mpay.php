<?php
Class paymentmpay extends MySqlDB {	
	function insertCheckBalance($email='',$balance='',$payfor='',$refid='',$mastermobile='',$remark='') {
	    $SqlData = "insert into tbl_payment_mpay (p_date,p_balance,p_payfor,p_email,p_mastermobile,p_refid,p_status,p_remark) values (now(),'".addslashes($balance)."','".addslashes($payfor)."','".addslashes($email)."','".addslashes($mastermobile)."','".addslashes($refid)."','0','".addslashes($remark)."')";
		$ResultData = $this->DataExecute($SqlData);
		return true;
	}

    function checkPaymentRecord($refid='',$email='') {
	    $SqlData = "select * from tbl_payment_mpay where p_refid='".$refid."' and p_email='".strtolower($email)."' order by p_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
            return true;
		}else{
			return false;
		}
	}

	function updateRecord ($payeemobile='',$price='',$refid='',$email='',$txtid='',$status='') {
	    $SqlData = "update tbl_payment_mpay set p_payeemobile='".$payeemobile."',p_price='".$price."',p_status='".strtoupper($status)."',p_transid1='".$txtid."'  where p_refid='".$refid."' and p_email='".$email."'";
                #error_log("sqlData => ".$SqlData."\n",3,"/tmp/mylog.txt"); 
                $ResultData = $this->DataExecute($SqlData);
		return true;
	}

    function extractdata ($value='') {
        $field_array = explode ("&",$value);
        $xmldata = "<data>";
        for ($i=0;$i<count($field_array);$i++) {
			unset($valname);
            $valname = explode ("=",$field_array[$i]);
			$vdata = "";
			for ($t=1;$t<count($valname);$t++) {
				 if ($t>1) {
                    $vdata .= "=".$valname[$t];
				 }else{
                    $vdata .= $valname[$t];
				 }
			}
			if (strtolower($valname[0])=='invoicelist') {
               $xmldata .= "<".$valname[0].">".base64_encode($vdata)."</".$valname[0].">\n";
			}else{
               $xmldata .= "<".$valname[0].">".$vdata."</".$valname[0].">\n";
			}
		}
        $xmldata .= "</data>";
        return $xmldata;
	}
}
?>
