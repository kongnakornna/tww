<?php
include '../leone.php';
include '../admin/controller/member.php';
include '../admin/controller/province.php';
$member = new member();
$province = new province();
$mdata_array = $member->getallmemberid('');
if (count($mdata_array)>0) {
   foreach ($mdata_array as $mdata) { 
        	$m_id = $mdata['m_id'];
		$m_email = $mdata['m_email'];
		$m_fullname = $mdata['m_fullname'];
		$m_address = $mdata['m_address'];
		$m_province = $mdata['m_province'];
		$m_mobile = $mdata['m_mobile'];
		$m_cardid = $mdata['m_cardid'];
		$m_bdate = $mdata['m_bdate'];
		$m_code = $mdata['m_code'];
	       
                $m_fullname = preg_replace('/[ ]+/',' ',$m_fullname);     
                $m_address = preg_replace('/\n/','',$m_address);     
                $numspace = substr_count($m_fullname,' ');
                if ($numspace == 1) {
                               $mynamearray = preg_split('/\s+/', $m_fullname);
                               $fname = $mynamearray[0];
                               $lname = $mynamearray[1];
                }
                else {
                               $fname = $m_fullname;
                               $lname = " ";
                } 
                 
                /*$datarray = $String->tis2utf8($m_code)."|";
                $datarray .= $String->tis2utf8($fname)."|";
                $datarray .= $String->tis2utf8($lname)."|";
                $datarray .= $String->tis2utf8($m_email)."|";
                $datarray .= $String->tis2utf8($m_address)."|";
                $datarray .= $String->tis2utf8($province->getname($m_province))."|";
                $datarray .= $String->tis2utf8($m_mobile)."|";
                $datarray .= $String->tis2utf8($m_cardid)."|";
                $datarray .= $String->tis2utf8($m_bdate);*/
                $datarray = "200000001777,";
                $datarray .= $m_email.",";
                $datarray .= $m_mobile.",";
                if (strlen($fname) <= 50) { 
                    $datarray .= $String->tis2utf8($fname).",";
                }
                else {
                    $datarray .= $String->tis2utf8(substr($fname,50)).",";
                } 
                if (strlen($lname) <= 50) { 
                   $datarray .= $String->tis2utf8($lname).",";
                }
                else {
                    $datarray .= $String->tis2utf8(substr($lname,50)).",";
                } 
                $datarray .= $m_cardid.",";
                $datarray .= $m_code;
                print $datarray."\n"; 
    }
}

?>
