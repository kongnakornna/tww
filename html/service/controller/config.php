<?php
Class config extends MySqlDB {
	function getdata() {
		$RowData = array();
		$SqlData = "select * from tbl_config order by c_code";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData[] = $this->DBfetch_array($ResultData,$t);
			 }
		}
		return $RowData;
	}

	function getbycode($value='') {
		$RowData = array();
		$SqlData = "select * from tbl_config where c_code='".$value."' order by c_code";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $tt_data = $RowData['c_data'];
			 }
		}
		return $tt_data;
	}
}
?>