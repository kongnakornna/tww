<?php
Class bank extends MySqlDB {
	function getdata() {
		$RowData = array();
		$SqlData = "select * from tbl_bank order by b_id";
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
		$tt_data = "";
		$SqlData = "select * from tbl_bank where b_id='".$value."' order by b_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $tt_data = $RowData['b_title'];
			 }
		}
		return $tt_data;
	}

	function getlist($value='',$default='') {
		$RowData = array();
		$tt_list = "<option value=\"\">".$default."</option>";
		$SqlData = "select * from tbl_bank order by b_title";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $tt_id = $RowData['b_id'];
				 $tt_title = $RowData['b_title'];
				 if ($tt_id==$value) {
				    $tt_list .= "<option value=\"".$tt_id."\" selected>".$tt_title."</option>\n";
				 }else{
				    $tt_list .= "<option value=\"".$tt_id."\">".$tt_title."</option>\n";
				 }
			 }
		}
		return $tt_list;
	}
}
?>