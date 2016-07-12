<?php
Class authenticate extends MySqlDB {
	function login($username='',$password='') {
		$userarray = array();
        $SqlData = "select * from tbl_username where u_username='".trim($username)."' and u_password=MD5('".trim($password)."') and u_status='1' order by u_id limit 0,1";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $userarray[0] = $RowData['u_username'];
				 $userarray[1] = $RowData['u_fullname'];
				 $userarray[2] = $RowData['u_email'];
			     $userarray[3] = $RowData['u_id'];
		         $userarray[4] = $RowData['u_permission'];
			 }
			 unset($RowData);
		}

		return $userarray;
	}

	function logout($username='') {
		session_destroy();
	}

	function checkimeilogin($username='',$imei='') {
		$responsedata = false;
		$SqlData = "select * from tbl_member where m_email='".trim($username)."' and m_imei='".$imei."' and m_status='1' order by m_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			$responsedata = true;
		}
		return $responsedata;
	}
	
	function memberlogin($username='',$password='',$imei='') {
		$userarray = array();
        $SqlData = "select * from tbl_member where m_email='".trim($username)."' and m_password=MD5('".trim($password)."') and m_imei='".$imei."' and m_status='1' order by m_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $userarray[0] = $RowData['m_code'];
				 $userarray[1] = $RowData['m_fullname'];
				 $userarray[2] = $RowData['m_email'];
			     $userarray[3] = $RowData['m_id'];
			 }
			 unset($RowData);
		}
		return $userarray;
	}

	function memberloginforweb($username='',$password='') {
		$userarray = array();
        $SqlData = "select * from tbl_member where m_email='".trim($username)."' and m_password=MD5('".trim($password)."') and m_status='1' order by m_id limit 0,1";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $userarray[0] = $RowData['m_code'];
				 $userarray[1] = $RowData['m_fullname'];
				 $userarray[2] = $RowData['m_email'];
			     $userarray[3] = $RowData['m_id'];
			 }
			 unset($RowData);
		}
		return $userarray;
	}
}
?>