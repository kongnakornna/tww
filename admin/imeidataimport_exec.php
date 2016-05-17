<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_type = (!empty($_REQUEST["type"])) ? $_REQUEST["type"] : "";
if ($_FILES['image1']['name']!='') {
	$no = 0;
    $GenCode = $param_type . "_" .$String->GenKey(6);
	$uploadpath = $files_folder . $Ext;
	list ($newfilename,$uploadresult) = $GC->uploadPhoto("image1",$GenCode,$uploadpath,'','csv|txt','20480');
    if ($uploadresult!='ERROR') {
        $SqlAdd = "insert into tbl_model (m_type,m_emei,m_docno,m_docdate,m_barcode,m_used) values ";
		$fp = fopen($uploadpath.$newfilename,"r");
		while (!feof($fp)) {
		   $no++;
		   $mline=fgets($fp,4096);
		   if (strlen($mline) > 5) {
			  list ($docno,$docdate,$barcode,$imei) = explode (",",$mline);
			  $newdocdate = ConvertDocDate ($docdate);
			  if ($no>1) {
	              $SqlAdd .= ",('".$String->sqlEscape(strtoupper($param_type))."','".$String->sqlEscape(strtoupper($imei))."','".$String->sqlEscape($docno)."','".$newdocdate."','".$String->sqlEscape(strtoupper($barcode))."','N')";
			  }else{
	              $SqlAdd .= "('".$String->sqlEscape(strtoupper($param_type))."','".$String->sqlEscape(strtoupper($imei))."','".$String->sqlEscape($docno)."','".$newdocdate."','".$String->sqlEscape(strtoupper($barcode))."','N')";
			  }
		   }
		}
		fclose($fp);
        $ResultAdd = $DatabaseClass->DataExecute($SqlAdd);
	}

    $DatabaseClass->DBClose();
	$Web->AlertWinGo("เพิ่มข้อมูลเรียบร้อย","imeidata_view.php");	
}
die();
?>

<?php
function ConvertDocDate ($value) {
   list ($mmonth,$mdate,$myear) = explode ("/",$value);
   $ndate = str_pad ($mdate,2, "0", STR_PAD_LEFT);
   $nmonth = str_pad ($mmonth,2, "0", STR_PAD_LEFT);
   $newdate = $myear . "-" . $nmonth . "-" . $ndate;
   return $newdate;
}
?>