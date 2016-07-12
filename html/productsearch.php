<?php
include "leone.php";
include "./admin/controller/app.php";
include "./admin/controller/banner.php";
include "./admin/controller/content.php";
include "./admin/controller/partner.php";
$app = new app();
$banner = new banner();
$content = new content();
$partner = new partner();
$param_keyword = (!empty($_REQUEST["keyword"])) ? $_REQUEST["keyword"] : "";
$param_page = (!empty($_REQUEST["page"])) ? $_REQUEST["page"] : "";
$catelist = $content->getlistdd2($param_cat);

if ($param_page=='') $param_page = '1';
$totalrecs = $app->getfinddatatotal ($param_keyword);
$totalpage = ceil ($totalrecs/$maxrec);
if ($param_page=='' || $param_page=='0' || $param_page=='1') {
   $page = "1";
   $min = "0";
   $max = $maxrec;
}else{
   $min = ($maxrec * ($page-1));
   $max = $maxrec * $page;
}

$freeapplist = $app->getfinddata ($param_keyword,$min,$max);
$freeapplistrows = count($freeapplist);
$fno = 1;
$flist = "";
for ($f=0;$f<$freeapplistrows;$f++) {   
	 $db_id = $freeapplist[$f]['p_id'];
	 $db_title = stripslashes($freeapplist[$f]['p_title']);
	 $db_partner = stripslashes($freeapplist[$f]['p_partnerid']);
	 $db_type = stripslashes($freeapplist[$f]['p_type']);
	 $db_cate = stripslashes($freeapplist[$f]['p_categorie']);
	 $db_gallery = stripslashes($freeapplist[$f]['p_gallery']);
	 $db_price = stripslashes($freeapplist[$f]['p_price']);
	 $contentname = $content->gettitle($db_cate);
	 $partnername = $partner->getname($db_partner);

	 $fileimg = explode ("|",$db_gallery);

	 $showimage = "<img src=\"./photo/gallery/".$fileimg[0]."\" width=\"128\" height=\"128\" border=\"0\" class=\"cliplistthumb\" />";
	 $starshow = $app->getrate($db_id);
	 $flist .= "<div id=\"contentlist1\">".$showimage."<br /><div style=\"padding:0px 16px;\" class=\"cliplink\"><a href=\"productdetail.php?id=".$db_id."\">".$db_title."</a><br /><img src=\"images/blank.gif\" width=\"1\" height=\"3\"><br /><span class=\"ownerlink\">โดย ".$partnername."</span><br /><img src=\"images/blank.gif\" width=\"1\" height=\"8\"><br /><div style=\"float:left; width:65px;\">".$starshow."</div></div></div>";

     if ($fno==5) {
       $flist .= "<br clear=\"all\" />";
	   $fno = 1;
     }else{
       $fno++;
     }
}

$pageing = "<div id=\"pagelist\">หน้าที่&nbsp;:&nbsp;&nbsp;";
for ($r=1;$r<=$totalpage;$r++) {
	if ($r==$page || $page=='0') {
       $pageing .= "[" . $r."]&nbsp;&nbsp;";
	}else{
       $pageing .= "<a href=\"productsearch.php?keyword=".$param_keyword."&page=".$r."\">".$r."</a>&nbsp;&nbsp;";
	}
}
$pageing .= "</div>";
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
<script type="text/javascript">
document.write('<style>.noscript { display: none; }</style>');

$(document).ready(function() {
	$("#categorie").change(function() {     
		var src = $(this).val();       
	    document.location.href="mainpage.php?cat=" + src;
	}); 
});
</script>
</head>

<body>
<div id="wrapper">
    <?php include('_header.inc.php'); ?>
    
    <br clear="all" /> 
    <div id="msgbody">
    
    <div id="searchbox">
    <div id="searchtxt">
	<form action="productsearch.php" method="post" name="frmsearch" id="frmsearch">
    <div style="float:left; width:48%; margin-left:10px;">ค้นหา  : <input name="keyword" type="text" class="txtbox_login" id="keyword" style="width:280px;" value="<?php echo $param_keyword;?>" align="absmiddle" />&nbsp;<input type="submit" value=" ค้นหา " class="searchbtmain" align="absmiddle" /></div><div style="float:right; width:48%; text-align:right; margin-right:10px;">ค้นหาตามประเภทร้านค้า&nbsp;&nbsp;<select name="categorie" class="txtbox_login" id="categorie" style="width:200px;" label="categories" align="absmiddle"><?php echo $catelist;?></select></div>
    </form>
    </div>
    </div>

	<br clear="all" /> 
    <div id="topicstyle1">ค้นหาด้วยคำว่า "<?php echo $param_keyword;?>" </div>
    <?php echo $flist;?>   
    <br clear="all" /><br clear="all" />       
    <?php echo $pageing;?>
    
    </div><br/>
    
    <?php include('_footer.inc.php'); ?>
    

</div>
    
</body>
</html>
