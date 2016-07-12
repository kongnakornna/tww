<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/* @(#) $Header: /sources/code128php/code128php/example_png.php,v 1.1 2006/04/20 18:34:08 harding Exp $

/*
 * Example of use of code128barcode with gd
 *   provide a png barcode image
 *
 * Copyright(C) 2005-2006 Thomas Harding
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are
 * met:
 * 
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *     * Neither the name of Thomas Harding nor the names of its
 *       contributors may be used to endorse or promote products derived from
 *       this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS
 * IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO,
 * THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
 * PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR
 * CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 * EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
 * PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR
 * PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF
 * LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 * NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE. 
 *
 *   mailto:thomas.harding@laposte.net
 *   Thomas Harding, 56 rue de la bourie rouge, 45 000 ORLEANS -- FRANCE
 *
 */


    require_once('code128barcode.class.php');
  
        if (isset($_REQUEST['process'])) {

        $code = $_REQUEST['code'];
        $string = $code;

        $barcode = new code128barcode();
  
        $code = $barcode->output($code);
        //
        // to add function codes, use an array like:
        // 
        // $code = $barcode->output(array('FNC4',$code,'SHIFT',"end\n"));
        //                                              SHIFT =>End
    if ($code) {
        $height = intval(strlen($code) / 3);
        $width = strlen($code);
        $im = imagecreate($width,intval(($height * 1.33) + 6));
        $white = ImageColorAllocate ($im, 255, 255, 255);
        $black = ImageColorAllocate ($im, 0,0,0);
    
        $code = preg_split('##',$code);
        array_pop($code);
        array_shift($code);
        for($i = 0 ; array_key_exists($i,$code) ; $i++)
            if ($code[$i] == 0)
                imageline($im,$i,0,$i,$height,$white);
            else
                imageline($im,$i,0,$i,$height,$black);

        $font=ImagePsLoadFont("css/URWGothicL-Demi.pfb");
        imagepsencodefont ($font,'css/latin1.enc');
        $size = ImagePSBbox($string,$font,($height/3));
        $h = ($width - $size[2]) / 2;
        $v = ($height + 18);
        ImagePsText($im, $string,$font, $height/3, $black, $white, $h, $v);
        
        header ("Content-type: image/png");
        header ("Content-disposition: inline; filename=barcode.png");
        ImagePng ($im);    
        }

    exit();
    }
echo <<<FIN
<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

FIN;

?>
<head>

<!-- 
 
 /*
 * Example of use of code128barcode with GD
 *   provide a png image barcode
 *
 * Copyright(C) 2006 Thomas Harding
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are
 * met:
 * 
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *     * Neither the name of Thomas Harding nor the names of its
 *       contributors may be used to endorse or promote products derived from
 *       this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS
 * IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO,
 * THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
 * PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR
 * CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 * EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
 * PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR
 * PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF
 * LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 * NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE. 
 *
 *   mailto:thomas.harding@laposte.net
 *   Thomas Harding, 56 rue de la bourie rouge, 45 000 ORLEANS - FRANCE

 -->
  
    <meta name="Author" content="Thomas Harding" />
    <meta http-equiv="Description" content="code128barcode testpage" />
    <meta http-equiv="Keywords" content="php barcode printing lgpl" />
    <link type="image/png" rel="shortcut icon" href="images/printipp-logo-shicon.png" title="code128barcode logo" />
    <link type="text/css" rel="stylesheet" href="./css/local.css" title="code128barcode" />
    <link rev="made" href="mailto:thomas.harding@laposte.net" />
    
    <style type="text/css">
    #bandeau { opacity: 0.5 ; 
               /* -moz-opacity: 0.25 ;*/
               /* filter:alpha(opacity=25); z-index:255 ; */ 
              position: absolute ; 
              left: 470px ;
              top: 20px ;
              z-index: 10 ;
              color:red ;
              font-size: 50pt ;
              font-weight: bold ;
              }
    #bandeau a {
              color:red ;
              text-decoration: none;
            }
    #bandeau_img {
              position: absolute ; 
              left: 450px ;
              top: 20px ;
              z-index: 5 ;
              }
     h1 {
            font-size: 130%;
        }
    </style>

</head>
<body>
    <h1>PDF Barcode labelling test</h1>
    <div id='bandeau'><a href='../downloads/code128barcode/code128barcode.tgz'>PHP</a></div>
    <a href='../downloads/code128barcode/code128barcode.tgz'><img id='bandeau_img' src='css/label.png' /></a>
        <p>prints code128 barcode as PNG image.</p>
        <p><a href='./example_fpdf.php'>back</a></p> 
<form method='post'>
    <input type='text' name='code' />
    <input type='submit' name='process' />
</form>

</body>
</html>
