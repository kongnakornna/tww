<?php
Class banner extends MySqlDB {
	function getbanner() {
		$DateNow = date("Y-m-d");
		$SqlData = "select * from tbl_banner where (b_startdate<='".$DateNow."' and b_enddate>='".$DateNow."') order by b_id desc";
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