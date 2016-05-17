<?php
Class app extends MySqlDB {
	function getdetail($id='') {
		$RowData = array();
		$SqlData = "select * from tbl_product where p_id='".$id."' and p_status='1' order by p_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData[] = $this->DBfetch_array($ResultData,$t);
			 }
		}
		return $RowData;
	}

	function getfinddata($keyword='') {
		$RowData = array();
		if ($keyword=='') {
		    $Criteria1 = "";
		}else{
		    $Criteria1 = "and (p_title like '".$keyword."%' or p_title like '%".$keyword."%' or p_detail like '".$keyword."%' or p_detail like '%".$keyword."%')";
		}
		$SqlData = "select * from tbl_product where p_status='1' $Criteria1 order by rand()";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData[] = $this->DBfetch_array($ResultData,$t);
			 }
		}
		return $RowData;
	}

	function getapplist($partner='',$ptype='') {
		if ($partner=='') {
		    $Criteria1 = "";
		}else{
		    $Criteria1 = "and p_partnerid='".$partner."'";
		}
		if ($ptype=='') {
		    $Criteria2 = "";
		}else{
		    $Criteria2 = "and p_type='".$ptype."'";
		}

		$RowData = array();
		$tt_list = "<option value=\"\">ทั้งหมด</option>";
		$SqlData = "select * from tbl_product where p_status='1' $Criteria1 $Criteria2 order by p_id";
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

	function getfinddatatotal($keyword='') {
		if ($keyword=='') {
		    $Criteria1 = "";
		}else{
		    $Criteria1 = "and (p_title like '".$keyword."%' or p_title like '%".$keyword."%')";
		}
		$SqlData = "select * from tbl_product where p_status='1' $Criteria1 order by p_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		return $RowsData;
	}

	function getdatatotal($type='',$cate='',$order='') {
		if ($type=='') {
		    $Criteria1 = "";
		}else{
		    $Criteria1 = "and p_type='".$type."'";
		}
		if ($cate=='') {
			$Criteria2 = "";
		}else{
            $Criteria2 = " and p_categorie='".$cate."'";
		}
		if ($order=='1') {
		    $Criteria3 = "order by p_id desc";
		}else{
		    $Criteria3 = "order by p_id";
		} 
		$SqlData = "select * from tbl_product where p_status='1' $Criteria1 $Criteria2 $Criteria3";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		return $RowsData;
	}

	function getdata($type='',$cate='',$order='',$min='',$max='') {
		$RowData = array();
		if ($min=='') $min = '0';
		if ($max=='') $max = '10';
		if ($type=='') {
		    $Criteria1 = "";
		}else{
		    $Criteria1 = "and p_type='".$type."'";
		}
		if ($cate=='') {
			$Criteria2 = "";
		}else{
            $Criteria2 = " and p_categorie='".$cate."'";
		}
		if ($order=='1') {
		    $Criteria3 = "order by p_id desc";
		}else{
		    $Criteria3 = "order by p_id";
		} 
		$SqlData = "select * from tbl_product where p_status='1' $Criteria1 $Criteria2 $Criteria3 limit $min,$max";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData[] = $this->DBfetch_array($ResultData,$t);
			 }
		}
		return $RowData;
	}

	function getrecomdatatotal($cat='',$type='',$order='') {
		if ($cat!='') {
			$Criteria1 = " and p_categorie='".$cat."'";
		}else{
            $Criteria1 = "";
		}
		if ($type=='') {
		    $Criteria2 = "";
		}else{
		    $Criteria2 = "and p_type='".$type."'";
		}
		if ($order=='1') {
		    $Criteria3 = "order by p_id desc";
		}else{
		    $Criteria3 = "order by rand()";
		} 
	    $SqlData = "select * from tbl_product where p_status='1' $Criteria1 $Criteria2 $Criteria3";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		return $RowsData;
	}

	function getrecomdata($cat='',$type='',$order='',$min='',$max='') {
		$RowData = array();
		if ($min=='') $min = '0';
		if ($max=='') $max = '10';
		if ($cat!='') {
			$Criteria1 = " and p_categorie='".$cat."'";
		}else{
            $Criteria1 = "";
		}
		if ($type=='') {
		    $Criteria2 = "";
		}else{
		    $Criteria2 = "and p_type='".$type."'";
		}
		if ($order=='1') {
		    $Criteria3 = "order by p_id desc";
		}else{
		    $Criteria3 = "order by rand()";
		} 
	    $SqlData = "select * from tbl_product where p_status='1' $Criteria1 $Criteria2 $Criteria3 limit $min,$max";
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
		$SqlData = "select * from tbl_product where p_id='".$value."' order by p_id";
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

	function getcode($value='') {
		$RowData = array();
		$tt_code = "";
		$SqlData = "select * from tbl_product where p_id='".$value."' order by p_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $tt_code = $RowData['p_code'];
			 }
		}
		return $tt_code;
	}

	function getprice($value='') {
		$RowData = array();
		$tt_title = "";
		$SqlData = "select * from tbl_product where p_id='".$value."' and p_status='1' order by p_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $tt_type = $RowData['p_type'];
				 $tt_price = $RowData['p_price'];

				 if ($tt_type=='F') {
					 $price = "0";
				 }else{
					 $price = $tt_price;
				 }
			 }
		}
		return $price;
	}

	function getrelatebyowner($value='',$appid='') {
		$RowData = array();
		$SqlData = "select * from tbl_product where p_partnerid='".$value."' and p_id not in ('".$appid."') and p_status='1' order by p_id desc limit 0,10";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData[] = $this->DBfetch_array($ResultData,$t);
			 }
		}
		return $RowData;
	}

	function countappbyid($value='') {
		$RowData = array();
		$SqlData = "select * from tbl_product where p_partnerid='".$value."' order by p_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		return $RowsData;
	}

	function getappbyid($value='',$min='',$max='') {
		$RowData = array();
	    $SqlData = "select * from tbl_product where p_partnerid='".$value."' order by p_id limit $min,$max";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData[] = $this->DBfetch_array($ResultData,$t);
			 }
		}
		return $RowData;
	}

	function getappowner($value='') {
		$RowData = array();
		$RowPartner = array();
		$tt_title = "";
		$db_title = "";
		$SqlData = "select * from tbl_product where p_id='".$value."' and p_status='1' order by p_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $tt_partnerid = $RowData['p_partnerid'];

				 $SqlPartner = "select * from tbl_partner where p_id='".$tt_partnerid."' order by p_id";
				 $ResultPartner = $this->DataExecute($SqlPartner);
				 $RowsPartner = $this->DBNumRows($ResultPartner);
				 if ($RowsPartner>0) {
					 for ($e=0;$e<$RowsPartner;$e++) {
						 $RowPartner = $this->DBfetch_array($ResultPartner,$e);
						 $db_title = stripslashes($RowPartner['p_title']);
					 }
				 }
			 }
		}
		unset($RowData);
		unset($RowPartner);
		return $db_title;
	}

	function getcommentdata($value='') {
		$RowData = array();
	    $SqlData = "select * from tbl_comment where c_appid='".$value."' order by c_id desc";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData[] = $this->DBfetch_array($ResultData,$t);
			 }
		}
		return $RowData;
	}

    function getrate($appid='') {
        $totalrate = "0";
		$commentdata = $this->getcommentdata($appid);
		$commentdata_rows = count($commentdata);
		for ($p=0;$p<$commentdata_rows;$p++) {
			$c_rate = trim($commentdata[$p]['c_rate']);
			$totalrate = $totalrate + $c_rate;
		}

		$apprate = ceil($totalrate / $commentdata_rows);
		$staraward = $this->getstarmini($apprate);

        return $staraward;
	}

	function getstarmini($value='') {
        $answer = "";
		for ($i=1;$i<=$value;$i++) {
            $answer .= "<img src=\"images/star_s.png\" border=\"0\" class=\"startratemini\" />";
		}

		for ($b=($value+1);$b<=5;$b++) {
            $answer .= "<img src=\"images/star_sb.png\" border=\"0\" class=\"startratemini\" />";
		}
		return $answer;
	}

	function getstarbig($value='') {
        $answer = "";
		for ($i=1;$i<=$value;$i++) {
            $answer .= "<img src=\"images/star_f.png\" border=\"0\" class=\"startrate\" />";
		}

		for ($b=($value+1);$b<=5;$b++) {
            $answer .= "<img src=\"images/star_b.png\" border=\"0\" class=\"startrate\" />";
		}
		return $answer;
	}
}
?>