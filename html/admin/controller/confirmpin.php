<?php
Class Confirmpin extends MySqlDB {
    function insert($email='',$ref='',$token='',$partnerid='',$price='',$backurl='',$respurl='',$appcode='',$ref1='',$ref2='',$data='') {
	    $SqlData = "insert into tbl_confirmpin (cp_email,cp_ref,cp_token,cp_partnerid,cp_price,cp_req_date,cp_backurl,cp_respurl,cp_appcode,cp_ref1,cp_ref2,cp_postval) values ('".addslashes($email)."','".addslashes($ref)."','".addslashes($token)."','".addslashes($partnerid)."','".$price."',now(),'".$backurl."','".$respurl."','".$appcode."','".$ref1."','".$ref2."','".addslashes($data)."')";
		$ResultData = $this->DataExecute($SqlData);
		return true;
	}

    function update($ref='',$token='',$url='') {
	    $SqlData = "update tbl_confirmpin set cp_confirm_date=now(),cp_returnurl='".$url."' where cp_ref='".$ref."' and cp_token='".$token."'";
		$ResultData = $this->DataExecute($SqlData);
		return true;
	}

    function updateemail($email='',$sercharge='',$total='',$id='') {
	    $SqlData = "update tbl_confirmpin set cp_email='".strtolower($email)."',cp_charge='".$sercharge."',cp_total='".$total."' where cp_id='".$id."'";
		$ResultData = $this->DataExecute($SqlData);
		return true;
	}

    function updaterespanswer($status='',$data='',$ref='') {
	    $SqlData = "update tbl_confirmpin set cp_respurl_rec='".$status."',cp_respurl_return='".$data."' where cp_ref='".trim($ref)."'";
		$ResultData = $this->DataExecute($SqlData);
		return true;
	}

    function updatebackurlanswer($status='',$id='') {
	    $SqlData = "update tbl_confirmpin set cp_backurl_rec='".$status."' where cp_id='".$id."'";
		$ResultData = $this->DataExecute($SqlData);
		return true;
	}

	function getdata($ref='',$token='') {
		$SqlData = "select * from tbl_confirmpin where cp_token='".trim($token)."' and cp_ref='".trim($ref)."' order by cp_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData[] = $this->DBfetch_array($ResultData,$t);
			 }
		}
		return $RowData;
	}

	function releasetoken($ref='',$token='') {
		$SqlData = "update tbl_confirmpin set cp_token='".trim($token)."-XX' where cp_ref='".trim($ref)."' and cp_token='".$token."'";
		$ResultData = $this->DataExecute($SqlData);
		return $RowData;
	}

 	function getdetail($ref='') {
		$SqlData = "select * from tbl_confirmpin where cp_ref='".trim($ref)."' order by cp_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData[] = $this->DBfetch_array($ResultData,$t);
			 }
		}
		return $RowData;
	}

	function checkref($ref='') {
		$responsedata = false;
		$SqlData = "select * from tbl_confirmpin where cp_ref='".trim($ref)."' order by cp_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			$responsedata = true;
		}
		return $responsedata;
	}

	function checkemail($email='') {
		$responsedata = false;
		$SqlData = "select * from tbl_member where m_email='".strtolower($email)."' and m_status='1' order by m_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			$responsedata = true;
		}
		return $responsedata;
	}

	function checkpin($pin='',$email='') {
		$responsedata = false;
		$SqlData = "select * from tbl_member where m_pin='".trim($pin)."' and m_email='".strtolower($email)."' order by m_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			$responsedata = true;
		}
		return $responsedata;
	}
}
?>