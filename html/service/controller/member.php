<?php
Class member extends MySqlDB {
    function finddata($value='') {
		$RowData = array();
		if ($value!='') {
			$SqlData = "select * from tbl_member where (m_fullname like '%".$value."%' or m_fullname like '".$value."%' or m_email like '%".$value."%' or m_email like '".$value."%'  or m_imei like '%".$value."%' or m_imei like '".$value."%') and m_status='1' order by m_id";
			$ResultData = $this->DataExecute($SqlData);
			$RowsData = $this->DBNumRows($ResultData);
			if ($RowsData>0) {
				 for ($t=0;$t<$RowsData;$t++) {
					 $RowData[] = $this->DBfetch_array($ResultData,$t);
				 }
			}
		}
		return $RowData;
	}

    function insert($partnercode='',$email='',$token='') {
	    $SqlData = "insert into tbl_inappmember (i_partnercode,i_memberemail,i_token,i_register_date) values ('".addslashes($partnercode)."','".addslashes($email)."','".$token."',now())";
		$ResultData = $this->DataExecute($SqlData);
		return true;
	}

    function changepassword($value='',$pass='') {
	    $SqlData = "update tbl_member set m_password=MD5('".$pass."') where m_email='".$value."'";
		$ResultData = $this->DataExecute($SqlData);
		return true;
	}

    function checkcurrentpass($value='',$pass='') {
		$RowData = array();
	    $SqlData = "select * from tbl_member where m_email='".$value."' and m_password=MD5('".$pass."') and m_status='1' order by m_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			return true;
		}else{
		    return false;
		}
	}

    function havemember($value='') {
		$RowData = array();
	    $SqlData = "select * from tbl_member where m_email='".$value."' and m_status='1' order by m_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			return true;
		}else{
		    return false;
		}
	}

    function havememberbycode($value='') {
		$RowData = array();
	    $SqlData = "select * from tbl_member where m_code='".$value."' and m_status='1' order by m_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			return true;
		}else{
		    return false;
		}
	}

    function getnamefromcode($value='') {
		$RowData = array();
		$dbname = "";
	    $SqlData = "select * from tbl_member where m_code='".$value."' and m_status='1' order by m_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $dbname = $RowData['m_fullname'];
			 }
		}
		return $dbname;
	}

	function checktoken($partnercode='',$email='',$token='') {
		$ans = false;
        $SqlData = "select * from tbl_inappmember where i_partnercode='".$partnercode."' and i_memberemail='".trim($email)."' and i_token='".trim($token)."' order by i_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
            $ans = true;
		}
		return $ans;
	}

	function imeicheck($value='') {
		$ans = false;
        $SqlData = "select * from tbl_member where m_imei='".trim($value)."' order by m_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
            $ans = true;
		}
		return $ans;
	}

	function inappcheck($email='',$password='',$imei='') {
		$ans = false;
        $SqlData = "select * from tbl_member where m_email='".trim($email)."' and m_password=MD5('".trim($password)."') and m_imei='".$imei."' and m_status='1' order by m_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
            $ans = true;
		}
		return $ans;
	}

	function inapplogout($partnercode='',$email='') {
		$ans = false;
        $SqlData = "delete from tbl_inappmember where i_partnercode='".$partnercode."' and i_memberemail='".trim($email)."'";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
            $ans = true;
		}
		return $ans;
	}

    function getprice($value='') {
		$RowData = array();
	    $SqlData = "select * from tbl_member where m_email='".$value."' and m_status='1' order by m_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $mprice = $RowData['m_price'];
			 }
		}
		return $mprice;
	}

    function getpoint($value='') {
		$RowData = array();
	    $SqlData = "select * from tbl_member where m_email='".$value."' and m_status='1' order by m_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $mpoint = $RowData['m_point'];
			 }
		}
		return $mpoint;
	}

    function getcodebyemail($value='') {
		$RowData = array();
	    $SqlData = "select * from tbl_member where m_email='".$value."' and m_status='1' order by m_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $mcode = $RowData['m_code'];
			 }
		}
		return $mcode;
	}

    function getemailfromcode($value='') {
		$RowData = array();
	    $SqlData = "select * from tbl_member where m_code='".$value."' and m_status='1' order by m_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $mcode = $RowData['m_email'];
			 }
		}
		return $mcode;
	}

    function getdata($value='') {
		$RowData = array();
		if ($value=='') {
		   $SqlData = "select * from tbl_member order by m_id desc";
		}else{
		   $SqlData = "select * from tbl_member where m_id='".$value."' order by m_id limit 0,1";
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

    function getdatabyemail($value='') {
		$RowData = array();
	    $SqlData = "select * from tbl_member where m_email='".$value."' and m_status='1' order by m_id limit 0,1";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData[] = $this->DBfetch_array($ResultData,$t);
			 }
		}
		return $RowData;
	}

    function getlist($criteria='',$sortby='') {
		$RowData = array();
		if ($criteria=='') {
		   $SqlData = "";
		}else{
		   $SqlData = " and " .$criteria;
		}

		$SqlData = "select * from tbl_member where m_status='1' $SqlData order by m_id " . $sortby;
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData[] = $this->DBfetch_array($ResultData,$t);
			 }
		}
		return $RowData;
	}

	function runid ($code='') {
		$dbnumber = "";
        if ($code=='TWZ') {
			$xcode = "01";
		}else{
			$xcode = "02";
		}

		$SqlData = "select * from tbl_running where r_id='".$xcode."' order by r_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $dbnumber = $RowData['r_number'];
			 }
		}

        $newcode = $code . date("mY") . str_pad ($dbnumber,'5','0',STR_PAD_LEFT);
		$SqlUpdate = "update tbl_running set r_number=r_number+1 where r_id='".$xcode."'";
		$ResultUpdate = $this->DataExecute($SqlUpdate);
		return $newcode;
	}
}
?>