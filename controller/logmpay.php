<?php
Class logmpay extends MySqlDB {
	function getmsisdnfromtaxid($txid='') {
		$RowData = array();
		$SqlData = "select * from tbl_logmpay where l_transid='".$txid."' and l_msisdn!='' order by l_id limit 0,1";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $msisdn = $RowData['l_msisdn'];
			 }
		}
		return $msisdn;
	}
}
?>