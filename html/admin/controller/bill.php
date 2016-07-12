<?php
Class bill extends MySqlDB {
	function runid () {
		$dbnumber = "";
		$SqlData = "select * from tbl_running where r_id='05' order by r_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $dbnumber = $RowData['r_number'];
			 }
		}

        $newcode = "R" . date("mY") . str_pad ($dbnumber,'5','0',STR_PAD_LEFT);
		$SqlUpdate = "update tbl_running set r_number=r_number+1 where r_id='05'";
		$ResultUpdate = $this->DataExecute($SqlUpdate);
		return $newcode;
	}
}
?>