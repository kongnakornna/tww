<script type="text/javascript">
<!--
var myMenu;
window.onload = function() {
	myMenu = new SDMenu("my_menu");
	myMenu.remember = true;
	myMenu.oneSmOnly = false;
	myMenu.markCurrent = true;
	myMenu.init();
	var firstSubmenu = myMenu.submenus[0];
};
//-->
</script>
<link rel="stylesheet" type="text/css" href="./style/sdmenu.css" />
<script language="JavaScript" type="text/javascript" src="./js/sdmenu.js"></script>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr><td valign="top"><div style="float: left" id="my_menu" class="sdmenu">

<?php
if ($_SESSION['TWZGroup']=='M') {
?>
<div class="collapsed">
	<span>�Ѵ��â�����</span>
	<a href="reportdealer_form.php">����ª��ͷ��ӡ����Ѥêԡ</a>
	<a href="reportdealerpay_form.php">�ټ���Ҫԡ�������Թ����</a>
</div>
<?php
}else{
?>
<div class="collapsed">
	<span>�Ѵ��â�����</span>
	<a href="report_form.php">����ª��ͷ��ӡ����Ѥêԡ</a>
	<a href="reportpay_form.php">�ټ���Ҫԡ�������Թ����</a>
</div>
<?php
}
?>
</div>
</td></tr></table> 