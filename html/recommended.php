<?php
include "leone.php";
include "./admin/controller/app.php";
include "./admin/controller/content.php";
include "./admin/controller/partner.php";
$app = new app();
$content = new content();
$partner = new partner();
$param_cat = (!empty($_REQUEST["cat"])) ? $_REQUEST["cat"] : "";
$param_type = (!empty($_REQUEST["type"])) ? $_REQUEST["type"] : "";
$param_sort = (!empty($_REQUEST["sort"])) ? $_REQUEST["sort"] : "";
$param_page = (!empty($_REQUEST["page"])) ? $_REQUEST["page"] : "";
if ($param_page=='') $param_page = '1';

$totalrecs = $app->getrecomdatatotal ($param_cat,$param_type,'0');
$totalpage = ceil ($totalrecs/$maxrec);
if ($param_page=='' || $param_page=='0' || $param_page=='1') {
   $page = "1";
   $min = "0";
   $max = $maxrec;
}else{
   $min = ($maxrec * ($page-1));
   $max = $maxrec * $page;
}

$recomapplist = $app->getrecomdata ($param_cat,$param_type,'0',$min,$max);
$recomapplistrows = count($recomapplist);
$rno = 1;
$rlist = "";
for ($b=0;$b<$recomapplistrows;$b++) {
   
	 $db_id = $recomapplist[$b]['p_id'];
	 $db_title = stripslashes($recomapplist[$b]['p_title']);
	 $db_partner = stripslashes($recomapplist[$b]['p_partnerid']);
	 $db_type = stripslashes($recomapplist[$b]['p_type']);
	 $db_cate = stripslashes($recomapplist[$b]['p_categorie']);
	 $db_gallery = stripslashes($recomapplist[$b]['p_gallery']);
	 $db_price = stripslashes($recomapplist[$b]['p_price']);
	 $contentname = $content->gettitle($db_cate);
	 $partnername = $partner->getname($db_partner);

	 $fileimg = explode ("|",$db_gallery);

	 $showimage = "<img src=\"./photo/gallery/".$fileimg[0]."\" width=\"165\" border=\"0\" class=\"cliplistthumb\" />";

	 if ($db_type=='F') {
		 $TypeName = 'Free';
	 }else{
		 $TypeName = $db_price . ' B.';
	 }

     $rlist .= "<div id=\"contentlist1\">".$showimage."<br /><div style=\"padding:0px 8px 5px 8px;\"><a href=\"productdetail.php?id=".$db_id."\" class=\"cliplink\">".$db_title."</a><br /><img src=\"images/blank.gif\" width=\"1\" height=\"3\"><br />by <span class=\"ownerlink\">".$partnername."</span><br /><br /><div style=\"float:left; width:50px;\">&nbsp;</div><div id=\"priceshow\"><a href=\"productdetail.php?id=".$db_id."\" class=\"cliplink\">".$TypeName."</a></div></div></div>";
     if ($rno==5) {
       $rlist .= "<br clear=\"all\" />";
	   $rno = 1;
     }else{
       $rno++;
     }
}



$pageing = "<div id=\"pagelist\">หน้าที่&nbsp;:&nbsp;&nbsp;";
for ($r=1;$r<=$totalpage;$r++) {
	if ($r==$page || $page=='0') {
       $pageing .= "[" . $r."]&nbsp;&nbsp;";
	}else{
       $pageing .= "<a href=\"recommended.php?page=".$r."\">".$r."</a>&nbsp;&nbsp;";
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
    
    
    <div id="msgbody">
    
    <div id="topicstyle1">สินค้าแนะนำ</div>
	<?php echo $rlist;?>  
    <br clear="all" /><br clear="all" />       
    <?php echo $pageing;?>
    </div><br/>
    
    <?php include('_footer.inc.php'); ?>
    

</div>
    
</body>
</html>
