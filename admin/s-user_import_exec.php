<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
if ($_FILES['image1']['name']!='') {
	$no = 0;
    $GenCode = "user_" .$String->GenKey(6);
	$uploadpath = $files_folder . $Ext;
	list ($newfilename,$uploadresult) = $GC->uploadPhoto("image1",$GenCode,$uploadpath,'','csv|txt','20480');
    if ($uploadresult!='ERROR') {
        $SqlAdd = "insert into tbl_username (u_group,u_username,u_password,u_fullname,u_code,u_shoptitle,u_shopaddress,u_shopprovince,u_shoppostcode,u_bankname,u_bankcode,u_phone,u_status) values ";
		$fp = fopen($uploadpath.$newfilename,"r");
		while (!feof($fp)) {
		   $no++;
		   $mline=fgets($fp,4096);
		   if (strlen($mline) > 5) {
			  list ($title,$code,$address,$province,$postcode,$phone) = explode (",",$mline);

			  $newcode = splitline($code);

			  if ($no>1) {
	              $SqlAdd .= ",('S','".$String->sqlEscape($newcode)."',MD5('".$newcode."'),'".$String->sqlEscape($title)."','".$String->sqlEscape($code)."','".$String->sqlEscape($title)."','".$String->sqlEscape($address)."','".$String->sqlEscape($province)."','".$String->sqlEscape($postcode)."','".$String->sqlEscape($bankname)."','".$String->sqlEscape($bankcode)."','".$String->sqlEscape($phone)."','1')";
			  }else{
	              $SqlAdd .= "('S','".$String->sqlEscape($newcode)."',MD5('".$newcode."'),'".$String->sqlEscape($title)."','".$String->sqlEscape($code)."','".$String->sqlEscape($title)."','".$String->sqlEscape($address)."','".$String->sqlEscape($province)."','".$String->sqlEscape($postcode)."','".$String->sqlEscape($bankname)."','".$String->sqlEscape($bankcode)."','".$String->sqlEscape($phone)."','1')";
			  }
		   }
		}
		fclose($fp);
        $ResultAdd = $DatabaseClass->DataExecute($SqlAdd);
	}

    $DatabaseClass->DBClose();
	$Web->AlertWinGo("เพิ่มข้อมูลเรียบร้อย","s-user_view.php");	
}
die();
?>
<?php
function splitline($value='') {
   $res = str_replace ("-","",$value);
   return trim($res);
}

?>