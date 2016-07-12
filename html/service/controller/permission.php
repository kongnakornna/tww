<?php
Class permission extends MySqlDB {
	function gettitle($value='') {
        $SqlData = "select * from tbl_permission where p_code='".trim($value)."' order by p_id limit 0,1";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $dbtitle = stripslashes($RowData['p_title']);
			 }
			 unset($RowData);
		}
		return $dbtitle;
	}

    function getdata($value='') {
		$RowData = array();
		if ($value=='') {
		   $SqlData = "select * from tbl_permission order by p_id desc";
		}else{
		   $SqlData = "select * from tbl_permission where p_id='".$value."' order by p_id limit 0,1";
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

	function getcheckboxlist($value='') {
		$list = "";
        $SqlData = "select * from tbl_permission order by p_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $dbcode = $RowData['p_code'];
				 $dbtitle = stripslashes($RowData['p_title']);
                 if ($this->permisscheck ($value,$dbcode)) {
				    $list .= "<input type=\"checkbox\" name=\"permission[]\" id=\"permission[]\" value=\"".$dbcode."\" checked />&nbsp;" . $dbtitle . "<br/>";
				 }else{
			        $list .= "<input type=\"checkbox\" name=\"permission[]\" id=\"permission[]\" value=\"".$dbcode."\" />&nbsp;" . $dbtitle . "<br/>";
				 }
			 }
			 unset($RowData);
		}
		return $list;
	}

	function permisscheck($value,$key) {
       $return_value = false;
       $hostarray = explode("|",$value);
       for ($i=0;$i<count($hostarray);$i++) {
           if ($hostarray[$i]==$key) {
			   $return_value=true;
		       continue;
		   }
	   }
       return $return_value;
	}
}
?>