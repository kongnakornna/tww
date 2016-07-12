<?php
class Processing{

  function __construct(){

  }
  public function Start_Time(){
	return time()+ microtime();
  }
  public  function End_Time(){
	 return time()+ microtime();
  }
  public function Total_Time($ini_t,$end_t){
	 return round($end_t - $ini_t,4);
  }
  public function show_msg($time){
	 echo "Page generated in $time seconds !";
  }
}
?>
