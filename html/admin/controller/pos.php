<?php
Class pos extends MySqlDB {
	function getdata($value='') {
		$RowData = array();
		if ($value=='') {
		   $SqlData = "select * from tbl_poscounter order by p_counterid desc";
		}else{
		   $SqlData = "select * from tbl_poscounter where p_counterid='".$value."' order by p_counterid limit 0,1";
		}
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData[] = $this->DBfetch_array($ResultData,$t);
			 }
		}
		return $RowData;
	}
	
        function getdatabank($value='') {
		$RowData = array();
		if ($value=='') {
		   $SqlData = "select * from tbl_bank_transfer order by b_code desc";
		}else{
		   $SqlData = "select * from tbl_bank_transfer where b_code='".$value."' order by b_code  limit 0,1";
		}
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
