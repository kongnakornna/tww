<?php
Class product extends MySqlDB {
	function gettype($value='') {
		$RowData = array();
		$SqlData = "select * from tbl_twzlcd where t_code='".$value."' order by t_code";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $tt_id = $RowData['t_code'];
				 $tt_title = $RowData['t_title'];
			 }
		}
		return $tt_title;
	}

	function getdata($value='') {
		$RowData = array();
		if ($value=='') {
		   $SqlData = "select * from tbl_twzlcd order by t_id desc";
		}else{
		   $SqlData = "select * from tbl_twzlcd where t_code='".$value."' order by t_id limit 0,1";
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

	function getlist($value='') {
		$RowData = array();
		$tt_list = "<option value=\"\">ไม่ระบุ</option>";
		$SqlData = "select * from tbl_twzlcd order by t_code";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $tt_id = $RowData['t_code'];
				 $tt_title = $RowData['t_title'];
				 if ($tt_id==$value) {
				    $tt_list .= "<option value=\"".$tt_id."\" selected>".$tt_title."</option>\n";
				 }else{
				    $tt_list .= "<option value=\"".$tt_id."\">".$tt_title."</option>\n";
				 }
			 }
		}
		return $tt_list;
	}

	function getbrandlist($value='') {
		$RowData = array();
		$tt_list = "<option value=\"\"></option>";
		$SqlData = "select * from tbl_phone_brand order by p_title";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $tt_id = $RowData['p_id'];
				 $tt_title = $RowData['p_title'];
				 if ($tt_id==$value) {
				    $tt_list .= "<option value=\"".$tt_id."\" selected>".$tt_title."</option>\n";
				 }else{
				    $tt_list .= "<option value=\"".$tt_id."\">".$tt_title."</option>\n";
				 }
			 }
		}
		return $tt_list;
	}

	function getbranddata($value='') {
		$RowData = array();
		if ($value=='') {
		   $SqlData = "select * from tbl_phone_brand order by p_title";
		}else{
		   $SqlData = "select * from tbl_phone_brand where p_id='".$value."' order by p_id limit 0,1";
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

	function getbrandname($value='') {
		$RowData = array();
		$SqlData = "select * from tbl_phone_brand where p_id='".$value."' order by p_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $tt_title = $RowData['p_title'];
			 }
		}
		return $tt_title;
	}

	function getmodeldata($value='',$typeid='') {
		$RowData = array();
		if ($typeid=='') {
			$SqlType = "";
		}else{
            $SqlType = " and m_model_type='".$typeid."'";
		}
	    $SqlData = "select * from tbl_phone_model where m_phone_id='".$value."' $SqlType order by m_title";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData[] = $this->DBfetch_array($ResultData,$t);
			 }
		}
		return $RowData;
	}

	function getbrandmodeldd($value='') {
		$phonelist = "<option value=\"\"></option>";
		$RowData = array();
		$SqlData = "select * from tbl_phone_brand order by p_title";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($w=0;$w<$RowsData;$w++) {
				 $RowData = $this->DBfetch_array($ResultData,$w);
				 $tt_id = $RowData['p_id'];
				 $tt_title = $RowData['p_title'];

				 $phonelist .= "<optgroup label=\"".$tt_title."\">\n";

				 $SqlModel = "select * from tbl_phone_model where m_phone_id='".$tt_id."' order by m_title";
				 $ResultModel = $this->DataExecute($SqlModel);
				 $RowsModel = $this->DBNumRows($ResultModel);
				 if ($RowsModel>0) {
					 for ($t=0;$t<$RowsModel;$t++) {
						 $RowModel = $this->DBfetch_array($ResultModel,$t);
						 $tts_id = $RowModel['m_id'];
						 $tts_title = $RowModel['m_title'];
						 $tts_type = $RowModel['m_model_type'];

						 $typename = $this->getmodeltype($tts_type);

						 $vtts = $tt_id.'@'.$tts_id;

						 if ($vtts==trim($value)) {
							$phonelist .= "<option value=\"".$vtts."\" selected>".$tts_title." (".$typename.")</option>\n";
						 }else{
							$phonelist .= "<option value=\"".$vtts."\">".$tts_title." (".$typename.")</option>\n";
						 }
					 }
				 }
                 $phonelist .= "</optgroup>\n";

			 }
		}
		return $phonelist;
	}

	function getmodelname($value='') {
		$SqlData = "select * from tbl_phone_model where m_id='".$value."' order by m_title";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowModel = $this->DBfetch_array($ResultData,$t);
				 $tts_model_type = $RowModel['m_title'];
			 }
		}
		return $tts_model_type;
	}

	function getphonemodeltype($value='') {
		$SqlData = "select * from tbl_phone_model where m_id='".$value."' order by m_title";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowModel = $this->DBfetch_array($ResultData,$t);
				 $tts_model_type = $RowModel['m_model_type'];
			 }
		}
		return $tts_model_type;
	}

	function totalmodel($value='') {
		$SqlData = "select * from tbl_phone_model where m_phone_id='".$value."' order by m_title";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		return $RowsData;
	}

	function getmodeltype($value='') {
		$RowData = array();
	    $SqlData = "select * from tbl_model_type where t_id='".$value."' order by t_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $tt_title = $RowData['t_title'];
			 }
		}
		return $tt_title;
	}

	function getmodeltypedata() {
		$RowData = array();
	    $SqlData = "select * from tbl_model_type order by t_id";
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