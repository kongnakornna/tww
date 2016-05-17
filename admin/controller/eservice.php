<?php
Class eservice extends MySqlDB {
    function getdata($cat='') {
        $RowData = array();
		if ($cat=='') {
            $SqlData = "select * from tbl_eservice where prod_flag = 1 order by e_group,e_id";
		}else{
            $SqlData = "select * from tbl_eservice where prod_flag = 1 and e_cat='".$cat."' order by e_id,e_group";
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
    
    function getdataall($cat='') {
        $RowData = array();
		if ($cat=='') {
            $SqlData = "select * from tbl_eservice where order by e_group,e_id";
		}else{
            $SqlData = "select * from tbl_eservice where e_cat='".$cat."' order by e_group,e_id";
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

	function getserviceid ($code='') {
		$serviceid = "";
		$SqlData = "select * from tbl_eservice where e_code='".$code."' order by e_id";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			 for ($t=0;$t<$RowsData;$t++) {
				 $RowData = $this->DBfetch_array($ResultData,$t);
				 $serviceid = $RowData['e_serviceid'];
			 }
		}
		return $serviceid;
	}

    function getecharge($itemid='') {
        $RowData = array();
        $SqlData = "select * from tbl_eservice where e_code='".$itemid."' order by e_id";
        $ResultData = $this->DataExecute($SqlData);
        $RowsData = $this->DBNumRows($ResultData);
        if ($RowsData>0) {
            for ($t=0;$t<$RowsData;$t++) {
                $RowData = $this->DBfetch_array($ResultData,$t);
				$echarge = $RowData['e_charge'];
            }
        }
        return $echarge;
    }

    function getediscount($itemid='',$memberid='',$price='') {
        $RowData = array();
        $RowDatatemp = array();
        $RowDataoutput = array();
       	$dcode = '';
       	$codetype = '';
       	$memberid_dcode = '';
        error_log("myreq ecode  => ".$itemid."\n",3,"/tmp/mylog.txt"); 
        error_log("myreq memberid  => ".$memberid."\n",3,"/tmp/mylog.txt"); 
        error_log("myreq price  => ".$price."\n",3,"/tmp/mylog.txt"); 
        $SqlData = "select * from tbl_eservice where e_code='".$itemid."'";
        $ResultData = $this->DataExecute($SqlData);
        $RowsData = $this->DBNumRows($ResultData);
        if ($RowsData>0) {
            for ($t=0;$t<$RowsData;$t++) {
                $RowData = $this->DBfetch_array($ResultData,$t);
            }
        }
        
        $SqlData = "select * from tbl_member where m_code='".$memberid."'";
        $ResultData = $this->DataExecute($SqlData);
        $RowsDatatemp = $this->DBNumRows($ResultData);
        if ($RowsDatatemp>0) {
            for ($t=0;$t<$RowsDatatemp;$t++) {
                $RowDatatemp = $this->DBfetch_array($ResultData,$t);
        	$dcode = $RowDatatemp['m_dcode'];
        	$codetype = $RowDatatemp['m_codetype'];
            }
        }
        error_log("codetype  => ".$codetype."\n",3,"/tmp/mylog.txt"); 
        error_log("dcode  => ".$dcode."\n",3,"/tmp/mylog.txt"); 
       
        if ($codetype == 'S' && $dcode != '') { 
        $SqlData = "select * from tbl_username where u_code='".$dcode."'";
        $ResultData = $this->DataExecute($SqlData);
        $RowsDatatemp = $this->DBNumRows($ResultData);
        if ($RowsDatatemp>0) {
            for ($t=0;$t<$RowsData;$t++) {
                $RowsDatatemp = $this->DBfetch_array($ResultData,$t);
        	$memberid_dcode = $RowsDatatemp['member_id'];
            }
        error_log("memberid_code  => ".$memberid_dcode."\n",3,"/tmp/mylog.txt"); 
        }
        }
       
        // Find Discount rate for own and others (Percentage or Fixed)
        if ($RowData['disc_type'] == 'P') { 
            if ($codetype == 'S') {
                $discount_result_own = ($RowData['disc_rate_sd']*$price)/100;
                $rev_share_ipps = ($RowData['rev_share_ipps']*$price)/100;
                $rev_share = ($RowData['rev_share']*$price)/100;
                if ($memberid_dcode != '') {
                    $discount_result_other = ($RowData['disc_rate_d']*$price)/100;
                }
                else {
                    $discount_result_other = 0;
                }
            }
            else {
                $discount_result_own = (($RowData['disc_rate_sd']+$RowData['disc_rate_d'])*$price)/100;
                $rev_share_ipps = ($RowData['rev_share_ipps']*$price)/100;
                $rev_share = ($RowData['rev_share']*$price)/100;
                $discount_result_other = 0;
            }
        }

        else {
            if ($codetype == 'S') {
                $discount_result_own =  $RowData['disc_rate_sd'];
                $rev_share_ipps = $RowData['rev_share_ipps'];
                $rev_share = $RowData['rev_share'];
                if ($memberid_dcode != '') {
                    $discount_result_other = $RowData['disc_rate_d'];
                }
                else {
                    $discount_result_other = 0;
                } 
            }
            else {
                $discount_result_own = $RowData['disc_rate_sd']+$RowData['disc_rate_d'];
                $rev_share_ipps = $RowData['rev_share_ipps'];
                $rev_share = $RowData['rev_share'];
                $discount_result_other = 0;
            }
        }
        $RowDataoutput['memberid_own'] = $memberid ;
        $RowDataoutput['memberid_other'] = $memberid_dcode;
        $RowDataoutput['discount_result_own'] = number_format($discount_result_own,2,'.','');
        $RowDataoutput['discount_result_other'] = number_format($discount_result_other,2,'.','');
        $RowDataoutput['rev_share_ipps'] = number_format($rev_share_ipps,2,'.','');
        $RowDataoutput['rev_share'] = number_format($rev_share,2,'.','');
       
        /* 
        $RowDataoutput['memberid_own'] = $memberid ;
        $RowDataoutput['memberid_other'] = $memberid_dcode;
        $RowDataoutput['discount_result_own'] = $discount_result_own;
        $RowDataoutput['discount_result_other'] = $discount_result_other;
        $RowDataoutput['rev_share_ipps'] = $rev_share_ipps;
        $RowDataoutput['rev_share'] = $rev_share;
        $mytest = number_format($rev_share_ipps,2,'.','');
        */
        error_log("memberid_own  => ".$RowDataoutput['memberid_own']."\n",3,"/tmp/mylog.txt"); 
        error_log("memberid_other  => ".$RowDataoutput['memberid_other']."\n",3,"/tmp/mylog.txt"); 
        error_log("discount_result_own  => ".$RowDataoutput['discount_result_own']."\n",3,"/tmp/mylog.txt"); 
        error_log("discount_result_other  => ".$RowDataoutput['discount_result_other']."\n",3,"/tmp/mylog.txt"); 
        error_log("rev_share_ipps  => ".$RowDataoutput['rev_share_ipps']."\n",3,"/tmp/mylog.txt"); 
        error_log("rev_share  => ".$RowDataoutput['rev_share']."\n",3,"/tmp/mylog.txt"); 

        return $RowDataoutput;
    }
    
    function getediscount1($itemid='',$memberid='',$price='',& $RowDataoutput) {
        $RowData = array();
        $RowDatatemp = array();
        $RowDataoutput = "";	
        $dcode = '';
       	$codetype = '';
       	$memberid_dcode = '';
        error_log("myreq ecode  => ".$itemid."\n",3,"/tmp/mylog.txt"); 
        error_log("myreq memberid  => ".$memberid."\n",3,"/tmp/mylog.txt"); 
        error_log("myreq price  => ".$price."\n",3,"/tmp/mylog.txt"); 
        $SqlData = "select * from tbl_eservice where e_code='".$itemid."'";
        $ResultData = $this->DataExecute($SqlData);
        $RowsData = $this->DBNumRows($ResultData);
        if ($RowsData>0) {
            for ($t=0;$t<$RowsData;$t++) {
                $RowData = $this->DBfetch_array($ResultData,$t);
            }
        }
        
        $SqlData = "select * from tbl_member where m_code='".$memberid."'";
        $ResultData = $this->DataExecute($SqlData);
        $RowsDatatemp = $this->DBNumRows($ResultData);
        if ($RowsDatatemp>0) {
            for ($t=0;$t<$RowsDatatemp;$t++) {
                $RowDatatemp = $this->DBfetch_array($ResultData,$t);
        	$dcode = $RowDatatemp['m_dcode'];
        	$codetype = $RowDatatemp['m_codetype'];
            }
        }
        error_log("codetype  => ".$codetype."\n",3,"/tmp/mylog.txt"); 
        error_log("dcode  => ".$dcode."\n",3,"/tmp/mylog.txt"); 
       
        if ($codetype == 'S' && $dcode != '') { 
        $SqlData = "select * from tbl_username where u_code='".$dcode."'";
        $ResultData = $this->DataExecute($SqlData);
        $RowsDatatemp = $this->DBNumRows($ResultData);
        if ($RowsDatatemp>0) {
            for ($t=0;$t<$RowsData;$t++) {
                $RowsDatatemp = $this->DBfetch_array($ResultData,$t);
        	$memberid_dcode = $RowDatatemp['memberid'];
            }
        }
        }
       
        // Find Discount rate for own and others (Percentage or Fixed)
        if ($RowData['disc_type'] == 'P') { 
            if ($codetype == 'S') {
                $discount_result_own = ($RowData['disc_rate_sd']*$price)/100;
                $rev_share_ipps = ($RowData['rev_share_ipps']*$price)/100;
                $rev_share = ($RowData['rev_share']*$price)/100;
                if ($memberid_dcode != '') {
                    $discount_result_other = ($RowData['disc_rate_d']*$price)/100;
                }
                else {
                    $discount_result_other = 0;
                }
            }
            else {
                $discount_result_own = (($RowData['disc_rate_sd']+$RowData['disc_rate_d'])*$price)/100;
                $rev_share_ipps = ($RowData['rev_share_ipps']*$price)/100;
                $rev_share = ($RowData['rev_share']*$price)/100;
                $discount_result_other = 0;
            }
        }

        else {
            if ($codetype == 'S') {
                $discount_result_own =  $RowData['disc_rate_sd'];
                $rev_share_ipps = $RowData['rev_share_ipps'];
                $rev_share = $RowData['rev_share'];
                if ($memberid_dcode != '') {
                    $discount_result_other = $RowData['disc_rate_d'];
                }
                else {
                    $discount_result_other = 0;
                } 
            }
            else {
                $discount_result_own = $RowData['disc_rate_sd']+$RowData['disc_rate_d'];
                $rev_share_ipps = $RowData['rev_share_ipps'];
                $rev_share = $RowData['rev_share'];
                $discount_result_other = 0;
            }
        }
        
        $RowDataoutput['memberid_own'] = $memberid ;
        $RowDataoutput['memberid_other'] = $memberid_dcode;
        $RowDataoutput['discount_result_own'] = number_format($discount_result_own,2,'.','');
        $RowDataoutput['discount_result_other'] = number_format($discount_result_other,2,'.','');
        $RowDataoutput['rev_share_ipps'] = number_format($rev_share_ipps,2,'.'.'');
        $RowDataoutput['rev_share'] = number_format($rev_share,2,'.','');
        error_log("memberid_own  => ".$RowDataoutput['memberid_own']."\n",3,"/tmp/mylog.txt"); 
        error_log("memberid_other  => ".$RowDataoutput['memberid_other']."\n",3,"/tmp/mylog.txt"); 
        error_log("discount_result_own  => ".$RowDataoutput['discount_result_own']."\n",3,"/tmp/mylog.txt"); 
        error_log("discount_result_own  => ".number_format($discount_result_own,2,'.','')."\n",3,"/tmp/mylog.txt"); 
        error_log("discount_result_other  => ".$RowDataoutput['discount_result_other']."\n",3,"/tmp/mylog.txt"); 
        error_log("rev_share_ipps  => ".$RowDataoutput['rev_share_ipps']."\n",3,"/tmp/mylog.txt"); 
        error_log("rev_share  => ".$RowDataoutput['rev_share']."\n",3,"/tmp/mylog.txt"); 
    }
    
    
    function getegroup($itemid='') {
        $RowData = array();
        $SqlData = "select * from tbl_eservice where e_code='".$itemid."' order by e_id";
        $ResultData = $this->DataExecute($SqlData);
        $RowsData = $this->DBNumRows($ResultData);
        if ($RowsData>0) {
            for ($t=0;$t<$RowsData;$t++) {
                $RowData = $this->DBfetch_array($ResultData,$t);
				$egroup = $RowData['e_group'];
            }
        } 
        return $egroup;
    }
    
    
    function gettitle($itemid='') {
        $RowData = array();
        $SqlData = "select * from tbl_eservice where e_code='".$itemid."' order by e_id";
        $ResultData = $this->DataExecute($SqlData);
        $RowsData = $this->DBNumRows($ResultData);
        if ($RowsData>0) {
            for ($t=0;$t<$RowsData;$t++) {
                $RowData = $this->DBfetch_array($ResultData,$t);
				$dbtitle = $RowData['e_title'];
            }
        }
        return $dbtitle;
    }

   function getpaymentmap($itemid='') {
        $RowData = array();
        $SqlData = "select * from tbl_payment_mapping where e_code='".$itemid."'";
        $ResultData = $this->DataExecute($SqlData);
        $RowsData = $this->DBNumRows($ResultData);
        if ($RowsData>0) {
            for ($t=0;$t<$RowsData;$t++) {
                $RowData = $this->DBfetch_array($ResultData,$t);
		$partnercode = $RowData['e_partnercode'];
            }
        }
        return $partnercode;
    }

    function gettopup($itemid='') {
        $RowData = array();
        if ($itemid=='ES0001') {
           $SqlData = "select * from tbl_topup where t_happy='1' order by t_id";            
        }else if ($itemid=='ES0002') {
           $SqlData = "select * from tbl_topup where t_truemove='1' order by t_id";            
        }else if ($itemid=='ES0003') {
           $SqlData = "select * from tbl_topup where t_truemoveh='1' order by t_id";            
        }else{
           $SqlData = "select * from tbl_topup where t_happy='1' order by t_id";                
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
}
?>
