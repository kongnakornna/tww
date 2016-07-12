<?php
Class CookieClass {
	function AddCookie($a,$b,$c) {
		Setcookie($a,$b,time()+$c);
	}

	function DeleteCookie($a,$b) {
		Setcookie($a,"",time()-$b);
	}
}
?>