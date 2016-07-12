<?php
Class wallet extends MySqlDB {
    function checkwallet($refdate='',$wallet_type='') {
	    $SqlData = "select * from tbl_wallet where w_date='".$refdate."' and w_type ='".$wallet_type."'";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $currval = $RowData['w_value'];
			 }
                     return $currval;	
   	        }
                else {
                     return -1;
                } 	
    }
	
	
	
	
	
	 function checkdeposit($refdate='',$wallet_type='') {
	    $SqlData = "select * from tbl_deposit where d_date='".$refdate."' and d_partner ='".$wallet_type."'";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $currval = $currval + $RowData['amount'];
			 }
                     return $currval;	
   	        }
                else {
                     return 0;
                } 	
    }
	
		
    function getdeposit_list() {
		$RowData = array();
		/*if ($criteria=='') {
		   $SqlData = "";
		}else{
		   $SqlData = " where " .$criteria;
		}*/

		$SqlData = "select * from tbl_deposit order by d_date desc,d_partner asc";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData[] = $this->DBfetch_array($ResultData,$t);
			 }
		}
		return $RowData;
	}
	
	
	
    function getdeposit_list_withdate($startdate='',$enddate='') {
		$RowData = array();
		/*if ($criteria=='') {
		   $SqlData = "";
		}else{
		   $SqlData = " where " .$criteria;
		}*/

		$SqlData = "select * from tbl_deposit where d_date >= '".$startdate."' and d_date <= '".$enddate."' order by d_date desc,d_partner asc";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData[] = $this->DBfetch_array($ResultData,$t);
			 }
		}
		return $RowData;
	}
	
    function insertwallet($refdate='',$wallet_type='',$wallet_value='') {
	    $SqlData = "insert into tbl_wallet (logtime,d_date,w_value,w_type) values (now(),'".addslashes($refdate)."','".addslashes($wallet_value)."','".addslashes($wallet_type)."')";
         	$ResultData = $this->DataExecute($SqlData);
		return true;
    }

	function insertdeposit($add_date='',$wallet_type='',$wallet_value='',$username='',$remark1='',$remark2='') {
	    $SqlData = "insert into tbl_deposit (d_logtime,d_date,d_partner,d_username,amount,d_remark1,d_remark2) values (now(),'".addslashes($add_date)."','".addslashes($wallet_type)."','".addslashes($username)."','".addslashes($wallet_value)."','".addslashes($remark1)."','".addslashes($remark2)."')";
         	$ResultData = $this->DataExecute($SqlData);
		return true;
    }
	
	
    function updatewallet($refdate='',$wallet_value='',$wallet_type='') {
	        $SqlDataUpdate = "update tbl_wallet set w_value='".$wallet_value."',logtime=now() where w_date='".$refdate."' and w_type ='".$wallet_type."'";
		$ResultDataUpdate = $this->DataExecute($SqlDataUpdate);
		return true;
    }
}
?>
