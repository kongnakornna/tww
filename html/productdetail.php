<?php
include "leone.php";
include "./admin/controller/app.php";
include "./admin/controller/banner.php";
include "./admin/controller/content.php";
include "./admin/controller/partner.php";
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";
$param_cat = (!empty($_REQUEST["cat"])) ? $_REQUEST["cat"] : "";
$param_type = (!empty($_REQUEST["type"])) ? $_REQUEST["type"] : "";
$param_sco = (!empty($_REQUEST["sco"])) ? $_REQUEST["sco"] : "";
$app = new app();
$banner = new banner();
$content = new content();
$partner = new partner();
$data = $app->getdetail ($param_id);
$datarows = count($data);
$rno = 1;
$bannershow = "";
for ($b=0;$b<$datarows;$b++) {
   	 $db_id = $data[$b]['p_id'];
	 $db_title = stripslashes($data[$b]['p_title']);
	 $db_partner = stripslashes($data[$b]['p_partnerid']);
	 $db_type = stripslashes($data[$b]['p_type']);
	 $db_cate = stripslashes($data[$b]['p_categorie']);
	 $db_detail = nl2br(stripslashes($data[$b]['p_detail']));
	 $db_clipurl = stripslashes($data[$b]['p_clipurl']);
	 $db_whatnew = nl2br(stripslashes($data[$b]['p_whatnew']));
	 $db_gallery = stripslashes($data[$b]['p_gallery']);
	 $db_date = $DT->ShowDateValue($data[$b]['p_date']);
	 $db_price = stripslashes($data[$b]['p_price']);
	 $db_version = stripslashes($data[$b]['p_version']);
	 $contentname = $content->gettitle($db_cate);
	 $partnername = $partner->getname($db_partner);

	 $maindata = "<span class='apptitle'>".$db_title . "</span><br/>";
	 $maindata .= "<span class='apptitle3'>เวอร์ชั่น ".$db_version."</span><br/>";
	 $maindata .= "<span class='apptitle3'>".$partnername."&nbsp;-&nbsp;" . $db_date . "</span><br/>";
	 $maindata .= "<span class='apptitle2'>หมวด ".$contentname."</span><br/><br/>";


	 if (strlen($db_clipurl) > 1) {
	     $clipshow .= "<div id=\"topicstyle1\">คลิปแนะนำ</div><div id=\"contentwide\">";
		 $clipshow .= "<object width='425' height='355'><param name='movie' value='http://www.youtube.com/v/".$db_clipurl."'></param>";
         $clipshow .= "<param name='wmode' value='transparent'></param><embed src='http://www.youtube.com/v/".$db_clipurl."' type='application/x-shockwave-flash' wmode='transparent' width='425' height='355'></embed></object>";
		 $clipshow .= "</div><br clear=\"all\" /><br clear=\"all\" />";
	 }else{
         $clipshow = "";
	 }

	 $fileimg = explode ("|",$db_gallery);

	 $firstimg = "<img src=\"./photo/gallery/".$fileimg[0]."\" width=\"200\" border=\"0\" alt=\"".$db_title."\" title=\"".$db_title."\" />";

	 for ($i=1;$i<count($fileimg);$i++) {
        $bannershow .= "<img src=\"./photo/gallery/".$fileimg[$i]."\" width=\"125\" border=\"0\" class=\"cliplistthumb\" />";
	 }
}

$commentdatalist = "";
$totalrate = "0";
$rate_1 = "0";
$rate_2 = "0";
$rate_3 = "0";
$rate_4 = "0";
$rate_5 = "0";
$num = 1;
$commentdata = $app->getcommentdata($param_id);
$commentdata_rows = count($commentdata);
for ($p=0;$p<$commentdata_rows;$p++) {
    $c_msg = stripslashes(nl2br($commentdata[$p]['c_message']));
    $c_postby = stripslashes($commentdata[$p]['c_postby']);
    $c_rate = stripslashes($commentdata[$p]['c_rate']);

	$totalrate = $totalrate + $c_rate;

    if ($c_rate=='1') {
	   $rate_1++;
	   $starlist = "<img src=\"images/star_s.png\" border=\"0\" align=\"absmiddle\" /><img src=\"images/star_sb.png\" border=\"0\" align=\"absmiddle\" /><img src=\"images/star_sb.png\" border=\"0\" align=\"absmiddle\" /><img src=\"images/star_sb.png\" border=\"0\" align=\"absmiddle\" /><img src=\"images/star_sb.png\" border=\"0\" align=\"absmiddle\" />";
	}else if ($c_rate=='2') {
	   $rate_2++;
	   $starlist = "<img src=\"images/star_s.png\" border=\"0\" align=\"absmiddle\" /><img src=\"images/star_s.png\" border=\"0\" align=\"absmiddle\" /><img src=\"images/star_sb.png\" border=\"0\" align=\"absmiddle\" /><img src=\"images/star_sb.png\" border=\"0\" align=\"absmiddle\" /><img src=\"images/star_sb.png\" border=\"0\" align=\"absmiddle\" />";
	}else if ($c_rate=='3') {
	   $rate_3++;
	   $starlist = "<img src=\"images/star_s.png\" border=\"0\" align=\"absmiddle\" /><img src=\"images/star_s.png\" border=\"0\" align=\"absmiddle\" /><img src=\"images/star_s.png\" border=\"0\" align=\"absmiddle\" /><img src=\"images/star_sb.png\" border=\"0\" align=\"absmiddle\" /><img src=\"images/star_sb.png\" border=\"0\" align=\"absmiddle\" />";
	}else if ($c_rate=='4') {
	   $rate_4++;
	   $starlist = "<img src=\"images/star_s.png\" border=\"0\" align=\"absmiddle\" /><img src=\"images/star_s.png\" border=\"0\" align=\"absmiddle\" /><img src=\"images/star_s.png\" border=\"0\" align=\"absmiddle\" /><img src=\"images/star_s.png\" border=\"0\" align=\"absmiddle\" /><img src=\"images/star_sb.png\" border=\"0\" />";
	}else if ($c_rate=='5') {
	   $rate_5++;
	   $starlist = "<img src=\"images/star_s.png\" border=\"0\" align=\"absmiddle\" /><img src=\"images/star_s.png\" border=\"0\" align=\"absmiddle\" /><img src=\"images/star_s.png\" border=\"0\" align=\"absmiddle\" /><img src=\"images/star_s.png\" border=\"0\" align=\"absmiddle\" /><img src=\"images/star_s.png\" border=\"0\" align=\"absmiddle\" />";
	}

	if ($p<4) {
	    $commentdatalist .= "<div id=\"commentlist\"><img src=\"images/bullet_comment.png\" border=\"0\" class=\"commentbullet\" /><div id=\"commenttext\"> <strong>".$c_postby."</strong><br />".$starlist."<br />".$c_msg."</div></div>";
	}

	if ($num==2) {
		$commentdatalist .= "<br clear=\"all\" />";
        $num = 1;
	}else{
        $num++;
	}
}
$percent_1 = (100 * $rate_1) / $commentdata_rows;
$percent_2 = (100 * $rate_2) / $commentdata_rows;
$percent_3 = (100 * $rate_3) / $commentdata_rows;
$percent_4 = (100 * $rate_4) / $commentdata_rows;
$percent_5 = (100 * $rate_5) / $commentdata_rows;

$apprate = ceil($totalrate / $commentdata_rows);
$staraward = $app->getstarbig($apprate);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=TIS-620" />
<title><?php echo $webtitle;?></title>
<link href="css/mainstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="js/jquery.rsv.js"></script>
<script type="text/javascript" src="js/global.js"></script>
<script type="text/JavaScript" src="js/jquery.colorbox.js" charset="utf-8"></script>
<link href="css/colorbox.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
document.write('<style>.noscript { display: none; }</style>');
$(document).ready(function() {
	$("#categorie").change(function() {     
		var src = $(this).val();       
	    document.location.href="mainpage.php?cat=" + src;
	}); 
	$("#btnInstall").click(function() {     
		alert ("Install Application");
	}); 
	$(".commentpopup").colorbox({width:"55%", height:"50%", iframe:true});
});
</script>
</head>

<body>
<div id="wrapper">
    <?php include('_header.inc.php'); ?>
    
    
    <div id="msgbody">
    
    <div id="pagenavi"><a href="mainpage.php">หน้าแรก</a> &raquo;&nbsp;<?php echo $db_title;?></div>
    <br clear="all" />
    <div style="background:url(images/detailbg.png) no-repeat; float:left; position:relative; min-height:285px;">
    <div id="contentleft"><?php echo $firstimg;?></div>
    <div id="contentright"><?php echo $maindata;?></div>
    </div>
    <br clear="all" />
	<div id="topicstyle1">รูปตัวอย่าง</div>
    <div id="ownerbanner"><?php echo $bannershow;?></div>
	<br clear="all" />
	<?php echo $clipshow;?>
    <div id="topicstyle1">รายละเอียด</div>
    <div id="contentwide"><?php echo $db_detail;?></div>
    <br clear="all" /><br clear="all" />
	<div id="topicstyle1">มีอะไรใหม่</div>
    <div id="contentwide"><?php echo $db_whatnew;?></div>
	    <br clear="all" /><br clear="all" />
    <div id="topicstyle1">ให้คะแนน</div>
    <div id="contentwide">
    	<div id="commentleft">
        <div id="ratebox">
             <div id="ratesummary">
             <span class="rateshow"><?php echo $apprate;?></span>
             <br /><?php echo $staraward;?><br /><img src="images/spacer.gif" width="1" height="6" border="0" /><br />
             รวม<img src="images/count.png" border="0" class="startrate" align="absmiddle" /><?php echo $commentdata_rows;?> คน
            </div> 
            <div id="ratebreakdown">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="30">
                <img src="images/star_s5.png" border="0" class="startrate" align="absmiddle" /><br />
                <img src="images/star_s4.png" border="0" class="startrate" align="absmiddle" /><br />
                <img src="images/star_s3.png" border="0" class="startrate" align="absmiddle" /><br />
                <img src="images/star_s2.png" border="0" class="startrate" align="absmiddle" /><br />
                <img src="images/star_s1.png" border="0" class="startrate" align="absmiddle" />
                </td>
                <td width="141">
                <div style="min-height:14px; background-color:#9fc05a; margin:1px; padding:4px; width:<?php echo $percent_5;?>%;"><?php echo $rate_5;?></div>
                <div style="min-height:14px; background-color:#add633; margin:1px; padding:4px; width:<?php echo $percent_4;?>%;"><?php echo $rate_4;?></div>
                <div style="min-height:14px; background-color:#ffd834; margin:1px; padding:4px; width:<?php echo $percent_3;?>%;"><?php echo $rate_3;?></div>
                <div style="min-height:14px; background-color:#ffb234; margin:1px; padding:4px; width:<?php echo $percent_2;?>%;"><?php echo $rate_2;?></div>
                <div style="min-height:14px; background-color:#ff8b5a; margin:1px; padding:4px; width:<?php echo $percent_1;?>%;"><?php echo $rate_1;?></div>
                </td>
              </tr>
            </table>
            </div>         
        </div>
        <a href="comment_form.php?appid=<?php echo $param_id;?>" class="commentpopup"><input type="image" border="0" src="images/comment.png" style="float:left; margin-top:20px;"></a>
        </div>
      	<div id="commentbox">
		<?php echo $commentdatalist;?>
       
      </div>
    </div>

    <br clear="all" /><br clear="all" />
    <!--
	<div id="topicstyle1">More from developer</div>
    <div id="contentwide"><?php echo $relateshow;?></div>
    <br clear="all" />
     -->
    </div>
   

    <?php include('_footer.inc.php'); ?>
    

</div>

</body>
</html>
