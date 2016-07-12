<?php
$bannerdata = $banner->getbanner();
$bannerdata_count = count($bannerdata);
for ($b=0;$b<$bannerdata_count;$b++) {
	 $bnn_id = $bannerdata[$b]['c_id'];
	 $bnn_title = stripslashes($bannerdata[$b]['c_title']);
	 $bnn_url = stripslashes($bannerdata[$b]['b_url']);
	 $bnn_file = stripslashes($bannerdata[$b]['b_file']);
	 if ($bnn_file=='') {
		 $imgbanner = "";
	 }else{
		 if ($bnn_url=='') {
		    $imgbanner = "<img src=\"./photo/".$bnn_file."\" width=\"560\" height=\"90\" border=\"0\" alt=\"".$bnn_title."\" />";
		 }else{
		    $imgbanner = "<a href=\"".$bnn_url."\"><img src=\"./photo/".$bnn_file."\" width=\"560\" height=\"90\" border=\"0\" alt=\"".$bnn_title."\" /></a>";
		 }
	 }
}
?>
<div id="header">
     <div id="topzone">
            <div id="logo"><img src="images/logo.png" border="0" width="90" /></div>
            <div id="headbanner"><?php echo $imgbanner;?></div>
            
                
<?php
if ($_SESSION['isdevlogin']) {
?>
                <div id="boxloginpass">
                <div id="loginform">
                <div style="float:left;text-align:center;width:240px;"><span style="color:#FFF; font-size:16px;">ยินดีต้อนรับท่านสมาชิก</span></div>
                <br clear="all" />
				<div style="float:left;text-align:center; width:240px; border-top:solid 1px #fff; margin-top:2px; padding-top:2px; padding-left:10px;color:#FFF; font-size:14px;"><br/>
                คุณ <?php echo $_SESSION['DVFullname'];?><br/>
                </div>
				</div>
				</div>
<?php
}
?>
			
        </div>
    <div id="mainmenu"><a href="dev_mainpage.php">หน้าแรก</a><img src="images/menu_seperator.gif" border="0" align="absmiddle"><a href="dev_help.php">วิธีการใช้งาน</a><img src="images/menu_seperator.gif" border="0" align="absmiddle"><a href="dev_changepass_form.php">เปลี่ยนรหัสผ่าน</a><img src="images/menu_seperator.gif" border="0" align="absmiddle"><a href="dev_report_form.php">รายงานยอดขาย</a><img src="images/menu_seperator.gif" border="0" align="absmiddle"><a href="dev_contactus_form.php">ติดต่อทีมดูแลระบบ EasyCard</a><img src="images/menu_seperator.gif" border="0" align="absmiddle"><a href="dev_logout.php">ออกจากระบบ</a></div>
</div>