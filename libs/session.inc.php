<?php
Class SessionClass {
	function Start() {
		Session_Start();
	}

	function Create($a) {
		Session_register($a);
	}

	function Delete($a) {
		Session_unregister($a);
	}

	function Destroy() {
		Session_Destroy();
	}
}
?>