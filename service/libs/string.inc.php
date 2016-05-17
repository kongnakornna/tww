<?php
Class String {
    function sqlEscape($value) {
        return mysql_real_escape_string(trim($value));
	}

	function striptag_only($str, $tags) {
		if(!is_array($tags)) {
			$tags = (strpos($str, '>') !== false ? explode('>', str_replace('<', '', $tags)) : array($tags));
			if(end($tags) == '') array_pop($tags);
		}
		foreach($tags as $tag) $str = preg_replace('#</?'.$tag.'[^>]*>#is', '', $str);
		return $str;
	}

	function getextention($value) {
        $temp=explode(".",$value);
        $data=strtolower($temp[sizeof($temp)-1]);
		return $data;
	}

	function cuttext($theText, $txtLength){
		if(strlen($theText) > $txtLength)
			return substr($theText, 0, $txtLength) . "...";
		else
			return $theText;
	}

	function cleantag ($value) {
		$search = array ("'<script[^>]*?>.*?</script>'si",  // Strip out javascript  
						 "'([\r\n])[\s]+'",                 // Strip out white space  
						 "'&(quot|#34);'i",                 // Replace html entities  
						 "'&(amp|#38);'i",  
						 "'&(lt|#60);'i",  
						 "'&(gt|#62);'i",  
						 "'&(nbsp|#160);'i",  
						 "'&(iexcl|#161);'i",  
						 "'&(cent|#162);'i",  
						 "'&(pound|#163);'i",  
						 "'&(copy|#169);'i",  
						 "'&#(\d+);'e");                    // evaluate as php  

		$replace = array ("",  
						  "\\1",  
						  "\"",  
						  "&",  
						  "<",  
						  ">",  
						  " ",  
						  chr(161),  
						  chr(162),  
						  chr(163),  
						  chr(169),  
						  "chr(\\1)"); 
         $content = preg_replace ($search, $replace, $value);  
         return $content;
	}

	function extractParameter($value) {
         if (preg_match('/,/i', $value)) {
            $arrlist = explode(",",$value);
            for ($i=0;$i<count($arrlist);$i++) {
               $data[] = $arrlist[$i];
			}
		 }else{
            $data[] = $value;
		 }
		 return $data;
	}

	function validpassword($passwd){
		$valid = true;	
		$check_chars = array("'", "\"", "=");
		
		foreach($check_chars as $check_char){
			if(strpos($passwd, $check_char) !== false) $valid = false;
		}
		return $valid;
	}

	function word_cleanup ($str){
		$pattern = "/<(\w+)>(\s|&nbsp;)*<\/\1>/" ;
		$str = preg_replace ( $pattern , '' , $str ) ;
	//	return mb_convert_encoding ( $str , 'HTML-ENTITIES' , 'UTF-8' ) ;
	    return $str;
	}

	function GenKey($maxLength) {
		$myChar = "0123456789";
			for ($r=0;$r<6500;$r++) :
			$myText="";
				for ($i=0;$i<$maxLength;$i++) :
					$rand = rand (0,9);
					$myText .= strtolower($myChar{$rand});
				endfor;
			endfor;
		return $myText;
	}

	function GenPassword($maxLength) {
		$myChar = "0123456789abcdefghijklmnopqrstuvwxyz";
		for ($r=0;$r<5500;$r++) :
		  $myText="";
		  for ($i=0;$i<$maxLength;$i++) :
			 $rand = rand (0,35);
			 $myText .= strtolower($myChar{$rand});
		  endfor;
		endfor;
		return $myText;
	}

	function EncodeURL($value) {
	    $myText = urlencode($value);
		return $myText;
	}

	function DecodeURL($value) {
	    $myText = urldecode($value);
		return $myText;
	}

    function utf82tis($string) {
             $str = $string;
             $res = "";
             for ($i = 0; $i < strlen($str); $i++) {
                 if (ord($str[$i]) == 224) {
					  $unicode = ord($str[$i+2]) & 0x3F;
					  $unicode |= (ord($str[$i+1]) & 0x3F) << 6;
					  $unicode |= (ord($str[$i]) & 0x0F) << 12;
					  $res .= chr($unicode-0x0E00+0xA0);
					  $i += 2;
				} else {
					 $res .= $str[$i];
				}
			 }
			 return $res;
	}

	function tis2utf8($tis) {
	   $utf8 = "";
	   for( $i=0 ; $i< strlen($tis) ; $i++ ){
		  $s = substr($tis, $i, 1);
		  $val = ord($s);
		  if( $val < 0x80 ){
			 $utf8 .= $s;
		  } elseif ( ( 0xA1 <= $val and $val <= 0xDA ) or ( 0xDF <= $val and $val <= 0xFB ) ){
			 $unicode = 0x0E00 + $val - 0xA0;
			 $utf8 .= chr( 0xE0 | ($unicode >> 12) );
			 $utf8 .= chr( 0x80 | (($unicode >> 6) & 0x3F) );
			 $utf8 .= chr( 0x80 | ($unicode & 0x3F) );
		  }
	   }
	   return $utf8;
	}
}
$String = new String();
?>