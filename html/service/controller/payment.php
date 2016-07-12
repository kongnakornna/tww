<?php
Class payment extends MySqlDB {
    function usedcardno($value='',$price='') {
		if ($price=='') $price = '0';
	    $SqlData = "update tbl_member set m_price=m_price-".$price." where m_code='".strtoupper($value)."'";
		$ResultData = $this->DataExecute($SqlData);
		return true;
	}

    function updatecardno($value='',$price='') {
		if ($price=='') $price = '0';
	    $SqlData = "update tbl_member set m_price=m_price+".$price." where m_code='".strtoupper($value)."'";
		$ResultData = $this->DataExecute($SqlData);
		return true;
	}

    function insert($partnercode='',$productid='',$detail='',$type='',$price='',$ref1='',$ref2='',$reinstall='',$email='',$addby='',$station='') {
	    $SqlData = "insert into tbl_payment (p_partnercode,p_productid,p_station,p_detail,p_type,p_price,p_ref1,p_ref2,p_reinstall,p_email,p_status,p_addby,p_adddate) values ('".addslashes($partnercode)."','".addslashes($productid)."','".addslashes($station)."','".addslashes($detail)."','".addslashes($type)."','".$price."','".addslashes($ref1)."','".addslashes($ref2)."','".strtoupper($reinstall)."','".addslashes($email)."','1','".$addby."',now())";
		$ResultData = $this->DataExecute($SqlData);
		return true;
	}

    function updaterefund($value='') {
		if ($price=='') $price = '0';
	    $SqlData = "update tbl_payment set p_status='9' where p_ref2='".strtoupper($value)."'";
		$ResultData = $this->DataExecute($SqlData);
		return true;
	}

	function getdetailbyref ($value='') {
		$RowData = array();
		$SqlData = "select * from tbl_payment where p_ref2='".$value."' order by p_id";
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
			$SqlData = "select * from tbl_payment,tbl_member where (p_email=m_email) and (m_fullname like '%".$value."%' or m_fullname like '".$value."%' or p_email like '%".$value."%' or p_email like '".$value."%') and p_type IN ('A') order by p_id desc";
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

	function getfirstbuy ($email='') {
        $resp = false;
		$SqlData = "select * from tbl_payment where p_email='".$email."' and p_type in ('I') order by p_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
            $resp = true;
		}
		return $resp;
	}

	function getapphistory ($value='') {
		$SqlData = "select * from tbl_payment where p_detail='".$value."' and p_email='".$email."' order by p_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		return $RowsData;
	}

	function getsetupdate ($value='',$email='') {
		$adddate = "";
		$SqlData = "select * from tbl_payment where p_productid='".$value."' and p_email='".$email."' order by p_id desc limit 0,1";
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
		$SqlData = "select * from tbl_payment where p_email='".$email."' and p_type in ('B','I') and p_reinstall='N' order by p_id desc";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		return $RowsData;
	}

	function getbuyhistorydata ($email='',$min='0',$max='10') {
		$RowData = array();
		$SqlData = "select * from tbl_payment where p_email='".$email."' and p_type in ('B','I') and p_reinstall='N' order by p_id desc limit $min,$max";
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
		$SqlData = "select * from tbl_payment where p_email='".$email."' and p_type in ('B','I') and p_reinstall='N' order by p_id desc";
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
		$SqlData = "select * from tbl_payment where p_email='".$email."' and p_type in ('B','I') and p_reinstall='N' and p_price>0 order by p_id desc limit 0,20";
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
		$SqlData = "select * from tbl_payment where p_email='".$email."' and p_price not in ('0') and p_reinstall='N' order by p_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		return $RowsData;
	}

	function getbook ($email='',$min='0',$max='10') {
		$RowData = array();
		$SqlData = "select * from tbl_payment where p_email='".$email."' and p_price not in ('0') and p_reinstall='N' order by p_id limit $min,$max";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData[] = $this->DBfetch_array($ResultData,$t);
			 }
		}
		return $RowData;
	}

	function getfirstwalletdata ($email='',$membercode='') {
		$RowData = array();
		$SqlData = "select * from tbl_payment where (p_email='".$email."' or p_detail='".$membercode."') and p_type in ('A') order by p_id desc";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			return true;
		}else{
		    return false;
		}
	}

	function getbuyhistorycount_cl ($email='',$pcode='') {
		$SqlData = "select * from tbl_payment where p_email='".$email."' and p_partnercode='".$pcode."' and p_type in ('B','I') and p_reinstall='N' order by p_id desc";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		return $RowsData;
	}

	function getbuyhistorydata_cl ($email='',$pcode='',$min='0',$max='10') {
		$RowData = array();
		$SqlData = "select * from tbl_payment where p_email='".$email."' and p_partnercode='".$pcode."' and p_type in ('B','I') and p_reinstall='N' order by p_id desc limit $min,$max";
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
		$SqlData = "select * from tbl_member_payment where p_cardpayment='".$value."' order by p_id";
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
}
?>