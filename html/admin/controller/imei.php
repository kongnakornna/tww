<?php
Class imei extends MySqlDB {
    function getcheck($value='') {
		$ansresult = false;
	    $SqlData = "select * from tbl_model where m_emei='".strtoupper($value)."' order by m_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
           $ansresult = true;
		}
		return $ansresult;
	}

    function getcheckregister($value='') {
		$m_used = "0";
	    $SqlData = "select * from tbl_model where m_emei='".strtoupper($value)."' order by m_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $m_used = $RowData['m_used'];
			 }
		}
		return $m_used;
	}

	function update($value='') {
		$SqlData = "update tbl_model set m_used='Y' where m_emei='".strtoupper($value)."'";
		$ResultData = $this->DataExecute($SqlData);
		return true;
	}

    function getdata($value='') {
		$RowData = array();
		if ($value=='') {
		   $SqlData = "select * from tbl_model order by m_id desc";
		}else{
		   $SqlData = "select * from tbl_model where m_id='".$value."' order by m_id limit 0,1";
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

	function getgroupdd($value='') {
		$RowData = array();
		$tt_list = "<option value=\"\"></option>";
		$SqlData = "select * from tbl_model group by m_type order by m_type";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $tt_title = $RowData['m_type'];
				 if ($tt_title==$value) {
				    $tt_list .= "<option value=\"".$tt_title."\" selected>".$tt_title."</option>\n";
				 }else{
				    $tt_list .= "<option value=\"".$tt_title."\">".$tt_title."</option>\n";
				 }
			 }
		}
		return $tt_list;
	}

    function getlistcount($criteria='',$sortby='') {
		if ($criteria=='') {
		   $SqlData = "";
		}else{
		   $SqlData = " where 1 " .$criteria;
		}

		$SqlData = "select * from tbl_model $SqlData order by m_id " . $sortby;
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		return $RowsData;
	}

    function getlist($criteria='',$sortby='',$min='0',$max='10') {
		$RowData = array();
		if ($criteria=='') {
		   $SqlData = "";
		}else{
		   $SqlData = " where 1 " .$criteria;
		}

		$SqlData = "select * from tbl_model $SqlData order by m_id " . $sortby . " limit $min,$max";
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