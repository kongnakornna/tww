<?php
Class GraphicClass {
function checkExtFile ($extname,$fileext) {
	   $rdata = false;
	   $extarray = explode ("|",$extname);

       if(in_array($fileext,$extarray)) {
            $rdata = true;
	   }
	   return $rdata;
	}

	function uploadPhoto($fileSource,$fileName,$pathPhoto,$scaleResize,$ext='',$limit='') {
		if ($limit=='') $limit = 2048;
        $fileNameSource = $_FILES[$fileSource]["name"];
		$temp=explode(".",$fileNameSource);
		$Imgexe=strtolower($temp[sizeof($temp)-1]);
		if($this->checkExtFile($ext,$Imgexe) || $ext=='') {
			$NewFileName = $fileName . "." . $Imgexe;
			$NewFilePath = $pathPhoto . $NewFileName;
            if (file_exists ($NewFilePath)) unlink($NewFilePath);
			$result = copy($_FILES[$fileSource]["tmp_name"],$NewFilePath);
			if ($scaleResize!='') {				
				$newSize = $this->ResizeScale($NewFilePath,$scaleResize);
				list($sizeWidth,$sizeHeight) = explode("x",$newSize);
			}
            chmod ($NewFilePath,0777);
			$returnData = "OK";
		}else{
			$NewFileName = "support $ext only";
            $returnData = "ERROR";
		}
		return array ($NewFileName,$returnData);
	}

	function create_square_thumb($srcimg, $thumbimg, $size) {   
		$src = imagecreatefromjpeg($srcimg);   
		if (!$src) return FALSE;   
		  
		list($w, $h) = getimagesize($srcimg);   
		$nw = 0;   
		$nh = 0;   
		$sx = 0;   
		$sy = 0;   
		if ($w > $h) {   
			$nh = $size;   
			$nw = $size * $w / $h;   
			$sx = ($w - $h) / 2;   
			$ss = $h;   
		}else{   
			$nw = $size;   
			$nh = $size * $h / $w;   
			$sy = ($h - $w) / 2;   
			$ss = $w;   
		}   
		  
		$tmp = imagecreatetruecolor($size, $size);   
		if (!$tmp) return FALSE;   
		  
		if (imagecopyresampled($tmp, $src, 0, 0, $sx, $sy, $size, $size, $ss, $ss))   
		return imagejpeg($tmp, $thumbimg, 100);   
		return FALSE;   
	} 


	function ResizeScale($name,$thumbwidth) {
		    list($width, $height, $type, $attr) = GetImageSize($name); 
			if ($thumbwidth <= $width) {
				$imgratio = $width/$height;
				if ($imgratio>1) {
					$newh = $thumbwidth / $imgratio;
					$neww = $thumbwidth;
				}else{
					$newh = $thumbwidth * $imgratio;
					$neww = $thumbwidth;
				}
			   return $neww . "x" . $newh ;
	        }else{
			   return $width . "x" . $height;
			}
	}

	function ThumbCreate($name,$max_width,$new_name) {
			$size=GetImageSize($name); 
		    $run = exec ("/home/rumbuy/public_html/shell/convert -size {$size[0]}x{$size[1]} $name -thumbnail $max_width $new_name");
		    return $run;
	}
}
$GC = new GraphicClass();
?>