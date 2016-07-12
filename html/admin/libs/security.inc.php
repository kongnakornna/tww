<?php
Class Security {
    function CheckSession($value,$url) {
       if ($value=='') {
		   Header ("Location: " . $url);
		   die();
	   }
	}

	function showcard($cardno) {
        $cardnumber = Security::ssldecrypt($cardno);
		$cardtext = substr ($cardnumber,0,4) . "********" . substr ($cardnumber,-4);
		return $cardtext;
	}

	function sslencrypt($textToEncrypt) {
       $encryptionMethod = "AES-256-CBC";
	   $secretHash = "25c6c7ff35b9979b151f2136cd13b0ff";
	   $encryptedMessage = openssl_encrypt($textToEncrypt, $encryptionMethod, $secretHash); 
	   return $encryptedMessage;
	}

	function ssldecrypt($textToEncrypt) {
       $encryptionMethod = "AES-256-CBC";
	   $secretHash = "25c6c7ff35b9979b151f2136cd13b0ff";
	   $decryptedMessage = openssl_decrypt($textToEncrypt, $encryptionMethod, $secretHash); 
	   return $decryptedMessage;
	}

	 function Redirect($url) {
            print "<SCRIPT LANGUAGE=\"JavaScript\">\n";
            print "<!--\n";
            print "document.location.replace('$url');";
            print "//-->\n";
            print "</SCRIPT>\n";
	 }

    function HaveSession($value) {
       if (strlen($value)>0) {
           return true; 
	   }else{
           return false; 
	   }
	}

	function getIP(){
		if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			return $_SERVER['HTTP_X_FORWARDED_FOR'];
		}else{
			return $_SERVER['REMOTE_ADDR'];
		}
	}

	function Dot2LongIP ($IPaddr){
		if ($IPaddr == "") {
			return 0;
		} else {
			$ips = explode (".", $IPaddr);
			return ($ips[3] + $ips[2] * 256 + $ips[1] * 256 * 256 + $ips[0] * 256 * 256 * 256);
		}
	}

	function loadCheckIPAddr($value) {
		$RowData = array();
		$DataName = "";
		$SqlData = "select * from tbl_ipcountry where '".$value."' between ip_from and ip_to";
		$ResultData = $this->DataExecute($SqlData);
		$RowsData = $this->DBNumRows($ResultData);
		if ($RowsData>0) {
			for ($q=0;$q<$RowsData;$q++) {
			   $RowData = $this->DBfetch_array($ResultData,$q);
			   $DataName = $RowData['country_code'];
			}
		}
		return $DataName;
	}

	function PermissionCheck($value,$key) {
	   $num=0;
	   $numArray = explode("|",$value);
	   $CountName = count($numArray);
	   for ($i=0;$i<$CountName;$i++) {
			if ($numArray[$i]==$key) {
			   $num=1; 
			}
	   }

	   if ($num==1) {
		   return true;
	   }else{
		   return false;
	   }
	}
}
$Security = new Security();
?>