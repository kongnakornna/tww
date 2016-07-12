<?php
Class payment extends MySqlDB {
    function usedcardno($value='',$price='') {
		if ($price=='') $price = '0';
		if (strlen ($value) > 3) {
			$price = str_replace (",","",$price);
			$SqlData = "update tbl_member set m_price=m_price-".$price." where m_code='".strtoupper($value)."'";
			$ResultData = $this->DataExecute($SqlData);
		}
		return true;
	}

    function updatecardno($value='',$price='') {
		if ($price=='') $price = '0';
		if (strlen ($value) > 3) {
			$price = str_replace (",","",$price);
			$SqlData = "update tbl_member set m_price=m_price+".$price." where m_code='".strtoupper($value)."'";
			$ResultData = $this->DataExecute($SqlData);
		}
		return true;
	}

       function usedcardnobyemail($value='',$price='') {
		if ($price=='') $price = '0';
		if (strlen ($value) > 3) {
			$price = str_replace (",","",$price);
			$SqlData = "update tbl_member set m_price=m_price-".$price." where m_email='".strtolower($value)."'";
			$ResultData = $this->DataExecute($SqlData);
		}
		return true;
	}
       
       function adjustcardnobyemail($value='',$price='') {
		if ($price=='') $price = '0';
		if (strlen ($value) > 3) {
			$price = str_replace (",","",$price);
			$SqlData = "update tbl_member set m_price_sync=".$price." where m_email='".strtolower($value)."'";
			$ResultData = $this->DataExecute($SqlData);
		}
		return true;
	}
    
    function refundcardnobyemail($value='',$price='') {
		if ($price=='') $price = '0';
                if (strlen ($value) > 3) {	
        		$price = str_replace (",","",$price);
			$SqlData = "update tbl_member set m_price=m_price+".$price." where m_email='".strtolower($value)."'";
			$ResultData = $this->DataExecute($SqlData);
                }	
          	return true;
	}

    function updatecardnobyemail($value='',$price='') {
		if ($price=='') $price = '0';
		if (strlen ($value) > 3) {
			$price = str_replace (",","",$price);
			$SqlData = "update tbl_member set m_price=m_price+".$price." where m_email='".strtolower($value)."'";
			$ResultData = $this->DataExecute($SqlData);
		}
		return true;
	}

    function checkfirstpaymentandupdate($value='') {
		$SqlData = "select * from tbl_member where m_email='".strtolower($value)."' and m_first_payment='0000-00-00'";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			$SqlUpdate = "update tbl_member set m_first_payment=now() where m_email='".strtolower($value)."' and m_first_payment='0000-00-00'";
			$ResultUpdate = $this->DataExecute($SqlUpdate);
		}
		return true;
	}

       function checkpayment($refcode='',$email='') {
	    $SqlData = "select * from tbl_payment where p_ref='".$refcode."' and p_email='".strtolower($email)."' order by p_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
            return true;
		}else{
			return false;
		}
	}

	function getpaymentdata($refcode='',$email='') {
		$RowData = array();
		$SqlData = "select * from tbl_payment where p_type = 'I' and p_ref='".$refcode."' and p_email='".strtolower($email)."' order by p_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData[] = $this->DBfetch_array($ResultData,$t);
			 }
		}
		return $RowData;
	}
	
	function getpaymentwait_cancel($startdate='',$enddate='') {
		$RowData = array();
		$SqlData = "select * from tbl_payment where p_type = 'I' and p_adddate >'".$startdate."' and p_adddate<='".$enddate."' and p_status='0' and (p_ref2 is not null or p_txnid_wallet is not null) order by p_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData[] = $this->DBfetch_array($ResultData,$t);
			 }
		}
		return $RowData;
	}
	
        function getpaymentdatabyrefcode($refcode='') {
		$RowData = array();
		$SqlData = "select * from tbl_payment where p_ref='".$refcode."' order by p_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData[] = $this->DBfetch_array($ResultData,$t);
			 }
		}
		return $RowData;
	}
	
	function insertlog($refcode='',$email='',$type='',$module='',$detail='') {
	    $SqlData = "insert into tbl_trans_logging (logtime,refcode,email,type,module,detail) values (now(),'".addslashes($refcode)."','".addslashes($email)."','".addslashes($type)."','".addslashes($module)."','".addslashes($detail)."')";
		$ResultData = $this->DataExecute($SqlData);
		return true;
	}
	
        function insertrefundlog($refcode='',$txnid='',$mytext='') {
	    $SqlData = "insert into tbl_refund_logging (p_ref,p_txnid,p_datetime,p_response) values ('".addslashes($refcode)."','".addslashes($txnid)."',".now().",'".addslashes($mytext)."')";
		$ResultData = $this->DataExecute($SqlData);
		return true;
	}

	function insert($partnercode='',$productid='',$detail='',$type='',$price='',$sercharge='',$total='',$ref='',$ref1='',$ref2='',$reinstall='',$email='',$addby='',$station='',$msisdn='',$status='') {
		$price = str_replace (",","",$price);
	    $SqlData = "insert into tbl_payment (p_partnercode,p_productid,p_station,p_detail,p_type,p_price,p_charge,p_total,p_ref,p_ref1,p_ref2,p_reinstall,p_email,p_msisdn,p_status,p_addby,p_adddate) values ('".addslashes($partnercode)."','".addslashes($productid)."','".addslashes($station)."','".addslashes($detail)."','".addslashes($type)."','".$price."','".$sercharge."','".$total."','".addslashes($ref)."','".addslashes($ref1)."','".addslashes($ref2)."','".strtoupper($reinstall)."','".addslashes(strtolower($email))."','".$msisdn."','".$status."','".$addby."',now())";
		$ResultData = $this->DataExecute($SqlData);
		return true;
	}

	function insertlemon($partnercode='',$productid='',$detail='',$type='',$price='',$sercharge='',$total='',$ref='',$ref1='',$ref2='',$ref3='',$ref4='',$reinstall='',$email='',$addby='',$station='',$msisdn='',$status='') {
		$price = str_replace (",","",$price);
	    $SqlData = "insert into tbl_payment (p_partnercode,p_productid,p_station,p_detail,p_type,p_price,p_charge,p_total,p_ref,p_ref1,p_ref2,p_ref3,p_ref4,p_reinstall,p_email,p_msisdn,p_status,p_addby,p_adddate) values ('".addslashes($partnercode)."','".addslashes($productid)."','".addslashes($station)."','".addslashes($detail)."','".addslashes($type)."','".$price."','".$sercharge."','".$total."','".addslashes($ref)."','".addslashes($ref1)."','".addslashes($ref2)."','".addslashes($ref3)."','".addslashes($ref4)."','".strtoupper($reinstall)."','".addslashes(strtolower($email))."','".$msisdn."','".$status."','".$addby."',now())";
		$ResultData = $this->DataExecute($SqlData);
		return true;
	}
	
        function insertmpay($partnercode='',$productid='',$detail='',$type='',$price='',$sercharge='',$total='',$ref='',$ref1='',$ref2='',$ref3='',$ref4='',$ref5='',$ref6='',$reinstall='',$email='',$addby='',$station='',$msisdn='',$status='') {
		$price = str_replace (",","",$price);
	    $SqlData = "insert into tbl_payment (p_partnercode,p_productid,p_station,p_detail,p_type,p_price,p_charge,p_total,p_ref,p_ref1,p_ref2,p_ref3,p_ref4,p_reinstall,p_email,p_msisdn,p_status,p_addby,p_adddate) values ('".addslashes($partnercode)."','".addslashes($productid)."','".addslashes($station)."','".addslashes($detail)."','".addslashes($type)."','".$price."','".$sercharge."','".$total."','".addslashes($ref)."','".addslashes($ref1)."','".addslashes($ref2)."','".addslashes($ref3)."','".addslashes($ref4)."','".addslashes($ref5)."','".addslahes($ref6)."','".strtoupper($reinstall)."','".addslashes(strtolower($email))."','".$msisdn."','".$status."','".$addby."',now())";
		$ResultData = $this->DataExecute($SqlData);
		return true;
	}
	
        function insertipps($partnercode='',$productid='',$detail='',$type='',$price='',$sercharge='',$total='',$ref='',$ref1='',$ref2='',$ref3='',$ref4='',$reinstall='',$email='',$addby='',$station='',$msisdn='',$status='') {
		$price = str_replace (",","",$price);
	    $SqlData = "insert into tbl_payment (p_partnercode,p_productid,p_station,p_detail,p_type,p_price,p_charge,p_total,p_ref,p_ref1,p_ref2,p_ref3,p_ref4,p_reinstall,p_email,p_msisdn,p_status,p_addby,p_adddate) values ('".addslashes($partnercode)."','".addslashes($productid)."','".addslashes($station)."','".addslashes($detail)."','".addslashes($type)."','".$price."','".$sercharge."','".$total."','".addslashes($ref)."','".addslashes($ref1)."','".addslashes($ref2)."','".addslashes($ref3)."','".addslashes($ref4)."','".strtoupper($reinstall)."','".addslashes(strtolower($email))."','".$msisdn."','".$status."','".$addby."',now())";
		$ResultData = $this->DataExecute($SqlData);
		return true;
	}

	function updatepaymentpayforu($status='',$station='',$remark='',$approvecode='',$approvedate='',$refcode='') {
		$SqlData = "select * from tbl_payment where p_ref2='".$refcode."' order by p_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $db_remark = stripslashes($RowData['p_remark']);
			 }
		}
        $BigRemark = $remark . "\n" . $db_remark;

	    $SqlDataUpdate = "update tbl_payment set p_status='".$status."',p_station='".$station."',p_remark='".addslashes($BigRemark)."',p_approval_code='".$approvecode."',p_approval_detail='".$approvedate."' where p_ref2='".$refcode."'";
		$ResultDataUpdate = $this->DataExecute($SqlDataUpdate);
		return true;
	}

	function getemailfromref($refcode='') {
		$RowData = array();
		$email = "";
		$SqlData = "select * from tbl_payment where p_ref2='".$refcode."' order by p_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $email = $RowData['p_email'];
			 }
		}
		return $email;
	}

    function updaterefund($ref='') {
		if (strlen ($ref) > 3) {
			$SqlData = "update tbl_payment set p_status='9' where p_ref1='".strtoupper($ref)."'";
			$ResultData = $this->DataExecute($SqlData);
		}
		return true;
	}

 	function updatepaymentwait($ref='') { // Wait for confirm from ePay
		if (strlen ($ref) > 3) {
			$SqlData = "update tbl_payment set p_status='3' where p_ref='".trim($ref)."'";
			$ResultData = $this->DataExecute($SqlData);
		}
        return true;
	}

 	function updatepaymentstatus($ref='') {
		if (strlen ($ref) > 3) {
			$SqlData = "update tbl_payment set p_status='1' where p_ref='".trim($ref)."'";
			$ResultData = $this->DataExecute($SqlData);
		}
        return true;
	}
 	
        function updatepaymentmsisdn($ref='',$msisdn='') {
		if (strlen ($ref) > 3) {
			$SqlData = "update tbl_payment set p_msisdn = '".$msisdn."' where p_ref='".trim($ref)."'";
			$ResultData = $this->DataExecute($SqlData);
		}
        return true;
	}
 	
        function updatepaymentstatuswepay($ref='',$tranid='') {
		if (strlen ($ref) > 3) {
			$SqlData = "update tbl_payment set p_status='1',p_ref1='".$tranid."' where p_ref='".trim($ref)."'";
			$ResultData = $this->DataExecute($SqlData);
		}
        return true;
	}

 	function updatepaymentstatusfail($ref='') {
		if (strlen ($ref) > 3) {
			$SqlData = "update tbl_payment set p_status='9' where p_ref='".trim($ref)."'";
			$ResultData = $this->DataExecute($SqlData);
		}
        return true;
	}
        
        function updatepaymentstatuswepayfail($ref='',$tranid='') {
		if (strlen ($ref) > 3) {
			$SqlData = "update tbl_payment set p_status='9',p_ref1='".$tranid."' where p_ref='".trim($ref)."'";
			$ResultData = $this->DataExecute($SqlData);
		}
        return true;
	}

 	function updatepaymentapprovaldata($code='',$detail='',$ref='') {
		if (strlen ($ref) > 3) {
			$SqlData = "update tbl_payment set p_approval_code='".$code."',p_approval_detail='".$detail."' where p_ref='".trim($ref)."'";
			$ResultData = $this->DataExecute($SqlData);
		}
        return true;
	}

 	function updatepaymentremark($remark='',$ref='') {
		if (strlen ($ref) > 3) {
			$SqlData = "update tbl_payment set p_remark='".$remark."' where p_ref='".trim($ref)."'";
			$ResultData = $this->DataExecute($SqlData);
		}
        return true;
	}
 	 
       function updatepaymenttxnid($ref='',$txnid='') {
		if (strlen ($ref) > 3) {
			$SqlData = "update tbl_payment set p_txnid='".$txnid."' where p_ref='".trim($ref)."'";
			$ResultData = $this->DataExecute($SqlData);
		}
        return true;
	}
        function updatepaymenttxnid_wallet($ref='',$txnid='') {
                error_log("myreq ref => ".$ref."\n",3,"/tmp/mylog.txt");
                error_log("myreq txnid => ".$txnid."\n",3,"/tmp/mylog.txt");
		if (strlen ($ref) > 3) {
			$SqlData = "update tbl_payment set p_txnid_wallet='".$txnid."' where p_ref='".trim($ref)."'";
			$ResultData = $this->DataExecute($SqlData);
		}
        return true;
	}

	function getdetailbyref ($value='') {
		$RowData = array();
		$SqlData = "select * from tbl_payment where p_ref1='".$value."' and p_station='TWZ' order by p_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData[] = $this->DBfetch_array($ResultData,$t);
			 }
		}
		return $RowData;
	}

	function getdatafromkeyword ($value='') {
		$RowData = array();
        if ($value!='') {
			$SqlData = "select * from tbl_payment,tbl_member where (p_email=m_email) and (m_fullname like '%".$value."%' or m_fullname like '".$value."%' or m_code like '%".$value."%' or m_code like '".$value."%' or p_detail like '%".$value."%' or p_detail like '".$value."%') and p_type IN ('A') order by p_id desc";
			$ResultData = $this->DataExecute($SqlData);
			$RowsData = $this->DBNumRows($ResultData);
			if ($RowsData>0) {
				 for ($t=0;$t<$RowsData;$t++) {
					 $RowData[] = $this->DBfetch_array($ResultData,$t);
				 }
			}
		}
		return $RowData;
	}

	function getapplist($partner='') {
		if ($partner=='') {
		    $Criteria1 = "";
		}else{
		    $Criteria1 = "and p_partnercode='".$partner."'";
		}

		$RowData = array();
		$tt_list = "<option value=\"\">ทั้งหมด</option>";
		$SqlData = "select p_detail,p_id from tbl_payment where p_type='I' and p_reinstall='N' $Criteria1 group by p_detail order by p_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $tt_id = $RowData['p_id'];
				 $tt_title = $RowData['p_detail'];
				 if ($tt_id==$value) {
				    $tt_list .= "<option value=\"".$tt_title."\" selected>".$tt_title."</option>\n";
				 }else{
				    $tt_list .= "<option value=\"".$tt_title."\">".$tt_title."</option>\n";
				 }
			 }
		}
		return $tt_list;
	}

	function getpaylist($station='') {
		if ($station=='') {
		    $Criteria1 = "";
		}else{
		    $Criteria1 = "and p_station='".$station."'";
		}

		$RowData = array();
		$tt_list = "<option value=\"\">ทั้งหมด</option>";
		$SqlData = "select p_station from tbl_payment where p_type='A' and p_status='1' $Criteria1 group by p_station order by p_station";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $tt_title = $RowData['p_station'];
				 if ($tt_title==$value) {
				    $tt_list .= "<option value=\"".$tt_title."\" selected>".$tt_title."</option>\n";
				 }else{
				    $tt_list .= "<option value=\"".$tt_title."\">".$tt_title."</option>\n";
				 }
			 }
		}
		return $tt_list;
	}

	function getfirstsaving ($email='') {
        $resp = false;
		$SqlData = "select * from tbl_payment where p_email='".strtolower($email)."' and p_type in ('A') order by p_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
            $resp = true;
		}
		return $resp;
	}


	function getfirstbuy ($email='') {
        $resp = false;
		$SqlData = "select * from tbl_payment where p_email='".strtolower($email)."' and p_type in ('I') order by p_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
            $resp = true;
		}
		return $resp;
	}

	function getapphistory ($value='') {
		$SqlData = "select * from tbl_payment where p_detail='".$value."' and p_email='".strtolower($email)."' order by p_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		return $RowsData;
	}

	function getsetupdate ($value='',$email='') {
		$adddate = "";
		$SqlData = "select * from tbl_payment where p_productid='".$value."' and p_email='".strtolower($email)."' order by p_id desc limit 0,1";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $adddate = $RowData['p_adddate'];
			 }
		}
		return $adddate;
	}

	function getbuyhistorycount ($email='') {
		$SqlData = "select * from tbl_payment where p_email='".strtolower($email)."' and p_type in ('B','I') and p_reinstall='N' order by p_id desc";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		return $RowsData;
	}

	function getbuyhistorydata ($email='',$min='0',$max='10') {
		$RowData = array();
		$SqlData = "select * from tbl_payment where p_email='".strtolower($email)."' and p_type in ('B','I') and p_reinstall='N' order by p_id desc limit $min,$max";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData[] = $this->DBfetch_array($ResultData,$t);
			 }
		}
		return $RowData;
	}

	function getwalletdata ($email='',$membercode='') {
		$RowData = array();
		$SqlData = "select * from tbl_payment where (p_email='".strtolower($email)."' or p_detail='".$membercode."') and p_type in ('A') and p_status='1' order by p_id desc";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData[] = $this->DBfetch_array($ResultData,$t);
			 }
		}
		return $RowData;
	}

	function getbuyhistorydataall ($email='') {
		$RowData = array();
		$SqlData = "select * from tbl_payment where p_email='".strtolower($email)."' and p_type in ('B','I') and p_reinstall='N' order by p_id desc";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData[] = $this->DBfetch_array($ResultData,$t);
			 }
		}
		return $RowData;
	}

	function getbuyhistorydataforapp ($email='') {
		$RowData = array();
		$SqlData = "select * from tbl_payment where p_email='".strtolower($email)."' and p_type in ('B','I') and p_reinstall='N' and p_price>0 and p_status = '1' order by p_id desc limit 0,20";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData[] = $this->DBfetch_array($ResultData,$t);
			 }
		}
		return $RowData;
	}
	
        function getdiscounthistorydataforapp ($email='') {
		$RowData = array();
		$SqlData = "select * from tbl_payment where p_email='".strtolower($email)."' and p_type in ('D') and p_reinstall='N' and p_price>0 and p_status = '1' order by p_id desc limit 0,20";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData[] = $this->DBfetch_array($ResultData,$t);
			 }
		}
		return $RowData;
	}

	function getbookcount ($email='') {
		$SqlData = "select * from tbl_payment where p_email='".strtolower($email)."' and p_price not in ('0') and p_reinstall='N' and p_status = '1' order by p_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		return $RowsData;
	}

	function getbook ($email='',$min='0',$max='10') {
		$RowData = array();
		$SqlData = "select * from tbl_payment where p_email='".strtolower($email)."' and p_price not in ('0') and p_reinstall='N' and p_status = '1' order by p_id limit $min,$max";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData[] = $this->DBfetch_array($ResultData,$t);
			 }
		}
		return $RowData;
	}

	function getbookforapp ($email='') {
		$RowData = array();
		$SqlData = "select * from tbl_payment where p_email='".strtolower($email)."' and p_price not in ('0') and p_reinstall='N' and p_status = '1' order by p_adddate desc";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=$RowsData;$t>0;$t--) {
				 $RowData[] = $this->DBfetch_array($ResultData,$t);
			 }
		}
		return $RowData;
	}

	function getbuyhistorycount_cl ($email='',$pcode='') {
		$SqlData = "select * from tbl_payment where p_email='".strtolower($email)."' and p_partnercode='".$pcode."' and p_type in ('B','I') and p_reinstall='N' order by p_id desc";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		return $RowsData;
	}

	function getbuyhistorydata_cl ($email='',$pcode='',$min='0',$max='10') {
		$RowData = array();
		$SqlData = "select * from tbl_payment where p_email='".strtolower($email)."' and p_partnercode='".$pcode."' and p_type in ('B','I') and p_reinstall='N' order by p_id desc limit $min,$max";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData[] = $this->DBfetch_array($ResultData,$t);
			 }
		}
		return $RowData;
	}

	function getcardcodedatafromid ($value='') {
		$RowData = array();
		$SqlData = "select * from tbl_member_payment where p_id='".$value."' order by p_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData[] = $this->DBfetch_array($ResultData,$t);
			 }
		}
		return $RowData;
	}

	function getcardcodefromid ($value='') {
		$cardpayment = "";
		$SqlData = "select * from tbl_member_payment where p_membercode='".$value."' order by p_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $cardpayment = $RowData['p_cardpayment'];
			 }
		}
		return $cardpayment;
	}

	function getmembercodefromcardno ($value='') {
		$cardpayment = "";
		$SqlData = "select * from tbl_member_payment where p_cardtype='TWZ' and p_cardnumber='".$value."' order by p_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $cardpayment = $RowData['p_membercode'];
			 }
		}
		return $cardpayment;
	}

	function getavailiablecard () {
		$cardpayment = "";
		$SqlData = "select * from tbl_member_payment where p_membercode='' order by p_id limit 0,1";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $cardpayment = $RowData['p_cardpayment'];
			 }
		}
		return $cardpayment;
	}

	function getpaymentcard ($value='') {
		$resp = false;
		$SqlData = "select * from tbl_member_payment where p_cardpayment='".$value."' and p_membercode='' order by p_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
            $resp = true;
		}
		return $resp;
	}

    function getlistcount($sortby='') {
		$SqlData = "select * from tbl_member_payment order by p_id " . $sortby;
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		return $RowsData;
	}

    function getlist($sortby='',$min='',$max='') {
		if ($min=='') $min = '0';
		if ($max=='') $max = '10';
		$RowData = array();
		$SqlData = "select * from tbl_member_payment order by p_id " . $sortby . " limit $min,$max";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData[] = $this->DBfetch_array($ResultData,$t);
			 }
		}
		return $RowData;
	}
    
   function geterrormesg($module='',$vendor='',$code='') {
		$SqlData = "select * from tbl_error_message where module='".$module."' and vendor ='".$vendor."' and code ='".$code."'";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $error_mesg = $RowData['ext_error_message'];
			 }
		}
		return $error_mesg;
	}

    function extractresult($result='') {
               static $new_array; 
               if (!is_null($result)) {
               $arrays = explode('&',$result);
               $new_array = array();
               foreach($arrays as $value)
               {
                     list($k,$v)=explode('=',$value);
                    #$arr_name = substr($k,0,8); 
                     $new_array[$k]=$v;
                     #error_log("extract result ".$arr_name.":".$v."\n",3,"/tmp/mylog.txt"); 
                     #error_log("extract result ".$new_array['confirmc'].":".$v."\n",3,"/tmp/mylog.txt"); 
               }
                   return $new_array; 
               }
               else {
                   return null;
               } 
    }
   
    function loggingandroid($result='') {
       $req=''; 
       foreach ($result as $key => $value) 
       {
           $req .= "$key=$value|";  
       }
       return $req;
    }

    function extractresultwepay($result='') {
               static $new_array; 
               if (!is_null($result)) {
               $arrays = explode('|',$result);
               if ($arrays[0] == 'SUCCEED') { 
               $new_array = array();
               foreach($arrays as $value)
               {
                     if ($value == 'SUCCEED') {
                        $new_array['status'] = 'SUCCEED';
                     }
                     else { 
                         list($k,$v)=explode('=',$value);
                         $arr_name = substr($k,0,8); 
                         $new_array[$arr_name]=$v;
                     } 
                     #error_log("extract result ".$arr_name.":".$v."\n",3,"/tmp/mylog.txt"); 
                     #error_log("extract result ".$new_array['confirmc'].":".$v."\n",3,"/tmp/mylog.txt"); 
               }
                   return $new_array; 
               }
              else {
               $new_array = array();
               $new_array['status'] = $arrays[0];
               $new_array['description'] = $arrays[1];
               return $new_array; 
              }  
          } 
          else {
                   return null;
          } 
    }
}
?>
