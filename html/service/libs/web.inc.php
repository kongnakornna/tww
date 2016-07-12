<?php
Class WebClass {
    function TITLE() {
       global $webtitle;
	   return $webtitle;
    }

	function curPageURL() {
		 $pageURL = 'http';
		 $pageURL .= "://";
		 if ($_SERVER["SERVER_PORT"] != "80") {
			 $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		 } else {
			 $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		 }
	     return $pageURL;
	}

	function curPageName($url) {
		 return substr($url,strrpos($url,"/")+1);
	}

	function ReadDataFile ($filename) {
		if (file_exists ($filename)) {
			$handle = fopen($filename, "rb");
			$contents = '';
			while (!feof($handle)) {
			  $contents .= fread($handle, 8192);
			}
			fclose($handle);
		}else{
            $contents = "";
		}
		return $contents;
	}

	function paging($totalrecord,$recordperpage,$nowpage='',$url='') {
		 $data = "";
		 $totalpage = ceil ($totalrecord/$recordperpage);
		 if ($totalrecord<$recordperpage) $recordperpage = $totalrecord;
         if ($nowpage==1) {
            $rec_start = 1;
			$rec_end = $recordperpage;
		 }else{
            $rec_start = (($nowpage-1) * $recordperpage) + 1;
			$rec_end = $nowpage * $recordperpage;
		 }
         $data .= "<div id='paginglist' style='width:100%;text-align:center;font-size:12px;color:#666'>";
		 
		 if ($nowpage==$totalpage) {	
			 $nextpage = $totalpage;
		 }else{
			 $nextpage = $nowpage+1;
		 }
		 $data .= "<div style=\"float:left;font-size:12px;color:#666;\" align=\"left\">แสดงข้อมูล ".$rec_start." - ".$rec_end." จาก ".$totalrecord."</div>";
		 if ($nowpage=='1') {	
			 $prevpage = '1';
		 }else{
			 $prevpage = $nowpage-1;
		 }
		 $pageinput = "<input type=\"text\" name=\"pg\" id=\"pg\" value=\"".$nowpage."\" style=\"width:30px;border-bottom-width: 1px;border-bottom-style: solid;border-bottom-color: #b6b6b6;border-top-width: 1px;border-top-style: solid;border-top-color: #b6b6b6;border-left-width: 1px;border-left-style: solid;border-left-color: #b6b6b6;border-right-width: 1px;border-right-style: solid;border-right-color: #b6b6b6;\" onkeypress=\"document.location.replace('?page=' + this.value + '&".$url."');\" />";
		 if ($url=='') {
			$data .= "<a href=\"?page=1\"><img src=\"./images/start.gif\" alt=\"หน้าแรก\" title=\"หน้าแรก\" border=\"0\"/></a>&nbsp;&nbsp;<a href=\"?page=".$prevpage."\"><img src=\"./images/previous.gif\" alt=\"ถอย\" title=\"ถอย\" border=\"0\" /></a>&nbsp;&nbsp;" . $pageinput . "&nbsp;ถึง&nbsp;".$totalpage."&nbsp;<a href=\"?page=".$nextpage."\"><img src=\"./images/next.gif\" alt=\"ถัดไป\" title=\"ถัดไป\" border=\"0\" /></a>&nbsp;&nbsp;<a href=\"?page=".$totalpage."\"><img src=\"./images/end.gif\" alt=\"หน้าสุดท้าย\" title=\"หน้าสุดท้าย\" border=\"0\" /></a>";
		 }else{
			$data .= "<a href=\"?page=1&".$url."\"><img src=\"./images/start.gif\" alt=\"หน้าแรก\" title=\"หน้าแรก\" border=\"0\" /></a>&nbsp;&nbsp;<a href=\"?page=".$prevpage."&".$url."\"><img src=\"./images/previous.gif\" alt=\"ถอย\" title=\"ถอย\" border=\"0\" /></a>&nbsp;&nbsp;" . $pageinput . "&nbsp;ถึง&nbsp;".$totalpage."&nbsp;<a href=\"?page=".$nextpage."&".$url."\"><img src=\"./images/next.gif\" alt=\"ถัดไป\" title=\"ถัดไป\" border=\"0\" /></a>&nbsp;&nbsp;<a href=\"?page=".$totalpage."&".$url."\"><img src=\"./images/end.gif\" alt=\"หน้าสุดท้าย\" title=\"หน้าสุดท้าย\" border=\"0\" /></a>";
		 }
		 $data .= "<div style=\"float:right;font-size:10px;color:#fff\" align=\"right\">แสดงข้อมูล ".$rec_start." - ".$rec_end." จาก ".$totalrecord."</div></div>";
		 return $data;
	}

	function checkURLPatern($filename) {
         if (preg_match("/html/i",$filename) || preg_match("/php/i",$filename) || preg_match("/htm/i",$filename)) {
            return true;
		 }else{
            return false;
		 }
	}

	function CheckLanguage($value,$lang) {
	   $lang = strtolower(trim($lang));
	   $value = strtolower(trim($value));
	   if (strlen($value)>0) {
		   if (preg_match("/&/i",$value)) {
			   if ($lang=='th') { 
				  if (preg_match("/ln=en/i",$value)) {
					  $str = "?" . str_replace("ln=en","ln=th",$value);
				  }else{
					  $str = "?".$value;
				  }
			   }else{
				  if (preg_match("/ln=th/i",$value)) {
					  $str =  "?" . str_replace("ln=th","ln=en",$value);
				  }else{
					  $str = "?".$value;
				  }
			   }
		   }else{
			   $str = "?ln=" . $lang;
		   } 
	   }else{
		   $str = "?ln=" . $lang;
	   }
	   return $str;
	}

	function hostCheck($value,$key) {
       $return_value = false;
       $hostarray = explode(",",$value);
       for ($i=0;$i<count($hostarray);$i++) {
           if ($hostarray[$i]==$key) {
			   $return_value=true;
		       continue;
		   }
	   }
       return $return_value;
	}

	function EmailCheck($value,$key) {
       $return_value = false;
       $hostarray = explode(",",$value);
       for ($i=0;$i<count($hostarray);$i++) {
           if ($hostarray[$i]==$key) {
			   $return_value=true;
		       continue;
		   }
	   }
       return $return_value;
	}

    function htmlHead() {
	  global $webdescription,$webkeyword;
      $data = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">\n<HTML>\n<HEAD>\n<TITLE>\n";
	  $data .= $this->TITLE();
	  $data .= "</TITLE>\n<META NAME=\"Author\" CONTENT=\"Preeda S.\">\n<META NAME=\"Keywords\" CONTENT=\"".$webkeyword."\">\n<META NAME=\"Description\" CONTENT=\"".$webdescription."\">\n</HEAD>\n";

       return $data; 
    }

    function htmlBodyHead($value="") {
       return "<body $value>";
    }

    function htmlFooter() {
       return "</body></html>\n";
    }

	 function Redirect($url) {
            echo "<SCRIPT LANGUAGE=\"JavaScript\">\n";
            echo "<!--\n";
            echo "document.location.href = '$url';";
            echo "//-->\n";
            echo "</SCRIPT>\n";
	 }

	 function AlertClose($value) {
            echo "<SCRIPT LANGUAGE=\"JavaScript\">\n";
            echo "<!--\n";
            echo "alert('$value');\n";
			echo "window.close();\n";
            echo "//-->\n";
            echo "</SCRIPT>\n";
	 }

	 function confirmationAlert($question,$iftrue,$iffalse) {
            echo "<SCRIPT LANGUAGE=\"JavaScript\">\n";
            echo "<!--\n";
            echo "if (confirm('".$question."')==true) {\n";
			echo "  document.location.replace('$iftrue');\n";
			echo "}else{\n";
			echo "  document.location.replace('$iffalse');\n";
			echo "}\n";
            echo "//-->\n";
            echo "</SCRIPT>\n";
	 }

	 function AlertCloseAndReload($value) {
            echo "<SCRIPT LANGUAGE=\"JavaScript\">\n";
            echo "<!--\n";
            echo "alert('".$value."');\n";
			echo "window.opener.location.reload();";
			echo "window.close();\n";
            echo "//-->\n";
            echo "</SCRIPT>\n";
	 }

	 function AlertWin($value) {
            echo "<SCRIPT LANGUAGE=\"JavaScript\">\n";
            echo "<!--\n";
            echo "alert('$value');\n";
            echo "history.back();";
            echo "//-->\n";
            echo "</SCRIPT>\n";
	 }

	 function AlertWinGo($value,$url) {
            echo "<SCRIPT LANGUAGE=\"JavaScript\">\n";
            echo "<!--\n";
            echo "alert('$value');\n";
            echo "document.location.href='$url';";
            echo "//-->\n";
            echo "</SCRIPT>\n";
	 }

    function checkLang($data,$lang) {
		$output = explode("/&/i",$data);
		for ($i=0;$i<count($output);$i++) {
			 if (trim($output[$i])=='lang=th' || trim($output[$i])=='lang=en') {
				 $data_array = $this->relang(trim($output[$i]),$lang);
			 }else{
				 $data_array = trim($output[$i]);
			 }
			if ($i==0) {
			   $datae = $data_array;
			}else{
			   $datae .= "&" . $data_array;
			}
		}

		return $datae . $kl;
    }

	function WriteFile ($filename,$data) {
       $fp = fopen($filename,"a+");
	   fputs($fp,$data);
	   fclose($fp);
	   return true;
	}

	function relang($a,$b) {
	   if ($a==$b) {
		   $data = $a;
	   }else{
		   $data = $b;
	   }
	   return $data;
	}

	function getIP(){
		if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			return $_SERVER['HTTP_X_FORWARDED_FOR'];
		}else{
			return $_SERVER['REMOTE_ADDR'];
		}
	}
}
$Web = new WebClass();
?>