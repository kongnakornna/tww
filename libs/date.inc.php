<?php
Class DateClass {
	function RevertMonth($value) {
		if (strlen($value)==1) $value = '0' . $value;
		switch ($value) {
			case "01":
				return "Jan";
				break;
			case "02":
				return "Feb";
				break;
			case "03":
				return "Mar";
				break;
			case "04":
				return "Apr";
				break;
			case "05":
				return "May";
				break;
			case "06":
				return "Jun";
				break;
			case "07":
				return "Jul";
				break;
			case "08":
				return "Aug";
				break;
			case "09":
				return "Sep";
				break;
			case "10":
				return "Oct";
				break;
			case "11":
				return "Nov";
				break;
			case "12":
				return "Dec";
				break;
		}
	}

	function ShowViewDate($value) {
		if ($value=='0000-00-00') {
			return " - ";
		}else{
			$year = substr($value,0,4);
			$m = strtoupper(substr($value,5,2));
			$day = substr($value,8,2);
			$time = substr($value,11);
			$rdate = date ("l, d F Y",mktime(0, 0, 0, $m, $day, $year)) ." ". $time;
			return $rdate;
		}
	}
	
        function ShowViewDateOnly($value) {
		if ($value=='0000-00-00') {
			return " - ";
		}else{
			$year = substr($value,0,4);
			$m = strtoupper(substr($value,5,2));
			$day = substr($value,8,2);
			$time = substr($value,11);
			$rdate = date ("l, d F Y",mktime(0, 0, 0, $m, $day, $year));
			return $rdate;
		}
	}
        
        function ShowViewTimeOnly($value) {
		if ($value=='0000-00-00') {
			return " - ";
		}else{
			$year = substr($value,0,4);
			$m = strtoupper(substr($value,5,2));
			$day = substr($value,8,2);
			$time = substr($value,11);
			$rdate = $time;
			return $rdate;
		}
	}

	function MailReceiveDate($value) {
		 $MonthArray = Array ("Jan"=>"01","Feb"=>"02","Mar"=>"03","Apr"=>"04","May"=>"05","Jun"=>"06","Jul"=>"07","Aug"=>"08","Sep"=>"09","Oct"=>"10","Nov"=>"11","Dec"=>"12");
		 $data = "";
		 $dValue = trim($value);
		 $datevalue = substr(trim($dValue),0,2);
		 $monthvalue = substr(trim($dValue),3,3);
		 $yearvalue = substr(trim($dValue),7,4);
		 $timevalue = substr(trim($dValue),12,8);
		 $data = $yearvalue . "-" . $MonthArray[$monthvalue] . "-" . $datevalue . " " . $timevalue;

         return $data;
	}

	function ConvertDate($value) {
		if ($value=='' || $value=='dd/mm/yyyy') {
            $rdate = date("Y-m-d");
		}else{
			$year = substr($value,6,4);
			$month =  substr($value,3,2);
			$day = substr($value,0,2);
			$rdate = $year . "-" . $month . "-" . $day;
		}
		return $rdate;
	}

	function ConvertDateForSql($value) {
		if ($value=='' || $value=='dd/mm/yyyy') {
            $rdate = date("Y-m-d");
		}else{
			$year = substr($value,6,4);
			$month =  substr($value,3,2);
			$day = substr($value,0,2);
			if ($year > 2500) $year = $year - 543;
			$rdate = $year . "-" . $month . "-" . $day;
		}
		return $rdate;
	}

	function ShowDate($value,$lang='') {
		if ($lang=='') $lang = "th";
		if ($value=='0000-00-00') {
			return " - ";
		}else{
			$year = substr($value,0,4);
			if ($lang == "th") {
              if ($year < 2550) $year = $year + 543;
			  $MonthArray = Array ("01"=>"ม.ค.","02"=>"ก.พ.","03"=>"มี.ค.","04"=>"เม.ย.","05"=>"พ.ค.","06"=>"มิ.ย.","07"=>"ก.ค.","08"=>"ส.ค.","09"=>"ก.ย.","10"=>"ต.ค.","11"=>"พ.ย.","12"=>"ธ.ค.");
			}else{
			  $MonthArray = Array ("01"=>"Jan","02"=>"Feb","03"=>"March","04"=>"Apr","05"=>"May","06"=>"Jun","07"=>"Jul","08"=>"Aug","09"=>"Sep","10"=>"Oct","11"=>"Nov","12"=>"Dec");
			}
			$m = strtoupper(substr($value,5,2));
			$month = $MonthArray[$m];
			$day = substr($value,8,2);
			$rdate = $day . " " . $month . " " . $year;
			return $rdate;
		}
	}

	function ShowDateDelivery($value) {
		if ($value=='0000-00-00') {
			return " - ";
		}else{
			$year = substr($value,2,2);
			$month = substr($value,5,2);
			$day = substr($value,8,2);
			$time = substr($value,11);
			$rdate = $day . "/" . $month . "/" . $year . " " . $time;
			return $rdate;
		}
	}

	function ShowDateShipment($value) {
		if ($value=='0000-00-00') {
			return " - ";
		}else{
			$year = substr($value,0,4);
			$month = substr($value,5,2);
			$day = substr($value,8,2);
			$rdate = $month . "/" . $day . "/" . $year;
			return $rdate;
		}
	}

	function ShowDateValue($value) {
		if ($value=='0000-00-00') {
			return " - ";
		}else{
			$year = substr($value,0,4);
			$month = substr($value,5,2);
			$day = substr($value,8,2);
			$rdate = $day . "/" . $month . "/" . $year;
			return $rdate;
		}
	}

	function TimeStamp($value) {
		$year = substr($value,0,4);
		$month =  substr($value,5,2);
		$day = substr($value,8,2);
		$hour = substr($value,11,2);
		$min = substr($value,14,2);
		$sec = substr($value,17,2);
		$data = mktime($hour,$min,$sec,$month,$day,$year);
		return $data;
	}

	function ShowLastTime ($value){ 
		if ($value>=60) {
			$dat = $value / 60;
			if ($dat>=60) {
			   $hour = ceil($dat / 60);
			   if ($hour>=24) {
				  $day = ceil($hour / 24);
				  $TextShow = $day . " วัน";
			   }else{
				  $TextShow = $hour . " ชั่วโมง";
			   }
			}else{
			   $TextShow = ceil($dat) . " นาที";
			}
		}else{
            $TextShow = $value . " วินาที";
		}
		return $TextShow;
	}

	function ShowDateTime($value,$lang='') {
		if ($value=='0000-00-00') {
			return " - ";
		}else{
			if ($lang=='') $lang = "th";
			if ($lang=='th') {
				$year = substr($value,0,4);
				if ($year < 2550) $year = $year + 543;
			}else{
				$year = substr($value,0,4);
			}

			$m = strtoupper(substr($value,5,2));
			$day = substr($value,8,2);
			$time = substr($value,11);
			$rdate = $day . "/" . $m . "/" . $year . "  " . $time;
			return $rdate;
		}
	}

	function ShowFullDateTime($value,$lang='') {
		if ($value=='0000-00-00') {
			return " - ";
		}else{
			if ($lang=='') $lang = "th";
			if ($lang=='th') {
				$year = substr($value,0,4);
				if ($year < 2550) $year = $year + 543;
				$MonthArray = Array ("01"=>"ม.ค.","02"=>"ก.พ.","03"=>"มี.ค.","04"=>"เม.ย.","05"=>"พ.ค.","06"=>"มิ.ย.","07"=>"ก.ค.","08"=>"ส.ค.","09"=>"ก.ย.","10"=>"ต.ค.","11"=>"พ.ย.","12"=>"ธ.ค.");
			}else{
				$year = substr($value,0,4);
				$MonthArray = Array ("01"=>"Jan","02"=>"Feb","03"=>"March","04"=>"Apr","05"=>"May","06"=>"Jun","07"=>"Jul","08"=>"Aug","09"=>"Sep","10"=>"Oct","11"=>"Nov","12"=>"Dec");
			}

			$m = strtoupper(substr($value,5,2));
			$month = $MonthArray[$m];
			$day = substr($value,8,2);
			$time = substr($value,11);
			$rdate = $day . "/" . $month . "/" . $year . "  " . $time;
			return $rdate;
		}
	}

	function ShowTime($value) {
		if ($value=='0000-00-00') {
			return " - ";
		}else{
			$time = substr($value,11);
			$rdate = $time;
			return $rdate;
		}
	}

	function ShowDateCountDown($value) {
		if ($value=='0000-00-00') {
			return " - ";
		}else{
			$year = substr($value,0,4);
			$month = substr($value,5,2);
			$day = substr($value,8,2);
			$rdate = $year . "," . ($month-1) . "," . $day . ",23,59,59";
			return $rdate;
		}
	}

	function DateDropDown ($value='') {
        for ($i=1;$i<=31;$i++) {
            if ($i==$value) {
                $dlist .= "<option value=\"".$i."\" selected>".$i."</option>";
			}else{
                $dlist .= "<option value=\"".$i."\">".$i."</option>";
			}
		}
		return $dlist;
	}

	function MonthDropDown ($value='') {
		 $MonthArray = Array ("01"=>"January","02"=>"February","03"=>"March","04"=>"April","05"=>"May","06"=>"June","07"=>"July","08"=>"August","09"=>"September","10"=>"October","11"=>"November","12"=>"December");
        for ($i=1;$i<=count($MonthArray);$i++) {
			$i = str_pad($i, 2, "0", STR_PAD_LEFT); 
            if ($i==$value) {
                $dlist .= "<option value=\"".$i."\" selected>".$MonthArray[$i]."</option>";
			}else{
                $dlist .= "<option value=\"".$i."\">".$MonthArray[$i]."</option>";
			}
		}
		return $dlist;
	}

	function YearDropDown ($value='') {
		$MaxYear = date("Y",mktime(0, 0, 0, date("m"),   date("d"),   date("Y")-12)); 
        for ($i=1950;$i<=$MaxYear;$i++) {
            if ($i==$value) {
                $dlist .= "<option value=\"".$i."\" selected>".$i."</option>";
			}else{
                $dlist .= "<option value=\"".$i."\">".$i."</option>";
			}
		}
		return $dlist;
	}

	function thaidate( $format = '', $timestamp = '', $be = true ) {
		if ( $timestamp == null ) {$timestamp = time();}
		// month values
		$en_month_long = array( 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' );
		$en_month_short = array( 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' );
		$th_month_long = array( 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม' );
		$th_month_short = array( 'ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.' );
		// day values
		$en_day_long = array( 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday' );
		$en_day_short = array( 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat' );
		$th_day_long = array( 'อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์' );
		$th_day_short = array( 'อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.' );
		// convert year to buddha era (rg. 2554, 2555, 2556)?
		if ( $be == true ) {
			if ( mb_strpos( $format, 'o' ) !== false ) {
				$year = ( date( 'o', $timestamp )+543 );
				$format = str_replace( 'o', $year, $format );
			} elseif ( mb_strpos( $format, 'Y' ) !== false ) {
				$year = ( date( 'Y', $timestamp )+543 );
				$format = str_replace( 'Y', $year, $format );
			} elseif ( mb_strpos( $format, 'y' ) !== false) {
				$year = ( date( 'y', $timestamp )+43 );
				$format = str_replace( 'y', $year, $format );
			}
			unset( $year );
		}
		// replace eng to thai from long to short
		$thaidate = date( $format, $timestamp );
		if ( mb_strpos( $format, 'F' ) !== false ) {
			$thaidate = str_replace( $en_month_long, $th_month_long, $thaidate );
		} else {
			$thaidate = str_replace( $en_month_short, $th_month_short, $thaidate );
		}
		$thaidate = str_replace( $en_day_long, $th_day_long, $thaidate );
		$thaidate = str_replace( $en_day_short, $th_day_short, $thaidate );
		unset( $en_month_long, $en_month_short, $th_month_long, $th_month_short, $en_day_long, $en_day_short, $th_day_long, $th_day_short );
		return $thaidate;
	}
}
$DT = new DateClass();
?>
