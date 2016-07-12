<?php
Class FormClass {
   function postForm($url,$value) {
  	   $a = $this->openTag($url,'form1','');
  	   $a .= $this->inputText('hidden','value','100','100',$value,'');
  	   $a .= $this->closeTag();
	   $a .= $this->autoSubmit('form1');
	   return $a;
   }

   function openTag($url,$name,$other="") {
      return "<form method=\"post\" action=\"".$url."\" name=\"".$name."\" $other>\n";
   }

   function closeTag() {
      return "</form>";
   }

   function inputText($type,$name,$width,$maxlength,$content="",$other="") {
      return "<input type=\"$type\" name=\"$name\" size=\"$width\" id=\"$name\" value=\"$content\" maxlength=\"$maxlength\" />\n";
   }

   function textArea($name,$content="",$size,$other="") {
	   list ($width,$height) = split("x",$size);
	   return "<textarea name=\"$name\" id=\"$name\" cols=\"$width\" rows=\"$height\" $other>".$content."</textarea>\n";
   }

   function checkBox($name,$topic,$content="",$chk=false,$other="") {
      if ($chk) {
		  $a = "checked=\"checked\"";
	  }else{
	      $a = "";
	  }
      return "<input type=\"checkbox\" name=\"$name\" id=\"$name\" value=\"$content\" $a />&nbsp;$topic\n";
   }

   function radioBox($name,$topic,$content="",$chk=false,$other="") {
      if ($chk) {
		  $a = "checked=\"checked\"";
	  }else{
	      $a = "";
	  }
      return "<input type=\"radio\" name=\"$name\" id=\"$name\" $other value=\"$content\" $a />&nbsp;$topic\n";
   }

   function selectBox($name,$data1,$data2,$width=100,$default="",$other="") {
      $list = "<select name=\"$name\" id=\"$name\" style=\"width: ".$width."px;\">";
	  for ($r=0;$r<count($data1);$r++) {
		    if ($data1[$r]==$default) {
               $list .= "<option value=\"".$data1[$r]."\" selected>".$data2[$r]."</option>\n";
			}else{
               $list .= "<option value=\"".$data1[$r]."\">".$data2[$r]."</option>\n";
			}
	  }	  
	  $list .= "</select>\n";
	  return $list;
   }

   function btnSubmit($name,$other="") {
      return "<input type=\"submit\" name=\"btnSubmit\" value=\"$name\" $other />";
   }

   function btnReset($name,$other="") {
      return "<input type=\"reset\" name=\"btnReset\" value=\"$name\" $other />";
   }

   function btnButton($name,$other="") {
      return "<input type=\"button\" name=\"btnReset\" value=\"$name\" $other />";
   }

   function autoSubmit($frmName){ 
        $data = "<SCRIPT LANGUAGE=\"JavaScript\">\n";
        $data .= "<!--\n";
		$data .= "	document.".$frmName.".submit();\n";
        $data .= "//-->\n";
        $data .= "</SCRIPT>\n";
		return $data;
   }
}
?>