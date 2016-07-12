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
$param_type = (!empty($_REQUEST["type"])) ? $_REQUEST["type"] : "";
$param_sort = (!empty($_REQUEST["sort"])) ? $_REQUEST["sort"] : "";
$catelist = $content->getlistdd2($param_cat);
if ($param_sort=='') $param_sort = '0';
$dlist = "";
$sqltags = "";

$catdata = $content->getdata();
$catdata_count = count($catdata);

for ($c=0;$c<$catdata_count;$c++) {
	 $cat_id = $catdata[$c]['c_id'];
	 $cat_title = stripslashes($catdata[$c]['c_title']);

	 
	 $freeapplist = $app->getdata ('',$cat_id,$param_sort);
	 $freeapplistrows = count($freeapplist);
	 if ($freeapplistrows>0) {
		 $fno = 1;
		 $dlist .= "<div id=\"topicstyle1\">".$cat_title."</div>\n";
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
			 if ($db_type=='F') {
				 $TypeName = "FREE";
			 }else{
				 $TypeName = $db_price . ' B.';
			 }

			 $dlist .= "<div id=\"contentlist1\">".$showimage."<br /><div style=\"padding:8px;\" class=\"cliplink\"><a href=\"productdetail.php?id=".$db_id."\">".$db_title."</a><br /><img src=\"images/blank.gif\" width=\"1\" height=\"3\"><br /><span class=\"ownerlink\">โดย ".$partnername."</span><br /><br /><div style=\"float:left; width:50px;\">&nbsp;</div><div id=\"priceshow\"><a href=\"productdetail.php?id=".$db_id."\" class=\"cliplink\">".$TypeName."</a></div></div></div>";
			 if ($fno==5) {
			   $dlist .= "<br clear=\"all\" />";
			   $fno = 1;
			 }else{
			   $fno++;
			 }
		 }
		 $dlist .= "<br clear=\"all\" /><div style=\"float:right; text-align:right;\"><a href=\"productbycategorie.php?cat=".$cat_id."\">[ดูทั้งหมด]</a></div><br clear=\"all\" />\n\n";
	 }
}

$rlist .= "<br clear=\"all\" />";  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=TIS-620" />
<title><?php echo $webtitle;?></title>
<link rel="stylesheet" href="./css/le-frog/jquery-ui-1.10.4.custom.css" type="text/css" media="screen" />
<link href="./css/mainstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.4.custom.js" ></script>
<script type="text/javascript" src="js/jquery.rsv.js"></script>
<script type="text/javascript" src="js/global.js"></script>
<script type="text/javascript">
document.write('<style>.noscript { display: none; }</style>');

$(document).ready(function() {
	<?php echo $sqltags;?>
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
    <div style="float:left; width:48%; margin-left:10px;">ค้นหา  : <input name="keyword" type="text" class="txtbox_login" id="keyword" style="width:280px;" value="<?php echo $param_keyword;?>" align="absmiddle" />&nbsp;<input type="submit" value=" ค้นหา " class="searchbtmain" align="absmiddle" /></div><div style="float:right; width:48%; text-align:right; margin-right:10px;">ค้นหาตามประเภท&nbsp;&nbsp;<select name="categorie" class="txtbox_login" id="categorie" style="width:200px;" label="categories" align="absmiddle"><?php echo $catelist;?></select></div>
    </form>
	</div>    
    </div><br/>

	<?php echo $dlist;?>  
    
    </div><br/>
    
    <?php include('_footer.inc.php'); ?>
    

</div>
    
</body>
</html>
