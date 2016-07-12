<?php
Class bank extends MySqlDB {
	function getdata($value='') {
		$RowData = array();
		if ($value=='') {
		   $SqlData = "select * from tbl_bank order by b_id desc";
		}else{
		   $SqlData = "select * from tbl_bank where b_id='".$value."' order by b_id limit 0,1";
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

	function gettitle($value='') {
		$RowData = array();
		$tt_title = "";
		$SqlData = "select * from tbl_bank where b_id='".$value."' order by b_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $tt_id = $RowData['b_id'];
				 $tt_title = $RowData['b_title'];
			 }
		}
		return $tt_title;
	}
	
        function getid($value='') {
		$RowData = array();
		$tt_id = "";
		$SqlData = "select * from tbl_bank where b_title like '%".$value."%' order by b_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $tt_id = $RowData['b_id'];
			 }
		}
		return $tt_id;
	}
	
        function getcode($value='') {
		$RowData = array();
		$tt_code = "";
		$SqlData = "select * from tbl_bank where b_id='".$value."' order by b_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $tt_code = $RowData['b_code'];
			 }
		}
		return $tt_code;
	}

	function getlistdd($value='') {
		$RowData = array();
		$tt_list = "<option value=\"\"></option>";
		$SqlData = "select * from tbl_bank order by b_id";
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
