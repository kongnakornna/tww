<?php
Class user extends MySqlDB {
	function getsalename($value='') {
		$RowData = array();
		$tt_title = "";
		$SqlData = "select * from tbl_username where u_username='".$value."' and u_group='S' order by u_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $tt_title = $RowData['u_shoptitle'];
			 }
		}
		return $tt_title;
	}

	function getdealername($value='') {
		$RowData = array();
		$tt_title = "";
		$SqlData = "select * from tbl_username where u_username='".$value."' and u_group='M' order by u_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $tt_title = $RowData['u_fullname'];
			 }
		}
		return $tt_title;
	}

	function getcode($type='',$value='') {
		$resval = false;
		if ($type=='M') {
		   $SqlData = "select * from tbl_username where u_group='M' and u_username='".strtoupper($value)."' order by u_id";
		}else{
		   $SqlData = "select * from tbl_username where u_group='S' and u_username='".strtoupper($value)."' order by u_id";
		}
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
            $resval = true;
		}
		return $resval;
	}

	function getscodedd($value='') {
		$RowData = array();
		$tt_list = "<option value=\"\">ทั้งหมด</option>";
		$SqlData = "select * from tbl_username where u_group='S' order by u_fullname";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $tt_id = $RowData['u_username'];
				 $tt_title = $RowData['u_shoptitle'];
				 if ($tt_id==$value) {
				    $tt_list .= "<option value=\"".$tt_id."\" selected>".$tt_title."</option>\n";
				 }else{
				    $tt_list .= "<option value=\"".$tt_id."\">".$tt_title."</option>\n";
				 }
			 }
		}
		return $tt_list;
	}

	function getsdcodedd($value='') {
		$RowData = array();
		$tt_list = "<option value=\"\">ทั้งหมด</option>";
		$SqlData = "select * from tbl_username where u_group='M' order by u_fullname";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $tt_id = $RowData['u_username'];
				 $tt_title = $RowData['u_fullname'];
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