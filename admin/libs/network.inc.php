<?php
Class NetworkClass {
     function RedirectHtml($a) {
           Header ("Location: " . $a);
	 }

	 function AlertWin($value) {
            print "<SCRIPT LANGUAGE=\"JavaScript\">\n";
            print "<!--\n";
            print "alert('$value');\n";
            print "history.back();";
            print "//-->\n";
            print "</SCRIPT>\n";
	 }

	 function AlertWinGo($value,$url) {
            print "<SCRIPT LANGUAGE=\"JavaScript\">\n";
            print "<!--\n";
            print "alert('$value');\n";
            print "document.location.replace('$url');";
            print "//-->\n";
            print "</SCRIPT>\n";
	 }

	 function AlertWinGoTop($value,$url) {
            print "<SCRIPT LANGUAGE=\"JavaScript\">\n";
            print "<!--\n";
            print "alert('$value');\n";
            print "document.location.top.replace('$url');";
            print "//-->\n";
            print "</SCRIPT>\n";
	 }
}
?>