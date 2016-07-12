<?php
Class broadcast extends MySqlDB {
    function getbroadcast_list() {
		$RowData = array();

		$SqlData = "select * from tbl_broadcast order by b_logtime desc" ;
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
		$SqlData = "select * from tbl_broadcast where b_logtime >= '".$startdate."' and b_logtime <= '".$enddate."' order by b_logtime desc";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData[] = $this->DBfetch_array($ResultData,$t);
			 }
		}
		return $RowData;
	}
	
    
	function insertbroadcast($add_date='',$broadcast_type='',$broadcast_to='',$broadcast_username='',$broadcast_message='') {
		$broadcast->insertbroadcast(now(),$type,$param_email,$param_username,$param_message);	
	    $SqlData = "insert into tbl_broadcast (b_logtime,b_type,b_to,b_username,b_message) values (now(),'".addslashes($broadcast_type)."','".addslashes($broadcast_to)."','".addslashes($broadcast_username)."','".addslashes($broadcast_message)."')";
       	$ResultData = $this->DataExecute($SqlData);
		return true;
    }
	
	
}
?>
