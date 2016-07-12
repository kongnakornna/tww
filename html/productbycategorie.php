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
$param_cat = (!empty($_REQUEST["cat"])) ? $_REQUEST["cat"] : "";

$catelist = $content->getlistdd2($param_cat);
$catetitle = $content->gettitle($param_cat);
$catebanner = $content->getbanner($param_cat);

if ($catebanner=='') {
  $bnnimg = "";
}else{
  $bnnimg = "<img src=\"./photo/".$catebanner."\" border=\"0\" alt=\"".$catetitle."\" />";
}

$freeapplist = $app->getdata ('F',$param_cat,'0');
$freeapplistrows = count($freeapplist);
if ($freeapplistrows>0) {
 $fno = 1;
 $dlist .= "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td>\n";
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
	 $dlist .= "<div id=\"contentlist1\">".$showimage."<br /><div style=\"padding:0px 16px;\" class=\"cliplink\"><a href=\"productdetail.php?id=".$db_id."\">".$db_title."</a><br /><img src=\"images/blank.gif\" width=\"1\" height=\"3\"><br /><span class=\"ownerlink\">โดย ".$partnername."</span><br /><img src=\"images/blank.gif\" width=\"1\" height=\"8\"><br /><div style=\"float:left; width:65px;\">".$starshow."</div></div></div>";

	 if ($fno==5) {
	   $dlist .= "<br clear=\"all\" />";
	   $fno = 1;
	 }else{
	   $fno++;
	 }
 }
 $dlist .= "</td></tr></table>\n\n";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=TIS-620" />
<title><?php echo $webtitle;?></title>
<link rel="stylesheet" href="./css/redmond/jquery-ui-1.10.3.custom.css" type="text/css" media="screen" />
<link href="./css/mainstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.4.custom.js" ></script>
<script type="text/javascript" src="js/jquery.rsv.js"></script>
<script type="text/javascript" src="js/global.js"></script>
<script type="text/javascript">
document.write('<style>.noscript { display: none; }</style>');

$(document).ready(function() {
	$("#tabs" ).tabs();
	$("#categorie").change(function() {     
		var src = $(this).val();       
	    document.location.href="productbycategorie.php?cat=" + src;
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
    &nbsp;&nbsp;ค้นหา  : <input type="text" name="keyword" id="keyword" style="width:280px; height:18px;" value="<?php echo $product_keyword;?>" />&nbsp;<input type="submit" value=" ค้นหา " class="searchbtmain" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ค้นหาตามประเภท&nbsp;&nbsp;<select name="categorie" id="categorie" style="width:200px;" label="categories"><?php echo $catelist;?></select>
    </form>
	</div>    
    </div><br/><br/>
	<div id="topicstyle1"><?php echo $catetitle;?></div>
    
   <?php echo $bnnimg;?>
    <br /><br />
    
	    <?php echo $dlist;?>  

             
              
	</div><br/>
    
    <?php include('_footer.inc.php'); ?>
    

</div>
    
</body>
</html>
