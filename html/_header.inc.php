<?php
$bannerdata = $banner->getbanner();
$bannerdata_count = count($bannerdata);
for ($b=0;$b<$bannerdata_count;$b++) {
	 $bnn_id = $bannerdata[$b]['b_id'];
	 $bnn_title = stripslashes($bannerdata[$b]['b_title']);
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
if ($_SESSION['ismemberlogin']) {
	 $membermenu = "<a href=\"member_mainpage.php\">หน้าแรกสมาชิก</a>";
?>
                <div id="boxloginpass">
                <div id="loginform">
                <div style="float:left;text-align:center;width:240px;"><span style="color:#FFF; font-size:16px;">ยินดีต้อนรับท่านสมาชิก</span></div>
				<br clear="all" />
				<div style="float:left;text-align:center;width:240px; border-top:solid 1px #fff; margin-top:2px; padding-top:2px; padding-left:10px;"><br/>
                <span style="color:#FFF; font-size:14px;">คุณ <?php echo $_SESSION['TWFullname'];?></span>
                </div>
				</div>
				</div>
<?php
}else{
	 $membermenu = "<a href=\"member.php\">หน้าแรก</a>";
?>
				<div id="boxlogin">
				<div id="loginform">
				<form method="post" name="frmLoginBar" id="frmLoginBar" action="loginform_exec.php">
                <div style="float:left; margin-bottom:6px;"><span style="color:#FFF; font-size:16px;">เข้าสู่ระบบสมาชิก</span></div>
                <div style="float:right; text-align:right; margin-bottom:6px;"><a href="forgetpassword.php" style="color:#3b302e;">( ลืมรหัสผ่าน )</a></div>
                <br clear="all" />
                <div style="float:left; width:160px;">
                <input id="uname" name="uname" type="text" class="txtbox_login" placeholder="Username" autocomplete="off" /><br />
                <input id="pname" name="pname" type="password" class="txtbox_login" placeholder="Password" autocomplete="off"  />
                </div>
                <div style="float:left; width:70px;"><input type="submit" value="Login" border="0" style="margin-left:11px;" align="absmiddle" class="btloginsubmit" /></div>
                </form>
				</div>
				</div>
<?php
}
?>
			
        </div>
		<form method="post" action="dev_loginform.php">
    <div id="mainmenu"><?php echo $membermenu;?><img src="images/menu_seperator.gif" border="0" align="absmiddle"><a href="aboutus.php">เกี่ยวกับ EasyCard</a><img src="images/menu_seperator.gif" border="0" align="absmiddle"><a href="howto.php">วิธีใช้งาน</a><img src="images/menu_seperator.gif" border="0" align="absmiddle"><a href="policy.php">นโยบายบริการ</a><img src="images/menu_seperator.gif" border="0" align="absmiddle"><a href="condition.php">สิทธิและเงื่อนไขบริการ</a><img src="images/menu_seperator.gif" border="0" align="absmiddle"><a href="contactus.php">ติดต่อเรา</a><img src="images/menu_seperator.gif" border="0" align="absmiddle"><input type="image" src="images/bt_developer.png" border="0" style="margin-left:15px;" align="absmiddle" /></div></form>
</div>