<?php
Class member extends MySqlDB {
	function getdetailbyid($id='') {
		$RowData = array();
		$SqlData = "select * from tbl_member where m_id='".$id."' order by m_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData[] = $this->DBfetch_array($ResultData,$t);
			 }
		}
		return $RowData;
	}

	function getdetailbymsisdn($msisdn='') {
		$RowData = array();
		$SqlData = "select * from tbl_member where m_mobile='".$msisdn."' order by m_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData[] = $this->DBfetch_array($ResultData,$t);
			 }
		}
		return $RowData;
	}

        function getmemberlist($value='') {
		$RowData = array();
		$tt_id = "";
		$tt_title = "";
		$tt_list = "<option value=\"\">เลือกทั้งหมด</option>";
		$SqlData = "select * from tbl_member where m_code!='' order by m_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $tt_id = $RowData['m_mobile'];
				 $tt_title = $RowData['m_fname'] . " " . $RowData['m_lname'];
				 if ($tt_id==$value) {
				    $tt_list .= "<option value=\"".$tt_id."\" selected>".$tt_title."</option>\n";
				 }else{
				    $tt_list .= "<option value=\"".$tt_id."\">".$tt_title."</option>\n";
				 }
			 }
		}
		return $tt_list;
	}

	function getmembertypedd($value='',$default='') {
		 $type = array("TP","TPF","TPA");
		 $tt_list = "<option value=\"\">".$default."</option>";
		 for ($t=0;$t<count($type);$t++) {
			 if ($type[$t]==$value) {
				$tt_list .= "<option value=\"".$type[$t]."\" selected>".$type[$t]."</option>\n";
			 }else{
				$tt_list .= "<option value=\"".$type[$t]."\">".$type[$t]."</option>\n";
			 }
		 }
		return $tt_list;
	}
}
?>
