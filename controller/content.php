<?php
Class content extends MySqlDB {
	function getdata() {
		$RowData = array();
		$SqlData = "select * from tbl_categorie order by c_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData[] = $this->DBfetch_array($ResultData,$t);
			 }
		}
		return $RowData;
	}

	function getdatabycat($value='') {
		$RowData = array();
		$SqlData = "select * from tbl_categorie where c_id='".$value."' order by c_id";
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
		$SqlData = "select * from tbl_categorie where c_id='".$value."' order by c_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $tt_title = $RowData['c_title'];
			 }
		}
		return $tt_title;
	}

	function getbanner($value='') {
		$RowData = array();
		$tt_banner = "";
		$SqlData = "select * from tbl_categorie where c_id='".$value."' order by c_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $tt_banner = $RowData['c_banner'];
			 }
		}
		return $tt_banner;
	}

	function getlistdd($value='') {
		$RowData = array();
		$tt_list = "<option value=\"\"></option>";
		$SqlData = "select * from tbl_categorie order by c_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $tt_id = $RowData['c_id'];
				 $tt_title = $RowData['c_title'];
				 if ($tt_id==$value) {
				    $tt_list .= "<option value=\"".$tt_id."\" selected>".$tt_title."</option>\n";
				 }else{
				    $tt_list .= "<option value=\"".$tt_id."\">".$tt_title."</option>\n";
				 }
			 }
		}
		return $tt_list;
	}

	function getlistdd2($value='') {
		$RowData = array();
		$tt_list = "<option value=\"\">���͡������</option>";
		$SqlData = "select * from tbl_categorie order by c_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $tt_id = $RowData['c_id'];
				 $tt_title = $RowData['c_title'];
				 if ($tt_id==$value) {
				    $tt_list .= "<option value=\"".$tt_id."\" selected>".$tt_title."</option>\n";
				 }else{
				    $tt_list .= "<option value=\"".$tt_id."\">".$tt_title."</option>\n";
				 }
			 }
		}
		return $tt_list;
	}

	function getsubcategoriedd($catid='',$value='') {
		$RowData = array();
		$tt_list = "<option value=\"\">���͡������</option>";
		$SqlData = "select * from tbl_subcategorie where s_catid='".$catid."' and s_service_code!='' order by s_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $tt_id = $RowData['s_serviceid'];
				 $tt_title = $RowData['s_service_code'];
				 if ($tt_id==$value) {
				    $tt_list .= "<option value=\"".$tt_id."\" selected>".$tt_title."</option>\n";
				 }else{
				    $tt_list .= "<option value=\"".$tt_id."\">".$tt_title."</option>\n";
				 }
			 }
		}
		return $tt_list;
	}

	function gettotalsubcategorie($value='') {
		$RowData = array();
		$SqlData = "select * from tbl_subcategorie where s_catid='".$value."' order by s_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		return $RowsData;
	}

	function getservicecode($value='') {
		$service_code = "";
		$RowData = array();
		$SqlData = "select * from tbl_subcategorie where s_serviceid='".$value."' order by s_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $service_code = $RowData['s_service_code'];
			 }
		}
		return $service_code;
	}

	function getservicename($value='') {
		$service_name = "";
		$RowData = array();
		$SqlData = "select * from tbl_subcategorie where s_serviceid='".$value."' order by s_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $service_name = $RowData['s_title_en'];
			 }
		}
		return $service_name;
	}

	function getmessage($value='') {
		$RowData = array();
		$SqlData = "select * from tbl_message where m_id='".$value."' order by m_id";
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