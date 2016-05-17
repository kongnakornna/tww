<?php
Class partner extends MySqlDB {
	function login($username='',$password='') {
		$userarray = array();
        $SqlData = "select * from tbl_partner where p_username='".trim($username)."' and p_password=MD5('".trim($password)."') and p_status='1' order by p_id limit 0,1";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 $SqlUpdate = "update tbl_partner set p_lastlogin=now() where p_username='".trim($username)."'";
			 $ResultUpdate = $this->DataExecute($SqlUpdate);
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $userarray[0] = $RowData['p_title'];
				 $userarray[1] = $RowData['p_fullname'];
				 $userarray[2] = $RowData['p_email'];
			     $userarray[3] = $RowData['p_id'];
		         $userarray[4] = $RowData['p_code'];
		         $userarray[5] = $RowData['p_lastlogin'];
		         $userarray[6] = $RowData['p_username'];
			 }
			 unset($RowData);
		}
		return $userarray;
	}

	function logout($username='') {
		session_destroy();
	}

    function getdetail($value='') {
		$RowData = array();
		$SqlData = "select * from tbl_partner where p_id='".$value."' order by p_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData[] = $this->DBfetch_array($ResultData,$t);
			 }
		}
		return $RowData;
	}

    function getcode($value='') {
		$RowData = array();
		$SqlData = "select * from tbl_partner where p_id='".$value."' order by p_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $db_code = stripslashes($RowData['p_code']);
			 }
		}
		unset($RowData);
		return $db_code;
	}

    function getnamebycode($value='') {
		$RowData = array();
		$SqlData = "select * from tbl_partner where p_code='".$value."' order by p_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $db_title = stripslashes($RowData['p_title']);
			 }
		}
		unset($RowData);
		return $db_title;
	}

    function getname($value='') {
		$RowData = array();
		$SqlData = "select * from tbl_partner where p_id='".$value."' order by p_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $db_title = stripslashes($RowData['p_title']);
			 }
		}
		unset($RowData);
		return $db_title;
	}

    function getshareapp($value='',$type='') {
		$RowData = array();
		$SqlData = "select * from tbl_partner where p_code='".$value."' order by p_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $db_share = stripslashes($RowData['p_share_app']);
				 $db_inshare = stripslashes($RowData['p_share_inapp']);
			 }
		}
		unset($RowData);
		if ($type=='B') {
		   return $db_share;
		}else{
		   return $db_inshare;
		}
	}

    function havepartner($value='') {
		$ans = false;
		$SqlData = "select * from tbl_partner where p_code='".$value."' order by p_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 $ans = true;
		}
		return $ans;
	}

    function havepartnerbyemail($value='') {
		$ans = false;
		$SqlData = "select * from tbl_partner where p_email='".$value."' order by p_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 $ans = true;
		}
		return $ans;
	}

	function getlistdd($value='') {
		$RowData = array();
		$tt_list = "<option value=\"\"></option>";
		$SqlData = "select * from tbl_partner where p_status='1' order by p_title";
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

	function getlistddcode($value='') {
		$RowData = array();
		$tt_list = "<option value=\"\"></option>";
		$SqlData = "select * from tbl_partner where p_status='1' order by p_title";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $tt_id = $RowData['p_code'];
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

    function getlist($criteria='',$sortby='') {
		$RowData = array();
		if ($criteria=='') {
		   $SqlData = "";
		}else{
		   $SqlData = " where " .$criteria;
		}

		$SqlData = "select * from tbl_partner $SqlData order by p_id " . $sortby;
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData[] = $this->DBfetch_array($ResultData,$t);
			 }
		}
		return $RowData;
	}

	function runid () {
		$dbnumber = "";
		$SqlData = "select * from tbl_running where r_id='04' order by r_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $dbnumber = $RowData['r_number'];
			 }
		}

        $newcode = "P" . date("mY") . str_pad ($dbnumber,'5','0',STR_PAD_LEFT);
		$SqlUpdate = "update tbl_running set r_number=r_number+1 where r_id='04'";
		$ResultUpdate = $this->DataExecute($SqlUpdate);
		return $newcode;
	}
}
?>